<?php 

	class M_Item_Specifics extends CI_Model{

		public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	public function queryData($perameter){
    $item_qry = $this->db->query("select m.item_id,m.lz_manifest_id,m.condition_id from lz_barcode_mt m where m.barcode_no=$perameter"); 
    $item_data = $item_qry->result_array();

    if($item_qry->num_rows() > 0){
      $item_det = $this->db->query("SELECT B.UNIT_NO, B.BARCODE_NO IT_BARCODE, D.CONDITIONS_SEG5     ITEM_CONDITION, D.ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, D.ITEM_MT_UPC         UPC, D.AVAILABLE_QTY       AVAIL_QTY, B.ITEM_ID, B.LZ_MANIFEST_ID, M.PURCH_REF_NO,  B.CONDITION_ID FROM LZ_BARCODE_MT B, LZ_MANIFEST_DET D, ITEMS_MT I, LZ_MANIFEST_MT M,LZ_ITEM_COND_MT C WHERE B.ITEM_ID = I.ITEM_ID AND B.LZ_MANIFEST_ID = D.LZ_MANIFEST_ID AND D.LAPTOP_ITEM_CODE = I.ITEM_CODE AND M.LZ_MANIFEST_ID = D.LZ_MANIFEST_ID 
   AND  UPPER(TRIM(D.CONDITIONS_SEG5)) =UPPER(C.COND_NAME(+)) AND B.LZ_MANIFEST_ID=".$item_data[0]['LZ_MANIFEST_ID']." AND B.ITEM_ID = ".$item_data[0]['ITEM_ID']." ORDER BY B.UNIT_NO"); 
      $item_det = $item_det->result_array(); 
    }

    // $cat_id = $this->db->query("SELECT DISTINCT DT.E_BAY_CATA_ID_SEG6,DT.BRAND_SEG3 FROM LZ_MANIFEST_DET DT WHERE DT.LAPTOP_ITEM_CODE = (SELECT V.LAPTOP_ITEM_CODE FROM VIEW_LZ_LISTING_REVISED V WHERE V.LZ_MANIFEST_ID = ".$item_det[0]['LZ_MANIFEST_ID']." AND V.ITEM_ID = ".$item_det[0]['ITEM_ID']." AND ROWNUM = 1) AND DT.E_BAY_CATA_ID_SEG6 NOT IN ('N/A', 'Other', 'OTHER', 'other')"); 
    
    if(!empty($item_data[0]['CONDITION_ID'])){
      $condition_id = $item_data[0]['CONDITION_ID'];
    }else{
      $condition_id = $item_det[0]['CONDITION_ID'];
    }
		$cat_id = $this->db->query("SELECT S.CATEGORY_ID E_BAY_CATA_ID_SEG6, S.CATEGORY_NAME BRAND_SEG3 FROM LZ_MANIFEST_DET DT, LZ_ITEM_SEED S , ITEMS_MT I WHERE DT.LZ_MANIFEST_ID = S.LZ_MANIFEST_ID AND DT.LAPTOP_ITEM_CODE = I.ITEM_CODE AND I.ITEM_ID = S.ITEM_ID AND S.ITEM_ID = ".$item_data[0]['ITEM_ID']." AND S.LZ_MANIFEST_ID = ".$item_data[0]['LZ_MANIFEST_ID']." AND S.DEFAULT_COND = ".$condition_id);

		$cat_id=  $cat_id->result_array();
		//var_dump($cat_id);exit;

		if(!empty($cat_id[0]['E_BAY_CATA_ID_SEG6'])){
			

			//$mt_id = $this->db->query("SELECT * FROM CATEGORY_SPECIFIC_MT T WHERE T.EBAY_CATEGORY_ID = (SELECT DISTINCT DT.E_BAY_CATA_ID_SEG6 FROM LZ_MANIFEST_DET DT WHERE DT.LAPTOP_ITEM_CODE = (SELECT V.LAPTOP_ITEM_CODE FROM VIEW_LZ_LISTING_REVISED V WHERE V.LZ_MANIFEST_ID = ".$item_det[0]['LZ_MANIFEST_ID']." AND V.ITEM_ID = ".$item_det[0]['ITEM_ID']." AND ROWNUM = 1) AND DT.E_BAY_CATA_ID_SEG6 NOT IN ('N/A', 'Other', 'OTHER', 'other') ) ORDER BY T.SPECIFIC_NAME");
      $mt_id = $this->db->query("SELECT * FROM CATEGORY_SPECIFIC_MT T WHERE T.EBAY_CATEGORY_ID = ".$cat_id[0]['E_BAY_CATA_ID_SEG6']." ORDER BY T.SPECIFIC_NAME"); 
      $mt_id = $mt_id->result_array();

			if(!empty($mt_id[0]['EBAY_CATEGORY_ID'])){
				// $specs_qry = $this->db->query("SELECT Q1.EBAY_CATEGORY_ID, Q1.SPECIFIC_NAME, DET.SPECIFIC_VALUE, Q1.MAX_VALUE, Q1.MIN_VALUE, Q1.SELECTION_MODE,Q1.MT_ID FROM (SELECT * FROM CATEGORY_SPECIFIC_MT MT WHERE MT.EBAY_CATEGORY_ID = (SELECT DISTINCT  DT.E_BAY_CATA_ID_SEG6 FROM LZ_MANIFEST_DET DT WHERE DT.LAPTOP_ITEM_CODE = (SELECT V.LAPTOP_ITEM_CODE FROM VIEW_LZ_LISTING_REVISED V WHERE V.LZ_MANIFEST_ID = ".$item_det[0]['LZ_MANIFEST_ID']." AND V.ITEM_ID = ".$item_det[0]['ITEM_ID']." AND ROWNUM = 1) AND DT.E_BAY_CATA_ID_SEG6 NOT IN ('N/A', 'Other', 'OTHER', 'other' ) AND ROWNUM = 1 )) Q1, CATEGORY_SPECIFIC_DET DET WHERE Q1.MT_ID = DET.MT_ID ORDER BY Q1.SPECIFIC_NAME");

        $specs_qry = $this->db->query("SELECT Q1.EBAY_CATEGORY_ID, Q1.SPECIFIC_NAME, DET.SPECIFIC_VALUE, Q1.MAX_VALUE, Q1.MIN_VALUE, Q1.SELECTION_MODE,Q1.MT_ID FROM (SELECT * FROM CATEGORY_SPECIFIC_MT MT WHERE MT.EBAY_CATEGORY_ID = (SELECT * FROM (SELECT I.CATEGORY_ID FROM LZ_ITEM_SEED I WHERE I.LZ_MANIFEST_ID =".$item_det[0]['LZ_MANIFEST_ID']." AND I.ITEM_ID = ".$item_det[0]['ITEM_ID']." ORDER BY I.SEED_ID DESC) WHERE ROWNUM <= 1)) Q1, CATEGORY_SPECIFIC_DET DET WHERE Q1.MT_ID = DET.MT_ID ORDER BY Q1.SPECIFIC_NAME"); $specs_qry=  $specs_qry->result_array();

        $match_qry = "SELECT  D.LZ_TEST_MT_ID FROM LZ_TEST_CHECK_MT M, LZ_TEST_CHECK_DET D WHERE M.LZ_TEST_MT_ID = D.LZ_TEST_MT_ID AND M.LZ_TEST_MT_ID IN (SELECT DISTINCT D.LZ_TEST_MT_ID FROM LZ_CHECKLIST_DET D, LZ_CHECKLIST_MT M WHERE D.CHECKLIST_MT_ID = (SELECT B.CHECKLIST_MT_ID FROM LZ_CATEGORY_CHECKLIST_BIND B WHERE B.CATEGORY_ID = ".$mt_id[0]['EBAY_CATEGORY_ID']." AND ROWNUM = 1) AND D.CHECKLIST_MT_ID = M.CHECKLIST_MT_ID) ORDER BY D.LZ_TEST_MT_ID"; 
        $match_qry = $this->db->query($match_qry);
        $match_qry=  $match_qry->result_array();

        $specs_value = "SELECT MT.SPECIFICS_NAME, DT.SPECIFICS_VALUE,CM.MT_ID FROM LZ_ITEM_SPECIFICS_MT MT, LZ_ITEM_SPECIFICS_DET DT,category_specific_mt cm WHERE MT.SPECIFICS_MT_ID = DT.SPECIFICS_MT_ID and upper(cm.specific_name) = upper(mt.specifics_name) and cm.ebay_category_id = mt.category_id AND MT.ITEM_ID = ". $item_det[0]['ITEM_ID']."AND MT.CATEGORY_ID = ".$mt_id[0]['EBAY_CATEGORY_ID']."  ORDER BY MT.SPECIFICS_NAME";
        $specs_value = $this->db->query($specs_value);
        $specs_value=  $specs_value->result_array();   

				return array('specs_qry'=>$specs_qry,'mt_id'=>$mt_id, 'item_det'=> $item_det, 'cat_id'=>$cat_id, 'specs_value'=>$specs_value,'match_qry'=>$match_qry);
			}else{
        
				$result['category_id'] = $cat_id[0]['E_BAY_CATA_ID_SEG6'];
        //var_dump($cat_id[0]['E_BAY_CATA_ID_SEG6']);exit;
				$this->load->view('ebay/trading/item_specifics',$result);
				// $result['data'] = $this->m_tester_model->queryData($perameter);
			  // $this->load->view('tester_screen/v_tester_result', $result);
			}

		}else{//category id if else
				return array('error_msg'=>true, 'item_det'=> $item_det);
		}
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

        $item_qry = $this->db->query("select m.item_id,m.lz_manifest_id from lz_barcode_mt m where m.barcode_no=$it_barcode"); 
        $item_det = $item_qry->result_array();
       //B.LZ_MANIFEST_ID=".$item_det[0]['LZ_MANIFEST_ID']." AND B.ITEM_ID = ".$item_det[0]['ITEM_ID']";

        $cat_id = $this->db->query("UPDATE LZ_MANIFEST_DET SET MAIN_CATAGORY_SEG1='$main_category' ,SUB_CATAGORY_SEG2='$sub_cat',E_BAY_CATA_ID_SEG6= '$category_id',BRAND_SEG3 = '$category_name' WHERE LAPTOP_ITEM_CODE = (SELECT I.ITEM_CODE FROM ITEMS_MT I WHERE I.ITEM_ID=".$item_det[0]['ITEM_ID'].")");
        return $cat_id;
	}
	public function add_specifics(){
      $item_id = $this->input->post('item_id');
      $cat_id = $this->input->post('cat_id');
      $spec_name = $this->input->post('spec_name');

      $spec_value = $this->input->post('spec_value');
      //var_dump($spec_value);exit;
      $item_upc = $this->input->post('item_upc');
      $item_mpn = $this->input->post('item_mpn');
      $user_id = $this->session->userdata('user_id');
      date_default_timezone_set("America/Chicago");
      $current_date = date("Y-m-d H:i:s");
      $current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";
      $comma = ',';

      $qry_det = $this->db->query("DELETE FROM LZ_ITEM_SPECIFICS_DET D WHERE D.SPECIFICS_MT_ID IN (SELECT S.SPECIFICS_MT_ID FROM LZ_ITEM_SPECIFICS_MT S WHERE S.CATEGORY_ID = $cat_id AND S.ITEM_ID = $item_id)");

      $qry_mt = $this->db->query("DELETE FROM  LZ_ITEM_SPECIFICS_MT S WHERE S.CATEGORY_ID =  $cat_id AND S.ITEM_ID = $item_id");


      $i=0;
      foreach ($spec_name as $name) {
      	
      	$name = trim(str_replace("  ", ' ', $name));
      	$name = trim(str_replace(array("'"), "''", $name));
        if(is_array(@$spec_value[$i])){
          $value = "ok";
          //var_dump(@$spec_value[$i]);
        }else{
          $value = @$spec_value[$i];
          //var_dump(@$spec_value[$i]);
        }
      	
        if($value != 'select' && !empty($value)){
          //var_dump($value);
          // if(!empty($item_upc)){
          //   $query = $this->db->query("SELECT SPECIFICS_MT_ID from LZ_ITEM_SPECIFICS_MT WHERE SPECIFICS_NAME = '$name' AND CATEGORY_ID=$cat_id AND UPC = '$item_upc'");
          //     $rs = $query->result_array();
          // }elseif(!empty($item_mpn)){
          //   $query = $this->db->query("SELECT SPECIFICS_MT_ID from LZ_ITEM_SPECIFICS_MT WHERE SPECIFICS_NAME = '$name' AND CATEGORY_ID=$cat_id AND upper(MPN) = upper('$item_mpn')");
          //     $rs = $query->result_array();
          // }else{
          //   return false;
          //   exit;
          // }
      	
          	$get_mt_pk = $this->db->query("SELECT get_single_primary_key('LZ_ITEM_SPECIFICS_MT','SPECIFICS_MT_ID') SPECIFICS_MT_ID FROM DUAL");
		        $get_pk = $get_mt_pk->result_array();
		        $specifics_mt_id = $get_pk[0]['SPECIFICS_MT_ID'];
            $ins_mt_qty = "INSERT INTO LZ_ITEM_SPECIFICS_MT VALUES ($specifics_mt_id $comma $item_id $comma $cat_id $comma $user_id $comma $current_date $comma '$name' $comma '$item_mpn' $comma '$item_upc')";
				    $ins_mt_qty = $this->db->query($ins_mt_qty);
        //}
          if(is_array(@$spec_value[$i])){
            foreach(@$spec_value[$i] as $val){
              //var_dump(@$spec_value[$i]);
              $specific_value = trim(str_replace("  ", ' ', $val));
              $specific_value = trim(str_replace(array("'"), "''", $specific_value));

              if(!empty($specific_value)){
                $get_det_pk = $this->db->query("SELECT get_single_primary_key('LZ_ITEM_SPECIFICS_DET','SPECIFICS_DET_ID') SPECIFICS_DET_ID FROM DUAL");
                $get_det_pk = $get_det_pk->result_array();
                $specifics_det_id = $get_det_pk[0]['SPECIFICS_DET_ID'];
                $ins_det_qty = "INSERT INTO LZ_ITEM_SPECIFICS_DET VALUES ($specifics_det_id $comma $specifics_mt_id $comma '$specific_value')";
                $ins_det_qty = $this->db->query($ins_det_qty);
              }
            }

          }else{
           // if(!empty(specific_valueue)){
              $specific_value = trim(str_replace("  ", ' ', $value));
              $specific_value = trim(str_replace(array("'"), "''", $specific_value));
              $get_det_pk = $this->db->query("SELECT get_single_primary_key('LZ_ITEM_SPECIFICS_DET','SPECIFICS_DET_ID') SPECIFICS_DET_ID FROM DUAL");
              $get_det_pk = $get_det_pk->result_array();
              $specifics_det_id = $get_det_pk[0]['SPECIFICS_DET_ID'];
              $ins_det_qty = "INSERT INTO LZ_ITEM_SPECIFICS_DET VALUES ($specifics_det_id $comma $specifics_mt_id $comma '$specific_value')";
              $ins_det_qty = $this->db->query($ins_det_qty);
           // }
            }    
            	//}//end main ifelse
        }// end main if
         $i++;
      }//end main foreach
	}
  public function attribute_value($cat_id, $barcode, $item_mpn, $item_upc, $spec_name, $custom_attribute){
    $comma = ',';
    $query = $this->db->query("SELECT SPECIFIC_VALUE FROM CATEGORY_SPECIFIC_DET D WHERE D.MT_ID = (SELECT M.MT_ID FROM CATEGORY_SPECIFIC_MT M WHERE M.EBAY_CATEGORY_ID = $cat_id AND UPPER(M.SPECIFIC_NAME) = UPPER('$spec_name')) AND UPPER(SPECIFIC_VALUE) = UPPER('$custom_attribute')"); 
    if($query->num_rows() >0){
        return false;
    }else{
      $get_mt_id = $this->db->query("SELECT M.MT_ID FROM CATEGORY_SPECIFIC_MT M WHERE M.EBAY_CATEGORY_ID=$cat_id AND UPPER(M.SPECIFIC_NAME)=UPPER('$spec_name')");
      $get_mt_id = $get_mt_id->result_array();
      $mt_id = $get_mt_id[0]['MT_ID'];

      $get_det_pk = $this->db->query("SELECT get_single_primary_key('CATEGORY_SPECIFIC_DET','DET_ID') SPECIFICS_DET_ID FROM DUAL");
      $get_det_pk = $get_det_pk->result_array();
      $specifics_det_id = $get_det_pk[0]['SPECIFICS_DET_ID'];
      
        $ins_det_qry = "INSERT INTO CATEGORY_SPECIFIC_DET VALUES ($specifics_det_id $comma $mt_id $comma '$custom_attribute')";
        $ins_det_qry = $this->db->query($ins_det_qry);
    }
  }
  public function custom_specifics(){
    $cat_id = $this->input->post('cat_id');
    $custom_name = ucfirst($this->input->post('custom_name'));
    $custom_name = trim(str_replace("  ", ' ', $custom_name));
    $custom_name = trim(str_replace(array("'"), "''", $custom_name));

    $custom_value = ucfirst($this->input->post('custom_value'));
    $custom_value = trim(str_replace("  ", ' ', $custom_value));
    $custom_value = trim(str_replace(array("'"), "''", $custom_value));
    $selectionMode = $this->input->post('selectionMode');
    if(empty($selectionMode)){
      $selectionMode = 'FreeText';
    } 
    
    $catalogue_only = 0;

    $maxValue = $this->input->post('maxValue');

    if(empty($maxValue)){
      $maxValue = 1;
    }      
    $comma = ',';
    date_default_timezone_set("America/Chicago");
    $current_date = date("Y-m-d H:i:s");
    $current_date = "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";  

    $query = $this->db->query("SELECT SPECIFIC_NAME FROM CATEGORY_SPECIFIC_MT WHERE SPECIFIC_NAME = '$custom_name' AND EBAY_CATEGORY_ID = $cat_id"); 
    if($query->num_rows() >0){
        return false;
    }else{

      $get_mt_pk = $this->db->query("SELECT get_single_primary_key('CATEGORY_SPECIFIC_MT','MT_ID') SPECIFICS_MT_ID FROM DUAL");
      $get_mt_pk = $get_mt_pk->result_array();
      $specifics_mt_id = $get_mt_pk[0]['SPECIFICS_MT_ID'];

        $ins_mt_qry = "INSERT INTO CATEGORY_SPECIFIC_MT(MT_ID, EBAY_CATEGORY_ID, SPECIFIC_NAME, MARKETPLACE_ID, MAX_VALUE, MIN_VALUE, SELECTION_MODE, UPDATE_DATE, CUSTOM, CATALOGUE_ONLY) VALUES ($specifics_mt_id $comma $cat_id $comma '$custom_name' $comma 1 $comma $maxValue $comma 1 $comma '$selectionMode' $comma $current_date $comma 1 $comma $catalogue_only)";
        $ins_mt_qry = $this->db->query($ins_mt_qry);

      $get_det_pk = $this->db->query("SELECT get_single_primary_key('CATEGORY_SPECIFIC_DET','DET_ID') SPECIFICS_DET_ID FROM DUAL");
      $get_det_pk = $get_det_pk->result_array();
      $specifics_det_id = $get_det_pk[0]['SPECIFICS_DET_ID'];              
      
        $ins_det_qry = "INSERT INTO CATEGORY_SPECIFIC_DET VALUES ($specifics_det_id $comma $specifics_mt_id $comma '$custom_value')";
        $ins_det_qry = $this->db->query($ins_det_qry);
    }
  }
  public function item_specifics_details(){
      $spec_detail = $this->db->query("SELECT MT.MT_ID,MT.SPECIFIC_NAME,MT.SELECTION_MODE FROM CATEGORY_SPECIFIC_MT MT");
      $spec_detail = $spec_detail->result_array();
  }
  function view_item_specifics(){

    $specifics_manifest = $this->input->post('specifics_manifest');

/*==============================================
    =            Not Inserted Specifics            =
    ==============================================*/
     $not_inserted_qry = "select b.unit_no, b.barcode_no it_barcode, b.print_status, v.ITEM_CONDITION, v.ITEM_MT_DESC, v.MANUFACTURER, v.MFG_PART_NO, v.UPC, v.AVAIL_QTY, v.ITEM_ID, v.LZ_MANIFEST_ID, v.PURCH_REF_NO, v.laptop_item_code from lz_barcode_mt b, (SELECT im.item_desc ITEM_MT_DESC, im.item_mt_manufacture MANUFACTURER, im.ITEM_MT_BBY_SKU, im.ITEM_MT_UPC UPC, im.ITEM_MT_MFG_PART_NO MFG_PART_NO, im.item_condition, ld.laptop_item_code, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, lm.purchase_date, IM.ITEM_ID, LM.LOADING_NO, LM.LOADING_DATE, sum(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0)) PO_DETAIL_RETIAL_PRICE, SUM(NVL(LD.AVAILABLE_QTY, 0)) AVAIL_QTY, IM.Item_Code FROM LZ_MANIFEST_MT LM, LZ_MANIFEST_DET LD, ITEMS_MT IM WHERE LM.LZ_MANIFEST_ID = LD.LZ_MANIFEST_ID AND IM.ITEM_CODE = LD.LAPTOP_ITEM_CODE GROUP BY im.item_desc, im.item_mt_manufacture, ld.laptop_item_code, IM.ITEM_ID, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, lM.purchase_date, LM.LOADING_NO, LM.LOADING_DATE, im.ITEM_MT_BBY_SKU, im.ITEM_MT_UPC, im.ITEM_MT_MFG_PART_NO, im.item_condition, IM.Item_Code) v where b.item_id = v.item_id and b.lz_manifest_id = v.LZ_MANIFEST_ID and b.lz_manifest_id = $specifics_manifest and b.item_id in (select distinct i.item_id from items_mt i where i.item_code in (select distinct d.laptop_item_code from lz_manifest_det d where d.lz_manifest_id = $specifics_manifest) and i.item_id not in (select distinct item_id from lz_item_specifics_mt where item_id in (select distinct i.item_id from items_mt i where i.item_code in (select distinct d.laptop_item_code from lz_manifest_det d where d.lz_manifest_id = $specifics_manifest)))) order by b.item_id, b.unit_no "; 
     
      $not_inserted_qry = $this->db->query($not_inserted_qry);
      $not_inserted_qry = $not_inserted_qry->result_array();     
    
    
    /*=====  End of Not Inserted Specifics  ======*/
        
/*==============================================
    =            Inserted Specifics            =
    ==============================================*/
     $inserted_qry = "select b.unit_no, b.barcode_no it_barcode, b.print_status, v.ITEM_CONDITION, v.ITEM_MT_DESC, v.MANUFACTURER, v.MFG_PART_NO, v.UPC, v.AVAIL_QTY, v.ITEM_ID, v.LZ_MANIFEST_ID, v.PURCH_REF_NO, v.laptop_item_code from lz_barcode_mt b, (SELECT im.item_desc ITEM_MT_DESC, im.item_mt_manufacture MANUFACTURER, im.ITEM_MT_BBY_SKU, im.ITEM_MT_UPC UPC, im.ITEM_MT_MFG_PART_NO MFG_PART_NO, im.item_condition, ld.laptop_item_code, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, lm.purchase_date, IM.ITEM_ID, LM.LOADING_NO, LM.LOADING_DATE, sum(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0)) PO_DETAIL_RETIAL_PRICE, SUM(NVL(LD.AVAILABLE_QTY, 0)) AVAIL_QTY, IM.Item_Code FROM LZ_MANIFEST_MT LM, LZ_MANIFEST_DET LD, ITEMS_MT IM WHERE LM.LZ_MANIFEST_ID = LD.LZ_MANIFEST_ID AND IM.ITEM_CODE = LD.LAPTOP_ITEM_CODE GROUP BY im.item_desc, im.item_mt_manufacture, ld.laptop_item_code, IM.ITEM_ID, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, lM.purchase_date, LM.LOADING_NO, LM.LOADING_DATE, im.ITEM_MT_BBY_SKU, im.ITEM_MT_UPC, im.ITEM_MT_MFG_PART_NO, im.item_condition, IM.Item_Code) v where b.item_id = v.item_id and b.lz_manifest_id = v.LZ_MANIFEST_ID and b.lz_manifest_id = $specifics_manifest and b.item_id in (select distinct item_id from lz_item_specifics_mt where item_id in (select i.item_id from items_mt i where i.item_code in (select distinct d.laptop_item_code from lz_manifest_det d where d.lz_manifest_id = $specifics_manifest)) ) order by b.item_id, b.unit_no "; 
    $inserted_qry = $this->db->query($inserted_qry);
    $inserted_qry = $inserted_qry->result_array();   
    
    return array('not_inserted_qry' => $not_inserted_qry, 'inserted_qry'=>$inserted_qry); 
    
    /*=====  End of Inserted Specifics  ======*/

  }
  function specific_edit($perameter){
    
  }
  public function itemCategorySpecifics($perameter){
    $cat_query = $this->db2->query("SELECT CATEGORY_ID,CATEGORY_NAME FROM LZ_BD_CATEGORY_TREE WHERE CATEGORY_ID = $perameter"); 
    $cat_query =  $cat_query->result_array();

    $mt_query = $this->db->query("SELECT * FROM LAPTOP_ZONE.CATEGORY_SPECIFIC_MT  M WHERE M.EBAY_CATEGORY_ID = $perameter"); 
    $mt_query =  $mt_query->result_array();

    $det_query = $this->db->query("SELECT * FROM  LAPTOP_ZONE.CATEGORY_SPECIFIC_DET D WHERE D.MT_ID IN (SELECT MT_ID FROM LAPTOP_ZONE.CATEGORY_SPECIFIC_MT  M WHERE M.EBAY_CATEGORY_ID = $perameter)");

    $det_query =  $det_query->result_array();

    return array('mt_query' => $mt_query, 'det_query'=>$det_query, 'cat_query'=>$cat_query);

   
  }
  public function saveCustomAttribute(){

    // $cat_id = $this->input->post('cat_id');
    $custom_attribute = $this->input->post('custom_attribute');
    $mt_id = $this->input->post('mt_id');
    $custom_attribute = ucfirst($this->input->post('custom_attribute'));
    $custom_attribute = trim(str_replace("  ", ' ', $custom_attribute));
    $custom_attribute = trim(str_replace(array("'"), "''", $custom_attribute));

    $comma = ',';
    $query = $this->db->query("SELECT SPECIFIC_VALUE FROM CATEGORY_SPECIFIC_DET D WHERE D.MT_ID = $mt_id AND upper(SPECIFIC_VALUE) = upper('$custom_attribute')"); 
    if($query->num_rows() >0){
        return false;
    }else{
     
      // $mt_id = $get_mt_id[0]['MT_ID'];

      $get_det_pk = $this->db->query("SELECT get_single_primary_key('CATEGORY_SPECIFIC_DET','DET_ID') SPECIFICS_DET_ID FROM DUAL");
      $get_det_pk = $get_det_pk->result_array();
      $specifics_det_id = $get_det_pk[0]['SPECIFICS_DET_ID'];
      
        $ins_det_qry = "INSERT INTO CATEGORY_SPECIFIC_DET VALUES ($specifics_det_id $comma $mt_id $comma '$custom_attribute')";
        $ins_det_qry = $this->db->query($ins_det_qry);
    }    


    
  }
  public function selectedValues(){
    $specific_barcode = ucfirst($this->input->post('specific_barcode'));
    $spec_barcode = trim(str_replace("  ", ' ', $specific_barcode));
    $spec_barcode = trim(str_replace(array("'"), "''", $spec_barcode));

     $item_qry = $this->db->query("SELECT M.ITEM_ID,M.LZ_MANIFEST_ID FROM LZ_BARCODE_MT M WHERE M.BARCODE_NO=$spec_barcode"); 
    $item_det = $item_qry->result_array();

    if($item_qry->num_rows() > 0){
      $item_det = $this->db->query("SELECT B.UNIT_NO,B.BARCODE_NO IT_BARCODE,V.ITEM_CONDITION,V.ITEM_MT_DESC,V.MANUFACTURER,V.MFG_PART_NO,V.UPC,V.AVAIL_QTY,V.ITEM_ID,V.LZ_MANIFEST_ID,V.PURCH_REF_NO FROM LZ_BARCODE_MT B, VIEW_LZ_LISTING_REVISED V WHERE B.ITEM_ID = V.ITEM_ID AND B.LZ_MANIFEST_ID = V.LZ_MANIFEST_ID AND B.LZ_MANIFEST_ID=".$item_det[0]['LZ_MANIFEST_ID']." AND B.ITEM_ID = ".$item_det[0]['ITEM_ID']." ORDER BY B.UNIT_NO"); 
      $item_det = $item_det->result_array();
    }

    $cat_id = $this->db->query("SELECT DISTINCT DT.E_BAY_CATA_ID_SEG6,DT.BRAND_SEG3 FROM LZ_MANIFEST_DET DT WHERE DT.LAPTOP_ITEM_CODE = (SELECT V.LAPTOP_ITEM_CODE FROM VIEW_LZ_LISTING_REVISED V WHERE V.LZ_MANIFEST_ID = ".$item_det[0]['LZ_MANIFEST_ID']." AND V.ITEM_ID = ".$item_det[0]['ITEM_ID']." AND ROWNUM = 1) AND DT.E_BAY_CATA_ID_SEG6 NOT IN ('N/A', 'Other', 'OTHER', 'other')"); 

    $cat_id=  $cat_id->result_array();
    //var_dump($cat_id);exit;

    if(!empty($cat_id[0]['E_BAY_CATA_ID_SEG6'])){
      $mt_id = $this->db->query("SELECT * FROM CATEGORY_SPECIFIC_MT T WHERE T.EBAY_CATEGORY_ID = (SELECT DISTINCT DT.E_BAY_CATA_ID_SEG6 FROM LZ_MANIFEST_DET DT WHERE DT.LAPTOP_ITEM_CODE = (SELECT dt.laptop_item_code FROM lz_manifest_det dt WHERE dt.LZ_MANIFEST_ID = ".$item_det[0]['LZ_MANIFEST_ID']." AND dt.laptop_item_code = (select item_code from items_mt where item_id = ".$item_det[0]['ITEM_ID'].") AND ROWNUM = 1) AND DT.E_BAY_CATA_ID_SEG6 NOT IN ('N/A', 'Other', 'OTHER', 'other')  AND ROWNUM = 1) ORDER BY T.SPECIFIC_NAME");
      $mt_id = $mt_id->result_array();
      $specs_value = "SELECT MT.SPECIFICS_NAME, DT.SPECIFICS_VALUE,CM.MT_ID FROM LZ_ITEM_SPECIFICS_MT MT, LZ_ITEM_SPECIFICS_DET DT,category_specific_mt cm WHERE MT.SPECIFICS_MT_ID = DT.SPECIFICS_MT_ID and upper(cm.specific_name) = upper(mt.specifics_name) and cm.ebay_category_id = mt.category_id AND MT.ITEM_ID = ". $item_det[0]['ITEM_ID']."AND MT.CATEGORY_ID = ".$mt_id[0]['EBAY_CATEGORY_ID']."  ORDER BY MT.SPECIFICS_NAME";
      $specs_value = $this->db->query($specs_value);
      $specs_value=  $specs_value->result_array(); 

      return array('result'=>$specs_value, 'flag' => 1 ); 
  }else{
    return array('result'=>$specs_value, 'flag' => 0 );
  }
      
  }

}

 ?>