<?php 

	class Reports extends CI_Controller{

		public function __construct(){
		parent::__construct();
		$this->load->database();
	    if(!$this->loginmodel->is_logged_in())
	     {
	       redirect('login/login/');
	     }
		}
		public function index(){

			
		}

		public function manifest_pl(){

			$status = $this->session->userdata('login_status');
			$login_id = $this->session->userdata('user_id');
			if(@$login_id && @$status == TRUE)
			{
				$data['manifest_data'] = $this->m_reports->manifest_data();
				$data['sum_data'] = $this->m_reports->sum_manf_data();
				$data['pageTitle'] = 'Manifest P/L Report';
				$this->load->view('Reports/manifest_PL', $data);
				//$this->load->view('Reports/manifest_PL');

			}else{
				redirect('login/login/');
			}
		}

		public function search_manifest_pl(){

			$status = $this->session->userdata('login_status');
			$login_id = $this->session->userdata('user_id');
			if(@$login_id && @$status == TRUE)
			{

				$submit = $this->input->post('Submit');
		        $purchase_no = $this->input->post('purchase_no');
		        $manif_radio = $this->input->post('manif');
		        $rslt = $this->input->post('date_range');
		        $this->session->set_userdata('date_range', $rslt);

		        $rs = explode('-',$rslt);
		        $fromdate = $rs[0];
		        $todate = $rs[1];

		        /*===Convert Date in 24-Apr-2016===*/
		        $fromdate = date_create($rs[0]);
		        $todate = date_create($rs[1]);

		        $from = date_format($fromdate,'d-m-y');
		        $to = date_format($todate, 'd-m-y');
		        
		        if ($submit)
		          {
		        	$data['manifest_data'] = $this->m_reports->search_manifest_data($from,$to,$purchase_no,$manif_radio);
		        	$data['sum_data'] = $this->m_reports->search_sum_manf_data($from,$to,$purchase_no,$manif_radio);
		        	$data['pageTitle'] = 'Manifest P/L Report';
					$this->load->view('Reports/manifest_PL', $data);

		        }else{
		                echo "Search filter is Invalid";
		            }    
			}else{
				redirect('login/login/');
			}
		}
		public function sale_pl(){

			$status = $this->session->userdata('login_status');
			$login_id = $this->session->userdata('user_id');
			$this->session->unset_userdata('get_emplo');
			if(@$login_id && @$status == TRUE)
			{
					$data['sale_data'] = $this->m_reports->sale_data();
					$data['sum_data'] = $this->m_reports->sum_data();
					$data['result'] = $this->m_reports->get_emp();
					$data['pageTitle'] = 'Sale P/L Report';
					$this->load->view('Reports/sale_PL', $data);
					//$this->load->view('Reports/sale_PL');

			}else{
				redirect('login/login/');
			}
		}

		public function search_sale_pl(){

			$status = $this->session->userdata('login_status');
			$login_id = $this->session->userdata('user_id');
			
			if(@$login_id && @$status == TRUE)
			{

				$submit = $this->input->post('Submit');
		        //$purchase_no = $this->input->post('purchase_no');
		        $sale_pl_radio = $this->input->post('sale_pl');
		        $rslt = $this->input->post('date_range');
		        $this->session->set_userdata('date_range', $rslt);

		        $rs = explode('-',$rslt);
		        $fromdate = $rs[0];
		        $todate = $rs[1];

		        /*===Convert Date in 24-Apr-2016===*/
		        $fromdate = date_create($rs[0]);
		        $todate = date_create($rs[1]);

		        $from = date_format($fromdate,'d-m-y');
		        $to = date_format($todate, 'd-m-y');
		        
		        if ($submit)
		          {
		        	$data['sale_data'] = $this->m_reports->search_sale_data($from,$to,$sale_pl_radio);
		        	$data['sum_data'] = $this->m_reports->search_sum_data($from,$to,$sale_pl_radio);
		        	$data['result'] = $this->m_reports->get_emp();
					$this->load->view('Reports/sale_PL', $data);

		        }else{
		                echo "Search filter is Invalid";
		            }    
			}else{
				redirect('login/login/');
			}
		}
	
 	// ========== Post manifest Pl report start ======================

		public function post_manifest_pl(){

				$status = $this->session->userdata('login_status');
				$login_id = $this->session->userdata('user_id');
				if(@$login_id && @$status == TRUE)
				{
					$from = NULL;
					$to= NULL;
					$purchase_no= NULL;
					$manif_dropdown= NULL;
					$keyword_search = NULL;
						$data['manifest_data'] = $this->m_reports->post_manifest_data($from,$to,$purchase_no,$manif_dropdown,$keyword_search);
						$data['sum_data'] = $this->m_reports->post_sum_manf_data($from,$to,$purchase_no,$manif_dropdown,$keyword_search);
						//$this->load->view('Reports/manifest_PL', $data);
						$data['pageTitle'] = 'Post Manifest P/L Report';
						$this->load->view('Reports/post_manifest_pl', $data);
						//$this->load->view('Reports/manifest_PL');

				}else{
					redirect('login/login/');
				}
			}
		public function search_post_manifest(){

			$status = $this->session->userdata('login_status');
			$login_id = $this->session->userdata('user_id');
			if(@$login_id && @$status == TRUE)
			{

				$submit = $this->input->post('Submit');
				$keyword_search = $this->input->post('keyword_search');
		        $keyword_search = trim(str_replace("  ", ' ', $keyword_search));
		        $keyword_search = trim(str_replace(array("'"), "''", $keyword_search));
		        $purchase_no = $this->input->post('purchase_no');
		        $manif_dropdown = $this->input->post('post_manifest_pl');
		        $rslt = $this->input->post('date_range');
		        $this->session->set_userdata('date_range', $rslt);

		        $rs = explode('-',$rslt);
		        $fromdate = $rs[0];
		        $todate = $rs[1];

		        /*===Convert Date in 24-Apr-2016===*/
		        $fromdate = date_create($rs[0]);
		        $todate = date_create($rs[1]);

		        $from = date_format($fromdate,'d-m-y');
		        $to = date_format($todate, 'd-m-y');
		        
		        if ($submit)
		          {
		        	$data['manifest_data'] = $this->m_reports->post_manifest_data($from,$to,$purchase_no,$manif_dropdown,$keyword_search);
		        	$data['sum_data'] = $this->m_reports->post_sum_manf_data($from,$to,$purchase_no,$manif_dropdown,$keyword_search);
		        	$data['pageTitle'] = 'Post Manifest P/L Report';
					$this->load->view('Reports/post_manifest_pl', $data);

		        }else{
		                echo "Search filter is Invalid";
		            }    
			}else{
				redirect('login/login/');
			}
		}
		public function item_detail(){

			$status = $this->session->userdata('login_status');
			$login_id = $this->session->userdata('user_id');
			if(@$login_id && @$status == TRUE)
			{
				$item_id = $this->uri->segment(4);
				$manifest_id = $this->uri->segment(5);
				$ebay_id = $this->uri->segment(6);
				//var_dump($item_id,$manifest_id,$ebay_id);exit;
				$data = $this->m_reports->item_detail($item_id,$manifest_id,$ebay_id);
                //$results['data'] = array('item_detail'=> $data ,'view'=> true,'paid&ship' => true);
                $results['data'] = array('item_detail'=> $data );
        		//$this->load->view('manifest_loading/v_manf_load',$results);
                $results['pageTitle'] = 'Item Detail';
        	    $this->load->view('Reports/v_itemsearch', $results);
			}else{
				redirect('login/login/');
			}
		}
	}

 ?>