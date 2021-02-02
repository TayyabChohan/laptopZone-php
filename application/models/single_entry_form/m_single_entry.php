<?php 
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
	/**
	* Single Entry Model
	*/
	class M_Single_Entry extends CI_Model
	{

		public function __construct(){
		parent::__construct();
		$this->load->database();
		}

		public function loading_no(){
/*=============================================
			=            Create auto Purchase Ref No.            =
			=============================================*/
		  $rs = $this->db->query("SELECT * FROM (SELECT PURCHASE_REF_NO, ID LOADING_NO FROM LZ_SINGLE_ENTRY ORDER BY ID DESC) WHERE   ROWNUM = 1")->result_array();

		  $get_purch_ref = $rs[0]['PURCHASE_REF_NO'];
		  $load_num = $rs[0]['LOADING_NO']+1;

		   // $rs = $query->result_array();


		   $purch_ref = $get_purch_ref;
                      $str = explode('-', $purch_ref);
                      if(count($str) > 1){
                        $last_num = end($str);
                        $date = date('d-M-y');
                        $current_date = strtoupper($date);
                        $last_date = $str[0].'-'.$str[1].'-'.@$str[2];
                        if($last_date == $current_date){
                         $count = $last_num + 1;
                         $purch_ref = strtoupper($date.'-'. $count);
                        }else{
                         $purch_ref = strtoupper($date.'-'. 1);
                        }
                      }else{
                        $date = date('d-M-y');
                        //$current_date = strtoupper($date);
                        $purch_ref = strtoupper($date.'-'. 1);
                      }

                      //var_dump($purch_ref,$load_num);
                      //exit;
	      // $purch_ref = $rs[0]['PURCHASE_REF_NO'];
	      // $str = explode('-', $purch_ref);
	      // $last_num = end($str);
	      // $date = date('d-M-y');
       //    $current_date = strtoupper($date);
	      // $last_date = $str[0].'-'.$str[1].'-'.$str[2];
	      // if($last_date == $current_date){
	      // 	$count = $last_num + 1;
	      // 	$purch_ref = strtoupper($date.'-'. $count);
	      // }else{
	      // 	$purch_ref = strtoupper($date.'-'. 1);
	      // }
	      
			/*=====  End of Create auto Purchase Ref No.  ======*/

			// $list_rslt = $this->db->query("SELECT MAX(ID) as LOADING_NO FROM lz_single_entry");
			// $rs = $list_rslt->result_array();

			// $e = $rs[0]['LOADING_NO'];
			// //var_dump($e);exit;
			// if(@$e == 0){$ID = 1;}else{$ID = $e+1;}	

			return array('load_num' => $load_num, 'purch_ref' => $purch_ref, ); 
			//return $rs;
		}
		public function purchase_ref_no($purch_ref){

			$query = $this->db->query("SELECT * FROM PURCHASE_INVOICE_MT WHERE PURCH_INVOICE_REF_NO = '$purch_ref'");
			//var_dump($query->num_rows());exit;
			if($query->num_rows() == 0){
				return false;
			}else{
				return true;
			}
			//return $query->result_array();
		}
		public function get_cond(){

			$query = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT");
			//var_dump($query->num_rows());exit;

			return $query->result_array();
		}

		public function get_single_entry_two_data(){

			$get_singl_pk = $this->uri->segment('4');

			$gte_query = "SELECT LZ.*,C.COND_NAME FROM LZ_SINGLE_ENTRY_RAPID LZ,LZ_ITEM_COND_MT C WHERE LZ.COND_ID = C.ID ";

			if(!empty($get_singl_pk)){
				$gte_query .= " AND LZ.SINGLE_PK = $get_singl_pk";
			}
			$gte_query .= " ORDER BY  LZ.SINGLE_PK DESC";
			
			$query = $this->db->query($gte_query)->result_array();

			
			return array('query'=>$query);

		}

		public function add_two() {

		  $ent_upc = $this->input->post('ent_upc');
		  $ent_mpn = $this->input->post('ent_mpn');
		  $ent_qty = $this->input->post('ent_qty');
		  $ent_cost = $this->input->post('ent_cost');
		  $ent_con = $this->input->post('ent_con');

		  $query = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_SINGLE_ENTRY_RAPID','SINGLE_PK') SINGLE_PK FROM DUAL");
	      $rs = $query->result_array();
	      $single_pk = $rs[0]['SINGLE_PK'];

	      $sav_rec = $this->db->query("INSERT INTO LZ_SINGLE_ENTRY_RAPID (SINGLE_PK,UPC,MPN,COST,QTY,COND_ID)VALUES($single_pk,'$ent_upc','$ent_mpn',$ent_cost,$ent_qty,'$ent_con')");
	      if($sav_rec){
	      	return true;
	      }


		}
		
		public function add() {

		  //$loading_no = $this->input->post('loading_no');
		  $item_bin = trim($this->input->post('item_bin'));//Assign bin location	
		    $this->session->set_userdata('item_bin',$item_bin);
		 
		  $purch_ref = $this->input->post('purch_ref');
		  $purch_ref = trim(str_replace("  ", ' ', $purch_ref));
          $purch_ref = trim(str_replace(array("'"), "''", $purch_ref)); 
		  $suplier_desc = $this->input->post('suplier_desc');
		  $suplier_desc = trim(str_replace("  ", ' ', $suplier_desc));
          $suplier_desc = trim(str_replace(array("'"), "''", $suplier_desc));
		  $remarks = $this->input->post('remarks');
		  $remarks = trim(str_replace("  ", ' ', $remarks));
          $remarks = trim(str_replace(array("'"), "''", $remarks));
          //var_dump($skip_test);exit;
          if(empty($remarks)){
          	$remarks = "";
          }
		  $purchase_date = $this->input->post('purchase_date');
		  $purchase_date= "TO_DATE('".$purchase_date."', 'MM/DD/YYYY')";
		  $serial_no = $this->input->post('serial_no');
		  $serial_no = trim(str_replace("  ", ' ', $serial_no));
          $serial_no = trim(str_replace(array("'"), "''", $serial_no));
		  $manufacturer = $this->input->post('manufacturer');
		  $manufacturer = trim(str_replace("  ", ' ', $manufacturer));
          $manufacturer = trim(str_replace(array("'"), "''", $manufacturer));
          $list_date = "NULL";
		  $lot_ref = $this->input->post('lot_ref');
		  $lot_ref = trim(str_replace("  ", ' ', $lot_ref));
          $lot_ref = trim(str_replace(array("'"), "''", $lot_ref));
		  $upc = $this->input->post('upc');
		  $upc = trim(str_replace("  ", ' ', $upc));
          $upc = trim(str_replace(array("'"), "''", $upc));
          if(!is_numeric($upc)){
		  	$upc = '';
		  }
		  $sku = $this->input->post('sku');
		  $sku = trim(str_replace("  ", ' ', $sku));
          $sku = trim(str_replace(array("'"), "''", $sku));
		  $price = $this->input->post('active_price');
          if(empty($price)){
          	$price = "NULL";
          }		  
		  $cost_price = $this->input->post('cost_price');
		  $part_no = $this->input->post('part_no');
		  $part_no = trim(str_replace("  ", ' ', $part_no));
          $part_no = trim(str_replace(array("'"), "''", $part_no));
		  $title = $this->input->post('title');
		  $title = trim(str_replace("  ", ' ', $title));
          $title = trim(str_replace(array("'"), "''", $title));
          $main_category = $this->input->post('main_category');
		  $main_category = trim(str_replace("  ", ' ', $main_category));
          $main_category = trim(str_replace(array("'"), "''", $main_category));
		  $sub_cat = $this->input->post('sub_cat');
		  $sub_cat = trim(str_replace("  ", ' ', $sub_cat));
          $sub_cat = trim(str_replace(array("'"), "''", $sub_cat));
		  $category = $this->input->post('category_name');
		  $category = trim(str_replace("  ", ' ', $category));
          $category = trim(str_replace(array("'"), "''", $category));
		  $origin = $this->input->post('origin');
		  $origin = trim(str_replace("  ", ' ', $origin));
          $origin = trim(str_replace(array("'"), "''", $origin));
          if(empty($origin)){
          	$origin = "";
          }
		  $condition = $this->input->post('default_condition');
		  $avail_qty = $this->input->post('avail_qty');
		  $ounces = $this->input->post('ounces');
		  if(empty($ounces)){
          	$ounces = "NULL";
          }

		  $ebay_item_id = '';
		  $user_name = $this->input->post('user_name');
		  $user_name = trim(str_replace("  ", ' ', $user_name));
          $user_name = trim(str_replace(array("'"), "''", $user_name));
		  $po_mt_ref_no = '';
		  $po_mt_ref_no = trim(str_replace("  ", ' ', $po_mt_ref_no));
          $po_mt_ref_no = trim(str_replace(array("'"), "''", $po_mt_ref_no));
		  $job_no = $this->input->post('job_no');
		  $category_id = $this->input->post('category_id');
		  $shipping_service = $this->input->post('shipping_service');

		  //pic approval
		 

		  

		  //********************************************************************************
		  // code section added by adil asad jan-8-2018 in case of par no not assigned start
		  //********************************************************************************
		  $insert_by = $this->session->userdata('user_id');
		  date_default_timezone_set("America/Chicago");
		  $date = date('Y-m-d H:i:s');
		  $insert_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

		  $object_des = $this->input->post('Object');
		  $object_des = trim(str_replace("  ", ' ', $object_des));
          $object_des = trim(str_replace(array("'"), "''", $object_des));

          	
          $get_obj = $this->db->query("SELECT OB.OBJECT_ID FROM LZ_BD_OBJECTS_MT OB WHERE UPPER(OB.OBJECT_NAME) =upper('$object_des') and ob.category_id =$category_id ");
          	if($get_obj->num_rows() > 0 ){

	          	$get_obj = $get_obj->result_array();
				$get_obj = $get_obj[0]['OBJECT_ID'];
				$object_des = $get_obj;
				
				$this->db->query("UPDATE LZ_BD_OBJECTS_MT SET SHIP_SERV= '$shipping_service' ,WEIGHT = $ounces WHERE OBJECT_ID = $object_des");

			}else{			


				$obj_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_OBJECTS_MT','OBJECT_ID') OBJECT_ID FROM DUAL");
	  			$get_mt_pk = $obj_id->result_array();
	  			$object_id = $get_mt_pk[0]['OBJECT_ID'];

	  			$this->db->query("INSERT INTO LZ_BD_OBJECTS_MT(OBJECT_ID, OBJECT_NAME,INSERT_DATE,INSERT_BY, CATEGORY_ID,SHIP_SERV,WEIGHT) VALUES($object_id, '$object_des',$insert_date,$insert_by, $category_id, '$shipping_service', $ounces)");

	  			// $this->db->query("SELECT OB.OBJECT_ID  FROM LZ_BD_OBJECTS_MT OB WHERE OBJECT_ID =$object_id ");
	  			// $get_mt_pk = $obj_id->result_array();
	  			// $obj_id = $get_mt_pk[0]['OBJECT_ID'];

	  			$object_des = $object_id; //storing object id
	  		// 	var_dump($object_des);
				 // exit;
		}			


		if(empty($part_no)){
		  		$get_mpn = $this->db->query("SELECT MPN_GENERATION($category_id) as MPN FROM DUAL");
					$get_mpn = $get_mpn->result_array();
					$get_mpn = $get_mpn[0]['MPN'];		  
				 	$get_mpn = trim(str_replace("  ", ' ', $get_mpn));
		      $get_mpn = trim(str_replace(array("'"), "''", $get_mpn));

          $get_catalg_id = $this->db->query("SELECT T.ITEM_MT_MFG_PART_NO  MPN FROM ITEMS_MT T WHERE T.Item_Mt_Upc = '$upc'");

			  if($get_catalg_id->num_rows() > 0) {

			  	$get_exist_mpn = $get_catalg_id->result_array();
				$get_exist_mpn = $get_exist_mpn[0]['MPN'];
				$part_no = $get_exist_mpn; // ASSIGN TO PART NUMBER IF AVAILABLE IN LZ_CATALOGUE_MT

				$check_catalogue_mt = $this->db->query("SELECT CATALOGUE_MT_ID, MPN FROM LZ_CATALOGUE_MT WHERE UPPER(MPN) = UPPER('$part_no') and CATEGORY_ID = $category_id");

					if($check_catalogue_mt->num_rows() > 0){
					  	$catalogue_mpn = $check_catalogue_mt->result_array();
						$catalogue_mt_id = $catalogue_mpn[0]['CATALOGUE_MT_ID'];
						//$part_no = $catalogue_mpn;
						if(!empty($upc)){
								$this->db->query("UPDATE LZ_CATALOGUE_MT SET UPC = '$upc',object_id = $object_des  WHERE CATALOGUE_MT_ID = $catalogue_mt_id");
						}

					}else{

			          	$get_mt_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') CATALOGUE_MT_ID FROM DUAL");
			          	$get_pk = $get_mt_pk->result_array();
			          	$cat_mt_id = $get_pk[0]['CATALOGUE_MT_ID'];



			          	$mt_qry = $this->db->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY,OBJECT_ID,MPN_DESCRIPTION,BRAND,UPC) VALUES($cat_mt_id, '$get_mpn', $category_id, $insert_date, $insert_by,$object_des,'$title','$manufacturer','$upc')");

			          	$part_no = $get_mpn; // assign newly created part no

					} //check_catalogue_mt else closing



			  }else{
			  	
	          	$get_mt_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') CATALOGUE_MT_ID FROM DUAL");
	          	$get_pk = $get_mt_pk->result_array();
	          	$cat_mt_id = $get_pk[0]['CATALOGUE_MT_ID'];



	          	$mt_qry = $this->db->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY,OBJECT_ID,MPN_DESCRIPTION,BRAND,UPC) VALUES($cat_mt_id, '$get_mpn', $category_id, $insert_date, $insert_by,$object_des,'$title','$manufacturer','$upc')");

							$part_no = $get_mpn; // assign newly created part no

			 } //get_catalg_id else closing
        }else{
        	$get_mpn = $part_no;
        	$check_catalogue_mt = $this->db->query("SELECT CATALOGUE_MT_ID, MPN FROM LZ_CATALOGUE_MT WHERE UPPER(MPN) = UPPER('$part_no') and CATEGORY_ID = $category_id");

					if($check_catalogue_mt->num_rows() > 0){
					  $catalogue_mpn = $check_catalogue_mt->result_array();
						$catalogue_mt_id = $catalogue_mpn[0]['CATALOGUE_MT_ID'];
						//$part_no = $catalogue_mpn;
						if(!empty($upc)){
								$this->db->query("UPDATE LZ_CATALOGUE_MT SET UPC = '$upc',object_id = $object_des WHERE CATALOGUE_MT_ID = $catalogue_mt_id");
						}

					}else{

			          	$get_mt_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') CATALOGUE_MT_ID FROM DUAL");
			          	$get_pk = $get_mt_pk->result_array();
			          	$cat_mt_id = $get_pk[0]['CATALOGUE_MT_ID'];

			          	$mt_qry = $this->db->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY,OBJECT_ID,MPN_DESCRIPTION,BRAND,UPC) VALUES($cat_mt_id, '$get_mpn', $category_id, $insert_date, $insert_by,$object_des,'$title','$manufacturer','$upc')");


									//$part_no = $get_mpn; // assign newly created part no

							} //check_catalogue_mt else closing
        }// empty part no ifelse closing
			// var_dump($get_mpn);
   //        	exit;


		  
		
		// var_dump($part_no);
		// exit;
		  //******************************************************************************
		  // code section added by adil asad jan-8-2018 in case of par no not assigned end
		  //******************************************************************************

		  $comma = ',';
		  $query = $this->db->query("SELECT get_single_primary_key('LZ_SINGLE_ENTRY','ID') ID FROM DUAL");
	      $rs = $query->result_array();
	      $loading_no = $rs[0]['ID'];
		//var_dump($loading_no."-".$purch_ref."-".$suplier_desc."-".$remarks."-".$purchase_date);exit;

			/*=============================================
			=            Create auto Purchase Ref No.            =
			=============================================*/
		  $query = $this->db->query("SELECT PURCHASE_REF_NO FROM LZ_SINGLE_ENTRY WHERE id = (SELECT max(id) FROM LZ_SINGLE_ENTRY)");
	      $rs = $query->result_array();
	      $purch_ref = $rs[0]['PURCHASE_REF_NO'];
	      $str = explode('-', $purch_ref);
	      if(count($str) > 1){
		      $last_num = end($str);
		      $date = date('d-M-y');
	          $current_date = strtoupper($date);
		      $last_date = $str[0].'-'.$str[1].'-'.$str[2];
		      if($last_date == $current_date){
		      	$count = $last_num + 1;
		      	$purch_ref = strtoupper($date.'-'. $count);
		      }else{
		      	$purch_ref = strtoupper($date.'-'. 1);
		      }
	      }else{
          $date = date('d-M-y');
          //$current_date = strtoupper($date);
          $purch_ref = strtoupper($date.'-'. 1);
        }
			/*=====  End of Create auto Purchase Ref No.  ======*/


    	// $qry_sef = "INSERT INTO LZ_SINGLE_ENTRY VALUES($loading_no $comma '$purch_ref' $comma $suplier_desc $comma '$remarks' $comma $purchase_date $comma '$serial_no' $comma '$manufacturer' $comma $list_date $comma '$lot_ref' $comma '$upc' $comma '$sku' $comma $price $comma $cost_price $comma '$part_no' $comma '$title' $comma '$main_category' $comma '$sub_cat' $comma '$category' $comma '$origin' $comma '$condition' $comma $avail_qty $comma $ounces $comma '$ebay_item_id' $comma '$user_name' $comma '$po_mt_ref_no' $comma '$job_no' $comma $category_id $comma NULL $comma NULL)";
    	//

		/*=====  Bin Assignment section start  ======*/    	 
		$bin_id_qry = $this->db->query("SELECT BIN_ID, BIN_NAME FROM (SELECT B.BIN_ID, DECODE(B.BIN_TYPE, 'TC', 'TC', 'PB', 'PB', 'WB', 'WB', 'AB', 'AB', 'DK', 'DK', 'NA', 'NA') || '-' || B.BIN_NO BIN_NAME FROM BIN_MT B) WHERE BIN_NAME = '$item_bin'");
		$result = $bin_id_qry->result_array();
		$bin_id = @$result[0]['BIN_ID'];		

		/*=====  Bin Assignment section end  ======*/

    	$qry_sef = "INSERT INTO LZ_SINGLE_ENTRY (ID, PURCHASE_REF_NO, SUPPLIER_ID, REMARKS, PURCHASE_DATE, SERIAL_NO, ITEM_MT_MANUFACTURE, LIST_DATE, PO_DETAIL_LOT_REF, ITEM_MT_UPC, ITEM_MT_BBY_SKU, PRICE, PO_DETAIL_RETIAL_PRICE, ITEM_MT_MFG_PART_NO, ITEM_MT_DESC, MAIN_CATAGORY_SEG1, SUB_CATAGORY_SEG2, BRAND_SEG3, ORIGIN_SEG4, CONDITIONS_SEG5, AVAILABLE_QTY, WEIGHT_KG, EBAY_ITEM_ID, LISTER, PO_MT_REF_NO, JOB_NO, CATEGORY_ID, OLD_BARCODE, POS_ONLY ,OBJECT_ID, BIN_ID) VALUES($loading_no $comma '$purch_ref' $comma $suplier_desc $comma '$remarks' $comma $purchase_date $comma '$serial_no' $comma '$manufacturer' $comma $list_date $comma '$lot_ref' $comma '$upc' $comma '$sku' $comma $price $comma $cost_price $comma '$part_no' $comma '$title' $comma '$main_category' $comma '$sub_cat' $comma '$category' $comma '$origin' $comma '$condition' $comma $avail_qty $comma $ounces $comma '$ebay_item_id' $comma '$user_name' $comma '$po_mt_ref_no' $comma '$job_no' $comma $category_id $comma NULL $comma 0 $comma $object_des $comma '$bin_id' )";
    	//print_r($qry_sef);exit;
        $this->db->query($qry_sef);
        

        $qry_id = "SELECT M.LZ_MANIFEST_ID,M.SINGLE_ENTRY_ID FROM LZ_MANIFEST_MT M WHERE M.SINGLE_ENTRY_ID=(SELECT MAX(T.ID) FROM LZ_SINGLE_ENTRY T)";
    	//print_r($qry_sef);exit;
        $query=$this->db->query($qry_id);
        $rs = $query->result_array();
	    // $lz_manifest_id = $rs[0]['LZ_MANIFEST_ID'];

	    return $rs;


		 }
		 public function skip_test($lz_manifest_id){
		 	$skip_test = $this->input->post('skip_test');
		 	$condition = strtoupper($this->input->post('default_condition'));

		 	$cond_qry = $this->db->query("SELECT ID FROM LZ_ITEM_COND_MT WHERE UPPER(COND_NAME) = '$condition'");
			$result = $cond_qry->result_array();
			$condition_id = @$result[0]['ID'];
			if($skip_test == 'Yes'){
			//var_dump($skip_test);
	            // if(@$condition == 'Used'){
	            //   @$condition = 3000;
	            // }elseif(@$condition == 'New'){
	            //   @$condition = 1000; 
	            // }elseif(@$condition == 'New other'){
	            //   @$condition = 1500; 
	            // }elseif(@$condition == 'Manufacturer Refurbished'){
	            //     @$condition = 2000;
	            // }elseif(@$condition == 'Seller Refurbished'){
	            //   @$condition = 2500; 
	            // }elseif(@$condition == 'For Parts or Not Working'){
	            //   @$condition = 7000; 
	            // }

	    		$cond_qry = "UPDATE LZ_BARCODE_MT B SET B.CONDITION_ID = '$condition_id' WHERE  B.LZ_MANIFEST_ID = '$lz_manifest_id'";
	    		//var_dump($cond_qry);exit;
				$this->db->query($cond_qry);        	
	        }
		 }
		 public function updateRecord() {

		  $loading_no = $this->input->post('loading_no');
		  $purch_ref = $this->input->post('purch_ref');
		  $purch_ref = trim(str_replace("  ", ' ', $purch_ref));
          $purch_ref = trim(str_replace(array("'"), "''", $purch_ref)); 
		  $suplier_desc = $this->input->post('suplier_desc');
		  $suplier_desc = trim(str_replace("  ", ' ', $suplier_desc));
          $suplier_desc = trim(str_replace(array("'"), "''", $suplier_desc));
		  $remarks = $this->input->post('remarks');
		  $remarks = trim(str_replace("  ", ' ', $remarks));
          $remarks = trim(str_replace(array("'"), "''", $remarks));
          if(empty($remarks)){
          	$remarks = "";
          }
		  $purchase_date = $this->input->post('purchase_date');
		  $date=date_create($purchase_date);//change date format from 07-Dec-2016 to 12/07/2016
		  $date= date_format($date,"m/d/Y");
		  $purchase_date= "TO_DATE('".$date."', 'MM/DD/YYYY')";
		  $serial_no = $this->input->post('serial_no');
		  $serial_no = trim(str_replace("  ", ' ', $serial_no));
          $serial_no = trim(str_replace(array("'"), "''", $serial_no));
		//   $manufacturer = $this->input->post('manufacturer');
		//   $manufacturer = trim(str_replace("  ", ' ', $manufacturer));
        //   $manufacturer = trim(str_replace(array("'"), "''", $manufacturer));
          $list_date = "NULL";
		  $lot_ref = $this->input->post('lot_ref');
		  $lot_ref = trim(str_replace("  ", ' ', $lot_ref));
          $lot_ref = trim(str_replace(array("'"), "''", $lot_ref));
		//   $upc = $this->input->post('upc');
		//   $upc = trim(str_replace("  ", ' ', $upc));
        //   $upc = trim(str_replace(array("'"), "''", $upc));
		  $sku = $this->input->post('sku');
		  $sku = trim(str_replace("  ", ' ', $sku));
          $sku = trim(str_replace(array("'"), "''", $sku));
		  $price = $this->input->post('active_price');
          if(empty($price)){
          	$price = "NULL";
          }		  
		  $cost_price = $this->input->post('cost_price');
		//   $part_no = $this->input->post('part_no');
		//   $part_no = trim(str_replace("  ", ' ', $part_no));
        //   $part_no = trim(str_replace(array("'"), "''", $part_no));
		  $title = $this->input->post('title');
		  $title = trim(str_replace("  ", ' ', $title));
          $title = trim(str_replace(array("'"), "''", $title));
          $main_category = $this->input->post('main_category');
		  $main_category = trim(str_replace("  ", ' ', $main_category));
          $main_category = trim(str_replace(array("'"), "''", $main_category));
		  $sub_cat = $this->input->post('sub_cat');
		  $sub_cat = trim(str_replace("  ", ' ', $sub_cat));
          $sub_cat = trim(str_replace(array("'"), "''", $sub_cat));
		  $category = $this->input->post('category_name');
		  $category = trim(str_replace("  ", ' ', $category));
          $category = trim(str_replace(array("'"), "''", $category));
		  $origin = $this->input->post('origin');
		  $origin = trim(str_replace("  ", ' ', $origin));
          $origin = trim(str_replace(array("'"), "''", $origin));
          if(empty($origin)){
          	$origin = "";
          }
		//   $condition = $this->input->post('default_condition');
		  $avail_qty = $this->input->post('avail_qty');
		  $ounces = $this->input->post('ounces');
		  if(empty($ounces)){
          	$ounces = "NULL";
          }
		  $ebay_item_id = '';
		  $user_name = $this->input->post('user_name');
		  $user_name = trim(str_replace("  ", ' ', $user_name));
          $user_name = trim(str_replace(array("'"), "''", $user_name));
		  $po_mt_ref_no = '';
		  $po_mt_ref_no = trim(str_replace("  ", ' ', $po_mt_ref_no));
          $po_mt_ref_no = trim(str_replace(array("'"), "''", $po_mt_ref_no));
		  $job_no = $this->input->post('job_no');
		  $insert_by = $this->session->userdata('user_id');
		  date_default_timezone_set("America/Chicago");
		  $date = date('Y-m-d H:i:s');
		  $insert_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
		  $category_id = $this->input->post('category_id');
		  $part_no = $this->input->post('part_no');
		  $shipping_service = $this->input->post('shipping_service');

		  // adde by adil start
		  $new_obj = $this->input->post('obj_id');

		  $get_obj = $this->db->query("SELECT OB.OBJECT_ID FROM LZ_BD_OBJECTS_MT OB WHERE UPPER(OB.OBJECT_NAME) =UPPER('$new_obj') and OB.CATEGORY_ID =$category_id ");
          	if($get_obj->num_rows() > 0 ){

	          	$get_obj = $get_obj->result_array();
				$get_obj = $get_obj[0]['OBJECT_ID'];
				$object_des = $get_obj;
				// var_dump($object_des);
				// exit;
				$this->db->query("UPDATE LZ_BD_OBJECTS_MT SET SHIP_SERV= '$shipping_service' ,WEIGHT = $ounces WHERE OBJECT_ID = $object_des");

			}else{			

				$obj_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_OBJECTS_MT','OBJECT_ID') OBJECT_ID FROM DUAL");
	  			$get_mt_pk = $obj_id->result_array();
	  			$object_id = $get_mt_pk[0]['OBJECT_ID'];

	  			$this->db->query("INSERT INTO LZ_BD_OBJECTS_MT(OBJECT_ID, OBJECT_NAME,INSERT_DATE,INSERT_BY, CATEGORY_ID,SHIP_SERV,WEIGHT) VALUES($object_id, '$new_obj',$insert_date,$insert_by, $category_id, $shipping_service ,$ounces )");

	  			$object_des = $object_id; //storing object id

		}

		  // end 
		  //$comma = ',';
		  $query = $this->db->query("UPDATE LZ_SINGLE_ENTRY SET ID = '$loading_no', PURCHASE_REF_NO = '$purch_ref', SUPPLIER_ID  = '$suplier_desc', REMARKS  = '$remarks', PURCHASE_DATE = $purchase_date, SERIAL_NO = '$serial_no', LIST_DATE = $list_date, PO_DETAIL_LOT_REF  = '$lot_ref', ITEM_MT_BBY_SKU  = '$sku', PRICE  = $price, PO_DETAIL_RETIAL_PRICE = '$cost_price',ITEM_MT_DESC = '$title', MAIN_CATAGORY_SEG1 = '$main_category', SUB_CATAGORY_SEG2  = '$sub_cat', BRAND_SEG3= '$category', ORIGIN_SEG4  = '$origin', AVAILABLE_QTY = '$avail_qty', WEIGHT_KG = $ounces, EBAY_ITEM_ID  = '$ebay_item_id', LISTER  = '$user_name', PO_MT_REF_NO  = '$po_mt_ref_no', JOB_NO  = '$job_no',CATEGORY_ID = '$category_id',OBJECT_ID = '$object_des' WHERE ID = '$loading_no'");

		  $mpn_upd =  $this->db->query(" UPDATE LZ_CATALOGUE_MT SET OBJECT_ID = $object_des WHERE UPPER(MPN) =UPPER('$part_no') AND CATEGORY_ID = $category_id  ");
			
		 }
		 public function get_supplier_id(){
		 	$query = $this->db->query("select supplier_id, company_name from supplier_mt  WHERE  company_name = 'dfwonline' ");
		 	return $query->result_array();

		 }
		 public function singlentry_view_all($single_entry_id,$se_radio){
		 	$barcode_arr = [];
			$seed_id_arr = [];
			$date_qry = null;
			$order_by = null;
		 	if(empty($single_entry_id) && empty($se_radio)){
		 		//$query = "SELECT S.OLD_BARCODE ,S.ID, S.LISTER,S.REMARKS,S.PURCHASE_DATE,S.PURCHASE_REF_NO,S.ITEM_MT_MANUFACTURE, S.ITEM_MT_UPC, S.ITEM_MT_BBY_SKU, S.PRICE, S.PO_DETAIL_RETIAL_PRICE, S.ITEM_MT_MFG_PART_NO, S.ITEM_MT_DESC, S.MAIN_CATAGORY_SEG1, S.SUB_CATAGORY_SEG2, S.BRAND_SEG3, S.ORIGIN_SEG4, UPPER(S.CONDITIONS_SEG5) CONDITIONS_SEG5, S.AVAILABLE_QTY, S.CATEGORY_ID, S.WEIGHT_KG,V.ITEM_ID,V.EBAY_ITEM_ID, M.LZ_MANIFEST_ID, M.GRN_ID,V.LIST_QTY,V.IT_BARCODE FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M,VIEW_LZ_LISTING_REVISED V WHERE S.ID = M.SINGLE_ENTRY_ID AND V.SINGLE_ENTRY_ID = S.ID AND V.EBAY_ITEM_ID IS NULL AND upper(S.CONDITIONS_SEG5) not in ('N/A','OTHER','NEW WITHOUT TAGS')";

		 		//$group =" GROUP BY S.OLD_BARCODE,S.ID,  S.LISTER,S.REMARKS,S.PURCHASE_DATE,S.PURCHASE_REF_NO,S.ITEM_MT_MANUFACTURE, S.ITEM_MT_UPC, S.ITEM_MT_BBY_SKU, S.PRICE, S.PO_DETAIL_RETIAL_PRICE, S.ITEM_MT_MFG_PART_NO, S.ITEM_MT_DESC, S.MAIN_CATAGORY_SEG1, S.SUB_CATAGORY_SEG2, S.BRAND_SEG3, S.ORIGIN_SEG4, UPPER(S.CONDITIONS_SEG5), S.AVAILABLE_QTY, S.CATEGORY_ID, S.WEIGHT_KG,V.ITEM_ID,V.EBAY_ITEM_ID, M.LZ_MANIFEST_ID, M.GRN_ID,V.LIST_QTY,V.IT_BARCODE";
		 		
		 		$query = "SELECT S.*, MANF.EBAY_ITEM_ID, MANF.LZ_MANIFEST_ID, MANF.ITEM_ID, C.ID CONDITION_ID,C.COND_NAME, I.SEED_ID, I.APPROVED_DATE FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M, LZ_ITEM_COND_MT C, LZ_ITEM_SEED I, (SELECT DISTINCT B.LZ_MANIFEST_ID, B.EBAY_ITEM_ID, B.ITEM_ID FROM LZ_BARCODE_MT B WHERE B.LZ_MANIFEST_ID IN (SELECT M.LZ_MANIFEST_ID FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M WHERE M.SINGLE_ENTRY_ID = S.ID) AND B.EBAY_ITEM_ID IS NULL) MANF WHERE M.SINGLE_ENTRY_ID = S.ID AND MANF.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID AND S.POS_ONLY = 0 AND UPPER(S.CONDITIONS_SEG5) = UPPER(C.COND_NAME) AND MANF.ITEM_ID = I.ITEM_ID(+) AND  MANF.LZ_MANIFEST_ID = I.LZ_MANIFEST_ID(+) AND C.ID = I.DEFAULT_COND(+) ";
		 		$from = date('m/d/Y', strtotime('-1 months'));// date('m/01/Y');
				$to = date('m/d/Y');
				$date_qry = "AND S.PURCHASE_DATE BETWEEN TO_DATE('$from','MM/DD/YY') AND TO_DATE('$to ','MM/DD/YY')";
				$order_by =" ORDER BY S.PURCHASE_DATE DESC";
		 		$se_radio = 'Not_Listed'; 
		 		$this->session->set_userdata('se_radio', $se_radio);
			 // $barcode_arr = [];
			 // $seed_id_arr = [];		 		
		 	}elseif(empty($single_entry_id) && !empty($se_radio)){
		 		if($se_radio == 'Listed'){
		 			//$query = "SELECT S.OLD_BARCODE ,S.ID, S.LISTER,S.REMARKS,S.PURCHASE_DATE,S.PURCHASE_REF_NO,S.ITEM_MT_MANUFACTURE, S.ITEM_MT_UPC, S.ITEM_MT_BBY_SKU, S.PRICE, S.PO_DETAIL_RETIAL_PRICE, S.ITEM_MT_MFG_PART_NO, S.ITEM_MT_DESC, S.MAIN_CATAGORY_SEG1, S.SUB_CATAGORY_SEG2, S.BRAND_SEG3, S.ORIGIN_SEG4, UPPER(S.CONDITIONS_SEG5) CONDITIONS_SEG5, S.AVAILABLE_QTY, S.CATEGORY_ID, S.WEIGHT_KG,V.ITEM_ID,V.EBAY_ITEM_ID, M.LZ_MANIFEST_ID, M.GRN_ID,V.LIST_QTY,V.IT_BARCODE FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M,VIEW_LZ_LISTING_REVISED V WHERE S.ID = M.SINGLE_ENTRY_ID AND V.SINGLE_ENTRY_ID = S.ID AND upper(S.CONDITIONS_SEG5) not in ('N/A','OTHER','NEW WITHOUT TAGS')";
		 			//$group =" GROUP BY S.OLD_BARCODE ,S.ID,  S.LISTER,S.REMARKS,S.PURCHASE_DATE,S.PURCHASE_REF_NO,S.ITEM_MT_MANUFACTURE, S.ITEM_MT_UPC, S.ITEM_MT_BBY_SKU, S.PRICE, S.PO_DETAIL_RETIAL_PRICE, S.ITEM_MT_MFG_PART_NO, S.ITEM_MT_DESC, S.MAIN_CATAGORY_SEG1, S.SUB_CATAGORY_SEG2, S.BRAND_SEG3, S.ORIGIN_SEG4, S.CONDITIONS_SEG5, S.AVAILABLE_QTY, S.CATEGORY_ID, S.WEIGHT_KG,V.ITEM_ID,V.EBAY_ITEM_ID, M.LZ_MANIFEST_ID, M.GRN_ID,V.LIST_QTY,V.IT_BARCODE";
		 			$query = "SELECT S.*, MANF.EBAY_ITEM_ID, MANF.LZ_MANIFEST_ID, MANF.ITEM_ID, C.ID CONDITION_ID,C.COND_NAME, I.SEED_ID, I.APPROVED_DATE FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M, LZ_ITEM_COND_MT C, LZ_ITEM_SEED I, (SELECT DISTINCT B.LZ_MANIFEST_ID, B.EBAY_ITEM_ID, B.ITEM_ID FROM LZ_BARCODE_MT B WHERE B.LZ_MANIFEST_ID IN (SELECT M.LZ_MANIFEST_ID FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M WHERE M.SINGLE_ENTRY_ID = S.ID) AND B.EBAY_ITEM_ID IS NOT NULL) MANF WHERE M.SINGLE_ENTRY_ID = S.ID AND MANF.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID AND S.POS_ONLY = 0 AND UPPER(S.CONDITIONS_SEG5) = UPPER(C.COND_NAME) AND MANF.ITEM_ID = I.ITEM_ID(+) AND  MANF.LZ_MANIFEST_ID = I.LZ_MANIFEST_ID(+) AND C.ID = I.DEFAULT_COND(+) ";
		 			$from = date('m/d/Y', strtotime('-1 months'));// date('m/01/Y');
					$to = date('m/d/Y');
					$date_qry = "AND S.PURCHASE_DATE BETWEEN TO_DATE('$from','MM/DD/YY') AND TO_DATE('$to ','MM/DD/YY')";
					$order_by =" ORDER BY S.PURCHASE_DATE DESC"; 
		 			$this->session->set_userdata('se_radio', $se_radio);
		 		}elseif ($se_radio == 'Not_Listed') {
		 			$query = "SELECT S.*, MANF.EBAY_ITEM_ID, MANF.LZ_MANIFEST_ID, MANF.ITEM_ID, C.ID CONDITION_ID,C.COND_NAME, I.SEED_ID, I.APPROVED_DATE FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M, LZ_ITEM_COND_MT C, LZ_ITEM_SEED I, (SELECT DISTINCT B.LZ_MANIFEST_ID, B.EBAY_ITEM_ID, B.ITEM_ID FROM LZ_BARCODE_MT B WHERE B.LZ_MANIFEST_ID IN (SELECT M.LZ_MANIFEST_ID FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M WHERE M.SINGLE_ENTRY_ID = S.ID) AND B.EBAY_ITEM_ID IS NULL) MANF WHERE M.SINGLE_ENTRY_ID = S.ID AND MANF.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID AND S.POS_ONLY = 0 AND UPPER(S.CONDITIONS_SEG5) = UPPER(C.COND_NAME) AND MANF.ITEM_ID = I.ITEM_ID(+) AND  MANF.LZ_MANIFEST_ID = I.LZ_MANIFEST_ID(+) AND C.ID = I.DEFAULT_COND(+)";
		 			$from = date('m/d/Y', strtotime('-1 months'));// date('m/01/Y');
					$to = date('m/d/Y');
					$date_qry = "AND S.PURCHASE_DATE BETWEEN TO_DATE('$from','MM/DD/YY') AND TO_DATE('$to ','MM/DD/YY')";
					$order_by =" ORDER BY S.PURCHASE_DATE DESC";
		 			//$query = "SELECT S.*, M.LZ_MANIFEST_ID, M.POSTED, M.GRN_ID FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M WHERE S.ID = M.SINGLE_ENTRY_ID AND  M.GRN_ID IS NULL";
		 			//$group =" ";
		 			$this->session->set_userdata('se_radio', $se_radio);
		 		}elseif($se_radio == 'All') {
		 			//$query = "SELECT S.*, M.LZ_MANIFEST_ID, M.POSTED, M.GRN_ID FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M WHERE S.ID = M.SINGLE_ENTRY_ID";
		 			$query = "SELECT S.*, MANF.EBAY_ITEM_ID, MANF.LZ_MANIFEST_ID, MANF.ITEM_ID, C.ID CONDITION_ID,C.COND_NAME, I.SEED_ID, I.APPROVED_DATE FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M, LZ_ITEM_COND_MT C, LZ_ITEM_SEED I, (SELECT DISTINCT B.LZ_MANIFEST_ID, B.EBAY_ITEM_ID, B.ITEM_ID FROM LZ_BARCODE_MT B WHERE B.LZ_MANIFEST_ID IN (SELECT M.LZ_MANIFEST_ID FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M WHERE M.SINGLE_ENTRY_ID = S.ID)) MANF WHERE M.SINGLE_ENTRY_ID = S.ID AND MANF.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID AND S.POS_ONLY = 0 AND UPPER(S.CONDITIONS_SEG5) = UPPER(C.COND_NAME) AND MANF.ITEM_ID = I.ITEM_ID(+) AND  MANF.LZ_MANIFEST_ID = I.LZ_MANIFEST_ID(+) AND C.ID = I.DEFAULT_COND(+) ";
		 			$order_by =" ORDER BY S.PURCHASE_DATE DESC";
		 			//$group =" ";
		 			$this->session->set_userdata('se_radio', $se_radio);
		 		}	
		 	}elseif(!empty($single_entry_id)){
		 		$query = "SELECT S.*, M.LZ_MANIFEST_ID, M.POSTED, M.GRN_ID, OB.OBJECT_NAME,C.ID CONDITION_ID,C.COND_NAME FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M, LZ_BD_OBJECTS_MT OB, LZ_ITEM_COND_MT C WHERE S.ID = M.SINGLE_ENTRY_ID AND S.OBJECT_ID = OB.OBJECT_ID(+) AND UPPER(S.CONDITIONS_SEG5) = UPPER(C.COND_NAME) AND S.ID = $single_entry_id"; $group =" ";
				$query = $this->db->query($query);
		 		$query = $query->result_array();
		 		return array('query'=>$query, 'barcode_qry'=>$barcode_arr, 'seed_id_qry'=>$seed_id_arr);
		 		

		 	}else{
			 	$from = date('m/d/Y', strtotime('-1 months'));// date('m/01/Y');
				$to = date('m/d/Y');
				$date_qry = "AND S.PURCHASE_DATE BETWEEN TO_DATE('$from','MM/DD/YY') AND TO_DATE('$to ','MM/DD/YY')";
	
		} //last else close

			//$query = $this->db->query($query. " " . $date_qry . $group . $order_by);
			$query = $this->db->query($query. " " . $date_qry . $order_by);

		 	$query = $query->result_array();

		foreach($query as $cond){
			//var_dump($query);exit;
			if(!empty($cond['CONDITION_ID'])){

      //               if(!is_numeric(@$cond['CONDITION_ID'])){
						// $condition_id = @$cond['CONDITION_ID'];
      //                   if(@$condition_id == 'USED'){
      //                     @$condition_id = 3000;
      //                   }elseif(@$condition_id == 'NEW'){
      //                     @$condition_id = 1000; 
      //                   }elseif(@$condition_id == 'NEW OTHER' || @$condition_id == 'NEW OTHER (SEE DETAILS)'){
      //                     @$condition_id = 1500; 
      //                   }elseif(@$condition_id == 'MANUFACTURER REFURBISHED'){
      //                       @$condition_id = 2000;
      //                   }elseif(@$condition_id == 'SELLER REFURBISHED'){
      //                     @$condition_id = 2500; 
      //                   }elseif(@$condition_id == 'FOR PARTS OR NOT WORKING' || @$condition_id == 'FOR PARTS'){
      //                     @$condition_id = 7000; 
      //                   }
      //               }else{
      //               	$condition_id = @$cond['CONDITION_ID'];
      //               }
                $condition_id = @$cond['CONDITION_ID'];   

		 		$barcode_qry = $this->db->query("SELECT MT.BARCODE_NO, MT.ITEM_ID, MT.LZ_MANIFEST_ID FROM LZ_BARCODE_MT MT WHERE MT.ITEM_ID = ".$cond['ITEM_ID']." AND MT.LZ_MANIFEST_ID = ".$cond['LZ_MANIFEST_ID']." AND CONDITION_ID = ".$condition_id." AND ROWNUM = 1");
		 		
		 		if($barcode_qry->num_rows() > 0){
		 			$barcode_qry = $barcode_qry->result_array();

		 		array_push($barcode_arr, @$barcode_qry[0]['BARCODE_NO']);
		 		}else{
			 		$barcode_qry = $this->db->query("SELECT MT.BARCODE_NO, MT.ITEM_ID, MT.LZ_MANIFEST_ID FROM LZ_BARCODE_MT MT WHERE MT.ITEM_ID = ".$cond['ITEM_ID']." AND MT.LZ_MANIFEST_ID = ".$cond['LZ_MANIFEST_ID']." AND ROWNUM = 1");
			 			$barcode_qry = $barcode_qry->result_array();
			 			//var_dump($barcode_qry);exit;

			 		array_push($barcode_arr, @$barcode_qry[0]['BARCODE_NO']);		 		
		 		}
		 		
		 	// }elseif(!empty($cond['CONDITIONS_SEG5'])){
		 	// 	$condition_id = strtoupper($cond['CONDITIONS_SEG5']);
	 		// 		if(@$condition_id == 'USED'){
    //                   @$condition_id = 3000;
    //                 }elseif(@$condition_id == 'NEW'){
    //                   @$condition_id = 1000; 
    //                 }elseif(@$condition_id == 'NEW OTHER' || @$condition_id == 'NEW OTHER (SEE DETAILS)'){
    //                   @$condition_id = 1500; 
    //                 }elseif(@$condition_id == 'MANUFACTURER REFURBISHED'){
    //                     @$condition_id = 2000;
    //                 }elseif(@$condition_id == 'SELLER REFURBISHED'){
    //                   @$condition_id = 2500; 
    //                 }elseif(@$condition_id == 'FOR PARTS OR NOT WORKING' || @$condition_id == 'FOR PARTS'){
    //                   @$condition_id = 7000; 
    //                 }else{
    //                 	@$condition_id = 3000;
    //                 }
    //             $barcode_qry = $this->db->query("SELECT MT.BARCODE_NO, MT.ITEM_ID, MT.LZ_MANIFEST_ID FROM LZ_BARCODE_MT MT WHERE MT.ITEM_ID = ".$cond['ITEM_ID']." AND MT.LZ_MANIFEST_ID = ".$cond['LZ_MANIFEST_ID']." AND CONDITION_ID = ".$condition_id." AND ROWNUM = 1");
		 		
		 	// 	if($barcode_qry->num_rows() > 0){
		 	// 		$barcode_qry = $barcode_qry->result_array();

		 	// 	array_push($barcode_arr, @$barcode_qry[0]['BARCODE_NO']);
		 	// 	}else{
			 // 		$barcode_qry = $this->db->query("SELECT MT.BARCODE_NO, MT.ITEM_ID, MT.LZ_MANIFEST_ID FROM LZ_BARCODE_MT MT WHERE MT.ITEM_ID = ".$cond['ITEM_ID']." AND MT.LZ_MANIFEST_ID = ".$cond['LZ_MANIFEST_ID']." AND ROWNUM = 1");
			 // 			$barcode_qry = $barcode_qry->result_array();
			 // 			//var_dump($barcode_qry);exit;

			 // 		array_push($barcode_arr, @$barcode_qry[0]['BARCODE_NO']);		 		
		 	// 	}
		 	}else{
		 		//$barcode_qry = null;
		 		array_push($barcode_arr, null);
		 		//return array('query'=>$query, 'barcode_qry'=>$barcode_arr);
		 	}	
		 // 	$seed_id_qry = $this->db->query("SELECT SEED_ID, APPROVED_DATE FROM LZ_ITEM_SEED  WHERE ITEM_ID = ".$cond['ITEM_ID']." AND LZ_MANIFEST_ID = ".$cond['LZ_MANIFEST_ID']." AND DEFAULT_COND = ".$condition_id);
			// $seed_id_qry = $seed_id_qry->result_array();
			// array_push($seed_id_arr, @$seed_id_qry[0]['SEED_ID']);			

		} //END FOREACH		
		//var_dump($cond['ITEM_ID'],$cond['LZ_MANIFEST_ID'],$condition_id);exit;
		//var_dump($seed_id_arr);exit;
		
		return array('query'=>$query, 'barcode_qry'=>$barcode_arr);
		 					 

		 }		 
		 public function update() {

		  $loading_no = $this->input->post('loading_no');
		  $purch_ref = $this->input->post('purch_ref');
		  $purch_ref = trim(str_replace("  ", ' ', $purch_ref));
          $purch_ref = trim(str_replace(array("'"), "''", $purch_ref)); 
		  $suplier_desc = $this->input->post('suplier_desc');
		  $suplier_desc = trim(str_replace("  ", ' ', $suplier_desc));
          $suplier_desc = trim(str_replace(array("'"), "''", $suplier_desc));
		  $remarks = $this->input->post('remarks');
		  $remarks = trim(str_replace("  ", ' ', $remarks));
          $remarks = trim(str_replace(array("'"), "''", $remarks));
          if(empty($remarks)){
          	$remarks = "";
          }
		  $purchase_date = $this->input->post('purchase_date');
		  $date=date_create($purchase_date);//change date format from 07-Dec-2016 to 12/07/2016
		  $date= date_format($date,"m/d/Y");
		  $purchase_date= "TO_DATE('".$date."', 'MM/DD/YYYY')";
		  $serial_no = $this->input->post('serial_no');
		  $serial_no = trim(str_replace("  ", ' ', $serial_no));
          $serial_no = trim(str_replace(array("'"), "''", $serial_no));
		  $manufacturer = $this->input->post('manufacturer');
		  $manufacturer = trim(str_replace("  ", ' ', $manufacturer));
          $manufacturer = trim(str_replace(array("'"), "''", $manufacturer));
          $list_date = "NULL";
		  $lot_ref = $this->input->post('lot_ref');
		  $lot_ref = trim(str_replace("  ", ' ', $lot_ref));
          $lot_ref = trim(str_replace(array("'"), "''", $lot_ref));
		  $upc = $this->input->post('upc');
		  $upc = trim(str_replace("  ", ' ', $upc));
          $upc = trim(str_replace(array("'"), "''", $upc));
		  $sku = $this->input->post('sku');
		  $sku = trim(str_replace("  ", ' ', $sku));
          $sku = trim(str_replace(array("'"), "''", $sku));
		  $price = $this->input->post('active_price');
          if(empty($price)){
          	$price = "NULL";
          }		  
		  $cost_price = $this->input->post('cost_price');
		  $part_no = $this->input->post('part_no');
		  $part_no = trim(str_replace("  ", ' ', $part_no));
          $part_no = trim(str_replace(array("'"), "''", $part_no));
		  $title = $this->input->post('title');
		  $title = trim(str_replace("  ", ' ', $title));
          $title = trim(str_replace(array("'"), "''", $title));
          $main_category = $this->input->post('main_category');
		  $main_category = trim(str_replace("  ", ' ', $main_category));
          $main_category = trim(str_replace(array("'"), "''", $main_category));
		  $sub_cat = $this->input->post('sub_cat');
		  $sub_cat = trim(str_replace("  ", ' ', $sub_cat));
          $sub_cat = trim(str_replace(array("'"), "''", $sub_cat));
		  $category = $this->input->post('category_name');
		  $category = trim(str_replace("  ", ' ', $category));
          $category = trim(str_replace(array("'"), "''", $category));
		  $origin = $this->input->post('origin');
		  $origin = trim(str_replace("  ", ' ', $origin));
          $origin = trim(str_replace(array("'"), "''", $origin));
          if(empty($origin)){
          	$origin = "";
          }
		  $condition = $this->input->post('default_condition');
		  $avail_qty = $this->input->post('avail_qty');
		  $ounces = $this->input->post('ounces');
		  if(empty($ounces)){
          	$ounces = "NULL";
          }
		  $ebay_item_id = '';
		  $user_name = $this->input->post('user_name');
		  $user_name = trim(str_replace("  ", ' ', $user_name));
          $user_name = trim(str_replace(array("'"), "''", $user_name));
		  $po_mt_ref_no = '';
		  $po_mt_ref_no = trim(str_replace("  ", ' ', $po_mt_ref_no));
          $po_mt_ref_no = trim(str_replace(array("'"), "''", $po_mt_ref_no));
		  $job_no = $this->input->post('job_no');
		  $category_id = $this->input->post('category_id');
		  //$comma = ',';
		  $query = $this->db->query("UPDATE LZ_SINGLE_ENTRY SET ID = '$loading_no', PURCHASE_REF_NO = '$purch_ref', SUPPLIER_ID  = '$suplier_desc', REMARKS  = '$remarks', PURCHASE_DATE = $purchase_date, SERIAL_NO = '$serial_no', ITEM_MT_MANUFACTURE = '$manufacturer', LIST_DATE = $list_date, PO_DETAIL_LOT_REF  = '$lot_ref', ITEM_MT_UPC  = '$upc', ITEM_MT_BBY_SKU  = '$sku', PRICE  = $price, PO_DETAIL_RETIAL_PRICE = '$cost_price', ITEM_MT_MFG_PART_NO  = '$part_no',ITEM_MT_DESC = '$title', MAIN_CATAGORY_SEG1 = '$main_category', SUB_CATAGORY_SEG2  = '$sub_cat', BRAND_SEG3= '$category', ORIGIN_SEG4  = '$origin', CONDITIONS_SEG5  = '$condition', AVAILABLE_QTY = '$avail_qty', WEIGHT_KG = $ounces, EBAY_ITEM_ID  = '$ebay_item_id', LISTER  = '$user_name', PO_MT_REF_NO  = '$po_mt_ref_no', JOB_NO  = '$job_no',CATEGORY_ID = '$category_id' WHERE ID = '$loading_no'");
			$qry_id = "SELECT M.LZ_MANIFEST_ID,M.SINGLE_ENTRY_ID FROM LZ_MANIFEST_MT M WHERE M.SINGLE_ENTRY_ID=$loading_no";
	    	$query=$this->db->query($qry_id);
	        $rs = $query->result_array();
		    
		    return $rs;
		 }

public function get_data($upc, $part_no, $condid){

	$dekitted_pics = [];
	$parts = [];
	$uri = [];

	if(!empty($upc)){
		$query = $this->db->query("SELECT LZ_MANIFEST_ID,ITEM_MT_DESC,CONDITIONS_SEG5,ITEM_MT_MFG_PART_NO,trim(ITEM_MT_UPC) ITEM_MT_UPC ,ITEM_MT_MANUFACTURE ,ITEM_MT_BBY_SKU,E_BAY_CATA_ID_SEG6,MAIN_CATAGORY_SEG1,SUB_CATAGORY_SEG2,BRAND_SEG3,ORIGIN_SEG4 FROM (SELECT * FROM LZ_MANIFEST_DET DT WHERE DT.ITEM_MT_UPC ='$upc' AND DT.E_BAY_CATA_ID_SEG6 NOT IN ('N/A','other','Other','OTHER','123456') AND DT.E_BAY_CATA_ID_SEG6 IS NOT NULL AND DT.LAPTOP_ITEM_CODE IS NOT NULL ORDER BY DT.LZ_MANIFEST_ID DESC) WHERE ROWNUM = 1"); 

		// $query = $this->db->query("SELECT * FROM (SELECT DTT.LZ_MANIFEST_ID, C.COND_NAME CONDITIONS_SEG5, DTT.F_MPN ITEM_MT_MFG_PART_NO, TRIM(DTT.F_UPC) ITEM_MT_UPC, DTT.F_MANUFACTURE ITEM_MT_MANUFACTURE, '' ITEM_MT_BBY_SKU, DTT.CATEGORY_ID E_BAY_CATA_ID_SEG6 FROM LZ_ITEM_SEED DTT,LZ_ITEM_COND_MT C WHERE DTT.DEFAULT_COND = C.ID(+) AND UPPER(DTT.F_UPC) = '$upc' AND   DTT.CATEGORY_ID IS NOT NULL ORDER BY DTT.SEED_ID DESC) WHERE ROWNUM =1 ");
		//$data = $query->result();

		if($query->num_rows()>0){
			$manifest_id = $query->result_array();
			//var_dump($purch_ref);exit;
			$lz_manifest_id = $manifest_id[0]['LZ_MANIFEST_ID'];
			$lz_cond_id = $manifest_id[0]['CONDITIONS_SEG5'];

			$item_mt_mfg_part_no = str_replace('/', '_', trim(@$manifest_id[0]['ITEM_MT_MFG_PART_NO']));
			

			$item_mt_upc = $manifest_id[0]['ITEM_MT_UPC'];

			// if(is_numeric($lz_cond_id)){

			// 	$get_co = $this->db->query("SELECT C.COND_NAME FROM LZ_ITEM_COND_MT C WHERE C.ID ='$lz_cond_id'")->result_array();
			// 	$get_co_nam = $get_co[0]['COND_NAME'];
			// 	$lz_cond_id = $get_co_nam;
			// }


			$weight_qry = $this->db->query("SELECT LS.WEIGHT_KG, LS.ITEM_MT_DESC, LS.OBJECT_ID FROM LZ_SINGLE_ENTRY LS WHERE LS.ID = (select m.single_entry_id from lz_manifest_mt m where m.lz_manifest_id = $lz_manifest_id)");
			$weight_qry = $weight_qry->result_array();
			$object_id = @$weight_qry[0]['OBJECT_ID'];

			if(!empty($object_id)){
	 		$object_query = $this->db->query("SELECT O.OBJECT_NAME FROM LZ_BD_OBJECTS_MT O WHERE O.OBJECT_ID = $object_id");
	 		$object_query = $object_query->result_array();		 			
			}else{
				$object_query = 0;
			}

		//picture code start

		$path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 1");
		$path = $path->result_array();  	
		$master_path = $path[0]["MASTER_PATH"];

		//$master_path.@$row['UPC'].'~'.$mpn.'/'.@$it_condition
		if(!empty($item_mt_upc) && !empty($item_mt_mfg_part_no)){
			$dir = $master_path.@$item_mt_upc.'~'.$item_mt_mfg_part_no.'/'.@$condid.'/thumb/';

		}elseif(empty($item_mt_upc) && !empty($item_mt_mfg_part_no)){
			$dir = $master_path."~".@$item_mt_mfg_part_no."/".@$condid.'/thumb/';

		}elseif(!empty($item_mt_upc) && empty($item_mt_mfg_part_no)){
			$dir = $master_path.@$item_mt_upc."~/".@$condid.'/thumb/';
		}

		

		$dir = preg_replace("/[\r\n]*/","",$dir);
	

		$dekitted_pics = [];
		$parts = [];
		$uri = [];
		if (is_dir($dir)) {
		//var_dump($dir);exit;
			$images = glob($dir."\*.{JPG,jpg,GIF,gif,PNG,png,BMP,bmp,JPEG,jpeg}",GLOB_BRACE);
			// var_dump($images);
			// exit;
			$i=0 ;
			
			foreach($images as $image) {

				$uri[$i] = $image;

				$parts = explode(".", $image);
				$img_name = explode("/",$image);

				 
				$img_n = explode(".",$img_name[4]);
				$str = preg_replace('/[^A-Za-z0-9\. -]/', '', $img_name[4]);
				$new_string = substr($str,0,1) . "_" . substr($str,1,strlen($str)-1);
				
//var_dump(count($parts));exit;
	            if (is_array($parts) && count($parts) > 1){
	                $extension = end($parts);
	                if(!empty($extension)){


	                	if(count($parts)>2){
	                	$img_concat = '';

		                for($k=0; $k<count($parts)-1; $k++){
		                	if($k==0){
		                		$img_concat .= $parts[$k];

		                	}else{
		                		$img_concat .='.'. $parts[$k];

		                	}
		                	
		                }

		                $url = $img_concat.'.'.$extension;
	                	}
	                	else{
	                	 $url = $parts['0'].'.'.$extension;
	                	}
	                	
	                    

	                    $url = preg_replace("/[\r\n]*/","",$url);

	                     //var_dump($url);exit;
	                    $uri[$i] = $url;
	                    $img = file_get_contents($url);
	                     //var_dump($url);exit;
	                    $img =base64_encode($img);
	                    $dekitted_pics[$i] = $img;



	                   	 $i++;
	                	}
	            	}
				}
		}	

		
		//picture code end

		}else{
			$object_query = 0;
			$manifest_id = 0;
			$weight_qry = 0;
		}


	}elseif(!empty($part_no)){

		$query = $this->db->query("SELECT LZ_MANIFEST_ID,ITEM_MT_DESC,CONDITIONS_SEG5,ITEM_MT_MFG_PART_NO,trim(ITEM_MT_UPC) ITEM_MT_UPC ,ITEM_MT_MANUFACTURE ,ITEM_MT_BBY_SKU,E_BAY_CATA_ID_SEG6,MAIN_CATAGORY_SEG1,SUB_CATAGORY_SEG2,BRAND_SEG3,ORIGIN_SEG4 FROM (SELECT * FROM LZ_MANIFEST_DET DT WHERE upper(DT.ITEM_MT_MFG_PART_NO) =upper('$part_no') AND DT.E_BAY_CATA_ID_SEG6 NOT IN ('N/A','other','Other','OTHER','123456') AND DT.E_BAY_CATA_ID_SEG6 IS NOT NULL AND DT.LAPTOP_ITEM_CODE IS NOT NULL ORDER BY DT.LZ_MANIFEST_ID DESC) WHERE ROWNUM = 1");

		// $query = $this->db->query("SELECT LZ_MANIFEST_ID,E_BAY_CATA_ID_SEG6,CONDITIONS_SEG5,ITEM_MT_MFG_PART_NO,trim(ITEM_MT_UPC) ITEM_MT_UPC,ITEM_MT_MANUFACTURE,ITEM_MT_BBY_SKU FROM (SELECT * FROM LZ_MANIFEST_DET DT WHERE upper(DT.ITEM_MT_MFG_PART_NO) =upper('$part_no') AND DT.E_BAY_CATA_ID_SEG6 NOT IN ('N/A','other','Other','OTHER') AND DT.E_BAY_CATA_ID_SEG6 IS NOT NULL AND DT.LAPTOP_ITEM_CODE IS NOT NULL ORDER BY DT.LZ_MANIFEST_ID DESC) WHERE ROWNUM = 1");

		// $query = $this->db->query("SELECT * FROM (SELECT DTT.LZ_MANIFEST_ID, C.COND_NAME CONDITIONS_SEG5, DTT.F_MPN ITEM_MT_MFG_PART_NO, TRIM(DTT.F_UPC) ITEM_MT_UPC, DTT.F_MANUFACTURE ITEM_MT_MANUFACTURE, '' ITEM_MT_BBY_SKU, DTT.CATEGORY_ID E_BAY_CATA_ID_SEG6 FROM LZ_ITEM_SEED DTT,LZ_ITEM_COND_MT C WHERE DTT.DEFAULT_COND = C.ID(+) AND UPPER(DTT.F_MPN) = UPPER('$part_no') AND   DTT.CATEGORY_ID IS NOT NULL ORDER BY DTT.SEED_ID DESC) WHERE ROWNUM =1 ");

		if($query->num_rows()>0){
			$manifest_id = $query->result_array();
			//var_dump($purch_ref);exit;
			$lz_manifest_id = $manifest_id[0]['LZ_MANIFEST_ID'];
			// $item_mt_mfg_part_no = $manifest_id[0]['ITEM_MT_MFG_PART_NO'];
			$item_mt_mfg_part_no = str_replace('/', '_', trim(@$manifest_id[0]['ITEM_MT_MFG_PART_NO']));
			
			$item_mt_upc = $manifest_id[0]['ITEM_MT_UPC'];
			$lz_cond_id = $manifest_id[0]['CONDITIONS_SEG5'];

			// if(is_numeric($lz_cond_id)){

			// 	$get_co = $this->db->query("SELECT C.COND_NAME FROM LZ_ITEM_COND_MT C WHERE C.ID ='$lz_cond_id'")->result_array();
			// 	$get_co_nam = $get_co[0]['COND_NAME'];
			// 	$lz_cond_id = $get_co_nam;
			// }

			$weight_qry = $this->db->query("SELECT LS.WEIGHT_KG, LS.ITEM_MT_DESC, LS.OBJECT_ID FROM LZ_SINGLE_ENTRY LS WHERE LS.ID = (select m.single_entry_id from lz_manifest_mt m where m.lz_manifest_id = $lz_manifest_id)");
			$weight_qry = $weight_qry->result_array();
			$object_id = @$weight_qry[0]['OBJECT_ID'];

			if(!empty($object_id)){
	 		$object_query = $this->db->query("SELECT O.OBJECT_NAME FROM LZ_BD_OBJECTS_MT O WHERE O.OBJECT_ID = $object_id");
	 		$object_query = $object_query->result_array();		 			
			}else{
				$object_query = 0;
			}
		}else{ 
			$object_query = 0;
			$manifest_id = 0;
			$weight_qry = 0;
		}

		//picture code start

		$path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 1");
		$path = $path->result_array();  	
		$master_path = $path[0]["MASTER_PATH"];
		$dir = '';
		if(!empty($item_mt_upc) && !empty($item_mt_mfg_part_no)){
			$dir = $master_path.@$item_mt_upc.'~'.$item_mt_mfg_part_no.'/'.@$condid.'/thumb/';

		}elseif(empty($item_mt_upc) && !empty($item_mt_mfg_part_no)){
			$dir = $master_path."~".@$item_mt_mfg_part_no."/".@$condid.'/thumb/';

		}elseif(!empty($item_mt_upc) && empty($item_mt_mfg_part_no)){
			$dir = $master_path.@$item_mt_upc."~/".@$condid.'/thumb/';
		}

		$dir = preg_replace("/[\r\n]*/","",$dir);
		// var_dump($dir);
		// exit;

		$dekitted_pics = [];
		$parts = [];
		$uri = [];
		if (is_dir($dir)) {
		// var_dump($dir);exit;
			$images = glob($dir."\*.{JPG,jpg,GIF,gif,PNG,png,BMP,bmp,JPEG,jpeg}",GLOB_BRACE);
			//var_dump($images);
			$i=0 ;

			foreach($images as $image) {

				$uri[$i] = $image;
				$parts = explode(".", $image);
				$img_name = explode("/",$image);

				// var_dump($img_name);exit;
				$img_n = explode(".",$img_name[4]);
				$str = preg_replace('/[^A-Za-z0-9\. -]/', '', $img_name[4]);
				$new_string = substr($str,0,1) . "_" . substr($str,1,strlen($str)-1);
				

	            if (is_array($parts) && count($parts) > 1){
	                $extension = end($parts);
	                if(!empty($extension)){

	                	if(count($parts)>2){
	                	$img_concat = '';
		                
		                 for($k=0; $k<count($parts)-1; $k++){
		                	if($k==0){
		                		$img_concat .= $parts[$k];

		                	}else{
		                		$img_concat .='.'. $parts[$k];

		                	}
		                	
		                }

		                $url = $img_concat.'.'.$extension;
	                	}
	                	else{
	                	 $url = $parts['0'].'.'.$extension;
	                	}
	                	
		                
	                    //$url = $parts['0'].'.'.$extension;

	                    $url = preg_replace("/[\r\n]*/","",$url);

	                    // var_dump($url);exit;
	                    $uri[$i] = $url;
	                    $img = file_get_contents($url);
	                     //var_dump($url);exit;
	                    $img =base64_encode($img);
	                    $dekitted_pics[$i] = $img;



	                   	 $i++;
	                	}
	            	}
				}
		}	

		
		//picture code end

	} 
	
    return array('data'=>$manifest_id, 'weight_qry'=>$weight_qry, 'object_query'=>$object_query,'dekitted_pics'=>$dekitted_pics,'parts'=>$parts,'uri'=>$uri);


}	














    public function single_entry_print($lz_manifest_id){
        //======================== Print Sticker tab Start =============================//

        //$print_qry = "select t.* from LZ_MANIFEST_DET t where t.lz_manifest_id=$lz_manifest_id and t.STICKER_PRINT = 0";
        $print_qry = "SELECT B.UNIT_NO, B.BARCODE_NO IT_BARCODE, B.PRINT_STATUS, V.ITEM_CONDITION, V.ITEM_MT_DESC, V.MANUFACTURER, V.MFG_PART_NO, V.UPC, V.AVAIL_QTY, V.ITEM_ID, V.LZ_MANIFEST_ID, V.PURCH_REF_NO, V.LAPTOP_ITEM_CODE FROM LZ_BARCODE_MT B, (SELECT IM.ITEM_DESC ITEM_MT_DESC, IM.ITEM_MT_MANUFACTURE MANUFACTURER, IM.ITEM_MT_BBY_SKU, IM.ITEM_MT_UPC UPC, IM.ITEM_MT_MFG_PART_NO MFG_PART_NO, IM.ITEM_CONDITION, LD.LAPTOP_ITEM_CODE, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, LM.PURCHASE_DATE, IM.ITEM_ID, LM.LOADING_NO, LM.LOADING_DATE, SUM(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0)) PO_DETAIL_RETIAL_PRICE, SUM(NVL(LD.AVAILABLE_QTY, 0)) AVAIL_QTY, IM.ITEM_CODE FROM LZ_MANIFEST_MT LM, LZ_MANIFEST_DET LD, ITEMS_MT IM WHERE LM.LZ_MANIFEST_ID = LD.LZ_MANIFEST_ID AND IM.ITEM_CODE = LD.LAPTOP_ITEM_CODE GROUP BY IM.ITEM_DESC, IM.ITEM_MT_MANUFACTURE, LD.LAPTOP_ITEM_CODE, IM.ITEM_ID, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, LM.PURCHASE_DATE, LM.LOADING_NO, LM.LOADING_DATE, IM.ITEM_MT_BBY_SKU, IM.ITEM_MT_UPC, IM.ITEM_MT_MFG_PART_NO, IM.ITEM_CONDITION, IM.ITEM_CODE ) V WHERE B.ITEM_ID = V.ITEM_ID AND B.LZ_MANIFEST_ID = V.LZ_MANIFEST_ID AND B.LZ_MANIFEST_ID = $lz_manifest_id ORDER BY B.ITEM_ID, B.UNIT_NO"; 
        //print_r($print_qry);exit;
        $print_qry =$this->db->query($print_qry);

        return $print_qry->result_array();

         
        //======================== Print Sticker tab End =============================//    	
    }
    public function get_old_barcode($lz_manifest_id,$single_entry_id){
	      date_default_timezone_set("America/Chicago");
          $del_date = date("Y-m-d H:i:s");
          $del_date = "TO_DATE('".$del_date."', 'YYYY-MM-DD HH24:MI:SS')";
          $deleted_by = $this->session->userdata('user_id'); 
          $comma = ',';
          $remarks = '';
	      $old_barcode = $this->db->query("SELECT M.BARCODE_NO FROM LZ_BARCODE_MT M WHERE M.LZ_MANIFEST_ID = $lz_manifest_id");
	      $old_barcode = $old_barcode->result_array();
		    // $str = serialize($old_barcode);
	    	// $strenc = urlencode($str);
    	  $barcode = '';
	    	foreach ($old_barcode as $value) {
	    		$barcode .= $value['BARCODE_NO'].'-';
	    		$barcode_no = $value['BARCODE_NO'];
	    		$query = $this->db->query("SELECT get_single_primary_key('LZ_DELETION_LOG','LOG_ID') LOG_ID FROM DUAL");
                $rs = $query->result_array();
                $log_id = $rs[0]['LOG_ID'];
                $query = $this->db->query("SELECT B.ITEM_ID,B.LZ_MANIFEST_ID,B.CONDITION_ID, I.ITEM_DESC FROM LZ_BARCODE_MT B, ITEMS_MT I WHERE B.ITEM_ID = I.ITEM_ID AND B.BARCODE_NO = $barcode_no");
                $rs = $query->result_array();
                $item_id = $rs[0]['ITEM_ID'];
                $lz_manifest_id = $rs[0]['LZ_MANIFEST_ID'];
                $condition_id = $rs[0]['CONDITION_ID'];
                $item_title = $rs[0]['ITEM_DESC'];

                  //echo $id;
                  $query = $this->db->query("INSERT INTO LZ_DELETION_LOG VALUES($log_id $comma $barcode_no $comma $item_id $comma $lz_manifest_id $comma $condition_id $comma $deleted_by $comma $del_date $comma '$item_title' $comma '$remarks')");
	    	}
	    $query = $this->db->query("UPDATE LZ_SINGLE_ENTRY E SET E.OLD_BARCODE = '$barcode' WHERE E.ID = $single_entry_id");     
	    //return $print_qry->result_array();
	  }
	public function manifest_sticker_print($item_code,$manifest_id,$barcode){
	    //$print_qry = $this->db->query("SELECT D.LAPTOP_ITEM_CODE || '+' || LPAD(T.LOADING_NO, 4, 0) ITEM_CODE, 'R#' || T.PURCH_REF_NO LOT_NO, '~'  || substr(D.ITEM_MT_DESC,1,80) ITEM_DESC, (SELECT SUM(S.AVAILABLE_QTY) FROM LZ_MANIFEST_DET S WHERE S.ITEM_MT_DESC = D.ITEM_MT_DESC AND S.LZ_MANIFEST_ID = D.LZ_MANIFEST_ID GROUP BY S.ITEM_MT_DESC) LOT_QTY, 'SKU:'  || D.ITEM_MT_BBY_SKU SKU, '*+' || REPLACE(D.LAPTOP_ITEM_CODE, '-', '') || LPAD(T.LOADING_NO, 4, 0) || '*' BAR_CODE,D.PO_DETAIL_LOT_REF LOT_ID FROM LZ_MANIFEST_MT T, LZ_MANIFEST_DET D WHERE T.LZ_MANIFEST_ID = D.LZ_MANIFEST_ID and D.LAPTOP_ZONE_ID = $laptop_zone_id");

	    $print_qry = $this->db->query("SELECT B.PO_DETAIL_LOT_REF, B.BARCODE_NO BAR_CODE ,SUBSTR(I.ITEM_DESC, 1, 80) ITEM_DESC, 'R#' || T.PURCH_REF_NO LOT_NO, B.UNIT_NO, (SELECT SUM(S.AVAILABLE_QTY) FROM LZ_MANIFEST_DET S WHERE S.LAPTOP_ITEM_CODE=I.ITEM_CODE AND S.LZ_MANIFEST_ID = T.LZ_MANIFEST_ID AND ROWNUM =1 GROUP BY S.ITEM_MT_DESC) LOT_QTY, 'UPC:' || I.ITEM_MT_UPC UPC FROM LZ_MANIFEST_MT T, LZ_BARCODE_MT B, ITEMS_MT I WHERE T.LZ_MANIFEST_ID = B.LZ_MANIFEST_ID AND B.ITEM_ID = I.ITEM_ID AND I.ITEM_CODE='$item_code' AND B.LZ_MANIFEST_ID = $manifest_id AND B.BARCODE_NO = $barcode");
	    $query = $this->db->query("UPDATE LZ_BARCODE_MT SET PRINT_STATUS = 1 WHERE BARCODE_NO = $barcode");     
	    //var_dump($print_qry);exit;
	    return $print_qry->result_array();
	  }
	  public function printAllStickers(){
	  	$manifest_id = $this->uri->segment(4);
	    //$print_qry = $this->db->query("SELECT D.LAPTOP_ITEM_CODE || '+' || LPAD(T.LOADING_NO, 4, 0) ITEM_CODE, 'R#' || T.PURCH_REF_NO LOT_NO, '~'  || substr(D.ITEM_MT_DESC,1,80) ITEM_DESC, (SELECT SUM(S.AVAILABLE_QTY) FROM LZ_MANIFEST_DET S WHERE S.ITEM_MT_DESC = D.ITEM_MT_DESC AND S.LZ_MANIFEST_ID = D.LZ_MANIFEST_ID GROUP BY S.ITEM_MT_DESC) LOT_QTY, 'SKU:'  || D.ITEM_MT_BBY_SKU SKU, '*+' || REPLACE(D.LAPTOP_ITEM_CODE, '-', '') || LPAD(T.LOADING_NO, 4, 0) || '*' BAR_CODE,D.PO_DETAIL_LOT_REF LOT_ID FROM LZ_MANIFEST_MT T, LZ_MANIFEST_DET D WHERE T.LZ_MANIFEST_ID = D.LZ_MANIFEST_ID and D.LAPTOP_ZONE_ID = $laptop_zone_id");
	    
	    $print_qry = $this->db->query("SELECT B.PO_DETAIL_LOT_REF, B.BARCODE_NO BAR_CODE ,SUBSTR(I.ITEM_DESC, 1, 80) ITEM_DESC, 'R#' || T.PURCH_REF_NO LOT_NO, B.UNIT_NO, (SELECT SUM(S.AVAILABLE_QTY) FROM LZ_MANIFEST_DET S WHERE S.LAPTOP_ITEM_CODE=I.ITEM_CODE AND S.LZ_MANIFEST_ID = T.LZ_MANIFEST_ID AND ROWNUM =1 GROUP BY S.ITEM_MT_DESC) LOT_QTY, 'UPC:' || I.ITEM_MT_UPC UPC FROM LZ_MANIFEST_MT T, LZ_BARCODE_MT B, ITEMS_MT I WHERE T.LZ_MANIFEST_ID = B.LZ_MANIFEST_ID AND B.ITEM_ID = I.ITEM_ID AND B.LZ_MANIFEST_ID = $manifest_id");
	    $query = $this->db->query("UPDATE LZ_BARCODE_MT SET PRINT_STATUS = 1 WHERE LZ_MANIFEST_ID = $manifest_id");     
	    //var_dump($print_qry); exit;
	    return $print_qry->result_array();
	  } 
	  public function printAllStickers_copy($manifest_id){  	
	   
	    $print_qry = $this->db->query("SELECT B.PO_DETAIL_LOT_REF, B.BARCODE_NO BAR_CODE ,SUBSTR(I.ITEM_DESC, 1, 80) ITEM_DESC, 'R#' || T.PURCH_REF_NO LOT_NO, B.UNIT_NO, (SELECT SUM(S.AVAILABLE_QTY) FROM LZ_MANIFEST_DET S WHERE S.LAPTOP_ITEM_CODE=I.ITEM_CODE AND S.LZ_MANIFEST_ID = T.LZ_MANIFEST_ID AND ROWNUM =1 GROUP BY S.ITEM_MT_DESC) LOT_QTY, 'UPC:' || I.ITEM_MT_UPC UPC FROM LZ_MANIFEST_MT T, LZ_BARCODE_MT B, ITEMS_MT I WHERE T.LZ_MANIFEST_ID = B.LZ_MANIFEST_ID AND B.ITEM_ID = I.ITEM_ID AND B.LZ_MANIFEST_ID = $manifest_id");
	    $query = $this->db->query("UPDATE LZ_BARCODE_MT SET PRINT_STATUS = 1 WHERE LZ_MANIFEST_ID = $manifest_id");     
	    //var_dump($print_qry); exit;
	    return $print_qry->result_array();
	  }


	  public function dekit_print_all(){
	  	$master_barcode = $this->session->userdata('ctc_kit_barcode');

		$listing_qry = $this->db->query("SELECT BB.UNIT_NO, LPAD(O.OBJECT_NAME, 16) OBJECT_NAME, DT.PO_DETAIL_LOT_REF LOT_NO, DT.LAPTOP_ITEM_CODE, DT.ITEM_MT_MANUFACTURE, DT.LZ_MANIFEST_ID LZ_MANIFEST_ID, BB.BARCODE_NO BAR_CODE, DT.ITEM_MT_DESC ITEM_DESC, DT.ITEM_MT_UPC UPC, DT.ITEM_MT_MFG_PART_NO MFG_PART_NO, '1' LOT_QTY, DT.CONDITIONS_SEG5 ITEM_CONDITION FROM LZ_MANIFEST_DET DT, LZ_BARCODE_MT BB , LZ_CATALOGUE_MT C , LZ_BD_OBJECTS_MT O WHERE DT.EST_DET_ID IN (SELECT E.LZ_ESTIMATE_DET_ID FROM LZ_BD_ESTIMATE_DET E WHERE E.ITEM_ADJ_DET_ID IN (SELECT D.ITEM_ADJUSTMENT_DET_ID FROM ITEM_ADJUSTMENT_DET D WHERE D.ITEM_ADJUSTMENT_ID = (SELECT B.ITEM_ADJ_DET_ID_FOR_OUT FROM LZ_BARCODE_MT B WHERE B.BARCODE_NO = $master_barcode) AND D.PRIMARY_QTY > 0)) AND DT.LZ_MANIFEST_ID = BB.LZ_MANIFEST_ID AND  UPPER(DT.ITEM_MT_MFG_PART_NO) = UPPER(C.MPN (+)) AND DT.E_BAY_CATA_ID_SEG6 = C.CATEGORY_ID AND C.OBJECT_ID = O.OBJECT_ID")->result_array(); /*  LZ_LISTING_ALLOC A,*/ /*  AND LS.APPROVED_DATE IS NOT NULL AND LS.APPROVED_BY IS NOT NULL AND A.LISTER_ID = $lister_id AND A.SEED_ID = LS.SEED_ID */
		// $listing_qry = $listing_qry->result_array();
	    //$print_qry = $this->db->query("SELECT D.LAPTOP_ITEM_CODE || '+' || LPAD(T.LOADING_NO, 4, 0) ITEM_CODE, 'R#' || T.PURCH_REF_NO LOT_NO, '~'  || substr(D.ITEM_MT_DESC,1,80) ITEM_DESC, (SELECT SUM(S.AVAILABLE_QTY) FROM LZ_MANIFEST_DET S WHERE S.ITEM_MT_DESC = D.ITEM_MT_DESC AND S.LZ_MANIFEST_ID = D.LZ_MANIFEST_ID GROUP BY S.ITEM_MT_DESC) LOT_QTY, 'SKU:'  || D.ITEM_MT_BBY_SKU SKU, '*+' || REPLACE(D.LAPTOP_ITEM_CODE, '-', '') || LPAD(T.LOADING_NO, 4, 0) || '*' BAR_CODE,D.PO_DETAIL_LOT_REF LOT_ID FROM LZ_MANIFEST_MT T, LZ_MANIFEST_DET D WHERE T.LZ_MANIFEST_ID = D.LZ_MANIFEST_ID and D.LAPTOP_ZONE_ID = $laptop_zone_id");
	    // $print_qry = $this->db->query("SELECT B.PO_DETAIL_LOT_REF, B.BARCODE_NO BAR_CODE , '~' || SUBSTR(I.ITEM_DESC, 1, 80) ITEM_DESC, 'R#' || T.PURCH_REF_NO LOT_NO, B.UNIT_NO, (SELECT SUM(S.AVAILABLE_QTY) FROM LZ_MANIFEST_DET S WHERE S.LAPTOP_ITEM_CODE=I.ITEM_CODE AND S.LZ_MANIFEST_ID = T.LZ_MANIFEST_ID AND ROWNUM =1 GROUP BY S.ITEM_MT_DESC) LOT_QTY, 'SKU:' || I.ITEM_MT_BBY_SKU SKU FROM LZ_MANIFEST_MT T, LZ_BARCODE_MT B, ITEMS_MT I WHERE T.LZ_MANIFEST_ID = B.LZ_MANIFEST_ID AND B.ITEM_ID = I.ITEM_ID AND I.ITEM_CODE='$item_code' AND B.LZ_MANIFEST_ID = $manifest_id AND B.BARCODE_NO = $barcode");
	    // foreach ($listing_qry as $value) {
	    // 	$barcode = $value[0]['BARCODE_NO'];
	    // 	$query = $this->db->query("UPDATE LZ_BARCODE_MT SET PRINT_STATUS = 1 WHERE BARCODE_NO = $barcode"); 
	    // }
	        
	    //var_dump($print_qry);exit;
	    return $listing_qry;
	  }



	  public function UnpostItem(){
          date_default_timezone_set("America/Chicago");
          $del_date = date("Y-m-d H:i:s");
          $del_date = "TO_DATE('".$del_date."', 'YYYY-MM-DD HH24:MI:SS')";
          $deleted_by = $this->session->userdata('user_id');     
          //$user_name = $this->input->post('user_name');
          //$remarks = $this->input->post('remarks');
          $remarks = '';
          $purch_ref = $this->input->post('purch_ref');
		  $manf_qry = $this->db->query("SELECT M.LZ_MANIFEST_ID FROM LZ_MANIFEST_MT M WHERE M.PURCH_REF_NO = '$purch_ref'");
          $manf_qry = $manf_qry->result_array();
          $manifest_id = $manf_qry[0]['LZ_MANIFEST_ID'];
          $comma = ",";

          foreach($barcode as $barcode_no){

            $item_alloc = $this->db->query("SELECT * FROM LZ_LISTING_ALLOC A WHERE A.SEED_ID = (SELECT S.SEED_ID FROM LZ_BARCODE_MT B, LZ_ITEM_SEED S WHERE B.ITEM_ID = S.ITEM_ID AND B.LZ_MANIFEST_ID = S.LZ_MANIFEST_ID AND B.CONDITION_ID = S.DEFAULT_COND AND B.BARCODE_NO = $barcode_no)");

            if($item_alloc->num_rows() > 0){

             return array('item_alloc'=>$item_alloc);

            }else{

              $hold_barcode_qry = $this->db->query("SELECT * FROM LZ_BARCODE_HOLD_LOG WHERE BARCODE_NO = $barcode_no AND ACTION = 1");
                if($hold_barcode_qry->num_rows() == 0){                        

                $query = $this->db->query("SELECT get_single_primary_key('LZ_DELETION_LOG','LOG_ID') LOG_ID FROM DUAL");
                $rs = $query->result_array();
                $log_id = $rs[0]['LOG_ID'];
                $query = $this->db->query("SELECT B.ITEM_ID,B.LZ_MANIFEST_ID,B.CONDITION_ID, I.ITEM_DESC FROM LZ_BARCODE_MT B, ITEMS_MT I WHERE B.ITEM_ID = I.ITEM_ID AND B.BARCODE_NO = $barcode_no");
                $rs = $query->result_array();
                $item_id = $rs[0]['ITEM_ID'];
                $lz_manifest_id = $rs[0]['LZ_MANIFEST_ID'];
                $condition_id = $rs[0]['CONDITION_ID'];
                $item_title = $rs[0]['ITEM_DESC'];

                  //echo $id;
                  $query = $this->db->query("INSERT INTO LZ_DELETION_LOG VALUES($log_id $comma $barcode_no $comma $item_id $comma $lz_manifest_id $comma $condition_id $comma $deleted_by $comma $del_date $comma '$item_title' $comma '$remarks')");
                  
                  $unpost_barcode = "call Pro_Unpost_barcode($barcode_no)";
                  $unpost_barcode = $this->db->query($unpost_barcode);

              }else{ //holded barcode if else
                  //echo "Item is holded. Please un-hold item first.";
                  return array('item_holded'=>$barcode_no);
              } 

            }

                  
          }//foreach end
          if($unpost_barcode){
            //echo "Item Deletion process Succsessfully executed.";
            return "deleted";
          }
         
    }
    public function holdcheck($single_entry_id){
    	$qry_id = "SELECT M.LZ_MANIFEST_ID,M.SINGLE_ENTRY_ID FROM LZ_MANIFEST_MT M WHERE M.SINGLE_ENTRY_ID=$single_entry_id";
    	$query=$this->db->query($qry_id);
        $rs = $query->result_array();

        $old_barcode = $this->db->query("SELECT M.BARCODE_NO FROM LZ_BARCODE_MT M WHERE M.LZ_MANIFEST_ID =". $rs[0]['LZ_MANIFEST_ID']);
	    $old_barcode = $old_barcode->result_array();
	    	foreach ($old_barcode as $barcode) {
	    		$hold_barcode_qry = $this->db->query("SELECT * FROM LZ_BARCODE_HOLD_LOG WHERE BARCODE_NO = " .$barcode['BARCODE_NO']." AND ACTION = 1");
                if($hold_barcode_qry->num_rows() == 0){
                	$flag = false;
                }else{
                	$flag = true;
                	break;
                }
	    	}
	    	return $flag;
    }  
    public function autoList($single_entry_id){
    	$this->db->query("CALL PRO_AUTOLIST_SINGLE_ITEM($single_entry_id)");
    }  
    public function pic_approval()
    {
    	$seed_id = trim($this->input->post('seed_id'));
	    date_default_timezone_set("America/Chicago");
	    $date = date('Y-m-d H:i:s');
	    $ins_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
	    $entered_by = $this->session->userdata('user_id');

	 	$query = $this->db->query("UPDATE LZ_ITEM_SEED S SET S.APPROVED_DATE = $ins_date, S.APPROVED_BY = $entered_by WHERE S.SEED_ID = $seed_id");
	 	if ($query)
	 	{
	 		return 1;
	 	}
	 	else
	 	{
	 		return 0;
	 	}
	}

}

 ?>