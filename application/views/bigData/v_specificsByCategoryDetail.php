<?php $this->load->view('template/header'); 
ini_set('memory_limit', '-1'); // add for picture loading issue
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Specifics List
    </h1>
    <ol class="breadcrumb">
      <li>
        <a href="<?php echo base_url();?>dashboard/dashboard">
          <i class="fa fa-dashboard">
          </i> Home
        </a>
      </li>
      <li class="active">Specifics List
      </li>
    </ol>
  </section>  
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="box">
          <br>
          <!-- <div class="col-sm-12">
            <div class="col-sm-2">
              <div class="form-group pull-left">
               
              </div>
            </div>
          </div> --> 
          <div class="col-sm-12">
            <!-- <form   accept-charset="utf-8"> -->

                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="Conditions" class="control-label">Category:</label>
                    <select name="bd_category" id="bd_category" class="form-control selectpicker" data-live-search="true" required>
                      <option value="0">---</option>
                      <?php                                
                         if(!empty($data)){

                          foreach ($data as $cat){

                              ?>
                              <option value="<?php echo $cat['EBAY_CATEGORY_ID']; ?>" <?php if($this->session->userdata('bd_category') == $cat['EBAY_CATEGORY_ID']){echo "selected";}?>> <?php echo $cat['CATEGORY_NAME'].'-'.$cat['EBAY_CATEGORY_ID']; ?> </option>
                              <?php
                              } 
                          }
                          $this->session->unset_userdata('bd_category');
                          
                      ?>  
                                          
                    </select>  
                  </div>
                </div>
               



                <div class="col-sm-2">
                  <div class="form-group p-t-24">
                    <input type="submit" class="btn btn-success btn-sm" name="search_list" id="search_list" value="Search">
                  </div>
                </div>

            <!-- </form> -->
          </div>    
          <div class="box-body form-scroll">  
            <?php if($this->session->flashdata('success')){ ?>
            <div id="successMsg" class="alert alert-success">
              <a href="#" class="close" data-dismiss="alert">&times;
              </a>
              <strong>Success!
              </strong> 
              <?php echo $this->session->flashdata('success'); ?>
            </div>
            <?php }else if($this->session->flashdata('error')){  ?>
            <div id="errorMsg" class="alert alert-danger">
              <a href="#" class="close" data-dismiss="alert">&times;
              </a>
              <strong>Error!
              </strong> 
              <?php echo $this->session->flashdata('error'); ?>
            </div>
            <?php } ?>    
            <div class="col-md-12" id='clear'>
              <!-- Custom Tabs -->
              <!-- <table id="specificList" class="table table-responsive table-striped table-bordered table-hover specificList">
               <!--  <thead> <th>SR.NO </th> <th>Specifics </th> <th>Check/Uncheck </th> </thead> -->
              <!-- </table>  -->
            </div>
            <!-- /.col --> 
          </div>
   
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>    
<!-- End Listing Form Data -->
 <!-- Modal -->
               

<div id="success-modal" class="modal modal-success fade" role="dialog" ">
  <div class="modal-dialog" >
    <!-- Modal content-->
    <div class="modal-content" >
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Message</h4>
      </div>
      <div class="modal-body" style="height: 80px !important;">
        <section class="" > 
          <p id="successMessage"> </p>         

        </section>                  
      </div>
      <div class="modal-footer">
          <button type="button" id="closeSuccess" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>         

      </div>
            
    </div>
  </div>

</div> 

<div id="danger-modal" class="modal modal-danger fade" role="dialog" style="width: 100%;">
  <div class="modal-dialog" style="width: 50%;height:100px !important;">
    <!-- Modal content-->
    <div class="modal-content" style="width: 100%; ">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Message</h4>
      </div>
      <div class="modal-body" style="height: 80px !important;">
        <section class="" > 
          <p> Spec Deleted Successfully !</p>         

        </section>                  
      </div>
      <div class="modal-footer">

          <button type="button" id="closeSuccess" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>         

      </div>
            
    </div>
  </div>

</div> 


<div id="edit-modal" class="modal modal-info fade" role="dialog" style="width: 100%;">
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
          <button type="button" id="updateSpec" class="btn btn-outline pull-right" data-dismiss="modal">Update</button> 
          <button type="button" id="closeSuccess" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>         

      </div>
            
    </div>
  </div>

</div> 

<div id="warning-modal" class="modal modal-warning fade" role="dialog" >
  <div class="modal-dialog" >
    <!-- Modal content-->
    <div class="modal-content"  >
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Seller Notes</h4>
      </div>
      <div class="modal-body" style="height: 80px !important;">
        <section class="" style="height: 70px !important;"> 
          <p> Are you sure you want to delete?</p>         
          <input type="hidden" id="del_value" value="">
        </section>                  
      </div>
      <div class="modal-footer">
          <button type="button" id="delSpecific" class="btn btn-outline pull-right" data-dismiss="modal">Delete</button> 
          <button type="button" id="closeWarning" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>         

      </div>
            
    </div>
  </div>

</div> 

<div id="warning-modal2" class="modal modal-warning fade" role="dialog" >
  <div class="modal-dialog" >
    <!-- Modal content-->
    <div class="modal-content"  >
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Seller Notes</h4>
      </div>
      <div class="modal-body" style="height: 80px !important;">
        <section class="" style="height: 70px !important;"> 
          <p> Are you sure you want to delete All Specicifics?</p>         
          <input type="hidden" id="del_value" value="">
        </section>                  
      </div>
      <div class="modal-footer">
          <button type="button" id="delSpecificAll" class="btn btn-outline pull-right" data-dismiss="modal">Delete</button> 
          <button type="button" id="closeWarning" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>         

      </div>
            
    </div>
  </div>

</div> 
<?php $this->load->view('template/footer'); ?>

<script>
var dataTable='';

function loadTable(){
  var cat_id = $('#bd_category').val();

  $.ajax({
        url :"<?php echo base_url().'bigData/c_autoCatalog/loadSpecificsDetail' ?>", // json datasource
        type: "post" , // method  , by default get
        dataType:'json',
        data:{'cat_id':cat_id},
        success : function(data){
          // console.log(data.length);return false;
          var specs = [];
          var j = 0;
          // var spec_for = 0;
          var specForName = '';
          for(var i=0;i<data.length;i++){
              j = j+1;
              // 1 = AUTO_CATALOGUE, 2 = AUTO_KIT, 3 = AUTO_EXPRESSION
              if(data[i].SPECS_FOR == 1){
                specForName = "AUTO_CATALOGUE"
              }else if(data[i].SPECS_FOR == 2){
                specForName = "AUTO_KIT"
              }else{
                specForName = "AUTO_EXPRESSION"
              }
            specs.push('<tr><td><div style="float:left;margin-right:8px;"><button class="btn btn-xs btn-warning edit_spec" id="edit_'+data[i]['LZ_SPEC_ID']+'" ><span class="glyphicon glyphicon-pencil " aria-hidden="true"></span></button> <button class="btn btn-xs btn-danger delete_spec" id="delete_'+data[i]['LZ_SPEC_ID']+'" style="margin-left: 2px;"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></div></td><td id="specific_name_'+i+'">'+data[i].SPECIFIC_NAME+'<input type="hidden" id="mt_id_'+data[i]['LZ_SPEC_ID']+'" value="'+data[i]['SPECIFIC_MT_ID']+'"></td><td>'+specForName+'</td></tr>');
          }

          $('#clear').html("");
          $('#clear').append('<table id="specificList" class="table table-responsive table-striped table-bordered table-hover specificList"><thead> <th>Action </th> <th>Specifics </th> <th>Specs For </th> </thead><tbody>'+specs.join("")+'</tbody></table>');


            dataTable = $('#specificList').DataTable({
              "oLanguage": {
              "sInfo": "Total Records: _TOTAL_"
            },
              "iDisplayLength": 500,
              "aLengthMenu": [[25, 50, 100, 200,500, -1], [25, 50, 100, 200,500, "All"]],
              "paging": true,
              "lengthChange": true,
              "searching": true,
              "ordering": true,
              
              "info": true,
              "autoWidth": true,
               "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',

            });

            $("#specificList_paginate").append('<div class="pull-left"><button type="button" id="delAll" class="btn btn-sm btn-danger " >Delete All</button><!--<button type="button" id="updateAll" class="btn btn-sm btn-warning " style="margin-left:10px !important;">Update All</button>--><div>');

            if($('#specificList_info').text() == 'Showing 0 to 0 of 0 entries'){
              $('#delAll').prop('disabled',true);
              $('#updateAll').prop('disabled',true);
            }else{
              $('#delAll').prop('disabled',false);
              $('#updateAll').prop('disabled',false);
            }
          
        }
  });

}
$('#search_list').on('click',function(){
  loadTable();
});




$(document).on('click','.delete_spec',function(){
  var id = this.id.match(/\d+/);
  $('#del_value').val(id);
  $('#warning-modal').modal('show');
 
});

$('#delSpecific').on('click',function(){
  var del_id = $('#del_value').val();
  var cat_id = $('#bd_category').val();

   $.ajax({
      dataType: "json",
      data:{'del_id':del_id},
      url : "<?php echo base_url();?>bigData/c_autoCatalog/deleteSpecForCatalogue",
      type: "POST",
      success : function(data){
        if(data == 1){
          $('#danger-modal').modal('show');
        }
        dataTable.destroy();
        loadTable();

      }
  });

});


$(document).on('click','.edit_spec',function(){
  var id = this.id.match(/\d+/);
  var cat_id = $('#bd_category').val();
  var selected = $('#mt_id_'+id+'').val();
  
  $.ajax({
      url :"<?php echo base_url().'bigData/c_autoCatalog/loadSpecifics' ?>", // json datasource
      type: "post" , // method  , by default get
      dataType:'json',
      data:{'cat_id':cat_id},
      success : function(data){
        var catData = [];
        for (var i = 0; i < data.length; i++) {
          catData.push('<option value="'+data[i].MT_ID+'">'+data[i].SPECIFIC_NAME+'</option>');
        }
        $("#appCat").html("");
        $("#appCat").append('<label for="All Specs">Spec List :</label><select  name="oneSpec" id="oneSpec" class="selectpicker form-control"  data-live-search="true">'+catData.join("")+'</select> <input type="hidden" id="oneSpecId" value="'+id+'"> <label for="All Specs">Spec List :</label><select  name="oneSpec" id="forOneSpec" class="selectpicker form-control"  data-live-search="true"><option value="1">Auto Catalogue</option> <option value="2">Auto Kit</option> <option value="3">Auto Expression</option></select>');
        $('select[id=oneSpec]').val(selected);
        $('.selectpicker').selectpicker();

      }
    });
  $('#edit-modal').modal('show');
 
});

$('#updateSpec').on('click',function(){
  var cat_id = $('#bd_category').val();
  var dropVal = $('#oneSpec').val();
  var lz_spec_id = $('#oneSpecId').val();
  var specFor = $('#forOneSpec').val();
  $.ajax({
    url :"<?php echo base_url().'bigData/c_autoCatalog/updateOneSpec' ?>", // json datasource
    type: "post" , // method  , by default get
    dataType:'json',
    data:{'dropVal':dropVal,'cat_id':cat_id,'lz_spec_id':lz_spec_id,'specFor':specFor},
    success : function(data){
      if(data==1){
        $('#successMessage').text('spec updated Successfully !');
        $('#success-modal').modal('show');
        loadTable();
      }
    }
  });
});


$(document).on('click','#delAll',function(){
    $('#warning-modal2').modal('show');

});

$('#delSpecificAll').on('click',function(){
    var cat_id = $('#bd_category').val();
    $.ajax({
      url :"<?php echo base_url().'bigData/c_autoCatalog/deleteAllSpec' ?>", // json datasource
      type: "post" , // method  , by default get
      dataType:'json',
      data:{'cat_id':cat_id},
      success : function(data){
        $('#danger-modal').modal('show');
        loadTable();
      }
  });

});
</script>