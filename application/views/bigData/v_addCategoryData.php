<?php $this->load->view('template/header');?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
   Add Category Data
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Add Category Data </li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-sm-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Add Category Data</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
					<?php if($this->session->flashdata('success')){ ?>
            <div id="successMsg" class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Success! </strong> <?php echo $this->session->flashdata('success'); ?>
            </div>
          <?php }else if($this->session->flashdata('error')){  ?>
            <div id="errorMsg" class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Error! </strong> <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php }else if($this->session->flashdata('warning')){  ?>
            <div id="warningMsg" class="alert alert-warning">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Warning! </strong> <?php echo $this->session->flashdata('warning'); ?>
            </div>
        <?php } ?>
			<?php 
			/*  © 2008-2013 eBay Inc., All Rights Reserved */
			/* Licensed under CDDL 1.0 -  http://opensource.org/licenses/cddl1.php */
   		// require_once('/../../API/get-common/Productionkeys.php'); 
     //  require_once('/../../API/get-common/eBaySession.php');
       ?>
			<div class="col-sm-12">
				<form action="<?php echo base_url();?>bigData/c_bigData/saveCategoryData" method="post">
				    <div class="col-sm-3">
		          <div class="form-group">
		            <label for="webhook_name">Search Category:</label>
		            <input class="form-control" type="text" name="keyword" id="keyword" value="" placeholder="Enter Keword" required="required"> 
		            <a class="crsr-pntr" title="Click here for category suggestion"  id="Suggest_Categories_for_webhook">Suggest Category Against Keyword
		            </a>    
		          </div>
		        </div>
				</div>
				<div class="col-sm-12">
          <div class="col-sm-2">
  					<div class="form-group">
  						<label for="categoryId">Category Id</label>
  						<input class="form-control" type="text" id="categoryId" name="categoryId" value="<?php if(isset($_POST['categoryId'])){ echo $_POST['categoryId']; }; ?>">
  					</div>
          </div>
          <div class="col-sm-2">
  					<div class="form-group">
  						<label for="main_category">Main Category</label>
  						<input class="form-control" type="text" id="main_category" name="main_category" value="<?php if(isset($_POST['main_category'])){ echo $_POST['main_category']; }; ?>">
  					</div>
          </div>
          <div class="col-sm-2">          
  					<div class="form-group">
  						<label for="sub_category">Sub Category</label>
  						<input class="form-control" type="text" id="sub_category" name="sub_category" value="<?php if(isset($_POST['sub_category'])){ echo $_POST['sub_category']; }; ?>">
  					</div>
          </div>
          <div class="col-sm-2">
  					<div class="form-group">
  							<label for="category_name">Category Name</label>
  							<input class="form-control" type="text" id="category_name" name="category_name" value="<?php if(isset($_POST['category_name'])){ echo $_POST['category_name']; }; ?>">
  					</div>
          </div>
          <div class="col-sm-2">
            <div class="form-group">
              <label for="Conditions" class="control-label">Conditions:</label>
              <select class="form-control" id="condition" name="condition" required>
                <option value="0" selected="selected">All</option>
                <option value="3000">Used</option>
                <option value="1000">New</option>
                <option value="1500">New Other</option>
                <option value="2000">Manufacturer Refurbished</option>
                <option value="2500">Seller Refurbished</option>
                <option value="7000">For Parts or Not Working</option>
              </select>  
            </div>
          </div>
          <div class="col-sm-2">
  					<div class="form-group">
  						<label for="Seller Id">Seller ID:</label>
  						<input class="form-control" type="text" id="seller_id" name="seller_id" value="">
  					</div>
          </div>
          <div class="col-sm-2">
            <div class="form-group">
              <label for="Global ID" class="control-label">Global ID:</label>
              <select class="form-control" id="global_id" name="global_id" required>
                <option value="US">United States</option>
                <option value="ENCA">Canada (English)</option>
                <option value="GB">UK</option>
                <option value="AU">Australia</option>
                <option value="AT">Austria</option>
                <option value="FRBE">Belgium (French)</option>
                <option value="FR">France</option>
                <option value="DE">Germany</option>
                <option value="IT">Italy</option>
                <option value="NLBE">Belgium (Dutch)</option>
                <option value="NL">Netherlands</option>
                <option value="ES">Spain</option>
                <option value="CH">Switzerland</option>
                <option value="HK">Hong Kong</option>
                <option value="IN">INDIA</option>
                <option value="IE">Ireland</option>
                <option value="MY">Malaysia</option>
                <option value="FRCA">Canada (French)</option>
                <option value="PH">Philippones</option>
                <option value="PL">Poland</option>
                <option value="SG">Singapore</option>
              </select>  
            </div>
          </div>
          <div class="col-sm-2">
            <div class="form-group">
              <label for="Listing Filter" class="control-label">Listing Filter:</label>
              <select class="form-control" name="listing_filter" id="listing_filter">
                <option value="active">Active</option>
                <option value="sold">Sold</option>
              </select>
            </div>
          </div>
          <div class="col-sm-2">
            <div class="form-group">
              <label for="Listing Type" class="control-label">Listing Type:</label>
              <select class="form-control" name="listing_type[]" id="listing_type" multiple>
                <option value="Auction">Auction</option>
                <option value="AuctionWithBIN">Buy It Now</option>
                <option value="Classified">Classified</option>
                <option value="FixedPrice">FixedPrice</option>
                <option value="All" selected>All</option>
              </select>
            </div>
          </div>          

				</div>
				<div style="margin-top: 8px;" class="col-sm-12">
          <div class="col-sm-2">
            <div class="form-group">
              <input class="btn btn-success btn-sm" type="submit" name="save_btn" id="save_btn" value="Save">
               <a style="margin-left: 5px;" class="btn btn-primary btn-sm" title="Go Back" href="<?php echo base_url(); ?>bigData/c_bigData/">Back</a>
            </div>                
          </div>         
				</div>

        </form> 
				<div class="col-sm-12">
				    <!-- Category Result -->
				      <div id="Categories_data">
				      </div>            
				      <!-- Category Result -->  
				</div>
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
<script>
$(document).ready(function()
  {
  /*-- Suggest Categories against title on single entry--*/
   $("#Suggest_Categories_for_webhook").click(function(){
      var UPC  = null;
      var MPN  = null;
      var TITLE  = $("#keyword").val();
      $.ajax({
      type: 'POST',
      dataType: 'json',
      url:'<?php echo base_url(); ?>listing/listing/Suggest_Categories/',
      data:{ 
            'UPC' : UPC,
            'MPN' : MPN,
            'TITLE' : TITLE
            },
     success: function (data) {
     
     if(data.Ack='Success' && data.CategoryCount > 0){
       if(data.CategoryCount == 1)//if result is 1 than condition is changed so this check is neccessory
      {
          $( "#Categories_data" ).html("");
          var tr='';

         $( "#Categories_data" ).html( "<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>Suggested Categories</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='100%' class='table table-bordered table-striped' border='1' id='category_table'> <th>Sr. No</th><th>Category ID</th><th>Main Category </th><th>Sub Category</th><th>Category Name</th><th>Item(%)</th><th>Select</th>" );

            var item = data['SuggestedCategoryArray']['SuggestedCategory'];
            var CategoryParentName1=item['Category']['CategoryParentName'][0].length;//[0];//manin category
            if(CategoryParentName1 === 1){//check sub category exist or not
              var CategoryParentName1=item['Category']['CategoryParentName'];//[0];//manin category
              var CategoryID = item['Category']['CategoryID'];
              var CategoryName=item['Category']['CategoryName'];
              var PercentItemFound = item['PercentItemFound'];
              $('<tr>').html("<td>" + 1 + "</td><td>"+ CategoryID +"</td><td>" + CategoryParentName1 + "</td><td>" + '' + "</td><td>" + CategoryName + "</td><td>" + PercentItemFound + "</td><td><a class='crsr-pntr web_select' id='cat_"+i+"' onclick='hook_Function("+1+");'> Select </a></td></tr></table></div></div>").appendTo('#category_table');
            }else{
              var CategoryParentName1=item['Category']['CategoryParentName'][0];//manin category
              var CategoryParentName2=item['Category']['CategoryParentName'][1];// sub category
              var CategoryID = item['Category']['CategoryID'];
              var CategoryName=item['Category']['CategoryName'];
              var PercentItemFound = item['PercentItemFound'];
              $('<tr>').html("<td>" + 1 + "</td><td>"+ CategoryID +"</td><td>" + CategoryParentName1 + "</td><td>" + CategoryParentName2 + "</td><td>" + CategoryName + "</td><td>" + PercentItemFound + "</td><td><a class='crsr-pntr web_select' id='cat_"+i+"' onclick='hook_Function("+1+");'> Select </a></td></tr></table></div></div>").appendTo('#category_table');
            }

       }

      if(data.CategoryCount > 1){
                $( "#Categories_data" ).html("");
                     var tr='';
               //var CategoryCount = data['CategoryCount']; 
               $( "#Categories_data" ).html( "<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>Suggested Categories</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='100%' class='table table-bordered table-striped' border='1' id='category_table'> <th>Sr. No</th><th>Category ID</th><th>Main Category </th><th>Sub Category</th><th>Category Name</th><th>Item(%)</th><th>Select</th>" );
              for ( var i = 1; i <= data.CategoryCount; i++ ) 
              {
                
                var item = data['SuggestedCategoryArray']['SuggestedCategory'][i-1];
                var CategoryParentName1=item['Category']['CategoryParentName'][0].length;//manin category
                if(CategoryParentName1 === 1){//check sub category exist or not
                  var CategoryParentName1=item['Category']['CategoryParentName'];//[0];//manin category
                  var CategoryID = item['Category']['CategoryID'];
                  var CategoryName=item['Category']['CategoryName'];
                  var PercentItemFound = item['PercentItemFound'];
                  $('<tr>').html("<td>" + i + "</td><td>"+ CategoryID +"</td><td>" + CategoryParentName1 + "</td><td>" + '' + "</td><td>" + CategoryName + "</td><td>" + PercentItemFound + "</td><td><a class='crsr-pntr web_select' id='cat_"+i+"' onclick='hook_Function("+i+");'> Select </a></td></tr></table></div></div>").appendTo('#category_table');
                }else{
                  var CategoryParentName1=item['Category']['CategoryParentName'][0];//manin category
                  var CategoryParentName2=item['Category']['CategoryParentName'][1];// sub category
                  var CategoryID = item['Category']['CategoryID'];
                  var CategoryName=item['Category']['CategoryName'];
                  var PercentItemFound = item['PercentItemFound'];
                  $('<tr>').html("<td>" + i + "</td><td>"+ CategoryID +"</td><td>" + CategoryParentName1 + "</td><td>" + CategoryParentName2 + "</td><td>" + CategoryName + "</td><td>" + PercentItemFound + "</td><td><a class='crsr-pntr web_select' id='cat_"+i+"' onclick='hook_Function("+i+");'> Select </a></td></tr></table></div></div>").appendTo('#category_table');
                }
              }

              $( "</table></div></div>" ).appendTo( "#Categories_data");
            }
       
     }else{
      //$( "#Categories_data").html("No Record found");
      $("<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>No Record Found.</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div></div></div>").appendTo("#Categories_data");
      }
     }
     }); 
 });
/*-- End Suggest Cotegories against title on single entry --*/ 
 
 });
      /*-- End Suggest Cotegories --*/
         function hook_Function(i) {
            var index = i;
            var t = document.getElementById('category_table');
            var cat_id = $(t.rows[index].cells[1]).text();
            var main_cat = $(t.rows[index].cells[2]).text();
            var sub_cat = $(t.rows[index].cells[3]).text();
            var cat_name = $(t.rows[index].cells[4]).text();
            document.getElementById("categoryId").value = cat_id;
            document.getElementById("main_category").value = main_cat;
            document.getElementById("sub_category").value = sub_cat ;
            document.getElementById("category_name").value = cat_name;   
        }
/*-- End Suggest Cotegories against title on single entry --*/
    /*===== Success message auto hide ====*/
        setTimeout(function() {
          $('#successMsg').fadeOut('slow');
        }, 5000); // <-- time in milliseconds

        setTimeout(function() {
          $('#errorMsg').fadeOut('slow');
        }, 5000); // <-- time in milliseconds 
        setTimeout(function(){
          $('#warningMsg').fadeOut('slow');
        }, 5000);       

    /*===== Success message auto hide ====*/ 
</script>
