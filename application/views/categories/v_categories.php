<?php $this->load->view('template/header'); 
      
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          Categories Group Form
        <small>Control panel</small>
       </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Categories Group Form</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content"> 
      <div class="row">
        <div class="col-sm-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Categories Group</h3>
            </div>
              <!-- /.box-header -->

       <div class="box-body">

                <?php if($this->session->flashdata('category_success')){ ?>
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Success!</strong> <?php echo $this->session->flashdata('category_success'); ?>
                </div>
                <?php }else if($this->session->flashdata('category_error')){ ?>
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Error!</strong> <?php echo $this->session->flashdata('category_error'); ?>
                </div>
                <?php }else if($this->session->flashdata('category_info')){ ?>
                    <div class="alert alert-info">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Error!</strong><?php echo $this->session->flashdata('category_info'); ?>
                </div>
                <?php } ?>  
   
                <?php if($this->session->flashdata('cat_update_success')){ ?>
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Success!</strong> <?php echo $this->session->flashdata('cat_update_success'); ?>
                </div>
                <?php }else if($this->session->flashdata('cat_update_error')){ ?>
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Error!</strong> <?php echo $this->session->flashdata('cat_update_error'); ?>
                </div>
                <?php }else if($this->session->flashdata('cat_update_info')){ ?>
                    <div class="alert alert-info">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Error!</strong><?php echo $this->session->flashdata('cat_update_info'); ?>
                </div>
                <?php } ?>

          <div class="row">
           <form method="post" action=<?php echo base_url(); ?>categories/c_categories/SaveCategory >
          
          <div class="col-sm-12">
              
          <div class="col-sm-3">
              <div class="form-group">
                <label for="Packing Name" class="control-label">Category Group Name:</label>
                  <input type="text" class="form-control" id="category_name" name="category_name" value=''">
              </div>
          </div>

             <div class="col-sm-3">
                  <div class="form-group">
                    <label for="Category">Category Id:</label>
                     
                      <select  name="category[]" id="category" class="selectpicker form-control" multiple data-actions-box="true" data-live-search="true">
                       <!--  <option value="all">All</option> -->
                        <?php
                          foreach(@$categories['query'] as $type):                    
                            $selected = "";           
                              ?>
                             <option value="<?php echo $type['CATEGORY_ID']; ?>"<?php echo $selected; ?>><?php echo $type['CATEGORY_ID'].'-'.$type['KEYWORD']; ?></option>
                              <?php
                            endforeach;
                         
                           ?>                     
                      </select> 

                  </div>
                </div>
        
          <div class="col-sm-2 p-t-24">
                  <div class="form-group">
                    <input type="submit" title="SaveCategory" name="SaveCategory" value="Save" class="btn btn-success">
                </div>
              </div>
        
          </div>
        </form>
          </div>

          </div>
        </div>
      </div>
    </div>
                                    
     <!--       warehouse mt table data start
 -->
    <div class ="row">
      <div class ="col-sm-12">
        <div class="box">
          
            <div class="box-body form-scroll">
              <div class="col-sm-12">

                <table id="get_cata" class="table table-responsive table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Actions</th>
                      <th>Group Name</th>
                      <th>Inserted Date</th>
                      <th>Inserted By</th>
                      <th>Updated Date</th>
                      <th>Updated By</th>
                    </tr>
                  </thead>
                  <tbody>
                  <tr>
                      <?php foreach($categories['cquery'] as $row): ?>
                     <td>
                     <div style="float:left;margin-right:8px;"> 
                     <button title="Delete" class="btn btn-danger btn-xs del_group" style="" id="<?php echo @$row['LZ_BD_GROUP_ID']; ?>"><i class="fa fa-trash-o text text-center" aria-hidden="true"> </i> </button>
                    <button title="Edit Group" class="btn btn-warning btn-xs edit_group" style="" id="<?php echo $row['LZ_BD_GROUP_ID']; ?>"><i class="fa fa-edit" aria-hidden="true"></i></button>
                     </div>
                      </td> 
                      <td ><?php echo @$row['GROUP_NAME'];?></td>
                      <td ><?php echo @$row['INSERTED_DATE'];?></td>
                      <td ><?php echo @$row['NAME'];?></td>                      
                      <td ><?php echo @$row['UPDATED_DATE'];?></td>                      
                      <td ><?php echo @$row['UPDATED_BY'];?></td>                      
                      </tr>
                        <?php endforeach; ?>
                  </tbody>
                </table>              
                            
              </div>
              
            </div>
        </div>
        
      </div>
      
    </div>
     <!--  warehouse mt data end  -->

    </section>
  </div>


<div id="warning-modal" class="modal modal-warning fade" role="dialog" >
  <div class="modal-dialog" >
    <!-- Modal content-->
    <div class="modal-content"  >
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Info</h4>
      </div>
      <div class="modal-body" style="height: 80px !important;">
        <section class="" style="height: 70px !important;"> 
          <p id="warning_info"> </p>         
          <input type="hidden" id="del_value" value="">
        </section>                  
      </div>
      <div class="modal-footer">
        <button type="button" id="closeWarning" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>         

      </div>
            
    </div>
  </div>

</div> 
<!-- err msg modal -->
<div id="danger-modal" class="modal modal-danger fade" role="dialog" >
  <div class="modal-dialog" >
    <!-- Modal content-->
    <div class="modal-content"  >
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Info</h4>
      </div>
      <div class="modal-body" style="height: 80px !important;">
        <section class="" style="height: 70px !important;"> 
          <p id="danger_info"> </p>         
          <input type="hidden" id="del_value" value="">
        </section>                  
      </div>
      <div class="modal-footer">
        <button type="button" id="closeWarning" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
      </div>
            
    </div>
  </div>

</div> 
<!-- end error msg modal -->

<!-- Modal -->
<div id="UpdateCategory" class="modal modal-info fade" role="dialog" style="width: 100%;">
    <div class="modal-dialog" style="width: 70%;">
        <!-- Modal content-->
        <div class="modal-content" style="width: 100%;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Details</h4>
            </div>
            <div class="modal-body">
                <section class="" style="height: 40px !important;"> 
                  <div class="col-sm-12" >
                    <div class="col-sm-6 col-sm-offset-3" id="errorMessage"></div>
                  </div>
                </section>
                <section class="content"> 
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="box" style="border-color: blue !important;">
                        <div class="box-header " style="background-color: #ADD8E6 !important;">
                          <h1 class="box-title" style="color:white;">Category Group Detail</h1>
                          <div class="box-tools pull-right">
                            
                          </div>
                        </div> 
                        <div class="box-body ">
                          <div class="col-sm-12 ">
                            <div class="col-sm-3">
                              <div class="form-group">
                                <label for="Category Name" style = "color: black!important;">Category Group Name:</label>
                                <input name="cat_name" type="text" id="cat_name" class="cat_name form-control " >
                                <input name="cat_id" type="hidden" id="cat_id" class="cat_id form-control " >
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group">
                                <label for="Inserted Date" style = "color: black!important;">Inserted Date:</label>
                                <input name="insert_date" type="text" id="insert_date" class="insert_date form-control" readonly="readonly">
                              </div>
                            </div> 
                            <div class="col-sm-3">
                              <div class="form-group">
                                <label for="Inserted By" style = "color: black!important;">Inserted By :</label>
                                <input name="insert_by" type="text" id="insert_by" class="insert_by form-control" readonly="readonly">
                              </div>
                            </div> 
                            <div class="col-sm-3">
                              <div class="form-group">
                                <label for="Updated Date" style = "color: black!important;">Updated Date:</label>
                                <input name="update_date" type="text" id="update_date" class="update_date form-control" readonly="readonly">
                              </div>
                            </div>  
                                                         
                          </div> <!-- nested col-sm-12 div close-->
                          <div class="col-sm-12">
                            <div class="col-sm-3">
                              <div class="form-group">
                                <label for="Updated By" style = "color: black!important;">Updated By :</label>
                                <input name="update_by" type="text" id="update_by" class="update_by form-control" readonly="readonly">
                              </div>
                            </div> 
                            <div class="col-sm-3">
                            <div class="form-group">
                            <label for="Category" style="color:black!important;">Category Id:</label>
                              <select  name="categories[]" id="categories" class="selectpicker form-control categories" multiple data-actions-box="true" data-live-search="true"> 
                                     
                              </select> 
                          </div>
                          </div>
                           <div class="col-sm-2  p-t-24">
                              <div class="form-group">
                                <input type="button" class="btn btn-primary btn-sm" id="update_cat" name="update_cat" value="UPDATE">
                              </div>
                            </div> 
                             
                        </div> <!-- box body div close-->
            
                    </div><!--box body close -->
                      </div>
                    </div>
                  </div>
                  </section>
                  </div>
            </div>
        </div>
      </div>
<!-- detail modal end -->
<?php $this->load->view("template/footer.php"); ?>
<script>
  $(document).ready(function()
  {
    $('#get_cata').DataTable({
    "oLanguage": {
    "sInfo": "Total Records: _TOTAL_"
  },
  "iDisplayLength": 10,
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    //"aaSorting": [ [1, "desc"] ],
    //"order": [[ 1, "desc" ]],
    "info": true,
    "autoWidth": true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
  });
          
});
//     $('#category_table').DataTable({
//     "oLanguage": {
//     "sInfo": "Total Records: _TOTAL_"
//   },
//   "iDisplayLength": 25,
//     "paging": true,
//     "lengthChange": true,
//     "searching": true,
//     "ordering": true,
//     "aLengthMenu": [[25, 50, 100, 200], [25, 50, 100, 200]],
//     //"aaSorting": [ [1, "desc"] ],
//     "order": [[ ]],
//     "info": true,
//     "autoWidth": true,
//     "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
//   });
          
// });
  $(document).on('click', '.del_group', function(){
  var group_id = $(this).attr("id");
  //console.log(packing_id);
  //return false;
  //alert(lz_estimate_det_id);return false;
  var x = confirm("Are you sure you want to delete?");
  if(x){
    $(".loader").show();
    $.ajax({
      url:'<?php echo base_url(); ?>categories/c_categories/deleteGroup',
      type:'post',
      dataType:'json',
      data:{'group_id':group_id},
      success:function(data){

         if(data == 1){
          var table=$('#category_table').DataTable();
          //$(this).closest('tr').remove();
          table.row( $("#"+group_id).parents('tr') ).remove().draw();
         }else if(data == 2){
          alert("Error! Category Group is not deleted");
         }
      },
       complete: function(data){
        $(".loader").hide();
      },
        error: function(jqXHR, textStatus, errorThrown){
           $(".loader").hide();
          if (jqXHR.status){
            alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
          }
      }
    });
  }else{
    return false;
  }

});


 $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
    $(".alert-danger").slideUp(500);
});
 
 $(".alert-danger").fadeTo(2000, 500).slideUp(500, function(){
    $(".alert-danger").slideUp(500);
});
 $(".alert-info").fadeTo(2000, 500).slideUp(500, function(){
    $(".alert-info").slideUp(500);
});


$(document).on('click','.edit_group',function(){
  var cat_id = this.id;
 //$('#UpdateCategory ').modal('show');
  $(".loader").show();
    $.ajax({
        url: '<?php echo base_url(); ?>categories/c_categories/edit_cat_group', 
        type: 'post',
        dataType: 'json',
        data : {'cat_id':cat_id},
        success:function(data){
          //console.log(data[0].FEED_NAME,data[0].KEYWORD,data[0].CATEGORY_ID);
          $('#UpdateCategory ').modal('show');
          $(".loader").hide();
            if (data.results.length > 0) {
              $('#cat_name').val("");
              $('#cat_name').val(data.results[0].GROUP_NAME);

              $('#insert_date').val("");
              $('#insert_date').val(data.results[0].INSERTED_DATE);

              $('#insert_by').val("");
              $('#insert_by').val(data.results[0].NAME);

              $('#update_date').val("");
              $('#update_date').val(data.results[0].UPDATED_DATE);

              $('#update_by').val("");
              $('#update_by').val(data.results[0].UPDATED_BY);
              
              $('#cat_id').val("");
              $('#cat_id').val(data.results[0].LZ_BD_GROUP_ID);

              var options = [];
            for(var i=0; i<data.all_cats.length; i++){
                for(var j=0; j<data.selected_cats.length; j++){
                      
                      if(data.all_cats[i].CATEGORY_ID == data.selected_cats[j].CATEGORY_ID){
                        var selected = 'selected';
                        break;
                      }else{   
                        var selected = '';
                      }  
                   }
                   options.push('<option value="'+data.all_cats[i].CATEGORY_ID+'" '+selected+'>'+data.all_cats[i].KEYWORD+'</option>');
                } //return false;
                //console.log(options); return false;
                $('#categories').html("");
                $('#categories').html(options);
                $('#categories').selectpicker("refresh");
        }
  }
  //alert(category_id);
});
  });

/*================================================
=            update feed url function            =
================================================*/
$(document).on('click','#update_cat',function(){
var group_id                   = $('#cat_id').val();
var cat_name                   = $('#cat_name').val();
var categories                 = $('#categories').val();
  $(".loader").show();
    $.ajax({
        url: '<?php echo base_url(); ?>categories/c_categories/update_cat_group', 
        type: 'post',
        dataType: 'json',
        data : {
                'group_id' :group_id,
                'cat_name':cat_name,
                'categories':categories,
              },
        success:function(data){
         
         if(data==1){
         $(".loader").hide();
            //alert('Category Group Updated Sucessfully');
            $('#UpdateCategory').modal('hide');
            window.location.reload(true);
          }else{

          if(data){
          $(".loader").hide();
            $('#UpdateCategory').modal('hide');
            window.location.reload(true);
          }else{
            //console.log(data[0].FEED_NAME);
          //$('#UpdateKeyword').modal('show');
          $(".loader").hide();
          alert('Some Error occur');
          } 
          }
          
        }
    });
  });
</script>