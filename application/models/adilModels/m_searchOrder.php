<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Single Entry Model
 */
class m_searchOrder extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function get_search_order_record()
    {
        $parameter                = trim($this->input->post('searchOrder'));
        $search_type              = $this->input->post('search_type');
        $other_by                 = $this->input->post('other_by');
        $search_extended_order_id = $this->input->post('search_extended_order_id');
        $search_order_id          = $this->input->post('search_order_id');
        $search_sale_order        = $this->input->post('search_sale_order');
        $ebay_id                  = $this->input->post('ebay_id');
        $daysCheck                = $this->input->post('daysCheck');
        $equalLike                = $this->input->post('equalLike');
        if ($daysCheck == 'on') {
            $qryOlder90 = "";
        } else {
            $qryOlder90 = "AND DET.INSERTED_DATE >= sysdate-90 ";
        }
        $parm = '';
        $i    = 0;
        if ($equalLike == 'LIKE') {
            if ($search_type == 'on') {
                $tempPara = (explode(" ", $parameter));
                foreach ($tempPara as $key => $value) {
                    if ($i === 0) {
                        $parm .= "(upper(DET.$other_by) LIKE upper('%$value%')";
                    } else {
                        $parm .= "AND upper(DET.$other_by) LIKE upper('%$value%')";
                    }
                    $i++;
                }
                if (count($tempPara) == 1) {
                    $preQuery = $qryOlder90 . "AND " . $parm . ")";
                } else {
                    $preQuery = $qryOlder90 . "AND " . $parm . ")";
                }
                
                $query = "SELECT 
                DET.ITEM_TITLE,
                DET.SALES_RECORD_NUMBER SALE_RECORD_NO,
                DET.BUYER_ADDRESS1,
                DET.ORDER_ID,
                DET.EXTENDEDORDERID,
                MT.LZ_SALELOAD_ID,
                MT.LZ_SELLER_ACCT_ID,
                DET.USER_ID,
                DET.BUYER_FULLNAME,
                DET.QUANTITY,
                DET.SALE_PRICE,
                DET.TOTAL_PRICE,
                DET.SALE_DATE,
                DET.TRACKING_NUMBER,
                DET.BUYER_ZIP,
                DET.ITEM_ID,
                DET.SALES_RECORD_NO_GROUP,
                (SELECT COUNT(1) QTY_RETURN
                   FROM LJ_CANCELLATION_DT D
                  WHERE D.ORDER_ID = DET.ORDER_ID
                  GROUP BY D.ORDER_ID) QTY_RETURN 
                 FROM  LZ_SALESLOAD_DET DET,
                      LZ_SALESLOAD_MT  MT 
                WHERE MT.LZ_SALELOAD_ID = DET.LZ_SALELOAD_ID
                  AND DET.ORDER_ID NOT IN
                      (SELECT ORDER_ID
                         FROM (SELECT D.ORDER_ID,
                                 COUNT(1) QTY_RETURN,
                                 MAX(SD.QUANTITY) QTY_SOLD
                                 FROM LJ_CANCELLATION_DT D, LZ_SALESLOAD_DET SD
                                WHERE SD.ORDER_ID = D.ORDER_ID
                               GROUP BY D.ORDER_ID)
                        WHERE QTY_RETURN = QTY_SOLD)
                ";
                $query .= $preQuery . " ORDER BY DET.LZ_SALESLOAD_DET_ID)";
                $query = "SELECT * FROM(" . $query . " WHERE ROWNUM <=1000";
                $query = $this->db->query($query)->result_array();
                if ($query) {
                    return array(
                        "found" => true,
                        "searchOrderResult" => $query
                    );
                } else {
                    return array(
                        "found" => false,
                        "message" => "Order already canceled!"
                    );
                }
            } else {
                if ($search_extended_order_id == 'on') {
                    $checkValid = $this->db->query("SELECT EXTENDEDORDERID FROM LZ_SALESLOAD_DET WHERE EXTENDEDORDERID LIKE '%$parameter%' ")->row();
                    if (!$checkValid) {
                        return array(
                            "found" => false,
                            "message" => "Record Not Found Against Extended Order Id!"
                        );
                    }
                    $checkReturn = $this->db->query("SELECT * FROM lj_returned_barcode_mt WHERE EXTENDEDORDERID = '$parameter'")->row();
                    if ($checkReturn) {
                        return array(
                            "found" => false,
                            "message" => "Return created against this order. Can't be Canceled!"
                        );
                    }
                    
                } elseif ($search_order_id == 'on') {
                    $checkValid = $this->db->query("SELECT TRACKING_NUMBER FROM LZ_SALESLOAD_DET WHERE TRACKING_NUMBER LIKE '%$parameter%' ")->row();
                    if (!$checkValid) {
                        return array(
                            "found" => false,
                            "message" => "Record Not Found Against Tracking Number!"
                        );
                    }
                    $checkReturn = $this->db->query("SELECT * FROM lj_returned_barcode_mt bb WHERE bb.order_id =
                         (SELECT d.order_id
                            FROM lz_salesload_det d
                           WHERE d.tracking_number = '$parameter')")->row();
                    if ($checkReturn) {
                        return array(
                            "found" => false,
                            "message" => "Return created against this order. Can't be Canceled!"
                        );
                    }
                } elseif ($search_sale_order == 'on') {
                    $checkValid = $this->db->query("SELECT SALES_RECORD_NUMBER FROM LZ_SALESLOAD_DET WHERE SALES_RECORD_NUMBER LIKE '%$parameter%' ")->row();
                    if (!$checkValid) {
                        return array(
                            "found" => false,
                            "message" => "Record Not Found Against Sale Record Number!"
                        );
                    }
                    $checkReturn = $this->db->query("SELECT * FROM lj_returned_barcode_mt WHERE SALE_RECORD_NO = '$parameter'")->row();
                    if ($checkReturn) {
                        return array(
                            "found" => false,
                            "message" => "Return created against this order. Can't be Canceled!"
                        );
                    }
                    
                } elseif ($ebay_id == 'on') {
                    $checkValid = $this->db->query("SELECT ITEM_ID FROM LZ_SALESLOAD_DET WHERE ITEM_ID LIKE '%$parameter%' ")->row();
                    if (!$checkValid) {
                        return array(
                            "found" => false,
                            "message" => "Record Not Found Against Item Id!"
                        );
                    }
                    $checkReturn = $this->db->query("SELECT * FROM lj_returned_barcode_mt WHERE EBAY_ITEM_ID = '$parameter'")->row();
                    if ($checkReturn) {
                        return array(
                            "found" => false,
                            "message" => "Return created against this order. Can't be Canceled!"
                        );
                    }
                }
                if ($search_extended_order_id == 'on') {
                    $preQuery = $qryOlder90 . "AND (DET.EXTENDEDORDERID LIKE '%$parameter%')";
                } elseif ($search_order_id == 'on') {
                    $preQuery = $qryOlder90 . "AND (DET.TRACKING_NUMBER LIKE '%$parameter%')";
                } elseif ($search_sale_order == 'on') {
                    $preQuery = $qryOlder90 . "AND (DET.SALES_RECORD_NUMBER LIKE '%$parameter%')";
                } elseif ($ebay_id == 'on') {
                    $preQuery = $qryOlder90 . "AND (DET.ITEM_ID LIKE '%$parameter%')";
                } else {
                    $preQuery = $qryOlder90 . "AND (DET.SALES_RECORD_NUMBER LIKE '%$parameter%' OR DET.ORDER_ID LIKE '%$parameter%' OR
                    DET.EXTENDEDORDERID LIKE '%$parameter%')";
                }
                
                $query = "SELECT 
                DET.ITEM_TITLE,
                DET.SALES_RECORD_NUMBER SALE_RECORD_NO,
                DET.BUYER_ADDRESS1,
                DET.ORDER_ID,
                DET.EXTENDEDORDERID,
                MT.LZ_SALELOAD_ID,
                MT.LZ_SELLER_ACCT_ID,
                DET.USER_ID,
                DET.BUYER_FULLNAME,
                DET.QUANTITY,
                DET.SALE_PRICE,
                DET.TOTAL_PRICE,
                DET.SALE_DATE,
                DET.TRACKING_NUMBER,
                DET.BUYER_ZIP,
                DET.ITEM_ID,
                DET.SALES_RECORD_NO_GROUP,
                (SELECT COUNT(1) QTY_RETURN
                   FROM LJ_CANCELLATION_DT D
                  WHERE D.ORDER_ID = DET.ORDER_ID
                  GROUP BY D.ORDER_ID) QTY_RETURN 
                 FROM  LZ_SALESLOAD_DET DET,
                      LZ_SALESLOAD_MT  MT 
                WHERE MT.LZ_SALELOAD_ID = DET.LZ_SALELOAD_ID
                  AND DET.ORDER_ID NOT IN
                      (SELECT ORDER_ID
                         FROM (SELECT D.ORDER_ID,
                                 COUNT(1) QTY_RETURN,
                                 MAX(SD.QUANTITY) QTY_SOLD
                                 FROM LJ_CANCELLATION_DT D, LZ_SALESLOAD_DET SD
                                WHERE SD.ORDER_ID = D.ORDER_ID
                               GROUP BY D.ORDER_ID)
                        WHERE QTY_RETURN = QTY_SOLD)
                AND ROWNUM <= 1000";
                $query .= $preQuery;
                $query = $this->db->query($query)->result_array();
                if ($query) {
                    // group 
                    $group_id = $query[0]['SALES_RECORD_NO_GROUP'];
                    if ($group_id) {
                        $query    = "SELECT 
                            DET.ITEM_TITLE,
                            DET.SALES_RECORD_NUMBER SALE_RECORD_NO,
                            DET.BUYER_ADDRESS1,
                            DET.ORDER_ID,
                            DET.EXTENDEDORDERID,
                            MT.LZ_SALELOAD_ID,
                            MT.LZ_SELLER_ACCT_ID,
                            DET.USER_ID,
                            DET.BUYER_FULLNAME,
                            DET.QUANTITY,
                            DET.SALE_PRICE,
                            DET.TOTAL_PRICE,
                            DET.SALE_DATE,
                            DET.TRACKING_NUMBER,
                            DET.BUYER_ZIP,
                            DET.ITEM_ID,
                            DET.SALES_RECORD_NO_GROUP,
                            (SELECT COUNT(1) QTY_RETURN
                            FROM LJ_CANCELLATION_DT D
                            WHERE D.ORDER_ID = DET.ORDER_ID
                            GROUP BY D.ORDER_ID) QTY_RETURN 
                            FROM  LZ_SALESLOAD_DET DET,
                                LZ_SALESLOAD_MT  MT 
                            WHERE MT.LZ_SALELOAD_ID = DET.LZ_SALELOAD_ID
                            AND DET.ORDER_ID NOT IN
                                (SELECT ORDER_ID
                                    FROM (SELECT D.ORDER_ID,
                                            COUNT(1) QTY_RETURN,
                                            MAX(SD.QUANTITY) QTY_SOLD
                                            FROM LJ_CANCELLATION_DT D, LZ_SALESLOAD_DET SD
                                            WHERE SD.ORDER_ID = D.ORDER_ID
                                        GROUP BY D.ORDER_ID)
                                    WHERE QTY_RETURN = QTY_SOLD)
                            AND ROWNUM <= 1000";
                        $preQuery = $qryOlder90 . "AND (DET.SALES_RECORD_NO_GROUP LIKE '%$group_id%')";
                        $query .= $preQuery;
                        $query = $this->db->query($query)->result_array();
                    }
                    // end group
                    return array(
                        "found" => true,
                        "searchOrderResult" => $query
                    );
                } else {
                    return array(
                        "found" => false,
                        "message" => "Order already canceled!"
                    );
                }
            }
        } else {
            if ($search_type == 'on') {
                $tempPara = (explode(" ", $parameter));
                $parm .= "(upper(DET.$other_by) = upper('$parameter'))";
                $preQuery = $qryOlder90 . "AND " . $parm;
                $query    = "SELECT 
                DET.ITEM_TITLE,
                DET.SALES_RECORD_NUMBER SALE_RECORD_NO,
                DET.BUYER_ADDRESS1,
                DET.ORDER_ID,
                DET.EXTENDEDORDERID,
                MT.LZ_SALELOAD_ID,
                MT.LZ_SELLER_ACCT_ID,
                DET.USER_ID,
                DET.BUYER_FULLNAME,
                DET.QUANTITY,
                DET.SALE_PRICE,
                DET.TOTAL_PRICE,
                DET.SALE_DATE,
                DET.TRACKING_NUMBER,
                DET.BUYER_ZIP,
                DET.ITEM_ID,
                DET.SALES_RECORD_NO_GROUP,
                (SELECT COUNT(1) QTY_RETURN
                   FROM LJ_CANCELLATION_DT D
                  WHERE D.ORDER_ID = DET.ORDER_ID
                  GROUP BY D.ORDER_ID) QTY_RETURN 
                 FROM  LZ_SALESLOAD_DET DET,
                      LZ_SALESLOAD_MT  MT 
                WHERE MT.LZ_SALELOAD_ID = DET.LZ_SALELOAD_ID
                  AND DET.ORDER_ID NOT IN
                      (SELECT ORDER_ID
                         FROM (SELECT D.ORDER_ID,
                                 COUNT(1) QTY_RETURN,
                                 MAX(SD.QUANTITY) QTY_SOLD
                                 FROM LJ_CANCELLATION_DT D, LZ_SALESLOAD_DET SD
                                WHERE SD.ORDER_ID = D.ORDER_ID
                               GROUP BY D.ORDER_ID)
                        WHERE QTY_RETURN = QTY_SOLD)
                ";
                $query .= $preQuery . " ORDER BY DET.LZ_SALESLOAD_DET_ID)";
                $query = "SELECT * FROM(" . $query . " WHERE ROWNUM <=1000";
                $query = $this->db->query($query)->result_array();
                if ($query) {
                    return array(
                        "found" => true,
                        "searchOrderResult" => $query
                    );
                } else {
                    return array(
                        "found" => false,
                        "message" => "Order already canceled!"
                    );
                }
            } else {
                if ($search_extended_order_id == 'on') {
                    $checkValid = $this->db->query("SELECT EXTENDEDORDERID FROM LZ_SALESLOAD_DET WHERE EXTENDEDORDERID = '$parameter' ")->row();
                    if (!$checkValid) {
                        return array(
                            "found" => false,
                            "message" => "Record Not Found Against Extended Order Id!"
                        );
                    }
                    $checkReturn = $this->db->query("SELECT * FROM lj_returned_barcode_mt WHERE EXTENDEDORDERID = '$parameter'")->row();
                    if ($checkReturn) {
                        return array(
                            "found" => false,
                            "message" => "Return created against this order. Can't be Canceled!"
                        );
                    }
                } elseif ($search_order_id == 'on') {
                    $checkValid = $this->db->query("SELECT TRACKING_NUMBER FROM LZ_SALESLOAD_DET WHERE TRACKING_NUMBER = '$parameter' ")->row();
                    if (!$checkValid) {
                        return array(
                            "found" => false,
                            "message" => "Record Not Found Against Tracking Number!"
                        );
                    }
                    $checkReturn = $this->db->query("SELECT * FROM lj_returned_barcode_mt bb WHERE bb.order_id =
                         (SELECT d.order_id
                            FROM lz_salesload_det d
                           WHERE d.tracking_number = '$parameter')")->row();
                    if ($checkReturn) {
                        return array(
                            "found" => false,
                            "message" => "Return created against this order. Can't be Canceled!"
                        );
                    }
                } elseif ($search_sale_order == 'on') {
                    $checkValid = $this->db->query("SELECT SALES_RECORD_NUMBER FROM LZ_SALESLOAD_DET WHERE SALES_RECORD_NUMBER = '$parameter' ")->row();
                    if (!$checkValid) {
                        return array(
                            "found" => false,
                            "message" => "Record Not Found Against Sale Record Number!"
                        );
                    }
                    $checkReturn = $this->db->query("SELECT * FROM lj_returned_barcode_mt WHERE SALE_RECORD_NO = '$parameter'")->row();
                    if ($checkReturn) {
                        return array(
                            "found" => false,
                            "message" => "Return created against this order. Can't be Canceled!"
                        );
                    }
                    
                } elseif ($ebay_id == 'on') {
                    $checkValid = $this->db->query("SELECT ITEM_ID FROM LZ_SALESLOAD_DET WHERE ITEM_ID = '$parameter' ")->row();
                    if (!$checkValid) {
                        return array(
                            "found" => false,
                            "message" => "Record Not Found Against Item Id!"
                        );
                    }
                    $checkReturn = $this->db->query("SELECT * FROM lj_returned_barcode_mt WHERE EBAY_ITEM_ID = '$parameter'")->row();
                    if ($checkReturn) {
                        return array(
                            "found" => false,
                            "message" => "Return created against this order. Can't be Canceled!"
                        );
                    }
                }
                
                
                if ($search_extended_order_id == 'on') {
                    $preQuery = $qryOlder90 . "AND (DET.EXTENDEDORDERID = '$parameter')";
                } elseif ($search_order_id == 'on') {
                    $preQuery = $qryOlder90 . "AND (DET.TRACKING_NUMBER = '$parameter')";
                } elseif ($search_sale_order == 'on') {
                    $preQuery = $qryOlder90 . "AND (DET.SALES_RECORD_NUMBER = '$parameter')";
                } elseif ($ebay_id == 'on') {
                    $preQuery = $qryOlder90 . "AND (DET.ITEM_ID = '$parameter')";
                } else {
                    $preQuery = $qryOlder90 . "AND (DET.SALES_RECORD_NUMBER = '$parameter' OR DET.ORDER_ID = '$parameter' OR
                    DET.EXTENDEDORDERID = '$parameter')";
                }
                
                $query = "SELECT 
                DET.ITEM_TITLE,
                DET.SALES_RECORD_NUMBER SALE_RECORD_NO,
                DET.BUYER_ADDRESS1,
                DET.ORDER_ID,
                DET.EXTENDEDORDERID,
                MT.LZ_SALELOAD_ID,
                MT.LZ_SELLER_ACCT_ID,
                DET.USER_ID,
                DET.BUYER_FULLNAME,
                DET.QUANTITY,
                DET.SALE_PRICE,
                DET.TOTAL_PRICE,
                DET.SALE_DATE,
                DET.TRACKING_NUMBER,
                DET.BUYER_ZIP,
                DET.ITEM_ID,
                DET.SALES_RECORD_NO_GROUP,
                (SELECT COUNT(1) QTY_RETURN
                   FROM LJ_CANCELLATION_DT D
                  WHERE D.ORDER_ID = DET.ORDER_ID
                  GROUP BY D.ORDER_ID) QTY_RETURN 
                 FROM  LZ_SALESLOAD_DET DET,
                      LZ_SALESLOAD_MT  MT 
                WHERE MT.LZ_SALELOAD_ID = DET.LZ_SALELOAD_ID
                  AND DET.ORDER_ID NOT IN
                      (SELECT ORDER_ID
                         FROM (SELECT D.ORDER_ID,
                                 COUNT(1) QTY_RETURN,
                                 MAX(SD.QUANTITY) QTY_SOLD
                                 FROM LJ_CANCELLATION_DT D, LZ_SALESLOAD_DET SD
                                WHERE SD.ORDER_ID = D.ORDER_ID
                               GROUP BY D.ORDER_ID)
                        WHERE QTY_RETURN = QTY_SOLD)
                ";
                $query .= $preQuery;
                $query = $this->db->query($query)->result_array();
                if ($query) {
                    $group_id = $query[0]['SALES_RECORD_NO_GROUP'];
                    if ($group_id) {
                        $query    = "SELECT 
                            DET.ITEM_TITLE,
                            DET.SALES_RECORD_NUMBER SALE_RECORD_NO,
                            DET.BUYER_ADDRESS1,
                            DET.ORDER_ID,
                            DET.EXTENDEDORDERID,
                            MT.LZ_SALELOAD_ID,
                            MT.LZ_SELLER_ACCT_ID,
                            DET.USER_ID,
                            DET.BUYER_FULLNAME,
                            DET.QUANTITY,
                            DET.SALE_PRICE,
                            DET.TOTAL_PRICE,
                            DET.SALE_DATE,
                            DET.TRACKING_NUMBER,
                            DET.BUYER_ZIP,
                            DET.ITEM_ID,
                            DET.SALES_RECORD_NO_GROUP,
                            (SELECT COUNT(1) QTY_RETURN
                            FROM LJ_CANCELLATION_DT D
                            WHERE D.ORDER_ID = DET.ORDER_ID
                            GROUP BY D.ORDER_ID) QTY_RETURN 
                            FROM  LZ_SALESLOAD_DET DET,
                                LZ_SALESLOAD_MT  MT 
                            WHERE MT.LZ_SALELOAD_ID = DET.LZ_SALELOAD_ID
                            AND DET.ORDER_ID NOT IN
                                (SELECT ORDER_ID
                                    FROM (SELECT D.ORDER_ID,
                                            COUNT(1) QTY_RETURN,
                                            MAX(SD.QUANTITY) QTY_SOLD
                                            FROM LJ_CANCELLATION_DT D, LZ_SALESLOAD_DET SD
                                            WHERE SD.ORDER_ID = D.ORDER_ID
                                        GROUP BY D.ORDER_ID)
                                    WHERE QTY_RETURN = QTY_SOLD)
                            AND ROWNUM <= 1000";
                        $preQuery = $qryOlder90 . "AND (DET.SALES_RECORD_NO_GROUP LIKE '%$group_id%')";
                        $query .= $preQuery;
                        $query = $this->db->query($query)->result_array();
                    }
                    return array(
                        "found" => true,
                        "searchOrderResult" => $query
                    );
                } else {
                    return array(
                        "found" => false,
                        "message" => "Order already canceled!"
                    );
                }
            }
        }
    }
    public function processCancel($order_id, $remarks, $cancel_by, $bin_id, $barcode_no)
    {
        
        $check_bin_id  = $this->db->query("SELECT BIN_ID FROM BIN_MT BB WHERE UPPER(BB.BIN_TYPE) ||'-'||BB.BIN_NO = UPPER('$bin_id')")->row();
        $cancel_status = $this->input->post("barcode_status");
        $cancel_id     = "";
        if ($check_bin_id) {
            $bin_id = $check_bin_id->BIN_ID;
        } else {
            $bin_id = 0;
        }
        $group_record_number = $this->db->query("SELECT SALES_RECORD_NO_GROUP FROM LZ_SALESLOAD_DET WHERE ORDER_ID ='$order_id'")->row();
        $group_record_number = $group_record_number->SALES_RECORD_NO_GROUP;
        if ($group_record_number) {
            $order_ids = $this->db->query("SELECT ORDER_ID FROM LZ_SALESLOAD_DET WHERE SALES_RECORD_NO_GROUP = '$group_record_number'")->result_array();
            foreach ($order_ids as $key => $value) {
                $order_id_temp     = $value['ORDER_ID'];
                $updateData = $this->db->query("UPDATE LZ_SALESLOAD_DET SET RELEASE_DATE = sysdate, RELEASE_BY = '$cancel_by' WHERE ORDER_ID = '$order_id_temp'");
                $getData           = $this->db->query("SELECT DT.ORDER_ID,DT.SALES_RECORD_NUMBER,DT.EXTENDEDORDERID FROM LZ_SALESLOAD_DET DT WHERE DT.ORDER_ID =  '$order_id_temp'")->result_array();
                $sale_record_no    = $getData[0]['SALES_RECORD_NUMBER'];
                $extended_order_id = $getData[0]['EXTENDEDORDERID'];
                $barcode_no        = $this->db->query("SELECT B.BARCODE_NO FROM LZ_BARCODE_MT B
                        WHERE B.ORDER_ID = '$order_id_temp'")->result_array();
                foreach ($barcode_no as $barcode) {
                    $barcode = $barcode['BARCODE_NO'];
                    $this->db->query("INSERT INTO LJ_CANCELLATION_DT CD (CD.CANCELLATION_DT_ID,
                                                            CD.BARCODE_NO,
                                                            CD.sale_order_id,
                                                            CD.extendedorderid,
                                                            CD.ORDER_ID)
                                                            values (
                                                                GET_SINGLE_PRIMARY_KEY('LJ_CANCELLATION_DT','CANCELLATION_DT_ID'),
                                                                '$barcode',
                                                                '$sale_record_no',
                                                                '$extended_order_id',
                                                                '$order_id') ");
                    if ($cancel_status == 'release') {
                        $qyer = $this->db->query("UPDATE lz_barcode_mt b
                                        SET b.ebay_item_id    = '',
                                            b.sale_record_no  = '',
                                            b.list_id         = '',
                                            b.pulling_id      = '',
                                            b.bin_id          = '$bin_id',
                                            b.order_id        = '',
                                            b.packing_id      = '',
                                            b.packing_by      = '',
                                            b.packing_date    = '',
                                            b.ebay_sticker    = 0,
                                            b.audit_datetime  = '',
                                            b.audit_by        = '',
                                            b.shopify_list_id = ''
                                    WHERE b.barcode_no = '$barcode'");
                    } else {
                        $qyer = $this->db->query("UPDATE lz_barcode_mt b
                                    SET b.condition_id  = -1,
                                        DISCARD_DATE    = sysdate,
                                        DISCARD_BY      = '$cancel_by',
                                        DISCARD         = 1,
                                        DISCARD_REMARKS = '$remarks'
                                WHERE b.barcode_no = '$barcode'");
                    }
                    
                }
            }
        } else {
            $updateData        = $this->db->query("UPDATE LZ_SALESLOAD_DET SET RELEASE_DATE = sysdate, RELEASE_BY = '$cancel_by' WHERE ORDER_ID = '$order_id'");
            $getData           = $this->db->query("SELECT DT.ORDER_ID,DT.SALES_RECORD_NUMBER,DT.EXTENDEDORDERID FROM LZ_SALESLOAD_DET DT WHERE DT.ORDER_ID =  '$order_id' ")->result_array();
            $sale_record_no    = $getData[0]['SALES_RECORD_NUMBER'];
            $extended_order_id = $getData[0]['EXTENDEDORDERID'];
            $barcode_no        = $this->db->query("SELECT B.BARCODE_NO FROM LZ_BARCODE_MT B
                        WHERE B.ORDER_ID = '$order_id'")->result_array();
            foreach ($barcode_no as $barcode) {
                $barcode = $barcode['BARCODE_NO'];
                $this->db->query("INSERT INTO LJ_CANCELLATION_DT CD (CD.CANCELLATION_DT_ID,
                                                                CD.BARCODE_NO,
                                                                CD.sale_order_id,
                                                                CD.extendedorderid,
                                                                CD.ORDER_ID)
                                                                values (
                                                                    GET_SINGLE_PRIMARY_KEY('LJ_CANCELLATION_DT','CANCELLATION_DT_ID'),
                                                                    '$barcode',
                                                                    '$sale_record_no',
                                                                    '$extended_order_id',
                                                                    '$order_id') ");
                if ($cancel_status == 'release') {
                    $qyer = $this->db->query("UPDATE lz_barcode_mt b
                                            SET b.ebay_item_id    = '',
                                                b.sale_record_no  = '',
                                                b.list_id         = '',
                                                b.pulling_id      = '',
                                                b.bin_id          = '$bin_id',
                                                b.order_id        = '',
                                                b.packing_id      = '',
                                                b.packing_by      = '',
                                                b.packing_date    = '',
                                                b.ebay_sticker    = 0,
                                                b.audit_datetime  = '',
                                                b.audit_by        = '',
                                                b.shopify_list_id = ''
                                        WHERE b.barcode_no = '$barcode'");
                } else {
                    $qyer = $this->db->query("UPDATE lz_barcode_mt b
                                        SET b.condition_id  = -1,
                                            DISCARD_DATE    = sysdate,
                                            DISCARD_BY      = '$cancel_by',
                                            DISCARD         = 1,
                                            DISCARD_REMARKS = '$remarks'
                                    WHERE b.barcode_no = '$barcode'");
                }
                
            }
            
        }
        // exit();
        // $updateData = $this->db->query("UPDATE LZ_SALESLOAD_DET SET RELEASE_DATE = sysdate, RELEASE_BY = '$cancel_by' WHERE ORDER_ID = '$order_id'");
        // $getData = $this->db->query("SELECT DT.ORDER_ID,DT.SALES_RECORD_NUMBER,DT.EXTENDEDORDERID FROM LZ_SALESLOAD_DET DT WHERE DT.ORDER_ID =  '$order_id' ")->result_array();
        // $sale_record_no = $getData[0]['SALES_RECORD_NUMBER'];
        // $extended_order_id = $getData[0]['EXTENDEDORDERID'];
        // $barcode_no = explode(',', $barcode_no);
        // print_r($barcode_no);
        // foreach($barcode_no as $bar){
        //     echo $bar;
        // }
        // exit();
        // return false;
        // $barcodes = $this->db->query("SELECT B.BARCODE_NO FROM LZ_BARCODE_MT B WHERE B.ORDER_ID = (SELECT DT.ORDER_ID FROM LZ_SALESLOAD_DET DT WHERE DT.ORDER_ID =  '$order_id') ")->result_array();
        
        // if($group_record_number){
        //     $order_ids = $this->m_searchOrder->get_order_ids_by_group_record($group_record_number);
        //     $bar_codes =  array();
        //     foreach ($order_ids as $key => $value) {
        //     // echo $value['ORDER_ID'];
        //     // $bar_codes1 = $this->m_searchOrder->get_bar_codes($value['ORDER_ID']);
        //     foreach ($bar_codes1 as $key => $value1) {
        //         $bar_codes1[$key]['ORDER_ID'] = $value['ORDER_ID'];
        //     }
        //     array_push($bar_codes ,$bar_codes1);
        //     }
        //     // echo '<pre>';
        //     //  print_r($bar_codes);
        //     // exit();
        // }
        
        // foreach($barcode_no as $barcode){
        //     $this->db->query("INSERT INTO LJ_CANCELLATION_DT CD (CD.CANCELLATION_DT_ID,
        //                                                 CD.BARCODE_NO,
        //                                                 CD.sale_order_id,
        //                                                 CD.extendedorderid,
        //                                                 CD.ORDER_ID)
        //                                                 values (
        //                                                     GET_SINGLE_PRIMARY_KEY('LJ_CANCELLATION_DT','CANCELLATION_DT_ID'),
        //                                                     '$barcode',
        //                                                     '$sale_record_no',
        //                                                     '$extended_order_id',
        //                                                     '$order_id') ");
        //     if($cancel_status == 'release'){
        //         $qyer = $this->db->query("UPDATE lz_barcode_mt b
        //             SET b.ebay_item_id    = '',
        //                 b.sale_record_no  = '',
        //                 b.list_id         = '',
        //                 b.pulling_id      = '',
        //                 b.bin_id          = '$bin_id',
        //                 b.order_id        = '',
        //                 b.packing_id      = '',
        //                 b.packing_by      = '',
        //                 b.packing_date    = '',
        //                 b.ebay_sticker    = 0,
        //                 b.audit_datetime  = '',
        //                 b.audit_by        = '',
        //                 b.shopify_list_id = ''
        //         WHERE b.barcode_no = '$barcode'");
        //     }else{
        //         $qyer = $this->db->query("UPDATE lz_barcode_mt b
        //         SET b.condition_id  = -1,
        //             DISCARD_DATE    = sysdate,
        //             DISCARD_BY      = '$cancel_by',
        //             DISCARD         = 1,
        //             DISCARD_REMARKS = '$remarks'
        //       WHERE b.barcode_no = '$barcode'");
        //     }                                            
        
        // }
        
        // $qyer = $this->db->query("Call pro_processCancel('$cancel_id','$order_id','$cancel_status','$cancel_by','$remarks','$bin_id')");
        if ($qyer) {
            return $cancel_status;
        } else {
            return false;
        }
    }
    public function printBarcode()
    {
        $order_id = $this->uri->segment(4);
        return $this->db->query("SELECT B.BARCODE_NO, TO_CHAR(DET.RELEASE_DATE, 'DD-MON-YYYY') RELEASE_DATE FROM LJ_CANCELLATION_DT B, LZ_SALESLOAD_DET DET WHERE B.ORDER_ID = DET.ORDER_ID AND B.ORDER_ID = '$order_id' ")->result_array();
    }
    public function checkDiscard($order_id)
    {
        $checkDiscard = $this->db->query("SELECT DISCARD FROM LZ_BARCODE_MT  WHERE ORDER_ID = '$order_id'")->row();
        if ($checkDiscard == '') {
            return true;
        } else {
            return false;
        }
        
    }
    public function checkRelease($order_id)
    {
        $checkRelease = $this->db->query("SELECT ORDER_ID FROM LZ_BARCODE_MT  WHERE ORDER_ID = '$order_id'")->row();
        if ($checkRelease == '') {
            return true;
        } else {
            return false;
        }
        
    }
    public function get_bar_codes($order_id)
    {
        $query = $this->db->query("SELECT B.BARCODE_NO,B.PULLING_ID,B.BIN_ID,BB.BIN_TYPE || '-' || BB.BIN_NO BIN_NAME,
            (SELECT COUNT(1) CNT
            FROM LZ_BARCODE_MT B
            WHERE B.ORDER_ID = '$order_id'
            GROUP BY B.BIN_ID) CNT
            FROM LZ_BARCODE_MT B, BIN_MT BB
            WHERE BB.BIN_ID = B.BIN_ID
                AND B.ORDER_ID = '$order_id'")->result_array();
        return $query;
    }
    public function get_cancelled_barcode()
    {
        $order_id = $this->input->post('order_id');
        $query    = $this->db->query("SELECT * FROM lj_cancellation_dt WHERE order_id = '$order_id'")->result_array();
        return $query;
    }
    public function get_cancelled_barcode_records()
    {
        $query = $this->db->query("SELECT DET.ITEM_TITLE,
        DET.SALE_RECORD_NO,
        DET.BUYER_ADDRESS1,
        DET.ORDER_ID,
        DET.EXTENDEDORDERID,
        DET.LZ_SALELOAD_ID,
        DET.LZ_SELLER_ACCT_ID,
        DET.USER_ID,
        DET.BUYER_FULLNAME,
        DET.QUANTITY,
        DET.SALE_PRICE,
        DET.TOTAL_PRICE,
        DET.SALE_DATE,
        DET.TRACKING_NUMBER,
        DET.BUYER_ZIP,
        DET.BARCODES,
        DET.SELL_ACCT_DESC
    FROM (SELECT DET.ITEM_TITLE,
                DET.SALES_RECORD_NUMBER SALE_RECORD_NO,
                DET.BUYER_ADDRESS1,
                DET.ORDER_ID,
                DET.EXTENDEDORDERID,
                MT.LZ_SALELOAD_ID,
                MT.LZ_SELLER_ACCT_ID,
                DET.USER_ID,
                DET.BUYER_FULLNAME,
                DET.QUANTITY,
                DET.SALE_PRICE,
                DET.TOTAL_PRICE,
                DET.SALE_DATE,
                DET.TRACKING_NUMBER,
                DET.BUYER_ZIP,
                TO_CHAR((SELECT REPLACE(REPLACE(XMLAGG(XMLELEMENT(A, CDT.BARCODE_NO) ORDER BY CDT.BARCODE_NO DESC NULLS LAST)
                                               .GETCLOBVAL(),
                                               '<A>',
                                               ''),
                                       '</A>',
                                       ', ') AS BARCODE_NO
                          FROM LJ_CANCELLATION_DT CDT
                         WHERE CDT.ORDER_ID = DET.ORDER_ID)) BARCODES,
                AA.SELL_ACCT_DESC
            FROM LZ_SALESLOAD_DET   DET,
                LZ_SALESLOAD_MT    MT,
                LJ_CANCELLATION_DT DT,
                LZ_SELLER_ACCTS    AA
            WHERE MT.LZ_SALELOAD_ID = DET.LZ_SALELOAD_ID
            AND DT.ORDER_ID = DET.ORDER_ID
            AND MT.LZ_SELLER_ACCT_ID = AA.LZ_SELLER_ACCT_ID) DET
            GROUP BY DET.ITEM_TITLE,
                DET.SALE_RECORD_NO,
                DET.BUYER_ADDRESS1,
                DET.ORDER_ID,
                DET.EXTENDEDORDERID,
                DET.LZ_SALELOAD_ID,
                DET.LZ_SELLER_ACCT_ID,
                DET.USER_ID,
                DET.BUYER_FULLNAME,
                DET.QUANTITY,
                DET.SALE_PRICE,
                DET.TOTAL_PRICE,
                DET.SALE_DATE,
                DET.TRACKING_NUMBER,
                DET.BUYER_ZIP,
                DET.BARCODES,
                DET.SELL_ACCT_DESC")->result_array();
            return $query;
    }
    public function get_order_ids_by_group_record($group_record_number)
    {
        $query = $this->db->query("SELECT ORDER_ID FROM LZ_SALESLOAD_DET WHERE SALES_RECORD_NO_GROUP = '$group_record_number'")->result_array();
        if ($query) {
            return $query;
        } else {
            return false;
        }
    }
    
}
?>    