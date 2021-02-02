<?php
class Login extends CI_Controller
{
	
	public function index()
	{
		//$this->load->helper('form');
	  $status = $this->session->userdata('login_status');
      $login_id = $this->session->userdata('user_id');
       $this->load->library('user_agent');  // load user agent library
    // save the redirect_back data from referral url (where user first was prior to login)
    $this->session->set_userdata('redirect_back', $this->agent->referrer());

      if(@$login_id && @$status == TRUE)
      {
      	// user is authenticated, lets see if there is a redirect:
if( $this->session->userdata('redirect_back') ) {
    $redirect_url = $this->session->userdata('redirect_back');  // grab value and put into a temp variable so we unset the session value
    $this->session->unset_userdata('redirect_back');
    redirect( $redirect_url );
}elseif($login_id == 17 || $login_id == 2 )
					{
						redirect('dashboard/dashboard');
					}else{
						redirect('tolist/c_tolist/tolist_view');
						//redirect('dashboard/dashboard');
					}
      }else{
      	$data['merchant'] =$this->m_users->getMerchant();
      	$this->load->view('login/user_login',$data);
      }
		
	}
	public function user_login_form()
	{
		//$this->load->helper('form');

		$this->load->view('login/user_login');
	}
	
	public function account_type()
	{

		$account_type = $this->input->post('account_type');

		//$this->session->unset_userdata('account_type');
		$this->session->set_userdata('account_type', $account_type);
		// $rslt = $this->session->userdata('account_type');
		// var_dump($rslt);exit;

	}	
	public function user_login()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('uname','User Name','required|trim');
		$this->form_validation->set_rules('password','Password','required');
		//$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required');
		$this->form_validation->set_error_delimiters('<p class="text-danger error-msg">', '</p>');
		if($this->form_validation->run())
		{
			//success
			$username = $this->input->post('uname');
			//$redirect_url = $this->input->post('redirect_url');
			//$cookie_url = $this->input->post('cookie_url');
			//$url = $this->input->post('current_page');
			//var_dump($redirect_url); exit;
			$password = $this->input->post('password');
			$this->load->model('login/loginmodel');
			$login_id = $this->loginmodel->login_valid($username,$password);
				//$url=$this->session->flashdata('redirectToCurrent');
				////header("Location: http://localhost/$url");
				//die;
			if($login_id)
			{
				$this->session->set_userdata('login_status',TRUE);
			}else{
				$this->session->unset_userdata('employee_name');
			}



			$status = $this->session->userdata('login_status');
			
			if($login_id && $status == TRUE)
			{
			

			//account type value from dropdown 
			$account_type =	$this->input->post('account_type');
			$merchant =	$this->input->post('merchant');
			//var_dump($redirect_url); exit;
			$this->session->set_userdata('account_type', $account_type);

			$this->session->set_userdata('user_id',$login_id);
			$this->session->set_userdata('merchant_id',$merchant);
			// for random session_id for lz_bd_tmp_title
			$characters = 'abcdefghijklmnopqrstuvwxyz0123456789'; 
			$session_tmp_id = '';
			 $max = strlen($characters) - 1;
			 for ($k = 0; $k < 10; $k++) {
			      $session_tmp_id .= $characters[mt_rand(0, $max)];
			      
			 }
			 $this->session->set_userdata('session_tmp_id', $session_tmp_id);
				// echo"Login Successful";
				// echo "<a href='login/logout'>Logout</a>";
				//$_SESSION['current_page'] = $_SERVER['REQUEST_URI'];
				if($login_id == 17 || $login_id == 2 )
				{
					/*if($redirect_url!='')
					{
						header('Location: '.$redirect_url);
						
    					
					}elseif($cookie_url!='')
					{
						header('Location: '.$cookie_url);
					}else {*/
						redirect('dashboard/dashboard');
					//}
				}else
				{
					//redirect('tolist/c_tolist/lister_view');
					redirect('dashboard/dashboard');
				}					
			}
			else
			{

			// employee_name unset
			$this->session->unset_userdata('employee_name');
			//login failed
			$this->session->set_userdata('login_error', TRUE);

			
			//echo "Username and password is invalid.";
			//$this->load->view('login/user_login');
			redirect('login/login/user_login');
			}
		}
		else{//failed
		$this->load->view('login/user_login');
		//echo"Validation Failed";
		//echo validation_errors();
		}
	}

	public function signup_form(){
		$this->load->view('login/admin_signup');
	}	
	public function user_signup()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('fname','First Name','required|alpha|trim');
		$this->form_validation->set_rules('lname','Last Name','required|alpha|trim');
		$this->form_validation->set_rules('email','Email','required|trim');
		$this->form_validation->set_rules('uname','User Name','required|trim');
		$this->form_validation->set_rules('password','Password','required');
		$this->form_validation->set_rules('confirm_password','Confrim Password','required');
		
		$this->form_validation->set_error_delimiters('<p class="text-danger error-msg">', '</p>');
		if($this->form_validation->run())
		{
			//success
			$id=NULL;
			$fname = $this->input->post('fname');
			$lname = $this->input->post('lname');
			$email = $this->input->post('email');
			$uname = $this->input->post('uname');	
			//$password = md5($this->input->post('password'));
			$password = $this->input->post('password');
			//var_dump($password);
			//die;
			// $data = array(
			// 				'id'=>NULL,
			// 				'fname' => $this->input->post('fname'),
			// 				'lname' => $this->input->post('lname'),
			// 				'email' => $this->input->post('email'),
			// 				'uname' => $this->input->post('uname'),							
			// 				'pw' => md5($this->input->post('password'))
			// 			);
						//print_r($data);
						//exit;
			$this->load->model('login/loginmodel');
			$result = $this->loginmodel->signup($id,$fname,$lname,$email,$uname,$password);
					
			
			if ($result == TRUE) {
			$data['message_display'] = 'Registration Successfully!';
			//echo $data['message_display'];
			//$this->load->view('dashboard/dashboard',$data);
			redirect('dashboard/dashboard',$data);
			//$this->load->view('login_form', $data);
			//$this->load->view('dashboard/dashboard_home');
			} else {
			$data['message_display'] = 'Username already exist!';
			$this->load->view('login/admin_signup', $data);
			}
			}
			else{//failed
			$this->load->view('login/admin_signup');
			
			}
	}
	public function logout()
	{	
	    //$user_data = $this->session->all_userdata();
	    $this->session->unset_userdata('account_type');
	    $this->session->unset_userdata('login_status');  
	    $this->session->sess_destroy();
	   /*	$url_ref=$_SERVER['HTTP_REFERER'];
	    $this->session->set_userdata('current_page', $url_ref);*/
	    	//$this->load->helper('cookie');
	    	//$cookie_url=$_SERVER['HTTP_REFERER'];
            //$cookie_name = "user";
			//$cookie_value = $cookie_url;
			//setcookie($cookie_name, $cookie_value,  time() +86400, "/");
			//$data['cookie_url']=$_COOKIE[$cookie_name];
	    $data['merchant'] =$this->m_users->getMerchant();
      	$this->load->view('login/user_login',$data);
	    
	   
	    //redirect('login');
	}
}

?>