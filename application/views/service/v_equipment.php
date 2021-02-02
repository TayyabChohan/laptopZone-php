<?php $this->load->view("template/header.php"); ?>


   <!-- Content Wrapper. Contains page content -->
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Equipment
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Equipment Form</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-sm-12">
        <?php if($this->session->flashdata('success')){ ?>
          <div id="successMessage" class="alert alert-success alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php }elseif($this->session->flashdata('error')){  ?>

        <div id="errorMessage" class="alert alert-danger alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
        </div>

    
    <?php }elseif($this->session->flashdata('warning')){  ?>

        <div id="errorMessage" class="alert alert-warning alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Error!</strong> <?php echo $this->session->flashdata('warning'); ?>
        </div>

    <?php } ?>     
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Equipment</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div> 
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
               <!-- <?php// if(@$data == "inserted"){
                //var_dump($data);
                  /*echo '<div class="col-sm-12"><div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Record inserted successfully. </div></div>'; 
                  } */?> -->
                <form action="<?php echo base_url(); ?>service/c_serviceForm/addEquipment" method="post">
	                <div class="col-sm-12">
	                  <div class="col-sm-4">
		                <div class="form-group">
		                  <label for="equip_name" class="control-label">Equipment Name:</label>
		                   <input type="text" class="form-control" id="equip_name" name="equip_name" value="" required>
		                </div>
	                  </div>
	                  <div class="col-sm-1" style="padding-top: 22px;">
	                  	<input type="submit" name="equip_save" id="equip_save" class="btn  btn-success" value="Save">
	                  	<!-- <button type="submit" class="btn btn-success">Save</button> -->
	                  </div>

	                <div class="col-sm-2 ">
	                  <div class="form-group">
	                   
	                     
	                  </div>
	                </div>
	               </div>
	            </form>
	           </div> 
	        </div>  
	      </div>
	    </div>
	   </div>
	  </section>
	 </div>


<?php $this->load->view("template/footer.php"); ?>
<!-- <script type="text/javascript">
// check equip_name
/*---Toggle Account--*/
$("#equip_name").blur(function(){
  var equip_name = $("#equip_name").val();
  
      $.ajax({
      	dataType: 'json',
        type: 'POST',
        url:'<?php //echo base_url(); ?>pos/c_point_of_sale/checkEquipment',
        data: { 'equip_name' : equip_name},
       success: function (data) {
         if(data){ 
              alert('Error-Equipment already exist.');
              return false;
         }
       }
      }); 
 });	
</script> -->