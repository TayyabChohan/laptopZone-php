<?php
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
 
class M_bkProfiles extends CI_Model
{
	function showProfilesList()
	{
		return $this->db->query("SELECT * FROM LZ_BK_ITEM_MT, LZ_BK_ITEM_TYPE_MT WHERE LZ_BK_ITEM_MT.LZ_BK_ITEM_TYPE_ID=LZ_BK_ITEM_TYPE_MT.LZ_BK_ITEM_TYPE_ID ORDER BY LZ_BK_ITEM_ID DESC");
	}
	function bk_ProfileDeletion($profile_id)
	{
		$query=$this->db->query("SELECT * FROM LZ_BK_KIT_MT WHERE LZ_BK_ITEM_ID =$profile_id");
			if($query->num_rows() >0){
				 $this->session->set_flashdata('warning',"This profile has used in kit/s. So first DELETE its kit/s");
				 redirect(base_url()."BundleKit/c_bkProfiles");
			}else
			{
				$query=$this->db->query("DELETE FROM LZ_BK_ITEM_DET WHERE LZ_BK_ITEM_ID =$profile_id");
					if($query)
					{
						$query=$this->db->query("DELETE FROM  LZ_BK_ITEM_MT WHERE LZ_BK_ITEM_ID=$profile_id");
						if($query)
						{
						  $this->session->set_flashdata('success', "Profile is deleted successfully"); 
						}else {
						  $this->session->set_flashdata('error',"Profile deletion has Failed");
						} 		  
						redirect(base_url()."BundleKit/c_bkProfiles");
					}
			}
	}
	function showDetailPage($profile_id)
	{
		return $this->db->query("SELECT * FROM LZ_BK_ITEM_DET, LZ_BK_ITEM_MT, LZ_COMPONENT_MT, LZ_BK_ITEM_TYPE_MT, LZ_BK_ITEM_TYPE_DET WHERE LZ_BK_ITEM_TYPE_MT.LZ_BK_ITEM_TYPE_ID=LZ_BK_ITEM_MT.LZ_BK_ITEM_TYPE_ID AND LZ_BK_ITEM_DET.LZ_BK_ITEM_ID=LZ_BK_ITEM_MT.LZ_BK_ITEM_ID AND LZ_BK_ITEM_DET.LZ_COMPONENT_ID=LZ_COMPONENT_MT.LZ_COMPONENT_ID AND LZ_BK_ITEM_TYPE_DET.LZ_BK_ITEM_TYPE_ID=lz_bk_item_type_mt.LZ_BK_ITEM_TYPE_ID AND LZ_BK_ITEM_TYPE_DET.LZ_COMPONENT_ID=LZ_COMPONENT_MT.LZ_COMPONENT_ID AND LZ_BK_ITEM_MT.LZ_BK_ITEM_ID=$profile_id"); 
	}
	function getAllComponents()
	{
		return $query=$this->db->query("SELECT * FROM LZ_COMPONENT_MT");
		
	}
	function getAllTemplates()
	{
		return $query=$this->db->query("SELECT * FROM LZ_BK_ITEM_TYPE_MT")->result_array();
		
	}

	function getDetailById($template_id)
	{
		return $query=$this->db->query("SELECT D.*, M.ITEM_TYPE_DESC FROM LZ_BK_ITEM_TYPE_DET D,LZ_BK_ITEM_TYPE_MT M WHERE D.LZ_BK_ITEM_TYPE_ID = M.LZ_BK_ITEM_TYPE_ID AND D.LZ_BK_ITEM_TYPE_ID =$template_id")->result_array();
	}
	function searchCats()
	{

		if($this->input->post('submit_query')){
			//echo "welcome to searchCats inter"; exit;
			$query = $this->input->post('item_name');
			$item_upc = $this->input->post('item_upc');
			$item_mpn = $this->input->post('item_mpn');
			$item_template = $this->input->post('item_template');
			//var_dump($item_template, $query, $item_upc, $item_mpn); exit;
			if(empty($item_upc) && empty($item_mpn)){
		   			$query1=$this->db->query("SELECT * FROM LZ_BK_ITEM_MT M WHERE M.LZ_BK_ITEM_DESC LIKE '%$query%'");
		   			if($query1->num_rows() > 0)
		   			{
				   		$this->session->set_flashdata('warning', "Item profile already exist!");
				   		redirect(base_url()."BundleKit/c_bkProfiles");
				   	}else
				   	{
				   		$data['templates']=$this->db->query("SELECT * FROM LZ_BK_ITEM_TYPE_MT")->result_array();
				   		$data['pageTitle'] = 'Search Category';
						$this->load->view("BundleKit/profile/v_searchCats", $data);
				   	}
		   		}elseif(!empty($item_upc) && !empty($item_mpn)){
		   			$query1=$this->db->query("SELECT * FROM LZ_BK_ITEM_MT M WHERE M.LZ_BK_ITEM_DESC LIKE '%$query%' OR M.UPC LIKE '%$item_upc%' OR M.MPN LIKE '%$item_mpn%'");
		   			if($query1->num_rows() > 0)
		   			{
				   		$this->session->set_flashdata('warning', "Item profile already exist!");
				   		redirect(base_url()."BundleKit/c_bkProfiles");
				   	}else
				   	{
				   		$data['templates']=$this->db->query("SELECT * FROM LZ_BK_ITEM_TYPE_MT")->result_array();
				   		$data['pageTitle'] = 'Search Category';
						$this->load->view("BundleKit/profile/v_searchCats", $data);
				   	}
		   		}elseif(!empty($item_upc) && empty($item_mpn)){
		   			$query2=$this->db->query("SELECT * FROM LZ_BK_ITEM_MT M WHERE M.LZ_BK_ITEM_DESC LIKE '%$query%' OR M.UPC LIKE '%$item_upc%'");
		   			if($query2->num_rows() > 0)
		   			{
				   		$this->session->set_flashdata('warning', "Item profile already exist!");
				   		redirect(base_url()."BundleKit/c_bkProfiles");
				   	}else
				   	{
				   		$data['templates']=$this->db->query("SELECT * FROM LZ_BK_ITEM_TYPE_MT")->result_array();
				   		$data['pageTitle'] = 'Search Category';
						$this->load->view("BundleKit/profile/v_searchCats", $data);
				   	}
		   		}elseif(empty($item_upc) && !empty($item_mpn))
		   		{
		   			$query3=$this->db->query("SELECT * FROM LZ_BK_ITEM_MT M WHERE M.LZ_BK_ITEM_DESC LIKE '%$query%' OR M.MPN LIKE '%$item_mpn%' ");
		   			if($query3->num_rows() > 0)
		   			{
				   		$this->session->set_flashdata('warning', "Item profile already exist!");
				   		redirect(base_url()."BundleKit/c_bkProfiles");
				   	}else
				   	{
				   		$data['templates']=$this->db->query("SELECT * FROM LZ_BK_ITEM_TYPE_MT")->result_array();
				   		$data['pageTitle'] = 'Search Category';
						$this->load->view("BundleKit/profile/v_searchCats", $data);
				   	}
		   		}	   	
		}
	}
	function  already_saved_data()
	{
		if($this->input->post('submit_query')){
			$query = $this->input->post('item_name');
			$item_upc = $this->input->post('item_upc');
			$item_mpn = $this->input->post('item_mpn');
			$item_template = $this->input->post('item_template');
			//var_dump($item_template, $query, $item_upc, $item_mpn); exit;
			if(empty($item_upc) && empty($item_mpn)){
		   			$query1=$this->db->query("SELECT * FROM LZ_BK_ITEM_MT M WHERE M.LZ_BK_ITEM_DESC LIKE '%$query%'");
		   			if($query1->num_rows() > 0)
		   			{
				   		$this->session->set_flashdata('warning', "Item profile already exist!");
				   		redirect(base_url()."BundleKit/c_bkProfiles");
				   	}else
				   	{
				   		$data['templates']=$this->db->query("SELECT * FROM LZ_BK_ITEM_TYPE_MT")->result_array();
				   		$data['pageTitle'] = 'Search Category';
						$this->load->view("BundleKit/profile/v_bkViewSavedData", $data);
				   	}
		   		}elseif(!empty($item_upc) && !empty($item_mpn)){
		   			$query1=$this->db->query("SELECT * FROM LZ_BK_ITEM_MT M WHERE M.LZ_BK_ITEM_DESC LIKE '%$query%' OR M.UPC LIKE '%$item_upc%' OR M.MPN LIKE '%$item_mpn%'");
		   			if($query1->num_rows() > 0)
		   			{
				   		$this->session->set_flashdata('warning', "Item profile already exist!");
				   		redirect(base_url()."BundleKit/c_bkProfiles");
				   	}else
				   	{
				   		$data['templates']=$this->db->query("SELECT * FROM LZ_BK_ITEM_TYPE_MT")->result_array();
				   		$data['pageTitle'] = 'Search Category';
						$this->load->view("BundleKit/profile/v_bkViewSavedData", $data);
				   	}
		   		}elseif(!empty($item_upc) && empty($item_mpn)){
		   			$query2=$this->db->query("SELECT * FROM LZ_BK_ITEM_MT M WHERE M.LZ_BK_ITEM_DESC LIKE '%$query%' OR M.UPC LIKE '%$item_upc%'");
		   			if($query2->num_rows() > 0)
		   			{
				   		$this->session->set_flashdata('warning', "Item profile already exist!");
				   		redirect(base_url()."BundleKit/c_bkProfiles");
				   	}else
				   	{
				   		$data['templates']=$this->db->query("SELECT * FROM LZ_BK_ITEM_TYPE_MT")->result_array();
				   		$data['pageTitle'] = 'Search Category';
						$this->load->view("BundleKit/profile/v_bkViewSavedData", $data);
				   	}
		   		}elseif(empty($item_upc) && !empty($item_mpn))
		   		{
		   			$query3=$this->db->query("SELECT * FROM LZ_BK_ITEM_MT M WHERE M.LZ_BK_ITEM_DESC LIKE '%$query%' OR M.MPN LIKE '%$item_mpn%' ");
		   			if($query3->num_rows() > 0)
		   			{
				   		$this->session->set_flashdata('warning', "Item profile already exist!");
				   		redirect(base_url()."BundleKit/c_bkProfiles");
				   	}else
				   	{
				   		$data['templates']=$this->db->query("SELECT * FROM LZ_BK_ITEM_TYPE_MT")->result_array();
				   		$data['pageTitle'] = 'Search Category';
						$this->load->view("BundleKit/profile/v_bkViewSavedData", $data);
				   	}
		   		}	   	
		}
	}
	function createProfile()
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
	function profileComponentDeletion($component_id='', $profile_id='')
	{
		$query=$this->db->query("DELETE FROM LZ_BK_ITEM_DET WHERE LZ_BK_ITEM_DET_ID =$component_id");
			if($query)
			{
			  $this->session->set_flashdata('success', "Component is deleted successfully"); 
			}else {
			  $this->session->set_flashdata('error',"Component deletion has Failed");
			} 		  
			redirect(base_url()."BundleKit/c_bkProfiles/ProfileDetail/".$profile_id);
	}
}