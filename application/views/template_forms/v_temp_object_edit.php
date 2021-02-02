<?php $this->load->view("template/header.php"); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Template Form
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Template Form</li>
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
              <h3 class="box-title">Template Form</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
          
          <?php 
          //$object_id = $this->uri->segment(4);
          foreach ($data as $value):
          $object_id = $value['OBJECT_ID'];
          $object_name = $value['OBJECT_NAME'];
          $category_id = $value['CATEGORY_ID'];
          $item_desc = $value['ITEM_DESC'];
          $ship_serv = $value['SHIP_SERV'];
          $weight = $value['WEIGHT'];
         

          ?>
          <?php endforeach;?>

        <form method="post" action="<?php echo base_url().'template/c_temp/new_object_edit/'.$object_id ?>">
               


                <div class="row">
                <div class="col-sm-12">
                  
            <div class="col-sm-3">
              <div class="form-group">
                    <label for="Conditions" class="control-label">Category:</label>
                    <input type="text" class="form-control" id="ob_category" name="ob_category" value="<?php echo $category_id; ?>" readonly>   
                  </div>
              </div>
            
             <div class='col-sm-3'>
                <div class="form-group">
                <label for="obj_name" class=" control-label">Object Name:</label>
                
                  <input type="text" class="form-control" id="object_name" name="object_name" value ="<?php echo $object_name;?>" readonly>   
                </div>
              </div>

             <div class="col-sm-6">
              <div class="form-group">
                <label for="item_desc" class=" control-label">Object Description:</label>
                
                  <input type="text" class="form-control" id="item_des" name="item_des" value ="<?PHP echo $item_desc; ?>">
                </div>
              </div>

              <div class="col-sm-6">
              <div class="form-group">
                <label for="inputShipService" class=" control-label">Shipping Service:</label>
                <?php //echo $ship_serv;?>
                  <select class="form-control" id="shipping_service" name="shipping_service" >
                   <option value="USPSParcel" <?php if(@$ship_serv == 'USPSParcel' ){echo "selected='selected'";} ?>>USPSParcel</option>
                    <option value="USPSFirstClass" <?php if(@$ship_serv == 'USPSFirstClass' ){echo "selected='selected'";} ?>>USPS First Class</option>
                    <option value="USPSPriority" <?php if(@$ship_serv == 'USPSPriority' ){echo "selected='selected'";} ?>>USPS Priority Mail</option>
                    <option value="FedExHomeDelivery" <?php if(@$ship_serv == 'FedExHomeDelivery' ){echo "selected='selected'";} ?>>FedEx Ground or FedEx Home Delivery</option> 
                    <option value="USPSPriorityFlatRateEnvelope" <?php if(@$ship_serv == 'USPSPriorityFlatRateEnvelope' ){echo "selected='selected'";} ?>>USPS Priority Flat Rate Envelope</option>
                    <option value="USPSPriorityMailSmallFlatRateBox" <?php if(@$ship_serv == 'USPSPriorityMailSmallFlatRateBox' ){echo "selected='selected'";} ?>>USPS Priority Mail Small Flat Rate Box</option> 
                    <option value="USPSPriorityFlatRateBox <?php if(@$ship_serv == 'USPSPriorityFlatRateBox' ){echo "selected='selected'";} ?>">USPS Priority Mail Medium Flat Rate Box</option>
                    <option value="USPSPriorityMailLargeFlatRateBox" <?php if(@$ship_serv == 'USPSPriorityMailLargeFlatRateBox' ){echo "selected='selected'";} ?>>USPS Priority Mail Large Flat Rate Box</option> 
                    <option value="USPSPriorityMailPaddedFlatRateEnvelope"<?php if(@$ship_serv == 'USPSPriorityMailPaddedFlatRateEnvelope' ){echo "selected='selected'";} ?>>USPS Priority Mail Padded Flat Rate Envelope</option>
                    <option value="USPSPriorityMailLegalFlatRateEnvelope" <?php if(@$ship_serv == 'USPSPriorityMailLegalFlatRateEnvelope' ){echo "selected='selected'";} ?>>USPS Priority Mail Legal Flat Rate Envelope</option>
                     
                  </select>  





                </div>
              </div>
              <div class="col-sm-6">
              <div class="form-group">
                <label for="inputCurrancy" class=" control-label">Weight:</label>
                
                  <input type="text" class="form-control" id="weight" name="weight" value ="<?php echo $weight; ?>">
                </div>
              </div>
              
                  
       
              
             

                      
               <div class="form-group">
                <div class="col-sm-12 buttn_submit">
                  <input type="submit" name="update" title="Save Template" class="btn btn-success" value="update">
                  <!-- <button type="button" title="Go Back" onclick="location.href='<?php //echo site_url('template/c_temp/object_temp') ?>'" class="btn btn-primary">Back</button> -->
                </div>
              </div>
          </form>
          
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

<?php $this->load->view("template/footer.php"); ?>

<script>
  
  $('#ob_category').on('change',function(){

  var ob_category = $('#ob_category').val();
  // alert(ob_category);
  $(".loader").show();
  $.ajax({
    url:'<?php echo base_url(); ?>template/c_temp/get_objects',
    type:'post',
    dataType:'json',
    data:{'ob_category':ob_category},
    success:function(data){
      var brands = [];
       // alert(data.length);return false;
      for(var i = 0;i<data.length;i++){
        brands.push('<option value="'+data[i].OBJECT_ID+'">'+data[i].OBJECT_NAME+'</option>')
      }
      $('#objects').html("");
      $('#objects').append('<label>objects:</label><select name="bd_objects" id="bd_objects" class="form-control bd_objects" data-live-search="true" required>'+brands.join("")+'</select>');
      $('.objects').selectpicker();
    },
     complete: function(data){
      $(".loader").hide();
    }
  });
});
</script>