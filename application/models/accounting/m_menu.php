<?php 
// Test

	/**
	* Accounting menu Model
	*/
	class M_Menu extends CI_Model
	{

		public function __construct(){
		parent::__construct();
		$this->load->database();



		
	}


	public function st_data(){
		// Query for accounting menu 1st level select * from wiz_structure_type_mt
	$qry =("SELECT WIZ_STRUCTURE_TYPE_MT.STRUCTURE_TYPE_ID AS ST_ID,
               WIZ_STRUCTURE_TYPE_MT.STRUCTURE_TYPE_DESC AS NAME,
            WIZ_STRUCTURE_MT.STRUCTURE_TYPE_ID AS TYPE_ID
            FROM WIZ_STRUCTURE_TYPE_MT WIZ_STRUCTURE_TYPE_MT,WIZ_STRUCTURE_MT WIZ_STRUCTURE_MT
            WHERE WIZ_STRUCTURE_TYPE_MT.STRUCTURE_TYPE_ID= WIZ_STRUCTURE_MT.STRUCTURE_TYPE_ID(+)");


	$queryy =$this->db->query($qry);
	$st_dat = $queryy->result_array();
	return array('st_dat'=>$st_dat);


	}

	public function type_data(){
		// Query for accounting menu 2nd level select * from wiz_structure_mt

	$qry =("SELECT WIZ_STRUCTURE_MT.STRUCTURE_DESC,
              WIZ_STRUCTURE_MT.STRUCTURE_TYPE_ID,
              WIZ_SEGMENT_DEFINITION.STRUCTURE_ID
   FROM WIZ_STRUCTURE_MT WIZ_STRUCTURE_MT,WIZ_SEGMENT_DEFINITION WIZ_SEGMENT_DEFINITION
   WHERE WIZ_STRUCTURE_MT.STRUCTURE_ID= WIZ_SEGMENT_DEFINITION.STRUCTURE_ID
   GROUP BY WIZ_STRUCTURE_MT.STRUCTURE_DESC ,WIZ_STRUCTURE_MT.STRUCTURE_TYPE_ID,WIZ_SEGMENT_DEFINITION.STRUCTURE_ID");


	$queryy =$this->db->query($qry);
	$type_data = $queryy->result_array();
	return array('type_data'=>$type_data);

	}

	public function segm_data(){
 			// Query for accounting menu 3nd level select * from WIZ_SEGMENT_DEFINITION
		$qry =("SELECT  WIZ_SEGMENT_DEFINITION.STRUCTURE_ID,
              WIZ_SEGMENT_DEFINITION.SEGMENT_NO,
              WIZ_SEGMENT_DEFINITION.SEGMENT_DESC,
              WIZ_SEGMENT_DEFINITION.SEGMENT_WIDTH,
              WIZ_SEGMENT_DEFINITION.QUALIFIER_ID,
            DECODE(WIZ_SEGMENT_DEFINITION.DEPENDENT_ON_SEGMENT_NO,NULL,0,WIZ_SEGMENT_DEFINITION.DEPENDENT_ON_SEGMENT_NO)  AS DEPENDENT_ON_SEGMENT_NO,
                DECODE(DEP.DEPENDENT_ON_SEGMENT_NO,NULL,0,1) AS HAS_DEP_SEG_YN 
              FROM WIZ_SEGMENT_DEFINITION,
               (SELECT T.DEPENDENT_ON_SEGMENT_NO FROM WIZ_SEGMENT_DEFINITION T WHERE T.DEPENDENT_ON_SEGMENT_NO IS NOT NULL) DEP
              WHERE WIZ_SEGMENT_DEFINITION.SEGMENT_NO = DEP.DEPENDENT_ON_SEGMENT_NO(+)
              order by  WIZ_SEGMENT_DEFINITION.SEGMENT_NO asc");



	$queryy =$this->db->query($qry);
	$segm_data = $queryy->result_array();
	return array('segm_data'=>$segm_data);
	
	
	}

}
		
	

 ?>
 
