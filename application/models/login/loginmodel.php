<?php 
class Loginmodel extends CI_Model
{
	public function login_valid($username,$password)
	{
		$password=$password;
		$data = array(
						'uname'=>$username,			
						'pw' => $password
					);
		

$q = $this->db->query("select * from EMPLOYEE_MT WHERE USER_NAME = '{$data['uname']}' and PASS_WORD ='{$data['pw']}' and STATUS =1 ");
		//$q=$this->db->where(['uname' =>$username,'pw' =>$password])
		//		->get_compiled_select('USERS');
//print_r($q->result()) ;
//die;

				if($q->num_rows())
				{
					$employee_name = $q->row()->USER_NAME;
					$employee_location = $q->row()->LOCATION;
					//var_dump($employee_name);exit;
					$this->session->set_userdata('employee_name', $employee_name);
					$this->session->set_userdata('employee_location', $employee_location);

					return $q->row()->EMPLOYEE_ID;
					//return TRUE;
				}else
				{
					return false;
				}
		
	}
	// Insert registration data in database
		public function signup($id,$fname,$lname,$email,$uname,$password) 
	//public function signup($data) 
		{
		$data = array(
							'id'=>$id,
							'fname' => $fname,
							'lname' => $lname,
							'email' => $email,
							'uname' => $uname,							
							'pw' => $password
						);
				//$id=NULL;
			// Query to check whether username already exist or not

$query = $this->db->query("select * from EMPLOYEE_MT WHERE USER_NAME = '{$data['uname']}'");

			//  $condition = "uname =" . "'" . $data['uname'] . "'";
			// $this->db->select('*');
			// $this->db->from('USERS');
			// $this->db->where($condition);
			// $this->db->limit(1);
			// $query = $this->db->get();
			if ($query->num_rows() == 0) {

			$query = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('EMPLOYEE_MT','employee_id') emp_id FROM DUAL");
			//var_dump($query->row()->EMP_ID+1);
			//exit;
			
			$id=$query->row()->EMP_ID;

			// Query to insert data in database
				//INSERT INTO USERS (id, fname, lname, email, uname, pw) VALUES (NULL, 'test', 'test', 'abc@abc.com', 'test', '098f6bcd4621d373cade4e832627b4f6')
				//$qry = "INSERT INTO USERS VALUES('$id,$fname,$lname,$email,$uname,$password')";
				//$qry = "INSERT INTO USERS VALUES('$data=>id,$data=>fname,$data=>lname,$data=>email,$data=>uname,$data=>pw .')'";
			//$qry=$this->db->query('INSERT INTO USERS VALUES(NULL'.",'".$fname."','".$lname."','".$email."','".$uname."','".$password.')');
			$qry=$this->db->query("INSERT INTO EMPLOYEE_MT (EMPLOYEE_ID, FIRST_NAME, LAST_NAME, JOIN_DATE, BIRTH_DATE, HOME_ADDRESS, RES_PHONE_NO, CELL_PHONE_NO, MARITAL_STATUS, ID_CARD_NUMBER, GENDER, REMARKS, TITLE, APPL_USER_YN, USER_NAME, PASS_WORD, E_MAIL_ADDRESS, EMP_STATUS, DEPT_ID, DESIG_ID, EMP_CODE, PASSWORD_DATE, EBAY_ITEM_ID, LOCATION, SHOW_UN_ASSIGNED, AUTH_PASSWORD)VALUES('$id','{$data['fname']}','{$data['lname']}','01-JAN-90',NULL,NULL,NULL,NULL,'2',NULL,'M',NULL,'TITLE','2','{$data['uname']}','{$data['pw']}','{$data['email']}','OKY',NULL,NULL,NULL,NULL,NULL,NULL)");

			//'{$_POST['username']}'
			//$this->db->insert('USERS', $data);
			//	oci_execute($q);
			//if ($this->db->affected_rows() > 0) {
			if($qry){
			return true;
				//return $data['uname'];
			}
			} else {
			return false;
			}
		}
	function is_logged_in()
	 {
	  return $this->session->userdata('user_id')!=false;
	 } 
	
}
?>