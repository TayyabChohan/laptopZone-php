<?php 
ini_set('memory_limit', '-1');
	class c_ledgerReport extends CI_Controller{
		public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library('m_pdf');
	    if(!$this->loginmodel->is_logged_in())
	     {
	       redirect('login/login/');
	     }
		}
		public function index(){
			$result['pageTitle'] = 'Ledger Report';
      		$this->load->view('reports/v_ledgerReport', $result);	
		}
			function newReport(){
			if ($this->input->post('report_submit')){
				$data['pageTitle']= 'Ledger Report';
				$data['ledgers']=$this->m_ledger_report->make_report();
				$this->load->view('reports/v_final_report', $data);
				}
		
			}
			 function loadReport(){
		        $result['data'] = $this->m_ledger_report->load_report();
		        echo json_encode($result['data']);
		        return json_encode($result['data']);   
    			}	
	}
 ?>