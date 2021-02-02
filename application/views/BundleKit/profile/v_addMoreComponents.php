<?php $this->load->view('template/header');?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Add More Components
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
<!-- Small boxes (Stat box) -->
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-sm-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Item Search Form</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
		<?php if($this->session->flashdata('warning')){  ?>
          <div class="alert alert-warning">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
              <strong>Warning:</strong> <?php echo $this->session->flashdata('warning'); ?>
          </div>
      	<?php } ?>
<?php 
/*  © 2008-2013 eBay Inc., All Rights Reserved */
/* Licensed under CDDL 1.0 -  http://opensource.org/licenses/cddl1.php */
   require_once('/../../API/get-common/Productionkeys.php') ?>
<?php require_once('/../../API/get-common/eBaySession.php') ?>
<!-- =================================
*	FOR SHOWING PREVIOUS DATA ONLY
================================== -->
	<div class="col-sm-12">
	    <div class="col-sm-3">
	      <div class="form-group">
	        <label for="query">Search Keyword:</label>
	        <?php //echo $query; ?>
	        <input class="form-control" type="text" id="query" name="query" value="<?php echo $query; ?>" > 
	        <a class="crsr-pntr" title="Click here for category suggestion" id="Suggest_Categories_for_keyword">Suggest Category Against Title</a>    
	      </div>
	    </div>

		<div class="form-group col-sm-3">
			<label for="item_upc">UPC:</label>
			<input class="form-control" type="number" id="item_upc" name="item_upc" value="<?php echo $item_upc; ?>" >
		</div>
		<div class="form-group col-sm-2">
			<label for="item_mpn">MPN:</label>
			<input class="form-control" type="text" id="item_mpn" name="item_mpn" value="<?php echo $item_mpn; ?>">
		</div>
	</div>
	<div class="col-sm-12">
		<div class="form-group col-sm-2">
			<label for="categoryId">Category Id</label>
			<input class="form-control" type="text" id="categoryId" name="categoryId" value="<?php if(isset($_POST['categoryId'])){ echo $_POST['categoryId']; }; ?>">
		</div>
		<div class="form-group col-sm-2">
			<label for="main_category">Main Category</label>
			<input class="form-control" type="text" id="main_category" name="main_category" value="<?php if(isset($_POST['main_category'])){ echo $_POST['main_category']; }; ?>">
		</div>
		<div class="form-group col-sm-2">
			<label for="sub_category">Sub Category</label>
			<input class="form-control" type="text" id="sub_category" name="sub_category" value="<?php if(isset($_POST['sub_category'])){ echo $_POST['sub_category']; }; ?>">
		</div>

		<div class="form-group col-sm-2">
				<label for="category_name">Category Name</label>
				<input class="form-control" type="text" id="category_name" name="category_name" value="<?php if(isset($_POST['category_name'])){ echo $_POST['category_name']; }; ?>">
		</div>
	</div>
	<div class="col-sm-12">
		<div class="form-group col-sm-3">
			<label for="item_template">Template:</label>
			<select name="item_template" class="form-control selectpicker" required="required" data-live-search="true">
			<option value="<?php echo $template_id; ?>"><?php echo $item_template; ?></option>
			      
    	</select>
    	</div>
	</div>
<!-- =================================
*	FOR SHOWING PREVIOUS DATA ONLY
================================== -->
<form action="<?php echo base_url().'BundleKit/c_bkProfiles/search_for_profile/'.$profile_id; ?>" method="post">
		<input type="submit" class="btn btn-success search_category" name="update_profile" value="Submit" style="margin-left: 15px;">
	<?php

				$responseDoc = new DomDocument();
				$responseDoc->loadXML($responseXml);

				
				//get any error nodes
				$errors = $responseDoc->getElementsByTagName('Errors');
				//if there are error nodes
				if($errors->length > 0)
				{
					echo '<P><B>eBay returned the following error(s):</B>';
					//display each error
					//Get error code, ShortMesaage and LongMessage
					$code = $errors->item(0)->getElementsByTagName('ErrorCode');
					$shortMsg = $errors->item(0)->getElementsByTagName('ShortMessage');
					$longMsg = $errors->item(0)->getElementsByTagName('LongMessage');
					//Display code and shortmessage
					echo '<P>', $code->item(0)->nodeValue, ' : ', str_replace(">", "&gt;", str_replace("<", "&lt;", $shortMsg->item(0)->nodeValue));
					//if there is a long message (ie ErrorLevel=1), display it
					if(count($longMsg) > 0)
						echo '<BR>', str_replace(">", "&gt;", str_replace("<", "&lt;", $longMsg->item(0)->nodeValue));
			
				}
				else //no errors
				{
					//get the nodes needed
					$catCount = $responseDoc->getElementsByTagName('CategoryCount');
					$suggestedCategories = $responseDoc->getElementsByTagName('SuggestedCategory');
				
					//display title and number of categories returned
					echo '<P><B>Suggested Categories - ', $catCount->item(0)->nodeValue, '</B>';
					$i=1;
					//go through each suggested category
					//echo "<BR> <div class='col-sm-8'><table class='table table-bordered table-striped' > <th>Sr. No</th><th>Category ID</th><th>Main Category</th><th>Sub Category</th><th>Category Name</th><th>Item(%)</th>";

					echo '<div class="box"> <div class="box-body form-scroll"> <div class="col-md-12"> <!-- Custom Tabs --><table id="notListed" class="table table-bordered table-striped " > <thead> <tr> <th>Check/Uncheck</th><th>Sr. No</th> <th>Category ID</th><th>Main Category</th><th>Sub Category</th><th>Category Name</th><th>Item(%)</th></tr></thead><tbody>';
					foreach($suggestedCategories as $cat)
					{
						//get SuggestedCategory details
						$mainCat = $cat->getElementsByTagName('CategoryParentName');
						//$subCat = $cat->getElementsByTagName('CategoryName');
						//$catName = $cat->getElementsByTagName('CategoryName');
						$catName = $cat->getElementsByTagName('CategoryName');
						$catId = $cat->getElementsByTagName('CategoryID');
						$percentItems = $cat->getElementsByTagName('PercentItemFound');
						//display suggested category
						//echo '<BR>', $catName->item(0)->nodeValue, ' (', $catId->item(0)->nodeValue, ') - ', $percentItems->item(0)->nodeValue, '% of items';
						
						echo "<tr><td><input style='margin-right: 3px;' class='pull-left' type='checkbox' name='cat_list[]' value='".@$catId->item(0)->nodeValue."'><input type='text' name='item_query' value='".@$query."'><input type='hidden' name='item_upc' value='".@$item_upc."'><input type='hidden' name='item_mpn' value='".@$item_mpn."'><input type='hidden' name='bk_template' value='".@$template_id."'></td><td style='width: 70px;'>".@$i."</td><td>".@$catId->item(0)->nodeValue."</td><td>".@$catName->item(0)->nodeValue."</td><td>".@$mainCat->item(0)->nodeValue."</td><td>".@$mainCat->item(1)->nodeValue."</td><td>".@$percentItems->item(0)->nodeValue."</td></tr>";
						$i++;
					}
					echo '</tbody></table></div><!-- /.col --></div><!-- /.box-body --></div><!-- /.box -->';
					echo '<div class="col-sm-2" style="margin-top: 23px;">
		        <div class="form-group">'; ?>
		            <input type="submit" class="btn btn-success search_category" name="update_profile" value="Submit">
		        </div>
		      </div>
		      <?php
					 }
				?>
			</form>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>  
<?php $this->load->view('template/footer');?>
