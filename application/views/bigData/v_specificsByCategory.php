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
               
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="Specs" class="control-label">Specs For:</label>
                    <select name="specs" id="specs" class="form-control selectpicker" data-live-search="true" required>
                      <option value="1">Auto Catalogue</option>
                      <option value="2">Auto Kit</option>
                      <option value="3">Auto Expression</option>
                    </select>
                  </div>
                </div>

 

              


                <div class="col-sm-2">
                  <div class="form-group p-t-24">
                    <input type="submit" class="btn btn-success btn-sm" name="search_list" id="search_list" value="Search">
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group p-t-24">
                    <a  href="<?php echo base_url();?>bigData/c_autoCatalog/specificsDetailView" class="btn btn-primary btn-sm" name="detail_view" id="detail_view" target="_blank">Detail View</a>
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
          <!-- /.box-body -->
          <!-- <div class = "col-sm-12">
            <div class="col-sm-1">
                <div class="form-group p-t-24">
                  <input type="button" class="btn btn-primary btn-sm" name="saveSpecs" id="saveSpecs" value="Save">
                
                </div>
            </div>
          </div> -->
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
<?php $this->load->view('template/footer'); ?>

<script>
 var dataTable = '';
$('#search_list').on('click',function(){

  var cat_id = $('#bd_category').val();

  $.ajax({
        url :"<?php echo base_url().'bigData/c_autoCatalog/loadSpecifics' ?>", // json datasource
        type: "post" , // method  , by default get
        dataType:'json',
        data:{'cat_id':cat_id},
        success : function(data){
          // console.log(data.length);return false;
          var specs = [];
          var j = 0;
          for(var i=0;i<data.length;i++){
              j = j+1;
            specs.push('<tr><td>'+j+'</td><td id="specific_name_'+i+'">'+data[i].SPECIFIC_NAME+'<input type="hidden" id="mt_id_'+i+'" value="'+data[i].MT_ID+'" name="hidd"></td><td><input name="checkData" type="checkbox" id="checkbox_'+i+'" class="checkboxes"></td></tr>');
          }

          $('#clear').html("");
          $('#clear').append('<form id="insertData" class="insertData"><table id="specificList" class="table table-responsive table-striped table-bordered table-hover specificList"><thead> <th>SR.NO </th> <th>Specifics </th> <th>Check/Uncheck </th> </thead><tbody>'+specs.join("")+'</tbody></table>          <div class = "col-sm-12"> <div class="col-sm-1"> <div class="form-group p-t-24"> <input type="button" class="btn btn-primary btn-sm" name="saveSpecs" id="saveSpecs" value="Save"> </div> </div> </div></form>');

            dataTable = $('#specificList').DataTable({
              "oLanguage": {
              "sInfo": "Total Records: _TOTAL_"
            },
              "iDisplayLength": 10,
              "aLengthMenu": [[25, 50, 100, 200,500, -1], [25, 50, 100, 200,500, "All"]],
              "paging": true,
              "lengthChange": true,
              "searching": true,
              "ordering": true,
              
              "info": true,
              "autoWidth": true
              // "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
            });
          

        }


  });

  

});

$(document).on('click','#saveSpecs',function(){
  var spec_checked = [];
  // var spec_checked = $('#insertData').serialize();
  var cat_id = $('#bd_category').val();
  var specs = $('#specs').val();
  var i =0;
  var j=0;

  
  // $('.checkboxes').each(function(){
  //     var checkbox = $('#checkbox_'+i+'').prop('checked');

  //     if(checkbox == true){
  //       spec_checked.push($('#mt_id_'+i+'').val());
  //         // alert(i);
  //         // alert($('#det_id_'+i+'').val());return false;
  //         j++;
  //     }
  //     i++;
  // });
  // input[name="checkData"]
  dataTable.$('.checkboxes').each(function(){
    
    var checkbox = dataTable.$('#checkbox_'+i+'').prop('checked');
      if(checkbox == true){
        spec_checked.push(dataTable.$('#mt_id_'+i+'').val());
          // alert(i);
          // alert($('#det_id_'+i+'').val());return false;
          j++;
      }
      i++;
  });
  // alert(j);return false;
  
  // alert(spec_checked);return false;
  if(j == 0){
    alert('Please Select Some value/values');return false;
  }else{
    // alert(spec_checked);return false;
        $.ajax({
     url: '<?php echo base_url() ?>bigData/c_autoCatalog/saveSpecifics', //maintains the (controller/function/argument) logic in the MVC pattern
        type: 'post',
        dataType: 'json',
        data : {'spec_checked':spec_checked,'cat_id':cat_id,'specs':specs},
        success: function(data){
            if(data == 1){
              alert('Specifics inserted against :'+cat_id+'');
            }else{

              alert('Data already exist');
            }
        }

    });
  }

});

// $(document).on('submit','#insertData',function(e){
//   var cat_id = $('#bd_category').val();
//   e.preventDefault();

//   var data = dataTable.$('input').serialize();
//   // alert(data);return false;
//   $.ajax({
//      url: '<?php //echo base_url() ?>bigData/c_autoCatalog/saveSpecifics',
//      type: 'post',
//      dataType: 'json',
//      data:{data,cat_id},
//      success: function(data){
//         if(data == 1){
//           alert('Specifics inserted against :'+cat_id+'');
//         }else{

//           alert('Data already exist');
//         }
//      }     

//   });
// });
</script>