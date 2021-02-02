<?php 
	class M_Tester_Model extends CI_Model{
		public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	public function queryData($perameter,$handle){
		$item_qry = $this->db->query("SELECT M.ITEM_ID,M.LZ_MANIFEST_ID,M.CONDITION_ID ITEM_CONDITION FROM LZ_BARCODE_MT M WHERE M.BARCODE_NO=$perameter"); 
		$item_con = $item_qry->result_array();



		if($item_qry->num_rows() > 0){
			//$item_det = $this->db->query("SELECT B.UNIT_NO, B.BARCODE_NO IT_BARCODE, B.EBAY_ITEM_ID, B.CONDITION_ID ITEM_CONDITION, V.ITEM_MT_DESC, V.MANUFACTURER, V.MFG_PART_NO, V.UPC, V.AVAIL_QTY, V.ITEM_ID, V.LZ_MANIFEST_ID, V.PURCH_REF_NO FROM LZ_BARCODE_MT B, VIEW_LZ_LISTING_REVISED V WHERE B.ITEM_ID = V.ITEM_ID AND B.LZ_MANIFEST_ID = V.LZ_MANIFEST_ID AND B.LZ_MANIFEST_ID=".$item_con[0]['LZ_MANIFEST_ID']." AND B.ITEM_ID = ".$item_con[0]['ITEM_ID']." ORDER BY B.UNIT_NO");
			$item_det = $this->db->query("SELECT B.UNIT_NO, B.BARCODE_NO          IT_BARCODE, B.EBAY_ITEM_ID, B.CONDITION_ID        ITEM_CONDITION, I.ITEM_DESC           ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_UPC         UPC, BCD.QTY AVAIL_QTY, B.ITEM_ID, B.LZ_MANIFEST_ID, M.PURCH_REF_NO FROM LZ_BARCODE_MT B, LZ_MANIFEST_MT M, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.LZ_MANIFEST_ID=".$item_con[0]['LZ_MANIFEST_ID']." AND BC.ITEM_ID = ".$item_con[0]['ITEM_ID']." GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID) BCD WHERE B.ITEM_ID = I.ITEM_ID AND M.LZ_MANIFEST_ID = B.LZ_MANIFEST_ID AND B.LZ_MANIFEST_ID=".$item_con[0]['LZ_MANIFEST_ID']." AND B.ITEM_ID = ".$item_con[0]['ITEM_ID']." ORDER BY B.UNIT_NO "); 
			$item_det = $item_det->result_array(); 
		}else{
            	//echo "<script>alert('Invalid Barcode. Please search a valid barcode.')</script>";
      			return "Barcode_Invalid";
    		}

		/*=====================================================
		=            check barcode and apply color            =
		=====================================================*/
		
		$tested_barcode = $this->db->query("SELECT * FROM LZ_TESTING_DATA WHERE LZ_BARCODE_ID = (SELECT LZ_BARCODE_MT_ID FROM LZ_BARCODE_MT WHERE BARCODE_NO = $perameter) ORDER BY LZ_TEST_MT_ID ,LZ_TEST_DET_ID");
		$test_data = $tested_barcode->result_array();
	 
		
		/*=====  End of check barcode and apply color  ======*/
		$item_cond = "SELECT ID,COND_NAME FROM LZ_ITEM_COND_MT ORDER BY ID ASC";
		$item_cond = $this->db->query($item_cond);
		$item_cond =  $item_cond->result_array();
		
		$cat_id = $this->db->query("select distinct dt.e_bay_cata_id_seg6,dt.brand_seg3 from lz_manifest_det dt where dt.laptop_item_code = (select v.laptop_item_code from view_lz_listing_revised v where v.lz_manifest_id = ".$item_det[0]['LZ_MANIFEST_ID']." AND v.item_id = ".$item_det[0]['ITEM_ID']." and rownum = 1) and dt.e_bay_cata_id_seg6 not in ('N/A', 'Other', 'OTHER', 'other')"); 

		$cat_id=  $cat_id->result_array();
		//var_dump($cat_id);exit;

		if(!empty($cat_id[0]['E_BAY_CATA_ID_SEG6'])){
			

			$mt_id = $this->db->query("select * from CATEGORY_SPECIFIC_MT t where t.ebay_category_id = (select distinct dt.e_bay_cata_id_seg6 from lz_manifest_det dt where dt.laptop_item_code = (select v.laptop_item_code from view_lz_listing_revised v where v.lz_manifest_id = ".$item_det[0]['LZ_MANIFEST_ID']." AND v.item_id = ".$item_det[0]['ITEM_ID']." and rownum = 1) and dt.e_bay_cata_id_seg6 not in ('N/A', 'Other', 'OTHER', 'other') and rownum=1) order by t.mt_id");
			
			// if($mt_id->num_rows() == 0){
			// 	echo "<script>alert('Specifics not found. Please enter item specifics.')</script>";exit;
			// }else{
				$mt_id = $mt_id->result_array();
			//}

		$checklist_name = $this->db->query("select cm.checklist_name, cm.checklist_mt_id from lz_category_checklist_bind cb, lz_checklist_mt cm where cb.checklist_mt_id = cm.checklist_mt_id and cb.category_id = ".$cat_id[0]['E_BAY_CATA_ID_SEG6']); 
		$checklist_name = $checklist_name->result_array();

			if(!empty($mt_id[0]['EBAY_CATEGORY_ID'])){
				$specs_qry = $this->db->query("select q1.ebay_category_id, q1.specific_name, det.specific_value, q1.max_value, q1.min_value, q1.selection_mode,q1.mt_id from (select * from category_specific_mt mt where mt.ebay_category_id = (select distinct  dt.e_bay_cata_id_seg6 from lz_manifest_det dt where dt.laptop_item_code = (select v.laptop_item_code from view_lz_listing_revised v where v.lz_manifest_id = ".$item_det[0]['LZ_MANIFEST_ID']." AND v.item_id = ".$item_det[0]['ITEM_ID']." and rownum = 1) and dt.e_bay_cata_id_seg6 not in ('N/A','Other', 'OTHER', 'other' ) and rownum =1)) q1, category_specific_det det where q1.mt_id = det.mt_id");
				$specs_qry=  $specs_qry->result_array();
				$test_qry = "select d.*,m.check_name,m.selection_mode from lz_test_check_mt m,lz_test_check_det d where m.lz_test_mt_id=d.lz_test_mt_id and m.lz_test_mt_id in (select distinct d.lz_test_mt_id from lz_checklist_det d,lz_checklist_mt m where d.checklist_mt_id in (select b.checklist_mt_id from lz_category_checklist_bind b where b.category_id =".$mt_id[0]['EBAY_CATEGORY_ID'].") and d.checklist_mt_id = m.checklist_mt_id)  order by d.lz_test_mt_id ,d.lz_test_det_id";

				//var_dump($test_qry);exit;
				$test_id = $this->db->query($test_qry); 
				if($test_id->num_rows() == 0){
				echo "<script>alert('Item checklist not found. Please asign checklist first.');</script>";
				$test_id=  $test_id->result_array();
			}else{
				$test_id=  $test_id->result_array();
			}
				
				$match_qry = "select  d.lz_test_mt_id from lz_test_check_mt m, lz_test_check_det d where m.lz_test_mt_id = d.lz_test_mt_id and m.lz_test_mt_id in (select distinct d.lz_test_mt_id from lz_checklist_det d, lz_checklist_mt m where d.checklist_mt_id in (select b.checklist_mt_id from lz_category_checklist_bind b where b.category_id = ".$mt_id[0]['EBAY_CATEGORY_ID'].") and d.checklist_mt_id = m.checklist_mt_id) order by d.lz_test_mt_id"; 
				$match_qry = $this->db->query($match_qry);
				$match_qry=  $match_qry->result_array();

				$specs_value = "SELECT MT.SPECIFICS_NAME, DT.SPECIFICS_VALUE FROM LZ_ITEM_SPECIFICS_MT MT, LZ_ITEM_SPECIFICS_DET DT WHERE MT.SPECIFICS_MT_ID = DT.SPECIFICS_MT_ID AND MT.ITEM_ID =". $item_det[0]['ITEM_ID']."  AND MT.CATEGORY_ID = ".$mt_id[0]['EBAY_CATEGORY_ID'];
				$specs_value = $this->db->query($specs_value);
				$specs_value =  $specs_value->result_array();

				if($handle){
					return array('specs_qry'=>$specs_qry,'mt_id'=>$mt_id, 'item_det'=> $item_det, 'test_id'=> $test_id, 'match_qry'=> $match_qry, 'specs_value'=>$specs_value, 'checklist_name'=>$checklist_name, 'cat_id'=>$cat_id,'test_data'=>$test_data,'item_con'=>$item_con,'item_cond'=>$item_cond,'testing_data'=>$test_data);

				}else{
					return array('specs_qry'=>$specs_qry,'mt_id'=>$mt_id, 'item_det'=> $item_det, 'test_id'=> $test_id, 'match_qry'=> $match_qry, 'specs_value'=>$specs_value, 'checklist_name'=>$checklist_name, 'cat_id'=>$cat_id,'test_data'=>false,'item_con'=>$item_con,'item_cond'=>$item_cond,'testing_data'=>$test_data);
				}
				
			}else{
				$result['category_id'] = $cat_id[0]['E_BAY_CATA_ID_SEG6'];
				$this->load->view('ebay/trading/item_specifics',$result);
				// $result['data'] = $this->m_tester_model->queryData($perameter);
			 //    $this->load->view('tester_screen/v_tester_result', $result);
			}

		}else{//category id if else
				return array('error_msg'=>true, 'item_det'=> $item_det,'item_cond'=>$item_cond);
		}
	}
	public function get_single_checklist_test(){	
		$cat_id = $this->input->post('cat_id');
		$checklist_name = $this->input->post('checklist_name');
		//$bar_code = $this->input->post('bar_code');
		$checklist_test = "SELECT D.*,M.CHECK_NAME,M.SELECTION_MODE FROM LZ_TEST_CHECK_MT M,LZ_TEST_CHECK_DET D WHERE M.LZ_TEST_MT_ID=D.LZ_TEST_MT_ID AND M.LZ_TEST_MT_ID IN (SELECT DISTINCT D.LZ_TEST_MT_ID FROM LZ_CHECKLIST_DET D,LZ_CHECKLIST_MT M WHERE D.CHECKLIST_MT_ID IN (SELECT B.CHECKLIST_MT_ID FROM LZ_CATEGORY_CHECKLIST_BIND B WHERE B.CATEGORY_ID = ".$cat_id." AND B.CHECKLIST_MT_ID = ".$checklist_name.") AND D.CHECKLIST_MT_ID = M.CHECKLIST_MT_ID)  ORDER BY D.LZ_TEST_MT_ID ,D.LZ_TEST_DET_ID";	
		$checklist_test = $this->db->query($checklist_test);
		$checklist_test = $checklist_test->result_array();
		$match_qry = "SELECT  D.LZ_TEST_MT_ID FROM LZ_TEST_CHECK_MT M, LZ_TEST_CHECK_DET D WHERE M.LZ_TEST_MT_ID = D.LZ_TEST_MT_ID AND M.LZ_TEST_MT_ID IN (SELECT DISTINCT D.LZ_TEST_MT_ID FROM LZ_CHECKLIST_DET D, LZ_CHECKLIST_MT M WHERE D.CHECKLIST_MT_ID IN (SELECT B.CHECKLIST_MT_ID FROM LZ_CATEGORY_CHECKLIST_BIND B WHERE B.CATEGORY_ID = ".$cat_id."AND B.CHECKLIST_MT_ID = ".$checklist_name.") AND D.CHECKLIST_MT_ID = M.CHECKLIST_MT_ID) ORDER BY D.LZ_TEST_MT_ID ,D.LZ_TEST_DET_ID"; 
		$match_qry = $this->db->query($match_qry);
		$match_qry=  $match_qry->result_array();
        // var_dump($checklist_test);exit;
		// $tested_barcode = $this->db->query("SELECT * FROM LZ_TESTING_DATA WHERE LZ_BARCODE_ID = (SELECT LZ_BARCODE_MT_ID from LZ_BARCODE_MT WHERE BARCODE_NO = $bar_code) order by lz_test_mt_id ,lz_test_det_id");
		// $test_data = $tested_barcode->result_array();
		// return $test_id->result_array(); 
		return array('match_qry'=>$match_qry, 'checklist_test'=> $checklist_test);		
	}
	public function update_cat_id(){
		$it_barcode = $this->input->post('it_barcode');
        $category_id = $this->input->post('category_id');
        $main_category = $this->input->post('main_category');
        $main_category = trim(str_replace("  ", ' ', $main_category));
        $main_category = trim(str_replace(array("'"), "''", $main_category));
        $sub_cat = $this->input->post('sub_cat');
        $sub_cat = trim(str_replace("  ", ' ', $sub_cat));
        $sub_cat = trim(str_replace(array("'"), "''", $sub_cat));
        $category_name = $this->input->post('category_name');
        $category_name = trim(str_replace("  ", ' ', $category_name));
        $category_name = trim(str_replace(array("'"), "''", $category_name));
        $cat_id = $this->db->query("UPDATE LZ_MANIFEST_DET SET MAIN_CATAGORY_SEG1='$main_category' ,SUB_CATAGORY_SEG2='$sub_cat',E_BAY_CATA_ID_SEG6= '$category_id',CATEGORY_NAME_SEG7 = '$category_name' WHERE LAPTOP_ITEM_CODE = (SELECT V.LAPTOP_ITEM_CODE FROM VIEW_LZ_LISTING_REVISED V WHERE V.IT_BARCODE = '$it_barcode')");
        return $cat_id;
	}
	public function add_specifics(){
      $item_id = $this->input->post('item_id');
      $cat_id = $this->input->post('cat_id');
      $spec_name = $this->input->post('spec_name');
      $spec_name = trim(str_replace("  ", ' ', $spec_name));
      $spec_name = trim(str_replace(array("'"), "''", $spec_name));
      $spec_value = $this->input->post('spec_value');
      $spec_value = trim(str_replace("  ", ' ', $spec_value));
      $spec_value = trim(str_replace(array("'"), "''", $spec_value));
      $user_id = $this->session->userdata('user_id');
      date_default_timezone_set("America/Chicago");
	  $current_date = date("Y-m-d H:i:s");
      $current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";
      $comma = ',';
        $cat_id = $this->db->query("INSERT INTO LZ_ITEM_SPECIFICS VALUES ('$item_id $comma $cat_id $comma '$spec_name' $comma $user_id $comma '$spec_value' $comma $current_date')");
        return $cat_id;
	}
	public function delete_item_test(){
		$manifest_list_qry = "SELECT DISTINCT B.LZ_MANIFEST_ID,MT.MANIFEST_NAME FROM LZ_BARCODE_MT B,LZ_MANIFEST_MT MT WHERE B.LZ_MANIFEST_ID IN (SELECT M.LZ_MANIFEST_ID FROM LZ_MANIFEST_MT M WHERE M.POSTED = 'Posted' AND M.SINGLE_ENTRY_ID IS NULL AND M.GRN_ID IS NOT NULL) AND B.CONDITION_ID IS NULL AND MT.LZ_MANIFEST_ID = B.LZ_MANIFEST_ID AND MT.MANIFEST_NAME IS NOT NULL";
		$manifest_list_qry =$this->db->query($manifest_list_qry);
		$manifest_list_qry = $manifest_list_qry->result_array();		
		//$barcode = $this->input->post('barcode');
		$barcode = $this->uri->segment(4);
        $del_qry = $this->db->query("DELETE FROM LZ_TESTING_DATA WHERE LZ_BARCODE_ID=(SELECT LZ_BARCODE_MT_ID from LZ_BARCODE_MT WHERE BARCODE_NO = $barcode)"); 
		if($del_qry){
			$cond_qry = "UPDATE LZ_BARCODE_MT SET CONDITION_ID = '' WHERE BARCODE_NO = $barcode ";
						$this->db->query($cond_qry);
			$deleted = "deleted";
			return array('deleted'=>$deleted, 'manifest_list_qry'=> $manifest_list_qry);
		}else{
			$not_deleted = "not_deleted";
			return array('not_deleted'=>$not_deleted, 'manifest_list_qry'=> $manifest_list_qry);
		}
		
	}
	public function save_item_test(){
	
		$barcode = $this->input->post('barcode');
		$condition = $this->input->post('condition');
		$special_remarks = trim($this->input->post('special_remarks'));
		$picture_note = trim($this->input->post('picture_note'));
		$test_mt_id = $this->input->post('test_mt_id');
		$test_det_id = $this->input->post('test_det_id');
		$selection_mode = $this->input->post('selection_mode');
		//var_dump($test_det_id);exit;
		$user_id = $this->session->userdata('user_id');
		date_default_timezone_set("America/Chicago");
		$current_date = date("Y-m-d H:i:s");
		$current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";
		$comma = ',';
		var_dump($barcode, $condition, $special_remarks, $picture_note, $test_mt_id, $test_det_id, $selection_mode);
		//exit;
			foreach($barcode as $barcode){
				$barcode_no = $this->db->query("SELECT LZ_BARCODE_MT_ID FROM LZ_BARCODE_MT  WHERE BARCODE_NO = $barcode");
				$barcode_id = $barcode_no->result_array();
				$lz_barcode_id = $barcode_id[0]['LZ_BARCODE_MT_ID'];

				if(!empty($test_mt_id)){
					$i=0;
					foreach($test_mt_id as $mt_id)
				    {
				    	$get_mt_pk = $this->db->query("SELECT get_single_primary_key('LZ_TESTING_DATA','LZ_TESTING_DATA_ID') LZ_TESTING_DATA_ID FROM DUAL");
						$get_pk = $get_mt_pk->result_array();
						$lz_testing_data_id = $get_pk[0]['LZ_TESTING_DATA_ID'];
						if($selection_mode[$i] == 'freeText'){
							$str = explode('_', $mt_id);
							$t_mt_id = $str[0];
							$t_det_id = $str[1]; 
							$qry = "INSERT INTO LZ_TESTING_DATA VALUES ($lz_testing_data_id $comma $lz_barcode_id $comma $t_mt_id $comma $t_det_id $comma '$special_remarks' $comma $user_id $comma $current_date $comma '$picture_note' $comma '$test_det_id[$i]')";
							$this->db->query($qry);
							
						}elseif($selection_mode[$i] == 'logical'){
							$qry = "INSERT INTO LZ_TESTING_DATA VALUES ($lz_testing_data_id $comma $lz_barcode_id $comma $mt_id $comma $test_det_id[$i] $comma '$special_remarks' $comma $user_id $comma $current_date $comma '$picture_note' $comma NULL)";
							$this->db->query($qry);
						}elseif($selection_mode[$i] == 'list'){
							//$str = explode(',', $test_det_id[$i]);
							//if(is_array($test_det_id[$i])){
							$lz_testing_id = $lz_testing_data_id;
								foreach($test_det_id[$i] as $val){
									$qry = "INSERT INTO LZ_TESTING_DATA VALUES ($lz_testing_id $comma $lz_barcode_id $comma $mt_id $comma $val $comma '$special_remarks' $comma $user_id $comma $current_date $comma '$picture_note' $comma NULL)";
									$this->db->query($qry);
									$get_pk = $this->db->query("SELECT get_single_primary_key('LZ_TESTING_DATA','LZ_TESTING_DATA_ID') LZ_TESTING_DATA_ID FROM DUAL");
									$get__pk = $get_pk->result_array();
									$lz_testing_id = $get__pk[0]['LZ_TESTING_DATA_ID'];
								}
							// }else{
							// 	$qry = "INSERT INTO LZ_TESTING_DATA VALUES ($lz_testing_data_id $comma $barcode $comma $mt_id $comma $test_det_id[$i] $comma '$special_remarks' $comma $user_id $comma $current_date $comma '$picture_note' $comma NULL)";
							// }
						}
				    	//if($this->db->query($qry)){
				    		$cond_qry = "UPDATE LZ_BARCODE_MT SET CONDITION_ID = $condition WHERE LZ_BARCODE_MT_ID = $lz_barcode_id";
							$this->db->query($cond_qry);
				    	//}
					$i++;
				    } // end testing data foreach
				}else{//end if
					$skip_test = "UPDATE LZ_BARCODE_MT SET CONDITION_ID = $condition WHERE LZ_BARCODE_MT_ID = $lz_barcode_id";
					$this->db->query($skip_test);
				}
			}//barcode foreach
			
	return true;	 
		

	}
	public function update_item_test(){
		$barcode = $this->input->post('barcode');
		$condition = $this->input->post('condition');
		$special_remarks = trim($this->input->post('special_remarks'));
		$picture_note = trim($this->input->post('picture_note'));
		$test_mt_id = $this->input->post('test_mt_id');
		$test_det_id = $this->input->post('test_det_id');
		$selection_mode = $this->input->post('selection_mode');
		//var_dump($test_det_id);exit;
		$user_id = $this->session->userdata('user_id');
		date_default_timezone_set("America/Chicago");
		$current_date = date("Y-m-d H:i:s");
		$current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";
		$comma = ',';
		$barcode_no = $this->db->query("SELECT LZ_BARCODE_MT_ID FROM LZ_BARCODE_MT WHERE BARCODE_NO = $barcode");
		$barcode_id = $barcode_no->result_array();
		$lz_barcode_id = $barcode_id[0]['LZ_BARCODE_MT_ID'];
		$qry_flag = $this->db->query("DELETE FROM LZ_TESTING_DATA WHERE LZ_BARCODE_ID = $lz_barcode_id");
				//foreach($barcode as $barcode){
				$i=0;
				foreach($test_mt_id as $mt_id)
			    {
			    	$get_mt_pk = $this->db->query("SELECT get_single_primary_key('LZ_TESTING_DATA','LZ_TESTING_DATA_ID') LZ_TESTING_DATA_ID FROM DUAL");
					$get_pk = $get_mt_pk->result_array();
					$lz_testing_data_id = $get_pk[0]['LZ_TESTING_DATA_ID'];
					if($selection_mode[$i] == 'freeText'){
						$str = explode('_', $mt_id);
						$t_mt_id = $str[0];
						$t_det_id = $str[1]; 
						$qry = "INSERT INTO LZ_TESTING_DATA VALUES ($lz_testing_data_id $comma $lz_barcode_id $comma $t_mt_id $comma $t_det_id $comma '$special_remarks' $comma $user_id $comma $current_date $comma '$picture_note' $comma '$test_det_id[$i]')";
						$this->db->query($qry);
						
					}elseif($selection_mode[$i] == 'logical'){
						$qry = "INSERT INTO LZ_TESTING_DATA VALUES ($lz_testing_data_id $comma $lz_barcode_id $comma $mt_id $comma $test_det_id[$i] $comma '$special_remarks' $comma $user_id $comma $current_date $comma '$picture_note' $comma NULL)";
						$this->db->query($qry);
					}elseif($selection_mode[$i] == 'list'){
						//$str = explode(',', $test_det_id[$i]);
						//if(is_array($test_det_id[$i])){
						$lz_testing_id = $lz_testing_data_id;
							foreach($test_det_id[$i] as $val){
								$qry = "INSERT INTO LZ_TESTING_DATA VALUES ($lz_testing_id $comma $lz_barcode_id $comma $mt_id $comma $val $comma '$special_remarks' $comma $user_id $comma $current_date $comma '$picture_note' $comma NULL)";
								$this->db->query($qry);
								$get_pk = $this->db->query("SELECT get_single_primary_key('LZ_TESTING_DATA','LZ_TESTING_DATA_ID') LZ_TESTING_DATA_ID FROM DUAL");
								$get__pk = $get_pk->result_array();
								$lz_testing_id = $get__pk[0]['LZ_TESTING_DATA_ID'];
							}
						// }else{
						// 	$qry = "INSERT INTO LZ_TESTING_DATA VALUES ($lz_testing_data_id $comma $barcode $comma $mt_id $comma $test_det_id[$i] $comma '$special_remarks' $comma $user_id $comma $current_date $comma '$picture_note' $comma NULL)";
						// }
					}
			    	//if($this->db->query($qry)){
			    		$cond_qry = "UPDATE LZ_BARCODE_MT SET CONDITION_ID = $condition WHERE LZ_BARCODE_MT_ID = $lz_barcode_id ";
						$this->db->query($cond_qry);
			    	//}
				$i++;
			    }

			//}//barcode foreach
			
	return true;	 
		

	}
	function tested_data_results(){
		if($this->input->post('test_manifest_id')){
			$test_manifest_id = $this->input->post('test_manifest_id');
		}else{
			$test_manifest_id = $this->uri->segment(4);
		}
		if(is_numeric($test_manifest_id)){
		//to handle single entry we use this check		
			//======================== Un-Tested Data tab Start =============================//
			 $un_tested_qry = "select b.unit_no, b.barcode_no it_barcode, b.print_status, v.ITEM_CONDITION, v.ITEM_MT_DESC, v.MANUFACTURER, v.MFG_PART_NO, v.UPC, v.AVAIL_QTY, v.ITEM_ID, v.LZ_MANIFEST_ID, v.PURCH_REF_NO, v.laptop_item_code from lz_barcode_mt b, (SELECT im.item_desc ITEM_MT_DESC, im.item_mt_manufacture MANUFACTURER, im.ITEM_MT_BBY_SKU, im.ITEM_MT_UPC UPC, im.ITEM_MT_MFG_PART_NO MFG_PART_NO, im.item_condition, ld.laptop_item_code, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, lm.purchase_date, IM.ITEM_ID, LM.LOADING_NO, LM.LOADING_DATE, sum(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0)) PO_DETAIL_RETIAL_PRICE, SUM(NVL(LD.AVAILABLE_QTY, 0)) AVAIL_QTY, IM.Item_Code FROM LZ_MANIFEST_MT LM, LZ_MANIFEST_DET LD, ITEMS_MT IM WHERE LM.LZ_MANIFEST_ID = LD.LZ_MANIFEST_ID AND IM.ITEM_CODE = LD.LAPTOP_ITEM_CODE GROUP BY im.item_desc, im.item_mt_manufacture, ld.laptop_item_code, IM.ITEM_ID, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, lM.purchase_date, LM.LOADING_NO, LM.LOADING_DATE, im.ITEM_MT_BBY_SKU, im.ITEM_MT_UPC, im.ITEM_MT_MFG_PART_NO, im.item_condition, IM.Item_Code ) v where b.item_id = v.item_id and b.lz_manifest_id = v.LZ_MANIFEST_ID and (b.lz_manifest_id = $test_manifest_id or v.purch_ref_no = to_char($test_manifest_id)) and b.CONDITION_ID is null order by b.item_id, b.unit_no"; 
			 //======================== Un-Tested Data tab End =============================//

			 //======================== Tested Data tab Start =============================//
			 $tested_qry = "select b.unit_no, b.barcode_no it_barcode, b.print_status, b.CONDITION_ID, v.ITEM_MT_DESC, v.MANUFACTURER, v.MFG_PART_NO, v.UPC, v.AVAIL_QTY, v.ITEM_ID, v.LZ_MANIFEST_ID, v.PURCH_REF_NO, v.laptop_item_code from lz_barcode_mt b, (SELECT im.item_desc ITEM_MT_DESC, im.item_mt_manufacture MANUFACTURER, im.ITEM_MT_BBY_SKU, im.ITEM_MT_UPC UPC, im.ITEM_MT_MFG_PART_NO MFG_PART_NO, im.item_condition, ld.laptop_item_code, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, lm.purchase_date, IM.ITEM_ID, LM.LOADING_NO, LM.LOADING_DATE, sum(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0)) PO_DETAIL_RETIAL_PRICE, SUM(NVL(LD.AVAILABLE_QTY, 0)) AVAIL_QTY, IM.Item_Code FROM LZ_MANIFEST_MT LM, LZ_MANIFEST_DET LD, ITEMS_MT IM WHERE LM.LZ_MANIFEST_ID = LD.LZ_MANIFEST_ID AND IM.ITEM_CODE = LD.LAPTOP_ITEM_CODE GROUP BY im.item_desc, im.item_mt_manufacture, ld.laptop_item_code, IM.ITEM_ID, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, lM.purchase_date, LM.LOADING_NO, LM.LOADING_DATE, im.ITEM_MT_BBY_SKU, im.ITEM_MT_UPC, im.ITEM_MT_MFG_PART_NO, im.item_condition, IM.Item_Code ) v where b.item_id = v.item_id and b.lz_manifest_id = v.LZ_MANIFEST_ID and (b.lz_manifest_id = $test_manifest_id or v.purch_ref_no = to_char($test_manifest_id)) and b.CONDITION_ID is not null order by b.item_id, b.unit_no";
			 //die("if called");
			 //================ Tested Data tab End =======================//
			}else{

				//$manifest_list_qry = "SELECT DISTINCT B.LZ_MANIFEST_ID,MT.MANIFEST_NAME FROM LZ_BARCODE_MT B,LZ_MANIFEST_MT MT WHERE B.LZ_MANIFEST_ID IN (SELECT M.LZ_MANIFEST_ID FROM LZ_MANIFEST_MT M WHERE M.POSTED = 'POSTED' AND M.SINGLE_ENTRY_ID IS NULL AND M.GRN_ID IS NOT NULL) AND B.CONDITION_ID IS NULL AND MT.LZ_MANIFEST_ID = B.LZ_MANIFEST_ID AND MT.MANIFEST_NAME IS NOT NULL";
				
				//======================== Un-Tested Data tab Start =============================//
				$un_tested_qry = "select b.unit_no, b.barcode_no it_barcode, b.print_status, v.ITEM_CONDITION, v.ITEM_MT_DESC, v.MANUFACTURER, v.MFG_PART_NO, v.UPC, v.AVAIL_QTY, v.ITEM_ID, v.LZ_MANIFEST_ID, v.PURCH_REF_NO, v.laptop_item_code from lz_barcode_mt b, (SELECT im.item_desc ITEM_MT_DESC, im.item_mt_manufacture MANUFACTURER, im.ITEM_MT_BBY_SKU, im.ITEM_MT_UPC UPC, im.ITEM_MT_MFG_PART_NO MFG_PART_NO, im.item_condition, ld.laptop_item_code, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, lm.purchase_date, IM.ITEM_ID, LM.LOADING_NO, LM.LOADING_DATE, sum(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0)) PO_DETAIL_RETIAL_PRICE, SUM(NVL(LD.AVAILABLE_QTY, 0)) AVAIL_QTY, IM.Item_Code FROM LZ_MANIFEST_MT LM, LZ_MANIFEST_DET LD, ITEMS_MT IM WHERE LM.LZ_MANIFEST_ID = LD.LZ_MANIFEST_ID AND IM.ITEM_CODE = LD.LAPTOP_ITEM_CODE GROUP BY im.item_desc, im.item_mt_manufacture, ld.laptop_item_code, IM.ITEM_ID, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, lM.purchase_date, LM.LOADING_NO, LM.LOADING_DATE, im.ITEM_MT_BBY_SKU, im.ITEM_MT_UPC, im.ITEM_MT_MFG_PART_NO, im.item_condition, IM.Item_Code ) v where b.item_id = v.item_id and b.lz_manifest_id = v.LZ_MANIFEST_ID and v.purch_ref_no = to_char('$test_manifest_id') and b.CONDITION_ID is null order by b.item_id, b.unit_no";
				//======================== Un-Tested Data tab End =============================//
				$tested_qry = "select b.unit_no, b.barcode_no it_barcode, b.print_status, b.CONDITION_ID, v.ITEM_MT_DESC, v.MANUFACTURER, v.MFG_PART_NO, v.UPC, v.AVAIL_QTY, v.ITEM_ID, v.LZ_MANIFEST_ID, v.PURCH_REF_NO, v.laptop_item_code from lz_barcode_mt b, (SELECT im.item_desc ITEM_MT_DESC, im.item_mt_manufacture MANUFACTURER, im.ITEM_MT_BBY_SKU, im.ITEM_MT_UPC UPC, im.ITEM_MT_MFG_PART_NO MFG_PART_NO, im.item_condition, ld.laptop_item_code, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, lm.purchase_date, IM.ITEM_ID, LM.LOADING_NO, LM.LOADING_DATE, sum(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0)) PO_DETAIL_RETIAL_PRICE, SUM(NVL(LD.AVAILABLE_QTY, 0)) AVAIL_QTY, IM.Item_Code FROM LZ_MANIFEST_MT LM, LZ_MANIFEST_DET LD, ITEMS_MT IM WHERE LM.LZ_MANIFEST_ID = LD.LZ_MANIFEST_ID AND IM.ITEM_CODE = LD.LAPTOP_ITEM_CODE GROUP BY im.item_desc, im.item_mt_manufacture, ld.laptop_item_code, IM.ITEM_ID, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, lM.purchase_date, LM.LOADING_NO, LM.LOADING_DATE, im.ITEM_MT_BBY_SKU, im.ITEM_MT_UPC, im.ITEM_MT_MFG_PART_NO, im.item_condition, IM.Item_Code ) v where b.item_id = v.item_id and b.lz_manifest_id = v.LZ_MANIFEST_ID and v.purch_ref_no = to_char('$test_manifest_id') and b.CONDITION_ID is not null order by b.item_id, b.unit_no";
			}
        $un_tested_qry =$this->db->query($un_tested_qry);
        $un_tested_qry = $un_tested_qry->result_array();
 
        $tested_qry =$this->db->query($tested_qry);
        $tested_qry = $tested_qry->result_array();

		$manifest_list_qry = "SELECT DISTINCT B.LZ_MANIFEST_ID,MT.MANIFEST_NAME FROM LZ_BARCODE_MT B,LZ_MANIFEST_MT MT WHERE B.LZ_MANIFEST_ID IN (SELECT M.LZ_MANIFEST_ID FROM LZ_MANIFEST_MT M WHERE M.POSTED = 'Posted' AND M.SINGLE_ENTRY_ID IS NULL AND M.GRN_ID IS NOT NULL) AND B.CONDITION_ID IS NULL AND MT.LZ_MANIFEST_ID = B.LZ_MANIFEST_ID AND MT.MANIFEST_NAME IS NOT NULL";
		$manifest_list_qry =$this->db->query($manifest_list_qry);
        $manifest_list_qry = $manifest_list_qry->result_array();
           

        return array('un_tested_qry' => $un_tested_qry, 'tested_qry'=>$tested_qry, 'manifest_list_qry'=>$manifest_list_qry);	

	}
	public function manifestFilters(){

				$manifest_list_qry = "SELECT DISTINCT B.LZ_MANIFEST_ID,MT.MANIFEST_NAME FROM LZ_BARCODE_MT B,LZ_MANIFEST_MT MT WHERE B.LZ_MANIFEST_ID IN (SELECT M.LZ_MANIFEST_ID FROM LZ_MANIFEST_MT M WHERE M.POSTED = 'Posted' AND M.SINGLE_ENTRY_ID IS NULL AND M.GRN_ID IS NOT NULL) AND B.CONDITION_ID IS NULL AND MT.LZ_MANIFEST_ID = B.LZ_MANIFEST_ID AND MT.MANIFEST_NAME IS NOT NULL";
				$manifest_list_qry =$this->db->query($manifest_list_qry);
		    $manifest_list_qry = $manifest_list_qry->result_array();	    

        $manifest_id = $this->input->post('manifest_list');
        $manifest_filter = $this->input->post('manifest_filter');
        
        if(!empty($manifest_id)){
        //  ====================== Total Manifest Entries Inserted  Start =============================//
        $total_entries = "SELECT T.TOTAL_EXCEL_ROWS FROM LZ_MANIFEST_MT T WHERE T.LZ_MANIFEST_ID = $manifest_id";

        $total_entries =$this->db->query($total_entries);
        $total_entries = $total_entries->result_array();
        //  ====================== Total Manifest Entries Inserted End =============================//


        //======================== Unique Item in Manifest Start =============================//
        $unique_item = "SELECT count(LAPTOP_ZONE_ID) UNQ_COUNT FROM (SELECT * FROM LZ_MANIFEST_DET D WHERE D.LAPTOP_ZONE_ID IN (SELECT MAX(LAPTOP_ZONE_ID) FROM LZ_MANIFEST_DET DET WHERE LZ_MANIFEST_ID = $manifest_id GROUP BY DET.ITEM_MT_MFG_PART_NO, DET.ITEM_MT_UPC) AND D.LZ_MANIFEST_ID = $manifest_id)";
        $unique_item =$this->db->query($unique_item);
        $unique_item = $unique_item->result_array();
         
        //======================== Unique Item in Manifest Start =============================//
			}

        //======================== Specific count in Manifest Start =============================//
        // $assigned_spec_qry = "SELECT DISTINCT M.ITEM_ID FROM LZ_ITEM_SPECIFICS_MT M WHERE M.ITEM_ID IN (SELECT DISTINCT I.ITEM_ID FROM ITEMS_MT I WHERE I.ITEM_CODE IN (SELECT DISTINCT D.LAPTOP_ITEM_CODE FROM LZ_MANIFEST_DET D WHERE D.LZ_MANIFEST_ID = $manifest_id))"; 
        // $assigned_spec_qry =$this->db->query($assigned_spec_qry);
        // $assigned_spec_qry = $assigned_spec_qry->result_array();

        // $total_spec_qry = "SELECT DISTINCT I.ITEM_ID FROM ITEMS_MT I WHERE I.ITEM_CODE IN (SELECT DISTINCT D.LAPTOP_ITEM_CODE FROM LZ_MANIFEST_DET D WHERE D.LZ_MANIFEST_ID = $manifest_id)"; 
        // $total_spec_qry =$this->db->query($total_spec_qry);
        // $total_spec_qry = $total_spec_qry->result_array();        
         
        //======================== Specific count in Manifest Start =============================//


        if($manifest_filter == 'tested'){

					$filter_qry = "SELECT B.PO_DETAIL_LOT_REF, B.UNIT_NO, B.BARCODE_NO IT_BARCODE, B.ITEM_ID, B.PRINT_STATUS, B.CONDITION_ID ITEM_CONDITION, V.ITEM_MT_DESC, V.MANUFACTURER, V.MFG_PART_NO, V.UPC, V.AVAIL_QTY, V.ITEM_ID, V.LZ_MANIFEST_ID, V.PURCH_REF_NO, V.LAPTOP_ITEM_CODE, V.BRAND_SEG3, V.E_BAY_CATA_ID_SEG6 FROM LZ_BARCODE_MT B, (SELECT IM.ITEM_DESC ITEM_MT_DESC, IM.ITEM_MT_MANUFACTURE MANUFACTURER, IM.ITEM_MT_BBY_SKU, IM.ITEM_MT_UPC UPC, IM.ITEM_MT_MFG_PART_NO MFG_PART_NO, IM.ITEM_CONDITION, LD.LAPTOP_ITEM_CODE, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, LM.PURCHASE_DATE, IM.ITEM_ID, LM.LOADING_NO, LM.LOADING_DATE,LD.BRAND_SEG3, LD.E_BAY_CATA_ID_SEG6, SUM(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0)) PO_DETAIL_RETIAL_PRICE, SUM(NVL(LD.AVAILABLE_QTY, 0)) AVAIL_QTY, IM.ITEM_CODE FROM LZ_MANIFEST_MT LM, LZ_MANIFEST_DET LD, ITEMS_MT IM WHERE LM.LZ_MANIFEST_ID = LD.LZ_MANIFEST_ID AND IM.ITEM_CODE = LD.LAPTOP_ITEM_CODE GROUP BY IM.ITEM_DESC, IM.ITEM_MT_MANUFACTURE, LD.LAPTOP_ITEM_CODE, IM.ITEM_ID, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, LM.PURCHASE_DATE, LM.LOADING_NO, LM.LOADING_DATE, IM.ITEM_MT_BBY_SKU, IM.ITEM_MT_UPC, IM.ITEM_MT_MFG_PART_NO, IM.ITEM_CONDITION, IM.ITEM_CODE, LD.BRAND_SEG3, LD.E_BAY_CATA_ID_SEG6 ) V WHERE B.ITEM_ID = V.ITEM_ID AND B.LZ_MANIFEST_ID = $manifest_id AND V.LZ_MANIFEST_ID = $manifest_id AND B.CONDITION_ID IS NOT NULL ORDER BY B.ITEM_ID, B.UNIT_NO";
		      $this->session->set_userdata('tested', TRUE);
		      $this->session->set_userdata('manifest_id', $manifest_id); 
	        $filter_qry =$this->db->query($filter_qry);
	        $filter_qry = $filter_qry->result_array();

			/*=============================================
        = Checklist check on tests view block   =
        =============================================*/
        
			$checklist_qry = "SELECT DISTINCT BN.CATEGORY_ID, M.CHECKLIST_NAME FROM LZ_CATEGORY_CHECKLIST_BIND BN, LZ_CHECKLIST_MT M, (SELECT D.E_BAY_CATA_ID_SEG6 FROM LZ_MANIFEST_DET D WHERE D.E_BAY_CATA_ID_SEG6 NOT IN ('N/A', 'Other', 'OTHER', 'other') AND D.LZ_MANIFEST_ID = $manifest_id) Q1 WHERE BN.CATEGORY_ID = Q1.E_BAY_CATA_ID_SEG6 AND M.CHECKLIST_MT_ID = BN.CHECKLIST_MT_ID";

	        $checklist_qry =$this->db->query($checklist_qry);
	        $checklist_qry = $checklist_qry->result_array();				
        /*=====  End Checklist check on tests view block  ======*/

			/*=============================================
        = specific check on tests view block   =
        =============================================*/
        
			$specific_qry = "SELECT DISTINCT M.ITEM_ID FROM LZ_ITEM_SPECIFICS_MT M, LZ_BARCODE_MT B WHERE M.ITEM_ID = B.ITEM_ID AND B.LZ_MANIFEST_ID = $manifest_id";
	        $specific_qry =$this->db->query($specific_qry);
	        $specific_qry = $specific_qry->result_array();				
        /*=====  End specific check on tests view block  ======*/        

				}elseif($manifest_filter == 'un_tested'){

					$filter_qry = "SELECT B.PO_DETAIL_LOT_REF, B.UNIT_NO, B.BARCODE_NO IT_BARCODE, B.ITEM_ID, B.PRINT_STATUS, B.CONDITION_ID ITEM_CONDITION, V.ITEM_MT_DESC, V.MANUFACTURER, V.MFG_PART_NO, V.UPC, V.AVAIL_QTY, V.ITEM_ID, V.LZ_MANIFEST_ID, V.PURCH_REF_NO, V.LAPTOP_ITEM_CODE, V.BRAND_SEG3, V.E_BAY_CATA_ID_SEG6 FROM LZ_BARCODE_MT B, (SELECT IM.ITEM_DESC ITEM_MT_DESC, IM.ITEM_MT_MANUFACTURE MANUFACTURER, IM.ITEM_MT_BBY_SKU, IM.ITEM_MT_UPC UPC, IM.ITEM_MT_MFG_PART_NO MFG_PART_NO, IM.ITEM_CONDITION, LD.LAPTOP_ITEM_CODE, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, LM.PURCHASE_DATE, IM.ITEM_ID, LM.LOADING_NO, LM.LOADING_DATE, LD.BRAND_SEG3, LD.E_BAY_CATA_ID_SEG6, SUM(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0)) PO_DETAIL_RETIAL_PRICE, SUM(NVL(LD.AVAILABLE_QTY, 0)) AVAIL_QTY, IM.ITEM_CODE FROM LZ_MANIFEST_MT LM, LZ_MANIFEST_DET LD, ITEMS_MT IM WHERE LM.LZ_MANIFEST_ID = LD.LZ_MANIFEST_ID AND IM.ITEM_CODE = LD.LAPTOP_ITEM_CODE GROUP BY IM.ITEM_DESC, IM.ITEM_MT_MANUFACTURE, LD.LAPTOP_ITEM_CODE, IM.ITEM_ID, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, LM.PURCHASE_DATE, LM.LOADING_NO, LM.LOADING_DATE, IM.ITEM_MT_BBY_SKU, IM.ITEM_MT_UPC, IM.ITEM_MT_MFG_PART_NO, IM.ITEM_CONDITION, IM.ITEM_CODE, LD.BRAND_SEG3, LD.E_BAY_CATA_ID_SEG6 ) V WHERE B.ITEM_ID = V.ITEM_ID AND B.LZ_MANIFEST_ID = V.LZ_MANIFEST_ID AND (B.LZ_MANIFEST_ID = $manifest_id) AND B.CONDITION_ID IS NULL ORDER BY B.ITEM_ID, B.UNIT_NO";

					$this->session->set_userdata('un_tested', TRUE);
					$this->session->set_userdata('manifest_id', $manifest_id);  

	        $filter_qry =$this->db->query($filter_qry);
	        $filter_qry = $filter_qry->result_array();

			/*=============================================
        = Checklist check on tests view block   =
        =============================================*/
        
			$checklist_qry = "SELECT DISTINCT BN.CATEGORY_ID, M.CHECKLIST_NAME FROM LZ_CATEGORY_CHECKLIST_BIND BN, LZ_CHECKLIST_MT M, (SELECT D.E_BAY_CATA_ID_SEG6 FROM LZ_MANIFEST_DET D WHERE D.E_BAY_CATA_ID_SEG6 NOT IN ('N/A', 'Other', 'OTHER', 'other') AND D.LZ_MANIFEST_ID = $manifest_id) Q1 WHERE BN.CATEGORY_ID = Q1.E_BAY_CATA_ID_SEG6 AND M.CHECKLIST_MT_ID = BN.CHECKLIST_MT_ID";

	        $checklist_qry =$this->db->query($checklist_qry);
	        $checklist_qry = $checklist_qry->result_array();				
        /*=====  End Checklist check on tests view block  ======*/

			/*=============================================
        = specific check on tests view block   =
        =============================================*/
        
			$specific_qry = "SELECT DISTINCT M.ITEM_ID FROM LZ_ITEM_SPECIFICS_MT M, LZ_BARCODE_MT B WHERE M.ITEM_ID = B.ITEM_ID AND B.LZ_MANIFEST_ID = $manifest_id";
	        $specific_qry =$this->db->query($specific_qry);
	        $specific_qry = $specific_qry->result_array();				
        /*=====  End specific check on tests view block  ======*/           

        }elseif($manifest_filter == 'all'){

					$filter_qry = "SELECT B.PO_DETAIL_LOT_REF, B.UNIT_NO, B.BARCODE_NO IT_BARCODE, B.ITEM_ID, B.PRINT_STATUS, B.CONDITION_ID ITEM_CONDITION, V.ITEM_MT_DESC, V.MANUFACTURER, V.MFG_PART_NO, V.UPC, V.AVAIL_QTY, V.ITEM_ID, V.LZ_MANIFEST_ID, V.PURCH_REF_NO, V.LAPTOP_ITEM_CODE, V.BRAND_SEG3, V.E_BAY_CATA_ID_SEG6 FROM LZ_BARCODE_MT B, (SELECT IM.ITEM_DESC ITEM_MT_DESC, IM.ITEM_MT_MANUFACTURE MANUFACTURER, IM.ITEM_MT_BBY_SKU, IM.ITEM_MT_UPC UPC, IM.ITEM_MT_MFG_PART_NO MFG_PART_NO, IM.ITEM_CONDITION, LD.LAPTOP_ITEM_CODE, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, LM.PURCHASE_DATE, IM.ITEM_ID, LM.LOADING_NO, LM.LOADING_DATE, LD.BRAND_SEG3, LD.E_BAY_CATA_ID_SEG6, SUM(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0)) PO_DETAIL_RETIAL_PRICE, SUM(NVL(LD.AVAILABLE_QTY, 0)) AVAIL_QTY, IM.ITEM_CODE FROM LZ_MANIFEST_MT LM, LZ_MANIFEST_DET LD, ITEMS_MT IM WHERE LM.LZ_MANIFEST_ID = LD.LZ_MANIFEST_ID AND IM.ITEM_CODE = LD.LAPTOP_ITEM_CODE GROUP BY IM.ITEM_DESC, IM.ITEM_MT_MANUFACTURE, LD.LAPTOP_ITEM_CODE, IM.ITEM_ID, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, LM.PURCHASE_DATE, LM.LOADING_NO, LM.LOADING_DATE, IM.ITEM_MT_BBY_SKU, IM.ITEM_MT_UPC, IM.ITEM_MT_MFG_PART_NO, IM.ITEM_CONDITION, IM.ITEM_CODE, LD.BRAND_SEG3, LD.E_BAY_CATA_ID_SEG6 ) V WHERE B.ITEM_ID = V.ITEM_ID AND B.LZ_MANIFEST_ID = V.LZ_MANIFEST_ID AND (B.LZ_MANIFEST_ID = $manifest_id) ORDER BY B.ITEM_ID, B.UNIT_NO"; 
					$this->session->set_userdata('all', TRUE);
					$this->session->set_userdata('manifest_id', $manifest_id); 

        $filter_qry =$this->db->query($filter_qry);
        $filter_qry = $filter_qry->result_array();

			/*=============================================
        = Checklist check on tests view block   =
        =============================================*/
        
			$checklist_qry = "SELECT DISTINCT BN.CATEGORY_ID, M.CHECKLIST_NAME FROM LZ_CATEGORY_CHECKLIST_BIND BN, LZ_CHECKLIST_MT M, (SELECT D.E_BAY_CATA_ID_SEG6 FROM LZ_MANIFEST_DET D WHERE D.E_BAY_CATA_ID_SEG6 NOT IN ('N/A', 'Other', 'OTHER', 'other') AND D.LZ_MANIFEST_ID = $manifest_id) Q1 WHERE BN.CATEGORY_ID = Q1.E_BAY_CATA_ID_SEG6 AND M.CHECKLIST_MT_ID = BN.CHECKLIST_MT_ID";
	        $checklist_qry =$this->db->query($checklist_qry);
	        $checklist_qry = $checklist_qry->result_array();				
        /*=====  End Checklist check on tests view block  ======*/

			/*=============================================
        = specific check on tests view block   =
        =============================================*/
        
			$specific_qry = "SELECT DISTINCT M.ITEM_ID FROM LZ_ITEM_SPECIFICS_MT M, LZ_BARCODE_MT B WHERE M.ITEM_ID = B.ITEM_ID AND B.LZ_MANIFEST_ID = $manifest_id";
	        $specific_qry =$this->db->query($specific_qry);
	        $specific_qry = $specific_qry->result_array();				
        /*=====  End specific check on tests view block  ======*/           
                

        }else{
        	$filter_qry = null;
        }
			if($this->input->post('tested_untested')){
					/*=============================================
					=            Test Result count block            =
					 =============================================*/
		        
					$test_count_qry = "SELECT COUNT(1) TESTED_COUNT FROM (SELECT B.UNIT_NO, B.BARCODE_NO IT_BARCODE, B.PRINT_STATUS, B.CONDITION_ID, V.ITEM_MT_DESC, V.MANUFACTURER, V.MFG_PART_NO, V.UPC, V.AVAIL_QTY, V.ITEM_ID, V.LZ_MANIFEST_ID, V.PURCH_REF_NO, V.LAPTOP_ITEM_CODE, V.BRAND_SEG3 FROM LZ_BARCODE_MT B, (SELECT IM.ITEM_DESC ITEM_MT_DESC, IM.ITEM_MT_MANUFACTURE MANUFACTURER, IM.ITEM_MT_BBY_SKU, IM.ITEM_MT_UPC UPC, IM.ITEM_MT_MFG_PART_NO MFG_PART_NO, IM.ITEM_CONDITION, LD.LAPTOP_ITEM_CODE, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, LM.PURCHASE_DATE, IM.ITEM_ID, LM.LOADING_NO, LM.LOADING_DATE, LD.BRAND_SEG3, SUM(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0)) PO_DETAIL_RETIAL_PRICE, SUM(NVL(LD.AVAILABLE_QTY, 0)) AVAIL_QTY, IM.ITEM_CODE FROM LZ_MANIFEST_MT LM, LZ_MANIFEST_DET LD, ITEMS_MT IM WHERE LM.LZ_MANIFEST_ID = LD.LZ_MANIFEST_ID AND IM.ITEM_CODE = LD.LAPTOP_ITEM_CODE GROUP BY IM.ITEM_DESC, IM.ITEM_MT_MANUFACTURE, LD.LAPTOP_ITEM_CODE, IM.ITEM_ID, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, LM.PURCHASE_DATE, LM.LOADING_NO, LM.LOADING_DATE, IM.ITEM_MT_BBY_SKU, IM.ITEM_MT_UPC, IM.ITEM_MT_MFG_PART_NO, IM.ITEM_CONDITION, IM.ITEM_CODE, LD.BRAND_SEG3) V WHERE B.ITEM_ID = V.ITEM_ID AND B.LZ_MANIFEST_ID = $manifest_id AND B.CONDITION_ID IS NOT NULL ORDER BY B.ITEM_ID, B.UNIT_NO)";

		        $test_count_qry =$this->db->query($test_count_qry);
		        $test_count_qry = $test_count_qry->result_array();        
		        
		        /*=====  End of Test Result count block  ======*/

						/*=============================================
                =            Un-Test result count block            =
                =============================================*/
				$untested_count_qry = "SELECT COUNT(1) UN_TESTED_QTY FROM  LZ_BARCODE_MT B WHERE B.LZ_MANIFEST_ID= $manifest_id AND B.CONDITION_ID IS NULL";
	        	$untested_count_qry =$this->db->query($untested_count_qry);
	        	$untested_count_qry = $untested_count_qry->result_array();                 
                
                
                /*=====  End of Un-Test result count block  ======*/
                                
						/*=============================================
						=            Section comment block            =
						=============================================*/

				$assigned_count_qry = "SELECT COUNT(DISTINCT DT.E_BAY_CATA_ID_SEG6) UNQ_CAT FROM LZ_MANIFEST_DET DT WHERE DT.E_BAY_CATA_ID_SEG6 IS NOT NULL AND DT.E_BAY_CATA_ID_SEG6 <> 'N/A'AND DT.LZ_MANIFEST_ID = $manifest_id"; 
				$assigned_count_qry =$this->db->query($assigned_count_qry);
	        	$assigned_count_qry = $assigned_count_qry->result_array();  

				/*=====  End of Section comment block  ======*/

						/*=============================================
						=            Section comment block            =
						=============================================*/

				$uniq_cat_qry = "SELECT COUNT(DISTINCT DT.E_BAY_CATA_ID_SEG6) UNQ_CAT FROM LZ_MANIFEST_DET DT WHERE DT.E_BAY_CATA_ID_SEG6 IS NOT NULL AND DT.E_BAY_CATA_ID_SEG6 <> 'N/A'AND DT.LZ_MANIFEST_ID = $manifest_id"; 
				$uniq_cat_qry =$this->db->query($uniq_cat_qry);
	        	$uniq_cat_qry = $uniq_cat_qry->result_array();  

				/*=====  End of Section comment block  ======*/

						/*=============================================
						=            Section comment block            =
						=============================================*/

				$un_assigned_count_qry = "SELECT COUNT(DISTINCT DT.E_BAY_CATA_ID_SEG6) UN_ASIGN_CAT FROM LZ_MANIFEST_DET DT WHERE DT.E_BAY_CATA_ID_SEG6 IS  NULL AND DT.E_BAY_CATA_ID_SEG6 <> 'N/A'AND DT.LZ_MANIFEST_ID = $manifest_id"; 
				$un_assigned_count_qry =$this->db->query($un_assigned_count_qry);
		        $un_assigned_count_qry = $un_assigned_count_qry->result_array();  

				/*=====  End of Section comment block  ======*/
				return array('filter_qry' => $filter_qry, 'manifest_list_qry'=>$manifest_list_qry, 'test_count_qry'=>$test_count_qry, 'untested_count_qry'=>$untested_count_qry, 'assigned_count_qry'=>$assigned_count_qry, 'un_assigned_count_qry'=>$un_assigned_count_qry, 'checklist'=>$checklist_qry, 'specific_qry'=>$specific_qry, 'total_entries'=>$total_entries, 'unique_item'=>$unique_item, 'uniq_cat_qry'=>$uniq_cat_qry);    				
			}else{
        return array('filter_qry' => $filter_qry, 'manifest_list_qry'=>$manifest_list_qry, 'test_count_qry'=>null, 'untested_count_qry'=>null, 'assigned_count_qry'=>null, 'un_assigned_count_qry'=>null, 'checklist'=>null, 'specific_qry'=>null, 'total_entries'=>null, 'unique_item'=>null, 'uniq_cat_qry'=>null);         

			}
	}
	public function showChecklistDetail(){

		$cat_id = $this->input->post('cat_id');
		$manifest_id = $this->input->post('manifest_list');

		$checklist_qry = "SELECT DISTINCT BN.CATEGORY_ID, M.CHECKLIST_NAME, Q1.BRAND_SEG3 FROM LZ_CATEGORY_CHECKLIST_BIND BN, LZ_CHECKLIST_MT M, (SELECT D.E_BAY_CATA_ID_SEG6, D.BRAND_SEG3 FROM LZ_MANIFEST_DET D WHERE D.E_BAY_CATA_ID_SEG6 NOT IN ('N/A', 'Other', 'OTHER', 'other') AND D.LZ_MANIFEST_ID = $manifest_id) Q1 WHERE BN.CATEGORY_ID = Q1.E_BAY_CATA_ID_SEG6 AND M.CHECKLIST_MT_ID = BN.CHECKLIST_MT_ID AND BN.CATEGORY_ID = $cat_id"; 
		$checklist_qry =$this->db->query($checklist_qry);

        return $checklist_qry->result_array();      				

	}
	function search_barcode($perameter){
	/*=====================================================
		=            check barcode and apply color            =
		=====================================================*/
		
		$tested_barcode = $this->db->query("SELECT * FROM LZ_TESTING_DATA WHERE LZ_BARCODE_ID = (SELECT LZ_BARCODE_MT_ID FROM LZ_BARCODE_MT WHERE BARCODE_NO = $perameter)");
		 $tested_barcode->result_array();
		//var_dump($tested_barcode);exit;
		//$tested_barcode = $tested_barcode->result_array();

	      if($tested_barcode->num_rows() == 0){
	          return true;
	      }elseif($tested_barcode->num_rows() > 0){
	      	return false;
	      }		
			
		
		/*=====  End of check barcode and apply color  ======*/		
	}
	function load_tested_data($item_id, $manifest_id, $perameter){
	/*=====================================================
		=            check barcode and apply color            =
		=====================================================*/

		$alert_tested = $this->db->query("SELECT LZ_BARCODE_ID FROM LZ_TESTING_DATA WHERE LZ_BARCODE_ID = (SELECT LZ_BARCODE_MT_ID FROM LZ_BARCODE_MT WHERE BARCODE_NO = $perameter)");

		$holded_item_qry = $this->db->query("SELECT BARCODE_NO FROM LZ_BARCODE_HOLD_LOG WHERE ACTION = 1 AND BARCODE_NO IN (SELECT B.BARCODE_NO FROM LZ_BARCODE_MT B WHERE B.ITEM_ID = $item_id AND B.LZ_MANIFEST_ID = $manifest_id)");

		$not_tested_barcode = $this->db->query("SELECT B.BARCODE_NO FROM LZ_BARCODE_MT B WHERE B.ITEM_ID = $item_id AND B.LZ_MANIFEST_ID = $manifest_id and B.CONDITION_ID is null order by B.BARCODE_NO ");

		
		//$tested_data = $this->db->query("SELECT DISTINCT T.LZ_BARCODE_ID FROM LZ_TESTING_DATA T WHERE T.LZ_BARCODE_ID IN (SELECT B.BARCODE_NO FROM LZ_BARCODE_MT B WHERE B.ITEM_ID = $item_id AND B.LZ_MANIFEST_ID = $manifest_id) order by T.LZ_BARCODE_ID"); 
		//// Commented by imran 2-june-2018
		$tested_data = $this->db->query("SELECT  DISTINCT B.BARCODE_NO LZ_BARCODE_ID FROM LZ_TESTING_DATA T , LZ_BARCODE_MT B WHERE  T.LZ_BARCODE_ID = B.LZ_BARCODE_MT_ID AND B.ITEM_ID =  $item_id AND B.LZ_MANIFEST_ID = $manifest_id ORDER BY B.BARCODE_NO");

		//var_dump($tested_data);exit;
		//$tested_data = $tested_data->result_array();

	      if($tested_data->num_rows() == 0){
	          return true;
	      }elseif($tested_data->num_rows() > 0){
			$tested_barcode = $tested_data->result_array();
	      	$not_tested_barcode = $not_tested_barcode->result_array();
	      	$holded_item_qry = $holded_item_qry->result_array();	      	
	      	if($alert_tested->num_rows() > 0){
	      		$alert_tested = $alert_tested->result_array();	
				return array('tested_barcode' => $tested_barcode, 'not_tested_barcode'=>$not_tested_barcode, 'alert_tested'=>$alert_tested, 'holded_item_qry'=>$holded_item_qry);
	      	}else{
	      		return array('tested_barcode' => $tested_barcode, 'not_tested_barcode'=>$not_tested_barcode, 'alert_tested'=>false, 'holded_item_qry'=>$holded_item_qry);
	      	}
	      	
	      		
	      	// return $tested_data;
	      }		
			
		
		/*=====  End of check barcode and apply color  ======*/		
	}
	function hold_item(){
		$hold_barcode = $this->input->post('hold_barcode');
		$user_id = $this->session->userdata('user_id');
		date_default_timezone_set("America/Chicago");
		$current_date = date("Y-m-d H:i:s");
		$current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";
		$comma = ',';
		
			foreach($hold_barcode as $barcode){

		    	$get_pk = $this->db->query("SELECT get_single_primary_key('LZ_BARCODE_HOLD_LOG','LZ_HOLD_ID') LZ_HOLD_ID FROM DUAL");
				$get_pk = $get_pk->result_array();
				$lz_hold_id = $get_pk[0]['LZ_HOLD_ID'];
					
				$qry = "INSERT INTO LZ_BARCODE_HOLD_LOG VALUES ($lz_hold_id $comma $barcode $comma $current_date $comma 1 $comma $user_id)";
				$this->db->query($qry);


	    		$hold_qry = "UPDATE LZ_BARCODE_MT SET HOLD_STATUS = 1 WHERE BARCODE_NO = $barcode ";
				$hold_status = $this->db->query($hold_qry);


			}//barcode foreach
			if($hold_status){
				return true;
			}else {
				return false;
			}

	}
	function hold_item_detail($manifest_id){
		// var_dump($manifest_id);exit;
		if(!empty($manifest_id)){
			$hold_item_qry = "select b.unit_no, b.barcode_no it_barcode, b.print_status, v.ITEM_CONDITION, v.ITEM_MT_DESC, v.MANUFACTURER, v.MFG_PART_NO, v.UPC, v.AVAIL_QTY, v.ITEM_ID, v.LZ_MANIFEST_ID, v.PURCH_REF_NO, v.laptop_item_code from lz_barcode_mt b, (SELECT im.item_desc ITEM_MT_DESC, im.item_mt_manufacture MANUFACTURER, im.ITEM_MT_BBY_SKU, im.ITEM_MT_UPC UPC, im.ITEM_MT_MFG_PART_NO MFG_PART_NO, im.item_condition, ld.laptop_item_code, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, lm.purchase_date, IM.ITEM_ID, LM.LOADING_NO, LM.LOADING_DATE, sum(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0)) PO_DETAIL_RETIAL_PRICE, SUM(NVL(LD.AVAILABLE_QTY, 0)) AVAIL_QTY, IM.Item_Code FROM LZ_MANIFEST_MT LM, LZ_MANIFEST_DET LD, ITEMS_MT IM WHERE LM.LZ_MANIFEST_ID = LD.LZ_MANIFEST_ID AND IM.ITEM_CODE = LD.LAPTOP_ITEM_CODE GROUP BY im.item_desc, im.item_mt_manufacture, ld.laptop_item_code, IM.ITEM_ID, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, lM.purchase_date, LM.LOADING_NO, LM.LOADING_DATE, im.ITEM_MT_BBY_SKU, im.ITEM_MT_UPC, im.ITEM_MT_MFG_PART_NO, im.item_condition, IM.Item_Code ) v where b.item_id = v.item_id and b.lz_manifest_id = v.LZ_MANIFEST_ID and (b.lz_manifest_id = $manifest_id or v.purch_ref_no = to_char($manifest_id)) and HOLD_STATUS = 1 order by b.item_id, b.unit_no";
			

		}else{
			$manifest_id = $this->input->post('hold_manifest_id');
			$hold_item_qry = "select b.unit_no, b.barcode_no it_barcode, b.print_status, v.ITEM_CONDITION, v.ITEM_MT_DESC, v.MANUFACTURER, v.MFG_PART_NO, v.UPC, v.AVAIL_QTY, v.ITEM_ID, v.LZ_MANIFEST_ID, v.PURCH_REF_NO, v.laptop_item_code from lz_barcode_mt b, (SELECT im.item_desc ITEM_MT_DESC, im.item_mt_manufacture MANUFACTURER, im.ITEM_MT_BBY_SKU, im.ITEM_MT_UPC UPC, im.ITEM_MT_MFG_PART_NO MFG_PART_NO, im.item_condition, ld.laptop_item_code, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, lm.purchase_date, IM.ITEM_ID, LM.LOADING_NO, LM.LOADING_DATE, sum(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0)) PO_DETAIL_RETIAL_PRICE, SUM(NVL(LD.AVAILABLE_QTY, 0)) AVAIL_QTY, IM.Item_Code FROM LZ_MANIFEST_MT LM, LZ_MANIFEST_DET LD, ITEMS_MT IM WHERE LM.LZ_MANIFEST_ID = LD.LZ_MANIFEST_ID AND IM.ITEM_CODE = LD.LAPTOP_ITEM_CODE GROUP BY im.item_desc, im.item_mt_manufacture, ld.laptop_item_code, IM.ITEM_ID, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, lM.purchase_date, LM.LOADING_NO, LM.LOADING_DATE, im.ITEM_MT_BBY_SKU, im.ITEM_MT_UPC, im.ITEM_MT_MFG_PART_NO, im.item_condition, IM.Item_Code ) v where b.item_id = v.item_id and b.lz_manifest_id = v.LZ_MANIFEST_ID and (b.lz_manifest_id = $manifest_id or v.purch_ref_no = to_char($manifest_id)) and HOLD_STATUS = 1 order by b.item_id, b.unit_no";
			
		}
			$hold_item_qry =$this->db->query($hold_item_qry);
	        return $hold_item_qry->result_array(); 

		
			
			 	
	}
	function un_hold_item(){
		$barcode = $this->input->post('unhold_item');
		$user_id = $this->session->userdata('user_id');
		date_default_timezone_set("America/Chicago");
		$current_date = date("Y-m-d H:i:s");
		$current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";
		$comma = ',';
		
		$un_hold_qry = "UPDATE LZ_BARCODE_HOLD_LOG SET ACTION = 0, TIME_STAMP = $current_date, USER_ID = $user_id WHERE BARCODE_NO = $barcode";
		$this->db->query($un_hold_qry);


		$un_hold_stat_qry = "UPDATE LZ_BARCODE_MT SET HOLD_STATUS = 0 WHERE BARCODE_NO = $barcode ";
		$un_hold_status = $this->db->query($un_hold_stat_qry);


			if($un_hold_status){
				return true;
			}else {
				return false;
			}		
	}
	function un_hold_all(){
		$unHold_barcode = $this->input->post('unHold_barcode');
		$user_id = $this->session->userdata('user_id');
		date_default_timezone_set("America/Chicago");
		$current_date = date("Y-m-d H:i:s");
		$current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";
		$comma = ',';
		
		foreach($unHold_barcode as $barcode){

			$un_hold_qry = "UPDATE LZ_BARCODE_HOLD_LOG SET ACTION = 0, TIME_STAMP = $current_date, USER_ID = $user_id WHERE BARCODE_NO = $barcode";
			$this->db->query($un_hold_qry);


			$un_hold_stat_qry = "UPDATE LZ_BARCODE_MT SET HOLD_STATUS = 0 WHERE BARCODE_NO = $barcode ";
			$un_hold_status = $this->db->query($un_hold_stat_qry);


		}//barcode foreach
		if($un_hold_status){
			return true;
		}else {
			return false;
		}

	}
	public function holdedUnholdedLog(){
    	$barcode_log = $this->db->query("SELECT L.BARCODE_NO, TO_CHAR(L.TIME_STAMP, 'YYYY-MM-DD HH24:MI:SS') AS TIME_STAMP, L.ACTION, L.USER_ID FROM LZ_BARCODE_HOLD_LOG L");
		return $barcode_log->result_array();		
	}
  	public function UsersList(){
    	$query = $this->db->query("SELECT T.EMPLOYEE_ID, T.USER_NAME FROM EMPLOYEE_MT T WHERE T.EMPLOYEE_ID NOT IN (19, 9, 10, 11, 12, 1, 7, 8, 6, 17, 15, 20)"); 
    	return $query->result_array();
  	}						

}

 ?>