<?php
class c_CreateComponent extends CI_Controller
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
		$data['pageTitle'] = 'Components';
		$data['components']=$this->m_bundlekit->getAllComponents();
		$this->load->view("BundleKit/v_ItemComponents", $data);
		
	}
	function addComponent()

	{
		$this->form_validation->set_rules('component_name', 'component name', 'trim|required');

		if($this->form_validation->run()==FALSE)
		{
			echo validation_errors();
			exit;
		}else {
			$lz_component_desc=ucfirst($this->input->post('component_name'));
			  $query = $this->db->query("SELECT lz_component_desc from lz_component_mt WHERE lz_component_desc = '$lz_component_desc'");
			    if($query->num_rows() >0){
			        $this->session->set_flashdata('warning',"Component has already exist");
			        redirect(site_url()."BundleKit/c_CreateComponent");
			    }else{
					$qry = $this->db->query("SELECT get_single_primary_key('lz_component_mt','lz_component_id') ID FROM DUAL");
			        $rs = $qry->result_array();
			        $lz_component_id= $rs[0]['ID']; 
					$result=$this->m_bundlekit->insertComponent($lz_component_id, $lz_component_desc);
					if($result)
						{
							 $this->session->set_flashdata('success', "Component created Successfully"); 
						}else {
							$this->session->set_flashdata('error',"Component creation Failed");
						}			
    			}	
			}
			redirect(site_url()."BundleKit/c_CreateComponent");
}

function getAllData()
{
	$data['categories']=$this->db->query("SELECT * FROM LZ_BK_TEMP");
 	$this->load->view("BundleKit/v_show_master_data", $data);
}
function createTemplate()
{
	$data['components']=$this->m_bundlekit->getAllComponents();
	$data['templates']=$this->m_bundlekit->getAllTemplates();
	$data['pageTitle'] = 'Templates';
	$this->load->view("BundleKit/v_NewTemplate", $data);
}
function addTemplate()
{
	//$result=$this->m_bundlekit->insertTemplateName();
	$this->form_validation->set_rules('component_list[]', 'component', 'trim|required');
	$this->form_validation->set_rules('template_name', 'template name', 'trim|required');

		if($this->form_validation->run()==FALSE)
		{
			$this->session->set_flashdata('compo',"Empty template name OR Not choosen any component");
            redirect(site_url()."BundleKit/c_CreateComponent/createTemplate");
		}else {
				  $template_name = $this->input->post('template_name');
		          $template_name = trim(str_replace("  ", ' ', $template_name));
		          $template_name = trim(str_replace("'", "''", $template_name));
		          $template_name = ucfirst($template_name);
		          //var_dump($template_name);exit;

			      $query = $this->db->query("SELECT item_type_desc FROM lz_bk_item_type_mt WHERE item_type_desc = '$template_name'"); 
			      if($query->num_rows() >0){
			           $this->session->set_flashdata('warning',"Template has already exist");
			           redirect(site_url()."BundleKit/c_CreateComponent/createTemplate");
			     
			      }else{
			  		$qry = $this->db->query("SELECT get_single_primary_key('lz_bk_item_type_mt','lz_bk_item_type_id') ID FROM DUAL");
			        $rs = $qry->result_array();
			        $lz_bk_item_type_id= $rs[0]['ID'];
			        $query=$this->db->query("INSERT INTO lz_bk_item_type_mt (lz_bk_item_type_id, item_type_desc) VALUES($lz_bk_item_type_id, '$template_name')");
			           
			          foreach($this->input->post('component_list') as $selected){
			            if(!empty($selected)){
			              $query = $this->db->query("SELECT get_single_primary_key('lz_bk_item_type_det','lz_bk_item_type_det_id') ID FROM DUAL");
			              $rs = $query->result_array();
			              $lz_bk_item_type_det_id = @$rs[0]['ID'];
			              $query=$this->db->query("INSERT INTO lz_bk_item_type_det (lz_bk_item_type_det_id, lz_bk_item_type_id, lz_component_id) VALUES($lz_bk_item_type_det_id, '$lz_bk_item_type_id', '$selected')");
			            } //foreach if
			          }//end foreach
			          if($query)
						{
							 $this->session->set_flashdata('success', "Template created Successfully"); 
						}else {
							$this->session->set_flashdata('error',"Template creation Failed");
						} 		  
							redirect(site_url()."BundleKit/c_CreateComponent/createTemplate");
		        }
	}//main if end
}
function showTemplateDetail($template_id='')
{
	$template_id=$template_id;
	if(!empty($template_id) && $template_id!==''){
		$data['records']=$this->db->query("select type_mt.*, type_dt.*, comp.*
  from lz_bk_item_type_mt type_mt,
       lz_bk_item_type_det type_dt,
       lz_component_mt comp
 where type_mt.lz_bk_item_type_id = type_dt.lz_bk_item_type_id
   and comp.lz_component_id = type_dt.lz_component_id and type_mt.lz_bk_item_type_id=$template_id")->result_array();
		/*echo "<pre>";
		print_r($data['records']);
		exit;*/
		$data['pageTitle'] = 'Template Detail';
		$this->load->view("BundleKit/v_finalTemplateView", $data);	
	}
	//$result=$this->m_bundlekit->createFinalTemplate();
		  
	//redirect(site_url()."BundleKit/c_CreateComponent/v_finalTemplateView");
}
function editTemplateDetail($template_id='')
{
	if(!empty($template_id) && $template_id!==''){
		$data['records']=$this->db->query("SELECT TYPE_MT.*, TYPE_DT.*, COMP.* FROM LZ_BK_ITEM_TYPE_MT TYPE_MT, LZ_BK_ITEM_TYPE_DET TYPE_DT, LZ_COMPONENT_MT COMP WHERE TYPE_MT.LZ_BK_ITEM_TYPE_ID = TYPE_DT.LZ_BK_ITEM_TYPE_ID AND COMP.LZ_COMPONENT_ID = TYPE_DT.LZ_COMPONENT_ID AND TYPE_MT.LZ_BK_ITEM_TYPE_ID=$template_id")->result_array(); 
		/*echo "<pre>";
		print_r($data['records']);
		exit;*/
		$data['pageTitle'] = 'Edit Components';
		$this->load->view("BundleKit/v_bk_editComponents", $data);	
	}
}
function templateDelete($template_id='')
{
	$query1 = $this->db->query("SELECT * FROM LZ_BK_ITEM_MT WHERE LZ_BK_ITEM_TYPE_ID = $template_id");
	    if($query1->num_rows() >0){
	        $this->session->set_flashdata('warning',"This template has used in profile. So first DELETE its profile/s");
	        redirect(site_url()."BundleKit/c_CreateComponent/createTemplate");
	    }else{
	    	$query2=$this->db->query("DELETE FROM lz_bk_item_type_det WHERE lz_bk_item_type_id =$template_id");
				if($query2)
				{
					$query3=$this->db->query("delete from lz_bk_item_type_mt where lz_bk_item_type_id=$template_id");
					if($query3)
					{
					  $this->session->set_flashdata('success', "Template deleted successfully"); 
					}else {
					  $this->session->set_flashdata('error',"Template deletion Failed");
					} 		  
					redirect(site_url()."BundleKit/c_CreateComponent/createTemplate");
				}
	    }	
}
function componentDelete($component_id='')
{
	$query1 = $this->db->query("SELECT * FROM LZ_BK_KIT_DET WHERE LZ_COMPONENT_ID = $component_id");
	$query2 = $this->db->query("SELECT * FROM LZ_BK_ITEM_DET WHERE LZ_COMPONENT_ID = $component_id");
	$query3 = $this->db->query("SELECT * FROM LZ_BK_ITEM_TYPE_DET WHERE LZ_COMPONENT_ID = $component_id");
			    if($query1->num_rows() >0){
			        $this->session->set_flashdata('warning',"This component has assigned in kit/s. First DELETE it from its kit/s");
			        redirect(site_url()."BundleKit/c_CreateComponent");
			    }elseif($query2->num_rows() >0)
			    { 
			    	 $this->session->set_flashdata('warning',"This component has assigned in profile/s. First DELETE it from its profile/s");
			        redirect(site_url()."BundleKit/c_CreateComponent");
			    }elseif($query3->num_rows() >0)
			    { 
			    	 $this->session->set_flashdata('warning',"This component has assigned in template/s. First DELETE it from its template/s");
			        redirect(site_url()."BundleKit/c_CreateComponent");
			    }else
			    { 
			    	$query=$this->db->query("DELETE FROM LZ_COMPONENT_MT WHERE LZ_COMPONENT_ID =$component_id");
						if($query)
						{
						  $this->session->set_flashdata('success', "Component deleted successfully"); 
						}else {
						  $this->session->set_flashdata('error',"Component deletion Failed");
						} 		  
						redirect(site_url()."BundleKit/c_CreateComponent");
			    }
	
	
}
function bktForUpdation($template_id='')
{
	$template_id=$template_id;
	if(!empty($template_id) && $template_id!==''){
		$data['components']=$this->m_bundlekit->getAllComponents();
		$data['details']=$this->m_bundlekit->getDetailById($template_id);

		/*echo "<pre>";
		print_r($data['details']);
		exit;*/
		$data['pageTitle'] = 'Update Template';
		$this->load->view("BundleKit/v_bk_updateTemplate", $data);	
	}
}
function showComponent($component_id='')
{
	$component_id=$component_id;
	if(!empty($component_id) && $component_id!==''){
		$data['component']=$this->m_bundlekit->getComponentById($component_id);
		$data['pageTitle'] = 'Add Components';
		$this->load->view("BundleKit/v_bk_componentUpdate", $data);
			
	}
}
function bkUpdateComponent($component_id='')
{
	$component_id=$component_id;
	if(!empty($component_id) && $component_id!==''){
		$this->form_validation->set_rules('component_name', 'component name', 'trim|required');

		if($this->form_validation->run()==FALSE)
		{
			$this->session->set_flashdata('compo',"Component name is required!");
            redirect(site_url()."BundleKit/c_CreateComponent/createTemplate");
		}else {
			$component_name=$this->input->post('component_name');
			$query=$this->db->query("UPDATE  lz_component_mt SET lz_component_desc='$component_name' WHERE lz_component_id =$component_id");
			if($query)
					{
						$this->session->set_flashdata('success', "Component updated Successfully"); 
					}else {
						$this->session->set_flashdata('error',"Component updation Failed");
					}
		}
			
	}
	redirect(site_url()."BundleKit/c_CreateComponent/");
}
function updateTemplate($template_id='')
{
		if($this->input->post('update_template'))
		{
           	foreach($this->input->post('check_list') as $selected)
           	{
           		$query1=$this->db->query("SELECT * FROM LZ_BK_ITEM_TYPE_DET WHERE LZ_COMPONENT_ID =$selected");

           		$query2 = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BK_ITEM_TYPE_DET','LZ_BK_ITEM_TYPE_DET_ID') ID FROM DUAL"); 
              	$rs = $query2->result_array();
              	$lz_bk_item_type_det_id = @$rs[0]['ID'];
		           	if($query1->num_rows() > 0)
		           		{
		   
		           		}else{
		           		  $q4=$this->db->query("INSERT INTO LZ_BK_ITEM_TYPE_DET (LZ_BK_ITEM_TYPE_DET_ID, LZ_BK_ITEM_TYPE_ID, LZ_COMPONENT_ID) VALUES($lz_bk_item_type_det_id, $template_id, $selected)");	              	
		           		}     
          }
           if($q3 || $q4)
			{
				$this->session->set_flashdata('success', "Template updated Successfully");	 
			} 		  
				redirect(base_url()."BundleKit/c_CreateComponent/createTemplate");		        
			}else{
					$this->session->set_flashdata('error',"Template updation has Failed");
					redirect(base_url()."BundleKit/c_CreateComponent/createTemplate");	
				}//main if end
	
	
}
function bk_deleteTempComponent($detail_id='', $template_id="")
{
			    	$query2=$this->db->query("DELETE FROM LZ_BK_ITEM_TYPE_DET WHERE LZ_BK_ITEM_TYPE_DET_ID=$detail_id");
						if($query2)
						{
						  $this->session->set_flashdata('success', "Component deleted successfully"); 
						}else {
						  $this->session->set_flashdata('error',"Component deletion Failed");
						} 		  
						redirect(site_url()."BundleKit/c_CreateComponent/editTemplateDetail/".$template_id);
		
}
function bk_edit_quantity()
	{
		$template_id=$this->input->post('template_id');
		$component_id=$this->input->post('component_id');
		$i=0;
		foreach ($this->input->post('component_qty') as $qty) {				
			$data=$this->db->query("UPDATE lz_bk_item_type_det SET QUANTITY=$qty WHERE lz_bk_item_type_id=$template_id AND lz_component_id=$component_id[$i]");				
			$i++;
		}
		echo json_encode($data);
        return json_encode($data);		
	}

}