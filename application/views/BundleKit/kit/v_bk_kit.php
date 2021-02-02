<?php $this->load->view('template/header');?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Kit Listing
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
                <strong>Warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
            </div>
        <?php }else if($this->session->flashdata('info')){  ?>
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Information!</strong> <?php echo $this->session->flashdata('compo'); ?>
            </div>
        <?php } ?>
			<div class="col-sm-12">
			<form action="<?php echo base_url();?>BundleKit/c_bk_kit/showDataForKit" method="post">
				<div class="row">
					<div class="form-group col-sm-3">
						<label for="kit_name">Kit Name:</label>
						<input class="form-control" type="text" name="kit_name" id="kitName" value="<?php if(isset($_POST['kit_name'])){echo $_POST['kit_name'];}; ?>" required="required">
					</div>
          <div class="form-group col-sm-3">
            <label for="kit_keyword">Keyword:</label>
            <input class="form-control" type="text" name="kit_keyword" id="kit_keyword" value="<?php if(isset($_POST['kit_keyword'])){echo $_POST['kit_keyword'];}; ?>" required="required">
          </div>
				</div>
				 <div class="row">
					<div class="form-group col-sm-3">
						<label for="item_template">Items:</label>
							<select name="bk_kit_item" class="form-control selectpicker" required="required" id="bk_kit_item" data-live-search="true">
								<option value="">---</option>
									<?php                                
               			if(isset($_POST['bk_kit_item'])){
               			foreach ($items as $cat) {
                   			$bkTempId=$cat['LZ_BK_ITEM_ID'];
                       	 if(isset($_POST['bk_kit_item']))
                       	 	{
                       	 		if($_POST['bk_kit_item']==$cat['LZ_BK_ITEM_ID'])
                       	 		{
                       	 			$selected="selected";
                       	 		}else{
                       	 			$selected="";
                       	 		}
                       	 		
                       	 	}
                   				?>
                       	<option value="<?php echo $cat['LZ_BK_ITEM_ID']; ?>"  <?php echo $selected; ?> > <?php echo $cat['LZ_BK_ITEM_DESC']; ?> </option>
                       	<?php
                        }                     
	                       }else {
	                       	foreach ($items as $cat)
                          {
	                           	?>
	                           	<option value="<?php echo $cat['LZ_BK_ITEM_ID']; ?>" > <?php echo $cat['LZ_BK_ITEM_DESC']; ?> 
                              </option>
	                           	<?php
	                       } 
	                     }
		                  ?>  		                            
		                </select>
					       </div>
				      </div>
  				<div class="row form-group col-sm-12" style="display: none;">
  					<input class="btn btn-primary" type="submit" name="craete_kit" id="craete_kit">
  				</div>
        </div>
        <div class="col-sm-12">
			    </form>	
			      <?php 
			      if($components){
                	if($components->num_rows() > 0)
                      { 
                      	?>
                      	<div class="panel-body  form-scroll">
                          <table id="bk_kit_save" class="table table-responsive table-striped table-bordered table-hover">
                          <thead>
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
                                  <?php $manualPrice=$profile->MANUAL_PRICE;
                                        $activePrice=$profile->ACTIVE_PRICE; ?>
                                 <td><?php echo $i; ?></td>
                                 <td><input type="checkbox" name="check_value" value="<?php echo $i; ?>" class="<?php echo $profile->LZ_COMPONENT_DESC; ?>"></td>
                                 <td><input type="hidden" name="component_id" value="<?php echo $profile->LZ_COMPONENT_ID; ?>" class="getComponent"><?php echo $profile->LZ_COMPONENT_DESC; ?></td> 
                                 <td><?php echo $profile->EBAY_ITEM_ID; ?></td>
                                 <td><?php echo $profile->ITEM_DESC; ?></td>
                                 <td><?php echo $profile->ITEM_MANUFACTURER; ?></td> 
                                                        
                                 <td><?php echo $profile->CATEGORY_ID; ?></td>
                                 <td><?php echo $profile->CATEGORY_NAME; ?></td>
                                 <td><?php echo $profile->QUANTITY; ?></td> 
                                 <td><input type="text" name="bk_kit_mpn" class="getMPN" value="<?php echo $profile->ITEM_MPN; ?>"></td>
                                 <td><?php echo $profile->ITEM_UPC; ?></td>                      
                                 <td>
                                 <?php
                                 if(!empty($activePrice)){
                                  echo number_format((float)@$profile->ACTIVE_PRICE,2,'.',',');
                                  } ?>                          	
                                  </td> 
                                 <td>
                                 <?php 
                                 if(!empty($manualPrice)){
                                  echo number_format((float)@$profile->MANUAL_PRICE,2,'.',',');
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
                                 <td>
                                 <?php 
                                 if(!empty($totalPrice)){
                                  echo '$ '.number_format((float)@$totalPrice,2,'.',',');
                                  }   ?>
                                  	
                                  </td> 

                                 <?php
                                 $i++;
                                echo "</tr>"; 
                               } ?>
                              </tbody>                                            
                            </table>
                            <?php  }else{ ?>
                               </tbody>                                            
                            </table>
                            <?php  } ?>
        					             <div class="form-group" style="margin-left: 6px;">
                    			<button class="btn btn-primary" id="save_kit" value="save_kit">Save</button>
                			   </div>
                          <?php
                              }
                            }
                              ?>
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
<?php $this->load->view('template/footer');?>
<script>
$(document).ready(function()
{
/***********************************
  FOR CRAETING NEW KIT  
*************************************/
$("#bk_kit_item").change(function()
{
    $("#craete_kit").click();
});

/***********************************
  FOR CHECKBOX VALIDATION FOR NEW KIT  
*************************************/
$("input[name='check_value[]']").on('click', function() {
  var val =$(this).val();
  alert(val); return false;
  var parent = $(this);
  $("input[value='"+val+"']").each(function() {
    $(this).not(parent).attr('disabled', parent.is(':checked'));
  });
})

/***********************************
  FOR SAVING BK KIT DATA  
*************************************/
$("#save_kit").click(function(){
    this.disabled = true;
  var fields = $("input[name='check_value']").serializeArray(); 
    if (fields.length === 0) 
    { 
        alert('Please Select at least one Component'); 
        // cancel submit
        return false;
    }  
  var arr=[];
  var url='<?php echo base_url() ?>BundleKit/c_bk_kit/savekitData'; 
  //alert(count); return false;
  var kit_name=$("#kitName").val();
  var kit_keyword=$("#kit_keyword").val();
  var item_name=$("#bk_kit_item").val();
  //alert(kit_name); return false;
  var componentName=[];
  var itemId=[];
  var titles=[];
  var brand=[];
  var catId=[];
  var CategoryName=[];
  var qty=[];
  var mpn=[];
  var upc=[];
  var activePrice=[];
  var manualPrice=[];
  //var category_id=[];
  
  var tableId="bk_kit_save";
  var tdbk = document.getElementById(tableId);
  $.each($("#"+tableId+" input[name='check_value']:checked"), function()
  {            
    arr.push($(this).val());
  });
  //console.log(tdbk); return false;
  //category_id.push($(tdbk.rows[1].cells[2]).text());
   for (var i = 0; i < arr.length; i++)
      {
        $(tdbk.rows[arr[i]]).find(".getComponent").each(function()
          {
            componentName.push($(this).val());
          });
        itemId.push($(tdbk.rows[arr[i]].cells[3]).text());
        titles.push($(tdbk.rows[arr[i]].cells[4]).text());
        brand.push($(tdbk.rows[arr[i]].cells[5]).text());
        catId.push($(tdbk.rows[arr[i]].cells[6]).text());
        CategoryName.push($(tdbk.rows[arr[i]].cells[7]).text());
        qty.push($(tdbk.rows[arr[i]].cells[8]).text());
        $(tdbk.rows[arr[i]]).find(".getMPN").each(function()
          {
            mpn.push($(this).val());
          });
        upc.push($(tdbk.rows[arr[i]].cells[10]).text());
        activePrice.push($(tdbk.rows[arr[i]].cells[11]).text());
        //console.log($(tdbk.rows[arr[i]].cells[13]).text()); return false;
        var temp=$(tdbk.rows[arr[i]].cells[12]).text();
        var temp = $.trim(temp);
         //console.log(temp.length); return false;
        if(temp.length === 0){
        	manualPrice.push(null);

        }else{
        	manualPrice.push($(tdbk.rows[arr[i]].cells[12]).text());

        	}
        
        
      }
 //console.log(catId, CategoryName); return false;
  $.ajax({
    url:url,
    type: 'POST',
    data: {
      'componentName': componentName,
      'itemId': itemId,
      'titles': titles,
      'brand': brand,
      'catId': catId,
      'CategoryName': CategoryName,
      'qty': qty,
      'mpn': mpn,
      'upc': upc,
      'activePrice': activePrice,
      'manualPrice': manualPrice,
      'item_name': item_name,
      'kit_name': kit_name,
      'kit_keyword': kit_keyword
    },
    dataType: 'json',
    success: function (data) {
         if(data != ''){
           window.location.href = '<?php echo base_url(); ?>BundleKit/c_bk_kit';
               //alert("data is inserted");    
         }else{
           alert('Error: Fail to insert data');
         }
       }
  });
  
  });

$(".search_category").click(function(){
  var fields = $("input[name='cat_list[]']").serializeArray(); 
    if (fields.length === 0) 
    { 
        alert('Please select atleast one category'); 
        // cancel submit
        return false;
    }
  });
});

</script>