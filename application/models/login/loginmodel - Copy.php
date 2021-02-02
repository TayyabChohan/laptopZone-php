<?php 
class Loginmodel extends CI_Model
{
	public function login_valid($username,$password)
	{
		$password=md5($password);
		$data = array(
							'uname'=>$username,			
							'pw' => $password
						);
		

$q = $this->db->query("select * from USERS WHERE uname = '{$data['uname']}' and pw ='{$data['pw']}' ");
		//$q=$this->db->where(['uname' =>$username,'pw' =>$password])
		//		->get_compiled_select('USERS');
//print_r($q->result()) ;
//die;

				if($q->num_rows())
				{
					return $q->row()->ID;
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

$query = $this->db->query("select * from USERS WHERE uname = '{$data['uname']}'");

			//  $condition = "uname =" . "'" . $data['uname'] . "'";
			// $this->db->select('*');
			// $this->db->from('USERS');
			// $this->db->where($condition);
			// $this->db->limit(1);
			// $query = $this->db->get();
			if ($query->num_rows() == 0) {
			
			// Query to insert data in database
				//INSERT INTO USERS (id, fname, lname, email, uname, pw) VALUES (NULL, 'test', 'test', 'abc@abc.com', 'test', '098f6bcd4621d373cade4e832627b4f6')
				//$qry = "INSERT INTO USERS VALUES('$id,$fname,$lname,$email,$uname,$password')";
				//$qry = "INSERT INTO USERS VALUES('$data=>id,$data=>fname,$data=>lname,$data=>email,$data=>uname,$data=>pw .')'";
			//$qry=$this->db->query('INSERT INTO USERS VALUES(NULL'.",'".$fname."','".$lname."','".$email."','".$uname."','".$password.')');
			$qry=$this->db->query("INSERT INTO USERS VALUES('{$data['id']}','{$data['fname']}','{$data['lname']}','{$data['email']}','{$data['uname']}','{$data['pw']}')");

			//'{$_POST['username']}'
			//$this->db->insert('USERS', $data);
			//	oci_execute($q);
			//if ($this->db->affected_rows() > 0) {
			if($qry){
			return true;
			}
			} else {
			return false;
			}
		}
	
}
?>