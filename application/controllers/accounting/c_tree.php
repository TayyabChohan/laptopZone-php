<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class C_Tree extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->database();
			
		$this->load->model('accounting/m_tree');

	}

	public function tree_list(){
		// $struc_id=$this->input->post('struc_id');
		// $segment_no=$this->input->post('segment_no');
		// $dependent_on=$this->input->post('dependent_on');
		// $qualifier_id=$this->input->post('qualifier_id');
		// $has_dep_val=$this->input->post('has_dep_val');

		$struc_id = $this->uri->segment(4);
        $segment_no = $this->uri->segment(5); 
        $dependent_on = $this->uri->segment(6); 
        $qualifier_id = $this->uri->segment(7);
        $has_dep_val = $this->uri->segment(8);

		$segment_val_session = array('struc_id'  => $struc_id,
						'segment_no'  => $segment_no,
						'dependent_on'  => $dependent_on,
						'qualifier_id'  => $qualifier_id,
						'has_dep_val' => $has_dep_val);
 		$this->session->set_userdata($segment_val_session);

		
		// $dependent_on = $this->uri->segment(6); 

		if($dependent_on !=0){
		$data['depkey'] = $this->m_tree->lov_data();

		$data['tree'] = $this->m_tree->tree_data();

		
		$this->load->view('accounting/v_dtree_search',$data);
		}elseif($dependent_on == 0){

		$data['tree'] = $this->m_tree->tree_data();

		
		$this->load->view('accounting/v_dtree',$data);

		}

	}

	

	public function seg_add_lov(){
		  	
		$result['nature'] = $this->m_tree->get_segment_value();
		$result['seg'] = $this->m_tree->get_segment_value();
		// echo "<pre>";

		// print_r($result);
		// exit;
		$this->load->view('accounting/v_segform',$result);
		
	}

	public function seg_update_lov(){
		  	
		$result['nature'] = $this->m_tree->get_segment_value();
		$result['seg'] = $this->m_tree->get_segment_value();
		// echo "<pre>";

		// print_r($result);
		// exit;
		$this->load->view('accounting/v_usegform',$result);
		
	}

	public function seg_add(){
		$struc_id = $this->session->userdata('struc_id');//4
		$segment_no = $this->session->userdata('segment_no');//5
		$dependent_on = $this->session->userdata('dependent_on');//6
		$qualifier_id = $this->session->userdata('qualifier_id');//7
		$has_dep_val = $this->session->userdata('has_dep_val');//8

		
		$segment_id = $this->uri->segment(4);


		if($this->input->post('insert'))
		{
				 
       	$result['data'] = $this->m_tree->seg_form();
		$this->load->view('accounting/v_segform',$result);
		
		
		redirect(base_url() .'accounting/c_tree/tree_list/'.$struc_id.'/'.$segment_no.'/'.$dependent_on.'/'.$qualifier_id.'/'.$has_dep_val); 
		
		}elseif($this->input->post('update')){
			$this->m_tree->seg_update($segment_id);
			redirect(base_url() .'accounting/c_tree/tree_list/'.$struc_id.'/'.$segment_no.'/'.$dependent_on.'/'.$qualifier_id.'/'.$has_dep_val); 
		}
		elseif($this->input->post('delete')){
			$this->m_tree->seg_delete($segment_id);
			redirect(base_url() .'accounting/c_tree/tree_list/'.$struc_id.'/'.$segment_no.'/'.$dependent_on.'/'.$qualifier_id.'/'.$has_dep_val); 


		}
			

	
	}


		

	
}