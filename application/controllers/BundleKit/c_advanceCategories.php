<?php
class c_advanceCategories extends CI_Controller
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
		echo "dgdgdggg"; exit;
		if($this->input->post('submit_query')){
			$query = $this->input->post('item_name');
			$item_upc = $this->input->post('item_upc');
			$item_mpn = $this->input->post('item_mpn');
			$item_template = $this->input->post('item_template');
			if(!empty($query) && !empty($item_upc) && !empty($item_mpn)){
		   			$query1=$this->db->query("SELECT * FROM LZ_BK_ITEM_MT M WHERE M.LZ_BK_ITEM_DESC LIKE '%$query%' OR M.UPC LIKE '%$item_upc%' OR M.MPN LIKE '%$item_mpn%'");
		   			if($query1->num_rows() > 0)
		   			{
				   		$this->session->set_flashdata('warning', "Item profile already exist!");
				   		redirect(base_url()."BundleKit/c_advanceCategories");
				   	}else
				   	{
				   		$data['templates']=$this->db->query("SELECT * FROM LZ_BK_ITEM_TYPE_MT")->result_array();
				   		$data['pageTitle'] = 'Search Category';
						$this->load->view("BundleKit/api/v_advance_cetegories", $data);
				   	}
		   		}elseif(!empty($query) && !empty($item_upc) && empty($item_mpn)){
		   			$query2=$this->db->query("SELECT * FROM LZ_BK_ITEM_MT M WHERE M.LZ_BK_ITEM_DESC LIKE '%$query%' OR M.UPC LIKE '%$item_upc%'");
		   			if($query2->num_rows() > 0)
		   			{
				   		$this->session->set_flashdata('warning', "Item profile already exist!");
				   		redirect(base_url()."BundleKit/c_advanceCategories");
				   	}else
				   	{
				   		$data['templates']=$this->db->query("SELECT * FROM LZ_BK_ITEM_TYPE_MT")->result_array();
				   		$data['pageTitle'] = 'Search Category';
						$this->load->view("BundleKit/api/v_advance_cetegories", $data);
				   	}
		   		}elseif(!empty($query) && empty($item_upc) && empty($item_mpn))
		   		{
		   			$query3=$this->db->query("SELECT * FROM LZ_BK_ITEM_MT M WHERE M.LZ_BK_ITEM_DESC LIKE '%$query%'");
		   			if($query3->num_rows() > 0)
		   			{
				   		$this->session->set_flashdata('warning', "Item profile already exist!");
				   		redirect(base_url()."BundleKit/c_advanceCategories");
				   	}else
				   	{
				   		$data['templates']=$this->db->query("SELECT * FROM LZ_BK_ITEM_TYPE_MT")->result_array();
				   		$data['pageTitle'] = 'Search Category';
						$this->load->view("BundleKit/api/v_advance_cetegories", $data);
				   	}
		   		}else {
		   			$this->session->set_flashdata('warning', "Profile name is neccessary!");
				   		redirect(base_url()."BundleKit/c_advanceCategories");
		   		}	   	
		}else{
			$data['templates']=$this->db->query("SELECT * FROM LZ_BK_ITEM_TYPE_MT")->result_array();
			$data['pageTitle'] = 'Search Category';
			$this->load->view("BundleKit/api/v_advance_cetegories", $data);
		}	
	}
	function bk_search()
	{
		$data['pageTitle'] = 'Search Category';
		$data['templates']=$this->db->query("SELECT * FROM lz_bk_item_type_mt")->result_array();
		if($this->input->post('submit_query'))
		{
			$this->load->view("BundleKit/api/v_bkSearch_category", $data);
		}else {
			$this->load->view("BundleKit/api/v_bkSearch", $data);
		}		
	}
	function getAllAPIData()
	{
		$data['categories']=$this->db->query("SELECT * FROM LZ_BK_TEMP");
     	$this->load->view("BundleKit/v_show_master_data", $data);
	}
	function showCategoriesData($itemQuery='', $item_upc='', $item_mpn='', $bk_template='', $categoryId='', $main_category='', $sub_category='', $category_name='' )
	{
		$data['itemQuery']=$itemQuery;

		$data['item_upc']=$item_upc;
		if ($data['item_upc']=='upc') {
			$data['item_upc']='';
		}
		$data['item_mpn']=$item_mpn;
		if ($data['item_mpn']=='mpn') {
			$data['item_mpn']='';
		}else {
			//$str = preg_replace('/[^a-zA-Z0-9\']/', '/', $data['item_mpn']);
			$data['item_mpn'] = str_replace("_", '/', $data['item_mpn']);
			$data['item_mpn'] = str_replace("'", '', $data['item_mpn']);
		}
		$data['bk_template']=$bk_template;

		$data['categoryId']=$categoryId;
		$data['main_category']=$main_category;
		$data['sub_category']=$sub_category;
		$data['category_name']=$category_name;
		$data['distincts']=$this->db->query("SELECT DISTINCT ebay_cat_id, EBAY_CAT_NAME FROM LZ_BK_TEMP");
		$data['items']=$this->db->query("SELECT * FROM LZ_BK_TEMP");
		$data['components']=$this->db->query("SELECT * FROM LZ_BK_ITEM_TYPE_DET, LZ_BK_ITEM_TYPE_MT, LZ_COMPONENT_MT WHERE LZ_BK_ITEM_TYPE_DET.LZ_BK_ITEM_TYPE_ID=LZ_BK_ITEM_TYPE_MT.LZ_BK_ITEM_TYPE_ID AND LZ_BK_ITEM_TYPE_DET.LZ_COMPONENT_ID=LZ_COMPONENT_MT.LZ_COMPONENT_ID AND LZ_BK_ITEM_TYPE_DET.LZ_BK_ITEM_TYPE_ID=$bk_template")->result_array(); 
		$this->load->view("BundleKit/api/v_searchByCategory_edit", $data);
	}
	function showEditProfileData($itemQuery='', $item_upc='', $item_mpn='', $bk_template='', $profile_id='', $categoryId='', $main_category='', $sub_category='', $category_name='' )
	{
		$data['itemQuery']=$itemQuery;

		$data['item_upc']=$item_upc;
		if ($data['item_upc']=='upc') {
			$data['item_upc']='';
		}
		$data['item_mpn']=$item_mpn;
		if ($data['item_mpn']=='mpn') {
			$data['item_mpn']='';
		}else {
			//$str = preg_replace('/[^a-zA-Z0-9\']/', '/', $data['item_mpn']);
			$data['item_mpn'] = str_replace("_", '/', $data['item_mpn']);
			$data['item_mpn'] = str_replace("'", '', $data['item_mpn']);
		}
		$data['profile_id']=$profile_id;
		$data['bk_template']=$bk_template;
		$data['categoryId']=$categoryId;
		$data['main_category']=$main_category;
		$data['sub_category']=$sub_category;
		$data['category_name']=$category_name;

		$data['distincts']=$this->db->query("SELECT DISTINCT ebay_cat_id, EBAY_CAT_NAME FROM LZ_BK_TEMP");
		$data['items']=$this->db->query("SELECT * FROM LZ_BK_TEMP");
		$data['pageTitle'] = 'Edit Profile';
		$data['components']=$this->db->query("SELECT * FROM LZ_BK_ITEM_TYPE_DET, LZ_BK_ITEM_TYPE_MT, LZ_COMPONENT_MT 
		WHERE LZ_BK_ITEM_TYPE_DET.LZ_BK_ITEM_TYPE_ID=LZ_BK_ITEM_TYPE_MT.LZ_BK_ITEM_TYPE_ID 
AND LZ_BK_ITEM_TYPE_DET.LZ_COMPONENT_ID=LZ_COMPONENT_MT.LZ_COMPONENT_ID 
AND LZ_BK_ITEM_TYPE_DET.LZ_BK_ITEM_TYPE_ID=$bk_template")->result_array();
     	$this->load->view("BundleKit/api/v_searchByCategory_edit", $data);
	}
	function saveEbaycatData()
	{		
		$profile_id=$this->input->post('profile_id');
		$templateiD=$this->input->post('templateiD');
		$itemName=$this->input->post('itemName');

		$categoryId=$this->input->post('categoryId');
		$main_category=$this->input->post('main_category');
		$sub_category=$this->input->post('sub_category');
		$category_name=$this->input->post('category_name');

		$itemName = trim(str_replace("  ", ' ', $itemName));
		$itemName = trim(str_replace("'", "''", $itemName));
		$tempName= ucfirst($itemName);
		$componentName =$this->input->post('componentName');
		$titles=$this->input->post('titles');
		date_default_timezone_set("America/Chicago");
		$date = date('Y-m-d H:i:s');
		$list_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
		$mpn=$this->input->post('mpn');
		$upc=$this->input->post('upc');
		$catId=$this->input->post('catId');
		$brand=$this->input->post('brand');
		$itemId=$this->input->post('itemId');
		$item_upc=$this->input->post('item_upc');
		$item_mpn=$this->input->post('item_mpn');
		//var_dump($item_upc, $item_mpn);exit;
		$suggestPrice=$this->input->post('suggestPrice');
		$itemPrice=$this->input->post('itemPrice');
		$remarks=$this->input->post('remarks');
		$CategoryName=$this->input->post('CategoryName');
			if(empty($profile_id))
			{
				$qry = $this->db->query("SELECT get_single_primary_key('LZ_BK_ITEM_MT','LZ_BK_ITEM_ID') ID FROM DUAL");
				$rs = $qry->result_array();
	   			$lz_bk_item_id= $rs[0]['ID'];
	    		$query=$this->db->query("INSERT INTO LZ_BK_ITEM_MT (LZ_BK_ITEM_ID, LZ_BK_ITEM_TYPE_ID, LZ_BK_ITEM_DESC, CREATE_DATE, UPC, MPN, CATEGORY_ID, MAIN_CATEGORY, SUB_CATEGORY, CATEGORY_NAME) VALUES($lz_bk_item_id, $templateiD, '$itemName', $list_date, '$item_upc', '$item_mpn', $categoryId, '$main_category', '$sub_category', '$category_name')");
	    			if($query)
						{
							$i=0;         	
							foreach ($componentName as $component)
								{
									$qry = $this->db->query("SELECT get_single_primary_key('LZ_BK_ITEM_DET','LZ_BK_ITEM_DET_ID') ID FROM DUAL");
				        			$rs = $qry->result_array();
					        		$lz_bk_item_det_id= $rs[0]['ID'];
			          				$qry="INSERT INTO LZ_BK_ITEM_DET (LZ_BK_ITEM_DET_ID, LZ_BK_ITEM_ID, LZ_COMPONENT_ID, ITEM_DESC, ITEM_UPC, ITEM_MPN, ITEM_MANUFACTURER, MANUAL_PRICE, EBAY_ITEM_ID, ACTIVE_PRICE, CATEGORY_ID, CATEGORY_NAME, REMARKS) VALUES($lz_bk_item_det_id, $lz_bk_item_id, $component, '$titles[$i]','$upc[$i]', '$mpn[$i]', '$brand[$i]','$suggestPrice[$i]', $itemId[$i], $itemPrice[$i], $catId[$i], '$CategoryName[$i]', '$remarks[$i]')";
									$q=$this->db->query($qry); 
									$i++;

								}
									if($q)
									{
										$qq=$this->db->query("TRUNCATE TABLE LZ_BK_TEMP");
									}
									if($qq)
										{
									 	 $this->session->set_flashdata('success', "Data is saved successfully"); 
										}else 
										{
								  			$this->session->set_flashdata('error',"Data insertion has Failed");
										} 
							echo json_encode($q);
        				    return json_encode($q);
						}
			}else 
				{
					$i=0;         	
						foreach ($componentName as $component)
							{
								$qry = $this->db->query("SELECT get_single_primary_key('LZ_BK_ITEM_DET','LZ_BK_ITEM_DET_ID') ID FROM DUAL");
			        			$rs = $qry->result_array();
				        		$lz_bk_item_det_id= $rs[0]['ID'];
		          				$qry="INSERT INTO LZ_BK_ITEM_DET (LZ_BK_ITEM_DET_ID, LZ_BK_ITEM_ID, LZ_COMPONENT_ID, ITEM_DESC, ITEM_UPC, ITEM_MPN, ITEM_MANUFACTURER, MANUAL_PRICE, EBAY_ITEM_ID, ACTIVE_PRICE, CATEGORY_ID, CATEGORY_NAME, REMARKS) VALUES($lz_bk_item_det_id, $profile_id, $component, '$titles[$i]','$upc[$i]', '$mpn[$i]', '$brand[$i]','$suggestPrice[$i]', $itemId[$i], $itemPrice[$i], $catId[$i], '$CategoryName[$i]', '$remarks[$i]')";
								$q=$this->db->query($qry); 
								$i++;
							}
							if($q)
							{
								$qq=$this->db->query("TRUNCATE TABLE LZ_BK_TEMP");
							}
							if($qq)
								{
								  $this->session->set_flashdata('success', "Data is saved successfully"); 
								}else 
								{
								  $this->session->set_flashdata('error',"Data insertion has Failed");
								} 
							echo json_encode($q);
        				    return json_encode($q);
			}
	}
	function showProfilesList()
	{
		$data['pageTitle'] = 'Profiles List';
		$data['profiles']=$this->db->query("SELECT * FROM lz_bk_item_mt, lz_bk_item_type_mt where lz_bk_item_mt.lz_bk_item_type_id=lz_bk_item_type_mt.lz_bk_item_type_id ORDER BY LZ_BK_ITEM_ID DESC");
		$this->load->view("BundleKit/api/v_profilesList", $data);
	}
	function showProfileDetail($template_id='')
	{
	$data['pageTitle'] = 'Profile Detail';
	$data['components']=$this->db->query("select * from LZ_BK_ITEM_DET, LZ_BK_ITEM_MT, LZ_COMPONENT_MT, LZ_BK_ITEM_TYPE_MT, LZ_BK_ITEM_TYPE_DET WHERE LZ_BK_ITEM_TYPE_MT.LZ_BK_ITEM_TYPE_ID=LZ_BK_ITEM_MT.LZ_BK_ITEM_TYPE_ID 
AND LZ_BK_ITEM_DET.LZ_BK_ITEM_ID=LZ_BK_ITEM_MT.LZ_BK_ITEM_ID 
AND LZ_BK_ITEM_DET.LZ_COMPONENT_ID=LZ_COMPONENT_MT.LZ_COMPONENT_ID 
AND LZ_BK_ITEM_TYPE_DET.LZ_BK_ITEM_TYPE_ID=lz_bk_item_type_mt.LZ_BK_ITEM_TYPE_ID
AND LZ_BK_ITEM_TYPE_DET.LZ_COMPONENT_ID=LZ_COMPONENT_MT.LZ_COMPONENT_ID
AND LZ_BK_ITEM_MT.LZ_BK_ITEM_ID=$template_id");
		$this->load->view("BundleKit/api/v_profileDetail", $data);
	}
	function deleteTemplate($template_id='')
		{
			$query=$this->db->query("SELECT * FROM LZ_BK_KIT_MT WHERE LZ_BK_ITEM_ID =$template_id");
			if($query->num_rows() >0){
				 $this->session->set_flashdata('warning',"This profile has used in kit/s. So first DELETE its kit/s");
				 redirect(base_url()."BundleKit/c_advanceCategories/showProfilesList");
			}else{
				$query=$this->db->query("DELETE FROM LZ_BK_ITEM_DET WHERE LZ_BK_ITEM_ID =$template_id");
					if($query)
					{
						$query=$this->db->query("DELETE FROM  LZ_BK_ITEM_MT WHERE LZ_BK_ITEM_ID=$template_id");
						if($query)
						{
						  $this->session->set_flashdata('success', "Template is deleted successfully"); 
						}else {
						  $this->session->set_flashdata('error',"Template deletion has Failed");
						} 		  
						redirect(base_url()."BundleKit/c_advanceCategories/showProfilesList");
					}
			}	
		}
		function deleteProfileComponent($component_id='', $profile_id='')
		{			
			$query=$this->db->query("DELETE FROM LZ_BK_ITEM_DET WHERE LZ_BK_ITEM_DET_ID =$component_id");
				if($query)
				{
				  $this->session->set_flashdata('success', "Component is deleted successfully"); 
				}else{
				  $this->session->set_flashdata('error',"Component deletion has Failed");
				} 		  
				redirect(base_url()."BundleKit/c_bkProfiles/showProfileDetail/".$profile_id);			
		}
		function Suggest_Categories(){
			$UPC = NULL;
			$TITLE = $this->input->post('item_name');
			$TITLE = trim(str_replace("  ", ' ', $TITLE));
	        $TITLE = trim(str_replace(array("'"), "''", $TITLE));
			$MPN = $this->input->post('MPN');
			$MPN = trim(str_replace("  ", ' ', $MPN));
	        $MPN = trim(str_replace(array("'"), "''", $MPN));
			if(!empty($UPC) && strtoupper($UPC) != "DOES NOT APPLY")
			{
				$data['key']=$UPC;	
			}elseif(!empty($MPN) && strtoupper($MPN) != "DOES NOT APPLY"){
				$data['key']=$MPN;
			}elseif(!empty($TITLE)){
				$data['key']=$TITLE;
			}
			$data['result'] =$this->load->view('API/SuggestCategories', $data);
			$data['templates']=$this->db->query("SELECT * FROM lz_bk_item_type_mt")->result_array();
			$this->load->view("BundleKit/api/v_bkSearch", $data);
			//return $data['result'];
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
			$this->load->view("BundleKit/api/v_addMoreComponents", $data);	
		}			
	}	
}