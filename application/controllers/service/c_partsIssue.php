<?php

	class C_PartsIssue extends CI_Controller{


		public function __construct(){
			parent::__construct();
			$this->load->database();
			$this->load->model('service/m_partsIssue');
			$this->load->model('service/m_serviceForm');
			if(!$this->loginmodel->is_logged_in())
		      {
		        redirect('login/login/');
		      }
		}

		public function index(){

		}

		public function partsIssuanceView(){
			$result['doc_no'] = $this->m_partsIssue->issuanceNo();
			$result['pageTitle'] = 'Parts Issuance Form';

			$this->load->view('service/v_partsIssue',$result);
		}

		public function returnFilledData(){
			$data = $this->m_partsIssue->returnFilledData();
		    echo json_encode($data);
		    return json_encode($data);
		}

		public function partDetails(){
			$data = $this->m_partsIssue->partDetails();
			//var_dump($data);exit;
		    echo json_encode($data);
		    return json_encode($data);
		}

		public function issueParts(){
			if($this->input->post('save')){
				$this->m_partsIssue->partsIssuance();
			}
			return redirect('service/c_partsIssue/partsIssuanceView');
		}

		public function partsIssueDetailView(){
			$result['data'] = $this->m_partsIssue->partsIssuanceDetail();
		    $result['users'] = $this->m_ListingAllocation->UsersList();
		    $result['pageTitle'] = 'Parts Issue Detail View';
			$this->load->view('service/v_partsIssueDetail',$result);
		}

		public function editPartsIssue(){
			$lz_part_issue_mt_id = $this->uri->segment(4);
			// var_dump($lz_part_issue_mt_id);exit;
			$result['data'] = $this->m_partsIssue->editPartsIssue($lz_part_issue_mt_id);
			// var_dump($result['data']);exit;
			$result['resultData'] = $this->m_partsIssue->editPartsIssueOne($lz_part_issue_mt_id);
			$result['component'] = $this->m_partsIssue->selectComponent();
			$result['pageTitle'] = 'Parts Issue Edit View';
			$this->load->view('service/v_editPartsIssue', $result);
		}

		public function deletePartIssue(){
			$lz_part_issue_mt_id = $this->uri->segment(4);
			// var_dump($lz_part_issue_mt_id);exit;
			$this->m_partsIssue->deletePartIssue($lz_part_issue_mt_id);

			redirect('service/c_partsIssue/partsIssueDetailView','refresh');
		}

		public function updatePartsIssue(){
			if($this->input->post('update')){
				// $lz_part_issue_mt_id = $this->uri->segment(5);
				// var_dump($lz_part_issue_mt_id);exit;
				$this->m_partsIssue->updatePartsIssue();
			}
			return redirect('service/c_partsIssue/partsIssueDetailView');
		}
	}
?>
