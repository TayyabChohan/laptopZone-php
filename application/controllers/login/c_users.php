<?php
class C_users extends CI_Controller
{
	public function index(){
		$data['pageTitle'] ='Users List';
		$data['users'] =$this->m_users->getAllUsers();
		//echo "<pre>";
		//print_r($data['users']->result_array());
		//exit;
		$this->load->view('login/v_users_list', $data);
	}
	public function addNewUser()
	{
		$data['merchant'] =$this->m_users->getMerchant();
		$this->load->view('login/v_add_user',$data);
	}	
	public function addUser()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('first_name','First Name','required|alpha|trim');
		$this->form_validation->set_rules('last_name','Last Name','required|alpha|trim');
		$this->form_validation->set_rules('user_name','User Name','required|trim');
		$this->form_validation->set_rules('user_email','User Email','required|trim');
		$this->form_validation->set_rules('user_password','Password','required');
		//$this->form_validation->set_rules('confirm_password','Confrim Password','required|matches[user_password]');
		if($this->form_validation->run())
		{
			//echo 'success'; exit;
			$id=NULL;
			$first_name = $this->input->post('first_name');
			$last_name = $this->input->post('last_name');
			$user_password = $this->input->post('user_password');
			$user_name = $this->input->post('user_name');
			//$user_password=$this->encrypt->encode($user_password);
			$user_location = $this->input->post('user_location');
			$user_email = $this->input->post('user_email');
			//var_dump($user_password, $user_location, $user_email); exit;
			//$this->load->model('login/m_users');
			$result = $this->m_users->addUser($id,$first_name,$last_name,$user_name,$user_email,$user_location, $user_password);
		if($result==TRUE)
			{
				$this->session->set_flashdata('success',"User created successfully");
			        redirect(site_url()."login/c_users");
			}else{
				$this->session->set_flashdata('warning',"User creation failed");
			        redirect(site_url()."login/c_users");
				}
			}
			else{	//echo 'failed'; exit;
				$this->load->view('login/v_add_user');			
			}
	}
	public function deleteUser($user_id='')
	{
		$result =$this->m_users->delete_user($user_id);
		if ($result==true)
		{
			$this->session->set_flashdata('success',"User deleted!");
	        redirect(site_url()."login/c_users");
		}else{
			$this->session->set_flashdata('error',"User deletion fail");
	        redirect(site_url()."login/c_users");
		}
	}
	public function updateUser($user_id){
		$data['pageTitle'] ='Update User';
		$data['users'] =$this->m_users->getUserById($user_id);
		$data['merchant'] =$this->m_users->getMerchant();
		$this->load->view('login/v_update_user', $data);
	}
	public function editUser($user_id='')
	{
		$results =$this->m_users->edit_user($user_id);
		if ($results==TRUE)
		{
			$this->session->set_flashdata('success',"User data updated!");
	        redirect(site_url()."login/c_users");
		}else{
			$this->session->set_flashdata('error',"User updation fail");
	        redirect(site_url()."login/c_users");
		}
	}
	public function disable_user()
	{
		$data = $this->m_users->disable_user();
		echo json_encode($data);
        return json_encode($data);
	}
	public function enable_user()
	{
		$data = $this->m_users->enable_user();
		echo json_encode($data);
        return json_encode($data);
	}

}

?>