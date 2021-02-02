<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class m_merchant extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_lot_det()
    {

        $lot_id = $this->input->post('lot_id');

        $qur = $this->db->query("SELECT D.LOT_DESC ,D.WEIGHT,D.LOT_ID FROM LOT_DEFINATION_MT D WHERE D.LOT_ID = $lot_id ")->result_array();

        return array('qur' => $qur);

    }

    public function update_lot()
    {

        $weigh = $this->input->post('lot_wight');
        $lot_id_get = $this->input->post('lot_id_get');

        $qur = $this->db->query(" UPDATE LOT_DEFINATION_MT D  SET D.WEIGHT ='$weigh'  WHERE D.LOT_ID = $lot_id_get ");

        if ($qur) {
            return true;
        } else {
            return false;
        }

    }

    public function get_states()
    {

        $stat_query = $this->db->query("SELECT  C.CITY_ID,CITY_DESC FROM WIZ_CITY_MT C WHERE C.STATE_ID > 1004")->result_array();

        $get_merchants = $this->db->query("SELECT  M.MERCHANT_ID,M.CONTACT_PERSON, M.MERCHANT_CODE, M.BUISNESS_NAME, DECODE(M.SERVICE_TYPE,1,'LISTING',2,'PICTURE',3,'WAREHOUSE') SERVICE_TYPE, C.CITY_DESC, ST.STATE_DESC, M.CONTACT_NO, M.ADDRESS, M.ACTIVE_FROM, M.ACTIVE_TO, M.ACTIVE_STATUS FROM LZ_MERCHANT_MT M,WIZ_CITY_MT C,WIZ_STATE_MT ST WHERE  M.STATE_ID = C.CITY_ID(+) AND C.STATE_ID = ST.STATE_ID(+) ORDER BY M.MERCHANT_ID asc")->result_array();

        return array('stat_query' => $stat_query, 'get_merchants' => $get_merchants);
    }

    public function get_total_bar()
    {

        $avail_lot_id = $this->input->post('avail_lot_id');

        $tot_quer = $this->db->query("SELECT COUNT(K.BARCODE_NO) TOTAL_BAR, '$ '||ROUND(NVL(MAX(DE.COST),0),2) COST_LOT, MAX(DE.WEIGHT) WEIGH, '$ '|| ROUND(NVL(MAX(DE.COST) / MAX(DE.WEIGHT), 0),2) COST_PER_LBS, '$ '|| ROUND(NVL(MAX(DE.COST) / COUNT(K.BARCODE_NO), 0), 2) AVG_AMOUNT FROM LZ_MERCHANT_BARCODE_MT M, LZ_MERCHANT_BARCODE_DT K,LOT_DEFINATION_MT DE WHERE M.LOT_ID = $avail_lot_id AND M.MT_ID = K.MT_ID AND M.LOT_ID = DE.LOT_ID ")->result_array();
        return array('tot_quer' => $tot_quer);
    }

    public function update_merchant_view()
    {
        $merch_id = $this->uri->segment(4);

        $get_merchants = $this->db->query("SELECT  M.MERCHANT_ID,M.CONTACT_PERSON, M.MERCHANT_CODE, M.BUISNESS_NAME, DECODE(M.SERVICE_TYPE,1,'LISTING',2,'PICTURE',3,'WAREHOUSE') SERVICE_TYPE, C.CITY_ID,C.CITY_DESC, ST.STATE_DESC, M.CONTACT_NO, M.ADDRESS, M.ACTIVE_FROM, M.ACTIVE_TO, M.ACTIVE_STATUS FROM LZ_MERCHANT_MT M,WIZ_CITY_MT C,WIZ_STATE_MT ST WHERE  M.STATE_ID = C.CITY_ID(+) AND C.STATE_ID = ST.STATE_ID(+) AND M.MERCHANT_ID = $merch_id ORDER BY M.MERCHANT_ID asc")->result_array();

        return array('get_merchants' => $get_merchants);
    }

    public function save_merch_lot()
    {
        $lot_desc = $this->input->post('lot_desc');
        $purch_date = $this->input->post('purch_date');
        $purch_date = date_create($purch_date);
        $get_purch_date = date_format(@$purch_date, 'm/d/y'); /// purchase date get

        $purch_date = $this->input->post('purch_date');
        $lot_mini_prof = $this->input->post('lot_mini_prof');
        $lot_cost = $this->input->post('lot_cost');
        $lot_sourc = $this->input->post('lot_sourc');
        $est_reques = $this->input->post('est_reques');
        $part_lis = $this->input->post('part_lis');
        $lis_Cost = $this->input->post('lis_Cost');
        $appr_list = $this->input->post('appr_list');
        $lot_ref = $this->input->post('lot_ref');
        $merchant_id = $this->input->post("mer_name");
        // $merchant_id = $this->session->userdata('merchant_id');

        $get_lot_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LOT_DEFINATION_MT', 'LOT_ID')ID FROM DUAL")->result_array();
        $get_lot_pk = $get_lot_pk[0]['ID'];

        $qry = $this->db->query("INSERT INTO LOT_DEFINATION_MT(LOT_ID, REF_NO, PURCHASE_DATE, ASSIGN_DATE, COST, PROFIT_REQUIRE, SOURCE, EST_REQUEST, PARTIAL_LIST, LINE_ITEM_COST_AVAIL, APPROVAL_REQUIRE,EST_SHIP_SERVIC,LOT_DESC,MERCHANT_ID)values($get_lot_pk,'$lot_ref',TO_DATE('$get_purch_date', 'mm/dd/yyyy/'),sysdate,$lot_cost,$lot_mini_prof,'$lot_sourc',$est_reques,$part_lis,$lis_Cost,$appr_list,'','$lot_desc' ,'$merchant_id' )");

        if ($qry) {
            return true;

        } else {

            return false;
        }

    }

    public function merchant_lot_details()
    {

        $merch = $this->db->query("SELECT MA.LOT_ID, MA.REF_NO, MA.weight,MA.PURCHASE_DATE, MA.ASSIGN_DATE, MA.COST, MA.PROFIT_REQUIRE, MA.SOURCE, DECODE(MA.EST_REQUEST,'1','YES','NO') ESTIMATE_REQUEST, DECODE(MA.PARTIAL_LIST,'1','YES','NO') PARTIAL_LIST, DECODE(MA.LINE_ITEM_COST_AVAIL,'1','YES','NO') LINE_ITEM_COST_AVAIL, DECODE(MA.APPROVAL_REQUIRE,'1','YES','NO') APPROVAL_REQUIRE, MA.EST_SHIP_SERVIC, MA.LOT_DESC, DECODE(MA.LOT_STATUS,'1','COMPLETED','2','PENDING','3','DISCARD') LOT_STATUS FROM LOT_DEFINATION_MT MA ORDER BY MA.LOT_ID DESC")->result_array();

        return array('merch' => $merch);
    }

    public function save_merchant()
    {

        $murch_name = $this->input->post('murch_name');
        $buis_name = $this->input->post('buis_name');
        $merch_add = $this->input->post('merch_add');
        $merch_phon = $this->input->post('merch_phon');
        $merch_act_from = $this->input->post('merch_act_from');
        $merch_act_to = $this->input->post('merch_act_to');
        $merch_servic = $this->input->post('merch_servic_id');
        $stat_id = $this->input->post('stat_id');

        $merchant_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_MERCHANT_MT', 'MERCHANT_ID')ID FROM DUAL")->result_array();
        $merchant_id = $merchant_id[0]['ID'];

        $merch_code = $this->db->query("SELECT lpad(NVL(MAX(Merchant_code + 1), 1),5,0) MERCH_CODE FROM LZ_MERCHANT_MT ")->result_array();
        $gmerch_code = $merch_code[0]['MERCH_CODE'];

        // $dates =$this->db->query("SELECT TO_DATE($merch_act_from, 'YYYY-MM-DD HH24:MI:SS') ACTIV_FROM , TO_DATE($merch_act_to, 'YYYY-MM-DD HH24:MI:SS') ACTIV_TO  FROM DUAL ")->result_array();

        $merch_act_from = date_create($merch_act_from);
        $from = date_format(@$merch_act_from, 'm/d/y');

        $merch_act_to = date_create($merch_act_to);
        $to = date_format(@$merch_act_to, 'm/d/y');

        $query = $this->db->query("INSERT INTO LZ_MERCHANT_MT (MERCHANT_ID, MERCHANT_CODE, BUISNESS_NAME, CONTACT_NO, CONTACT_PERSON, ADDRESS, STATE_ID, SERVICE_TYPE, ACTIVE_FROM, ACTIVE_TO) VALUES ($merchant_id, '$gmerch_code', '$buis_name', $merch_phon, '$murch_name', '$merch_add', '$stat_id', '$merch_servic',TO_DATE('$from', 'mm/dd/yyyy/'),TO_DATE('$to', 'mm/dd/yyyy/'))");

        //  $data = array(
        //    'MERCHANT_ID' => $merchant_id,
        //    'MERCHANT_CODE' => $merch_code,
        //    'BUISNESS_NAME' => $buis_name,
        //    'CONTACT_NO' => $merch_phon,
        //    'CONTACT_PERSON' => $murch_name,
        //    'ADDRESS' => $merch_add,
        //    'STATE_ID' => '',
        //    'SERVICE_TYPE' => $merch_servic,
        //    'ACTIVE_FROM' => $merch_act_from,
        //    'ACTIVE_TO' => $merch_act_to

        //  );
        //  // var_dump($data);
        //  // exit;

        // $query =  $this->db->insert('LZ_MERCHANT_MT', $data);
        if ($query) {
            return true;

        } else {

            return false;
        }

    }

    public function update_merchant()
    {

        $murch_name = $this->input->post('murch_name');
        $buis_name = $this->input->post('buis_name');
        $merch_add = $this->input->post('merch_add');
        $merch_phon = $this->input->post('merch_phon');
        $merch_act_from = $this->input->post('merch_act_from');
        $merch_act_to = $this->input->post('merch_act_to');
        $merch_servic = $this->input->post('merch_servic_id');
        $stat_id = $this->input->post('stat_id');

        $merch_act_from = date_create($merch_act_from);
        $from = date_format(@$merch_act_from, 'm/d/y');

        $merch_act_to = date_create($merch_act_to);
        $to = date_format(@$merch_act_to, 'm/d/y');
        $merch_id = $this->uri->segment(4);

        // $merchant_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_MERCHANT_MT', 'MERCHANT_ID')ID FROM DUAL")->result_array();
        // $merchant_id = $merchant_id[0]['ID']; 60,000 + 25,000 + 30,000 + 20,000

        // $merch_code =$this->db->query("SELECT lpad(NVL(MAX(Merchant_code + 1), 1),5,0) MERCH_CODE FROM LZ_MERCHANT_MT ")->result_array();
        // $gmerch_code = $merch_code[0]['MERCH_CODE'];
        $query = $this->db->query("  UPDATE LZ_MERCHANT_MT M SET M.BUISNESS_NAME = '$buis_name', M.CONTACT_NO = $merch_phon,M.CONTACT_PERSON ='$murch_name', M.ADDRESS ='$merch_add',M.STATE_ID =$stat_id, M.SERVICE_TYPE = '$merch_servic',M.ACTIVE_FROM = TO_DATE('$from', 'MM/DD/YYYY/') ,M.ACTIVE_TO = TO_DATE('$to', 'MM/DD/YYYY/')  WHERE M.MERCHANT_ID = $merch_id ");
        if ($query) {
            return true;

        } else {

            return false;
        }

    }

    public function get_mech_lots()
    {

        $mer_name = $this->input->post('mer_name');

        $get_lot = $this->db->query("SELECT  D.LOT_ID,D.LOT_DESC FROM LOT_DEFINATION_MT D WHERE D.MERCHANT_ID =$mer_name  ")->result_array();

        return array('get_lot' => $get_lot);

    }

    public function print_barcode()
    {
        $bar_range = $this->input->post('bar_range');
        $no_of_barcode = $this->input->post('no_of_barcode');
        $mer_name = $this->input->post('mer_name');
        $user_id = @$this->session->userdata('user_id');
        $merchant_id = $mer_name; // @$this->session->userdata('merchant_id');
        $avail_lot = $this->input->post('avail_lot');
         $seller_account_id = $this->input->post("seller_account");

        $mt_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_MERCHANT_BARCODE_MT', 'MT_ID') ID FROM DUAL")->result_array();
        $mt_id = $mt_id[0]['ID'];

        $this->db->query("INSERT INTO LZ_MERCHANT_BARCODE_MT (MT_ID, MERCHANT_ID, ISSUED_DATE, ISSUED_BY, NO_OF_BARCODE,LOT_ID,RANGE_ID) VALUES ($mt_id, '$merchant_id', sysdate, $user_id , '$no_of_barcode','$avail_lot','$bar_range')");

        for ($i = 1; $i <= $no_of_barcode; $i++) {
            $this->db->query("INSERT INTO LZ_MERCHANT_BARCODE_DT (DT_ID, MT_ID, BARCODE_NO, ACCOUNT_ID) VALUES (GET_SINGLE_PRIMARY_KEY('LZ_MERCHANT_BARCODE_DT', 'DT_ID'), '$mt_id', seq_barcode_no.nextval, '$seller_account_id')");
        }

        return $this->db->query("SELECT B.ISSUED_DATE,B.NO_OF_BARCODE,B.RANGE_ID, D.BARCODE_NO, MM.BUISNESS_NAME,L.LOT_ID,L.LOT_DESC,L.REF_NO FROM LZ_MERCHANT_BARCODE_MT B, LZ_MERCHANT_BARCODE_DT D, LZ_MERCHANT_MT         MM, LOT_DEFINATION_MT L WHERE B.MERCHANT_ID = MM.MERCHANT_ID AND B.MT_ID = D.MT_ID AND B.LOT_ID = L.LOT_ID(+) AND D.MT_ID = $mt_id ORDER BY BARCODE_NO ASC ")->result_array();
    }

    public function printBarcode()
    {
        $dt_id = $this->uri->segment(4);
        return $this->db->query("SELECT B.ISSUED_DATE, D.BARCODE_NO, MM.BUISNESS_NAME,L.LOT_ID,L.LOT_DESC,L.REF_NO FROM LZ_MERCHANT_BARCODE_MT B, LZ_MERCHANT_BARCODE_DT D, LZ_MERCHANT_MT         MM, LOT_DEFINATION_MT L WHERE B.MERCHANT_ID = MM.MERCHANT_ID AND B.MT_ID = D.MT_ID AND B.LOT_ID = L.LOT_ID(+)AND D.DT_ID = $dt_id")->result_array();
    }
    public function printAllBarcode()
    {

        $mt_id = $this->input->post('barcode_mt_id');

        return $this->db->query("SELECT B.ISSUED_DATE,B.NO_OF_BARCODE,B.RANGE_ID, D.BARCODE_NO, MM.BUISNESS_NAME,L.LOT_ID,L.LOT_DESC,L.REF_NO FROM LZ_MERCHANT_BARCODE_MT B, LZ_MERCHANT_BARCODE_DT D, LZ_MERCHANT_MT   MM, LOT_DEFINATION_MT L WHERE B.MERCHANT_ID = MM.MERCHANT_ID AND B.MT_ID = D.MT_ID AND B.LOT_ID = L.LOT_ID(+)AND D.MT_ID = $mt_id ORDER BY BARCODE_NO ASC")->result_array();
    }
    public function gen_barcode()
    {
        //$mt_id = $this->db->query("SELECT B.*, M.BUISNESS_NAME,B.NO_OF_BARCODE,Decode(B.RANGE_ID,1,'Yes',0,'No') RANGE, E.USER_NAME,DE.LOT_DESC,DE.REF_NO FROM LZ_MERCHANT_BARCODE_MT B, LZ_MERCHANT_MT M, EMPLOYEE_MT E,LOT_DEFINATION_MT DE WHERE B.MERCHANT_ID = M.MERCHANT_ID AND B.LOT_ID = DE.LOT_ID(+) AND E.EMPLOYEE_ID = B.ISSUED_BY ORDER BY B.MT_ID DESC");
        $mt_id = $this->db->query("SELECT B.*, M.BUISNESS_NAME, B.NO_OF_BARCODE, Decode(B.RANGE_ID, 1, 'Yes', 0, 'No') RANGE, E.USER_NAME, DE.LOT_DESC, DE.REF_NO, (SELECT MIN(DD.BARCODE_NO) ||'-' || MAX(DD.BARCODE_NO) FROM LZ_MERCHANT_BARCODE_DT DD WHERE DD.MT_ID = B.MT_ID ) RANGE_BARCODE FROM LZ_MERCHANT_BARCODE_MT B, LZ_MERCHANT_MT         M, EMPLOYEE_MT            E, LOT_DEFINATION_MT      DE WHERE B.MERCHANT_ID = M.MERCHANT_ID AND B.LOT_ID = DE.LOT_ID(+) AND E.EMPLOYEE_ID = B.ISSUED_BY ORDER BY B.MT_ID DESC");
        return $mt_id;

    }
    public function avail_lot()
    {
        // $user_id = @$this->session->userdata('user_id');
        echo $merchant_id = $this->input->post('mer_name');
        // if ($user_id == 2) {
        //     $avail_lot = $this->db->query("SELECT LOT_ID , LOT_DESC, MERCHANT_ID FROM LOT_DEFINATION_MT WHERE LOT_STATUS = 2 ORDER BY LOT_ID DESC")->result_array(); // 2 means pending lot
        // } else {
            $avail_lot = $this->db->query("SELECT LOT_ID , LOT_DESC, MERCHANT_ID FROM LOT_DEFINATION_MT WHERE LOT_STATUS = 2 AND MERCHANT_ID = '$merchant_id' ORDER BY LOT_ID DESC")->result_array(); // 2 means pending lot
        // }
        return $avail_lot;
        // $avail_lot = $this->db->query("SELECT LOT_ID , LOT_DESC FROM LOT_DEFINATION_MT WHERE LOT_STATUS = 2 ORDER BY LOT_ID DESC")->result_array(); // 2 means pending lot
        // return $avail_lot;

    }
    public function get_merchant()
    {
        $user_id = @$this->session->userdata('user_id');
        $merchant_id = @$this->session->userdata('merchant_id');
        if ($user_id == 2) {
            $get_mer = $this->db->query("SELECT MM.MERCHANT_ID,MM.CONTACT_PERSON FROM LZ_MERCHANT_MT MM ORDER BY MM.MERCHANT_ID DESC")->result_array(); // 2 means pending lot
        } else {
            $get_mer = $this->db->query("SELECT MM.MERCHANT_ID,MM.CONTACT_PERSON FROM LZ_MERCHANT_MT MM WHERE MERCHANT_ID = '$merchant_id' ORDER BY MM.MERCHANT_ID DESC")->result_array(); // 2 means pending lot
        }
        return $get_mer;
        // $get_mer = $this->db->query("SELECT MM.MERCHANT_ID,MM.CONTACT_PERSON FROM LZ_MERCHANT_MT MM ORDER BY MM.MERCHANT_ID DESC")->result_array(); // 2 means pending lot

        // return $get_mer;

    }
    public function get_Merchant_Acount_Name()
    {
        // $user_id = $this->input->post('user_id');
        $merchant_id = $this->input->post('merchant_id');
        if($merchant_id == null){
            $merchant_id = @$this->session->userdata('merchant_id');
        }
        // if ($user_id == 2) {
        //     $get_mer_acc = $this->db->query("SELECT MERCHANT_ID, ACCOUNT_NAME, ACCT_ID FROM lj_merhcant_acc_dt")->result_array();
        // } else {
            $get_mer_acc = $this->db->query("SELECT MERCHANT_ID, ACCOUNT_NAME, ACCT_ID, DEFAULT_MERCHANT FROM lj_merhcant_acc_dt WHERE MERCHANT_ID = '$merchant_id' ")->result_array();
        // }
        return $get_mer_acc;
    }
    public function barcodeDetail()
    {
        $requestData = $_REQUEST;

        $columns = array(
            // datatable column index  => database column name
            0 => '',
            1 => 'PIC',
            2 => 'BARCODE_NO',
            3 => 'COST',
        );

        $mt_id = $this->input->post("mt_id");

        $qty_det = $this->db->query("SELECT *  FROM LZ_MERCHANT_BARCODE_DT WHERE MT_ID =  $mt_id");
        $totalData = $qty_det->num_rows();
        // var_dump($totalData);exit;
        //$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT 'NULL' PIC,DT.BARCODE_NO BARCODE_NO,DT.COST ,MT.RANGE_ID,DT.MT_ID MT_ID,SP.FOLDER_NAME,DT.DT_ID FROM LZ_MERCHANT_BARCODE_DT DT, LZ_MERCHANT_BARCODE_MT MT,LZ_SPECIAL_LOTS SP WHERE DT.MT_ID =  $mt_id AND DT.BARCODE_NO = SP.BARCODE_PRV_NO(+) AND MT.MT_ID = DT.MT_ID";
        if (!empty($requestData['search']['value'])) { // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql .= " AND ( BARCODE_NO LIKE '%" . $requestData['search']['value'] . "%')";
        }

        $query = $this->db->query($sql);

        //$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
        $totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify total number filtered rows as per search result.
        $sql .= " ORDER BY  " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'];
        /*================================================
        =            for oracle 11g or bellow  it also words on 12c          =
        ================================================*/
        //$sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($sql) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'];

        /*=====  End of for oracle 11g or bellow  ======*/

        /*=======================================
        =            For Oracle 12-c            =
        =======================================*/
        $sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($sql) q ) OFFSET " . $requestData['start'] . " ROWS FETCH NEXT " . $requestData['length'] . " ROWS ONLY";
        /*=====  End of For Oracle 12-c  ======*/

        $query = $this->db->query($sql);
        $query = $query->result_array();

        $get_rang_id = $query[0]['RANGE_ID'];

        //////////////////////////////
        $path_query = $this->db->query("SELECT * FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 2");
        $path_query = $path_query->result_array();
        $master_path = $path_query[0]['MASTER_PATH'];
        ////////////////////////////

        $data = array();
        $i = 1;
        foreach ($query as $row) {
            $nestedData = array();

            $print_url = base_url('merchant/c_merchant/printBarcode') . '/' . $row['DT_ID'];
            $nestedData[] = '<div> <a href="' . $print_url . '" title="Barcode Sticker" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></a> </div>';

            $folder_name = str_replace('/', '_', @$row['FOLDER_NAME']);

            $m_dir = $master_path . @$folder_name . "/thumb/";
            //var_dump($folder_name, $m_dir); exit;
            $m_dir = preg_replace("/[\r\n]*/", "", $m_dir);

            if (is_dir(@$m_dir)) {
                $iterator = new \FilesystemIterator(@$m_dir);
                if (@$iterator->valid()) {
                    $m_flag = 1;
                } else {
                    $m_flag = 0;
                }
            } else {
                $m_flag = 0;
            }
            if ($m_flag == 1) {
                if (is_dir($m_dir)) {
                    $images = scandir($m_dir);
                    if (count($images) > 0) { // make sure at least one image exists
                        $url = $images[2]; // first image
                        $img = file_get_contents($m_dir . $url);
                        $img = base64_encode($img);
                        $nestedData[] = '<div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);cursor: pointer!important;"><img class="sort_img up-img" id="" name="" src="data:image;base64,' . $img . '"/></div>';
                    } else {
                        $nestedData[] = 'Not Found';
                    }
                } else {
                    $nestedData[] = 'Not Found';
                }
            } else {
                $nestedData[] = 'Not Found';
            }

            $nestedData[] = $row["BARCODE_NO"];

            if ($get_rang_id == 1) {

                $nestedData[] = '<div class="pull-CENTER" style="width:90px;">$ ' . number_format((float) @$row['COST'], 2, '.', ',') . '</div>';
            } else {
                $nestedData[] = '<div><input type ="number" class="form-control" name ="bar_cost" id="get_cost_' . $row["BARCODE_NO"] . '" value="' . number_format((float) @$row['COST'], 2, '.', '') . '"> <button class="btn btn-success get_bar_cost" id="' . $row["BARCODE_NO"] . '">Save</button></div>';

            }

            $data[] = $nestedData;
            $i++;
        } //end foreach

        $json_data = array(
            "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
            "recordsTotal" => intval($totalData), // total number of records
            "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
            //"deferLoading" =>  intval( $totalFiltered ),
            "data" => $data, // total data array

        );

        return $json_data;

    }
    public function save_bar_cost()
    {
        $get_barc = $this->input->post('get_barc');
        $get_cost = $this->input->post('get_cost');

        $this->db->query(" UPDATE LZ_MERCHANT_BARCODE_DT D SET D.COST= $get_cost WHERE D.BARCODE_NO =$get_barc ");

    }
    public function save_rang_bar_cost()
    {
        $get_rang_cost_val = $this->input->post('get_rang_cost_val');
        $mt_id = $this->input->post('mt_id');

        $this->db->query(" UPDATE LZ_MERCHANT_BARCODE_DT D SET D.COST= $get_rang_cost_val WHERE D.mt_id =$mt_id ");

    }

}
