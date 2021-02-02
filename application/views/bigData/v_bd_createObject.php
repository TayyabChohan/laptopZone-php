<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo (isset($pageTitle)) ? $pageTitle : 'Dashboard'; ?> 
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo (isset($pageTitle)) ? $pageTitle : 'Dashboard'; ?> </li>
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
            <?php } 
            ?>                 
            <!-- </div> --> 

            <div class="col-sm-12">
              <form action="<?php echo base_url(); ?>bigData/c_bd_recognize_data/queryObject" method="post" accept-charset="utf-8">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="Search Webhook">Search:</label>
                      <input type="text" name="bd_search" id="bd_search" class="form-control" value="<?php echo $this->session->userdata('search_key'); ?>">                      
                  </div>
                </div>  
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="Conditions" class="control-label">Category:</label>
                    <select name="bd_category" id="bd_category" class="form-control selectpicker" required="required" data-live-search="true">
                      <option value="0">---</option>
                      <?php                                
                         if(!empty($getCategories)){

                          foreach ($getCategories as $cat){

                              ?>
                              <option value="<?php echo $cat['CATEGORY_ID']; ?>" <?php if($this->session->userdata('category_id') == $cat['CATEGORY_ID']){echo "selected";}?>> <?php echo $cat['CATEGORY_NAME'].'-'.$cat['CATEGORY_ID']; ?> </option>
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

          
        <div class="row">
      <div class="col-sm-12">
      <?php /*=====================================
=            Summary block            =
=====================================*/ ?>
          <div class="box">
              <div class="box-header with-border">
               <h3 class="box-title">Category Statistics</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                </div> 
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                  
                    <?php
                      //$array_count = count(@$data['mt_id']);

                      //var_dump($count);
                    //exit;
                      //$i=1;

                      //foreach(@$getStatistics as $name):
                    ?>
                      <div class="col-sm-3">
                        <div class="form-group">

                          <label for="" value="<?php //echo @$name['SPECIFIC_NAME']; ?>" id="<?php //echo 'specific_name_'.@$i;?>"><?php //echo @$name['SPECIFIC_NAME']; ?></label>
                          

                          <input type="text" name="<?php //echo 'specific_name_'.@$i;?>" class="form-control" id="<?php //echo @$name['MT_ID']; ?>" value="<?php //echo @$name['CNT']; ?>">
                          </div>                                     
                        </div> 
                        

                      <?php //$i++; endforeach; ?>
<!--             <div class="box-header with-border">
               <h3 class="box-title">Add Data Type</h3>
            </div> -->
              </div> <!-- boxbody -->
            </div> <!-- box -->


<?php /*=====  End of Summary block  ======*/
 ?>
      <?php echo form_open('bigData/c_bd_recognize_data/saveObject', 'id = "myform"'); ?>
          <?php if(!empty(@$getSpecifics)):?> 
          <div class="box">
              <div class="box-header with-border">
               <h3 class="box-title">Add Item Specifics</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                </div> 
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                  <input type="hidden" class="form-control" id="array_count" name="array_count" value="<?php echo count(@$getSpecifics['spec_name']);  ?>">
                  <input type="hidden" name="bd_search" id="bd_search" class="form-control" value="<?php echo $this->session->userdata('search_key'); ?>">
                  <input type="hidden" class="form-control" id="cat_id" name="cat_id" value="<?php echo $this->session->userdata('category_id');  ?>">
                  
                    <?php
                      //$array_count = count(@$data['mt_id']);

                      //var_dump($count);
                    //exit;
                      $i=1;
                      foreach(@$getSpecifics['spec_name'] as $name):
                    ?>
                      <div class="col-sm-3">
                        <div class="form-group">

                          <label for="" value="<?php echo @$name['SPECIFIC_NAME']; ?>" id="<?php echo 'specific_name_'.@$i;?>"><?php echo @$name['SPECIFIC_NAME']; ?></label>
                          <input type="hidden" name="<?php echo 'specific_name_'.@$i;?>" class="<?php echo 'specific_name_'.@$i;?>" id="<?php echo @$name['MT_ID']; ?>" value="<?php echo @$name['MT_ID'].'_'.@$name['SPECIFIC_NAME']; ?>">
                          
                         <?php if(@$name['MAX_VALUE'] > 1){ 
                          // echo '<br><select name="specific_'.@$i.'" id="specific_'.@$i.'" class="selectpicker" multiple><option value="select_select">------------Select------------</option>';

                          echo '<select class="form-control" name="specific_'.@$i.'" id="specific_'.@$i.'" ><option value="select_select">------------Select------------</option>';
                        }else{
                           echo '<select class="form-control" name="specific_'.@$i.'" id="specific_'.@$i.'" ><option value="select_select">------------Select------------</option>';
                        }
                          ?>
                          <?php foreach(@$getSpecifics['spec_value'] as $specifics): ?>
                                                     
                            <?php
                              if($specifics['MT_ID'] == @$name['MT_ID']): 
                                   //if(@$specifics['SELECTION_MODE'] == "FreeText"){
                                    echo '<option value="'.htmlentities(@$specifics['DET_ID'].'_'.@$specifics['SPECIFIC_VALUE']).'">'.@$specifics['SPECIFIC_VALUE'].'</option>';
                      
                                  //}
                                 endif;
                              ?>
                              <?php
                              endforeach;
                            ?>
                           </select>
                          
                          </div>                                     
                        </div> 
                        

                      <?php $i++; endforeach; ?>
<!--             <div class="box-header with-border">
               <h3 class="box-title">Add Data Type</h3>
            </div> -->
              </div> <!-- boxbody -->
            </div> <!-- box -->
            <div class="box">
              <div class="box-header with-border">
            <div class="col-sm-3">
              <div class="form-group">
                <label for="object_bd" class="control-label">Object:</label>
                <input type="text" name="object_bd" id="object_bd" class="form-control" value="<?php echo $this->session->userdata('search_key'); ?>">
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="mpn_bd" class="control-label">MPN</label>
                  <input type="text" name="mpn_bd" id="mpn_bd" class="form-control" value="<?php echo $this->session->userdata('search_key'); ?>">
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="model_bd" class="control-label">Model</label>
                  <input type="text" name="model_bd" id="model_bd" class="form-control" value="<?php echo $this->session->userdata('search_key'); ?>">
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="manufacturer_bd" class="control-label">Manufacturer</label>
                  <input type="text" name="manufacturer_bd" id="manufacturer_bd" class="form-control" value="<?php echo $this->session->userdata('search_key'); ?>">
              </div>
            </div>
            <div class="col-sm-1 p-t-24">
              <div class="form-group">
                <input type="submit" class="btn btn-primary" name="recognizeObject" value="Recognize"> 
              </div>
            </div>

            <div class="col-sm-1 p-t-24">
              <div class="form-group">
                <input type="button" class="btn btn-success" name="recognize_all"  id="recognize_all" value="Recognize All"> 
              </div>
            </div>

          </div><!-- /.boxbody -->
        </div><!-- /.box -->
      </div><!-- /.col-sm-12 -->
    </div><!-- /.row -->    
        <div class="box">
          <div class="box-body form-scroll">

            <div class="col-sm-12">

                    <table id="recognizeData" class="table table-responsive table-striped table-bordered table-hover recognizeData" >

                    <thead>
                      <tr>
                          <th>
                            <div style="width: 80px!important;">
                             
                              <input class="" name="btSelectAll[]" type="checkbox" onclick="toggleRecord(this)">&nbsp;Select All
                            </div>
                          </th>
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
                      </tr>  
                    </thead>
                     
                  </table>          

              <div class="col-sm-1">
                <div class="form-group">
                 <input type="submit" class="btn btn-success" name="recognizeObject" value="Recognize"> 
                </div>
              </div>                    
            </div><!-- /.col -->
                    
          </div>
        </div>
        <?php endif;
echo form_close();
         ?> 

      </div>
        <!-- /.col -->
    </div>
      <!-- /.row -->
  </section>

  <?php 
      $this->session->unset_userdata('search_key');
      $this->session->unset_userdata('category_id');
   ?>
    <!-- /.content -->
</div>

<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>
 <script type="text/javascript">
   $(document).ready(function(){

    /*========================================================
    =            server side script for datatable            =
    ========================================================*/
    var bd_category = $('#bd_category').val();
    var bd_search = $('#bd_search').val();
    var dataTable = $('#recognizeData').DataTable( {
      "oLanguage": {
      "sInfo": "Total Records: _TOTAL_"
    },
    // For stop ordering on a specific column
    columnDefs: [ { orderable: false, targets: [0] }],
    "iDisplayLength": 100,
    "aLengthMenu": [[25, 50, 100, 200], [25, 50, 100, 200]],
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      //"order": [[ 8, "desc" ]],
      // "order": [[ 16, "ASC" ]],
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
      "processing": true,
      "serverSide": true,
      
      "ajax":{
        url :"<?php echo base_url() ?>bigData/c_bd_recognize_data/loadData", // json datasource
        type: "post",  // method  , by default get
        data: {'bd_search' : bd_search,'bd_category' : bd_category},
        error: function(){  // error handling
          $(".categoryData-error").html("");
          $("#categoryData").append('<tbody class="categoryData-error"><tr><th colspan="12">No data found in the server</th></tr></tbody>');
          $("#categoryData_processing").css("display","none");
          
        }
      }
      //dataTable.destory();
    } );
    
    //dataTable.destory();
    /*=====  End of server side script for datatable  ======*/
    
    /*=====================================
=            recognize all            =
=====================================*/
 $("#recognize_all").click(function(){

    

      var bd_category = $('#bd_category').val();
      var bd_search = $('#bd_search').val();
      var object_bd = $('#object_bd').val();
      var mpn_bd = $('#mpn_bd').val(); 
      var array_count = $('#array_count').val();
      var model_bd = $('#model_bd').val();
      var manufacturer_bd = $('#manufacturer_bd').val();
      var spec_name=[];
      var spec_value=[];
      for (var i = 1; i <= array_count; i++) { 
        if($('#specific_'+i).val() != 'select_select' ){
              spec_name.push($('.specific_name_'+i).val()); 
              spec_value.push($('#specific_'+i).val());
        }
      }
    //console.log(spec_name,spec_value);return false;    
              
$.ajax({
      //dataType: 'json',
      type: 'POST',
      url:'<?php echo base_url(); ?>bigData/c_bd_recognize_data/recognizeAll',
      data: {
              'bd_search' : bd_search,
              'bd_category' : bd_category,
              'object_bd' : object_bd,
              'mpn_bd' : mpn_bd,
              //'array_count' : array_count,
              'model_bd' : model_bd,
              'manufacturer_bd' : manufacturer_bd,
              'spec_name' : spec_name,
              'spec_value' : spec_value
            },
      // error: function(){  // error handling
      //     $(".categoryData-error").html("");
      //     $("#categoryData").append('<tbody class="categoryData-error"><tr><th colspan="12">No data found in the server</th></tr></tbody>');
      //     $("#categoryData_processing").css("display","none");
          
      //   }
     success: function () {
      window.location.href = '<?php echo base_url(); ?>bigData/c_bd_recognize_data/queryObject';

     }
  });

});


/*=====  End of recognize all  ======*/
     
   });
function toggleRecord(source) {
    checkboxes = document.getElementsByName('select_recognize[]');
    for(var i=0, n=checkboxes.length;i<n;i++) {
      checkboxes[i].checked = source.checked;
    }
  }
  /*-- Start auto fill specs --*/
function autoFill(clicked_id) {
    $.ajax({
      dataType: 'json',
      type: 'POST',
      url:'<?php echo base_url(); ?>bigData/c_bd_recognize_data/autoFill',
      data: {
              'lz_bd_cata_id' : clicked_id
            },
     success: function (response) {
      $("#myform")[0].reset();
      
      //$('select option:selected').removeAttr('selected');
      for(var i = 0; i<response.spec_qry.length; i++){
        var t = response.spec_qry[i].MT_ID;
        var label_name = $('#'+t).attr("name");
        var dropdown_id = label_name.replace("_name", "");
        $('#'+dropdown_id).val(response.spec_qry[i].SPECIFIC_VALUE);
      }

      for(var i = 0; i<response.mpn_qry.length; i++){
        if(response.mpn_qry[i].DATA_TYPE == 'MPN'){
          $('#mpn_bd').val(response.mpn_qry[i].DATA_DESC);
        }
      }

      
     }
  });
}
/*-- End auto fill specs --*/
 </script>