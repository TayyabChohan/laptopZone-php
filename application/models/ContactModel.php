<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class ContactModel extends CI_Model {

    private $contact = 'contact';

    function get_unposted_items() {
        $query = $this->db->query("SELECT 'DEKIT' BAROCDE_TYPE, D.LZ_DEKIT_US_DT_ID, D.BARCODE_PRV_NO, C.COND_NAME, O.OBJECT_NAME, D.PIC_DATE_TIME, D.PIC_BY, D.PIC_NOTES, DECODE(D.MPN_DESCRIPTION, NULL, CA.MPN_DESCRIPTION, D.MPN_DESCRIPTION) MPN_DESC, CA.MPN, CA.UPC, CA.BRAND, TO_CHAR(D.FOLDER_NAME)FOLDER_NAME , D.DEKIT_REMARKS REMARKS FROM LZ_DEKIT_US_DT D, LZ_BD_OBJECTS_MT O, LZ_CATALOGUE_MT CA,LZ_ITEM_COND_MT C WHERE/* D.BARCODE_PRV_NO = 128966 AND*/ D.OBJECT_ID = O.OBJECT_ID(+) AND D.CATALOG_MT_ID = CA.CATALOGUE_MT_ID(+) AND D.CONDITION_ID = C.ID(+)   and d.barcode_prv_no =117001/* not in (select barcode_no from lz_barcode_mt where barcode_no <> 117001 )*/ AND ROWNUM <=20 UNION ALL SELECT 'SPECIAL LOT' BAROCDE_TYPE, L.SPECIAL_LOT_ID, L.BARCODE_PRV_NO, C.COND_NAME, OB.OBJECT_NAME, L.PIC_DATE_TIME, L.PIC_BY, L.PIC_NOTES, DECODE(L.MPN_DESCRIPTION, NULL, CA.MPN_DESCRIPTION, L.MPN_DESCRIPTION) MPN_DESC, DECODE(L.CARD_MPN, NULL, CA.MPN, L.CARD_MPN) MPN, DECODE(L.CARD_UPC, NULL, CA.UPC, L.CARD_UPC) UPC, DECODE(L.BRAND, NULL, CA.BRAND, L.BRAND) BRAND, TO_CHAR(L.FOLDER_NAME) FOLDER_NAME,L.LOT_REMARKS REMARKS FROM LZ_SPECIAL_LOTS  L, LZ_BD_OBJECTS_MT OB, LZ_ITEM_COND_MT  C, LZ_CATALOGUE_MT  CA WHERE/* L.BARCODE_PRV_NO = 128680 AND */L.OBJECT_ID = OB.OBJECT_ID(+) AND L.CONDITION_ID = C.ID(+)  and l.barcode_prv_no not in (select barcode_no from lz_barcode_mt  ) AND L.CATALOG_MT_ID = CA.CATALOGUE_MT_ID(+) AND ROWNUM <=20 ORDER BY BAROCDE_TYPE asc ");
        if ($query) {
            $get_items =$query->result_array();
            return array('get_items' => $get_items);
        }else{
        return NULL;
        }
    }

    function obj_drop(){
        $get_obj = $this->db->query("SELECT O.OBJECT_ID, O.OBJECT_NAME, O.CATEGORY_ID FROM LZ_BD_CAT_GROUP_MT M, LZ_BD_CAT_GROUP_DET D, LZ_BD_OBJECTS_MT O WHERE M.LZ_BD_GROUP_ID = D.LZ_BD_GROUP_ID AND M.LZ_BD_GROUP_ID = O.LZ_BD_GROUP_ID AND D.LZ_BD_GROUP_ID = O.LZ_BD_GROUP_ID AND D.CATEGORY_ID = O.CATEGORY_ID AND M.LZ_BD_GROUP_ID = 7 ");

        if ($get_obj) {
            $get_obj_itm =$get_obj->result_array();
            return array('get_obj_itm' => $get_obj_itm);
        }else{
        return NULL;
        }

    }

    function get_contact($id) {
        $query = $this->db->get_where($this->contact, array("contact_id" => $id));
        if ($query) {
            return $query->row();
        }
        return NULL;
    }

}