<?php 

	class Dashboard extends CI_Controller{

		public function index(){

			$status = $this->session->userdata('login_status');
			$login_id = $this->session->userdata('user_id');
			if(@$login_id && @$status == TRUE)
			{

				$this->load->view('dashboard/dashboard_home');

			}else{
				redirect('login/login/');
			}

		}
		public function advance_categories(){

			$this->load->view('API/advance_categories');
		}
		public function advance_price(){

			$this->load->view('API/advancedItemSearch.html');
			
		}
		public function advance_price_process(){

			$this->load->view('API/advancedItemSearchTest');
		}
		public function auth_str(){
			$this->load->helper('string'); // for generate authenticate number
			$auth_string = strtoupper(random_string('alnum', 10));
			//var_dump($auth_string);exit;

		}


	}




 ?>