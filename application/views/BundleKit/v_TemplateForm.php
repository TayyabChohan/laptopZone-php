<?php $this->load->view("template/header.php"); ?>

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Template 
        <small>For Components</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Item Components Form</li>
      </ol>
    </section>

     <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Item Components Form</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

				<form style="background: #fff;" method="post" action="<?php echo base_url().'BundleKit/c_Template/addTemplate'?>" enctype="multipart/form-data">
					
					<div class="col-sm-12">
			          	<!-- <h4 for="inputEmail3" class="col-sm-3 col-form-label pull-left">Input Item</h4>  -->
			          	<!--first Row -->   
			        	<div class="col-sm-12">
			        		<!-- <div class="col-sm-1"></div> -->
			          		<div class="col-sm-6">
			            		<div class="form-group">
			              			<label for="template_name">Template Name</label>
			              			<input type="text" class="form-control" id="template_name" name="template_name">
			            		</div>
			            		
			            	</div>
			            </div>	
			        </div>

			        

			        <!--Second Row --> 
			        <div class="col-sm-12">
			          	<!-- <h4 for="inputEmail3" class="col-sm-3 col-form-label pull-left">Select Component</h4>  -->
			          	<!--first Row -->   
			        	<div class="col-sm-12">
			        		
			          		<div class="col-sm-6">
			            		<div class="form-group">
			              			<label for="">Components</label>
			              			 <?php 
			              			 if($components->num_rows() > 0){
			              			 	/*var_dump($components->result());
			              			 	exit;*/
			              			 	?>

										<label for=""></label>
										<input type="checkbox" name="component[]">

			              			 <select multiple name="component[]" class="dropdown form-control js-example-basic-multiple" id="component" >
			              			 <?php 
			              			 	foreach ($components->result_array() as $component) {
		              			 		?>
		              			 		<option value="<?php echo $component['LZ_COMPONENT_ID'] ?>"><?php echo $component['LZ_COMPONENT_DESC'] ?></option>
			              			 	<?php	
			              			 	}
			              			 
									   ?>   
								    </select>
			              			<?php }
									   ?>
			            		</div>
			            	</div>
			            	
			            </div>	
			        </div>

			        <div class="col-sm-12">
			        	<div class="col-sm-12">
			        		<div class="col-sm-1">
				        		<div class="form-group " >
				        			<button type="submit" class="btn btn-primary">Submit</button>
				        		</div>
			        		</div>
			        	</div>

			        </div>
            		
	  				
				</form>
			</div>
		  </div>
		</div>
	  </div>  	


  </div>


<?php $this->load->view("template/footer.php"); ?>