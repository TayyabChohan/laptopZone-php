<?php
ini_set('memory_limit', '-1');
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
 
class m_bd_recognize_data extends CI_Model
{

	public function getCategorySpecifics(){
		$title_id = $this->input->post('title_id');
		$category_id = $this->input->post('category_id');
		$session_id = $this->session->userdata('session_tmp_id');


		$title_sql = "SELECT MATCHED_TITLE FROM LZ_BD_TMP_TITLE WHERE TITLE_ID = $title_id AND SESSION_ID = '$session_id'";
		$title_qry = $this->db->query($title_sql);
		$title_qry = $title_qry->result_array();
		$matched_title = ' ' . trim($title_qry[0]['MATCHED_TITLE']). ' ';
		/*===================================================
		=            match title with Specifics            =
		===================================================*/
		$specs_sql = "SELECT M.MT_ID,UPPER(M.SPECIFIC_NAME) AS SPECIFIC_NAME, D.DET_ID, UPPER(D.SPECIFIC_VALUE) AS SPECIFIC_VALUE FROM LAPTOP_ZONE.CATEGORY_SPECIFIC_MT  M, LAPTOP_ZONE.CATEGORY_SPECIFIC_DET D WHERE M.MT_ID = D.MT_ID AND '$matched_title' LIKE '% ' || UPPER(D.SPECIFIC_VALUE) || ' %'AND M.EBAY_CATEGORY_ID = $category_id ORDER BY LENGTH(D.SPECIFIC_VALUE) ASC"; 
		$specs_qry = $this->db->query($specs_sql);
		$specs_qry = $specs_qry->result_array();
		/*=====  End of match title with Specifics  ======*/
		/*===================================================
		=            match title with Alt Specifics            =
		===================================================*/
		$alt_specs_sql = "SELECT M.MT_ID,UPPER(M.SPECIFIC_NAME) AS SPECIFIC_NAME, D.DET_ID, UPPER(D.SPECIFIC_VALUE) AS SPECIFIC_VALUE FROM LAPTOP_ZONE.CATEGORY_SPECIFIC_MT  M, LAPTOP_ZONE.CATEGORY_SPECIFIC_DET D WHERE M.MT_ID = D.MT_ID AND '$matched_title' LIKE '% ' || UPPER(D.SPECIFIC_VALUE) || ' %'AND M.EBAY_CATEGORY_ID = $category_id ORDER BY LENGTH(D.SPECIFIC_VALUE) DESC"; 
		$alt_specs_qry = $this->db->query($alt_specs_sql);
		$alt_specs_qry = $alt_specs_qry->result_array();
		/*=====  End of match title with Alt Specifics  ======*/
		
		/*===================================================
		=            match title with mpn            =
		===================================================*/
		$mpn_sql = "SELECT MPN.MPN_MT_ID, MPN.MPN FROM LZ_BD_MPN_MT MPN WHERE MPN.CATEGORY_ID = $category_id AND '$matched_title' LIKE '% ' || MPN.MPN || ' %'"; 
		$mpn_qry = $this->db->query($mpn_sql);
		$mpn_qry = $mpn_qry->result_array();
		/*=====  End of match title with mpn  ======*/
		/*===================================================
		=            match title with object            =
		===================================================*/
		$object_sql = "SELECT O.OBJECT_NAME FROM LZ_BD_OBJECTS_MT O WHERE '$matched_title' LIKE '% ' || O.OBJECT_NAME || ' %'"; 
		$object_qry = $this->db->query($object_sql);
		$object_qry = $object_qry->result_array();
		/*=====  End of match title with object  ======*/
		/*===================================================
		=           get specifics against category id       =
		===================================================*/
		$cat_specifics = "SELECT D.MT_ID, D.DET_ID, upper(D.SPECIFIC_VALUE) SPECIFIC_VALUE, M.SPECIFIC_NAME FROM CATEGORY_SPECIFIC_MT M, CATEGORY_SPECIFIC_DET D WHERE M.MT_ID = D.MT_ID AND M.EBAY_CATEGORY_ID = $category_id AND (SPECIFIC_NAME = 'Brand' OR SPECIFIC_NAME = 'Model' OR SPECIFIC_NAME = 'Product Family' OR SPECIFIC_NAME = 'Product Line')"; 
		$get_specifics = $this->db->query($cat_specifics);
		$get_specifics = $get_specifics->result_array();
		/*=====  End of get specifics against category id  ======*/

		/*===================================================
		=           get objects against category id       =
		===================================================*/
		$cat_objects = "SELECT M.OBJECT_ID, M.OBJECT_NAME FROM LZ_BD_OBJECTS_MT M, LZ_BD_OBJECTS_CATEGORIES C WHERE M.OBJECT_ID = C.OBJECT_MT_ID AND C.CATEGORY_ID = $category_id ";
		$get_objects = $this->db->query($cat_objects);
		$get_objects = $get_objects->result_array();
		/*=====  End of get objects against category id  ======*/		

		return array('specs_qry'=>$specs_qry,'alt_specs_qry'=>$alt_specs_qry,'mpn_qry'=>$mpn_qry,'object_qry'=>$object_qry,'get_specifics'=>$get_specifics, 'get_objects'=>$get_objects);
	}
	public function getCategories(){
		// $sql = "SELECT DISTINCT CATEGORY_ID,CATEGORY_NAME FROM LZ_BD_CATEGORY WHERE CATEGORY_ID IN('31569', '175676', '168061', '1244', '16145', '31519', '175669', '31510', '31568', '177', '14295', '20318', '131486', '175668', '56083', '51064', '131511', '171814', '162', '175745', '176982', '33963', '175677', '20357', '180235', '3709', '176973', '168068', '182097','111422','177','179','111418') ORDER BY CATEGORY_NAME";
		// $sql = "SELECT DISTINCT D.CATEGORY_ID, BD.CATEGORY_NAME, GET_ACTIVE_COUNT(D.CATEGORY_ID) CAT_COUNT FROM LZ_BD_CAT_GROUP_DET D, LZ_BD_CATEGORY BD WHERE  D.CATEGORY_ID = BD.CATEGORY_ID" ;


		// $sql = "SELECT K.CATEGORY_ID CATEGORY_ID,K.CATEGORY_NAME ||'-'|| K.CATEGORY_ID CATEGORY_NAME FROM LZ_BD_CATEGORY K where CATEGORY_ID = 171833 " ;
		$sql = "SELECT K.CATEGORY_ID CATEGORY_ID,K.CATEGORY_NAME ||'-'|| K.CATEGORY_ID CATEGORY_NAME FROM LZ_BD_CATEGORY K ORDER BY  DECODE(CATEGORY_ID,177,177)" ;

		
		$query = $this->db2->query($sql);
		$query = $query->result_array();
		return $query;
	}
	
	public function getDatatype(){
		$sql = "SELECT * FROM LZ_GOOG_DATA_TYPE";
		$query = $this->db->query($sql);
		$query = $query->result_array();
		return $query;
	}
	public function getStatistics(){

		$keyword = $this->input->post('bd_search');
		$keyword = strtoupper(trim(str_replace('  ',' ', $keyword)));
		//$keyword = str_replace(' ','|', $keyword);
		$str = explode(' ', $keyword);
		//$category_id = $this->input->post('bd_category');

		$category_id = $this->input->post('bd_category');
		if( empty( $category_id )){
			$category_id = $this->session->userdata('category_id');
		}
		if( empty( $category_id )){
			$category_id = $this->uri->segment(5);
			//$category_id = $this->session->userdata('category_id');
		}

		$sql = "SELECT VD.SPEC_MT_ID, COUNT(1) CNT FROM (SELECT DISTINCT V.LZ_BD_CATA_ID, V.SPEC_MT_ID FROM LZ_BD_VERIFIED_DATA V, LZ_BD_CATAG_DATA C WHERE V.LZ_BD_CATA_ID = C.LZ_BD_CATA_ID AND C.MAIN_CATEGORY_ID = $category_id";
		if($category_id == 0){
			//$sql.=" FROM LZ_BD_CATAG_DATA";
			if(!empty($keyword) ) {   // if there is a search parameter, $keyword contains search parameter
				if (count($str)>1) {
					foreach ($str as $key) {
						$sql.=" AND UPPER(C.TITLE) LIKE '%$key%' ";
					}
				}else{
					$sql.=" AND UPPER(C.TITLE) LIKE '%$keyword%' ";
				}

			}
		}else{
			//$sql.=" FROM LZ_BD_CATAG_DATA WHERE MAIN_CATEGORY_ID = $category_id";
			if(!empty($keyword) ) {   // if there is a search parameter, $keyword contains search parameter
				if (count($str)>1) {
					foreach ($str as $key) {
						$sql.=" AND UPPER(C.TITLE) LIKE '%$key%'";
					}
				}else{
					$sql.=" AND UPPER(C.TITLE) LIKE '%$keyword%'";
				}
			}
		}
		// $sql = $this->db->query($sql);
		// $total_row = $sql->num_rows();
	$final_sql = "SELECT M.EBAY_CATEGORY_ID, M.SPECIFIC_NAME, SPEC_CNT.CNT FROM LAPTOP_ZONE.CATEGORY_SPECIFIC_MT M, (".$sql.") VD GROUP BY VD.SPEC_MT_ID) SPEC_CNT WHERE M.MT_ID = SPEC_CNT.SPEC_MT_ID(+) AND M.EBAY_CATEGORY_ID = ".$category_id;

		$final_sql = $this->db2->query($final_sql);
		
		$query = $final_sql->result_array();
		return $query;
	}

	public function verified_data(){
		$bd_search = $this->input->post('bd_search');
		$bd_category_id = $this->input->post('bd_category');
		$sql = "SELECT DISTINCT C.LZ_BD_CATA_ID, C.CATEGORY_ID, C.EBAY_ID, C.TITLE, C.CONDITION_NAME, C.ITEM_URL, C.SALE_PRICE, C.LISTING_TYPE, C.START_TIME, C.SALE_TIME, C.SELLER_ID, C.FEEDBACK_SCORE, C.CATEGORY_NAME, C.CURRENCY_ID FROM LZ_BD_VERIFIED_DATA V, LZ_BD_CATAG_DATA C WHERE V.LZ_BD_CATA_ID = C.LZ_BD_CATA_ID AND C.CATEGORY_ID =$bd_category_id AND C.VERIFIED = 0";
		$query = $this->db2->query($sql);
		$query = $query->result_array();
		return $query;
	}
	public function verifySingleTitle(){
		$title_id = $this->input->post('title_id');
		
		$qry_data = $this->db2->query("SELECT IS_MPN_FOUND($title_id) IS_MPN_FOUND FROM DUAL");
	    $rs = $qry_data->result_array();           
	    $is_mpn_found = $rs[0]['IS_MPN_FOUND'];

	   // var_dump($is_mpn_found);exit;
	    if($is_mpn_found){
	    	$query = $this->db2->query("SELECT * FROM LZ_BD_VERIFIED_DATA WHERE LZ_BD_CATA_ID = $title_id");
			if($query->num_rows() == 0){
				$varify_title = "CALL PRO_VARIFY_SINGLE_TITLE($title_id)";
				if (!$this->db2->query($varify_title)){
			            // $error = $this->db->error(); // Has keys 'code' and 'message'
			            return 2;
			            //echo "Query: ".$query.'<br>';
		         }else{
		         	return 1;
		         }
			}else{
				return 3;
			}
	    }else{
	    	return 4;
	    }
		
	}
	public function titleData(){
		$keyword = $this->input->post('bd_search');
		$keyword = strtoupper(trim(str_replace('  ',' ', $keyword)));
		$this->session->set_userdata('search_key', $keyword);
		$category_id = $this->input->post('bd_category');
		$this->session->set_userdata('category_id', $category_id);
				
		$str = explode(' ', $keyword);

		$no_of_record = $this->input->post('bd_records');
		$this->session->set_userdata('no_of_record', $no_of_record);
		if( empty( $category_id )){
			$category_id = $this->session->userdata('category_id');
		}
		if( empty( $category_id )){
			$category_id = $this->uri->segment(5);
			//$category_id = $this->session->userdata('category_id');
		}
		$session_id = $this->session->userdata('session_tmp_id');
		//var_dump($session_id);exit;
		$this->session->set_userdata('category_id',$category_id);	

		$sql='';
			if(!empty($keyword) ) {   // if there is a search parameter, $keyword contains search parameter
				if (count($str)>1) {
					foreach ($str as $key) {

						$sql.=" AND UPPER(CD.TITLE) LIKE ''%$key%''";
					}
				}else{
					$sql.=" AND UPPER(CD.TITLE) LIKE ''%$keyword%''";
				}
			}
		$delete_tmp_title = "DELETE FROM LZ_BD_TMP_TITLE WHERE SESSION_ID = '$session_id'";
        $this->db2->query($delete_tmp_title);
	 	$process_title = "call pro_process_title_catalogue('$session_id','$sql',$category_id)";
        $this->db2->query($process_title);

        $query = $this->db2->query("SELECT T.*,C.ITEM_URL FROM LZ_BD_TMP_TITLE T,LZ_BD_CATAG_DATA C WHERE C.LZ_BD_CATA_ID=T.TITLE_ID AND T.SESSION_ID = '$session_id' AND ROWNUM < $no_of_record");
		$title_data = $query->result_array();	

		/*=========================================
		=            get Specific Name            =
		=========================================*/
		$name_qry = "SELECT T.MT_ID, T.SPECIFIC_NAME FROM CATEGORY_SPECIFIC_MT T WHERE T.EBAY_CATEGORY_ID = $category_id"; 
		$query = $this->db->query($name_qry);
		$spec_name = $query->result_array();
		/*=====  End of get Specific Name  ======*/	

		return array('title_data'=>$title_data, 'spec_name'=>$spec_name);			

	}
	public function getSpecificsValues(){

		/*==========================================
		=            get Specific Value            =
		==========================================*/
		$mt_id = $this->input->post('mt_id');
		//var_dump($mt_id);exit;
		$val_qry = "SELECT D.DET_ID, D.SPECIFIC_VALUE FROM CATEGORY_SPECIFIC_DET D WHERE D.MT_ID = $mt_id"; 
		$query = $this->db->query($val_qry);
		return $query->result_array();
		/*=====  End of get Specific Value  ======*/

	}
	public function addSpecificsAltVal(){

		$det_id = $this->input->post('det_id');
		$bd_category = $this->input->post('bd_category');
		$specifics = strtoupper($this->input->post('specifics'));

		$spec_alt_value = strtoupper($this->input->post('spec_alt_value'));
		$spec_alt_value = trim(str_replace("  ", ' ', $spec_alt_value));
        $spec_alt_value = str_replace(array("`,′"), "", $spec_alt_value);
        $spec_alt_value = trim(str_replace(array("'"), "''", $spec_alt_value));
		$user_id = $this->session->userdata('user_id');
        date_default_timezone_set("America/Chicago");
        $current_date = date("Y-m-d H:i:s");
        $current_date = "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";        

		$comma = ",";

		//var_dump($det_id, $spec_alt_value);exit;
		if(is_numeric($specifics)){

			$check_query = $this->db2->query("SELECT SPECS_ALT_ID FROM LZ_BD_SPECS_ALT_VAL WHERE DET_ID = $det_id AND SPEC_ALT_VALUE = '$spec_alt_value'");
			if($check_query->num_rows() == 0){
		        $qry_data = $this->db2->query("SELECT LAPTOP_ZONE.GET_SINGLE_PRIMARY_KEY('LZ_BD_SPECS_ALT_VAL','SPECS_ALT_ID') SPECS_ALT_ID FROM DUAL");
			    $rs = $qry_data->result_array();           
			    $specs_alt_id = $rs[0]['SPECS_ALT_ID'];
			    //var_dump($object_id);
		        $query = "INSERT INTO LZ_BD_SPECS_ALT_VAL (SPECS_ALT_ID, DET_ID, SPEC_ALT_VALUE, INSERT_DATE, INSERT_BY)VALUES($specs_alt_id $comma $det_id $comma '$spec_alt_value' $comma $current_date $comma $user_id)";

				if (!$this->db2->query($query)){
		            // $error = $this->db->error(); // Has keys 'code' and 'message'
		            return 2;
		            //echo "Query: ".$query.'<br>';
		         }else{
		         	return 1;
		         }  
			}else{
				return 3;
			}
		}elseif($specifics == "GW"){

			$check_query = $this->db2->query("SELECT GEN_DET_ID FROM LZ_BD_GEN_WORDS_DET WHERE GEN_MT_ID = $det_id AND GEN_WORDS = '$spec_alt_value'");
			if($check_query->num_rows() == 0){
		        $qry_data = $this->db2->query("SELECT LAPTOP_ZONE.GET_SINGLE_PRIMARY_KEY('LZ_BD_GEN_WORDS_DET','GEN_DET_ID') GEN_DET_ID FROM DUAL");
			    $rs = $qry_data->result_array();           
			    $gen_det_id = $rs[0]['GEN_DET_ID'];
			    //var_dump($object_id);
		        $words_query = "INSERT INTO LZ_BD_GEN_WORDS_DET (GEN_DET_ID, GEN_MT_ID, GEN_WORDS, INSERT_DATE, INSERT_BY)VALUES($gen_det_id $comma $det_id $comma '$spec_alt_value' $comma $current_date $comma $user_id)"; //general words data_type_id is 8 in lz_goog_data_type

				$cat_query = $this->db2->query("SELECT GEN_WORD_ID FROM LZ_BD_GEN_WORDS_CATEGORIES WHERE GEN_MT_ID = $det_id AND CATEGORY_ID = $bd_category");
				if($cat_query->num_rows() == 0){

			        $qry_data = $this->db2->query("SELECT LAPTOP_ZONE.GET_SINGLE_PRIMARY_KEY('LZ_BD_GEN_WORDS_CATEGORIES','GEN_WORD_ID') GEN_WORD_ID FROM DUAL");
				    $rs = $qry_data->result_array();           
				    $gen_word_id = $rs[0]['GEN_WORD_ID'];					

			        $query = "INSERT INTO LZ_BD_GEN_WORDS_CATEGORIES (GEN_WORD_ID, GEN_MT_ID, CATEGORY_ID)VALUES($gen_word_id $comma $det_id $comma $bd_category)"; //general words data_type_id is 8 in lz_goog_data_type
			        if (!$this->db2->query($query)){
		            // $error = $this->db->error(); // Has keys 'code' and 'message'
		            	return 2;
			            //echo "Query: ".$query.'<br>';
			         }else{
			         	return 1;	
			         } 
			    }
				if (!$this->db2->query($words_query)){
		            // $error = $this->db->error(); // Has keys 'code' and 'message'
		            return 2;
		            //echo "Query: ".$query.'<br>';
		         }else{
		         	return 1;
		         }  
			}else{
				return 3;
			}

		}elseif($specifics == "OTH"){
			$check_query = $this->db2->query("SELECT GEN_DET_ID FROM LZ_BD_GEN_WORDS_DET WHERE GEN_MT_ID = $det_id AND GEN_WORDS = '$spec_alt_value'");
			if($check_query->num_rows() == 0){
		        $qry_data = $this->db2->query("SELECT LAPTOP_ZONE.GET_SINGLE_PRIMARY_KEY('LZ_BD_GEN_WORDS_DET','GEN_DET_ID') GEN_DET_ID FROM DUAL");
			    $rs = $qry_data->result_array();           
			    $gen_det_id = $rs[0]['GEN_DET_ID'];
			    //var_dump($object_id);
		        $words_query = "INSERT INTO LZ_BD_GEN_WORDS_DET (GEN_DET_ID, GEN_MT_ID, GEN_WORDS, INSERT_DATE, INSERT_BY)VALUES($gen_det_id $comma $det_id $comma '$spec_alt_value' $comma $current_date $comma $user_id)"; //general words data_type_id is 8 in lz_goog_data_type
		        //$this->db2->query($words_query);

				$cat_query = $this->db2->query("SELECT GEN_WORD_ID FROM LZ_BD_GEN_WORDS_CATEGORIES WHERE GEN_MT_ID = $det_id AND CATEGORY_ID = $bd_category");
				if($cat_query->num_rows() == 0){

			        $qry_data = $this->db2->query("SELECT LAPTOP_ZONE.GET_SINGLE_PRIMARY_KEY('LZ_BD_GEN_WORDS_CATEGORIES','GEN_WORD_ID') GEN_WORD_ID FROM DUAL");
				    $rs = $qry_data->result_array();           
				    $gen_word_id = $rs[0]['GEN_WORD_ID'];					

			        $query = "INSERT INTO LZ_BD_GEN_WORDS_CATEGORIES (GEN_WORD_ID, GEN_MT_ID, CATEGORY_ID)VALUES($gen_word_id $comma $det_id $comma $bd_category)"; //general words data_type_id is 8 in lz_goog_data_type
				if (!$this->db2->query($query)){
		            // $error = $this->db->error(); // Has keys 'code' and 'message'
		            return 2;
		            //echo "Query: ".$query.'<br>';
		         }else{
		         	return 1;
		         }  			        
			    }
				if (!$this->db2->query($words_query)){
		            // $error = $this->db->error(); // Has keys 'code' and 'message'
		            return 2;
		            //echo "Query: ".$query.'<br>';
		         }else{
		         	return 1;
		         }  
			}else{
				return 3;
			}
		}elseif($specifics == "OBJECT"){

			$check_query = $this->db2->query("SELECT OBJECT_ID FROM LZ_BD_OBJECTS_MT WHERE UPPER(OBJECT_NAME) = '$spec_alt_value'");
			//var_dump($check_query);exit;
			if($check_query->num_rows() == 0){
		        $qry_data = $this->db2->query("SELECT LAPTOP_ZONE.GET_SINGLE_PRIMARY_KEY('LZ_BD_OBJECTS_MT','OBJECT_ID') OBJECT_ID FROM DUAL");
			    $rs = $qry_data->result_array();           
			    $object_id = $rs[0]['OBJECT_ID'];
			    //var_dump($object_id);
		        $query = "INSERT INTO LZ_BD_OBJECTS_MT (OBJECT_ID, OBJECT_NAME, INSERT_DATE, INSERT_BY)VALUES($object_id $comma '$spec_alt_value' $comma $current_date $comma $user_id)"; //general words data_type_id is 8 in lz_goog_data_type
		        $this->db2->query($query);
		        $qry_pk = $this->db2->query("SELECT LAPTOP_ZONE.GET_SINGLE_PRIMARY_KEY('LZ_BD_OBJECTS_CATEGORIES','OBJ_CAT_ID') OBJ_CAT_ID FROM DUAL");
			    $result = $qry_pk->result_array();           
			    $object_cat_id = $result[0]['OBJ_CAT_ID'];

		        $qry_obj = "INSERT INTO LZ_BD_OBJECTS_CATEGORIES (OBJ_CAT_ID, OBJECT_MT_ID, CATEGORY_ID)VALUES($object_cat_id $comma $object_id $comma $bd_category)";

				if (!$this->db2->query($qry_obj)){
		            // $error = $this->db->error(); // Has keys 'code' and 'message'
		            return 2;
		            //echo "Query: ".$query.'<br>';
		         }else{
		         	return 1;
		         }  
			}else{
				return 3;
			}
		}
		

      

	}
	public function addMpnData(){
		$mpn = $this->input->post('mpn');
		$mpn = trim(str_replace("  ", ' ', $mpn));
        $mpn = trim(str_replace(array("'"), "''", $mpn));
        $mpn = strtoupper($mpn);

        $manufacturer = $this->input->post('manufacturer');
		$manufacturer = trim(str_replace("  ", ' ', $manufacturer));
        $manufacturer = trim(str_replace(array("'"), "''", $manufacturer));
        $manufacturer = strtoupper($manufacturer);

        $brand = $this->input->post('brand');
		$brand = trim(str_replace("  ", ' ', $brand));
        $brand = trim(str_replace(array("'"), "''", $brand));
        $brand = strtoupper($brand);        

		$model = $this->input->post('model');
		$model = trim(str_replace("  ", ' ', $model));
        $model = trim(str_replace(array("'"), "''", $model));
        $model = strtoupper($model);

        $product_family = $this->input->post('product_family');
		$product_family = trim(str_replace("  ", ' ', $product_family));
        $product_family = trim(str_replace(array("'"), "''", $product_family));
        $product_family = strtoupper($product_family);        

		$object = $this->input->post('object');
		$object = trim(str_replace("  ", ' ', $object));
        $object = trim(str_replace(array("'"), "''", $object));
        $object = strtoupper($object); 

		$bd_category = $this->input->post('bd_category');
		$user_id = $this->session->userdata('user_id');
        date_default_timezone_set("America/Chicago");
        $current_date = date("Y-m-d H:i:s");
        $current_date = "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";  		
		
        $comma = ',';

        $qry_obj = $this->db2->query("SELECT OBJECT_ID FROM LZ_BD_OBJECTS_MT WHERE UPPER(OBJECT_NAME) = '$object'");
        
        if($qry_obj->num_rows()==0){        		

	        $object_id = $this->db2->query("SELECT LAPTOP_ZONE.GET_SINGLE_PRIMARY_KEY('LZ_BD_OBJECTS_MT','OBJECT_ID') OBJECT_ID FROM DUAL");
		    $rs = $object_id->result_array();           
		    $object_id = $rs[0]['OBJECT_ID'];
		    //var_dump($object_id);
	        $insert_object = $this->db2->query("INSERT INTO LZ_BD_OBJECTS_MT (OBJECT_ID, OBJECT_NAME, INSERT_DATE, INSERT_BY)VALUES($object_id $comma '$object' $comma $current_date $comma $user_id)");
    	}else{
    		$rs= $qry_obj->result_array();
    		$object_id = $rs[0]['OBJECT_ID'];
    	}

        $qry_mpn = $this->db2->query("SELECT MPN_MT_ID FROM LZ_BD_MPN_MT WHERE UPPER(MPN) = '$mpn'");
        
        if($qry_mpn->num_rows() == 0){      		

	        $mpn_mt_id = $this->db2->query("SELECT LAPTOP_ZONE.GET_SINGLE_PRIMARY_KEY('LZ_BD_MPN_MT','MPN_MT_ID') MPN_MT_ID FROM DUAL");
		    $rs = $mpn_mt_id->result_array();           
		    $mpn_mt_id = $rs[0]['MPN_MT_ID'];

	        $insert_mpn = $this->db2->query("INSERT INTO LZ_BD_MPN_MT (MPN_MT_ID, MPN, MANUFACTURER, BRAND, MODEL, PRODUCT_FAMILY, CATEGORY_ID, OBJECT_ID, INSERT_DATE, INSERT_BY)VALUES($mpn_mt_id $comma '$mpn' $comma '$manufacturer' $comma '$brand' $comma '$model' $comma '$product_family' $comma $bd_category $comma $object_id $comma $current_date $comma $user_id)");


    	}
    	return "MPN";
		// if (!$this->db2->query($query)){
  //           // $error = $this->db->error(); // Has keys 'code' and 'message'
  //           return 2;
  //           //echo "Query: ".$query.'<br>';
  //        }else{
  //        	return 1;
  //        }  




	}
	public function getGenWords(){

		/*==========================================
		=            get GenWords Value            =
		==========================================*/

		$gen_words_qry = "SELECT GEN_MT_ID, SET_DESCRIPTION FROM LZ_BD_GEN_WORDS_MT ORDER BY GEN_MT_ID ASC"; 
		$query = $this->db->query($gen_words_qry);
		return $query->result_array();
		/*=====  End of get GenWords Value  ======*/	
				
	}		

	public function saveObject(){
		$category_id = $this->input->post('cat_id');
		$model_bd = $this->input->post('model_bd');
		$model_bd = trim(str_replace("  ", ' ', $model_bd));
        $model_bd = trim(str_replace(array("'"), "''", $model_bd));
        $model_bd = strtoupper($model_bd);		
		$object_bd = $this->input->post('object_bd');
		$object_bd = strtoupper($object_bd);
		$mpn_bd = $this->input->post('mpn_bd');
		$mpn_bd = trim(str_replace("  ", ' ', $mpn_bd));
        $mpn_bd = trim(str_replace(array("'"), "''", $mpn_bd));
        $mpn_bd = strtoupper($mpn_bd);
        $manufacturer_bd = $this->input->post('manufacturer_bd');
		$manufacturer_bd = trim(str_replace("  ", ' ', $manufacturer_bd));
        $manufacturer_bd = trim(str_replace(array("'"), "''", $manufacturer_bd));
        $manufacturer_bd = strtoupper($manufacturer_bd);
		$select_recognize = $this->input->post('select_recognize');
		//var_dump($select_recognize);exit;
		$array_count = $this->input->post('array_count');
		$user_id = $this->session->userdata('user_id');
        date_default_timezone_set("America/Chicago");
        $current_date = date("Y-m-d H:i:s");
        $current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";
        $comma = ',';
       

        $qry_data = $this->db2->query("SELECT OBJECT_ID FROM LZ_BD_OBJECTS_MT WHERE OBJECT_TYPE = 7 AND OBJECT_NAME = '$object_bd'");
        
        if($qry_data->num_rows()==0){
        	
        	/*=====================================
	        =            insert object            =
	        =====================================*/

	        $qry_data = $this->db2->query("SELECT GET_PRIMARY_KEY('LZ_BD_OBJECTS_MT','OBJECT_ID') OBJECT_ID FROM DUAL");
		    $rs = $qry_data->result_array();           
		    $object_id= $rs[0]['OBJECT_ID'];
		    //var_dump($object_id);
	        $query = $this->db2->query("INSERT INTO LZ_BD_OBJECTS_MT (OBJECT_ID,OBJECT_TYPE,OBJECT_NAME)VALUES($object_id $comma 7 $comma '$object_bd')");       
	        
	        /*=====  End of insert object  ======*/

        }else{
        	$data = $qry_data->result_array();
        	$object_id= @$data[0]['OBJECT_ID'];
        	
        }
        $qry_mpn = $this->db2->query("SELECT MPN_MT_ID FROM LZ_BD_MPN_MT WHERE MPN = '$mpn_bd'");
        if($qry_mpn->num_rows()==0){
        	
        	/*=====================================
	        =            insert mpn            =
	        =====================================*/

	        $qry_mpn = $this->db2->query("SELECT GET_PRIMARY_KEY('LZ_BD_MPN_MT','MPN_MT_ID') MPN_MT_ID FROM DUAL");
		    $rs = $qry_mpn->result_array();           
		    $mpn_mt_id= $rs[0]['MPN_MT_ID'];
		    //var_dump($mpn_mt_id);
			$query = $this->db2->query("INSERT INTO LZ_BD_MPN_MT (MPN_MT_ID, MPN, MANUFACTURER, BRAND, MODEL, PRODUCT_FAMILY, CATEGORY_ID, OBJECT_ID)VALUES($mpn_mt_id $comma '$mpn_bd' $comma '$manufacturer_bd' $comma '$brand' $comma '$model_bd' $comma '$product_family' $comma $category_id $comma $object_id )");
	        
	        /*=====  End of insert mpn  ======*/

        }else{
        	$qry_mpn = $qry_mpn->result_array();
        	$mpn_mt_id= @$qry_mpn[0]['MPN_MT_ID'];
        }

        //exit;
		foreach($select_recognize as $lz_bd_cata_id):
			/*==========================================================
			=            update MPN_MT_ID in lz_bd_catag_data            =
			==========================================================*/
			$qry_data = $this->db2->query("UPDATE LZ_BD_CATAG_DATA SET MPN_MT_ID = $mpn_mt_id WHERE LZ_BD_CATA_ID = $lz_bd_cata_id");			
			/*=====  End of update MPN_MT_ID in lz_bd_catag_data  ======*/


				for ($i = 1; $i <= $array_count; $i++) { 
	 				$spec_name = $this->input->post('specific_name_'.$i);
	 				$str = explode("_", @$spec_name);
			        $spec_mt_id = @$str[0];
			        //echo $spec_name;
			        /*==========================================================
					=            check if already inserted/varified            =
					==========================================================*/
					$qry_data = $this->db2->query("SELECT VERIFIED_ID FROM LZ_BD_VERIFIED_DATA WHERE LZ_BD_CATA_ID = $lz_bd_cata_id AND SPEC_MT_ID = $spec_mt_id");			
					/*=====  End of check if already inserted/varified  ======*/
					if($qry_data->num_rows() == 0):
						$specific_name = @$str[1];
				        $specific_name = trim(str_replace("  ", ' ', $specific_name));
				        $specific_name = trim(str_replace(array("'"), "''", $specific_name));
				        $specific_name = strtoupper($specific_name);
						$spec_value = $this->input->post('specific_'.$i);
						//var_dump($specific_name,$spec_value);exit;
						if(is_array(@$spec_value)){
				          $spec_val = explode(",", @$spec_value);
				          
				          foreach ($spec_val as $value) {
				          	$spec_val = explode("_", @$value);
				          	$spec_det_id = @$value[0];
				          	$spec_value = @$value[1];
				          	$spec_value = trim(str_replace("  ", ' ', $spec_value));
					        $spec_value = trim(str_replace(array("'"), "''", $spec_value));
					        $spec_value = strtoupper($spec_value);
				          	if(is_numeric($spec_det_id)){
				          		$qry_data = $this->db2->query("SELECT GET_PRIMARY_KEY('LZ_BD_VERIFIED_DATA','VERIFIED_ID') VERIFIED_ID FROM DUAL");
							    $rs = $qry_data->result_array();           
							    $verified_id= $rs[0]['VERIFIED_ID'];
				          		$query = $this->db2->query("INSERT INTO LZ_BD_VERIFIED_DATA (VERIFIED_ID, LZ_BD_CATA_ID, SPEC_DET_ID, SPEC_DET_VALUE, SPEC_MT_ID, SPEC_MT_VALUE)VALUES($verified_id $comma $lz_bd_cata_id $comma $spec_det_id $comma '$spec_value' $comma $spec_mt_id $comma '$specific_name')");
				          	}
				          	
				          }
				        }else{

				        	$spec_val = explode("_", @$spec_value);
				          	$spec_det_id = @$spec_val[0];
				          	$spec_value = @$spec_val[1];
				          	$spec_value = trim(str_replace("  ", ' ', $spec_value));
					        $spec_value = trim(str_replace(array("'"), "''", $spec_value));
					        $spec_value = strtoupper($spec_value);
		/*===========================================================================
		=            update product family / product line in lz_bd_mpn_mt            =
		===========================================================================*/
						if($specific_name == 'PRODUCT LINE' || $specific_name == 'PRODUCT FAMILY'){
							$qry_data = $this->db2->query("UPDATE LZ_BD_MPN_MT SET PRODUCT_FAMILY = '$spec_value' WHERE MPN_MT_ID = $mpn_mt_id");
						}
						if($specific_name == 'BRAND'){
							$qry_data = $this->db2->query("UPDATE LZ_BD_MPN_MT SET BRAND = '$spec_value' WHERE MPN_MT_ID = $mpn_mt_id");
						}

		/*=====  End of update product family / product line in lz_bd_mpn_mt  ======*/
				          	if(is_numeric($spec_det_id)){
				          		$qry_data = $this->db2->query("SELECT GET_PRIMARY_KEY('LZ_BD_VERIFIED_DATA','VERIFIED_ID') VERIFIED_ID FROM DUAL");
							    $rs = $qry_data->result_array();           
							    $verified_id= $rs[0]['VERIFIED_ID'];
				          		$query = $this->db2->query("INSERT INTO LZ_BD_VERIFIED_DATA (VERIFIED_ID, LZ_BD_CATA_ID, SPEC_DET_ID, SPEC_DET_VALUE, SPEC_MT_ID, SPEC_MT_VALUE)VALUES($verified_id $comma $lz_bd_cata_id $comma $spec_det_id $comma '$spec_value' $comma $spec_mt_id $comma '$specific_name')");
				          	}
				        }
					endif;

				}//end for loop
		endforeach;
if(@$query && !empty(@$query)){
        $this->session->set_flashdata('success', 'Record Inserted Successfully.');
      }else{
        $this->session->set_flashdata('warning', 'Record Already Inserted.');
      }
      return $category_id;
	}
	public function recognizeAll(){
		$requestData= $_REQUEST;
		$keyword = $this->input->post('bd_search');
		$keyword = strtoupper(trim(str_replace('  ',' ', $keyword)));
		//$keyword = str_replace(' ','|', $keyword);
		$str = explode(' ', $keyword);
		$category_id = $this->input->post('bd_category');
		$columns = array( 
		// datatable column index  => database column name
			0 =>'LZ_BD_CATA_ID',
			1 =>'CATEGORY_NAME',
			2 =>'CATEGORY_ID', 
			3 => 'EBAY_ID',
			4 => 'TITLE',
			5 => 'CONDITION_NAME',
			6 => 'SELLER_ID',
			7 => 'LISTING_TYPE',
			8 => 'SALE_PRICE',
			9 => 'START_TIME',
			10 => 'SALE_TIME',
			11 => 'FEEDBACK_SCORE'
		);
		$sql = "SELECT LZ_BD_CATA_ID, CATEGORY_ID, EBAY_ID, TITLE, CONDITION_NAME, ITEM_URL, SALE_PRICE, LISTING_TYPE, START_TIME, SALE_TIME, SELLER_ID, FEEDBACK_SCORE, CATEGORY_NAME, CURRENCY_ID ";
		if($category_id == 0){
			$sql.=" FROM LZ_BD_CATAG_DATA";
			if(!empty($keyword) ) {   // if there is a search parameter, $keyword contains search parameter
				if (count($str)>1) {
					$i=1;
					foreach ($str as $key) {
						if($i === 1){
							$sql.=" WHERE TITLE LIKE '%$key%' ";
						}else{
							$sql.=" AND TITLE LIKE '%$key%' ";
						}
						$i++;
					}
				}else{
					$sql.=" WHERE TITLE LIKE '%$keyword%' ";
				}

				// $sql.=" WHERE ( CATEGORY_NAME LIKE '%".$keyword."%' ";    
				// $sql.=" OR TITLE LIKE '%".$keyword."%' ";
				// $sql.=" OR CONDITION_NAME LIKE '%".$keyword."%' ";
				// $sql.=" OR SELLER_ID LIKE '%".$keyword."%' ";
				// $sql.=" OR LISTING_TYPE LIKE '%".$keyword."%' ";
				// $sql.=" OR START_TIME LIKE '%".$keyword."%' ";
				// $sql.=" OR SALE_TIME LIKE '%".$keyword."%' ";
				// $sql.=" OR EBAY_ID LIKE '".$keyword."' )";

				// $sql.=" WHERE REGEXP_LIKE (TITLE,'".$keyword."')";
			}
		}else{
			$sql.=" FROM LZ_BD_CATAG_DATA WHERE MAIN_CATEGORY_ID = $category_id";
			if(!empty($keyword) ) {   // if there is a search parameter, $keyword contains search parameter
				if (count($str)>1) {
					foreach ($str as $key) {
						$sql.=" AND TITLE LIKE '%$key%'";
					}
				}else{
					$sql.=" AND TITLE LIKE '%$keyword%'";
				}
				// $sql.=" AND ( CATEGORY_NAME LIKE '%".$keyword."%' ";    
				// $sql.=" OR TITLE LIKE '%".$keyword."%' ";
				// $sql.=" OR CONDITION_NAME LIKE '%".$keyword."%' ";
				// $sql.=" OR SELLER_ID LIKE '%".$keyword."%' ";
				// $sql.=" OR LISTING_TYPE LIKE '%".$keyword."%' ";
				// $sql.=" OR START_TIME LIKE '%".$keyword."%' ";
				// $sql.=" OR SALE_TIME LIKE '%".$keyword."%' ";
				// $sql.=" OR EBAY_ID LIKE '".$keyword."' )";

				//$sql.=" AND REGEXP_LIKE (TITLE,'".$keyword."')";
			}
		}
		$sql = $this->db2->query($sql." AND MPN_MT_ID IS NULL");
		// $query = $query->result_array();

		// $sql = $this->db->query("SELECT LZ_BD_CATA_ID, CATEGORY_ID, EBAY_ID, TITLE, CONDITION_NAME, ITEM_URL, SALE_PRICE, LISTING_TYPE, START_TIME, SALE_TIME, SELLER_ID, FEEDBACK_SCORE, CATEGORY_NAME, CURRENCY_ID FROM LZ_BD_CATAG_DATA WHERE MAIN_CATEGORY_ID = $category_id");
		$totalData = $sql->num_rows();
		$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

		$sql = "SELECT LZ_BD_CATA_ID, CATEGORY_ID, EBAY_ID, TITLE, CONDITION_NAME, ITEM_URL, SALE_PRICE, LISTING_TYPE, START_TIME, SALE_TIME, SELLER_ID, FEEDBACK_SCORE, CATEGORY_NAME, CURRENCY_ID ";
		if($category_id == 0){
			$sql.=" FROM LZ_BD_CATAG_DATA";
			if(!empty($keyword) ) {   // if there is a search parameter, $keyword contains search parameter
				// $sql.=" WHERE ( CATEGORY_NAME LIKE '%".$keyword."%' ";    
				// $sql.=" OR TITLE LIKE '%".$keyword."%' ";
				// $sql.=" OR CONDITION_NAME LIKE '%".$keyword."%' ";
				// $sql.=" OR SELLER_ID LIKE '%".$keyword."%' ";
				// $sql.=" OR LISTING_TYPE LIKE '%".$keyword."%' ";
				// $sql.=" OR START_TIME LIKE '%".$keyword."%' ";
				// $sql.=" OR SALE_TIME LIKE '%".$keyword."%' ";
				// $sql.=" OR EBAY_ID LIKE '".$keyword."' )";

				//$sql.=" WHERE REGEXP_LIKE (TITLE,'".$keyword."')";
				if (count($str)>1) {
					$i=1;
					foreach ($str as $key) {
						if($i === 1){
							$sql.=" WHERE UPPER(TITLE) LIKE '%$key%' ";
						}else{
							$sql.=" AND UPPER(TITLE) LIKE '%$key%' ";
						}
						$i++;
					}
				}else{
					$sql.=" WHERE UPPER(TITLE) LIKE '%$keyword%' ";
				}


				if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
					$sql.=" AND ( CATEGORY_NAME LIKE '%".$requestData['search']['value']."%' ";    
					$sql.=" OR CATEGORY_ID LIKE '".$requestData['search']['value']."' ";
					$sql.=" OR MAIN_CATEGORY_ID LIKE '".$requestData['search']['value']."' ";
					$sql.=" OR UPPER(TITLE) LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR START_TIME LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR SALE_TIME LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR EBAY_ID LIKE '".$requestData['search']['value']."' )";
				}
			}else{
				if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
					$sql.=" WHERE ( CATEGORY_NAME LIKE '%".$requestData['search']['value']."%' ";    
					$sql.=" OR CATEGORY_ID LIKE '".$requestData['search']['value']."' ";
					$sql.=" OR MAIN_CATEGORY_ID LIKE '".$requestData['search']['value']."' ";
					$sql.=" OR UPPER(TITLE) LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR START_TIME LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR SALE_TIME LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR EBAY_ID LIKE '".$requestData['search']['value']."' )";
				}
			}
		}else{
			$sql.=" FROM LZ_BD_CATAG_DATA WHERE MAIN_CATEGORY_ID = $category_id";
			if(!empty($keyword) ) {   // if there is a search parameter, $keyword contains search parameter
				// $sql.=" AND ( CATEGORY_NAME LIKE '%".$keyword."%' ";    
				// $sql.=" OR UPPER(TITLE) LIKE '%".$keyword."%' ";
				// $sql.=" OR CONDITION_NAME LIKE '%".$keyword."%' ";
				// $sql.=" OR SELLER_ID LIKE '%".$keyword."%' ";
				// $sql.=" OR LISTING_TYPE LIKE '%".$keyword."%' ";
				// $sql.=" OR START_TIME LIKE '%".$keyword."%' ";
				// $sql.=" OR SALE_TIME LIKE '%".$keyword."%' ";
				// $sql.=" OR EBAY_ID LIKE '".$keyword."' )";

				//$sql.=" AND REGEXP_LIKE (UPPER(TITLE),'".$keyword."')";
				if (count($str)>1) {
					foreach ($str as $key) {
						$sql.=" AND UPPER(TITLE) LIKE '%$key%'";
					}
				}else{
					$sql.=" AND UPPER(TITLE) LIKE '%$keyword%'";
				}
			}
			if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
				$sql.=" AND ( CATEGORY_NAME LIKE '%".$requestData['search']['value']."%' ";    
				$sql.=" OR CATEGORY_ID LIKE '".$requestData['search']['value']."' ";
				$sql.=" OR MAIN_CATEGORY_ID LIKE '".$requestData['search']['value']."' ";
				$sql.=" OR UPPER(TITLE) LIKE '%".$requestData['search']['value']."%' ";
				$sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' ";
				$sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' ";
				$sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' ";
				$sql.=" OR START_TIME LIKE '%".$requestData['search']['value']."%' ";
				$sql.=" OR SALE_TIME LIKE '%".$requestData['search']['value']."%' ";
				$sql.=" OR EBAY_ID LIKE '".$requestData['search']['value']."' )";
			}
		}//main if else


		$query = $this->db2->query($sql." AND MPN_MT_ID IS NULL");
		$all_rows = $query->result_array();
	    /*=======================================
	    =            save all record            =
	    =======================================*/
	    
	    //$category_id = $this->input->post('cat_id');
		$object_bd = $this->input->post('object_bd');
		$object_bd = strtoupper($object_bd);
		$mpn_bd = $this->input->post('mpn_bd');
		$mpn_bd = trim(str_replace("  ", ' ', $mpn_bd));
        $mpn_bd = trim(str_replace(array("'"), "''", $mpn_bd));
        $mpn_bd = strtoupper($mpn_bd);
        $model_bd = $this->input->post('model_bd');
		$model_bd = trim(str_replace("  ", ' ', $model_bd));
        $model_bd = trim(str_replace(array("'"), "''", $model_bd));
        $model_bd = strtoupper($model_bd);
        $manufacturer_bd = $this->input->post('manufacturer_bd');
		$manufacturer_bd = trim(str_replace("  ", ' ', $manufacturer_bd));
        $manufacturer_bd = trim(str_replace(array("'"), "''", $manufacturer_bd));
        $manufacturer_bd = strtoupper($manufacturer_bd);
        
        $array_count = $this->input->post('array_count');
		//$select_recognize = $this->input->post('select_recognize');
		//var_dump($category_id,$object_bd,$mpn_bd,$array_count);exit;
		
		$user_id = $this->session->userdata('user_id');
        date_default_timezone_set("America/Chicago");
        $current_date = date("Y-m-d H:i:s");
        $current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";
        $comma = ',';
       

        $qry_data = $this->db2->query("SELECT OBJECT_ID FROM LZ_BD_OBJECTS_MT WHERE OBJECT_TYPE = 7 AND OBJECT_NAME = '$object_bd'");
        
        if($qry_data->num_rows()==0){
        	
        	/*=====================================
	        =            insert object            =
	        =====================================*/

	        $qry_data = $this->db2->query("SELECT GET_PRIMARY_KEY('LZ_BD_OBJECTS_MT','OBJECT_ID') OBJECT_ID FROM DUAL");
		    $rs = $qry_data->result_array();           
		    $object_id= $rs[0]['OBJECT_ID'];
		    //var_dump($object_id);
	        $query = $this->db2->query("INSERT INTO LZ_BD_OBJECTS_MT (OBJECT_ID,OBJECT_TYPE,OBJECT_NAME)VALUES($object_id $comma 7 $comma '$object_bd')");       
	        
	        /*=====  End of insert object  ======*/

        }else{
        	$data = $qry_data->result_array();
        	$object_id= @$data[0]['OBJECT_ID'];
        	
        }
		$qry_mpn = $this->db2->query("SELECT MPN_MT_ID FROM LZ_BD_MPN_MT WHERE MPN = '$mpn_bd'");
        if($qry_mpn->num_rows()==0){
        	
        	/*=====================================
	        =            insert mpn            =
	        =====================================*/

	        $qry_mpn = $this->db2->query("SELECT GET_PRIMARY_KEY('LZ_BD_MPN_MT','MPN_MT_ID') MPN_MT_ID FROM DUAL");
		    $rs = $qry_mpn->result_array();           
		    $mpn_mt_id= $rs[0]['MPN_MT_ID'];
		    //var_dump($mpn_mt_id);
			$query = $this->db2->query("INSERT INTO LZ_BD_MPN_MT (MPN_MT_ID, MPN, MANUFACTURER, BRAND, MODEL, PRODUCT_FAMILY, CATEGORY_ID, OBJECT_ID)VALUES($mpn_mt_id $comma '$mpn_bd' $comma '$manufacturer_bd' $comma '$brand' $comma '$model_bd' $comma '$product_family' $comma $category_id $comma $object_id )");
	        
	        /*=====  End of insert mpn  ======*/

        }else{
        	$qry_mpn = $qry_mpn->result_array();
        	$mpn_mt_id= @$qry_mpn[0]['MPN_MT_ID'];
        }

        foreach ($all_rows as $row):
		//foreach($select_recognize as $lz_bd_cata_id):
        	$lz_bd_cata_id = $row['LZ_BD_CATA_ID'];
			/*==========================================================
			=            update MPN_MT_ID in lz_bd_catag_data            =
			==========================================================*/
			$qry_data = $this->db2->query("UPDATE LZ_BD_CATAG_DATA SET MPN_MT_ID = $mpn_mt_id WHERE LZ_BD_CATA_ID = $lz_bd_cata_id");			
			/*=====  End of update MPN_MT_ID in lz_bd_catag_data  ======*/


				//print_r($qry_data->num_rows());exit;
				$spec_name = $this->input->post('spec_name');
				$spec_value = $this->input->post('spec_value');
				//var_dump($spec_value);exit;
			if(!empty($spec_name)){
				$i = 0;
				foreach ($spec_name as $name) {
					$str = explode("_", @$name);
			        $spec_mt_id = @$str[0];
					/*==========================================================
					=            check if already inserted/varified            =
					==========================================================*/
					$qry_data = $this->db2->query("SELECT VERIFIED_ID FROM LZ_BD_VERIFIED_DATA WHERE LZ_BD_CATA_ID = $lz_bd_cata_id AND SPEC_MT_ID = $spec_mt_id");	
							
					/*=====  End of check if already inserted/varified  ======*/
					if($qry_data->num_rows() == 0):
						$specific_name = @$str[1];
				        $specific_name = trim(str_replace("  ", ' ', $specific_name));
				        $specific_name = trim(str_replace(array("'"), "''", $specific_name));
				        $specific_name = strtoupper($specific_name);
						$specific_value = $spec_value[$i];
						if(is_array(@$specific_value)){
					        $spec_val = explode(",", @$specific_value);
					          
					        foreach ($spec_val as $value) {
					        	$spec_val = explode("_", @$value);
					          	$spec_det_id = @$value[0];
					          	$specific_value = @$value[1];
					          	$specific_value = trim(str_replace("  ", ' ', $specific_value));
						        $specific_value = trim(str_replace(array("'"), "''", $specific_value));
						        $specific_value = strtoupper($specific_value);
					          		$qry_data = $this->db2->query("SELECT GET_PRIMARY_KEY('LZ_BD_VERIFIED_DATA','VERIFIED_ID') VERIFIED_ID FROM DUAL");
								    $rs = $qry_data->result_array();           
								    $verified_id= $rs[0]['VERIFIED_ID'];
					          		$query = $this->db2->query("INSERT INTO LZ_BD_VERIFIED_DATA (VERIFIED_ID, LZ_BD_CATA_ID, SPEC_DET_ID, SPEC_DET_VALUE, SPEC_MT_ID, SPEC_MT_VALUE)VALUES($verified_id $comma $lz_bd_cata_id $comma $spec_det_id $comma '$specific_value' $comma $spec_mt_id $comma '$specific_name')");
					        }
					    }else{
					        	$spec_val = explode("_", @$specific_value);
					          	$spec_det_id = @$spec_val[0];
					          	$specific_value = @$spec_val[1];
					          	$specific_value = trim(str_replace("  ", ' ', $specific_value));
						        $specific_value = trim(str_replace(array("'"), "''", $specific_value));
						        $specific_value = strtoupper($specific_value);
		/*===========================================================================
		=            update product family / product line in lz_bd_mpn_mt            =
		===========================================================================*/
						if($specific_name == 'PRODUCT LINE' || $specific_name == 'PRODUCT FAMILY'){
							$qry_data = $this->db2->query("UPDATE LZ_BD_MPN_MT SET PRODUCT_FAMILY = '$spec_value' WHERE MPN_MT_ID = $mpn_mt_id");
						}
						if($specific_name == 'BRAND'){
							$qry_data = $this->db2->query("UPDATE LZ_BD_MPN_MT SET BRAND = '$spec_value' WHERE MPN_MT_ID = $mpn_mt_id");
						}

		/*=====  End of update product family / product line in lz_bd_mpn_mt  ======*/
					          	$qry_data = $this->db2->query("SELECT GET_PRIMARY_KEY('LZ_BD_VERIFIED_DATA','VERIFIED_ID') VERIFIED_ID FROM DUAL");
								$rs = $qry_data->result_array();           
								$verified_id= $rs[0]['VERIFIED_ID'];
					          	$query = $this->db2->query("INSERT INTO LZ_BD_VERIFIED_DATA (VERIFIED_ID, LZ_BD_CATA_ID, SPEC_DET_ID, SPEC_DET_VALUE, SPEC_MT_ID, SPEC_MT_VALUE)VALUES($verified_id $comma $lz_bd_cata_id $comma $spec_det_id $comma '$specific_value' $comma $spec_mt_id $comma '$specific_name')");
					    }
					endif;
					$i++;
				}// end spec_name foreach
			}// end spec_name empty check if
			
				// for ($i = 1; $i <= $array_count; $i++) { 
		 	// 			$spec_name = $this->input->post('specific_name_'.$i);
		 	// 			$spec_name = explode("_", @$spec_name);
				//         $spec_mt_id = @$spec_name[0];
				//         $spec_name = @$spec_name[1];
				//         $spec_name = trim(str_replace("  ", ' ', $spec_name));
				//         $spec_name = trim(str_replace(array("'"), "''", $spec_name));
				//         $spec_name = strtoupper($spec_name);
				// 		$spec_value = $this->input->post('specific_'.$i);
				// 		var_dump($spec_name,$spec_value);exit;
				// 		if(is_array(@$spec_value)){
				//           $spec_val = explode(",", @$spec_value);
				          
				//           foreach ($spec_val as $value) {
				//           	$spec_val = explode("_", @$value);
				//           	$spec_det_id = @$value[0];
				//           	$spec_value = @$value[1];
				//           	$spec_value = trim(str_replace("  ", ' ', $spec_value));
				// 	        $spec_value = trim(str_replace(array("'"), "''", $spec_value));
				// 	        $spec_value = strtoupper($spec_value);
				//           	if(is_numeric($spec_det_id)){
				//           		$qry_data = $this->db2->query("SELECT GET_PRIMARY_KEY('LZ_BD_VERIFIED_DATA','VERIFIED_ID') VERIFIED_ID FROM DUAL");
				// 			    $rs = $qry_data->result_array();           
				// 			    $verified_id= $rs[0]['VERIFIED_ID'];
				//           		$query = $this->db2->query("INSERT INTO LZ_BD_VERIFIED_DATA (VERIFIED_ID, LZ_BD_CATA_ID, SPEC_DET_ID, SPEC_DET_VALUE, SPEC_MT_ID, SPEC_MT_VALUE)VALUES($verified_id $comma $lz_bd_cata_id $comma $spec_det_id $comma '$spec_value' $comma $spec_mt_id $comma '$spec_name')");
				//           	}
				          	
				//           }
				//         }else{

				//         	$spec_val = explode("_", @$spec_value);
				//           	$spec_det_id = @$spec_val[0];
				//           	$spec_value = @$spec_val[1];
				//           	$spec_value = trim(str_replace("  ", ' ', $spec_value));
				// 	        $spec_value = trim(str_replace(array("'"), "''", $spec_value));
				// 	        $spec_value = strtoupper($spec_value);
				// 	        //var_dump($spec_value);
				//           	if(is_numeric($spec_det_id)){
				//           		$qry_data = $this->db2->query("SELECT GET_PRIMARY_KEY('LZ_BD_VERIFIED_DATA','VERIFIED_ID') VERIFIED_ID FROM DUAL");
				// 			    $rs = $qry_data->result_array();           
				// 			    $verified_id= $rs[0]['VERIFIED_ID'];
				//           		$query = $this->db2->query("INSERT INTO LZ_BD_VERIFIED_DATA (VERIFIED_ID, LZ_BD_CATA_ID, SPEC_DET_ID, SPEC_DET_VALUE, SPEC_MT_ID, SPEC_MT_VALUE)VALUES($verified_id $comma $lz_bd_cata_id $comma $spec_det_id $comma '$spec_value' $comma $spec_mt_id $comma '$spec_name')");
				//           	}
				//         }
				// }//end for loop
			
		endforeach;
		if(@$query && !empty(@$query)){
	        $this->session->set_flashdata('success', 'Record Inserted Successfully.');
	      }else{
	        $this->session->set_flashdata('warning', 'Record Already Inserted.');
	      }

      return $category_id;
	    
	    
	    /*=====  End of save all record  ======*/
	    
	    
	    
	}
	public function getSpecifics(){
		/*=========================================
		=            get Specific Name            =
		=========================================*/
		$category_id = $this->input->post('bd_category');
		if( empty( $category_id )){
			$category_id = $this->session->userdata('category_id');
		}
		if( empty( $category_id )){
			$category_id = $this->uri->segment(5);
			//$category_id = $this->session->userdata('category_id');
		}

		$name_qry = "SELECT T.MT_ID, T.SPECIFIC_NAME, T.MAX_VALUE, T.MIN_VALUE, T.SELECTION_MODE FROM CATEGORY_SPECIFIC_MT T WHERE T.EBAY_CATEGORY_ID = $category_id"; 
		$query = $this->db->query($name_qry);
		$spec_name = $query->result_array();
		/*=====  End of get Specific Name  ======*/
		
		/*==========================================
		=            get Specific Value            =
		==========================================*/
		$val_qry = "SELECT D.MT_ID, D.DET_ID, D.SPECIFIC_VALUE FROM CATEGORY_SPECIFIC_DET D WHERE D.MT_ID IN (SELECT T.MT_ID FROM CATEGORY_SPECIFIC_MT T WHERE T.EBAY_CATEGORY_ID = $category_id)"; 
		$query = $this->db->query($val_qry);
		$spec_value = $query->result_array();
		/*=====  End of get Specific Value  ======*/
		

		
		return array('spec_name'=>$spec_name,'spec_value'=>$spec_value);
	}
	public function getSpecifics_obj($category_id){
		/*=========================================
		=            get Specific Name            =
		=========================================*/
		//$category_id = $this->input->post('bd_category');

		$name_qry = "SELECT T.MT_ID, T.SPECIFIC_NAME, T.MAX_VALUE, T.MIN_VALUE, T.SELECTION_MODE FROM CATEGORY_SPECIFIC_MT T WHERE T.EBAY_CATEGORY_ID = $category_id"; 
		$query = $this->db->query($name_qry);
		$spec_name = $query->result_array();
		/*=====  End of get Specific Name  ======*/
		
		/*==========================================
		=            get Specific Value            =
		==========================================*/
		$val_qry = "SELECT D.MT_ID, D.DET_ID, D.SPECIFIC_VALUE FROM CATEGORY_SPECIFIC_DET D WHERE D.MT_ID IN (SELECT T.MT_ID FROM CATEGORY_SPECIFIC_MT T WHERE T.EBAY_CATEGORY_ID = $category_id)"; 
		$query = $this->db->query($val_qry);
		$spec_value = $query->result_array();
		/*=====  End of get Specific Value  ======*/
		

		
		return array('spec_name'=>$spec_name,'spec_value'=>$spec_value);
	}

	public function queryData(){
		$keyword = $this->input->post('bd_search');
		$keyword = strtoupper($keyword);
		$category_id = $this->input->post('bd_category');
		$this->session->set_userdata('search_key', $keyword);
		$this->session->set_userdata('category_id', $category_id);

		$sql = "SELECT LZ_BD_CATA_ID, CATEGORY_ID, EBAY_ID, TITLE, CONDITION_NAME, ITEM_URL, SALE_PRICE, LISTING_TYPE, START_TIME, SALE_TIME, SELLER_ID, FEEDBACK_SCORE, CATEGORY_NAME, CURRENCY_ID ";
		if($category_id == 0){
			$sql.=" FROM LZ_BD_CATAG_DATA";
			if(!empty($keyword) ) {   // if there is a search parameter, $keyword contains search parameter
				$sql.=" WHERE ( CATEGORY_NAME LIKE '%".$keyword."%' ";    
				$sql.=" OR UPPER(TITLE) LIKE '%".$keyword."%' ";
				$sql.=" OR CONDITION_NAME LIKE '%".$keyword."%' ";
				$sql.=" OR SELLER_ID LIKE '%".$keyword."%' ";
				$sql.=" OR LISTING_TYPE LIKE '%".$keyword."%' ";
				$sql.=" OR START_TIME LIKE '%".$keyword."%' ";
				$sql.=" OR SALE_TIME LIKE '%".$keyword."%' ";
				$sql.=" OR EBAY_ID LIKE '".$keyword."' )";
			}
		}else{
			$sql.=" FROM LZ_BD_CATAG_DATA WHERE MAIN_CATEGORY_ID = $category_id";
			if(!empty($keyword) ) {   // if there is a search parameter, $keyword contains search parameter
				$sql.=" AND ( CATEGORY_NAME LIKE '%".$keyword."%' ";    
				$sql.=" OR UPPER(TITLE) LIKE '%".$keyword."%' ";
				$sql.=" OR CONDITION_NAME LIKE '%".$keyword."%' ";
				$sql.=" OR SELLER_ID LIKE '%".$keyword."%' ";
				$sql.=" OR LISTING_TYPE LIKE '%".$keyword."%' ";
				$sql.=" OR START_TIME LIKE '%".$keyword."%' ";
				$sql.=" OR SALE_TIME LIKE '%".$keyword."%' ";
				$sql.=" OR EBAY_ID LIKE '".$keyword."' )";
			}
		}
		//var_dump($sql);exit;
		
		$query = $this->db->query($sql);
		$query = $query->result_array();
		//var_dump($query);exit;
		return $query;

	}
public function loadData(){
		$requestData= $_REQUEST;
		$keyword = $this->input->post('bd_search');
		$keyword = strtoupper(trim(str_replace('  ',' ', $keyword)));
		//$keyword = str_replace(' ','|', $keyword);
		$str = explode(' ', $keyword);
		$category_id = $this->input->post('bd_category');
		$columns = array( 
		// datatable column index  => database column name
			0 =>'LZ_BD_CATA_ID',
			1 =>'CATEGORY_NAME',
			2 =>'CATEGORY_ID', 
			3 => 'EBAY_ID',
			4 => 'TITLE',
			5 => 'CONDITION_NAME',
			6 => 'SELLER_ID',
			7 => 'LISTING_TYPE',
			8 => 'SALE_PRICE',
			9 => 'START_TIME',
			10 => 'SALE_TIME',
			11 => 'FEEDBACK_SCORE'
		);
		$sql = "SELECT LZ_BD_CATA_ID, CATEGORY_ID, EBAY_ID, TITLE, CONDITION_NAME, ITEM_URL, SALE_PRICE, LISTING_TYPE, START_TIME, SALE_TIME, SELLER_ID, FEEDBACK_SCORE, CATEGORY_NAME, CURRENCY_ID ";
		if($category_id == 0){
			$sql.=" FROM LZ_BD_CATAG_DATA";
			if(!empty($keyword) ) {   // if there is a search parameter, $keyword contains search parameter
				if (count($str)>1) {
					$i=1;
					foreach ($str as $key) {
						if($i === 1){
							$sql.=" WHERE UPPER(TITLE) LIKE '%$key%' ";
						}else{
							$sql.=" AND UPPER(TITLE) LIKE '%$key%' ";
						}
						$i++;
					}
				}else{
					$sql.=" WHERE UPPER(TITLE) LIKE '%$keyword%' ";
				}

				// $sql.=" WHERE ( CATEGORY_NAME LIKE '%".$keyword."%' ";    
				// $sql.=" OR UPPER(TITLE) LIKE '%".$keyword."%' ";
				// $sql.=" OR CONDITION_NAME LIKE '%".$keyword."%' ";
				// $sql.=" OR SELLER_ID LIKE '%".$keyword."%' ";
				// $sql.=" OR LISTING_TYPE LIKE '%".$keyword."%' ";
				// $sql.=" OR START_TIME LIKE '%".$keyword."%' ";
				// $sql.=" OR SALE_TIME LIKE '%".$keyword."%' ";
				// $sql.=" OR EBAY_ID LIKE '".$keyword."' )";

				// $sql.=" WHERE REGEXP_LIKE (UPPER(TITLE),'".$keyword."')";
			}
		}else{
			$sql.=" FROM LZ_BD_CATAG_DATA WHERE MAIN_CATEGORY_ID = $category_id";
			if(!empty($keyword) ) {   // if there is a search parameter, $keyword contains search parameter
				if (count($str)>1) {
					foreach ($str as $key) {
						$sql.=" AND UPPER(TITLE) LIKE '%$key%'";
					}
				}else{
					$sql.=" AND UPPER(TITLE) LIKE '%$keyword%'";
				}
				// $sql.=" AND ( CATEGORY_NAME LIKE '%".$keyword."%' ";    
				// $sql.=" OR UPPER(TITLE) LIKE '%".$keyword."%' ";
				// $sql.=" OR CONDITION_NAME LIKE '%".$keyword."%' ";
				// $sql.=" OR SELLER_ID LIKE '%".$keyword."%' ";
				// $sql.=" OR LISTING_TYPE LIKE '%".$keyword."%' ";
				// $sql.=" OR START_TIME LIKE '%".$keyword."%' ";
				// $sql.=" OR SALE_TIME LIKE '%".$keyword."%' ";
				// $sql.=" OR EBAY_ID LIKE '".$keyword."' )";

				//$sql.=" AND REGEXP_LIKE (UPPER(TITLE),'".$keyword."')";
			}
		}
		//echo $sql;//exit;
		$sql = $this->db->query($sql." AND MPN_MT_ID IS NULL");
		// $query = $query->result_array();

		// $sql = $this->db->query("SELECT LZ_BD_CATA_ID, CATEGORY_ID, EBAY_ID, TITLE, CONDITION_NAME, ITEM_URL, SALE_PRICE, LISTING_TYPE, START_TIME, SALE_TIME, SELLER_ID, FEEDBACK_SCORE, CATEGORY_NAME, CURRENCY_ID FROM LZ_BD_CATAG_DATA WHERE MAIN_CATEGORY_ID = $category_id");
		$totalData = $sql->num_rows();
		$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

		$sql = "SELECT LZ_BD_CATA_ID, CATEGORY_ID, EBAY_ID, TITLE, CONDITION_NAME, ITEM_URL, SALE_PRICE, LISTING_TYPE, START_TIME, SALE_TIME, SELLER_ID, FEEDBACK_SCORE, CATEGORY_NAME, CURRENCY_ID ";
		if($category_id == 0){
			$sql.=" FROM LZ_BD_CATAG_DATA";
			if(!empty($keyword) ) {   // if there is a search parameter, $keyword contains search parameter
				// $sql.=" WHERE ( CATEGORY_NAME LIKE '%".$keyword."%' ";    
				// $sql.=" OR UPPER(TITLE) LIKE '%".$keyword."%' ";
				// $sql.=" OR CONDITION_NAME LIKE '%".$keyword."%' ";
				// $sql.=" OR SELLER_ID LIKE '%".$keyword."%' ";
				// $sql.=" OR LISTING_TYPE LIKE '%".$keyword."%' ";
				// $sql.=" OR START_TIME LIKE '%".$keyword."%' ";
				// $sql.=" OR SALE_TIME LIKE '%".$keyword."%' ";
				// $sql.=" OR EBAY_ID LIKE '".$keyword."' )";

				//$sql.=" WHERE REGEXP_LIKE (UPPER(TITLE),'".$keyword."')";
				if (count($str)>1) {
					$i=1;
					foreach ($str as $key) {
						if($i === 1){
							$sql.=" WHERE UPPER(TITLE) LIKE '%$key%' ";
						}else{
							$sql.=" AND UPPER(TITLE) LIKE '%$key%' ";
						}
						$i++;
					}
				}else{
					$sql.=" WHERE UPPER(TITLE) LIKE '%$keyword%' ";
				}


				if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
					$sql.=" AND ( CATEGORY_NAME LIKE '%".$requestData['search']['value']."%' ";    
					$sql.=" OR CATEGORY_ID LIKE '".$requestData['search']['value']."' ";
					$sql.=" OR MAIN_CATEGORY_ID LIKE '".$requestData['search']['value']."' ";
					$sql.=" OR UPPER(TITLE) LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR START_TIME LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR SALE_TIME LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR EBAY_ID LIKE '".$requestData['search']['value']."' )";
				}
			}else{
				if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
					$sql.=" WHERE ( CATEGORY_NAME LIKE '%".$requestData['search']['value']."%' ";    
					$sql.=" OR CATEGORY_ID LIKE '".$requestData['search']['value']."' ";
					$sql.=" OR MAIN_CATEGORY_ID LIKE '".$requestData['search']['value']."' ";
					$sql.=" OR UPPER(TITLE) LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR START_TIME LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR SALE_TIME LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR EBAY_ID LIKE '".$requestData['search']['value']."' )";
				}
			}
		}else{
			$sql.=" FROM LZ_BD_CATAG_DATA WHERE MAIN_CATEGORY_ID = $category_id";
			if(!empty($keyword) ) {   // if there is a search parameter, $keyword contains search parameter
				// $sql.=" AND ( CATEGORY_NAME LIKE '%".$keyword."%' ";    
				// $sql.=" OR UPPER(TITLE) LIKE '%".$keyword."%' ";
				// $sql.=" OR CONDITION_NAME LIKE '%".$keyword."%' ";
				// $sql.=" OR SELLER_ID LIKE '%".$keyword."%' ";
				// $sql.=" OR LISTING_TYPE LIKE '%".$keyword."%' ";
				// $sql.=" OR START_TIME LIKE '%".$keyword."%' ";
				// $sql.=" OR SALE_TIME LIKE '%".$keyword."%' ";
				// $sql.=" OR EBAY_ID LIKE '".$keyword."' )";

				//$sql.=" AND REGEXP_LIKE (UPPER(TITLE),'".$keyword."')";
				if (count($str)>1) {
					foreach ($str as $key) {
						$sql.=" AND UPPER(TITLE) LIKE '%$key%'";
					}
				}else{
					$sql.=" AND UPPER(TITLE) LIKE '%$keyword%'";
				}
			}
			if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
				$sql.=" AND ( CATEGORY_NAME LIKE '%".$requestData['search']['value']."%' ";    
				$sql.=" OR CATEGORY_ID LIKE '".$requestData['search']['value']."' ";
				$sql.=" OR MAIN_CATEGORY_ID LIKE '".$requestData['search']['value']."' ";
				$sql.=" OR UPPER(TITLE) LIKE '%".$requestData['search']['value']."%' ";
				$sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' ";
				$sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' ";
				$sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' ";
				$sql.=" OR START_TIME LIKE '%".$requestData['search']['value']."%' ";
				$sql.=" OR SALE_TIME LIKE '%".$requestData['search']['value']."%' ";
				$sql.=" OR EBAY_ID LIKE '".$requestData['search']['value']."' )";
			}
		}//main if else


		$query = $this->db->query($sql." AND MPN_MT_ID IS NULL");
		//$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
		$totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
		$sql.=" AND MPN_MT_ID IS NULL ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
		//$sql="SELECT * FROM ($sql) WHERE ROWNUM <= 100"; 
		$sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($sql) q ) WHERE   rn BETWEEN ".$requestData['start']." AND ".$requestData['length'];
		/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
		//$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
		$query = $this->db->query($sql);
		//$query->result_array();
		$data = array();
		foreach($query->result_array() as $row){ // preparing an array
			$listing_type=$row['LISTING_TYPE'];
			  if ($listing_type=='FixedPrice') {
			      $listing_type ="BIN";
			  }elseif ($listing_type=='StoreInventory') {
			      $listing_type = "BIN/Best Offer";
			  }
			$nestedData=array(); 

			$nestedData[] =	"<input title='checkbox' type='checkbox' name='select_recognize[]' id='select_recognize' value='".$row['LZ_BD_CATA_ID']."'>
					<i id='".$row['LZ_BD_CATA_ID']."' style=' cursor: pointer;' title='Show Detail' class='btn btn-primary btn-xs fa fa-external-link' aria-hidden='true' onclick='autoFill(this.id)'></i>
					";
		    
			$nestedData[] = $row["CATEGORY_NAME"];
			$nestedData[] = $row["CATEGORY_ID"];
			$nestedData[] = "<a target='_blank' href='".$row['ITEM_URL']. "'>".$row['EBAY_ID']. "</a>";
			//$nestedData[] = $row["EBAY_ID"];
			$nestedData[] =  $row["TITLE"];
			$nestedData[] = $row["CONDITION_NAME"];
			$nestedData[] = $row["SELLER_ID"];
			$nestedData[] = $listing_type;
			$nestedData[] = '$ '.number_format((float)@$row['SALE_PRICE'],2,'.',',');
			//$nestedData[] = $row["SALE_PRICE"];
			$nestedData[] = $row["START_TIME"];
			$nestedData[] = $row["SALE_TIME"];
			$nestedData[] = $row["FEEDBACK_SCORE"];
			$data[] = $nestedData;
		}

		$json_data = array(
					"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => intval( $totalData ),  // total number of records
					"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data   // total data array
					);
		return $json_data;


	}
	public function autoFill(){
		$lz_bd_cata_id = $this->input->post('lz_bd_cata_id');
		/*===========================================
		=            Auto Fill Specifics            =
		===========================================*/
		$spec_qry = "SELECT  M.MT_ID,M.MT_ID||'_'||M.SPECIFIC_NAME SPECIFIC_NAME,D.DET_ID||'_'||D.SPECIFIC_VALUE SPECIFIC_VALUE FROM LZ_BD_CATAG_DATA CD, CATEGORY_SPECIFIC_MT M ,CATEGORY_SPECIFIC_DET D WHERE CD.MAIN_CATEGORY_ID = M.EBAY_CATEGORY_ID AND M.MT_ID = D.MT_ID AND UPPER(CD.TITLE) LIKE '%'||UPPER(D.SPECIFIC_VALUE)||'%'AND CD.LZ_BD_CATA_ID = $lz_bd_cata_id"; 
		$spec_qry = $this->db->query($spec_qry);
		$spec_qry = $spec_qry->result_array();
		/*=====  End of Auto Fill Specifics  ======*/
		/*=====================================
		=            Auto Fill MPN            =
		=====================================*/
		$mpn_qry = "SELECT T3.DATA_TYPE, T1.DATA_DESC     AS DATA_DESC FROM LZ_GOOGDATA T1, LZ_BD_CATAG_DATA T2, LZ_GOOG_DATA_TYPE T3 WHERE T3.DATA_TYPE_ID = T1.DATA_TYPE_ID AND UPPER(T2.TITLE) LIKE '%' || T1.DATA_DESC || '%'AND T2.LZ_BD_CATA_ID = $lz_bd_cata_id"; 
		$mpn_qry = $this->db2->query($mpn_qry);
		$mpn_qry = $mpn_qry->result_array();

		/*=====  End of Auto Fill MPN  ======*/
		
		return array('spec_qry'=>$spec_qry,'mpn_qry'=>$mpn_qry);
	}
	public function varifiedData(){
		$lz_bd_cata_id = $this->uri->segment(4);
		/*===========================================
		=            Auto Fill Specifics            =
		===========================================*/
		$spec_qry = "SELECT * FROM LZ_BD_VERIFIED_DATA V WHERE V.LZ_BD_CATA_ID = $lz_bd_cata_id"; 
		$spec_qry = $this->db2->query($spec_qry);
		$spec_qry = $spec_qry->result_array();
		//var_dump($lz_bd_cata_id);exit;
		/*=====  End of Auto Fill Specifics  ======*/
		/*=====================================
		=            Auto Fill MPN            =
		=====================================*/
		$mpn_qry = "SELECT DISTINCT M.MPN_MT_ID, C.LZ_BD_CATA_ID, C.TITLE, M.MPN, M.MODEL, M.PRODUCT_FAMILY, M.MANUFACTURER, M.BRAND, M.OBJECT_ID, O.OBJECT_NAME FROM LZ_BD_MPN_MT M, LZ_BD_OBJECTS_MT O,LZ_BD_CATAG_DATA C WHERE M.OBJECT_ID = O.OBJECT_ID AND M.MPN_MT_ID = C.MPN_MT_ID AND C.LZ_BD_CATA_ID = $lz_bd_cata_id"; 
		$mpn_qry = $this->db2->query($mpn_qry);
		$mpn_qry = $mpn_qry->result_array();

		/*=====  End of Auto Fill MPN  ======*/
		
		return array('spec_qry'=>$spec_qry,'mpn_qry'=>$mpn_qry);
	}
	public function getSuggestedMPN(){
		$unverfied_title_id = $this->input->post('title_id');
		$category_id = $this->input->post('category_id');
		
		/*===========================================
		=            Auto Fill Specifics            =
		===========================================*/
		$process_title = "CALL PRO_PROCESS_TITLE_FOR_MPN($unverfied_title_id)"; 
		/*=====  End of Auto Fill Specifics  ======*/
		if ($this->db2->query($process_title)){
			/*===========================================
			=            Auto Fill Specifics            =
			===========================================*/
			$mpn_qry = "SELECT MPN_MT_ID, MPN, MAX(CNT) CNT  FROM (SELECT DISTINCT C.MPN_MT_ID, M.MPN, GET_INTERSECT_COUNT(C.LZ_BD_CATA_ID) CNT FROM LZ_BD_CATAG_DATA C, LZ_BD_MPN_MT M WHERE C.VERIFIED = 1 AND C.MAIN_CATEGORY_ID = $category_id AND M.MPN_MT_ID = C.MPN_MT_ID AND GET_INTERSECT_COUNT(C.LZ_BD_CATA_ID) > 1 ) GROUP BY MPN_MT_ID, MPN ORDER BY CNT DESC "; 
			$mpn_qry = $this->db2->query($mpn_qry); 
			$mpn_qry = $mpn_qry->result_array();
			//var_dump($lz_bd_cata_id);exit;
			/*=====  End of Auto Fill Specifics  ======*/
		}else{
			$mpn_qry = 0;
		}
		return $mpn_qry;
	}
	public function selectSugestedMPN(){
		$mpn_mt_id = $this->input->post('mpn_mt_id');
		
			/*===========================================
			=            Auto Fill Specifics            =
			===========================================*/
			$mpn_qry = "SELECT M.MPN, M.MANUFACTURER, M.BRAND, M.MODEL, M.PRODUCT_FAMILY, O.OBJECT_NAME FROM LZ_BD_MPN_MT M, LZ_BD_OBJECTS_MT O WHERE M.MPN_MT_ID = $mpn_mt_id AND O.OBJECT_ID = M.OBJECT_ID"; 
			$mpn_qry = $this->db2->query($mpn_qry); 
			$mpn_qry = $mpn_qry->result_array();
			//var_dump($lz_bd_cata_id);exit;
			/*=====  End of Auto Fill Specifics  ======*/

		return $mpn_qry;
	}	
	public function verifyDataConfirm(){
		$lz_bd_cata_id = $this->input->post('title_id');
		$mpn_mt_id = $this->input->post('mpn_mt_id');
		$object_id = $this->input->post('object_id');
		/*============================================
		=            Delete previous data            =
		============================================*/

		$del_spec_qry = "DELETE FROM LZ_BD_VERIFIED_DATA WHERE LZ_BD_CATA_ID = $lz_bd_cata_id"; 
		$this->db2->query($del_spec_qry);
		// $del_mpn_qry = "DELETE FROM LZ_BD_MPN_MT WHERE MPN_MT_ID = $mpn_mt_id"; 
		// $this->db2->query($del_mpn_qry);
		// $object_qry = "DELETE FROM LZ_BD_OBJECTS_MT WHERE OBJECT_ID = $object_id"; 
		// $this->db2->query($object_qry);
		/*=====  End of Delete previous data  ======*/
		
		/*===========================================
		=            Insert varified Data             =
		===========================================*/
		$category_id = $this->input->post('cat_id');
		$model_bd = $this->input->post('model_bd');
		$model_bd = trim(str_replace("  ", ' ', $model_bd));
        $model_bd = trim(str_replace(array("'"), "''", $model_bd));
        $model_bd = strtoupper($model_bd);		
		$object_bd = $this->input->post('object_bd');
		$object_bd = strtoupper($object_bd);
		$mpn_bd = $this->input->post('mpn_bd');
		$mpn_bd = trim(str_replace("  ", ' ', $mpn_bd));
        $mpn_bd = trim(str_replace(array("'"), "''", $mpn_bd));
        $mpn_bd = strtoupper($mpn_bd);
		$manufacturer_bd = $this->input->post('manufacturer_bd');
		$manufacturer_bd = trim(str_replace("  ", ' ', $manufacturer_bd));
        $manufacturer_bd = trim(str_replace(array("'"), "''", $manufacturer_bd));
        $manufacturer_bd = strtoupper($manufacturer_bd);
		$array_count = $this->input->post('array_count');
		$user_id = $this->session->userdata('user_id');
        date_default_timezone_set("America/Chicago");
        $current_date = date("Y-m-d H:i:s");
        $current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";
        $comma = ',';
       

        $qry_data = $this->db2->query("SELECT OBJECT_ID FROM LZ_BD_OBJECTS_MT WHERE OBJECT_TYPE = 7 AND OBJECT_NAME = '$object_bd'");
        
        if($qry_data->num_rows()==0){
        	
        	/*=====================================
	        =            insert object            =
	        =====================================*/

	        $qry_data = $this->db2->query("SELECT GET_PRIMARY_KEY('LZ_BD_OBJECTS_MT','OBJECT_ID') OBJECT_ID FROM DUAL");
		    $rs = $qry_data->result_array();           
		    $object_id= $rs[0]['OBJECT_ID'];
		    //var_dump($object_id);
	        $query = $this->db2->query("INSERT INTO LZ_BD_OBJECTS_MT (OBJECT_ID,OBJECT_TYPE,OBJECT_NAME)VALUES($object_id $comma 7 $comma '$object_bd')");       
	        
	        /*=====  End of insert object  ======*/

        }else{
        	$data = $qry_data->result_array();
        	$object_id= @$data[0]['OBJECT_ID'];

        }
        $qry_mpn = $this->db2->query("SELECT MPN_MT_ID FROM LZ_BD_MPN_MT WHERE MPN = '$mpn_bd'");
        if($qry_mpn->num_rows()==0){
        	
        	/*=====================================
	        =            insert mpn            =
	        =====================================*/

	        $qry_mpn = $this->db2->query("SELECT GET_PRIMARY_KEY('LZ_BD_MPN_MT','MPN_MT_ID') MPN_MT_ID FROM DUAL");
		    $rs = $qry_mpn->result_array();           
		    $mpn_mt_id= $rs[0]['MPN_MT_ID'];
		    //var_dump($mpn_mt_id);
			$query = $this->db2->query("INSERT INTO LZ_BD_MPN_MT (MPN_MT_ID, MPN, MANUFACTURER, BRAND, MODEL, PRODUCT_FAMILY, CATEGORY_ID, OBJECT_ID)VALUES($mpn_mt_id $comma '$mpn_bd' $comma '$manufacturer_bd' $comma '$brand' $comma '$model_bd' $comma '$product_family' $comma $category_id $comma $object_id )");
	        
	        /*=====  End of insert mpn  ======*/

        }else{
        	$qry_mpn = $qry_mpn->result_array();
        	$mpn_mt_id= @$qry_mpn[0]['MPN_MT_ID'];
        	/*==========================================================
			=            update DATA in LZ_BD_MPN_MT            =
			==========================================================*/
			$qry_data = $this->db2->query("UPDATE LZ_BD_MPN_MT SET MPN = '$mpn_bd', MANUFACTURER = '$manufacturer_bd', BRAND = '$brand', MODEL = '$model_bd', OBJECT_ID = $object_id WHERE MPN_MT_ID = $mpn_mt_id");			
			/*=====  End of update DATA in LZ_BD_MPN_MT  ======*/
        }

        //exit;
		//foreach($select_recognize as $lz_bd_cata_id):
			

				for ($i = 1; $i <= $array_count; $i++) { 
	 				$spec_name = $this->input->post('specific_name_'.$i);
	 				$str = explode("_", @$spec_name);
			        $spec_mt_id = @$str[0];
			        //echo $spec_name;
			        /*==========================================================
					=            check if already inserted/varified            =
					==========================================================*/
					$qry_data = $this->db2->query("SELECT VERIFIED_ID FROM LZ_BD_VERIFIED_DATA WHERE LZ_BD_CATA_ID = $lz_bd_cata_id AND SPEC_MT_ID = $spec_mt_id");			
					/*=====  End of check if already inserted/varified  ======*/
					if($qry_data->num_rows() == 0):
						$specific_name = @$str[1];
				        $specific_name = trim(str_replace("  ", ' ', $specific_name));
				        $specific_name = trim(str_replace(array("'"), "''", $specific_name));
				        $specific_name = strtoupper($specific_name);
						$spec_value = $this->input->post('specific_'.$i);
							
						if(is_array(@$spec_value)){
				          $spec_val = explode(",", @$spec_value);
				          
				          foreach ($spec_val as $value) {
				          	$spec_val = explode("_", @$value);
				          	$spec_det_id = @$value[0];
				          	$spec_value = @$value[1];
				          	$spec_value = trim(str_replace("  ", ' ', $spec_value));
					        $spec_value = trim(str_replace(array("'"), "''", $spec_value));
					        $spec_value = strtoupper($spec_value);
				          	if(is_numeric($spec_det_id)){
				          		$qry_data = $this->db2->query("SELECT GET_PRIMARY_KEY('LZ_BD_VERIFIED_DATA','VERIFIED_ID') VERIFIED_ID FROM DUAL");
							    $rs = $qry_data->result_array();           
							    $verified_id= $rs[0]['VERIFIED_ID'];
				          		$query = $this->db2->query("INSERT INTO LZ_BD_VERIFIED_DATA (VERIFIED_ID, LZ_BD_CATA_ID, SPEC_DET_ID, SPEC_DET_VALUE, SPEC_MT_ID, SPEC_MT_VALUE)VALUES($verified_id $comma $lz_bd_cata_id $comma $spec_det_id $comma '$spec_value' $comma $spec_mt_id $comma '$specific_name')");
				          	}
				          	
				          }
				        }else{

				        	$spec_val = explode("_", @$spec_value);
				          	$spec_det_id = @$spec_val[0];
				          	$spec_value = @$spec_val[1];
				          	$spec_value = trim(str_replace("  ", ' ', $spec_value));
					        $spec_value = trim(str_replace(array("'"), "''", $spec_value));
					        $spec_value = strtoupper($spec_value);
		/*===========================================================================
		=            update product family / product line in lz_bd_mpn_mt            =
		===========================================================================*/
						if($specific_name == 'PRODUCT LINE' || $specific_name == 'PRODUCT FAMILY'){
							$qry_data = $this->db2->query("UPDATE LZ_BD_MPN_MT SET PRODUCT_FAMILY = '$spec_value' WHERE MPN_MT_ID = $mpn_mt_id");
						}
						if($specific_name == 'BRAND'){
							$qry_data = $this->db2->query("UPDATE LZ_BD_MPN_MT SET BRAND = '$spec_value' WHERE MPN_MT_ID = $mpn_mt_id");
						}

		/*=====  End of update product family / product line in lz_bd_mpn_mt  ======*/
				          	if(is_numeric($spec_det_id)){
				          		$qry_data = $this->db2->query("SELECT GET_PRIMARY_KEY('LZ_BD_VERIFIED_DATA','VERIFIED_ID') VERIFIED_ID FROM DUAL");
							    $rs = $qry_data->result_array();           
							    $verified_id= $rs[0]['VERIFIED_ID'];
				          		$query = $this->db2->query("INSERT INTO LZ_BD_VERIFIED_DATA (VERIFIED_ID, LZ_BD_CATA_ID, SPEC_DET_ID, SPEC_DET_VALUE, SPEC_MT_ID, SPEC_MT_VALUE)VALUES($verified_id $comma $lz_bd_cata_id $comma $spec_det_id $comma '$spec_value' $comma $spec_mt_id $comma '$specific_name')");
				          	}
				        }
					endif;

				}//end for loop
		if(@$query && !empty(@$query)){	
			/*==========================================================
			=            update MPN_MT_ID in lz_bd_catag_data            =
			==========================================================*/
			$qry_data = $this->db2->query("UPDATE LZ_BD_CATAG_DATA SET MPN_MT_ID = $mpn_mt_id,VERIFIED = 1 WHERE LZ_BD_CATA_ID = $lz_bd_cata_id");			
			/*=====  End of update MPN_MT_ID in lz_bd_catag_data  ======*/

        	$this->session->set_flashdata('success', 'Record Varified Successfully.');
	    }else{
	        $this->session->set_flashdata('warning', 'Record Already Varified.');
	    }	

		//endforeach;
		/*=====  End of Insert varified Data   ======*/

		// /*================================================================
		// =            check if alredy inserted in LZ_BD_MPN_MT            =
		// ================================================================*/
		// $qry_mpn = $this->db2->query("SELECT MPN_MT_ID FROM LZ_BD_MPN_MT WHERE MPN = '$mpn_bd'");
		// /*=====  End of check if alredy inserted in LZ_BD_MPN_MT  ======*/

  //       if($qry_mpn->num_rows()==0){
        	
  //       	/*=====================================
		// =            INSERT DATA IN LZ_BD_MPN_MT            =
		// =====================================*/

	 //        $qry_mpn = $this->db2->query("SELECT GET_PRIMARY_KEY('LZ_BD_MPN_MT','MPN_MT_ID') MPN_MT_ID FROM DUAL");
		//     $rs = $qry_mpn->result_array();           
		//     $mpn_mt_id= $rs[0]['MPN_MT_ID'];
		//     //var_dump($LZ_BD_REL_ID);

	 //        $query = $this->db2->query("INSERT INTO LZ_BD_MPN_MT (MPN_MT_ID MPN, MANUFACTURER, BRAND, MODEL, PRODUCT_FAMILY, CATEGORY_ID, OBJECT_ID)VALUES($mpn_mt_id $comma '$mpn_bd' $comma '$manufacturer' $comma '$brand' $comma '$model_bd' $comma '$product_family' $comma $category_id $comma $object_id)");       
	        
	 //        /*=====  End of INSERT DATA IN LZ_BD_MPN_MT  ======*/

  //       }
		
		
		

		
		// //return array('spec_qry'=>$spec_qry,'mpn_qry'=>$mpn_qry);
	}
	
}