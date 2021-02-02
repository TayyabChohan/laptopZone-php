<?php 

	class M_Tree extends CI_Model
	{

		public function __construct(){
		parent::__construct();
		$this->load->database();
		
	}
	public function get_segment_value()
	{	
		// family nature lov on add child form agains qualifier id 

		$struc_id = $this->session->userdata('struc_id');//4
		$segment_no = $this->session->userdata('segment_no');//5
		$qualifier_id = $this->session->userdata('qualifier_id');//7
        // var_dump($qualifier_id);
        // exit;
        
        $segment_id = $this->uri->segment(4);
        // var_dump($struc_id);
        // exit;

        
        
		
		  $segmet_val = $this->db->query("SELECT SEGMENT_VAL_NATURE_ID,SEGMENT_NATURE_DESC  FROM WIZ_SEGMENT_VALUE_NATURE_MT 
		       							where QUALIFIER_ID =$qualifier_id");
			    
		  $nature_id=$segmet_val->result_array();
			
			// on click of any child or parent on tree get its description on usegform

		$qry1 = ("SELECT SEGMENT_VALUE_DESC FROM WIZ_SEGMENT01 WHERE STRUCTURE_ID=$struc_id");
		$qry2 = ("SELECT SEGMENT_VALUE_DESC FROM WIZ_SEGMENT02 WHERE STRUCTURE_ID=$struc_id");
		$qry3 = ("SELECT SEGMENT_VALUE_DESC FROM WIZ_SEGMENT03 WHERE STRUCTURE_ID=$struc_id");
		$qry4 = ("SELECT SEGMENT_VALUE_DESC FROM WIZ_SEGMENT04 WHERE STRUCTURE_ID=$struc_id");
		$qry5 = ("SELECT SEGMENT_VALUE_DESC FROM WIZ_SEGMENT05 WHERE STRUCTURE_ID=$struc_id");
		$qry6 = ("SELECT SEGMENT_VALUE_DESC FROM WIZ_SEGMENT06 WHERE STRUCTURE_ID=$struc_id");
		$qry7 = ("SELECT SEGMENT_VALUE_DESC FROM WIZ_SEGMENT07 WHERE STRUCTURE_ID=$struc_id");
		$qry8 = ("SELECT SEGMENT_VALUE_DESC FROM WIZ_SEGMENT08 WHERE STRUCTURE_ID=$struc_id");
		$qry9 = ("SELECT SEGMENT_VALUE_DESC FROM WIZ_SEGMENT09 WHERE STRUCTURE_ID=$struc_id");
		$qry10 = ("SELECT SEGMENT_VALUE_DESC FROM WIZ_SEGMENT10 WHERE STRUCTURE_ID=$struc_id");

			if($segment_no == 1)
			{	
				if(!empty($segment_id)){
						$queryy = $qry1." and SEGMENT_ID=$segment_id ";
						$qry_str = $this->db->query($queryy);
						$seg_id = $qry_str->result_array();
					}else{
						$queryy = $qry1;
						$qry_str = $this->db->query($queryy);
						$seg_id = $qry_str->result_array();

					}
				

			}
			else if($segment_no == 2)
			{			
				if(!empty($segment_id)){
						$queryy = $qry2." and SEGMENT_ID=$segment_id ";
						$qry_str = $this->db->query($queryy);
						$seg_id = $qry_str->result_array();
					}else{
						$queryy = $qry2;
						$qry_str = $this->db->query($queryy);
						$seg_id = $qry_str->result_array();

					}
			}
			else if($segment_no == 3)
			{			
				
					if(!empty($segment_id)){
						$queryy = $qry3." and SEGMENT_ID=$segment_id ";
						$qry_str = $this->db->query($queryy);
						$seg_id = $qry_str->result_array();
					}else{
						$queryy = $qry3;
						$qry_str = $this->db->query($queryy);
						$seg_id = $qry_str->result_array();

					}
				
			}
			else if($segment_no == 4)
			{			
				if(!empty($segment_id)){
						$queryy = $qry4." and SEGMENT_ID=$segment_id ";
						$qry_str = $this->db->query($queryy);
						$seg_id = $qry_str->result_array();
					}else{
						$queryy = $qry4;
						$qry_str = $this->db->query($queryy);
						$seg_id = $qry_str->result_array();

					}
				
			}
			else if($segment_no == 5)
			{			
				if(!empty($segment_id)){
						$queryy = $qry5." and SEGMENT_ID=$segment_id ";
						$qry_str = $this->db->query($queryy);
						$seg_id = $qry_str->result_array();
					}else{
						$queryy = $qry5;
						$qry_str = $this->db->query($queryy);
						$seg_id = $qry_str->result_array();

					}
				
			}
			else if($segment_no == 6)
			{			
				if(!empty($segment_id)){
						$queryy = $qry6." and SEGMENT_ID=$segment_id ";
						$qry_str = $this->db->query($queryy);
						$seg_id = $qry_str->result_array();
					}else{
						$queryy = $qry6;
						$qry_str = $this->db->query($queryy);
						$seg_id = $qry_str->result_array();

					}
				
			}
			else if($segment_no == 7)
			{			
				if(!empty($segment_id)){
						$queryy = $qry7." and SEGMENT_ID=$segment_id ";
						$qry_str = $this->db->query($queryy);
						$seg_id = $qry_str->result_array();
					}else{
						$queryy = $qry7;
						$qry_str = $this->db->query($queryy);
						$seg_id = $qry_str->result_array();

					}
				
			}
			else if($segment_no == 8)
			{			
				if(!empty($segment_id)){
						$queryy = $qry8." and SEGMENT_ID=$segment_id ";
						$qry_str = $this->db->query($queryy);
						$seg_id = $qry_str->result_array();
					}else{
						$queryy = $qry8;
						$qry_str = $this->db->query($queryy);
						$seg_id = $qry_str->result_array();

					}
				
			}
			else if($segment_no == 9)
			{			
				if(!empty($segment_id)){
						$queryy = $qry9." and SEGMENT_ID=$segment_id ";
						$qry_str = $this->db->query($queryy);
						$seg_id = $qry_str->result_array();
					}else{
						$queryy = $qry9;
						$qry_str = $this->db->query($queryy);
						$seg_id = $qry_str->result_array();

					}
				
			}
			else if($segment_no == 10)
			{			
				if(!empty($segment_id)){
						$queryy = $qry10." and SEGMENT_ID=$segment_id ";
						$qry_str = $this->db->query($queryy);
						$seg_id = $qry_str->result_array();
					}else{
						$queryy = $qry10;
						$qry_str = $this->db->query($queryy);
						$seg_id = $qry_str->result_array();

					}
				
			}

			return array('nature_id'=>$nature_id,'seg_id',$seg_id);

			

			 
	}



	public function tree_data()
	{
	$struc_id = $this->uri->segment(4);
    $segment_no = $this->uri->segment(5); 
    //$dep_key = $this->uri->segment(6); 
    $qual_id = $this->uri->segment(7);

    $qry1 = ("SELECT LPAD(W.STRUCTURE_ID, 14, '0') || LPAD(W.SEGMENT_ID, 14, '0') as ID ,
										w.STRUCTURE_ID,
										W.SEGMENT_ID,
										W.SEGMENT_VALUE, 
										W.DEP_ON_KEY_ID,
										W.SEGMENT_VALUE_DESC ||' ('|| W.SEGMENT_VALUE ||')' as SEGMENT_VALUE_DESC,
										lpad(w.parent_structure_id, 14, '0') || decode(w.parent_segment_id,null,'0',lpad(w.parent_segment_id, 14, '0')) as parent_id
										FROM WIZ_SEGMENT01 W 
										where W.STRUCTURE_ID = $struc_id");
    $qry2 = ("SELECT LPAD(W.STRUCTURE_ID, 14, '0') || LPAD(W.SEGMENT_ID, 14, '0') as ID ,
										w.STRUCTURE_ID,
										W.SEGMENT_ID,
										W.SEGMENT_VALUE, 
										W.DEP_ON_KEY_ID,
										W.SEGMENT_VALUE_DESC ||' ('|| W.SEGMENT_VALUE ||')' as SEGMENT_VALUE_DESC,
										lpad(w.parent_structure_id, 14, '0') || decode(w.parent_segment_id,null,'0',lpad(w.parent_segment_id, 14, '0')) as parent_id
										FROM WIZ_SEGMENT02 W 
										where W.STRUCTURE_ID = $struc_id");
    $qry3 = ("SELECT LPAD(W.STRUCTURE_ID, 14, '0') || LPAD(W.SEGMENT_ID, 14, '0') as ID ,
										w.STRUCTURE_ID,
										W.SEGMENT_ID,
										W.SEGMENT_VALUE, 
										W.DEP_ON_KEY_ID,
										W.SEGMENT_VALUE_DESC ||' ('|| W.SEGMENT_VALUE ||')' as SEGMENT_VALUE_DESC,
										lpad(w.parent_structure_id, 14, '0') || decode(w.parent_segment_id,null,'0',lpad(w.parent_segment_id, 14, '0')) as parent_id
										FROM WIZ_SEGMENT03 W 
										where W.STRUCTURE_ID = $struc_id");
    $qry4 = ("SELECT LPAD(W.STRUCTURE_ID, 14, '0') || LPAD(W.SEGMENT_ID, 14, '0') as ID ,
										w.STRUCTURE_ID,
										W.SEGMENT_ID,
										W.SEGMENT_VALUE, 
										W.DEP_ON_KEY_ID,
										W.SEGMENT_VALUE_DESC ||' ('|| W.SEGMENT_VALUE ||')' as SEGMENT_VALUE_DESC,
										lpad(w.parent_structure_id, 14, '0') || decode(w.parent_segment_id,null,'0',lpad(w.parent_segment_id, 14, '0')) as parent_id
										FROM WIZ_SEGMENT04 W 
										where W.STRUCTURE_ID = $struc_id");
    $qry5 = ("SELECT LPAD(W.STRUCTURE_ID, 14, '0') || LPAD(W.SEGMENT_ID, 14, '0') as ID ,
										w.STRUCTURE_ID,
										W.SEGMENT_ID,
										W.SEGMENT_VALUE, 
										W.DEP_ON_KEY_ID,
										W.SEGMENT_VALUE_DESC ||' ('|| W.SEGMENT_VALUE ||')' as SEGMENT_VALUE_DESC,
										lpad(w.parent_structure_id, 14, '0') || decode(w.parent_segment_id,null,'0',lpad(w.parent_segment_id, 14, '0')) as parent_id
										FROM WIZ_SEGMENT05 W 
										where W.STRUCTURE_ID = $struc_id");
     $qry6 = ("SELECT LPAD(W.STRUCTURE_ID, 14, '0') || LPAD(W.SEGMENT_ID, 14, '0') as ID ,
										w.STRUCTURE_ID,
										W.SEGMENT_ID,
										W.SEGMENT_VALUE, 
										W.DEP_ON_KEY_ID,
										W.SEGMENT_VALUE_DESC ||' ('|| W.SEGMENT_VALUE ||')' as SEGMENT_VALUE_DESC,
										lpad(w.parent_structure_id, 14, '0') || decode(w.parent_segment_id,null,'0',lpad(w.parent_segment_id, 14, '0')) as parent_id
										FROM WIZ_SEGMENT06 W 
										where W.STRUCTURE_ID = $struc_id");

		if($this->input->post('search'))
		{
				$dependent_key = $this->input->post('dependent_key');

				if($segment_no ==1)
				{			
			  
					$queryy = $qry1." and W.DEP_ON_KEY_ID = $dependent_key order by parent_id ";
					$qry_str = $this->db->query($queryy);
					$query = $qry_str->result_array();
					return array('query'=>$query);

				}
				else if($segment_no ==2)
				{			
					$queryy = $qry2." and W.DEP_ON_KEY_ID = $dependent_key order by parent_id ";
					$qry_str = $this->db->query($queryy);
					$query = $qry_str->result_array();
					return array('query'=>$query);
				}
				else if($segment_no ==3)
				{
					$queryy = $qry3." and W.DEP_ON_KEY_ID = $dependent_key order by parent_id ";
					$qry_str = $this->db->query($queryy);
					$query = $qry_str->result_array();
					return array('query'=>$query);
				}
				else if($segment_no ==4)
				{
					$queryy = $qry4." and W.DEP_ON_KEY_ID = $dependent_key order by parent_id ";
					$qry_str = $this->db->query($queryy);
					$query = $qry_str->result_array();
					return array('query'=>$query);
				}
				else if($segment_no ==5)
				{
					$queryy = $qry5." and W.DEP_ON_KEY_ID = $dependent_key order by parent_id ";
					$qry_str = $this->db->query($queryy);
					$query = $qry_str->result_array();
					return array('query'=>$query);
				}
				else if($segment_no ==6)
				{
					$queryy = $qry6." and W.DEP_ON_KEY_ID = $dependent_key order by parent_id ";
					$qry_str = $this->db->query($queryy);
					$query = $qry_str->result_array();
					return array('query'=>$query);
				}

		}
		// end of seg_id condition if
		else{
				if ($segment_no ==1)
				{ 
					$queryy = $qry1." order by parent_id";
					$qry_str = $this->db->query($queryy);
					$query = $qry_str->result_array();
					return array('query'=>$query);
				}	
				else if ($segment_no ==2)
				{ 
					
				  	$queryy = $qry2." order by parent_id";
					$qry_str = $this->db->query($queryy);
					$query = $qry_str->result_array();
					return array('query'=>$query);
				}
				else if ($segment_no ==3)
				{	 
					$queryy = $qry3." order by parent_id";
					$qry_str = $this->db->query($queryy);
					$query = $qry_str->result_array();
					return array('query'=>$query);
				}
				else if ($segment_no ==4)
				{ 
				  	$queryy = $qry4." order by parent_id";
					$qry_str = $this->db->query($queryy);
					$query = $qry_str->result_array();
					return array('query'=>$query);
				}
				else if ($segment_no ==5)
				{ 
					$queryy = $qry5." order by parent_id";
					$qry_str = $this->db->query($queryy);
					$query = $qry_str->result_array();
					return array('query'=>$query);
				}
				else if ($segment_no ==6)
				{ 
					$queryy = $qry6." order by parent_id";
					$qry_str = $this->db->query($queryy);
					$query = $qry_str->result_array();
					return array('query'=>$query);
				}

			}
	}


// **************************************************************************************************
// ************************************************************************************************

public function lov_data(){

	// DEPENDENT_ON_SEGMENT_NO LOV FOR WIZ_SEGMENT01 TO WIZ_SEGMENT10

		 $struc_id = $this->uri->segment(4);
		 $DEPENDENT_ON_SEGMENT_NO = $this->uri->segment(6);

		if($DEPENDENT_ON_SEGMENT_NO !=0){
			$dep_key=$this->db->query("SELECT D.DEP_ON_KEY_ID, D.DEP_ON_KEY_STRING, D.DEP_ON_KEY_DESC 
									FROM DEPENDENT_ON_KEY_MT D 
									WHERE D.STRUCTURE_ID=$struc_id 
									AND D.DEPENDENT_SEGMENT_NO =$DEPENDENT_ON_SEGMENT_NO
									AND D.HAVE_DEP_VAL_YN = 1
									ORDER BY D.DEP_ON_KEY_ID");
		$query_two=$dep_key->result_array();
		return array('query_two'=>$query_two);

		 }
		

	}

	public function seg_form(){

   	$segment_no = $this->session->userdata('segment_no');//5
   	$parent_segment_id = $this->uri->segment(4);
 	
 	// var_dump($segment_no);
 	// exit;

 	 
     $parent_structure_id = $this->uri->segment(10);


   	$structure_id = $this->input->post('structure_id');

  	$dep_on_struc_id = $this->input->post('dep_on_struc_id');
  
	if($this->uri->segment(8) == 'undefined'){
	$dep_on_key_id ='';
	}else{
	$dep_on_key_id = $this->uri->segment(8);
	}

   	$segment_value = $this->input->post('segment_value');
   	$segment_value_desc = $this->input->post('segment_value_desc');
    $segment_nature_id = $this->input->post('segment_nature_id');

    if(isset($parent_segment_id)){
    	$parent_segment_id = $this->uri->segment(9);
    }else{
    	$parent_segment_id = '';
    }

    if(isset($parent_structure_id)){
    	$parent_structure_id = $this->uri->segment(10);
    }else{
    	$parent_structure_id = '';
    }


    if(isset($_POST['Parent_yn']))
            {
                $Parent_yn = 1;
            }
            else
            {
                $Parent_yn = 0;
            }

             if(isset($_POST['Contains_subsidiary']))
            {
                $Contains_subsidiary = 1;
            }
            else
            {
                $Contains_subsidiary = 0;
            }



   
   //	$Contains_subsidiary = $this->input->post('Contains_subsidiary');
   	$segment_value_short_desc = $this->input->post('segment_value_short_desc');
   	



 	if($segment_no == 1)
 	{
 	
 	 $segment_data = $this->db->query("SELECT get_primary_key('wiz_segment01','SEGMENT_ID') SEGMENT_ID FROM DUAL");
  	 $rs = $segment_data->result_array(); 
 	 $SEGMENT_ID= $rs[0]['SEGMENT_ID'];

 	 $qry = "INSERT INTO wiz_segment01 (STRUCTURE_ID,SEGMENT_ID,DEP_ON_STRUC_ID,DEP_ON_KEY_ID,SEGMENT_VALUE,SEGMENT_VALUE_DESC,SEGMENT_NATURE_ID,PARENT_SEGMENT_ID,
	 PARENT_STRUCTURE_ID,PARENT_YN,HAVE_DEP_VAL_YN,SEGMENT_VALUE_SHORT_DESC) 
   	 VALUES ('$structure_id','$SEGMENT_ID','$dep_on_struc_id','$dep_on_key_id','$segment_value','$segment_value_desc','$segment_nature_id','$parent_segment_id','$parent_structure_id','$Parent_yn','$Contains_subsidiary','$segment_value_short_desc')";
   		
   		if($this->input->post('insert'))
   		{
		 $this->db->query($qry);   	
   		}
	}
	elseif($segment_no == 2)
	{
	 $segment_data = $this->db->query("SELECT get_primary_key('wiz_segment02','SEGMENT_ID') SEGMENT_ID FROM DUAL");
  	 $rs = $segment_data->result_array(); 
 	 $SEGMENT_ID= $rs[0]['SEGMENT_ID'];

	$qry = "INSERT INTO wiz_segment02 (STRUCTURE_ID,SEGMENT_ID,DEP_ON_STRUC_ID,DEP_ON_KEY_ID,SEGMENT_VALUE,SEGMENT_VALUE_DESC,SEGMENT_NATURE_ID,PARENT_SEGMENT_ID,
	 PARENT_STRUCTURE_ID,PARENT_YN,HAVE_DEP_VAL_YN) 
   	 VALUES ('$structure_id','$SEGMENT_ID','$dep_on_struc_id','$dep_on_key_id','$segment_value','$segment_value_desc','$segment_nature_id','$parent_segment_id','$parent_structure_id','$Parent_yn','$Contains_subsidiary')";
   		
   		if($this->input->post('insert'))
   		{
		 $this->db->query($qry);   	
   		}

	}
	elseif($segment_no == 3)
	{
	 $segment_data = $this->db->query("SELECT get_primary_key('wiz_segment03','SEGMENT_ID') SEGMENT_ID FROM DUAL");
  	 $rs = $segment_data->result_array(); 
 	 $SEGMENT_ID= $rs[0]['SEGMENT_ID'];

	  $qry = "INSERT INTO wiz_segment03 (STRUCTURE_ID,SEGMENT_ID,DEP_ON_STRUC_ID,DEP_ON_KEY_ID,SEGMENT_VALUE,SEGMENT_VALUE_DESC,SEGMENT_NATURE_ID,PARENT_SEGMENT_ID,
	 PARENT_STRUCTURE_ID,PARENT_YN,HAVE_DEP_VAL_YN) 
   	 VALUES ('$structure_id','$SEGMENT_ID','$dep_on_struc_id','$dep_on_key_id','$segment_value','$segment_value_desc','$segment_nature_id','$parent_segment_id','$parent_structure_id','$Parent_yn','$Contains_subsidiary')";
   		if($this->input->post('insert'))
   		{
		 $this->db->query($qry);   	
   		}

	}
	elseif($segment_no == 4)
	{
	 $segment_data = $this->db->query("SELECT get_primary_key('wiz_segment04','SEGMENT_ID') SEGMENT_ID FROM DUAL");
  	 $rs = $segment_data->result_array(); 
 	 $SEGMENT_ID= $rs[0]['SEGMENT_ID'];

	 $qry = "INSERT INTO wiz_segment04 (STRUCTURE_ID,SEGMENT_ID,DEP_ON_STRUC_ID,DEP_ON_KEY_ID,SEGMENT_VALUE,SEGMENT_VALUE_DESC,SEGMENT_NATURE_ID,PARENT_SEGMENT_ID,
	 PARENT_STRUCTURE_ID,PARENT_YN,HAVE_DEP_VAL_YN) 
   	 VALUES ('$structure_id','$SEGMENT_ID','$dep_on_struc_id','$dep_on_key_id','$segment_value','$segment_value_desc','$segment_nature_id','$parent_segment_id','$parent_structure_id','$Parent_yn','$Contains_subsidiary')";
   		if($this->input->post('insert'))
   		{
		 $this->db->query($qry);   	
   		}

	}
	elseif($segment_no == 5)
	{
	 $segment_data = $this->db->query("SELECT get_primary_key('wiz_segment05','SEGMENT_ID') SEGMENT_ID FROM DUAL");
  	 $rs = $segment_data->result_array(); 
 	 $SEGMENT_ID= $rs[0]['SEGMENT_ID'];

	 $qry = "INSERT INTO wiz_segment05 (STRUCTURE_ID,SEGMENT_ID,DEP_ON_STRUC_ID,DEP_ON_KEY_ID,SEGMENT_VALUE,SEGMENT_VALUE_DESC,SEGMENT_NATURE_ID,PARENT_SEGMENT_ID,
	 PARENT_STRUCTURE_ID,PARENT_YN,HAVE_DEP_VAL_YN,SEGMENT_VALUE_SHORT_DESC) 
   	 VALUES ('$structure_id','$SEGMENT_ID','$dep_on_struc_id','$dep_on_key_id','$segment_value','$segment_value_desc','$segment_nature_id','$parent_segment_id','$parent_structure_id','$Parent_yn','$Contains_subsidiary','$segment_value_short_desc')";
   		if($this->input->post('insert'))
   		{
		 $this->db->query($qry);   	
   		}

	}
	elseif($segment_no == 6)
	{
	 $segment_data = $this->db->query("SELECT get_primary_key('wiz_segment06','SEGMENT_ID') SEGMENT_ID FROM DUAL");
  	 $rs = $segment_data->result_array(); 
 	 $SEGMENT_ID= $rs[0]['SEGMENT_ID'];

	 $qry = "INSERT INTO wiz_segment06 (STRUCTURE_ID,SEGMENT_ID,DEP_ON_STRUC_ID,DEP_ON_KEY_ID,SEGMENT_VALUE,SEGMENT_VALUE_DESC,SEGMENT_NATURE_ID,PARENT_SEGMENT_ID,
	 PARENT_STRUCTURE_ID,PARENT_YN,HAVE_DEP_VAL_YN) 
   	 VALUES ('$structure_id','$SEGMENT_ID','$dep_on_struc_id','$dep_on_key_id','$segment_value','$segment_value_desc','$segment_nature_id','$parent_segment_id','$parent_structure_id','$Parent_yn','$Contains_subsidiary')";
   		if($this->input->post('insert'))
   		{
		 $this->db->query($qry);   	
   		}

	}
	elseif($segment_no == 7)
	{
	 $segment_data = $this->db->query("SELECT get_primary_key('wiz_segment07','SEGMENT_ID') SEGMENT_ID FROM DUAL");
  	 $rs = $segment_data->result_array(); 
 	 $SEGMENT_ID= $rs[0]['SEGMENT_ID'];

 $qry = "INSERT INTO wiz_segment07 (STRUCTURE_ID,SEGMENT_ID,DEP_ON_STRUC_ID,DEP_ON_KEY_ID,SEGMENT_VALUE,SEGMENT_VALUE_DESC,SEGMENT_NATURE_ID,PARENT_SEGMENT_ID,
	 PARENT_STRUCTURE_ID,PARENT_YN,HAVE_DEP_VAL_YN) 
   	 VALUES ('$structure_id','$SEGMENT_ID','$dep_on_struc_id','$dep_on_key_id','$segment_value','$segment_value_desc','$segment_nature_id','$parent_segment_id','$parent_structure_id','$Parent_yn','$Contains_subsidiary')";
   		if($this->input->post('insert'))
   		{
		 $this->db->query($qry);   	
   		}

	}
	elseif($segment_no == 8)
	{
	 $segment_data = $this->db->query("SELECT get_primary_key('wiz_segment08','SEGMENT_ID') SEGMENT_ID FROM DUAL");
  	 $rs = $segment_data->result_array(); 
 	 $SEGMENT_ID= $rs[0]['SEGMENT_ID'];

 $qry = "INSERT INTO wiz_segment08 (STRUCTURE_ID,SEGMENT_ID,DEP_ON_STRUC_ID,DEP_ON_KEY_ID,SEGMENT_VALUE,SEGMENT_VALUE_DESC,SEGMENT_NATURE_ID,PARENT_SEGMENT_ID,
	 PARENT_STRUCTURE_ID,PARENT_YN,HAVE_DEP_VAL_YN) 
   	 VALUES ('$structure_id','$SEGMENT_ID','$dep_on_struc_id','$dep_on_key_id','$segment_value','$segment_value_desc','$segment_nature_id','$parent_segment_id','$parent_structure_id','$Parent_yn','$Contains_subsidiary')";
   		if($this->input->post('insert'))
   		{
		 $this->db->query($qry);   	
   		}

	}
	elseif($segment_no == 9)
	{
	 $segment_data = $this->db->query("SELECT get_primary_key('wiz_segment09','SEGMENT_ID') SEGMENT_ID FROM DUAL");
  	 $rs = $segment_data->result_array(); 
 	 $SEGMENT_ID= $rs[0]['SEGMENT_ID'];

	  $qry = "INSERT INTO wiz_segment09 (STRUCTURE_ID,SEGMENT_ID,DEP_ON_STRUC_ID,DEP_ON_KEY_ID,SEGMENT_VALUE,SEGMENT_VALUE_DESC,SEGMENT_NATURE_ID,PARENT_SEGMENT_ID,
	 PARENT_STRUCTURE_ID,PARENT_YN,HAVE_DEP_VAL_YN) 
   	 VALUES ('$structure_id','$SEGMENT_ID','$dep_on_struc_id','$dep_on_key_id','$segment_value','$segment_value_desc','$segment_nature_id','$parent_segment_id','$parent_structure_id','$Parent_yn','$Contains_subsidiary')";
   		if($this->input->post('insert'))
   		{
		 $this->db->query($qry);   	
   		}

	}
	elseif($segment_no == 10)
	{
	 $segment_data = $this->db->query("SELECT get_primary_key('wiz_segment10','SEGMENT_ID') SEGMENT_ID FROM DUAL");
  	 $rs = $segment_data->result_array(); 
 	 $SEGMENT_ID= $rs[0]['SEGMENT_ID'];

	  $qry = "INSERT INTO wiz_segment10 (STRUCTURE_ID,SEGMENT_ID,DEP_ON_STRUC_ID,DEP_ON_KEY_ID,SEGMENT_VALUE,SEGMENT_VALUE_DESC,SEGMENT_NATURE_ID,PARENT_SEGMENT_ID,
	 PARENT_STRUCTURE_ID,PARENT_YN,HAVE_DEP_VAL_YN) 
   	 VALUES ('$structure_id','$SEGMENT_ID','$dep_on_struc_id','$dep_on_key_id','$segment_value','$segment_value_desc','$segment_nature_id','$parent_segment_id','$parent_structure_id','$Parent_yn','$Contains_subsidiary')";
   		if($this->input->post('insert'))
   		{
		 $this->db->query($qry);   	
   		}

	}
   
  

}


public function seg_update($b){
	$segm_id = $this->uri->segment(5); 
	$parent_desc=$this->input->post('parent_desc');
			
	$query=$this->db->query("UPDATE  WIZ_SEGMENT01 SET SEGMENT_VALUE_DESC='$parent_desc' WHERE SEGMENT_ID =$b");

		if($segm_id == 1){
			$query=$this->db->query("UPDATE  WIZ_SEGMENT01 SET SEGMENT_VALUE_DESC='$parent_desc' WHERE SEGMENT_ID =$b");
		}elseif($segm_id == 2) {
			$query=$this->db->query("UPDATE  WIZ_SEGMENT02 SET SEGMENT_VALUE_DESC='$parent_desc' WHERE SEGMENT_ID =$b");
		}elseif($segm_id == 3) {
			$query=$this->db->query("UPDATE  WIZ_SEGMENT03 SET SEGMENT_VALUE_DESC='$parent_desc' WHERE SEGMENT_ID =$b");	
		}elseif($segm_id == 4) {
			$query=$this->db->query("UPDATE  WIZ_SEGMENT04 SET SEGMENT_VALUE_DESC='$parent_desc' WHERE SEGMENT_ID =$b");	
		}elseif($segm_id == 5) {
			$query=$this->db->query("UPDATE  WIZ_SEGMENT05 SET SEGMENT_VALUE_DESC='$parent_desc' WHERE SEGMENT_ID =$b");	
		}elseif($segm_id == 6) {
			$query=$this->db->query("UPDATE  WIZ_SEGMENT06 SET SEGMENT_VALUE_DESC='$parent_desc' WHERE SEGMENT_ID =$b");	
		}elseif($segm_id == 7) {
			$query=$this->db->query("UPDATE  WIZ_SEGMENT07 SET SEGMENT_VALUE_DESC='$parent_desc' WHERE SEGMENT_ID =$b");	
		}elseif($segm_id == 8) {
			$$query=$this->db->query("UPDATE  WIZ_SEGMENT08 SET SEGMENT_VALUE_DESC='$parent_desc' WHERE SEGMENT_ID =$b");	
		}elseif($segm_id == 9) {
			$query=$this->db->query("UPDATE  WIZ_SEGMENT09 SET SEGMENT_VALUE_DESC='$parent_desc' WHERE SEGMENT_ID =$b");	
		}elseif($segm_id == 10) {
			$query=$this->db->query("UPDATE  WIZ_SEGMENT10 SET SEGMENT_VALUE_DESC='$parent_desc' WHERE SEGMENT_ID =$b");	
		}


}


public function seg_delete($a){
	$segm_id = $this->uri->segment(5); 
	
if($segm_id == 1){
	$segment_data = $this->db->query("DELETE FROM wiz_segment01 WHERE SEGMENT_ID = $a");
}elseif($segm_id == 2) {
	$segment_data = $this->db->query("DELETE FROM wiz_segment02 WHERE SEGMENT_ID = $a");	
}elseif($segm_id == 3) {
	$segment_data = $this->db->query("DELETE FROM wiz_segment03 WHERE SEGMENT_ID = $a");	
}elseif($segm_id == 4) {
	$segment_data = $this->db->query("DELETE FROM wiz_segment04 WHERE SEGMENT_ID = $a");	
}elseif($segm_id == 5) {
	$segment_data = $this->db->query("DELETE FROM wiz_segment05 WHERE SEGMENT_ID = $a");	
}elseif($segm_id == 6) {
	$segment_data = $this->db->query("DELETE FROM wiz_segment06 WHERE SEGMENT_ID = $a");	
}elseif($segm_id == 7) {
	$segment_data = $this->db->query("DELETE FROM wiz_segment07 WHERE SEGMENT_ID = $a");	
}elseif($segm_id == 8) {
	$segment_data = $this->db->query("DELETE FROM wiz_segment08 WHERE SEGMENT_ID = $a");	
}elseif($segm_id == 9) {
	$segment_data = $this->db->query("DELETE FROM wiz_segment09 WHERE SEGMENT_ID = $a");	
}elseif($segm_id == 10) {
	$segment_data = $this->db->query("DELETE FROM wiz_segment10 WHERE SEGMENT_ID = $a");	
}






	
	}





}
?>
