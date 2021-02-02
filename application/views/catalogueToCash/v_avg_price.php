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
              <form action="<?php echo base_url().'reports/c_offer_report/get_avg_price'; ?>" method="post" accept-charset="utf-8">
                
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
                        <input type="text" name="exclude_key" class="form-control" placeholder="Exclude Keyword" value="<?php if(!empty($this->session->userdata('exclude_key'))){echo htmlentities($this->session->userdata('exclude_key'));}else{echo 'Lot';} ?>" > 
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
                    <div class="form-group" style="color:red;">
                     <!--  <h3 style="color:red;"> Average Price : <?php //echo @$data['sql'][0]['SALE_PRICE'];  ?> </h3> -->
                      <label for="Avg Price">Avg Price:</label>
                        <input type="text" name="avg_price" class="form-control" placeholder="Avg Price" value="<?php echo @$data['sql'][0]['SALE_PRICE']; ?>" readonly> 
                    </div>              
                  </div>
                  <div class="col-sm-2">                
                    <div class="form-group" style="color:red;">
                     <!--  <h3 style="color:red;"> Average Price : <?php //echo @$data['sql'][0]['SALE_PRICE'];  ?> </h3> -->
                      <label for="sold_qty">Sold Qty:</label>
                        <input type="text" name="sold_qty" class="form-control" placeholder="Sold Qty" value="<?php echo @$data['sql'][0]['QTY_SOLD']; ?>" readonly> 
                    </div>              
                  </div>
                </div>
                </form>


              
              
                   
            </div>
              <!-- /.box-body -->
              
          </div>
                 



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