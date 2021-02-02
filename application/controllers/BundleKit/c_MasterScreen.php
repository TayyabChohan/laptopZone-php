<?php
class C_MasterScreen extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->database();
		 if(!$this->loginmodel->is_logged_in())
		     {
		       redirect('login/login/');
		     }		
	}
	function index()
	{
		$this->load->view("BundleKit/v_search_master_screen");
		
	}
	function search_category()
	{
				require('/../../views/API/get-common/Productionkeys_imran.php'); 
 				require('/../../views/API/get-common/eBaySession.php');	

				$this->form_validation->set_rules('cat_list[]', 'Category Id', 'required');
				$this->form_validation->set_rules('bk_template', 'Item Template', 'required');
				if($this->form_validation->run()==FALSE)
					{
						redirect(site_url().'BundleKit/c_advanceCategories');
					}else {
				$catId='';
				$catsId=$this->input->post('cat_list');			
				$item_upc=$this->input->post('item_upc');
				$item_mpn=$this->input->post('item_mpn');
				$bk_template=$this->input->post('bk_template');
				$categoryId=$this->input->post('categoryId');			
				$main_category=$this->input->post('main_category');
				$sub_category=$this->input->post('sub_category');
				$category_name=$this->input->post('category_name');
				//var_dump($catsId, $item_upc, $item_mpn, $bk_template);
				//exit;
				
				//var_dump($categoryId, $main_category, $sub_category, $category_name);
				//exit;
				
				$k=0;
				/*
				echo $query;
				exit;
				*/
				//echo "pre";
				//print_r($catId);
				//exit;
				foreach ((array)$catsId as $value) {
					$itemQuery=$this->input->post($value);
					//var_dump($itemQuery);//exit;
					$catId.="&categoryId(0)=".$value;
					$query=trim(preg_replace('/\s+/', '+', $itemQuery));
					$k++;

					$pageNumber=1;
				do{
				$URL ="http://svcs.ebay.com/services/search/FindingService/v1?siteid=0&SECURITY-APPNAME=Muhammad-bundlean-PRD-208fa563f-4079df85&OPERATION-NAME=findItemsAdvanced&GLOBAL-ID=EBAY-US&SERVICE-VERSION=1.0.0&RESPONSE-DATA-FORMAT=XML&keywords=($query)&paginationInput.entriesPerPage=100&paginationInput.pageNumber=".$pageNumber.$catId; 
				
				 $XML = new SimpleXMLElement(file_get_contents($URL));
				 $count=$XML->searchResult['count'];
				 $ack=$XML->ack;
				
				  if($ack=='Failure')
				  {
				  		$this->session->set_flashdata('warning', "Maximum three categories are allowed to select by ebay!");
				  		redirect('BundleKit/c_advanceCategories');
				  }else if($count > 0){
				   $i = 0; 
				   foreach((object)$XML->searchResult->item as $item)
				    {
				          $itmId=$json['item'][$i]['basicInfo']['itemId'] = "$item->itemId";

				          $sellingStatus = $item->sellingStatus;

				          
				          $price ="$sellingStatus->convertedCurrentPrice";

           				
				           if(!empty(@$price))
				           {
				           	$StartPrice=$price;
				           }else {
				           	$StartPrice=NULL;
				           }
				          $siteID = 0;
				          //the call being made:
				          $verb = 'GetItem';
				          ///Build the request Xml string
				          $requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>';
				          $requestXmlBody .= '<GetItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
				          $requestXmlBody .= "<ItemID>$itmId</ItemID>";
				          $requestXmlBody .= "<DetailLevel>ReturnAll</DetailLevel>";
				          $requestXmlBody .= "<RequesterCredentials>";
				          $requestXmlBody .= "<eBayAuthToken>" . $userToken . "</eBayAuthToken>";
				          $requestXmlBody .= "</RequesterCredentials>";

				          $requestXmlBody .= '</GetItemRequest>';
				                
				          //Create a new eBay session with all details pulled in from included keys.php
				          //$session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
				          //build eBay headers using variables passed via constructor
				          $headers = array (
				          //Regulates versioning of the XML interface for the API
				          'X-EBAY-API-COMPATIBILITY-LEVEL: ' . $compatabilityLevel,
				          
				          //set the keys
				          'X-EBAY-API-DEV-NAME: ' . $devID,
				          'X-EBAY-API-APP-NAME: ' . $appID,
				          'X-EBAY-API-CERT-NAME: ' . $certID,
				          
				          //the name of the call we are requesting
				          'X-EBAY-API-CALL-NAME: ' . $verb,     
				          
				          //SiteID must also be set in the Request's XML
				          //SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
				          //SiteID Indicates the eBay site to associate the call with
				          'X-EBAY-API-SITEID: ' . $siteID,
				        );
				          
				          //initialise a CURL session
				          $connection = curl_init();
				          //set the server we are using (could be Sandbox or Production server)
				          curl_setopt($connection, CURLOPT_URL, $serverUrl);
				          
				          //stop CURL from verifying the peer's certificate
				          curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
				          curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
				          
				          //set the headers using the array of headers
				          curl_setopt($connection, CURLOPT_HTTPHEADER, $headers);
				          
				          //set method as POST
				          curl_setopt($connection, CURLOPT_POST, 1);
				          
				          //set the XML body of the request
				          curl_setopt($connection, CURLOPT_POSTFIELDS, $requestXmlBody);
				          
				          //set it to return the transfer as a string from curl_exec
				          curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
				          
				          //Send the Request
				          $response = curl_exec($connection);
				          
				          //close the connection
				          curl_close($connection);

				         $response = simplexml_load_string($response);
				         /*
					         echo "<pre>";
					         print_r($response);
					         echo "</pre>";
					         exit;
				         */

				           if(!empty(@$response->Item->Variations->Variation[$i]->VariationProductListingDetails->UPC))
				           {
				           	$pro_UPC=$response->Item->Variations->Variation[$i]->VariationProductListingDetails->UPC;
				           }else {
				           	$pro_UPC=NULL;
				           }
				           

				           if(!empty(@$response->Item->Quantity))
				           {
				           	$Quantity=$response->Item->Quantity;
				           }else {
				           	$Quantity=NULL;
				           }
				           
				           //$QuantitySold=$response->Item->SellingStatus->QuantitySold;
				           if(!empty(@$response->Item->SellingStatus->QuantitySold))
				           {
				           	$QuantitySold=$response->Item->SellingStatus->QuantitySold;
				           }else {
				           	$QuantitySold=NULL;
				           }
				         
				           if(!empty(@$response->Item->ProductListingDetails->BrandMPN->MPN))
				           {
				           	$pro_MPN=$response->Item->ProductListingDetails->BrandMPN->MPN;
				           	$pro_MPN = trim(str_replace("  ", ' ', $pro_MPN));
        					$pro_MPN = trim(str_replace(array("'"), "''", $pro_MPN));
				           }else {
				           	$pro_MPN=NULL;
				           }

				            if(!empty(@$response->Item->ProductListingDetails->BrandMPN->Brand))
				           {
				           	$Brand=$response->Item->ProductListingDetails->BrandMPN->Brand;
				           	$Brand = trim(str_replace("  ", ' ', $Brand));
        					$Brand = trim(str_replace(array("'"), "''", $Brand));
				           }else {
				           	$Brand=NULL;

				           }

				           if(!empty(@$response->Item->PrimaryCategory->CategoryID))
				           {
				           	$cat_id=$response->Item->PrimaryCategory->CategoryID;
				           }else {
				           	$cat_id=NULL;
				           }
				           
				           //$cat_name=$response->Item->PrimaryCategory->CategoryName;
				           if(!empty(@$response->Item->PrimaryCategory->CategoryName))
				           {
				           	$cat_name=$response->Item->PrimaryCategory->CategoryName;
				           	$cat_name = trim(str_replace("  ", ' ', $cat_name));
        					$cat_name = trim(str_replace(array("'"), "''", $cat_name));
				           }else {
				           	$cat_name=NULL;
				           }
				          
				           //$UserID=$response->Item->Seller->UserID;
				           if(!empty(@$response->Item->Seller->UserID))
				           {
				           	$UserID=$response->Item->Seller->UserID;
				           	$UserID = trim(str_replace("  ", ' ', $UserID));
        					$UserID = trim(str_replace(array("'"), "''", $UserID));
				           }else {
				           	$UserID=NULL;
				           }

				           if(!empty(@$response->Item->Title))
				           {
				           	$itemTitle=$response->Item->Title;
				           	$itemTitle = trim(str_replace("  ", ' ', $itemTitle));
        					$itemTitle = trim(str_replace(array("'"), "''", $itemTitle));
				           }else {
				           	$itemTitle=NULL;
				           }
				           if(!empty(@$response->Item->ItemID))
				           {
				           	$ItemID=$response->Item->ItemID;
				           }else {
				           	$ItemID=NULL;
				           }
				          
				           	// var_dump($itemTitle);
				           	// exit;
						      $qry = $this->db->query("SELECT get_single_primary_key('LZ_BK_TEMP','TEMP_ID') ID FROM DUAL");
					          $rs = $qry->result_array();
					          $LZ_BK_TEMP_ID = $rs[0]['ID'];      
						      $qrey=$this->db->query("INSERT INTO LZ_BK_TEMP (TEMP_ID, EBAY_CAT_NAME, EBAY_CAT_ID, MPN, UPC, QTY_LISTED, QTY_SOLD, LISTED_PRICE, LIST_DATE, ITEM_TITLE, SELLER_ACC, EBAY_ITEM_ID, ITEM_MANUFACTURE) VALUES($LZ_BK_TEMP_ID, '$cat_name', $cat_id, '$pro_MPN', '$pro_UPC', $Quantity, $QuantitySold, $StartPrice, NULL, '$itemTitle', '$UserID', $ItemID, '$Brand')");						      
						      $i++;
						   //var_dump($qrey);
				           //exit;   
				      		/*/////////////////////////////////////////////*/				       
				    }//END FOREACH
				}else {
					$this->session->set_flashdata('warning', "Data not available!");
				}//end count if

				    $pageNumber += 1;
				}while($pageNumber <= $XML->paginationOutput->totalPages); 
			}//end foreach for category   

		$data['itemQuery']=$itemQuery;
		$data['item_upc']=$item_upc;
		$data['item_mpn']=$item_mpn;
		$data['bk_template']=$bk_template;
		$data['categoryId']=$categoryId;
		$data['main_category']=$main_category;
		$data['sub_category']=$sub_category;
		$data['category_name']=$category_name;
		$data['distincts']=$this->db->query("SELECT DISTINCT ebay_cat_id, EBAY_CAT_NAME FROM LZ_BK_TEMP");
		$data['items']=$this->db->query("SELECT * FROM LZ_BK_TEMP");
		$data['components']=$this->db->query("SELECT * FROM LZ_BK_ITEM_TYPE_DET, LZ_BK_ITEM_TYPE_MT, LZ_COMPONENT_MT WHERE LZ_BK_ITEM_TYPE_DET.LZ_BK_ITEM_TYPE_ID=LZ_BK_ITEM_TYPE_MT.LZ_BK_ITEM_TYPE_ID AND LZ_BK_ITEM_TYPE_DET.LZ_COMPONENT_ID=LZ_COMPONENT_MT.LZ_COMPONENT_ID AND LZ_BK_ITEM_TYPE_DET.LZ_BK_ITEM_TYPE_ID=$bk_template")->result_array(); 
		$this->load->view("BundleKit/api/v_searchByCategory_edit", $data);
						
			} //END ELSE
		

	}
	function search_for_profile($profile_id='')
	{
		require('/../../views/API/get-common/Productionkeys_imran.php'); 
 		require('/../../views/API/get-common/eBaySession.php');
		if($this->input->post('create_template'))
		 {
				$catId='';
				$catsId=$this->input->post('cat_list');
				$itemQuery=$this->input->post('item_query');
				//var_dump($itemQuery, $catsId); exit;
				$item_upc=$this->input->post('item_upc');
				$item_mpn=$this->input->post('item_mpn');
				$bk_template=$this->input->post('bk_template');
				$categoryId=$this->input->post('categoryId');			
				$main_category=$this->input->post('main_category');
				$sub_category=$this->input->post('sub_category');
				$category_name=$this->input->post('category_name');
				// var_dump($bk_template);
				// exit;
				//$k=0;
				foreach ((array)$catsId as $value) {
					$catId.="&categoryId(0)=".$value;
				//	$k++;
				
				$query=preg_replace('/\s+/', '+', $itemQuery);
				//$query=preg_replace(',', '`', $query);
				/*echo $query;
				exit;*/
				//echo "pre";
				//print_r($catId);
				//exit;
				$pageNumber=1;
				do{
				$URL ="http://svcs.ebay.com/services/search/FindingService/v1?siteid=0&SECURITY-APPNAME=Muhammad-bundlean-PRD-208fa563f-4079df85&OPERATION-NAME=findItemsAdvanced&GLOBAL-ID=EBAY-US&SERVICE-VERSION=1.0.0&RESPONSE-DATA-FORMAT=XML&keywords=$query&paginationInput.entriesPerPage=100&paginationInput.pageNumber=".$pageNumber.$catId; 
				
				 $XML = new SimpleXMLElement(file_get_contents($URL));
				 $count=$XML->searchResult['count'];
				 $ack=$XML->ack;
				/*
				 echo $ack;
				 echo "<br>";
				 echo "countt".$count;
				 echo '<pre>';
				 print_r($XML);
				 echo '</pre>';
				 exit;
				  */
				  if($ack=='Failure')
				  {
				  		$this->session->set_flashdata('warning', "Maximum three categories are allowed to select by ebay!");
				  		redirect('BundleKit/c_advanceCategories');
				  }else if($count > 0){
				   $i = 0; 
				   foreach((object)$XML->searchResult->item as $item)
				    {
				          $itmId=$json['item'][$i]['basicInfo']['itemId'] = "$item->itemId";

				          $sellingStatus = $item->sellingStatus;

				          //$json['item'][$i]['basicInfo']['convertedCurrentPrice'] = "$sellingStatus->convertedCurrentPrice";
				          $price ="$sellingStatus->convertedCurrentPrice";

           				 //$price = $json['item'][$i]['basicInfo']['convertedCurrentPrice'];
				           if(!empty(@$price))
				           {
				           	$StartPrice=$price;
				           }else {
				           	$StartPrice=NULL;
				           }

				         /* echo '<pre>';
				          print_r($price);
				          echo '</pre>';
				          exit;*/
				      /*///////////////////New api call//////////////////////////*/
				          //$compatabilityLevel = 949;    // eBay API version
				          /*$devID = '5f940391-f231-422f-8dc9-e125a616249c';   // these prod keys are different from sandbox keys
				          $appID = 'Muhammad-bundlean-PRD-208fa563f-4079df85';
				          $certID = 'PRD-08fa563fee6d-1205-402d-9f28-2e57';*/
				          //set the Server to use (Sandbox or Production)
     					  // server URL different for prod and sandbox
				          //the token representing the eBay user to assign the call with
				          //$userToken = 'AgAAAA**AQAAAA**aAAAAA**lwveWA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6ACkIWjDJGKoQ6dj6x9nY+seQ**eq0DAA**AAMAAA**A83CXqypqLBmxghCRV5HsJZtipBL/3pm3gyLPc5m8RaSm4TxJj/b+p7JMTLHIkdjetlixnIUeOPpY8CAzvGCsxz/iH87OxFJQD38QkMvWz85JedahUqpkE4GK4jlVRfHnvn9HTsrVf7YYwZQSOhR942FBqHizJKwzF0ydHYl/QGXjzht8m8kannpJqYpV5EAN6dt0+tHR5Z0weDleIbSwM4TiUFk3+uS4lGAA3rvrM4Cn8y5cZK6K6j+J2LOjHM5XaTAFMHfKG65TlE1kK5XsMyVIIxuCQnlii0AZczClCKYtxGwrf3NUe6tLph5QXfywlriPURRrty6N1Brf+ZsrZPUh9QqUYzj0vQWBUpmBesIjl7tAuIxpT1gBYCKXHzrCsRpkfs47AxWQGoPPVl0u+vACrwYtaEGReJJqmdj10JffL4tE63VJqG43rWX/bkAyJFzYgUQbhEbpQMhPPMwxs6J32i+2kee1J15zj0Cwas1KBjjkJiUdocxG7DvhVxyUOvXN8qeuesrpVQd3Lym0drWxj/XKPBXdes1wKA6JAQvWW70SrOw+MLKXZOP033CQDjVaYVoPxzk6C0xS43wQcIVskhQgweF7ErC62MXNnNe88RqHUP7MFvM6X0C6x9oiPGh2qDC9X8K7SdI5IiAVyq72EBquy3BLe1zbzgmcR5Oa6OGAz+t8rz3M77OVMk8cDYP/2J1zpB7zKzjbXEnmDTHwKr8Z+oIvr66kii720gesMcrDxy40i46Bhsz3B8C'; 			          
				        //echo "<div class='text-center'>$query</div>";
				          $siteID = 0;
				          //the call being made:
				          $verb = 'GetItem';
				          ///Build the request Xml string
				          $requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>';
				          $requestXmlBody .= '<GetItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
				          $requestXmlBody .= "<ItemID>$itmId</ItemID>";
				          $requestXmlBody .= "<DetailLevel>ReturnAll</DetailLevel>";
				          $requestXmlBody .= "<RequesterCredentials>";
				          $requestXmlBody .= "<eBayAuthToken>" . $userToken . "</eBayAuthToken>";
				          $requestXmlBody .= "</RequesterCredentials>";

				          $requestXmlBody .= '</GetItemRequest>';
				                
				            //Create a new eBay session with all details pulled in from included keys.php
				            //$session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
				          //build eBay headers using variables passed via constructor
				          $headers = array (
				          //Regulates versioning of the XML interface for the API
				          'X-EBAY-API-COMPATIBILITY-LEVEL: ' . $compatabilityLevel,
				          
				          //set the keys
				          'X-EBAY-API-DEV-NAME: ' . $devID,
				          'X-EBAY-API-APP-NAME: ' . $appID,
				          'X-EBAY-API-CERT-NAME: ' . $certID,
				          
				          //the name of the call we are requesting
				          'X-EBAY-API-CALL-NAME: ' . $verb,     
				          
				          //SiteID must also be set in the Request's XML
				          //SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
				          //SiteID Indicates the eBay site to associate the call with
				          'X-EBAY-API-SITEID: ' . $siteID,
				        );
				          
				          //initialise a CURL session
				          $connection = curl_init();
				          //set the server we are using (could be Sandbox or Production server)
				          curl_setopt($connection, CURLOPT_URL, $serverUrl);
				          
				          //stop CURL from verifying the peer's certificate
				          curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
				          curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
				          
				          //set the headers using the array of headers
				          curl_setopt($connection, CURLOPT_HTTPHEADER, $headers);
				          
				          //set method as POST
				          curl_setopt($connection, CURLOPT_POST, 1);
				          
				          //set the XML body of the request
				          curl_setopt($connection, CURLOPT_POSTFIELDS, $requestXmlBody);
				          
				          //set it to return the transfer as a string from curl_exec
				          curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
				          
				          //Send the Request
				          $response = curl_exec($connection);
				          
				          //close the connection
				          curl_close($connection);

				         $response = simplexml_load_string($response);

				         /*echo "<pre>";
				         print_r($response);
				         echo "</pre>";
				         exit;*/

				           if(!empty(@$response->Item->Variations->Variation[$i]->VariationProductListingDetails->UPC))
				           {
				           	$pro_UPC=$response->Item->Variations->Variation[$i]->VariationProductListingDetails->UPC;
				           }else {
				           	$pro_UPC=NULL;
				           }
				           

				           if(!empty(@$response->Item->Quantity))
				           {
				           	$Quantity=$response->Item->Quantity;
				           }else {
				           	$Quantity=NULL;
				           }
				           
				           //$QuantitySold=$response->Item->SellingStatus->QuantitySold;
				           if(!empty(@$response->Item->SellingStatus->QuantitySold))
				           {
				           	$QuantitySold=$response->Item->SellingStatus->QuantitySold;
				           }else {
				           	$QuantitySold=NULL;
				           }
				         
				           if(!empty(@$response->Item->ProductListingDetails->BrandMPN->MPN))
				           {
				           	$pro_MPN=$response->Item->ProductListingDetails->BrandMPN->MPN;
				           	$pro_MPN = trim(str_replace("  ", ' ', $pro_MPN));
        					$pro_MPN = trim(str_replace(array("'"), "''", $pro_MPN));
				           }else {
				           	$pro_MPN=NULL;
				           }

				            if(!empty(@$response->Item->ProductListingDetails->BrandMPN->Brand))
				           {
				           	$Brand=$response->Item->ProductListingDetails->BrandMPN->Brand;
			           		$Brand = trim(str_replace("  ", ' ', $Brand));
        					$Brand = trim(str_replace(array("'"), "''", $Brand));
				           }else {
				           	$Brand=NULL;

				           }

				           if(!empty(@$response->Item->PrimaryCategory->CategoryID))
				           {
				           	$cat_id=$response->Item->PrimaryCategory->CategoryID;
				           }else {
				           	$cat_id=NULL;
				           }
				           
				           //$cat_name=$response->Item->PrimaryCategory->CategoryName;
				           if(!empty(@$response->Item->PrimaryCategory->CategoryName))
				           {
				           	$cat_name=$response->Item->PrimaryCategory->CategoryName;
				           	$cat_name = trim(str_replace("  ", ' ', $cat_name));
        					$cat_name = trim(str_replace(array("'"), "''", $cat_name));
				           }else {
				           	$cat_name=NULL;
				           }
				          
				           //$UserID=$response->Item->Seller->UserID;
				           if(!empty(@$response->Item->Seller->UserID))
				           {
				           	$UserID=$response->Item->Seller->UserID;
				           	$UserID = trim(str_replace("  ", ' ', $UserID));
        					$UserID = trim(str_replace(array("'"), "''", $UserID));
				           }else {
				           	$UserID=NULL;
				           }

				           if(!empty(@$response->Item->Title))
				           {
				           	$itemTitle=$response->Item->Title;
				           	$itemTitle = trim(str_replace("  ", ' ', $itemTitle));
        					$itemTitle = trim(str_replace(array("'"), "''", $itemTitle));
				           }else {
				           	$itemTitle=NULL;
				           }
				           if(!empty(@$response->Item->ItemID))
				           {
				           	$ItemID=$response->Item->ItemID;
				           }else {
				           	$ItemID=NULL;
				           }
				          	// var_dump($itemTitle);
				           	// exit;
						      $qry = $this->db->query("SELECT get_single_primary_key('LZ_BK_TEMP','TEMP_ID') ID FROM DUAL");
					          $rs = $qry->result_array();
					          $LZ_BK_TEMP_ID = $rs[0]['ID'];      
						      $qrey=$this->db->query("INSERT INTO LZ_BK_TEMP (TEMP_ID, EBAY_CAT_NAME, EBAY_CAT_ID, MPN, UPC, QTY_LISTED, QTY_SOLD, LISTED_PRICE, LIST_DATE, ITEM_TITLE, SELLER_ACC, EBAY_ITEM_ID, ITEM_MANUFACTURE) VALUES($LZ_BK_TEMP_ID, '$cat_name', $cat_id, '$pro_MPN', '$pro_UPC', $Quantity, $QuantitySold, $StartPrice, NULL, '$itemTitle', '$UserID', $ItemID, '$Brand')");						      
						      $i++;
						   //var_dump($qrey);
				           	//exit;   
				      /*/////////////////////////////////////////////*/
				       
				    }//END FOREACH
				}else {
					$this->session->set_flashdata('warning', "Data not available!");
				}//end count if
				    $pageNumber += 1;
				}while($pageNumber <= $XML->paginationOutput->totalPages); 
			}//end foreach for category   

					$itemQuery= str_replace("/", '_', $itemQuery);
					$itemQuery= str_replace(",", '`', $itemQuery);
					$itemQuery = str_replace("'", "''", $itemQuery);

					$item_mpn= str_replace("/", '_', $item_mpn);
					$item_mpn = str_replace("'", "''", $item_mpn);
					$categoryId=$this->input->post('categoryId');			
					$main_category=$this->input->post('main_category');
					$main_category= str_replace("/", '`', $main_category);
					$sub_category=$this->input->post('sub_category');
					$sub_category= str_replace("/", '`', $sub_category);
					$category_name=$this->input->post('category_name');
					$category_name= str_replace("/", '`', $category_name);

					$bkUrl='BundleKit/c_advanceCategories/showCategoriesData/'.$itemQuery.'/'.'upc'.'/'.'mpn'.'/'.$bk_template.'/'.$categoryId.'/'.$main_category.'/'.$sub_category.'/'.$category_name;
						$bkUrl=urlencode($bkUrl);
						
					if(!empty($profile_id)){
						if (empty($item_upc) && empty($item_mpn)) {
							redirect($bkUrl);
						}elseif (empty($item_mpn) && !empty($item_upc)) {
							redirect($bkUrl);
						}elseif (!empty($item_mpn) && empty($item_upc)) {
							redirect($bkUrl);
						}else {
							redirect($bkUrl);
						}
					}else{
						if (empty($item_upc) && empty($item_mpn)) {
							redirect($bkUrl);
						}elseif (empty($item_mpn) && !empty($item_upc)) {
							redirect($bkUrl);
						}elseif (!empty($item_mpn) && empty($item_upc)) {
							redirect($bkUrl);
						}else {
							redirect($bkUrl);
						}

					}
				
			} //END ELSE

	}
	
}