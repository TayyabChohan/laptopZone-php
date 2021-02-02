<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Single Entry Model
 */
class m_react extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function login()
    {

        $userName = strtoupper($this->input->post('userName'));
        $passWord = $this->input->post('passWord');

        $query = $this->db->query("SELECT M.EMPLOYEE_ID,M.USER_NAME,M.LOCATION,(select MT.BUISNESS_NAME from emp_merchant_det DE, lz_merchant_mt MT WHERE DE.MERCHANT_ID = MT.MERCHANT_ID AND DE.EMPLOYEE_ID = M.EMPLOYEE_ID AND ROWNUM <= 1) MER_NAME, (select MT.MERCHANT_ID from emp_merchant_det DE, lz_merchant_mt MT WHERE DE.MERCHANT_ID = MT.MERCHANT_ID AND DE.EMPLOYEE_ID = M.EMPLOYEE_ID AND ROWNUM <= 1) MER_id FROM  EMPLOYEE_MT M WHERE upper(USER_NAME) = '$userName' AND PASS_WORD ='$passWord' AND STATUS =1 ")->result_array();

        if (count($query) == 1) {

            return array('query' => $query, 'login_true' => true);
            //return TRUE;
        } else {
            $query = null;
            return array('query' => $query, 'login_true' => false);
        }

        // return  $userName + $passWord;
    }

    public function getMacro()
    {
        $type_id = $this->input->post('type_id');

        $get_macro = $this->db->query("SELECT * FROM LZ_MACRO_MT WHERE TYPE_ID = $type_id ORDER BY MACRO_ORDER ASC")->result_array();
        return $get_macro;
    }

    public function get_cond_desc()
    {
        $cond_id = $this->input->post('cond_id');
        $get_cond_desc = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT M WHERE M.ID ='$cond_id' ")->result_array();

        if ($get_cond_desc) {
            return array('get_cond_desc' => $get_cond_desc);

        }

    }

    public function get_obj_drop()
    {
        $get_obj = $this->db->query("SELECT O.OBJECT_ID, O.OBJECT_NAME, O.CATEGORY_ID FROM LZ_BD_CAT_GROUP_MT M, LZ_BD_CAT_GROUP_DET D, LZ_BD_OBJECTS_MT O WHERE M.LZ_BD_GROUP_ID = D.LZ_BD_GROUP_ID AND M.LZ_BD_GROUP_ID = O.LZ_BD_GROUP_ID AND D.LZ_BD_GROUP_ID = O.LZ_BD_GROUP_ID AND D.CATEGORY_ID = O.CATEGORY_ID AND M.LZ_BD_GROUP_ID = 7 ");

        if ($get_obj) {
            $get_obj_itm = $get_obj->result_array();
            return array('get_obj_itm' => $get_obj_itm);
        } else {
            return null;
        }

    }

    public function get_obj_drop_sugestion()
    {
        // $get_obj = $this->db->query("SELECT O.OBJECT_ID, O.OBJECT_NAME NICKNAME, O.CATEGORY_ID EMAIL FROM LZ_BD_CAT_GROUP_MT M, LZ_BD_CAT_GROUP_DET D, LZ_BD_OBJECTS_MT O WHERE M.LZ_BD_GROUP_ID = D.LZ_BD_GROUP_ID AND M.LZ_BD_GROUP_ID = O.LZ_BD_GROUP_ID AND D.LZ_BD_GROUP_ID = O.LZ_BD_GROUP_ID AND D.CATEGORY_ID = O.CATEGORY_ID AND M.LZ_BD_GROUP_ID = 7 ");

        // $get_obj = $this->db->query("SELECT OB.OBJECT_NAME NICKNAME,OB.CATEGORY_ID EMAIL FROM LZ_BD_OBJECTS_MT OB WHERE ROWNUM <=1000 order by OB.OBJECT_ID desc");

        $get_obj = $this->db->query("SELECT O.OBJECT_ID, O.OBJECT_NAME NICKNAME, O.CATEGORY_ID  EMAIL FROM LZ_BD_CAT_GROUP_MT M, LZ_BD_CAT_GROUP_DET D, LZ_BD_OBJECTS_MT O WHERE M.LZ_BD_GROUP_ID = D.LZ_BD_GROUP_ID AND M.LZ_BD_GROUP_ID = O.LZ_BD_GROUP_ID AND D.LZ_BD_GROUP_ID = O.LZ_BD_GROUP_ID AND D.CATEGORY_ID = O.CATEGORY_ID AND M.LZ_BD_GROUP_ID = 7 ");

        return $get_obj->result();
        exit;

        // if ($get_obj) {
        //     $get_obj_itm = $get_obj->result_array();
        //     return $get_obj_itm; //array('get_obj_itm' => $get_obj_itm);
        // } else {
        //     return null;
        // }

    }

    public function get_unposted_item()
    {
        $query = $this->db->query("SELECT * FROM (SELECT 'DEKIT ITEM' BAROCDE_TYPE, DECODE(D.LZ_MANIFEST_DET_ID, NULL, 'PENDING', 'POSTED') VERIFY_ITEM, D.LZ_DEKIT_US_DT_ID, D.BARCODE_PRV_NO, BB.BARCODE_NO, BB.EBAY_ITEM_ID, C.COND_NAME, O.OBJECT_NAME, D.PIC_DATE_TIME, D.PIC_BY, D.PIC_NOTES, DECODE(D.MPN_DESCRIPTION, NULL, CA.MPN_DESCRIPTION, D.MPN_DESCRIPTION) MPN_DESC, CA.MPN, CA.UPC, CA.BRAND, TO_CHAR(D.FOLDER_NAME) FOLDER_NAME, D.DEKIT_REMARKS REMARKS, D.LZ_MANIFEST_DET_ID FROM LZ_DEKIT_US_DT   D, LZ_BARCODE_MT BB, LZ_BD_OBJECTS_MT O, LZ_CATALOGUE_MT  CA, LZ_ITEM_COND_MT  C WHERE D.OBJECT_ID = O.OBJECT_ID(+) AND D.CATALOG_MT_ID = CA.CATALOGUE_MT_ID(+) AND D.CONDITION_ID = C.ID(+) AND D.BARCODE_PRV_NO = BB.BARCODE_NO(+) UNION ALL SELECT 'SPECIAL LOT' BAROCDE_TYPE, DECODE(L.LZ_MANIFEST_DET_ID, NULL, 'PENDING', 'POSTED') VERIFY_ITEM, L.SPECIAL_LOT_ID, L.BARCODE_PRV_NO, BB.BARCODE_NO, BB.EBAY_ITEM_ID, C.COND_NAME, OB.OBJECT_NAME, L.PIC_DATE_TIME, L.PIC_BY, L.PIC_NOTES, DECODE(L.MPN_DESCRIPTION, NULL, CA.MPN_DESCRIPTION, L.MPN_DESCRIPTION) MPN_DESC, DECODE(L.CARD_MPN, NULL, CA.MPN, L.CARD_MPN) MPN, DECODE(L.CARD_UPC, NULL, CA.UPC, L.CARD_UPC) UPC, DECODE(L.BRAND, NULL, CA.BRAND, L.BRAND) BRAND, TO_CHAR(L.FOLDER_NAME) FOLDER_NAME, L.LOT_REMARKS REMARKS, L.LZ_MANIFEST_DET_ID FROM LZ_SPECIAL_LOTS  L, LZ_BD_OBJECTS_MT OB, LZ_ITEM_COND_MT  C, LZ_CATALOGUE_MT  CA, LZ_BARCODE_MT BB WHERE L.OBJECT_ID = OB.OBJECT_ID(+) AND L.CONDITION_ID = C.ID(+) AND L.CATALOG_MT_ID = CA.CATALOGUE_MT_ID(+) AND L.BARCODE_PRV_NO = BB.BARCODE_NO(+) /*ORDER BY LZ_MANIFEST_DET_ID  NULLS FIRST*/) WHERE ROWNUM <= 150   and barcode_prv_no in (127758,127645,127834,127640,127835,127715)
          order by barcode_prv_no asc /*and barcode_prv_no = 126153*/ ");

        if ($query) {
            $get_items = $query->result_array();
            return array('get_items' => $get_items);
        } else {
            return null;
        }
    }

    public function add_custom_specifics()
    {
        $cat_id = $this->input->post('cat_id');
        $custom_name = ucfirst($this->input->post('custom_name'));
        $custom_name = trim(str_replace("  ", ' ', $custom_name));
        $custom_name = trim(str_replace(array("'"), "''", $custom_name));

        $custom_value = ucfirst($this->input->post('custom_value'));
        $custom_value = trim(str_replace("  ", ' ', $custom_value));
        $custom_value = trim(str_replace(array("'"), "''", $custom_value));

        $selectionMode = 'FreeText';

        $catalogue_only = 0;

        $maxValue = 1;

        $comma = ',';
        date_default_timezone_set("America/Chicago");
        $current_date = date("Y-m-d H:i:s");
        $current_date = "TO_DATE('" . $current_date . "', 'YYYY-MM-DD HH24:MI:SS')";

        $query = $this->db->query("SELECT SPECIFIC_NAME FROM CATEGORY_SPECIFIC_MT WHERE SPECIFIC_NAME = '$custom_name' AND EBAY_CATEGORY_ID = $cat_id");
        if ($query->num_rows() > 0) {
            return false;
        } else {

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

    public function add_specifics()
    {
        $item_id = $this->input->post('item_id');
        $cat_id = $this->input->post('cat_id');
        $spec_name = $this->input->post('spec_name');

        $spec_value = $this->input->post('spec_value');
        //var_dump($spec_value);exit;
        $item_upc = $this->input->post('item_upc');
        $item_mpn = $this->input->post('item_mpn');
        $user_id = 2; // $this->session->userdata('user_id');
        date_default_timezone_set("America/Chicago");
        $current_date = date("Y-m-d H:i:s");
        $current_date = "TO_DATE('" . $current_date . "', 'YYYY-MM-DD HH24:MI:SS')";
        $comma = ',';

        $qry_det = $this->db->query("DELETE FROM LZ_ITEM_SPECIFICS_DET D WHERE D.SPECIFICS_MT_ID IN (SELECT S.SPECIFICS_MT_ID FROM LZ_ITEM_SPECIFICS_MT S WHERE S.CATEGORY_ID = $cat_id AND S.ITEM_ID = $item_id)");

        $qry_mt = $this->db->query("DELETE FROM  LZ_ITEM_SPECIFICS_MT S WHERE S.CATEGORY_ID =  $cat_id AND S.ITEM_ID = $item_id");

        $i = 0;
        foreach ($spec_name as $name) {

            $name = trim(str_replace("  ", ' ', $name));
            $name = trim(str_replace(array("'"), "''", $name));
            if (is_array(@$spec_value[$i])) {
                $value = "ok";
                //var_dump(@$spec_value[$i]);
            } else {
                $value = @$spec_value[$i];
                //var_dump(@$spec_value[$i]);
            }

            if ($value != 'select' && !empty($value)) {
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
                if (is_array(@$spec_value[$i])) {
                    foreach (@$spec_value[$i] as $val) {
                        //var_dump(@$spec_value[$i]);
                        $specific_value = trim(str_replace("  ", ' ', $val));
                        $specific_value = trim(str_replace(array("'"), "''", $specific_value));

                        if (!empty($specific_value)) {
                            $get_det_pk = $this->db->query("SELECT get_single_primary_key('LZ_ITEM_SPECIFICS_DET','SPECIFICS_DET_ID') SPECIFICS_DET_ID FROM DUAL");
                            $get_det_pk = $get_det_pk->result_array();
                            $specifics_det_id = $get_det_pk[0]['SPECIFICS_DET_ID'];
                            $ins_det_qty = "INSERT INTO LZ_ITEM_SPECIFICS_DET VALUES ($specifics_det_id $comma $specifics_mt_id $comma '$specific_value')";
                            $ins_det_qty = $this->db->query($ins_det_qty);
                        }
                    }

                } else {
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
            } // end main if
            $i++;
        } //end main foreach
    }

    public function queryData()
    {

        $perameter = $this->input->post('barocde');
        $item_qry = $this->db->query("select m.item_id,m.lz_manifest_id,m.condition_id from lz_barcode_mt m where m.barcode_no=$perameter");
        $item_data = $item_qry->result_array();

        if ($item_qry->num_rows() > 0) {
            $item_det = $this->db->query("SELECT B.UNIT_NO, B.BARCODE_NO IT_BARCODE, D.CONDITIONS_SEG5     ITEM_CONDITION, D.ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, D.ITEM_MT_UPC         UPC, D.AVAILABLE_QTY       AVAIL_QTY, B.ITEM_ID, B.LZ_MANIFEST_ID, M.PURCH_REF_NO,  B.CONDITION_ID FROM LZ_BARCODE_MT B, LZ_MANIFEST_DET D, ITEMS_MT I, LZ_MANIFEST_MT M,LZ_ITEM_COND_MT C WHERE B.ITEM_ID = I.ITEM_ID AND B.LZ_MANIFEST_ID = D.LZ_MANIFEST_ID AND D.LAPTOP_ITEM_CODE = I.ITEM_CODE AND M.LZ_MANIFEST_ID = D.LZ_MANIFEST_ID
   AND  UPPER(TRIM(D.CONDITIONS_SEG5)) =UPPER(C.COND_NAME(+)) AND B.LZ_MANIFEST_ID=" . $item_data[0]['LZ_MANIFEST_ID'] . " AND B.ITEM_ID = " . $item_data[0]['ITEM_ID'] . " ORDER BY B.UNIT_NO");
            $item_det = $item_det->result_array();
        }

        // $cat_id = $this->db->query("SELECT DISTINCT DT.E_BAY_CATA_ID_SEG6,DT.BRAND_SEG3 FROM LZ_MANIFEST_DET DT WHERE DT.LAPTOP_ITEM_CODE = (SELECT V.LAPTOP_ITEM_CODE FROM VIEW_LZ_LISTING_REVISED V WHERE V.LZ_MANIFEST_ID = ".$item_det[0]['LZ_MANIFEST_ID']." AND V.ITEM_ID = ".$item_det[0]['ITEM_ID']." AND ROWNUM = 1) AND DT.E_BAY_CATA_ID_SEG6 NOT IN ('N/A', 'Other', 'OTHER', 'other')");

        if (!empty($item_data[0]['CONDITION_ID'])) {
            $condition_id = $item_data[0]['CONDITION_ID'];
        } else {
            $condition_id = $item_det[0]['CONDITION_ID'];
        }
        $cat_id = $this->db->query("SELECT S.CATEGORY_ID E_BAY_CATA_ID_SEG6, S.CATEGORY_NAME BRAND_SEG3 FROM LZ_MANIFEST_DET DT, LZ_ITEM_SEED S , ITEMS_MT I WHERE DT.LZ_MANIFEST_ID = S.LZ_MANIFEST_ID AND DT.LAPTOP_ITEM_CODE = I.ITEM_CODE AND I.ITEM_ID = S.ITEM_ID AND S.ITEM_ID = " . $item_data[0]['ITEM_ID'] . " AND S.LZ_MANIFEST_ID = " . $item_data[0]['LZ_MANIFEST_ID'] . " AND S.DEFAULT_COND = " . $condition_id);

        $cat_id = $cat_id->result_array();
        //var_dump($cat_id);exit;

        if (!empty($cat_id[0]['E_BAY_CATA_ID_SEG6'])) {

            //$mt_id = $this->db->query("SELECT * FROM CATEGORY_SPECIFIC_MT T WHERE T.EBAY_CATEGORY_ID = (SELECT DISTINCT DT.E_BAY_CATA_ID_SEG6 FROM LZ_MANIFEST_DET DT WHERE DT.LAPTOP_ITEM_CODE = (SELECT V.LAPTOP_ITEM_CODE FROM VIEW_LZ_LISTING_REVISED V WHERE V.LZ_MANIFEST_ID = ".$item_det[0]['LZ_MANIFEST_ID']." AND V.ITEM_ID = ".$item_det[0]['ITEM_ID']." AND ROWNUM = 1) AND DT.E_BAY_CATA_ID_SEG6 NOT IN ('N/A', 'Other', 'OTHER', 'other') ) ORDER BY T.SPECIFIC_NAME");
            $mt_id = $this->db->query("SELECT * FROM CATEGORY_SPECIFIC_MT T  WHERE T.EBAY_CATEGORY_ID = " . $cat_id[0]['E_BAY_CATA_ID_SEG6'] . "  ORDER BY T.SPECIFIC_NAME");
            $mt_id = $mt_id->result_array();

            if (!empty($mt_id[0]['EBAY_CATEGORY_ID'])) {
                // $specs_qry = $this->db->query("SELECT Q1.EBAY_CATEGORY_ID, Q1.SPECIFIC_NAME, DET.SPECIFIC_VALUE, Q1.MAX_VALUE, Q1.MIN_VALUE, Q1.SELECTION_MODE,Q1.MT_ID FROM (SELECT * FROM CATEGORY_SPECIFIC_MT MT WHERE MT.EBAY_CATEGORY_ID = (SELECT DISTINCT  DT.E_BAY_CATA_ID_SEG6 FROM LZ_MANIFEST_DET DT WHERE DT.LAPTOP_ITEM_CODE = (SELECT V.LAPTOP_ITEM_CODE FROM VIEW_LZ_LISTING_REVISED V WHERE V.LZ_MANIFEST_ID = ".$item_det[0]['LZ_MANIFEST_ID']." AND V.ITEM_ID = ".$item_det[0]['ITEM_ID']." AND ROWNUM = 1) AND DT.E_BAY_CATA_ID_SEG6 NOT IN ('N/A', 'Other', 'OTHER', 'other' ) AND ROWNUM = 1 )) Q1, CATEGORY_SPECIFIC_DET DET WHERE Q1.MT_ID = DET.MT_ID ORDER BY Q1.SPECIFIC_NAME");

                $specs_qry = $this->db->query("SELECT Q1.EBAY_CATEGORY_ID, Q1.SPECIFIC_NAME, DET.SPECIFIC_VALUE, Q1.MAX_VALUE, Q1.MIN_VALUE, Q1.SELECTION_MODE,Q1.MT_ID FROM (SELECT * FROM CATEGORY_SPECIFIC_MT MT WHERE MT.EBAY_CATEGORY_ID = (SELECT * FROM (SELECT I.CATEGORY_ID FROM LZ_ITEM_SEED I WHERE I.LZ_MANIFEST_ID =" . $item_det[0]['LZ_MANIFEST_ID'] . " AND I.ITEM_ID = " . $item_det[0]['ITEM_ID'] . " ORDER BY I.SEED_ID DESC) WHERE ROWNUM <= 1)) Q1, CATEGORY_SPECIFIC_DET DET WHERE Q1.MT_ID = DET.MT_ID ORDER BY Q1.SPECIFIC_NAME");

                $specs_qry = $specs_qry->result_array();

                $match_qry = "SELECT  D.LZ_TEST_MT_ID FROM LZ_TEST_CHECK_MT M, LZ_TEST_CHECK_DET D WHERE M.LZ_TEST_MT_ID = D.LZ_TEST_MT_ID AND M.LZ_TEST_MT_ID IN (SELECT DISTINCT D.LZ_TEST_MT_ID FROM LZ_CHECKLIST_DET D, LZ_CHECKLIST_MT M WHERE D.CHECKLIST_MT_ID = (SELECT B.CHECKLIST_MT_ID FROM LZ_CATEGORY_CHECKLIST_BIND B WHERE B.CATEGORY_ID = " . $mt_id[0]['EBAY_CATEGORY_ID'] . " AND ROWNUM = 1) AND D.CHECKLIST_MT_ID = M.CHECKLIST_MT_ID) ORDER BY D.LZ_TEST_MT_ID";
                $match_qry = $this->db->query($match_qry);
                $match_qry = $match_qry->result_array();

                $specs_value = "SELECT MT.SPECIFICS_NAME, DT.SPECIFICS_VALUE,CM.MT_ID FROM LZ_ITEM_SPECIFICS_MT MT, LZ_ITEM_SPECIFICS_DET DT,category_specific_mt cm WHERE MT.SPECIFICS_MT_ID = DT.SPECIFICS_MT_ID and upper(cm.specific_name) = upper(mt.specifics_name) and cm.ebay_category_id = mt.category_id AND MT.ITEM_ID = " . $item_det[0]['ITEM_ID'] . "AND MT.CATEGORY_ID = " . $mt_id[0]['EBAY_CATEGORY_ID'] . "  ORDER BY MT.SPECIFICS_NAME";
                $specs_value = $this->db->query($specs_value);
                $specs_value = $specs_value->result_array();

                return array('specs_qry' => $specs_qry, 'mt_id' => $mt_id, 'item_det' => $item_det, 'cat_id' => $cat_id, 'specs_value' => $specs_value, 'match_qry' => $match_qry);
                // return array("specs_value" => $specs_value);
            } else {

                $result['category_id'] = $cat_id[0]['E_BAY_CATA_ID_SEG6'];
                //var_dump($cat_id[0]['E_BAY_CATA_ID_SEG6']);exit;
                $this->load->view('ebay/trading/item_specifics', $result);
                // $result['data'] = $this->m_tester_model->queryData($perameter);
                // $this->load->view('tester_screen/v_tester_result', $result);
            }

        } else { //category id if else
            return array('error_msg' => true, 'item_det' => $item_det);
        }
    }
    public function attribute_value($cat_id, $barcode, $item_mpn, $item_upc, $spec_name, $custom_attribute)
    {
        $comma = ',';
        $query = $this->db->query("SELECT SPECIFIC_VALUE FROM CATEGORY_SPECIFIC_DET D WHERE D.MT_ID = (SELECT M.MT_ID FROM CATEGORY_SPECIFIC_MT M WHERE M.EBAY_CATEGORY_ID = $cat_id AND UPPER(M.SPECIFIC_NAME) = UPPER('$spec_name')) AND UPPER(SPECIFIC_VALUE) = UPPER('$custom_attribute')");
        if ($query->num_rows() > 0) {
            return false;
        } else {
            $get_mt_id = $this->db->query("SELECT M.MT_ID FROM CATEGORY_SPECIFIC_MT M WHERE M.EBAY_CATEGORY_ID=$cat_id AND UPPER(M.SPECIFIC_NAME)=UPPER('$spec_name')");
            $get_mt_id = $get_mt_id->result_array();
            $mt_id = $get_mt_id[0]['MT_ID'];

            $get_det_pk = $this->db->query("SELECT get_single_primary_key('CATEGORY_SPECIFIC_DET','DET_ID') SPECIFICS_DET_ID FROM DUAL");
            $get_det_pk = $get_det_pk->result_array();
            $specifics_det_id = $get_det_pk[0]['SPECIFICS_DET_ID'];

            $ins_det_qry = "INSERT INTO CATEGORY_SPECIFIC_DET VALUES ($specifics_det_id $comma $mt_id $comma '$custom_attribute')";
            $ins_det_qry = $this->db->query($ins_det_qry);
            return $ins_det_qry;
        }
    }
    // public function get_pictures(){

    // $barocde_no = $this->input->post('barocde_no');
    //  //var_dump($barocde_no['barcodePass']);
    //   //var_dump($barocde_no);
    //  $bar_val = $barocde_no['barcodePass'] ;

    //  //var_dump($bar_val);
    //   //$condition = $this->input->post('condition');

    // $path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 2");
    // $path = $path->result_array();

    // $master_path = $path[0]["MASTER_PATH"];

    // $qry = $this->db->query("SELECT TO_CHAR(FOLDER_NAME) FOLDER_NAME FROM LZ_DEKIT_US_DT WHERE BARCODE_PRV_NO = '$bar_val' UNION ALL SELECT TO_CHAR(FOLDER_NAME) FOLDER_NAME FROM LZ_SPECIAL_LOTS L WHERE L.BARCODE_PRV_NO =  '$bar_val' ")->result_array();

    // $barcode = $qry[0]["FOLDER_NAME"];

    // $dir = $master_path.$barcode."/";//getBarcodePrv_no
    // // $dir = $master_path.$getBarcodePrv_no."/thumb/";
    // // var_dump($dir);exit;
    // $dir = preg_replace("/[\r\n]*/","",$dir);

    // $mdir = $master_path.$barcode."/";
    // //var_dump($dir);exit;
    // $dekitted_pics = [];
    // $parts = [];
    // $uri = [];

    //  //var_dump(is_dir($dir));exit;
    // if (is_dir($dir)){
    //  // var_dump($dir);exit;
    //  $images = glob($dir."\*.{JPG,jpg,GIF,gif,PNG,png,BMP,bmp,JPEG,jpeg}",GLOB_BRACE);
    //  $i=0 ;

    //  foreach($images as $image){
    //    $uri[$i] = $image;
    //    $parts = explode(".", $image);
    //    $img_name = explode("/",$image);
    //    // var_dump($img_name);exit;
    //    $img_n = explode(".",$img_name[4]);
    //    $str = preg_replace('/[^A-Za-z0-9\. -]/', '', $img_name[4]);
    //    $new_string = substr($str,0,1) . "_" . substr($str,1,strlen($str)-1);
    //    // var_dump($new_string);exit;
    //    //$cloudUrl[$i] = "https://res.cloudinary.com/ecologix/image/upload/".$barcode.'/'.$new_string;
    //            // var_dump($cloudUrl);exit;
    //    // var_dump($new_string );exit;
    //            if (is_array($parts) && count($parts) > 1){
    //                $extension = end($parts);
    //                if(!empty($extension)){

    //                 // $live_path = $data['path_query'][0]['LIVE_PATH'];
    //                    $url = $parts['0'].'.'.$extension;

    //                    $url = preg_replace("/[\r\n]*/","",$url);

    //                    // var_dump($url);exit;
    //                    $uri[$i] = $url;
    //                     //var_dump($uri[$i]);exit;
    //                    $img = file_get_contents($url);
    //                     //var_dump($img);exit;
    //                    $img =base64_encode($img);

    //                    $dekitted_pics[$i] = $img;

    //                    $i++;
    //                }
    //            }

    //  }
    // }

    // //var_dump($dekitted_pics);exit;
    // return array('dekitted_pics'=>$dekitted_pics,'parts'=>$parts,'uri'=>$uri);

    // }

    public function update_seed()
    {

        $seedUpc = $this->input->post('seedUpc');
        $seedUpc = trim(str_replace("  ", ' ', $seedUpc));
        $seedUpc = trim(str_replace(array("'"), "''", $seedUpc));

        $seedMpn = $this->input->post('seedMpn');
        $seedMpn = trim(str_replace("  ", ' ', $seedMpn));
        $seedMpn = trim(str_replace(array("'"), "''", $seedMpn));

        $seedBrand = $this->input->post('seedBrand');
        $seedBrand = trim(str_replace("  ", ' ', $seedBrand));
        $seedBrand = trim(str_replace(array("'"), "''", $seedBrand));

        $itemTitle = $this->input->post('itemTitle');
        $itemTitle = trim(str_replace("  ", ' ', $itemTitle));
        $itemTitle = trim(str_replace(array("'"), "''", $itemTitle));

        $itemDesc = $this->input->post('itemDesc');
        //var_dump($itemDesc);
        $itemDesc = trim(str_replace("  ", ' ', $itemDesc));
        $itemDesc = trim(str_replace(array("'"), "''", $itemDesc));
//var_dump($itemDesc);
        $categId = $this->input->post('categId');
        $categId = trim(str_replace("  ", ' ', $categId));
        $categId = trim(str_replace(array("'"), "''", $categId));

        $categName = $this->input->post('categName');
        $categName = trim(str_replace("  ", ' ', $categName));
        $categName = trim(str_replace(array("'"), "''", $categName));

        $defCondDis = $this->input->post('defCondDis');
        $defCondDis = trim(str_replace("  ", ' ', $defCondDis));
        $defCondDis = trim(str_replace(array("'"), "''", $defCondDis));

        $defCond = $this->input->post('defCond');
        $defCond = trim(str_replace("  ", ' ', $defCond));
        $defCond = trim(str_replace(array("'"), "''", $defCond));

        $hidenCond = $this->input->post('hidenCond');

        $price = $this->input->post('price');
        $price = trim(str_replace("  ", ' ', $price));
        $price = trim(str_replace(array("'"), "''", $price));

        $shipServ = $this->input->post('shipServ');
        $shipServ = trim(str_replace("  ", ' ', $shipServ));
        $shipServ = trim(str_replace(array("'"), "''", $shipServ));

        $bin = $this->input->post('bin');

        $editTemp = $this->input->post('editTemp');
        $editTemp = trim(str_replace("  ", ' ', $editTemp));
        $editTemp = trim(str_replace(array("'"), "''", $editTemp));

        $retDay = $this->input->post('retDay');
        $retDay = trim(str_replace("  ", ' ', $retDay));
        $retDay = trim(str_replace(array("'"), "''", $retDay));

        $retAccept = $this->input->post('retAccept');
        $retAccept = trim(str_replace("  ", ' ', $retAccept));
        $retAccept = trim(str_replace(array("'"), "''", $retAccept));

        $otherNote = $this->input->post('otherNote');
        $otherNote = trim(str_replace("  ", ' ', $otherNote));
        $otherNote = trim(str_replace(array("'"), "''", $otherNote));

        date_default_timezone_set("America/Chicago");
        $created_date = date("Y-m-d H:i:s");
        $created_date = "TO_DATE('" . $created_date . "', 'YYYY-MM-DD HH24:MI:SS')";

        $barocde = $this->input->post('barocde');
        $entered_by = $this->input->post('user_id');
        $ebaysite = $this->input->post("ebaysite");
        $bar_query = $this->db->query("SELECT B.LZ_MANIFEST_ID,B.ITEM_ID,B.CONDITION_ID  FROM LZ_BARCODE_MT B WHERE B.BARCODE_NO =$barocde")->result_array();
        $lz_manifest_id = $bar_query[0]['LZ_MANIFEST_ID'];
        $item_id = $bar_query[0]['ITEM_ID'];

        // var_dump($defCond);
        // var_dump($hidenCond);
        $temp = $this->db->query("SELECT I.TEMPLATE_NAME,I.EBAY_LOCAL,I.CURRENCY,I.LIST_TYPE,I.SHIP_FROM_ZIP_CODE,I.SHIP_FROM_LOC,I.PAYMENT_METHOD,I.PAYPAL_EMAIL,I.DISPATCH_TIME_MAX,I.SHIPPING_PAID_BY FROM LZ_ITEM_TEMPLATE I WHERE I.TEMPLATE_ID = $editTemp ")->result_array();

        $ebay_local = $temp[0]['EBAY_LOCAL'];
        $currency = $temp[0]['CURRENCY'];
        $list_type = $temp[0]['LIST_TYPE'];
        $ship_from_zip_code = $temp[0]['SHIP_FROM_ZIP_CODE'];
        $ship_from_loc = $temp[0]['SHIP_FROM_LOC'];
        $payment_method = $temp[0]['PAYMENT_METHOD'];
        $paypal_email = $temp[0]['PAYPAL_EMAIL'];
        $dispatch_time_max = $temp[0]['DISPATCH_TIME_MAX'];
        $shipping_paid_by = $temp[0]['SHIPPING_PAID_BY'];

        if ($defCond !== $hidenCond) {

            $this->db->query("UPDATE LZ_BARCODE_MT SET CONDITION_ID = $defCond  WHERE ITEM_ID = $item_id AND LZ_MANIFEST_ID = $lz_manifest_id AND  CONDITION_ID = $hidenCond AND LIST_ID IS NULL AND SALE_RECORD_NO IS NULL AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND EBAY_ITEM_ID IS NULL");
            //------------------------------------------------------------------------------------------------

            $this->db->query(" UPDATE LZ_ITEM_SEED SET ITEM_ID = $item_id, ITEM_TITLE = '$itemTitle', EBAY_LOCAL= $ebaysite, ITEM_DESC = '$itemDesc', EBAY_PRICE = '$price', TEMPLATE_ID = '$editTemp',CURRENCY = '$currency',LIST_TYPE = '$list_type',CATEGORY_ID = $categId, SHIP_FROM_ZIP_CODE = $ship_from_zip_code,SHIP_FROM_LOC ='$ship_from_loc', DEFAULT_COND = '$defCond',      DETAIL_COND = '$defCondDis',PAYMENT_METHOD='$payment_method',PAYPAL_EMAIL='$paypal_email', BID_LENGTH = NULL, DISPATCH_TIME_MAX=$dispatch_time_max,/*ship cost aditioncost*/ RETURN_OPTION = '$retAccept', RETURN_DAYS = '$retDay',SHIPPING_PAID_BY='$shipping_paid_by',    SHIPPING_SERVICE = '$shipServ',/*qty*/ LZ_MANIFEST_ID = $lz_manifest_id, CATEGORY_NAME = '$categName',/*item sesc long*/ENTERED_BY = '$entered_by',/*aprov date and by*/ DATE_TIME = $created_date,OTHER_NOTES='$otherNote',/*EPID = 1,*/ F_UPC ='$seedUpc',F_MPN='$seedMpn',F_MANUFACTURE='$seedBrand'  WHERE ITEM_ID = $item_id AND LZ_MANIFEST_ID = $lz_manifest_id AND DEFAULT_COND = $defCond");

            return true;
        } else {

            $this->db->query(" UPDATE LZ_ITEM_SEED SET ITEM_ID = $item_id, ITEM_TITLE = '$itemTitle', EBAY_LOCAL= $ebaysite, ITEM_DESC = '$itemDesc', EBAY_PRICE = '$price', TEMPLATE_ID = '$editTemp',CURRENCY = '$currency',LIST_TYPE = '$list_type',CATEGORY_ID = $categId, SHIP_FROM_ZIP_CODE = $ship_from_zip_code,SHIP_FROM_LOC ='$ship_from_loc', DEFAULT_COND = '$defCond',      DETAIL_COND = '$defCondDis',PAYMENT_METHOD='$payment_method',PAYPAL_EMAIL='$paypal_email', BID_LENGTH = NULL, DISPATCH_TIME_MAX=$dispatch_time_max,/*ship cost aditioncost*/ RETURN_OPTION = '$retAccept', RETURN_DAYS = '$retDay',SHIPPING_PAID_BY='$shipping_paid_by',   SHIPPING_SERVICE = '$shipServ',/*qty*/ LZ_MANIFEST_ID = $lz_manifest_id, CATEGORY_NAME = '$categName',/*item sesc long*/ENTERED_BY = '$entered_by',/*aprov date and by*/ DATE_TIME = $created_date,OTHER_NOTES='$otherNote',/*EPID = 1,*/ F_UPC ='$seedUpc',F_MPN='$seedMpn',F_MANUFACTURE='$seedBrand'  WHERE ITEM_ID = $item_id AND LZ_MANIFEST_ID = $lz_manifest_id AND DEFAULT_COND = $defCond");

            return false;
        }

    }

    public function get_avail_cond()
    {

        $catId = $this->input->post('catId');

        $get_cond = $this->db->query("SELECT C.CONDITION_ID,M.COND_NAME FROM LZ_BD_CAT_COND C,LZ_ITEM_COND_MT M WHERE C.CATEGORY_ID = $catId AND C.CONDITION_ID = M.ID")->result_array();
        if (count($get_cond) > 1) {

            return array('get_cond' => $get_cond, 'exist' => true);

        } else {

            $get_cond = $this->db->query('SELECT CC.ID CONDITION_ID,CC.COND_NAME FROM LZ_ITEM_COND_MT CC')->result_array();

            return array('get_cond' => $get_cond, 'exist' => true);

        }

    }

    public function serch_mpn_sys()
    {
        $mpn = strtoupper($this->input->post('passVal'));

        $desc_mpn = "SELECT * FROM (SELECT S.ITEM_TITLE  TITLE, DECODE(S.CATEGORY_ID,NULL,O.CATEGORY_ID,S.CATEGORY_ID) CATE, I.ITEM_MT_MFG_PART_NO MPN, I.ITEM_MT_MANUFACTURE BRAND, I.ITEM_MT_UPC  UPC, I.ITEM_CONDITION COND_NAME, O.OBJECT_NAME OBJECT_NAME FROM LZ_ITEM_SEED S, ITEMS_MT I, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE S.ITEM_ID = I.ITEM_ID AND UPPER(I.ITEM_MT_MFG_PART_NO) = UPPER(C.MPN(+)) AND S.CATEGORY_ID = C.CATEGORY_ID(+) AND C.OBJECT_ID = O.OBJECT_ID(+) and UPPER(I.ITEM_MT_MFG_PART_NO) LIKE '%$mpn%' order by s.seed_id desc ) WHERE ROWNUM <=20";

        $desc_mpn_quer = $this->db->query($desc_mpn)->result_array();

        if (count($desc_mpn_quer) < 1) {

            $desc_mpn = " SELECT * FROM (SELECT DECODE(D.MPN_DESCRIPTION, NULL, C.MPN_DESCRIPTION,D.MPN_DESCRIPTION) TITLE, C.CATEGORY_ID CATE, C.MPN, C.BRAND , C.UPC, CO.COND_NAME, OB.OBJECT_NAME FROM LZ_CATALOGUE_MT C, LZ_BD_ESTIMATE_DET D,LZ_ITEM_COND_MT CO,LZ_BD_OBJECTS_MT OB WHERE D.PART_CATLG_MT_ID = C.CATALOGUE_MT_ID AND D.TECH_COND_ID = CO.ID(+) AND C.OBJECT_ID = OB.OBJECT_ID (+) and UPPER(C.MPN) LIKE '%$mpn%'  ) WHERE  ROWNUM <=20 ";
        }

        $desc_mpn_quer = $this->db->query($desc_mpn)->result_array();

        return array('desc_quer' => $desc_mpn_quer, 'exist' => true);

    }

    public function get_upc_title()
    {

        $upc = strtoupper($this->input->post('passVal'));

        $desc_upc = "SELECT * FROM (SELECT S.ITEM_TITLE  TITLE, DECODE(S.CATEGORY_ID,NULL,O.CATEGORY_ID,S.CATEGORY_ID) CATE, I.ITEM_MT_MFG_PART_NO MPN, I.ITEM_MT_MANUFACTURE BRAND, I.ITEM_MT_UPC  UPC, I.ITEM_CONDITION COND_NAME, O.OBJECT_NAME OBJECT_NAME FROM LZ_ITEM_SEED S, ITEMS_MT I, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE S.ITEM_ID = I.ITEM_ID AND UPPER(I.ITEM_MT_MFG_PART_NO) = UPPER(C.MPN(+)) AND S.CATEGORY_ID = C.CATEGORY_ID(+) AND C.OBJECT_ID = O.OBJECT_ID(+) and UPPER(ITEM_MT_UPC) LIKE '%$upc%' order by s.seed_id desc ) WHERE  ROWNUM <=20 ";

        $desc_upc_quer = $this->db->query($desc_upc)->result_array();

        if (count($desc_upc_quer) < 1) {

            $desc_upc = " SELECT * FROM (SELECT DECODE(D.MPN_DESCRIPTION, NULL, C.MPN_DESCRIPTION,D.MPN_DESCRIPTION) TITLE, C.CATEGORY_ID CATE, C.MPN, C.BRAND , C.UPC, CO.COND_NAME, OB.OBJECT_NAME FROM LZ_CATALOGUE_MT C, LZ_BD_ESTIMATE_DET D,LZ_ITEM_COND_MT CO,LZ_BD_OBJECTS_MT OB WHERE D.PART_CATLG_MT_ID = C.CATALOGUE_MT_ID AND D.TECH_COND_ID = CO.ID(+) AND C.OBJECT_ID = OB.OBJECT_ID (+) and  UPPER(C.UPC) LIKE '%$upc%' ) WHERE  ROWNUM <=20 ";
        }

        $desc_upc_quer = $this->db->query($desc_upc)->result_array();

        return array('desc_quer' => $desc_upc_quer, 'exist' => true);

    }

    public function serch_desc_sys()
    {
        $get_desc = strtoupper(trim($this->input->post('passVal')));

        $str = explode(' ', $get_desc);

        $desc_sys = "SELECT * FROM (SELECT S.ITEM_TITLE  TITLE, DECODE(S.CATEGORY_ID,NULL,O.CATEGORY_ID,S.CATEGORY_ID) CATE, I.ITEM_MT_MFG_PART_NO MPN, I.ITEM_MT_MANUFACTURE BRAND, I.ITEM_MT_UPC  UPC, I.ITEM_CONDITION COND_NAME, O.OBJECT_NAME OBJECT_NAME FROM LZ_ITEM_SEED S, ITEMS_MT I, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE S.ITEM_ID = I.ITEM_ID AND UPPER(I.ITEM_MT_MFG_PART_NO) = UPPER(C.MPN(+)) AND S.CATEGORY_ID = C.CATEGORY_ID(+) AND C.OBJECT_ID = O.OBJECT_ID(+)";

        if (!empty($get_desc)) {
            if (count($str) > 1) {
                $i = 1;
                foreach ($str as $key) {
                    if ($i === 1) {
                        $desc_sys .= " and UPPER(S.ITEM_TITLE) LIKE '%$key%' ";
                    } else {
                        $desc_sys .= " AND UPPER(S.ITEM_TITLE) LIKE '%$key%' ";
                    }
                    $i++;
                }
            } else {
                $desc_sys .= " and UPPER(S.ITEM_TITLE) LIKE '%$get_desc%' ";
            }
        }
        $desc_sys .= "  order by s.seed_id desc ) WHERE ROWNUM <=20 ";

        $desc_sys_quer = $this->db->query($desc_sys)->result_array();

        if (count($desc_sys_quer) < 1) {

            $desc_sys = " SELECT * FROM (SELECT DECODE(D.MPN_DESCRIPTION, NULL, C.MPN_DESCRIPTION,D.MPN_DESCRIPTION) TITLE, C.CATEGORY_ID CATE, C.MPN, C.BRAND , C.UPC, CO.COND_NAME, OB.OBJECT_NAME FROM LZ_CATALOGUE_MT C, LZ_BD_ESTIMATE_DET D,LZ_ITEM_COND_MT CO,LZ_BD_OBJECTS_MT OB WHERE D.PART_CATLG_MT_ID = C.CATALOGUE_MT_ID AND D.TECH_COND_ID = CO.ID(+) AND C.OBJECT_ID = OB.OBJECT_ID (+)  ) WHERE  MPN is not null  ";

            if (!empty($get_desc)) {
                if (count($str) > 1) {
                    $i = 1;
                    foreach ($str as $key) {
                        if ($i === 1) {
                            $desc_sys .= " and UPPER(TITLE) LIKE '%$key%' ";
                        } else {
                            $desc_sys .= " AND UPPER(TITLE) LIKE '%$key%' ";
                        }
                        $i++;
                    }
                } else {
                    $desc_sys .= " and UPPER(TITLE) LIKE '%$get_desc%' ";
                }
            }
            $desc_sys .= "  and ROWNUM <=20 ";
        }
        $desc_sys_quer = $this->db->query($desc_sys)->result_array();

        return array('desc_quer' => $desc_sys_quer, 'exist' => true);

    }

    public function itemDiscard()
    {

        $barcodeNo = $this->input->post('barcodeNo');
        //$barcodeNo = trim(str_replace("  ", ' ', $barcodeNo));
        //$barcodeNo = trim(str_replace(array("'"), "''", $barcodeNo));

        $itemType = $this->input->post('itemType');
        $itemType = trim(str_replace("  ", ' ', $itemType));
        $itemType = trim(str_replace(array("'"), "''", $itemType));

        $idArray = $this->input->post('idArray');

        $upcNum = $this->input->post('upcNum');
        $upcNum = trim(str_replace("  ", ' ', $upcNum));
        $upcNum = trim(str_replace(array("'"), "''", $upcNum));

        $mpnName = $this->input->post('mpnName');
        $mpnName = trim(str_replace("  ", ' ', $mpnName));
        $mpnName = trim(str_replace(array("'"), "''", $mpnName));

        $objName = $this->input->post('objName');
        $objName = trim(str_replace("  ", ' ', $objName));
        $objName = trim(str_replace(array("'"), "''", $objName));

        $catId = $this->input->post('catId');
        $catId = trim(str_replace("  ", ' ', $catId));
        $catId = trim(str_replace(array("'"), "''", $catId));

        $brandName = $this->input->post('brandName');
        $brandName = trim(str_replace("  ", ' ', $brandName));
        $brandName = trim(str_replace(array("'"), "''", $brandName));

        $mpnDesc = $this->input->post('mpnDesc');
        $mpnDesc = trim(str_replace("  ", ' ', $mpnDesc));
        $mpnDesc = trim(str_replace(array("'"), "''", $mpnDesc));

        $remarks = $this->input->post('remarks');
        $remarks = trim(str_replace("  ", ' ', $remarks));
        $remarks = trim(str_replace(array("'"), "''", $remarks));

        $avgSold = $this->input->post('avgSold');
        $avgSold = trim(str_replace("  ", ' ', $avgSold));
        $avgSold = trim(str_replace(array("'"), "''", $avgSold));

        $condRadio = $this->input->post('condRadio');
        $userId = $this->input->post('userId');

        date_default_timezone_set("America/Chicago");
        $date = date('Y-m-d H:i:s');
        $insert_date = "TO_DATE('" . $date . "', 'YYYY-MM-DD HH24:MI:SS')";

        $insert_by = $userId;

        if ($itemType == 'DEKIT ITEM') {

            foreach ($barcodeNo as $child_brcd) {
                $update_dekit = $this->db->query("UPDATE LZ_DEKIT_US_DT SET  IDENT_DATE_TIME = $insert_date, IDENTIFIED_BY = $insert_by, IDENT_REMARKS = '$remarks',AVG_SELL_PRICE = '$avgSold', DISCARD_BY =$insert_by ,DISCARD_DATE=$insert_date, DISCARD = 1 WHERE BARCODE_PRV_NO = $child_brcd");
                // if ($update_dekit) {
                //     $this->db->query("call pro_dekiting_us_pk($child_brcd)");
                // }
            }

        } else if ($itemType == 'SPECIAL LOT') {

            foreach ($barcodeNo as $child_brcd) {

                $update_dekit = $this->db->query("UPDATE LZ_SPECIAL_LOTS SET LOT_REMARKS = '$remarks' ,UPDATED_AT = $insert_date, UPDATED_BY = $insert_by,  AVG_SOLD = '$avgSold', DISCARD_BY =$insert_by , DISCARD_DATE =$insert_date, DISCARD = 1 WHERE BARCODE_PRV_NO = $child_brcd"); // if ($update_dekit) {
                //     $this->db->query("call pro_dekiting_us_pk($child_brcd)");
                // }
            }

        }

        if ($update_dekit) {

            return true;
        } else {
            return false;
        }

    }

    public function verify_item()
    {

        $barcodeNo = $this->input->post('barcodeNo');
        //$barcodeNo = trim(str_replace("  ", ' ', $barcodeNo));
        //$barcodeNo = trim(str_replace(array("'"), "''", $barcodeNo));

        $itemType = $this->input->post('itemType');
        $itemType = trim(str_replace("  ", ' ', $itemType));
        $itemType = trim(str_replace(array("'"), "''", $itemType));

        $idArray = $this->input->post('idArray');

        $upcNum = $this->input->post('upcNum');
        $upcNum = trim(str_replace("  ", ' ', $upcNum));
        $upcNum = trim(str_replace(array("'"), "''", $upcNum));

        $mpnName = $this->input->post('mpnName');
        $mpnName = trim(str_replace("  ", ' ', $mpnName));
        $mpnName = trim(str_replace(array("'"), "''", $mpnName));

        $objName = $this->input->post('objName');
        $objName = trim(str_replace("  ", ' ', $objName));
        $objName = trim(str_replace(array("'"), "''", $objName));

        $catId = $this->input->post('catId');
        $catId = trim(str_replace("  ", ' ', $catId));
        $catId = trim(str_replace(array("'"), "''", $catId));

        $brandName = $this->input->post('brandName');
        $brandName = trim(str_replace("  ", ' ', $brandName));
        $brandName = trim(str_replace(array("'"), "''", $brandName));

        $mpnDesc = $this->input->post('mpnDesc');
        $mpnDesc = trim(str_replace("  ", ' ', $mpnDesc));
        $mpnDesc = trim(str_replace(array("'"), "''", $mpnDesc));

        $remarks = $this->input->post('remarks');
        $remarks = trim(str_replace("  ", ' ', $remarks));
        $remarks = trim(str_replace(array("'"), "''", $remarks));

        $avgSold = $this->input->post('avgSold');
        $avgSold = trim(str_replace("  ", ' ', $avgSold));
        $avgSold = trim(str_replace(array("'"), "''", $avgSold));

        $condRadio = $this->input->post('condRadio');
        $userId = $this->input->post('userId');

        date_default_timezone_set("America/Chicago");
        $date = date('Y-m-d H:i:s');
        $insert_date = "TO_DATE('" . $date . "', 'YYYY-MM-DD HH24:MI:SS')";

        $insert_by = $userId;
        //var_dump($catId);

        $get_obj = $this->db->query("SELECT OB.OBJECT_ID FROM LZ_BD_OBJECTS_MT OB WHERE UPPER(OB.OBJECT_NAME) =upper('$objName') and ob.category_id =$catId ");

        if ($get_obj->num_rows() > 0) {

            $get_obj = $get_obj->result_array();
            $get_obj = $get_obj[0]['OBJECT_ID'];
            $objName = $get_obj;

        } else {
            $obj_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_OBJECTS_MT','OBJECT_ID') OBJECT_ID FROM DUAL");
            $get_mt_pk = $obj_id->result_array();
            $object_id = $get_mt_pk[0]['OBJECT_ID'];

            $this->db->query("INSERT INTO LZ_BD_OBJECTS_MT(OBJECT_ID, OBJECT_NAME,INSERT_DATE,INSERT_BY, CATEGORY_ID) VALUES($object_id, '$objName',$insert_date,$insert_by, $catId)");

            $objName = $object_id;
        }

        // dekit posting code start
        if ($itemType == 'DEKIT ITEM') {
            // var_dump($itemType );
            // exit;
            // $get_sedd_param = $this->db->query("SELECT U.LZ_MANIFEST_ID,U.ITEM_ID,U.CONDITION_ID FROM LZ_BARCODE_MT U WHERE U.BARCODE_NO = $barcodeNo")->result_array();

            // if (count($get_sedd_param) > 0) {
            //     $manif_id = $get_sedd_param[0]['LZ_MANIFEST_ID'];
            //     $item_id = $get_sedd_param[0]['ITEM_ID'];
            //     $cond_id = $get_sedd_param[0]['CONDITION_ID'];

            //     return array('exist' => true, 'posted' => true);

            // } else {

            $mpn_check = $this->db->query("SELECT CATALOGUE_MT_ID, OBJECT_ID,MPN FROM LZ_CATALOGUE_MT WHERE UPPER(MPN) = UPPER('$mpnName') AND CATEGORY_ID = $catId");

            if ($mpn_check->num_rows() == 0) {

                $get_mt_pk = $this->db->query("SELECT get_single_primary_key('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') CATALOGUE_MT_ID FROM DUAL");
                //$get_mt_pk = $this->db->query("SELECT MAX(CATALOGUE_MT_ID + 1) CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT");
                $get_pk = $get_mt_pk->result_array();
                $cat_mt_id = $get_pk[0]['CATALOGUE_MT_ID'];

                $mt_qry = $this->db->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY,OBJECT_ID,MPN_DESCRIPTION,BRAND,UPC) VALUES($cat_mt_id, '$mpnName', $catId, $insert_date, $insert_by,$objName,'$mpnDesc','$brandName','$upcNum')");
                //echo "yes";
            } else {
                $get_pk = $mpn_check->result_array();
                $cat_mt_id = $get_pk[0]['CATALOGUE_MT_ID'];
                $mpn_description = $get_pk[0]['MPN'];
                $object_id = $get_pk[0]['OBJECT_ID'];
                //$get_brand = $get_pk[0]['BRAND'];
                $this->db->query("UPDATE LZ_CATALOGUE_MT SET BRAND = '$brandName' WHERE CATALOGUE_MT_ID =$cat_mt_id ");
            }

            // code section added by adil asad on jan-19-2018 strat
            //*****************************************************
            // foreach ($idArray as $child_brcd) { coment by adil
            //     $update_dekit = $this->db->query("UPDATE LZ_DEKIT_US_DT SET CATALOG_MT_ID = $cat_mt_id, IDENT_DATE_TIME = $insert_date, IDENTIFIED_BY = $insert_by, IDENT_REMARKS = '$remarks', OBJECT_ID = $objName, CONDITION_ID = $condRadio, MPN_DESCRIPTION = '$mpnDesc' ,AVG_SELL_PRICE = '$avgSold'  WHERE LZ_DEKIT_US_DT_ID = $child_brcd");
            //     if ($update_dekit) {
            //         $this->db->query("call pro_dekiting_us_pk($child_brcd)");
            //     }
            // }
            foreach ($barcodeNo as $child_brcd) {
                $update_dekit = $this->db->query("UPDATE LZ_DEKIT_US_DT SET CATALOG_MT_ID = $cat_mt_id, IDENT_DATE_TIME = $insert_date, IDENTIFIED_BY = $insert_by, IDENT_REMARKS = '$remarks', OBJECT_ID = $objName, CONDITION_ID = $condRadio, MPN_DESCRIPTION = '$mpnDesc' ,AVG_SELL_PRICE = '$avgSold'  WHERE BARCODE_PRV_NO = $child_brcd");
                if ($update_dekit) {
                    $this->db->query("call pro_dekiting_us_pk($child_brcd)");
                }
            }

            return array('exist' => true, 'newly post' => true);
            //}

        } else if ($itemType == 'SPECIAL LOT') {
            // var_dump($itemType );
            // exit;

            // $get_sedd_param = $this->db->query("SELECT U.LZ_MANIFEST_ID,U.ITEM_ID,U.CONDITION_ID FROM LZ_BARCODE_MT U WHERE U.BARCODE_NO = $barcodeNo")->result_array();

            // if (count($get_sedd_param) > 0) {
            //     $manif_id = $get_sedd_param[0]['LZ_MANIFEST_ID'];
            //     $item_id = $get_sedd_param[0]['ITEM_ID'];
            //     $cond_id = $get_sedd_param[0]['CONDITION_ID'];

            //     return array('exist' => true, 'posted' => true);

            // } else {

            // inertion bloc
            $weights = $this->db->query("SELECT O.WEIGHT, O.ITEM_COST,O.CATEGORY_ID FROM LZ_BD_OBJECTS_MT O WHERE O.OBJECT_ID = $objName ")->result_array();
            $item_cost = @$weights[0]['ITEM_COST'];
            $item_weight = @$weights[0]['WEIGHT'];
            $category_id = @$weights[0]['CATEGORY_ID'];

            if (empty($item_cost)) {
                $item_cost = 0;
            }
            if (empty($item_weight)) {
                $item_weight = 0;
            }

            $card_mpn = $mpnName;
            $category_id = $catId;
            $user_id = $insert_by;
            $object_desc = $objName;
            $mpn_description = $mpnDesc;
            $brand_name = $brandName;
            $card_upc = $upcNum;
            $dek = $remarks;
            $cond_item = $condRadio;

            $catalogue_mt_id = '';

            if (!empty($card_mpn)) {
                $check_mpn = $this->db->query("SELECT M.CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT M WHERE UPPER(M.MPN) = UPPER('$card_mpn') AND M.CATEGORY_ID = $category_id")->result_array();
                if (count($check_mpn) == 0) {
                    $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT', 'CATALOGUE_MT_ID')ID FROM DUAL");
                    $qry = $qry->result_array();
                    $catalogue_mt_id = $qry[0]['ID'];

                    $insert_mpn = $this->db->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY, OBJECT_ID, MPN_DESCRIPTION, BRAND, UPC) VALUES($catalogue_mt_id, '$card_mpn', $category_id, $insert_date, $user_id, $object_desc, '$mpn_description', '$brand_name', '$card_upc')");
                } else {
                    $catalogue_mt_id = $check_mpn[0]['CATALOGUE_MT_ID'];
                }

            } else {
                /*==================================================
                =            genrate mpn if mpn is null            =
                ==================================================*/

                $get_catalg_id = $this->db->query("SELECT * FROM (SELECT L.CATALOG_MT_ID FROM LZ_SPECIAL_LOTS L WHERE L.CARD_UPC = '$card_upc' AND L.CATALOG_MT_ID IS NOT NULL ORDER BY L.SPECIAL_LOT_ID DESC) WHERE ROWNUM = 1");

                if ($get_catalg_id->num_rows() > 0) {

                    $get_exist_mpn = $get_catalg_id->result_array();
                    $catalogue_mt_id = $get_exist_mpn[0]['CATALOG_MT_ID'];

                } else {
                    $get_mpn = $this->db->query("SELECT MPN_GENERATION($category_id) as MPN FROM DUAL");
                    $get_mpn = $get_mpn->result_array();
                    $get_mpn = $get_mpn[0]['MPN'];

                    $get_mt_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') CATALOGUE_MT_ID FROM DUAL");
                    $get_pk = $get_mt_pk->result_array();
                    $catalogue_mt_id = $get_pk[0]['CATALOGUE_MT_ID'];

                    $mt_qry = $this->db->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY, OBJECT_ID, MPN_DESCRIPTION, BRAND, UPC) VALUES($catalogue_mt_id, '$card_mpn', $category_id, $insert_date, $user_id, $object_desc, '$mpn_description', '$brand_name', '$card_upc')");

                    //$card_mpn = $get_mpn; // assign newly created part no

                } //get_catalg_id else closing
                /*=====  End of genrate mpn if mpn is null  ===*/
            } //end if else !empty($card_mpn)

            $lots_data = $this->db->query("SELECT SPECIAL_LOT_ID,C.CARD_UPC, UPPER(C.CARD_MPN) CARD_MPN, C.CONDITION_ID, C.OBJECT_ID, C.BRAND,C.FOLDER_NAME,C.BIN_ID FROM LZ_SPECIAL_LOTS C WHERE C.barcode_prv_no = $barcodeNo[0]")->result_array();
            $special_lot_id = $lots_data[0]['SPECIAL_LOT_ID'];
            $lot_upc = $lots_data[0]['CARD_UPC'];
            $lot_mpn = $lots_data[0]['CARD_MPN'];
            $lot_condition_id = $lots_data[0]['CONDITION_ID'];
            $lot_object_id = $lots_data[0]['OBJECT_ID'];
            $lot_brand = $lots_data[0]['BRAND'];
            $folder_name = $lots_data[0]['FOLDER_NAME'];
            $current_bin = $lots_data[0]['BIN_ID'];

            // if(!empty($current_bin)){
            //    = "";
            // }else{
            //    =",BIN_ID =".$bin_rack;
            // }

            if ($lot_upc != '' && $lot_mpn == '') {

                $with_upcs = $this->db->query("SELECT * FROM LZ_SPECIAL_LOTS LS WHERE LS.CARD_UPC = '$card_upc' AND LS.CARD_MPN IS NULL AND LS.LZ_MANIFEST_DET_ID IS NULL")->result_array();
                if (count($with_upcs) > 1) {
                    $insert_est_det = $this->db->query("UPDATE LZ_SPECIAL_LOTS SET OBJECT_ID = $object_desc ,CARD_CATEGORY_ID = '$category_id', LOT_REMARKS = '$dek' , WEIGHT = '$item_weight',CONDITION_ID = $cond_item,CARD_UPC = '$card_upc', CARD_MPN = '$card_mpn', CATALOG_MT_ID = '$catalogue_mt_id', MPN_DESCRIPTION = '$mpn_description', BRAND = '$brand_name', UPDATED_AT = $insert_date, UPDATED_BY = $user_id, ITEM_COST = '$item_cost' , AVG_SOLD = '$avgSold'  WHERE CARD_UPC = '$lot_upc' AND CARD_MPN IS NULL AND LZ_MANIFEST_DET_ID IS NULL");
                    if ($insert_est_det) {
                        $flag = 1;

                    } else {
                        $flag = 0;

                    }

                } else {
                    $insert_est_det = $this->db->query("UPDATE LZ_SPECIAL_LOTS SET OBJECT_ID = $object_desc ,CARD_CATEGORY_ID = '$category_id', LOT_REMARKS = '$dek' , WEIGHT = '$item_weight',CONDITION_ID = $cond_item, CARD_UPC = '$card_upc' ,CARD_MPN = '$card_mpn', CATALOG_MT_ID = '$catalogue_mt_id', MPN_DESCRIPTION = '$mpn_description', BRAND = '$brand_name', UPDATED_AT = $insert_date, UPDATED_BY = $user_id, ITEM_COST = '$item_cost' , AVG_SOLD = '$avgSold' WHERE SPECIAL_LOT_ID = $special_lot_id");
                    if ($insert_est_det) {
                        $flag = 1;
                    } else {
                        $flag = 0;

                    }
                }
            } elseif ($lot_mpn != '' && $lot_upc == '') {

                $with_upcs = $this->db->query("SELECT * FROM LZ_SPECIAL_LOTS LS WHERE LS.CARD_UPC IS NULL AND UPPER(LS.CARD_MPN) = '$card_mpn' AND LS.LZ_MANIFEST_DET_ID IS NULL")->result_array();
                if (count($with_upcs) > 1) {
                    $insert_est_det = $this->db->query("UPDATE LZ_SPECIAL_LOTS SET OBJECT_ID = $object_desc , CARD_CATEGORY_ID = '$category_id',LOT_REMARKS = '$dek' , WEIGHT = '$item_weight',CONDITION_ID = $cond_item,CARD_UPC = '$card_upc', CARD_MPN = '$card_mpn', CATALOG_MT_ID = '$catalogue_mt_id', MPN_DESCRIPTION = '$mpn_description', BRAND = '$brand_name', UPDATED_AT = $insert_date, UPDATED_BY = $user_id, ITEM_COST = '$item_cost'  , AVG_SOLD = '$avgSold'  WHERE CARD_UPC IS NULL AND UPPER(CARD_MPN) = '$lot_mpn' AND LZ_MANIFEST_DET_ID IS NULL");
                    if ($insert_est_det) {
                        $flag = 1;

                    } else {
                        $flag = 0;

                    }

                } else {
                    $insert_est_det = $this->db->query("UPDATE LZ_SPECIAL_LOTS SET OBJECT_ID = $object_desc ,CARD_CATEGORY_ID = '$category_id', LOT_REMARKS = '$dek' , WEIGHT = '$item_weight',CONDITION_ID = $cond_item, CARD_UPC = '$card_upc' ,CARD_MPN = '$card_mpn', CATALOG_MT_ID = '$catalogue_mt_id', MPN_DESCRIPTION = '$mpn_description', BRAND = '$brand_name', UPDATED_AT = $insert_date, UPDATED_BY = $user_id, ITEM_COST = '$item_cost' , AVG_SOLD = '$avgSold' WHERE SPECIAL_LOT_ID = $special_lot_id");
                    if ($insert_est_det) {
                        $flag = 1;
                    } else {
                        $flag = 0;

                    }
                }
            } elseif ($lot_mpn != '' && $lot_upc != '') {

                $with_upcs = $this->db->query("SELECT * FROM LZ_SPECIAL_LOTS LS WHERE LS.CARD_UPC = '$card_upc' AND UPPER(LS.CARD_MPN) = '$card_mpn' AND LS.LZ_MANIFEST_DET_ID IS NULL")->result_array();
                if (count($with_upcs) > 1) {
                    $insert_est_det = $this->db->query("UPDATE LZ_SPECIAL_LOTS SET OBJECT_ID = $object_desc ,CARD_CATEGORY_ID = '$category_id', LOT_REMARKS = '$dek' , WEIGHT = '$item_weight',CONDITION_ID = $cond_item,CARD_UPC = '$card_upc', CARD_MPN = '$card_mpn', CATALOG_MT_ID = '$catalogue_mt_id', MPN_DESCRIPTION = '$mpn_description', BRAND = '$brand_name', UPDATED_AT = $insert_date, UPDATED_BY = $user_id, ITEM_COST = '$item_cost' , AVG_SOLD = '$avgSold' WHERE CARD_UPC = '$lot_upc' AND UPPER(CARD_MPN) = '$lot_mpn'AND LZ_MANIFEST_DET_ID IS NULL");
                    if ($insert_est_det) {
                        $flag = 1;

                    } else {
                        $flag = 0;

                    }

                } else {
                    $insert_est_det = $this->db->query("UPDATE LZ_SPECIAL_LOTS SET OBJECT_ID = $object_desc ,CARD_CATEGORY_ID = '$category_id', LOT_REMARKS = '$dek' , WEIGHT = '$item_weight',CONDITION_ID = $cond_item, CARD_UPC = '$card_upc' ,CARD_MPN = '$card_mpn', CATALOG_MT_ID = '$catalogue_mt_id', MPN_DESCRIPTION = '$mpn_description', BRAND = '$brand_name', UPDATED_AT = $insert_date, UPDATED_BY = $user_id, ITEM_COST = '$item_cost', AVG_SOLD = '$avgSold'  WHERE SPECIAL_LOT_ID = $special_lot_id");
                    if ($insert_est_det) {
                        $flag = 1;
                    } else {
                        $flag = 0;
                    }
                }
            } else {
                $insert_est_det = $this->db->query("UPDATE LZ_SPECIAL_LOTS SET OBJECT_ID = $object_desc , CARD_CATEGORY_ID = '$category_id',LOT_REMARKS = '$dek' , WEIGHT = '$item_weight',CONDITION_ID = $cond_item, CARD_UPC = '$card_upc' ,CARD_MPN = '$card_mpn', CATALOG_MT_ID = '$catalogue_mt_id', MPN_DESCRIPTION = '$mpn_description', BRAND = '$brand_name', UPDATED_AT = $insert_date, UPDATED_BY = $user_id, ITEM_COST = '$item_cost',AVG_SOLD = '$avgSold' WHERE SPECIAL_LOT_ID = $special_lot_id");
                if ($insert_est_det) {
                    $flag = 1;
                } else {
                    $flag = 0;

                }
            }
            //}
            /*================================================================
            =            update all barcode with same folder name            =
            ================================================================*/
            $insert_est_det = $this->db->query("UPDATE LZ_SPECIAL_LOTS SET OBJECT_ID = $object_desc , CARD_CATEGORY_ID = '$category_id',LOT_REMARKS = '$dek' , WEIGHT = '$item_weight',CONDITION_ID = $cond_item, CARD_UPC = '$card_upc' ,CARD_MPN = '$card_mpn', CATALOG_MT_ID = '$catalogue_mt_id', MPN_DESCRIPTION = '$mpn_description', BRAND = '$brand_name', UPDATED_AT = $insert_date, UPDATED_BY = $user_id, ITEM_COST = '$item_cost', AVG_SOLD = '$avgSold' WHERE FOLDER_NAME = $folder_name AND LZ_MANIFEST_DET_ID IS NULL");
            if ($insert_est_det) {
                $flag = 1;
            } else {
                $flag = 0;

            }

            if (!empty($card_upc) and !empty($card_mpn)) {

                $querys = $this->db->query("call PRO_SINGLE_INSERT_LOTS('=''$card_upc''' ,  '=''$card_mpn''', $user_id) ");

            } elseif (!empty($card_upc) and empty($card_mpn)) {
                $querys = $this->db->query("call PRO_SINGLE_INSERT_LOTS('=''$card_upc''' , ' IS NULL', $user_id) ");

            } elseif (empty($card_upc) and !empty($card_mpn)) {
                $querys = $this->db->query("call PRO_SINGLE_INSERT_LOTS(' IS NULL' , '=''$card_mpn''', $user_id) ");

            } elseif (empty($card_upc) and empty($card_mpn)) {
                die('UPC and Mpn is required');
            }

            if ($querys) {
                $flag = 1;
                return array('exist' => true, 'newly post' => true, 'flag' => $flag);
            } else {
                $flag = 0;
                return array('exist' => true, 'newly post' => true, 'flag' => $flag);
            }

            // end insertion block
            //}

        }
        // dekit posting code end
    }
    public function get_verify_item()
    {
        // /117001
        $barcode = $this->uri->segment(4);

        $get_items = $this->db->query("SELECT * FROM (SELECT 'DEKIT ITEM' BAROCDE_TYPE, DECODE(D.LZ_MANIFEST_DET_ID ,NULL,'PENDING','POSTED') VERIFY_ITEM, D.LZ_DEKIT_US_DT_ID, D.BARCODE_PRV_NO, C.COND_NAME, C.ID, O.OBJECT_NAME,O.OBJECT_ID, D.PIC_DATE_TIME, D.PIC_BY, D.PIC_NOTES, DECODE(D.MPN_DESCRIPTION, NULL, CA.MPN_DESCRIPTION, D.MPN_DESCRIPTION) MPN_DESC, CA.MPN, CA.UPC, CA.BRAND, TO_CHAR(D.FOLDER_NAME) FOLDER_NAME, D.DEKIT_REMARKS REMARKS, D.LZ_MANIFEST_DET_ID, CA.CATEGORY_ID, TO_CHAR(D.AVG_SELL_PRICE) AVG_PRIC FROM LZ_DEKIT_US_DT   D, LZ_BD_OBJECTS_MT O, LZ_CATALOGUE_MT  CA, LZ_ITEM_COND_MT  C WHERE D.OBJECT_ID = O.OBJECT_ID(+) AND D.CATALOG_MT_ID = CA.CATALOGUE_MT_ID(+) AND D.CONDITION_ID = C.ID(+) UNION ALL SELECT 'SPECIAL LOT' BAROCDE_TYPE, DECODE(L.LZ_MANIFEST_DET_ID,NULL,'PENDING','POSTED') VERIFY_ITEM, L.SPECIAL_LOT_ID, L.BARCODE_PRV_NO, C.COND_NAME, C.ID, OB.OBJECT_NAME,OB.OBJECT_ID, L.PIC_DATE_TIME, L.PIC_BY, L.PIC_NOTES, DECODE(L.MPN_DESCRIPTION, NULL, CA.MPN_DESCRIPTION, L.MPN_DESCRIPTION) MPN_DESC, DECODE(L.CARD_MPN, NULL, CA.MPN, L.CARD_MPN) MPN, DECODE(L.CARD_UPC, NULL, CA.UPC, L.CARD_UPC) UPC, DECODE(L.BRAND, NULL, CA.BRAND, L.BRAND) BRAND, TO_CHAR(L.FOLDER_NAME) FOLDER_NAME, L.LOT_REMARKS REMARKS, L.LZ_MANIFEST_DET_ID, CA.CATEGORY_ID, TO_CHAR(l.AVG_SOLD) AVG_PRIC FROM LZ_SPECIAL_LOTS  L, LZ_BD_OBJECTS_MT OB, LZ_ITEM_COND_MT  C, LZ_CATALOGUE_MT  CA WHERE L.OBJECT_ID = OB.OBJECT_ID(+) AND L.CONDITION_ID = C.ID(+) AND L.CATALOG_MT_ID = CA.CATALOGUE_MT_ID(+) ORDER BY LZ_MANIFEST_DET_ID  NULLS FIRST) WHERE BARCODE_PRV_NO ='$barcode' and ROWNUM <= 150  ")->result_array();

        $get_cond = $this->db->query('SELECT CC.ID CONDITION_ID,CC.COND_NAME FROM LZ_ITEM_COND_MT CC')->result_array();

        if (count($get_items) >= 1) {
            //var_dump('helllo');

            //$get_items = $query->result_array();
            $barocde_type = $get_items[0]['BAROCDE_TYPE'];

            if ($barocde_type == 'DEKIT ITEM') {

                $run_mast = $this->db->query("SELECT M.BARCODE_NO MASTER_BARCODE FROM LZ_DEKIT_US_MT M ,LZ_DEKIT_US_DT D WHERE M.LZ_DEKIT_US_MT_ID  = D.LZ_DEKIT_US_MT_ID AND D.BARCODE_PRV_NO = '$barcode' ")->result_array();

                $get_master_barc = $run_mast[0]['MASTER_BARCODE'];

                $run_master_bar_query = $this->db->query("SELECT B.BARCODE_NO,C.COND_NAME,I.ITEM_DESC,I.ITEM_MT_MANUFACTURE,I.ITEM_MT_MFG_PART_NO FROM LZ_BARCODE_MT B, ITEMS_MT I,LZ_ITEM_COND_MT C WHERE B.BARCODE_NO = '$get_master_barc' AND B.CONDITION_ID = C.ID(+) AND B.ITEM_ID = I.ITEM_ID")->result_array();
            } else {
                $run_master_bar_query = null;
            }

            $seed_avail = $this->db->query("SELECT * FROM LZ_BARCODE_MT WHERE BARCODE_NO = $barcode ")->result_array();

            if (count($seed_avail) >= 1) {
                return array('get_items' => $get_items, 'get_cond' => $get_cond, 'run_master_bar_query' => $run_master_bar_query, 'exist' => true, 'seed_avail' => true);

            } else {
                return array('get_items' => $get_items, 'get_cond' => $get_cond, 'run_master_bar_query' => $run_master_bar_query, 'exist' => true, 'seed_avail' => false);

            }

        } else {

            return array('get_items' => $get_items, 'exist' => false);
        }

        return $barcode; //var_dump($barcode);
        //exit;

    }

    public function merch_lot_dash()
    {
        $merchId = $this->input->post('merchId');

        $merchLotData = $this->db->query("SELECT LOT_ID,
       MAX(REF_NO) REF_NO,
       MAX(LOT_DESCRIPTION) LOT_DESCRIPTION,
       MAX(CREATION_DATE) CREATION_DATE,
       MAX(LOT_COST) LOT_COST,
       COUNT(LOT_COUNT) LOT_COUNT,
       COUNT(EBAY_ITEM_ID) TOTAL_LISTED,
       SUM(LIST_VAL) TOTAL_LIST_AMOUNT,
       COUNT(EBAY_ITEM_ID) - COUNT(ORDER_ID) ACTIV_LISTED,
       SUM(LIST_VAL) - SUM(SOLD_VALUE) ACTIV_LIST_AMOUNT,
       COUNT(ORDER_ID) TOTAL_SOLD,
       NVL(SUM(SOLD_VALUE), 0) SOLD_AMOUNT,
       round(NVL(SUM(PIC_CHARGE) + SUM(LIST_CHARGE) + SUM(PACK_PULL_CHARGE), 0),2) LJ_CHARGES,
       NVL(SUM(EXPENSE), 0) EXPENSES,
       NVL(SUM(EXPENSE), 0) +
       round(NVL(SUM(PIC_CHARGE) + SUM(LIST_CHARGE) + SUM(PACK_PULL_CHARGE), 0),2) CHRG_OR_EXPENS,
       /*NVL(SUM(SOLD_VALUE), 0) -
       (NVL(SUM(PIC_CHARGE) + SUM(LIST_CHARGE) + SUM(PACK_PULL_CHARGE), 0) +
        NVL(SUM(EXPENSE), 0)) NET_EARNING*/
        NVL(SUM(LIST_VAL), 0) -
       (NVL(SUM(PIC_CHARGE) + SUM(LIST_CHARGE) + SUM(PACK_PULL_CHARGE), 0) +
        NVL(SUM(EXPENSE), 0)) projected_earning
  FROM (SELECT M.LOT_ID,
               B.EBAY_ITEM_ID,

               M.NO_OF_BARCODE,
               (SELECT NVL(SD.EBAY_PRICE, 0)
                  FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD
                 WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID
                   AND MM.ITEM_ID = SD.ITEM_ID
                   AND MM.CONDITION_ID = SD.DEFAULT_COND
                   AND MM.BARCODE_NO = B.BARCODE_NO
                   AND B.EBAY_ITEM_ID IS NOT NULL) LIST_VAL,
               (SELECT NVL(SD.EBAY_PRICE, 0)
                  FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD
                 WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID
                   AND MM.ITEM_ID = SD.ITEM_ID
                   AND MM.CONDITION_ID = SD.DEFAULT_COND
                   AND MM.BARCODE_NO = B.BARCODE_NO
                   AND B.EBAY_ITEM_ID IS NOT NULL
                   AND B.ORDER_ID IS NOT NULL) SOLD_VALUE,
               (SELECT NVL(BIL.CHARGES, 0)
                  FROM LJ_BARCODE_BILLING BIL
                 WHERE BIL.BARCODE_NO = L.BARCODE_PRV_NO /*B.BARCODE_NO*/
                   AND BIL.SER_RATE_ID = 1) PIC_CHARGE, /*PIC SERVICE CHARGE*/
               (SELECT NVL(BIL.CHARGES, 0)
                  FROM LJ_BARCODE_BILLING BIL, LZ_BARCODE_MT BAR
                 WHERE BIL.BARCODE_NO = B.BARCODE_NO
                   AND BIL.BARCODE_NO = BAR.BARCODE_NO
                   AND BIL.SER_RATE_ID = 2
                   AND BAR.EBAY_ITEM_ID IS NOT NULL) LIST_CHARGE, /*LIST SERVICE CHARGE*/
               (SELECT NVL(BIL.CHARGES, 0)
                  FROM LJ_BARCODE_BILLING BIL, LZ_BARCODE_MT BAR
                 WHERE BIL.BARCODE_NO = B.BARCODE_NO
                   AND BIL.BARCODE_NO = BAR.BARCODE_NO
                   AND BIL.SER_RATE_ID = 6
                   AND BAR.EBAY_ITEM_ID IS NOT NULL) BIN_STORAGE_CHARGE, /*BIN STORAGE SERVICE CHARGE*/
               (SELECT NVL(BIL.CHARGES, 0)
                  FROM LJ_BARCODE_BILLING BIL, LZ_BARCODE_MT BAR
                 WHERE BIL.BARCODE_NO = B.BARCODE_NO
                   AND BIL.BARCODE_NO = BAR.BARCODE_NO
                   AND BIL.SER_RATE_ID = 7
                   AND BAR.EBAY_ITEM_ID IS NOT NULL) PACK_PULL_CHARGE, /*PACK AND PULL STORAGE SERVICE CHARGE*/
               round((SELECT NVL(SUM(OD.PACKING_COST) +
                           NVL(MAX(OM.SHIPING_LABEL_RATE), 0) +
                           NVL(MAX(OM.EBAY_FEE), 0) +
                           NVL((7 / 100) *
                               NVL(MAX(OM.SALE_PRICE * OM.QTY), 0),
                               0),
                           0)
                  FROM LJ_ORDER_PACKING_MT OM, LJ_ORDER_PACKING_DT OD
                 WHERE OM.ORDER_PACKING_ID = OD.ORDER_PACKING_ID
                   AND OM.ORDER_ID = B.ORDER_ID
                 GROUP BY OD.ORDER_PACKING_ID) /
               (SELECT NVL(MAX(OM.QTY), 0)
                  FROM LJ_ORDER_PACKING_MT OM, LJ_ORDER_PACKING_DT OD
                 WHERE OM.ORDER_PACKING_ID = OD.ORDER_PACKING_ID
                   AND OM.ORDER_ID = B.ORDER_ID
                 GROUP BY OD.ORDER_PACKING_ID),2) EXPENSE,
               (SELECT NVL(MAX(OM.QTY), 0)
                  FROM LJ_ORDER_PACKING_MT OM, LJ_ORDER_PACKING_DT OD
                 WHERE OM.ORDER_PACKING_ID = OD.ORDER_PACKING_ID
                   AND OM.ORDER_ID = B.ORDER_ID
                 GROUP BY OD.ORDER_PACKING_ID) QTY,
               MD.REF_NO REF_NO,
               MD.LOT_DESC LOT_DESCRIPTION,
               MD.ASSIGN_DATE CREATION_DATE,
               MD.COST LOT_COST,
               D.BARCODE_NO LOT_COUNT,
               B.ORDER_ID,
               B.SALE_RECORD_NO
          FROM LOT_DEFINATION_MT      MD,
               LZ_MERCHANT_BARCODE_MT M,
               LZ_MERCHANT_BARCODE_DT D,
               LZ_SPECIAL_LOTS        L,
               LZ_BARCODE_MT          B
         WHERE M.MT_ID = D.MT_ID
           AND MD.LOT_ID = M.LOT_ID
           AND D.BARCODE_NO = L.BARCODE_PRV_NO(+)
           AND L.BARCODE_PRV_NO = B.BARCODE_NO(+)
           AND M.MERCHANT_ID = $merchId)
 GROUP BY LOT_ID
")->result_array();

        if (count($merchLotData) >= 1) {
            return array('merchLotData' => $merchLotData, 'exist' => true);
        } else {
            return array('merchLotData' => $merchLotData, 'exist' => false);
        }

    }

    public function merch_lot_detail_view()
    {

        $getSeach = strtoupper($this->input->post('getSeach'));
        $recntSold = strtoupper($this->input->post('recntSold'));

        //$recntSold = strtoupper($this->input->post('recntSold'));
        //var_dump($recntSold);
        // exit;

        $getSeach = trim(str_replace("  ", ' ', $getSeach));
        $getSeach = str_replace(array("`,′"), "", $getSeach);
        $getSeach = str_replace(array("'"), "''", $getSeach);

        $priceOne = strtoupper($this->input->post('priceOne'));
        $priceOne = trim(str_replace("  ", ' ', $priceOne));
        $priceOne = str_replace(array("`,′"), "", $priceOne);
        $priceOne = str_replace(array("'"), "''", $priceOne);

        $priceTwo = strtoupper($this->input->post('priceTwo'));
        $priceTwo = trim(str_replace("  ", ' ', $priceTwo));
        $priceTwo = str_replace(array("`,′"), "", $priceTwo);
        $priceTwo = str_replace(array("'"), "''", $priceTwo);

        $merLotName = strtoupper($this->input->post('merLotName'));
        $merchId = strtoupper($this->input->post('merchId'));
        $str = explode(' ', $getSeach);
        //var_dump($getSeach);

        $lot_name = $this->db->query("SELECT M.LOT_ID, M.LOT_DESC ||'  ('|| M.REF_NO ||')' LOT_DESC FROM LOT_DEFINATION_MT M WHERE M.MERCHANT_ID  =$merchId ")->result_array();

        $sqlOne = "SELECT LOT_ID, MAX(REF_NO) REF_NO, MAX(LOT_DESCRIPTION) LOT_DESCRIPTION, MAX(CREATION_DATE) CREATION_DATE, MAX(LOT_COST) LOT_COST, COUNT(LOT_COUNT) LOT_COUNT, COUNT(EBAY_ITEM_ID) TOTAL_LISTED, SUM(LIST_VAL) TOTAL_LIST_AMOUNT, COUNT(EBAY_ITEM_ID) - COUNT(ORDER_ID) ACTIV_LISTED,  SUM(nvl(LIST_VAL,0)) - SUM(nvl(SOLD_VALUE,0)) ACTIV_LIST_AMOUNT, COUNT(ORDER_ID) TOTAL_SOLD, NVL(SUM(SOLD_VALUE), 0) SOLD_AMOUNT, round(NVL(SUM(PIC_CHARGE) + SUM(LIST_CHARGE) + SUM(PACK_PULL_CHARGE), 0),2) LJ_CHARGES, NVL(SUM(EXPENSE), 0) EXPENSES, NVL(SUM(EXPENSE), 0) + round(NVL(SUM(PIC_CHARGE) + SUM(LIST_CHARGE) + SUM(PACK_PULL_CHARGE), 0),2) CHRG_OR_EXPENS, /*NVL(SUM(SOLD_VALUE), 0) - (NVL(SUM(PIC_CHARGE) + SUM(LIST_CHARGE) + SUM(PACK_PULL_CHARGE), 0) + NVL(SUM(EXPENSE), 0)) NET_EARNING*/ NVL(SUM(LIST_VAL), 0) - (NVL(SUM(PIC_CHARGE) + SUM(LIST_CHARGE) + SUM(PACK_PULL_CHARGE), 0) + NVL(SUM(EXPENSE), 0)) projected_earning FROM (SELECT * FROM (SELECT M.LOT_ID, B.EBAY_ITEM_ID, M.NO_OF_BARCODE, (SELECT NVL(SD.EBAY_PRICE, 0) FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO AND B.EBAY_ITEM_ID IS NOT NULL) LIST_VAL, OM.SALE_PRICE /*(SELECT NVL(SD.EBAY_PRICE, 0) FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO AND B.EBAY_ITEM_ID IS NOT NULL AND B.ORDER_ID IS NOT NULL)*/ SOLD_VALUE, (SELECT NVL(BIL.CHARGES, 0) FROM LJ_BARCODE_BILLING BIL WHERE BIL.BARCODE_NO = L.BARCODE_PRV_NO /*B.BARCODE_NO*/ AND BIL.SER_RATE_ID = 1) PIC_CHARGE, /*PIC SERVICE CHARGE*/ (SELECT NVL(BIL.CHARGES, 0) FROM LJ_BARCODE_BILLING BIL, LZ_BARCODE_MT BAR WHERE BIL.BARCODE_NO = B.BARCODE_NO AND BIL.BARCODE_NO = BAR.BARCODE_NO AND BIL.SER_RATE_ID = 2 AND BAR.EBAY_ITEM_ID IS NOT NULL) LIST_CHARGE, /*LIST SERVICE CHARGE*/ (SELECT NVL(BIL.CHARGES, 0) FROM LJ_BARCODE_BILLING BIL, LZ_BARCODE_MT BAR WHERE BIL.BARCODE_NO = B.BARCODE_NO AND BIL.BARCODE_NO = BAR.BARCODE_NO AND BIL.SER_RATE_ID = 6 AND BAR.EBAY_ITEM_ID IS NOT NULL) BIN_STORAGE_CHARGE, /*BIN STORAGE SERVICE CHARGE*/ (SELECT NVL(BIL.CHARGES, 0) FROM LJ_BARCODE_BILLING BIL, LZ_BARCODE_MT BAR WHERE BIL.BARCODE_NO = B.BARCODE_NO AND BIL.BARCODE_NO = BAR.BARCODE_NO AND BIL.SER_RATE_ID = 7 AND BAR.EBAY_ITEM_ID IS NOT NULL) PACK_PULL_CHARGE, /*PACK AND PULL STORAGE SERVICE CHARGE*/ round((SELECT NVL(SUM(OD.PACKING_COST) + NVL(MAX(OM.SHIPING_LABEL_RATE), 0) + NVL(MAX(OM.EBAY_FEE), 0) + NVL((7 / 100) * NVL(MAX(OM.SALE_PRICE * OM.QTY), 0), 0), 0) FROM LJ_ORDER_PACKING_MT OM, LJ_ORDER_PACKING_DT OD WHERE OM.ORDER_PACKING_ID = OD.ORDER_PACKING_ID AND OM.ORDER_ID = B.ORDER_ID GROUP BY OD.ORDER_PACKING_ID) / (SELECT NVL(MAX(OM.QTY), 0) FROM LJ_ORDER_PACKING_MT OM, LJ_ORDER_PACKING_DT OD WHERE OM.ORDER_PACKING_ID = OD.ORDER_PACKING_ID AND OM.ORDER_ID = B.ORDER_ID GROUP BY OD.ORDER_PACKING_ID),2) EXPENSE, (SELECT NVL(MAX(OM.QTY), 0) FROM LJ_ORDER_PACKING_MT OM, LJ_ORDER_PACKING_DT OD WHERE OM.ORDER_PACKING_ID = OD.ORDER_PACKING_ID AND OM.ORDER_ID = B.ORDER_ID GROUP BY OD.ORDER_PACKING_ID) QTY, MD.REF_NO REF_NO, MD.LOT_DESC LOT_DESCRIPTION, MD.ASSIGN_DATE CREATION_DATE, MD.COST LOT_COST, D.BARCODE_NO LOT_COUNT, B.ORDER_ID, B.SALE_RECORD_NO FROM LOT_DEFINATION_MT      MD, LZ_MERCHANT_BARCODE_MT M, LZ_MERCHANT_BARCODE_DT D, LZ_SPECIAL_LOTS        L, LZ_BARCODE_MT          B, lz_item_seed           s, lj_order_packing_mt    om WHERE M.MT_ID = D.MT_ID AND MD.LOT_ID = M.LOT_ID AND D.BARCODE_NO = L.BARCODE_PRV_NO(+) AND L.BARCODE_PRV_NO = B.BARCODE_NO(+) and b.item_id = s.item_id(+) and b.lz_manifest_id = s.lz_manifest_id(+) and b.condition_id = s.default_cond(+) and b.order_id = om.order_id(+) AND M.MERCHANT_ID =$merchId ";

        if (!empty($getSeach)) {
            if (count($str) > 1) {
                $i = 1;
                foreach ($str as $key) {
                    if ($i === 1) {
                        $sqlOne .= " and (UPPER(S.ITEM_TITLE) LIKE '%$key%' ";
                    } else {
                        $sqlOne .= " AND UPPER(S.ITEM_TITLE) LIKE '%$key%' ";
                    }
                    $i++;
                }
            } else {
                $sqlOne .= " and (UPPER(S.ITEM_TITLE) LIKE '%$getSeach%' ";
            }

            $sqlOne .= " OR UPPER(B.BARCODE_NO) LIKE '%$getSeach%'
        OR UPPER(OM.SALE_RECRD_NUM) LIKE '%$getSeach%'
        OR UPPER(OM.BUYER_NAME) LIKE '%$getSeach%'
           OR UPPER(B.EBAY_ITEM_ID) LIKE '%$getSeach%' )";
            //OR UPPER(OM.SALE_PRICE) LIKE '%$getSeach%') ";
        }

        if (!empty($merLotName)) {
            $sqlOne .= " and M.lot_id = $merLotName ";
        }

        if (!empty($priceOne) && !empty($priceTwo)) {

            $sqlOne .= " AND OM.SALE_PRICE BETWEEN  $priceOne AND $priceTwo ";

        }

        if (!empty($recntSold)) {

            $sqlOne .= "AND B.ORDER_ID IS NOT NULL
           order by om.sale_date desc)
           where rownum<=$recntSold";
        } else {
            $sqlOne .= " ) ";

        }

        $sqlOne .= " ) GROUP BY LOT_ID";

        $lot_detail_query = $this->db->query($sqlOne)->result_array();

        $sqlTwo = " SELECT COUNT(BARCODE_NO) TOT_BARC, COUNT(PIC_DATE_TIME) PICTURS_DONE, COUNT(LZ_MANIFEST_DET_ID) BARCODE_CREATED, COUNT(EBAY_ITEM_ID) - COUNT(SALE_RECORD_NO) ACTIVE_LISTED, COUNT(LZ_MANIFEST_DET_ID) - COUNT(EBAY_ITEM_ID) - COUNT(OUTT) NOT_LISTED, COUNT(SALE_RECORD_NO) SOLD, ROUND(NVL(SUM(TOTAL_VAL), 0), 2) PROCESED_QTY_VAL,
  round(SUM(nvl(LIST_VAL,0)) - SUM(nvl(SOLD_VALUE,0)),2) ACTIV_LIST_QTY_VAL, ROUND(NVL(SUM(NOT_LIST_VAL), 0), 2) ACTIV_NOT_LIST_QTY_VAL, ROUND(NVL(SUM(SOLD_VALUE), 0), 2) SOLD_QTY_VAL FROM(select * from  (SELECT D.BARCODE_NO, L.BARCODE_PRV_NO,B.ITEM_ADJ_DET_ID_FOR_OUT OUTT,  L.PIC_DATE_TIME, L.LZ_MANIFEST_DET_ID, B.ITEM_ID, B.LZ_MANIFEST_ID, (SELECT SD.EBAY_PRICE FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO) TOTAL_VAL, (SELECT SD.EBAY_PRICE FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO AND B.EBAY_ITEM_ID IS NOT NULL) LIST_VAL, (SELECT SD.EBAY_PRICE FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO  AND mm.EBAY_ITEM_ID IS NULL AND MM.ITEM_ADJ_DET_ID_FOR_OUT IS NULL) NOT_LIST_VAL,OM.SALE_PRICE /*(SELECT SD.EBAY_PRICE FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO AND B.EBAY_ITEM_ID IS NOT NULL AND B.ORDER_ID IS NOT NULL)*/ SOLD_VALUE, B.EBAY_ITEM_ID, B.ORDER_ID SALE_RECORD_NO FROM LZ_MERCHANT_BARCODE_MT M, LZ_MERCHANT_BARCODE_DT D, LZ_SPECIAL_LOTS L, LZ_BARCODE_MT B, LZ_ITEM_SEED S, LJ_ORDER_PACKING_MT OM WHERE M.MT_ID = D.MT_ID AND D.BARCODE_NO = L.BARCODE_PRV_NO(+) AND L.BARCODE_PRV_NO = B.BARCODE_NO(+) AND B.ITEM_ID = S.ITEM_ID(+) and b.order_id = om.order_id(+) AND B.LZ_MANIFEST_ID = S.LZ_MANIFEST_ID(+) AND B.CONDITION_ID = S.DEFAULT_COND(+) ";

        if (!empty($getSeach)) {
            if (count($str) > 1) {
                $i = 1;
                foreach ($str as $key) {
                    if ($i === 1) {
                        $sqlTwo .= " and (UPPER(S.ITEM_TITLE) LIKE '%$key%' ";
                    } else {
                        $sqlTwo .= " AND UPPER(S.ITEM_TITLE) LIKE '%$key%' ";
                    }
                    $i++;
                }
            } else {
                $sqlTwo .= " and (UPPER(S.ITEM_TITLE) LIKE '%$getSeach%' ";
            }

            $sqlTwo .= " OR UPPER(B.BARCODE_NO) LIKE '%$getSeach%'
        OR UPPER(OM.SALE_RECRD_NUM) LIKE '%$getSeach%'
          OR UPPER(OM.BUYER_NAME) LIKE '%$getSeach%'
           OR UPPER(B.EBAY_ITEM_ID) LIKE '%$getSeach%' )";
            //OR UPPER(OM.SALE_PRICE) LIKE '%$getSeach%') ";
        }

        if (!empty($merLotName)) {
            $sqlTwo .= " and M.lot_id = $merLotName ";
        }

        if (!empty($priceOne) && !empty($priceTwo)) {

            $sqlTwo .= " AND OM.SALE_PRICE BETWEEN  $priceOne AND $priceTwo ";

        }

        $sqlTwo .= " AND M.MERCHANT_ID =$merchId";

        if (!empty($recntSold)) {
            $sqlTwo .= "  AND b.order_id is not null
           order by om.sale_date desc)
           where rownum <=$recntSold )";
        } else {
            $sqlTwo .= " ))";
        }

        $lot_detail_totals = $this->db->query($sqlTwo)->result_array();

        if (count($lot_detail_query) >= 1) {
            return array('lot_detail_query' => $lot_detail_query, 'lot_detail_totals' => $lot_detail_totals, 'lot_name' => $lot_name, 'exist' => true);
        } else {
            return array('lot_detail_query' => $lot_detail_query, 'lot_detail_totals' => $lot_detail_totals, 'lot_name' => $lot_name, 'exist' => false);
        }

    }

    public function get_barcodes_pictures($barcodes, $conditions)
    {

        $path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 2");
        $path = $path->result_array();

        $master_path = $path[0]["MASTER_PATH"];
        $uri = array();
        $base_url = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        foreach ($barcodes as $barcode) {

            $bar = $barcode['EBAY_ITEM_ID'];

            if (!empty($bar)) {
                $getFolder = $this->db->query("SELECT LOT.FOLDER_NAME FROM LZ_SPECIAL_LOTS LOT WHERE lot.barcode_prv_no in (select mm.barcode_no from lz_barcode_mt mm where mm.ebay_item_id = '$bar') and lot.folder_name is not null and rownum <= 1  ")->result_array();

            } else {

                $bar = $barcode['BARCODE_NO'];
                $getFolder = $this->db->query("SELECT LOT.FOLDER_NAME FROM LZ_SPECIAL_LOTS LOT WHERE lot.barcode_prv_no = '$bar' and rownum <= 1  ")->result_array();
            }

            $folderName = "";
            if ($getFolder) {
                $folderName = $getFolder[0]['FOLDER_NAME'];
            } else {
                $folderName = $bar;
            }

            $dir = "";
            $barcodePictures = $master_path . $folderName . "/";
            $barcodePicturesThumb = $master_path . $folderName . "/thumb" . "/";

            if (is_dir($barcodePictures)) {
                $dir = $barcodePictures;
            } else if (is_dir($barcodePicturesThumb)) {
                $dir = $barcodePicturesThumb;
            }

            //   if(!is_dir($dir)){
            //     $getBarcodeMt = $this->db->query("SELECT IT.ITEM_MT_UPC UPC, IT.ITEM_MT_MFG_PART_NO MPN FROM LZ_BARCODE_MT MT, ITEMS_MT IT WHERE MT.ITEM_ID = IT.ITEM_ID AND MT.BARCODE_NO = '$bar' ")->result_array();
            //     $upc = "";
            //     $mpn = "";
            //     if($getBarcodeMt){
            //       $upc = $getBarcodeMt[0]['UPC'];
            //       $mpn = $getBarcodeMt[0]['MPN'];
            //     }

            //     $path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 1");
            //     $path = $path->result_array();

            //     $upc_mpn_master_path = $path[0]["MASTER_PATH"];

            //     $mpn = str_replace("/","_",$mpn);
            // foreach($conditions as $cond){
            //     $dir = $upc_mpn_master_path.$upc."~".$mpn."/".$cond['COND_NAME']."/";
            //     $dirWithMpn = $upc_mpn_master_path."~".$mpn."/".$cond['COND_NAME']."/";
            //     $dirWithUpc = $upc_mpn_master_path.$upc."~/".$cond['COND_NAME']."/";
            //     if (is_dir($dir)){
            //         $dir = $dir;
            //         break;
            //     }else if(is_dir($dirWithMpn)){
            //         $dir = $dirWithMpn;
            //         break;
            //     }else if(is_dir($dirWithUpc)){
            //         $dir = $dirWithUpc;
            //         break;
            //     }else {
            //         $dir = $upc_mpn_master_path."/".$cond['COND_NAME']."/";
            //     }

            // }
            // if($dir == $upc_mpn_master_path."~/".$cond['COND_NAME']."/"){
            //         $dir = $upc_mpn_master_path."/".$cond['COND_NAME']."/";
            //     }

            //   }
            $dir = preg_replace("/[\r\n]*/", "", $dir);

            if (is_dir($dir)) {
                $images = glob($dir . "\*.{JPG,jpg,GIF,gif,PNG,png,BMP,bmp,JPEG,jpeg}", GLOB_BRACE);

                if ($images) {
                    $j = 0;
                    foreach ($images as $image) {

                        $withoutMasterPartUri = str_replace("D:/wamp/www/", "", $image);
                        $withoutMasterPartUri = preg_replace("/[\r\n]*/", "", $withoutMasterPartUri);
                        $uri[$bar][$j] = $base_url . $withoutMasterPartUri;
                        // if($uri[$barcode['LZ_barcode_ID']]){
                        //     break;
                        // }

                        $j++;
                    }
                } else {
                    $uri[$bar][0] = $base_url . "item_pictures/master_pictures/image_not_available.jpg";
                    $uri[$bar][1] = false;
                }
            } else {
                $uri[$bar][0] = $base_url . "item_pictures/master_pictures/image_not_available.jpg";
                $uri[$bar][1] = false;
            }
        }
        return array('uri' => $uri);

    }

    public function merch_lot_load_detail()
    {
        $get_param = strtoupper($this->input->post('param'));
        $recntSold = strtoupper($this->input->post('recntSold'));

        $getSeach = strtoupper($this->input->post('getSeach'));
        $getSeach = trim(str_replace("  ", ' ', $getSeach));
        $getSeach = str_replace(array("`,′"), "", $getSeach);
        $getSeach = str_replace(array("'"), "''", $getSeach);

        $priceOne = strtoupper($this->input->post('priceOne'));
        $priceOne = trim(str_replace("  ", ' ', $priceOne));
        $priceOne = str_replace(array("`,′"), "", $priceOne);
        $priceOne = str_replace(array("'"), "''", $priceOne);

        $priceTwo = strtoupper($this->input->post('priceTwo'));
        $priceTwo = trim(str_replace("  ", ' ', $priceTwo));
        $priceTwo = str_replace(array("`,′"), "", $priceTwo);
        $priceTwo = str_replace(array("'"), "''", $priceTwo);

        $merLotName = strtoupper($this->input->post('merLotName'));
        $merchId = strtoupper($this->input->post('merchId'));
        $str = explode(' ', $getSeach);

        $sql = "SELECT EBAY_ITEM_ID, MAX(ITEM_TITLE) ITM_TITLE, MAX(QTY) SOLD_QTY, COUNT(EBAY_ITEM_ID) QTY, MAX(SALE_PRICE) SALE_PRICE, MAX(QTY) * MAX(SALE_PRICE) TOTAL, MAX(SHIPING_LABEL_RATE) SHIPING_PRICE, MAX(EBAY_FEE) EBAY_FEE, MAX(PACKING_COST) PACKING_COST, NVL((7 / 100) * NVL(MAX(SALE_PRICE * QTY), 0), 0) MARKEPLACE_FEE, ROUND(NVL(SUM(NVL(PIC_CHARGE, 0)) + SUM(NVL(LIST_CHARGE, 0)) + SUM(NVL(PACK_PULL_CHARGE, 0)), 0), 2) LJ_CHARGES, MAX(BUYER_NAME) BUY_NAME, MAX(SALE_RECRD_NUM) SALE_REC, MAX(CHECKOUT_DATE) CHECKOUT_DATE, MAX(SALE_DATE) SALE_DATE, MAX(EBAY_PRICE) EBAY_PRICE, MAX(DEFAULT_COND) DEFAULT_COND, MAX(F_UPC) F_UPC, MAX(F_MPN)F_MPN , MAX(F_MANUFACTURE)F_MANUFACTURE, MAX(CATEGORY_NAME)CATEGORY_NAME, MAX(COND_NAME) COND_NAME FROM (SELECT * FROM (SELECT M.LOT_ID, S.SEED_ID, B.EBAY_ITEM_ID, OM.SALE_DATE, OM.CHECKOUT_DATE, M.NO_OF_BARCODE, B.ORDER_ID, B.SALE_RECORD_NO, OM.QTY, S.ITEM_TITLE, B.BARCODE_NO, OM.SALE_PRICE, OM.SHIPING_LABEL_RATE, OM.EBAY_FEE, (SELECT NVL(SUM(OD.PACKING_COST), 0) FROM LJ_ORDER_PACKING_MT O, LJ_ORDER_PACKING_DT OD WHERE O.ORDER_PACKING_ID = OD.ORDER_PACKING_ID AND O.ORDER_ID = OM.ORDER_ID GROUP BY OD.ORDER_PACKING_ID) PACKING_COST, (SELECT NVL(BIL.CHARGES, 0) FROM LJ_BARCODE_BILLING BIL WHERE BIL.BARCODE_NO = L.BARCODE_PRV_NO /*B.BARCODE_NO*/ AND BIL.SER_RATE_ID = 1) PIC_CHARGE, /*PIC SERVICE CHARGE*/ (SELECT NVL(BIL.CHARGES, 0) FROM LJ_BARCODE_BILLING BIL, LZ_BARCODE_MT BAR WHERE BIL.BARCODE_NO = B.BARCODE_NO AND BIL.BARCODE_NO = BAR.BARCODE_NO AND BIL.SER_RATE_ID = 2 AND BAR.EBAY_ITEM_ID IS NOT NULL) LIST_CHARGE, (SELECT NVL(BIL.CHARGES, 0) FROM LJ_BARCODE_BILLING BIL, LZ_BARCODE_MT BAR WHERE BIL.BARCODE_NO = B.BARCODE_NO AND BIL.BARCODE_NO = BAR.BARCODE_NO AND BIL.SER_RATE_ID = 7 AND BAR.EBAY_ITEM_ID IS NOT NULL) PACK_PULL_CHARGE, OM.BUYER_NAME, OM.SALE_RECRD_NUM, S.EBAY_PRICE, S.DEFAULT_COND, S.F_UPC,S.F_MPN, S.F_MANUFACTURE, S.CATEGORY_NAME, CD.COND_NAME FROM LOT_DEFINATION_MT      MD, LZ_MERCHANT_BARCODE_MT M, LZ_MERCHANT_BARCODE_DT D, LZ_SPECIAL_LOTS        L, LZ_BARCODE_MT          B, LZ_ITEM_SEED           S, LJ_ORDER_PACKING_MT    OM, LZ_ITEM_COND_MT CD WHERE M.MT_ID = D.MT_ID AND MD.LOT_ID = M.LOT_ID AND D.BARCODE_NO = L.BARCODE_PRV_NO(+) AND L.BARCODE_PRV_NO = B.BARCODE_NO(+) AND B.ITEM_ID = S.ITEM_ID(+) AND B.LZ_MANIFEST_ID = S.LZ_MANIFEST_ID(+) AND B.CONDITION_ID = S.DEFAULT_COND(+) AND B.ORDER_ID = OM.ORDER_ID(+) AND S.DEFAULT_COND = CD.ID   and b.ebay_item_id is not null AND M.MERCHANT_ID = $merchId ";

        if (!empty($getSeach)) {
            if (count($str) > 1) {
                $i = 1;
                foreach ($str as $key) {
                    if ($i === 1) {
                        $sql .= " and (UPPER(S.ITEM_TITLE) LIKE '%$key%' ";
                    } else {
                        $sql .= " AND UPPER(S.ITEM_TITLE) LIKE '%$key%' ";
                    }
                    $i++;
                }
            } else {
                $sql .= " and (UPPER(S.ITEM_TITLE) LIKE '%$getSeach%' ";
            }

            $sql .= " OR UPPER(B.BARCODE_NO) LIKE '%$getSeach%'
           OR UPPER(OM.BUYER_NAME) LIKE '%$getSeach%'
           OR UPPER(OM.SALE_RECRD_NUM) LIKE '%$getSeach%'
           OR UPPER(B.EBAY_ITEM_ID) LIKE '%$getSeach%' )";

        }

        if ($get_param == 'ACTIVE') {

            $sql .= " AND B.ORDER_ID IS NULL ";

        } else if ($get_param == 'SOLD') {

            $sql .= " AND B.ORDER_ID IS NOT NULL ";
        }

// if (!empty($recntSold)){
        //     $sqlTwo .= "  AND b.order_id is not null
        //            order by b.order_id  desc)
        //            where rownum <=$recntSold )";
        //     }else{
        //            $sqlTwo .= " ))" ;
        //     }

        //
        if (!empty($merLotName)) {
            $sql .= " and M.lot_id = $merLotName ";
        }

        if (!empty($priceOne) && !empty($priceTwo)) {

            $sql .= " AND OM.SALE_PRICE BETWEEN  $priceOne AND $priceTwo";
        }

        if (!empty($recntSold)) {
            $sql .= "  order by OM.SALE_DATE desc";
        }

        $sql .= " ) ";

        if (!empty($recntSold)) {
            $sql .= " where rownum<= $recntSold";
        }

        $sql .= " ) GROUP BY EBAY_ITEM_ID, ORDER_ID  ORDER BY  QTY DESC ";

        $lot_detail_data = $this->db->query($sql)->result_array();

        if (count($lot_detail_data) >= 1) {
            $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array();

            $uri = $this->get_barcodes_pictures($lot_detail_data, $conditions);
            $images = $uri['uri'];

            return array('lot_detail_data' => $lot_detail_data, "images" => $images, 'exist' => true);
        } else {
            return array('lot_detail_data' => $lot_detail_data, 'exist' => false);
        }

    }

    public function merch_inproces_items()
    {
        $get_param = strtoupper($this->input->post('param'));
        $getSeach = strtoupper($this->input->post('getSeach'));
        $getSeach = trim(str_replace("  ", ' ', $getSeach));
        $getSeach = str_replace(array("`,′"), "", $getSeach);
        $getSeach = str_replace(array("'"), "''", $getSeach);

        $priceOne = strtoupper($this->input->post('priceOne'));
        $priceOne = trim(str_replace("  ", ' ', $priceOne));
        $priceOne = str_replace(array("`,′"), "", $priceOne);
        $priceOne = str_replace(array("'"), "''", $priceOne);

        $priceTwo = strtoupper($this->input->post('priceTwo'));
        $priceTwo = trim(str_replace("  ", ' ', $priceTwo));
        $priceTwo = str_replace(array("`,′"), "", $priceTwo);
        $priceTwo = str_replace(array("'"), "''", $priceTwo);

        $merLotName = strtoupper($this->input->post('merLotName'));
        $merchId = strtoupper($this->input->post('merchId'));
        $str = explode(' ', $getSeach);

        $sql = "SELECT B.BARCODE_NO ,B.BARCODE_NO EBAY_ITEM_ID, S.ITEM_TITLE , C.COND_NAME, S.EBAY_PRICE, S.F_UPC, S.F_MPN, S.F_MANUFACTURE, L.UPDATED_AT, S.CATEGORY_NAME FROM LZ_MERCHANT_BARCODE_MT M, LZ_MERCHANT_BARCODE_DT D, LZ_SPECIAL_LOTS        L, LZ_BARCODE_MT          B, LZ_ITEM_SEED           S, LZ_ITEM_COND_MT        C WHERE M.MT_ID = D.MT_ID AND M.MERCHANT_ID = $merchId AND L.BARCODE_PRV_NO = D.BARCODE_NO AND L.BARCODE_PRV_NO = B.BARCODE_NO AND B.ITEM_ID = S.ITEM_ID(+) AND S.DEFAULT_COND = C.ID(+) AND B.LZ_MANIFEST_ID = S.LZ_MANIFEST_ID(+) AND B.CONDITION_ID = S.DEFAULT_COND(+) AND B.EBAY_ITEM_ID IS NULL AND B.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND M.MERCHANT_ID = $merchId ";

        if (!empty($getSeach)) {
            if (count($str) > 1) {
                $i = 1;
                foreach ($str as $key) {
                    if ($i === 1) {
                        $sql .= " and (UPPER(S.ITEM_TITLE) LIKE '%$key%' ";
                    } else {
                        $sql .= " AND UPPER(S.ITEM_TITLE) LIKE '%$key%' ";
                    }
                    $i++;
                }
            } else {
                $sql .= " and (UPPER(S.ITEM_TITLE) LIKE '%$getSeach%' ";
            }

            $sql .= " OR UPPER(B.BARCODE_NO) LIKE '%$getSeach%' )";

        }

        $sql .= " ORDER BY  B.BARCODE_NO DESC ";

        $lot_detail_data = $this->db->query($sql)->result_array();

        if (count($lot_detail_data) >= 1) {

            $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array();

            $uri = $this->get_barcodes_pictures($lot_detail_data, $conditions);
            $images = $uri['uri'];

            return array('lot_detail_data' => $lot_detail_data, "images" => $images, 'exist' => true);
        } else {
            return array('lot_detail_data' => $lot_detail_data, 'exist' => false);
        }

    }

    public function merchant_sold_items()
    {

        $get_param = 'SOLD'; //strtoupper($this->input->post('param'));
        $getSeach = strtoupper($this->input->post('getSeach'));
        $getSeach = trim(str_replace("  ", ' ', $getSeach));
        $getSeach = str_replace(array("`,′"), "", $getSeach);
        $getSeach = str_replace(array("'"), "''", $getSeach);

        $priceOne = strtoupper($this->input->post('priceOne'));
        $priceOne = trim(str_replace("  ", ' ', $priceOne));
        $priceOne = str_replace(array("`,′"), "", $priceOne);
        $priceOne = str_replace(array("'"), "''", $priceOne);

        $priceTwo = strtoupper($this->input->post('priceTwo'));
        $priceTwo = trim(str_replace("  ", ' ', $priceTwo));
        $priceTwo = str_replace(array("`,′"), "", $priceTwo);
        $priceTwo = str_replace(array("'"), "''", $priceTwo);

        $merLotName = strtoupper($this->input->post('merLotName'));
        $merchId = strtoupper($this->input->post('merchId'));
        $str = explode(' ', $getSeach);

        $lot_name = $this->db->query("SELECT M.LOT_ID, M.LOT_DESC ||'  ('|| M.REF_NO ||')' LOT_DESC FROM LOT_DEFINATION_MT M WHERE M.MERCHANT_ID  =$merchId ")->result_array();

        $sql = "SELECT EBAY_ITEM_ID, MAX(ITEM_TITLE) ITM_TITLE, MAX(QTY) SOLD_QTY, COUNT(EBAY_ITEM_ID) QTY, MAX(SALE_PRICE) SALE_PRICE, MAX(QTY) * MAX(SALE_PRICE) TOTAL, MAX(SHIPING_LABEL_RATE) SHIPING_PRICE, MAX(EBAY_FEE) EBAY_FEE, MAX(PACKING_COST) PACKING_COST, NVL((7 / 100) * NVL(MAX(SALE_PRICE * QTY), 0), 0) MARKEPLACE_FEE, ROUND(NVL(SUM(NVL(PIC_CHARGE, 0)) + SUM(NVL(LIST_CHARGE, 0)) + SUM(NVL(PACK_PULL_CHARGE, 0)), 0), 2) LJ_CHARGES, MAX(BUYER_NAME) BUY_NAME, MAX(SALE_RECRD_NUM) SALE_REC, MAX(CHECKOUT_DATE) CHECKOUT_DATE, MAX(SALE_DATE) SALE_DATE, MAX(EBAY_PRICE) EBAY_PRICE, MAX(DEFAULT_COND) DEFAULT_COND, MAX(F_UPC) F_UPC, MAX(F_MPN)F_MPN , MAX(F_MANUFACTURE)F_MANUFACTURE, MAX(CATEGORY_NAME)CATEGORY_NAME, MAX(COND_NAME) COND_NAME FROM (SELECT M.LOT_ID, S.SEED_ID, B.EBAY_ITEM_ID, OM.SALE_DATE, OM.CHECKOUT_DATE, M.NO_OF_BARCODE, B.ORDER_ID, B.SALE_RECORD_NO, OM.QTY, S.ITEM_TITLE, B.BARCODE_NO, OM.SALE_PRICE, OM.SHIPING_LABEL_RATE, OM.EBAY_FEE, (SELECT NVL(SUM(OD.PACKING_COST), 0) FROM LJ_ORDER_PACKING_MT O, LJ_ORDER_PACKING_DT OD WHERE O.ORDER_PACKING_ID = OD.ORDER_PACKING_ID AND O.ORDER_ID = OM.ORDER_ID GROUP BY OD.ORDER_PACKING_ID) PACKING_COST, (SELECT NVL(BIL.CHARGES, 0) FROM LJ_BARCODE_BILLING BIL WHERE BIL.BARCODE_NO = L.BARCODE_PRV_NO /*B.BARCODE_NO*/ AND BIL.SER_RATE_ID = 1) PIC_CHARGE, /*PIC SERVICE CHARGE*/ (SELECT NVL(BIL.CHARGES, 0) FROM LJ_BARCODE_BILLING BIL, LZ_BARCODE_MT BAR WHERE BIL.BARCODE_NO = B.BARCODE_NO AND BIL.BARCODE_NO = BAR.BARCODE_NO AND BIL.SER_RATE_ID = 2 AND BAR.EBAY_ITEM_ID IS NOT NULL) LIST_CHARGE, (SELECT NVL(BIL.CHARGES, 0) FROM LJ_BARCODE_BILLING BIL, LZ_BARCODE_MT BAR WHERE BIL.BARCODE_NO = B.BARCODE_NO AND BIL.BARCODE_NO = BAR.BARCODE_NO AND BIL.SER_RATE_ID = 7 AND BAR.EBAY_ITEM_ID IS NOT NULL) PACK_PULL_CHARGE, OM.BUYER_NAME, OM.SALE_RECRD_NUM, S.EBAY_PRICE, S.DEFAULT_COND, S.F_UPC,S.F_MPN, S.F_MANUFACTURE, S.CATEGORY_NAME, CD.COND_NAME FROM LOT_DEFINATION_MT      MD, LZ_MERCHANT_BARCODE_MT M, LZ_MERCHANT_BARCODE_DT D, LZ_SPECIAL_LOTS        L, LZ_BARCODE_MT          B, LZ_ITEM_SEED           S, LJ_ORDER_PACKING_MT    OM, LZ_ITEM_COND_MT CD WHERE M.MT_ID = D.MT_ID AND MD.LOT_ID = M.LOT_ID AND D.BARCODE_NO = L.BARCODE_PRV_NO(+) AND L.BARCODE_PRV_NO = B.BARCODE_NO(+) AND B.ITEM_ID = S.ITEM_ID(+) AND B.LZ_MANIFEST_ID = S.LZ_MANIFEST_ID(+) AND B.CONDITION_ID = S.DEFAULT_COND(+) AND B.ORDER_ID = OM.ORDER_ID(+) AND S.DEFAULT_COND = CD.ID AND M.MERCHANT_ID = $merchId ";

        if (!empty($getSeach)) {
            if (count($str) > 1) {
                $i = 1;
                foreach ($str as $key) {
                    if ($i === 1) {
                        $sql .= " and (UPPER(S.ITEM_TITLE) LIKE '%$key%' ";
                    } else {
                        $sql .= " AND UPPER(S.ITEM_TITLE) LIKE '%$key%' ";
                    }
                    $i++;
                }
            } else {
                $sql .= " and (UPPER(S.ITEM_TITLE) LIKE '%$getSeach%' ";
            }

            $sql .= " OR UPPER(B.BARCODE_NO) LIKE '%$getSeach%'
           OR UPPER(OM.BUYER_NAME) LIKE '%$getSeach%'
           OR UPPER(OM.SALE_RECRD_NUM) LIKE '%$getSeach%'
           OR UPPER(B.EBAY_ITEM_ID) LIKE '%$getSeach%' )";

        }

        if ($get_param == 'ACTIVE') {

            $sql .= " AND B.ORDER_ID IS NULL ";

        } else if ($get_param == 'SOLD') {

            $sql .= " AND B.ORDER_ID IS NOT NULL ";
        }

        if (!empty($merLotName)) {
            $sql .= " and M.lot_id = $merLotName ";
        }

        if (!empty($priceOne) && !empty($priceTwo)) {

            $sql .= " AND OM.SALE_PRICE BETWEEN  $priceOne AND $priceTwo";

        }

        $sql .= " ) GROUP BY EBAY_ITEM_ID, ORDER_ID  ORDER BY  QTY DESC ";

        $lot_detail_data = $this->db->query($sql)->result_array();

        if (count($lot_detail_data) >= 1) {
            $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array();

            $uri = $this->get_barcodes_pictures($lot_detail_data, $conditions);
            $images = $uri['uri'];

            return array('lot_detail_data' => $lot_detail_data, 'lot_name' => $lot_name, "images" => $images, 'exist' => true);
        } else {
            return array('lot_detail_data' => $lot_detail_data, 'lot_name' => $lot_name, 'exist' => false);
        }

    }

    public function merchant_sold_latest()
    {

        $get_param = 'SOLD'; //strtoupper($this->input->post('param'));
        $getSeach = strtoupper($this->input->post('getSeach'));
        $getSeach = trim(str_replace("  ", ' ', $getSeach));
        $getSeach = str_replace(array("`,′"), "", $getSeach);
        $getSeach = str_replace(array("'"), "''", $getSeach);

        $priceOne = strtoupper($this->input->post('priceOne'));
        $priceOne = trim(str_replace("  ", ' ', $priceOne));
        $priceOne = str_replace(array("`,′"), "", $priceOne);
        $priceOne = str_replace(array("'"), "''", $priceOne);

        $priceTwo = strtoupper($this->input->post('priceTwo'));
        $priceTwo = trim(str_replace("  ", ' ', $priceTwo));
        $priceTwo = str_replace(array("`,′"), "", $priceTwo);
        $priceTwo = str_replace(array("'"), "''", $priceTwo);

        $merLotName = strtoupper($this->input->post('merLotName'));
        $merchId = strtoupper($this->input->post('merchId'));
        $str = explode(' ', $getSeach);

        $lot_name = $this->db->query("SELECT M.LOT_ID, M.LOT_DESC ||'  ('|| M.REF_NO ||')' LOT_DESC FROM LOT_DEFINATION_MT M WHERE M.MERCHANT_ID  =$merchId ")->result_array();

        $sql = "SELECT EBAY_ITEM_ID, MAX(ITEM_TITLE) ITM_TITLE, MAX(QTY) SOLD_QTY, COUNT(EBAY_ITEM_ID) QTY, MAX(SALE_PRICE) SALE_PRICE, MAX(QTY) * MAX(SALE_PRICE) TOTAL, MAX(SHIPING_LABEL_RATE) SHIPING_PRICE, MAX(EBAY_FEE) EBAY_FEE, MAX(PACKING_COST) PACKING_COST, NVL((7 / 100) * NVL(MAX(SALE_PRICE * QTY), 0), 0) MARKEPLACE_FEE, ROUND(NVL(SUM(NVL(PIC_CHARGE, 0)) + SUM(NVL(LIST_CHARGE, 0)) + SUM(NVL(PACK_PULL_CHARGE, 0)), 0), 2) LJ_CHARGES, MAX(BUYER_NAME) BUY_NAME, MAX(SALE_RECRD_NUM) SALE_REC, MAX(CHECKOUT_DATE) CHECKOUT_DATE, MAX(SALE_DATE) SALE_DATE, MAX(EBAY_PRICE) EBAY_PRICE, MAX(DEFAULT_COND) DEFAULT_COND, MAX(F_UPC) F_UPC, MAX(F_MPN)F_MPN , MAX(F_MANUFACTURE)F_MANUFACTURE, MAX(CATEGORY_NAME)CATEGORY_NAME, MAX(COND_NAME) COND_NAME FROM (SELECT M.LOT_ID, S.SEED_ID, B.EBAY_ITEM_ID, OM.SALE_DATE, OM.CHECKOUT_DATE, M.NO_OF_BARCODE, B.ORDER_ID, B.SALE_RECORD_NO, OM.QTY, S.ITEM_TITLE, B.BARCODE_NO, OM.SALE_PRICE, OM.SHIPING_LABEL_RATE, OM.EBAY_FEE, (SELECT NVL(SUM(OD.PACKING_COST), 0) FROM LJ_ORDER_PACKING_MT O, LJ_ORDER_PACKING_DT OD WHERE O.ORDER_PACKING_ID = OD.ORDER_PACKING_ID AND O.ORDER_ID = OM.ORDER_ID GROUP BY OD.ORDER_PACKING_ID) PACKING_COST, (SELECT NVL(BIL.CHARGES, 0) FROM LJ_BARCODE_BILLING BIL WHERE BIL.BARCODE_NO = L.BARCODE_PRV_NO /*B.BARCODE_NO*/ AND BIL.SER_RATE_ID = 1) PIC_CHARGE, /*PIC SERVICE CHARGE*/ (SELECT NVL(BIL.CHARGES, 0) FROM LJ_BARCODE_BILLING BIL, LZ_BARCODE_MT BAR WHERE BIL.BARCODE_NO = B.BARCODE_NO AND BIL.BARCODE_NO = BAR.BARCODE_NO AND BIL.SER_RATE_ID = 2 AND BAR.EBAY_ITEM_ID IS NOT NULL) LIST_CHARGE, (SELECT NVL(BIL.CHARGES, 0) FROM LJ_BARCODE_BILLING BIL, LZ_BARCODE_MT BAR WHERE BIL.BARCODE_NO = B.BARCODE_NO AND BIL.BARCODE_NO = BAR.BARCODE_NO AND BIL.SER_RATE_ID = 7 AND BAR.EBAY_ITEM_ID IS NOT NULL) PACK_PULL_CHARGE, OM.BUYER_NAME, OM.SALE_RECRD_NUM, S.EBAY_PRICE, S.DEFAULT_COND, S.F_UPC,S.F_MPN, S.F_MANUFACTURE, S.CATEGORY_NAME, CD.COND_NAME FROM LOT_DEFINATION_MT      MD, LZ_MERCHANT_BARCODE_MT M, LZ_MERCHANT_BARCODE_DT D, LZ_SPECIAL_LOTS        L, LZ_BARCODE_MT          B, LZ_ITEM_SEED           S, LJ_ORDER_PACKING_MT    OM, LZ_ITEM_COND_MT CD WHERE M.MT_ID = D.MT_ID AND MD.LOT_ID = M.LOT_ID AND D.BARCODE_NO = L.BARCODE_PRV_NO(+) AND L.BARCODE_PRV_NO = B.BARCODE_NO(+) AND B.ITEM_ID = S.ITEM_ID(+) AND B.LZ_MANIFEST_ID = S.LZ_MANIFEST_ID(+) AND B.CONDITION_ID = S.DEFAULT_COND(+) AND B.ORDER_ID = OM.ORDER_ID(+) AND S.DEFAULT_COND = CD.ID AND M.MERCHANT_ID = $merchId ";

        if (!empty($getSeach)) {
            if (count($str) > 1) {
                $i = 1;
                foreach ($str as $key) {
                    if ($i === 1) {
                        $sql .= " and (UPPER(S.ITEM_TITLE) LIKE '%$key%' ";
                    } else {
                        $sql .= " AND UPPER(S.ITEM_TITLE) LIKE '%$key%' ";
                    }
                    $i++;
                }
            } else {
                $sql .= " and (UPPER(S.ITEM_TITLE) LIKE '%$getSeach%' ";
            }

            $sql .= " OR UPPER(B.BARCODE_NO) LIKE '%$getSeach%'
           OR UPPER(OM.BUYER_NAME) LIKE '%$getSeach%'
           OR UPPER(OM.SALE_RECRD_NUM) LIKE '%$getSeach%'
           OR UPPER(B.EBAY_ITEM_ID) LIKE '%$getSeach%' )";

        }

        if ($get_param == 'ACTIVE') {

            $sql .= " AND B.ORDER_ID IS NULL ";

        } else if ($get_param == 'SOLD') {

            $sql .= " AND B.ORDER_ID IS NOT NULL ";
        }

        if (!empty($merLotName)) {
            $sql .= " and M.lot_id = $merLotName ";
        }

        if (!empty($priceOne) && !empty($priceTwo)) {

            $sql .= " AND OM.SALE_PRICE BETWEEN  $priceOne AND $priceTwo";

        }

        $sql .= " ) GROUP BY EBAY_ITEM_ID, ORDER_ID  ORDER BY  QTY DESC ";

        $lot_detail_data = $this->db->query($sql)->result_array();

        if (count($lot_detail_data) >= 1) {
            $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array();

            $uri = $this->get_barcodes_pictures($lot_detail_data, $conditions);
            $images = $uri['uri'];

            return array('lot_detail_data' => $lot_detail_data, 'lot_name' => $lot_name, "images" => $images, 'exist' => true);
        } else {
            return array('lot_detail_data' => $lot_detail_data, 'lot_name' => $lot_name, 'exist' => false);
        }

    }

    public function merchant_dashboard()
    {

        $merchId = $this->input->post('merchId');

        $merhc_dash = $this->db->query("SELECT COUNT(BARCODE_NO) TOT_BARC, COUNT(PIC_DATE_TIME) PICTURS_DONE, COUNT(LZ_MANIFEST_DET_ID) BARCODE_CREATED, COUNT(EBAY_ITEM_ID) - COUNT(SALE_RECORD_NO) ACTIVE_LISTED, COUNT(LZ_MANIFEST_DET_ID) - COUNT(EBAY_ITEM_ID) - COUNT(OUTT) NOT_LISTED, COUNT(SALE_RECORD_NO) SOLD, ROUND(NVL(SUM(TOTAL_VAL), 0), 2) PROCESED_QTY_VAL, ROUND(NVL(SUM(LIST_VAL) - SUM(SOLD_VALUE), 0), 2) ACTIV_LIST_QTY_VAL, ROUND(NVL(SUM(NOT_LIST_VAL), 0), 2) ACTIV_NOT_LIST_QTY_VAL, ROUND(NVL(SUM(SOLD_VALUE), 0), 2) SOLD_QTY_VAL FROM (SELECT D.BARCODE_NO, B.ITEM_ADJ_DET_ID_FOR_OUT OUTT, L.BARCODE_PRV_NO, L.PIC_DATE_TIME, L.LZ_MANIFEST_DET_ID, B.ITEM_ID, B.LZ_MANIFEST_ID, (SELECT SD.EBAY_PRICE FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO) TOTAL_VAL, (SELECT SD.EBAY_PRICE FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO AND B.EBAY_ITEM_ID IS NOT NULL) LIST_VAL, (SELECT SD.EBAY_PRICE FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO AND B.EBAY_ITEM_ID IS NULL AND B.ITEM_ADJ_DET_ID_FOR_OUT IS NULL ) NOT_LIST_VAL, (SELECT SD.EBAY_PRICE FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO AND B.EBAY_ITEM_ID IS NOT NULL AND B.ORDER_ID IS NOT NULL) SOLD_VALUE, B.EBAY_ITEM_ID, B.ORDER_ID SALE_RECORD_NO FROM LZ_MERCHANT_BARCODE_MT M, LZ_MERCHANT_BARCODE_DT D, LZ_SPECIAL_LOTS        L, LZ_BARCODE_MT          B WHERE M.MT_ID = D.MT_ID AND D.BARCODE_NO = L.BARCODE_PRV_NO(+) AND L.BARCODE_PRV_NO = B.BARCODE_NO(+) AND M.MERCHANT_ID = $merchId /* AND M.LOT_ID = 31*/ ) ")->result_array();

        return array('merhc_dash' => $merhc_dash, 'exist' => true);

    }
    public function mer_active_listed()
    {
        $merchId = $this->input->post('merchId');
        $avail_cat = $this->input->post('avail_cat');

        $merhc_activ_list = "SELECT B.EBAY_ITEM_ID,max(s.seed_id) seed_id,max(s.ebay_price) pric, COUNT(B.EBAY_ITEM_ID) QTY, MAX(S.ITEM_TITLE) ITEM_DESC, MAX(S.F_MANUFACTURE) ITEM_MT_MANUFACTURE, MAX(S.F_MPN) ITEM_MT_MFG_PART_NO, MAX(S.F_UPC) ITEM_MT_UPC, /*MAX(I.ITEM_DESC) ITEM_DESC, MAX(I.ITEM_MT_MANUFACTURE) ITEM_MT_MANUFACTURE, MAX(I.ITEM_MT_MFG_PART_NO) ITEM_MT_MFG_PART_NO, MAX(I.ITEM_MT_UPC) ITEM_MT_UPC,*/ MAX(COND_NAME) CONDITION_ID,MAX(CA.CATEGORY_NAME)  NAME FROM LZ_MERCHANT_BARCODE_MT M, LZ_ITEM_COND_MT        C, LZ_MERCHANT_BARCODE_DT D, LZ_SPECIAL_LOTS        L, LZ_BARCODE_MT          B, /*ITEMS_MT               I,*/ LZ_ITEM_SEED S,LZ_BD_CATEGORY    CA WHERE M.MT_ID = D.MT_ID AND B.CONDITION_ID = C.ID AND D.BARCODE_NO = L.BARCODE_PRV_NO(+) AND L.BARCODE_PRV_NO = B.BARCODE_NO(+) AND B.ITEM_ID = S.ITEM_ID AND B.LZ_MANIFEST_ID =  S.LZ_MANIFEST_ID AND S.CATEGORY_ID = CA.CATEGORY_ID(+) AND B.CONDITION_ID = S.DEFAULT_COND /*AND B.ITEM_ID = I.ITEM_ID(+)*/ AND B.EBAY_ITEM_ID IS NOT NULL AND B.SALE_RECORD_NO IS NULL AND M.MERCHANT_ID = $merchId  ";
        if (!empty($avail_cat)) {
            $merhc_activ_list .= " AND S.CATEGORY_ID = $avail_cat ";
        }

        $merhc_activ_list .= " GROUP BY  B.EBAY_ITEM_ID ";

        $merhc_activ_list = $this->db->query($merhc_activ_list)->result_array();

        $merch_act_list_categry = $this->db->query("SELECT count(s.category_id) cat_id, s.category_id, max(ca.category_name) || ' (' || count(s.category_id) || ')' name FROM LZ_MERCHANT_BARCODE_MT M, LZ_ITEM_COND_MT  C, LZ_MERCHANT_BARCODE_DT D, LZ_SPECIAL_LOTS  L, LZ_BARCODE_MT B, LZ_ITEM_SEED  S, lz_bd_category    ca WHERE M.MT_ID = D.MT_ID AND B.CONDITION_ID = C.ID AND D.BARCODE_NO = L.BARCODE_PRV_NO(+) AND L.BARCODE_PRV_NO = B.BARCODE_NO(+) AND B.ITEM_ID = S.ITEM_ID AND B.LZ_MANIFEST_ID = S.LZ_MANIFEST_ID AND B.CONDITION_ID = S.DEFAULT_COND AND B.EBAY_ITEM_ID IS NOT NULL AND B.SALE_RECORD_NO IS NULL and s.category_id = ca.category_id(+) AND M.MERCHANT_ID = $merchId GROUP BY s.category_id ")->result_array();

        return array('merhc_activ_list' => $merhc_activ_list, 'merch_act_list_categry' => $merch_act_list_categry, 'exist' => true);

    }
    public function mer_active_not_listed()
    {
        $merchId = $this->input->post('merchId');

        $merhc_activ_not_list = $this->db->query("SELECT D.BARCODE_NO, L.BARCODE_PRV_NO, L.PIC_DATE_TIME, L.LZ_MANIFEST_DET_ID, B.EBAY_ITEM_ID, B.SALE_RECORD_NO, B.ITEM_ID, I.ITEM_DESC, I.ITEM_MT_MANUFACTURE, I.ITEM_MT_MFG_PART_NO, I.ITEM_MT_UPC, I.ITEM_CONDITION, C.COND_NAME CONDITION_ID FROM LZ_MERCHANT_BARCODE_MT M, LZ_ITEM_COND_MT C,LZ_MERCHANT_BARCODE_DT D, LZ_SPECIAL_LOTS L, LZ_BARCODE_MT B, ITEMS_MT  I WHERE M.MT_ID = D.MT_ID AND B.CONDITION_ID = C.ID  AND D.BARCODE_NO = L.BARCODE_PRV_NO(+) AND L.BARCODE_PRV_NO = B.BARCODE_NO(+) AND B.ITEM_ID = I.ITEM_ID (+) AND B.EBAY_ITEM_ID IS  NULL  and l.lz_manifest_det_id is not null   AND M.MERCHANT_ID = $merchId order by BARCODE_NO desc ")->result_array();

        return array('merhc_activ_not_list' => $merhc_activ_not_list, 'exist' => true);

    }
    // public function mer_active_listed_category(){
    //    $merchId = $this->input->post('merchId');

    //   $merch_act_list_categry = $this->db->query("SELECT count(s.category_id) cat_id, s.category_id, max(ca.category_name) || ' (' || count(s.category_id) || ')' name FROM LZ_MERCHANT_BARCODE_MT M, LZ_ITEM_COND_MT  C, LZ_MERCHANT_BARCODE_DT D, LZ_SPECIAL_LOTS  L, LZ_BARCODE_MT B, LZ_ITEM_SEED  S, lz_bd_category_tree    ca WHERE M.MT_ID = D.MT_ID AND B.CONDITION_ID = C.ID AND D.BARCODE_NO = L.BARCODE_PRV_NO(+) AND L.BARCODE_PRV_NO = B.BARCODE_NO(+) AND B.ITEM_ID = S.ITEM_ID AND B.LZ_MANIFEST_ID = S.LZ_MANIFEST_ID AND B.CONDITION_ID = S.DEFAULT_COND AND B.EBAY_ITEM_ID IS NOT NULL AND B.SALE_RECORD_NO IS NULL and s.category_id = ca.category_id(+) AND M.MERCHANT_ID = $merchId GROUP BY s.category_id ")->result_array();

    //   return array('merch_act_list_categry' => $merch_act_list_categry,'exist'=>true);

    // }

    public function get_pictures()
    {

        $barocde_no = $this->input->post('barocde_no');
        $bar_val = $barocde_no;
        // //var_dump($barocde_no['barcodePass']);
        //  var_dump($barocde_no);
        //  exit;
        //$bar_val = $barocde_no['barcodePass'] ;

        $path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 2");
        $path = $path->result_array();

        $master_path = $path[0]["MASTER_PATH"];

        $qry = $this->db->query("SELECT TO_CHAR(FOLDER_NAME) FOLDER_NAME FROM LZ_DEKIT_US_DT WHERE BARCODE_PRV_NO = '$bar_val' UNION ALL SELECT TO_CHAR(FOLDER_NAME) FOLDER_NAME FROM LZ_SPECIAL_LOTS L WHERE L.BARCODE_PRV_NO =  '$bar_val' ")->result_array();

        $barcode = $qry[0]["FOLDER_NAME"];

        $dir = $master_path . $barcode . "/";

        $dir = preg_replace("/[\r\n]*/", "", $dir);

        $uri = [];

        //var_dump(is_dir($dir));exit;
        if (is_dir($dir)) {
            // var_dump($dir);exit;
            $images = glob($dir . "\*.{JPG,jpg,GIF,gif,PNG,png,BMP,bmp,JPEG,jpeg}", GLOB_BRACE);
            $i = 0;
            $base_url = 'http://' . $_SERVER['HTTP_HOST'] . '/';
            foreach ($images as $image) {
                $withoutMasterPartUri = str_replace("D:/wamp/www/", "", $image);
                $uri[$i] = $base_url . $withoutMasterPartUri;

                $i++;
            }
        }

        //var_dump($dekitted_pics);exit;
        return array('uri' => $uri);

    }

    public function get_dropdowns()
    {

        $barocde = $this->input->post('barocde');

        $get_remarks = $this->db->query("SELECT 'Dekit Item => ' ||kK.DEKIT_REMARKS DEKIT_REMARKS , 'Identity Remarks => ' || KK.IDENT_REMARKS IDENT_REMARKS,'Barcode Notes => ' || KK.BARCODE_NOTES  BARCODE_NOTES FROM LZ_DEKIT_US_DT KK where kk.barcode_prv_no  ='$barocde' union all SELECT 'Special Lot => ' ||L.LOT_REMARKS DEKIT_REMARKS,'Identity Remarks => ' ||L.PIC_NOTES IDENT_REMARKS,'Barcode Notes =>' ||L.BARCODE_NOTES FROM LZ_SPECIAL_LOTS L where l.barcode_prv_no  ='$barocde' ")->result_array();

        $condition_quer = $this->db->query("SELECT C.ID,C.COND_NAME FROM LZ_ITEM_COND_MT C ORDER BY C.ID ASC")->result_array();

        $ship_quer = $this->db->query("SELECT S.SHIPING_NAME FROM LZ_SHIPING_NAME S ORDER BY S.ID ASC")->result_array();

        $temp_data = $this->db->query("SELECT TEMPLATE_ID,TEMPLATE_NAME FROM LZ_ITEM_TEMPLATE ORDER BY TEMPLATE_NAME DESC")->result_array();

        $macro_type = $this->db->query("SELECT T.TYPE_ID,T.TYPE_DESCRIPTION,T.TYPE_ORDER FROM LZ_MACRO_TYPE T ORDER BY T.TYPE_DESCRIPTION  ASC")->result_array();
        $get_sedd_param = $this->db->query("SELECT U.LZ_MANIFEST_ID,U.EBAY_ITEM_ID,U.ITEM_ID,U.CONDITION_ID FROM LZ_BARCODE_MT U WHERE U.BARCODE_NO = $barocde")->result_array();

        if (count($get_sedd_param) > 0) {
            $manif_id = $get_sedd_param[0]['LZ_MANIFEST_ID'];
            $item_id = $get_sedd_param[0]['ITEM_ID'];
            $cond_id = $get_sedd_param[0]['CONDITION_ID'];
            $ebay_item_id = $get_sedd_param[0]['EBAY_ITEM_ID'];

            $seed_data = $this->db->query("SELECT S.SEED_ID, B.BARCODE_NO IT_BARCODE, DECODE(S.F_MPN, NULL, I.ITEM_MT_MFG_PART_NO, S.F_MPN) MFG_PART_NO, DECODE(S.F_UPC,NULL,D.ITEM_MT_UPC,S.F_UPC) UPC, DECODE(S.F_MANUFACTURE, NULL, I.ITEM_MT_MANUFACTURE, S.F_MANUFACTURE) MANUFACTURER, I.ITEM_MT_BBY_SKU SKU_NO, I.ITEM_CODE LAPTOP_ITEM_CODE,s.item_title ITEM_MT_DESC,S.ITEM_DESC DESCR, D.WEIGHT, S.*, R.GENERAL_RULE, R.SPECIFIC_RULE, BM.BIN_TYPE || '-' || BM.BIN_NO BIN_NAME, C.COND_NAME,S.CATEGORY_ID FROM LZ_ITEM_SEED  S,LZ_BARCODE_MT B,LZ_MANIFEST_DET  D, ITEMS_MT  I, LZ_LISTING_RULES R, BIN_MT  BM, LZ_ITEM_COND_MT  C WHERE B.ITEM_ID = S.ITEM_ID AND I.ITEM_ID = S.ITEM_ID AND B.LZ_MANIFEST_ID = S.LZ_MANIFEST_ID AND D.LZ_MANIFEST_ID = S.LZ_MANIFEST_ID AND D.LAPTOP_ITEM_CODE = I.ITEM_CODE AND R.ITEM_CONDITION = S.DEFAULT_COND AND D.LZ_MANIFEST_ID = S.LZ_MANIFEST_ID AND D.LAPTOP_ITEM_CODE = I.ITEM_CODE AND BM.BIN_ID = B.BIN_ID AND S.DEFAULT_COND = C.ID /*AND S.SEED_ID = 10000000041*/ AND S.LZ_MANIFEST_ID = $manif_id AND S.ITEM_ID = $item_id AND S.DEFAULT_COND = $cond_id AND ROWNUM = 1")->result_array();

            $mfg_part_no = $seed_data[0]['MFG_PART_NO'];
            $category_id = $seed_data[0]['CATEGORY_ID'];

            $list_qty = $this->db->query("SELECT COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL AND BC.LIST_ID IS NULL AND BC.SALE_RECORD_NO IS NULL AND BC.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND BC.LZ_PART_ISSUE_MT_ID IS NULL AND BC.LZ_POS_MT_ID IS NULL AND BC.PULLING_ID IS NULL AND BC.LZ_MANIFEST_ID = $manif_id AND BC.ITEM_ID = $item_id AND BC.CONDITION_ID = $cond_id GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID ");

            if ($list_qty->num_rows() > 0) {
                $list_qty = $list_qty->result_array();
                $list_qty = $list_qty[0]['QTY'];
            } else {
                $list_qty = null;
            }

            $ebay_paypal_qry = $this->db->query("SELECT ITEM_ID,PAYPAL_FEE,EBAY_FEE FROM (SELECT SD.SALES_RECORD_NUMBER, E.ITEM_ID, ROUND((SD.PAYPAL_PER_TRANS_FEE / SD.SALE_PRICE) * 100, 2) PAYPAL_FEE, ROUND((SD.EBAY_FEE_PERC / SD.SALE_PRICE) * 100, 2) EBAY_FEE FROM LZ_SALESLOAD_DET SD, EBAY_LIST_MT E WHERE SD.ITEM_ID = E.EBAY_ITEM_ID AND SD.SALE_PRICE > 0 AND SD.PAYPAL_PER_TRANS_FEE > 0 AND SD.EBAY_FEE_PERC > 0 AND SD.QUANTITY = 1 AND E.ITEM_ID = $item_id ORDER BY SD.SALES_RECORD_NUMBER DESC) WHERE ROWNUM =1");

            if ($ebay_paypal_qry->num_rows() > 0) {
                $ebay_paypal_qry = $ebay_paypal_qry->result_array();
            } else {
                $ebay_paypal_qry = null;
            }

            $ship_fee_qry = $this->db->query(" SELECT * FROM ( SELECT DISTINCT D.SHIP_FEE FROM LZ_MANIFEST_DET D WHERE D.LAPTOP_ITEM_CODE = (SELECT ITEM_CODE FROM ITEMS_MT WHERE ITEM_ID = $item_id) AND D.SHIP_FEE IS NOT NULL ORDER BY D.SHIP_FEE DESC) WHERE ROWNUM =1");

            if ($ship_fee_qry->num_rows() > 0) {
                $ship_fee_qry = $ship_fee_qry->result_array();
            } else {

                $ship_fee_qry = $this->db->query("SELECT O.SHIP_SERV SHIP_FEE,O.WEIGHT FROM LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE O.OBJECT_ID = C.OBJECT_ID AND C.CATEGORY_ID = '$category_id' AND UPPER(TRIM(C.MPN)) = UPPER(TRIM('$mfg_part_no'))");
                if ($ship_fee_qry->num_rows() > 0) {
                    $ship_fee_qry = $ship_fee_qry->result_array();
                } else {
                    $ship_fee_qry = null;
                }
            }

            $cost_qry = $this->db->query("SELECT D.LZ_MANIFEST_ID, I.ITEM_ID, MAX(D.PO_DETAIL_RETIAL_PRICE) COST_PRICE FROM LZ_MANIFEST_DET D, ITEMS_MT I WHERE D.LAPTOP_ITEM_CODE = I.ITEM_CODE AND I.ITEM_ID = $item_id AND D.LZ_MANIFEST_ID = $manif_id GROUP BY D.LZ_MANIFEST_ID, I.ITEM_ID");
            if ($cost_qry->num_rows() > 0) {
                $cost_qry = $cost_qry->result_array();
            } else {
                $cost_qry = null;
            }

            return array('seed_data' => $seed_data, 'get_remarks' => $get_remarks, 'list_qty' => $list_qty, 'ebay_paypal_qry' => $ebay_paypal_qry, 'ship_fee_qry' => $ship_fee_qry, 'exist' => true, 'condition_quer' => $condition_quer, 'ship_quer' => $ship_quer, 'temp_data' => $temp_data, 'macro_type' => $macro_type, 'cost_qry' => $cost_qry, 'ebay_item_id' => $ebay_item_id);

        } else {

            $seed_data = null;
            $list_qty = null;
            $ebay_paypal_qry = null;
            $ship_fee_qry = null;
            $ebay_item_id = null;

            return array('seed_data' => $seed_data, 'get_remarks' => $get_remarks, 'list_qty' => $list_qty, 'ebay_paypal_qry' => $ebay_paypal_qry, 'ship_fee_qry' => $ship_fee_qry, 'exist' => false, 'condition_quer' => $condition_quer, 'ship_quer' => $ship_quer, 'temp_data' => $temp_data, 'macro_type' => $macro_type, 'ebay_item_id' => $ebay_item_id);
        }

    }

    public function updateReviseStatus($ebay_id, $price)
    {
        $list_rslt = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('EBAY_LIST_MT','LIST_ID') LIST_ID FROM DUAL");
        $rs = $list_rslt->result_array();
        $LIST_ID = $rs[0]['LIST_ID'];
        //$this->session->set_userdata('list_id',$LIST_ID);
        /*========================================================
        =            get require column for insertion            =
        ========================================================*/

        $list_rslt = $this->db->query("SELECT * FROM (SELECT E.* FROM EBAY_LIST_MT E WHERE E.EBAY_ITEM_ID = '$ebay_id' ORDER BY E.LIST_ID DESC) WHERE ROWNUM = 1");
        $rslt_dta = $list_rslt->result_array();
        $LIST_ID = $rs[0]['LIST_ID'];

        /*=====  End of get require column for insertion  ======*/

        $status = "UPDATE";
        $forceRevise = 0;
        //$rslt_dta = $query->result_array();

        //$list_date = date("d/M/Y");// return format Aug/13/2016
        date_default_timezone_set("America/Chicago");
        $list_date = date("Y-m-d H:i:s");
        $list_date = "TO_DATE('" . $list_date . "', 'YYYY-MM-DD HH24:MI:SS')";
        $lister_id = $this->session->userdata('user_id');
        $ebay_item_desc = @$rslt_dta[0]['ITEM_TITLE'];
        $manifest_id = @$rslt_dta[0]['LZ_MANIFEST_ID'];
        $item_id = @$rslt_dta[0]['ITEM_ID'];
        $list_qty = 0;
        $ebay_item_id = $ebay_id;
        $list_price = @$price;
        $remarks = null;
        $single_entry_id = null;
        $salvage_qty = 0.00;
        $entry_type = "L";
        $LZ_SELLER_ACCT_ID = @$rslt_dta[0]['LZ_SELLER_ACCT_ID'];
        $condition_id = @$rslt_dta[0]['ITEM_CONDITION'];
        $seed_id = @$rslt_dta[0]['SEED_ID'];
        //$auth_by_id = $this->session->userdata('auth_by_id');
        $list_qty = 0;

        $insert_query = $this->db->query("INSERT INTO ebay_list_mt (LIST_ID, LZ_MANIFEST_ID, LISTING_NO, ITEM_ID, LIST_DATE, LISTER_ID, EBAY_ITEM_DESC, LIST_QTY, EBAY_ITEM_ID, LIST_PRICE, REMARKS, SINGLE_ENTRY_ID, SALVAGE_QTY, ENTRY_TYPE, LZ_SELLER_ACCT_ID, SEED_ID, STATUS, ITEM_CONDITION, FORCEREVISE)VALUES (" . $LIST_ID . "," . $manifest_id . ", " . $LIST_ID . ", " . $item_id . ", " . $list_date . ", " . $lister_id . ", '" . $ebay_item_desc . "', " . $list_qty . "," . $ebay_item_id . ",'" . $list_price . "',NULL,NULL, NULL, '" . $entry_type . "'," . $LZ_SELLER_ACCT_ID . "," . $seed_id . ",'" . trim($status) . "'," . $condition_id . "," . @$forceRevise . ")");
        if ($insert_query) {
            $update_barcode_qry = "UPDATE LZ_BARCODE_MT SET LIST_ID = $LIST_ID WHERE ITEM_ID= $item_id AND LZ_MANIFEST_ID = $manifest_id AND CONDITION_ID = $condition_id AND EBAY_ITEM_ID IS NOT NULL AND LIST_ID IS NOT NULL AND SALE_RECORD_NO IS NULL AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND HOLD_STATUS = 0";
            $this->db->query($update_barcode_qry);
            $this->db->query("UPDATE LZ_LISTING_ALLOC SET LIST_ID = $LIST_ID WHERE SEED_ID = $seed_id");
            $this->db->query("UPDATE lz_item_seed SET EBAY_PRICE = '$price' WHERE SEED_ID = '$seed_id'");
            return $LIST_ID;
        }

    }

    public function pic_log()
    {
        $user_id = $this->uri->segment(4);

        $data = $this->db->query("SELECT BARCODE_NO , NO_OF_PIC , TO_CHAR(PIC_DATE, 'DD/MM/YYYY HH24:MI:SS') PIC_DATE FROM LZ_PIC_LOG  WHERE PIC_DATE >= TO_DATE(SYSDATE, 'DD-MON-YY') AND PIC_BY = '$user_id'  ORDER BY PIC_DATE DESC ")->result_array();
        return $data;
    }

    public function merch_servic_invoice()
    {

        $merchant_id = $this->input->post('merchant_id');
        //var_dump($merchant_id);
        // if(!empty($merchant_id)){
        //   $
        // }

        $mer_inv = $this->db->query("SELECT DECODE(MAX(SER_NAME), NULL, '-', MAX(SER_NAME)) SERVICE_NAME, MAX(SERV_TYPE) SER_TYPE, CASE WHEN COUNT(EBAY_ITEM_ID) > 0 THEN ROUND(NVL(SUM(CHARGES) / COUNT(TO_CHAR(EBAY_ITEM_ID)), 0), 4) ELSE NVL(SUM(CHARGES) / NULL, 0) END RATE, COUNT(EBAY_ITEM_ID) TOTAL_COUNT, NVL(SUM(CHARGES), 0) TOTAL_CAHRGES, MAX(SER_RATE_ID) RATE_ID, MAX(MERCHANT_ID) MERCHANT_ID, '-' DURATION FROM (SELECT D.BARCODE_NO, L.BARCODE_PRV_NO, L.PIC_DATE_TIME, BINV.CHARGES, L.LZ_MANIFEST_DET_ID, B.ITEM_ID, B.LZ_MANIFEST_ID, RA.SER_RATE_ID, M.MERCHANT_ID, (SELECT SD.EBAY_PRICE FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO) TOTAL_VAL, (SELECT SD.EBAY_PRICE FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO AND B.EBAY_ITEM_ID IS NOT NULL) LIST_VAL, (SELECT SD.EBAY_PRICE FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO AND B.EBAY_ITEM_ID IS NULL) NOT_LIST_VAL, (SELECT SD.EBAY_PRICE FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO AND B.EBAY_ITEM_ID IS NOT NULL AND B.SALE_RECORD_NO IS NOT NULL) SOLD_VALUE, (SELECT SB.SERVICE_DESC FROM LJ_SERVICES SB WHERE SB.SERVICE_ID = RA.SERVICE_ID) SER_NAME, DECODE(RA.SERVICE_TYPE, 1, 'PER_BARC', 2, 'PER_HOUR') SERV_TYPE, B.EBAY_ITEM_ID, B.SALE_RECORD_NO FROM LZ_MERCHANT_BARCODE_MT M, LZ_MERCHANT_BARCODE_DT D, LZ_SPECIAL_LOTS        L, LZ_BARCODE_MT          B, LJ_BARCODE_BILLING     BINV, LJ_SERVICE_RATE        RA WHERE M.MT_ID = D.MT_ID AND D.BARCODE_NO = L.BARCODE_PRV_NO(+) AND L.BARCODE_PRV_NO = B.BARCODE_NO(+) AND L.BARCODE_PRV_NO = BINV.BARCODE_NO(+) AND BINV.INVOICE_ID IS NULL AND B.EBAY_ITEM_ID IS NOT NULL AND BINV.SER_RATE_ID = 2 AND BINV.SER_RATE_ID = RA.SER_RATE_ID(+) AND M.MERCHANT_ID = $merchant_id) UNION ALL SELECT DECODE(MAX(SER_NAME), NULL, '-', MAX(SER_NAME)) SERVICE_NAME, MAX(SERV_TYPE) SER_TYPE, ROUND(SUM(CHRG) / COUNT(BARCODE_PRV_NO), 4) RATE, COUNT(FOLDER_NAME) TOTAL_COUNT, (ROUND(SUM(CHRG) / COUNT(BARCODE_PRV_NO), 4)) * COUNT(FOLDER_NAME) TOTAL_CAHRGES, MAX(SER_RATE_ID) RATE_ID, MAX(MERCHANT_ID) MERCHANT_ID, '-' DURATION FROM (SELECT L.FOLDER_NAME, L.BARCODE_PRV_NO, ROUND(BINV.CHARGES, 2) CHRG, DECODE(RA.SERVICE_TYPE, 1, 'PER_BARC', 2, 'PER_HOUR') SERV_TYPE, RA.SER_RATE_ID, M.MERCHANT_ID, SR.SERVICE_DESC SER_NAME FROM LZ_MERCHANT_BARCODE_MT M, LZ_MERCHANT_BARCODE_DT D, LZ_SPECIAL_LOTS        L, LJ_BARCODE_BILLING     BINV, LJ_SERVICE_RATE        RA, LJ_SERVICES            SR, LZ_BARCODE_MT          B WHERE M.MT_ID = D.MT_ID AND D.BARCODE_NO = L.BARCODE_PRV_NO(+) AND L.BARCODE_PRV_NO = B.BARCODE_NO(+) AND L.BARCODE_PRV_NO = BINV.BARCODE_NO(+) AND BINV.SER_RATE_ID = 1 AND BINV.SER_RATE_ID = RA.SER_RATE_ID(+) AND BINV.INVOICE_ID IS NULL AND RA.SERVICE_ID = SR.SERVICE_ID AND M.MERCHANT_ID = $merchant_id AND BINV.INVOICE_ID IS NULL) UNION ALL SELECT MAX(SERVICE_NAME) SERVICE_NAME, MAX(SER_TYPE) SER_TYPE, ROUND(SUM(CHARGES) / SUM(TOTAL_COUNT), 4) RATE, SUM(TOTAL_COUNT) TOTAL_COUNT, SUM(CHARGES) TOTAL_CAHRGES, MAX(RATE_ID) RATE_ID, MAX(MERCHANT_ID) MERCHANT_ID, '-' DURATION FROM (SELECT MAX(SV.SERVICE_DESC) SERVICE_NAME, DECODE(MAX(RA.SERVICE_TYPE), 1, 'PER_BARC', 2, 'PER_HOUR', 3, 'PER_ORDER') SER_TYPE, NVL(MAX(M.SHIPING_LABEL_RATE), 0) SHIPING_RATE, SUM(PM.PACKING_COST) PACKING_COST, nvl(SUM(dt.PACKING_COST) + nvl(MAX(M.SHIPING_LABEL_RATE), 0) + nvl(max(m.ebay_fee), 0) + NVL((7 / 100) * NVL(MAX(m.SALE_PRICE * m.qty), 0), 0), 0) CHARGES, COUNT(DISTINCT M.ORDER_ID) TOTAL_COUNT, MAX(M.SER_RATE_ID) RATE_ID, MAX(M.MERCHANT_ID) MERCHANT_ID FROM LJ_ORDER_PACKING_MT M, LJ_ORDER_PACKING_DT DT, LZ_PACKING_TYPE_MT  PM, lj_service_rate     ra, lj_services         sv WHERE M.ORDER_PACKING_ID = DT.ORDER_PACKING_ID and m.ser_rate_id = ra.ser_rate_id(+) and ra.service_id = sv.service_id(+) AND DT.PACKING_ID = PM.PACKING_ID(+) AND M.MERCHANT_ID = $merchant_id AND M.INVOICE_ID IS NULL GROUP BY dt.order_packing_id) UNION ALL SELECT DECODE(MAX(SER_NAME), NULL, '-', MAX(SER_NAME)) SERVICE_NAME, MAX(SERV_TYPE) SER_TYPE, CASE WHEN COUNT(ITEM_ID) > 0 THEN ROUND(NVL(SUM(CHARGES) / COUNT(TO_CHAR(ITEM_ID)), 0), 4) ELSE NVL(SUM(CHARGES) / NULL, 0) END RATE, COUNT(ITEM_ID) TOTAL_COUNT, NVL(SUM(CHARGES), 0) TOTAL_CAHRGES, MAX(SER_RATE_ID) RATE_ID, MAX(MERCHANT_ID) MERCHANT_ID, '-' DURATION FROM (SELECT D.BARCODE_NO, L.BARCODE_PRV_NO, L.PIC_DATE_TIME, BINV.CHARGES, L.LZ_MANIFEST_DET_ID, B.ITEM_ID, B.LZ_MANIFEST_ID, RA.SER_RATE_ID, M.MERCHANT_ID, (SELECT SD.EBAY_PRICE FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO) TOTAL_VAL, (SELECT SD.EBAY_PRICE FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO AND B.EBAY_ITEM_ID IS NOT NULL) LIST_VAL, (SELECT SD.EBAY_PRICE FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO AND B.EBAY_ITEM_ID IS NULL) NOT_LIST_VAL, (SELECT SD.EBAY_PRICE FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO AND B.EBAY_ITEM_ID IS NOT NULL AND B.SALE_RECORD_NO IS NOT NULL) SOLD_VALUE, (SELECT SB.SERVICE_DESC FROM LJ_SERVICES SB WHERE SB.SERVICE_ID = RA.SERVICE_ID) SER_NAME, DECODE(RA.SERVICE_TYPE, 1, 'PER_BARC', 2, 'PER_HOUR') SERV_TYPE, B.EBAY_ITEM_ID, B.SALE_RECORD_NO FROM LZ_MERCHANT_BARCODE_MT M, LZ_MERCHANT_BARCODE_DT D, LZ_SPECIAL_LOTS        L, LZ_BARCODE_MT          B, LJ_BARCODE_BILLING     BINV, LJ_SERVICE_RATE        RA WHERE M.MT_ID = D.MT_ID AND D.BARCODE_NO = L.BARCODE_PRV_NO(+) AND L.BARCODE_PRV_NO = B.BARCODE_NO(+) AND L.BARCODE_PRV_NO = BINV.BARCODE_NO(+) AND BINV.INVOICE_ID IS NULL AND BINV.SER_RATE_ID = 6 AND BINV.SER_RATE_ID = RA.SER_RATE_ID(+) AND M.MERCHANT_ID = $merchant_id) UNION ALL SELECT MAX(SERVICE_DESC) SERVICE_NAME, MAX(SERV_TYPE) SER_TYPE, MAX(CHARGES) RATE, count(barcode_no) TOTAL_COUNT, NVL(SUM(TOT_CHARGE), 0) TOTAL_CAHRGES, MAX(SER_RATE_ID) RATE_ID, MAX(MERCHANT_ID) MERCHANT_ID, TO_CHAR(TRUNC(sum(get_sec) / 3600), 'FM9900') || ' hrs: ' || TO_CHAR(TRUNC(MOD(sum(get_sec), 3600) / 60), 'FM00') || ' min: ' || TO_CHAR(MOD(sum(get_sec), 60), 'FM00') || ' sec' Duration FROM (SELECT SR.CHARGES, SV.SERVICE_DESC, DECODE(SR.SERVICE_TYPE, 1, 'PER_BARC', 2, 'PER_HOUR') SERV_TYPE, SR.SERVICE_ID, (SR.CHARGES / 60) / 60 * TO_NUMBER(((LG.STOP_TIME - LG.START_TIME) * 24) * 60 * 60) TOT_CHARGE, TO_NUMBER(((LG.STOP_TIME - LG.START_TIME) * 24) * 60 * 60) get_sec, SR.SER_RATE_ID, MA.MERCHANT_ID, MA.APPOINTMENT_ID, lg.barcode_no FROM LJ_APPOINTMENT_MT  MA, LJ_APPOINTMENT_DT  DA, LJ_SERVICE_RATE    SR, LJ_SERVICES        SV, LJ_APPOINTMENT_LOG LG WHERE MA.APPOINTMENT_ID = DA.APPOINTMENT_ID AND DA.APPOINTMENT_DT_ID = LG.APPOINTMENT_DT_ID(+) AND LG.INV_ID IS NULL AND DA.SERVICE_ID = SV.SERVICE_ID AND SV.SERVICE_ID = SR.SERVICE_ID AND MA.MERCHANT_ID = $merchant_id ORDER BY LG.APPOINTMENT_LOG_ID ASC) GROUP BY SERVICE_ID, SERVICE_DESC ")->result_array();

        if (count($mer_inv) >= 1) {
            return array('mer_inv' => $mer_inv, 'exist' => true);
        } else {
            return array('mer_inv' => $mer_inv, 'exist' => false);
        }

    }

    public function merch_servic_invoice_barcode()
    {

        $merchant_id = $this->input->post('merchant_id');
        $rate_id = $this->input->post('rate_id');
        // var_dump($merchant_id);
        // var_dump($rate_id );
        //echo $servRateId;

        if ($rate_id == 2) {

            $mer_inv_barcode = $this->db->query("SELECT ROWNUM PK, B.EBAY_ITEM_ID, 'NULL' DURATION,'null' ORDER_ID,'null' SHIPING_RATE,'null' MARKTPLACE,'null' PACKING_COST,'null' SALES_RECORD_NUMBER,'null' eba_fee,'null' QTY,B.BARCODE_NO, SD.ITEM_TITLE, SD.EBAY_PRICE, CO.COND_NAME DEFAULT_COND, L.BARCODE_PRV_NO, L.PIC_DATE_TIME, BINV.CHARGES, L.LZ_MANIFEST_DET_ID, B.ITEM_ID, B.LZ_MANIFEST_ID, (SELECT SD.EBAY_PRICE FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO) TOTAL_VAL, (SELECT SD.EBAY_PRICE FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO AND B.EBAY_ITEM_ID IS NOT NULL) LIST_VAL, (SELECT SD.EBAY_PRICE FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO AND B.EBAY_ITEM_ID IS NULL) NOT_LIST_VAL, (SELECT SD.EBAY_PRICE FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO AND B.EBAY_ITEM_ID IS NOT NULL AND B.SALE_RECORD_NO IS NOT NULL) SOLD_VALUE, (SELECT SB.SERVICE_DESC FROM LJ_SERVICES SB WHERE SB.SERVICE_ID = RA.SERVICE_ID) SER_NAME, DECODE(RA.SERVICE_TYPE, 1, 'PER_BARCODE', 2, 'PER_HOUR') SERV_TYPE, RA.SER_RATE_ID, B.EBAY_ITEM_ID, B.SALE_RECORD_NO FROM LZ_MERCHANT_BARCODE_MT M, LZ_MERCHANT_BARCODE_DT D, LZ_SPECIAL_LOTS L, LZ_BARCODE_MT B, LJ_BARCODE_BILLING  BINV, LJ_SERVICE_RATE   RA, LZ_ITEM_SEED   SD,LZ_ITEM_COND_MT CO WHERE M.MT_ID = D.MT_ID AND D.BARCODE_NO = L.BARCODE_PRV_NO(+) AND L.BARCODE_PRV_NO = B.BARCODE_NO(+) AND L.BARCODE_PRV_NO = BINV.BARCODE_NO(+) AND BINV.SER_RATE_ID = $rate_id AND BINV.SER_RATE_ID = RA.SER_RATE_ID(+) AND BINV.INVOICE_ID IS  NULL AND B.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID (+)AND B.ITEM_ID = SD.ITEM_ID(+) AND B.CONDITION_ID = SD.DEFAULT_COND(+) AND SD.DEFAULT_COND = CO.ID(+) AND B.EBAY_ITEM_ID IS NOT NULL AND M.MERCHANT_ID = $merchant_id ")->result_array();

        } elseif ($rate_id == 6) {

            $mer_inv_barcode = $this->db->query("SELECT ROWNUM PK, B.EBAY_ITEM_ID, 'NULL' DURATION,'null' ORDER_ID,'null' SHIPING_RATE,'null' MARKTPLACE,'null' PACKING_COST,'null' SALES_RECORD_NUMBER,'null' eba_fee,'null' QTY,B.BARCODE_NO, SD.ITEM_TITLE, SD.EBAY_PRICE, CO.COND_NAME DEFAULT_COND, L.BARCODE_PRV_NO, L.PIC_DATE_TIME, BINV.CHARGES, L.LZ_MANIFEST_DET_ID, B.ITEM_ID, B.LZ_MANIFEST_ID, (SELECT SD.EBAY_PRICE FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO) TOTAL_VAL, (SELECT SD.EBAY_PRICE FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO AND B.EBAY_ITEM_ID IS NOT NULL) LIST_VAL, (SELECT SD.EBAY_PRICE FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO AND B.EBAY_ITEM_ID IS NULL) NOT_LIST_VAL, (SELECT SD.EBAY_PRICE FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO AND B.EBAY_ITEM_ID IS NOT NULL AND B.SALE_RECORD_NO IS NOT NULL) SOLD_VALUE, (SELECT SB.SERVICE_DESC FROM LJ_SERVICES SB WHERE SB.SERVICE_ID = RA.SERVICE_ID) SER_NAME, DECODE(RA.SERVICE_TYPE, 1, 'PER_BARCODE', 2, 'PER_HOUR') SERV_TYPE, RA.SER_RATE_ID, B.EBAY_ITEM_ID, B.SALE_RECORD_NO FROM LZ_MERCHANT_BARCODE_MT M, LZ_MERCHANT_BARCODE_DT D, LZ_SPECIAL_LOTS L, LZ_BARCODE_MT B, LJ_BARCODE_BILLING  BINV, LJ_SERVICE_RATE   RA, LZ_ITEM_SEED   SD,LZ_ITEM_COND_MT CO WHERE M.MT_ID = D.MT_ID AND D.BARCODE_NO = L.BARCODE_PRV_NO(+) AND L.BARCODE_PRV_NO = B.BARCODE_NO(+) AND L.BARCODE_PRV_NO = BINV.BARCODE_NO(+) AND BINV.SER_RATE_ID = $rate_id AND BINV.SER_RATE_ID = RA.SER_RATE_ID(+) AND BINV.INVOICE_ID IS  NULL AND B.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID (+)AND B.ITEM_ID = SD.ITEM_ID(+) AND B.CONDITION_ID = SD.DEFAULT_COND(+) AND SD.DEFAULT_COND = CO.ID(+) /*AND B.EBAY_ITEM_ID IS NOT NULL*/ AND M.MERCHANT_ID = $merchant_id ")->result_array();

        } elseif ($rate_id == 3) {

            $mer_inv_barcode = $this->db->query(" SELECT lg.BARCODE_NO, 'NULL' ORDER_ID, decode(BB.EBAY_ITEM_ID,null,'Not Listed',BB.EBAY_ITEM_ID) EBAY_ITEM_ID, decode(S.ITEM_TITLE,null,'Not Posted',S.ITEM_TITLE) ITEM_TITLE, S.EBAY_PRICE, 'NULL' EBA_FEE, 'NULL' SHIPING_RATE, 'NULL' MARKTPLACE, 'NULL' PACKING_COST, 'NULL' SALES_RECORD_NUMBER, 'NULL' QTY, 'NULL' SALES_RECORD_NUMBER, CM.COND_NAME DEFAULT_COND, SR.SERVICE_ID, /*TO_NUMBER(((LG.STOP_TIME - LG.START_TIME) * 24)) DIFF_IN_HOUR, TO_NUMBER(((LG.STOP_TIME - LG.START_TIME) * 24) * 60) DIFF_IN_MIN, TO_NUMBER(((LG.STOP_TIME - LG.START_TIME) * 24) * 60 * 60) DIFF_IN_SECNDS,*/ TO_CHAR(TRUNC(((86400 * (LG.STOP_TIME - LG.START_TIME)) / 60) / 60) - 24 * (TRUNC((((86400 * (LG.STOP_TIME - LG.START_TIME)) / 60) / 60) / 24))) || ' H:' || TO_CHAR(TRUNC((86400 * (LG.STOP_TIME - LG.START_TIME)) / 60) - 60 * (TRUNC(((86400 * (LG.STOP_TIME - LG.START_TIME)) / 60) / 60))) || ' M: ' || TO_CHAR(TRUNC(86400 * (LG.STOP_TIME - LG.START_TIME)) - 60 * (TRUNC((86400 * (LG.STOP_TIME - LG.START_TIME)) / 60))) || ' S' DURATION, ROUND((SR.CHARGES / 60) / 60 * TO_NUMBER(((LG.STOP_TIME - LG.START_TIME) * 24) * 60 * 60), 2) CHARGES, SR.SER_RATE_ID, MA.MERCHANT_ID, MA.APPOINTMENT_ID, LG.BARCODE_NO, LG.INV_ID FROM LJ_APPOINTMENT_MT  MA, LJ_APPOINTMENT_DT  DA, LJ_SERVICE_RATE    SR, LJ_SERVICES        SV, LJ_APPOINTMENT_LOG LG, LZ_BARCODE_MT      BB, LZ_ITEM_SEED       S, LZ_ITEM_COND_MT    CM WHERE MA.APPOINTMENT_ID = DA.APPOINTMENT_ID AND DA.APPOINTMENT_DT_ID = LG.APPOINTMENT_DT_ID(+) AND DA.SERVICE_ID = SV.SERVICE_ID AND SV.SERVICE_ID = SR.SERVICE_ID AND BB.LZ_MANIFEST_ID = S.LZ_MANIFEST_ID(+) AND BB.ITEM_ID = S.ITEM_ID(+) AND BB.CONDITION_ID = S.DEFAULT_COND(+) AND LG.BARCODE_NO = BB.BARCODE_NO(+) AND S.DEFAULT_COND = CM.ID(+)  and lg.barcode_no is not null AND MA.MERCHANT_ID = $merchant_id AND LG.INV_ID IS NULL ORDER BY LG.APPOINTMENT_LOG_ID ASC ")->result_array();

        } elseif ($rate_id == 5) {

            $mer_inv_barcode = $this->db->query("SELECT M.ORDER_ID BARCODE_NO, 'NULL' DURATION, 'NULL' ORDER_ID, MAX(M.EBAY_ID) EBAY_ITEM_ID, MAX(M.ITEM_TITLE) ITEM_TITLE, NVL(MAX(M.SHIPING_LABEL_RATE), 0) SHIPING_RATE, SUM(PM.PACKING_COST) PACKING_COST, NVL(SUM(DT.PACKING_COST) + NVL(MAX(M.SHIPING_LABEL_RATE), 0) + NVL(MAX(M.EBAY_FEE), 0) + NVL((7 / 100) * NVL(MAX(M.SALE_PRICE * M.QTY), 0), 0), 0) CHARGES, NVL((7 / 100) * NVL(MAX(M.SALE_PRICE * M.QTY), 0), 0) MARKTPLACE, MAX(M.EBAY_FEE) EBA_FEE, '' DEFAULT_COND, NVL(MAX(M.SALE_PRICE * M.QTY), 0) EBAY_PRICE, MAX(M.QTY) QTY, MAX(M.SALE_RECRD_NUM) SALES_RECORD_NUMBER FROM LJ_ORDER_PACKING_MT M, LJ_ORDER_PACKING_DT DT, LZ_PACKING_TYPE_MT PM WHERE M.ORDER_PACKING_ID = DT.ORDER_PACKING_ID AND DT.PACKING_ID = PM.PACKING_ID(+) AND M.MERCHANT_ID = $merchant_id AND M.INVOICE_ID IS NULL GROUP BY M.ORDER_ID ")->result_array();

        } elseif ($rate_id == 1) {

            $mer_inv_barcode = $this->db->query("SELECT B.EBAY_ITEM_ID   EBAY_ITEM_ID,'NULL' DURATION, 'null' ORDER_ID,'null' MARKTPLACE,'null' SHIPING_RATE,'null' SALES_RECORD_NUMBER,'null' PACKING_COST,'null' eba_fee,'null' QTY,L.FOLDER_NAME, L.BARCODE_PRV_NO BARCODE_NO, SD.ITEM_TITLE    ITEM_TITLE, SD.EBAY_PRICE    EBAY_PRICE, CO.COND_NAME     DEFAULT_COND, BINV.CHARGES     CHARGES FROM LZ_MERCHANT_BARCODE_MT M, LZ_MERCHANT_BARCODE_DT D, LZ_SPECIAL_LOTS        L, LJ_BARCODE_BILLING     BINV, LJ_SERVICE_RATE        RA, LJ_SERVICES            SR, LZ_BARCODE_MT          B, LZ_ITEM_SEED           SD, LZ_ITEM_COND_MT        CO WHERE M.MT_ID = D.MT_ID AND D.BARCODE_NO = L.BARCODE_PRV_NO(+) AND L.BARCODE_PRV_NO = B.BARCODE_NO(+) AND L.BARCODE_PRV_NO = BINV.BARCODE_NO(+) AND BINV.SER_RATE_ID = 1 AND BINV.SER_RATE_ID = RA.SER_RATE_ID(+) AND BINV.INVOICE_ID IS NULL AND RA.SERVICE_ID = SR.SERVICE_ID AND B.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID(+) AND B.ITEM_ID = SD.ITEM_ID(+) AND B.CONDITION_ID = SD.DEFAULT_COND(+) AND SD.DEFAULT_COND = CO.ID(+) AND M.MERCHANT_ID = $merchant_id order by b.EBAY_ITEM_ID asc")->result_array();

        } elseif ($rate_id == 7) {

            $mer_inv_barcode = $this->db->query("SELECT B.EBAY_ITEM_ID ,'NULL' DURATION,EBAY_ITEM_ID,S.ORDER_ID,'null' MARKTPLACE,'null' SHIPING_RATE,'null' SALES_RECORD_NUMBER,'null' QTY,'null' eba_fee,'null' PACKING_COST, L.BARCODE_PRV_NO BARCODE_NO, SD.ITEM_TITLE    ITEM_TITLE, SD.EBAY_PRICE    EBAY_PRICE, CO.COND_NAME     DEFAULT_COND, BINV.CHARGES     CHARGES FROM LZ_MERCHANT_BARCODE_MT M, LZ_MERCHANT_BARCODE_DT D, LZ_SPECIAL_LOTS        L, LJ_BARCODE_BILLING     BINV, LJ_SERVICE_RATE        RA, LJ_SERVICES            SR, LZ_BARCODE_MT          B, LZ_ITEM_SEED           SD, LZ_ITEM_COND_MT        CO, LZ_SALESLOAD_DET       S WHERE M.MT_ID = D.MT_ID AND D.BARCODE_NO = L.BARCODE_PRV_NO(+) AND L.BARCODE_PRV_NO = B.BARCODE_NO(+) AND L.BARCODE_PRV_NO = BINV.BARCODE_NO(+) AND BINV.SER_RATE_ID = 7 AND BINV.SER_RATE_ID = RA.SER_RATE_ID(+) AND BINV.INVOICE_ID IS NULL AND RA.SERVICE_ID = SR.SERVICE_ID AND B.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID(+) AND B.ITEM_ID = SD.ITEM_ID(+) AND B.CONDITION_ID = SD.DEFAULT_COND(+) AND SD.DEFAULT_COND = CO.ID(+) AND B.ORDER_ID = S.ORDER_ID /*AND B.SALE_RECORD_NO = S.SALES_RECORD_NUMBER */AND S.ORDER_ID IS NOT NULL AND M.MERCHANT_ID = $merchant_id ORDER BY BINV.CHARGES desc ")->result_array();
        }

        if (count($mer_inv_barcode) >= 1) {
            return array('mer_inv_barcode' => $mer_inv_barcode, 'exist' => true);
        } else {
            return array('mer_inv_barcode' => $mer_inv_barcode, 'exist' => false);
        }

    }

    public function generate_invoic()
    {

        $ids = $this->input->post('ids');
        // var_dump($ids);
        // return $ids;
        $serRateId = $this->input->post('serRateId');
        $merchantId = $this->input->post('merchantId');

        $chek_temp_data = $this->db->query("SELECT T.INV_MT_ID_TEMP FROM LJ_INOVICE_MT_TEMP T WHERE T.SER_RATE_ID = $serRateId AND T.MERCHANT_ID = $merchantId ")->result_array();

        if (count($chek_temp_data) > 0) {
            $get_temp_mt_id = $chek_temp_data[0]['INV_MT_ID_TEMP'];

            $delte_from_det = $this->db->query("DELETE FROM LJ_INOVICE_DT_TEMP WHERE INV_MT_ID_TEMP = $get_temp_mt_id ");
            if ($delte_from_det) {
                $this->db->query("DELETE FROM LJ_INOVICE_MT_TEMP WHERE INV_MT_ID_TEMP = $get_temp_mt_id ");
                $get_pk = $this->db->query(" SELECT GET_SINGLE_PRIMARY_KEY('LJ_INOVICE_MT_TEMP','INV_MT_ID_TEMP') INV_MT_ID_TEMP FROM DUAL")->result_array();
                $get_pk = $get_pk[0]['INV_MT_ID_TEMP'];

                $inser_mt = $this->db->query(" INSERT INTO LJ_INOVICE_MT_TEMP (INV_MT_ID_TEMP, SER_RATE_ID, MERCHANT_ID, CREATED_DATE, CREATED_BY) VALUES ($get_pk,$serRateId,$merchantId, SYSDATE, 2)");

                if ($inser_mt) {
                    $i = 0;
                    foreach ($ids as $barocdes) {

                        $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LJ_INOVICE_DT_TEMP', 'INV_DET_ID_TEMP')INV_DET_ID_TEMP FROM DUAL")->result_array();
                        $lz_dekit_us_dt_id = $qry[0]['INV_DET_ID_TEMP'];

                        $insert_est_det = $this->db->query(" INSERT INTO LJ_INOVICE_DT_TEMP (INV_DET_ID_TEMP, INV_MT_ID_TEMP, TEMP_PARAMETER) VALUES ($lz_dekit_us_dt_id, $get_pk, '$barocdes' )");

                        $i++;
                    } /// end foreach
                    if ($insert_est_det) {
                        return true;
                    }

                }
            }

        } else {

            $get_pk = $this->db->query(" SELECT GET_SINGLE_PRIMARY_KEY('LJ_INOVICE_MT_TEMP','INV_MT_ID_TEMP') INV_MT_ID_TEMP FROM DUAL")->result_array();
            $get_pk = $get_pk[0]['INV_MT_ID_TEMP'];

            $inser_mt = $this->db->query(" INSERT INTO LJ_INOVICE_MT_TEMP (INV_MT_ID_TEMP, SER_RATE_ID, MERCHANT_ID, CREATED_DATE, CREATED_BY) VALUES ($get_pk,$serRateId,$merchantId, SYSDATE, 2)");

            if ($inser_mt) {
                $i = 0;
                foreach ($ids as $barocdes) {

                    $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LJ_INOVICE_DT_TEMP', 'INV_DET_ID_TEMP')INV_DET_ID_TEMP FROM DUAL")->result_array();
                    $lz_dekit_us_dt_id = $qry[0]['INV_DET_ID_TEMP'];

                    $insert_est_det = $this->db->query(" INSERT INTO LJ_INOVICE_DT_TEMP (INV_DET_ID_TEMP, INV_MT_ID_TEMP, TEMP_PARAMETER) VALUES ($lz_dekit_us_dt_id, $get_pk, '$barocdes' )");

                    $i++;
                } /// end foreach
                if ($insert_est_det) {
                    return true;
                }
            }

        }

    }

    public function load_merchant()
    {

        $load_merch = $this->db->query("SELECT M.MERCHANT_ID,M.BUISNESS_NAME FROM LZ_MERCHANT_MT M ORDER BY M.MERCHANT_ID DESC")->result_array();
        return array('load_merch' => $load_merch);
    }
    public function merch_generate_invoice()
    {

        $serId = $this->input->post('serId');
        $merchant_id = $this->input->post('merchant_id');

        $invoice_query = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LJ_INVOICE_MT', 'INVOICE_ID') INVID FROM DUAL")->result_array();
        $invoice_id = $invoice_query[0]['INVID'];

        $inser_invoice = $this->db->query("INSERT INTO LJ_INVOICE_MT (INVOICE_ID, MERCHANT_ID, CREATED_DATE, INVOICE_NO, DUE_DATE, REMARKS) VALUES ($invoice_id, $merchant_id, SYSDATE, $invoice_id, SYSDATE, NULL)");

        if ($inser_invoice) {

            $i = 0;
            foreach ($serId as $serviceRateId) {

                $query = $this->db->query("call  pro_generate_inovice($serviceRateId,$merchant_id,$invoice_id)");

                $i++;
            }

            // $query = $this->db->query("");

            if ($query) {
                $mer_inv = $this->db->query("SELECT DECODE(MAX(SER_NAME), NULL, '-', MAX(SER_NAME)) SERVICE_NAME, MAX(SERV_TYPE) SER_TYPE, CASE WHEN COUNT(EBAY_ITEM_ID) > 0 THEN ROUND(NVL(SUM(CHARGES) / COUNT(TO_CHAR(EBAY_ITEM_ID)), 0), 4) ELSE NVL(SUM(CHARGES) / NULL, 0) END RATE, COUNT(EBAY_ITEM_ID) TOTAL_COUNT, NVL(SUM(CHARGES), 0) TOTAL_CAHRGES, MAX(SER_RATE_ID) RATE_ID, MAX(MERCHANT_ID) MERCHANT_ID, '-' DURATION FROM (SELECT D.BARCODE_NO, L.BARCODE_PRV_NO, L.PIC_DATE_TIME, BINV.CHARGES, L.LZ_MANIFEST_DET_ID, B.ITEM_ID, B.LZ_MANIFEST_ID, RA.SER_RATE_ID, M.MERCHANT_ID, (SELECT SD.EBAY_PRICE FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO) TOTAL_VAL, (SELECT SD.EBAY_PRICE FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO AND B.EBAY_ITEM_ID IS NOT NULL) LIST_VAL, (SELECT SD.EBAY_PRICE FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO AND B.EBAY_ITEM_ID IS NULL) NOT_LIST_VAL, (SELECT SD.EBAY_PRICE FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO AND B.EBAY_ITEM_ID IS NOT NULL AND B.SALE_RECORD_NO IS NOT NULL) SOLD_VALUE, (SELECT SB.SERVICE_DESC FROM LJ_SERVICES SB WHERE SB.SERVICE_ID = RA.SERVICE_ID) SER_NAME, DECODE(RA.SERVICE_TYPE, 1, 'PER_BARC', 2, 'PER_HOUR') SERV_TYPE, B.EBAY_ITEM_ID, B.SALE_RECORD_NO FROM LZ_MERCHANT_BARCODE_MT M, LZ_MERCHANT_BARCODE_DT D, LZ_SPECIAL_LOTS        L, LZ_BARCODE_MT          B, LJ_BARCODE_BILLING     BINV, LJ_SERVICE_RATE        RA WHERE M.MT_ID = D.MT_ID AND D.BARCODE_NO = L.BARCODE_PRV_NO(+) AND L.BARCODE_PRV_NO = B.BARCODE_NO(+) AND L.BARCODE_PRV_NO = BINV.BARCODE_NO(+) AND BINV.INVOICE_ID IS NULL AND B.EBAY_ITEM_ID IS NOT NULL AND BINV.SER_RATE_ID = 2 AND BINV.SER_RATE_ID = RA.SER_RATE_ID(+) AND M.MERCHANT_ID = $merchant_id) UNION ALL SELECT DECODE(MAX(SER_NAME), NULL, '-', MAX(SER_NAME)) SERVICE_NAME, MAX(SERV_TYPE) SER_TYPE, ROUND(SUM(CHRG) / COUNT(BARCODE_PRV_NO), 4) RATE, COUNT(FOLDER_NAME) TOTAL_COUNT, (ROUND(SUM(CHRG) / COUNT(BARCODE_PRV_NO), 4)) * COUNT(FOLDER_NAME) TOTAL_CAHRGES, MAX(SER_RATE_ID) RATE_ID, MAX(MERCHANT_ID) MERCHANT_ID, '-' DURATION FROM (SELECT L.FOLDER_NAME, L.BARCODE_PRV_NO, ROUND(BINV.CHARGES, 2) CHRG, DECODE(RA.SERVICE_TYPE, 1, 'PER_BARC', 2, 'PER_HOUR') SERV_TYPE, RA.SER_RATE_ID, M.MERCHANT_ID, SR.SERVICE_DESC SER_NAME FROM LZ_MERCHANT_BARCODE_MT M, LZ_MERCHANT_BARCODE_DT D, LZ_SPECIAL_LOTS        L, LJ_BARCODE_BILLING     BINV, LJ_SERVICE_RATE        RA, LJ_SERVICES            SR, LZ_BARCODE_MT          B WHERE M.MT_ID = D.MT_ID AND D.BARCODE_NO = L.BARCODE_PRV_NO(+) AND L.BARCODE_PRV_NO = B.BARCODE_NO(+) AND L.BARCODE_PRV_NO = BINV.BARCODE_NO(+) AND BINV.SER_RATE_ID = 1 AND BINV.SER_RATE_ID = RA.SER_RATE_ID(+) AND BINV.INVOICE_ID IS NULL AND RA.SERVICE_ID = SR.SERVICE_ID AND M.MERCHANT_ID = $merchant_id AND BINV.INVOICE_ID IS NULL) UNION ALL SELECT MAX(SERVICE_NAME) SERVICE_NAME, MAX(SER_TYPE) SER_TYPE, ROUND(SUM(CHARGES) / SUM(TOTAL_COUNT), 4) RATE, SUM(TOTAL_COUNT) TOTAL_COUNT, SUM(CHARGES) TOTAL_CAHRGES, MAX(RATE_ID) RATE_ID, MAX(MERCHANT_ID) MERCHANT_ID, '-' DURATION FROM (SELECT MAX(SV.SERVICE_DESC) SERVICE_NAME, DECODE(MAX(RA.SERVICE_TYPE), 1, 'PER_BARC', 2, 'PER_HOUR', 3, 'PER_ORDER') SER_TYPE, NVL(MAX(M.SHIPING_LABEL_RATE), 0) SHIPING_RATE, SUM(PM.PACKING_COST) PACKING_COST, nvl(SUM(dt.PACKING_COST) + nvl(MAX(M.SHIPING_LABEL_RATE), 0) + nvl(max(m.ebay_fee), 0) + NVL((7 / 100) * NVL(MAX(m.SALE_PRICE * m.qty), 0), 0), 0) CHARGES, COUNT(DISTINCT M.ORDER_ID) TOTAL_COUNT, MAX(M.SER_RATE_ID) RATE_ID, MAX(M.MERCHANT_ID) MERCHANT_ID FROM LJ_ORDER_PACKING_MT M, LJ_ORDER_PACKING_DT DT, LZ_PACKING_TYPE_MT  PM, lj_service_rate     ra, lj_services         sv WHERE M.ORDER_PACKING_ID = DT.ORDER_PACKING_ID and m.ser_rate_id = ra.ser_rate_id(+) and ra.service_id = sv.service_id(+) AND DT.PACKING_ID = PM.PACKING_ID(+) AND M.MERCHANT_ID = $merchant_id AND M.INVOICE_ID IS NULL GROUP BY dt.order_packing_id) UNION ALL SELECT DECODE(MAX(SER_NAME), NULL, '-', MAX(SER_NAME)) SERVICE_NAME, MAX(SERV_TYPE) SER_TYPE, CASE WHEN COUNT(ITEM_ID) > 0 THEN ROUND(NVL(SUM(CHARGES) / COUNT(TO_CHAR(ITEM_ID)), 0), 4) ELSE NVL(SUM(CHARGES) / NULL, 0) END RATE, COUNT(ITEM_ID) TOTAL_COUNT, NVL(SUM(CHARGES), 0) TOTAL_CAHRGES, MAX(SER_RATE_ID) RATE_ID, MAX(MERCHANT_ID) MERCHANT_ID, '-' DURATION FROM (SELECT D.BARCODE_NO, L.BARCODE_PRV_NO, L.PIC_DATE_TIME, BINV.CHARGES, L.LZ_MANIFEST_DET_ID, B.ITEM_ID, B.LZ_MANIFEST_ID, RA.SER_RATE_ID, M.MERCHANT_ID, (SELECT SD.EBAY_PRICE FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO) TOTAL_VAL, (SELECT SD.EBAY_PRICE FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO AND B.EBAY_ITEM_ID IS NOT NULL) LIST_VAL, (SELECT SD.EBAY_PRICE FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO AND B.EBAY_ITEM_ID IS NULL) NOT_LIST_VAL, (SELECT SD.EBAY_PRICE FROM LZ_BARCODE_MT MM, LZ_ITEM_SEED SD WHERE MM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID AND MM.ITEM_ID = SD.ITEM_ID AND MM.CONDITION_ID = SD.DEFAULT_COND AND MM.BARCODE_NO = B.BARCODE_NO AND B.EBAY_ITEM_ID IS NOT NULL AND B.SALE_RECORD_NO IS NOT NULL) SOLD_VALUE, (SELECT SB.SERVICE_DESC FROM LJ_SERVICES SB WHERE SB.SERVICE_ID = RA.SERVICE_ID) SER_NAME, DECODE(RA.SERVICE_TYPE, 1, 'PER_BARC', 2, 'PER_HOUR') SERV_TYPE, B.EBAY_ITEM_ID, B.SALE_RECORD_NO FROM LZ_MERCHANT_BARCODE_MT M, LZ_MERCHANT_BARCODE_DT D, LZ_SPECIAL_LOTS        L, LZ_BARCODE_MT          B, LJ_BARCODE_BILLING     BINV, LJ_SERVICE_RATE        RA WHERE M.MT_ID = D.MT_ID AND D.BARCODE_NO = L.BARCODE_PRV_NO(+) AND L.BARCODE_PRV_NO = B.BARCODE_NO(+) AND L.BARCODE_PRV_NO = BINV.BARCODE_NO(+) AND BINV.INVOICE_ID IS NULL AND BINV.SER_RATE_ID = 6 AND BINV.SER_RATE_ID = RA.SER_RATE_ID(+) AND M.MERCHANT_ID = $merchant_id) UNION ALL SELECT MAX(SERVICE_DESC) SERVICE_NAME, MAX(SERV_TYPE) SER_TYPE, MAX(CHARGES) RATE, count(barcode_no) TOTAL_COUNT, NVL(SUM(TOT_CHARGE), 0) TOTAL_CAHRGES, MAX(SER_RATE_ID) RATE_ID, MAX(MERCHANT_ID) MERCHANT_ID, TO_CHAR(TRUNC(sum(get_sec) / 3600), 'FM9900') || ' hrs: ' || TO_CHAR(TRUNC(MOD(sum(get_sec), 3600) / 60), 'FM00') || ' min: ' || TO_CHAR(MOD(sum(get_sec), 60), 'FM00') || ' sec' Duration FROM (SELECT SR.CHARGES, SV.SERVICE_DESC, DECODE(SR.SERVICE_TYPE, 1, 'PER_BARC', 2, 'PER_HOUR') SERV_TYPE, SR.SERVICE_ID, (SR.CHARGES / 60) / 60 * TO_NUMBER(((LG.STOP_TIME - LG.START_TIME) * 24) * 60 * 60) TOT_CHARGE, TO_NUMBER(((LG.STOP_TIME - LG.START_TIME) * 24) * 60 * 60) get_sec, SR.SER_RATE_ID, MA.MERCHANT_ID, MA.APPOINTMENT_ID, lg.barcode_no FROM LJ_APPOINTMENT_MT  MA, LJ_APPOINTMENT_DT  DA, LJ_SERVICE_RATE    SR, LJ_SERVICES        SV, LJ_APPOINTMENT_LOG LG WHERE MA.APPOINTMENT_ID = DA.APPOINTMENT_ID AND DA.APPOINTMENT_DT_ID = LG.APPOINTMENT_DT_ID(+) AND LG.INV_ID IS NULL AND DA.SERVICE_ID = SV.SERVICE_ID AND SV.SERVICE_ID = SR.SERVICE_ID AND MA.MERCHANT_ID = $merchant_id ORDER BY LG.APPOINTMENT_LOG_ID ASC) GROUP BY SERVICE_ID, SERVICE_DESC ")->result_array();

                if (count($mer_inv) >= 1) {return array('mer_inv' => $mer_inv, 'exist' => true);
                } else {
                    return array('mer_inv' => $mer_inv, 'exist' => false);
                }
            } else {
                return false;
            }
        }
    }

    public function load_identification_data()
    {

        $user_id = $this->input->post('user_id');
        $filterData = trim($this->input->post('filterData'));
        //var_dump($filterData);

        //$date_range = $this->input->post('date_range');
        $from = $this->input->post("startDate");
        $to = $this->input->post("endDate");
        // var_dump($date_range);
        // var_dump($from);
        // var_dump($to);
        // exit;
        $idntiti_data = "SELECT * FROM (SELECT 'Dekit' DEKIT_ITEM, DC.BRAND, D.LZ_DEKIT_US_DT_ID PK_ID, D.BARCODE_PRV_NO, DECODE(DC.MPN_DESCRIPTION, NULL, D.MPN_DESCRIPTION, DC.MPN_DESCRIPTION) MPN_DESCRIPTION, DC.MPN MPN, DC.UPC, O.OBJECT_NAME, C.COND_NAME, D.AVG_SELL_PRICE, D.DEKIT_REMARKS /*D.IDENT_REMARKS*/ REMARKS, d.allocate_to assign_to, D.discard, BAR.EBAY_ITEM_ID,D.LZ_MANIFEST_DET_ID GET_MANIF_ID,to_char(M.BARCODE_NO)  MAS_BAR,/* M.MASTER_MPN_ID, K.CATALOGUE_MT_ID,  K.MPN_DESCRIPTION,*/ I.ITEM_DESC   mast_mpn_desc  FROM LZ_DEKIT_US_DT   D,LZ_BARCODE_MT BAR, LZ_DEKIT_US_MT   M, LZ_BD_OBJECTS_MT O, LZ_ITEM_COND_MT  C, LZ_CATALOGUE_MT  K, LZ_BARCODE_MT MB, ITEMS_MT I, LZ_CATALOGUE_MT  DC WHERE D.OBJECT_ID = O.OBJECT_ID(+) AND D.CONDITION_ID = C.ID(+)  AND D.BARCODE_PRV_NO = BAR.BARCODE_NO(+) AND M.MASTER_MPN_ID = K.CATALOGUE_MT_ID(+) AND D.LZ_DEKIT_US_MT_ID = M.LZ_DEKIT_US_MT_ID  AND D.PIC_DATE_TIME IS NOT NULL AND D.PIC_BY IS NOT NULL AND D.CATALOG_MT_ID = DC.CATALOGUE_MT_ID(+)   AND M.LZ_MANIFEST_MT_ID IS NOT NULL  AND M.BARCODE_NO = MB.BARCODE_NO AND MB.ITEM_ID = I.ITEM_ID AND D.ALLOCATE_TO = '$user_id'";
        $idntiti_data .= "AND D.ALLOCATE_DATE  BETWEEN TO_DATE('$from " . "00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to " . "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";

        // if (!empty($date_range)) {
        // $fromdate = @$date_range[0];
        // //     $todate = @$rslt[1];
        // //     /*===Convert Date in 24-Apr-2016===*/
        // var_dump($fromdate);
        // $fromdate = date_create($date_range[0]);

        // $from = date_format($fromdate, 'Y-m-d');
        // $from = $date_range;

        // }
        $idntiti_data .= " UNION ALL ";
        $idntiti_data .= "SELECT 'Lot' DEKIT_ITEM, DECODE(MT.BRAND, NULL, LL.BRAND, MT.BRAND) BARAND, LL.SPECIAL_LOT_ID PK_ID, LL.BARCODE_PRV_NO, DECODE(MT.MPN_DESCRIPTION, NULL, LL.MPN_DESCRIPTION, MT.MPN_DESCRIPTION) MPN_DESCRIPTION, DECODE(MT.MPN, NULL, LL.CARD_MPN, MT.MPN) MPN, DECODE(MT.UPC, NULL, LL.CARD_UPC, MT.UPC) UPC, OB.OBJECT_NAME, C.COND_NAME, TO_NUMBER(LL.AVG_SOLD) AVG_SOLD, LL.LOT_REMARKS REMARKS, ll.allocate_to assign_to, ll.discard, BAR.EBAY_ITEM_ID ,LL.LZ_MANIFEST_DET_ID GET_MANIF_ID, '' MAS_BAR, '' MAST_MPN_DESC FROM LZ_SPECIAL_LOTS  LL,LZ_BARCODE_MT BAR, LZ_CATALOGUE_MT  MT, LZ_ITEM_COND_MT  C, LZ_BD_OBJECTS_MT OB WHERE LL.CATALOG_MT_ID = MT.CATALOGUE_MT_ID(+)  AND LL.BARCODE_PRV_NO = BAR.BARCODE_NO(+) AND LL.CONDITION_ID = C.ID(+)  AND LL.OBJECT_ID = OB.OBJECT_ID(+) AND LL.PIC_DATE_TIME IS NOT NULL AND LL.PIC_BY IS NOT NULL  AND LL.ALLOCATE_TO = '$user_id'  ";
        $idntiti_data .= "AND LL.ALLOC_DATE BETWEEN TO_DATE('$from " . "00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to " . "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";

        $idntiti_data .= "  )";

        // if (!empty($date_range)) {
        // $fromdate = @$date_range[0];
        // //     $todate = @$rslt[1];
        // //     /*===Convert Date in 24-Apr-2016===*/
        // $fromdate = date_create($date_range[0]);

        // $from = date_format($fromdate, 'Y-m-d');
        // $from = $date_range;
        ////////$idntiti_data .= "AND LL.ALLOC_DATE BETWEEN TO_DATE('$from " . "00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to " . "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";
        // }

        if (!empty($filterData) && $filterData != 'All') {

            if (!empty($filterData) && $filterData == 'Dekit') {
                $idntiti_data .= " where DEKIT_ITEM = '$filterData'";
                $idntiti_data .= " AND GET_MANIF_ID IS NULL";
                $idntiti_data .= " AND  DISCARD <> 1";

            } else if (!empty($filterData) && $filterData == 'Lot') {
                $idntiti_data .= " where DEKIT_ITEM = '$filterData'";
                $idntiti_data .= " AND GET_MANIF_ID IS NULL";
                $idntiti_data .= " AND  DISCARD <> 1";
            } else if (!empty($filterData) && $filterData == 'Not Listed') {
                $idntiti_data .= " where EBAY_ITEM_ID is null ";
                $idntiti_data .= " AND GET_MANIF_ID IS not NULL ";
                $idntiti_data .= " AND  DISCARD <> 1";
            } else if (!empty($filterData) && $filterData == 'Discarded') {
                $idntiti_data .= " WHERE DISCARD = 1";
            } else {
                $idntiti_data .= " AND GET_MANIF_ID IS NULL";
                $idntiti_data .= " AND DISCARD <> 1 ";

            }

        } else {
            $idntiti_data .= " Where GET_MANIF_ID IS NULL";
            $idntiti_data .= " AND  DISCARD <> 1";

        }
        //$idntiti_data .= "  )";

        $idntiti_datas = $this->db->query($idntiti_data)->result_array();

        if (count($idntiti_datas) >= 1) {

            $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array();
            $uri = $this->get_identiti_bar_pics($idntiti_datas, $conditions);
            $images = $uri['uri'];

            return array('idntiti_data' => $idntiti_datas, "images" => $images, 'exist' => true);
        } else {
            return array('idntiti_data' => $idntiti_datas, 'exist' => false);
        }

    }

    public function get_identiti_bar_pics($barcodes, $conditions)
    {

        $path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 2");
        $path = $path->result_array();

        $master_path = $path[0]["MASTER_PATH"];
        $uri = array();
        $base_url = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        foreach ($barcodes as $barcode) {

            $bar = $barcode['BARCODE_PRV_NO'];

            if (!empty($bar)) {

                $getFolder = $this->db->query("SELECT LOT.FOLDER_NAME FROM LZ_SPECIAL_LOTS LOT WHERE lot.barcode_prv_no = '$bar' and rownum <= 1  ")->result_array();
            }

            $folderName = "";
            if ($getFolder) {
                $folderName = $getFolder[0]['FOLDER_NAME'];
            } else {
                $folderName = $bar;
            }

            $dir = "";
            $barcodePictures = $master_path . $folderName . "/";
            $barcodePicturesThumb = $master_path . $folderName . "/thumb" . "/";

            if (is_dir($barcodePictures)) {
                $dir = $barcodePictures;
            } else if (is_dir($barcodePicturesThumb)) {
                $dir = $barcodePicturesThumb;
            }

            $dir = preg_replace("/[\r\n]*/", "", $dir);

            if (is_dir($dir)) {
                $images = glob($dir . "\*.{JPG,jpg,GIF,gif,PNG,png,BMP,bmp,JPEG,jpeg}", GLOB_BRACE);

                if ($images) {
                    $j = 0;
                    foreach ($images as $image) {

                        $withoutMasterPartUri = str_replace("D:/wamp/www/", "", $image);
                        $withoutMasterPartUri = preg_replace("/[\r\n]*/", "", $withoutMasterPartUri);
                        $uri[$bar][$j] = $base_url . $withoutMasterPartUri;
                        // if($uri[$barcode['LZ_barcode_ID']]){
                        //     break;
                        // }

                        $j++;
                    }
                } else {
                    $uri[$bar][0] = $base_url . "item_pictures/master_pictures/image_not_available.jpg";
                    $uri[$bar][1] = false;
                }
            } else {
                $uri[$bar][0] = $base_url . "item_pictures/master_pictures/image_not_available.jpg";
                $uri[$bar][1] = false;
            }
        }
        return array('uri' => $uri);

    }

    // listing apis query start

    public function uplaod_seed($item_id, $manifest_id, $condition_id, $check_btn, $forceRevise)
    {

        if ($check_btn == 'revise' and $forceRevise == 0) {
            $query = $this->db->query("SELECT DET.WEIGHT, LS.ITEM_ID, LS.ITEM_TITLE, LS.ITEM_DESC, LS.EBAY_PRICE, LS.TEMPLATE_ID, LS.EBAY_LOCAL, LS.CURRENCY, LS.LIST_TYPE, LS.CATEGORY_ID, LS.SHIP_FROM_ZIP_CODE, LS.SHIP_FROM_LOC, LS.DEFAULT_COND, LS.DETAIL_COND, LS.PAYMENT_METHOD, LS.PAYPAL_EMAIL, LS.DISPATCH_TIME_MAX, LS.SHIPPING_COST, LS.ADDITIONAL_COST, LS.RETURN_OPTION, LS.RETURN_DAYS, LS.SHIPPING_PAID_BY, LS.SHIPPING_SERVICE, LS.CATEGORY_NAME, LS.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, LS.F_MANUFACTURE MANUFACTURE,LS.F_MPN PART_NO, I.ITEM_MT_BBY_SKU SKU, LS.F_UPC UPC, LS.DEFAULT_COND ITEM_CONDITION, NULL QUANTITY, R.GENERAL_RULE, R.SPECIFIC_RULE, C.COND_NAME, LS.EPID FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, LZ_MANIFEST_DET DET, ITEMS_MT I, LZ_LISTING_RULES R, LZ_ITEM_COND_MT C, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LM.LZ_MANIFEST_ID = DET.LZ_MANIFEST_ID AND LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND R.ITEM_CONDITION = LS.DEFAULT_COND AND LS.DEFAULT_COND = C.ID AND LS.ITEM_ID = $item_id and LS.LZ_MANIFEST_ID = $manifest_id and LS.DEFAULT_COND = $condition_id AND ROWNUM=1");
        } else {
            $query = $this->db->query("SELECT DET.WEIGHT, LS.ITEM_ID, LS.ITEM_TITLE, LS.ITEM_DESC, LS.EBAY_PRICE, LS.TEMPLATE_ID, LS.EBAY_LOCAL, LS.CURRENCY, LS.LIST_TYPE, LS.CATEGORY_ID, LS.SHIP_FROM_ZIP_CODE, LS.SHIP_FROM_LOC, LS.DEFAULT_COND, LS.DETAIL_COND, LS.PAYMENT_METHOD, LS.PAYPAL_EMAIL, LS.DISPATCH_TIME_MAX, LS.SHIPPING_COST, LS.ADDITIONAL_COST, LS.RETURN_OPTION, LS.RETURN_DAYS, LS.SHIPPING_PAID_BY, LS.SHIPPING_SERVICE, LS.CATEGORY_NAME, LS.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, LS.F_MANUFACTURE MANUFACTURE,LS.F_MPN PART_NO,  I.ITEM_MT_BBY_SKU  SKU, LS.F_UPC UPC, LS.DEFAULT_COND  ITEM_CONDITION, BCD.QTY  QUANTITY, R.GENERAL_RULE, R.SPECIFIC_RULE, C.COND_NAME,LS.EPID FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, LZ_MANIFEST_DET DET, ITEMS_MT I, LZ_LISTING_RULES R, LZ_ITEM_COND_MT C, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL AND BC.SALE_RECORD_NO IS NULL AND BC.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND BC.LZ_PART_ISSUE_MT_ID IS NULL AND BC.LZ_POS_MT_ID IS NULL AND BC.PULLING_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LM.LZ_MANIFEST_ID = DET.LZ_MANIFEST_ID AND LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND R.ITEM_CONDITION = LS.DEFAULT_COND AND LS.DEFAULT_COND = C.ID AND LS.ITEM_ID = $item_id and LS.LZ_MANIFEST_ID = $manifest_id and LS.DEFAULT_COND = $condition_id AND ROWNUM=1");}

        return $query->result_array();
    }

    public function uplaod_seed_pic($item_id, $manifest_id, $condition_id, $seed_id)
    {

        // $query = $this->db->query("SELECT trim(I.ITEM_MT_MFG_PART_NO) ITEM_MT_MFG_PART_NO,trim(I.ITEM_MT_UPC) ITEM_MT_UPC FROM ITEMS_MT I WHERE I.ITEM_ID = $item_id");

        $query = $this->db->query("SELECT I.F_UPC ITEM_MT_UPC,I.F_MPN ITEM_MT_MFG_PART_NO FROM LZ_ITEM_SEED I WHERE I.SEED_ID =$seed_id ");
        $result = $query->result_array();
        $mpn = $result[0]['ITEM_MT_MFG_PART_NO'];
        $upc = $result[0]['ITEM_MT_UPC'];
        $it_condition = $condition_id;
        $query = $this->db->query("SELECT COND_NAME FROM LZ_ITEM_COND_MT WHERE ID = $condition_id");
        $result = $query->result_array();
        $it_condition = $result[0]['COND_NAME'];
        $mpn = str_replace('/', '_', @$mpn);

        /*==============================================
        =            Master Picture Check            =
        ==============================================*/
        $query = $this->db->query("SELECT MASTER_PATH,SPECIFIC_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
        $master_qry = $query->result_array();
        $master_path = $master_qry[0]['MASTER_PATH'];
        $specific_path = $master_qry[0]['SPECIFIC_PATH'];

        $m_dir = $master_path . @$upc . "~" . @$mpn . "/" . @$it_condition;
        if (is_dir(@$m_dir)) {
            $iterator = new \FilesystemIterator(@$m_dir);
            if (@$iterator->valid()) {
                $m_flag = true;
            } else {
                $m_flag = false;
            }
        } else {
            $m_flag = false;
        }
        /*=====  End of Master Picture Check  ======*/

        /*==============================================
        =            Specific Picture Check            =
        ==============================================*/
        $s_dir = $specific_path . @$upc . "~" . $mpn . "/" . @$it_condition . "/" . $manifest_id;
        // Open a directory, and read its contents
        if (is_dir(@$s_dir)) {
            $iterator = new \FilesystemIterator(@$s_dir);
            if (@$iterator->valid()) {
                $s_flag = true;
            } else {
                $s_flag = false;
            }
        } else {
            $s_flag = false;
        }
        /*=====  End of Specific Picture Check  ======*/
        if ($m_flag && $s_flag) {
            return "B";

        } elseif ($m_flag === true && $s_flag === false) {
            return "M";
        } elseif ($m_flag === false && $s_flag === true) {
            return "S";
        } else {
            die('Error! Item Picture Not Found.');
        }
    } //end function

    public function item_specifics($item_id, $manifest_id, $condition_id)
    {
        // $item_id = 18786;
        // $manifest_id = 13827;
        // $query = $this->db->query("SELECT s.f_upc  I.ITEM_MT_UPC, s.f_mpn I.ITEM_MT_MFG_PART_NO, S.CATEGORY_ID FROM ITEMS_MT I, LZ_ITEM_SEED S WHERE I.ITEM_ID = $item_id AND I.ITEM_ID = S.ITEM_ID AND S.LZ_MANIFEST_ID = $manifest_id AND S.DEFAULT_COND = $condition_id AND ROWNUM = 1");
        $query = $this->db->query("SELECT s.f_upc  ITEM_MT_UPC, s.f_mpn ITEM_MT_MFG_PART_NO, S.CATEGORY_ID FROM ITEMS_MT I, LZ_ITEM_SEED S WHERE I.ITEM_ID = $item_id AND I.ITEM_ID = S.ITEM_ID AND S.LZ_MANIFEST_ID = $manifest_id AND S.DEFAULT_COND = $condition_id AND ROWNUM = 1");

        $result = $query->result_array();

        if ($query->num_rows() > 0) {

            if (!empty($result[0]['ITEM_MT_UPC'])) {
                $where_upc = " AND MT.UPC = '" . $result[0]['ITEM_MT_UPC'] . "'";
            } else {
                $where_upc = ' ';
            }
            if (!empty($result[0]['ITEM_MT_MFG_PART_NO'])) {
                $where_mpn = " AND MT.MPN = '" . $result[0]['ITEM_MT_MFG_PART_NO'] . "'";
            } else {
                $where_mpn = '';
            }

            $spec_query = $this->db->query("SELECT MT.SPECIFICS_NAME, DT.SPECIFICS_VALUE FROM LZ_ITEM_SPECIFICS_MT MT, LZ_ITEM_SPECIFICS_DET DT WHERE DT.SPECIFICS_MT_ID = MT.SPECIFICS_MT_ID AND MT.ITEM_ID = $item_id AND MT.CATEGORY_ID = " . $result[0]['CATEGORY_ID'] . $where_upc . $where_mpn);
            $spec_query = $spec_query->result_array();

        } else {
            $spec_query = "";
        }

        return $spec_query;

        //var_dump($spec_query);exit ;

    }

    public function insert_ebay_id($item_id, $manifest_id, $seed_id, $condition_id, $status, $check_btn, $forceRevise, $account_id, $userId)
    {
        $list_rslt = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('EBAY_LIST_MT','LIST_ID') LIST_ID FROM DUAL");
        $rs = $list_rslt->result_array();
        $LIST_ID = $rs[0]['LIST_ID'];
        $this->session->set_userdata('list_id', $LIST_ID);
        $ebay_id = $this->session->userdata('ebay_item_id');
        $get_acc = $this->db->query("SELECT E.LZ_SELLER_ACCT_ID FROM EBAY_LIST_MT E WHERE E.LIST_ID = (SELECT MIN(LIST_ID) FROM EBAY_LIST_MT EE WHERE EE.EBAY_ITEM_ID = '$ebay_id' AND EE.LZ_SELLER_ACCT_ID IS NOT NULL )");
        $rs = $get_acc->result_array();
        if (count($rs) > 0) {
            $account_id = $rs[0]['LZ_SELLER_ACCT_ID'];
        }
        if ($check_btn == "revise") {
            $status = "UPDATE";

            // if(@$forceRevise === 1){
            //  $query = $this->db->query("SELECT LS.ITEM_TITLE,LS.EBAY_PRICE, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0  AND BC.SALE_RECORD_NO IS NULL AND BC.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND BC.LZ_PART_ISSUE_MT_ID IS NULL AND BC.LZ_POS_MT_ID IS NULL AND BC.PULLING_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.ITEM_ID = $item_id and LS.LZ_MANIFEST_ID = $manifest_id and LS.DEFAULT_COND=$condition_id");
            //  if($query->num_rows() === 0){
            //    $query = $this->db->query("SELECT LS.ITEM_TITLE,LS.EBAY_PRICE, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.ITEM_ID = $item_id and LS.LZ_MANIFEST_ID = $manifest_id and LS.DEFAULT_COND=$condition_id");
            //  }
            //  $update_barcode_qry = "UPDATE LZ_BARCODE_MT SET EBAY_ITEM_ID=$ebay_id, LIST_ID = $LIST_ID WHERE ITEM_ID= $item_id AND LZ_MANIFEST_ID = $manifest_id AND CONDITION_ID = $condition_id AND EBAY_ITEM_ID IS NULL AND LIST_ID IS NULL AND SALE_RECORD_NO IS NULL AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND HOLD_STATUS = 0";
            // }else{

            //  $query = $this->db->query("SELECT LS.ITEM_TITLE,LS.EBAY_PRICE, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NOT NULL  AND BC.SALE_RECORD_NO IS NULL AND BC.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND BC.LZ_PART_ISSUE_MT_ID IS NULL AND BC.LZ_POS_MT_ID IS NULL AND BC.PULLING_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.ITEM_ID = $item_id and LS.LZ_MANIFEST_ID = $manifest_id and LS.DEFAULT_COND=$condition_id");
            //  if($query->num_rows() === 0){
            //    $query = $this->db->query("SELECT LS.ITEM_TITLE,LS.EBAY_PRICE, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.ITEM_ID = $item_id and LS.LZ_MANIFEST_ID = $manifest_id and LS.DEFAULT_COND=$condition_id");
            //  }

            //  $update_barcode_qry = "UPDATE LZ_BARCODE_MT SET EBAY_ITEM_ID=$ebay_id, LIST_ID = $LIST_ID WHERE ITEM_ID= $item_id AND LZ_MANIFEST_ID = $manifest_id AND CONDITION_ID = $condition_id AND EBAY_ITEM_ID IS NOT NULL AND LIST_ID IS NOT NULL AND SALE_RECORD_NO IS NULL AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND HOLD_STATUS = 0";
            // }
            $query = $this->db->query("SELECT LS.ITEM_TITLE,LS.EBAY_PRICE, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NOT NULL  AND BC.SALE_RECORD_NO IS NULL AND BC.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND BC.LZ_PART_ISSUE_MT_ID IS NULL AND BC.LZ_POS_MT_ID IS NULL AND BC.PULLING_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.ITEM_ID = $item_id and LS.LZ_MANIFEST_ID = $manifest_id and LS.DEFAULT_COND=$condition_id");
            if ($query->num_rows() === 0) {
                $query = $this->db->query("SELECT LS.ITEM_TITLE,LS.EBAY_PRICE, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.ITEM_ID = $item_id and LS.LZ_MANIFEST_ID = $manifest_id and LS.DEFAULT_COND=$condition_id");
            }

            $update_barcode_qry = "UPDATE LZ_BARCODE_MT SET EBAY_ITEM_ID=$ebay_id, LIST_ID = $LIST_ID WHERE ITEM_ID= $item_id AND LZ_MANIFEST_ID = $manifest_id AND CONDITION_ID = $condition_id AND EBAY_ITEM_ID IS NOT NULL AND LIST_ID IS NOT NULL AND SALE_RECORD_NO IS NULL AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND HOLD_STATUS = 0";

        } else {
            $query = $this->db->query("SELECT LS.ITEM_TITLE,LS.EBAY_PRICE, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL  AND BC.LIST_ID IS NULL AND BC.SALE_RECORD_NO IS NULL AND BC.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND BC.LZ_PART_ISSUE_MT_ID IS NULL AND BC.LZ_POS_MT_ID IS NULL AND BC.PULLING_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.ITEM_ID = $item_id and LS.LZ_MANIFEST_ID = $manifest_id and LS.DEFAULT_COND=$condition_id");
            $update_barcode_qry = "UPDATE LZ_BARCODE_MT SET EBAY_ITEM_ID=$ebay_id, LIST_ID = $LIST_ID WHERE ITEM_ID= $item_id AND LZ_MANIFEST_ID = $manifest_id AND CONDITION_ID = $condition_id AND EBAY_ITEM_ID IS NULL AND LIST_ID IS NULL AND SALE_RECORD_NO IS NULL AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND HOLD_STATUS = 0";
        } //check_btn if else close
        $rslt_dta = $query->result_array();

        //$list_date = date("d/M/Y");// return format Aug/13/2016
        date_default_timezone_set("America/Chicago");
        $list_date = date("Y-m-d H:i:s");
        $list_date = "TO_DATE('" . $list_date . "', 'YYYY-MM-DD HH24:MI:SS')";

        if (!empty($this->session->userdata('user_id'))) {
            $lister_id = $this->session->userdata('user_id');
        } else {
            $lister_id = $userId;
        }

        $ebay_item_desc = @$rslt_dta[0]['ITEM_TITLE'];
        $ebay_item_desc = trim(str_replace("  ", '', $ebay_item_desc));
        $ebay_item_desc = trim(str_replace(array("'"), "''", $ebay_item_desc));
        if ($check_btn == "revise") {
            //$current_qty = $this->session->userdata('current_qty');
            $list_qty = 0;
        } else {
            $list_qty = @$rslt_dta[0]['QUANTITY'];
        }

        $ebay_item_id = $ebay_id;
        $list_price = @$rslt_dta[0]['EBAY_PRICE'];
        $remarks = null;
        $single_entry_id = null;
        $salvage_qty = 0.00;
        $entry_type = "L";
        $LZ_SELLER_ACCT_ID = $account_id;
        $auth_by_id = $this->session->userdata('auth_by_id');
        $list_qty = "'" . $list_qty . "'";

        $insert_query = $this->db->query("INSERT INTO ebay_list_mt (LIST_ID, LZ_MANIFEST_ID, LISTING_NO, ITEM_ID, LIST_DATE, LISTER_ID, EBAY_ITEM_DESC, LIST_QTY, EBAY_ITEM_ID, LIST_PRICE, REMARKS, SINGLE_ENTRY_ID, SALVAGE_QTY, ENTRY_TYPE, LZ_SELLER_ACCT_ID, SEED_ID, STATUS, ITEM_CONDITION, AUTH_BY_ID,FORCEREVISE)VALUES (" . $LIST_ID . "," . $manifest_id . ", " . $LIST_ID . ", " . $item_id . ", " . $list_date . ", " . $lister_id . ", '" . $ebay_item_desc . "', " . $list_qty . "," . $ebay_item_id . ",'" . $list_price . "',NULL,NULL, NULL, '" . $entry_type . "'," . $LZ_SELLER_ACCT_ID . "," . $seed_id . ",'" . trim($status) . "'," . $condition_id . ", '" . $auth_by_id . "'," . @$forceRevise . ")");
        if ($insert_query) {
            $this->db->query($update_barcode_qry);
            $this->db->query("UPDATE LZ_LISTING_ALLOC SET LIST_ID = $LIST_ID WHERE SEED_ID = $seed_id");
            return $LIST_ID;
        }

    }

    public function insert_ebay_url($userId)
    {
        $ebay_item_id = $this->session->userdata('ebay_item_id');
        //$ebay_item_url = $this->session->userdata('ebay_item_url');
        $ebay_item_url = "https://www.ebay.com/itm/" . $ebay_item_id;
        date_default_timezone_set("America/Chicago");
        $list_date = date("Y-m-d H:i:s");
        $ins_date = "TO_DATE('" . $list_date . "', 'YYYY-MM-DD HH24:MI:SS')";
        $entered_by = $userId; //$this->session->userdata('user_id');
        $comma = ',';
        $query = $this->db->query("SELECT * FROM LZ_LISTED_ITEM_URL WHERE EBAY_ID = $ebay_item_id");
        $result = $query->result_array();
        if ($query->num_rows() == 0) {
            $insert_query = $this->db->query("INSERT INTO LZ_LISTED_ITEM_URL VALUES ($ebay_item_id $comma '$ebay_item_url' $comma $ins_date $comma $entered_by)");
        }
    }
    
    // listing apis query end
      /// get lz webiste functions
    public function ljw_Brands(){

       $get_product_name = $this->input->post('get_product_name');
        $ljw_getobject = $this->db->query("SELECT  DT.BRAND_DT_ID,(SELECT B.IMAGE_URL FROM LZW_BRANDS_MT B WHERE B.BRAND_ID = DT.BRAND_ID) BRAND_URL, (SELECT B.DESCRIPTION FROM LZW_BRANDS_MT B WHERE B.BRAND_ID = DT.BRAND_ID) BRAND_NAME, (SELECT O.OBJECT_NAME FROM LZW_OBJECT_MT O WHERE O.OBJECT_ID = DT.OBJECT_ID) PRODUCT FROM LZW_BRANDS_DT DT WHERE DT.OBJECT_ID =$get_product_name ")->result_array(); 
        return array('ljw_getobject' =>  $ljw_getobject,'exist'=> true);

    }

    public function ljw_Series(){

        $get_brand_name = $this->input->post('get_brand_name');

        $ljw_Series = $this->db->query("SELECT SD.SERIES_DT_ID,(SELECT MT.DESCRIPTION FROM LZW_SERIES_MT MT WHERE MT.SERIES_ID = SD.SERIES_ID) SERIES_NAME, SD.BRAND_DT_ID, (SELECT BM.DESCRIPTION FROM LZW_BRANDS_DT BT,LZW_BRANDS_MT BM WHERE BM.BRAND_ID = BT.BRAND_ID AND BT.BRAND_DT_ID = SD.BRAND_DT_ID ) BRAND_NAME FROM LZW_SERIES_DT SD WHERE  to_char(SD.BRAND_DT_ID) ='$get_brand_name'")->result_array(); 

        return array('ljw_Series' =>  $ljw_Series,'exist'=> true);
    }
    public function ljw_Model(){
        $get_series_name = $this->input->post('get_series_name');
        $ljw_Model = $this->db->query(" SELECT MDT.MODEL_DT_ID,MD.DESCRIPTION FROM LZW_MODEL_MT MD,LZW_MODEL_DT MDT WHERE MD.MODEL_ID = MDT.MODEL_ID AND to_char(MDT.SERIES_DT_ID) ='$get_series_name'")->result_array(); 

        return array('ljw_Model' =>  $ljw_Model,'exist'=> true);
    }
    public function ljw_Issues(){
        $get_product_name = $this->input->post('get_product_name');
        $ljw_Issues = $this->db->query("SELECT SDS.ISSUE_DT_ID, (SELECT SM.DESCIPTION FROM LZW_ISSUES_MT SM WHERE SM.ISSUE_ID =SDS.ISSUE_ID) ISSU_NAME FROM LZW_ISSUES_DT SDS WHERE to_char(SDS.OBJECT_ID) = '$get_product_name'")->result_array();
        return array('ljw_Issues' =>  $ljw_Issues,'exist'=> true);
    }

    public function ljw_SaveRequest(){

    $product_name = $this->input->post('product_name');
    
    $brand_name = $this->input->post('brand_name'); 

    $series_name = $this->input->post('series_name');
    $model_name = $this->input->post('model_name');
    $issues_name = $this->input->post('issues_name');
    $issuesInput = $this->input->post('issuesInput');


      // foreach ($spec_name as $name) {

      //       $name = trim(str_replace("  ", ' ', $name));
      //       $name = trim(str_replace(array("'"), "''", $name));
      //       if (is_array(@$spec_value[$i])) {
      //           $value = "ok";
      //           //var_dump(@$spec_value[$i]);
      //       } else {
      //           $value = @$spec_value[$i];
    
    $emailNumb = $this->input->post('emailNumb');
    $phoneNumb = $this->input->post('phoneNumb');

    $LastName = $this->input->post('LastName');
    $LastName = trim(str_replace("  ", ' ', $LastName));
    $LastName = str_replace(array("`,′"), "", $LastName);
    $LastName = str_replace(array("'"), "''", $LastName);

    $yourName = $this->input->post('yourName');
    $yourName = trim(str_replace("  ", ' ', $yourName));
    $yourName = str_replace(array("`,′"), "", $yourName);
    $yourName = str_replace(array("'"), "''", $yourName);

    $enterComents = $this->input->post('enterComents');
    $coments = trim(str_replace("  ", ' ', $enterComents));
    $coments = str_replace(array("`,′"), "", $coments);
    $coments = str_replace(array("'"), "''", $coments);
    if(isset($_FILES['images'])){
        $images = $_FILES['images'];
    }
    
    // BRAND_INPUT
    // SERIES_INPUT
    // MODAL_INPUT

    
            $req_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZW_REPAIRE_MT','REPAIRE_MT_ID') RE_PK FROM DUAL");
            $req_pk = $req_pk->result_array();
            $req_pk_id = $req_pk[0]['RE_PK'];

        $saveRequest =$this->db->query("INSERT INTO LZW_REPAIRE_MT (REPAIRE_MT_ID, F_NAME, L_NAME, EMAIL, CONTACT_NO,CUSTOMER_REMARKS, OBJECT_ID,BRAND_INPUT,SERIES_INPUT,MODAL_INPUT,ISSUE_INPUT )VALUES($req_pk_id, '$yourName', '$LastName', '$emailNumb', '$phoneNumb','$coments','$product_name','$brand_name','$series_name','$model_name','$issuesInput') ");

        if($saveRequest){
            
            $req_pk = $this->db->query("SELECT 'REP-' || LPAD(NVL(MT.REPAIRE_MT_ID, 0), 6, '0')   getid FROM LZW_REPAIRE_MT MT WHERE MT.REPAIRE_MT_ID = $req_pk_id ");
            $req_pk = $req_pk->result_array();

            $get_req_id = $req_pk[0]['GETID'];


            if($get_req_id){

                //var_dump($issues_name);
                //$i=0;
                 foreach ($issues_name as $key ) {
                    $req_det_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZW_REPAIRE_DT','REPAIRE_DT_ID') RE_PK FROM DUAL");
                    $req_det_pk = $req_det_pk->result_array();
                    $req_det_pk_id = $req_det_pk[0]['RE_PK'];

                    $this->db->query("INSERT INTO LZW_REPAIRE_DT (REPAIRE_DT_ID, REPAIRE_ID, ISSUE_DT_ID)VALUES($req_det_pk_id,$req_pk_id, '$key' ) ");                              
                }

                if(isset($_FILES['images'])){

                $query = $this->db->query("SELECT c.MASTER_PATH from lz_pict_path_config c where c.path_id = 9");
                $specific_qry = $query->result_array();
                $specific_path = $specific_qry[0]['MASTER_PATH'];
                // $specific_path = "E:/wamp/www/item_pictures/repair_pics/";
    
                $main_dir =  $specific_path . $get_req_id;
                if (is_dir($main_dir) === false) {
                    mkdir($main_dir);
                }
                foreach ($images['name'] as $key => $value) {
                    $_FILES['file']['name'] = $_FILES['images']['name'][$key];
                    $_FILES['file']['type'] = $_FILES['images']['type'][$key];
                    $_FILES['file']['tmp_name'] = $_FILES['images']['tmp_name'][$key];
                    $_FILES['file']['error'] = $_FILES['images']['error'][$key];
                    $_FILES['file']['size'] = $_FILES['images']['size'][$key];
                    $config['upload_path'] = $main_dir; 
                    $config['allowed_types'] = 'jpg|jpeg|png|gif';
                    $config['max_size'] = '10000'; // max_size in kb
                    $new_name = $get_req_id.'_repairing';
                    $config['file_name'] = $new_name;
                    //Load upload library
                    $this->load->library('upload',$config); 
                    $this->upload->do_upload('file');
                }

            }// pic code check against null
                
            }
            return array('get_req_id'=>$get_req_id,'exist'=>true);
        }else{
            $get_req_id = '';
            return array('get_req_id'=>$get_req_id,'exist'=>false); 
        }


        
    }

    public function get_repairs(){

        $searcInput = $this->input->post('searcInput');
        
        $searcInput = strtoupper(trim(str_replace("  ", ' ', $searcInput)));
        $searcInput = str_replace(array("`,′"), "", $searcInput);
        $searcInput = str_replace(array("'"), "''", $searcInput);

    $get_data = $this->db->query("SELECT * FROM (SELECT 'REP-' || LPAD(NVL(RM.REPAIRE_MT_ID, 0), 6, '0') REPAIR_ID, RM.REPAIRE_MT_ID, RM.F_NAME || ' ' || RM.L_NAME F_NAME, RM.L_NAME, RM.EMAIL, RM.CONTACT_NO, RM.CUSTOMER_REMARKS, (SELECT OM.OBJECT_NAME FROM LZW_OBJECT_MT OM WHERE OM.OBJECT_ID = RM.OBJECT_ID) PRODUCT_NAME, /*(SELECT BMM.DESCRIPTION FROM LZW_BRANDS_DT BT, LZW_BRANDS_MT BMM WHERE BMM.BRAND_ID = BT.BRAND_ID AND TO_CHAR(BT.BRAND_DT_ID) = RM.BRAND_INPUT) BRAND_NAME,*/ DECODE((SELECT BMM.DESCRIPTION FROM LZW_BRANDS_DT BT, LZW_BRANDS_MT BMM WHERE BMM.BRAND_ID = BT.BRAND_ID AND TO_CHAR(BT.BRAND_DT_ID) = RM.BRAND_INPUT), NULL, RM.BRAND_INPUT, (SELECT BMM.DESCRIPTION FROM LZW_BRANDS_DT BT, LZW_BRANDS_MT BMM WHERE BMM.BRAND_ID = BT.BRAND_ID AND TO_CHAR(BT.BRAND_DT_ID) = RM.BRAND_INPUT)) BRAND_NAME, /* (SELECT SM.DESCRIPTION FROM LZW_SERIES_MT SM, LZW_SERIES_DT ST WHERE SM.SERIES_ID = ST.SERIES_ID AND TO_CHAR(ST.SERIES_DT_ID) = RM.SERIES_INPUT) SERIES_NAME,*/ DECODE((SELECT SM.DESCRIPTION FROM LZW_SERIES_MT SM, LZW_SERIES_DT ST WHERE SM.SERIES_ID = ST.SERIES_ID AND TO_CHAR(ST.SERIES_DT_ID) = RM.SERIES_INPUT), NULL, RM.SERIES_INPUT, (SELECT SM.DESCRIPTION FROM LZW_SERIES_MT SM, LZW_SERIES_DT ST WHERE SM.SERIES_ID = ST.SERIES_ID AND TO_CHAR(ST.SERIES_DT_ID) = RM.SERIES_INPUT)) SERIES_NAME, /*(SELECT MOM.DESCRIPTION FROM LZW_MODEL_MT MOM, LZW_MODEL_DT MDT WHERE MOM.MODEL_ID = MDT.MODEL_ID AND TO_CHAR(MDT.MODEL_DT_ID) = RM.MODAL_INPUT) MODEL_NAME,*/ DECODE((SELECT MOM.DESCRIPTION FROM LZW_MODEL_MT MOM, LZW_MODEL_DT MDT WHERE MOM.MODEL_ID = MDT.MODEL_ID AND TO_CHAR(MDT.MODEL_DT_ID) = RM.MODAL_INPUT), NULL, RM.MODAL_INPUT, (SELECT MOM.DESCRIPTION FROM LZW_MODEL_MT MOM, LZW_MODEL_DT MDT WHERE MOM.MODEL_ID = MDT.MODEL_ID AND TO_CHAR(MDT.MODEL_DT_ID) = RM.MODAL_INPUT)) MODEL_NAME, NVL(OFFER, 0) OFFER, CASE WHEN nvl(OFFER,0) >= 1  then 'Approved' else 'Pending' end status FROM LZW_REPAIRE_MT RM ORDER BY REPAIRE_MT_ID DESC) where REPAIR_ID='$searcInput' ")->result_array(); if(count($get_data)>0){

        return array('get_data' => $get_data,'exist'=>true);

    }else{
        return array('get_data' => $get_data,'exist'=>false);
    }


}


public function saveOptionData(){

    $address = $this->input->post('address');
    $city = $this->input->post('city');
    $area = $this->input->post('area');
    $state = $this->input->post('state');
    $zipcode = $this->input->post('zipcode');
    //$getRepareId = TRIM($this->input->post('getRepareId');
    $getRepareId = strtoupper(trim(str_replace("  ", ' ', $this->input->post('getRepareId'))));

    $getradio = $this->input->post('getradio');

    $save = $this->db->query(" UPDATE LZW_REPAIRE_MT SET SELECT_OPTION ='$getradio'  where REPAIRE_MT_ID = (SELECT REP_ID
          FROM (SELECT 'REP-' || LPAD(NVL(RM.REPAIRE_MT_ID, 0), 6, '0') REPAIR_ID,RM.REPAIRE_MT_ID REP_ID
                  FROM LZW_REPAIRE_MT RM) where UPPER(REPAIR_ID)='$getRepareId' )");
    if($save){
        $query = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('lzw_pickups', 'PICK_ID')ID FROM DUAL")->result_array();
        $pk = $query[0]['ID'];
        $stat_query = $this->db->query("INSERT INTO  
            lzw_pickups(PICK_ID,REPAIRE_ID,STREET,CITY,STATE,ZIP,CREATED_AT, UPDATED_AT) 
                values 
                    ($pk,
                    '$getRepareId',
                    '$address',
                    '$city',
                    '$state',
                    '$zipcode',
                    sysdate,
                    sysdate)");
            if($stat_query){
                return array(
                    "save" => true,
                    "message" => "Successfully Save !");
            } else{
                return array(
                    "save" => false,
                    "message" => "Updated but no save !");
            }       
    }else{
        return array(
            "save" => false,
            "message" => "Something went wrong !");
    }


}

}
