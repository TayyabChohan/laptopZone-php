<?php
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
class M_bkTemplate extends CI_Model
{
	function getAllComponents()
	{
		return $query=$this->db->query("SELECT * FROM LZ_COMPONENT_MT ORDER BY LZ_COMPONENT_ID DESC");		
	}
	function getAllTemplates()
	{
		return $query=$this->db->query("SELECT * FROM LZ_BK_ITEM_TYPE_MT ORDER BY LZ_BK_ITEM_TYPE_ID DESC");		
	}
	function bk_addTemplate()
	{
		$this->form_validation->set_rules('component_list[]', 'component', 'trim|required');
		$this->form_validation->set_rules('template_name', 'template name', 'trim|required');
		if($this->form_validation->run()==FALSE)
		{
			$this->session->set_flashdata('compo',"Empty template name OR Not choosen any component");
        	redirect(site_url()."BundleKit/c_bkTemplate");
		}else
		{
			$template_name = $this->input->post('template_name');
	        $template_name = trim(str_replace("  ", ' ', $template_name));
	        $template_name = trim(str_replace("'", "''", $template_name));
	        $template_name = ucfirst($template_name);

		    $query = $this->db->query("SELECT ITEM_TYPE_DESC FROM LZ_BK_ITEM_TYPE_MT WHERE ITEM_TYPE_DESC = '$template_name'"); 
	      	if($query->num_rows() >0){
	           $this->session->set_flashdata('warning',"Template already exist");
	           redirect(site_url()."BundleKit/c_bkTemplate");
      		}else
      		{
  				$qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BK_ITEM_TYPE_MT','LZ_BK_ITEM_TYPE_ID') ID FROM DUAL");
        		$rs = $qry->result_array();
        		$lz_bk_item_type_id= $rs[0]['ID'];
        		$templateName=$this->db->query("INSERT INTO LZ_BK_ITEM_TYPE_MT (LZ_BK_ITEM_TYPE_ID, ITEM_TYPE_DESC) VALUES($lz_bk_item_type_id, '$template_name')");
           
          		foreach($this->input->post('component_list') as $selected)
          		{
            		if(!empty($selected))
            		{

              			$auto = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BK_ITEM_TYPE_DET','LZ_BK_ITEM_TYPE_DET_ID') ID FROM DUAL");
              			$rs = $auto->result_array();
              			$lz_bk_item_type_det_id = @$rs[0]['ID'];
              			$detail=$this->db->query("INSERT INTO LZ_BK_ITEM_TYPE_DET (LZ_BK_ITEM_TYPE_DET_ID, LZ_BK_ITEM_TYPE_ID, LZ_COMPONENT_ID) VALUES($lz_bk_item_type_det_id, '$lz_bk_item_type_id', '$selected')");
            		} //foreach if
          		}//end foreach
          		if($detail)
					{
				 		$this->session->set_flashdata('success', "Template created Successfully"); 
					}else
					{
						$this->session->set_flashdata('error',"Template creation Failed");
					} 		  
						redirect(site_url()."BundleKit/c_bkTemplate");
        		}
		} //main if end
	}
	function bk_templateDetail($template_id='')
	{
		if(!empty($template_id) && $template_id!==''){
				$data['records']=$this->db->query("SELECT TYPE_MT.*, TYPE_DT.*, COMP.* FROM LZ_BK_ITEM_TYPE_MT TYPE_MT, LZ_BK_ITEM_TYPE_DET TYPE_DT, LZ_COMPONENT_MT COMP WHERE TYPE_MT.LZ_BK_ITEM_TYPE_ID = TYPE_DT.LZ_BK_ITEM_TYPE_ID AND COMP.LZ_COMPONENT_ID = TYPE_DT.LZ_COMPONENT_ID AND TYPE_MT.LZ_BK_ITEM_TYPE_ID=$template_id")->result_array();
				$data['pageTitle'] = 'Template Detail';
				$this->load->view("BundleKit/template/v_bkTemplateDetail", $data);	
		}
	}
	function bk_editTemplate($template_id='')
	{
		if(!empty($template_id) && $template_id!=='')
		{
		$data['records']=$this->db->query("SELECT TYPE_MT.*, TYPE_DT.*, COMP.* FROM LZ_BK_ITEM_TYPE_MT TYPE_MT, LZ_BK_ITEM_TYPE_DET TYPE_DT, LZ_COMPONENT_MT COMP WHERE TYPE_MT.LZ_BK_ITEM_TYPE_ID = TYPE_DT.LZ_BK_ITEM_TYPE_ID AND COMP.LZ_COMPONENT_ID = TYPE_DT.LZ_COMPONENT_ID AND TYPE_MT.LZ_BK_ITEM_TYPE_ID=$template_id")->result_array();
		$data['pageTitle'] = 'Edit Components';
		$this->load->view("BundleKit/template/v_bkTemplateEditQty", $data);	
		}
	}
	function bk_deleteComponent($component_id='')
	{
		$query1 = $this->db->query("SELECT * FROM LZ_BK_KIT_DET WHERE LZ_COMPONENT_ID = $component_id");
		$query2 = $this->db->query("SELECT * FROM LZ_BK_ITEM_DET WHERE LZ_COMPONENT_ID = $component_id");
		$query3 = $this->db->query("SELECT * FROM LZ_BK_ITEM_TYPE_DET WHERE LZ_COMPONENT_ID = $component_id");
		    if($query1->num_rows() >0)
		    {
		        $this->session->set_flashdata('warning',"This component has assigned in kit/s. First DELETE it from its kit/s");
		        redirect(site_url()."BundleKit/c_bkTemplate");
		    }elseif($query2->num_rows() >0)
		    { 
		    	 $this->session->set_flashdata('warning',"This component has assigned in profile/s. First DELETE it from its profile/s");
		        redirect(site_url()."BundleKit/c_bkTemplate");
		    }elseif($query3->num_rows() >0)
		    { 
		    	 $this->session->set_flashdata('warning',"This component has assigned in template/s. First DELETE it from its template/s");
		        redirect(site_url()."BundleKit/c_bkTemplate");
		    }else
		    { 
		    	$query=$this->db->query("DELETE FROM LZ_COMPONENT_MT WHERE LZ_COMPONENT_ID =$component_id");
					if($query)
					{
					  $this->session->set_flashdata('success', "Component deleted successfully"); 
					}else {
					  $this->session->set_flashdata('error',"Component deletion Failed");
					} 		  
					redirect(site_url()."BundleKit/c_bkTemplate");
		    }
	}
	function getDetailById($template_id)
	{
		return $query=$this->db->query("SELECT D.*, M.ITEM_TYPE_DESC FROM LZ_BK_ITEM_TYPE_DET D,LZ_BK_ITEM_TYPE_MT M WHERE D.LZ_BK_ITEM_TYPE_ID = M.LZ_BK_ITEM_TYPE_ID AND D.LZ_BK_ITEM_TYPE_ID =$template_id")->result_array();
	}
	function bk_deleteTemplate($template_id='')
	{
		$query1 = $this->db->query("SELECT * FROM LZ_BK_ITEM_MT WHERE LZ_BK_ITEM_TYPE_ID = $template_id");
	    if($query1->num_rows() >0){
	        $this->session->set_flashdata('warning',"This template has used in profile. So first DELETE its profile/s");
	        redirect(site_url()."BundleKit/c_bkTemplate");
	    }else{
		    	$query2=$this->db->query("DELETE FROM LZ_BK_ITEM_TYPE_DET WHERE LZ_BK_ITEM_TYPE_ID =$template_id");
				if($query2)
				{
					$query3=$this->db->query("DELETE FROM LZ_BK_ITEM_TYPE_MT WHERE LZ_BK_ITEM_TYPE_ID=$template_id");
					if($query3)
					{
					  $this->session->set_flashdata('success', "Template deleted successfully"); 
					}else {
					  $this->session->set_flashdata('error',"Template deletion Failed");
					} 		  
					redirect(site_url()."BundleKit/c_bkTemplate");
				}
	    }
	}
	function bk_UpdateTemplate($template_id='')
	{
		if($this->input->post('update_template'))
		{
           	foreach($this->input->post('check_list') as $selected)
           	{
           		$checkComponent=$this->db->query("SELECT * FROM LZ_BK_ITEM_TYPE_DET WHERE LZ_COMPONENT_ID =$selected AND LZ_BK_ITEM_TYPE_ID=$template_id");
           		$autoInc = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BK_ITEM_TYPE_DET','LZ_BK_ITEM_TYPE_DET_ID') ID FROM DUAL"); 
              	$rs = $autoInc->result_array();
              	$lz_bk_item_type_det_id = @$rs[0]['ID'];
		           	if($checkComponent->num_rows() > 0)
		           		{
		           			
		           		}else{
		           		  $insertData=$this->db->query("INSERT INTO LZ_BK_ITEM_TYPE_DET (LZ_BK_ITEM_TYPE_DET_ID, LZ_BK_ITEM_TYPE_ID, LZ_COMPONENT_ID) VALUES($lz_bk_item_type_det_id, $template_id, $selected)");
		           		 
		           		}
	           				  
          		}
          		 if($insertData)
						{
							$this->session->set_flashdata('success', "Template updated Successfully");	 
						} 
          		redirect(base_url()."BundleKit/c_bkTemplate/showTemplateDetail/".$template_id);		        
			}else
			{
				$this->session->set_flashdata('error',"Template updation has Failed");
				redirect(base_url()."BundleKit/c_bkTemplate/addMoreComponents".$template_id);	
			}//main if end
	}
	function bk_deleteComponentOfTemplate($detail_id='', $template_id="")
	{
		$query2=$this->db->query("DELETE FROM LZ_BK_ITEM_TYPE_DET WHERE LZ_BK_ITEM_TYPE_DET_ID=$detail_id");
			if($query2)
			{
			  $this->session->set_flashdata('success', "Component deleted successfully"); 
			}else {
			  $this->session->set_flashdata('error',"Component deletion Failed");
			} 		  
			redirect(site_url()."BundleKit/c_bkTemplate/editTemplateDetail/".$template_id);
	}
	function bk_editTemplateComponentsQuantity()
	{
		$template_id=$this->input->post('template_id');
		$component_id=$this->input->post('component_id');
		$i=0;
		foreach ($this->input->post('component_qty') as $qty)
		{				
			$data=$this->db->query("UPDATE LZ_BK_ITEM_TYPE_DET SET QUANTITY=$qty WHERE LZ_BK_ITEM_TYPE_ID=$template_id AND LZ_COMPONENT_ID=$component_id[$i]");
			$i++;
		}
		echo json_encode($data);
	    return json_encode($data);
	}
}