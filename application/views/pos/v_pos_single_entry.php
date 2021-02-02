<?php $this->load->view("template/header.php"); ?>

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

          <?php echo form_open('pos/c_pos_single_entry/add', 'role="form"'); ?>

          <div class="row">
          <div class="col-sm-12">
                  
            <div class="col-sm-3">
              <div class="form-group">
                <label for="Loading No" class="control-label">Loading No:</label>
                  <input type="number" class="form-control" id="loading_no" name="loading_no" value="<?php echo @$auto_num[0]['LOADING_NO']+1; ?>" readonly>
                  <input type="hidden" name="pos_only" value="1">
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
        $purch_ref = $auto_num[0]['PURCHASE_REF_NO'];
        $str = explode('-', $purch_ref);
        if(count($str) > 1){
          $last_num = end($str);
          $date = date('d-M-y');
          $current_date = strtoupper($date);
          $last_date = $str[0].'-'.$str[1].'-'.$str[2];
          if($last_date == $current_date){
           $count = $last_num + 1;
           $purch_ref = strtoupper($date.'-'. $count);
          }else{
           $purch_ref = strtoupper($date.'-'. 1);
          }
        }else{
          $date = date('d-M-y');
          //$current_date = strtoupper($date);
          $purch_ref = strtoupper($date.'-'. 1);
        }

        

?>
                <input type="text" class="form-control" maxlength="15" name="purch_ref" id="purch_ref" value="<?php echo $purch_ref; ?>" required readonly>
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
                <?php foreach($supplier_id as $row): ?>
                  <option value="<?php echo @$row['SUPPLIER_ID'];?>"><?php echo @$row['COMPANY_NAME'];?></option>
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
                        <input type="text" class="form-control" id="purchase_date" name="purchase_date" value="<?php echo date('m/d/Y');?>" data-date-format="mm/dd/yyyy" required>
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
                      <input type="number" class="form-control" id="upc" name="upc" >

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
                      <input type="text" class="form-control" id="ounces" name="ounces">
                  </div>
                </div>
<!--                <div class="col-sm-2">
              <div class="form-group">
                <label for="Conditions" class="control-label">Conditions:</label>
                <select class="form-control" id="default_condition" name="default_condition" required>
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
                    <select class="form-control" id="default_condition" name="default_condition" value="<?php echo @$row['CONDITIONS_SEG5']; ?>">
                    <option value="Used" <?php if(@$row['CONDITIONS_SEG5'] == 'Used' ){echo "selected='selected'";} ?>>Used</option>
                    <option value="New" <?php if(@$row['CONDITIONS_SEG5'] == 'New'){echo "selected='selected'";}?>>New</option>
                    <option value="New other" <?php if(@$row['CONDITIONS_SEG5'] == 'New other' ){echo "selected='selected'";}?>>New other</option>
                    <option value="Manufacturer Refurbished" <?php if(@$row['CONDITIONS_SEG5'] == 'Manufacturer Refurbished' ){echo "selected='selected'";}?>>Manufacturer Refurbished</option>
                    <option value="Seller Refurbished" <?php if(@$row['CONDITIONS_SEG5'] == 'Seller Refurbished' ){echo "selected='selected'";}?>>Seller Refurbished</option>
                    <option value="For Parts or Not Working" <?php if(@$row['CONDITIONS_SEG5'] == 'For Parts or Not Working' ){echo "selected='selected'";} ?>>For Parts or Not Working</option>

                  </select>
                </div>
              </div>
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
              <!-- <div class="col-sm-12">
                <div class="form-group">
                <label for="Item Description" class="control-label">Item Description:</label>
                
                  <textarea type="text" rows="5" class="form-control" id="item_description" name="item_description" required></textarea>
                </div>
              </div> style="display:none !important;" -->
              <div class="col-sm-12">
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="">Category ID:</label>
                      <input type="text" class="form-control" id="category_id" name="category_id" value="<?php //echo @$row->CATEGORY_ID; ?>" required>
                  </div>
                </div>
                <div class="col-sm-4">
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

                <div class="col-sm-3">
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



              <div class="col-sm-2">
                <div class="form-group">
                  <label for="Cost Price" class="control-label">Cost $:</label>         
                    <input type="number" step="0.01" min="0" class="form-control" id="cost_price" name="cost_price" required>
                </div>
              </div>

              <div class="col-sm-2">
                <div class="form-group">
                <label for="Available Qty" class="control-label" style="color: red;">QUANTITY:</label>
                  <input type="number" class="form-control" id="avail_qty" name="avail_qty" required>
                </div>
              </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="SALE Price" class="control-label" style="color: red;">SALE PRICE $:</label>
                      <input type="number" step="0.01" min="0" class="form-control" id="active_price" name="active_price" required>
                  </div>
                  <a class="crsr-pntr" title="Click here for Price suggestion" id="suggest_price">Suggest Price</a>&nbsp;&nbsp; 

                </div>

              <div class="col-sm-2">
                <div class="form-group p-t-24">
                <label for="Available Qty" class="control-label" style="color: red;">Skip Test:</label>
                  <input type="radio" id="skip_test" name="skip_test" value="Yes" checked>&nbsp;Yes&nbsp;&nbsp;
                  <input type="radio" id="skip_test" name="skip_test" value="No" >&nbsp;No
                </div>
              </div>                 

              <div class="col-sm-12">
                <div id="price-result">

                </div>              
              </div> 

              <div class="col-sm-8">
                <div class="form-group">
                  <label for="Remarks" class="control-label">Remarks:</label>
                    <input type="text" class="form-control" id="remarks" name="remarks">
                </div>
              </div>

 

              </div>   

                             

                                                                                      
                      
               
                <div class="col-sm-12 buttn_submit">
                  <div class="form-group">
                    <input type="submit" title="Save and Post Record" name="save" class="btn btn-success" value="Save & Post">
                    <button type="button" title="Back" onclick="location.href='<?php echo base_url('pos/c_pos_single_entry/filter_data') ?>'" class="btn btn-primary">Back</button>
                </div>
              </div>
          
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