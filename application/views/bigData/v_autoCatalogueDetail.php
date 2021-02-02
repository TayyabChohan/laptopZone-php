<?php 
ini_set('memory_limit', '-1');
$this->load->view('template/header');
 ?>

<style>
  #part_kits{display:none;}
  .part_kits{display:none;}
  #alter_mpn{display:none;}
/*    .example-modal .modal {
      position: absolute !important;
      top: auto;
      bottom: auto;
      right: auto;
      left: auto;
      display: block;
      z-index: 1;
    }

    .example-modal .modal {
      background: transparent !important;
    }*/
    #modal_form{display: none;}  
 
</style>   
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Catalogue Detail
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Catalogue Detail</li>
      </ol>
    </section>
        
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
        <!-- Title filtering section start -->
          <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Add Catalogue Detail</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                  </button>
                </div>
              </div>

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
                <?php } ?>                     
                <div class="col-sm-12">
                  <?php //var_dump($detail);exit;?> 
                  <?php $mpn = $this->uri->segment(4);?>
                  <?php $category_id = $this->uri->segment(5);?>
                  <table id="SpecificTable" class="table table-responsive table-striped table-bordered table-hover" > 
                      <thead>
                        <tr>
                          <th>SPECIFIC</th>
                          <th>WORD</th>
                          <th>COUNT</th>
                          <th>%</th>
                          <th></th>
                          
                        </tr> 
                      </thead>

                     <tbody>
                      <?php $i = 0;?>
                      <?php foreach($detail as $det){?>

                        <tr>
                           <td>
                              <?php echo @$det['SPECIFIC_NAME'];?>
                              <input type="hidden" class="validValue" id="mtId_<?php echo $i;?>" value="<?php echo @$det['MT_ID'];?>_<?php echo @$det['MAX_VALUE'];?>">
                           </td>
                           <td><?php echo @$det['SPECIFIC_VALUE'];?>
                             <input type="hidden" name="det_id"  value="<?php echo @$det['DET_ID']?>" id="det_id_<?php echo $i;?>" class="DET">
                           </td>
                           <td><?php echo @$det['COUNT(1)'];?></td>
                           <td></td>
                           <td>
                             <input type="checkbox" name="checkboxes" id="checkbox_<?php echo $i;?>" class="checkboxes" class="Check">
                           </td>
                        </tr>
                        <?php $i++;?>
                      <?php  }?>
                     </tbody>

                  </table>
                </div>
                <div class="col-sm-12">
                  <div class="col-sm-6">
                    <div class="form-group p-t-24">
                          <button type="button" class="btn btn-primary btn-sm" name="makeCatalogue" title="MakeCatalogue" id="Make" >Make Catalogue</button>
                    </div>
                    
                  </div>
                  <div class="col-sm-6 ">
                    <div class="form-group pull-right p-t-24">
                          <!-- <button type="button" class="btn btn-primary btn-sm" name="showCatalogue" title="ShowCatalogue" id="Show" >Show Catalogue</button> -->
                    </div>
                  </div>
                </div>
          </div>
        </div>
      </div>
    </section>
  </div>

<?php $this->load->view('template/footer'); ?>

<script text="javascript">

$(document).ready(function(){

  $('#SpecificTable').DataTable({
    "oLanguage": {
    "sInfo": "Total Records: _TOTAL_"
  },
  "iDisplayLength": 500,
  "aLengthMenu": [[25, 50, 100, 200,500, -1], [25, 50, 100, 200,500, "All"]],
    "paging": true,
    "lengthChange": true,
    "searching": true,
    // "ordering": true,
    // "order": [[ 16, "ASC" ]],
    "info": true,
    "autoWidth": true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
  });

});

$('.checkboxes').on('change',function(){
  var id = this.id.match(/\d+/);
  var checkbox = $('#checkbox_'+id+'').prop('checked');
  var spec_name = $('#mtId_'+id+'').val();

  var ret = spec_name.split("_");
  var str1 = ret[0];
  // alert(str1);
  var str2 = ret[1];
  // alert(str2);return false;

  var spec_name2 = '';
  var id2 = '';
  if(checkbox == true){
    $('.validValue').each(function(){   //.prop('disabled',false);
       id2 = this.id.match(/\d+/);
       spec_name2 = $('#mtId_'+id2+'').val();
       var ret = spec_name2.split("_");
       var str1 = ret[0];
       // alert(str1);
       var str2 = ret[1];
    
      if(spec_name == spec_name2 && str2 == 1){
        $('#checkbox_'+id2+'').prop('disabled',true);
      }
      $('#checkbox_'+id+'').prop('disabled',false);
    

    });
   }else{
       $('.validValue').each(function(){   //.prop('disabled',false);
       id2 = this.id.match(/\d+/);
       spec_name2 = $('#mtId_'+id2+'').val();
       var ret = spec_name2.split("_");
       var str1 = ret[0];
       // alert(str1);
       var str2 = ret[1];
    
      if(spec_name == spec_name2){
        $('#checkbox_'+id2+'').prop('disabled',false);
      }
      // $('#checkbox_'+id+'').prop('disabled',false);
    

    });
   }
  


});

$('#Make').on('click',function(){

 var $check = [];
 var det_ids = [];
 var num_checked = $(":checkbox:checked").length;
 
 var cat_id = '<?php echo $category_id;?>';
 var  mpn= '<?php echo $mpn;?>';
 // alert(cat_id);return false;
var i =0;
 $('.checkboxes').each(function(){
    var checkbox = $('#checkbox_'+i+'').prop('checked');

    if(checkbox == true){
      det_ids.push($('#det_id_'+i+'').val());
        // alert(i);
        // alert($('#det_id_'+i+'').val());return false;
    }
    i++;
 });

 // alert(det_ids);return false;
// $(".loader").show();
  $.ajax({
     url: '<?php echo base_url() ?>bigData/c_autoCatalog/makeCatalogueDetail/', //maintains the (controller/function/argument) logic in the MVC pattern
        type: 'post',
        dataType: 'json',
        data : {'det_ids':det_ids,'mpn':mpn,'cat_id':cat_id},
        success: function(data){
            if(data == 1){
              alert('Data is inserted!');
            }else{
              alert('Master Catalogue Does Not Exist');
            }
        }
 //        error: function(data){
 //           alert('inserted');
 //        }
        // complete: function(data){
        //  $(".loader").hide();
        // } 
 });

});

 
</script>