<?php 

	/**
	* Listing Model
	*/
	class Listing_Model extends CI_Model
	{

		public function __construct(){
		parent::__construct();
		$this->load->database();
		}
		
		public function listed_data()
		{
			$from = date('m/d/Y', strtotime('-3 months'));// date('m/01/Y');
			$to = date('m/d/Y');
			$main_query = "select t.item_pic,decode(s.item_title, null, t.item_mt_desc, s.item_title) item_title,t.Manufacturer,t.MFG_Part_No,t.SKU_No,t.UPC,decode(s.default_cond, null, t.item_condition, s.default_cond) item_condition,t.Not_List_Qty,t.SALV_QTY,t.COST_US,t.list_price,t.SalValue,t.laptop_item_code,t.PURCH_REF_NO,t.purchase_date,t.AVAIL_QTY,t.LIST_QTY,t.LZ_MANIFEST_ID,t.it_barcode,t.item_id from view_lz_listing_revised t, lz_item_seed s";
			$qry_condition = " where t.item_id = s.item_id(+) and t.lz_manifest_id = s.lz_manifest_id(+) and s.item_id is null and s.lz_manifest_id is null and AVAIL_QTY -(NVL(LIST_QTY, 0) + NVL(SALV_QTY, 0)) = AVAIL_QTY";
			$date_qry = "AND t.purchase_date between TO_DATE('$from','MM/DD/YY') and TO_DATE('$to ','MM/DD/YY')";
			$query = $this->db->query( $main_query." ".$qry_condition." ".$date_qry);
			
			return $query->result_array();

			//return $query->result(); // This will return data in Ojbects

			// return $query->result_array(); // This will return data in Array 

		}
		public function seed_data(){
			$query = $this->db->query("SELECT * FROM LZ_ITEM_SEED");
			return $query->result_array();
		}

		public function check_item_id($item_id){
			$LZ_SELLER_ACCT_ID= $this->session->userdata('account_type');
			$q = $this->db->query("SELECT ITEM_ID,EBAY_ITEM_ID FROM EBAY_LIST_MT WHERE ITEM_ID = $item_id and LZ_SELLER_ACCT_ID=$LZ_SELLER_ACCT_ID order by LIST_DATE DESC");
			$rslt = $q->result_array();
			 if(!empty($rslt)){
			 	$ebay_id=$rslt[0]['EBAY_ITEM_ID'];
			 	$this->session->set_userdata('check_item_id', true);
			 	$this->session->set_userdata('ebay_item_id', $ebay_id);
			 	return true;
			}else{
			 	$this->session->set_userdata('check_item_id', false);
			 	return false;
			  }
		}

		public function uplaod_seed($item_id,$manifest_id){
			
			$query = $this->db->query("SELECT * FROM VIEW_LZ_UPLOAD_SEED where ITEM_ID = $item_id and LZ_MANIFEST_ID = $manifest_id");
			 return $query->result_array();
		}

		public function insert_ebay_id($item_id,$manifest_id){

			$query = $this->db->query("SELECT * FROM VIEW_LZ_UPLOAD_SEED where ITEM_ID = $item_id and LZ_MANIFEST_ID = $manifest_id");

			 $rslt_dta = $query->result_array();

			$list_rslt = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('ebay_list_mt','LIST_ID') LIST_ID FROM DUAL");
			$rs = $list_rslt->result_array();
			$LIST_ID = $rs[0]['LIST_ID'];
			$this->session->set_userdata('list_id',$LIST_ID);
			$ebay_id = $this->session->userdata('ebay_item_id');
			//$list_date = date("d/M/Y");// return format Aug/13/2016
			date_default_timezone_set("America/Chicago");
			$list_date = date("Y-m-d H:i:s");
            $list_date= "TO_DATE('".$list_date."', 'YYYY-MM-DD HH24:MI:SS')";
			$lister_id = $this->session->userdata('user_id');
			$ebay_item_desc = $rslt_dta[0]['ITEM_TITLE'];
		    $ebay_item_desc = trim(str_replace("  ", '', $ebay_item_desc));
		    $ebay_item_desc = trim(str_replace(array("'"), "''", $ebay_item_desc));
			$list_qty = $rslt_dta[0]['QUANTITY'];
			$ebay_item_id = $ebay_id;
			$list_price = $rslt_dta[0]['EBAY_PRICE'];
			$remarks = NULL;
			$single_entry_id = NULL;
			$salvage_qty = 0.00;
			$entry_type ="L";
			$seed_id=NULL;
			$LZ_SELLER_ACCT_ID= $this->session->userdata('account_type');
			$insert_query = $this->db->query("INSERT INTO ebay_list_mt VALUES (".$LIST_ID.",".$manifest_id.", ".$LIST_ID.", ".$item_id.", ".$list_date.", ".$lister_id.", '".$ebay_item_desc."', ".$list_qty.",".$ebay_item_id.",".$list_price.",NULL,NULL, NULL, '".$entry_type."',".$LZ_SELLER_ACCT_ID.",".$seed_id.")");
		}
		public function uplaod_listQty($item_id,$manifest_id,$list_qty){

			$data = array('QUANTITY' => $list_qty);
			$this->db->where('ITEM_ID', $item_id);
  			$this->db->where('LZ_MANIFEST_ID', $manifest_id);
  			$rsl = $this->db->update('LZ_ITEM_SEED', $data);

		}	

		public function check_avail_qty($item_id,$manifest_id){
			$query = $this->db->query("SELECT * FROM VIEW_LZ_LISTING_REVISED where ITEM_ID = $item_id and LZ_MANIFEST_ID = $manifest_id");
			 $result = $query->result_array();
			 $list_qty = $result[0]['LIST_QTY'];
			 $avail_qty = $result[0]['AVAIL_QTY'];
			 $remain_qty = $avail_qty - $list_qty;
			 return $remain_qty;
		}

		public function uplaod_seed_pic($item_id,$manifest_id){

			$query = $this->db->query("SELECT I.ITEM_MT_MFG_PART_NO,I.ITEM_MT_UPC,B.CONDITION_ID FROM ITEMS_MT I, LZ_BARCODE_MT B WHERE I.ITEM_ID = B.ITEM_ID AND B.LZ_MANIFEST_ID =$manifest_id AND B.ITEM_ID = $item_id"); 
			$result=$query->result_array();
			$mpn = $result[0]['ITEM_MT_MFG_PART_NO'];
			$upc = $result[0]['ITEM_MT_UPC'];
			$it_condition = $result[0]['CONDITION_ID'];

	    	if(is_numeric(@$it_condition)){
		        if(@$it_condition == 3000){
		          @$it_condition = 'Used';
		        }elseif(@$it_condition == 1000){
		          @$it_condition = 'New'; 
		        }elseif(@$it_condition == 1500){
		          @$it_condition = 'New other'; 
		        }elseif(@$it_condition == 2000){
		            @$it_condition = 'Manufacturer refurbished';
		        }elseif(@$it_condition == 2500){
		          @$it_condition = 'Seller refurbished'; 
		        }elseif(@$it_condition == 7000){
		          @$it_condition = 'For parts or not working'; 
		        }else{
		            @$it_condition = 'Used'; 
		        }
		    }else{// end main if
		      $it_condition  = ucfirst(@$it_condition);
		    }
		    $mpn = str_replace('/', '_', @$mpn);

/*==============================================
=            Master Picture Check            =
==============================================*/
		    //$dir = "D:/item_pictures/master_pictures/".@$data_get[0]->['UPC']."~".@$mpn."/".@$it_condition;
			// Open a directory, and read its contents
		    $query = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG");
		    $master_qry = $query->result_array();
		    $master_path = $master_qry[0]['MASTER_PATH'];

		   	$m_dir = $master_path.@$upc."~".@$mpn."/".@$it_condition;
		    if(is_dir(@$m_dir)){
					  $iterator = new \FilesystemIterator(@$m_dir);
				    if (@$iterator->valid()){    
				    	$m_flag = true;
					}else{
						$m_flag = false;
					}
			}else{
				$m_flag = false;
			}


/*=====  End of Master Picture Check  ======*/

/*==============================================
=            Specific Picture Check            =
==============================================*/
		    //$dir = "D:/item_pictures/master_pictures/".@$data_get[0]->['UPC']."~".@$mpn."/".@$it_condition;
			$query = $this->db->query("SELECT SPECIFIC_PATH FROM LZ_PICT_PATH_CONFIG");
			$specific_qry = $query->result_array();
			$specific_path = $specific_qry[0]['SPECIFIC_PATH'];

            $s_dir = $specific_path.@$upc."~".$mpn."/".@$it_condition."/".$manifest_id;
		    // Open a directory, and read its contents
		    if(is_dir(@$s_dir)){
					  $iterator = new \FilesystemIterator(@$s_dir);
				    if (@$iterator->valid()){    
				    	$s_flag = true;
					}else{
						$s_flag = false;
					}
			}else{
				$s_flag = false;
			}


/*=====  End of Specific Picture Check  ======*/
	if($m_flag && $s_flag){
		return "B";

	}elseif($m_flag === true && $s_flag === false){
		return "M";
	}elseif($m_flag === false && $s_flag === true){
		return "S";
	}elseif($m_flag === false && $s_flag === false){

					$query = $this->db->query("SELECT item_pict_desc,item_pic FROM item_pictures_mt where ITEM_ID = $item_id and LZ_MANIFEST_ID = $manifest_id");
					$result=$query->result_array();
					if(!empty($result)){
						return $query->result_array();
					}else{
						$query = $this->db->query("SELECT ITEM_ID,LZ_MANIFEST_ID FROM item_pictures_mt where ITEM_ID = $item_id AND LZ_MANIFEST_ID = (SELECT MAX(LZ_MANIFEST_ID) FROM item_pictures_mt WHERE ITEM_ID = $item_id) AND ROWNUM =1");
						$result = $query->result_array();
						if(!empty($result)){
							$item_id = $result[0]['ITEM_ID'];
							$manifest_id = $result[0]['LZ_MANIFEST_ID'];
							$query = $this->db->query("SELECT item_pict_desc,item_pic FROM item_pictures_mt where ITEM_ID = $item_id and LZ_MANIFEST_ID = $manifest_id");
							return $query->result_array();
						}else{
							echo "Please Select Images.Add at least 1 photo. More photos are better! Show off your item from every angle and zoom in on details.";
							exit;//You can't "break" from an if statement. You can only break from a loop.
						}
					}

			}
		}//end function
	public function item_specifics($item_id, $manifest_id){
		// $item_id = 18786;
		// $manifest_id = 13827;
			$query = $this->db->query("SELECT I.ITEM_MT_UPC, I.ITEM_MT_MFG_PART_NO, S.CATEGORY_ID FROM ITEMS_MT I, LZ_ITEM_SEED S WHERE I.ITEM_ID = $item_id AND I.ITEM_ID = S.ITEM_ID AND S.LZ_MANIFEST_ID = $manifest_id AND ROWNUM = 1");
			$result = $query->result_array();
			if($query->num_rows() > 0){

				// $spec_query = $this->db->query("SfELECT * FROM LZ_ITEM_SPECIFICS_MT MT WHERE MT.ITEM_ID = $item_id AND MT.MPN = '".$result[0]['ITEM_MT_MFG_PART_NO'] ."' AND MT.UPC = '".$result[0]['ITEM_MT_UPC'] ."' AND MT.CATEGORY_ID = ".$result[0]['CATEGORY_ID'] ."");
				$spec_query = $this->db->query("SELECT MT.SPECIFICS_NAME, DT.SPECIFICS_VALUE FROM LZ_ITEM_SPECIFICS_MT MT, LZ_ITEM_SPECIFICS_DET DT WHERE DT.SPECIFICS_MT_ID = MT.SPECIFICS_MT_ID AND MT.ITEM_ID = $item_id AND MT.MPN = '".$result[0]['ITEM_MT_MFG_PART_NO']."' AND MT.UPC = '".$result[0]['ITEM_MT_UPC']."' AND MT.CATEGORY_ID = ".$result[0]['CATEGORY_ID']."");
				$spec_query = $spec_query->result_array();

			}else{
				$spec_query = "";
			}

			return $spec_query; 

			//var_dump($spec_query);exit ;

			

		}	
	// code section added by adil asad 1-19-2018
	//*******************************************
		public function print_audit_label(){
			$list_id = $this->uri->segment(4);
			$print_qry = $this->db->query("SELECT DISTINCT MD.ITEM_MT_BBY_SKU,MM.PURCH_REF_NO,MD.ITEM_MT_MANUFACTURE BRAND,MD.ITEM_MT_MFG_PART_NO MPN,T.EBAY_ITEM_DESC ITEM_DESC,T.EBAY_ITEM_ID,'*' || T.EBAY_ITEM_ID || '*' BAR_CODE FROM EBAY_LIST_MT T, ITEMS_MT IM, LZ_MANIFEST_DET MD, LZ_MANIFEST_MT MM WHERE T.ITEM_ID = IM.ITEM_ID AND IM.ITEM_CODE = MD.LAPTOP_ITEM_CODE AND MM.LZ_MANIFEST_ID = MD.LZ_MANIFEST_ID AND T.LIST_ID =$list_id");

			return $print_qry->result_array();

		}

	// code section added by adil asad 1-19-2018
	//*******************************************


	}

 ?>