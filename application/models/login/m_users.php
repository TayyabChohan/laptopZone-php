<?php 
class M_users extends CI_Model
{
	
	// Insert registration data in database
		public function addUser($id,$first_name,$last_name,$user_name,$user_email,$user_location, $user_password) 
		{
		$data = array(
					'id'=>$id,
					'first_name' => $first_name,
					'last_name' => $last_name,
					'user_name' => $user_name,
					'user_email' => $user_email,
					'user_location' => $user_location,
					'user_password' => $user_password
					);
				//$id=NULL;
			// Query to check whether username already exist or not
			$query = $this->db->query("SELECT * FROM EMPLOYEE_MT WHERE USER_NAME = '{$data['user_name']}'");
				if ($query->num_rows() == 0) {
				$query = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('EMPLOYEE_MT','employee_id') emp_id FROM DUAL");
				/*var_dump($query->row()->EMP_ID+1);
				exit;*/
				$id=$query->row()->EMP_ID;

				$qry=$this->db->query("INSERT INTO EMPLOYEE_MT(EMPLOYEE_ID, FIRST_NAME, LAST_NAME, JOIN_DATE, BIRTH_DATE, HOME_ADDRESS, RES_PHONE_NO, CELL_PHONE_NO, MARITAL_STATUS, ID_CARD_NUMBER, GENDER, REMARKS, TITLE, APPL_USER_YN, USER_NAME, PASS_WORD, E_MAIL_ADDRESS, EMP_STATUS, DEPT_ID, DESIG_ID, EMP_CODE, PASSWORD_DATE, EBAY_ITEM_ID, LOCATION, SHOW_UN_ASSIGNED, AUTH_PASSWORD) VALUES('$id','{$data['first_name']}','{$data['last_name']}','01-JAN-90',NULL,NULL,NULL,NULL,'2',NULL,'M',NULL,'TITLE','2','{$data['user_name']}','{$data['user_password']}','{$data['user_email']}','OKY',NULL,NULL,NULL,NULL,NULL,'{$data['user_location']}',NULL,NULL)");
				//echo $qry; 
			if($qry){
				$merchant = $this->input->post('merchant');
				if($merchant > 0){
					$check=$this->db->query("SELECT EMP_DET_ID FROM EMP_MERCHANT_DET WHERE EMPLOYEE_ID = $id and MERCHANT_ID = $merchant"); 
					if($check->num_rows() == 0){

						$this->db->query("INSERT INTO EMP_MERCHANT_DET (EMP_DET_ID,EMPLOYEE_ID,MERCHANT_ID) VALUES (GET_SINGLE_PRIMARY_KEY('EMP_MERCHANT_DET','EMP_DET_ID'),$id,$merchant)");
					}
					
				}
			return true;
				//return $data['uname'];
			}else{
				return false;
			}
			} else {
			return false;
			}
		}
		public function getAllUsers()
		{
			$user_id = $this->session->userdata('user_id'); 
			if($user_id == 2 || $user_id == 21 ){
				return $query = $this->db->query("SELECT * FROM EMPLOYEE_MT  ");

			}else{  
				return $query = $this->db->query("SELECT * FROM EMPLOYEE_MT WHERE EMPLOYEE_ID ='$user_id' ");		}
			
		}
		public function getUserById($user_id)
		{
			return $query = $this->db->query("SELECT EMPLOYEE_ID, FIRST_NAME, LAST_NAME, USER_NAME, PASS_WORD, E_MAIL_ADDRESS, LOCATION FROM EMPLOYEE_MT WHERE EMPLOYEE_ID =$user_id");
		}
		public function getMerchant()
		{

			$hostname = $_SERVER['HTTP_HOST'];       
		    //$oraserver = "192.168.0.59:8081";
		    $oraserver2 = "192.168.0.28";
		   // $oraserverLive = "71.78.236.22:8081";
		    //$oraserverLive2 = "71.78.236.20";
		    $ecologixserver = "192.168.0.78:8081";
		    $ecologixserverLive = "71.78.236.21:8081";

		    if($hostname == $ecologixserverLive OR $hostname == $ecologixserver){
		    	$DBLink = '@ORASERVER';
		    }else{
		    	$DBLink = '';
		    }

			return $query = $this->db->query("SELECT M.MERCHANT_ID,M.CONTACT_PERSON,M.BUISNESS_NAME ||'   ('||M.CONTACT_PERSON||')' BUISNESS_NAME FROM LZ_MERCHANT_MT$DBLink M ORDER BY M.BUISNESS_NAME ASC ")->result_array(); }
		public function delete_user($user_id)
		{
			$query = $this->db->query("DELETE FROM EMPLOYEE_MT WHERE EMPLOYEE_ID =$user_id");
			if ($query)
			{
				return true;
			}else
			{
				return false;
			}
		}
		public function edit_user($user_id)
		{
			 $this->load->library('form_validation');
			 $this->form_validation->set_rules('first_name','First Name','required|alpha|trim');
			 $this->form_validation->set_rules('last_name','Last Name','required|alpha|trim');
			 $this->form_validation->set_rules('user_name','User Name','required|trim');
			 $this->form_validation->set_rules('user_email','User Email','trim');
			 $this->form_validation->set_rules('user_password','Password','required');
			// //$this->form_validation->set_rules('confirm_password','Confrim Password','required|matches[user_password]');
			 if($this->form_validation->run())
			 {
				//echo 'success'; exit;
				$id=NULL;
				$first_name = $this->input->post('first_name');
				$last_name = $this->input->post('last_name');
				$user_password = $this->input->post('user_password');
				$user_name = $this->input->post('user_name');
				$user_location = $this->input->post('user_location');
				$user_email = $this->input->post('user_email');
				// var_dump($first_name, $last_name, $user_name, $user_password, $user_location, $user_email);
				// exit;
				//$this->load->model('login/m_users');
				$query=$this->db->query("UPDATE EMPLOYEE_MT SET FIRST_NAME='$first_name', LAST_NAME='$last_name', USER_NAME='$user_name', PASS_WORD='$user_password', E_MAIL_ADDRESS='$user_email', LOCATION='$user_location' WHERE EMPLOYEE_ID =$user_id");
					if($query)
						{
							$merchant = $this->input->post('merchant');
							if($merchant > 0){
								$check=$this->db->query("SELECT EMP_DET_ID FROM EMP_MERCHANT_DET WHERE EMPLOYEE_ID = $user_id and MERCHANT_ID = $merchant"); 
								if($check->num_rows() == 0){

									$this->db->query("INSERT INTO EMP_MERCHANT_DET (EMP_DET_ID,EMPLOYEE_ID,MERCHANT_ID) VALUES (GET_SINGLE_PRIMARY_KEY('EMP_MERCHANT_DET','EMP_DET_ID'),$user_id,$merchant)");
								}
								
							}
							

							return TRUE;
						}else{
							return FALSE;
							}
			}
					else{	//echo 'failed'; exit;
						$this->load->view('login/v_update_user');			
					}
		}
		public function disable_user()
		{
			$user_id = $this->input->post('user_id');
			
			if (!empty($user_id)) 
			{
				$query=$this->db->query("UPDATE EMPLOYEE_MT SET STATUS= 0 WHERE EMPLOYEE_ID =$user_id");
					if($query)
						{
							return TRUE;
						}
						else
						{
							return FALSE;
						}
			}
		}
		public function enable_user()
		{
			$user_id = $this->input->post('user_id');
			
			if (!empty($user_id)) 
			{
				$query=$this->db->query("UPDATE EMPLOYEE_MT SET STATUS= 1 WHERE EMPLOYEE_ID =$user_id");
					if($query)
						{
							return TRUE;
						}
						else
						{
							return FALSE;
						}
			}
		}
	
}
?>