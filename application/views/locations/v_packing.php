<?php $this->load->view('template/header'); 
      
?>
<style type="text/css">
  .m-3{
    margin: 3px;
  } 
  .show-flag{
    border: 2px solid red;
    padding: 1px;
  }
 
 label.btn span {
  font-size: 1.5em ;
}

label input[type="radio"] ~ i.fa.fa-circle-o{
    color: #c8c8c8;    display: inline;
}
label input[type="radio"] ~ i.fa.fa-dot-circle-o{
    display: none;
}
label input[type="radio"]:checked ~ i.fa.fa-circle-o{
    display: none;
}
label input[type="radio"]:checked ~ i.fa.fa-dot-circle-o{
    color: #7AA3CC;    display: inline;
}
label:hover input[type="radio"] ~ i.fa {
color: #7AA3CC;
}

label input[type="checkbox"] ~ i.fa.fa-square-o{
    color: #c8c8c8;    display: inline;
}
label input[type="checkbox"] ~ i.fa.fa-check-square-o{
    display: none;
}
label input[type="checkbox"]:checked ~ i.fa.fa-square-o{
    display: none;
}
label input[type="checkbox"]:checked ~ i.fa.fa-check-square-o{
    color: #7AA3CC;    display: inline;
}
label:hover input[type="checkbox"] ~ i.fa {
color: #7AA3CC;
}

div[data-toggle="buttons"] label.active{
    color: #7AA3CC;
}

div[data-toggle="buttons"] label {
display: inline-block;
padding: 6px 12px;
margin-bottom: 0;
font-size: 14px;
font-weight: normal;
line-height: 2em;
text-align: left;
white-space: nowrap;
vertical-align: top;
cursor: pointer;
background-color: none;
border: 0px solid #c8c8c8;
border-radius: 3px;
color: #c8c8c8;
-webkit-user-select: none;
-moz-user-select: none;
-ms-user-select: none;
-o-user-select: none;
user-select: none;
}

div[data-toggle="buttons"] label:hover {
color: #7AA3CC;
}

div[data-toggle="buttons"] label:active, div[data-toggle="buttons"] label.active {
-webkit-box-shadow: none;
box-shadow: none;
}
#contentSec{
  display: none;
}
#objectSection{
  display: none;
} 

</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Packing Entry Form
        <small>Control panel</small>
       </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Packing Entry Form</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content"> 
      <div class="row">
        <div class="col-sm-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Packing Entry Form</h3>
            </div>
              <!-- /.box-header -->

       <div class="box-body">

                <?php if($this->session->flashdata('packing_success')){ ?>
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Success!</strong> <?php echo $this->session->flashdata('packing_success'); ?>
                </div>
                <?php }else if($this->session->flashdata('packing_error')){ ?>
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Error!</strong> <?php echo $this->session->flashdata('packing_error'); ?>
                </div>
                <?php }else if($this->session->flashdata('packing_info')){ ?>
                    <div class="alert alert-info">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Error!</strong><?php echo $this->session->flashdata('packing_info'); ?>
                </div>
                <?php } ?>  
 
             <div class="col-sm-10">
              
            </div>
          <div class="row">
           <form method="post" action=<?php echo base_url(); ?>locations/c_locations/SavePacking >
          
          <div class="col-sm-12">
              
          <div class="col-sm-3">
              <div class="form-group">
                <label for="Packing Name" class="control-label">Packing Name:</label>
                  <input type="text" class="form-control" id="packing_name" name="packing_name" value=''">
              </div>
          </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="Packing Length" class="control-label">Length:</label>
                  <input type="number"  step="0.01" min="0" class="form-control" id="packing_length" name="packing_length" value=''">
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="Packing Width" class="control-label">Width:</label>
                  <input type="number" step="0.01" min="0" class="form-control" id="packing_width" name="packing_width" value=''">
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="Packing Heigth" class="control-label">Height:</label>
                  <input type="number" step="0.01" min="0" class="form-control" id="packing_heigth" name="packing_heigth" value=''">
              </div>
            </div>
          </div>
          <div class="col-sm-12">
            <div class="col-sm-4">
                <div class="form-group p-t-24">
                    <label for="Packing Type" class="cotrol-label">Packing Type:</label>
                   <div class="btn-group btn-group-horizontal " data-toggle="buttons">
                   <label class="btn active">                                         
                      <input type="radio" name='packing_type' id='packing_type' value="Box" checked><i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i> <span>Box</span>
                    </label>
                    <label class="btn ">
                      <input type="radio" name='packing_type' id='packing_type' value="Envelope"><i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i> <span>Envelope</span>
                    </label>
                     <label class="btn ">
                      <input type="radio" name='packing_type' id='packing_type' value="Flat" <?php if($this->session->userdata('radiobutton') == 2) { echo 'checked="checked"';} ?> ><i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i> <span>Flat</span>
                    </label>
                     <label class="btn ">
                      <input type="radio" name='packing_type' id='packing_type' value="None"><i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i> <span>None</span>
                    </label>
                  </div>
                
                  <!-- <input type="radio" id="packing_type" name="packing_type" value="Box" checked>&nbsp;Box&nbsp;&nbsp;
                  <input type="radio" id="packing_type" name="packing_type" value="Envelope">&nbsp;Envelope&nbsp;&nbsp;
                  <input type="radio" id="packing_type" name="packing_type" value="Flat">&nbsp;Flat&nbsp;&nbsp;
                  <input type="radio" id="packing_type" name="packing_type" value="None" >&nbsp;None -->
                </div>
              </div>

            <div class="col-sm-3">
              <div class="form-group">
                <label for="Packing Weigth" class="control-label">Packing Weigth:</label>
                  <input type="number" step="0.01" min="0" class="form-control" id="packing_weigth" name="packing_weigth" placeholder="Type Weight in Oz"> 
              </div>
            </div>

            <div class="col-sm-3">
              <div class="form-group">
                <label for="Packing cost" class="control-label">Packing Cost:</label>
                  <input type="number" step="0.01" min="0" class="form-control" id="packing_cost" name="packing_cost" placeholder="Type Cost in $"> 
              </div>
            </div>
            <div class="col-sm-2 p-t-24">
                  <div class="form-group">
                    <input type="submit" title="Save Packing" name="Save" value="Save" class="btn btn-success">
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
          <div class="box-header with-border">
              
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>

            <div class="box-body form-scroll">
              <div class="col-sm-12">

                <table id="packing_table" class="table table-responsive table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Actions</th>
                      <th>Packing Name</th>
                      <th>Length</th>
                      <th>Width</th>
                      <th>Height</th>
                      <th>Packing Type</th>
                      <th>Weight</th>
                      <th>COST</th>
                    </tr>
                  </thead>
                  <tbody>
                  <tr>
                      <?php  
                      //var_dump($data);
                      //exit;
                        foreach($data as $row) :?>
                     <td>
                      <div style="float:left;margin-right:8px;">
                              <button title="Delete Packing" id="<?php echo $row['PACKING_ID']; ?>" class="btn btn-danger btn-xs del_comp"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                              </button>                            
                            </div>
                      </td> 
                      <td ><?php echo @$row['PACKING_NAME'];?></td>
                      <td ><?php echo @$row['PACKING_LENGTH'];?></td>
                      <td ><?php echo @$row['PACKING_WIDTH'];?></td>
                      <td ><?php echo @$row['PACKING_HEIGTH'];?></td>
                      <td ><?php echo @$row['PACKING_TYPE'];?></td>
                      <td ><?php echo @$row['PACKING_WEIGTH'];?></td>
                      <td ><?php echo @$row['PACKING_COST'];?></td>
                     
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

<?php $this->load->view("template/footer.php"); ?>
<script>
  $(document).ready(function()
  {
     $('#packing_table').DataTable({
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
// var table=$('#packing_table').DataTable();
//  $(document).on( 'click', '.del_comp', function () {
//     table.row( $(this).parents('tr') ).remove().draw();
// } );




  $(document).on('click', '.del_comp', function(){
  var packing_id = $(this).attr("id");
  //console.log(packing_id);
  //return false;
  //alert(lz_estimate_det_id);return false;
  var x = confirm("Are you sure you want to delete?");
  if(x){
    $(".loader").show();
    $.ajax({
      url:'<?php echo base_url(); ?>locations/c_locations/deletePacking',
      type:'post',
      dataType:'json',
      data:{'packing_id':packing_id},
      success:function(data){

         if(data == 1){
          var table=$('#packing_table').DataTable();
          table.row( $("#"+packing_id).parents('tr') ).remove().draw();
         }else if(data == 2){
          alert("Error! Packing is not deleted");
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
</script>