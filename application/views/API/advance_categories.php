<?php $this->load->view('template/header');?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Advance Categories Search  
    <small>Form</small>
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
          <h3 class="box-title">Advance Categories Search Form</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

<?php 
/*  © 2008-2013 eBay Inc., All Rights Reserved */
/* Licensed under CDDL 1.0 -  http://opensource.org/licenses/cddl1.php */
   require_once('get-common/Productionkeys.php') ?>
<?php require_once('get-common/eBaySession.php') ?>

<div class="col-sm-12">
	<form action="<?php echo base_url();?>dashboard/dashboard/advance_categories" method="post">
		<div class="col-sm-6">
			<div class="form-group">
				<label for="">Query:</label>
				<input class="form-control" type="text" name="Query"><br>
				<input class="btn btn-primary" type="submit" name="submit">
			</div>
		</div>



	</form>
</div> 

<?php
	if(isset($_POST['Query']))
	{
		//Get the query inputted
		$query = $_POST['Query'];
	
	
		//SiteID must also be set in the Request's XML
		//SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
		//SiteID Indicates the eBay site to associate the call with
		$siteID = 0;
		//the call being made:
		$verb = 'GetSuggestedCategories';
		
		///Build the request Xml string
		$requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
		$requestXmlBody .= '<GetSuggestedCategoriesRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
		$requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
		$requestXmlBody .= "<Query>$query</Query>";
		$requestXmlBody .= '</GetSuggestedCategoriesRequest>';
        
        //Create a new eBay session with all details pulled in from included keys.php
        $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
		
		//send the request and get response
		$responseXml = $session->sendHttpRequest($requestXmlBody);
		if(stristr($responseXml, 'HTTP 404') || $responseXml == '')
			die('<P>Error sending request');
		
$xml = simplexml_load_string($responseXml);
// echo json_encode($xml);
// print_r(json_encode($xml));
// exit;
		
		//Xml string is parsed and creates a DOM Document object
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
			echo "<BR> <div class='col-sm-8'><table class='table table-bordered table-striped' > <th>Sr. No</th><th>Category ID</th><th>Main Category</th><th>Sub Category</th><th>Category Name</th><th>Item(%)</th>";
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
				
				echo "<tr><td>".@$i."</td><td>".@$catId->item(0)->nodeValue."</td><td>".@$catName->item(0)->nodeValue."</td><td>".@$mainCat->item(0)->nodeValue."</td><td>".@$mainCat->item(1)->nodeValue."</td><td>".@$percentItems->item(0)->nodeValue."</td></tr>";
				$i++;
			}
			echo "</table></div>";
		}
	}
?>
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
