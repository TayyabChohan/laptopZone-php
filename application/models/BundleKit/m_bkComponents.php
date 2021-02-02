<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');
class M_bkComponents extends CI_Model
{
	function bk_addCompnent()
	{
		$this->form_validation->set_rules('component_name', 'component name', 'trim|required');
		if($this->form_validation->run()==FALSE)
		{
			echo validation_errors();
			exit;
		}else {
			$lz_component_desc=ucfirst($this->input->post('component_name'));
			  $query = $this->db->query("SELECT LZ_COMPONENT_DESC FROM LZ_COMPONENT_MT WHERE LZ_COMPONENT_DESC = '$lz_component_desc'");
			    if($query->num_rows() >0){
			        $this->session->set_flashdata('warning',"Component has already exist");
			        redirect(site_url()."BundleKit/c_bkComponents");
			    }else{
					$qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_COMPONENT_MT','LZ_COMPONENT_ID') ID FROM DUAL");
			        $rs = $qry->result_array();
			        $lz_component_id= $rs[0]['ID']; 
					$insert_qry=$this->db->query("INSERT INTO LZ_COMPONENT_MT (LZ_COMPONENT_ID, LZ_COMPONENT_DESC) VALUES($lz_component_id, '$lz_component_desc')");
					if($insert_qry)
						{
							 $this->session->set_flashdata('success', "Component created Successfully"); 
						}else {
							$this->session->set_flashdata('error',"Component creation Failed");
						}			
    			}	
			}
		redirect(site_url()."BundleKit/c_bkComponents");
	}
	function getAllComponents()
	{
		return $query=$this->db->query("SELECT * FROM LZ_COMPONENT_MT ORDER BY LZ_COMPONENT_ID DESC");
		
	}
	function getComponentById($component_id)
	{
		return $query=$this->db->query("SELECT * FROM LZ_COMPONENT_MT WHERE LZ_COMPONENT_ID=$component_id")->result_array();		
	}

	function bk_deleteComponent($component_id='')
	{
		$query1 = $this->db->query("SELECT * FROM LZ_BK_KIT_DET WHERE LZ_COMPONENT_ID = $component_id");
		$query2 = $this->db->query("SELECT * FROM LZ_BK_ITEM_DET WHERE LZ_COMPONENT_ID = $component_id");
		$query3 = $this->db->query("SELECT * FROM LZ_BK_ITEM_TYPE_DET WHERE LZ_COMPONENT_ID = $component_id");
		$query4 = $this->db->query("SELECT * FROM LZ_SERV_RECEIPT_DET WHERE COMPONENT_ID = $component_id");
		    if($query1->num_rows() >0 || $query2->num_rows() >0 || $query3->num_rows() >0 || $query4->num_rows() >0){
		        $this->session->set_flashdata('warning',"This component has assigned in kit/s. First DELETE it from its kit/s");
		        redirect(site_url()."BundleKit/c_bkComponents");
		    }else
		    { 
		    	$query=$this->db->query("DELETE FROM LZ_COMPONENT_MT WHERE LZ_COMPONENT_ID =$component_id");
					if($query)
					{
					  $this->session->set_flashdata('success', "Component deleted successfully"); 
					}else {
					  $this->session->set_flashdata('error',"Component deletion Failed");
					} 		  
					redirect(site_url()."BundleKit/c_bkComponents");
		    }
	}
	function bk_UpdateComponent($component_id='')
	{
		if(!empty($component_id) && $component_id!=='')
		{
		$this->form_validation->set_rules('component_name', 'component name', 'trim|required');

		if($this->form_validation->run()==FALSE)
		{
			$this->session->set_flashdata('compo',"Component name is required!");
            redirect(site_url()."BundleKit/c_bkComponents");
		}else {
			$component_name=$this->input->post('component_name');
			$query=$this->db->query("UPDATE  LZ_COMPONENT_MT SET LZ_COMPONENT_DESC='$component_name' WHERE LZ_COMPONENT_ID =$component_id");
			if($query)
					{
						$this->session->set_flashdata('success', "Component updated Successfully"); 
					}else {
						$this->session->set_flashdata('error',"Component updation Failed");
					}
				}
			
		}
			redirect(site_url()."BundleKit/c_bkComponents");
	}
	
	
}