<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>

 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Catalogue
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Alternate Values</li>
      </ol>
    </section>



    <section class="content">

        <!-- Item Specific Start -->
            <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Alternate Values</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>

                <div class="box-body">

                	 <div class="col-sm-12">
                	 	<div class="col-sm-4">
                  			<div class="form-group">
                  			<?php $i=1;?>
                  				<table class="table table-bordered table-striped table-responsive table-hover">
                  					<tr>
                  						<th>Original Value</th>
                  						<th>Alternate Values</th>
                  					</tr>
                  					<tr>
                  						<td rowspan="<?php echo count($data["alt"]);?>">
                  							 
                  							<?php echo $data["original"][0]["SPECIFIC_VALUE"];?>
                  							
                  						</td>
                  						<td>
                  							<?php foreach($data["alt"] as $alt_value){

				                  					echo $alt_value['SPEC_ALT_VALUE'];
				                  					$i++;
			                  					}	
			                  				?>
                  						</td>
                  					</tr>

                  				</table>
                  				
                  			</div>
                  		</div>
                	 </div>
                </div>
            </div>

    </section>
                  
  </div>

<?php $this->load->view('template/footer'); ?>