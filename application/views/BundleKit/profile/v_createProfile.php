<?php $this->load->view('template/header');?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"><!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
   Create Profile
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Bundle & Kit </li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-sm-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Bundle & Kit </h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
		    <?php if($this->session->flashdata('warning'))
				  {
        ?>
          <div class="alert alert-warning">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
              <strong>Warning:</strong> <?php echo $this->session->flashdata('warning'); ?>
          </div>
  			<?php
      		 	} 
				/*  © 2008-2013 eBay Inc., All Rights Reserved */
				/* Licensed under CDDL 1.0 -  http://opensource.org/licenses/cddl1.php */
				   require_once('/../../API/get-common/Productionkeys.php');
				   require_once('/../../API/get-common/eBaySession.php');
    			?>
    				<form action="<?php echo base_url(); ?>BundleKit/c_bkProfiles/searchCatsForProfile" method="post">
    					<div class="col-sm-12">
    					    <div class="col-sm-3">
    					      <div class="form-group">
    					        <label for="item_name">Search Keyword:</label>
    					        <input class="form-control" type="text" name="item_name" id="item_name" value="<?php if(isset($_POST['item_name'])){ echo $_POST['item_name']; }; ?>" required="required"> 
    					        <a class="crsr-pntr" title="Click here for category suggestion" id="Suggest_Categories_for_keyword">Suggest Category Against Title</a>    
    					      </div>
    					    </div>
    						<div class="form-group col-sm-3">
    							<label for="item_upc">UPC:</label>
    							<input class="form-control" type="number" id="item_upc" name="item_upc" value="<?php if(isset($_POST['item_upc'])){ echo $_POST['item_upc']; }; ?>" >
    						</div>
    						<div class="form-group col-sm-2">
    							<label for="item_mpn">MPN:</label>
    							<input class="form-control" type="text" id="item_mpn" name="item_mpn" value="<?php if(isset($_POST['item_mpn'])){ echo $_POST['item_mpn']; }; ?>">
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
    								<option value="">---</option>
    								<?php                                
    					           if(isset($_POST['item_template'])){
    					           	foreach ($templates as $cat) {
    					           	$bkTempId=$cat['LZ_BK_ITEM_TYPE_ID'];
    					           	 if(isset($_POST['item_template']))
    					           	 	{
    						           	 	if($_POST['item_template']==$cat['LZ_BK_ITEM_TYPE_ID'])
    						           	 	{
    						           	 		$selected="selected";
    						           	 	}else{
    						           	 		$selected="";
    						           	 	}              	 		
    					           	 	}
    					               	?>
    					               	<option value="<?php echo $cat['LZ_BK_ITEM_TYPE_ID']; ?>"  <?php echo $selected; ?> > <?php echo $cat['ITEM_TYPE_DESC']; ?> 
    					               	</option>
    					               	<?php
    					                } 
    					          
    					           }else{
    					           	foreach ($templates as $cat){
    					               	?>
    					               	<option value="<?php echo $cat['LZ_BK_ITEM_TYPE_ID']; ?>" > <?php echo $cat['ITEM_TYPE_DESC']; ?> </option>
    					               	<?php
    					                } 
    					           	}
    					             ?>  
    					                            
    					    	</select>
    					    </div>
    					</div>
    					<div class="col-sm-12">
    						<?php if(isset($_POST['item_name'])){ ?>
    								<div class="form-group col-sm-2" style="display: none;">
    								<input class="btn btn-primary" type="submit" name="submit_query" id="submit_query">
    								</div>
    						<?php }else{ ?> 
    								<div class="form-group col-sm-2">
    								<input class="btn btn-primary" type="submit" name="submit_query" id="submit_query">
    								</div>
    							<?php }; ?>
    						
    					</div>
    			 </form>
      			<div class="col-sm-12">
      			    <!-- Category Result -->
      			      <div id="Categories_data">
      			      </div>            
      			    <!-- Category Result -->  
      			</div>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
</div>  
<?php $this->load->view('template/footer');?>
<script>
	/*-- Suggest Categories against title on single entry--*/
   $("#Suggest_Categories_for_keyword").click(function(){
 
      var UPC  = null;
      var MPN  = null;
      var TITLE  = $("#item_name").val();
      //alert(TITLE); return false;
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
              $('<tr>').html("<td>" + 1 + "</td><td>"+ CategoryID +"</td><td>" + CategoryParentName1 + "</td><td>" + '' + "</td><td>" + CategoryName + "</td><td>" + PercentItemFound + "</td><td><a class='crsr-pntr' id='cat_"+i+"' onclick='bk_Function("+1+");'> Select </a></td></tr></table></div></div>").appendTo('#category_table');
            }else{
              var CategoryParentName1=item['Category']['CategoryParentName'][0];//manin category
              var CategoryParentName2=item['Category']['CategoryParentName'][1];// sub category
              var CategoryID = item['Category']['CategoryID'];
              var CategoryName=item['Category']['CategoryName'];
              var PercentItemFound = item['PercentItemFound'];
              $('<tr>').html("<td>" + 1 + "</td><td>"+ CategoryID +"</td><td>" + CategoryParentName1 + "</td><td>" + CategoryParentName2 + "</td><td>" + CategoryName + "</td><td>" + PercentItemFound + "</td><td><a class='crsr-pntr' id='cat_"+i+"' onclick='bk_Function("+1+");'> Select </a></td></tr></table></div></div>").appendTo('#category_table');
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
                  $('<tr>').html("<td>" + i + "</td><td>"+ CategoryID +"</td><td>" + CategoryParentName1 + "</td><td>" + '' + "</td><td>" + CategoryName + "</td><td>" + PercentItemFound + "</td><td><a class='crsr-pntr' id='cat_"+i+"' onclick='bk_Function("+i+");'> Select </a></td></tr></table></div></div>").appendTo('#category_table');
                }else{
                  var CategoryParentName1=item['Category']['CategoryParentName'][0];//manin category
                  var CategoryParentName2=item['Category']['CategoryParentName'][1];// sub category
                  var CategoryID = item['Category']['CategoryID'];
                  var CategoryName=item['Category']['CategoryName'];
                  var PercentItemFound = item['PercentItemFound'];
                  $('<tr>').html("<td>" + i + "</td><td>"+ CategoryID +"</td><td>" + CategoryParentName1 + "</td><td>" + CategoryParentName2 + "</td><td>" + CategoryName + "</td><td>" + PercentItemFound + "</td><td><a class='crsr-pntr' id='cat_"+i+"' onclick='bk_Function("+i+");'> Select </a></td></tr></table></div></div>").appendTo('#category_table');
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

function bk_Function(i)
	{
    var index = i;
    var t = document.getElementById('category_table');
    var cat_id = $(t.rows[index].cells[1]).text();
    var main_cat = $(t.rows[index].cells[2]).text();
    var sub_cat = $(t.rows[index].cells[3]).text();
    var cat_name = $(t.rows[index].cells[4]).text();
    document.getElementById("categoryId").value=cat_id;
    document.getElementById("category_name").value=cat_name;
    document.getElementById("main_category").value=main_cat;
    document.getElementById("sub_category").value=sub_cat;
	}
 $('#searchCats').DataTable({
    "oLanguage": {
    "sInfo": "Total Records: _TOTAL_"
  },
  "iDisplayLength": 50,
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    // "order": [[ 16, "ASC" ]],
    "info": true,
    "autoWidth": true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
  });
</script>
