<?php $this->load->view("template/header.php"); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Update Single Entry Form
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Update Single Entry Form</li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Update Single Entry Form</h3>
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
          <?php echo form_open('single_entry/c_single_entry/updateRecord', 'role="form"'); ?>

          <?php 
          //if(!empty($singlentry_all)){
          foreach($singlentry_all['query'] as $row):
           // } 
          ?>

          <div class="row">
            <div class="col-sm-12">      
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="Loading No" class="control-label">Loading No:</label>
                    <input type="number" class="form-control" id="loading_no" name="loading_no" value="<?php echo @$row['ID']; ?>" readonly>
                </div>
              </div>

              <div class="col-sm-2">
                <div class="form-group">
                  <label for="User" class="control-label">Update By:</label>
                  <?php $emp_name = $this->session->userdata('employee_name');?>
                    <input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo $emp_name;?>" readonly>
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="User" class="control-label">Created By:</label>
                  <?php $emp_name = $this->session->userdata('employee_name');?>
                    <input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo @$row['LISTER'];?>" readonly>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="">Purchase Ref:</label>
                  <input type="text" class="form-control" maxlength="15" name="purch_ref" id="purch_ref" value="<?php echo @$row['PURCHASE_REF_NO'];?>" readonly>
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
                  <select name="suplier_desc" class="form-control" id="suplier_desc">
                  <?php foreach($supplier_id as $supplier): ?>
                    <option value="<?php echo @$supplier['SUPPLIER_ID'];?>" <?php if(@$row['SUPPLIER_ID'] == @$supplier['SUPPLIER_ID'] ){echo "selected='selected'";} ?>><?php echo @$supplier['COMPANY_NAME'];?></option>
                  <?php endforeach;?>  
                  </select>
                </div>  
              </div>
             </div> 
              <!-- <div class="col-sm-4">
              <div class="form-group">
                <label for="Supplier Desc" class="control-label">Supplier Desc:</label>
                
                  <input type="text" class="form-control" id="suplier_desc" name="suplier_desc" value="Vendors for Goods" readonly>
                </div>
              </div> -->
              <div class="col-sm-12"> 
                <div class="col-sm-3">
                    <div class="form-group">
                  <label for="Job No" class="control-label">Job No:</label>
                    <input type="number" class="form-control" id="job_no" name="job_no" value="<?php echo @$row['JOB_NO'];?>">
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                  <label for="Serial No" class="control-label">Serial No:</label>
                  
                    <input type="text" class="form-control" id="serial_no" name="serial_no" value="<?php echo @$row['SERIAL_NO'];?>" >
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="Lot Ref" class="control-label">Lot Ref:</label>
                  
                    <input type="text" class="form-control" id="lot_ref" name="lot_ref" value="<?php echo @$row['PO_DETAIL_LOT_REF'];?>" >
                  </div>
                </div>
              
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="Purchase Date" class="control-label">Purchase Date:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                        <input type="text" class="form-control" id="purchase_date" name="purchase_date" value="<?php echo @$row['PURCHASE_DATE'];?>" required>
                    </div>
                  </div>              
                </div>
              </div>
              <div class="col-sm-12"> 

 
              <!-- <div class="col-sm-3">
                <div class="form-group">
                  <label for="Purchase Date" class="control-label">List Date:</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                      <input type="text" class="form-control" id="list_date" name="list_date" required>
                  </div>
                </div>
              </div>                 
 -->
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="UPC" class="control-label">UPC:</label>
                      <input type="number" class="form-control" id="upc" name="upc" value="<?php echo @$row['ITEM_MT_UPC'];?>" readonly>

                  </div>
                </div>

                <div class="col-sm-3">
                  <div class="form-group">
                  <label for="Manufacture" class="control-label">Manufacture:</label>
                  
                    <input type="text" class="form-control" id="manufacturer" name="manufacturer" value="<?php echo @$row['ITEM_MT_MANUFACTURE'];?>" readonly>
                  </div>
                </div>                
              
                <div class="col-sm-3">
                  <div class="form-group">
                  <label for="MPN" class="control-label">MPN:</label>
                  
                    <input type="text" class="form-control" id="part_no" name="part_no" value="<?php echo @$row['ITEM_MT_MFG_PART_NO'];?>" readonly>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                  <label for="SKU" class="control-label">SKU:</label>
                  
                    <input type="text" class="form-control" id="sku" name="sku" value="<?php echo @$row['ITEM_MT_BBY_SKU'];?>">
                  </div>
                </div>
              </div>
              <div class="col-sm-12">   
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="Ounces" class="control-label">Ounces:</label>
                      <input type="text" class="form-control" id="ounces" name="ounces" value="<?php echo @$row['WEIGHT_KG'];?>">
                  </div>
                </div>
<!--                <div class="col-sm-2">
                <div class="form-group">
                  <label for="Conditions" class="control-label">Conditions:</label>
                  <select class="form-control" id="default_condition" name="default_condition" value="<?php //echo @$row['CONDITIONS_SEG5'];?>">
                    <option value="3000">Used</option>
                    <option value="1000">New</option>
                    <option value="1500">New other</option>
                    <option value="2000">Manufacturer Refurbished</option>
                    <option value="2500">Seller Refurbished</option>
                    <option value="7000">For Parts or Not Working</option>
                  </select>  
                </div>
              </div> -->
              <div class="col-sm-2">
                <div class="form-group">      
                    <label for="Conditions" class="control-label">Conditions:</label>
                    <select class="form-control" id="default_condition" name="default_condition" value="<?php echo @$row['CONDITIONS_SEG5']; ?>" readonly>
                    <option value="<?php echo $row['COND_NAME']; ?>"><?php echo $row['COND_NAME']; ?></option>
                    
                     
                  </select>
                </div>
              </div>
              <div class="col-sm-8">
                <div class="form-group">
                <label for="Item Description" class="control-label">Title:</label>
                  <span>Maximum of 80 characters - 
                  <input class="c-count" type="text" id='titlelength' name="titlelength" size="3" maxlength="3" value="80" readonly> characters left</span><br/>                
                  <input type="text" class="form-control" id="title" name="title" onKeyDown="textCounter(this,80);" maxlength="80" onKeyUp="textCounter(this,'titlelength' ,80)"  value="<?php echo @$row['ITEM_MT_DESC'];?>">
                  <a class="crsr-pntr" title="Click here for category suggestion" id="Suggest_Categories_for_title">Suggest Category Against Title</a>
                </div>
              </div>
            </div>  
              <!-- <div class="col-sm-12">
                <div class="form-group">
                <label for="Item Description" class="control-label">Item Description:</label>
                
                  <textarea type="text" rows="5" class="form-control" id="item_description" name="item_description" required></textarea>
                </div>
              </div> style="display:none !important;" -->
            <div class="col-sm-12">   
              <div class="col-sm-1" >
                <div class="form-group">
                    <label for="">Category ID:</label>
                    <input type="number" class="form-control" id="category_id" name="category_id" value="<?php echo @$row['CATEGORY_ID'];?>" required>
                </div>
              </div>

              <div class="col-sm-2" >
                <div class="form-group">
                    <label for="">Object Name:</label>
                    <input type="text" class="form-control" id="obj_id" name="obj_id" value="<?php echo @$row['OBJECT_NAME'];?>" required>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                <label for="Main Category" class="control-label">Main Category:</label>
                
                  <input type="text" class="form-control" id="main_category" name="main_category" value="<?php echo @$row['MAIN_CATAGORY_SEG1'];?>" >
                  <a class="crsr-pntr" title="Click here for category suggestion" id="Suggest_Categories">Suggest Category</a> &nbsp;&nbsp; <a href="<?php echo base_url();?>dashboard/dashboard/advance_categories" title="Click here for Advance Category Search" target="_blank">Advance Category Search</a>
                </div>
              </div>

              <div class="col-sm-3">
                <div class="form-group">
                <label for="Sub Category" class="control-label">Sub Category:</label>
                  <input type="text" class="form-control" id="sub_cat" name="sub_cat" value="<?php echo @$row['SUB_CATAGORY_SEG2'];?>" >
                </div>
              </div>

              <div class="col-sm-3">
                <div class="form-group">
                  <label for="Category" class="control-label">Category Name:</label>
                   <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo @$row['BRAND_SEG3'];?>" required>
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
                  
                    <input type="text" class="form-control" id="origin" name="origin" value="<?php if(!empty(@$row['ORIGIN_SEG4'])){echo @$row['ORIGIN_SEG4'];}else{echo 'U.S';}?>" >

                  </div>
                </div> 

                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="Active Price" class="control-label">Active Price:</label>
                      <input type="number" step="0.01" min="0" class="form-control" id="active_price" name="active_price" value="<?php echo @$row['PRICE'];?>">
                  </div>
                  <a class="crsr-pntr" title="Click here for Price suggestion" id="suggest_price">Suggest Price</a> &nbsp;&nbsp; 
                    <a class="crsr-pntr" title="Click here for Advance Price Search" href="http://localhost/advance_search/advancedItemSearch.html" target="_blank">Advance Price Search</a><br>
                </div> 

                <!-- <div class="col-sm-3">
                  <div class="form-group">
                    <label for="Sold Price" class="control-label">Sold Price:</label>
                      <input type="number" class="form-control" id="sold_price" name="sold_price" >
                  </div>
                </div> -->
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="Cost Price" class="control-label">Cost Price:</label>         
                      <input type="number" step="0.01" min="0" class="form-control" id="cost_price" name="cost_price" value="<?php echo @$row['PO_DETAIL_RETIAL_PRICE'];?>" required>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                  <label for="Available Qty" class="control-label">Available Qty:</label>
                    <input type="number" class="form-control" id="avail_qty" name="avail_qty" value="<?php echo @$row['AVAILABLE_QTY'];?>" required readonly>
                  </div>
                </div>
              </div>     
              <div class="col-sm-12">

                <!--Price Result-->
                <div id="price-result">

                </div>              
                
              </div> 

              <div class="col-sm-12">
                <div class="col-sm-7">
                  <div class="form-group">
                    <label for="Remarks" class="control-label">Remarks:</label>
                      <input type="text" class="form-control" id="remarks" name="remarks" value="<?php echo @$row['REMARKS'];?>">
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
              
                  <!-- <select  class="form-control" id="shipping_service" name="shipping_service"  value="<?php //echo @$data_get['result'][0]->SHIPPING_SERVICE; ?>">
                    
                    <option value="USPSFirstClass" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSFirstClass' ){echo "selected='selected'";} ?>>USPS First Class</option>
                    <option value="USPSPriority" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriority' ){echo "selected='selected'";} ?>>USPS Priority Mail</option>
                    <option value="FedExHomeDelivery" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'FedExHomeDelivery' ){echo "selected='selected'";} ?>>FedEx Ground or FedEx Home Delivery</option>
                    <option value="USPSParcel" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSParcel' ){echo "selected='selected'";} ?>>USPSParcel</option> 
                    <option value="USPSPriorityFlatRateEnvelope" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityFlatRateEnvelope' ){echo "selected='selected'";} ?>>USPS Priority Flat Rate Envelope</option>
                    <option value="USPSPriorityMailSmallFlatRateBox" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityMailSmallFlatRateBox' ){echo "selected='selected'";} ?>>USPS Priority Mail Small Flat Rate Box</option> 
                    <option value="USPSPriorityFlatRateBox <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityFlatRateBox' ){echo "selected='selected'";} ?>">USPS Priority Mail Medium Flat Rate Box</option>
                    <option value="USPSPriorityMailLargeFlatRateBox" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityMailLargeFlatRateBox' ){echo "selected='selected'";} ?>>USPS Priority Mail Large Flat Rate Box</option> 
                    <option value="USPSPriorityMailPaddedFlatRateEnvelope"<?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityMailPaddedFlatRateEnvelope' ){echo "selected='selected'";} ?>>USPS Priority Mail Padded Flat Rate Envelope</option>
                    <option value="USPSPriorityMailLegalFlatRateEnvelope" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityMailLegalFlatRateEnvelope' ){echo "selected='selected'";} ?>>USPS Priority Mail Legal Flat Rate Envelope</option> -->
                     
                  </select> 
                 

              </div>
            </div> 
                <div class="col-sm-2">
                  <div class="form-group p-t-24">
                  <label for="Available Qty" class="control-label" style="color: red;">Skip Test:</label>
                    <input type="radio" id="skip_test" name="skip_test" value="Yes" checked>&nbsp;Yes&nbsp;&nbsp;
                    <input type="radio" id="skip_test" name="skip_test" value="No">&nbsp;No
                  </div>
                </div>
               </div>
               <!--<div class="col-sm-12">
                 <div class="form-group">
                  <div style="color: #dd4b39 !important; background-color: #f2dede!important; border-color: #ebccd1!important;" class="alert alert-danger alert-dismissable fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Note:</strong> On update of every single entry record <strong>New Barcode</strong> will be generate.
                  </div>                 
                 </div>
               </div>                 -->
              
                <div class="col-sm-12 buttn_submit">
                  <div class="form-group">
                    <input type="submit" name="update" class="btn btn-success" value="Update">
                    <button type="button" title="Back" onclick="location.href='<?php echo base_url('single_entry/c_single_entry/filter_data') ?>'" class="btn btn-primary">Back</button>

                  <!--<?php //if(empty($row['GRN_ID'])) { ?>
                     <a title="Click here to Post the Manifest" id="<?php //echo $row['LZ_MANIFEST_ID']."-post";?>" class="post_btn btn btn-primary" >Post</a>
                  <?php //}else{ ?>
                       <a title="Click here to Unpost the Manifest" id="<?php //echo $row['LZ_MANIFEST_ID']."-unpost"; ?>" class="post_btn btn btn-success " >Unpost</a> 
                  <?php  //} ?>-->
                </div>
              </div>
           <?php endforeach; ?>
          <?php echo form_close(); ?>

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
<script>
  function textCounter(field,cnt, maxlimit) {         
    var cntfield = document.getElementById(cnt) 
     if (field.value.length > maxlimit) // if too long...trim it!
        field.value = field.value.substring(0, maxlimit);
        // otherwise, update 'characters left' counter
    else
    cntfield.value = maxlimit - field.value.length;
}
</script>
<?php $this->load->view("template/footer.php"); ?>