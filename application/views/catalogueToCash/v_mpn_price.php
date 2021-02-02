 <?php $this->load->view('template/header'); 
      
?>
<style>

  #specific_fields{display:none;}
  .specific_attribute{display: none;}


.details-control {
            text-align:center;
            color:forestgreen;
    cursor: pointer;
}
tr.shown .details-control{
    text-align:center; 
    color:red;
}
th, td { white-space: nowrap; }



</style> 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Search Mpn Price
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Search Mpn Price</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content"> 
       <!-- Title filtering section start -->

          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Criteria</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
            <div class="box-body"> 
              <form action="<?php echo base_url().'reports/c_offer_report/mpn_price_criteria'; ?>" method="post" accept-charset="utf-8">
                
              <div class="col-md-12">
                
                <div class="col-sm-3">                
                    <div class="form-group">
                      <label for="Search Keyword">Search Category:</label>
                        <input type="text" name="mpn_cata" class="form-control mpn_cata" placeholder="Search Category" value="<?php echo htmlentities($this->session->userdata('mpn_cata')); ?>" required> 
                    </div>              
                  </div>


                <div class="col-sm-2">
                  <div class="form-group" id="conditionDropdown">
                    <label for="Condition">Condition:</label>
                    
                      <select  name="get_cond" id="get_cond" class="selectpicker form-control"  data-actions-box="true" data-live-search="true">
                           <option value="">Select Condition </option>
                        <?php                                
                         foreach ($dataa['conditions']  as $cat){

                              ?>
                              <option value="<?php echo $cat['ID']; ?>" <?php if($this->session->userdata('get_cond') == $cat['ID']){echo "selected";}?>> <?php echo $cat['COND_NAME']; ?> </option>
                              <?php
                              } 
                         
                      ?>              
                      </select> 

                  </div>
                </div>

                

                  <div class="col-sm-3">                
                    <div class="form-group">
                      <label for="Search Keyword">Search Keyword:</label>
                        <input type="text" name="search_key" class="form-control" placeholder="Search Keyword" value="<?php echo htmlentities($this->session->userdata('search_key')); ?>" > 
                    </div>              
                  </div>
                   <div class="col-sm-4">                
                    <div class="form-group">
                      <label for="Exclude Keyword">Exclude Keyword:</label>
                        <input type="text" name="exclude_key" class="form-control" placeholder="Exclude Keyword" value="<?php echo htmlentities($this->session->userdata('exclude_key')); ?>" > 
                    </div>              
                  </div>
                </div>
                
              <div class="col-md-12">
                  <div class="col-sm-1">                
                    <div class="form-group">
                      <label for="Search Keyword"></label>
                      <input type="submit" class="form-control btn btn-primary btn-sm " name="search_webhook" id="search_webhook" value="Search">
                    </div>              
                  </div>

                  <div class="col-sm-2">                
                    <div class="form-group">
                      <h3 style="color:red;"> Average Price : <?php echo @$data['sql'][0]['SALE_PRICE'];  ?> </h3>
                    </div>              
                  </div>
                </div>
                </form>
              <form action="<?php echo base_url().'reports/c_offer_report/mpn_price_update'; ?>" method="post" accept-charset="utf-8">
              <div class="col-sm-12">
                <div class="col-sm-2">                
                    <div class="form-group">
                      <label for="Search Keyword">Enter Mpn:</label>
                        <input type="text" name="get_mpn" class="form-control" placeholder="Enter Mpn" value="<?php //echo htmlentities($this->session->userdata('')); ?>" required > 
                    </div>              
                  </div>
                   <div class="col-sm-4">                
                    <div class="form-group">
                      <label for="Search Keyword">Mpn Description:</label>
                        <input type="text" name="get_desc" class="form-control" placeholder="Enter Mpn Description" value="<?php //echo htmlentities($this->session->userdata('')); ?>" required> 
                    </div>              
                  </div>
                  <div class="col-sm-2">                
                    <div class="form-group">
                      <label for="Search Keyword">Object Name:</label>
                        <input type="text" name="get_obj" class="form-control get_obj" placeholder="Enter Object" value="<?php //echo htmlentities($this->session->userdata('')); ?>" required> 
                    </div>              
                  </div>
                  <div class="col-sm-2">                
                    <div class="form-group">
                      <label for="Search Keyword">Upc:</label>
                        <input type="text" name="get_upc" class="form-control" placeholder="Enter Upc" value="<?php //echo htmlentities($this->session->userdata('')); ?>" > 
                    </div>              
                  </div> 
                  <div class="col-sm-2">                
                    <div class="form-group">
                      <label for="Search Keyword">Brand:</label>
                        <input type="text" name="get_brand" class="form-control" placeholder="Enter Brand" value="<?php //echo htmlentities($this->session->userdata('')); ?>" > 
                    </div>              
                  </div>
                  <!-- <div class="col-sm-3">                
                    <div class="form-group">
                      <label for="Search Keyword">Enter Average Sell Price:</label>
                        <input type="text" name="get_pric" class="form-control" placeholder="Enter Average Sell Price" value="<?php //echo htmlentities($this->session->userdata('')); ?>" > 
                    </div>              
                  </div> -->

                  

              </div>
              <div class="col-sm-12">
                  <div class="col-sm-1">                
                    <div class="form-group">
                      
                      <input type="submit" class="form-control btn btn-success btn-sm " name="varify_mpn" id="varify_mpn" value="Verify Mpn">
                    </div>              
                  </div>
                  <div class="col-sm-1">                
                    <div class="form-group">
                      
                     <button type="button" class="btn btn-info sav_obj" name="sav_obj" id="sav_obj">Save Object</button>
                    </div>              
                  </div>
                  <div class="col-sm-10">
                      
                  </div>
              </div>
              </form>

              
              
                   
            </div>
              <!-- /.box-body -->
              
          </div>
           <!-- Item Specific Start -->
<?php if(!empty($this->session->userdata('mpn_cata'))):  ?>
            <div class="box collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title">Add Custom Attribute & Specifics</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
            </div>

                <div class="box-body">
       
                      <div class="col-sm-12">

                        <div class="col-sm-3">
                          <button type="button" id="add_attribute" class="btn btn-default btn-block">Enter your own attribute</button><br>
                        </div>
                        <div class="specific_attribute">
                          
                          <!-- <form action="<?php //echo base_url('specifics/c_item_specifics/attribute_value'); ?>" method="post"> -->
                          <div class="col-sm-3">
                            <select  name="spec_name" id="spec_name"  class="selectpicker form-control" data-live-search="true">
                              <option value="">----Select Specific-----</option>
                              <?php
                              foreach(@$dataa['spec_id'] as $count):
                                
                                 echo '<option>'.@$count['SPECIFIC_NAME'].'</option>';
                          
                              endforeach;
                            ?>
                            </select>                           
                          </div>
                          <div class="col-sm-3">
                            <input class='form-control' type='text' name='custom_attribute' id="custom_attribute" value='' placeholder="Enter your own" />
                          </div>
                          <div class="col-sm-3">
                            
                            <input type="submit" name="save_attri" id="save_attri" class="add-row btn btn-success" value="Save">
                          </div>
                        <!-- </form> -->
                      </div>
                      
                      </div>

                      <div class="col-sm-12" style="margin-top: 15px;">

                        <div class="col-sm-3">
                          <button type="button" id="add_specific" class="btn btn-primary btn-block" >Add your own item specific</button><br>
                          
                        </div>
                     
                        <div id="specific_fields">
                        <!-- <form action="<?php //echo base_url('specifics/c_item_specifics/update_cat_id'); ?>" method="post"> -->
                          <div class='col-sm-3'>
                            <div class='form-group'>
                              <input class='form-control' type='text' name='custom_name' id="custom_name" value='' placeholder='Enter item specific name'/>
                              <span>For example, Brand, Material, or Year</span>
                            </div>
                          </div>
                          <div class='col-sm-3'>
                            <div class='form-group'>
                              <input class='form-control' type='text' name='custom_value' id="custom_value" value='' placeholder='Enter item specific value'/>
                              <span>For example, Ty, plastic, or 2007</span>
                            </div>
                          </div>                                                

                          <div class="col-sm-3">
                            <div class="form-group">
                              <input type="submit" class="btn btn-success btn-small" name="custom_specific" id="custom_specific" value="Save">
                            </div>
                          </div>
                          <!-- </form>  -->                             
                        </div>                        
                      </div>
              
                                           

                </div>
            </div>
<?php     endif; ?>            
        <!-- Item Specific end -->                    


          <div class="box">
            <div class="box-header with-border">
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
            <div class="box-body"> 
            
              <div class="col-md-12">

                <table id="mpn_price_table" class="table  table-responsive table-striped table-bordered table-hover" width="100%">
                  <thead>

                   <tr>
                    
                      <th>EBAY ID</th>
                      <th>TITLE</th>
                      <th>MPN</th>
                      <th>MPN DESCRIPTION</th>
                      <th>CONDITION NAME</th>
                      <th>SALE PRICE</th>
                      <th>BRAND</th>
                      
                      
                                          
                    </tr>
                  </thead>
                </table>              
                    <!-- nav-tabs-custom -->
                  </div>
                   
                <!-- /.col --> 

                </div>
              <!-- /.box-body -->
              
            </div>
        <!-- /.col -->
      </section>

      <!-- /.row -->
  <!-- Trigger the modal with a button -->
  <!-- Modal --> 
    <!-- /.content -->
  </div>  


  <div id="view-modal" class="modal  fade" role="dialog" style="width: 100%;">
    <div class="modal-dialog" style="width: 50%;height:100px !important;">
      <!-- Modal content-->
      <div class="modal-content" style="width: 100%; ">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit</h4>
        </div>
        <div class="modal-body" >
          <section class="content" id="appCat"> 

          </section>                  
        </div>
        <div class="modal-footer">
          <!--   <button type="button" id="updateSpec" class="btn btn-outline pull-right" data-dismiss="modal">Update</button> --> 
            <button type="button" id="closeSuccess" class="btn btn-sucess pull-left" data-dismiss="modal">Close</button>         

        </div>
              
      </div>
    </div>

  </div>
    <!-- /.row -->
  <!-- Trigger the modal with a button -->
    
<!-- End Listing Form Data -->
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>

 <script >
   

   $(document).ready(function(){
      var data_table = $('#mpn_price_table').DataTable( { 
      "oLanguage": {
      "sInfo": "Total Records: _TOTAL_",
          
    },
      "iDisplayLength": 25,
      "aLengthMenu": [[25, 50, 100, 200,500, -1], [25, 50, 100, 200,500, "All"]],       
       "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "Filter":true,
      "info": true,
      "bProcessing": true,
      "bRetrieve":true,
      "bDestroy":true,
      "bServerSide": true,
      "sScrollY": "600px",
      "sScrollX": true,
      "fixedHeader": true,
      "bScrollCollapse": true,
      "bPaginate": true,
      "fixedColumns": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
      "ajax":{
        url :"<?php echo base_url().'reports/c_offer_report/load_mpn_price' ?>", // json datasource
        type: "post"  
      },

        "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ],

      });

});

$("#save_attri").click(function(){

  var cat_id = $('.mpn_cata').val();

    var custom_attribute = $("#custom_attribute").val();
    var spec_name = $("#spec_name").val();
    // console.log(spec_name);
    // return false;

  if(cat_id == '') {
    $(".mpn_cata" ).focus();
  alert('Category Id Is Empty');
  return false;   
}

  if(custom_attribute == '' || custom_attribute == null){
     $("#custom_attribute" ).focus();
    alert('Please insert custom attribute value');    
    return false;
  }
  if(spec_name == '' || spec_name == null){
     $("#spec_name" ).focus();
    alert('Please Select Specific');    
    return false;
  }

    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>specifics/c_item_specifics/attribute_value',
      data: { 'cat_id' : cat_id ,'custom_attribute' : custom_attribute , 'spec_name' : spec_name  },
     success: function (data) {
        if(data == false){
          alert('Attribute value is already exist.');
          return false;
          }else{
            alert('Record successfully added.');
          }          
     }
      }); 
});


$("#custom_specific").click(function(){
    var cat_id = $(".mpn_cata").val();
    var custom_name = $("#custom_name").val();
    var custom_value = $("#custom_value").val();
    var maxValue = $("#maxValue").val();
    var selectionMode = $("#selectionMode").val();
    var catalogue_only = $("#catalogue_only").val();

    //alert(catalogue_only);return false;
if(cat_id == '') {
    $(".mpn_cata" ).focus();
  alert('Category Id Is Empty');
  return false;   
}
  if(custom_name == '' || custom_name == null){
    alert('Please insert specific name');
    $("#custom_name").focus();
    return false;
  }else if(custom_value == '' || custom_value == null){
    alert('Please insert specific value');
    $("#custom_value").focus();
    return false;
  }
  if(selectionMode == 'FreeText' && maxValue > 1){
    alert('You can only insert 1 against FreeText.');
    return false;
  }  

    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>specifics/c_item_specifics/custom_specific_name',
      data: { 'cat_id' : cat_id,
              'custom_name' : custom_name,
              'custom_value' : custom_value,
              'maxValue': maxValue,
              'selectionMode': selectionMode
    },
     success: function (data) {
        if(data == false){
          alert('Specific name is already exist.');
          return false;
          }else{
            alert('Record successfully added.');
          }          
     }
      }); 
 });

// checklist name check from db

$(document).on('click','.sav_obj',function(){
// $( ".get_obj" ).focus();
// return false;
  var sav_objct = $('.get_obj').val();
  var mpn_cata = $('.mpn_cata').val();

  if(sav_objct == '') {
    $(".get_obj" ).focus();
  alert('Object  Is Empty');
  return false;  
  
}
if(mpn_cata == '') {
    $(".mpn_cata" ).focus();
  alert('Category Id Is Empty');
  return false;   
}

  $.ajax({
    url: '<?php echo base_url();?>reports/c_offer_report/save_object', 
    type: 'post',
    dataType: 'json',
    data : {'sav_objct':sav_objct,'mpn_cata':mpn_cata},

    success:function(data){
      if(data){
        alert('Object Saved');
        return false;                        
      }else{
        alert('alredy exist');
        return false;
      }
    }
  });
});
 </script>