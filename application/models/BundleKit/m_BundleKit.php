<?php
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
 
class M_BundleKit extends CI_Model {
	function insertComponent($lz_component_id, $lz_component_desc)
	{
		$query=$this->db->query("INSERT INTO LZ_COMPONENT_MT (LZ_COMPONENT_ID, LZ_COMPONENT_DESC) VALUES($lz_component_id, '$lz_component_desc')");
		if($query)
		{
			return true;
		}else {
			return false;
		}
	}
	function insertTemplateName()
	{
		if($this->input->post('submit_template')){

      
      		if(!empty($this->input->post('component_list'))){

 			//var_dump($this->input->post('component_list')); exit;
	          $template_name = $this->input->post('template_name');
	          $template_name = trim(str_replace("  ", ' ', $template_name));
	          $template_name = trim(str_replace("'", "''", $template_name));
	          $template_name = ucfirst($template_name);
          	//var_dump($template_name);exit;

		      $query = $this->db->query("SELECT ITEM_TYPE_DESC FROM LZ_BK_ITEM_TYPE_MT WHERE ITEM_TYPE_DESC = '$template_name'");
		       if($query->num_rows() >0){
		           $this->session->set_flashdata('warning',"Template has already exist");
		           redirect(site_url()."BundleKit/c_CreateComponent/createTemplate");   
		      }else{
		  		$qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BK_ITEM_TYPE_MT','LZ_BK_ITEM_TYPE_ID') ID FROM DUAL");
		        $rs = $qry->result_array();
		        $lz_bk_item_type_id= $rs[0]['ID'];
		        $query=$this->db->query("INSERT INTO LZ_BK_ITEM_TYPE_MT (LZ_BK_ITEM_TYPE_ID, ITEM_TYPE_DESC) VALUES($lz_bk_item_type_id, '$template_name')");
		          foreach($this->input->post('component_list') as $selected){
		            if(!empty($selected)){
		              $query = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BK_ITEM_TYPE_DET','LZ_BK_ITEM_TYPE_DET_ID') ID FROM DUAL");
		              $rs = $query->result_array();
		              $lz_bk_item_type_det_id = @$rs[0]['ID'];
		              $data = array(
		                'LZ_BK_ITEM_TYPE_DET_ID' =>$lz_bk_item_type_det_id,
		                'LZ_BK_ITEM_TYPE_ID' =>$lz_bk_item_type_id,
		                'LZ_COMPONENT_ID' =>$selected );
		              $query=$this->db->query("INSERT INTO LZ_BK_ITEM_TYPE_DET (LZ_BK_ITEM_TYPE_DET_ID, LZ_BK_ITEM_TYPE_ID, LZ_COMPONENT_ID) VALUES($lz_bk_item_type_det_id, '$lz_bk_item_type_id', '$selected')"); 
		              //$this->db->insert('lz_bk_item_type_det', $data);
		            }
		          } //end foreach
			         return true;
        		} //end if checklist name check  
      		} //end checklist if

    	} //else{echo "ELSE";}//end main if
	}	
	function getTemplateById($template_id)
	{
		return $query=$this->db->query("SELECT * FROM LZ_BK_ITEM_TYPE_MT WHERE LZ_BK_ITEM_TYPE_ID=$template_id")->result_array();
	}
	
	function bk_kitData()
	{
		return $query=$this->db->query("SELECT * FROM LZ_BK_ITEM_MT")->result_array();		
	}
	function dataForKitDetail()
	{
		$item_id=$this->input->post('bk_kit_item');
		return $query=$this->db->query("SELECT * FROM LZ_BK_ITEM_DET, LZ_BK_ITEM_MT, LZ_COMPONENT_MT, LZ_BK_ITEM_TYPE_MT, LZ_BK_ITEM_TYPE_DET WHERE LZ_BK_ITEM_TYPE_MT.LZ_BK_ITEM_TYPE_ID=LZ_BK_ITEM_MT.LZ_BK_ITEM_TYPE_ID 
AND LZ_BK_ITEM_DET.LZ_BK_ITEM_ID=LZ_BK_ITEM_MT.LZ_BK_ITEM_ID 
AND LZ_BK_ITEM_DET.LZ_COMPONENT_ID=LZ_COMPONENT_MT.LZ_COMPONENT_ID 
AND LZ_BK_ITEM_TYPE_DET.LZ_BK_ITEM_TYPE_ID=LZ_BK_ITEM_TYPE_MT.LZ_BK_ITEM_TYPE_ID
AND LZ_BK_ITEM_TYPE_DET.LZ_COMPONENT_ID=LZ_COMPONENT_MT.LZ_COMPONENT_ID
AND LZ_BK_ITEM_MT.LZ_BK_ITEM_ID=$ITEM_ID");
		
	}
}