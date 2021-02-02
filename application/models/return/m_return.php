<?php 

	class m_return extends CI_Model
	{

		public function __construct(){
		parent::__construct();
		$this->load->database();
		
	}
	public function processReturn(){

	$return_id = $this->input->post("return_id");
	$return_status = $this->input->post("return_status");
	$return_by = $this->input->post("return_by");
	$remarks = $this->input->post("remarks");
	$bin = strtoupper(trim($this->input->post("location")));
	
	$bin =$this->db->query("SELECT BB.BIN_ID FROM BIN_MT BB WHERE BB.BIN_TYPE||'-'||BB.BIN_NO = '$bin'")->result_array();
	$bin_id = $bin[0]['BIN_ID'];

	$qyer =$this->db->query("Call pro_processReturn($return_id ,
                                              $return_status    ,
                                              $return_by   ,
                                              $remarks   ,
                                              $bin_id   )")->result_array();

    
    return  $qyer;
	}
}

 ?>
