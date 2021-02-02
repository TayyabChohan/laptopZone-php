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
                <form action="<?php echo base_url(); ?>template/c_temp/new_object_add" method="post" accept-charset="utf-8">
                <div class="row">
                <div class="col-sm-12">
                  
            <div class="col-sm-3">
              <div class="form-group">
                    <label for="Conditions" class="control-label">Category:</label>
                    <select name="ob_category"  id="ob_category" class="form-control selectpicker" required="required" data-live-search="true">
                      <!-- <option value="0">All Categories  ...</option> -->
                      <?php                                
                         

                          foreach ($data['category'] as $cat){

                              ?>
                              <option value="<?php echo $cat['CATEGORY_ID']; ?>" <?php //if($this->session->userdata('category_id') == $cat['CATEGORY_ID']){echo "selected";}?>> <?php echo $cat['CATEGORY_NAME']; ?> </option>
                              <?php
                              } 
                          
                      ?>  
                                          
                    </select>  
                  </div>
              </div>
            
              <div class='col-sm-3'>
                <div class="form-group">
                <label for="obj_name" class=" control-label">Object Name:</label>
                
                  <input type="text" class="form-control" id="object_name" name="object_name" value ="">   
                </div>
              </div>

              <div class="col-sm-6">
              <div class="form-group">
                <label for="obj_desc" class=" control-label">Object Description:</label>
                
                  <input type="text" class="form-control" id="obj_desc" name="obj_desc" value ="">
                </div>
              </div>

              <div class="col-sm-6">
              <div class="form-group">
                <label for="inputShipService" class=" control-label">Shipping Service:</label>
                
                  <select class="form-control" id="shipping_service" name="shipping_service" value="<?php //echo @$row->SHIPPING_SERVICE; ?>">
                    <option value="USPSParcel">USPSParcel</option>
                    <option value="USPSFirstClass">USPS First Class</option>
                    <option value="USPSPriority">USPS Priority Mail</option>
                    <option value="FedExHomeDelivery">FedEx Ground or FedEx Home Delivery</option>
                    <option value="USPSPriorityFlatRateEnvelope">USPS Priority Flat Rate Envelope</option>
                    <option value="USPSPriorityMailSmallFlatRateBox">USPS Priority Mail Small Flat Rate Box</option> 
                    <option value="USPSPriorityFlatRateBox">USPS Priority Mail Medium Flat Rate Box</option>
                    <option value="USPSPriorityMailLargeFlatRateBox">USPS Priority Mail Large Flat Rate Box</option> 
                    <option value="USPSPriorityMailPaddedFlatRateEnvelope">USPS Priority Mail Padded Flat Rate Envelope</option>
                    <option value="USPSPriorityMailLegalFlatRateEnvelope">USPS Priority Mail Legal Flat Rate Envelope</option>
                     
                  </select>  
                </div>
              </div>
              <div class="col-sm-6">
              <div class="form-group">
                <label for="inputCurrancy" class=" control-label">Weight:</label>
                
                  <input type="text" class="form-control" id="weight" name="weight" value ="">
                </div>
              </div>
              
                  
       
              
             

                      
               <div class="form-group">
                <div class="col-sm-12 buttn_submit">
                  <input type="submit" name="save" title="Save Template" class="btn btn-success" value="Save">
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
  
//   $('#ob_category').on('change',function(){

//   var ob_category = $('#ob_category').val();
//   // alert(ob_category);
//   $(".loader").show();
//   $.ajax({
//     url:'<?php //echo base_url(); ?>template/c_temp/get_objects',
//     type:'post',
//     dataType:'json',
//     data:{'ob_category':ob_category},
//     success:function(data){
//       var brands = [];
//        // alert(data.length);return false;
//       for(var i = 0;i<data.length;i++){
//         brands.push('<option value="'+data[i].OBJECT_ID+'">'+data[i].OBJECT_NAME+'</option>')
//       }
//       $('#objects').html("");
//       $('#objects').append('<label>objects:</label><select name="bd_objects" id="bd_objects" class="form-control bd_objects" data-live-search="true" required>'+brands.join("")+'</select>');
//       $('.objects').selectpicker();
//     },
//      complete: function(data){
//       $(".loader").hide();
//     }
//   });
// });
</script>