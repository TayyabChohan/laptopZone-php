<?php
class C_bkProfiles extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		 if(!$this->loginmodel->is_logged_in())
		     {
		       redirect('login/login/');
		     }		
	}
	function index()
	{
		$data['pageTitle'] = 'Profiles List';
		$data['profiles']=$this->m_bkProfiles->showProfilesList();
		$this->load->view("BundleKit/profile/v_bkProfiles", $data);
	}
	function addProfile()
	{
		$data['pageTitle'] ='Add Profiles';
		$data['templates'] =$this->m_bkProfiles->getAllTemplates();
		$this->load->view("BundleKit/profile/v_createProfile", $data);
	}
	function searchCatsForProfile()
	{
		$this->m_bkProfiles->searchCats();	
	}
	function ProfileDetail($profile_id='')
	{
		$data['pageTitle'] = 'Profile Detail';
		$data['components']=$this->m_bkProfiles->showDetailPage($profile_id);
		$this->load->view("BundleKit/profile/v_bkProfileDetail", $data);
	}
	function deleteProfile($profile_id='')
	{
		$this->m_bkProfiles->bk_ProfileDeletion($profile_id);	
	}
	function deleteProfileComponent($component_id='', $profile_id='')
	{			
		$this->m_bkProfiles->profileComponentDeletion($component_id, $profile_id);				
	}	
	function bk_addMoreComponents($profile_id='')
	{
		if(isset($_POST['edit_rofile']))
		{
			require('/../../views/API/get-common/Productionkeys.php');
			require('/../../views/API/get-common/eBaySession.php');
			$data['profile_id']=$profile_id;
			$data['query']=$this->input->post('profile_name');
			$data['template_id']=$this->input->post('template_id');
			$data['item_template']=$this->input->post('profile_template');
			$data['item_upc']=$this->input->post('profile_upc');
			$data['item_mpn']=$this->input->post('profile_mpn');
			$data['categoryId']=$this->input->post('categoryId');
			$data['main_category']=$this->input->post('main_category');
			$data['sub_category']=$this->input->post('sub_category');
			$data['category_name']=$this->input->post('category_name');
			//var_dump($data['item_upc'], $data['item_mpn']); exit;
			$siteID = 0;
			//the call being made:
			$verb = 'GetSuggestedCategories';
			$requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
			$requestXmlBody .= '<GetSuggestedCategoriesRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
			$requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
			$requestXmlBody .= "<Query>".$data['query']."</Query>";
			$requestXmlBody .= '</GetSuggestedCategoriesRequest>';    
	        //Create a new eBay session with all details pulled in from included keys.php
	        $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);	
			//send the request and get response
			$data['responseXml'] = $session->sendHttpRequest($requestXmlBody);
			if(stristr($data['responseXml'], 'HTTP 404') || $data['responseXml'] == '')
				die('<P>Error sending request');
			$data['xml'] = simplexml_load_string($data['responseXml']);
			$data['pageTitle'] = 'Edit Profile';
			$this->load->view("BundleKit/profile/v_addMoreComponents", $data);	
		}			
	}
	function bkTemplateUpdation($template_id='')
	{
		if(!empty($template_id) && $template_id!=='')
			{
				$data['components']=$this->m_bkProfiles->getAllComponents();
				$data['details']=$this->m_bkProfiles->getDetailById($template_id);
				$data['pageTitle'] = 'Update Template';
				$this->load->view("BundleKit/template/v_bk_updateTemplate", $data);	
			}
	}
	function saveEbaycatData()
	{		
		$this->m_bkProfiles->createProfile();
	}
	function search_category()
	{
		if ($this->input->post('for_accordians'))
		{
			require('/../../views/API/get-common/Productionkeys_imran.php'); 
			require('/../../views/API/get-common/eBaySession.php');
			$this->form_validation->set_rules('cat_list[]', 'Category Id', 'required');
			$this->form_validation->set_rules('bk_template', 'Item Template', 'required');
			if($this->form_validation->run()==FALSE)
				{
					redirect(site_url().'BundleKit/c_bkProfiles/addProfile');
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
			 /*echo "<pre>";
			print_r($XML); exit;*/
			 $count=$XML->searchResult['count'];
			 $ack=$XML->ack;
			
			  if($ack=='Failure')
			  {
			  		$this->session->set_flashdata('warning', "Maximum three categories are allowed to select by ebay!");
			  		redirect('BundleKit/c_bkProfiles/addProfile');
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
			         
				         // echo "<pre>";
				         // print_r($response);
				         // echo "</pre>";
				         // exit;
			         

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
					      $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BK_TEMP','TEMP_ID') ID FROM DUAL");
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

			$data['distincts']=$this->db->query("SELECT DISTINCT EBAY_CAT_ID, EBAY_CAT_NAME FROM LZ_BK_TEMP");
			$data['items']=$this->db->query("SELECT * FROM LZ_BK_TEMP");
			$data['components']=$this->db->query("SELECT * FROM LZ_BK_ITEM_TYPE_DET, LZ_BK_ITEM_TYPE_MT, LZ_COMPONENT_MT WHERE LZ_BK_ITEM_TYPE_DET.LZ_BK_ITEM_TYPE_ID=LZ_BK_ITEM_TYPE_MT.LZ_BK_ITEM_TYPE_ID AND LZ_BK_ITEM_TYPE_DET.LZ_COMPONENT_ID=LZ_COMPONENT_MT.LZ_COMPONENT_ID AND LZ_BK_ITEM_TYPE_DET.LZ_BK_ITEM_TYPE_ID=$bk_template")->result_array(); 
			$this->load->view("BundleKit/profile/v_searchByCategory_edit", $data);
				
			} //END ELSE		
		}//for submit button
	}
	function search_for_profile($profile_id='')
	{
		require('/../../views/API/get-common/Productionkeys_imran.php'); 
 		require('/../../views/API/get-common/eBaySession.php');
		if($this->input->post('update_profile'))
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
				//var_dump($profile_id);
				 //exit;
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
				$URL ="http://svcs.ebay.com/services/search/FindingService/v1?siteid=0&SECURITY-APPNAME=Muhammad-bundlean-PRD-208fa563f-4079df85&OPERATION-NAME=findItemsAdvanced&GLOBAL-ID=EBAY-US&SERVICE-VERSION=1.0.0&RESPONSE-DATA-FORMAT=XML&keywords=($query)&paginationInput.entriesPerPage=100&paginationInput.pageNumber=".$pageNumber.$catId; 
				
				 $XML = new SimpleXMLElement(file_get_contents($URL));
				 $count=$XML->searchResult['count'];
				 $ack=$XML->ack;
				  if($ack=='Failure')
				  {
				  		$this->session->set_flashdata('warning', "Maximum three categories are allowed to select by ebay!");
				  		redirect('BundleKit/c_bkProfiles');
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
				           }else
				           {
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
				$data['profile_id']=$profile_id;
				$data['itemQuery']=$itemQuery;
				$data['item_upc']=$item_upc;
				$data['item_mpn']=$item_mpn;
				$data['bk_template']=$bk_template;
				$data['categoryId']=$categoryId;
				$data['main_category']=$main_category;
				$data['sub_category']=$sub_category;
				$data['category_name']=$category_name;

				$data['distincts']=$this->db->query("SELECT DISTINCT EBAY_CAT_ID, EBAY_CAT_NAME FROM LZ_BK_TEMP");
				$data['items']=$this->db->query("SELECT * FROM LZ_BK_TEMP");
				$data['pageTitle'] = 'Edit Profile';
				$data['components']=$this->db->query("SELECT * FROM LZ_BK_ITEM_TYPE_DET, LZ_BK_ITEM_TYPE_MT, LZ_COMPONENT_MT 
				WHERE LZ_BK_ITEM_TYPE_DET.LZ_BK_ITEM_TYPE_ID=LZ_BK_ITEM_TYPE_MT.LZ_BK_ITEM_TYPE_ID 
				AND LZ_BK_ITEM_TYPE_DET.LZ_COMPONENT_ID=LZ_COMPONENT_MT.LZ_COMPONENT_ID 
				AND LZ_BK_ITEM_TYPE_DET.LZ_BK_ITEM_TYPE_ID=$bk_template")->result_array();
				//echo "<pre>";
				//print_r($data);
				//exit;
				$this->load->view("BundleKit/profile/v_searchByCategory_edit", $data);
				
			} //END ELSE

	}
/*********************************
* FOR VIEWING SAVED DATA
**********************************/	
function viewSavedData()
{
	$data['pageTitle'] = 'View Data';
	$this->m_bkProfiles->already_saved_data();
	//$this->load->view("BundleKit/profile/v_bkViewSavedData", $data);
}
/*********************************
* FOR DIRECT DATA ACCESSING
**********************************/
function directDataAccessing()
{
	$data['itemQuery']=$_POST['item_name'];
	$data['item_upc']=$_POST['item_upc'];
	$data['item_mpn']= $_POST['item_mpn'];
	$data['bk_template']= $_POST['item_template'];
	$data['categoryId']= $_POST['categoryId'];
	$data['main_category']= $_POST['main_category'];
	$data['sub_category']= $_POST['sub_category'];
	$data['category_name']=$_POST['category_name'];
	$data['distincts']=$this->db->query("SELECT DISTINCT EBAY_CAT_ID, EBAY_CAT_NAME FROM LZ_BK_TEMP");
	$data['items']=$this->db->query("SELECT * FROM LZ_BK_TEMP");
	$data['pageTitle'] = 'View Profile';
	$select_query=$this->db->query("SELECT * FROM LZ_BK_ITEM_TYPE_DET, LZ_BK_ITEM_TYPE_MT, LZ_COMPONENT_MT 
	WHERE LZ_BK_ITEM_TYPE_DET.LZ_BK_ITEM_TYPE_ID=LZ_BK_ITEM_TYPE_MT.LZ_BK_ITEM_TYPE_ID 
	AND LZ_BK_ITEM_TYPE_DET.LZ_COMPONENT_ID=LZ_COMPONENT_MT.LZ_COMPONENT_ID 
	AND LZ_BK_ITEM_TYPE_DET.LZ_BK_ITEM_TYPE_ID=".$data['bk_template']);
	$data['components']=$select_query->result_array();
	$this->load->view("BundleKit/profile/v_searchByCategory_edit", $data);
}

}
