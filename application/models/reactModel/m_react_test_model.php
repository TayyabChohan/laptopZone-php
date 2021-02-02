<?php
class M_react_test_model extends CI_Model
{


    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /********************************
     *  start Screen services 
     *********************************/
    public function getData()
    {
        $get_data = $this->db->query("SELECT CASE
WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND
DE.TRACKING_NUMBER IS NOT NULL THEN
'SOLD || SHIPPED'
WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND
DE.TRACKING_NUMBER IS NULL THEN
'SOLD || NOT SHIPPED'
ELSE
'AVAILABLE'
END SOLD_STAT,
LS.SEED_ID,
LS.LZ_MANIFEST_ID,
E.STATUS,
E.LISTER_ID,
E.LIST_ID,
TO_CHAR(E.LIST_DATE, 'MM-DD-YYYY HH24:MI:SS') AS LIST_DATE,
E.LZ_SELLER_ACCT_ID,
LS.EBAY_PRICE,
LM.LOADING_NO,
LM.LOADING_DATE,
LM.PURCH_REF_NO,
I.ITEM_ID,
I.ITEM_CODE LAPTOP_ITEM_CODE,
LS.ITEM_TITLE ITEM_MT_DESC,
BM.BIN_TYPE BI_TYP,
I.ITEM_MT_MANUFACTURE MANUFACTURER,
I.ITEM_MT_UPC UPC,
I.ITEM_MT_MFG_PART_NO MFG_PART_NO,
BCD.CONDITION_ID ITEM_CONDITION,
BCD.EBAY_ITEM_ID,
1 QUANTITY,
BCD.BARCODE_NO,
BCD.BIN_ID,
BM.BIN_TYPE || '-' || BM.BIN_NO BIN_NAME
FROM LZ_ITEM_SEED LS,
LZ_MANIFEST_MT LM,
ITEMS_MT I,
EBAY_LIST_MT E,
BIN_MT BM,
LZ_BARCODE_MT BCD,
LZ_SALESLOAD_DET DE
WHERE LS.ITEM_ID = I.ITEM_ID
AND E.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID
AND E.ITEM_ID = I.ITEM_ID
AND E.SEED_ID = LS.SEED_ID
AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID
AND LS.ITEM_ID = BCD.ITEM_ID
AND LS.DEFAULT_COND = BCD.CONDITION_ID
AND BCD.SALE_RECORD_NO = DE.SALES_RECORD_NUMBER(+)
AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID
AND E.EBAY_ITEM_ID = BCD.EBAY_ITEM_ID
and lm.manifest_type not in (3, 4)
AND BCD.EBAY_STICKER = 0
AND BCD.BIN_ID = BM.BIN_ID
ORDER BY LS.ITEM_ID DESC
FETCH FIRST 100 ROWS ONLY")->result_array();

        return $get_data;
        // return array("get_data"=>$get_data, "exist"=>true);
    }

    public function insertService($name, $created_by)
    {
        // $PACKING_NAME = $this->input->post('PACKING_NAME');
        $name = $this->input->post('name');
        $created_by = $this->input->post('created_by');
        $qr = "SELECT service_desc from lj_services where service_desc = '$name'";
        $result = $this->db->query($qr)->result_array();
        if ($result) {
            $data = array("status" => false, "response" => "Your Service Name Already Exist", "data" => $result);
        } else {
            $get_User = $this->db->query("INSERT INTO lj_services (service_id ,service_desc,created_date,created_by)
values (get_single_primary_key('lj_services','service_id'),'$name',sysdate,'$created_by')");

            $services = $this->db->query("SELECT l.service_id,l.service_desc, TO_CHAR(l.created_date, 'DD-MM-YYYY HH24:MI:SS') created_date, B.USER_NAME, l.CREATED_BY FROM LJ_SERVICES l,EMPLOYEE_MT B where l.SERVICE_DESC = '$name' and B.EMPLOYEE_ID = l.CREATED_BY order by service_id DESC ")->result_array();
            $service_desc = $services[0]['SERVICE_DESC'];
            $data = array("status" => true, "response" => $get_User, "services" => $services, "service_desc" => $service_desc);
        }
        return $data;
    }

    public function getService()
    {
        $get_user_from_database = $this->db->query("SELECT A.service_id, A.service_desc, TO_CHAR(A.created_date, 'DD-MM-YYYY HH24:MI:SS') created_date ,A.created_by , B.USER_NAME from lj_services A, EMPLOYEE_MT B WHERE B.EMPLOYEE_ID = A.CREATED_BY order by service_id DESC")->result_array();
        return $get_user_from_database;
    }

    public function deleteService()
    {
        $SERVICE_ID = $this->input->post('SERVICE_ID');
        $delData = $this->db->query("DELETE lj_services where SERVICE_ID='$SERVICE_ID'");
        return $delData;
    }
    /********************************
     *   end Screen services 
     *********************************/

    /********************************
     *   start Screen services rate
     *********************************/
    public function insertServiceRate()
    {
        // $name = $this->input->post('name');
        // $created_by = $this->input->post('userId'); lj_service_rate

       

        $selectServiceName = $this->input->post('selectServiceName');
        $service_type = $this->input->post('service_type');
        $service_Charges = $this->input->post('service_Charges');
        $created_by = $this->input->post('created_by');

        $Set_data = $this->db->query("INSERT INTO lj_service_rate A ( a.ser_rate_id,a.service_id, A.service_type, A.Charges, A.created_by, A.created_date)
values (get_single_primary_key('lj_service_rate','SER_RATE_ID'), '$selectServiceName', '$service_type','$service_Charges','$created_by',sysdate)");
        $tableData = $Set_data;
        $get_data = $this->db->query("SELECT ser_rate_id FROM lj_service_rate where ser_rate_id = (SELECT max(ser_rate_id) from lj_service_rate)")->result_array();
        //$data = $this->db->query($get_data)->;
        $tableData = $get_data[0]['SER_RATE_ID'];
        // print_r($tableData);
        // exit;
        // $tableData = $this->db->query(" SELECT A.ser_rate_id , A.service_id, A.service_type, A.Charges, A.created_by, TO_CHAR(A.created_date, 'DD-MM-YYYY HH24:MI:SS') created_date, c.service_desc, B.USER_NAME from lj_services c, lj_service_rate A , EMPLOYEE_MT B WHERE B.EMPLOYEE_ID = A.CREATED_BY and c.service_id=A.service_id and A.SER_RATE_ID = '$tableData'")->result_array();
        $tableData = $this->db->query(" SELECT A.ser_rate_id , A.service_id, A.service_type, '$' || A.Charges Charges, A.created_by, TO_CHAR(A.created_date, 'DD-MM-YYYY HH24:MI:SS') created_date, c.service_desc, B.USER_NAME from lj_services c, lj_service_rate A , EMPLOYEE_MT B WHERE B.EMPLOYEE_ID = A.CREATED_BY and c.service_id=A.service_id and A.SER_RATE_ID = '$tableData' order by ser_rate_id DESC ")->result_array();
        return array("status" => true, "tableData" => $tableData);
        // return array("status"=>true, "tableData" => $tableData);

    }
    public function getServiceRate()
    {
        $tableData = $this->db->query(" SELECT A.ser_rate_id , A.service_id, A.service_type, '$' || A.Charges Charges, A.created_by, TO_CHAR(A.created_date, 'DD-MM-YYYY HH24:MI:SS') created_date, c.service_desc, B.USER_NAME from lj_services c, lj_service_rate A , EMPLOYEE_MT B WHERE B.EMPLOYEE_ID = A.CREATED_BY and c.service_id=A.service_id order by ser_rate_id DESC ")->result_array();
        return array("status" => true, "tableData" => $tableData);
    }

    public function deleteServiceRate()
    {
        //$id=$this->input->post('service_id');
        $ser_rate_id = $this->input->post('ser_rate_id');
        $delData = $this->db->query("DELETE lj_service_rate where ser_rate_id='$ser_rate_id' ");
        return $delData;
    }

    public function upDateSerViceRate()
    {

        $ser_rate_id = $this->input->post('id');
        $service_Charges = $this->input->post('service_Charges');

        $Update_data = $this->db->query("UPDATE lj_service_rate set CHARGES='$service_Charges' where SER_RATE_ID='$ser_rate_id'");
        return $Update_data;
    }


    /********************************
     *   end Screen services rate
     *********************************/

    //data from lz_packing_type_mt

    /********************************
     *   start Screen packing and order packing
     *********************************/

    public function InsertPacking()
    {
        // var_dump($PACKING_BY);

        // exit;
        // $value = json_decode(file_get_contents('php://input'), true);
        // if(!empty($value)){
        // //var_dump($value);exit;
        // foreach( $Data as $value){
        $PACKING_NAME = $this->input->post('PACKING_NAME');
        // $value['PACKING_NAME'];
        $PACKING_TYPE = $this->input->post('PACKING_TYPE');
        // $value['PACKING_TYPE'];
        $PACKING_CODE = $this->input->post('PACKING_CODE');
        // $value['PACKING_CODE'];
        $PACKING_LENGTH = $this->input->post('PACKING_LENGTH');
        // $value['PACKING_LENGTH'];
        $PACKING_WIDTH = $this->input->post('PACKING_WIDTH');
        // $value['PACKING_WIDTH'];
        $PACKING_HEIGTH = $this->input->post('PACKING_HEIGTH');
        // $value['PACKING_HEIGTH'];
        $PACKING_WEIGTH = $this->input->post('PACKING_WEIGTH');
        // $value['PACKING_WEIGTH'];
        $PACKING_BY = $this->input->post('created_by');
        // $value['created_by'];
        $PACKING_COST = $this->input->post('PACKING_COST');
        // $value['PACKING_COST'];

        //}
        //var_dump($PACKING_LENGTH);exit;
        $PACKING_NAME = trim(str_replace(" ", ' ', $PACKING_NAME));
        $PACKING_NAME = trim(str_replace(array("'"), "''", $PACKING_NAME));

        $insertPackinData = $this->db->query("INSERT INTO lz_packing_type_mt (PACKING_ID,PACKING_NAME, PACKING_TYPE, PACKING_CODE, PACKING_LENGTH ,PACKING_WIDTH, PACKING_HEIGTH, PACKING_WEIGTH, PACKING_DATE, PACKING_BY, PACKING_COST)
values (get_single_primary_key('lz_packing_type_mt','PACKING_ID'),'$PACKING_NAME', '$PACKING_TYPE' ,'$PACKING_CODE', '$PACKING_LENGTH' , '$PACKING_WIDTH' , '$PACKING_HEIGTH', '$PACKING_WEIGTH',sysdate, '$PACKING_BY' , '$PACKING_COST')");
        $getPackingData = $insertPackinData;
        $get_data = $this->db->query("SELECT PACKING_ID FROM lz_packing_type_mt where PACKING_ID = (SELECT max(PACKING_ID) from lz_packing_type_mt)")->result_array();
        //$data = $this->db->query($get_data)->;
        $getPackingData = $get_data[0]['PACKING_ID'];
        // print_r($tableData);
        // var_dump($getPackingData); exit;
        $getPackingData = $this->db->query("SELECT p.packing_id,
p.packing_name||'|'||p.packing_type ||'|'||
p.packing_length||'x'||p.packing_width ||'x'||
p.packing_heigth packing_name
from lz_packing_type_mt p WHERE p.PACKING_ID ='$getPackingData'")->result_array();

        //$getPackingData = $this->db->query("SELECT PACKING_ID,PACKING_NAME, PACKING_TYPE, PACKING_CODE, PACKING_LENGTH ,PACKING_WIDTH, PACKING_HEIGTH, PACKING_WEIGTH, TO_CHAR(PACKING_DATE, 'DD-MM-YYYY HH24:MI:SS') PACKING_DATE, PACKING_BY, '$' || PACKING_COST PACKING_COST, B.USER_NAME FROM lz_packing_type_mt, EMPLOYEE_MT B WHERE B.EMPLOYEE_ID = PACKING_BY and PACKING_ID = '$getPackingData' ORDER BY PACKING_ID DESC")->result_array();
        return array("status" => true, 'getPackingData' => $getPackingData);
    }



    public function InsertPacking22()
    {
        // var_dump($PACKING_BY);

        // exit;
        // $value = json_decode(file_get_contents('php://input'), true);
        // if(!empty($value)){
        // //var_dump($value);exit;
        // foreach( $Data as $value){
        $PACKING_NAME = $this->input->post('PACKING_NAME');
        // $value['PACKING_NAME'];
        $PACKING_TYPE = $this->input->post('PACKING_TYPE');
        // $value['PACKING_TYPE'];
        $PACKING_CODE = $this->input->post('PACKING_CODE');
        // $value['PACKING_CODE'];
        $PACKING_LENGTH = $this->input->post('PACKING_LENGTH');
        // $value['PACKING_LENGTH'];
        $PACKING_WIDTH = $this->input->post('PACKING_WIDTH');
        // $value['PACKING_WIDTH'];
        $PACKING_HEIGTH = $this->input->post('PACKING_HEIGTH');
        // $value['PACKING_HEIGTH'];
        $PACKING_WEIGTH = $this->input->post('PACKING_WEIGTH');
        // $value['PACKING_WEIGTH'];
        $PACKING_BY = $this->input->post('created_by');
        // $value['created_by'];
        $PACKING_COST = $this->input->post('PACKING_COST');
        // $value['PACKING_COST'];

        //}
        //var_dump($PACKING_LENGTH);exit;
        $PACKING_NAME = trim(str_replace(" ", ' ', $PACKING_NAME));
        $PACKING_NAME = trim(str_replace(array("'"), "''", $PACKING_NAME));

        $insertPackinData = $this->db->query("INSERT INTO lz_packing_type_mt (PACKING_ID,PACKING_NAME, PACKING_TYPE, PACKING_CODE, PACKING_LENGTH ,PACKING_WIDTH, PACKING_HEIGTH, PACKING_WEIGTH, PACKING_DATE, PACKING_BY, PACKING_COST)
values (get_single_primary_key('lz_packing_type_mt','PACKING_ID'),'$PACKING_NAME', '$PACKING_TYPE' ,'$PACKING_CODE', '$PACKING_LENGTH' , '$PACKING_WIDTH' , '$PACKING_HEIGTH', '$PACKING_WEIGTH',sysdate, '$PACKING_BY' , '$PACKING_COST')");
        $getPackingData = $insertPackinData;
        $get_data = $this->db->query("SELECT PACKING_ID FROM lz_packing_type_mt where PACKING_ID = (SELECT max(PACKING_ID) from lz_packing_type_mt)")->result_array();
        //$data = $this->db->query($get_data)->;
        $getPackingData = $get_data[0]['PACKING_ID'];
        // print_r($tableData);
        // var_dump($getPackingData); exit;
        //         $getPackingData = $this->db->query("SELECT p.packing_id,
        // p.packing_name||'|'||p.packing_type ||'|'||
        // p.packing_length||'x'||p.packing_width ||'x'||
        // p.packing_heigth packing_name
        // from lz_packing_type_mt p WHERE p.PACKING_ID ='$getPackingData'")->result_array();

        $getPackingData = $this->db->query("SELECT PACKING_ID,PACKING_NAME, PACKING_TYPE, PACKING_CODE, PACKING_LENGTH ,PACKING_WIDTH, PACKING_HEIGTH, PACKING_WEIGTH, TO_CHAR(PACKING_DATE, 'DD-MM-YYYY HH24:MI:SS') PACKING_DATE, PACKING_BY, '$' || PACKING_COST PACKING_COST, B.USER_NAME FROM lz_packing_type_mt, EMPLOYEE_MT B WHERE B.EMPLOYEE_ID = PACKING_BY and PACKING_ID = '$getPackingData' ORDER BY PACKING_ID DESC")->result_array();
        return array("status" => true, 'getPackingData' => $getPackingData);
    }




    public function GetPacking()
    {
        $getPackingData = $this->db->query("SELECT PACKING_ID,PACKING_NAME, PACKING_TYPE, PACKING_CODE, PACKING_LENGTH ,PACKING_WIDTH, PACKING_HEIGTH, PACKING_WEIGTH, TO_CHAR(PACKING_DATE, 'DD-MM-YYYY HH24:MI:SS') PACKING_DATE, PACKING_BY, '$' || PACKING_COST PACKING_COST, B.USER_NAME FROM lz_packing_type_mt, EMPLOYEE_MT B WHERE B.EMPLOYEE_ID = PACKING_BY ORDER BY PACKING_ID DESC")->result_array();
        return array("status" => true, 'getPackingData' => $getPackingData);
    }

    public function DeletePacking()
    {
        $PACKING_ID = $this->input->post('PACKING_ID');
        $deletePack = $this->db->query("DELETE lz_packing_type_mt where PACKING_ID='$PACKING_ID'");
        return $deletePack;
    }

    public function UpdatePacking()
    {


        $PACKING_ID = $this->input->post('PACKING_ID');
        $PACKING_NAME = $this->input->post('PackingNameModel');
        $PACKING_TYPE = $this->input->post('radioModel');
        $PACKING_CODE = $this->input->post('PackingCodeNameModel');
        $PACKING_LENGTH = $this->input->post('LengthNameModel');
        $PACKING_WIDTH = $this->input->post('widthNameModel');
        $PACKING_HEIGTH = $this->input->post('HeightNameModel');
        $PACKING_WEIGTH = $this->input->post('PackingWeigthNameModel');
        $PACKING_COST = $this->input->post('PackingCostNameModel');

        $PACKING_NAME = trim(str_replace("  ", ' ', $PACKING_NAME));
        $PACKING_NAME = trim(str_replace(array("'"), "''", $PACKING_NAME));
        $updateData = $this->db->query(" UPDATE lz_packing_type_mt set PACKING_NAME='$PACKING_NAME', PACKING_TYPE='$PACKING_TYPE' , PACKING_CODE='$PACKING_CODE', PACKING_LENGTH='$PACKING_LENGTH' , PACKING_WIDTH='$PACKING_WIDTH' ,PACKING_HEIGTH='$PACKING_HEIGTH', PACKING_WEIGTH='$PACKING_WEIGTH' , PACKING_COST ='$PACKING_COST' where PACKING_ID='$PACKING_ID'");
        return $updateData;
    }

    public function PackingOrderDrop()
    {
        $getPackOrder = $this->db->query("SELECT p.packing_id,
-- p.packing_name||'|'||p.packing_type ||'|'||
p.packing_length||'x'||p.packing_width ||'x'||
p.packing_heigth ||'|'|| p.packing_name||'|'||p.packing_type  packing_name
from lz_packing_type_mt p")->result_array();
        return $getPackOrder;
    }

    public function MarchantDrop()
    {
        $getmarchantdrop = $this->db->query("SELECT MERCHANT_ID, BUISNESS_NAME from lz_merchant_mt")->result_array();
        return $getmarchantdrop;
    }


    public function GetPackingOrderDetail()
    {
        $MERCHANT_ID = $this->input->post('id');

        $getmarchantdrop = $this->db->query("SELECT max(d.sales_record_number) sales_record_number,
        d.order_id, max(i.item_id) ITEMS_ID,
        max(d.lz_salesload_det_id) lz_salesload_det_id,
        max(d.item_id) item_id,
        max(d.item_title) item_title,
        TO_CHAR(max(d.sale_date),'DD-MM-YYYY HH24:MI:SS') selling_date,
        max(d.quantity) quantity,
        '$' ||max(d.sale_price) sale_price,
        '$' || max(d.stamps_shipping_rate) postage,
        max(o.order_packing_id) order_packing_id,
        max(m.account_name) account_name,
        max(EM.USER_NAME) USER_NAME,
        max(d.shipping_service) shipping_service,
        max(i.item_length) ||'x'|| max(i.item_width) ||'x'||max(i.item_height) LWH,
        max(d.tracking_number) tracking_number
        from ebay_list_mt e,
        lz_salesload_det d,
        lj_merhcant_acc_dt m,
        lj_order_packing_mt o,
        lj_order_packing_dt dt,
        EMPLOYEE_MT EM,
        items_mt i
        where d.item_id = e.ebay_item_id
        and o.PACKING_BY = EM.EMPLOYEE_ID(+)
        and e.lz_seller_acct_id = m.acct_id
        and d.order_id = o.order_id(+)
        and o.order_packing_id = dt.order_packing_id(+)
        and e.item_id = i.item_id
        and d.orderstatus = 'Completed'
        and d.order_id is not null
        and m.merchant_id = '$MERCHANT_ID'
        group by d.order_id ORDER BY d.order_id DESC")->result_array();
        return $getmarchantdrop;
    }

    public function UpDatePostage()
    {
        $POSTAGE = $this->input->post('POSTAGE');
        // $value['PACKING_NAME'];
        $LZ_SALESLOAD_DET_ID = $this->input->post('LZ_SALESLOAD_DET_ID');

        $Data = $this->db->query("UPDATE lz_salesload_det set STAMPS_SHIPPING_RATE='$POSTAGE' where LZ_SALESLOAD_DET_ID='$LZ_SALESLOAD_DET_ID'");
        return $Data;
    }

    public function InsertPackingDetail()
    {
        $PACKING_ID = $this->input->post('PACKING_ID');
        //var_dump($PACKING_ID); exit;
        $PACKING_BY = $this->input->post('PACKING_BY');

        $ITEMS_ID = $this->input->post('ITEMS_ID');
        $QUANTITY = $this->input->post('QUANTITY');
        // var_dump($QUANTITY,$ITEMS_ID); exit;
        $ORDER_ID = $this->input->post('ORDER_ID');
        $MERCHANT_ID = $this->input->post('MERCHANT_ID');
        $PACKING_COST = $this->input->post('PACKING_COST');

        /*==========================================================
= check same item order exist or not =
==========================================================*/
        $getSameOrder = $this->db->query("SELECT
d.order_id,
max(d.item_id) item_id,
max(d.item_title) item_title,
max(o.order_packing_id) order_packing_id
from ebay_list_mt e,
lz_salesload_det d,
lj_merhcant_acc_dt m,
lj_order_packing_mt o,
lj_order_packing_dt dt,
items_mt i
where d.item_id = e.ebay_item_id
and e.lz_seller_acct_id = m.acct_id
and d.order_id = o.order_id(+)
and o.order_packing_id = dt.order_packing_id(+)
and e.item_id = i.item_id
and d.orderstatus = 'Completed'
and d.order_id is not null
and m.merchant_id = '$MERCHANT_ID'
and i.item_id = '$ITEMS_ID'
and d.quantity = '$QUANTITY'

group by d.order_id")->result_array();

        //if(count($getSameOrder) > 0){
        foreach ($getSameOrder as $value) {
            $order_id_id = $value['ORDER_ID'];
            $ebay_id = $value['ITEM_ID'];
            $item_title = $value['ITEM_TITLE'];
            $item_title = trim(str_replace(" ", ' ', $item_title));
            $item_title = trim(str_replace(array("'"), "''", $item_title));
            $order_packing_id = $value['ORDER_PACKING_ID'];
            //var_dump($order_id_id, $ebay_id,$item_title, $order_packing_id); exit;

            /*======================================
= update packing =
======================================*/

            if (empty($order_packing_id)) {
                $get_pk = $this->db->query("SELECT get_single_primary_key('lj_order_packing_mt','ORDER_PACKING_ID') PK from duAL")->result_array();
                $mt_pk = $get_pk[0]['PK'];
                $insertPackinData = $this->db->query("INSERT INTO lj_order_packing_mt (ORDER_PACKING_ID, ORDER_ID, MERCHANT_ID,SER_RATE_ID, PACKING_DATE, PACKING_BY,EBAY_ID, ITEM_TITLE) values ('$mt_pk', '$order_id_id', '$MERCHANT_ID' , '5',sysdate, '$PACKING_BY','$ebay_id','$item_title')");
            } else {
                $mt_pk = $order_packing_id;
            }

            foreach ($PACKING_ID as $value) {
                $pack_id = $value['value'];
                $insertPackinDetData = $this->db->query("INSERT INTO lj_order_packing_dt (ORDER_PACKING_DT_ID, ORDER_PACKING_ID, PACKING_ID, PACKING_COST) values (get_single_primary_key('lj_order_packing_dt','ORDER_PACKING_DT_ID') ,'$mt_pk', '$pack_id', (SELECT p.packing_cost from lz_packing_type_mt p where p.packing_id ='$pack_id'))");
            }

            /*===== End of update packing ======*/
        } // end main foreach
        //}
        $total = count($PACKING_ID);
        $result = $this->db->query("select *
        from (SELECT d.*, p.packing_name || '|' || p.packing_type || '|' ||
                     p.packing_length || 'x' || p.packing_width || 'x' ||
                     p.packing_heigth packing_name
                from lj_order_packing_dt d, lz_packing_type_mt p
               where d.packing_id = p.packing_id

               order by d.order_packing_dt_id desc)
       where rownum <= $total")->result_array();

        $get_data = $this->db->query("SELECT ORDER_PACKING_DT_ID FROM lj_order_packing_dt where ORDER_PACKING_DT_ID = (SELECT max(ORDER_PACKING_DT_ID) from lj_order_packing_dt)")->result_array();
        //$data = $this->db->query($get_data)->;
        $getPackingData = $get_data[0]['ORDER_PACKING_DT_ID'];
        $data = $this->db->query("SELECT d.*, p.packing_id,
p.packing_name||'|'|| p.packing_type ||'|'||
p.packing_length||'x'||p.packing_width||'x'||
p.packing_heigth packing_name from lj_order_packing_dt d, lz_packing_type_mt p where d.packing_id = p.packing_id AND d.order_packing_dt_id ='$getPackingData'")->result_array();
        /*===== End of check same item order exist or not ======*/
        // var_dump($insertPackinDetData); exit;
        return array("status" => true, 'getPackingData' => $result, 'order_packing_id' => $data);
    }

    public function DetailInsertPackingName()
    {
        // $result = array();
        $PACKING_ID = $this->input->post('pakingId');
        $total = count($PACKING_ID);
        $ORDER_PACKING_ID = $this->input->post('ORDER_PACKING_ID');
        // var_dump($PACKING_ID[0]);
        for ($i = 0; $i < $total; $i++) {
            // var_dump($i);
            $PACKING_data = $PACKING_ID[$i]['value'];
            // var_dump($PACKING_data);
            $data = $this->db->query("INSERT INTO lj_order_packing_dt (ORDER_PACKING_DT_ID,PACKING_ID, ORDER_PACKING_ID)
        values (get_single_primary_key('lj_order_packing_dt','ORDER_PACKING_DT_ID'),'$PACKING_data','$ORDER_PACKING_ID')");
        }
        // exit;
        // $get_data = $this->db->query("SELECT ORDER_PACKING_DT_ID FROM lj_order_packing_dt where ORDER_PACKING_DT_ID = (SELECT max(ORDER_PACKING_DT_ID) from lj_order_packing_dt)")->result_array();

        $get_Data = $this->db->query("SELECT * FROM (SELECT ORDER_PACKING_DT_ID FROM lj_order_packing_dt
        ORDER BY ORDER_PACKING_DT_ID DESC ) WHERE ROWNUM <=$total ")->result_array();
        // var_dump($get_Data);
        // exit;
        // $getPackingData = $get_data[0]['ORDER_PACKING_DT_ID'];

        // for ($j = 0; $j < sizeof($get_Data); $j++) {
        //     $getPackingData = $get_Data[$j]['ORDER_PACKING_DT_ID'];
        // var_dump( $get_Data[$j]['ORDER_PACKING_DT_ID']);
        // AND d.order_packing_dt_id = '$getPackingData'
        $result = $this->db->query("select *
            from (SELECT d.*, p.packing_name || '|' || p.packing_type || '|' ||
                         p.packing_length || 'x' || p.packing_width || 'x' ||
                         p.packing_heigth packing_name
                    from lj_order_packing_dt d, lz_packing_type_mt p
                   where d.packing_id = p.packing_id

                   order by d.order_packing_dt_id desc)
           where rownum <= $total")->result_array();
        // }
        // var_dump($result);
        // var_dump($result['data']);
        // $getPackingData = $get_data[0]['ORDER_PACKING_DT_ID'];
        // $data = $this->db->query("SELECT d.*, p.packing_id,
        // p.packing_name||'|'|| p.packing_type ||'|'||
        // p.packing_length||'x'||p.packing_width||'x'||
        // p.packing_heigth packing_name from lj_order_packing_dt d, lz_packing_type_mt p where d.packing_id = p.packing_id AND d.order_packing_dt_id ='$getPackingData'")->result_array();

        // exit;
        return $result;
    }

    public function UpDateDemension()
    {
        $LWH = $this->input->post('LWH');
        $ITEM_ID = $this->input->post('item_id');
        // $ENTERED_BY = $this->input->post('user_id');
        $LWH = (explode("x", $LWH));
        $total = count($LWH);
        $qr = "UPDATE items_mt SET ITEM_LENGTH = '$LWH[0]', ITEM_WIDTH = '$LWH[1]', ITEM_HEIGHT = '$LWH[2]' WHERE ITEM_ID = '$ITEM_ID'";
        $update = $this->db->query($qr);

        if ($update == true) {
            return array("status" => true, "message" => "Reacord Update");
        } else {
            return array("status" => false, "message" => "Not Update");
        }
    }
    public function DeleteListItem()
    {
        $ORDER_PACKING_DT_ID = $this->input->post('id');

        // var_dump($ORDER_PACKING_DT_ID);

        $deletelist = $this->db->query("SELECT d.order_packing_dt_id
from lj_order_packing_dt d
where d.order_packing_id in
     (select d.order_packing_id
        from lj_order_packing_dt d
       where d.order_packing_dt_id = '$ORDER_PACKING_DT_ID')")->result_array();
        //  var_dump($deletelist->num_rows());
        if (count($deletelist) > 1) {
            $deletelist = $this->db->query("DELETE lj_order_packing_dt where ORDER_PACKING_DT_ID='$ORDER_PACKING_DT_ID'");
            return array("status" => true, "remove" => false, 'deletelist' => $deletelist);
            //var_dump("det delete");
            // exit;
        } else {
            $get_mt_id = $this->db->query("select d.order_packing_id from lj_order_packing_dt d where d.order_packing_dt_id = '$ORDER_PACKING_DT_ID'")->result_array();
            $order_packing_id = @$get_mt_id[0]['ORDER_PACKING_ID'];
            $deletelist = $this->db->query("DELETE from lj_order_packing_dt where ORDER_PACKING_DT_ID='$ORDER_PACKING_DT_ID'");
            $deletelist = $this->db->query("DELETE from lj_order_packing_mt m where m.order_packing_id ='$order_packing_id'");
            // var_dump("master + det delete");
            //exit;
            return array("status" => true, "remove" => true, 'deletelist' => $deletelist);
        }

        // return $deletelist;
    }

    public function ListViewPackingName()
    {
        $ORDER_PACKING_ID = $this->input->post('id');

        $data = $this->db->query("SELECT d.*, p.packing_id,
            p.packing_name||'|'||p.packing_type||'|'||
            p.packing_length||'x'||p.packing_width||'x'||
            p.packing_heigth packing_name from lj_order_packing_dt d, lz_packing_type_mt p where d.packing_id = p.packing_id AND d.order_packing_id ='$ORDER_PACKING_ID'")->result_array();

        return $data;
    }

    /********************************
     *   end Screen packing and order packing
     *********************************/

    /********************************
     *   start Screen Tempdata
     *********************************/
    public function GetTempdata()
    {
        $get_data = $this->db->query("SELECT * from LZ_ITEM_TEMPLATE");
        //  var_dump( $get_data->result_array()); exit;
        return $get_data->result_array();
    }

    public function InsetTemplatedata()
    { // for template form
        $TEMPLATE_NAME = $this->input->post('TEMPLATE_NAME');
        $TEMPLATE_NAME = trim(str_replace("  ", ' ', $TEMPLATE_NAME));
        $EBAY_LOCAL = $this->input->post('EBAY_LOCAL');
        $SHIP_FROM_LOC = $this->input->post('SHIP_FROM_LOC');
        $CURRENCY = $this->input->post('CURRENCY');
        $LIST_TYPE = $this->input->post('LIST_TYPE');
        $SHIP_FROM_ZIP_CODE = $this->input->post('SHIP_FROM_ZIP_CODE');
        $PAYMENT_METHOD = $this->input->post('PAYMENT_METHOD');
        $PAYPAL_EMAIL = $this->input->post('PAYPAL_EMAIL');
        $DISPATCH_TIME_MAX = $this->input->post('DISPATCH_TIME_MAX');
        $SHIPPING_SERVICE = $this->input->post('SHIPPING_SERVICE');
        $SHIPPING_COST = $this->input->post('SHIPPING_COST');
        $ADDITIONAL_COST = $this->input->post('ADDITIONAL_COST');
        $RETURN_OPTION = $this->input->post('RETURN_OPTION');
        $RETURN_DAYS = $this->input->post('RETURN_DAYS');
        $SHIPPING_PAID_BY = $this->input->post('SHIPPING_PAID_BY');
        $ENTERED_BY = $this->input->post('ENTERED_BY');

        $ACCOUNT_ID = $this->input->post('ACCOUNT_ID');
        $MERCHANT_ID = $this->input->post('MERCHANT_ID');

        $temp_data = $this->db->query("INSERT INTO LZ_ITEM_TEMPLATE (TEMPLATE_ID, TEMPLATE_NAME, EBAY_LOCAL, CURRENCY, LIST_TYPE, SHIP_FROM_ZIP_CODE, PAYMENT_METHOD, SHIP_FROM_LOC,  PAYPAL_EMAIL, DISPATCH_TIME_MAX, SHIPPING_SERVICE, SHIPPING_COST, ADDITIONAL_COST, RETURN_OPTION, RETURN_DAYS, SHIPPING_PAID_BY, ENTERED_BY, MERCHANT_ID,ACCOUNT_ID)
      values (get_single_primary_key('LZ_ITEM_TEMPLATE','TEMPLATE_ID'),'$TEMPLATE_NAME', '$EBAY_LOCAL','$CURRENCY', '$LIST_TYPE','$SHIP_FROM_ZIP_CODE','$SHIP_FROM_LOC', '$PAYMENT_METHOD', '$PAYPAL_EMAIL', '$DISPATCH_TIME_MAX', '$SHIPPING_SERVICE', '$SHIPPING_COST', '$ADDITIONAL_COST', '$RETURN_OPTION', '$RETURN_DAYS', '$SHIPPING_PAID_BY', '$MERCHANT_ID','$ACCOUNT_ID', '$ENTERED_BY')");
        $tableData = $temp_data;
        $get_data = $this->db->query("SELECT TEMPLATE_ID FROM LZ_ITEM_TEMPLATE where TEMPLATE_ID = (SELECT max(TEMPLATE_ID) from LZ_ITEM_TEMPLATE)")->result_array();
        //$data = $this->db->query($get_data)->;
        $tableData = $get_data[0]['TEMPLATE_ID'];
        // print_r($tableData);

        $tableData = $this->db->query("SELECT TEMPLATE_ID,TEMPLATE_NAME, EBAY_LOCAL, CURRENCY, LIST_TYPE, SHIP_FROM_ZIP_CODE, PAYMENT_METHOD, SHIP_FROM_LOC,  PAYPAL_EMAIL, DISPATCH_TIME_MAX, SHIPPING_SERVICE, SHIPPING_COST, ADDITIONAL_COST, RETURN_OPTION, RETURN_DAYS, SHIPPING_PAID_BY, ENTERED_BY, MERCHANT_ID,ACCOUNT_ID from LZ_ITEM_TEMPLATE where TEMPLATE_ID = '$tableData' ORDER BY TEMPLATE_ID DESC ")->result_array();
        return array("status" => true, 'tableData' => $tableData);
    }

    public function DeleteTamplateData()
    { // for template form
        $TEMPLATE_ID = $this->input->post('id');
        $deleteTemp = $this->db->query("DELETE LZ_ITEM_TEMPLATE where TEMPLATE_ID='$TEMPLATE_ID'");
        return $deleteTemp;
    }

    public function ShipingServiceDrowp()
    { // for template form
        $shipData = $this->db->query("SELECT * from lz_shiping_name");
        return $shipData->result_array();
    }

    public function UpDateTamplateData()
    { // for template form

        $TEMPLATE_ID = $this->input->post('TEMPLATE_ID');
        $TemplateNameupdate = $this->input->post('TemplateNameupdate');
        $TemplateNameupdate = trim(str_replace("  ", ' ', $TemplateNameupdate));
        $EBAY_LOCAL = $this->input->post('SiteIDupdate');
        $SHIP_FROM_LOC = $this->input->post('ShipFromCountryupdate');
        $CURRENCY = $this->input->post('Currencyupdate');
        $LIST_TYPE = $this->input->post('selectListingTypeupdate');
        $SHIP_FROM_ZIP_CODE = $this->input->post('ZipCodeupdate');
        $PAYMENT_METHOD = $this->input->post('PaymentMethodupdate');
        $PAYPAL_EMAIL = $this->input->post('PaypalEmailAddressupdate');
        $DISPATCH_TIME_MAX = $this->input->post('DispatchTimeMaxupdate');
        $SHIPPING_SERVICE = $this->input->post('selectshippingserviceupdate');
        $SHIPPING_COST = $this->input->post('ShppingServiceCostupdate');
        $ADDITIONAL_COST = $this->input->post('ShppingServiceAdditionalCostupdate');
        $RETURN_OPTION = $this->input->post('selectreturnOptionupdate');
        $RETURN_DAYS = $this->input->post('ReturnsWithinOptionupdate');
        $SHIPPING_PAID_BY = $this->input->post('selectshingPaidupdate');

        $Data = $this->db->query("UPDATE LZ_ITEM_TEMPLATE set   TEMPLATE_NAME='$TemplateNameupdate' ,  EBAY_LOCAL='$EBAY_LOCAL' ,SHIP_FROM_LOC='$SHIP_FROM_LOC', CURRENCY='$CURRENCY',
LIST_TYPE='$LIST_TYPE', SHIP_FROM_ZIP_CODE='$SHIP_FROM_ZIP_CODE',PAYMENT_METHOD='$PAYMENT_METHOD',PAYPAL_EMAIL='$PAYPAL_EMAIL',DISPATCH_TIME_MAX='$DISPATCH_TIME_MAX',
SHIPPING_SERVICE='$SHIPPING_SERVICE',SHIPPING_COST='$SHIPPING_COST',ADDITIONAL_COST='$ADDITIONAL_COST',RETURN_OPTION='$RETURN_OPTION',
RETURN_DAYS='$RETURN_DAYS',SHIPPING_PAID_BY='$SHIPPING_PAID_BY'
 where TEMPLATE_ID='$TEMPLATE_ID'");
        return $Data;
    }

    /********************************
     *   end Screen Tempdata
     *********************************/

    /********************************
     *   start Screen TotalBarcode
     *********************************/
    public function TotalBarcode()
    {
        $merChant_ID = $this->input->post('id');
        $tBarcode = $this->db->query("SELECT D.BARCODE_NO,
        L.BARCODE_PRV_NO,
        L.PIC_DATE_TIME,
        L.LZ_MANIFEST_DET_ID,
        B.EBAY_ITEM_ID,
        B.SALE_RECORD_NO,
        B.ITEM_ID,
        I.ITEM_DESC,
        I.ITEM_MT_MANUFACTURE,
        I.ITEM_MT_MFG_PART_NO,
        I.ITEM_MT_UPC,
        I.ITEM_CONDITION,
        C.COND_NAME CONDITION_ID
   FROM LZ_MERCHANT_BARCODE_MT M,
        LZ_ITEM_COND_MT        C,
        LZ_MERCHANT_BARCODE_DT D,
        LZ_SPECIAL_LOTS        L,
        LZ_BARCODE_MT          B,
        ITEMS_MT               I
  WHERE M.MT_ID = D.MT_ID
    AND B.CONDITION_ID = C.ID
    AND D.BARCODE_NO = L.BARCODE_PRV_NO(+)
    AND L.BARCODE_PRV_NO = B.BARCODE_NO(+)
    AND B.ITEM_ID = I.ITEM_ID(+)
    AND B.EBAY_ITEM_ID IS NULL
    and l.lz_manifest_det_id is not null
    AND M.MERCHANT_ID = $merChant_ID
  order by BARCODE_NO desc");
        return $tBarcode->result_array();
    }
    /********************************
     *   end Screen TotalBarcode
     *********************************/

    /********************************
     *  Start Screen PictureDone
     *********************************/
    public function PictureDone()
    {
        $merChant_ID = $this->input->post('id');
        $tpicture = $this->db->query("SELECT B.EBAY_ITEM_ID,
        s.seed_id seed_id,
        '$'|| s.ebay_price pric,
        B.EBAY_ITEM_ID QTY,
        S.ITEM_TITLE ITEM_DESC,
        S.F_MANUFACTURE ITEM_MT_MANUFACTURE,
        S.F_MPN ITEM_MT_MFG_PART_NO,
        S.F_UPC ITEM_MT_UPC,
        COND_NAME CONDITION_ID,
        CA.CATEGORY_NAME NAME
        FROM LZ_MERCHANT_BARCODE_MT M,
        LZ_ITEM_COND_MT C,
        LZ_MERCHANT_BARCODE_DT D,
        LZ_SPECIAL_LOTS L,
        LZ_BARCODE_MT B,
        LZ_ITEM_SEED S,
        LZ_BD_CATEGORY CA
        WHERE M.MT_ID = D.MT_ID
        AND B.CONDITION_ID = C.ID(+)
        AND D.BARCODE_NO = L.BARCODE_PRV_NO(+)
        AND L.BARCODE_PRV_NO = B.BARCODE_NO(+)
        AND B.ITEM_ID = S.ITEM_ID(+)
        AND B.LZ_MANIFEST_ID = S.LZ_MANIFEST_ID(+)
        AND S.CATEGORY_ID = CA.CATEGORY_ID(+)
        AND B.CONDITION_ID = S.DEFAULT_COND(+)
        AND B.EBAY_ITEM_ID IS NOT NULL
        AND B.SALE_RECORD_NO IS NULL
        AND M.MERCHANT_ID = $merChant_ID
        --GROUP BY B.EBAY_ITEM_ID");
        return $tpicture->result_array();
    }
    /********************************
     *  end Screen PictureDone
     *********************************/

    /********************************
     *   start Screen barcodeProces
     *********************************/

    public function GetBarcodeProcess()
    {
        $merChant_ID = $this->input->post('id');
        $tBarcode = $this->db->query("SELECT B.EBAY_ITEM_ID,
        s.seed_id seed_id,
        '$'|| s.ebay_price pric,
        B.EBAY_ITEM_ID QTY,
        S.ITEM_TITLE ITEM_DESC,
        S.F_MANUFACTURE ITEM_MT_MANUFACTURE,
        S.F_MPN ITEM_MT_MFG_PART_NO,
        S.F_UPC ITEM_MT_UPC,
        COND_NAME CONDITION_ID,
        CA.CATEGORY_NAME NAME
        FROM LZ_MERCHANT_BARCODE_MT M,
        LZ_ITEM_COND_MT C,
        LZ_MERCHANT_BARCODE_DT D,
        LZ_SPECIAL_LOTS L,
        LZ_BARCODE_MT B,
        LZ_ITEM_SEED S,
        LZ_BD_CATEGORY CA
        WHERE M.MT_ID = D.MT_ID
        AND B.CONDITION_ID = C.ID(+)
        AND D.BARCODE_NO = L.BARCODE_PRV_NO(+)
        AND L.BARCODE_PRV_NO = B.BARCODE_NO(+)
        AND B.ITEM_ID = S.ITEM_ID(+)
        AND B.LZ_MANIFEST_ID = S.LZ_MANIFEST_ID(+)
        AND S.CATEGORY_ID = CA.CATEGORY_ID(+)
        AND B.CONDITION_ID = S.DEFAULT_COND(+)
        AND B.EBAY_ITEM_ID IS NOT NULL
        AND B.SALE_RECORD_NO IS NULL
        AND M.MERCHANT_ID = $merChant_ID
       -- GROUP BY B.EBAY_ITEM_ID");
        return $tBarcode->result_array();
    }
    /********************************
     *  end Screen barcodeProces
     *********************************/


    /********************************
     *  start Screen SoldeItem
     *********************************/
    public function GetSoldItem()
    {
        $merChant_ID = $this->input->post('id');
        $sold = $this->db->query("SELECT B.EBAY_ITEM_ID,
    max(s.seed_id) seed_id,
    '$'|| max(s.ebay_price) pric,
    COUNT(B.EBAY_ITEM_ID) QTY,
    MAX(S.ITEM_TITLE) ITEM_DESC,
    MAX(S.F_MANUFACTURE) ITEM_MT_MANUFACTURE,
    MAX(S.F_MPN) ITEM_MT_MFG_PART_NO,
    MAX(S.F_UPC) ITEM_MT_UPC, /*MAX(I.ITEM_DESC) ITEM_DESC, MAX(I.ITEM_MT_MANUFACTURE) ITEM_MT_MANUFACTURE, MAX(I.ITEM_MT_MFG_PART_NO) ITEM_MT_MFG_PART_NO, MAX(I.ITEM_MT_UPC) ITEM_MT_UPC,*/
    MAX(COND_NAME) CONDITION_ID,
    MAX(CA.CATEGORY_NAME) NAME
FROM LZ_MERCHANT_BARCODE_MT M,
    LZ_ITEM_COND_MT        C,
    LZ_MERCHANT_BARCODE_DT D,
    LZ_SPECIAL_LOTS        L,
    LZ_BARCODE_MT          B, /*ITEMS_MT I,*/
    LZ_ITEM_SEED           S,
    LZ_BD_CATEGORY         CA
WHERE M.MT_ID = D.MT_ID
AND B.CONDITION_ID = C.ID
AND D.BARCODE_NO = L.BARCODE_PRV_NO(+)
AND L.BARCODE_PRV_NO = B.BARCODE_NO(+)
AND B.ITEM_ID = S.ITEM_ID
AND B.LZ_MANIFEST_ID = S.LZ_MANIFEST_ID
AND S.CATEGORY_ID = CA.CATEGORY_ID(+)
AND B.CONDITION_ID = S.DEFAULT_COND /*AND B.ITEM_ID = I.ITEM_ID(+)*/
AND B.EBAY_ITEM_ID IS NOT NULL
AND B.SALE_RECORD_NO IS not NULL
AND M.MERCHANT_ID = $merChant_ID
GROUP BY B.EBAY_ITEM_ID");
        return $sold->result_array();
    }
    /********************************
     *  end Screen SoldeItem
     *********************************/



    /********************************
     *  Screen ActiveNotList
     *********************************/
    public function GetActiveNotListed()
    {
        $merChant_ID = $this->input->post('id');
        $tBarcode = $this->db->query("SELECT D.BARCODE_NO,
               L.BARCODE_PRV_NO,
               L.PIC_DATE_TIME,
               L.LZ_MANIFEST_DET_ID,
               B.EBAY_ITEM_ID,
               B.SALE_RECORD_NO,
               B.ITEM_ID,
               I.ITEM_DESC,
               I.ITEM_MT_MANUFACTURE,
               I.ITEM_MT_MFG_PART_NO,
               I.ITEM_MT_UPC,
               I.ITEM_CONDITION,
               C.COND_NAME CONDITION_ID
          FROM LZ_MERCHANT_BARCODE_MT M,
               LZ_ITEM_COND_MT        C,
               LZ_MERCHANT_BARCODE_DT D,
               LZ_SPECIAL_LOTS        L,
               LZ_BARCODE_MT          B,
               ITEMS_MT               I
         WHERE M.MT_ID = D.MT_ID
           AND B.CONDITION_ID = C.ID
           AND D.BARCODE_NO = L.BARCODE_PRV_NO(+)
           AND L.BARCODE_PRV_NO = B.BARCODE_NO(+)
           AND B.ITEM_ID = I.ITEM_ID(+)
           AND B.EBAY_ITEM_ID IS NULL
           and l.lz_manifest_det_id is not null
           AND M.MERCHANT_ID = $merChant_ID
         order by BARCODE_NO desc");
        return $tBarcode->result_array();
    }

    /********************************
     *  Screen ActiveNotList
     *********************************/

    /********************************
     *  Screen UserList
     *********************************/
    public function Get_Users_List()
    {
        $user_Data = $this->db->query("SELECT E.*, d.Merchant_Id, m.buisness_name from emp_merchant_det d, EMPLOYEE_MT E, lz_merchant_mt m WHERE d.Employee_Id = E.EMPLOYEE_ID AND m.merchant_id = d.merchant_id");
        return  $user_Data->result_array();
    }

    // public function Delete_Users_List()
    // {
    //     $EMPLOYEE_ID = $this->input->post('id');
    //     $user_Data = $this->db->query("DELETE EMPLOYEE_MT where EMPLOYEE_ID='$EMPLOYEE_ID'");
    //     return  $user_Data;
    // }

    public function disable_And_Anable_Users_List()
    {
        $EMPLOYEE_ID = $this->input->post('id');
        $status = $this->input->post('status');


        if (!empty($EMPLOYEE_ID)) {
            $query = $this->db->query("UPDATE EMPLOYEE_MT SET STATUS ='$status' WHERE EMPLOYEE_ID ='$EMPLOYEE_ID'");
            if ($query) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function Update_Users_List()

    {
        $EMPLOYEE_ID = $this->input->post('EMPLOYEE_ID');
        $FIRST_NAME = $this->input->post('FirstName_update');
        $FIRST_NAME = trim(str_replace("  ", ' ', $FIRST_NAME));
        $FIRST_NAME = trim(str_replace(array("'"), "''", $FIRST_NAME));
        $LAST_NAME = $this->input->post('LastName_update');
        $LAST_NAME = trim(str_replace("  ", ' ', $LAST_NAME));
        $LAST_NAME = trim(str_replace(array("'"), "''", $LAST_NAME));
        $USER_NAME = $this->input->post('UserName_update');
        $USER_NAME = trim(str_replace("  ", ' ', $USER_NAME));
        $USER_NAME = trim(str_replace(array("'"), "''", $USER_NAME));
        $PASS_WORD = $this->input->post('Password_update');
        $E_MAIL_ADDRESS = $this->input->post('UserEmail_Update');
        $LOCATION = $this->input->post('selectLocation_update');
        // var_dump( $EMPLOYEE_ID); exit;
        // $merchant = $this->input->post('selectMerchant');

        $query = $this->db->query("UPDATE EMPLOYEE_MT SET FIRST_NAME='$FIRST_NAME', LAST_NAME='$LAST_NAME', USER_NAME='$USER_NAME', PASS_WORD='$PASS_WORD', E_MAIL_ADDRESS='$E_MAIL_ADDRESS', LOCATION='$LOCATION' WHERE EMPLOYEE_ID ='$EMPLOYEE_ID'");
        if ($query) {
            $merchant = $this->input->post('selectMerchant_update');
            if ($merchant > 0) {
                $check = $this->db->query("SELECT EMP_DET_ID FROM EMP_MERCHANT_DET WHERE EMPLOYEE_ID = '$EMPLOYEE_ID' and MERCHANT_ID = '$merchant'");
                if ($check->num_rows() == 0) {

                    $this->db->query("INSERT INTO EMP_MERCHANT_DET (EMP_DET_ID,EMPLOYEE_ID,MERCHANT_ID) VALUES (GET_SINGLE_PRIMARY_KEY('EMP_MERCHANT_DET','EMP_DET_ID'),'$EMPLOYEE_ID','$merchant')");
                }
            }

            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function Insert_Users_List()
    {
        // $EMPLOYEE_ID = $this->input->post('EMPLOYEE_ID');
        $FIRST_NAME = $this->input->post('FirstName');
        $FIRST_NAME = trim(str_replace("  ", ' ', $FIRST_NAME));
        $FIRST_NAME = trim(str_replace(array("'"), "''", $FIRST_NAME));
        $LAST_NAME = $this->input->post('LastName');
        $LAST_NAME = trim(str_replace("  ", ' ', $LAST_NAME));
        $LAST_NAME = trim(str_replace(array("'"), "''", $LAST_NAME));
        $USER_NAME = $this->input->post('UserName');
        $USER_NAME = trim(str_replace("  ", ' ', $USER_NAME));
        $USER_NAME = trim(str_replace(array("'"), "''", $USER_NAME));
        $PASS_WORD = $this->input->post('Password');
        $E_MAIL_ADDRESS = $this->input->post('UserEmail');
        $LOCATION = $this->input->post('selectLocation');
        // var_dump($FIRST_NAME); exit;

        $usename = $this->db->query("SELECT USER_NAME from EMPLOYEE_MT where USER_NAME ='$USER_NAME'");
        if ($usename->num_rows() > 0) {
            $data = array("status" => false, "message" => "User Name Already Exist");
            return  $data;
        } else {
            $user_Data = $this->db->query("INSERT INTO EMPLOYEE_MT(EMPLOYEE_ID, FIRST_NAME, LAST_NAME, JOIN_DATE, BIRTH_DATE, HOME_ADDRESS, RES_PHONE_NO, CELL_PHONE_NO, MARITAL_STATUS, ID_CARD_NUMBER, GENDER, REMARKS, TITLE, APPL_USER_YN, USER_NAME, PASS_WORD, E_MAIL_ADDRESS, EMP_STATUS, DEPT_ID, DESIG_ID, EMP_CODE, PASSWORD_DATE, EBAY_ITEM_ID, LOCATION, SHOW_UN_ASSIGNED, AUTH_PASSWORD) VALUES((get_single_primary_key('EMPLOYEE_MT','EMPLOYEE_ID')),'$FIRST_NAME','$LAST_NAME','01-JAN-90',NULL,NULL,NULL,NULL,'2',NULL,'M',NULL,'TITLE','2','$USER_NAME','$PASS_WORD','$E_MAIL_ADDRESS','OKY',NULL,NULL,NULL,NULL,NULL,'$LOCATION',NULL,NULL)");

            if ($user_Data) {
                $merchant = $this->input->post('selectMerchant');

                $get_data = $this->db->query("SELECT EMPLOYEE_ID FROM EMPLOYEE_MT where EMPLOYEE_ID = (SELECT max(EMPLOYEE_ID) from EMPLOYEE_MT)")->result_array();
                //$data = $this->db->query($get_data)->;
                $getUserData = $get_data[0]['EMPLOYEE_ID'];
                // var_dump($getUserData); exit;
                $data = $this->db->query("SELECT EMPLOYEE_ID, FIRST_NAME, LAST_NAME,USER_NAME,PASS_WORD,E_MAIL_ADDRESS,LOCATION FROM EMPLOYEE_MT where EMPLOYEE_ID=' $getUserData'")->result_array();
                //$data = array("status" => true, "response" => $getUserData);

                if ($merchant > 0) {
                    $checkdata = $this->db->query("SELECT EMP_DET_ID FROM EMP_MERCHANT_DET WHERE EMPLOYEE_ID = '$getUserData' and MERCHANT_ID = '$merchant'");


                    if ($checkdata->num_rows() == 0) {

                        $this->db->query("INSERT INTO EMP_MERCHANT_DET (EMP_DET_ID,EMPLOYEE_ID,MERCHANT_ID) VALUES (GET_SINGLE_PRIMARY_KEY('EMP_MERCHANT_DET','EMP_DET_ID'),'$getUserData','$merchant')");
                    }
                }
                return array("status" => true, 'tableData' => $data);
            } else {
                return false;
            }
        }
    }
    /********************************
     *  Screen UserList
     *********************************/

    /********************************
     *  Screen itemReturned
     *********************************/

    public function GetitemReturned()
    {
        $merChant_ID = $this->input->post('id');
        $itemReturned = $this->db->query("SELECT D.BARCODE_NO,
               L.BARCODE_PRV_NO,
               L.PIC_DATE_TIME,
               L.LZ_MANIFEST_DET_ID,
               B.EBAY_ITEM_ID,
               B.SALE_RECORD_NO,
               B.ITEM_ID,
               I.ITEM_DESC,
               I.ITEM_MT_MANUFACTURE,
               I.ITEM_MT_MFG_PART_NO,
               I.ITEM_MT_UPC,
               I.ITEM_CONDITION,
               C.COND_NAME CONDITION_ID
          FROM LZ_MERCHANT_BARCODE_MT M,
               LZ_ITEM_COND_MT        C,
               LZ_MERCHANT_BARCODE_DT D,
               LZ_SPECIAL_LOTS        L,
               LZ_BARCODE_MT          B,
               ITEMS_MT               I
         WHERE M.MT_ID = D.MT_ID
           AND B.CONDITION_ID = C.ID
           AND D.BARCODE_NO = L.BARCODE_PRV_NO(+)
           AND L.BARCODE_PRV_NO = B.BARCODE_NO(+)
           AND B.ITEM_ID = I.ITEM_ID(+)
           AND B.EBAY_ITEM_ID IS NULL
           and l.lz_manifest_det_id is not null
           AND M.MERCHANT_ID = $merChant_ID
         order by BARCODE_NO desc");
        return $itemReturned->result_array();
    }
    /********************************
     *  Screen itemReturned
     *********************************/

    /********************************
     *  Screen AddMerchant
     *********************************/

    public function Get_merchant_detail()
    { // for template form
        $shipData = $this->db->query("SELECT M.MERCHANT_ID,
        M.CONTACT_PERSON,
        M.MERCHANT_CODE,
        M.BUISNESS_NAME,
        s.service_desc SERVICE_TYPE,
        C.CITY_DESC,
        ST.STATE_DESC,
        M.CONTACT_NO,
        M.ADDRESS,
        M.ACTIVE_FROM,
        M.ACTIVE_TO,
        M.ACTIVE_STATUS,
        C.CITY_ID,
        s.service_id
   FROM LZ_MERCHANT_MT M, WIZ_CITY_MT C, WIZ_STATE_MT ST , lj_services s
  WHERE M.STATE_ID = C.CITY_ID(+)
    AND C.STATE_ID = ST.STATE_ID(+)
    and m.service_type = s.service_id
  ORDER BY M.MERCHANT_ID asc");
        return $shipData->result_array();
    }

    public function Delete_merchant_detail()
    {
        $MERCHANT_ID = $this->input->post('id');

        $query = $this->db->query("DELETE LZ_MERCHANT_MT where MERCHANT_ID ='$MERCHANT_ID'");

        //$query=$this->db->query("DELETE lj_merchant_service where MERCHANT_SER_ID='$MERCHANT_ID'"); 
        return $query;
    }
    public function Get_merchant_Services_Type()
    { // for template form
        $stat_query = $this->db->query("SELECT SERVICE_ID, SERVICE_DESC FROM lj_services");
        return $stat_query->result_array();
    }

    public function Update_merchant_detail()
    {


        $MERCHANT_ID = $this->input->post('MERCHANT_ID');
        $murch_name = $this->input->post('MerchantNameUpdate');
        $buis_name = $this->input->post('BuisnessNameUpdate');
        $merch_add = $this->input->post('MerchantAddressUpdate');
        $merch_phon = $this->input->post('MerchantPhoneUpdate');
        $merch_act_from = $this->input->post('dateFromUpdate');
        $merch_act_to = $this->input->post('datetoUpdate');
        $merch_servic = $this->input->post('SelectServiceTypeUpdate');
        $stat_id = $this->input->post('SelectCityUpdate');
        $fromdate = new DateTime($merch_act_from);
        $startDate = date_format($fromdate, 'y-m-d');
        $todate = new DateTime($merch_act_to);
        $endDate = date_format($todate, 'y-m-d');
        $query = $this->db->query("UPDATE LZ_MERCHANT_MT M SET M.BUISNESS_NAME = '$buis_name', M.CONTACT_NO = '$merch_phon',M.CONTACT_PERSON ='$murch_name', M.ADDRESS ='$merch_add',M.STATE_ID ='$stat_id', M.SERVICE_TYPE = '$merch_servic',M.ACTIVE_FROM = TO_DATE('$startDate','yyyy-mm-dd HH24:MI:SS') ,M.ACTIVE_TO = TO_DATE('$endDate', 'yyyy-mm-dd HH24:MI:SS')  WHERE M.MERCHANT_ID = '$MERCHANT_ID' ");
        $query = $this->db->query("UPDATE lj_merchant_service SET SERVICE_ID ='$merch_servic' WHERE MERCHANT_ID ='$MERCHANT_ID'");
        if ($query) {
            return true;
        } else {

            return false;
        }
    }

    public function Insert_merchant_detail()
    {

        $murch_name = $this->input->post('MerchantName');
        $murch_name = trim(str_replace("  ", ' ', $murch_name));
        $murch_name = trim(str_replace(array("'"), "''", $murch_name));
        $buis_name = $this->input->post('BuisnessName');
        $buis_name = trim(str_replace("  ", ' ', $buis_name));
        $buis_name = trim(str_replace(array("'"), "''", $buis_name));
        $merch_add = $this->input->post('MerchantAddress');
        $merch_add = trim(str_replace("  ", ' ', $merch_add));
        $merch_add = trim(str_replace(array("'"), "''", $merch_add));
        $merch_phon = $this->input->post('MerchantPhone');
        $merch_act_from = $this->input->post('dateFrom');
        $merch_act_to = $this->input->post('dateto');
        $merch_servic = $this->input->post('SelectServiceType');
        $stat_id = $this->input->post('SelectCity');
        $created_by = $this->input->post('created_by');

        $fromdate = new DateTime($merch_act_from);
        $startDate = date_format($fromdate, 'y-m-d');
        $todate = new DateTime($merch_act_to);
        $endDate = date_format($todate, 'y-m-d');

        //var_dump( $murch_name,  $buis_name, $merch_add, $merch_phon,$startDate,  $endDate, $merch_servic, $stat_id);
        $merch_code = $this->db->query("SELECT lpad(NVL(MAX(Merchant_code + 1), 1),5,0) MERCH_CODE FROM LZ_MERCHANT_MT ")->result_array();
        $gmerch_code = $merch_code[0]['MERCH_CODE'];
        foreach ($merch_servic as $value) {
            $service_id = $value['value'];

            $get_data = $this->db->query("INSERT INTO LZ_MERCHANT_MT (MERCHANT_ID, MERCHANT_CODE, BUISNESS_NAME, CONTACT_NO, CONTACT_PERSON, ADDRESS, STATE_ID, SERVICE_TYPE, ACTIVE_FROM, ACTIVE_TO) VALUES (get_single_primary_key('LZ_MERCHANT_MT','MERCHANT_ID'), '$gmerch_code', '$buis_name', '$merch_phon', '$murch_name', '$merch_add', '$stat_id', '$service_id',TO_DATE('$startDate','yyyy-mm-dd HH24:MI:SS') ,TO_DATE('$endDate','yyyy-mm-dd HH24:MI:SS'))");
        }

        $get_merchant_id = $this->db->query("SELECT MERCHANT_ID FROM LZ_MERCHANT_MT where MERCHANT_ID = (SELECT max(MERCHANT_ID) from LZ_MERCHANT_MT)")->result_array();

        $getUserData = $get_merchant_id[0]['MERCHANT_ID'];

        $get_data  = $this->db->query("INSERT INTO lj_merchant_service (MERCHANT_SER_ID, MERCHANT_ID,SERVICE_ID, CREATED_BY,DATED) values(get_single_primary_key('lj_merchant_service','MERCHANT_SER_ID'),'$getUserData','$service_id','$created_by', sysdate)");

        $get_data = $this->db->query("SELECT m.MERCHANT_ID,
         m.MERCHANT_CODE,
         m.BUISNESS_NAME,
         m.CONTACT_NO,
         m.CONTACT_PERSON,
         m.ADDRESS,
         c.city_desc,
         st.state_desc,
         m.ACTIVE_FROM,
         m.ACTIVE_TO,
         s.SERVICE_DESC SERVICE_TYPE
         FROM LZ_MERCHANT_MT m, lj_services s , wiz_city_mt c , wiz_state_mt st
         WHERE MERCHANT_ID = '$getUserData'
         and SERVICE_ID = '$service_id'
         and m.state_id = c.city_id(+)
         and c.state_id = st.state_id(+)")->result_array();

        return array("status" => true, 'tableData' => $get_data);
    }

    public function Get_merchant_City()
    { // for template form
        $stat_query = $this->db->query("SELECT  C.CITY_ID,CITY_DESC FROM WIZ_CITY_MT C WHERE C.STATE_ID > 1004 order by CITY_DESC ");
        return $stat_query->result_array();
    }
    /********************************
     *  Screen AddMerchant
     *********************************/

    /********************************
     *  Screen MyProfile
     *********************************/

    public function Get_MyProfile()
    {
        $merchant_id = $this->input->post('merchant_id');
        // if ($merchant_id) {
        $directory = $this->db->query("SELECT c.MASTER_PATH from lz_pict_path_config c  where c.path_id = 6")->result_array();
        //var_dump($directory[0]["MASTER_PATH"] . $merchant_id);

        //get master path and save in directory 
        $pic_path = $directory[0]["MASTER_PATH"] . $merchant_id . '/';
        $qry = $this->db->query("SELECT
                        '$pic_path'|| LOGO img
                FROM lz_merchant_dt d, WIZ_CITY_MT c
                WHERE MERCHANT_ID = '$merchant_id'
                and d.city = c.city_id")->result_array();
        $pic_path = $qry[0]['IMG'];


        $img = @file_get_contents($pic_path);
        $img = base64_encode($img);
        //return array('image'=>$img);

        $qry = $this->db->query("SELECT
             F_NAME,
            L_NAME,
            ADDRESS1,
            ADDRESS2,
            CITY,
            ZIP_CODE,
            CONTACT_NO,
            PAYPAL_EMAIL,
            DISPLAY_NAME,
            LOGO,
            MERCH_DT_ID,
            MERCHANT_ID,
            c.city_desc,
            c.CITY_ID
       FROM lz_merchant_dt d, WIZ_CITY_MT c
      WHERE MERCHANT_ID = '$merchant_id'
      and d.city = c.city_id");
        if ($img) {

            return array('data' => $qry->result_array(), 'image' => $img);
        } else {
            return array('data' => $qry->result_array(), 'image' => '');
        }
    }
    public function Update_MyProfile()
    {

        $FirstName = $this->input->post('FirstName');
        $FirstName = trim(str_replace("  ", ' ', $FirstName));
        $FirstName = trim(str_replace(array("'"), "''", $FirstName));
        $image = $this->input->post('image');
        $LastName = $this->input->post('LastName');
        $LastName = trim(str_replace("  ", ' ', $LastName));
        $LastName = trim(str_replace(array("'"), "''", $LastName));
        $PaypalEmail = $this->input->post('PaypalEmail');
        $PaypalEmail = trim(str_replace("  ", ' ', $PaypalEmail));
        $PaypalEmail = trim(str_replace(array("'"), "''", $PaypalEmail));
        $ContactNo = $this->input->post('ContactNo');
        $ContactNo = trim(str_replace("  ", ' ', $ContactNo));
        $ContactNo = trim(str_replace(array("'"), "''", $ContactNo));
        $ZipCode = $this->input->post('ZipCode');
        $ZipCode = trim(str_replace("  ", ' ', $ZipCode));
        $ZipCode = trim(str_replace(array("'"), "''", $ZipCode));
        $Address1 = $this->input->post('Address1');
        $Address1 = trim(str_replace("  ", ' ', $Address1));
        $Address1 = trim(str_replace(array("'"), "''", $Address1));
        $Address2 = $this->input->post('Address2');
        $Address2 = trim(str_replace("  ", ' ', $Address2));
        $Address2 = trim(str_replace(array("'"), "''", $Address2));
        $DisplayName = $this->input->post('DisplayName');
        $DisplayName = trim(str_replace("  ", ' ', $DisplayName));
        $DisplayName = trim(str_replace(array("'"), "''", $DisplayName));
        $SelectCity = $this->input->post('SelectCity');
        $merchant_id = $this->input->post('merchant_id');
        $image = "";
        // var_dump(($_FILES['image']['name']));exit;

        $query = $this->db->query("SELECT c.MASTER_PATH from lz_pict_path_config c where c.path_id = 6");
        $specific_qry = $query->result_array();
        $specific_path = $specific_qry[0]['MASTER_PATH'];
        $main_dir =  $specific_path . $merchant_id; //. $_FILES['image']['name'];


        array_map('unlink', glob("$main_dir/*.*"));

        if (!empty($_FILES['image']['name'])) {

            $query = $this->db->query("SELECT c.MASTER_PATH from lz_pict_path_config c where c.path_id = 6");
            $specific_qry = $query->result_array();
            $specific_path = $specific_qry[0]['MASTER_PATH'];

            $main_dir =  $specific_path . $merchant_id;
            if (is_dir($main_dir) === false) {
                mkdir($main_dir);
            }
            $config['charset']       = 'charset=utf-8';
            $config['upload_path']   = $main_dir;
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['file_name']     = $_FILES['image']['name'];

            //Load upload library and initialize configuration
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            $uploadData = $this->upload->data();
            // var_dump($uploadData);exit;
            if ($this->upload->do_upload('image')) {
                $uploadData = $this->upload->data();
                $image = $uploadData['file_name'];
            } else {
                $image = "";
            }
        }

        $query = $this->db->query("UPDATE lz_merchant_dt SET F_NAME='$FirstName', L_NAME='$LastName', ADDRESS1='$Address1', ADDRESS2='$Address2', CITY='$SelectCity', ZIP_CODE='$ZipCode',CONTACT_NO='$ContactNo', PAYPAL_EMAIL='$PaypalEmail', DISPLAY_NAME='$DisplayName', LOGO='$image', INSERT_DATE= sysdate WHERE MERCHANT_ID ='$merchant_id'");
        if ($query) {
            return true;
        } else {

            return false;
        }
    }

    public function Insert_MyProfile()
    { // for MyProfile
        // var_dump($_FILES["image"]["tmp_name"]);//exit;
        $FirstName = $this->input->post('FirstName');
        $FirstName = trim(str_replace("  ", ' ', $FirstName));
        $FirstName = trim(str_replace(array("'"), "''", $FirstName));
        $image = $this->input->post('image');
        $LastName = $this->input->post('LastName');
        $LastName = trim(str_replace("  ", ' ', $LastName));
        $LastName = trim(str_replace(array("'"), "''", $LastName));
        $PaypalEmail = $this->input->post('PaypalEmail');
        $PaypalEmail = trim(str_replace("  ", ' ', $PaypalEmail));
        $PaypalEmail = trim(str_replace(array("'"), "''", $PaypalEmail));
        $ContactNo = $this->input->post('ContactNo');
        $ContactNo = trim(str_replace("  ", ' ', $ContactNo));
        $ContactNo = trim(str_replace(array("'"), "''", $ContactNo));
        $ZipCode = $this->input->post('ZipCode');
        $ZipCode = trim(str_replace("  ", ' ', $ZipCode));
        $ZipCode = trim(str_replace(array("'"), "''", $ZipCode));
        $Address1 = $this->input->post('Address1');
        $Address1 = trim(str_replace("  ", ' ', $Address1));
        $Address1 = trim(str_replace(array("'"), "''", $Address1));
        $Address2 = $this->input->post('Address2');
        $Address2 = trim(str_replace("  ", ' ', $Address2));
        $Address2 = trim(str_replace(array("'"), "''", $Address2));
        $DisplayName = $this->input->post('DisplayName');
        $DisplayName = trim(str_replace("  ", ' ', $DisplayName));
        $DisplayName = trim(str_replace(array("'"), "''", $DisplayName));
        $SelectCity = $this->input->post('SelectCity');
        $created_by = $this->input->post('created_by');
        $merchant_id = $this->input->post('merchant_id');

        // $mrQuery = "SELECT F_NAME from lz_merchant_dt  where MERCHANT_ID = '$merchant_id'";

        // $result = $this->db->query($mrQuery)->result_array();
        // if ($result) {

        //     $stat_query = array("status" => false, "response" => "Fisrt name Already Exist", "data" => $result);
        // } else {
        $query = $this->db->query("SELECT c.MASTER_PATH from lz_pict_path_config c where c.path_id = 6");
        $specific_qry = $query->result_array();
        $specific_path = $specific_qry[0]['MASTER_PATH'];
        $main_dir =  $specific_path . $merchant_id; //. $_FILES['image']['name'];


        array_map('unlink', glob("$main_dir/*.*"));
        //rmdir($main_dir);

        // if (file_exists($main_dir)) {

        //     unlink($main_dir);
        //      echo "File Successfully Delete."; 
        // } else {

        //var_dump($main_dir); exit;

        $image = "";
        // var_dump(($_FILES['image']['name']));exit;
        if (!empty($_FILES['image']['name'])) {

            $query = $this->db->query("SELECT c.MASTER_PATH from lz_pict_path_config c where c.path_id = 6");
            $specific_qry = $query->result_array();
            $specific_path = $specific_qry[0]['MASTER_PATH'];

            $main_dir =  $specific_path . $merchant_id;
            if (is_dir($main_dir) === false) {
                mkdir($main_dir);
            }

            $config['charset']       = 'charset=utf-8';
            $config['upload_path']   = $main_dir;
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['file_name']     = $_FILES['image']['name'];

            //Load upload library and initialize configuration
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            $uploadData = $this->upload->data();
            // var_dump($uploadData);exit;
            if ($this->upload->do_upload('image')) {
                $uploadData = $this->upload->data();
                $image = $uploadData['file_name'];
            } else {
                $image = "";
            }
        }
        $stat_query = $this->db->query("INSERT INTO  lz_merchant_dt(MERCH_DT_ID,  MERCHANT_ID, F_NAME, L_NAME, ADDRESS1, ADDRESS2, CITY, ZIP_CODE,CONTACT_NO, PAYPAL_EMAIL, DISPLAY_NAME, LOGO, INSERT_DATE, INSERTED_BY) values (get_single_primary_key('lz_merchant_dt','MERCH_DT_ID'),'$merchant_id','$FirstName','$LastName','$Address1','$Address2','$SelectCity','$ZipCode','$ContactNo','$PaypalEmail','$DisplayName','$image',sysdate,'$created_by')");
        //var_dump( $stat_query );exit;
        return $stat_query;
        //  }
        //}
    }

    public function check_merchant_id($merchant_id)
    {
        $mrQuery = "SELECT MERCHANT_ID from lz_merchant_dt  where MERCHANT_ID = '$merchant_id'";

        $result = $this->db->query($mrQuery)->result_array();

        return  $result;
    }
    /********************************
     *  Screen MyProfile
     *********************************/


    /********************************
     *  Screen US-PK Non Listed Items
     *********************************/
    public function Get_employee() // employee dropDown
    {

        $qyer = $this->db->query("SELECT M.EMPLOYEE_ID,M.USER_NAME FROM EMPLOYEE_MT M WHERE M.LOCATION = 'PK' AND M.STATUS =1 ")->result_array();

        return $qyer;
    }


    public function Get_nonListedItems()
    {

        $employeeName = $this->input->post('emp');
        $radioselect = $this->input->post('radioselect');

        $qyer = "SELECT * from ( SELECT Q.*, C.BUISNESS_NAME
            FROM LZ_MERCHANT_BARCODE_MT M,
                 LZ_MERCHANT_BARCODE_DT D,
                 LZ_MERCHANT_MT C,
                 (SELECT *
                    FROM (SELECT LS.SEED_ID,
                                 (SELECT M.USER_NAME
                                    FROM EMPLOYEE_MT M
                                   WHERE M.EMPLOYEE_ID = DET.IDENTIFIED_BY) VERIFY_BY,
                                 DECODE(((SELECT *
                                            FROM (SELECT M.USER_NAME
                                                    FROM LZ_LISTING_ALLOC L,
                                                         EMPLOYEE_MT      M
                                                   WHERE L.SEED_ID =
                                                         LS.SEED_ID
                                                     AND L.LISTER_ID =
                                                         M.EMPLOYEE_ID
                                                   ORDER BY L.ALLOC_ID DESC)
                                           WHERE ROWNUM <= 1)),
                                        NULL,
                                        'NOT ASSIGNED',
                                        ((SELECT *
                                            FROM (SELECT M.USER_NAME
                                                    FROM LZ_LISTING_ALLOC L,
                                                         EMPLOYEE_MT      M
                                                   WHERE L.SEED_ID =
                                                         LS.SEED_ID
                                                     AND L.LISTER_ID =
                                                         M.EMPLOYEE_ID
                                                   ORDER BY L.ALLOC_ID DESC)
                                           WHERE ROWNUM <= 1))) ASSIGN_TO,
                                 BB.BARCODE_NO,
                                 DET.BARCODE_PRV_NO,
                                 LS.ENTERED_BY,
                                 E.USER_NAME,
                                 LS.SHIPPING_SERVICE,
                                 LS.OTHER_NOTES,
                                 LS.LZ_MANIFEST_ID,
                                 LM.LOADING_DATE,
                                 LM.PURCH_REF_NO,
                                 LS.ITEM_TITLE ITEM_MT_DESC,
                                 I.ITEM_MT_MANUFACTURE MANUFACTURER,
                                 I.ITEM_ID,
                                 I.ITEM_CODE,
                                 I.ITEM_MT_MFG_PART_NO MFG_PART_NO,
                                 I.ITEM_MT_UPC UPC,
                                 BB.BIN_ID,
                                 BM.BIN_TYPE || '-' || BM.BIN_NO BIN_NAME,
                                 O.OBJECT_NAME OBJECT_DESCRIP,
                                 C.COND_NAME ITEM_CONDITION,
                                 '1' QUANTITY,
                                 DET.BARCODE_PRV_NO FOLDER_NAME
                            FROM LZ_BARCODE_MT    BB,
                                 LZ_DEKIT_US_DT   DET,
                                 LZ_MANIFEST_DET  MDET,
                                 ITEMS_MT         I,
                                 LZ_ITEM_SEED     LS,
                                 LZ_MANIFEST_MT   LM,
                                 BIN_MT           BM,
                                 LZ_ITEM_COND_MT  C,
                                 LZ_BD_OBJECTS_MT O,
                                 EMPLOYEE_MT      E
                           WHERE BB.BARCODE_NO = DET.BARCODE_PRV_NO
                             AND DET.LZ_MANIFEST_DET_ID =
                                 MDET.LAPTOP_ZONE_ID
                             AND LM.LZ_MANIFEST_ID = MDET.LZ_MANIFEST_ID
                             AND LS.DEFAULT_COND = BB.CONDITION_ID
                             AND LS.ITEM_ID = BB.ITEM_ID
                             AND LS.LZ_MANIFEST_ID = BB.LZ_MANIFEST_ID
                             AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID
                             AND C.ID = DET.CONDITION_ID
                             AND BB.ITEM_ID = I.ITEM_ID
                             AND O.OBJECT_ID = DET.OBJECT_ID
                             AND LS.ENTERED_BY = E.EMPLOYEE_ID(+)
                             AND BB.EBAY_ITEM_ID IS NULL
                             AND BB.BIN_ID = BM.BIN_ID
                             AND BB.DISCARD = 0)
                  UNION ALL
                  SELECT *
                    FROM (SELECT LS.SEED_ID,
                                 (SELECT M.USER_NAME
                                    FROM EMPLOYEE_MT M
                                   WHERE M.EMPLOYEE_ID = L.UPDATED_BY) VERIFY_BY,
                                 DECODE(((SELECT *
                                            FROM (SELECT M.USER_NAME
                                                    FROM LZ_LISTING_ALLOC L,
                                                         EMPLOYEE_MT      M
                                                   WHERE L.SEED_ID =
                                                         LS.SEED_ID
                                                     AND L.LISTER_ID =
                                                         M.EMPLOYEE_ID
                                                   ORDER BY L.ALLOC_ID DESC)
                                           WHERE ROWNUM <= 1)),
                                        NULL,
                                        'NOT ASSIGNED',
                                        ((SELECT *
                                            FROM (SELECT M.USER_NAME
                                                    FROM LZ_LISTING_ALLOC L,
                                                         EMPLOYEE_MT      M
                                                   WHERE L.SEED_ID =
                                                         LS.SEED_ID
                                                     AND L.LISTER_ID =
                                                         M.EMPLOYEE_ID
                                                   ORDER BY L.ALLOC_ID DESC)
                                           WHERE ROWNUM <= 1))) ASSIGN_TO,
                                 BB.BARCODE_NO,
                                 L.BARCODE_PRV_NO,
                                 LS.ENTERED_BY,
                                 E.USER_NAME,
                                 LS.SHIPPING_SERVICE,
                                 LS.OTHER_NOTES,
                                 LS.LZ_MANIFEST_ID,
                                 LM.LOADING_DATE,
                                 LM.PURCH_REF_NO,
                                 LS.ITEM_TITLE ITEM_MT_DESC,
                                 I.ITEM_MT_MANUFACTURE MANUFACTURER,
                                 I.ITEM_ID,
                                 I.ITEM_CODE,
                                 I.ITEM_MT_MFG_PART_NO MFG_PART_NO,
                                 I.ITEM_MT_UPC UPC,
                                 BB.BIN_ID,
                                 BM.BIN_TYPE || '-' || BM.BIN_NO BIN_NAME,
                                 O.OBJECT_NAME OBJECT_DESCRIP,
                                 C.COND_NAME ITEM_CONDITION,
                                 '1' QUANTITY,
                                 L.FOLDER_NAME
                            FROM LZ_BARCODE_MT    BB,
                                 LZ_SPECIAL_LOTS  L,
                                 LZ_MANIFEST_DET  MDET,
                                 ITEMS_MT         I,
                                 LZ_ITEM_SEED     LS,
                                 LZ_MANIFEST_MT   LM,
                                 BIN_MT           BM,
                                 LZ_ITEM_COND_MT  C,
                                 LZ_BD_OBJECTS_MT O,
                                 EMPLOYEE_MT      E
                           WHERE BB.BARCODE_NO = L.BARCODE_PRV_NO
                             AND L.LZ_MANIFEST_DET_ID =
                                 MDET.LAPTOP_ZONE_ID
                             AND LM.LZ_MANIFEST_ID = MDET.LZ_MANIFEST_ID
                             AND LS.DEFAULT_COND = BB.CONDITION_ID
                             AND LS.ITEM_ID = BB.ITEM_ID
                             AND LS.LZ_MANIFEST_ID = BB.LZ_MANIFEST_ID
                             AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID
                             AND BB.ITEM_ID = I.ITEM_ID
                             AND C.ID = L.CONDITION_ID
                             AND O.OBJECT_ID = L.OBJECT_ID
                             AND LS.ENTERED_BY = E.EMPLOYEE_ID(+)
                             AND BB.EBAY_ITEM_ID IS NULL
                             AND BB.BIN_ID = BM.BIN_ID
                             AND BB.DISCARD = 0)) Q
           WHERE M.MT_ID = D.MT_ID
             AND C.MERCHANT_ID = M.MERCHANT_ID
             AND D.BARCODE_NO = Q.BARCODE_PRV_NO)";

        $qyer = $this->db->query($qyer)->result_array();

        if (count($qyer) >= 1) {

            $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array();
            $uri = $this->get_identiti_bar_pics($qyer, $conditions);
            $images = $uri['uri'];

            foreach ($qyer as $key => $value) {

                $qyer[$key]['MFG_PART_NO'] = str_replace('-', ' ', $value['MFG_PART_NO']);
            }
            return array("images" => $images, 'query' => $qyer);
        } else {
            return array('images' => [], 'query' => [], 'exist' => false);
        }
    }

    public function Get_SearchData() // get All nonlistedData at load timme
    {

        $employeeName = $this->input->post('emp');
        $radioselect = $this->input->post('radioselect');

        if ($radioselect == 'All') {
            $qyer = "SELECT * from ( SELECT Q.*, C.BUISNESS_NAME
            FROM LZ_MERCHANT_BARCODE_MT M,
                 LZ_MERCHANT_BARCODE_DT D,
                 LZ_MERCHANT_MT C,
                 (SELECT *
                    FROM (SELECT LS.SEED_ID,
                                 (SELECT M.USER_NAME
                                    FROM EMPLOYEE_MT M
                                   WHERE M.EMPLOYEE_ID = DET.IDENTIFIED_BY) VERIFY_BY,
                                 DECODE(((SELECT *
                                            FROM (SELECT M.USER_NAME
                                                    FROM LZ_LISTING_ALLOC L,
                                                         EMPLOYEE_MT      M
                                                   WHERE L.SEED_ID =
                                                         LS.SEED_ID
                                                     AND L.LISTER_ID =
                                                         M.EMPLOYEE_ID
                                                   ORDER BY L.ALLOC_ID DESC)
                                           WHERE ROWNUM <= 1)),
                                        NULL,
                                        'NOT ASSIGNED',
                                        ((SELECT *
                                            FROM (SELECT M.USER_NAME
                                                    FROM LZ_LISTING_ALLOC L,
                                                         EMPLOYEE_MT      M
                                                   WHERE L.SEED_ID =
                                                         LS.SEED_ID
                                                     AND L.LISTER_ID =
                                                         M.EMPLOYEE_ID
                                                   ORDER BY L.ALLOC_ID DESC)
                                           WHERE ROWNUM <= 1))) ASSIGN_TO,
                                 BB.BARCODE_NO,
                                 DET.BARCODE_PRV_NO,
                                 LS.ENTERED_BY,
                                 E.USER_NAME,
                                 LS.SHIPPING_SERVICE,
                                 LS.OTHER_NOTES,
                                 LS.LZ_MANIFEST_ID,
                                 LM.LOADING_DATE,
                                 LM.PURCH_REF_NO,
                                 LS.ITEM_TITLE ITEM_MT_DESC,
                                 I.ITEM_MT_MANUFACTURE MANUFACTURER,
                                 I.ITEM_ID,
                                 I.ITEM_CODE,
                                 I.ITEM_MT_MFG_PART_NO MFG_PART_NO,
                                 I.ITEM_MT_UPC UPC,
                                 BB.BIN_ID,
                                 BM.BIN_TYPE || '-' || BM.BIN_NO BIN_NAME,
                                 O.OBJECT_NAME OBJECT_DESCRIP,
                                 C.COND_NAME ITEM_CONDITION,
                                 '1' QUANTITY,
                                 DET.BARCODE_PRV_NO FOLDER_NAME
                            FROM LZ_BARCODE_MT    BB,
                                 LZ_DEKIT_US_DT   DET,
                                 LZ_MANIFEST_DET  MDET,
                                 ITEMS_MT         I,
                                 LZ_ITEM_SEED     LS,
                                 LZ_MANIFEST_MT   LM,
                                 BIN_MT           BM,
                                 LZ_ITEM_COND_MT  C,
                                 LZ_BD_OBJECTS_MT O,
                                 EMPLOYEE_MT      E
                           WHERE BB.BARCODE_NO = DET.BARCODE_PRV_NO
                             AND DET.LZ_MANIFEST_DET_ID =
                                 MDET.LAPTOP_ZONE_ID
                             AND LM.LZ_MANIFEST_ID = MDET.LZ_MANIFEST_ID
                             AND LS.DEFAULT_COND = BB.CONDITION_ID
                             AND LS.ITEM_ID = BB.ITEM_ID
                             AND LS.LZ_MANIFEST_ID = BB.LZ_MANIFEST_ID
                             AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID
                             AND C.ID = DET.CONDITION_ID
                             AND BB.ITEM_ID = I.ITEM_ID
                             AND O.OBJECT_ID = DET.OBJECT_ID
                             AND LS.ENTERED_BY = E.EMPLOYEE_ID(+)
                             AND BB.EBAY_ITEM_ID IS NULL
                             AND BB.BIN_ID = BM.BIN_ID
                             AND BB.DISCARD = 0)
                  UNION ALL
                  SELECT *
                    FROM (SELECT LS.SEED_ID,
                                 (SELECT M.USER_NAME
                                    FROM EMPLOYEE_MT M
                                   WHERE M.EMPLOYEE_ID = L.UPDATED_BY) VERIFY_BY,
                                 DECODE(((SELECT *
                                            FROM (SELECT M.USER_NAME
                                                    FROM LZ_LISTING_ALLOC L,
                                                         EMPLOYEE_MT      M
                                                   WHERE L.SEED_ID =
                                                         LS.SEED_ID
                                                     AND L.LISTER_ID =
                                                         M.EMPLOYEE_ID
                                                   ORDER BY L.ALLOC_ID DESC)
                                           WHERE ROWNUM <= 1)),
                                        NULL,
                                        'NOT ASSIGNED',
                                        ((SELECT *
                                            FROM (SELECT M.USER_NAME
                                                    FROM LZ_LISTING_ALLOC L,
                                                         EMPLOYEE_MT      M
                                                   WHERE L.SEED_ID =
                                                         LS.SEED_ID
                                                     AND L.LISTER_ID =
                                                         M.EMPLOYEE_ID
                                                   ORDER BY L.ALLOC_ID DESC)
                                           WHERE ROWNUM <= 1))) ASSIGN_TO,
                                 BB.BARCODE_NO,
                                 L.BARCODE_PRV_NO,
                                 LS.ENTERED_BY,
                                 E.USER_NAME,
                                 LS.SHIPPING_SERVICE,
                                 LS.OTHER_NOTES,
                                 LS.LZ_MANIFEST_ID,
                                 LM.LOADING_DATE,
                                 LM.PURCH_REF_NO,
                                 LS.ITEM_TITLE ITEM_MT_DESC,
                                 I.ITEM_MT_MANUFACTURE MANUFACTURER,
                                 I.ITEM_ID,
                                 I.ITEM_CODE,
                                 I.ITEM_MT_MFG_PART_NO MFG_PART_NO,
                                 I.ITEM_MT_UPC UPC,
                                 BB.BIN_ID,
                                 BM.BIN_TYPE || '-' || BM.BIN_NO BIN_NAME,
                                 O.OBJECT_NAME OBJECT_DESCRIP,
                                 C.COND_NAME ITEM_CONDITION,
                                 '1' QUANTITY,
                                 L.FOLDER_NAME
                            FROM LZ_BARCODE_MT    BB,
                                 LZ_SPECIAL_LOTS  L,
                                 LZ_MANIFEST_DET  MDET,
                                 ITEMS_MT         I,
                                 LZ_ITEM_SEED     LS,
                                 LZ_MANIFEST_MT   LM,
                                 BIN_MT           BM,
                                 LZ_ITEM_COND_MT  C,
                                 LZ_BD_OBJECTS_MT O,
                                 EMPLOYEE_MT      E
                           WHERE BB.BARCODE_NO = L.BARCODE_PRV_NO
                             AND L.LZ_MANIFEST_DET_ID =
                                 MDET.LAPTOP_ZONE_ID
                             AND LM.LZ_MANIFEST_ID = MDET.LZ_MANIFEST_ID
                             AND LS.DEFAULT_COND = BB.CONDITION_ID
                             AND LS.ITEM_ID = BB.ITEM_ID
                             AND LS.LZ_MANIFEST_ID = BB.LZ_MANIFEST_ID
                             AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID
                             AND BB.ITEM_ID = I.ITEM_ID
                             AND C.ID = L.CONDITION_ID
                             AND O.OBJECT_ID = L.OBJECT_ID
                             AND LS.ENTERED_BY = E.EMPLOYEE_ID(+)
                             AND BB.EBAY_ITEM_ID IS NULL
                             AND BB.BIN_ID = BM.BIN_ID
                             AND BB.DISCARD = 0)) Q
           WHERE M.MT_ID = D.MT_ID
             AND C.MERCHANT_ID = M.MERCHANT_ID
             AND D.BARCODE_NO = Q.BARCODE_PRV_NO)";


            if (!empty($employeeName)) {
                $qyer .= "WHERE upper(ASSIGN_TO)=UPPER('$employeeName')";
            }
            $qyer = $this->db->query($qyer)->result_array();

            if (count($qyer) >= 1) {

                $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array();
                $uri = $this->get_identiti_bar_pics($qyer, $conditions);
                $images = $uri['uri'];
                foreach ($qyer as $key => $value) {

                    $qyer[$key]['MFG_PART_NO'] = str_replace('-', ' ', $value['MFG_PART_NO']);
                }

                return array("images" => $images, 'query' => $qyer);
            } else {
                return array('images' => [], 'query' => [], 'exist' => false);
            }
        } elseif ($radioselect == 'SpecilalLots') {

            $qyer = "SELECT * from (SELECT LS.SEED_ID,
        (SELECT M.USER_NAME
           FROM EMPLOYEE_MT M
          WHERE M.EMPLOYEE_ID = L.UPDATED_BY) VERIFY_BY,
        DECODE(((SELECT *
                   FROM (SELECT M.USER_NAME
                           FROM LZ_LISTING_ALLOC L, EMPLOYEE_MT M
                          WHERE L.SEED_ID = LS.SEED_ID
                            AND L.LISTER_ID = M.EMPLOYEE_ID
                          ORDER BY L.ALLOC_ID DESC)
                  WHERE ROWNUM <= 1)),
               NULL,
               'NOT ASSIGNED',
               ((SELECT *
                   FROM (SELECT M.USER_NAME
                           FROM LZ_LISTING_ALLOC L, EMPLOYEE_MT M
                          WHERE L.SEED_ID = LS.SEED_ID
                            AND L.LISTER_ID = M.EMPLOYEE_ID
                          ORDER BY L.ALLOC_ID DESC)
                  WHERE ROWNUM <= 1))) ASSIGN_TO,
        BB.BARCODE_NO,
        L.BARCODE_PRV_NO,
        LS.ENTERED_BY,
        E.USER_NAME,
        LS.SHIPPING_SERVICE,
        LS.OTHER_NOTES,
        LS.LZ_MANIFEST_ID,
        LM.LOADING_DATE,
        LM.PURCH_REF_NO,
        LS.ITEM_TITLE ITEM_MT_DESC,
        I.ITEM_MT_MANUFACTURE MANUFACTURER,
        I.ITEM_ID,
        I.ITEM_CODE,
        I.ITEM_MT_MFG_PART_NO MFG_PART_NO,
        I.ITEM_MT_UPC UPC,
        BB.BIN_ID,
        BM.BIN_TYPE || '-' || BM.BIN_NO BIN_NAME,
        O.OBJECT_NAME OBJECT_DESCRIP,
        C.COND_NAME ITEM_CONDITION,
        '1' QUANTITY,
        L.FOLDER_NAME
   FROM LZ_BARCODE_MT    BB,
        LZ_SPECIAL_LOTS  L,
        LZ_MANIFEST_DET  MDET,
        ITEMS_MT         I,
        LZ_ITEM_SEED     LS,
        LZ_MANIFEST_MT   LM,
        BIN_MT           BM,
        LZ_ITEM_COND_MT  C,
        LZ_BD_OBJECTS_MT O,
        EMPLOYEE_MT      E
  WHERE BB.BARCODE_NO = L.BARCODE_PRV_NO
    AND L.LZ_MANIFEST_DET_ID = MDET.LAPTOP_ZONE_ID
    AND LM.LZ_MANIFEST_ID = MDET.LZ_MANIFEST_ID
    AND LS.DEFAULT_COND = BB.CONDITION_ID
    AND LS.ITEM_ID = BB.ITEM_ID
    AND LS.LZ_MANIFEST_ID = BB.LZ_MANIFEST_ID
    AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID
    AND BB.ITEM_ID = I.ITEM_ID
    AND C.ID = L.CONDITION_ID
    AND O.OBJECT_ID = L.OBJECT_ID
    AND LS.ENTERED_BY = E.EMPLOYEE_ID(+)
    AND BB.EBAY_ITEM_ID IS NULL
    AND BB.BIN_ID = BM.BIN_ID
    AND BB.DISCARD = 0)";
            if (!empty($employeeName)) {
                $qyer .= "WHERE upper(ASSIGN_TO)=UPPER('$employeeName')";
            }
            $qyer = $this->db->query($qyer)->result_array();

            if (count($qyer) >= 1) {

                $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array();
                $uri = $this->get_identiti_bar_pics($qyer, $conditions);
                $images = $uri['uri'];
                foreach ($qyer as $key => $value) {

                    $qyer[$key]['MFG_PART_NO'] = str_replace('-', ' ', $value['MFG_PART_NO']);
                }

                return array('images' => $images, 'query' => $qyer);
            } else {
                return array('images' => [], 'query' => [], 'exist' => false);
            }
        } elseif ($radioselect == 'DekittedItems') {
            $qyer = "SELECT * FROM (SELECT LS.SEED_ID,
            (SELECT M.USER_NAME
               FROM EMPLOYEE_mT M
              WHERE M.EMPLOYEE_ID = DET.IDENTIFIED_BY) VERIFY_BY,
            DECODE(((SELECT *
                       FROM (SELECT M.USER_NAME
                               FROM LZ_LISTING_ALLOC L,
                                    EMPLOYEE_MT      M
                              WHERE L.SEED_ID = LS.SEED_ID
                                AND L.LISTER_ID =
                                    M.EMPLOYEE_ID
                              ORDER BY L.ALLOC_ID DESC)
                      WHERE ROWNUM <= 1)),
                   NULL,
                   'NOT ASSIGNED',
                   ((SELECT *
                       FROM (SELECT M.USER_NAME
                               FROM LZ_LISTING_ALLOC L,
                                    EMPLOYEE_MT      M
                              WHERE L.SEED_ID = LS.SEED_ID
                                AND L.LISTER_ID =
                                    M.EMPLOYEE_ID
                              ORDER BY L.ALLOC_ID DESC)
                      WHERE ROWNUM <= 1))) ASSIGN_TO,
            BB.BARCODE_NO,
            DET.BARCODE_PRV_NO,
            LS.ENTERED_BY,
            E.USER_NAME,
            LS.SHIPPING_SERVICE,
            LS.OTHER_NOTES,
            LS.LZ_MANIFEST_ID,
            LM.LOADING_DATE,
            LM.PURCH_REF_NO,
            LS.ITEM_TITLE ITEM_MT_DESC,
            I.ITEM_MT_MANUFACTURE MANUFACTURER,
            I.ITEM_ID,
            I.ITEM_CODE,
            I.ITEM_MT_MFG_PART_NO MFG_PART_NO,
            I.ITEM_MT_UPC UPC,
            BB.BIN_ID,
            BM.BIN_TYPE || '-' || BM.BIN_NO BIN_NAME,
            O.OBJECT_NAME OBJECT_DESCRIP,
            C.COND_NAME ITEM_CONDITION,
            '1' QUANTITY,
            DET.BARCODE_PRV_NO FOLDER_NAME
       FROM LZ_BARCODE_MT    BB,
            LZ_DEKIT_US_DT   DET,
            LZ_MANIFEST_DET  MDET,
            ITEMS_MT         I,
            LZ_ITEM_SEED     LS,
            LZ_MANIFEST_MT   LM,
            BIN_MT           BM,
            LZ_ITEM_COND_MT  C,
            LZ_BD_OBJECTS_MT O,
            EMPLOYEE_MT      E
      WHERE BB.BARCODE_NO = DET.BARCODE_PRV_NO
        AND DET.LZ_MANIFEST_DET_ID = MDET.LAPTOP_ZONE_ID
        AND LM.LZ_MANIFEST_ID = MDET.LZ_MANIFEST_ID
        AND LS.DEFAULT_COND = BB.CONDITION_ID
        AND LS.ITEM_ID = BB.ITEM_ID
        AND LS.LZ_MANIFEST_ID = BB.LZ_MANIFEST_ID
        AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID
        AND C.ID = DET.CONDITION_ID
        AND BB.ITEM_ID = I.ITEM_ID
        AND O.OBJECT_ID = DET.OBJECT_ID
        AND LS.ENTERED_BY = E.EMPLOYEE_ID(+)
        AND BB.EBAY_ITEM_ID IS NULL
        AND BB.BIN_ID = BM.BIN_ID
        AND BB.DISCARD = 0)";

            if (!empty($employeeName)) {
                $qyer .= "WHERE upper(ASSIGN_TO)=UPPER('$employeeName')";
            }
            $qyer = $this->db->query($qyer)->result_array();
            if (count($qyer) >= 1) {

                $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array();

                $uri = $this->get_identiti_bar_pics($qyer, $conditions);
                $images = $uri['uri'];
                foreach ($qyer as $key => $value) {

                    $qyer[$key]['MFG_PART_NO'] = str_replace('-', ' ', $value['MFG_PART_NO']);
                }


                return array("images" => $images, 'query' => $qyer);
            } else {
                return array('images' => [], 'query' => [], 'exist' => false);
            }
        }
    }



    public function get_identiti_bar_pics($barcodes, $conditions)
    {

        $path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 2");
        $path = $path->result_array();

        $master_path = $path[0]["MASTER_PATH"];
        $uri = array();
        // $base_url = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        $base_url = 'http://71.78.236.20/';
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


    /********************************
     *  end Screen US-PK Non Listed Items
     *********************************/

    /********************************
     * start Screen US-PK Non Listed Items
     *********************************/

    public function Last_ten_barcode()
    {

        $last_ten = $this->db->query("SELECT * FROM (SELECT D.BARCODE_NO,I.ITEM_DESC,C.COND_NAME,I.ITEM_MT_MANUFACTURE,I.ITEM_MT_MFG_PART_NO,I.ITEM_MT_UPC FROM LZ_DEKIT_US_MT D, LZ_BARCODE_MT B,ITEMS_MT I,LZ_ITEM_COND_MT C WHERE D.BARCODE_NO = B.BARCODE_NO AND B.ITEM_ID = I.ITEM_ID AND B.CONDITION_ID = C.ID ORDER BY D.BARCODE_NO DESC) WHERE ROWNUM <= 10 ")->result_array();

        return  $last_ten;
    }

    public function Get_master_Barcode()
    {
        $barcode = $this->input->post('bardcode');
        $master = $this->db->query("SELECT DE.ITEM_MT_DESC, DE.ITEM_MT_MFG_PART_NO, DE.CONDITIONS_SEG5
        FROM LZ_BARCODE_MT B, LZ_MANIFEST_DET DE, ITEMS_MT I
       WHERE B.BARCODE_NO = '$barcode'
         AND B.ITEM_ID = I.ITEM_ID
         AND I.ITEM_CODE = DE.LAPTOP_ITEM_CODE
         AND B.LZ_MANIFEST_ID = DE.LZ_MANIFEST_ID
         AND ROWNUM <= 1")->result_array();
        return  $master;
    }

    public function Get_master_detail()
    {
        $barcode = $this->input->post('bardcode');
        $master = $this->db->query("SELECT D.LZ_DEKIT_US_DT_ID,
        C.COND_NAME,
        DECODE(D.PRINT_STATUS, 0, 'False', 1, 'True', D.PRINT_STATUS) PRINT_STATUS,
        D.BARCODE_PRV_NO,
        B.BIN_TYPE || '-' || B.BIN_NO BIN_NO,
        B.BIN_ID,
        O.OBJECT_NAME,
        O.OBJECT_ID,
        D.DEKIT_REMARKS,
        D.PIC_NOTES,
        D.WEIGHT,
        D.CONDITION_ID
   FROM LZ_DEKIT_US_MT   M,
        LZ_DEKIT_US_DT   D,
        LZ_BD_OBJECTS_MT O,
        BIN_MT           B,
        LZ_ITEM_COND_MT  C
  WHERE M.BARCODE_NO = '$barcode'
    AND M.LZ_DEKIT_US_MT_ID = D.LZ_DEKIT_US_MT_ID
    AND D.OBJECT_ID = O.OBJECT_ID(+)
    AND B.BIN_ID(+) = D.BIN_ID
    AND D.CONDITION_ID = C.ID(+)
       
  ORDER BY D.BARCODE_PRV_NO desc")->result_array();
        return $master;
    }

    public function Get_object_DrowpDown()
    {
        $master = $this->db->query("SELECT DISTINCT O.OBJECT_NAME , O.OBJECT_ID FROM LZ_BD_CAT_GROUP_DET DT,LZ_BD_OBJECTS_MT O WHERE DT.LZ_BD_GROUP_ID = 3 AND DT.CATEGORY_ID = O.CATEGORY_ID 	ORDER BY O.OBJECT_ID DESC")->result_array();
        return $master;
    }

    public function Get_condition_DrowpDown()
    {
        // $master = $this->db->query("SELECT c.COND_NAME  , d.CONDITION_ID from LZ_ITEM_COND_MT c , LZ_DEKIT_US_DT d  where d.CONDITION_ID = c.ID(+)")->result_array();
        $master = $this->db->query("select c.id,c.cond_name from lz_item_cond_mt c")->result_array();

        return $master;
    }


    public function Get_bin_DrowpDown()
    {
        $master = $this->db->query("SELECT B.BIN_ID, B.BIN_TYPE ||'-'|| B.BIN_NO BIN_NO FROM BIN_MT B WHERE BIN_TYPE <> 'NA'AND BIN_TYPE IN( 'TC','NB') ORDER BY BIN_NO ASC")->result_array();
        return $master;
    }


    public function UpdateWeight()
    {
        $WEIGHT = $this->input->post('WEIGHT');
        // $value['PACKING_NAME'];
        $LZ_DEKIT_US_DT_ID = $this->input->post('LZ_DEKIT_US_DT_ID');

        $Data = $this->db->query("UPDATE LZ_DEKIT_US_DT set WEIGHT='$WEIGHT' where LZ_DEKIT_US_DT_ID='$LZ_DEKIT_US_DT_ID'");
        return $Data;
    }

    public function UpdateDekittingRemarks()
    {
        $DEKIT_REMARKS = $this->input->post('DEKIT_REMARKS');
        // $value['PACKING_NAME'];
        $LZ_DEKIT_US_DT_ID = $this->input->post('LZ_DEKIT_US_DT_ID');

        $Data = $this->db->query("UPDATE LZ_DEKIT_US_DT set DEKIT_REMARKS='$DEKIT_REMARKS' where LZ_DEKIT_US_DT_ID='$LZ_DEKIT_US_DT_ID'");
        return $Data;
    }

    public function UpdateMasterDetial()
    {
        $objectdata = $this->input->post('objectdata');
        $conditiondata = $this->input->post('conditiondata');
        $LZ_DEKIT_US_DT_ID = $this->input->post('LZ_DEKIT_US_DT_ID');
        $Weight = $this->input->post('Weight');
        $selectBin = $this->input->post('selectBin');
        $DekittingRemarks = $this->input->post('DekittingRemarks');

        $Data = $this->db->query("UPDATE LZ_DEKIT_US_DT set OBJECT_ID='$objectdata' ,CONDITION_ID='$conditiondata', BIN_ID='$selectBin' 
        , WEIGHT='$Weight', DEKIT_REMARKS='$DekittingRemarks'  where LZ_DEKIT_US_DT_ID='$LZ_DEKIT_US_DT_ID'");
        return $Data;
    }

    public function DeleteMasterDetail()
    { // for template form
        $LZ_DEKIT_US_DT_ID = $this->input->post('id');
        $deleteTemp = $this->db->query("DELETE LZ_DEKIT_US_DT where LZ_DEKIT_US_DT_ID='$LZ_DEKIT_US_DT_ID'");
        return $deleteTemp;
    }

    public function SaveMasterDetail()
    {
        $master_barcode = $this->input->post('barcode');
        // var_dump( $master_barcode); exit;
        $objectdataUpdate = $this->input->post('objectdataUpdate');
        $conditiondataUpdate = $this->input->post('conditiondataUpdate');
        $WeightUpdate = $this->input->post('WeightUpdate');
        $selectBinUpdate = $this->input->post('BinUpdate');
        // var_dump($selectBinUpdate); exit;
        $DekittingRemarksUpdate = $this->input->post('DekittingRemarksUpdate');
        //$barcode = $this->input->post('bardcode');
        $user_id = $this->input->post('created_by');
        date_default_timezone_set("America/Chicago");
        $date = date('Y-m-d H:i:s');
        $dekit_date = "TO_DATE('" . $date . "', 'YYYY-MM-DD HH24:MI:SS')";




        // check for items is alredy dekited
        //**********************************
        $load_dekit_check = $this->db->query("SELECT B.BARCODE_NO,B.ITEM_ID FROM LZ_BARCODE_MT B, LZ_MANIFEST_DET DE,ITEMS_MT I WHERE B.BARCODE_NO = $master_barcode AND B.ITEM_ID = I.ITEM_ID AND I.ITEM_CODE = DE.LAPTOP_ITEM_CODE AND B.LZ_MANIFEST_ID = DE.LZ_MANIFEST_ID AND ROWNUM <=1 ");
        // var_dump($load_dekit_check);exit;
        if ($load_dekit_check->num_rows() > 0) {
            $get_item = $load_dekit_check->result_array();
            $item_id = $get_item[0]['ITEM_ID'];
            $gl_gen = $this->db->query(" SELECT LZ_ITEM_ADJ_BOOK_ID  FROM GL_GEN_PREFERENCES GD ")->result_array();
            $gen_id = $gl_gen[0]['LZ_ITEM_ADJ_BOOK_ID'];

            $inv_book_id = $this->db->query(" SELECT S.DEF_LOCATOR_CODE_ID  FROM INV_BOOKS_MT B, SUB_INVENTORY_MT S WHERE INV_BOOK_ID = $gen_id AND B.SUB_INV_ID = S.SUB_INV_ID ")->result_array();
            $def_loc_id = $inv_book_id[0]['DEF_LOCATOR_CODE_ID'];

            $adjus_no = $this->db->query(" SELECT TO_CHAR(SYSDATE,'YY')||'-'|| LPAD('8',4,'0') ADJUST_REF_NO   FROM DUAL ")->result_array();
            $adjus = $adjus_no[0]['ADJUST_REF_NO'];

            $inv_book = $this->db->query(" SELECT DOC_SEQ_ID FROM   INV_SEQUENCE_ASSIGNMENT WHERE  inv_book_id = 8 ")->result_array();
            $seq_id = $inv_book[0]['DOC_SEQ_ID'];

            $last = $this->db->query("SELECT LAST_NO +1 LAST_NO, DOC_DET_SEQ_ID FROM   DOC_SEQUENCE_DETAIL WHERE  DOC_DET_SEQ_ID = (SELECT DOC_DET_SEQ_ID FROM   DOC_SEQUENCE_DETAIL WHERE  DOC_SEQ_ID = $seq_id AND TO_DATE('3/1/2017','DD-MM-YYYY') >= FROM_DATE AND TO_DATE('3/1/2017','DD-MM-YYYY') <= TO_DATE AND ROWNUM = 1)")->result_array();
            $last_no = $last[0]['LAST_NO'];
            $doc_det_seq_id = $last[0]['DOC_DET_SEQ_ID'];
            // **** variable declaration for insertion into ITEM_ADJUSTMENT_MT,ITEM_ADJUSTMENT_det end*
            //******************************************************************************************



            // **** code for insertion into ITEM_ADJUSTMENT_MT,ITEM_ADJUSTMENT_det start ****
            //**********************************************************************
            $adjs_mt = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('ITEM_ADJUSTMENT_MT', 'ITEM_ADJUSTMENT_ID')ID FROM DUAL")->result_array();
            $adjs_mt_pk = $adjs_mt[0]['ID'];

            $insert_adjus_mt = "INSERT INTO ITEM_ADJUSTMENT_MT(ITEM_ADJUSTMENT_ID, INV_BOOK_ID, ADJUSTMENT_NO, ADJUSTMENT_DATE, STOCK_TRANS_YN, REMARKS,INV_TRANSACTION_NO, JOURNAL_ID, POST_TO_GL, ENTERED_BY, AUTH_ID, AUTHORIZED_YN, SEND_FOR_AUTH, AUTH_STATUS_ID, 								ADJUSTMENT_REF_NO) 
						VALUES('$adjs_mt_pk', 8, '$last_no', to_date(sysdate), 0, NULL, NULL, NULL, 0, '$user_id', null, 0, 0, 0, '$adjus')";
            $this->db->query($insert_adjus_mt);
            // var_dump($insert_adjus_mt);exit;

            $adjs_det = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('ITEM_ADJUSTMENT_DET ', 'ITEM_ADJUSTMENT_DET_ID')ID FROM DUAL")->result_array();
            $adjs_det_pk = $adjs_det[0]['ID'];

            $insert_adjus_det = "INSERT INTO ITEM_ADJUSTMENT_DET(ITEM_ADJUSTMENT_DET_ID, ITEM_ADJUSTMENT_ID, ITEM_ID, SR_NO, LOC_CODE_COMB_ID, PRIMARY_QTY,SECONDARY_QTY, LINE_AMOUNT, CONTRA_ACC_CODE_COMB_ID, REMARKS ) 
						VALUES('$adjs_det_pk', '$adjs_mt_pk', '$item_id', 1, '$def_loc_id', -1, NULL, 99, NULL, NULL )"; /// $cost variable query        
            $this->db->query($insert_adjus_det);

            $this->db->query("UPDATE DOC_SEQUENCE_DETAIL  SET LAST_NO =$last_no where DOC_DET_SEQ_ID =$doc_det_seq_id");
            $this->db->query("UPDATE LZ_BARCODE_MT SET ITEM_ADJ_DET_ID_FOR_OUT = $adjs_mt_pk WHERE BARCODE_NO = $master_barcode");
            // **** code for insertion into ITEM_ADJUSTMENT_MT,ITEM_ADJUSTMENT_DET end
            //************************************************************************  


            // **** code for insertion into lz_manifest_mt start
            //************************************************************************
            $max_query = $this->db->query("SELECT get_single_primary_key('LZ_MANIFEST_MT','LOADING_NO') ID FROM DUAL");
            $rs = $max_query->result_array();
            $loading_no = $rs[0]['ID'];

            // date_default_timezone_set("America/Chicago");
            // $loading_date = date("Y-m-d H:i:s");
            // $loading_date = "TO_DATE('".$loading_date."', 'YYYY-MM-DD HH24:MI:SS')";
            date_default_timezone_set("America/Chicago");
            $loading_date = date("Y-m-d H:i:s");
            $load_date = "TO_DATE('$loading_date', 'YYYY-MM-DD HH24:MI:SS')";

            $purch_ref_no = 'dk_' . $loading_no;
            $supplier_id = 'null';
            $remarks = $this->input->post('DekittingRemarksUpdate');
            $remarks = trim(str_replace("  ", ' ', $remarks));
            $remarks = trim(str_replace(array("'"), "''", $remarks));
            $doc_seq_id = 30;
            $purchase_date = 'null';
            $posted = 'Posted';
            $excel_file_name = 'null';
            $grn_id = 'null';
            $purchase_invoice_id = 'null';
            $single_entry_id = 'null';
            $total_excel_rows = 'null';
            $manifest_name = 'null';
            $manifest_status = 'null';
            $sold_price = 'null';
            $end_date = 'null';
            $lz_offer = 'null';
            $manifest_type = 3; // for dekit-us-pk manifest generation
            $est_mt_id = 'null';

            /*--- Get Single Primary Key for LZ_MANIFEST_MT start---*/
            $get_mt_pk = $this->db->query("SELECT get_single_primary_key('LZ_MANIFEST_MT','LZ_MANIFEST_ID') LZ_MANIFEST_ID FROM DUAL");
            $get_mt_pk = $get_mt_pk->result_array();
            $lz_manifest_id = $get_mt_pk[0]['LZ_MANIFEST_ID'];
            /*--- Get Single Primary Key for LZ_MANIFEST_MT end---*/

            /*--- Insertion Query for LZ_MANIFEST_MT start---*/
            $mt_qry = "INSERT INTO LZ_MANIFEST_MT
    (LZ_MANIFEST_ID,
     LOADING_NO,
     LOADING_DATE,
     PURCH_REF_NO,
     SUPPLIER_ID,
    REMARKS,
     DOC_SEQ_ID,
     PURCHASE_DATE,
     POSTED,
     EXCEL_FILE_NAME,
     GRN_ID,
     PURCHASE_INVOICE_ID,
     SINGLE_ENTRY_ID,
     TOTAL_EXCEL_ROWS,
     MANIFEST_NAME,
     MANIFEST_STATUS,
     SOLD_PRICE,
     END_DATE,
     LZ_OFFER,
     MANIFEST_TYPE,
     EST_MT_ID)
  VALUES
    ($lz_manifest_id,
     $loading_no,
     sysdate,
     '$purch_ref_no',
     $supplier_id,
     '$remarks',
     $doc_seq_id,
     $purchase_date,
     '$posted',
     $excel_file_name,
     $grn_id,
     $purchase_invoice_id,
     $single_entry_id,
     $total_excel_rows,
     $manifest_name,
     $manifest_status,
     $sold_price,
     $end_date,
     $lz_offer,
     $manifest_type,
     $est_mt_id)";
            $mt_qry = $this->db->query($mt_qry);
            /*--- Insertion Query for LZ_MANIFEST_MT end---*/

            // **** code for insertion into lz_manifest_mt end
            //************************************************************************

            $lz_dekit_us_mt_id = $this->db->query("SELECT M.LZ_DEKIT_US_MT_ID  FROM LZ_DEKIT_US_MT M WHERE M.BARCODE_NO = $master_barcode")->result_array();
            //$lz_dekit_us_mt_id = $lz_dekit_us_mt_id[0]['LZ_DEKIT_US_MT_ID'];
            // var_dump( $lz_dekit_us_mt_id ); exit;
            if (count($lz_dekit_us_mt_id) > 0) {
                $lz_dekit_us_mt_id = $lz_dekit_us_mt_id[0]['LZ_DEKIT_US_MT_ID'];
            } else {
                $query = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_DEKIT_US_MT', 'LZ_DEKIT_US_MT_ID')ID FROM DUAL")->result_array();

                $lz_dekit_us_mt_id = $query[0]['ID'];

                $save_lz_dekit_us_mt = ("INSERT INTO LZ_DEKIT_US_MT(LZ_DEKIT_US_MT_ID,BARCODE_NO,DEKIT_BY,DEKIT_DATE_TIME,ADJUST_MT_ID,LZ_MANIFEST_MT_ID)
                                    VALUES('$lz_dekit_us_mt_id','$master_barcode','$user_id',sysdate,null,null)");
                $this->db->query($save_lz_dekit_us_mt);
            }
            $sequn = $this->db->query("SELECT /*GET_SINGLE_PRIMARY_KEY('LZ_BARCODE_MT','BARCODE_NO')*/SEQ_BARCODE_NO.NEXTVAL as ID FROM DUAL")->result_array();
            $bar_sq = $sequn[0]['ID'];
            $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_DEKIT_US_DT', 'LZ_DEKIT_US_DT_ID')ID FROM DUAL");
            $qry = $qry->result_array();
            $lz_dekit_us_dt_id = $qry[0]['ID'];

            $getlatestData = $this->db->query("INSERT INTO LZ_DEKIT_US_DT (LZ_DEKIT_US_DT_ID,LZ_DEKIT_US_MT_ID,BARCODE_PRV_NO,OBJECT_ID,BIN_ID,PIC_DATE_TIME,PIC_BY,CATALOG_MT_ID,IDENT_DATE_TIME,IDENTIFIED_BY,DEKIT_REMARKS,WEIGHT,CONDITION_ID) VALUES('$lz_dekit_us_dt_id','$lz_dekit_us_mt_id','$bar_sq','$objectdataUpdate','$selectBinUpdate',null,null,null,null,null,'$DekittingRemarksUpdate','$WeightUpdate','$conditiondataUpdate')");
            // **** code for insertion into LZ_DEKIT_US_MT,LZ_DEKIT_US_DT end ****
            //**********************************************************************
            $this->db->query("UPDATE LZ_DEKIT_US_MT  SET ADJUST_MT_ID ='$adjs_mt_pk' ,LZ_MANIFEST_MT_ID = $lz_manifest_id  where LZ_DEKIT_US_MT_ID = $lz_dekit_us_mt_id");


            //code section for saving master barcode mpn start
            $item_ids = $this->db->query("SELECT K.ITEM_ID FROM LZ_BARCODE_MT K WHERE K.BARCODE_NO = $master_barcode")->result_array();
            $item_id  = $item_ids[0]['ITEM_ID'];

            $mpns = $this->db->query("SELECT T.ITEM_MT_MFG_PART_NO FROM ITEMS_MT T WHERE T.ITEM_ID = $item_id")->result_array();
            $mpn  = $mpns[0]['ITEM_MT_MFG_PART_NO'];

            if (!empty($mpn)) {
                $item_mpn = strtoupper($mpn);

                $get_category = $this->db->query("SELECT de.e_bay_cata_id_seg6 CATEGORY_ID FROM LZ_BARCODE_MT B, LZ_MANIFEST_DET DE,ITEMS_MT I WHERE B.BARCODE_NO = $master_barcode AND B.ITEM_ID = I.ITEM_ID AND I.ITEM_CODE = DE.LAPTOP_ITEM_CODE AND B.LZ_MANIFEST_ID = DE.LZ_MANIFEST_ID AND ROWNUM <=1 ")->result_array();

                // old barcode chek$get_category = $this->db->query("SELECT S.CATEGORY_ID FROM LZ_BARCODE_MT B ,LZ_MANIFEST_MT M ,LZ_SINGLE_ENTRY S WHERE B.BARCODE_NO = $master_barcode AND B.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID AND M.SINGLE_ENTRY_ID  = S.ID")->result_array();
                //$get_category->result_array();
                $category_id  = $get_category[0]['CATEGORY_ID'];

                if (!empty($category_id)) {

                    $mpn_data = $this->db->query("SELECT MT.CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT MT WHERE UPPER(MT.MPN) = '$item_mpn' AND MT.CATEGORY_ID = $category_id");


                    //if(!empty($master_mpn_id)){
                    if ($mpn_data->num_rows() > 0) {
                        $mpn_data = $mpn_data->result_array();
                        $master_mpn_id  = $mpn_data[0]['CATALOGUE_MT_ID'];
                        $this->db->query("UPDATE LZ_DEKIT_US_MT SET MASTER_MPN_ID = $master_mpn_id WHERE LZ_DEKIT_US_MT_ID =$lz_dekit_us_mt_id ");
                    }
                }
            }

            //  $get_data = $this->db->query("SELECT * FROM LZ_DEKIT_US_DT where LZ_DEKIT_US_DT_ID = '$lz_dekit_us_dt_id'")->result_array();

            // $tableData = $this->db->query(" SELECT A.ser_rate_id , A.service_id, A.service_type, '$' || A.Charges Charges, A.created_by, TO_CHAR(A.created_date, 'DD-MM-YYYY HH24:MI:SS') created_date, c.service_desc, B.USER_NAME from lj_services c, lj_service_rate A , EMPLOYEE_MT B WHERE B.EMPLOYEE_ID = A.CREATED_BY and c.service_id=A.service_id and A.SER_RATE_ID = '$tableData' order by ser_rate_id DESC ")->result_array();
            // return array("status" => true, "tableData" => $tableData);

            //  $getlatestData = $get_data[0]['LZ_DEKIT_US_DT_ID'];
            $getlatestData = $this->db->query("SELECT D.LZ_DEKIT_US_DT_ID,
        C.COND_NAME,
        DECODE(D.PRINT_STATUS, 0, 'False', 1, 'True', D.PRINT_STATUS) PRINT_STATUS,
        D.BARCODE_PRV_NO,
        B.BIN_TYPE || '-' || B.BIN_NO BIN_NO,
        B.BIN_ID,
        O.OBJECT_NAME,
        O.OBJECT_ID,
        D.DEKIT_REMARKS,
        D.PIC_NOTES,
        D.WEIGHT,
        D.CONDITION_ID
   FROM 
        LZ_DEKIT_US_DT   D,
        LZ_BD_OBJECTS_MT O,
        BIN_MT           B,
        LZ_ITEM_COND_MT  C
  WHERE D.OBJECT_ID = O.OBJECT_ID(+)
    AND B.BIN_ID(+) = D.BIN_ID
    AND D.CONDITION_ID = C.ID(+)
    and D.LZ_DEKIT_US_DT_ID = '$lz_dekit_us_dt_id'
       
  ORDER BY D.BARCODE_PRV_NO desc")->result_array();

            return array("status" => true, 'getlatestData' => $getlatestData);
        } else {
            return array("status" => false, 'getlatestData' => '');
        }
    }


    public function print_us_pk()
    {

        //$lz_dekit_us_dt_id = $this->input->post('id');
        $lz_dekit_us_dt_id = $_GET['id'];
        //$lz_dekit_us_dt_id = $this->uri->segment(4);
        // var_dump( $lz_dekit_us_dt_id); exit;
        // $manifest_id =	$this->uri->segment(5);
        // $barcode = $this->uri->segment(6);
        $print_qry = $this->db->query("SELECT CO.COND_NAME ITEM_DESC, D.LZ_DEKIT_US_DT_ID, D.BARCODE_PRV_NO BAR_CODE, O.OBJECT_NAME, '1' LOT_NO, 'PO_DETAIL_LOT_REF' PO_DETAIL_LOT_REF, 'UNIT_NO' UNIT_NO, '1' LOT_QTY, 'MB' || '-' || MT.BARCODE_NO BARCODE_NO FROM LZ_DEKIT_US_DT D,LZ_DEKIT_US_MT MT ,LZ_BD_OBJECTS_MT O, BIN_MT B, LZ_ITEM_COND_MT CO WHERE D.CONDITION_ID = CO.ID(+) AND D.OBJECT_ID = O.OBJECT_ID(+) AND D.LZ_DEKIT_US_MT_ID = MT.LZ_DEKIT_US_MT_ID AND D.BIN_ID = B.BIN_ID(+) AND D.LZ_DEKIT_US_DT_ID = $lz_dekit_us_dt_id "); //$query = $this->db->query("UPDATE LZ_BARCODE_MT SET PRINT_STATUS = 1 WHERE BARCODE_NO = $barcode");
        //var_dump($print_qry);exit;
        return $print_qry->result_array();
    }
    public function print_all_us_pk()
    {
        //$master_barcode = $this->session->userdata('ctc_kit_barcode');
        //  $master_barcode = $this->uri->segment(4);
        $master_barcode = $_GET['id'];

        $listing_qry = $this->db->query("SELECT CO.COND_NAME ITEM_DESC ,'MB' || '-' || M.BARCODE_NO BARCODE_NO,D.barcode_prv_no BAR_CODE, o.object_name, '1' LOT_NO, 'PO_DETAIL_LOT_REF' PO_DETAIL_LOT_REF, 'UNIT_NO' UNIT_NO, '1' LOT_QTY FROM LZ_DEKIT_US_MT M, LZ_DEKIT_US_DT D, LZ_BD_OBJECTS_MT O, BIN_MT B,lz_item_cond_mt co WHERE M.BARCODE_NO = $master_barcode AND M.LZ_DEKIT_US_MT_ID = D.LZ_DEKIT_US_MT_ID AND D.PRINT_STATUS = 0 and d.condition_id = co.id(+) AND D.OBJECT_ID = O.OBJECT_ID(+) AND D.BIN_ID = B.BIN_ID (+) order by d.barcode_prv_no Desc")->result_array();


        $this->db->query("UPDATE LZ_DEKIT_US_DT L SET L.PRINT_STATUS = 1 WHERE L.BARCODE_PRV_NO IN ( SELECT D.BARCODE_PRV_NO BAR_CODE FROM LZ_DEKIT_US_MT   M, LZ_DEKIT_US_DT   D, LZ_BD_OBJECTS_MT O, BIN_MT B, LZ_ITEM_COND_MT  CO WHERE M.BARCODE_NO = $master_barcode AND M.LZ_DEKIT_US_MT_ID = D.LZ_DEKIT_US_MT_ID AND D.CONDITION_ID = CO.ID(+) AND D.OBJECT_ID = O.OBJECT_ID(+) AND D.BIN_ID = B.BIN_ID(+) AND D.PRINT_STATUS = 0 ) ");
        return $listing_qry;
    }


    /********************************
     * end Screen DE-Kitting - U.S.
     *********************************/

    /********************************
     * start Screen post Item returns
     *********************************/
    public function displayBarcode()
    {
        $bar = $this->input->post('id');
        $qry = $this->db->query("select * from lz_barcode_mt b where b.order_id = '$bar'");

        return  $qry->result_array();
    }

    public function save_data_manualy($merchantArray)

    {
        $buyername = $this->input->post('buyername');
        $reason = $this->input->post('reason');
        $comments = $this->input->post('comments');
        $date = $this->input->post('date');
        $amount = $this->input->post('amount');
        $daItemDescriptiont = $this->input->post('daItemDescriptiont');
        // $selectMarchant2 = $this->input - post('selectMarchant2');
        $returnid = $this->input->post('returnid');
        $TRANSACTION_ID = $this->input->post('TRANSACTION_ID');
        //var_dump($TRANSACTION_ID);
        $ItemId = $this->input->post('ItemId');
        $SelerTotalRefund = $this->input->post('SelerTotalRefund');
        // echo "<pre>";
        // print_r($merchantArray);exit;
        $fromdate = new DateTime($date);
        $checkissuedate2 = date_format($fromdate, 'd-m-y');
        // var_dump($checkissuedate2);exit;
        if (is_array($merchantArray[0])) {
            $merchArrayvalue = $merchantArray[0]['value'];
            $merchArraylable = $merchantArray[0]['label'];
            ///var_dump( $merchArrayvalue,  $merchArraylable, $checkissuedate2); exit;

            $returnURL = 'https://www.ebay.com/rtn/Return/ReturnsDetail?returnId=' . $returnid;

            //var_dump($returnURL); exit;
            $check = $this->db->query("SELECT * FROM LJ_ITEM_RETURNS A WHERE A.RETURNID = '$returnid'")->result_array();
            if (count($check) === 0) {
                $get_pk = $this->db->query("SELECT get_single_primary_key('LJ_ITEM_RETURNS', 'ITEM_RET_ID') ITEM_RET_ID from dual")->result_array();
                $ITEM_RET_ID = $get_pk[0]['ITEM_RET_ID'];
                // var_dump( $ITEM_RET_ID); exit;
                if (empty($returnid)) {
                    $returnid = -1 * $ITEM_RET_ID;
                    //var_dump($returnid); exit;
                }
                $qry = $this->db->query("INSERT INTO LJ_ITEM_RETURNS
        (ITEM_RET_ID,
         RETURNID,
         BUYERLOGINNAME,
         SELLERLOGINNAME,
         RETURN_TYPE,
         RETURN_STATE,
         STATUS,
         ITEMID,
         TRANSACTIONID,
         RETURNQUANTITY,
         TYPE,
         REASON,
         COMMENTS,
         CREATIONDATE,
         SELLERTOTALREFUND,
         SELLERCURRENCY,
         BUYERTOTALREFUND,
         BUYERCURRENCY,
         SELLERRESPONSEDUE,
         RESPONDBYDATE,
         BUYERESCALATIONINFO,
         SELLERESCALATIONINFO,
         ACTIONURL,
         BUYERRESPONSEDUE,
         BUYERRESPONDBYDATE,
         lz_seller_acct_id,
         INSERTED_DATE
         )values(
                $ITEM_RET_ID,
               '$returnid',
               '$buyername',
               '$merchArraylable',
               'MONEY_BACK',
                 null,
               null,
               '$ItemId',
               '$TRANSACTION_ID',
               '$amount',
                null,
               '$reason',
               '$comments',
               TO_DATE('$checkissuedate2','DD-MM-YY HH24:MI:SS'),
               --TO_CHAR(DT.STATUS_DATE,'DD-MM-YY HH24:MI:SS') STATUS_DATE,
               '$SelerTotalRefund',
                 null,
               '$SelerTotalRefund',
               null,
                sysdate,
               sysdate,
               null,
                null,
               '$returnURL',
               null,
               sysdate,
               '$merchArrayvalue',
               sysdate 
              )");
                // echo $this->db->last_query();
                //exit();
                $data = $qry;
                $get_data = $this->db->query("SELECT ITEM_RET_ID FROM LJ_ITEM_RETURNS where ITEM_RET_ID = '$ITEM_RET_ID'")->result_array();
                //$data = $this->db->query($get_data)->;
                $data1 = $get_data[0]['ITEM_RET_ID'];
                // var_dump($data1); exit;
                $data = $this->db->query("SELECT 
               ITEM_RET_ID,
               RETURNID,
               BUYERLOGINNAME,
               SELLERLOGINNAME,
               RETURN_TYPE,
               RETURN_STATE,
               STATUS,
               ITEMID,
               TRANSACTIONID,
               RETURNQUANTITY,
               TYPE,
               REASON,
               COMMENTS,
               CREATIONDATE,
               SELLERTOTALREFUND,
               SELLERCURRENCY,
               BUYERTOTALREFUND,
               BUYERCURRENCY,
               SELLERRESPONSEDUE,
               RESPONDBYDATE,
               BUYERESCALATIONINFO,
               SELLERESCALATIONINFO,
               ACTIONURL,
               BUYERRESPONSEDUE,
               BUYERRESPONDBYDATE,
               lz_seller_acct_id,
               INSERTED_DATE ,
               RETURN_PROCESSED from LJ_ITEM_RETURNS where ITEM_RET_ID ='$data1'")->result_array();
                return array('status' => true, 'data' => $data, 'return_id' => $returnid);
            } else {
                return array('status' => false, 'message' => 'Return Id allready Exist');
            }
        }
    }

    public function Post_item_returns()
    {
        $qry =  $this->db->query("SELECT ITEM_RET_ID,
                RETURNID,
                BUYERLOGINNAME,
                SELLERLOGINNAME,
                RETURN_TYPE,
                RETURN_STATE,
                r.STATUS,
                ITEMID,
                TRANSACTIONID,
                ITEMID ||'-'||  TRANSACTIONID ORDER_ID,
                RETURNQUANTITY,
                TYPE,
                REASON,
                COMMENTS,
                TO_CHAR(CREATIONDATE, 'DD-MM-YYYY HH24:MI:SS') CREATIONDATE,
                '$' || SELLERTOTALREFUND SELLERTOTALREFUND,
                SELLERCURRENCY,
                BUYERTOTALREFUND,
                BUYERCURRENCY,
                SELLERRESPONSEDUE,
                RESPONDBYDATE,
                BUYERESCALATIONINFO,
                SELLERESCALATIONINFO,
                ACTIONURL,
                BUYERRESPONSEDUE,
                BUYERRESPONDBYDATE,
                INSERTED_DATE,
                ee.ebay_item_desc,
                RETURN_PROCESSED,
              
              
                TO_CHAR((SELECT REPLACE(REPLACE(XMLAGG(XMLELEMENT(A, RB.BARCODE_NO) ORDER BY RB.BARCODE_NO DESC NULLS LAST)
                                        .GETCLOBVAL(),
                                        '<A>',
                                        ''),
                                '</A>',
                                ', ') AS BARCODE_NO FROM LJ_RETURNED_BARCODE_MT RB , LJ_ITEM_RETURNED_MT rm 
                            WHERE Rm.Returned_Id = RB.RETURNED_ID 
                            and rm.return_id = r.returnid)) BARCODES
                            
                            
           from LJ_ITEM_RETURNS r,
                (select *
                   from ebay_list_mt e
                  where e.list_id in
                        (select max(list_id) from ebay_list_mt group by ebay_item_id)) ee
          where ee.ebay_item_id = itemid");
        // $data = $this->db->query($qry);
        $qry = $qry->result_array();

        foreach ($qry as $key => $value) {
            // $item_title = trim(str_replace(" ", ' ', $item_title));
            $qry[$key]['RETURN_TYPE'] = str_replace('_', ' ', $value['RETURN_TYPE']);
            $qry[$key]['RETURN_STATE'] = str_replace('_', ' ', $value['RETURN_STATE']);
            $qry[$key]['STATUS'] = str_replace('_', ' ', $value['STATUS']);
            $qry[$key]['TYPE'] = str_replace('_', ' ', $value['TYPE']);
            $qry[$key]['REASON'] = str_replace('_', ' ', $value['REASON']);
            $qry[$key]['SELLERRESPONSEDUE'] = str_replace('_', ' ', $value['SELLERRESPONSEDUE']);
            $qry[$key]['BUYERRESPONSEDUE'] = str_replace('_', ' ', $value['BUYERRESPONSEDUE']);
        }

        return $qry;
    }

    public function InsertedDate($dataArray)
    {
        $merChant_ID = $this->input->post('merchant_id');
        if (!empty($merChant_ID)) {

            $merchantQry = "and r.LZ_SELLER_ACCT_ID =" . $merChant_ID;
        } else {
            $merchantQry = "";
        }

        if (is_array($dataArray[0])) {
            $startDate = date_create($dataArray[0][0]);
            //$startDate = date_format(@$startDate, 'd/m/Y');
            $startDate = date_format(@$startDate, 'Y/m/d');
            $endDate = date_create($dataArray[0][1]);
            $endDate = date_format(@$endDate, 'Y/m/d');

            //$dateQry = "and r.creationdate between TO_DATE('$startDate', 'DD/MM/YYYY') and TO_DATE('$endDate', 'DD/MM/YYYY')";
            $dateQry = "and r.creationdate between TO_DATE('$startDate 00:00:00', 'YYYY/MM/DD HH24:MI:SS') and TO_DATE('$endDate 23:59:59',  'YYYY/MM/DD HH24:MI:SS')";
            //TO_DATE('2019/05/22 00:00:00', 'YYYY/MM/DD HH24:MI:SS') and TO_DATE('2019/05/22 23:59:59', 'YYYY/MM/DD HH24:MI:SS')

        } else {
            $dateQry = "";
        }
        $qry = $this->db->query("SELECT ITEM_RET_ID,
        RETURNID,
        BUYERLOGINNAME,
        SELLERLOGINNAME,
        RETURN_TYPE,
        RETURN_STATE,
        r.STATUS,
        ITEMID,
        TRANSACTIONID,
        RETURNQUANTITY,
        TYPE,
        REASON,
        COMMENTS,
        TO_CHAR(CREATIONDATE, 'DD-MM-YYYY HH24:MI:SS') CREATIONDATE,
        '$' || SELLERTOTALREFUND SELLERTOTALREFUND,
        SELLERCURRENCY,
        BUYERTOTALREFUND,
        BUYERCURRENCY,
        SELLERRESPONSEDUE,
        RESPONDBYDATE,
        BUYERESCALATIONINFO,
        SELLERESCALATIONINFO,
        ACTIONURL,
        BUYERRESPONSEDUE,
        BUYERRESPONDBYDATE,
        INSERTED_DATE,
        ee.ebay_item_desc,
        RETURN_PROCESSED,
        TO_CHAR((SELECT REPLACE(REPLACE(XMLAGG(XMLELEMENT(A, RB.BARCODE_NO) ORDER BY RB.BARCODE_NO DESC NULLS LAST)
                                .GETCLOBVAL(),
                                '<A>',
                                ''),
                        '</A>',
                        ', ') AS BARCODE_NO FROM LJ_RETURNED_BARCODE_MT RB , LJ_ITEM_RETURNED_MT rm
                    WHERE Rm.Returned_Id = RB.RETURNED_ID 
                    and rm.return_id = r.returnid)) BARCODES
                    
   from LJ_ITEM_RETURNS r,
        (select *
           from ebay_list_mt e
          where e.list_id in
                (select max(list_id) from ebay_list_mt group by ebay_item_id)) ee
  where ee.ebay_item_id = itemid $merchantQry $dateQry");
        $qry = $qry->result_array();
        foreach ($qry as $key => $value) {
            // $item_title = trim(str_replace(" ", ' ', $item_title));
            $qry[$key]['RETURN_TYPE'] = str_replace('_', ' ', $value['RETURN_TYPE']);
            $qry[$key]['RETURN_STATE'] = str_replace('_', ' ', $value['RETURN_STATE']);
            $qry[$key]['STATUS'] = str_replace('_', ' ', $value['STATUS']);
            $qry[$key]['TYPE'] = str_replace('_', ' ', $value['TYPE']);
            $qry[$key]['REASON'] = str_replace('_', ' ', $value['REASON']);
            $qry[$key]['SELLERRESPONSEDUE'] = str_replace('_', ' ', $value['SELLERRESPONSEDUE']);
            $qry[$key]['BUYERRESPONSEDUE'] = str_replace('_', ' ', $value['BUYERRESPONSEDUE']);
        }
        return $qry;
    }



    public function Process_Return()
    {
        $return_id = $this->input->post("return_Id");
        $return_status = $this->input->post("radio_input");
        $return_by = $this->input->post("userId");
        $remarks = $this->input->post("Remarks_input");
        $bin = $this->input->post("location_input");
        $barcode_no = $this->input->post("barcode_no");
        $barcode = explode(',', $barcode_no);
        //  var_dump($barcode); exit;
        //$barcodes=explode(',',)
        // var_dump($return_id,  $return_status , $return_by ,  $remarks,$bin); exit;
        if (!empty($bin)) {
            $bin = $this->db->query("SELECT BB.BIN_ID FROM BIN_MT BB WHERE BB.BIN_TYPE||'-'||BB.BIN_NO = '$bin'")->result_array();
            $bin_id = $bin[0]['BIN_ID'];
        } else {
            $bin_id = 0;
        }
        foreach ($barcode as $bar) {


            $qyer = $this->db->query("Call pro_processReturn('$return_id',
                                                  '$return_status' ,
                                                  '$return_by'   ,
                                                  '$remarks'   ,
                                                  '$bin_id',
                                                  '$bar'
                                                   )");
        }

        // if ($qyer) {
        //     $qyer = $this->db->query("UPDATE  LJ_ITEM_RETURNS set RETURN_PROCESSED = '1' where returnid ='$return_id'");
        // }
        $qyer = $this->db->query("SELECT  RETURN_PROCESSED from LJ_ITEM_RETURNS s where s.returnid ='$return_id'")->result_array();

        if ($qyer) {
            return array("status" => true, "data" => $qyer);
        } else {
            return array("status" => false);
        }
    }


    public function printBarcode()
    {
        sleep(1);
        $return_id = $this->uri->segment(4);
        // var_dump($return_id);exit;
        return $this->db->query("SELECT B.BARCODE_NO,
       SUBSTR(I.ITEM_DESC, 1, 80) ITEM_DESC,
       'UPC:' || I.ITEM_MT_UPC UPC,
       'Printed:'|| sysdate dated,
       'R' r_bar
  FROM LZ_BARCODE_MT B, ITEMS_MT I
 WHERE B.ITEM_ID = I.ITEM_ID
   AND B.BARCODE_NO in (select m.barcode_no from LJ_RETURNED_BARCODE_MT m where m.returned_id = (select mm.returned_id from LJ_ITEM_RETURNED_MT mm where mm.return_id = '$return_id') )")->result_array();
    }
    public function Get_location()
    {
        $bin = $this->input->post("location_value");
        if (!empty($bin)) {
            $bin1 = $this->db->query("SELECT BB.BIN_ID FROM BIN_MT BB WHERE BB.BIN_TYPE||'-'||BB.BIN_NO = '$bin'");
            if ($bin1->num_rows() > 0) {
                $bin1 = $bin1->result_array();
                $bin_id = $bin1[0]['BIN_ID'];
                // return $bin_id;
                return array("status" => true, "data" => $bin_id);
            } else {
                return array("status" => false, "message" => "Invalid Location");
            }
        }
    }

    public function SellerDrop()
    {
        $getmarchantdrop = $this->db->query("SELECT  LZ_SELLER_ACCT_ID , SELL_ACCT_DESC from lz_seller_accts")->result_array();
        return $getmarchantdrop;
    }
    public function reasonDrop()
    {
        $reasond = $this->db->query("SELECT s.reason id ,replace(s.reason ,'_',' ') value from lj_item_returns s group by s.reason")->result_array();
        //var_dump($reasond); exit;
        return $reasond;
    }

    public function DownlaodReturns()
    {

        $merchant_id = $this->input->post("merchant_id");
        $return_value = $this->input->post("return_value");


        $result['merchant_id'] = $merchant_id;
        $result['return_value'] = $return_value;
        $result['returnCall'] = 1;
        $this->load->view('ebay/postOrder/01-searchReturn', $result);
        return  $result;
    }

    public function FiterDeta_radio()
    {
        $radiovalue = $this->input->post("id");
        if ($radiovalue == 'all') {
            $qry = $this->db->query("SELECT ITEM_RET_ID,
            RETURNID,
            BUYERLOGINNAME,
            SELLERLOGINNAME,
            RETURN_TYPE,
            RETURN_STATE,
            r.STATUS,
            ITEMID,
            TRANSACTIONID,
            RETURNQUANTITY,
            TYPE,
            REASON,
            COMMENTS,
            TO_CHAR(CREATIONDATE, 'DD-MM-YYYY HH24:MI:SS') CREATIONDATE,
            '$' || SELLERTOTALREFUND SELLERTOTALREFUND,
            SELLERCURRENCY,
            BUYERTOTALREFUND,
            BUYERCURRENCY,
            SELLERRESPONSEDUE,
            RESPONDBYDATE,
            BUYERESCALATIONINFO,
            SELLERESCALATIONINFO,
            ACTIONURL,
            BUYERRESPONSEDUE,
            BUYERRESPONDBYDATE,
            INSERTED_DATE,
            ee.ebay_item_desc,
            RETURN_PROCESSED,
            TO_CHAR((SELECT REPLACE(REPLACE(XMLAGG(XMLELEMENT(A, RB.BARCODE_NO) ORDER BY RB.BARCODE_NO DESC NULLS LAST)
                                    .GETCLOBVAL(),
                                    '<A>',
                                    ''),
                            '</A>',
                            ', ') AS BARCODE_NO FROM LJ_RETURNED_BARCODE_MT RB , LJ_ITEM_RETURNED_MT rm
                        WHERE Rm.Returned_Id = RB.RETURNED_ID 
                        and rm.return_id = r.returnid)) BARCODES
                        
       from LJ_ITEM_RETURNS r,
            (select *
               from ebay_list_mt e
              where e.list_id in
                    (select max(list_id) from ebay_list_mt group by ebay_item_id)) ee
      where ee.ebay_item_id = itemid")->result_array();
        } else {
            $qry = $this->db->query("SELECT ITEM_RET_ID,
            RETURNID,
            BUYERLOGINNAME,
            SELLERLOGINNAME,
            RETURN_TYPE,
            RETURN_STATE,
            r.STATUS,
            ITEMID,
            TRANSACTIONID,
            RETURNQUANTITY,
            TYPE,
            REASON,
            COMMENTS,
            TO_CHAR(CREATIONDATE, 'DD-MM-YYYY HH24:MI:SS') CREATIONDATE,
            '$' || SELLERTOTALREFUND SELLERTOTALREFUND,
            SELLERCURRENCY,
            BUYERTOTALREFUND,
            BUYERCURRENCY,
            SELLERRESPONSEDUE,
            RESPONDBYDATE,
            BUYERESCALATIONINFO,
            SELLERESCALATIONINFO,
            ACTIONURL,
            BUYERRESPONSEDUE,
            BUYERRESPONDBYDATE,
            INSERTED_DATE,
            ee.ebay_item_desc,
            RETURN_PROCESSED,
            TO_CHAR((SELECT REPLACE(REPLACE(XMLAGG(XMLELEMENT(A, RB.BARCODE_NO) ORDER BY RB.BARCODE_NO DESC NULLS LAST)
                                    .GETCLOBVAL(),
                                    '<A>',
                                    ''),
                            '</A>',
                            ', ') AS BARCODE_NO FROM LJ_RETURNED_BARCODE_MT RB , LJ_ITEM_RETURNED_MT rm
                        WHERE Rm.Returned_Id = RB.RETURNED_ID 
                        and rm.return_id = r.returnid)) BARCODES
                        
       from LJ_ITEM_RETURNS r,
            (select *
               from ebay_list_mt e
              where e.list_id in
                    (select max(list_id) from ebay_list_mt group by ebay_item_id)) ee
      where ee.ebay_item_id = itemid and RETURN_PROCESSED='$radiovalue'")->result_array();
        }
        foreach ($qry as $key => $value) {
            // $item_title = trim(str_replace(" ", ' ', $item_title));
            $qry[$key]['RETURN_TYPE'] = str_replace('_', ' ', $value['RETURN_TYPE']);
            $qry[$key]['RETURN_STATE'] = str_replace('_', ' ', $value['RETURN_STATE']);
            $qry[$key]['STATUS'] = str_replace('_', ' ', $value['STATUS']);
            $qry[$key]['TYPE'] = str_replace('_', ' ', $value['TYPE']);
            $qry[$key]['REASON'] = str_replace('_', ' ', $value['REASON']);
            $qry[$key]['SELLERRESPONSEDUE'] = str_replace('_', ' ', $value['SELLERRESPONSEDUE']);
            $qry[$key]['BUYERRESPONSEDUE'] = str_replace('_', ' ', $value['BUYERRESPONSEDUE']);
        }

        return $qry;
    }

    public function undo_data()
    {

        $return_id = $this->input->post("id");

        $qyer = $this->db->query("Call pro_processreturnundo('$return_id')");
        // if ($qyer) {
        //     $qyer = $this->db->query("UPDATE  LJ_ITEM_RETURNS set RETURN_PROCESSED ='0' where returnid ='$return_id'");
        // }
        $qyer = $this->db->query("SELECT  RETURN_PROCESSED from LJ_ITEM_RETURNS s where s.returnid ='$return_id'")->result_array();
        if ($qyer) {
            return array("status" => true, "data" => $qyer);
        } else {
            return array("status" => false, "data" => 'Not Exist');
        }
        //return  $qyer;
    }
    public function Filter_Data_Item_Return()
    {

        $radio_value = $this->input->post('radio_value');
        $check_box = $this->input->post('filterdata_radio');
        //    print_r($check_box);
        //    exit();
        $search_data = $this->input->post('search_data');
        $show_filter = $this->input->post('show_filter');
        $show_90 = $this->input->post('older_90');
        // if ($check_box) {
        // if ($check_box == '0') {
        //     $retunData = $this->db->query("SELECT g.return_id from lz_salesload_det g  where g.sales_record_number = '$search_data'")->result_array();


        if ($show_90 == 'true') {
            $qry = "select d.*, '$' || total_price total_price, m.lz_seller_acct_id
        from lz_salesload_det d , lz_salesload_mt m
       where d.lz_saleload_id = m.lz_saleload_id
       and d.inserted_date >= sysdate - 90 ";
        } else {
            $qry = "select d.*, '$' || total_price total_price, m.lz_seller_acct_id
        from lz_salesload_det d , lz_salesload_mt m
       where d.lz_saleload_id = m.lz_saleload_id ";
        }
        $cam = '';
        if ($radio_value == 'Like') {
            $cam = 'LIKE';
            $perc = '%';
        } else {
            $cam = '=';
            $perc = '';
        }

        if ($show_filter == 'true') {
            // var_dump(empty($check_box));exit;
            if ($check_box !== null) {


                if ($check_box == '0') {


                    $qry .= "and d.sales_record_number $cam '$perc$search_data$perc'";
                }
                if ($check_box == '1') {

                    $qry .= "and d.extendedorderid $cam '$perc$search_data$perc'";
                }
                if ($check_box == '2') {

                    $qry .= "and d.item_id $cam '$perc$search_data$perc'";
                }

                if ($check_box == '3') {

                    $qry .= "and d.tracking_number  $cam '$perc$search_data$perc'";
                }
            }
        } else {

            $filter_value = $this->input->post('filter_value');




            if ($filter_value['value'] !== null) {
                //var_dump($filter_value['value']); exit;
                $field = $filter_value['value'];
                $data = trim($search_data);
                $str = explode(' ', $data);
                $w = count($str);
                //var_dump($filter_value['value']);exit;
                $i = 1;
                if ($w > 1) {
                    foreach ($str as $val) {
                        $key = strtoupper(trim($val));
                        if ($i === 1) {
                            $startbreket = '(';
                        } else {
                            $startbreket = '';
                        }
                        if ($i === $w) {
                            $endbraket = ')';
                        } else {
                            $endbraket = '';
                        }

                        $qry .= "and  $startbreket upper(d.$field) $cam '$perc$key$perc' $endbraket";

                        if ($i === 1) {
                            $qry .= "and  $startbreket upper(d.$field) $cam '$perc$key$perc' $endbraket";
                        } else {
                            $qry .= " and  $startbreket upper(d.$field) $cam '$perc$key$perc' $endbraket";
                        }
                        // }

                        $i++;
                    }
                } else {
                    if ($cam == 'LIKE') {
                        foreach ($str as $val) {
                            $key = strtoupper(trim($val));
                            if ($field == 'buyer_address1') {

                                $qry .= "and  $startbreket upper(d.buyer_address1) $cam '$perc$key$perc' $endbraket";
                                $qry .= "and  $startbreket upper(d.buyer_address2) $cam '$perc$key$perc' $endbraket";
                                $qry .= "and  $startbreket upper(d.ship_to_address1) $cam '$perc$key$perc' $endbraket";
                                $qry .= "and  $startbreket upper(d.ship_to_address2) $cam '$perc$key$perc' $endbraket";
                            } else {

                                $qry .= "and upper(d.$field) $cam '$perc$key$perc'";
                            }


                            $i++;
                        }
                    } else {
                        if ($field == 'buyer_address1') {

                            $qry .= "and  $startbreket upper(d.buyer_address1) $cam '$perc$str$perc' $endbraket";
                            $qry .= "and  $startbreket upper(d.buyer_address2) $cam '$perc$str$perc' $endbraket";
                        } else {

                            $qry .= "and upper(d.$field) $cam '$perc$str$perc'";
                        }
                    }
                }
            }
        } // end main if else

        $data = $this->db->query($qry)->result_array();
        if ($show_filter == 'true') {
            $group_id = "";
            if ($radio_value !== 'Like') {
                if ($show_90 == 'true') {
                    $qry = "select d.*, '$' || total_price total_price, m.lz_seller_acct_id
                from lz_salesload_det d , lz_salesload_mt m
               where d.lz_saleload_id = m.lz_saleload_id
               and d.inserted_date >= sysdate - 90 ";
                } else {
                    $qry = "select d.*, '$' || total_price total_price, m.lz_seller_acct_id
                from lz_salesload_det d , lz_salesload_mt m
               where d.lz_saleload_id = m.lz_saleload_id ";
                }
                foreach ($data as $key => $value) {
                    $group_id = $value['SALES_RECORD_NO_GROUP'];
                    if (!empty($value['SALES_RECORD_NO_GROUP'])) {

                        $qry .= "and  ( upper(d.SALES_RECORD_NO_GROUP) = '$group_id' )";
                    }
                }
            }
            if (!empty($group_id)) {
                $data = $this->db->query($qry)->result_array();
            }
        }
        // echo "<pre>";
        // print_r($data);
        // exit;
        $mesages = '';
        foreach ($data as $key => $value) {
            if (!empty($value['RETURN_ID'])) {
                $data[$key]['RETURN_ID_STATUS'] = "TRUE";
                $mesages = 'Return Already Processed';
            } else {
                $data[$key]['RETURN_ID_STATUS'] = "FALSE";
                // $mesages = 'No Cancel Or Return Id';
            }
            if (!empty($value['CANCEL_ID'])) {
                $data[$key]['CANCEL_ID_STATUS'] = "TRUE";
                $mesages = 'Item Already Canceled';
            } else {
                $data[$key]['CANCEL_ID_STATUS'] = "FALSE";
                //$mesages = 'No Cancel Or Return Id';
            }
            if (empty($value['CANCEL_ID']) && empty($value['RETURN_ID'])) {
                $mesages = 'No Cancel And No Return iid';
            }
        }


        //else {

        //     $mesages = 'No Return And No Canceled Id';
        // }

        if ($data) {
            return array("data" => $data,  'status' => true, 'mesages' => $mesages);
        } else {
            return array("data" => array(), 'status' => false, 'mesages' => '');
        }
    }
    /********************************
     * end Screen post Item returns
     *********************************/
    /********************************
     * START  Screen invoices by tayyab
     *********************************/

    public function insert_payment_detail()
    {

        $merchantid = $this->input->post('merchantid');
        $RecieptNumber = $this->input->post('RecieptNumber');
        $paymentDate = $this->input->post('paymentDate');

        $fromdate = new DateTime($paymentDate);
        $paymentDate2 = date_format($fromdate, 'y-m-d');

        // $paymentDate1 = date_create($paymentDate);
        // $paymentDate1 = date_format(@$paymentDate1, 'd/m/y H:i');
        $amountPaid = $this->input->post('amountPaid');
        $user_id = $this->input->post('user_id');
        $payment_type = $this->input->post('payment_type');
        $checkNumber = $this->input->post('checkNumber');
        $checkName = $this->input->post('checkName');
        $checkissuedate = $this->input->post('checkissuedate');
        // $checkissuedate = date('Y-m-d H:i:s');
        // // $dekit_date = "TO_DATE('" . $date . "', 'YYYY-MM-DD HH24:MI:SS')";
        // $checkissuedate1 = date_create($checkissuedate);
        // $checkissuedate1 = date_format(@$checkissuedate1, 'd/m/y H:i');
        $fromdate = new DateTime($checkissuedate);
        $checkissuedate2 = date_format($fromdate, 'y-m-d');

        $incoive_id = $this->input->post('incoive_id');

        $stat_query = $this->db->query("INSERT INTO  LJ_PAYMENT_RECEIPT(LJ_PAYMENT_ID,  MERCHANT_ID, RECIEPT_NO, PAYMENT_DATE, AMOUNT_PAID, RECIEVED_BY, PAYMENT_TYPE, CHECK_NUMBER,CHECK_NAME, CHECK_ISSUE_DATE, INVOICE_ID) values (get_single_primary_key('LJ_PAYMENT_RECEIPT','LJ_PAYMENT_ID'),'$merchantid','$RecieptNumber', TO_DATE('$paymentDate2','yyyy-mm-dd HH24:MI:SS'),'$amountPaid','$user_id','$payment_type','$checkNumber','$checkName',TO_DATE('$checkissuedate2','yyyy-mm-dd HH24:MI:SS'),'$incoive_id')");
        //var_dump( $stat_query );exit;
        return $stat_query;
    }

    public function get_Receipt_no()
    {
        $merchantid = $this->input->post('id');
        // var_dump( $merchantid); exit;
        $stat_query = $this->db->query(" SELECT Lpad (NVL(MAX(l.reciept_no + 1), 1) , 5, '0') Receipt  FROM lj_payment_receipt l
        where l.merchant_id =$merchantid");
        //var_dump( $stat_query );exit;
        return $stat_query->result_array();
    }



    /********************************
     * end Screen invoices by tayyab
     *********************************/
    /********************************
     *   start Screen barcodeImage
     *********************************/

    public function get_barcode_detail()
    {
        $barccode_no = $this->input->post('id');
        if (!empty($barccode_no)) {
            $tBarcode = $this->db->query("SELECT C.USER_NAME,
            m.buisness_name,
            md.barcode_no,
            L.LOT_DESC,
            L.LOT_ID,
            mb.issued_date
       from employee_mt            C,
            lz_merchant_mt         m,
            lz_merchant_barcode_mt mb,
            lz_merchant_barcode_dt md,
            lot_defination_mt      L
      WHERE md.mt_id = mb.mt_id
        AND m.merchant_id = mb.merchant_id
        AND mb.lot_id = L.LOT_ID
        AND mb.issued_by = c.employee_id
        AND md.barcode_no = '$barccode_no'");

            if ($tBarcode->num_rows() > 0) {
                $tBarcode = $tBarcode->result_array();
                return array("status" => true, "data" => $tBarcode);
            } else {
                return array("status" => false, "message" => "Barcode Detail Not Exist");
            }
        }
    }
    public function get_all_barcode()
    {
        $qry = $this->db->query("SELECT C.USER_NAME,
        m.buisness_name,
        md.barcode_no,
        L.LOT_DESC,
        L.LOT_ID,
        mb.issued_date
   from employee_mt            C,
        lz_merchant_mt         m,
        lz_merchant_barcode_mt mb,
        lz_merchant_barcode_dt md,
        lot_defination_mt      L
  WHERE md.mt_id = mb.mt_id
    AND m.merchant_id = mb.merchant_id
    AND mb.lot_id = L.LOT_ID
    AND mb.issued_by = c.employee_id
    AND md.barcode_no = md.barcode_no")->result_array();
        return $qry;
    }
    // /********************************
    //  *  end Screen barcodeImage
    //  *********************************/

    // /********************************
    //  *  start Screen Lister View
    //  *********************************/
    public function lister_view()
    {
        $date = $this->input->post('data');
        $startDate = date_create($date);
        $startDate = date_format(@$startDate, 'Y/m/d');
        //var_dump($startDate);exit;
        $qry = $this->db->query("SELECT T.ITEM_ID,
        T.LZ_MANIFEST_ID,
        TO_CHAR(T.LIST_DATE, 'DD-MM-YYYY HH24:MI:SS') AS LIST_DATE,
        T.LISTER_ID,
        E.USER_NAME,
        T.EBAY_ITEM_DESC,
        T.LIST_QTY,
        T.EBAY_ITEM_ID,
        '$' || LIST_PRICE LIST_PRICE,
        T.LZ_SELLER_ACCT_ID,
        a.sell_acct_desc,
         EXTRACT(Day FROM(sysdate -
         T.LIST_DATE) DAY TO
          SECOND) as Day,
                L.EBAY_URL
            FROM EBAY_LIST_MT T, EMPLOYEE_MT E, LZ_LISTED_ITEM_URL L,lz_seller_accts a
            WHERE T.LISTER_ID = E.EMPLOYEE_ID
            AND T.EBAY_ITEM_ID = L.EBAY_ID
            and T.LIST_DATE BETWEEN TO_DATE('$startDate 00:00:00', 'YYYY/MM/DD HH24:MI:SS') AND TO_DATE('$startDate 23:59:59',  'YYYY/MM/DD HH24:MI:SS')           
            AND T.LZ_SELLER_ACCT_ID IS NOT NULL
            and T.lz_seller_acct_id = a.lz_seller_acct_id")->result_array();
        return  $qry;
    }

    public function sum_total_listing()
    {
        //$sum_listing = $this->db->query("select count(t.item_id) as TOTAL_LISTING,sum(t.list_price) as TOTAL_PRICE from ebay_list_mt t where  t.lz_seller_acct_id is not null");
        $date = $this->input->post('data');
        $startDate = date_create($date);
        $startDate = date_format(@$startDate, 'Y/m/d');

        $sum_listing = $this->db->query("SELECT COUNT(1) AS TOTAL_LISTING, '$' || SUM(LIST_AMT) AS TOTAL_PRICE
        FROM (SELECT E.EBAY_ITEM_ID, SUM(E.LIST_QTY * E.LIST_PRICE) LIST_AMT
                FROM EBAY_LIST_MT E
               WHERE E.LZ_SELLER_ACCT_ID IS NOT NULL
                    and E.LIST_DATE BETWEEN TO_DATE('$startDate 00:00:00', 'YYYY/MM/DD HH24:MI:SS') AND TO_DATE('$startDate 23:59:59',  'YYYY/MM/DD HH24:MI:SS') 
               GROUP BY E.EBAY_ITEM_ID) IN_QRY")->result_array();

        //var_dump($sum_listing->result_array());exit;

        return $sum_listing;
    }

    public function listerUsers()
    {
        $query = $this->db->query("SELECT T.EMPLOYEE_ID, T.USER_NAME FROM EMPLOYEE_MT T WHERE T.STATUS =1 ");

        //var_dump($query->result_array());exit;
        return $query->result_array();
    }


    public function filter_data($dataArray)
    {
        $radiobtn = $this->input->post('radiobtn');
        // $date = $this->input->post('date');
        $ListeruserId = $this->input->post('ListeruserId');
        //var_dump($dataArray); exit;
        $startDate = date_create($dataArray[0][0]);
        $startDate = date_format(@$startDate, 'Y/m/d');
        //var_dump($startDate); exit;
        $endDate = date_create($dataArray[0][1]);
        $endDate = date_format(@$endDate, 'Y/m/d');

        if ($ListeruserId == "" && $radiobtn == 'Both') {
            $sql = "SELECT T.ITEM_ID, T.LZ_MANIFEST_ID,EXTRACT(Day FROM(sysdate -
            T.LIST_DATE) DAY TO
             SECOND) as Day, TO_CHAR(T.LIST_DATE, 'DD-MM-YYYY HH24:MI:SS') AS LIST_DATE, T.LISTER_ID, E.USER_NAME, T.EBAY_ITEM_DESC, T.LIST_QTY, T.EBAY_ITEM_ID,  '$' || LIST_PRICE LIST_PRICE, T.LZ_SELLER_ACCT_ID, L.EBAY_URL , a.sell_acct_desc FROM EBAY_LIST_MT T, EMPLOYEE_MT E,LZ_LISTED_ITEM_URL L, lz_seller_accts a WHERE T.LISTER_ID = E.EMPLOYEE_ID AND T.EBAY_ITEM_ID=L.EBAY_ID AND T.LZ_SELLER_ACCT_ID= a.lz_seller_acct_id and T.LIST_DATE BETWEEN TO_DATE('$startDate 00:00:00', 'YYYY/MM/DD HH24:MI:SS') AND TO_DATE('$endDate 23:59:59',  'YYYY/MM/DD HH24:MI:SS') AND T.LISTER_ID IN (4,5,13,14,16,2,18,21,22,23,24,25,26)";
        } elseif ($ListeruserId !== "All" && $ListeruserId !== "PK" && $ListeruserId !== "US") {
            $sql = "SELECT T.ITEM_ID, T.LZ_MANIFEST_ID,EXTRACT(Day FROM(sysdate -
            T.LIST_DATE) DAY TO
             SECOND) as Day, TO_CHAR(T.LIST_DATE, 'DD-MM-YYYY HH24:MI:SS') AS LIST_DATE, T.LISTER_ID, E.USER_NAME, T.EBAY_ITEM_DESC, T.LIST_QTY, T.EBAY_ITEM_ID,  '$' || LIST_PRICE LIST_PRICE, T.LZ_SELLER_ACCT_ID, L.EBAY_URL ,a.sell_acct_desc FROM EBAY_LIST_MT T, EMPLOYEE_MT E,LZ_LISTED_ITEM_URL L, lz_seller_accts a WHERE T.LISTER_ID = E.EMPLOYEE_ID AND T.EBAY_ITEM_ID=L.EBAY_ID AND T.LZ_SELLER_ACCT_ID= a.lz_seller_acct_id and T.LIST_DATE BETWEEN TO_DATE('$startDate 00:00:00', 'YYYY/MM/DD HH24:MI:SS') AND TO_DATE('$endDate 23:59:59',  'YYYY/MM/DD HH24:MI:SS') AND T.LISTER_ID = '$ListeruserId'";
        } elseif ($ListeruserId == "US") {

            $sql = "SELECT T.ITEM_ID, T.LZ_MANIFEST_ID,EXTRACT(Day FROM(sysdate -
            T.LIST_DATE) DAY TO
             SECOND) as Day, TO_CHAR(T.LIST_DATE, 'DD-MM-YYYY HH24:MI:SS') AS LIST_DATE, T.LISTER_ID, E.USER_NAME, T.EBAY_ITEM_DESC, T.LIST_QTY, T.EBAY_ITEM_ID,  '$' || LIST_PRICE LIST_PRICE, T.LZ_SELLER_ACCT_ID, L.EBAY_URL, a.sell_acct_desc FROM EBAY_LIST_MT T, EMPLOYEE_MT E,LZ_LISTED_ITEM_URL L, lz_seller_accts a WHERE T.LISTER_ID = E.EMPLOYEE_ID AND T.EBAY_ITEM_ID=L.EBAY_ID AND T.LZ_SELLER_ACCT_ID= a.lz_seller_acct_id and T.LIST_DATE BETWEEN TO_DATE('$startDate 00:00:00', 'YYYY/MM/DD HH24:MI:SS') AND TO_DATE('$endDate 23:59:59',  'YYYY/MM/DD HH24:MI:SS') AND T.LISTER_ID IN (SELECT EMPLOYEE_ID FROM EMPLOYEE_MT WHERE LOCATION = 'US')";
        } elseif ($ListeruserId == "PK") {
            $sql = "SELECT T.ITEM_ID, T.LZ_MANIFEST_ID,EXTRACT(Day FROM(sysdate -
            T.LIST_DATE) DAY TO
             SECOND) as Day, TO_CHAR(T.LIST_DATE, 'DD-MM-YYYY HH24:MI:SS') AS LIST_DATE, T.LISTER_ID, E.USER_NAME, T.EBAY_ITEM_DESC, T.LIST_QTY, T.EBAY_ITEM_ID,  '$' || LIST_PRICE LIST_PRICE, T.LZ_SELLER_ACCT_ID, L.EBAY_URL ,a.sell_acct_desc FROM EBAY_LIST_MT T, EMPLOYEE_MT E,LZ_LISTED_ITEM_URL L ,lz_seller_accts a WHERE T.LISTER_ID = E.EMPLOYEE_ID AND T.EBAY_ITEM_ID=L.EBAY_ID AND T.LZ_SELLER_ACCT_ID= a.lz_seller_acct_id and T.LIST_DATE BETWEEN TO_DATE('$startDate 00:00:00', 'YYYY/MM/DD HH24:MI:SS') AND TO_DATE('$endDate 23:59:59',  'YYYY/MM/DD HH24:MI:SS') AND T.LISTER_ID IN (SELECT EMPLOYEE_ID FROM EMPLOYEE_MT WHERE LOCATION = 'PK')";
        }

        if ($radiobtn == 2) {
            $sql .= " AND T.LZ_SELLER_ACCT_ID =2";
            // $this->session->set_userdata('lister', $radiobtn);
        } elseif ($radiobtn == 1) {
            $sql .= " AND T.LZ_SELLER_ACCT_ID =1";
            //$this->session->set_userdata('lister', $radiobtn);
        } elseif ($radiobtn == 'Both') {
            $sql .= "AND T.LZ_SELLER_ACCT_ID IN(1,2)";
            //$this->session->set_userdata('lister', $radiobtn);
        }
        //  print_r($sql);exit;
        return  $this->db->query($sql)->result_array();
    }

    public function price_fiter($dataArray)
    {
        $radiobtn = $this->input->post('radiobtn');
        // $date = $this->input->post('date');process_Return
        $ListeruserId = $this->input->post('ListeruserId');

        $startDate = date_create($dataArray[0][0]);
        $startDate = date_format(@$startDate, 'Y/m/d');
        //var_dump($startDate); exit;
        $endDate = date_create($dataArray[0][1]);
        $endDate = date_format(@$endDate, 'Y/m/d');
        if ($ListeruserId == "" && $radiobtn == 'Both') {
            $main_query = "SELECT COUNT(1) AS TOTAL_LISTING,'$'|| SUM(LIST_AMT) AS  TOTAL_PRICE FROM ( SELECT E.EBAY_ITEM_ID, SUM(E.LIST_QTY * E.LIST_PRICE) LIST_AMT FROM EBAY_LIST_MT E WHERE E.LZ_SELLER_ACCT_ID IS NOT NULL AND E.LISTER_ID IN (4,5,13,14,16,2,18,21,22,23,24,25,26) AND E.LIST_DATE BETWEEN TO_DATE('$startDate 00:00:00', 'YYYY/MM/DD HH24:MI:SS') AND TO_DATE('$endDate 23:59:59',  'YYYY/MM/DD HH24:MI:SS')";
        } elseif ($ListeruserId !== "All" && $ListeruserId !== "PK" && $ListeruserId !== "US") {
            $main_query = "SELECT COUNT(1) AS TOTAL_LISTING,'$'|| SUM(LIST_AMT) AS  TOTAL_PRICE FROM ( SELECT E.EBAY_ITEM_ID, SUM(E.LIST_QTY * E.LIST_PRICE) LIST_AMT FROM EBAY_LIST_MT E WHERE E.LZ_SELLER_ACCT_ID IS NOT NULL AND E.LISTER_ID = '$ListeruserId' AND E.LIST_DATE BETWEEN TO_DATE('$startDate 00:00:00', 'YYYY/MM/DD HH24:MI:SS') AND TO_DATE('$endDate 23:59:59',  'YYYY/MM/DD HH24:MI:SS')";
        } elseif ($ListeruserId == "PK") {
            $main_query = "SELECT COUNT(1) AS TOTAL_LISTING,'$'|| SUM(LIST_AMT) AS  TOTAL_PRICE FROM ( SELECT E.EBAY_ITEM_ID, SUM(E.LIST_QTY * E.LIST_PRICE) LIST_AMT FROM EBAY_LIST_MT E WHERE E.LZ_SELLER_ACCT_ID IS NOT NULL AND E.LISTER_ID IN (SELECT EMPLOYEE_ID FROM EMPLOYEE_MT WHERE LOCATION = 'PK') AND E.LIST_DATE BETWEEN TO_DATE('$startDate 00:00:00', 'YYYY/MM/DD HH24:MI:SS') AND TO_DATE('$endDate 23:59:59',  'YYYY/MM/DD HH24:MI:SS')";
        } elseif ($ListeruserId == "US") {
            $main_query = "SELECT COUNT(1) AS TOTAL_LISTING, '$'|| SUM(LIST_AMT) AS TOTAL_PRICE FROM ( SELECT E.EBAY_ITEM_ID, SUM(E.LIST_QTY * E.LIST_PRICE) LIST_AMT FROM EBAY_LIST_MT E WHERE E.LZ_SELLER_ACCT_ID IS NOT NULL AND E.LISTER_ID IN (SELECT EMPLOYEE_ID FROM EMPLOYEE_MT WHERE LOCATION = 'US') AND E.LIST_DATE BETWEEN TO_DATE('$startDate 00:00:00', 'YYYY/MM/DD HH24:MI:SS') AND TO_DATE('$endDate 23:59:59',  'YYYY/MM/DD HH24:MI:SS')";
        }
        $qry_condition = "";
        if ($radiobtn == 2) {
            $qry_condition = " AND E.LZ_SELLER_ACCT_ID =2";
        } elseif ($radiobtn == 1) {
            $qry_condition = " AND E.LZ_SELLER_ACCT_ID =1";
        } elseif ($radiobtn == 'Both') {
            $qry_condition = "AND E.LZ_SELLER_ACCT_ID IN(1,2)";
        }
        $query = $this->db->query($main_query . " " . $qry_condition . "GROUP BY E.EBAY_ITEM_ID ORDER BY E.LIST_DATE DESC)");
        return $query->result_array();
    }



    // /********************************
    //  *  end Screen Lister View
    //  *********************************/


    // /********************************
    //  * start Screen Add Info
    //  *********************************/
    public function Filter_Data_Item_Return_add_info()
    {

        $radio_value = $this->input->post('radio_value');
        $check_box = $this->input->post('filterdata_radio');
        //    print_r($check_box);
        //    exit();
        $search_data = $this->input->post('search_data');
        $show_filter = $this->input->post('show_filter');
        $show_90 = $this->input->post('older_90');
        // if ($check_box) {
        // if ($check_box == '0') {
        //     $retunData = $this->db->query("SELECT g.return_id from lz_salesload_det g  where g.sales_record_number = '$search_data'")->result_array();


        if ($show_90 == 'true') {
            $qry = "select d.*, '$' || total_price total_price, m.lz_seller_acct_id
        from lz_salesload_det d , lz_salesload_mt m
       where d.lz_saleload_id = m.lz_saleload_id
       and d.inserted_date >= sysdate - 90 ";
        } else {
            $qry = "select d.*, '$' || total_price total_price, m.lz_seller_acct_id
        from lz_salesload_det d , lz_salesload_mt m
       where d.lz_saleload_id = m.lz_saleload_id ";
        }
        $cam = '';
        if ($radio_value == 'Like') {
            $cam = 'LIKE';
            $perc = '%';
        } else {
            $cam = '=';
            $perc = '';
        }

        if ($show_filter == 'true') {
            // var_dump(empty($check_box));exit;
            if ($check_box !== null) {


                if ($check_box == '0') {


                    $qry .= "and d.sales_record_number $cam '$perc$search_data$perc'";
                }
                if ($check_box == '1') {

                    $qry .= "and d.extendedorderid $cam '$perc$search_data$perc'";
                }
                if ($check_box == '2') {

                    $qry .= "and d.item_id $cam '$perc$search_data$perc'";
                }

                if ($check_box == '3') {

                    $qry .= "and d.tracking_number  $cam '$perc$search_data$perc'";
                }
            }
        } else {

            $filter_value = $this->input->post('filter_value');




            if ($filter_value['value'] !== null) {
                //var_dump($filter_value['value']); exit;
                $field = $filter_value['value'];
                $data = trim($search_data);
                $str = explode(' ', $data);
                $w = count($str);
                //var_dump($filter_value['value']);exit;
                $i = 1;
                if ($w > 1) {
                    foreach ($str as $val) {
                        $key = strtoupper(trim($val));
                        if ($i === 1) {
                            $startbreket = '(';
                        } else {
                            $startbreket = '';
                        }
                        if ($i === $w) {
                            $endbraket = ')';
                        } else {
                            $endbraket = '';
                        }

                        $qry .= "and  $startbreket upper(d.$field) $cam '$perc$key$perc' $endbraket";

                        if ($i === 1) {
                            $qry .= "and  $startbreket upper(d.$field) $cam '$perc$key$perc' $endbraket";
                        } else {
                            $qry .= " and  $startbreket upper(d.$field) $cam '$perc$key$perc' $endbraket";
                        }
                        // }

                        $i++;
                    }
                } else {
                    if ($cam == 'LIKE') {
                        foreach ($str as $val) {
                            $key = strtoupper(trim($val));
                            if ($field == 'buyer_address1') {

                                $qry .= "and  $startbreket upper(d.buyer_address1) $cam '$perc$key$perc' $endbraket";
                                $qry .= "and  $startbreket upper(d.buyer_address2) $cam '$perc$key$perc' $endbraket";
                                $qry .= "and  $startbreket upper(d.ship_to_address1) $cam '$perc$key$perc' $endbraket";
                                $qry .= "and  $startbreket upper(d.ship_to_address2) $cam '$perc$key$perc' $endbraket";
                            } else {

                                $qry .= "and upper(d.$field) $cam '$perc$key$perc'";
                            }


                            $i++;
                        }
                    } else {
                        if ($field == 'buyer_address1') {

                            $qry .= "and  $startbreket upper(d.buyer_address1) $cam '$perc$str$perc' $endbraket";
                            $qry .= "and  $startbreket upper(d.buyer_address2) $cam '$perc$str$perc' $endbraket";
                        } else {

                            $qry .= "and upper(d.$field) $cam '$perc$str$perc'";
                        }
                    }
                }
            }
        }
        $data = $this->db->query($qry)->result_array();
        if ($show_filter == 'true') {
            $group_id = "";
            if ($radio_value !== 'Like') {
                if ($show_90 == 'true') {
                    $qry = "select d.*, '$' || total_price total_price, m.lz_seller_acct_id
                from lz_salesload_det d , lz_salesload_mt m
               where d.lz_saleload_id = m.lz_saleload_id
               and d.inserted_date >= sysdate - 90 ";
                } else {
                    $qry = "select d.*, '$' || total_price total_price, m.lz_seller_acct_id
                from lz_salesload_det d , lz_salesload_mt m
               where d.lz_saleload_id = m.lz_saleload_id ";
                }
                foreach ($data as $key => $value) {
                    $group_id = $value['SALES_RECORD_NO_GROUP'];
                    if (!empty($value['SALES_RECORD_NO_GROUP'])) {

                        $qry .= "and  ( upper(d.SALES_RECORD_NO_GROUP) = '$group_id' )";
                    }
                }
            }
            if (!empty($group_id)) {
                $data = $this->db->query($qry)->result_array();
            }
        }
        // echo "<pre>";
        // print_r($data);
        // exit;
        $mesages = '';
        foreach ($data as $key => $value) {
            if (!empty($value['RETURN_ID'])) {
                $data[$key]['RETURN_ID_STATUS'] = "TRUE";
                $mesages = 'Return Already Processed';
            } else {
                $data[$key]['RETURN_ID_STATUS'] = "FALSE";
                // $mesages = 'No Cancel Or Return Id';
            }
            if (!empty($value['CANCEL_ID'])) {
                $data[$key]['CANCEL_ID_STATUS'] = "TRUE";
                $mesages = 'Item Already Canceled';
            } else {
                $data[$key]['CANCEL_ID_STATUS'] = "FALSE";
                //$mesages = 'No Cancel Or Return Id';
            }
            if (empty($value['CANCEL_ID']) && empty($value['RETURN_ID'])) {
                $mesages = 'No Cancel And No Return iid';
            }
        }


        //else {

        //     $mesages = 'No Return And No Canceled Id';
        // }

        if ($data) {
            return array("data" => $data,  'status' => true, 'mesages' => $mesages);
        } else {
            return array("data" => array(), 'status' => false, 'mesages' => '');
        }
    }


    public function add_tracking_no()
    {
        $tracking = $this->input->post('tracking');
        $orderid = $this->input->post('orderid');
        $user_id = $this->input->post('user_id');
        $data = $this->db->query("UPDATE lz_salesload_det set TRACKING_NUMBER='$tracking',TRACKING_BY='$user_id' , TRACKING_DATE=sysdate  where ORDER_ID='$orderid' ");
        if ($data) {
            return array('data' => $data, 'status' => true, 'message' => 'Inserted Secessfuly');
        } else {
            return array('status' => false);
        }
    }
    public function local_pic_up()
    {
        $oerderid = $this->input->post('oerderid');
        $user_id = $this->input->post('user_id');
        // var_dump( $user_id); exit;


        $data = $this->db->query("UPDATE lz_salesload_det set TRACKING_NUMBER='00000000000000000000000',TRACKING_BY='$user_id' , TRACKING_DATE= sysdate  where ORDER_ID='$oerderid' ");
        $get_data = $this->db->query("SELECT LZ_SALESLOAD_DET_ID FROM lz_salesload_det where LZ_SALESLOAD_DET_ID = (SELECT max(LZ_SALESLOAD_DET_ID) from lz_salesload_det)")->result_array();
        //$data = $this->db->query($get_data)->;
        $tableData = $get_data[0]['LZ_SALESLOAD_DET_ID'];
        // print_r($tableData);
        // exit;
        // $tableData = $this->db->query(" SELECT A.ser_rate_id , A.service_id, A.service_type, A.Charges, A.created_by, TO_CHAR(A.created_date, 'DD-MM-YYYY HH24:MI:SS') created_date, c.service_desc, B.USER_NAME from lj_services c, lj_service_rate A , EMPLOYEE_MT B WHERE B.EMPLOYEE_ID = A.CREATED_BY and c.service_id=A.service_id and A.SER_RATE_ID = '$tableData'")->result_array();
        $tableData = $this->db->query(" SELECT s.*,s.TRACKING_NUMBER from lz_salesload_det s  WHERE  s.LZ_SALESLOAD_DET_ID = '$tableData' order by LZ_SALESLOAD_DET_ID DESC ")->result_array();
        if ($data) {
            return array('data' => $data, 'data1' => $tableData, 'status' => true, 'message' => 'Inserted Secessfuly');
        } else {
            return array('status' => false, 'data' => []);
        }
    }

    // /********************************
    //  * end Screen Add Info
    //  *********************************/

    // /********************************
    //  * start Screen call log
    //  *********************************/

    public function Get_State()
    {
        $city_id = $this->input->post('Citydrop');
        $city_id = $city_id['value'];
        $state_id = $this->db->query("SELECT STATE_ID FROM WIZ_CITY_MT C WHERE C.CITY_ID = '$city_id'")->result_array();
        $state_id = $state_id[0]['STATE_ID'];
        $state_query = $this->db->query("SELECT * FROM WIZ_STATE_MT C WHERE C.STATE_ID = '$state_id'");
        $state_query = $state_query->result_array();
        if (count($state_query) > 0) {
            return array("status" => true, "state" => $state_query);
        } else {
            return array("status" => false, "state" => array());
        }
    }
    public function Get_State_single()
    {

        $state_id = $this->db->query("SELECT d.state_id , d.state_desc FROM WIZ_STATE_MT d")->result_array();

        return array("status" => true, "state" => $state_id);
    }
    public function Get_City_single()
    {

        $state_id = $this->db->query("SELECT f.city_id, f.city_desc from WIZ_CITY_MT f")->result_array();

        return array("status" => true, "state" => $state_id);
    }

    public function Call_log_save()
    {
        $name = $this->input->post('name');
        // $data=explode(" ",$name);
        $name1 = ucwords($name);
        $date = $this->input->post('date');
        $contact = $this->input->post('contact');
        $Sourcedrop = $this->input->post('Sourcedrop');
        $StateDrop = $this->input->post('StateDrop');
        $Type_Drop = $this->input->post('Type_Drop');
        $Citydrop = $this->input->post('Citydrop');
        $Remarks = $this->input->post('Remarks');
        $Description = $this->input->post('Description');
        $userid = $this->input->post('userid');
        $Adress = $this->input->post('Adress');
        $Price = $this->input->post('Price');
        $fromdate = new DateTime($date);
        $checkissuedate2 = date_format($fromdate, 'Y-m-d H:i');
        $qry = $this->db->query("INSERT INTO  lzw_call_log( LOG_ID, CONTACT_NO,CALL_TYPE,CALL_SOURCE, NAME,ITEM_DESC,ADDRESS,CITY_ID, STATE_ID,CALL_DATE, INSERT_DATE,INSERT_BY,REMARKS, PRICE) values (get_single_primary_key('lzw_call_log','LOG_ID'),'$contact','$Type_Drop','$Sourcedrop','$name1','$Description','$Adress','$Citydrop','$StateDrop',TO_DATE('$checkissuedate2','yyyy-mm-dd HH24:MI:SS'),sysdate,'$userid', '$Remarks', '$Price')");
        $tableData = $qry;
        $get_data = $this->db->query("SELECT LOG_ID FROM lzw_call_log where LOG_ID = (SELECT max(LOG_ID) from lzw_call_log)")->result_array();
        //$data = $this->db->query($get_data)->;
        $tableData = $get_data[0]['LOG_ID'];
        // print_r($tableData);
        // exit;
        // $tableData = $this->db->query(" SELECT A.ser_rate_id , A.service_id, A.service_type, A.Charges, A.created_by, TO_CHAR(A.created_date, 'DD-MM-YYYY HH24:MI:SS') created_date, c.service_desc, B.USER_NAME from lj_services c, lj_service_rate A , EMPLOYEE_MT B WHERE B.EMPLOYEE_ID = A.CREATED_BY and c.service_id=A.service_id and A.SER_RATE_ID = '$tableData'")->result_array();
        $tableData1 = $this->db->query(" SELECT a.LOG_ID,
        a.CONTACT_NO,
        a.CALL_TYPE,
        a.CALL_SOURCE,
        a.NAME,
        a.ITEM_DESC,
        a.ADDRESS,
        a.CITY_ID,
        a.STATE_ID,
        to_char(a.CALL_DATE,'yyyy-mm-dd HH24:MI') CALL_DATE,
        a.INSERT_DATE,
        a.INSERT_BY,
        a.REMARKS,
        '$' || a.PRICE PRICE,
        s.city_desc,
        f.state_desc
   from lzw_call_log a, WIZ_CITY_MT s, WIZ_STATE_MT f
  where s.city_id(+) = a.city_id
    and f.state_id(+) = a.state_id and LOG_ID = '$tableData' order by CALL_DATE DESC ")->result_array();
        // foreach ($tableData1 as $key => $value) {
        //     $tableData1[$key]['NAME'] = ucwords($value['NAME']);
        // }
        if ($tableData1) {
            return array('data' => $tableData1, 'state' => true);
        } else {
            return array('data' => '', 'state' => false);
        }
    }
    public function call_log_save_all()
    {
        $tableData = $this->db->query("SELECT a.LOG_ID,
        a.CONTACT_NO,
        a.CALL_TYPE,
        a.CALL_SOURCE,
        a.NAME,
        a.ITEM_DESC,
        a.ADDRESS,
        a.CITY_ID,
        a.STATE_ID,
        to_char(a.CALL_DATE,'yyyy-mm-dd HH24:MI') CALL_DATE,
        a.INSERT_DATE,
        a.INSERT_BY,
        a.REMARKS,
        '$' || a.PRICE PRICE,
        s.city_desc,
        f.state_desc
   from lzw_call_log a, WIZ_CITY_MT s, WIZ_STATE_MT f
  where s.city_id(+) = a.city_id
    and f.state_id(+) = a.state_id order by CALL_DATE DESC")->result_array();

        // foreach ($tableData as $key => $value) {
        //     $tableData[$key]['NAME'] = ucwords($value['NAME']);
        // }
        return array('data' => $tableData, 'state' => true);
    }
    public function delete_log()
    {
        $logId = $this->input->post('id');
        $tableData = $this->db->query(" DELETE  from lzw_call_log  where  LOG_ID='$logId'");
        return  $tableData;
    }
    public function update_call_log()
    {

        $logId = $this->input->post('LOG_ID');
        $ContactNumber_update = $this->input->post('ContactNumber_update');
        $name_update = $this->input->post('name_update');
        $Sourcedrop_update = $this->input->post('Sourcedrop_update');
        $Type_Drop_update = $this->input->post('Type_Drop_update');
        $Description_update = $this->input->post('Description_update');
        $Adress_update = $this->input->post('Adress_update');
        $Citydrop_update = $this->input->post('Citydrop_update');

        if (array_key_exists('value', $Citydrop_update)) {
            $Citydrop_update1 = $Citydrop_update['value'];
        } else {
            $Citydrop_update1 = "";
        }
        $StateDrop_update = $this->input->post('StateDrop_update');
        if (array_key_exists('value', $StateDrop_update)) {
            $StateDrop_update1 = $StateDrop_update['value'];
        } else {
            $StateDrop_update1 = "";
        }



        $date_update = $this->input->post('date_update');
        $Remarks_update = $this->input->post('Remarks_update');
        $userid = $this->input->post('userid');
        $Price_update = $this->input->post('Price_update');
        $fromdate = new DateTime($date_update);
        $checkissuedate2 = date_format($fromdate, 'Y-m-d H:i');
        //var_dump($Citydrop_update1);exit;
        $data = $this->db->query(" UPDATE lzw_call_log set CONTACT_NO ='$ContactNumber_update',CALL_TYPE='$Type_Drop_update',CALL_SOURCE='$Sourcedrop_update', NAME='$name_update',ITEM_DESC='$Description_update',ADDRESS='$Adress_update',CITY_ID='$Citydrop_update1', STATE_ID='$StateDrop_update1',CALL_DATE= TO_DATE('$checkissuedate2','yyyy-mm-dd HH24:MI:SS'), INSERT_DATE=sysdate,INSERT_BY='$userid',REMARKS='$Remarks_update', PRICE='$Price_update'  where  LOG_ID='$logId'");

        return $data;
    }
    // /********************************
    //  * end Screen call log
    //  *********************************/
    // /********************************
    //  * start Screen Listed Barcode
    //  *********************************/

    public function get_offerUp()
    {
        $data = $this->db->query("SELECT * from lz_portal_mt p  where p.portal_id IN ('9', '12', '11') ")->result_array();
        return array('data' => $data, 'status' => true);
    }
    public function get_conditionArray()
    {
        $data = $this->db->query("SELECT d.id, d.cond_name from lz_item_cond_mt d")->result_array();
        return array('data' => $data, 'status' => true);
    }
    public function Get_listed_barcode()
    {
        $barcode = $this->input->post('barcodeNo');
        $data = $this->db->query("SELECT *
        FROM (SELECT 'DEKIT ITEM' BAROCDE_TYPE,
                     DECODE(D.LZ_MANIFEST_DET_ID, NULL, 'PENDING', 'POSTED') VERIFY_ITEM,
                     D.LZ_DEKIT_US_DT_ID,
                     D.BARCODE_PRV_NO,
                     C.COND_NAME,
                     C.ID,
                     O.OBJECT_NAME,
                     O.OBJECT_ID,
                     D.PIC_DATE_TIME,
                     D.PIC_BY,
                     D.PIC_NOTES,
                     DECODE(D.MPN_DESCRIPTION,
                            NULL,
                            CA.MPN_DESCRIPTION,
                            D.MPN_DESCRIPTION) MPN_DESC,
                     CA.MPN,
                     CA.UPC,
                     CA.BRAND,
                     TO_CHAR(D.FOLDER_NAME) FOLDER_NAME,
                     D.DEKIT_REMARKS REMARKS,
                     D.LZ_MANIFEST_DET_ID,
                     CA.CATEGORY_ID,
                     TO_CHAR(D.AVG_SELL_PRICE) AVG_PRIC
                FROM LZ_DEKIT_US_DT   D,
                     LZ_BD_OBJECTS_MT O,
                     LZ_CATALOGUE_MT  CA,
                     LZ_ITEM_COND_MT  C
               WHERE D.OBJECT_ID = O.OBJECT_ID(+)
                 AND D.CATALOG_MT_ID = CA.CATALOGUE_MT_ID(+)
                 AND D.CONDITION_ID = C.ID(+)
              UNION ALL
              SELECT 'SPECIAL LOT' BAROCDE_TYPE,
                     DECODE(L.LZ_MANIFEST_DET_ID, NULL, 'PENDING', 'POSTED') VERIFY_ITEM,
                     L.SPECIAL_LOT_ID,
                     L.BARCODE_PRV_NO,
                     C.COND_NAME,
                     C.ID,
                     OB.OBJECT_NAME,
                     OB.OBJECT_ID,
                     L.PIC_DATE_TIME,
                     L.PIC_BY,
                     L.PIC_NOTES,
                     DECODE(L.MPN_DESCRIPTION,
                            NULL,
                            CA.MPN_DESCRIPTION,
                            L.MPN_DESCRIPTION) MPN_DESC,
                     DECODE(L.CARD_MPN, NULL, CA.MPN, L.CARD_MPN) MPN,
                     DECODE(L.CARD_UPC, NULL, CA.UPC, L.CARD_UPC) UPC,
                     DECODE(L.BRAND, NULL, CA.BRAND, L.BRAND) BRAND,
                     TO_CHAR(L.FOLDER_NAME) FOLDER_NAME,
                     L.LOT_REMARKS REMARKS,
                     L.LZ_MANIFEST_DET_ID,
                     CA.CATEGORY_ID,
                     TO_CHAR(l.AVG_SOLD) AVG_PRIC
                FROM LZ_SPECIAL_LOTS  L,
                     LZ_BD_OBJECTS_MT OB,
                     LZ_ITEM_COND_MT  C,
                     LZ_CATALOGUE_MT  CA
               WHERE L.OBJECT_ID = OB.OBJECT_ID(+)
                 AND L.CONDITION_ID = C.ID(+)
                 AND L.CATALOG_MT_ID = CA.CATALOGUE_MT_ID(+)
               ORDER BY LZ_MANIFEST_DET_ID NULLS FIRST)
       WHERE BARCODE_PRV_NO = '$barcode'")->result_array();
        if ($data) {
            return array('data' => $data, 'status' => true);
        } else {
            return array('data' => '', 'status' => false);
        }
    }

    public function Get_Image_DecodeBase64()
    {

        $barocde_no = $this->input->post('barcodeNo');
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
                $uri[$i] = 'http://71.78.236.20/' . $withoutMasterPartUri;

                $i++;
            }
        }

        //var_dump($dekitted_pics);exit;
        return array('uri' => $uri);
    }

    public function Save_listed_barcode()
    {

        $title = $this->input->post('Title');
        $cond = $this->input->post('Condition');
        $cond_id = $cond['value'];
        $cond_name = $cond['label'];
        $brand = $this->input->post('Brand');
        $mpn = $this->input->post('Mpn');
        $upc = $this->input->post('UPC');
        $barcode_no = $this->input->post('barcode_no');
        $data = $this->db->query("SELECT BARCODE_NO from lj_classified_ad_mt where BARCODE_NO= '$barcode_no'")->result_array();
        // echo "haji fucking fuck";
        // exit();
        if (count($data) == 0) {
            // echo "kjhdsfkjhdsa";
            // exit();
            $qry = $this->db->query("INSERT INTO  lj_classified_ad_mt( AD_ID, ITEM_DESC,CONDITION_ID,CONDITION_NAME, BRAND,MPN,UPC, PIC_DIR,BARCODE_NO) values (get_single_primary_key('lj_classified_ad_mt','AD_ID'),'$title','$cond_id','$cond_name','$brand','$mpn','$upc','$barcode_no','$barcode_no')");
            $tableData = $qry;
            $get_data = $this->db->query("SELECT AD_ID FROM lj_classified_ad_mt where AD_ID = (SELECT max(AD_ID) from lj_classified_ad_mt)")->result_array();
            $tableData = $get_data[0]['AD_ID'];

            $tableData1 = $this->db->query(" SELECT C.AD_ID, C.ITEM_DESC,C.CONDITION_ID,C.CONDITION_NAME, C.BRAND,C.MPN,C.UPC, C.PIC_DIR,C.BARCODE_NO BARCODE_PRV_NO,
            NVL(P.OFFERUP, 0) OFFERUP,
            NVL(P.FB, 0) fb,
            NVL(P.CRAIGLIST, 0) CRAIGLIST
       FROM LJ_CLASSIFIED_AD_MT C, lj_listed_ad_portals P
      WHERE C.AD_ID = P.AD_ID(+)
      and C.AD_ID ='$tableData' order by C.AD_ID DESC ")->result_array();
            // $this-get_listed_barcode_all();

            if ($tableData1) {
                $qyer = "SELECT C.AD_ID, C.ITEM_DESC,C.CONDITION_ID,C.CONDITION_NAME, C.BRAND,C.MPN,C.UPC, C.PIC_DIR,C.BARCODE_NO BARCODE_PRV_NO,
                NVL(P.OFFERUP, 0) OFFERUP,
                NVL(P.FB, 0) fb,
                NVL(P.CRAIGLIST, 0) CRAIGLIST
           FROM LJ_CLASSIFIED_AD_MT C, lj_listed_ad_portals P
          WHERE C.AD_ID = P.AD_ID(+) order by C.AD_ID DESC";

                $qyer = $this->db->query($qyer)->result_array();

                if (count($qyer) >= 1) {

                    $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array();
                    $uri = $this->get_identiti_bar_pics($qyer, $conditions);
                    $images = $uri['uri'];

                    foreach ($qyer as $key => $value) {

                        $qyer[$key]['MPN'] = str_replace('-', ' ', $value['MPN']);
                    }
                    // return array("images" => $images, 'query' => $qyer);
                }
                return array('data' => $qyer, "images" => $images, 'state' => true);
            } else {
                return array('data' => $qyer, 'state' => false);
            }
        } else {
            return array('data' => '', 'state' => false, 'message' => 'Barcode Already Exist');
        }
    }

    public function get_listed_barcode_all()
    {
        $qyer = "SELECT C.AD_ID, C.ITEM_DESC,C.CONDITION_ID,C.CONDITION_NAME, C.BRAND,C.MPN,C.UPC, C.PIC_DIR,C.BARCODE_NO BARCODE_PRV_NO,
        NVL(P.OFFERUP, 0) OFFERUP,
        NVL(P.FB, 0) fb,
        NVL(P.CRAIGLIST, 0) CRAIGLIST
   FROM LJ_CLASSIFIED_AD_MT C, lj_listed_ad_portals P
  WHERE C.AD_ID = P.AD_ID(+) order by C.AD_ID DESC";

        $qyer = $this->db->query($qyer)->result_array();

        if (count($qyer) >= 1) {

            $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array();
            $uri = $this->get_pictures_by_barcode($qyer, $conditions);
            $images = $uri['uri'];

            foreach ($qyer as $key => $value) {

                $qyer[$key]['MPN'] = str_replace('-', ' ', $value['MPN']);
            }
            return array("images" => $images, 'query' => $qyer);
        } else {
            return array('images' => [], 'query' => [], 'exist' => false);
        }
    }


    public function get_pictures_by_barcode($barcodes,$conditions){

        $path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 2");
        $path = $path->result_array(); 
        
        $master_path = $path[0]["MASTER_PATH"];
        $uri = array();
        $base_url = 'http://'.$_SERVER['HTTP_HOST'].'/';
        foreach($barcodes as $barcode){
        
        $bar = $barcode['BARCODE_NO'];
        
        $getFolder = $this->db->query("SELECT LOT.FOLDER_NAME FROM LZ_SPECIAL_LOTS LOT WHERE LOT.BARCODE_PRV_NO = '$bar' ")->result_array();
        $folderName = "";
        if($getFolder){
        $folderName = $getFolder[0]['FOLDER_NAME'];
        }else{
        $folderName = $bar;
        }
        
        
        $dir = "";
        $barcodePictures = $master_path.$folderName."/";
        $barcodePicturesThumb = $master_path.$folderName."/thumb"."/";
        
        if (is_dir($barcodePictures)){
        $dir = $barcodePictures;
        }else if(is_dir($barcodePicturesThumb)){
        $dir = $barcodePicturesThumb;
        } 
        
        if(!is_dir($dir)){
        $getBarcodeMt = $this->db->query("SELECT SD.F_UPC UPC, SD.F_MPN MPN
        FROM LZ_BARCODE_MT BM, LZ_ITEM_SEED SD
        WHERE BM.ITEM_ID = SD.ITEM_ID
        AND BM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID
        AND BM.CONDITION_ID = SD.DEFAULT_COND
        AND BM.BARCODE_NO = '$bar'
        ")->result_array();
        $upc = "";
        $mpn = "";
        if($getBarcodeMt){
        $upc = $getBarcodeMt[0]['UPC'];
        $mpn = $getBarcodeMt[0]['MPN'];
        }
        
        $path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
        $path = $path->result_array(); 
        
        $upc_mpn_master_path = $path[0]["MASTER_PATH"];
        
        $mpn = str_replace("/","_",$mpn);
        foreach($conditions as $cond){
        $dir = $upc_mpn_master_path.$upc."~".$mpn."/".$cond['COND_NAME']."/";
        $dirWithMpn = $upc_mpn_master_path."~".$mpn."/".$cond['COND_NAME']."/";
        $dirWithUpc = $upc_mpn_master_path.$upc."~/".$cond['COND_NAME']."/";
        if (is_dir($dir)){
        $dir = $dir;
        break;
        }else if(is_dir($dirWithMpn)){
        $dir = $dirWithMpn;
        break;
        }else if(is_dir($dirWithUpc)){
        $dir = $dirWithUpc;
        break;
        }else {
        $dir = $upc_mpn_master_path."/".$cond['COND_NAME']."/";
        }
        
        }
        if($dir == $upc_mpn_master_path."~/".$cond['COND_NAME']."/"){
        $dir = $upc_mpn_master_path."/".$cond['COND_NAME']."/";
        }
        
        }
        $dir = preg_replace("/[\r\n]*/","",$dir);
        
        if (is_dir($dir)){
        $images = glob($dir."\*.{JPG,jpg,GIF,gif,PNG,png,BMP,bmp,JPEG,jpeg}",GLOB_BRACE);
        
        if($images){
        $j=0;
        foreach($images as $image){
        
        $withoutMasterPartUri = str_replace("D:/wamp/www/","",$image);
        $withoutMasterPartUri = preg_replace("/[\r\n]*/","",$withoutMasterPartUri);
        $uri[$bar][$j] = $base_url. $withoutMasterPartUri;
        
        $j++;
        } 
        }else{
        $uri[$bar][0] = $base_url. "item_pictures/master_pictures/image_not_available.jpg";
        $uri[$bar][1] = false;
        }
        }else{
        $uri[$bar][0] = $base_url. "item_pictures/master_pictures/image_not_available.jpg";
        $uri[$bar][1] = false;
        }
        }
        return array('uri'=>$uri);
        }

    public function Save_marcket_place()
    {
        $id_add = $this->input->post('id_add');
        $port_id = $this->input->post('port_id');
        $url = $this->input->post('url');
        $price = $this->input->post('price');
        $dty = $this->input->post('dty');
        $listed_by = $this->input->post('listed_by');
        $LIST_ID = $this->input->post('LIST_ID');
        // var_dump($id_add,$port_id); exit;
        $ckeck_list_id = $this->db->query("SELECT LIST_ID from lj_classified_ad_listing l where l.LIST_ID='$LIST_ID' AND l.AD_ID = '$id_add'and l.portal_id='$port_id'")->result_array();
        if (count($ckeck_list_id) == 0) {

            $ckeck = $this->db->query("SELECT * from lj_classified_ad_listing l where l.ad_id='$id_add' and l.portal_id='$port_id' and l.list_url='$url'")->result_array();
            if (count($ckeck) == 0) {
                $qry = $this->db->query("INSERT INTO  lj_classified_ad_listing( LIST_ID, AD_ID, PORTAL_ID,LISTING_ID,LIST_URL,LIST_DATE,LIST_QTY,LIST_BY,LIST_PRICE ,LIST_STATUS) values (get_single_primary_key('lj_classified_ad_listing','LIST_ID'),'$id_add','$port_id','0','$url',sysdate,'$dty','$listed_by','$price', '1')");

                if ($qry) {
                    return array("data" => $qry, 'status' => true);
                } else {
                    return array("data" => '', 'status' => false);
                }
            } else {
                return array("data" => '', 'status' => false);
            }
        } else {
            $qry = $this->db->query("UPDATE lj_classified_ad_listing set LIST_URL ='$url',LIST_PRICE='$price' where LIST_ID='$LIST_ID'");
            return array("data" => $qry, 'status' => true);
        }
    }
    public function Save_marcket_place_as_sold()
    {
        $Price = $this->input->post('Price');
        $dty = $this->input->post('dty');
        $date = $this->input->post('date');
        $listed_by = $this->input->post('listed_by');
        $LIST_ID = $this->input->post('LIST_ID');
        // var_dump($LIST_ID);exit;
        $fromdate = new DateTime($date);
        $checkissuedate2 = date_format($fromdate, 'Y-m-d H:i');
        $ckeck = $this->db->query("SELECT LIST_ID from lj_classified_ad_sold l where l.LIST_ID='$LIST_ID'")->result_array();
        if (count($ckeck) == 0) {
            $qry = $this->db->query("INSERT INTO  lj_classified_ad_sold( SALE_ID, LIST_ID, SALE_PRICE,SALE_QTY,SALE_DATE,INSERTED_DATE,INSERTED_BY) values (get_single_primary_key('lj_classified_ad_sold','SALE_ID'),'$LIST_ID','$Price','$dty',TO_DATE('$checkissuedate2','yyyy-mm-dd HH24:MI:SS'),sysdate,'$listed_by')");
            if ($qry) {
                return array("data" => $qry, 'status' => true);
            } else {
                return array("data" => '', 'status' => false);
            }
        } else {
            return array("data" => '', 'status' => false);
        }
    }

    public function to_check_list_id()
    {
        $portal_id = $this->input->post('portal_id');
        $add_id = $this->input->post('add_id');
        $qry = $this->db->query("SELECT d.list_id , d.list_url, d.list_price from lj_classified_ad_listing d where d.ad_id='$add_id'and d.portal_id='$portal_id'")->result_array();
        if ($qry) {
            return array("data" => $qry, 'status' => true);
        } else {
            return array("data" => '', 'status' => false);
        }
    }
    public function Get_filter_barcode()

    
    {
        $barcode = $this->input->post('barcode');
        //var_dump( $barcode); exit;
        $qry = "SELECT B.BARCODE_NO BARCODE_PRV_NO,
        TO_CHAR(l.LIST_DATE, 'DD-MM-YYYY HH24:MI:SS') AS LIST_DATE,
        l.LIST_ID,
        l.STATUS,
        '$'|| l.LIST_PRICE LIST_PRICE,
        e.user_name lister_name,
        S.SEED_ID,
        M.SINGLE_ENTRY_ID,
        M.LZ_MANIFEST_ID,
        M.LOADING_NO,
        M.LOADING_DATE,
        M.PURCH_REF_NO,
        B.ITEM_ID,
        d.laptop_item_code,
        S.ITEM_TITLE ITEM_MT_DESC,
        s.f_manufacture MANUFACTURER,
        l.list_qty,
        S.F_MPN MFG_PART_NO,
        S.F_UPC UPC,
        BCD.EBAY_ITEM_ID,
        BCD.CONDITION_ID ITEM_CONDITION,
        BCD.QTY QUANTITY,
        '$'|| BCD.COST_PRICE COST_PRICE,
        C.COND_NAME,
        R.BUISNESS_NAME
        from lz_barcode_mt b,
        ebay_list_mt l,
        employee_mt e,
        lz_manifest_mt m,
        lz_manifest_det d,
        items_mt i,
        lz_item_seed s,
        LZ_ITEM_COND_MT c,
        lj_merhcant_acc_dt a,
        lz_merchant_mt r,
        (SELECT BC.EBAY_ITEM_ID,
        BC.LZ_MANIFEST_ID,
        BC.ITEM_ID,
        BC.CONDITION_ID,
        COUNT(1) QTY,
        max(dt.po_detail_retial_price) COST_PRICE
        FROM LZ_BARCODE_MT BC,
        items_mt i,
        lz_manifest_det dt,
        (select item_id, lz_manifest_id, condition_id
        from lz_barcode_mt
        where barcode_no = '$barcode') bb
        WHERE BC.Item_Id = bb.item_id
        and bc.lz_manifest_id = bb.lz_manifest_id
        and bc.condition_id = bb.condition_id
        and dt.lz_manifest_id = bc.lz_manifest_id
        and dt.laptop_item_code = i.item_code
        and dt.conditions_seg5 = bc.condition_id
        and i.item_id = bc.item_id
        GROUP BY BC.LZ_MANIFEST_ID,
        BC.ITEM_ID,
        BC.CONDITION_ID,
        BC.EBAY_ITEM_ID) bcd
        where b.list_id = l.list_id
        and e.employee_id = l.lister_id
        and m.lz_manifest_id = b.lz_manifest_id
        and d.laptop_item_code = i.item_code
        and d.lz_manifest_id = m.lz_manifest_id
        and b.item_id = i.item_id
        and s.item_id = b.item_id
        and s.lz_manifest_id = b.lz_manifest_id
        and s.default_cond = b.condition_id
        and b.condition_id = c.id
        AND R.MERCHANT_ID = A.MERCHANT_ID
        AND l.LZ_SELLER_ACCT_ID = A.ACCT_ID
        and bcd.item_id = b.item_id
        and bcd.lz_manifest_id = b.lz_manifest_id
        and b.barcode_no ='$barcode'";
           
        
         $qyer = $this->db->query($qry)->result_array();

         if (count($qyer) >= 1) {
 
             $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array();
             $uri = $this->get_identiti_bar_pics($qyer, $conditions);
             $images = $uri['uri'];
 
             foreach ($qyer as $key => $value) {
 
                 $qyer[$key]['MFG_PART_NO'] = str_replace('-', ' ', $value['MFG_PART_NO']);
                  $current_timestamp = date('m/d/Y');
         $purchase_date = $value['LOADING_DATE'];
         $date1=date_create($current_timestamp);
         $date2=date_create($purchase_date);
         $diff=date_diff($date1,$date2);
         $date_rslt = $diff->format("%R%a days");
         $qyer[$key]['LOADING_DATE'] = abs($date_rslt)." Days";
         

             }
            //   print_r($qyer);
             return array("images" => $images, 'query' => $qyer);
         } else {
             return array('images' => [], 'query' => [], 'exist' => false);
         }
    }


      public function deleteItemfromShopify($ebay_id){
    	
    	$qry = $this->db->query("SELECT B.SHOPIFY_LIST_ID FROM LZ_BARCODE_MT B WHERE B.EBAY_ITEM_ID = '$ebay_id' AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND ROWNUM = 1")->result_array();
    	$list_id = @$qry[0]["SHOPIFY_LIST_ID"];

    	$qry2 = $this->db->query("SELECT S.SHOPIFY_ID FROM SHOPIFY_LIST_MT S WHERE S.LIST_ID = '$list_id' ")->result_array();
    	$shopify_id = @$qry2[0]["SHOPIFY_ID"];

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://c084db0733b8db2aef9f2a3a37b7314e:d19b1f6eece15313ce289b80e206286f@k2bay.myshopify.com/admin/products/$shopify_id.json",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "DELETE",
		  CURLOPT_POSTFIELDS => "",
		  CURLOPT_HTTPHEADER => array(
		    "Content-Type: application/json",
		    "Postman-Token: aeb8d737-1fa8-4ef8-b4e9-312f675d0d2e",
		    "cache-control: no-cache"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "Shopify Item Delete Error #:" . $err;
		} else {


			$check_sold = $this->db->query("SELECT S.SHOPIFY_ID FROM SHOPIFY_ORDERS S WHERE S.LINE_ITEMS_PRODUCT_ID =  '$shopify_id'"); 
			if($check_sold->num_rows() > 0){
				$barcode_qry = $this->db->query("UPDATE LZ_BARCODE_MT B SET B.SHOPIFY_LIST_ID = '' WHERE B.SHOPIFY_LIST_ID = '$shopify_id' ");
			}else{
				$barcode_qry = $this->db->query("UPDATE LZ_BARCODE_MT B SET B.SHOPIFY_LIST_ID = '' WHERE B.SHOPIFY_LIST_ID = '$shopify_id' "); 
                $delete_qry = $this->db->query("DELETE FROM SHOPIFY_LIST_MT E WHERE E.SHOPIFY_ID = '$shopify_id'");
                return array("data" => $delete_qry);
				
			}
		  //echo $response;
		}        
    }


    public function endItem(){
        $ebay_id = $this->input->post('ebay_id');
        // check if item sold or not
        $check_sold = $this->db->query("SELECT * FROM LZ_SALESLOAD_DET D WHERE D.ITEM_ID = '$ebay_id'"); 
        if($check_sold->num_rows() > 0){
            $barcode_qry = $this->db->query("UPDATE LZ_BARCODE_MT B SET B.LIST_ID = '',B.EBAY_ITEM_ID='' WHERE B.EBAY_ITEM_ID = '$ebay_id'AND B.SALE_RECORD_NO IS NULL AND B.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND B.LZ_PART_ISSUE_MT_ID IS NULL AND B.LZ_POS_MT_ID IS NULL AND B.PULLING_ID IS NULL");
        }else{
            $barcode_qry = $this->db->query("UPDATE LZ_BARCODE_MT B SET B.LIST_ID = '',B.EBAY_ITEM_ID='' WHERE B.EBAY_ITEM_ID = '$ebay_id'AND B.SALE_RECORD_NO IS NULL AND B.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND B.LZ_PART_ISSUE_MT_ID IS NULL AND B.LZ_POS_MT_ID IS NULL AND B.PULLING_ID IS NULL"); 
    
            $delete_qry = $this->db->query("DELETE FROM LZ_LISTING_ALLOC WHERE LIST_ID IN (SELECT LIST_ID FROM EBAY_LIST_MT E WHERE E.EBAY_ITEM_ID = '$ebay_id')");
    
            $delete_qry = $this->db->query("DELETE FROM EBAY_LIST_MT E WHERE E.EBAY_ITEM_ID = '$ebay_id'");
    
            $delete_url = $this->db->query("DELETE FROM LZ_LISTED_ITEM_URL U WHERE U.EBAY_ID =  '$ebay_id'"); 
    
            
        }
        
        return 1;
        }


        public function holdBarcode(){
            $barcode = $this->input->post('bar');
            $user_id = $this->input->post('user_id');
            $barcodeStatus = 1;
            date_default_timezone_set("America/Chicago");
            $current_date = date("Y-m-d H:i:s");
            $current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";
            $comma = ',';
            
                //foreach($hold_barcode as $barcode){
                    $check_status = $this->db->query("SELECT * FROM LZ_BARCODE_MT WHERE BARCODE_NO =$barcode AND ITEM_ADJ_DET_ID_FOR_IN IS NULL AND LIST_ID IS NULL AND SALE_RECORD_NO IS NULL AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND EBAY_ITEM_ID IS NULL");
                    
                     if($check_status->num_rows()>0){
                        $get_pk = $this->db->query("SELECT get_single_primary_key('LZ_BARCODE_HOLD_LOG','LZ_HOLD_ID') LZ_HOLD_ID FROM DUAL");
                        $get_pk = $get_pk->result_array();
                        $lz_hold_id = $get_pk[0]['LZ_HOLD_ID'];
                            
                        $qry = "INSERT INTO LZ_BARCODE_HOLD_LOG VALUES ($lz_hold_id $comma $barcode $comma $current_date $comma $barcodeStatus $comma $user_id)";
                        $this->db->query($qry);
    
    
                        $hold_qry = "UPDATE LZ_BARCODE_MT SET HOLD_STATUS = $barcodeStatus WHERE BARCODE_NO = $barcode ";
                        $hold_status = $this->db->query($hold_qry);
    
                    }else{
                        $hold_status = true;
                        $barcodeStatus = 2;
                    }
                //}//barcode foreach
            if($hold_status){
                return $barcodeStatus;
            }else {
                return false;
            }
    
        }


        public function unHoldBarcode(){
            $barcode = $this->input->post('barcode_no');
            $barcodeStatus = 0;
            $user_id = $this->session->userdata('user_id');
            date_default_timezone_set("America/Chicago");
            $current_date = date("Y-m-d H:i:s");
            $current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";
            $comma = ',';
            
                //foreach($hold_barcode as $barcode){
                    // $check_status = $this->db->query("SELECT * FROM LZ_BARCODE_MT WHERE BARCODE_NO =$barcode AND HOLD_STATUS = 0");
                    
                    // if($check_status->num_rows()>0){
                        $get_pk = $this->db->query("SELECT get_single_primary_key('LZ_BARCODE_HOLD_LOG','LZ_HOLD_ID') LZ_HOLD_ID FROM DUAL");
                        $get_pk = $get_pk->result_array();
                        $lz_hold_id = $get_pk[0]['LZ_HOLD_ID'];
                            
                        $qry = "INSERT INTO LZ_BARCODE_HOLD_LOG VALUES ($lz_hold_id $comma $barcode $comma $current_date $comma $barcodeStatus $comma $user_id)";
                        $this->db->query($qry);
    
    
                        $hold_qry = "UPDATE LZ_BARCODE_MT SET HOLD_STATUS = $barcodeStatus WHERE BARCODE_NO = $barcode ";
                        $hold_status = $this->db->query($hold_qry);
    
                    // }else{
                    // 	$hold_status = true;
                    // }
                //}//barcode foreach
            if($hold_status){
                return $barcodeStatus;
            }else {
                return false;
            }
    
        }

    // /********************************
    //  * end Screen Listed Barcode
    //  *********************************/

}
