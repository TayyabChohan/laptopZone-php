<?php
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
 
class M_bk_kit extends CI_Model {
	
	function bk_kitData()
	{
		return $query=$this->db->query("SELECT * FROM LZ_BK_ITEM_MT")->result_array();
		
	}
	function dataForKitDetail($item_id)
	{
		return $query=$this->db->query("SELECT * FROM LZ_BK_ITEM_DET, LZ_BK_ITEM_MT, LZ_COMPONENT_MT, LZ_BK_ITEM_TYPE_MT, LZ_BK_ITEM_TYPE_DET WHERE LZ_BK_ITEM_TYPE_MT.LZ_BK_ITEM_TYPE_ID=LZ_BK_ITEM_MT.LZ_BK_ITEM_TYPE_ID AND LZ_BK_ITEM_DET.LZ_BK_ITEM_ID=LZ_BK_ITEM_MT.LZ_BK_ITEM_ID AND LZ_BK_ITEM_DET.LZ_COMPONENT_ID=LZ_COMPONENT_MT.LZ_COMPONENT_ID AND LZ_BK_ITEM_TYPE_DET.LZ_BK_ITEM_TYPE_ID=LZ_BK_ITEM_TYPE_MT.LZ_BK_ITEM_TYPE_ID AND LZ_BK_ITEM_TYPE_DET.LZ_COMPONENT_ID=LZ_COMPONENT_MT.LZ_COMPONENT_ID AND LZ_BK_ITEM_MT.LZ_BK_ITEM_ID=$item_id");
	}
	function kitData()
	{
		$componentName =$this->input->post('componentName');
		//var_dump($componentName); exit;
		$itemId=$this->input->post('itemId');
		$titles=$this->input->post('titles');
		$titles = str_replace("  ", ' ', $titles);
		$titles =str_replace("'", "''", $titles);

		$brand=$this->input->post('brand');
		$brand =str_replace("  ", ' ', $brand);
		$brand =str_replace("'", "''", $brand);

		$catId=$this->input->post('catId');
		$CategoryName=$this->input->post('CategoryName');
		$CategoryName = str_replace("  ", ' ', $CategoryName);
		$CategoryName = str_replace("'", "''", $CategoryName);

		$qty=$this->input->post('qty');
		$mpn=$this->input->post('mpn');
		$upc=$this->input->post('upc');
		$activePrice=$this->input->post('activePrice');
		//$activePrice= str_replace("$", '', $activePrice);
		$manualPrice=$this->input->post('manualPrice');
		//$manualPrice=str_replace("$", '', $manualPrice);
		//var_dump($activePrice, $manualPrice); exit;
		$item_id=$this->input->post('item_name');
		$kit_name=$this->input->post('kit_name');
		$kit_name = trim(str_replace("  ", ' ', $kit_name));
		$kit_name = trim(str_replace("'", "''", $kit_name));
		$kit_name= ucfirst($kit_name);
		$kit_keyword=$this->input->post('kit_keyword');
		$kit_keyword= ucfirst($kit_keyword);
		//var_dump($componentName, $itemId, $titles, $brand, $catId, $CategoryName, $qty); exit;
		date_default_timezone_set("America/Chicago");
		$date = date('Y-m-d H:i:s');
		$list_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
		//$remarks=$this->input->post('remarks');
		$qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BK_KIT_MT','LZ_BK_KIT_ID') ID FROM DUAL");
		$rs = $qry->result_array();
		$lz_bk_kit_id= $rs[0]['ID'];
		$kit_query=$this->db->query("INSERT INTO LZ_BK_KIT_MT (LZ_BK_KIT_ID, LZ_BK_ITEM_ID, LZ_BK_KIT_DESC, KIT_KEYWORD,  CREATE_DATE) VALUES($lz_bk_kit_id, $item_id, '$kit_name',  '$kit_keyword', $list_date)");
			if ($kit_query)
			{
				$qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_IND_WEBHOOK','WEBHOOK_ID') ID FROM DUAL");
				$rs = $qry->result_array();
				$webhook_id= $rs[0]['ID'];
				$webhook_query=$this->db->query("INSERT INTO LZ_IND_WEBHOOK (WEBHOOK_ID, KIT_ID) VALUES($webhook_id, $lz_bk_kit_id)");
			}
			if($webhook_query)
				{
					$i=0;         	
					foreach ($componentName as $component)
						{
							$manualPrice=trim(@$manualPrice[$i]);

							$qry = $this->db->query("SELECT get_single_primary_key('LZ_BK_KIT_DET','LZ_BK_KIT_DET_ID') ID FROM DUAL");
	        				$rs = $qry->result_array();
		        			$lz_bk_kit_det_id= $rs[0]['ID'];
          					$kit_det_qry="INSERT INTO LZ_BK_KIT_DET (LZ_BK_KIT_DET_ID, LZ_BK_KIT_ID, LZ_COMPONENT_ID, ITEM_DESC, ITEM_UPC, ITEM_MPN, ITEM_MANUFACTURER, EBAY_ITEM_ID, ACTIVE_PRICE, CATEGORY_ID, CATEGORY_NAME, QUANTITY, MANUAL_PRICE) VALUES($lz_bk_kit_det_id, $lz_bk_kit_id, $component, '$titles[$i]','$upc[$i]', '$mpn[$i]', '$brand[$i]', $itemId[$i], $activePrice[$i], $catId[$i], '$CategoryName[$i]', $qty[$i], '$manualPrice')";
          					//var_dump($qry); exit;
							$q=$this->db->query($kit_det_qry); 
							$i++;
						}	
						if($q)
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
	function updateManualPrice()
	{
		$kit_id=$this->input->post('kit_id');
		//var_dump($kit_id); exit;
		$component_id=$this->input->post('component_id');
		$component_qty=$this->input->post('component_qty');
		$component_qty = str_replace("$", '', $component_qty);
		$i=0;
		foreach ($component_qty as $qty) {	
			
			//var_dump($qty); exit;
			$data=$this->db->query("UPDATE  LZ_BK_KIT_DET SET MANUAL_PRICE=$qty WHERE LZ_BK_KIT_ID =$kit_id AND LZ_COMPONENT_ID=$component_id[$i]");				
			$i++;
		}
		echo json_encode($data);
        return json_encode($data);		
	}
	function updateKitComponents()
	{
		$kit_id=$this->input->post('kit_id');
		$component_id=$this->input->post('component_id');
		$kit_det_id=$this->input->post('kit_det_id');
		//var_dump($component_id, $kit_det_id); exit;
		$i=0;
		foreach ($component_id as $component) {	
			
			//var_dump($qty); exit;
			$data=$this->db->query("UPDATE  LZ_BK_KIT_DET SET LZ_COMPONENT_ID=$component WHERE LZ_BK_KIT_DET_ID=$kit_det_id[$i] AND LZ_BK_KIT_ID =$kit_id");				
			$i++;
		}
		if ($data){
			$this->session->set_flashdata('success',"Data is updated");
			echo json_encode($data);
        	return json_encode($data);
		}
				
	}
	function addkitData()
	{
		$kitid =$this->input->post('kitid');
		$componentName =$this->input->post('componentName');
		$itemId=$this->input->post('itemId');
		$titles=$this->input->post('titles');
		//$titles = str_replace("  ", ' ', $titles);
		//$titles =str_replace("'", "''", $titles);
		$brand=$this->input->post('brand');
		$brand =str_replace("  ", ' ', $brand);
		$brand =str_replace("'", "''", $brand);

		$catId=$this->input->post('catId');
		$CategoryName=$this->input->post('CategoryName');
		$CategoryName = str_replace("  ", ' ', $CategoryName);
		$CategoryName = str_replace("'", "''", $CategoryName);

		$qty=$this->input->post('qty');
		
		$mpn=$this->input->post('mpn');
		$upc=$this->input->post('upc');
		$activePrice=$this->input->post('activePrice');
		//$activePrice= str_replace("$ ", '', $activePrice);
		$manualPrice=$this->input->post('manualPrice');
		//$manualPrice=str_replace("$ ", '', $manualPrice);
		
		$item_id=$this->input->post('item_name');
		$kit_name=$this->input->post('kit_name');
		$kit_name = trim(str_replace("  ", ' ', $kit_name));
		$kit_name = trim(str_replace("'", "''", $kit_name));
		$kit_name= ucfirst($kit_name);
		//var_dump($activePrice); exit;
		//, $itemId, $brand, $mpn, $upc, $activePrice, $manualPrice
		date_default_timezone_set("America/Chicago");
		$date = date('Y-m-d H:i:s');
		$list_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
		$remarks=$this->input->post('remarks');
		$i=0;         	
		foreach ($componentName as $component)
			{
				$manualPrice=trim(@$manualPrice[$i]);

				$qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BK_KIT_DET','LZ_BK_KIT_DET_ID') ID FROM DUAL");
    			$rs = $qry->result_array();
        		$lz_bk_kit_det_id= $rs[0]['ID'];
  				$qry="INSERT INTO LZ_BK_KIT_DET (LZ_BK_KIT_DET_ID, LZ_BK_KIT_ID, LZ_COMPONENT_ID, ITEM_DESC, ITEM_UPC, ITEM_MPN, ITEM_MANUFACTURER, EBAY_ITEM_ID, ACTIVE_PRICE, CATEGORY_ID, CATEGORY_NAME, QUANTITY, MANUAL_PRICE) VALUES($lz_bk_kit_det_id, $kitid, $component, '$titles[$i]','$upc[$i]', '$mpn[$i]', '$brand[$i]', $itemId[$i], $activePrice[$i], $catId[$i], '$CategoryName[$i]', $qty[$i], '$manualPrice')"; 
  				//var_dump($qry); exit;
				$q=$this->db->query($qry); 
				$i++;
			}	
			/*if($q)
				{
			 	 $this->session->set_flashdata('success', "Data is saved successfully"); 
				}else 
				{
		  			$this->session->set_flashdata('error',"Data insertion has Failed");
				} 
				redirect(base_url()."BundleKit/c_bk_kit/showKitDetail/".$kitid);*/
		echo json_encode($q);
        return json_encode($q);	
	}
	function deleteKitComponent($detail_id='', $kit_id='')
	{
		$query=$this->db->query("DELETE FROM LZ_BK_KIT_DET WHERE LZ_BK_KIT_DET_ID =$detail_id");
		if($query)
		{
		  $this->session->set_flashdata('success', "Component is deleted successfully"); 
		}else
		{
		  $this->session->set_flashdata('error',"Component deletion has Failed");
		} 		  
		redirect(base_url()."BundleKit/c_bk_kit/showKitDetail/".$kit_id);
	}
	function deleteKitData($kit_id='')
	{
		$query=$this->db->query("DELETE FROM LZ_BK_KIT_DET WHERE LZ_BK_KIT_ID =$kit_id");
			if($query)
			{
				$query=$this->db->query("DELETE FROM  LZ_BK_KIT_MT where LZ_BK_KIT_ID=$kit_id");
				if($query)
				{
				  $this->session->set_flashdata('success', "Kit is deleted successfully"); 
				}else {
				  $this->session->set_flashdata('error',"Kit deletion has Failed");
				} 		  
				redirect(base_url()."BundleKit/c_bk_kit");
			}
	}
	function kitDetail($kit_id='', $template_id='')
	{
		$kit_detail=$this->db->query("SELECT * FROM LZ_BK_KIT_DET, LZ_BK_KIT_MT, LZ_COMPONENT_MT, LZ_BK_ITEM_MT WHERE LZ_BK_KIT_DET.LZ_BK_KIT_ID=LZ_BK_KIT_MT.LZ_BK_KIT_ID AND LZ_BK_KIT_DET.LZ_COMPONENT_ID=LZ_COMPONENT_MT.LZ_COMPONENT_ID AND LZ_BK_KIT_MT.LZ_BK_ITEM_ID=LZ_BK_ITEM_MT.LZ_BK_ITEM_ID AND LZ_BK_KIT_MT.LZ_BK_KIT_ID=$kit_id");
		//echo "<pre>";
		//print_r($kit_detail->result_array());
		//exit;
		$kit_components=$this->db->query("SELECT * FROM LZ_BK_ITEM_TYPE_DET, LZ_COMPONENT_MT WHERE LZ_BK_ITEM_TYPE_DET.LZ_COMPONENT_ID=LZ_COMPONENT_MT.LZ_COMPONENT_ID AND LZ_BK_ITEM_TYPE_DET.LZ_BK_ITEM_TYPE_ID=$template_id");
		//echo "<pre>";
		//print_r($kit_components->result_array());
		//exit;
		return array
		(
			'kit_detail'=>$kit_detail,
			'kit_components'=>$kit_components
		);
	}
	function addComponents()
	{
		$kit_id =$this->input->post('kit_id');
		$template_id=$this->input->post('template_id');
		$new_component=ucfirst($this->input->post('new_component'));
		  $query = $this->db->query("SELECT LZ_COMPONENT_DESC FROM LZ_COMPONENT_MT WHERE LZ_COMPONENT_DESC = '$new_component'");
		    if($query->num_rows() >0){
		        $this->session->set_flashdata('warning',"Component has already exist");
		        redirect(site_url()."BundleKit/c_bkComponents");
		    }else{
				$qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_COMPONENT_MT','LZ_COMPONENT_ID') ID FROM DUAL");
		        $rs = $qry->result_array();
		        $lz_component_id= $rs[0]['ID']; 
				$insert_qry=$this->db->query("INSERT INTO LZ_COMPONENT_MT (LZ_COMPONENT_ID, LZ_COMPONENT_DESC) VALUES($lz_component_id, '$new_component')");
				//$insert_id = $insert_qry->db->insert_id();
				//var_dump($insert_id); die;
				if ($insert_qry){
					if(!empty($template_id) && $template_id!=='')
						{
							$qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BK_ITEM_TYPE_DET','LZ_BK_ITEM_TYPE_DET_ID') ID FROM DUAL");
		        			$rs = $qry->result_array();
		        			$lz_bk_item_type_det_id= $rs[0]['ID']; 
							$template_data=$this->db->query("INSERT INTO LZ_BK_ITEM_TYPE_DET (LZ_BK_ITEM_TYPE_DET_ID, LZ_BK_ITEM_TYPE_ID, LZ_COMPONENT_ID) VALUES($lz_bk_item_type_det_id, $template_id, $lz_component_id)");
								if($template_data)
								{
									 $this->session->set_flashdata('success', "Component created Successfully"); 
								}else
								{
									$this->session->set_flashdata('error',"Component creation Failed");
								}
							echo json_encode($template_data);
        					return json_encode($template_data);
						}
					}						
			}
	}

}