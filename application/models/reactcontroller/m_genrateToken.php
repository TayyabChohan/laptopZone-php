
<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Single Entry Model
 */
/***
 *
 * Stripe Payment
 */
require_once './vendor/autoload.php';
\Stripe\Stripe::setApiKey('sk_test_GBoSFpvdORwnqddSO9bA6diO00ifrAdWVC');
class m_genrateToken extends CI_Model
{
    // Set your secret key: remember to change this to your live secret key in production
    // See your keys here: https://dashboard.stripe.com/account/apikeys
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /*

    e Bay Integration  Models

     */
    public function get_Portal_data()
    {
        // $name = 'B-STOCK';
        $qr = "select * from lz_portal_mt";
        $portal_data = $this->db->query($qr);
        if ($portal_data->num_rows() > 0) {
            $portal_data = $portal_data->result_array();
        } else {
            $portal_data = null;
        }
        return $portal_data;
    }

    public function get_Store_Name($name, $portal_code, $merchant_id)
    {
        $qr = "select * from lj_merhcant_acc_dt where ACCOUNT_NAME = '$name' AND PORTAL_ID = '$portal_code' AND  MERCHANT_ID = '$merchant_id' ";
        $store_name = $this->db->query($qr);
        if ($store_name->num_rows() > 0) {
            $store_name = array("status" => false, "message" => "Your Ebay User Id Already Used");
            // $store_name = $portal_data->result_array();
        } else {
            $store_name = array("status" => true);
        }
        return $store_name;
    }

    public function get_Last_Insert_Store()
    {
        $qr = "SELECT a.* , p.PORTAL_DESC, E.USER_NAME, TO_CHAR(a.INSERTED_DATE, 'MM/DD/YY HH24:MI:SS') INSERTED_DATE  FROM lj_merhcant_acc_dt a,  lz_portal_mt p, EMPLOYEE_MT E where rownum = 1 AND a.PORTAL_ID = p.PORTAL_ID AND a.INSERTED_BY = E.EMPLOYEE_ID ORDER BY a.acct_id DESC";
        $store_name = $this->db->query($qr);
        if ($store_name->num_rows() > 0) {
            $store_name = array("status" => true, "message" => $store_name->row());
        } else {
            $store_name = array("status" => false, "message" => "Record is not Found");
        }
        return $store_name;
    }

    public function select_Paypal_Email($email)
    {
        $qr = "SELECT PAYPAL_EMAIL FROM lj_paypal_mt WHERE PAYPAL_EMAIL = '$email' ";
        $result = $this->db->query($qr);
        if ($result->num_rows() > 0) {
            return $emailexist = array('status' => true);
        } else {
            return $eamilexist = array("status" => false);
        }
    }

    public function save_Email_Paypal($email, $acct_id, $insertedby)
    {

        $qr = "INSERT INTO lj_paypal_mt (PAYPAL_MT_ID, ACCOUNT_ID, PAYPAL_EMAIL, TOKEN, TOKEN_EXPIRY, INSERTED_DATE, INSERTED_BY) VALUES (get_single_primary_key('lj_paypal_mt','PAYPAL_MT_ID'), $acct_id, '$email','','', sysdate, $insertedby) ";
        $result = $this->db->query($qr);
        if ($result) {
            $resultArray = array("status" => true, 'message' => "inserted paypal email");
        } else {
            $resultArray = array("status" => false, 'message' => "Not inserted paypal email");
        }
        return $resultArray;
    }

    public function check_Previous_Default_STORE($merchant_id)
    {
        // $qr = "SELECT DEFAULT_MERCHANT FROM lj_merhcant_acc_dt WHERE  MERCHANT_ID = $merchant_id";
        // $data = $this->db->query($qr);
        // if ($data->num_rows() > 0) {
        //     for ($i = 1; $i <= count($data); $i++) {
        $qr = "UPDATE lj_merhcant_acc_dt SET DEFAULT_MERCHANT = 0 WHERE DEFAULT_MERCHANT = 1 AND  MERCHANT_ID = $merchant_id";
        $result = $this->db->query($qr);
        //     }
        // }
    }
    // public function check_Previous_Default_merchant_Store($merchant_id)
    // {
    //     $qr = "SELECT DEFAULT_MERCHANT FROM lj_merhcant_acc_dt WHERE MERCHANT_ID = $merchant_id";
    //     $data = $this->db->query($qr);
    //     if ($data->num_rows() > 0) {
    //         for ($i = 1; $i <= count($data); $i++) {
    //             $qr = "UPDATE lj_merhcant_acc_dt SET DEFAULT_MERCHANT = 0 WHERE DEFAULT_MERCHANT = 1 AND  MERCHANT_ID = $merchant_id";
    //             $result = $this->db->query($qr);
    //         }
    //     }
    // }
    public function set_Default_Store_Name($acct_id, $default_merchant, $user_id, $merchant_id)
    {
        if ($default_merchant == 1) {
            $this->check_Previous_Default_STORE($merchant_id);
        }
        $qr = "UPDATE lj_merhcant_acc_dt SET DEFAULT_MERCHANT = $default_merchant WHERE ACCT_ID = '$acct_id' ";
        $data = $this->db->query($qr);
        if ($data) {
            if ($default_merchant == 0) {
                $result = array("status" => true, "message" => "Remove From Default Seller Account");
            } else {
                $result = array("status" => true, "message" => "Add As Default Seller Account");
            }
        } else {
            $result = array("status" => false, "message" => "Your Account Is Not Update");
        }
        return $result;
    }
    public function save_Store_Name($name, $portal_code, $marchantid, $insertedby, $token, $email, $default_merchant)
    {
        $email_validate = $this->select_Paypal_Email($email);
        if ($email_validate['status'] == false) {
            $result = $this->get_Store_Name($name, $portal_code, $marchantid);
            if ($result['status'] == true) {
                if ($default_merchant == 1) {
                    $this->check_Previous_Default_STORE($marchantid);
                }
                $qr = "INSERT INTO lj_merhcant_acc_dt (ACCT_ID, MERCHANT_ID, ACCOUNT_NAME, PORTAL_ID, TOKEN, TOKEN_EXPIRY, INSERTED_DATE, INSERTED_BY, MERCHANT_STATUS, DEFAULT_MERCHANT) VALUES (get_single_primary_key('lj_merhcant_acc_dt','ACCT_ID'), '$marchantid', '$name' , '$portal_code',   '$token' ,  '', sysdate, '$insertedby', '1', $default_merchant)";
                $insert_data = $this->db->query($qr);
                if ($insert_data) {
                    $latest_data = $this->get_last_insert_store();
                    if ($latest_data['status'] == true) {
                        $acct_id = $latest_data['message']->ACCT_ID;
                        $paypalEmail = $this->save_Email_Paypal($email, $acct_id, $insertedby);
                        if ($paypalEmail['status'] == true) {
                            return $dataa = array("status" => true, 'message' => $latest_data['message'], 'data' => "Reacord Update");
                        } else {
                            return $dataa = array("status" => false, 'message' => $paypalEmail['message']);
                        }
                    } else {
                        return $dataa = array("status" => false, 'message' => $latest_data);
                    }
                } else {
                    return $dataa = array("status" => false, "message" => "No Record Update");
                }
            } else {
                return $dataa = $result;
            }
        } else {
            return $dataa = array("status" => false, "message" => "Email Already In Exist");
        }
        return $dataa;
    }

    //Updated
    // decode(a.active,1,'Yes',0,'No')
    public function select_All_Store_Data($merchant_id, $user_id)
    {
        //Made By Haziq
        // SELECT P.PORTAL_DESC, E.FIRST_NAME, M.* from lj_merhcant_acc_dt M, lz_portal_mt P, EMPLOYEE_MT E where M.MERCHANT_ID = '5' AND M.PORTAL_ID = P.PORTAL_ID AND M.INSERTED_BY = E.EMPLOYEE_ID;
        if ($user_id == 2) {
            $qr = "SELECT P.PORTAL_DESC, E.USER_NAME, M.*, TO_CHAR(M.TOKEN_EXPIRY, 'MM/DD/YY HH24:MI:SS') TOKEN_EXPIRY,  TO_CHAR(M.INSERTED_DATE, 'MM/DD/YY HH24:MI:SS') INSERTED_DATE from lj_merhcant_acc_dt M, lz_portal_mt P, EMPLOYEE_MT E where M.PORTAL_ID = P.PORTAL_ID AND M.INSERTED_BY = E.EMPLOYEE_ID ORDER BY M.acct_id DESC";
        } else {
            $qr = "SELECT P.PORTAL_DESC, E.USER_NAME, M.*,  TO_CHAR(M.TOKEN_EXPIRY, 'MM/DD/YY HH24:MI:SS') TOKEN_EXPIRY,  TO_CHAR(M.INSERTED_DATE, 'MM/DD/YY HH24:MI:SS') INSERTED_DATE from lj_merhcant_acc_dt M, lz_portal_mt P, EMPLOYEE_MT E  WHERE M.MERCHANT_ID = '$merchant_id' AND M.PORTAL_ID = P.PORTAL_ID AND M.INSERTED_BY = E.EMPLOYEE_ID ORDER BY M.acct_id DESC";

        }
        // $qr = "SELECT * FROM lj_merhcant_acc_dt a ORDER BY a.acct_id DESC";
        $store_name = $this->db->query($qr);
        if ($store_name->num_rows() > 0) {
            // $store_name = array("status"=>false, "message"=>"Your Store Account Already Avalibale");
            $store_name = $store_name->result_array();
            $store_name = array("status" => true, "message" => $store_name);
        } else {
            $store_name = array("status" => false, "message" => $store_name);
        }
        return $store_name;
    }

    public function updateStoreStatus($acct_id, $merchant_status)
    {
        $qr = "UPDATE lj_merhcant_acc_dt SET MERCHANT_STATUS = $merchant_status WHERE ACCT_ID = '$acct_id'";
        $updateData = $this->db->query($qr);
        if ($updateData) {
            if ($merchant_status == 1) {
                $result = array("status" => true, 'message' => "Your Account Is Enable Now");
            } else {
                $result = array("status" => true, "message" => "Your Account Is Disable Now");
            }
        } else {
            $result = array("status" => false, "message" => "Your Account Is Not Update");
        }
        return $result;
    }

    public function signIn_EBay_Url_Detail($acct_id)
    {
        $qr = "SELECT SESSION_ID FROM LJ_EBAY_SESSIONS_MT where ACCT_ID = '$acct_id' ";
        $get_Session_Id = $this->db->query($qr);
        if ($get_Session_Id->num_rows() > 0) {
            $get_Session_Id = $get_Session_Id->row();
            $qr_runame = "SELECT RUNAME FROM LZ_EBAY_DEV_CREDENTIALS_DT where USER_ID = 1";
            $get_Runame = $this->db->query($qr_runame);
            if ($get_Runame->num_rows() > 0) {
                $get_Runame = $get_Runame->row();
                $get_Signin_ebay = array("status" => true, "session_id" => $get_Session_Id->SESSION_ID, "runame" => $get_Runame->RUNAME);
            } else {
                $get_Signin_ebay = array("status" => false, "message" => "Error in Runame");
            }
        } else {
            $get_Signin_ebay = array("status" => false, "message" => "Error in Session_id");
        }
        return $get_Signin_ebay;
    }

    /*

    e Bay Integration  Models End
    Genrate Barcode Start Models

     */

    public function get_Merchant_Detail($user_id, $merchant_id)
    {
        if ($user_id == 2) {
            $get_mer = $this->db->query("SELECT MM.MERCHANT_ID,MM.CONTACT_PERSON FROM LZ_MERCHANT_MT MM ORDER BY MM.MERCHANT_ID DESC")->result_array(); // 2 means pending lot

        } else {
            $get_mer = $this->db->query("SELECT MM.MERCHANT_ID,MM.CONTACT_PERSON FROM LZ_MERCHANT_MT MM WHERE MERCHANT_ID = '$merchant_id' ORDER BY MM.MERCHANT_ID DESC")->result_array(); // 2 means pending lot
        }
        return $get_mer;
    }

    public function get_Merchant_Lot($user_id, $merchant_id)
    {
        if ($user_id == 2) {
            $get_mer_lot = $this->db->query("SELECT LOT_ID , LOT_DESC, MERCHANT_ID FROM LOT_DEFINATION_MT WHERE LOT_STATUS = 2 ORDER BY LOT_ID DESC")->result_array(); // 2 means pending lot
        } else {
            $get_mer_lot = $this->db->query("SELECT LOT_ID , LOT_DESC, MERCHANT_ID FROM LOT_DEFINATION_MT WHERE LOT_STATUS = 2 AND MERCHANT_ID = '$merchant_id' ORDER BY LOT_ID DESC")->result_array(); // 2 means pending lot
        }
        return $get_mer_lot;
    }

    public function get_Merchant_Acount_Name($user_id, $merchant_id)
    {
        if ($user_id == 2) {
            $get_mer_acc = $this->db->query("SELECT MERCHANT_ID, ACCOUNT_NAME, ACCT_ID, DEFAULT_MERCHANT FROM lj_merhcant_acc_dt")->result_array();
        } else {
            $get_mer_acc = $this->db->query("SELECT MERCHANT_ID, ACCOUNT_NAME, ACCT_ID, DEFAULT_MERCHANT FROM lj_merhcant_acc_dt WHERE MERCHANT_ID = '$merchant_id' ")->result_array();
        }
        return $get_mer_acc;
    }
    public function get_Total_Bar($lot_id)
    {

        // $avail_lot_id = $this->input->post('avail_lot_id');

        $tot_quer = $this->db->query("SELECT COUNT(K.BARCODE_NO) TOTAL_BAR, '$ '||ROUND(NVL(MAX(DE.COST),0),2) COST_LOT, MAX(DE.WEIGHT) WEIGH, '$ '|| ROUND(NVL(MAX(DE.COST) / MAX(DE.WEIGHT), 0),2) COST_PER_LBS, '$ '|| ROUND(NVL(MAX(DE.COST) / COUNT(K.BARCODE_NO), 0), 2) AVG_AMOUNT FROM LZ_MERCHANT_BARCODE_MT M, LZ_MERCHANT_BARCODE_DT K,LOT_DEFINATION_MT DE WHERE M.LOT_ID = '$lot_id' AND M.MT_ID = K.MT_ID AND M.LOT_ID = DE.LOT_ID ")->result_array();
        //  echo json_encode($tot_quer);
        //  return json_encode($tot_quer);
        return $tot_quer;
    }

    public function print_Barcode($bar_range, $no_of_barcode, $mer_name, $merchant_id, $user_id, $avail_lot, $seller_account_id, $pos_check)
    {
        // var_dump($bar_range . ":" . $no_of_barcode . ":" . $mer_name . ":" . $merchant_id . ":" . $user_id . ":" . $avail_lot . ":" . $seller_account_id);
        //  exit;
        $pos_status = '';
        $mid = $merchant_id;
        if ($pos_check == 'false') {
            $pos_status = 0;
        } else {
            $pos_status = 1;
        }
        $mt_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_MERCHANT_BARCODE_MT', 'MT_ID') ID FROM DUAL")->result_array();
        $mt_id = $mt_id[0]['ID'];
        $qr = "INSERT INTO LZ_MERCHANT_BARCODE_MT (MT_ID, MERCHANT_ID, ISSUED_DATE, ISSUED_BY, NO_OF_BARCODE,LOT_ID,RANGE_ID, POS_STATUS) VALUES ($mt_id, '$mid', sysdate, $user_id, $no_of_barcode, '$avail_lot', $bar_range, $pos_status)";
        $result = $this->db->query($qr);
        // return $result;
        if ($result) {
            for ($i = 1; $i <= $no_of_barcode; $i++) {
                $this->db->query("INSERT INTO LZ_MERCHANT_BARCODE_DT (DT_ID, MT_ID, BARCODE_NO, ACCOUNT_ID, CREATED_BY, CREATED_AT) VALUES (GET_SINGLE_PRIMARY_KEY('LZ_MERCHANT_BARCODE_DT', 'DT_ID'), '$mt_id', seq_barcode_no.nextval, '$seller_account_id',  $user_id, sysdate)");
            }

            $data1 = $this->db->query("SELECT B.ISSUED_DATE,B.NO_OF_BARCODE,B.RANGE_ID, D.BARCODE_NO, MM.BUISNESS_NAME,L.LOT_ID,L.LOT_DESC,L.REF_NO, (SELECT MIN(DD.BARCODE_NO) ||'-' || MAX(DD.BARCODE_NO) FROM LZ_MERCHANT_BARCODE_DT DD WHERE DD.MT_ID = B.MT_ID ) RANGE_BARCODE FROM LZ_MERCHANT_BARCODE_MT B, LZ_MERCHANT_BARCODE_DT D, LZ_MERCHANT_MT   MM, LOT_DEFINATION_MT L WHERE B.MERCHANT_ID = MM.MERCHANT_ID AND B.MT_ID = D.MT_ID AND B.LOT_ID = L.LOT_ID(+) AND D.MT_ID = $mt_id ORDER BY BARCODE_NO ASC ")->result_array();
            $barcodeNumbers = $this->db->query("SELECT BARCODE_NO  FROM LZ_MERCHANT_BARCODE_DT  WHERE MT_ID = '$mt_id'")->result_array();
            return $data = array("status" => true, "data" => $data1, "MT_ID" => $mt_id, "barcode" => $barcodeNumbers, "message" => "Your Barcode Is Genrated");

        } else {
            return $data = array("status" => false, "message" => "Your Barcode Is Not Genrated");
        }
    }

    public function get_Barcode_Form_Database($mt_id)
    {
        $data = $this->db->query("SELECT TO_CHAR(B.ISSUED_DATE, 'MM/DD/YY HH24:MI:SS')  ISSUED_DATE , B.NO_OF_BARCODE,  B.MERCHANT_ID, DECODE(B.POS_STATUS, '0', 'NOT FOR POS', '1', 'USE FOR POS') POS_STATUS, B.RANGE_ID, D.BARCODE_NO, MM.BUISNESS_NAME,L.LOT_ID,L.LOT_DESC,L.REF_NO, (SELECT MIN(DD.BARCODE_NO) ||'-' || MAX(DD.BARCODE_NO) FROM LZ_MERCHANT_BARCODE_DT DD WHERE DD.MT_ID = B.MT_ID ) RANGE_BARCODE FROM LZ_MERCHANT_BARCODE_MT B, LZ_MERCHANT_BARCODE_DT D, LZ_MERCHANT_MT  MM, LOT_DEFINATION_MT L WHERE B.MERCHANT_ID = MM.MERCHANT_ID AND B.MT_ID = D.MT_ID AND B.LOT_ID = L.LOT_ID(+) AND D.MT_ID = $mt_id ORDER BY BARCODE_NO ASC ")->result_array();
        if ($data > 0) {
            return $data;
        } else {
            return $result = array('status' => false, 'data' => 'No Record Found');
        }
    }
    public function gen_Barcode_DataTable($user_id, $merchant_id, $status)
    {
        if ($user_id == 2) {
            if ($status == 'all') {
                $mt_id = $this->db->query("SELECT B.*, M.BUISNESS_NAME,B.NO_OF_BARCODE,Decode(B.RANGE_ID,1,'Yes',0,'No') RANGE, TO_CHAR(B.ISSUED_DATE, 'MM/DD/YY HH24:MI:SS') ISSUED_DATE, (SELECT MIN(DD.BARCODE_NO) ||'-' || MAX(DD.BARCODE_NO) FROM LZ_MERCHANT_BARCODE_DT DD WHERE DD.MT_ID = B.MT_ID ) RANGE_BARCODE,  E.USER_NAME,DE.LOT_DESC,DE.REF_NO FROM LZ_MERCHANT_BARCODE_MT B, LZ_MERCHANT_MT M, EMPLOYEE_MT E,LOT_DEFINATION_MT DE  WHERE  B.MERCHANT_ID = M.MERCHANT_ID AND B.LOT_ID = DE.LOT_ID(+) AND E.EMPLOYEE_ID = B.ISSUED_BY ORDER BY B.MT_ID DESC")->result_array();

            } else {
                $mt_id = $this->db->query("select * from (SELECT B.MT_ID,
                B.MERCHANT_ID,
                B.ISSUED_BY,
                B.NO_OF_BARCODE,
                B.LOT_ID,
                B.RANGE_ID,
                B.LZ_PRODUCT_INV_ID,
                B.POS_STATUS,
                B.LZ_POS_MT_ID,
                M.BUISNESS_NAME,

                Decode(B.RANGE_ID, 1, 'Yes', 0, 'No') RANGE,
                TO_CHAR(B.ISSUED_DATE, 'MM/DD/YY HH24:MI:SS') ISSUED_DATE,
                (SELECT MIN(DD.BARCODE_NO) || '-' || MAX(DD.BARCODE_NO)
                FROM LZ_MERCHANT_BARCODE_DT DD
                WHERE DD.MT_ID = B.MT_ID) RANGE_BARCODE,
                E.USER_NAME,
                DE.LOT_DESC,
                DE.REF_NO
                FROM LZ_MERCHANT_BARCODE_MT B,
                LZ_MERCHANT_MT M,
                EMPLOYEE_MT E,
                LOT_DEFINATION_MT DE
                WHERE B.MERCHANT_ID = M.MERCHANT_ID
                AND B.LOT_ID = DE.LOT_ID(+)
                AND E.EMPLOYEE_ID = B.ISSUED_BY
                ORDER BY B.MT_ID DESC)
                where rownum <= 50")->result_array();
            }

        } else {
            $mt_id = $this->db->query("SELECT B.*, M.BUISNESS_NAME,B.NO_OF_BARCODE,Decode(B.RANGE_ID,1,'Yes',0,'No') RANGE, TO_CHAR(B.ISSUED_DATE, 'MM/DD/YY HH24:MI:SS') ISSUED_DATE , (SELECT MIN(DD.BARCODE_NO) ||'-' || MAX(DD.BARCODE_NO) FROM LZ_MERCHANT_BARCODE_DT DD WHERE DD.MT_ID = B.MT_ID ) RANGE_BARCODE, E.USER_NAME,DE.LOT_DESC,DE.REF_NO FROM LZ_MERCHANT_BARCODE_MT B, LZ_MERCHANT_MT M, EMPLOYEE_MT E,LOT_DEFINATION_MT DE  WHERE  B.MERCHANT_ID = M.MERCHANT_ID AND B.LOT_ID = DE.LOT_ID(+) AND E.EMPLOYEE_ID = B.ISSUED_BY AND B.MERCHANT_ID = $merchant_id ORDER BY B.MT_ID DESC")->result_array();
        }

        return $mt_id;

    }
    public function latest_Gen_Barcode_DataTable($mt_id)
    {
        $mt_id = $this->db->query("SELECT B.*, M.BUISNESS_NAME,B.NO_OF_BARCODE,Decode(B.RANGE_ID,1,'Yes',0,'No') RANGE, TO_CHAR(B.ISSUED_DATE, 'MM/DD/YY HH24:MI:SS') ISSUED_DATE, E.USER_NAME,DE.LOT_DESC,DE.REF_NO, (SELECT MIN(DD.BARCODE_NO) ||'-' || MAX(DD.BARCODE_NO) FROM LZ_MERCHANT_BARCODE_DT DD WHERE DD.MT_ID = B.MT_ID ) RANGE_BARCODE FROM LZ_MERCHANT_BARCODE_MT B, LZ_MERCHANT_MT M, EMPLOYEE_MT E,LOT_DEFINATION_MT DE WHERE B.MERCHANT_ID = M.MERCHANT_ID AND B.LOT_ID = DE.LOT_ID(+) AND E.EMPLOYEE_ID = B.ISSUED_BY AND B.MT_ID = '$mt_id'  ORDER BY B.MT_ID DESC")->result_array();

        return $mt_id;

    }
    public function get_Barcode_Detail()
    {
        $mt_id = $this->input->post('cell');
        $qr = "SELECT DT_ID, BARCODE_NO, COST from LZ_MERCHANT_BARCODE_DT WHERE MT_ID = '$mt_id'";
        $getBarcodeDetail = $this->db->query($qr)->result_array();
        if ($getBarcodeDetail == true) {
            $result = array("status" => true, "data" => $getBarcodeDetail);
        } else {
            $result = array("status" => false, "message" => "No Reacod Found");

        }
        return $result;
    }

    public function genrate_Barcode_By_Dt($dt_id)
    {
        // $dt_id =$this->input->post('cell');
        // $dt_id = $_GET['cell'];
        // $dt_id = 10000001996;
        $data = $this->db->query("SELECT TO_CHAR(B.ISSUED_DATE, 'MM/DD/YY HH24:MI:SS') ISSUED_DATE, B.MERCHANT_ID, DECODE(B.POS_STATUS, '0', 'NOT FOR POS', '1', 'USE FOR POS') POS_STATUS, D.BARCODE_NO, MM.BUISNESS_NAME,L.LOT_ID,L.LOT_DESC,L.REF_NO FROM LZ_MERCHANT_BARCODE_MT B, LZ_MERCHANT_BARCODE_DT D, LZ_MERCHANT_MT  MM, LOT_DEFINATION_MT L WHERE B.MERCHANT_ID = MM.MERCHANT_ID AND B.MT_ID = D.MT_ID AND B.LOT_ID = L.LOT_ID(+)AND D.DT_ID = '$dt_id' ")->result_array();
        // var_dump($data);exit;
        return $data;

    }

    public function update_Cost()
    {
        $dt_id = $this->input->post('dt_id');
        $cost = $this->input->post('cost');
        $qr = "UPDATE LZ_MERCHANT_BARCODE_DT SET COST = '$cost' WHERE DT_ID ='$dt_id'";
        $result = $this->db->query($qr);
        return $result;
    }
    public function Add_New_Barcode()
    {
        $total_barcode = $this->input->post('total_barcode');
        $mt_id = $this->input->post('mt_id');
        $user_id = $this->input->post('user_id');
        $qr = "SELECT ACCOUNT_ID from LZ_MERCHANT_BARCODE_DT WHERE MT_ID = '$mt_id'";
        $getBarcodeDetail = $this->db->query($qr)->result_array();
        $account_id = $getBarcodeDetail[0]['ACCOUNT_ID'];
        for ($i = 1; $i <= $total_barcode; $i++) {
            $this->db->query("INSERT INTO LZ_MERCHANT_BARCODE_DT (DT_ID, MT_ID, BARCODE_NO, ACCOUNT_ID, CREATED_BY, CREATED_AT) VALUES (GET_SINGLE_PRIMARY_KEY('LZ_MERCHANT_BARCODE_DT', 'DT_ID'), '$mt_id', seq_barcode_no.nextval, '$account_id', $user_id , sysdate)");
        }
        // $qry = "SELECT NO_OF_BARCODE FROM LZ_MERCHANT_BARCODE_MT  WHERE MT_ID = '$mt_id'";
        // $barcodes = $this->db->query($qry)->result_array();
        // $np_of_barcode = $barcodes[0]['NO_OF_BARCODE'];
        // $total_barcodes = $total_barcode + $np_of_barcode;
        $this->db->query("UPDATE LZ_MERCHANT_BARCODE_MT SET NO_OF_BARCODE = NO_OF_BARCODE + $total_barcode WHERE MT_ID = '$mt_id'");
        $qr = "SELECT DT_ID, BARCODE_NO, COST from LZ_MERCHANT_BARCODE_DT WHERE MT_ID = '$mt_id' AND rownum <= $total_barcode
        ORDER BY rownum DESC";
        $data = $this->db->query($qr);
        if ($data) {
            return array('status' => true, 'message' => "New Barcode Inserted", 'data' => $data->result_array());
        } else {
            return array('status' => false, 'message' => "New Barcode Not Inserted", 'data' => array());
        }

    }
    public function Delete_Barcode()
    {
        $barcode = $this->input->post('barcode');
        $dt_id = $this->input->post('dt_id');
        $mt_id = $this->input->post('mt_id');
        // $qr = $this->db->query("SELECT MT_ID FROM LZ_MERCHANT_BARCODE_DT WHERE DT_ID = '$dt_id'")->result_array();
        // $mt_id = $qr[0]['MT_ID'];

        $qr = "SELECT BARCODE_NO FROM LZ_BARCODE_MT WHERE BARCODE_NO = '$barcode'";
        $data = $this->db->query($qr);
        if ($data->num_rows() > 0) {
            return array('status' => false, 'message' => "Barcode is already cunsumed. It cannot be delete");
        } else {
            // $update = $this->db->query("SELECT NO_OF_BARCODE FROM LZ_MERCHANT_BARCODE_MT WHERE MT_ID = '$mt_id'")->result_array();
            // $total_barcode = $update[0]['NO_OF_BARCODE'];
            // $total_barcode = $total_barcode - 1;
            $this->db->query("UPDATE LZ_MERCHANT_BARCODE_MT SET NO_OF_BARCODE = NO_OF_BARCODE - 1 WHERE MT_ID ='$mt_id'");
            $this->db->query("DELETE FROM LZ_SPECIAL_LOTS WHERE BARCODE_PRV_NO = '$barcode'");
            $this->db->query("DELETE FROM LZ_MERCHANT_BARCODE_DT WHERE BARCODE_NO = '$barcode'");
            return array('status' => true, 'message' => "Barcode Deleted Successfuly");
        }
    }
    /*

    Merchant Lot Detail Models

     */

    public function get_Latest_Merchant_Lot()
    {
        $qr = ("SELECT MERCHANT_ID, LOT_ID, LOT_DESC FROM LOT_DEFINATION_MT where ASSIGN_DATE = ( select max(ASSIGN_DATE) from LOT_DEFINATION_MT )");
        $qry = $this->db->query($qr)->result_array();
        if ($qry) {
            $data = array("status" => true, "data" => $qry);
            // $data = $qry;
        } else {
            $data = array('status' => false, 'data' => 'No Record Found');
        }
        return $data;
    }
    public function save_Merchant_Lot($lot_desc, $purch_date, $lot_mini_prof, $lot_cost, $lot_sourc, $est_reques, $part_lis, $lis_Cost, $appr_list, $lot_ref, $merchant_id)
    {
        // $get_lot_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LOT_DEFINATION_MT', 'LOT_ID')ID FROM DUAL")->result_array();
        // $get_lot_pk = $get_lot_pk[0]['ID'];
        // if (empty($purch_date)) {
        //     $purch_date = date("Y/m/d");
        // }
        // if (empty($get_purch_date)) {
        //     $get_purch_date = date("Y/m/d");
        // }
        // var_dump($lot_desc . ":" . $purch_date . ":" . $get_purch_date . ":" . $lot_mini_prof . ":" . $lot_cost . ":" . $lot_sourc . ":" . $est_reques . ":" . $part_lis . ":" . $lis_Cost . ":" . $appr_list . ":" . $lot_ref . ":" . $merchant_id);
        //     exit;
        $qr = "INSERT INTO LOT_DEFINATION_MT(LOT_ID, REF_NO, PURCHASE_DATE, ASSIGN_DATE, COST, PROFIT_REQUIRE, SOURCE, EST_REQUEST, PARTIAL_LIST, LINE_ITEM_COST_AVAIL, APPROVAL_REQUIRE,EST_SHIP_SERVIC,LOT_DESC,MERCHANT_ID)values(GET_SINGLE_PRIMARY_KEY('LOT_DEFINATION_MT', 'LOT_ID'),'$lot_ref', TO_DATE('$purch_date', 'DD/MM/YYYY HH24:MI:SS'),sysdate,'$lot_cost','$lot_mini_prof','$lot_sourc','$est_reques','$part_lis','$lis_Cost','$appr_list','','$lot_desc' ,'$merchant_id')";
        $qry = $this->db->query($qr);

        if ($qry) {
            $result = array("status" => true, "message" => "your lot is added");

        } else {

            $result = array("status" => false, "message" => "your lot is not added");
        }
        return $result;

    }

    /*
    Merchant Lot Detail End
    Create Appointment  Models

     */

    public function get_Services()
    {
        $qr = "SELECT * FROM lj_services";
        $data = $this->db->query($qr);
        if ($data->num_rows() > 0) {
            $result = array("status" => true, "data" => $data->result_array());
        } else {
            $result = array("status" => false, "message" => "No Reacord Found");
        }
        return $result;
    }

    public function Get_Summary_Appointment()
    {
        $appointment_id = $this->input->post("appointment_id");
        $data = $this->Get_Time_Summary($appointment_id);
        // $total_amount = " select service_id, appointment_id,service_type,service_desc,charges, cnt , charges * cnt total_amount from
        // (select s.service_id, d.appointment_id,sr.service_type,s.service_desc,sr.charges , (select count(1)
        //   from lj_appointment_log     ll
        //  where ll.appointment_dt_id = d.appointment_dt_id and ll.barcode_no is not null) cnt
        // from lj_appointment_dt d, lj_service_rate sr,lj_services s
        // where d.appointment_id = '$appointment_id'
        // AND d.service_id = sr.service_id
        // and s.service_id = sr.service_id)";

        $total_amount = "select service_id,
        appointment_id,
        service_type,
        service_desc,
        charges,
        cnt,
        PACKING_COST,
        charges * cnt total_amount
   from (select s.service_id,
                d.appointment_id,
                sr.service_type,
                s.service_desc,
                sr.charges,
                (select count(1)
                   from lj_appointment_log ll
                  where ll.appointment_dt_id = d.appointment_dt_id
                    and ll.barcode_no is not null) cnt,
                (select SUM(ABS(lpm.packing_cost))
                   from lj_appointment_log        ll,
                        lj_appointment_packing_mt lp,
                        lz_packing_type_mt        lpm
                 --  lj_appointment_dt         d
                  where ll.appointment_dt_id = d.appointment_dt_id
                    AND lp.appointment_log_id = ll.appointment_log_id
                    AND lp.packing_id = lpm.packing_id
                    and ll.barcode_no is not null) PACKING_COST
           from lj_appointment_dt d, lj_service_rate sr, lj_services s
         -- lj_appointment_packing_mt lp,
         -- lj_appointment_log        ll,
         --lz_packing_type_mt        lpm
          where d.appointment_id = '$appointment_id'
            AND d.service_id = sr.service_id
               --AND lp.appointment_log_id = ll.appointment_log_id
               --AND lp.packing_id = lpm.packing_id
            and s.service_id = sr.service_id)";

        $result = $this->db->query($total_amount);
        $result = $result->result_array();
        $cost = $result[0]['CHARGES'];
        $Packing_cost = $result[0]['PACKING_COST'];
        $cost_per_sec = $cost / 120;
        $total_charge = $cost_per_sec * $data['total_second'];
        $total_charge = $total_charge + $Packing_cost;
        return array("status" => true, "data" => $result, "time" => $data['data'], "total_charge" => $total_charge, 'packing_cost' => $Packing_cost);

    }

    public function Get_Time_Summary($appointment_id)
    {
        $qr = "SELECT APPOINTMENT_DT_ID FROM lj_appointment_dt WHERE  APPOINTMENT_ID = '$appointment_id'";
        $result = $this->db->query($qr)->result_array();
        $appointment_dt_id = $result[0]['APPOINTMENT_DT_ID'];
//         $total_barcode = "selsect decode(Day,0,0,Day*86400) + decode(hour,0,0,hour*3600) + decode(Minute,0,0,Minute*60) + second total_second from (
        //             SELECT EXTRACT(Day FROM(l.STOP_TIME - l.START_TIME) DAY TO SECOND) as Day,
        //  EXTRACT(HOUR FROM(l.STOP_TIME -l.START_TIME) DAY TO SECOND) as Hour,
        //  EXTRACT(Minute FROM(l.STOP_TIME - l.START_TIME) DAY TO SECOND) as Minute,
        //  EXTRACT(SECOND FROM(l.STOP_TIME - l.START_TIME) DAY TO SECOND) as second
        //   from lj_appointment_log l
        //  WHERE l.appointment_dt_id = '$appointment_dt_id' AND l.Barcode_No IS NOT NULL AND l.START_TIME IS NOT NULL AND l.STOP_TIME IS NOT NULL)";
        $total_barcode = "select sum(total_second) total_second from (
    select decode(Day, 0, 0, Day * 86400) + decode(hour, 0, 0, hour * 3600) +
           decode(Minute, 0, 0, Minute * 60) + second total_second
      from (SELECT EXTRACT(Day FROM(l.STOP_TIME - l.START_TIME) DAY TO SECOND) as Day,
                   EXTRACT(HOUR FROM(l.STOP_TIME - l.START_TIME) DAY TO SECOND) as Hour,
                   EXTRACT(Minute FROM(l.STOP_TIME - l.START_TIME) DAY TO
                           SECOND) as Minute,
                   EXTRACT(SECOND FROM(l.STOP_TIME - l.START_TIME) DAY TO
                           SECOND) as second
              from lj_appointment_log l
             WHERE l.appointment_dt_id = '$appointment_dt_id'
               AND l.Barcode_No IS NOT NULL
               AND l.START_TIME IS NOT NULL
               AND l.STOP_TIME IS NOT NULL)
    )";

        $total_barcode = $this->db->query($total_barcode);
        $total_barcode = $total_barcode->result_array();
        // $total_barcodes = count($total_barcode);
        $total_sec = $total_barcode[0]["TOTAL_SECOND"];
        // $total_sec = $total_barcodes * $sec;
        // var_dump($total_sec);
        $get_time = "SELECT
            TO_CHAR(TRUNC('$total_sec'/3600),'FM9900') || ':' ||
            TO_CHAR(TRUNC(MOD('$total_sec',3600)/60),'FM00') || ':' ||
            TO_CHAR(MOD('$total_sec',60),'FM00') TOTAL_TIME
        FROM DUAL";
        $get_time = $this->db->query($get_time);
        return array("data" => $get_time->result_array(), "total_second" => $total_sec);
    }

    public function insert_Appointment($created_date, $request_for_approvel, $merchant_id, $user_id, $appointment_date, $appointment_status, $expected_barcode, $remarks)
    {
        $qr = "INSERT INTO lj_appointment_mt(APPOINTMENT_ID, MERCHANT_ID, APPOINTMENT_DATE, APPOINTMENT_STATUS, EXPECTED_BARCODE, REMARKS, CREATED_BY, CREATED_DATE, REQUEST_APPROVAL) VALUES (GET_SINGLE_PRIMARY_KEY('lj_appointment_mt', 'APPOINTMENT_ID'),'$merchant_id', TO_DATE('$appointment_date', 'DD/MM/YY HH24:MI:SS'), '$appointment_status', '$expected_barcode', '$remarks', '$user_id', sysdate, '$request_for_approvel')";
        $result = $this->db->query($qr);
        if ($result == true) {
            return array("status" => true, 'message' => "Appointment Created");
        } else {
            return array("status" => false, 'message' => "Appointment Not Created");
        }

    }
    public function insert_Appointment_Dt($service_id)
    {

        $qry = ("SELECT APPOINTMENT_ID FROM lj_appointment_mt where CREATED_DATE = ( select max(CREATED_DATE) from lj_appointment_mt )");

        $data = $this->db->query($qry)->result_array();
        $appointment_id = $data[0]['APPOINTMENT_ID'];
        $qr = "INSERT INTO lj_appointment_dt(APPOINTMENT_DT_ID, APPOINTMENT_ID, SERVICE_ID) VALUES (GET_SINGLE_PRIMARY_KEY('lj_appointment_dt', 'APPOINTMENT_DT_ID'), '$appointment_id', '$service_id') ";
        $result = $this->db->query($qr);
        $data = $this->get_Latest_Appointment_Detail($appointment_id);
        return array('result' => $result, "data" => $data);
        // return $result;
    }

    public function get_Latest_Appointment_Detail($appointment_id)
    {

        $qr = "SELECT A.*,
        E.USER_NAME,
        M.CONTACT_PERSON,
        M.BUISNESS_NAME,
        S.SERVICE_DESC,
        TO_CHAR(A.APPOINTMENT_DATE, 'DD/MM/YY HH24:MI:SS') APPOINTMENT_DATE,
        TO_CHAR(A.CREATED_DATE, 'DD/MM/YY HH24:MI:SS') CREATED_DATE,
        (select count(1)
           from lj_appointment_dt      dd,
                lz_merchant_barcode_dt d,
                lj_appointment_log     ll
          where dd.appointment_dt_id = ll.appointment_dt_id
            and dd.appointment_id = a.appointment_id
            and ll.appointment_log_id = d.appointment_log_id and ll.barcode_no is not null) TOTAL_PROCESS_BARCODEe,
        Decode(A.APPOINTMENT_STATUS,
               2,
               'In Process',
               0,
               'inqueue',
               1,
               'Approved',
               3,
               'Complete',
               4,
               'Cancel By User',
               5,
               'Cancel By Admin') APPOINTMENT_STATUS
   FROM lj_appointment_mt A,
        LZ_MERCHANT_MT    M,
        EMPLOYEE_MT       E,
        lj_services       S,
        lj_appointment_dt SD
  WHERE A.MERCHANT_ID = M.MERCHANT_ID
    AND A.CREATED_BY = E.EMPLOYEE_ID
    AND A.APPOINTMENT_ID = '$appointment_id'
    AND S.SERVICE_ID = SD.SERVICE_ID
    AND SD.APPOINTMENT_ID = '$appointment_id'";
        $data = $this->db->query($qr);
        if ($data->num_rows() > 0) {

            return $data->result_array();
        }
    }
    public function get_AppointmentDetail($user_id, $merchant_id)
    {
        if ($user_id == 2) {

            $qr = "SELECT A.*,
            E.USER_NAME,
            M.CONTACT_PERSON,
            M.BUISNESS_NAME,
            TO_CHAR(A.APPOINTMENT_DATE, 'DD/MM/YY HH24:MI:SS') APPOINTMENT_DATE,
            TO_CHAR(A.CREATED_DATE, 'DD/MM/YY HH:MI:SS') CREATED_DATE,
            (select count(1)
               from lj_appointment_dt      dd,
                    lz_merchant_barcode_dt d,
                    lj_appointment_log     ll
              where dd.appointment_dt_id = ll.appointment_dt_id
                and dd.appointment_id = a.appointment_id
                and ll.appointment_log_id = d.appointment_log_id and ll.barcode_no is not null) TOTAL_PROCESS_BARCODE,
            Decode(A.APPOINTMENT_STATUS,
                   2,
                   'In Process',
                   0,
                   'inqueue',
                   1,
                   'Approved',
                   3,
                   'Complete',
                   4,
                   'Cancel By User',
                   5,
                   'Cancel By Admin') APPOINTMENT_STATUS
       FROM lj_appointment_mt A, LZ_MERCHANT_MT M, EMPLOYEE_MT E
      WHERE A.MERCHANT_ID = M.MERCHANT_ID
        AND A.CREATED_BY = E.EMPLOYEE_ID
      ORDER BY A.APPOINTMENT_STATUS, 'inqueue', A.APPOINTMENT_ID DESC";
        } else {
            $qr = "SELECT A.*,
            E.USER_NAME,
            M.CONTACT_PERSON,
            M.BUISNESS_NAME,
            TO_CHAR(A.APPOINTMENT_DATE, 'DD/MM/YY HH24:MI:SS') APPOINTMENT_DATE,
            TO_CHAR(A.CREATED_DATE, 'DD/MM/YY HH:MI:SS') CREATED_DATE,
            (select count(1)
               from lj_appointment_dt      dd,
                    lz_merchant_barcode_dt d,
                    lj_appointment_log     ll
              where dd.appointment_dt_id = ll.appointment_dt_id
                and dd.appointment_id = a.appointment_id
                and ll.appointment_log_id = d.appointment_log_id) TOTAL_PROCESS_BARCODE,
            Decode(A.APPOINTMENT_STATUS,
                   2,
                   'In Process',
                   0,
                   'inqueue',
                   1,
                   'Approved',
                   3,
                   'Complete',
                   4,
                   'Cancel By User',
                   5,
                   'Cancel By Admin') APPOINTMENT_STATUS
       FROM lj_appointment_mt A, LZ_MERCHANT_MT M, EMPLOYEE_MT E
      WHERE A.MERCHANT_ID = M.MERCHANT_ID
        AND A.CREATED_BY = E.EMPLOYEE_ID
        AND A.MERCHANT_ID = '$merchant_id'
      ORDER BY A.APPOINTMENT_STATUS, 'inqueue', A.APPOINTMENT_ID DESC";

        }
        $data = $this->db->query($qr);
        if ($data->num_rows() > 0) {
            $result = array("status" => true, "data" => $data->result_array());
        } else {
            $result = array("status" => false, "message" => "No Services");
        }
        return $result;
    }

    public function cancel_Appointment($cell_id, $user_id)
    {
        if ($user_id == 2) {
            $qry = "UPDATE  lj_appointment_mt SET REQUEST_APPROVAL = 3, APPOINTMENT_STATUS = 5, APPOINT_CANCEL_BY = '$user_id', APPOINT_CANCEL_DATE = sysdate WHERE APPOINTMENT_ID = '$cell_id'";
        } else {
            $qry = "UPDATE  lj_appointment_mt SET REQUEST_APPROVAL = 4, APPOINTMENT_STATUS = 4, APPOINT_CANCEL_BY = '$user_id', APPOINT_CANCEL_DATE = sysdate WHERE APPOINTMENT_ID = '$cell_id'";
        }
        $result['appointment_mt'] = $this->db->query($qry);
        return $result;

    }

    public function send_To_Approve()
    {

        $cell_id = $this->input->post('cell_id');
        $user_id = $this->input->post('user_id');
        $qr = "SELECT REQUEST_APPROVAL from lj_appointment_mt WHERE APPOINTMENT_ID = '$cell_id' AND REQUEST_APPROVAL = 2 ";
        $result = $this->db->query($qr);
        if ($result->num_rows() > 0) {
            return array("status" => false, "message" => "It is already approved");
        }
        $qry = "UPDATE lj_appointment_mt SET REQUEST_APPROVAL = 1, APPOINTMENT_STATUS = 0 WHERE APPOINTMENT_ID = '$cell_id'";
        $result = $this->db->query($qry);
        return $result;
    }
    public function approve_Appointment($cell_id, $user_id, $status)
    {
        if ($status == 'inqueue' || $status == 'send to approvel') {
            $status = 1;
            $rstatus = $status + 1;
        } else if ($status == 'Approved') {
            $status = 2;
            $rstatus = $status;
        } else if ($status == 'In Process') {
            $status = 3;
            $rstatus = $status;
        } else if ($status == 'Cancel By Admin' || $status == 'Cancel By User') {
            $status = 0;
            $rstatus = 2;
        }
        $qr = "UPDATE lj_appointment_mt SET REQUEST_APPROVE_BY = '$user_id', REQUEST_APPROVAL =  '$rstatus', REQUEST_APPROVE_DATE = sysdate,  APPOINT_ACCEPT_BY = '$user_id', APPOINT_ACCEPT_DATE = sysdate, APPOINTMENT_STATUS =  '$status'  WHERE APPOINTMENT_ID = '$cell_id'";
        $result = $this->db->query($qr);
        return $result;
    }

    public function get_Specific_Services($cell_id)
    {
        $qr = "SELECT S.SERVICE_DESC,
        S.SERVICE_ID,
        TO_CHAR(A.APPOINTMENT_DATE, 'DD/MM/YY HH24:MI:SS') APPOINTMENT_DATE
   FROM lj_services S, lj_appointment_mt A, lj_appointment_dt SD
  WHERE SD.SERVICE_ID = S.SERVICE_ID
    AND SD.APPOINTMENT_ID = '$cell_id'
    AND A.APPOINTMENT_ID = '$cell_id'";

        $data = $this->db->query($qr);
        if ($data->num_rows() > 0) {
            $result = array("status" => true, "data" => $data->result_array());
        } else {
            $result = array("status" => false, "message" => "No Reacord Found");
        }
        return $result;
    }

    public function check_Log_Barcode_Exist($label, $service_id, $start_barcode, $end_barcode, $appointment_dt_id, $merchant_id)
    {
        if ($start_barcode != '' && $end_barcode != '') {

            if ($label == "Inventory prep" || $label == "Inventory Prop" || $service_id == 3) {
                // var_dump($merchant_id);
                // $qr = "SELECT * FROM lj_appointment_log WHERE APPOINTMENT_DT_ID = $appointment_dt_id AND BARCODE_NO BETWEEN $start_barcode AND $end_barcode";
                // $qr = "SELECT * FROM lz_merchant_barcode_dt WHERE MT_ID = '$merchant_id' AND (APPOINTMENT_LOG_ID is NULL OR APPOINTMENT_DT_ID_INV = 0) AND BARCODE_NO BETWEEN $start_barcode AND $end_barcode";
                $qr = "SELECT * from lz_merchant_barcode_dt d, lz_merchant_barcode_mt m WHERE m.mt_id = d.mt_id AND m.POS_STATUS != 1 AND m.merchant_id = '$merchant_id' AND d.appointment_log_id IS NULL AND d.barcode_no BETWEEN '$start_barcode' AND '$end_barcode'";
                $existBarcode = $this->db->query($qr);
                if ($existBarcode->num_rows() > 0) {
                    return array("status" => true, 'DT_ID' => $existBarcode->result_array());
                } else {
                    return array("status" => false);
                }
            }
            if ($label == "Picture" || $label == "picture" || $service_id == 1) {

                // $qr = "SELECT * FROM lj_appointment_log WHERE APPOINTMENT_DT_ID = $appointment_dt_id AND BARCODE_NO BETWEEN $start_barcode AND $end_barcode";
                // $qr = "SELECT * FROM lz_merchant_barcode_dt WHERE MT_ID = '$merchant_id' AND (APPOINTMENT_LOG_ID is NULL OR APPOINTMENT_DT_ID_INV = 0) AND BARCODE_NO BETWEEN $start_barcode AND $end_barcode";
                $qr = "SELECT * from lz_merchant_barcode_dt d, lz_merchant_barcode_mt m WHERE m.mt_id = d.mt_id AND m.POS_STATUS != 1 AND m.merchant_id = '$merchant_id' AND d.appointment_log_id IS NULL AND d.barcode_no BETWEEN '$start_barcode' AND '$end_barcode'";
                $existBarcode = $this->db->query($qr);
                if ($existBarcode->num_rows() > 0) {
                    return array("status" => true, 'DT_ID' => $existBarcode->result_array());
                } else {
                    return array("status" => false);
                }
            }
        } else {
            return array("status" => false);
        }

    }

    public function add_Lot_Barcode_Detail($label, $service_id, $start_barcode, $end_barcode, $appointment_dt_id, $user_id, $remarks, $merchant_id)
    {
        $barcodeExist = $this->check_Log_Barcode_Exist($label, $service_id, $start_barcode, $end_barcode, $appointment_dt_id, $merchant_id);
        if ($barcodeExist["status"] == true) {
            $countDiff = $end_barcode - $start_barcode;
            if ($label == "Inventory prep" || $label == "Inventory Prop" || $service_id == 3) {
                if ($countDiff > 0) {
                    for ($i = 0; $i <= $countDiff; $i++) {

                        $appointment_log_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('lj_appointment_log ', 'APPOINTMENT_LOG_ID')ID FROM DUAL")->result_array();
                        $appointment_log_id = $appointment_log_id[0]['ID'];
                        $updateBarcode = "INSERT INTO lj_appointment_log (APPOINTMENT_LOG_ID, APPOINTMENT_DT_ID, START_TIME, STOP_TIME, REMARKS, USER_ID, BARCODE_NO) VALUES ('$appointment_log_id' ,'$appointment_dt_id', null, null,'$remarks', '$user_id', '$start_barcode' )";
                        $updateMerchantBarcode = "UPDATE lz_merchant_barcode_dt SET APPOINTMENT_LOG_ID = '$appointment_log_id' WHERE BARCODE_NO = '$start_barcode'";
                        $start_barcode = $start_barcode + 1;
                        $update = $this->db->query($updateBarcode);
                        $updateMerchant = $this->db->query($updateMerchantBarcode);
                    }
                    return array("update" => $update, "barcode" => $barcodeExist['DT_ID']);
                } else if ($countDiff == 0) {
                    $appointment_log_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('lj_appointment_log ', 'APPOINTMENT_LOG_ID')ID FROM DUAL")->result_array();
                    $appointment_log_id = $appointment_log_id[0]['ID'];
                    $updateBarcode = "INSERT INTO lj_appointment_log (APPOINTMENT_LOG_ID, APPOINTMENT_DT_ID, START_TIME, STOP_TIME, REMARKS, USER_ID, BARCODE_NO) VALUES ('$appointment_log_id' ,'$appointment_dt_id', null, null,'$remarks', '$user_id', '$start_barcode' )";
                    $updateMerchantBarcode = "UPDATE lz_merchant_barcode_dt SET APPOINTMENT_LOG_ID = '$appointment_log_id' WHERE BARCODE_NO = '$start_barcode'";
                    $update = $this->db->query($updateBarcode);
                    $updateMerchant = $this->db->query($updateMerchantBarcode);
                    return array("update" => $update, "barcode" => $barcodeExist['DT_ID']);
                    // var_dump($start_barcode);
                } else if ($countDiff < 0) {
                    for ($i = $countDiff; $i < 0; $i++) {
                        $appointment_log_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('lj_appointment_log ', 'APPOINTMENT_LOG_ID')ID FROM DUAL")->result_array();
                        $appointment_log_id = $appointment_log_id[0]['ID'];
                        $updateBarcode = "INSERT INTO lj_appointment_log (APPOINTMENT_LOG_ID, APPOINTMENT_DT_ID, START_TIME, STOP_TIME, REMARKS, USER_ID, BARCODE_NO) VALUES ('$appointment_log_id' ,'$appointment_dt_id', null, null,'$remarks', '$user_id', '$start_barcode' )";
                        $updateMerchantBarcode = "UPDATE lz_merchant_barcode_dt SET APPOINTMENT_LOG_ID = '$appointment_log_id' WHERE BARCODE_NO = '$start_barcode'";
                        $start_barcode = $start_barcode - 1;
                        // var_dump($start_barcode);
                        $update = $this->db->query($updateBarcode);
                        $updateMerchant = $this->db->query($updateMerchantBarcode);
                    }
                    return array("update" => $update, "barcode" => $barcodeExist['DT_ID']);
                }
            } else if ($label == "Picture" || $label == "picture" || $service_id == 1) {
                $countDiff = $end_barcode - $start_barcode;
                if ($countDiff > 0) {
                    for ($i = 0; $i <= $countDiff; $i++) {
                        $appointment_log_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('lj_appointment_log ', 'APPOINTMENT_LOG_ID')ID FROM DUAL")->result_array();
                        $appointment_log_id = $appointment_log_id[0]['ID'];
                        $updateBarcode = "INSERT INTO lj_appointment_log (APPOINTMENT_LOG_ID, APPOINTMENT_DT_ID, START_TIME, STOP_TIME, REMARKS, USER_ID, BARCODE_NO) VALUES ('$appointment_log_id' ,'$appointment_dt_id', null, null,'$remarks', '$user_id', '$start_barcode' )";
                        $updateMerchantBarcode = "UPDATE lz_merchant_barcode_dt SET APPOINTMENT_LOG_ID = '$appointment_log_id' WHERE BARCODE_NO = '$start_barcode'";
                        $start_barcode = $start_barcode + 1;
                        // var_dump($start_barcode);
                        $update = $this->db->query($updateBarcode);
                        $updateMerchant = $this->db->query($updateMerchantBarcode);
                    }
                    return array("update" => $update, "barcode" => $barcodeExist['DT_ID']);
                } else if ($countDiff == 0) {
                    $appointment_log_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('lj_appointment_log ', 'APPOINTMENT_LOG_ID')ID FROM DUAL")->result_array();
                    $appointment_log_id = $appointment_log_id[0]['ID'];
                    $updateBarcode = "INSERT INTO lj_appointment_log (APPOINTMENT_LOG_ID, APPOINTMENT_DT_ID, START_TIME, STOP_TIME, REMARKS, USER_ID, BARCODE_NO) VALUES ('$appointment_log_id' ,'$appointment_dt_id', null, null,'$remarks', '$user_id', '$start_barcode' )";
                    $updateMerchantBarcode = "UPDATE lz_merchant_barcode_dt SET APPOINTMENT_LOG_ID = '$appointment_log_id' WHERE BARCODE_NO = '$start_barcode'";
                    // var_dump($start_barcode);
                    $update = $this->db->query($updateBarcode);
                    $updateMerchant = $this->db->query($updateMerchantBarcode);
                    return array("update" => $update, "barcode" => $barcodeExist['DT_ID']);
                } else if ($countDiff < 0) {
                    for ($i = $countDiff; $i < 0; $i++) {
                        $appointment_log_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('lj_appointment_log ', 'APPOINTMENT_LOG_ID')ID FROM DUAL")->result_array();
                        $appointment_log_id = $appointment_log_id[0]['ID'];
                        $updateBarcode = "INSERT INTO lj_appointment_log (APPOINTMENT_LOG_ID, APPOINTMENT_DT_ID, START_TIME, STOP_TIME, REMARKS, USER_ID, BARCODE_NO) VALUES ('$appointment_log_id' ,'$appointment_dt_id', null, null,'$remarks', '$user_id', '$start_barcode' )";
                        $updateMerchantBarcode = "UPDATE lz_merchant_barcode_dt SET APPOINTMENT_LOG_ID = '$appointment_log_id' WHERE BARCODE_NO = '$start_barcode'";
                        $start_barcode = $start_barcode - 1;
                        // var_dump($start_barcode);
                        $update = $this->db->query($updateBarcode);
                        $updateMerchant = $this->db->query($updateMerchantBarcode);
                    }
                    return array("update" => $update, "barcode" => $barcodeExist['DT_ID']);
                }
            }
        } else if ($barcodeExist["status"] == false) {
            // var_dump($barcodeExist);
            // exit;
            return false;
        }
    }

    public function in_Process_Appointment()
    {
        $user_id = $this->input->post('user_id');
        $service_id = $this->input->post('service_id');
        $remarks = $this->input->post('remarks');
        $appointment_id = $this->input->post("appointment_id");
        $start_barcode = $this->input->post("start_barcode");
        $end_barcode = $this->input->post("end_barcode");
        $merchant_id = $this->input->post("merchant_id");
        $label = $this->input->post('label');
        $qr = "SELECT APPOINTMENT_DT_ID FROM lj_appointment_dt WHERE SERVICE_ID = '$service_id' AND APPOINTMENT_ID = '$appointment_id'";
        $result = $this->db->query($qr)->result_array();
        $appointment_dt_id = $result[0]['APPOINTMENT_DT_ID'];
        $update = $this->add_Lot_Barcode_Detail($label, $service_id, $start_barcode, $end_barcode, $appointment_dt_id, $user_id, $remarks, $merchant_id);

        if (count($update['barcode']) > 0) {
            if ($update['update'] == true) {

                $qr = "UPDATE lj_appointment_mt SET APPOINTMENT_STATUS = 2 WHERE APPOINTMENT_ID = '$appointment_id'";
                $result = $this->db->query($qr);
                if ($result == true) {
                    $latestData = $this->get_Log_After_Add_Barcode_Appointment($appointment_id, $start_barcode, $end_barcode, $update['barcode']);
                    $updatedTime = $this->Get_Summary_Appointment_After_Insert_Delete($appointment_id, $appointment_dt_id);

                    if ($latestData == true) {
                        return array("status" => true, "message" => "Record Update", "data" => $latestData['data'], "summary" => $updatedTime['data'], "update_total" => count($update['barcode']), "update_time" => $updatedTime['time'], "total_charge" => $updatedTime['total_charge'], 'packing_cost' => $updatedTime['packing_cost']);

                    } else {
                        return array("status" => false, "message" => "Record Update", "data" => $latestData['data'], "summary" => $updatedTime['data'], "update_total" => count($update['barcode']), "update_time" => $updatedTime['time'], "total_charge" => $updatedTime['total_charge'], 'packing_cost' => $updatedTime['packing_cost']);
                    }
                } else {
                    return array("status" => false, "message" => "Record is not update mt");
                }
            } else {
                return array("status" => false, "message" => "Barcode already consumed");
            }
        } else {
            return array("status" => false, "message" => "Barcode already consumed and Barcode not for this merchant");
        }

    }

    public function get_Log_After_Add_Barcode_Appointment($appointment_id, $start_barcode, $end_barcode, $update)
    {
        $barcode = count($update);
        $qr = "select * from (select
        sd.service_desc,
        lg.appointment_log_id,
        D.service_id,
        em.User_Name,
        lg.barcode_no,
        lg.START_TIME,
        D.APPOINTMENT_DT_ID,
        m.APPOINTMENT_ID
     from lj_appointment_mt m,
        lj_appointment_dt D,
        lj_services sd,
        lj_appointment_log lg,
        EMPLOYEE_MT EM
    where d.appointment_id = '$appointment_id'
         AND m.APPOINTMENT_ID = D.appointment_id
        and d.appointment_dt_id = lg.appointment_dt_id
        AND D.service_id = sd.service_id
        AND EM.EMPLOYEE_ID = m.created_by
        ORDER BY  lg.appointment_log_id DESC)where rownum <= $barcode
        ORDER BY  appointment_log_id asc";
        // AND br.BARCODE_NO = $barcode_No";
        $result = $this->db->query($qr);
        if ($result->num_rows() > 0) {
            return array("status" => true, "data" => $result->result_array());
        } else {
            return array("status" => false, "data" => "No Record");
        }
    }

    public function complete_Appointment()
    {
        $appointment_id = $this->input->post('id');
        $qr = "UPDATE lj_appointment_mt SET APPOINTMENT_STATUS = 3 WHERE APPOINTMENT_ID = '$appointment_id'";
        $result = $this->db->query($qr);
        if ($result == true) {
            return array("status" => true, "message" => "Your appointment is complete");
        } else {
            return array("status" => false, "message" => "Record is not update mt");
        }
    }

    public function check_Lot_Custom_Barcode_Exist($label, $service_id, $customBarcode, $appointment_dt_id, $merchant_id)
    {
        if ($label == "Inventory prep" || $label == "Inventory prep" || $service_id == 3) {
            $qr = "SELECT * from lz_merchant_barcode_dt d, lz_merchant_barcode_mt m WHERE m.mt_id = d.mt_id AND m.POS_STATUS != 1 AND m.merchant_id = '$merchant_id' AND d.appointment_log_id IS NULL AND d.barcode_no =  '$customBarcode'";
            $existBarcode = $this->db->query($qr);
            if ($existBarcode->num_rows() > 0) {
                return array("status" => true);
            } else {
                return array("status" => false);
            }
        }
        if ($label == "Picture" || $label == "picture" || $service_id == 1) {

            $qr = "SELECT * from lz_merchant_barcode_dt d, lz_merchant_barcode_mt m WHERE m.mt_id = d.mt_id AND m.POS_STATUS != 1 AND m.merchant_id = '$merchant_id' AND d.appointment_log_id IS NULL AND d.barcode_no =  '$customBarcode'";
            $existBarcode = $this->db->query($qr);
            if ($existBarcode->num_rows() > 0) {
                return array("status" => true);
            } else {
                return array("status" => false);
            }
        } else {
            return array("status" => false);
        }
    }

    public function add_Lot_CustomBarcode_Barcode_Detail($label, $service_id, $customBarcode, $appointment_dt_id, $merchant_id, $user_id, $remarks)
    {
        $barcodeExist = $this->check_Lot_Custom_Barcode_Exist($label, $service_id, $customBarcode, $appointment_dt_id, $merchant_id);
        if ($barcodeExist["status"] == true) {
            if ($label == "Inventory prep" || $label == "Inventory Prop" || $service_id == 3) {
                $appointment_log_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('lj_appointment_log ', 'APPOINTMENT_LOG_ID')ID FROM DUAL")->result_array();
                $appointment_log_id = $appointment_log_id[0]['ID'];
                $updateBarcode = "INSERT INTO lj_appointment_log (APPOINTMENT_LOG_ID, APPOINTMENT_DT_ID, START_TIME, STOP_TIME, REMARKS, USER_ID, BARCODE_NO) VALUES ('$appointment_log_id' ,'$appointment_dt_id', null, null,'$remarks', '$user_id', '$customBarcode' )";
                $updateMerchantBarcode = "UPDATE lz_merchant_barcode_dt SET APPOINTMENT_LOG_ID = '$appointment_log_id' WHERE BARCODE_NO = '$customBarcode'";
                $update = $this->db->query($updateBarcode);
                $this->db->query($updateMerchantBarcode);
                return $update;

            } else if ($label == "Picture" || $label == "picture" || $service_id == 1) {
                $appointment_log_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('lj_appointment_log ', 'APPOINTMENT_LOG_ID')ID FROM DUAL")->result_array();
                $appointment_log_id = $appointment_log_id[0]['ID'];
                $updateBarcode = "INSERT INTO lj_appointment_log (APPOINTMENT_LOG_ID, APPOINTMENT_DT_ID, START_TIME, STOP_TIME, REMARKS, USER_ID, BARCODE_NO) VALUES ('$appointment_log_id' ,'$appointment_dt_id', null, null,'$remarks', '$user_id', '$customBarcode' )";
                $updateMerchantBarcode = "UPDATE lz_merchant_barcode_dt SET APPOINTMENT_LOG_ID = '$appointment_log_id' WHERE BARCODE_NO = '$customBarcode'";
                $update = $this->db->query($updateBarcode);
                $this->db->query($updateMerchantBarcode);
                return $update;

            }
        } else if ($barcodeExist["status"] == false) {
            return false;
        }
    }

    public function get_Log_After_Add_custonBarcode_Appointment($appointment_id, $customBarcode)
    {
        $qr = "select sd.service_desc,
        D.service_id,
        em.User_Name,
        lg.barcode_no,
        lg.START_TIME,
        D.APPOINTMENT_DT_ID,
        m.APPOINTMENT_ID,
        (select count(1)
            from lz_merchant_barcode_dt dd
           where D.appointment_dt_id = lg.appointment_dt_id
             and D.appointment_id = m.appointment_id
             and lg.appointment_log_id = dd.appointment_log_id) TOTAL_PROCESS_BARCODE
   from lj_appointment_mt  m,
        lj_appointment_dt  D,
        lj_services        sd,
        lj_appointment_log lg,

        EMPLOYEE_MT EM
  where d.appointment_id = '$appointment_id'
    AND m.APPOINTMENT_ID = D.appointment_id
    AND lg.appointment_dt_id = D.APPOINTMENT_DT_ID
    AND D.service_id = sd.service_id
    AND EM.EMPLOYEE_ID = m.created_by
    AND lg.BARCODE_NO = '$customBarcode'
  ORDER BY lg.barcode_no ASC
";
        $result = $this->db->query($qr);
        if ($result->num_rows() > 0) {
            return array("status" => true, "data" => $result->result_array());
        } else {
            return array("status" => false, "data" => "No Record");
        }
    }

    public function custom_Barcode_In_Process()
    {
        $customBarcode = $this->input->post("barcode");
        $user_id = $this->input->post('user_id');
        $service_id = $this->input->post('service_id');
        $remarks = $this->input->post('remarks');
        $appointment_id = $this->input->post("appointment_id");
        $label = $this->input->post("label");
        $merchant_id = $this->input->post("merchant_id");
        $qr = "SELECT APPOINTMENT_DT_ID FROM lj_appointment_dt WHERE SERVICE_ID = '$service_id' AND APPOINTMENT_ID = '$appointment_id'";
        $result = $this->db->query($qr)->result_array();
        $appointment_dt_id = $result[0]['APPOINTMENT_DT_ID'];

        $update = $this->add_Lot_CustomBarcode_Barcode_Detail($label, $service_id, $customBarcode, $appointment_dt_id, $merchant_id, $user_id, $remarks);
        if ($update == true) {
            $qr = "UPDATE lj_appointment_mt SET APPOINTMENT_STATUS = 2 WHERE APPOINTMENT_ID = '$appointment_id'";
            $result = $this->db->query($qr);
            if ($result == true) {
                $latestData = $this->get_Log_After_Add_custonBarcode_Appointment($appointment_id, $customBarcode);
                $updatedTime = $this->Get_Summary_Appointment_After_Insert_Delete($appointment_id, $appointment_dt_id);
                if ($latestData == true) {
                    return array("status" => true, "message" => "Record Update", "data" => $latestData['data'], "summary" => $updatedTime['data'], "update_time" => $updatedTime['time'], "total_charge" => $updatedTime['total_charge'], 'packing_cost' => $updatedTime['packing_cost']);

                } else {
                    return array("status" => false, "message" => "Record Update", "data" => $latestData['data'], "summary" => $updatedTime['data'], "update_time" => $updatedTime['time'], "total_charge" => $updatedTime['total_charge'], 'packing_cost' => $updatedTime['packing_cost']);
                }
            } else {
                return array("status" => false, "message" => "Record is not update mt");
            }
        } else {
            return array("status" => false, "message" => "Barcode already consumed and Barcode not for this merchant");
        }
    }

    public function Get_Lot_Aganist_Appointment_Merchant()
    {
        $merchant_id = $this->input->post("merchant_id");
        $get_mer_lot = $this->db->query("SELECT LOT_ID , LOT_DESC, MERCHANT_ID FROM LOT_DEFINATION_MT WHERE LOT_STATUS = 2 AND MERCHANT_ID = '$merchant_id' ORDER BY LOT_ID DESC")->result_array(); // 2 means pending lot

        return $get_mer_lot;
    }

    public function Get_Appointment_Lot_Barcode_Detail()
    {
        $appointment_id = $this->input->post("appointment_id");
        $merchant_id = $this->input->post("merchant_id");
        $lot_id = $this->input->post("lot_id");
        $lot_Id = $lot_id['value'];
        $service_id = $this->input->post("service_id");
        $qr = "SELECT APPOINTMENT_DT_ID FROM lj_appointment_dt WHERE SERVICE_ID = '$service_id' AND APPOINTMENT_ID = '$appointment_id'";
        $result = $this->db->query($qr)->result_array();
        $appointment_dt_id = $result[0]['APPOINTMENT_DT_ID'];

        $dbQuery = "SELECT BARCODE_NO, APPOINTMENT_LOG_ID
        from lz_merchant_barcode_dt d
       where d.mt_id in (SELECT MT_ID
                           FROM lz_merchant_barcode_mt
                          WHERE LOT_ID = '$lot_Id'
                          AND POS_STATUS != 1
                            AND MERCHANT_ID = '$merchant_id')
         ";
        //  and d.appointment_log_id is null
        $result = $this->db->query($dbQuery);
        if ($result->num_rows() > 0) {
            $data = $result->result_array();
            return array("status" => true, "data" => $data);
        } else {
            return array("status" => false, "message" => "No Available Barcode", "data" => array());
        }
    }
    public function Add_Barcode_Aganist_Lot_And_Barcode()
    {
        $customBarcode = $this->input->post("barcode");
        $user_id = $this->input->post('user_id');
        $service_id = $this->input->post('service_id');
        $remarks = $this->input->post('remarks');
        $appointment_id = $this->input->post("appointment_id");
        $label = $this->input->post("label");
        $merchant_id = $this->input->post("merchant_id");
        $end_barcode = $this->input->post("end_barcode");
        $start_barcode = $this->input->post("start_barcode");
        $lot_id = $this->input->post("lot_id");
        $lot_Id = $lot_id['value'];

        $qr = "SELECT APPOINTMENT_DT_ID FROM lj_appointment_dt WHERE SERVICE_ID = '$service_id' AND APPOINTMENT_ID = '$appointment_id'";
        $result = $this->db->query($qr)->result_array();
        $appointment_dt_id = $result[0]['APPOINTMENT_DT_ID'];

        $dbQuery = "SELECT BARCODE_NO from lz_merchant_barcode_dt d where d.mt_id in (SELECT MT_ID FROM lz_merchant_barcode_mt WHERE LOT_ID = '$lot_Id' AND POS_STATUS !=1  AND MERCHANT_ID = '$merchant_id') and d.appointment_log_id is null";
        $result = $this->db->query($dbQuery);
        if ($result->num_rows() > 0) {
            $data = $result->result_array();
            $total = count($data);
            // var_dump($total);
            foreach ($data as $barcode) {
                // var_dump($barcode['BARCODE_NO']);
                $barcode = $barcode['BARCODE_NO'];
                $appointment_log_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('lj_appointment_log ', 'APPOINTMENT_LOG_ID')ID FROM DUAL")->result_array();
                $appointment_log_id = $appointment_log_id[0]['ID'];
                // var_dump($appointment_log_id);
                $updateBarcode = "INSERT INTO lj_appointment_log (APPOINTMENT_LOG_ID, APPOINTMENT_DT_ID, START_TIME, STOP_TIME, REMARKS, USER_ID, BARCODE_NO) VALUES ('$appointment_log_id' ,'$appointment_dt_id', null, null,'$remarks', '$user_id', '$barcode' )";
                $updateMerchantBarcode = "UPDATE lz_merchant_barcode_dt SET APPOINTMENT_LOG_ID = '$appointment_log_id' WHERE BARCODE_NO = '$barcode'";
                $data = $this->db->query($updateBarcode);
                $updatemerc = $this->db->query($updateMerchantBarcode);
            }
            return array("status" => true, "message" => "Record Updated");

        } else {

            return array("status" => false, "message" => "Barcode Already Consumed OR Use For POS");
        }

    }
    public function Save_All_Lot_Barcode()
    {
        $data = $this->input->post("data");
        $appointment_id = $this->input->post('appointment_id');
        $user_id = $this->input->post('user_id');
        $service_id = $this->input->post('service_id');
        $remarks = $this->input->post('remarks');
        $total = count($data);
        // var_dump($total);
        $qr = "SELECT APPOINTMENT_DT_ID FROM lj_appointment_dt WHERE SERVICE_ID = '$service_id' AND APPOINTMENT_ID = '$appointment_id'";
        $result = $this->db->query($qr)->result_array();
        $appointment_dt_id = $result[0]['APPOINTMENT_DT_ID'];
        foreach ($data as $barcodes) {
            $barcode = $barcodes['BARCODE_NO'];
            $appointment_log_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('lj_appointment_log ', 'APPOINTMENT_LOG_ID')ID FROM DUAL")->result_array();
            $appointment_log_id = $appointment_log_id[0]['ID'];
            $updateBarcode = "INSERT INTO lj_appointment_log (APPOINTMENT_LOG_ID, APPOINTMENT_DT_ID, START_TIME, STOP_TIME, REMARKS, USER_ID, BARCODE_NO) VALUES ('$appointment_log_id' ,'$appointment_dt_id', null, null,'$remarks', '$user_id', '$barcode' )";
            $updateMerchantBarcode = "UPDATE lz_merchant_barcode_dt SET APPOINTMENT_LOG_ID = '$appointment_log_id' WHERE BARCODE_NO = '$barcode'";
            $update = $this->db->query($updateBarcode);
            $this->db->query($updateMerchantBarcode);
        }
        $qr = "UPDATE lj_appointment_mt SET APPOINTMENT_STATUS = 2 WHERE APPOINTMENT_ID = '$appointment_id'";
        $result = $this->db->query($qr);
        if ($result == true) {
            $result = $this->get_Log_After_Add_Barcode_Appointment($appointment_id, null, null, $data);
            if ($result['status'] == true) {
                return array("status" => true, "data" => $result['data'], "message" => "Reacord Updated", "total_update" => count($data));
            } else {
                return array("status" => true, "data" => array(), "message" => "Reacord Not Updated");
            }
        }

    }
    /**
     *
     * Search Appointment
     *
     */

    //  public function
    public function search_custom_barcode_in_process()
    {
        $customBarcode = $this->input->post("barcode");
        // $startDate = $this->input->post('startDate');
        // $endDate = $this->input->post('endDate');
        $user_id = $this->input->post('user_id');
        $service_id = $this->input->post('service_id');
        $remarks = $this->input->post('remarks');
        $appointment_id = $this->input->post("appointment_id");
        $label = $this->input->post("label");
        $merchant_id = $this->input->post("merchant_id");
        $qr = "SELECT APPOINTMENT_DT_ID FROM lj_appointment_dt WHERE SERVICE_ID = '$service_id' AND APPOINTMENT_ID = '$appointment_id'";
        $result = $this->db->query($qr)->result_array();
        $appointment_dt_id = $result[0]['APPOINTMENT_DT_ID'];
        $update = $this->add_Lot_CustomBarcode_Barcode_Detail($label, $service_id, $customBarcode, $appointment_dt_id, $merchant_id, $user_id, $remarks);
        if ($update == true) {
            $qr = "UPDATE lj_appointment_mt SET APPOINTMENT_STATUS = 2 WHERE APPOINTMENT_ID = '$appointment_id'";
            $result = $this->db->query($qr);
            if ($result == true) {
                $latestData = $this->get_Log_After_Add_custonBarcode_Appointment($appointment_id, $customBarcode);
                if ($latestData == true) {
                    return array("status" => true, "message" => "Record Update", "data" => $latestData['data']);

                } else {
                    return array("status" => false, "message" => "Record Update", "data" => $latestData['data']);
                }
            } else {
                return array("status" => false, "message" => "Record is not update mt");
            }
        } else {
            return array("status" => false, "message" => "Barcode already consumed and Barcode not for this merchant");
        }

    }
    public function get_Specific_Log_Detail()
    {
        $appointment_id = $this->input->post("cell");
        $qr = "select
        sd.service_desc,
        D.service_id,
        em.User_Name,
        l.APPOINTMENT_LOG_ID,
        l.START_TIME,
        D.APPOINTMENT_DT_ID,
        m.APPOINTMENT_ID,
        l.barcode_no
        from lj_appointment_mt m,
        lj_appointment_dt D,
        lj_services sd,
        lj_appointment_log l,
        EMPLOYEE_MT EM
        where d.appointment_id = '$appointment_id'
        AND m.APPOINTMENT_ID = D.appointment_id
        and d.appointment_dt_id = l.appointment_dt_id
        AND D.service_id = sd.service_id
        AND l.BARCODE_NO IS NOT NULL
        AND EM.EMPLOYEE_ID = m.created_by ORDER BY l.barcode_no ASC";
        $result = $this->db->query($qr);
        if ($result->num_rows() > 0) {
            return array("status" => true, "data" => $result->result_array());
        } else {
            return array("status" => false, "message" => "No Record Found");
        }

    }

    public function get_Specific_Log_Detail_Using_Param($appointment_id)
    {
        $qr = "select
        sd.service_desc,
        D.service_id,
        em.User_Name,
        l.APPOINTMENT_LOG_ID,
        l.START_TIME,
        D.APPOINTMENT_DT_ID,
        m.APPOINTMENT_ID,
        l.barcode_no
        from lj_appointment_mt m,
        lj_appointment_dt D,
        lj_services sd,
        lj_appointment_log l,
        EMPLOYEE_MT EM
        where d.appointment_id = '$appointment_id'
        AND m.APPOINTMENT_ID = D.appointment_id
        and d.appointment_dt_id = l.appointment_dt_id
        AND D.service_id = sd.service_id
        AND l.BARCODE_NO IS NOT NULL
        AND EM.EMPLOYEE_ID = m.created_by ORDER BY l.barcode_no ASC";
        $result = $this->db->query($qr);
        if ($result->num_rows() > 0) {
            return array("status" => true, "data" => $result->result_array());
        } else {
            return array("status" => false, "message" => "No Record Found");
        }

    }

    public function Save_Date_Appointmetnt_Barcode_Log()
    {
        $start_date = $this->input->post("startDate");
        $end_date = $this->input->post("endDate");
        $appointment_id = $this->input->post("appointment_id");
        $service_id = $this->input->post("service_id");
        $save = $this->input->post('save');
        $qr = "SELECT APPOINTMENT_DT_ID FROM lj_appointment_dt WHERE SERVICE_ID = '$service_id' AND APPOINTMENT_ID = '$appointment_id'";
        $result = $this->db->query($qr)->result_array();
        $appointment_dt_id = $result[0]['APPOINTMENT_DT_ID'];
        // var_dump($appointment_dt_id);
        $qr = "select decode(Day,0,0,Day*86400) + decode(hour,0,0,hour*3600) + decode(Minute,0,0,Minute*60) + second total_second from (
            SELECT EXTRACT(Day FROM(to_date('$end_date', 'DD/MM/YYYY HH24:MI:SS') - to_date('$start_date', 'DD/MM/YYYY HH24:MI:SS')) DAY TO SECOND) as Day,
 EXTRACT(HOUR FROM(to_date('$end_date', 'DD/MM/YYYY HH24:MI:SS') - to_date('$start_date', 'DD/MM/YYYY HH24:MI:SS')) DAY TO SECOND) as Hour,
 EXTRACT(Minute FROM(to_date('$end_date', 'DD/MM/YYYY HH24:MI:SS') - to_date('$start_date', 'DD/MM/YYYY HH24:MI:SS')) DAY TO SECOND) as Minute,
 EXTRACT(SECOND FROM(to_date('$end_date', 'DD/MM/YYYY HH24:MI:SS') - to_date('$start_date', 'DD/MM/YYYY HH24:MI:SS')) DAY TO SECOND) as second
  FROM dual)";
        $result = $this->db->query($qr)->result_array();
        if ($save == 'all') {
            $qr = "SELECT * FROM lj_appointment_log WHERE APPOINTMENT_DT_ID = '$appointment_dt_id' AND BARCODE_NO IS NOT NULL";
        } else {
            $qr = "SELECT * FROM lj_appointment_log WHERE APPOINTMENT_DT_ID ='$appointment_dt_id' AND START_TIME is NULL AND STOP_TIME is NULL and barcode_no is not null";
        }
        // $qr = "SELECT * FROM lj_appointment_log WHERE APPOINTMENT_DT_ID ='$appointment_dt_id' AND START_TIME is NULL AND STOP_TIME is NULL and barcode_no is not null";
        // Update All Appointment Time
        // $qr = "SELECT * FROM lj_appointment_log WHERE APPOINTMENT_DT_ID = '$appointment_dt_id' AND BARCODE_NO IS NOT NULL";
        $resbarcode = $this->db->query($qr);

        if ($resbarcode->num_rows() > 0) {

            $result1 = $resbarcode->result_array();
            $total_barcode = count($result1);
            //var_dump($total_barcode);exit;
            $time = floor($result[0]['TOTAL_SECOND'] / $total_barcode);

            for ($i = 0; $i < $total_barcode; $i++) {
                $qr = "select to_char(start_time, 'MM/DD/RRRR HH24:MI:SS') start_time , to_char(stop_time, 'MM/DD/RRRR HH24:MI:SS') stop_time from (
                    select sysdate start_time, sysdate + interval '$time'  second stop_time from dual)";

                $res = $this->db->query($qr)->result_array();
                //var_dump($res[0]['START_TIME'],$time);exit;

                //$start_time = to_date($res[0]['START_TIME'], 'MM/DD/RRRR HH24:MI:SS');
                $start_time = "TO_DATE('" . $res[0]['START_TIME'] . "', 'MM/DD/RRRR HH24:MI:SS')";
                $stop_time = "TO_DATE('" . $res[0]['STOP_TIME'] . "', 'MM/DD/RRRR HH24:MI:SS')";
                //$stop_time = "to_date($res[0]['STOP_TIME'], 'MM/DD/RRRR HH24:MI:SS')";
                // $barcode = $result1[$i]['BARCODE_NO'];
                $APPOINTMENT_LOG_ID = $result1[$i]['APPOINTMENT_LOG_ID'];
                $qry = "UPDATE lj_appointment_log  SET START_TIME = $start_time, STOP_TIME = $stop_time WHERE APPOINTMENT_LOG_ID ='$APPOINTMENT_LOG_ID' ";
                $res = $this->db->query($qry);
            }

            $total_amount = " select service_id, appointment_id,service_type,service_desc,charges, cnt , charges * cnt total_amount from
            (select s.service_id, d.appointment_id,sr.service_type,s.service_desc,sr.charges , (select count(1)
              from lj_appointment_log     ll
             where ll.appointment_dt_id = d.appointment_dt_id) cnt
            from lj_appointment_dt d, lj_service_rate sr,lj_services s
            where d.appointment_id = '$appointment_id'
            AND d.service_id = sr.service_id
            and s.service_id = sr.service_id)";
            $result = $this->db->query($total_amount);
            $data = $this->Get_Time_Summary($appointment_id);

            $result = $result->result_array();
            $cost = $result[0]['CHARGES'];
            $cost_per_sec = $cost / 120;
            $total_charge = $cost_per_sec * $data['total_second'];
            $allRecord = $this->get_Specific_Log_Detail_Using_Param($appointment_id);
            return array("status" => $res, "message" => "recod Updated", "time" => $data['data'], "data" => $allRecord['data'], 'total_charge' => $total_charge);
        } else {
            return array("status" => false, "message" => "all record aleady update");
        }
        // var_dump($result['TOTAL_SECoND']);
        // var_dump($end_date);

    }

    public function Get_Summary_Appointment_After_Insert_Delete($appointment_id, $appointment_dt_id)
    {
        // $total_amount = " select service_id, appointment_id,service_type,service_desc,charges, cnt , charges * cnt total_amount from
        // (select s.service_id, d.appointment_id,sr.service_type,s.service_desc,sr.charges , (select count(1)
        //   from lj_appointment_log     ll
        //  where ll.appointment_dt_id = d.appointment_dt_id and ll.barcode_no is not null) cnt
        // from lj_appointment_dt d, lj_service_rate sr,lj_services s
        // where d.appointment_id = '$appointment_id'
        // AND d.service_id = sr.service_id
        // and s.service_id = sr.service_id)";
        $total_amount = "select service_id,
        appointment_id,
        service_type,
        service_desc,
        charges,
        cnt,
        PACKING_COST,
        charges * cnt total_amount
   from (select s.service_id,
                d.appointment_id,
                sr.service_type,
                s.service_desc,
                sr.charges,
                (select count(1)
                   from lj_appointment_log ll
                  where ll.appointment_dt_id = d.appointment_dt_id
                    and ll.barcode_no is not null) cnt,
                (select SUM(ABS(lpm.packing_cost))
                   from lj_appointment_log        ll,
                        lj_appointment_packing_mt lp,
                        lz_packing_type_mt        lpm
                 --  lj_appointment_dt         d
                  where ll.appointment_dt_id = d.appointment_dt_id
                    AND lp.appointment_log_id = ll.appointment_log_id
                    AND lp.packing_id = lpm.packing_id
                    and ll.barcode_no is not null) PACKING_COST
           from lj_appointment_dt d, lj_service_rate sr, lj_services s
         -- lj_appointment_packing_mt lp,
         -- lj_appointment_log        ll,
         --lz_packing_type_mt        lpm
          where d.appointment_id = '$appointment_id'
            AND d.service_id = sr.service_id
               --AND lp.appointment_log_id = ll.appointment_log_id
               --AND lp.packing_id = lpm.packing_id
            and s.service_id = sr.service_id)";
        $result = $this->db->query($total_amount);
        $time = $this->Get_Time_Summary($appointment_id);

        $result = $result->result_array();
        $cost = $result[0]['CHARGES'];
        $cost_per_sec = $cost / 120;
        $total_charge = $cost_per_sec * $time['total_second'];
        $total_charge = $total_charge + $result[0]['PACKING_COST'];
        return array("status" => true, "data" => $result, "time" => $time['data'], "total_charge" => $total_charge, "packing_cost" => $result[0]['PACKING_COST']);

    }

    public function delete_Log_Appointment_Services()
    {
        $service_id = $this->input->post("service_id");
        $barcode_no = $this->input->post("barcode_no");
        $appointment_dt_id = $this->input->post("appointment_dt_id");
        $appointment_log_id = $this->input->post("appointment_log_id");
        $appointment_id = $this->input->post("appointment_id");

        $qry = "SELECT * FROM lj_appointment_log WHERE APPOINTMENT_LOG_ID = '$appointment_log_id'";
        $res = $this->db->query($qry);
        if ($res->num_rows() > 0) {
            $qr = "UPDATE  lz_merchant_barcode_dt SET APPOINTMENT_LOG_ID = null WHERE  BARCODE_NO = '$barcode_no'";
            $delAppointmentpacking = "DELETE FROM lj_appointment_packing_mt WHERE APPOINTMENT_LOG_ID = '$appointment_log_id' ";
            $del = "DELETE FROM lj_appointment_log WHERE APPOINTMENT_LOG_ID = '$appointment_log_id'";
        }
        $result = $this->db->query($qr);
        $delappointpacking = $this->db->query($delAppointmentpacking);
        $delete = $this->db->query($del);
        $updatedTime = $this->Get_Summary_Appointment_After_Insert_Delete($appointment_id, $appointment_dt_id);
        if ($result == true && $delete == true) {
            $qr = "SELECT * FROM lj_appointment_log WHERE APPOINTMENT_DT_ID ='$appointment_dt_id' AND barcode_no is not null";
            $result = $this->db->query($qr);
            if ($result->num_rows() > 0) {
                return array("status" => true, "message" => "Barcode Delete Successfuly", "summary" => $updatedTime['data'], "update_time" => $updatedTime['time'], "total_charge" => $updatedTime['total_charge'], 'packing_cost' => $updatedTime['packing_cost']);
            } else {
                $appointment_mt = "UPDATE lj_appointment_mt SET APPOINTMENT_STATUS = '1'  WHERE APPOINTMENT_ID = '$appointment_id'";
                $res = $this->db->query($appointment_mt);
                if ($res == true) {
                    return array("status" => true, "message" => "Barcode Delete Successfuly", 'appointmentstatus' => 'Approved', "summary" => $updatedTime['data'], "update_time" => $updatedTime['time'], "total_charge" => $updatedTime['total_charge'], 'packing_cost' => $updatedTime['packing_cost']);
                } else {
                    return array("status" => false, "message" => "Status Not Update");
                }
            }

        } else {
            return array("status" => false, "message" => "Record Not Found");
        }

    }
/*

Delete ALL Appointments

 */
    public function Delete_All_Appointment_Barcode()
    {
        $data = $this->input->post('data');
        $appointment_id = $data[0]['APPOINTMENT_ID'];
        $qr = "SELECT APPOINTMENT_DT_ID FROM lj_appointment_dt WHERE APPOINTMENT_ID = '$appointment_id'";
        $result = $this->db->query($qr)->result_array();
        $appointment_dt_id = $result[0]['APPOINTMENT_DT_ID'];
        if (is_array($data)) {
            foreach ($data as $appointmentData) {
                $appointment_log_id = $appointmentData['APPOINTMENT_LOG_ID'];
                $barcode_no = $appointmentData['BARCODE_NO'];
                $qry = "SELECT * FROM lj_appointment_log WHERE APPOINTMENT_LOG_ID = '$appointment_log_id' OR BARCODE_NO = '$barcode_no'";
                $res = $this->db->query($qry);
                if ($res->num_rows() > 0) {
                    $qr = "UPDATE  lz_merchant_barcode_dt SET APPOINTMENT_LOG_ID = null WHERE  BARCODE_NO = '$barcode_no'";
                    $del = "DELETE FROM lj_appointment_log WHERE APPOINTMENT_LOG_ID = '$appointment_log_id' OR BARCODE_NO = '$barcode_no'";
                    $delAppointmentpacking = "DELETE FROM lj_appointment_packing_mt WHERE APPOINTMENT_LOG_ID = '$appointment_log_id' ";
                }
                $result = $this->db->query($qr);
                $delappointpacking = $this->db->query($delAppointmentpacking);
                $delete = $this->db->query($del);
            }
            $updatedTime = $this->Get_Summary_Appointment_After_Insert_Delete($appointment_id, $appointment_dt_id);
            $appointment_mt = "UPDATE lj_appointment_mt SET APPOINTMENT_STATUS = '1'  WHERE APPOINTMENT_ID = '$appointment_id'";
            $res = $this->db->query($appointment_mt);
            if ($res == true) {
                return array("status" => true, "message" => "Barcode Delete Successfuly", 'appointmentstatus' => 'Approved', "summary" => $updatedTime['data'], "update_time" => $updatedTime['time'], "total_charge" => $updatedTime['total_charge'], 'packing_cost' => $updatedTime['packing_cost']);
            } else {
                return array("status" => false, "message" => "Status Not Update");
            }
        }
    }

    public function Diff_Mins()
    {
        $start_date = $this->input->post("startDate");
        $end_date = $this->input->post("endDate");
        $qr = "select decode(Day,0,0,Day*86400) + decode(hour,0,0,hour*3600) + decode(Minute,0,0,Minute*60) + second total_second from (
            SELECT EXTRACT(Day FROM(to_date('$end_date', 'DD/MM/YYYY HH24:MI:SS') - to_date('$start_date', 'DD/MM/YYYY HH24:MI:SS')) DAY TO SECOND) as Day,
 EXTRACT(HOUR FROM(to_date('$end_date', 'DD/MM/YYYY HH24:MI:SS') - to_date('$start_date', 'DD/MM/YYYY HH24:MI:SS')) DAY TO SECOND) as Hour,
 EXTRACT(Minute FROM(to_date('$end_date', 'DD/MM/YYYY HH24:MI:SS') - to_date('$start_date', 'DD/MM/YYYY HH24:MI:SS')) DAY TO SECOND) as Minute,
 EXTRACT(SECOND FROM(to_date('$end_date', 'DD/MM/YYYY HH24:MI:SS') - to_date('$start_date', 'DD/MM/YYYY HH24:MI:SS')) DAY TO SECOND) as second
  FROM dual)";
        $result = $this->db->query($qr);
        $timesec = $result->result_array();
        $sec = $timesec[0]["TOTAL_SECOND"];
        $time = "SELECT
        TO_CHAR(TRUNC( $sec/3600),'FM9900') || ':' ||
        TO_CHAR(TRUNC(MOD( $sec,3600)/60),'FM00') || ':' ||
        TO_CHAR(MOD( $sec,60),'FM00') TOTAL_TIME
    FROM DUAL";
        $res = $this->db->query($time);
        return array("status" => true, "data" => $res->result_array());
    }

    public function Save_Appointment_Packing()
    {
        $appointment_id = $this->input->post('appointment_id');
        $appointment_log_id = $this->input->post('appointment_log_id');
        $appointment_dt_id = $this->input->post('appointment_dt_id');
        $service_id = $this->input->post('service_id');
        $packing_id = $this->input->post('packing_id');
        $user_id = $this->input->post('user_id');
        // if (is_array($packing_id)) {
        //     foreach ($packing_id as $id) {
        if (is_null($packing_id)) {
            $deletePacking = "DELETE FROM lj_appointment_packing_mt WHERE APPOINTMENT_LOG_ID = '$appointment_log_id'";
            $result = $this->db->query($deletePacking);
            $result = $this->Get_Packing_Detail_Appointment_using_appointment_log($appointment_log_id);
            return array('status' => true, "message" => "Packing Deleted SuccessFully", 'data' => $result['data']);
        }
        //     }
        // }
        $deletePacking = "DELETE FROM lj_appointment_packing_mt WHERE APPOINTMENT_LOG_ID = '$appointment_log_id'";
        $result = $this->db->query($deletePacking);
        if (is_array($packing_id)) {
            foreach ($packing_id as $id) {
                $packing_id = $id['value'];
                $qry = "INSERT INTO lj_appointment_packing_mt (APPOINTMENT_PACKING_ID, APPOINTMENT_LOG_ID, PACKING_ID, INSERTED_BY, INSERTED_DATE) VALUES (GET_SINGLE_PRIMARY_KEY('lj_appointment_packing_mt ', 'APPOINTMENT_PACKING_ID'), '$appointment_log_id','$packing_id', '$user_id', sysdate)";
                $result = $this->db->query($qry);
            }
        }
        $result = $this->Get_Packing_Detail_Appointment_using_appointment_log($appointment_log_id);
        $updatedTime = $this->Get_Summary_Appointment_After_Insert_Delete($appointment_id, $appointment_dt_id);
        return array('status' => true, "message" => "Record Updated", 'data' => $result['data'], "summary" => $updatedTime['data'], "update_time" => $updatedTime['time'], "total_charge" => $updatedTime['total_charge'], 'packing_cost' => $updatedTime['packing_cost']);
    }
    public function Add_Packing_All_Appointment_Barcode()
    {
        $data = $this->input->post('data');
        $packing_id = $this->input->post('packing_id');
        $user_id = $this->input->post('user_id');
        // var_dump($data[0]['APPOINTMENT_ID']);
        // exit;
        $appointment_id = $data[0]['APPOINTMENT_ID'];
        foreach ($data as $datas) {
            $appointment_log_id = $datas['APPOINTMENT_LOG_ID'];
            $deletePacking = "DELETE FROM lj_appointment_packing_mt WHERE APPOINTMENT_LOG_ID = '$appointment_log_id'";
            $result = $this->db->query($deletePacking);
        }
        foreach ($data as $packingData) {
            foreach ($packing_id as $id) {
                $value = $id['value'];
                $appointment_log_id = $packingData['APPOINTMENT_LOG_ID'];
                // $appointment_dt_id = $data['APPOINTMENT_DT_ID'];
                $qry = "INSERT INTO lj_appointment_packing_mt (APPOINTMENT_PACKING_ID, APPOINTMENT_LOG_ID, PACKING_ID, INSERTED_BY, INSERTED_DATE) VALUES (GET_SINGLE_PRIMARY_KEY('lj_appointment_packing_mt ', 'APPOINTMENT_PACKING_ID'), '$appointment_log_id','$value', '$user_id', sysdate)";
                $result = $this->db->query($qry);
            }
        }
        $result = $this->Get_Packing_Detail_Appointment_using_param($appointment_id);
        $updatedTime = $this->Get_Summary_Appointment_After_Insert_Delete($appointment_id, null);
        return array('status' => true, "message" => "Record Updated", 'data' => $result['data'], "summary" => $updatedTime['data'], "update_time" => $updatedTime['time'], "total_charge" => $updatedTime['total_charge'], 'packing_cost' => $updatedTime['packing_cost']);
    }

    public function Get_Packing_Detail_Appointment()
    {
        $appointment_log_id = $this->input->post('appointment_log_id');
        $appointment_id = $this->input->post('appointment_id');
        $qry = "select
        sd.service_desc,
        D.service_id,
        l.APPOINTMENT_LOG_ID,
        D.APPOINTMENT_DT_ID,
        m.APPOINTMENT_ID,
        l.barcode_no,
        lp.packing_id,
        lpm.packing_name,
        lpm.packing_type,
        lpm.packing_length,
        lpm.packing_width,
        lpm.packing_heigth
        from lj_appointment_mt m,
        lj_appointment_dt D,
        lj_services sd,
        lj_appointment_log l,
        lj_appointment_packing_mt lp,
        lz_packing_type_mt lpm,
        EMPLOYEE_MT EM
        where d.appointment_id = '$appointment_id'
        AND m.APPOINTMENT_ID = D.appointment_id
        and d.appointment_dt_id = l.appointment_dt_id
        AND D.service_id = sd.service_id
        AND lp.appointment_log_id = l.appointment_log_id
       AND lp.packing_id = lpm.packing_id
        AND l.BARCODE_NO IS NOT NULL
        AND EM.EMPLOYEE_ID = m.created_by ORDER BY l.barcode_no ASC";

        $result = $this->db->query($qry);
        if ($result->num_rows() > 0) {
            return array("status" => true, "data" => $result->result_array());
        } else {
            return array("status" => false, "data" => array());
        }
    }

    public function Get_Packing_Detail_Appointment_using_appointment_log($appointment_log_id)
    {
        $qry = "select
        sd.service_desc,
        D.service_id,
        l.APPOINTMENT_LOG_ID,
        D.APPOINTMENT_DT_ID,
        m.APPOINTMENT_ID,
        l.barcode_no,
        lp.packing_id,
        lpm.packing_name,
        lpm.packing_type,
        lpm.packing_length,
        lpm.packing_width,
        lpm.packing_heigth
        from lj_appointment_mt m,
        lj_appointment_dt D,
        lj_services sd,
        lj_appointment_log l,
        lj_appointment_packing_mt lp,
        lz_packing_type_mt lpm,
        EMPLOYEE_MT EM
        where l.appointment_log_id = '$appointment_log_id'
        AND m.APPOINTMENT_ID = D.appointment_id
        and d.appointment_dt_id = l.appointment_dt_id
        AND D.service_id = sd.service_id
        AND lp.appointment_log_id = l.appointment_log_id
       AND lp.packing_id = lpm.packing_id
        AND l.BARCODE_NO IS NOT NULL
        AND EM.EMPLOYEE_ID = m.created_by ORDER BY l.barcode_no ASC";

        $result = $this->db->query($qry);
        if ($result->num_rows() > 0) {
            return array("status" => true, "data" => $result->result_array());
        } else {
            return array("status" => false, "data" => array());
        }
    }
    public function Get_Packing_Detail_Appointment_using_param($appointment_id)
    {

        $qry = "select
        sd.service_desc,
        D.service_id,
        l.APPOINTMENT_LOG_ID,
        D.APPOINTMENT_DT_ID,
        m.APPOINTMENT_ID,
        l.barcode_no,
        lp.packing_id,
        lpm.packing_name,
        lpm.packing_type,
        lpm.packing_length,
        lpm.packing_width,
        lpm.packing_heigth
        from lj_appointment_mt m,
        lj_appointment_dt D,
        lj_services sd,
        lj_appointment_log l,
        lj_appointment_packing_mt lp,
        lz_packing_type_mt lpm,
        EMPLOYEE_MT EM
        where d.appointment_id = '$appointment_id'
        AND m.APPOINTMENT_ID = D.appointment_id
        and d.appointment_dt_id = l.appointment_dt_id
        AND D.service_id = sd.service_id
        AND lp.appointment_log_id = l.appointment_log_id
       AND lp.packing_id = lpm.packing_id
        AND l.BARCODE_NO IS NOT NULL
        AND EM.EMPLOYEE_ID = m.created_by ORDER BY l.barcode_no ASC";

        $result = $this->db->query($qry);
        if ($result->num_rows() > 0) {
            return array("status" => true, "data" => $result->result_array());
        } else {
            return array("status" => false, "data" => array());
        }
    }
    public function search_Barcode()
    {
        $variable = $this->input->post('search_barcode');
        $merchant_id = $this->input->post('merchant_id');
        if (!$variable) {
            return array('status' => false, 'message' => "Search is empty!");
        }
        $data = trim($variable);
        $str = explode(' ', $data);
        $description = "";
        $i = 1;
        foreach ($str as $key) {
            if ($i === 1) {
                $description .= "  UPPER(l.MPN_DESCRIPTION) LIKE UPPER('%$key%')";
            } else {
                $description .= " AND  UPPER(l.MPN_DESCRIPTION) LIKE UPPER('%$key%') ";
            }
            $i++;
        }

        $qr = "select d.barcode_no,
        l.mpn_description,
        l.card_upc,
        l.card_mpn,
        b.ebay_item_id,
        decode(d.appointment_log_id,0,null,d.appointment_log_id) appointment_log_id
       from lz_merchant_barcode_mt m,
        lz_merchant_barcode_dt d,
        lz_special_lots        l,
        lz_barcode_mt          b
  where m.mt_id = d.mt_id
  and m.POS_STATUS != 1
  and d.barcode_no = l.barcode_prv_no(+)
  and b.barcode_no(+) = d.barcode_no
    and m.merchant_id = '$merchant_id'
    and (l.barcode_prv_no LIKE '%$variable%' OR  b.ebay_item_id like '%$variable%' OR  ($description))";
        $result = $this->db->query($qr);
        if ($result->num_rows() > 0) {
            return array("status" => true, "data" => $result->result_array());
        } else {
            return array("status" => false, "data" => array(), "message" => "No Reacod Found");
        }
    }

/**
 *
 *
 * END Create Appointment  Models
 * Genrate Billing Model
 *
 *
 */

    public function get_Packing_Type()
    {
        $qr = "SELECT * FROM lz_packing_type_mt";
        $data = $this->db->query($qr);
        if ($data->num_rows() > 0) {
            $result = array("status" => true, "data" => $data->result_array());
        } else {
            $result = array("status" => false, "data" => "No record in DB");

        }
        return $result;
    }

    public function genrate_Service_Packing_Bill($data, $bill_type)
    {
        if ($bill_type == 'service_billing') {
            if (is_array($data[4])) {
                $startDate = date_create($data[4][0]);
                // date_add($startDate, date_interval_create_from_date_string("5 hours"));
                $startDate = date_format(@$startDate, 'd/m/y H:i');
                $endDate = date_create($data[4][1]);
                // date_add($endDate, date_interval_create_from_date_string("5 hours"));
                $endDate = date_format(@$endDate, 'd/m/y H:i');
                // $startDate = $data[4][0];
                // $endDate = $data[4][1];
                // var_dump($endDate);
                // exit;
                $qr = "INSERT INTO lj_service_charges (STORAGE_ID, SERVICE_ID, QTY, RATE, FROMDATE, TODATE, CREATED_DATE, CREATED_BY, MERCHANT_ID) VALUES (GET_SINGLE_PRIMARY_KEY('lj_service_charges', 'STORAGE_ID'), '$data[1]', '$data[2]', '$data[3]',TO_DATE('$startDate', 'dd/MM/yy HH24:MI'), TO_DATE('$endDate', 'dd/MM/yy HH24:MI'), sysdate, '$data[5]','$data[0]')";
                $res = $this->db->query($qr);
                $latestId = ("SELECT STORAGE_ID FROM lj_service_charges  where CREATED_DATE = (select max(CREATED_DATE) from lj_service_charges)");
                $data = $this->db->query($latestId)->result_array();
                $latestId = $data[0]['STORAGE_ID'];
                $latestData = $this->get_Latest_Service_Bill($latestId);
                if ($res == true || $latestData) {
                    return $result = array("status" => true, "message" => "Reacord Inserted", "data" => $latestData);
                } else {
                    return $result = array("status" => false, "message" => "Reacord Not Inserted");
                }
            } else {
                $startDate = date_create($data[4]);
                // date_add($startDate, date_interval_create_from_date_string("5 hours"));
                $startDate = date_format(@$startDate, 'd/m/y H:i');
                // var_dump($startDate);
                // exit;

                $qr = "INSERT INTO lj_service_charges (STORAGE_ID, SERVICE_ID, QTY, RATE, FROMDATE, TODATE, CREATED_DATE, CREATED_BY, MERCHANT_ID) VALUES (GET_SINGLE_PRIMARY_KEY('lj_service_charges', 'STORAGE_ID'), '$data[1]', '$data[2]', '$data[3]',TO_DATE('$startDate', 'dd/MM/yy HH24:MI'), TO_DATE('$startDate', 'dd/MM/yy HH24:MI'), sysdate, '$data[5]','$data[0]')";
                $res = $this->db->query($qr);
                $latestId = ("SELECT STORAGE_ID FROM lj_service_charges  where CREATED_DATE = (select max(CREATED_DATE) from lj_service_charges)");
                $data = $this->db->query($latestId)->result_array();
                $latestId = $data[0]['STORAGE_ID'];
                $latestData = $this->get_Latest_Service_Bill($latestId);
                if ($res == true || $latestData) {
                    return $result = array("status" => true, "message" => "Reacord Inserted", "data" => $latestData);
                } else {
                    return $result = array("status" => false, "message" => "Reacord Not Inserted");
                }
            }

        }

        if ($bill_type == 'packing_billing') {
            if (is_array($data[4])) {
                $startDate = date_create($data[4][0]);
                date_add($startDate, date_interval_create_from_date_string("5 hours"));
                $startDate = date_format(@$startDate, 'd/m/y');
                $endDate = date_create($data[4][1]);
                date_add($endDate, date_interval_create_from_date_string("5 hours"));
                $endDate = date_format(@$endDate, 'd/m/y');

                $qr = "INSERT INTO lj_packing_charges (PACKING_CHARGE_ID, PACKING_ID, QTY, RATE, FROMDATE, TODATE, CREATED_DATE, CREATED_BY ) VALUES (GET_SINGLE_PRIMARY_KEY('lj_packing_charges', 'PACKING_CHARGE_ID'), '$data[1]', '$data[2]', '$data[3]',TO_DATE('$startDate', 'dd/MM/yy HH24:MI'), TO_DATE('$endDate', 'dd/MM/yy HH24:MI'), sysdate,  '$data[0]')";
                $res = $this->db->query($qr);
                if ($res == true) {
                    return $result = array("status" => true, "message" => "Reacord Inserted");
                } else {
                    return $result = array("status" => false, "message" => "Reacord Not Inserted");
                }
            } else {
                $startDate = date_create($data[4]);
                date_add($startDate, date_interval_create_from_date_string("5 hours"));
                $startDate = date_format(@$startDate, 'd/m/y');
                $qr = "INSERT INTO lj_packing_charges (PACKING_CHARGE_ID, PACKING_ID, QTY, RATE, FROMDATE, TODATE, CREATED_DATE, CREATED_BY) VALUES (GET_SINGLE_PRIMARY_KEY('lj_packing_charges', 'PACKING_CHARGE_ID'), '$data[1]', '$data[2]', '$data[3]',TO_DATE('$startDate', 'dd/MM/yy HH24:MI'), TO_DATE('$startDate', 'dd/MM/yy HH24:MI'), sysdate, '$data[0]')";
                $res = $this->db->query($qr);
                if ($res == true) {
                    return $result = array("status" => true, "message" => "Reacord Inserted");
                } else {
                    return $result = array("status" => false, "message" => "Reacord Not Inserted");
                }
            }
        }
    }

    public function get_Latest_Service_Bill($id)
    {
        $qr = "SELECT SB.* , (SB.QTY*SB.RATE) AMOUNT, M.CONTACT_PERSON, TO_CHAR(SB.CREATED_DATE, 'DD/MM/YY HH24:MI:SS') CREATED_DATE, TO_CHAR(SB.FROMDATE, 'DD/MM/YY HH24:MI') FROMDATE, TO_CHAR(SB.TODATE, 'DD/MM/YY HH24:MI') TODATE FROM lj_service_charges SB, LZ_MERCHANT_MT M WHERE M.MERCHANT_ID = SB.CREATED_BY AND SB.STORAGE_ID = '$id'";
        $result = $this->db->query($qr);
        return $result->result_array();
    }
    public function get_Service_Bills()
    {
        $qr = "SELECT SB.* , S.SERVICE_DESC, (SB.QTY*SB.RATE) AMOUNT, M.CONTACT_PERSON, TO_CHAR(SB.CREATED_DATE, 'DD/MM/YY HH24:MI:SS') CREATED_DATE,  TO_CHAR(SB.FROMDATE, 'DD/MM/YY HH24:MI') FROMDATE, TO_CHAR(SB.TODATE, 'DD/MM/YY HH24:MI') TODATE FROM lj_service_charges SB, LZ_MERCHANT_MT M, lj_services S WHERE M.MERCHANT_ID = SB.CREATED_BY AND SB.SERVICE_ID = S.SERVICE_ID ORDER BY SB.STORAGE_ID DESC";
        $data = $this->db->query($qr);
        if ($data->num_rows() > 0) {
            $result = array("status" => true, "data" => $data->result_array());
        } else {
            $result = array("status" => false, "message" => "No Record");
        }
        return $result;
    }

    public function delete_Service_Bill()
    {
        $Storage_id = $this->input->post('cell');
        $qr = "DELETE FROM lj_service_charges WHERE STORAGE_ID = '$Storage_id' ";
        $result = $this->db->query($qr);
        return array("status" => true, "message" => "Reacode Delete", 'res' => $Storage_id);
    }

    public function update_Service_Detail()
    {
        $rate = $this->input->post('rate');
        $qty = $this->input->post('qty');
        $storage_id = $this->input->post('id');
        $qr = "UPDATE lj_service_charges SET QTY = '$qty', RATE = '$rate' WHERE STORAGE_ID = '$storage_id'  ";
        $result = $this->db->query($qr);
        if ($result == true) {
            return array("status" => true, 'messgae' => "Record updated");
        } else {
            return array("status" => false, 'messgae' => "Record  not updated");

        }
    }
    /**
     *
     *
     * End Bill Model
     * Product Dimension
     *
     *
     */
    public function get_Merchant_Product()
    {
        $merchant_id = $this->input->post('merchant_id');
        $qr = "select i.item_id,
        max(s.item_title) item_desc,
        max(s.f_manufacture) brand,
        max(s.f_mpn) MPN,
        max(s.f_upc) UPC,
        max(s.category_id) category_id,
        max(o.object_name) object_name,
        max(i.item_length) i_length,
        max(i.item_width) i_width,
        max(i.item_height) i_height
        from lz_merchant_barcode_mt m,
        lz_merchant_barcode_dt d,
        lz_barcode_mt b,
        items_mt i,
        lz_item_seed s ,
        lz_special_lots l,
        lz_bd_objects_mt o
        where m.mt_id = d.mt_id
        and m.pos_status != 1
        and d.barcode_no = b.barcode_no
        and b.barcode_no = l.barcode_prv_no
        and o.object_id = l.object_id
        and i.item_id = b.item_id
        and s.item_id = b.item_id
        and m.merchant_id = '$merchant_id'
        group by i.item_id";
        $result = $this->db->query($qr);
        if ($result->num_rows() > 0) {
            return array("status" => true, "data" => $result->result_array());
        } else {
            return array("status" => false, "message" => "No Record Found");
        }
    }

    public function update_Product_Detail()
    {
        $item_id = $this->input->post("item_id");
        $cellName = $this->input->post("cellName");
        $cellValue = $this->input->post("cellValue");
        $user_id = $this->input->post("user_id");
        if ($cellName == "I_WIDTH") {
            $name = "Width";
            $qr = "UPDATE items_mt SET ITEM_WIDTH = '$cellValue' , ENTERED_BY = '$user_id' WHERE ITEM_ID = '$item_id' ";
        }
        if ($cellName == "I_HEIGHT") {
            $name = "Height";
            $qr = "UPDATE items_mt SET ITEM_HEIGHT = '$cellValue' , ENTERED_BY = '$user_id' WHERE ITEM_ID = '$item_id' ";
        }
        if ($cellName == "I_LENGTH") {
            $name = "Length";
            $qr = "UPDATE items_mt SET ITEM_LENGTH = '$cellValue' , ENTERED_BY = '$user_id' WHERE ITEM_ID = '$item_id' ";
        }
        $data = $this->db->query($qr);
        if ($data == true) {
            return array("status" => true, "message" => "$name is Updated");
        } else {
            return array("status" => false, "message" => 'Not Update');
        }
    }
    /**
     * End Dimension
     *
     * Start Invoice Detail
     *
     */
    public function get_Invoice_Detail()
    {
        $merchant_id = $this->input->post('merchant_id');
        $user_id = $this->input->post("user_id");

        // if ($user_id == 2) {
        //     $qr = "SELECT mt.invoice_no,
        //     mer.buisness_name,
        //     TO_CHAR(mt.CREATED_DATE, 'MM/DD/YY HH24:MI:SS') CREATED_DATE,
        //     TO_CHAR(mt.DUE_DATE, 'MM/DD/YY HH24:MI:SS') DUE_DATE,
        //     mt.invoice_id
        //     FROM LJ_INVOICE_MT mt, lz_merchant_mt mer
        //     WHERE mt.merchant_id = mer.merchant_id(+) order by mt.invoice_id DESC";
        // } else {
        // $qr = "SELECT mt.invoice_no,
        //     mer.buisness_name,
        //     TO_CHAR(mt.CREATED_DATE, 'DD/MM/YY HH24:MI:SS') CREATED_DATE,
        //     TO_CHAR(mt.DUE_DATE, 'DD/MM/YY HH24:MI:SS') DUE_DATE,
        //     mt.invoice_id
        //     FROM LJ_INVOICE_MT mt, lz_merchant_mt mer
        //     WHERE mt.merchant_id = mer.merchant_id(+) AND mt.merchant_id = '$merchant_id' order by mt.invoice_id DESC";
        // }
        $qr = "SELECT 'Inv_' || mt.invoice_no invoice_code,
        mer.buisness_name merchant_name,
        mt.invoice_id,
        (select count(d.service_rate_id)
           from LJ_INVOICE_dt d
          where d.invoice_id = mt.invoice_id) total_services,
        (select sum(d.rate * D.QUANTITY)
           from LJ_INVOICE_dt d
          where d.invoice_id = mt.invoice_id) total_charges,
        (select case
                  when sum(d.DIS_AMOUNT) = 0 then
                   0
                  when sum(d.DIS_AMOUNT) > 0 then
                   sum(d.rate * D.QUANTITY) - sum(d.DIS_AMOUNT)
                end
           from LJ_INVOICE_dt d
          where d.invoice_id = mt.invoice_id) DIFF_AMOUNT,



        TO_CHAR(mt.CREATED_DATE, 'DD/MM/YY HH24:MI:SS') CREATED_DATE,
        TO_CHAR(mt.DUE_DATE, 'DD/MM/YY HH24:MI:SS') DUE_DATE,
        decode(mt.invoice_status, 0, 'Unpaid', 1, 'Paid') INVOICE_STATUS
   FROM LJ_INVOICE_MT mt, lz_merchant_mt mer
  WHERE mt.merchant_id = mer.merchant_id(+)
    AND mt.merchant_id = '$merchant_id'
  order by mt.invoice_id DESC";

        $result = $this->db->query($qr);
        if ($result->num_rows() > 0) {
            return array("status" => true, "data" => $result->result_array());
        } else {
            return array("status" => false, "message" => "No Reacord Found", "data" => array());
        }
    }

    public function get_Invoice_Data_Detail()
    {
        $invoice_id = $this->input->post("invoice_id");
        $qr = "SELECT dt.INV_DT_ID,
        sv.service_desc,
        dt.rate,
        dt.duration,
        dt.quantity,
        dt.quantity * dt.rate TOTAL_CHARGE,
        dt.DIS_AMOUNT,
        dt.DIS_AMOUNT_PERC,
        dt.invoice_id,
        ra.ser_rate_id,
        dt.from_date,
        dt.to_date,
        -- dt.quantity * dt.rate - dt.DIS_AMOUNT DISCOUNT_AMOUNT
        --(select SUM(DIS_AMOUNT) from lj_invoice_dt) DISCOUNT_AMOUNT
        case when dt.DIS_AMOUNT = 0 then 0
else dt.quantity * dt.rate - dt.DIS_AMOUNT
end DISCOUNT_AMOUNT
   FROM LJ_INVOICE_dt dt, lj_service_rate ra, lj_services sv
  WHERE dt.service_rate_id = ra.ser_rate_id(+)
    AND ra.service_id = sv.service_id
    AND dt.Invoice_Id ='$invoice_id'";

        $qry = "select sum(TOTAL_CHARGE) sub_total,
    sum(DIS_AMOUNT) discount,
    sum(TOTAL_CHARGE) - sum(DIS_AMOUNT) total from (
     SELECT dt.INV_DT_ID,
            sv.service_desc,
            dt.rate,
            dt.duration,
            dt.quantity,
            dt.quantity * dt.rate TOTAL_CHARGE,
            dt.DIS_AMOUNT,
            dt.DIS_AMOUNT_PERC,
            dt.invoice_id,
            ra.ser_rate_id,
            dt.quantity * dt.rate - dt.DIS_AMOUNT DISCOUNT_AMOUNT,
            (select SUM(dt.quantity * dt.rate) from lj_invoice_dt dt) SUM_TOTAL_CHARGE,
            (select SUM(dt.quantity * dt.rate - dt.DIS_AMOUNT)
               from lj_invoice_dt dt) DISCOUNT_CHARGES,
            (select SUM(dt.DIS_AMOUNT) from lj_invoice_dt dt) DISCOUNT_AMOUNT
       FROM LJ_INVOICE_dt dt, lj_service_rate ra, lj_services sv
      WHERE dt.service_rate_id = ra.ser_rate_id(+)
        AND ra.service_id = sv.service_id
        AND dt.Invoice_Id = '$invoice_id')";
        $result = $this->db->query($qr);
        $res = $this->db->query($qry);
        if ($result->num_rows() > 0) {
            return array("status" => true, "data" => $result->result_array(), "invoice_summary" => $res->result_array());
        } else {
            return array("status" => false, "message" => "No Reacord Found");
        }
    }

    public function get_Specific_Invoice_Detail()
    {
        $invoice_id = $this->input->post("invoice_id");
        $ser_rate_id = $this->input->post("ser_rate_id");
        if ($ser_rate_id == 5) {
            //         $qr = "SELECT max(m.ebay_id) ebay_id,
            //         max(dd.sales_record_number) sale_record_number,
            //         max(m.item_title) item_title,
            //         NVL(MAX(DD.SALE_PRICE * dd.Quantity), 0) sale_price,
            //         NVL(MAX(dd.Quantity), 0) qty,
            //         NVL(MAX(M.SHIPING_LABEL_RATE), 0) SHIPING_RATE,
            //         SUM(PM.PACKING_COST) PACKING_COST,
            //         NVL(MAX(M.EBAY_FEE), 0) ebay_fee,
            //         NVL((7 / 100) * NVL(MAX(DD.SALE_PRICE * dd.Quantity), 0), 0) marketplace,
            //         NVL(SUM(DT.PACKING_COST), 0) + NVL(MAX(M.SHIPING_LABEL_RATE), 0) +
            //         NVL(MAX(M.EBAY_FEE), 0) +
            //         NVL((7 / 100)  *NVL(MAX(DD.SALE_PRICE  *dd.Quantity), 0), 0) CHARGES
            //    FROM LJ_ORDER_PACKING_MT M,
            //         LJ_ORDER_PACKING_DT DT,
            //         LZ_PACKING_TYPE_MT  PM,
            //         LZ_SALESLOAD_DET    DD,
            //         LJ_SERVICE_RATE     RA,
            //         LJ_SERVICES         SV
            //   WHERE M.ORDER_PACKING_ID = DT.ORDER_PACKING_ID
            //     AND M.ORDER_ID = DD.ORDER_ID
            //     AND M.SER_RATE_ID = RA.SER_RATE_ID(+)
            //     AND RA.SERVICE_ID = SV.SERVICE_ID(+)
            //     AND DT.PACKING_ID = PM.PACKING_ID(+)
            //     and m.invoice_id = '$invoice_id'
            //     and m.ser_rate_id = '$ser_rate_id'

            //   GROUP BY DT.ORDER_PACKING_ID";

            $qr = "select '--' ebay_id,
    '--' sale_record_number,
    'Totals' item_title,
    sum(sale_price) sale_price,
    sum(qty) qty,
    sum(SHIPING_RATE) SHIPING_RATE,
    sum(PACKING_COST) PACKING_COST,
    sum(ebay_fee) ebay_fee,
    sum(marketplace) marketplace,
    sum(CHARGES) CHARGES
     from (SELECT max(m.ebay_id) ebay_id,
      max(m.SALE_RECRD_NUM
         ) sale_record_number,

         max(m.item_title) item_title,
         NVL(MAX(m.sale_price * m.qty), 0) sale_price,
         NVL(MAX(m.qty), 0) qty,
         NVL(MAX(M.SHIPING_LABEL_RATE), 0) SHIPING_RATE,
         SUM(PM.PACKING_COST) PACKING_COST,
         NVL(MAX(M.EBAY_FEE), 0) ebay_fee,
         NVL((7 / 100) * NVL(MAX(m.sale_price * m.qty), 0), 0) marketplace,
         NVL(SUM(DT.PACKING_COST), 0) + NVL(MAX(M.SHIPING_LABEL_RATE), 0) +
         NVL(MAX(M.EBAY_FEE), 0) +
         NVL((7 / 100)  *NVL(MAX(m.sale_price * m.qty), 0), 0) CHARGES
    FROM LJ_ORDER_PACKING_MT M,
         LJ_ORDER_PACKING_DT DT,
         LZ_PACKING_TYPE_MT  PM,
         LJ_SERVICE_RATE     RA,
         LJ_SERVICES         SV
   WHERE M.ORDER_PACKING_ID = DT.ORDER_PACKING_ID
     AND M.SER_RATE_ID = RA.SER_RATE_ID(+)
     AND RA.SERVICE_ID = SV.SERVICE_ID(+)
     AND DT.PACKING_ID = PM.PACKING_ID(+)
     and m.invoice_id = '$invoice_id'
     and m.ser_rate_id = '$ser_rate_id'
   GROUP BY DT.ORDER_PACKING_ID)

   union all
   SELECT to_char(max(m.ebay_id)) ebay_id,
         max(m.SALE_RECRD_NUM
         ) sale_record_number,
         max(m.item_title) item_title,
         NVL(MAX(m.sale_price * m.qty), 0) sale_price,
         NVL(MAX(m.qty), 0) qty,
         NVL(MAX(M.SHIPING_LABEL_RATE), 0) SHIPING_RATE,
         SUM(PM.PACKING_COST) PACKING_COST,
         NVL(MAX(M.EBAY_FEE), 0) ebay_fee,
         NVL((7 / 100) * NVL(MAX(m.sale_price * m.qty), 0), 0) marketplace,
         NVL(SUM(DT.PACKING_COST), 0) + NVL(MAX(M.SHIPING_LABEL_RATE), 0) +
         NVL(MAX(M.EBAY_FEE), 0) +
         NVL((7 / 100)  *NVL(MAX(m.sale_price * m.qty), 0), 0) CHARGES
    FROM LJ_ORDER_PACKING_MT M,
         LJ_ORDER_PACKING_DT DT,
         LZ_PACKING_TYPE_MT  PM,
         LJ_SERVICE_RATE     RA,
         LJ_SERVICES         SV
   WHERE M.ORDER_PACKING_ID = DT.ORDER_PACKING_ID
     AND M.SER_RATE_ID = RA.SER_RATE_ID(+)
     AND RA.SERVICE_ID = SV.SERVICE_ID(+)
     AND DT.PACKING_ID = PM.PACKING_ID(+)
     and m.invoice_id = '$invoice_id'
     and m.ser_rate_id = '$ser_rate_id'
   GROUP BY DT.ORDER_PACKING_ID";
        } else {
            // $qr = "select bar.ebay_item_id,bar.barcode_no,s.item_title,cm.cond_name,s.ebay_price,b.charges ,b.ser_rate_id
            // from lj_barcode_billing b,lz_barcode_mt bar ,lz_item_seed s,lz_item_cond_mt cm
            // where b.ser_rate_id = '$ser_rate_id'
            // and b.invoice_id = '$invoice_id'
            // and b.barcode_no = bar.barcode_no(+)
            // and bar.item_id = s.item_id(+)
            // and bar.lz_manifest_id = s.lz_manifest_id(+)
            // and bar.condition_id = s.default_cond(+)
            // and s.default_cond = cm.id";
            $qr = " select '--' ebay_item_id,
                  '--' barcode_no,
                  '--' item_title,
                  'Totals' cond_name,
                  sum(ebay_price) ebay_price,
                  to_char(sum(charges)) charges
                   from (select bar.ebay_item_id,
                  bar.barcode_no,
                  s.item_title,
                  cm.cond_name,
                  s.ebay_price,
                  b.charges,
                  b.ser_rate_id
             from lj_barcode_billing b,
                  lz_barcode_mt      bar,
                  lz_item_seed       s,
                  lz_item_cond_mt    cm
            where b.invoice_id = '$invoice_id'
              and b.ser_rate_id = '$ser_rate_id'
              and b.barcode_no = bar.barcode_no(+)
              and bar.item_id = s.item_id(+)
              and bar.lz_manifest_id = s.lz_manifest_id(+)
              and bar.condition_id = s.default_cond(+)
              and s.default_cond = cm.id(+))

              union all (
              select to_char(bar.ebay_item_id) ebay_item_id,
                  to_char(bar.barcode_no) barcode_no,
                  s.item_title,
                  cm.cond_name,
                  s.ebay_price,
                  b.charges
             from lj_barcode_billing b,
                  lz_barcode_mt      bar,
                  lz_item_seed       s,
                  lz_item_cond_mt    cm
            where b.invoice_id ='$invoice_id'
              and b.ser_rate_id = '$ser_rate_id'
              and b.barcode_no = bar.barcode_no(+)
              and bar.item_id = s.item_id(+)
              and bar.lz_manifest_id = s.lz_manifest_id(+)
              and bar.condition_id = s.default_cond(+)
              and s.default_cond = cm.id(+)
              )";
        }

        $result = $this->db->query($qr);
        if ($result->num_rows() > 0) {
            return array("status" => true, "data" => $result->result_array());
        } else {
            return array("status" => false, "message" => "No Reacord Found");
        }
    }

    public function save_Discount_Amount()
    {
        $INV_DT_ID = $this->input->post('INV_DT_ID');
        $discount_amount = $this->input->post('discount_amount');
        $discount_per = $this->input->post('discount_per');
        $Inoivce_id = $this->input->post('invoice_id');

        $qr = "UPDATE lj_invoice_dt SET DIS_AMOUNT = '$discount_amount', DIS_AMOUNT_PERC = '$discount_per' WHERE  INV_DT_ID = '$INV_DT_ID '";
        $result = $this->db->query($qr);
        if ($result == true) {
            //  $qry = "select SUM(d.quantity * d.rate) TOTAL_CHARGES,
            //         SUM(d.DIS_AMOUNT) DIS_AMOUNT,
            //         SUM(d.quantity * d.rate) - SUM(d.DIS_AMOUNT) diff
            //           from lj_invoice_dt d
            //         where d.invoice_id = '$Inoivce_id' ";
            $qry = "select nvl(SUM(d.quantity * d.rate),0) TOTAL_CHARGES,
            nvl(SUM(d.DIS_AMOUNT),0) DIS_AMOUNT,
            decode(nvl(SUM(d.DIS_AMOUNT),0),0,'0.00',nvl(SUM(d.quantity * d.rate) - SUM(d.DIS_AMOUNT),0))
             diff
       from lj_invoice_dt d
      where d.invoice_id = '$Inoivce_id'";
            $res = $this->db->query($qry);
            if ($res->num_rows() > 0) {
                return array("status" => true, "message" => "Charges Update", "data" => $res->result_array());
            } else {
                return array("status" => true, "message" => "Data Not Fetch");
            }
        } else {
            return array("status" => true, "message" => "Charges Not Update");
        }

    }
    public function save_All_Discount_Amount()
    {
        $dataArray = $this->input->post('data');
        $userId = $this->input->post('user_id');
        if (is_array($dataArray)) {
            for ($i = 0; $i < sizeof($dataArray); $i++) {
                // var_dump($dataArray[$i]['INV_DT_ID']);
                $INV_DT_ID = $dataArray[$i]['INV_DT_ID'];
                $dis_amount = $dataArray[$i]['dis_amount'];
                $dis_amount_perc = $dataArray[$i]['dis_amount_perc'];
                $qr = "UPDATE lj_invoice_dt SET DIS_AMOUNT = '$dis_amount', DIS_AMOUNT_PERC = '$dis_amount_perc', DISCOUNTED_BY = '$userId', CREATED_AT = sysdate WHERE  INV_DT_ID = '$INV_DT_ID'";
                $result = $this->db->query($qr);
            }
            if ($result == true) {
                $invoice_id = $dataArray[0]['invoice_id'];

                $qr = "SELECT dt.INV_DT_ID,
            sv.service_desc,
            dt.rate,
            dt.quantity,
            dt.quantity * dt.rate TOTAL_CHARGE,
            dt.DIS_AMOUNT,
            dt.DIS_AMOUNT_PERC,
            dt.invoice_id,
            -- dt.quantity * dt.rate - dt.DIS_AMOUNT DISCOUNT_AMOUNT,
            case when dt.DIS_AMOUNT = 0 then 0
            else dt.quantity * dt.rate - dt.DIS_AMOUNT
            end DISCOUNT_AMOUNT
            FROM LJ_INVOICE_dt dt, lj_service_rate ra, lj_services sv
            WHERE dt.service_rate_id = ra.ser_rate_id(+)
            AND ra.service_id = sv.service_id
            AND dt.Invoice_Id = '$invoice_id'";
                $result = $this->db->query($qr);
                if ($result->num_rows() > 0) {
                    $qry = "select nvl(SUM(d.quantity * d.rate), 0) TOTAL_CHARGES,
                    nvl(SUM(d.DIS_AMOUNT), 0) DIS_AMOUNT,
                    decode(nvl(SUM(d.DIS_AMOUNT), 0),
                           0,
                           '0.00',
                           nvl(SUM(d.quantity * d.rate) - SUM(d.DIS_AMOUNT), 0)) diff
                  from lj_invoice_dt d
                  where d.invoice_id = '$invoice_id'";
                    $res = $this->db->query($qry);
                    if ($res->num_rows() > 0) {
                        return array("status" => true, "message" => "Record Update", "invoice_detail" => $res->result_array(), "data" => $result->result_array(), "id" => $invoice_id);
                    } else {
                        return array("status" => true, "message" => "Data Not Fetch");
                    }
                } else {
                    return array("status" => false, "message" => "No Reacord Found");
                }
            } else {
                return array("status" => false, "message" => "Record Not Update");
            }
        }

    }
    /**
     * End Invoice Detail
     *
     * Start Create Lot POSTED BARCODE
     *
     */

    public function Get_Image_DecodeBase64($barcode)
    {
        $path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 2");
        $path = $path->result_array();

        $master_path = $path[0]["MASTER_PATH"];
        // var_dump($master_path);

        // $master_path = "D:/wamp/www/item_pictures/dekitted_pictures/";
        $dir = $master_path . $barcode;

        $dir = preg_replace("/[\r\n]*/", "", $dir);
        // var_dump($dir);
        $uri = [];

        // var_dump(is_dir($dir));exit;
        if (is_dir($dir)) {
            // var_dump($dir);exit;
            $images = glob($dir . "\*.{JPG,jpg,GIF,gif,PNG,png,BMP,bmp,JPEG,jpeg}", GLOB_BRACE);
            $i = 0;
            $base_url = 'http://' . $_SERVER['HTTP_HOST'] . '/';
            // var_dump(count($images)); exit;
            // var_dump($images);exit;
            for ($i = 0; $i < count($images); $i++) {
                $pathinfo = pathinfo($images[$i]);
                // $pathinfo['filename'] . '.' . $pathinfo['extension'];
                $withoutMasterPartUri = str_replace("D:/wamp/www/", "", $images[$i]);
                // $withoutMasterPartUri = str_replace("D:/wamp64/www/", "", $images[$i]);
                $uri = $base_url . $withoutMasterPartUri;
                $img = base64_encode(file_get_contents($uri));
                $image[] = array(
                    "image" => $img,
                    "barcode" => $barcode,
                    "extension" => $pathinfo['extension'],
                    "filename" => $pathinfo['filename'],
                );
                // var_dump($withoutMasterPartUri);
                // var_dump($image);
            }
        } else {
            $image = [];
        }
        // exit;
        return array("status" => true, "images" => $image);
    }

    public function get_Lot_Barcode_Detail()
    {
        $barcode = $this->input->post('barcode');

        // var_dump($uri);exit;
        //   return array('uri'=>$uri);

        $result = $this->db->query("SELECT *
        FROM LZ_BARCODE_MT b
       WHERE b.BARCODE_NO = '$barcode' ");
        if ($result->num_rows() > 0) {
            $data = $result->result_array();
            if ($data[0]['PULLING_ID'] != null) {
                $sale_record_no = $data[0]['SALE_RECORD_NO'];
                return array("status" => false, 'message' => "Barcode Ship Aganist $sale_record_no ");
            } else if ($data[0]['PULLING_ID'] == null && $data[0]['SALE_RECORD_NO'] != null) {
                $sale_record_no = $data[0]['SALE_RECORD_NO'];
                return array("status" => false, 'message' => "Barcode Already Sold Aganist $sale_record_no ");
            } else if ($data[0]['PULLING_ID'] == null && $data[0]['SALE_RECORD_NO'] == null && $data[0]['EBAY_ITEM_ID'] != null) {
                $ebay_id = $data[0]['EBAY_ITEM_ID'];
                return array("status" => false, "message" => "Barcode Already Listed Aganist $ebay_id ");
            } else if ($data[0]['ITEM_ADJ_DET_ID_FOR_IN'] != null || $data[0]['ITEM_ADJ_DET_ID_FOR_OUT'] != null || $data[0]['LZ_PART_ISSUE_MT_ID'] != null || $data[0]['REPAIR_ID'] || $data[0]['LZ_POS_MT_ID'] != null || $data[0]['HOLD_STATUS'] != 0) {
                return array("status" => false, "message" => "Barcode Already Consumed");
            }
            $data = ("SELECT DISTINCT B.BARCODE_NO,
                I.ITEM_ID,
                I.ITEM_DESC              TITLE,
                D.ITEM_MT_MANUFACTURE    BRAND,
                D.ITEM_MT_MFG_PART_NO    MPN,
                D.ITEM_MT_UPC            UPC,
                D.WEIGHT                 WEIGHT,
                CON.COND_NAME            CONDIOTION,
                D.PO_DETAIL_RETIAL_PRICE COST_PRICE,
                D.E_BAY_CATA_ID_SEG6     CATEGORY
                    FROM LZ_BARCODE_MT   B,
                    ITEMS_MT        I,
                    LZ_MANIFEST_DET D,
                    LZ_ITEM_COND_MT CON
                    WHERE B.BARCODE_NO = '$barcode'
                    AND B.ITEM_ID = I.ITEM_ID
                    AND B.CONDITION_ID = CON.ID(+)
                    AND I.ITEM_CODE = D.LAPTOP_ITEM_CODE
                    AND B.EBAY_ITEM_ID IS NULL
                    AND B.PULLING_ID IS NULL
                    AND B.SALE_RECORD_NO IS NULL
                    AND B.LZ_MANIFEST_ID = D.LZ_MANIFEST_ID");

            $qr = ("select lm.CONTACT_PERSON, lm.MERCHANT_ID
                     from lz_merchant_barcode_dt d, lz_merchant_barcode_mt m, lz_merchant_mt lm
                     where d.BARCODE_NO = '$barcode'
                     AND d.mt_id = m.mt_id
                     AND m.pos_status != 1
                     AND m.merchant_id = lm.merchant_id");
            $res = $this->db->query($qr);
            $barcode_detail = $this->db->query($data);
            if ($barcode_detail->num_rows() > 0) {
                if ($res->num_rows() > 0) {
                    $data = $res->result_array();
                    $merchant_name = $data[0]["CONTACT_PERSON"];
                    $merchant_id = $data[0]["MERCHANT_ID"];
                    $images = $this->Get_Image_DecodeBase64($barcode);
                    if ($images['status'] == true) {
                        return array("status" => true, 'data' => $barcode_detail->result_array(), "merchant_detail" => $res->result_array(), "images" => $images['images']);
                    } else {
                        return array("status" => false, "message" => $images['message']);
                    }
                } else {
                    $data = array(
                        "CONTACT_PERSON" => "DFWONLINE",
                        "MERCHANT_ID" => "10000000072",
                    );
                    $images = $this->Get_Image_DecodeBase64($barcode);
                    if ($images['status'] == true) {
                        return array("status" => true, 'data' => $barcode_detail->result_array(), "merchant_detail" => array($data), "images" => $images['images']);
                    } else {
                        return array("status" => false, "message" => $images['message']);
                    }
                }

            } else {
                return array("status" => false, 'message' => "No Barcode Detail Found");
            }
        } else {
            return array("status" => false, 'message' => "No Barcode Found");
        }

    }

    public function Range_Get_Image_DecodeBase64($barcode)
    {
        // var_dump($barcode);
        $path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 2");
        $path = $path->result_array();

        $master_path = $path[0]["MASTER_PATH"];
        // var_dump($master_path);

        // $master_path = "D:/wamp/www/item_pictures/dekitted_pictures/";
        $dir = $master_path . $barcode;

        $dir = preg_replace("/[\r\n]*/", "", $dir);
        // var_dump($dir);
        $uri = [];

        // var_dump(is_dir($dir));exit;
        if (is_dir($dir)) {
            // var_dump($dir);exit;
            $images = glob($dir . "\*.{JPG,jpg,GIF,gif,PNG,png,BMP,bmp,JPEG,jpeg}", GLOB_BRACE);
            $i = 0;
            $base_url = 'http://' . $_SERVER['HTTP_HOST'] . '/';
            // var_dump(count($images)); exit;
            // var_dump($images);exit;
            for ($i = 0; $i < count($images); $i++) {
                $pathinfo = pathinfo($images[$i]);
                // $pathinfo['filename'] . '.' . $pathinfo['extension'];
                $withoutMasterPartUri = str_replace("D:/wamp/www/", "", $images[$i]);
                // $withoutMasterPartUri = str_replace("D:/wamp64/www/", "", $images[$i]);
                $uri = $base_url . $withoutMasterPartUri;
                $img = base64_encode(file_get_contents($uri));
                $image[] = array(
                    "image" => $img,
                    "barcode" => $barcode,
                    "extension" => $pathinfo['extension'],
                    "filename" => $pathinfo['filename'],
                );
                // var_dump($withoutMasterPartUri);
                // var_dump($image);
            }
            // $imagess[] = $image;
        } else {
            $image = [];
        }
        return $image;
        // exit;
        // return array("status" => true, "images" => $image);
    }

    public function Check_Lot_Range_Barcode_Exist($start_ser_barcode, $end_ser_barcode)
    {
        $diff = $end_ser_barcode - $start_ser_barcode;
        // var_dump($diff);
        if ($diff > 1) {
            $qr = "SELECT *
            FROM LZ_BARCODE_MT b
           WHERE b.BARCODE_NO BETWEEN '$start_ser_barcode' AND '$end_ser_barcode'";
            $result = $this->db->query($qr);
            return array("status" => true, "data" => $result->result_array());
        }if ($diff < 0) {
            $qr = "SELECT *
            FROM LZ_BARCODE_MT b
           WHERE b.BARCODE_NO BETWEEN '$end_ser_barcode' AND '$start_ser_barcode'";
            $result = $this->db->query($qr);
            return array("status" => true, "data" => $result->result_array());
        }if ($diff == 0) {
            $qr = "SELECT *
            FROM LZ_BARCODE_MT b
           WHERE b.BARCODE_NO BETWEEN '$start_ser_barcode' AND '$end_ser_barcode'";
            $result = $this->db->query($qr);
            return array("status" => true, "data" => $result->result_array());
        }
    }
    public function Get_Lot_Range_Barcode_Detail()
    {

        $start_ser_barcode = $this->input->post('start_ser_barcode');
        $end_ser_barcode = $this->input->post("end_ser_barcode");
        // var_dump($start_ser_barcode);
        $qr = "SELECT *
             FROM LZ_BARCODE_MT b
            WHERE b.BARCODE_NO BETWEEN '$start_ser_barcode' AND '$end_ser_barcode'";
        $result = $this->db->query($qr);
        // $result = $this->Check_Lot_Range_Barcode_Exist($start_ser_barcode, $end_ser_barcode);
        // var_dump($result);
        // exit;
        if ($result->num_rows() > 0) {
            // if (count($result['data'] > 0)) {
            $data = $result->result_array();
            // $data = $result['data'];
            $total_row = count($data);
            for ($i = 0; $i < $total_row; $i++) {

                if ($data[$i]['PULLING_ID'] != null) {
                    $sale_record_no = $data[$i]['SALE_RECORD_NO'];
                    $barcode = $data[$i]['BARCODE_NO'];
                    $error[] = array("status" => false, 'message' => "$barcode Barcode Ship Aganist $sale_record_no ");
                } else if ($data[$i]['PULLING_ID'] == null && $data[$i]['SALE_RECORD_NO'] != null) {
                    $sale_record_no = $data[$i]['SALE_RECORD_NO'];
                    $barcode = $data[$i]['BARCODE_NO'];
                    $error[] = array("status" => false, 'message' => "$barcode Barcode Already Sold Aganist $sale_record_no ");
                } else if ($data[$i]['PULLING_ID'] == null && $data[$i]['SALE_RECORD_NO'] == null && $data[$i]['EBAY_ITEM_ID'] != null) {
                    $ebay_id = $data[$i]['EBAY_ITEM_ID'];
                    $barcode = $data[$i]['BARCODE_NO'];
                    $error[] = array("status" => false, "message" => "$barcode Barcode Already Listed Aganist $ebay_id  ");
                } else if ($data[0]['ITEM_ADJ_DET_ID_FOR_IN'] != null || $data[0]['ITEM_ADJ_DET_ID_FOR_OUT'] != null || $data[0]['LZ_PART_ISSUE_MT_ID'] != null || $data[0]['LZ_POS_MT_ID'] != null || $data[0]['HOLD_STATUS'] != 0 || $data[0]['REPAIR_ID'] != null) {
                    $error[] = array("status" => false, "message" => "Barcode Already Consumed");
                } else {
                    $error = '';
                }
                // }
                // if (sizeof($error) > 0) {
                //     return array("error" => $error);
                // }
                // for ($i = 0; $i < $total_row; $i++) {
                $barcode = $data[$i]['BARCODE_NO'];
                $qrr = ("SELECT DISTINCT B.BARCODE_NO,
                     I.ITEM_ID,
                     I.ITEM_DESC              TITLE,
                     D.ITEM_MT_MANUFACTURE    BRAND,
                     D.ITEM_MT_MFG_PART_NO    MPN,
                     D.ITEM_MT_UPC            UPC,
                     CON.COND_NAME            CONDIOTION,
                     D.WEIGHT                 WEIGHT,
                     D.PO_DETAIL_RETIAL_PRICE COST_PRICE,
                     D.E_BAY_CATA_ID_SEG6     CATEGORY
                         FROM LZ_BARCODE_MT   B,
                         ITEMS_MT        I,
                         LZ_MANIFEST_DET D,
                         LZ_ITEM_COND_MT CON
                         WHERE B.BARCODE_NO = '$barcode'
                         AND B.ITEM_ID = I.ITEM_ID
                         AND B.CONDITION_ID = CON.ID(+)
                         AND I.ITEM_CODE = D.LAPTOP_ITEM_CODE
                         AND B.EBAY_ITEM_ID IS NULL
                         AND B.PULLING_ID IS NULL
                         AND B.SALE_RECORD_NO IS NULL
                         AND B.LZ_MANIFEST_ID = D.LZ_MANIFEST_ID");
                $qr = ("select lm.CONTACT_PERSON, lm.MERCHANT_ID
                                  from lz_merchant_barcode_dt d, lz_merchant_barcode_mt m, lz_merchant_mt lm
                                  where d.BARCODE_NO = '$barcode'
                                  AND m.pos_status !=1
                                  AND d.mt_id = m.mt_id
                                  AND m.merchant_id = lm.merchant_id");
                $images[] = $this->Range_Get_Image_DecodeBase64($barcode);
                $barcode_detail = $this->db->query($qrr);
                $res = $this->db->query($qr);
                if ($barcode_detail->num_rows() > 0) {
                    if ($res->num_rows() > 0) {
                        $result = $res->result_array();
                        $merchant_name = $result[0]["CONTACT_PERSON"];
                        $name[] = $merchant_name;
                        if ($name[0] == $result[0]["CONTACT_PERSON"]) {
                            // var_dump($barcode);
                            // $images = $this->Range_Get_Image_DecodeBase64($barcode);
                            // $dataArray[] = array("status" => true, "data" => $barcode_detail->result_array(), "merchant_detail" => $res->result_array());
                            $dataArray[] = $barcode_detail->result_array();
                            $merchantArray[] = $res->result_array();
                            // $images[] = $images;
                        } else {
                            $error[] = array("status" => false, "message" => "$barcode Barcode Merchant Name ($merchant_name) Is Not Same With Other");
                            $dataArray[] = $barcode_detail->result_array();
                            $merchantArray[] = $res->result_array();
                        }
                        // $data[] = array("data" => $barcode_detail->result_array(), "merchant_detail" => $data);
                    } else {
                        $merchant_detail = array(
                            "CONTACT_PERSON" => "DFWONLINE",
                            "MERCHANT_ID" => "10000000072",
                        );
                        // $images = $this->Range_Get_Image_DecodeBase64($barcode);
                        // $dataArray[] = array("status" => true, 'data' => $barcode_detail->result_array(), "merchant_detail" => array($merchant_detail));
                        $dataArray[] = $barcode_detail->result_array();
                        $merchantArray[] = array($merchant_detail);
                        // $images[] = $images;
                    }

                } else {
                    $error[] = array("status" => false, "message" => "No Record Aganist This $barcode Barcode");
                    // $dataArray[] = array("status" => true, "data" => array(), "merchant_detail" => array());
                    $dataArray[] = array();
                    $merchantArray[] = array();
                    $images[] = array();
                }
            }
            if (empty($error)) {
                return array("data" => $dataArray, "merchant_name" => $merchantArray, "images" => $images);
            } else {
                return array("data" => $dataArray, "merchant_name" => $merchantArray, "images" => $images, "error" => $error);
            }

        } else {
            return array("status" => false, 'message' => "No Barcode Found", "data" => array(), "merchant_name" => array(), "images" => array(), "error" => array());
            // return array("data" => $dataArray, "merchant_name" => $merchantArray, "error" => $error);
        }
    }
    public function Get_Item_Cond()
    {
        $qr = "select c.id,c.cond_name from lz_item_cond_mt c";
        $data = $this->db->query($qr);
        if ($data->num_rows() > 0) {
            return array("status" => true, "data" => $data->result_array());
        } else {
            return array("status" => false, "message" => "No Record Found");
        }
    }

    public function Get_Object_Cond()
    {
        $qr = "SELECT O.OBJECT_ID, O.OBJECT_NAME, O.CATEGORY_ID
        FROM LZ_BD_CAT_GROUP_MT M, LZ_BD_CAT_GROUP_DET D, LZ_BD_OBJECTS_MT O
       WHERE M.LZ_BD_GROUP_ID = D.LZ_BD_GROUP_ID
         AND M.LZ_BD_GROUP_ID = O.LZ_BD_GROUP_ID
         AND D.LZ_BD_GROUP_ID = O.LZ_BD_GROUP_ID
         AND D.CATEGORY_ID = O.CATEGORY_ID
         AND M.LZ_BD_GROUP_ID = 7";
        $result = $this->db->query($qr);
        if ($result->num_rows() > 0) {
            return array("status" => true, "data" => $result->result_array());
        } else {
            return array("status" => false, "message" => "No Record Found");
        }
    }

    public function Create_Lot_Object()
    {
        $obj_cat = $this->input->post('category_id');
        $obj_name = $this->input->post('obj_name');
        $ship_serv = $this->input->post('service');
        $obj_cost = $this->input->post('obj_cost');
        $obj_weig = $this->input->post('obj_weig');

        $user_id = $this->input->post('user_id');
        date_default_timezone_set("America/Chicago");
        $date = date('Y-m-d H:i:s');
        $curr_date = "TO_DATE('" . $date . "', 'YYYY-MM-DD HH24:MI:SS')";
        $check_qry = $this->db->query("SELECT OBJECT_ID FROM LZ_BD_OBJECTS_MT where upper(object_name) = upper('$obj_name') and category_id = '$obj_cat'");
        if ($check_qry->num_rows() > 0) {
            $insert = $this->db->query("UPDATE LZ_BD_OBJECTS_MT SET SHIP_SERV = '$ship_serv' , WEIGHT = '$obj_weig' , LZ_BD_GROUP_ID = 7 , ITEM_COST = '$obj_cost' WHERE upper(OBJECT_NAME) = upper('$obj_name') and category_id = '$obj_cat'");
            if ($insert) {
                $check_qry = $this->db->query("SELECT LZ_BD_GROUP_DET_ID FROM LZ_BD_CAT_GROUP_DET where category_id = $obj_cat and LZ_BD_GROUP_ID = 7");
                if ($check_qry->num_rows() == 0) {
                    $qry2 = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_CAT_GROUP_DET', 'LZ_BD_GROUP_DET_ID') GROUP_ID FROM DUAL");
                    $qry2 = $qry2->result_array();
                    $get_group_id = $qry2[0]['GROUP_ID'];
                    $this->db->query("INSERT INTO LZ_BD_CAT_GROUP_DET(LZ_BD_GROUP_DET_ID,LZ_BD_GROUP_ID,CATEGORY_ID) VALUES($get_group_id,7,$obj_cat) ");
                    if ($qry2) {
                        $selectLatest = "SELECT O.OBJECT_ID, O.OBJECT_NAME, O.CATEGORY_ID
                            FROM LZ_BD_CAT_GROUP_MT M, LZ_BD_CAT_GROUP_DET D, LZ_BD_OBJECTS_MT O
                           WHERE M.LZ_BD_GROUP_ID = D.LZ_BD_GROUP_ID
                             AND M.LZ_BD_GROUP_ID = O.LZ_BD_GROUP_ID
                             AND D.LZ_BD_GROUP_ID = O.LZ_BD_GROUP_ID
                             AND D.CATEGORY_ID = O.CATEGORY_ID
                             AND M.LZ_BD_GROUP_ID = 7
                             AND O.CATEGORY_ID = '$obj_cat'
                             AND O.OBJECT_NAME = '$obj_name'";
                        $selectLatest = $this->db->query($selectLatest);
                        if ($selectLatest->num_rows() > 0) {
                            return array("status" => true, "message" => 'Object Updated', 'data' => $selectLatest->result_array());
                        } else {
                            return array("status" => false, "message" => 'Latest Updated Object Not Selected');
                        }
                    } else {
                        return array("status" => false, "message" => 'Object Not Update');
                    }
                } else {
                    return array("status" => false, "message" => 'GROUP_DET_ID Already Exist');
                }

            }
        } else {
            $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_OBJECTS_MT', 'OBJECT_ID')ID FROM DUAL");
            $qry = $qry->result_array();
            $Object_id = $qry[0]['ID'];
            $insert = $this->db->query("INSERT INTO LZ_BD_OBJECTS_MT D(D.OBJECT_ID, D.OBJECT_NAME, D.INSERT_DATE, D.INSERT_BY, D.CATEGORY_ID, D.ITEM_DESC, D.SHIP_SERV, D.WEIGHT, D.LZ_BD_GROUP_ID, D.ITEM_COST)values($Object_id,'$obj_name',$curr_date,$user_id,$obj_cat,'','$ship_serv',$obj_weig,7,$obj_cost) ");
            if ($insert) {
                $qry2 = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_CAT_GROUP_DET', 'LZ_BD_GROUP_DET_ID') GROUP_ID FROM DUAL");
                $qry2 = $qry2->result_array();
                $get_group_id = $qry2[0]['GROUP_ID'];
                $this->db->query("INSERT INTO LZ_BD_CAT_GROUP_DET(LZ_BD_GROUP_DET_ID,LZ_BD_GROUP_ID,CATEGORY_ID) VALUES($get_group_id,7,$obj_cat) ");
                if ($qry2) {
                    $selectLatest = "SELECT O.OBJECT_ID, O.OBJECT_NAME, O.CATEGORY_ID
                    FROM LZ_BD_CAT_GROUP_MT M, LZ_BD_CAT_GROUP_DET D, LZ_BD_OBJECTS_MT O
                   WHERE M.LZ_BD_GROUP_ID = D.LZ_BD_GROUP_ID
                     AND M.LZ_BD_GROUP_ID = O.LZ_BD_GROUP_ID
                     AND D.LZ_BD_GROUP_ID = O.LZ_BD_GROUP_ID
                     AND D.CATEGORY_ID = O.CATEGORY_ID
                     AND M.LZ_BD_GROUP_ID = 7
                     AND O.OBJECT_ID = '$Object_id'";
                    $selectLatest = $this->db->query($selectLatest);
                    if ($selectLatest->num_rows() > 0) {
                        return array("status" => true, "message" => 'Object Updated', 'data' => $selectLatest->result_array());
                    } else {
                        return array("status" => false, "message" => 'Latest Object Not Selected');
                    }
                } else {
                    return array("status" => false, "message" => 'Object is Not Created');
                }

            } else {
                return array("status" => false, "message" => 'LZ BD OBJECTS MT Error');
            }

        }
    }

    public function Suggest_Lot_Categories()
    {

        $UPC = $this->input->post('UPC');
        $TITLE = $this->input->post('TITLE');
        $TITLE = trim(str_replace("  ", ' ', $TITLE));
        $TITLE = trim(str_replace(array("'"), "''", $TITLE));
        $MPN = $this->input->post('MPN');
        $MPN = trim(str_replace("  ", ' ', $MPN));
        $MPN = trim(str_replace(array("'"), "''", $MPN));
        if (!empty($UPC) && strtoupper($UPC) != "DOES NOT APPLY") {
            $data['key'] = $UPC;
        } elseif (!empty($MPN) && strtoupper($MPN) != "DOES NOT APPLY") {
            $data['key'] = $MPN;
        } elseif (!empty($TITLE)) {
            $data['key'] = $TITLE;
        }
        $data['result'] = $this->load->view('API/SuggestCategories', $data);
        return $data['result'];
    }

    public function Save_Lot_Data()
    {
        // $bar_no = $this->input->post('bar_no');
        // $item_id = $this->input->post('item_id');
        // $cost_pric = $this->input->post('cost_pric');

        // Image Lib
        $this->load->library('image_lib');

        $data = $this->input->post("data");
        $enter_manu = $this->input->post('enter_manu');
        $ent_title = $this->input->post('title');
        $get_user = $this->input->post('user_id');
        $bin = $this->input->post('bin');
        $ent_title = str_replace("'", "''", $ent_title);
        $condi_name = $this->input->post('selectcondition');
        $condi_id = $this->input->post('selectconditionid');
        $ent_cat_id = $this->input->post('category');
        $merchant_id = $this->input->post("merchant_id");
        $object_id = $this->input->post('object_id');
        $enter_mp = $this->input->post('mpn');
        $images = $this->input->post("images");
        $title = trim(str_replace("  ", ' ', $enter_mp));
        $title = str_replace(array("`,′"), "", $title);
        $title = str_replace(array("'"), "''", $title);
        // var_dump($condi_name);
        // var_dump($get_user);
        // var_dump(count($images));
        // var_dump($data);

        // exit;
        if (empty($enter_mp)) {
            $enter_mp_cust = 'LOTMPN';
        } else {
            $enter_mp_cust = $title;
        }

        // **** variable declaration for insertion into ITEM_ADJUSTMENT_MT,ITEM_ADJUSTMENT_det start*
        //******************************************************************************************

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

        $insert_adjus_mt = "INSERT INTO ITEM_ADJUSTMENT_MT(ITEM_ADJUSTMENT_ID, INV_BOOK_ID, ADJUSTMENT_NO, ADJUSTMENT_DATE, STOCK_TRANS_YN, REMARKS,INV_TRANSACTION_NO, JOURNAL_ID, POST_TO_GL, ENTERED_BY, AUTH_ID, AUTHORIZED_YN, SEND_FOR_AUTH, AUTH_STATUS_ID,ADJUSTMENT_REF_NO)
                  VALUES('$adjs_mt_pk', 8, '$last_no', to_date(sysdate), 0, NULL, NULL, NULL, 0, $get_user, null, 0, 0, 0, '$adjus')";
        $this->db->query($insert_adjus_mt);
        if ($insert_adjus_mt) {
            if (is_array($data)) {
                for ($i = 0; $i < count($data); $i++) {
                    $adjs_det = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('ITEM_ADJUSTMENT_DET ', 'ITEM_ADJUSTMENT_DET_ID')ID FROM DUAL")->result_array();
                    $adjs_det_pk = $adjs_det[0]['ID'];
                    $item = $data[$i]['ITEM_ID'];
                    $cost_price = $data[$i]['COST_PRICE'];
                    $barcode_no = $data[$i]['BARCODE_NO'];
                    $insert_adjus_det = "INSERT INTO ITEM_ADJUSTMENT_DET(ITEM_ADJUSTMENT_DET_ID, ITEM_ADJUSTMENT_ID, ITEM_ID, SR_NO, LOC_CODE_COMB_ID, PRIMARY_QTY, SECONDARY_QTY, LINE_AMOUNT, CONTRA_ACC_CODE_COMB_ID, REMARKS )
                          VALUES('$adjs_det_pk', '$adjs_mt_pk', '$item', 1, '$def_loc_id', -1, NULL, '$cost_price', NULL, NULL )"; /// $cost variable query
                    $this->db->query($insert_adjus_det);

                    $this->db->query("UPDATE DOC_SEQUENCE_DETAIL  SET LAST_NO = '$last_no' where DOC_DET_SEQ_ID = '$doc_det_seq_id'");
                    $this->db->query("UPDATE LZ_BARCODE_MT SET ITEM_ADJ_DET_ID_FOR_OUT = '$adjs_det_pk' WHERE BARCODE_NO = '$barcode_no'");

                }
            }
        }
        // **** code for insertion into ITEM_ADJUSTMENT_MT,ITEM_ADJUSTMENT_DET end
        //***********************************************************************

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
        $load_date = "TO_DATE('" . $loading_date . "', 'YYYY-MM-DD HH24:MI:SS')";

        $purch_ref_no = 'lot_' . $loading_no;
        /*--- Get Single Primary Key for LZ_MANIFEST_MT start---*/
        $get_mt_pk = $this->db->query("SELECT get_single_primary_key('LZ_MANIFEST_MT','LZ_MANIFEST_ID') LZ_MANIFEST_ID FROM DUAL");
        $get_mt_pk = $get_mt_pk->result_array();
        $lz_manifest_id = $get_mt_pk[0]['LZ_MANIFEST_ID'];
        /*--- Get Single Primary Key for LZ_MANIFEST_MT end---*/

        /*--- Insertion Query for LZ_MANIFEST_MT start---*/
        $mt_qry = "INSERT INTO LZ_MANIFEST_MT (LZ_MANIFEST_ID, LOADING_NO, LOADING_DATE, PURCH_REF_NO, SUPPLIER_ID, REMARKS, DOC_SEQ_ID, PURCHASE_DATE, POSTED, EXCEL_FILE_NAME, GRN_ID, PURCHASE_INVOICE_ID, SINGLE_ENTRY_ID, TOTAL_EXCEL_ROWS, MANIFEST_NAME, MANIFEST_STATUS, SOLD_PRICE, END_DATE, LZ_OFFER, MANIFEST_TYPE, EST_MT_ID) VALUES($lz_manifest_id , $loading_no , $load_date , '$purch_ref_no' , 7, NULL ,30 , null , 'POSTED' , null , null , null, null, null , null  , null, null ,null , null, 5, null)";
        $mt_qry = $this->db->query($mt_qry);
        if ($mt_qry) {

            $cat_name = $this->db->query(" SELECT C.CATEGORY_NAME, C.PARENT_CAT_ID FROM LZ_BD_CATEGORY_TREE C WHERE C.CATEGORY_ID = $ent_cat_id ");
            if (count($cat_name) > 0) {
                $cat_name = $cat_name->result_array();
                $get_cat_name = @$cat_name[0]['CATEGORY_NAME'];

                $cost_p = $this->db->query(" SELECT SUM(DE.LINE_AMOUNT) COST_P FROM ITEM_ADJUSTMENT_DET DE WHERE DE.ITEM_ADJUSTMENT_ID = $adjs_mt_pk ");
                $cost_p = $cost_p->result_array();
                $get_cost_price = @$cost_p[0]['COST_P'];

                $get_det_pk = $this->db->query("SELECT get_single_primary_key('LZ_MANIFEST_DET','LAPTOP_ZONE_ID') LZ_ID FROM DUAL");
                $get_det_pk = $get_det_pk->result_array();
                $laptop_zone_id = $get_det_pk[0]['LZ_ID'];

                $det_qry = "  INSERT INTO LZ_MANIFEST_DET
            (PO_MT_AUCTION_NO,
             PO_DETAIL_LOT_REF,
             PO_MT_REF_NO,
             ITEM_MT_MANUFACTURE,
             ITEM_MT_MFG_PART_NO,
             ITEM_MT_DESC,
             ITEM_MT_BBY_SKU,
             ITEM_MT_UPC,
             PO_DETAIL_RETIAL_PRICE,
             MAIN_CATAGORY_SEG1,
             SUB_CATAGORY_SEG2,
             BRAND_SEG3,
             ORIGIN_SEG4,
             CONDITIONS_SEG5,
             E_BAY_CATA_ID_SEG6,
             LAPTOP_ZONE_ID,
             LAPTOP_ITEM_CODE,
             AVAILABLE_QTY,
             PRICE,
             LZ_MANIFEST_ID,
             CATEGORY_NAME_SEG7,
             S_PRICE,
             V_PRICE,
             SHIP_FEE,
             STICKER_PRINT,
             MANUAL_UPDATE,
             EST_DET_ID,
             WEIGHT)

           values
            (null,
             null,
             null,
             '$enter_manu',
             '$enter_mp_cust',
             '$ent_title',
             null,
             null,
             $get_cost_price,
             '$get_cat_name',
             '$get_cat_name',
             '$get_cat_name',
             'US',
             '$condi_name',
             $ent_cat_id,
             $laptop_zone_id,
             null,
             1,
             null,
             $lz_manifest_id,
             null,
             null,
             null,
             null,
             null,
             null,
             null,
             null) ";
                $det_qry = $this->db->query($det_qry);
                if ($det_qry) {
                    $call_proc = $this->db->query("call Pro_Laptop_Zone($lz_manifest_id)");
                    if ($call_proc) {

                        $bar_quer = $this->db->query("SELECT BARCODE_NO ,ITEM_ID FROM LZ_BARCODE_MT WHERE LZ_MANIFEST_ID = $lz_manifest_id");
                        if (count($bar_quer) > 0) {
                            $bar_quer = $bar_quer->result_array();
                            $get_barcode_no = $bar_quer[0]['BARCODE_NO'];
                            $get_barcode_item = $bar_quer[0]['ITEM_ID'];

                            $get_adjs_det = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('ITEM_ADJUSTMENT_DET ', 'ITEM_ADJUSTMENT_DET_ID')ID FROM DUAL")->result_array();
                            $get_adjs_det_pk = $get_adjs_det[0]['ID'];

                            $ins_adjus_det = "INSERT INTO ITEM_ADJUSTMENT_DET(ITEM_ADJUSTMENT_DET_ID, ITEM_ADJUSTMENT_ID, ITEM_ID, SR_NO, LOC_CODE_COMB_ID, PRIMARY_QTY, SECONDARY_QTY, LINE_AMOUNT, CONTRA_ACC_CODE_COMB_ID, REMARKS )
                      VALUES($get_adjs_det_pk, $adjs_mt_pk, $get_barcode_item, 1, $def_loc_id, 1, NULL, $get_cost_price, NULL, NULL )"; /// $cost variable query
                            $this->db->query($ins_adjus_det);

                            $this->db->query(" UPDATE LZ_BARCODE_MT BB  SET BB.ITEM_ADJ_DET_ID_FOR_IN = $get_adjs_det_pk WHERE bb.BARCODE_NO = $get_barcode_no");
                            $lot_defination_lot_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('lot_defination_mt ', 'LOT_ID')ID FROM DUAL")->result_array();
                            $lot_defination_lot_id = $lot_defination_lot_id[0]['ID'];
                            $sum = 0;
                            for ($i = 0; $i < count($data); $i++) {
                                $sum = $sum + $data[$i]["COST_PRICE"];
                            }
                            $insert_lot_def = "INSERT INTO lot_defination_mt(LOT_ID,
                            REF_NO,
                            PURCHASE_DATE,
                            ASSIGN_DATE,
                            COST,
                            PROFIT_REQUIRE,
                            SOURCE,
                            EST_REQUEST,
                            PARTIAL_LIST,
                            LINE_ITEM_COST_AVAIL,
                            APPROVAL_REQUIRE,
                            EST_SHIP_SERVIC,
                            LOT_DESC,
                            LOT_STATUS,
                            MERCHANT_ID,
                            BILLING_TYPE) VALUES ($lot_defination_lot_id, $lot_defination_lot_id, sysdate, sysdate, '$sum', null, 'Lot Screen', null, null, null, null, null, '$ent_title', 1, $merchant_id, null)";

                            $insert_lot_def = $this->db->query($insert_lot_def);
                            if ($insert_lot_def == true) {
                                $merchant_barcode_mt_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('lz_merchant_barcode_mt ', 'MT_ID')ID FROM DUAL")->result_array();
                                $merchant_barcode_mt_id = $merchant_barcode_mt_id[0]['ID'];
                                $insert_merchant_barcode_mt = "INSERT INTO lz_merchant_barcode_mt
                                (MT_ID,
                                 MERCHANT_ID,
                                 ISSUED_DATE,
                                 ISSUED_BY,
                                 NO_OF_BARCODE,
                                 LOT_ID,
                                 RANGE_ID,
                                 LZ_PRODUCT_INV_ID)
                              VALUES
                                ('$merchant_barcode_mt_id',
                                 '$merchant_id',
                                 sysdate,
                                 '$get_user',
                                 1,
                                 '$lot_defination_lot_id',
                                 0,
                                 null)";
                                $insert_merchant_barcode_mt = $this->db->query($insert_merchant_barcode_mt);
                                if ($insert_merchant_barcode_mt == true) {

                                    $merchant_barcode_dt_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('lz_merchant_barcode_dt ', 'DT_ID')ID FROM DUAL")->result_array();
                                    $merchant_barcode_dt_id = $merchant_barcode_dt_id[0]['ID'];
                                    $insert_merchant_barcode_dt = "INSERT INTO lz_merchant_barcode_dt
                                (DT_ID,
                                 MT_ID,
                                 BARCODE_NO,
                                 SALE_PRICE,
                                 SHIPING_SERVICE,
                                 ACCOUNT_ID,
                                 DISCARD_COND,
                                 APPOINTMENT_DT_ID_INV,
                                 APPOINTMENT_DT_ID_PIC,
                                 COST,
                                 BARCODE_STATUS,
                                 REMARKS,
                                 STATUS_DATE,
                                 STATUS_BY,
                                 ADMIN_STATUS,
                                 NOTIFICATION,
                                 BIN_ID) VALUES
                                ('$merchant_barcode_dt_id',
                                 '$merchant_barcode_mt_id',
                                 '$get_barcode_no',
                                 0,
                                 null,
                                 null,
                                 null,
                                 null,
                                 null,
                                 0.00,
                                 0,
                                 null,
                                 null,
                                 null,
                                 0,
                                 null,
                                 0) ";
                                    $insert_merchant_barcode_dt = $this->db->query($insert_merchant_barcode_dt);
                                    if ($insert_merchant_barcode_dt == true) {
                                        $select = "SELECT CATALOGUE_MT_ID from LZ_CATALOGUE_MT WHERE  CATEGORY_ID = '$ent_cat_id' AND  UPPER(MPN) = UPPER('$enter_mp')";
                                        $result = $this->db->query($select);
                                        if ($result->num_rows() > 0) {
                                            $id = $result->result_array();
                                            $catalogue_mt_id = $id[0]['CATALOGUE_MT_ID'];

                                        } else {
                                            $catalogue_mt_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('lz_catalogue_mt ', 'CATALOGUE_MT_ID')ID FROM DUAL")->result_array();
                                            $catalogue_mt_id = $catalogue_mt_id[0]['ID'];
                                            $insert_into_catalogue = "INSERT INTO lz_catalogue_mt
                                            (CATALOGUE_MT_ID,
                                             MPN,
                                             CATEGORY_ID,
                                             INSERTED_DATE,
                                             INSERTED_BY,
                                             CUSTOM_MPN,
                                             OBJECT_ID,
                                             MPN_DESCRIPTION,
                                             AUTO_CREATED,
                                             LAST_RUN_TIME,
                                             BRAND,
                                             PRICE,
                                             UPC)
                                          VALUES
                                            ('$catalogue_mt_id',
                                             '$enter_mp',
                                             '$ent_cat_id',
                                             sysdate,
                                             '$get_user',
                                             0,
                                             '$object_id',
                                             '$ent_title',
                                             0,
                                             null,
                                             '$enter_manu',
                                             null,
                                             null)
                                          ";
                                            $insert_into_catalogue = $this->db->query($insert_into_catalogue);
                                        }

                                        if (1) {
                                            $special_lot_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('lz_special_lots ', 'SPECIAL_LOT_ID')ID FROM DUAL")->result_array();
                                            $special_lot_id = $special_lot_id[0]['ID'];
                                            $insert_special_lot_mt = "INSERT INTO lz_special_lots
                                            (SPECIAL_LOT_ID,
                                             BARCODE_PRV_NO,
                                             OBJECT_ID,
                                             BIN_ID,
                                             PIC_DATE_TIME,
                                             PIC_BY,
                                             CATALOG_MT_ID,
                                             LOT_REMARKS,
                                             WEIGHT,
                                             CONDITION_ID,
                                             LZ_MANIFEST_DET_ID,
                                             PIC_NOTES,
                                             MPN_DESCRIPTION,
                                             PIC_STATUS,
                                             PIC_TEXT,
                                             CARD_UPC,
                                             CARD_MPN,
                                             INSERTED_AT,
                                             INSERTED_BY,
                                             UPDATED_AT,
                                             UPDATED_BY,
                                             BRAND,
                                             ITEM_COST,
                                             LOT_ID,
                                            --  QTY,
                                             FOLDER_nAME,
                                             AVG_SOLD,
                                             CARD_CATEGORY_ID,
                                             BARCODE_NOTES,
                                             ALLOCATE_TO,
                                             ALLOC_DATE,
                                             ALLOCATED_BY,
                                             FB_OBJECT_NAME,
                                             CONDITION_REMRAKS,
                                             EAN,
                                             LISTED_YN,
                                             DISCARD,
                                             DISCARD_BY,
                                             DISCARD_DATE) VALUES
                                            ('$special_lot_id',
                                             '$get_barcode_no',
                                             '$object_id',
                                             '0',
                                             sysdate,
                                             '$get_user',
                                             '$catalogue_mt_id',
                                             null,
                                             null,
                                             '$condi_id',
                                             '$laptop_zone_id',
                                             null,
                                             '$ent_title',
                                             null,
                                             null,
                                             null,
                                             null,
                                             sysdate,
                                             '$get_user',
                                             null,
                                             null,
                                             '$enter_manu',
                                             '$sum',
                                             '$lot_defination_lot_id',
                                            --  null,
                                             '$get_barcode_no',
                                             null,
                                             null,
                                             null,
                                             null,
                                             null,
                                             null,
                                             null,
                                             null,
                                             null,
                                             null,
                                             0,
                                             null,
                                             null)";
                                            $insert_special_lot_mt = $this->db->query($insert_special_lot_mt);
                                            if ($insert_special_lot_mt == true) {
                                                if (count($images) > 0) {
                                                    /*=======================================
                                                    // =            save pic to dir            =
                                                    // =======================================*/
                                                    $dir_path_idd = 2;
                                                    $query = $this->db->query("SELECT C.MASTER_PATH FROM LZ_PICT_PATH_CONFIG C WHERE C.PATH_ID = '$dir_path_idd'")->result_array();
                                                    $pic_dir = $query[0]['MASTER_PATH'];
                                                    $folderName = $get_barcode_no;
                                                    // $condition_name = "new";
                                                    // $pic_dir = 'D:/wamp/www/item_pictures/dekitted_pictures/';
                                                    $folder_dir = $pic_dir . $folderName;
                                                    $thumb_dir = $pic_dir . $folderName . '\thumb';

                                                    if (!is_dir($folder_dir)) {
                                                        mkdir($folder_dir);

                                                        if (!is_dir($thumb_dir)) {
                                                            mkdir($thumb_dir);
                                                        }

                                                    }

                                                    for ($i = 0; $i < count($images); $i++) {

                                                        $image = $pic_dir . $images[$i]['barcode'] . '/' . $images[$i]['filename'] . '.' . $images[$i]['extension'];
                                                        $thumb_image = $pic_dir . $images[$i]['barcode'] . '/thumb/' . $images[$i]['filename'] . '.' . $images[$i]['extension'];
                                                        copy($image, $folder_dir . '/' . $images[$i]['filename'] . '.' . $images[$i]['extension']);
                                                        copy($thumb_image, $folder_dir . '/thumb' . '/' . $images[$i]['filename'] . '.' . $images[$i]['extension']);

                                                    }
                                                    return array("status" => true, "message" => "Lot Created Aganist this Barcode $get_barcode_no");
                                                }

                                                // /*=======================================
                                                // =            save pic to dir            =
                                                // =======================================*/
                                                // $dir_path_id = 2;
                                                // $query = $this->db->query("SELECT C.MASTER_PATH FROM LZ_PICT_PATH_CONFIG C WHERE C.PATH_ID = '$dir_path_id'")->result_array();
                                                // $pic_dir = $query[0]['MASTER_PATH'];

                                                // $folderName = $get_barcode_no;
                                                // // $condition_name = "new";
                                                // $folder_dir = $pic_dir . $folderName;
                                                // $thumb_dir = $pic_dir . $folderName . '\thumb';
                                                // // $pic_dir = 'D:/wamp/www/item_pictures/dekitted_pictures/';
                                                // // $folder_dir = 'D:/wamp/www/item_pictures/dekitted_picture/testimage';
                                                // for ($i = 0; $i < count($data); $i++) {
                                                //     $barcodes[] = $data[$i]["BARCODE_NO"];
                                                // }
                                                // // $barcodes = ['1234', '1235', '1236', '1237', '1234', '1234', '1234', '1234', '1234', '1234', '1234', '1234', '1234', '1234', '1234'];
                                                // if (!is_dir($folder_dir)) {
                                                //     mkdir($folder_dir);
                                                //     // if ($dir_path_id == 2) {
                                                //     //     $thumb_dir = $pic_dir . $folderName . '/' . $condition_name . '\thumb';
                                                //     //     if (!is_dir($folder_dir . '/' . $condition_name)) {
                                                //     //         mkdir($folder_dir . '/' . $condition_name);
                                                //     //     }
                                                //     // }
                                                //     $thumb_dir = $pic_dir . $folderName . '\thumb';

                                                //     if (!is_dir($thumb_dir)) {
                                                //         mkdir($thumb_dir);
                                                //     }

                                                // }
                                                // $count = count($barcodes);
                                                // if ($count >= 12) {
                                                //     foreach ($barcodes as $barcode) {
                                                //         $new_pic_dir = $pic_dir . $barcode;
                                                //         // var_dump($new_pic_dir);
                                                //         if (is_dir($new_pic_dir)) {

                                                //             $images = glob($new_pic_dir . "/*.{JPG,jpg,GIF,gif,PNG,png,BMP,bmp,JPEG,jpeg}", GLOB_BRACE);
                                                //             // $imageUrl = 'D:/wamp/www/item_pictures/dekitted_pictures/1234/images_off.bmp';
                                                //             $i = 0;
                                                //             $azRange = range('A', 'Z');
                                                //             $this->load->library('image_lib');
                                                //             // var_dump($images[0]);
                                                //             // foreach ($images as $image) {
                                                //             // var_dump($folder_dir);
                                                //             $pathinfo = pathinfo($images[0]);
                                                //             echo $pathinfo['filename'] . '.' . $pathinfo['extension'];
                                                //             copy($images[0], $folder_dir . '/' . $pathinfo['filename'] . '.' . $pathinfo['extension']);
                                                //             copy($images[0], $folder_dir . '/thumb' . '/' . $pathinfo['filename'] . '.' . $pathinfo['extension']);

                                                //             $config['image_library'] = 'gd2';
                                                //             $config['source_image'] = $images[0];
                                                //             $config['new_image'] = $folder_dir . '/' . $pathinfo['filename'] . '.' . $pathinfo['extension'];
                                                //             $config['maintain_ratio'] = true;
                                                //             $config['width'] = 1000;
                                                //             $config['height'] = 800;
                                                //             $in = $this->image_lib->initialize($config);
                                                //             $result = $this->image_lib->resize($in);
                                                //             $this->image_lib->clear();
                                                //             /*====================================
                                                //             =            image thumbnail creation            =
                                                //             ====================================*/
                                                //             $config['image_library'] = 'GD2';
                                                //             $config['source_image'] = $images[0];
                                                //             if (!is_dir($folder_dir . "/thumb")) {
                                                //                 mkdir($folder_dir . "/thumb");
                                                //             }
                                                //             $config['new_image'] = $folder_dir . '/thumb' . '/' . $pathinfo['filename'] . '.' . $pathinfo['extension'];
                                                //             $config['maintain_ratio'] = true;
                                                //             $config['width'] = 100;
                                                //             $config['height'] = 100;

                                                //             //$config['quality']     = 50; this filter doesnt work
                                                //             $in = $this->image_lib->initialize($config);
                                                //             $result = $this->image_lib->resize($in);
                                                //             $this->image_lib->clear();

                                                //             /*=====  End of image thumbnail creation  ======*/
                                                //             $i++;
                                                //         }
                                                //         // }
                                                //     }

                                                // } else {
                                                //     foreach ($barcodes as $barcode) {
                                                //         $new_pic_dir = $pic_dir . $barcode;
                                                //         // var_dump($new_pic_dir);
                                                //         if (is_dir($new_pic_dir)) {

                                                //             $images = glob($new_pic_dir . "/*.{JPG,jpg,GIF,gif,PNG,png,BMP,bmp,JPEG,jpeg}", GLOB_BRACE);
                                                //             // $imageUrl = 'D:/wamp/www/item_pictures/dekitted_pictures/1234/images_off.bmp';
                                                //             $i = 0;
                                                //             $azRange = range('A', 'Z');
                                                //             $this->load->library('image_lib');
                                                //             /*====================================
                                                //             =    Barcode Images  Greater than 1            =
                                                //             ====================================*/

                                                //             if (count($images) > 1) {

                                                //                 for ($i = 0; $i < 2; $i++) {
                                                //                     $path = $images[$i];
                                                //                     $pathinfo = pathinfo($path);
                                                //                     ($pathinfo['filename'] . '.' . $pathinfo['extension']);
                                                //                     copy($images[$i], $folder_dir . '/' . $pathinfo['filename'] . '.' . $pathinfo['extension']);
                                                //                     copy($images[$i], $folder_dir . '/thumb' . '/' . $pathinfo['filename'] . '.' . $pathinfo['extension']);
                                                //                     $config['image_library'] = 'gd2';
                                                //                     $config['source_image'] = $images[$i];
                                                //                     $config['new_image'] = $folder_dir . '/' . $pathinfo['filename'] . '.' . $pathinfo['extension'];
                                                //                     $config['maintain_ratio'] = true;
                                                //                     $config['width'] = 1000;
                                                //                     $config['height'] = 800;
                                                //                     $in = $this->image_lib->initialize($config);
                                                //                     $result = $this->image_lib->resize($in);
                                                //                     $this->image_lib->clear();
                                                //                     /*====================================
                                                //                     =            image thumbnail creation            =
                                                //                     ====================================*/
                                                //                     $config['image_library'] = 'GD2';
                                                //                     $config['source_image'] = $images[$i];
                                                //                     if (!is_dir($folder_dir . "/thumb")) {
                                                //                         mkdir($folder_dir . "/thumb");
                                                //                     }
                                                //                     $config['new_image'] = $folder_dir . '/thumb' . '/' . $pathinfo['filename'] . '.' . $pathinfo['extension'];
                                                //                     $config['maintain_ratio'] = true;
                                                //                     $config['width'] = 100;
                                                //                     $config['height'] = 100;

                                                //                     //$config['quality']     = 50; this filter doesnt work
                                                //                     $in = $this->image_lib->initialize($config);
                                                //                     $result = $this->image_lib->resize($in);
                                                //                     $this->image_lib->clear();
                                                //                 }
                                                //             } else {
                                                //                 /*====================================
                                                //                 =    Barcode Images == 1            =
                                                //                 ====================================*/
                                                //                 $path = $images[$i];
                                                //                 $pathinfo = pathinfo($path);
                                                //                 ($pathinfo['filename'] . '.' . $pathinfo['extension']);
                                                //                 copy($images[$i], $folder_dir . '/' . $pathinfo['filename'] . '.' . $pathinfo['extension']);
                                                //                 copy($images[$i], $folder_dir . '/thumb' . '/' . $pathinfo['filename'] . '.' . $pathinfo['extension']);
                                                //                 $config['image_library'] = 'gd2';
                                                //                 $config['source_image'] = $images[$i];
                                                //                 $config['new_image'] = $folder_dir . '/' . $pathinfo['filename'] . '.' . $pathinfo['extension'];
                                                //                 $config['maintain_ratio'] = true;
                                                //                 $config['width'] = 1000;
                                                //                 $config['height'] = 800;
                                                //                 $in = $this->image_lib->initialize($config);
                                                //                 $result = $this->image_lib->resize($in);
                                                //                 $this->image_lib->clear();
                                                //                 /*====================================
                                                //                 =            image thumbnail creation     =
                                                //                 ====================================*/
                                                //                 $config['image_library'] = 'GD2';
                                                //                 $config['source_image'] = $images[$i];
                                                //                 if (!is_dir($folder_dir . "/thumb")) {
                                                //                     mkdir($folder_dir . "/thumb");
                                                //                 }
                                                //                 $config['new_image'] = $folder_dir . '/thumb' . '/' . $pathinfo['filename'] . '.' . $pathinfo['extension'];
                                                //                 $config['maintain_ratio'] = true;
                                                //                 $config['width'] = 100;
                                                //                 $config['height'] = 100;

                                                //                 //$config['quality']     = 50; this filter doesnt work
                                                //                 $in = $this->image_lib->initialize($config);
                                                //                 $result = $this->image_lib->resize($in);
                                                //                 $this->image_lib->clear();
                                                //             }
                                                //         }
                                                //     }
                                                // }
                                                return array("status" => true, "message" => "Lot Created Aganist this Barcode $get_barcode_no");
                                            } else {
                                                return array("status" => false, "message" => "special lot Error");
                                            }
                                        } else {
                                            return array("status" => false, "message" => "Catalogue Mt Error");
                                        }
                                    } else {
                                        return array("status" => false, "message" => "Merchant Barcode DT Error");
                                    }
                                } else {
                                    return array("status" => false, "message" => "Merchant Barcode MT Error");
                                }

                            } else {
                                return array("status" => false, "message" => "Lot Def Error");
                            }

                        } else {
                            return array("status" => false, "message" => "lz BARCODE MT Error");
                        }
                    } else {
                        return array("status" => false, "message" => "cell proc Error");
                    }
                } else {
                    return array("status" => false, "message" => "det query Error");
                }
            } else {
                return array("status" => false, "message" => "mt query  Error");
            }
        } /*--- Insertion Query for LZ_MANIFEST_MT end---*/

        // **** code for insertion into lz_manifest_mt end
        //************************************************************************
    }

    // Create Lot UNPOST BARCODES

    public function get_Lot_UnPosted_Barcode_Detail()
    {
        $barcode = $this->input->post('barcode');

        // var_dump($barcode);

        $result = $this->db->query("SELECT *
        FROM lz_special_lots b
       WHERE b.barcode_prv_no = '$barcode' ");
        //    Dekit Barcode Check
        $dekit = $this->db->query("SELECT *
       FROM lz_dekit_us_dt b
      WHERE b.barcode_prv_no = '$barcode'");
        //   Merchant Barcode Dt Check

        $barcodes = "SELECT * FROM lz_merchant_barcode_dt WHERE BARCODE_NO = '$barcode'";
        $resultBarcode = $this->db->query($barcodes);
        if ($result->num_rows() > 0) {
            $data = $result->result_array();
            if ($data[0]['LZ_MANIFEST_DET_ID'] !== null) {
                $psoted = $data[0]['LZ_MANIFEST_DET_ID'];
                return array("status" => false, 'message' => "Barcode Already Posted For $psoted ");
            }
            $data = ("SELECT ls.mpn_description  TITLE,
            ls.barcode_prv_no  BARCODE,
            ls.card_mpn   MPN,
            ls.card_upc   UPC,
            con.cond_name CONDITION,
            ls.brand  BRAND,
            ls.ITEM_COST COST_PRICE,
            ls.weight  WEIGHT,
                ls.CARD_CATEGORY_ID  CATEGORY
       FROM lz_special_lots ls, lz_item_cond_mt con
      WHERE ls.barcode_prv_no =  '$barcode'
        AND ls.condition_id = con.id(+)
        AND ls.lz_manifest_det_id IS NULL");

        } else if ($dekit->num_rows() > 0) {
            $dekitData = $dekit->result_array();
            if ($dekitData[0]['LZ_MANIFEST_DET_ID'] !== null) {
                $psoted = $dekitData[0]['LZ_MANIFEST_DET_ID'];
                return array("status" => false, 'message' => "Barcode Already Posted For $psoted ");
            }
            $data = ("SELECT ld.mpn_description  TITLE,
            ld.barcode_prv_no  BARCODE,
            ld.WEIGHT   WEIGHT,
            con.cond_name CONDITION
                FROM lz_dekit_us_dt ld, lz_item_cond_mt con
                WHERE ld.barcode_prv_no =  '$barcode'
                AND ld.condition_id = con.id(+)
                AND ld.lz_manifest_det_id IS NULL");

        } else {
            if ($resultBarcode->num_rows() > 0) {
                $availBarcode = $resultBarcode->result_array();
                if ($availBarcode[0]['LOT_ID'] !== null) {
                    $psoted = $availBarcode[0]['LOT_ID'];
                    return array("status" => false, 'message' => "Barcode Already Loted For $psoted ");
                }
                if ($availBarcode[0]['POS_STATUS'] == 1) {
                    return array("status" => false, 'message' => "Barcode Already use in POS ");
                }
                $data = ("SELECT COST COST_PRICE, BARCODE_NO BARCODE FROM lz_merchant_barcode_dt WHERE BARCODE_NO = '$barcode'");
            }
        }

        $qr = ("select lm.CONTACT_PERSON, lm.MERCHANT_ID
                     from lz_merchant_barcode_dt d, lz_merchant_barcode_mt m, lz_merchant_mt lm
                     where d.BARCODE_NO = '$barcode'
                     and m.pos_status != 1
                     AND d.mt_id = m.mt_id
                     AND m.merchant_id = lm.merchant_id");
        $res = $this->db->query($qr);
        $barcode_detail = $this->db->query($data);
        if ($barcode_detail->num_rows() > 0) {
            if ($res->num_rows() > 0) {
                $data = $res->result_array();
                $merchant_name = $data[0]["CONTACT_PERSON"];
                $merchant_id = $data[0]["MERCHANT_ID"];
                $images = $this->Get_Image_DecodeBase64($barcode);
                if ($images['status'] == true) {
                    return array("status" => true, 'data' => $barcode_detail->result_array(), "merchant_detail" => $res->result_array(), "images" => $images['images']);
                } else {
                    return array("status" => false, "message" => $images['message']);
                }
            } else {
                $data = array(
                    "CONTACT_PERSON" => "DFWONLINE",
                    "MERCHANT_ID" => "10000000072",
                );
                $images = $this->Get_Image_DecodeBase64($barcode);
                if ($images['status'] == true) {
                    return array("status" => true, 'data' => $barcode_detail->result_array(), "merchant_detail" => array($data), "images" => $images['images']);
                } else {
                    return array("status" => false, "message" => $images['message']);
                }
            }

        } else {
            return array("status" => false, 'message' => "No Barcode Detail Found");
        }

    }

    public function Get_Lot_UnPosted_Range_Barcode_Detail()
    {

        $start_ser_barcode = $this->input->post('start_ser_barcode');
        $end_ser_barcode = $this->input->post("end_ser_barcode");

        //  Special Lot Barcode Check
        $qr = "SELECT *
        FROM lz_special_lots b
       WHERE b.barcode_prv_no BETWEEN '$start_ser_barcode' AND '$end_ser_barcode'";
        $result = $this->db->query($qr);

        // Dekit Barcode Check

        $dekit = $this->db->query("SELECT * FROM lz_dekit_us_dt d
        WHERE d.barcode_prv_no BETWEEN '$start_ser_barcode' AND '$end_ser_barcode'");

        //   Merchant Barcode Dt Check

        // $barcodes = "SELECT * FROM lz_merchant_barcode_dt WHERE BARCODE_NO BETWEEN '$start_ser_barcode' AND '$end_ser_barcode'";
        $barcodes = "SELECT m.LOT_ID  LOT_ID,  d.BARCODE_NO  BARCODE from lz_merchant_barcode_dt d, lz_merchant_barcode_mt m WHERE m.mt_id = d.mt_id AND m.POS_STATUS != 1 AND d.barcode_no BETWEEN '$start_ser_barcode' AND '$end_ser_barcode' ";
        $resultBarcode = $this->db->query($barcodes);

        if ($result->num_rows() > 0) {
            $data = $result->result_array();
            $total_row = count($data);
            for ($i = 0; $i < $total_row; $i++) {

                if ($data[$i]['LZ_MANIFEST_DET_ID'] != null) {
                    $barcode = $data[$i]['BARCODE_PRV_NO'];
                    $error[] = array("status" => false, 'message' => "$barcode Barcode Already Consumed");
                } else {
                    $error = '';
                }
                $barcode = $data[$i]['BARCODE_PRV_NO'];
                // var_dump($barcode);
                $qrr = ("SELECT ls.mpn_description  TITLE,
                ls.barcode_prv_no  BARCODE,
                ls.card_mpn   MPN,
                ls.card_upc   UPC,
                con.cond_name CONDITION,
                ls.brand  BRAND,
                ls.ITEM_COST COST_PRICE,
                ls.weight  WEIGHT,
                ls.CARD_CATEGORY_ID  CATEGORY
                    FROM lz_special_lots ls, lz_item_cond_mt con
                    WHERE ls.barcode_prv_no =  '$barcode'
                    AND ls.condition_id = con.id(+)
                    AND ls.lz_manifest_det_id IS NULL");

                $qr = ("select lm.CONTACT_PERSON, lm.MERCHANT_ID
                                  from lz_merchant_barcode_dt d, lz_merchant_barcode_mt m, lz_merchant_mt lm
                                  where d.BARCODE_NO = '$barcode'
                                  and m.pos_status != 1
                                  AND d.mt_id = m.mt_id
                                  AND m.merchant_id = lm.merchant_id");
                $images[] = $this->Range_Get_Image_DecodeBase64($barcode);
                $barcode_detail = $this->db->query($qrr);
                $res = $this->db->query($qr);
                if ($barcode_detail->num_rows() > 0) {
                    if ($res->num_rows() > 0) {
                        $result = $res->result_array();
                        $merchant_name = $result[0]["CONTACT_PERSON"];
                        $name[] = $merchant_name;
                        if ($name[0] == $result[0]["CONTACT_PERSON"]) {
                            $dataArray[] = $barcode_detail->result_array();
                            $merchantArray[] = $res->result_array();
                        } else {
                            $error[] = array("status" => false, "message" => "$barcode Barcode Merchant Name ($merchant_name) Is Not Same With Other");
                            $dataArray[] = $barcode_detail->result_array();
                            $merchantArray[] = $res->result_array();
                        }
                    } else {
                        $merchant_detail = array(
                            "CONTACT_PERSON" => "DFWONLINE",
                            "MERCHANT_ID" => "10000000072",
                        );
                        $dataArray[] = $barcode_detail->result_array();
                        $merchantArray[] = array($merchant_detail);
                    }

                } else {
                    $error[] = array("status" => false, "message" => "No Record Aganist This $barcode Barcode");
                    $dataArray[] = array();
                    $merchantArray[] = array();
                    $images[] = array();
                }
            }
            if (empty($error)) {
                return array("data" => $dataArray, "merchant_name" => $merchantArray, "images" => $images);
            } else {
                return array("data" => $dataArray, "merchant_name" => $merchantArray, "images" => $images, "error" => $error);
            }

        } else if ($dekit->num_rows() > 0) {

            $data = $dekit->result_array();
            $total_row = count($data);
            for ($i = 0; $i < $total_row; $i++) {

                if ($data[$i]['LZ_MANIFEST_DET_ID'] != null) {
                    $barcode = $data[$i]['BARCODE_PRV_NO'];
                    $error[] = array("status" => false, 'message' => "$barcode Barcode Already Consumed");
                } else {
                    $error = '';
                }
                $barcode = $data[$i]['BARCODE_PRV_NO'];
                $qrr = ("SELECT ld.mpn_description  TITLE,
            ld.barcode_prv_no  BARCODE,
            ld.WEIGHT   WEIGHT,
            con.cond_name CONDITION
                FROM lz_dekit_us_dt ld, lz_item_cond_mt con
                WHERE ld.barcode_prv_no =  '$barcode'
                AND ld.condition_id = con.id(+)
                AND ld.lz_manifest_det_id IS NULL");

                $qr = ("select lm.CONTACT_PERSON, lm.MERCHANT_ID
                              from lz_merchant_barcode_dt d, lz_merchant_barcode_mt m, lz_merchant_mt lm
                              where d.BARCODE_NO = '$barcode'
                              and m.pos_status != 1
                              AND d.mt_id = m.mt_id
                              AND m.merchant_id = lm.merchant_id");
                $images[] = $this->Range_Get_Image_DecodeBase64($barcode);
                $barcode_detail = $this->db->query($qrr);
                $res = $this->db->query($qr);
                if ($barcode_detail->num_rows() > 0) {
                    if ($res->num_rows() > 0) {
                        $result = $res->result_array();
                        $merchant_name = $result[0]["CONTACT_PERSON"];
                        $name[] = $merchant_name;
                        if ($name[0] == $result[0]["CONTACT_PERSON"]) {
                            $dataArray[] = $barcode_detail->result_array();
                            $merchantArray[] = $res->result_array();
                        } else {
                            $error[] = array("status" => false, "message" => "$barcode Barcode Merchant Name ($merchant_name) Is Not Same With Other");
                            $dataArray[] = $barcode_detail->result_array();
                            $merchantArray[] = $res->result_array();
                        }
                    } else {
                        $merchant_detail = array(
                            "CONTACT_PERSON" => "DFWONLINE",
                            "MERCHANT_ID" => "10000000072",
                        );
                        $dataArray[] = $barcode_detail->result_array();
                        $merchantArray[] = array($merchant_detail);
                    }

                } else {
                    $error[] = array("status" => false, "message" => "No Record Aganist This $barcode Barcode");
                    $dataArray[] = array();
                    $merchantArray[] = array();
                    $images[] = array();
                }
            }
            if (empty($error)) {
                return array("data" => $dataArray, "merchant_name" => $merchantArray, "images" => $images);
            } else {
                return array("data" => $dataArray, "merchant_name" => $merchantArray, "images" => $images, "error" => $error);
            }

        } else if ($resultBarcode->num_rows() > 0) {

            $data = $resultBarcode->result_array();
            // var_dump($data);
            // exit;
            $total_row = count($data);
            for ($i = 0; $i < $total_row; $i++) {

                if (($data[$i]['LOT_ID']) !== null) {
                    $barcode = $data[$i]['BARCODE'];
                    $error[] = array("status" => false, 'message' => "$barcode Barcode Already Loted");
                } else {
                    $error = '';
                }
                $barcode = $data[$i]['BARCODE'];
                $qrr = ("SELECT COST COST_PRICE, BARCODE_NO BARCODE FROM lz_merchant_barcode_dt WHERE BARCODE_NO = '$barcode'");
                $qr = ("select lm.CONTACT_PERSON, lm.MERCHANT_ID
                              from lz_merchant_barcode_dt d, lz_merchant_barcode_mt m, lz_merchant_mt lm
                              where d.BARCODE_NO = '$barcode'
                              and m.pos_status != 1
                              AND d.mt_id = m.mt_id
                              AND m.merchant_id = lm.merchant_id");
                $images[] = $this->Range_Get_Image_DecodeBase64($barcode);
                $barcode_detail = $this->db->query($qrr);
                $res = $this->db->query($qr);
                if ($barcode_detail->num_rows() > 0) {
                    if ($res->num_rows() > 0) {
                        $result = $res->result_array();
                        $merchant_name = $result[0]["CONTACT_PERSON"];
                        $name[] = $merchant_name;
                        if ($name[0] == $result[0]["CONTACT_PERSON"]) {
                            $dataArray[] = $barcode_detail->result_array();
                            $merchantArray[] = $res->result_array();
                        } else {
                            $error[] = array("status" => false, "message" => "$barcode Barcode Merchant Name ($merchant_name) Is Not Same With Other");
                            $dataArray[] = $barcode_detail->result_array();
                            $merchantArray[] = $res->result_array();
                        }
                    } else {
                        $merchant_detail = array(
                            "CONTACT_PERSON" => "DFWONLINE",
                            "MERCHANT_ID" => "10000000072",
                        );
                        $dataArray[] = $barcode_detail->result_array();
                        $merchantArray[] = array($merchant_detail);
                    }

                } else {
                    $error[] = array("status" => false, "message" => "No Record Aganist This $barcode Barcode");
                    $dataArray[] = array();
                    $merchantArray[] = array();
                    $images[] = array();
                }
            }
            if (empty($error)) {
                return array("data" => $dataArray, "merchant_name" => $merchantArray, "images" => $images);
            } else {
                return array("data" => $dataArray, "merchant_name" => $merchantArray, "images" => $images, "error" => $error);
            }
        } else {
            return array("status" => false, 'message' => "No Barcode Found", "data" => array(), "merchant_name" => array(), "images" => array(), "error" => array());

        }
    }

    public function Save_Unposted_Lot_Data()
    {
        // Image Lib
        $this->load->library('image_lib');

        $data = $this->input->post("data");
        $enter_manu = $this->input->post('enter_manu');
        $ent_title = $this->input->post('title');
        $get_user = $this->input->post('user_id');
        $bin = $this->input->post('bin');
        $ent_title = str_replace("'", "''", $ent_title);
        $condi_name = $this->input->post('selectcondition');
        $condi_id = $this->input->post('selectconditionid');
        $ent_cat_id = $this->input->post('category');
        $merchant_id = $this->input->post("merchant_id");
        $object_id = $this->input->post('object_id');
        $enter_mp = $this->input->post('mpn');
        $images = $this->input->post("images");
        $title = trim(str_replace("  ", ' ', $enter_mp));
        $title = str_replace(array("`,′"), "", $title);
        $title = str_replace(array("'"), "''", $title);
        $barcodeQr = "SELECT seq_barcode_no.nextval barcode FROM dual";
        $result = $this->db->query($barcodeQr);
        $barc = $result->result_array();
        $get_barcode_no = $barc[0]['BARCODE'];
        // var_dump($title);
        // var_dump($ent_cat_id);
        // var_dump($condi_name);
        // var_dump($get_user);
        // var_dump(count($images));
        // var_dump($merchant_id);
        // var_dump($data);
        // var_dump($get_barcode_no);
        // var_dump($ent_cat_id);
        // exit;
        if (empty($enter_mp)) {
            $enter_mp_cust = 'LOTMPN';
        } else {
            $enter_mp_cust = $title;
        }

        $lot_defination_lot_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('lot_defination_mt ', 'LOT_ID')ID FROM DUAL")->result_array();
        $lot_defination_lot_id = $lot_defination_lot_id[0]['ID'];
        $sum = 0;
        $sumWeight = 0;
        for ($i = 0; $i < count($data); $i++) {
            if (isset($data[$i]["COST_PRICE"])) {
                $sum = $sum + $data[$i]["COST_PRICE"];
            }
            if (isset($data[0]['WEIGHT'])) {
                $sumWeight = $sumWeight + $data[$i]["WEIGHT"];
            }
        }
        $insert_lot_def = "INSERT INTO lot_defination_mt(LOT_ID,
                            REF_NO,
                            PURCHASE_DATE,
                            ASSIGN_DATE,
                            COST,
                            PROFIT_REQUIRE,
                            SOURCE,
                            EST_REQUEST,
                            PARTIAL_LIST,
                            LINE_ITEM_COST_AVAIL,
                            APPROVAL_REQUIRE,
                            EST_SHIP_SERVIC,
                            LOT_DESC,
                            LOT_STATUS,
                            MERCHANT_ID,
                            BILLING_TYPE) VALUES ($lot_defination_lot_id, $lot_defination_lot_id, sysdate, sysdate, '$sum', null, 'Lot Screen', null, null, null, null, null, '$ent_title', 1, '$merchant_id', null)";

        $insert_lot_def = $this->db->query($insert_lot_def);
        if ($insert_lot_def == true) {
            $merchant_barcode_mt_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('lz_merchant_barcode_mt ', 'MT_ID')ID FROM DUAL")->result_array();
            $merchant_barcode_mt_id = $merchant_barcode_mt_id[0]['ID'];
            $insert_merchant_barcode_mt = "INSERT INTO lz_merchant_barcode_mt
                                (MT_ID,
                                 MERCHANT_ID,
                                 ISSUED_DATE,
                                 ISSUED_BY,
                                 NO_OF_BARCODE,
                                 LOT_ID,
                                 RANGE_ID,
                                 LZ_PRODUCT_INV_ID,
                                 POS_STATUS)
                              VALUES
                                ('$merchant_barcode_mt_id',
                                 '$merchant_id',
                                 sysdate,
                                 '$get_user',
                                 1,
                                 '$lot_defination_lot_id',
                                 0,
                                 null,
                                 0)";
            $insert_merchant_barcode_mt = $this->db->query($insert_merchant_barcode_mt);
            if ($insert_merchant_barcode_mt == true) {

                $merchant_barcode_dt_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('lz_merchant_barcode_dt ', 'DT_ID')ID FROM DUAL")->result_array();
                $merchant_barcode_dt_id = $merchant_barcode_dt_id[0]['ID'];
                $insert_merchant_barcode_dt = "INSERT INTO lz_merchant_barcode_dt
                                (DT_ID,
                                 MT_ID,
                                 BARCODE_NO,
                                 SALE_PRICE,
                                 SHIPING_SERVICE,
                                 ACCOUNT_ID,
                                 DISCARD_COND,
                                 APPOINTMENT_DT_ID_INV,
                                 APPOINTMENT_DT_ID_PIC,
                                 COST,
                                 BARCODE_STATUS,
                                 REMARKS,
                                 STATUS_DATE,
                                 STATUS_BY,
                                 ADMIN_STATUS,
                                 NOTIFICATION,
                                 BIN_ID) VALUES
                                ('$merchant_barcode_dt_id',
                                 '$merchant_barcode_mt_id',
                                 '$get_barcode_no',
                                 0,
                                 null,
                                 null,
                                 null,
                                 null,
                                 null,
                                 0.00,
                                 0,
                                 null,
                                 null,
                                 null,
                                 0,
                                 null,
                                 0) ";
                $insert_merchant_barcode_dt = $this->db->query($insert_merchant_barcode_dt);
                if ($insert_merchant_barcode_dt == true) {
                    $select = "SELECT CATALOGUE_MT_ID from LZ_CATALOGUE_MT WHERE  CATEGORY_ID = '$ent_cat_id' AND  UPPER(MPN) = UPPER('$enter_mp')";
                    $result = $this->db->query($select);
                    if ($result->num_rows() > 0) {
                        $id = $result->result_array();
                        $catalogue_mt_id = $id[0]['CATALOGUE_MT_ID'];

                    } else {
                        $catalogue_mt_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('lz_catalogue_mt ', 'CATALOGUE_MT_ID')ID FROM DUAL")->result_array();
                        $catalogue_mt_id = $catalogue_mt_id[0]['ID'];
                        $insert_into_catalogue = "INSERT INTO lz_catalogue_mt
                                            (CATALOGUE_MT_ID,
                                             MPN,
                                             CATEGORY_ID,
                                             INSERTED_DATE,
                                             INSERTED_BY,
                                             CUSTOM_MPN,
                                             OBJECT_ID,
                                             MPN_DESCRIPTION,
                                             AUTO_CREATED,
                                             LAST_RUN_TIME,
                                             BRAND,
                                             PRICE,
                                             UPC)
                                          VALUES
                                            ('$catalogue_mt_id',
                                             '$enter_mp',
                                             '$ent_cat_id',
                                             sysdate,
                                             '$get_user',
                                             0,
                                             '$object_id',
                                             '$ent_title',
                                             0,
                                             null,
                                             '$enter_manu',
                                             null,
                                             null)
                                          ";
                        $insert_into_catalogue = $this->db->query($insert_into_catalogue);
                    }

                    if (1) {
                        $special_lot_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('lz_special_lots ', 'SPECIAL_LOT_ID')ID FROM DUAL")->result_array();
                        $special_lot_id = $special_lot_id[0]['ID'];
                        $insert_special_lot_mt = "INSERT INTO lz_special_lots
                                            (SPECIAL_LOT_ID,
                                             BARCODE_PRV_NO,
                                             OBJECT_ID,
                                             BIN_ID,
                                             PIC_DATE_TIME,
                                             PIC_BY,
                                             CATALOG_MT_ID,
                                             LOT_REMARKS,
                                             WEIGHT,
                                             CONDITION_ID,
                                             LZ_MANIFEST_DET_ID,
                                             PIC_NOTES,
                                             MPN_DESCRIPTION,
                                             PIC_STATUS,
                                             PIC_TEXT,
                                             CARD_UPC,
                                             CARD_MPN,
                                             INSERTED_AT,
                                             INSERTED_BY,
                                             UPDATED_AT,
                                             UPDATED_BY,
                                             BRAND,
                                             ITEM_COST,
                                             LOT_ID,
                                            --  QTY,
                                             FOLDER_NAME,
                                             AVG_SOLD,
                                             CARD_CATEGORY_ID,
                                             BARCODE_NOTES,
                                             ALLOCATE_TO,
                                             ALLOC_DATE,
                                             ALLOCATED_BY,
                                             FB_OBJECT_NAME,
                                             CONDITION_REMRAKS,
                                             EAN,
                                             LISTED_YN,
                                             DISCARD,
                                             DISCARD_BY,
                                             DISCARD_DATE) VALUES
                                            ('$special_lot_id',
                                             '$get_barcode_no',
                                             '$object_id',
                                             '0',
                                             sysdate,
                                             '$get_user',
                                             '$catalogue_mt_id',
                                             null,
                                             '$sumWeight',
                                             '$condi_id',
                                             null,
                                             null,
                                             '$ent_title',
                                             null,
                                             null,
                                             null,
                                             '$enter_mp',
                                             sysdate,
                                             '$get_user',
                                             null,
                                             null,
                                             '$enter_manu',
                                             '$sum',
                                             '$lot_defination_lot_id',
                                            --  null,
                                             '$get_barcode_no',
                                             null,
                                             '$ent_cat_id',
                                             null,
                                             null,
                                             null,
                                             null,
                                             null,
                                             null,
                                             null,
                                             null,
                                             0,
                                             null,
                                             null)";
                        $insert_special_lot_mt = $this->db->query($insert_special_lot_mt);
                        if ($insert_special_lot_mt == true) {
                            $get_data = $this->db->query("SELECT trim(L.CARD_UPC) CARD_UPC, UPPER(trim(L.CARD_MPN)) CARD_MPN FROM LZ_SPECIAL_LOTS L WHERE L.SPECIAL_LOT_ID = '$special_lot_id'")->result_array();
                            $card_mpn = $get_data[0]['CARD_MPN'];
                            $card_upc = $get_data[0]['CARD_UPC'];
                            // $insert_by = $this->session->userdata('user_id');

                            if (!empty($card_upc) and !empty($card_mpn)) {

                                $query = $this->db->query("call PRO_SINGLE_INSERT_LOTS('=''$card_upc''' , '=''$card_mpn''', '$get_user') ");

                            } elseif (!empty($card_upc) and empty($card_mpn)) {
                                $query = $this->db->query("call PRO_SINGLE_INSERT_LOTS('=''$card_upc''' , ' IS NULL', '$get_user') ");

                            } elseif (empty($card_upc) and !empty($card_mpn)) {
                                $query = $this->db->query("call PRO_SINGLE_INSERT_LOTS(' IS NULL' , '=''$card_mpn''', '$get_user') ");

                            } elseif (empty($card_upc) and empty($card_mpn)) {
                                // die('UPC and Mpn is required');
                                return array("status" => false, "message" => "Must Enter MPN Or UPC");
                            }

                            if ($query) {
                                /*=======================================
                                // =            save pic to dir            =
                                // =======================================*/
                                if (count($images) > 0) {
                                    $dir_path_idd = 2;
                                    $query = $this->db->query("SELECT C.MASTER_PATH FROM LZ_PICT_PATH_CONFIG C WHERE C.PATH_ID = '$dir_path_idd'")->result_array();
                                    $pic_dir = $query[0]['MASTER_PATH'];
                                    $folderName = $get_barcode_no;
                                    // $condition_name = "new";
                                    // $pic_dir = 'D:/wamp/www/item_pictures/dekitted_pictures/';
                                    $folder_dir = $pic_dir . $folderName;
                                    $thumb_dir = $pic_dir . $folderName . '\thumb';

                                    if (!is_dir($folder_dir)) {
                                        mkdir($folder_dir);

                                        if (!is_dir($thumb_dir)) {
                                            mkdir($thumb_dir);
                                        }

                                    }

                                    for ($i = 0; $i < count($images); $i++) {

                                        $image = $pic_dir . $images[$i]['barcode'] . '/' . $images[$i]['filename'] . '.' . $images[$i]['extension'];
                                        $thumb_image = $pic_dir . $images[$i]['barcode'] . '/thumb/' . $images[$i]['filename'] . '.' . $images[$i]['extension'];
                                        copy($image, $folder_dir . '/' . $images[$i]['filename'] . '.' . $images[$i]['extension']);
                                        copy($thumb_image, $folder_dir . '/thumb' . '/' . $images[$i]['filename'] . '.' . $images[$i]['extension']);

                                    }
                                    return array("status" => true, "message" => "Lot Created Aganist this Barcode $get_barcode_no");
                                }

                                return array("status" => true, "message" => "Lot Created Aganist this Barcode $get_barcode_no");
                            } else {
                                return array("status" => false, "message" => "Pro Single Insert Lots Error");
                            }
                        } else {
                            return array("status" => false, "message" => "special lot Error");
                        }
                    } else {
                        return array("status" => false, "message" => "Catalogue Mt Error");
                    }
                } else {
                    return array("status" => false, "message" => "Merchant Barcode DT Error");
                }
            } else {
                return array("status" => false, "message" => "Merchant Barcode MT Error");
            }

        } else {
            return array("status" => false, "message" => "Lot Def Error");
        }

        // **** code for insertion into lz_manifest_mt end
        //************************************************************************
    }

// ****************************************************************//
    //          Point Of Sale START
    // ****************************************************************//

    public function Doc_No()
    {
        $query = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_POS_MT','DOC_NO') DOC_NO FROM DUAL");
        return $query->result_array();
    }

    public function City_State_List()
    {
        $city_query = $this->db->query("SELECT * FROM WIZ_CITY_MT C WHERE C.STATE_ID > 1004");
        $city_query = $city_query->result_array();

        // $state_query = $this->db->query("SELECT * FROM WIZ_STATE_MT C WHERE  C.COUNTRY_ID = 2");
        // $state_query = $state_query->result_array();

        return array('city' => $city_query, 'state' => array());
    }

    public function Get_State()
    {
        $city_id = $this->input->post('city_id');
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

    public function Get_State_Edit()
    {
        $city_id = $this->input->post('city_id');
        $city_id = $city_id['value'];
        // var_dump($city_id);
        // exit;
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
    public function Get_POS_Store_Name()
    {
        $qry = "SELECT LJ_POS_STORE_ID, STORE_NAME, STATE_DESC, CITY_DESC
        FROM LJ_POS_STORE_MT ST, WIZ_CITY_MT C, WIZ_STATE_MT S
       WHERE C.CITY_ID = ST.CITY_ID
         AND S.STATE_ID = ST.STATE_ID";
        $result = $this->db->query($qry);
        return array("status" => true, "data" => $result->result_array());
    }

    public function Get_Tax()
    {
        $store_id = $this->input->post('store_id');
        $store_id = $store_id['value'];
        $qry = "SELECT SALE_TAX FROM LJ_POS_STORE_MT WHERE LJ_POS_STORE_ID = '$store_id'";
        $result = $this->db->query($qry);
        if ($result->num_rows() > 0) {
            return array("status" => true, "data" => $result->result_array());
        } else {
            $data = array("SALE_TAX" => "8.25");

            return array("status" => false, "data" => $data, "message" => "No Tax Found Add 8.25 Automaticaly");

        }
    }
    public function Get_Barcode_Detail_Pos()
    {
        $barcode = $this->input->post('barcode');
        $barcode = explode('@', $barcode);
        // var_dump(empty($barcode[1]));
        if (!empty($barcode[1])) {
            $barcode = $barcode[1];
        } else {
            $barcode = $this->input->post('barcode');
        }
        // if (isset($barcode)) {
        $result = $this->db->query("SELECT *
            FROM LZ_BARCODE_MT b
           WHERE b.BARCODE_NO = '$barcode'");

        if ($result->num_rows() > 0) {
            $data = $result->result_array();
            if ($data[0]['PULLING_ID'] != null) {
                $sale_record_no = $data[0]['SALE_RECORD_NO'];
                return array("status" => false, 'message' => "Barcode Ship Aganist sale Record $sale_record_no ", "model" => false);
            } else if ($data[0]['PULLING_ID'] == null && $data[0]['SALE_RECORD_NO'] != null) {
                $sale_record_no = $data[0]['SALE_RECORD_NO'];
                return array("status" => false, 'message' => "Barcode Already Sold Aganist sale Record  $sale_record_no ", "model" => false);
            } else if ($data[0]['PULLING_ID'] == null && $data[0]['SALE_RECORD_NO'] == null && $data[0]['EBAY_ITEM_ID'] != null) {
                $ebay_id = $data[0]['EBAY_ITEM_ID'];
                return array("status" => false, "message" => "Barcode Already Listed Aganist ebay id $ebay_id ", "model" => true, 'barcode' => $barcode, 'ebay_id' => $ebay_id);
            } else if ($data[0]['ITEM_ADJ_DET_ID_FOR_IN'] != null || $data[0]['ITEM_ADJ_DET_ID_FOR_OUT'] != null || $data[0]['LZ_PART_ISSUE_MT_ID'] != null || $data[0]['HOLD_STATUS'] != 0) {
                return array("status" => false, "message" => "Barcode Already Consumed", "model" => false);
            } elseif ($data[0]['LZ_POS_MT_ID'] != null) {
                $id = $data[0]['LZ_POS_MT_ID'];
                return array("status" => false, "message" => "Barcode Already Consumed By POS $id", "model" => false);
            } else if ($data[0]['REPAIR_ID'] !== null) {
                $id = $data[0]['REPAIR_ID'];
                return array("status" => false, "message" => "Barcode Already Consumed By Repair  $id", "model" => false);
            }
            $detail_query = $this->db->query("SELECT S.SEED_ID,
                LM.LZ_MANIFEST_ID,
                LM.PURCH_REF_NO,
                NVL(S.ITEM_TITLE, I.ITEM_DESC) ITEM_MT_DESC,
                I.ITEM_MT_MANUFACTURE MANUFACTURER,
                I.ITEM_MT_MFG_PART_NO MFG_PART_NO,
                I.ITEM_MT_UPC UPC,
                BCD.CONDITION_ID ITEM_CONDITION,
                BCD.QTY QUANTITY,
                S.EBAY_PRICE COST_PRICE,
                BCD.BARCODE_NO,
                null LINE_TYPE,
                null DISCOUNT_PER,
                null DISCOUNT_AMOUNT,
                null LZ_POS_DET_ID,
                DECODE(S.EBAY_PRICE, 0, 0 , S.EBAY_PRICE) NET_PRICE,
                0 ADVANCE_PAYMENT,
                null REPAIRE_ID
           FROM LZ_MANIFEST_MT LM,
                ITEMS_MT I,
                LZ_ITEM_SEED S,
                (SELECT BC.EBAY_ITEM_ID,
                        BC.LZ_MANIFEST_ID,
                        BC.ITEM_ID,
                        BC.BARCODE_NO,
                        BC.CONDITION_ID,
                        COUNT(1) QTY
                   FROM LZ_BARCODE_MT BC
                  WHERE BC.BARCODE_NO = '$barcode'
                    and bc.pulling_id is null
                  GROUP BY BC.LZ_MANIFEST_ID,
                           BC.ITEM_ID,
                           BC.CONDITION_ID,
                           BC.BARCODE_NO,
                           BC.EBAY_ITEM_ID) BCD,
                (SELECT D.LZ_MANIFEST_ID,
                        I.ITEM_ID,
                        MAX(D.PO_DETAIL_RETIAL_PRICE) COST_PRICE
                   FROM LZ_MANIFEST_DET D, ITEMS_MT I
                  WHERE D.LAPTOP_ITEM_CODE = I.ITEM_CODE
                  GROUP BY D.LZ_MANIFEST_ID, I.ITEM_ID) QRY_PRICE
          WHERE BCD.ITEM_ID = I.ITEM_ID
            AND BCD.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID
            AND BCD.ITEM_ID = QRY_PRICE.ITEM_ID
            AND BCD.LZ_MANIFEST_ID = QRY_PRICE.LZ_MANIFEST_ID
            AND S.ITEM_ID(+) = BCD.ITEM_ID
            AND S.LZ_MANIFEST_ID(+) = BCD.LZ_MANIFEST_ID
            AND S.DEFAULT_COND(+) = BCD.CONDITION_ID");

            return array("status" => true, "data" => $detail_query->result_array());
        } else {
            $res = $this->db->query("select mb.*
            from lz_merchant_barcode_dt dm, lz_merchant_barcode_mt mb
           WHERE dm.barcode_no = '$barcode'
             and mb.pos_status = 1
             and dm.mt_id = mb.mt_id
             and mb.LZ_POS_MT_ID is null
            ");
            if ($res->num_rows() > 0) {
                $data = $this->db->query(" SELECT null SEED_ID,
                               null LZ_MANIFEST_ID,
                                null PURCH_REF_NO,
                                null ITEM_MT_DESC,
                               null MANUFACTURER,
                                null MFG_PART_NO,
                               null UPC,
                               null ITEM_CONDITION,
                                1  QUANTITY,
                                null  COST_PRICE,
                                dm.barcode_no BARCODE_NO,
                                null LINE_TYPE,
                                null DISCOUNT_PER,
                                null DISCOUNT_AMOUNT,
                                null LZ_POS_DET_ID,
                                null  NET_PRICE,
                                0 ADVANCE_PAYMENT,
                                null REPAIRE_ID
                                from lz_merchant_barcode_mt mb , lz_merchant_barcode_dt dm where dm.barcode_no = '$barcode' and mb.mt_id = dm.mt_id and mb.POS_STATUS = 1")->result_array();
                return array("status" => true, "data" => $data);

            } else {
                return array("status" => false, "message" => "No Barcode Found");

            }
        }
        // }

    }

    public function Get_Scan_Barcode_Detail()
    {
        $scan_barcode = $this->input->post('scan_barcode');
        $scan_barcode = explode('-', $scan_barcode);
        $scan_barcode = $scan_barcode[0];
        $qr = "SELECT PR.*
        FROM Lz_Pos_Repair_Mt pr, lz_pos_det pp
       WHERE pr.lz_pos_repaire_id = '$scan_barcode'
         AND pp.repaire_id = pr.lz_pos_repaire_id AND pp.DELETED_STATUS != 1";
        $result = $this->db->query($qr);
        if ($result->num_rows() > 0) {
            return array("status" => false, "message" => "Inovice Is Already Created");

        } else {
            $qr = "SELECT ps.lz_pos_repaire_id lz_pos_repaire_id,
            ps.product_owner     PRODUCT_OWNER,
            ps.store_id          STORE_ID,
            ps.phone_no          PHONE_NO,
            ps.email             EMAIL,
            ps.city_id           CITY_ID,
            ps.state_id          STATE_ID
       from lz_pos_repair_mt ps WHERE ps.lz_pos_repaire_id = '$scan_barcode'";
            $result = $this->db->query($qr);
            if ($result->num_rows() > 0) {
                $qry = "SELECT
                dt.barcode_no BARCODE_NO,
                dt.cost COST_PRICE,
                ps.mpn MFG_PART_NO,
                nvl(i.item_desc,
                ps.brand || ' | ' || ps.mpn || ' | ' || dt.line_type) ITEM_MT_DESC,
                ps.repaire_status REPAIR_STATUS,
                1 QUANTITY,
                NULL DISCOUNT_PER,
                NULL DISCOUNT_AMOUNT,
                nvl(i.item_mt_upc, NULL) UPC,
        nvl(i.item_mt_manufacture,NULL) MANUFACTURER,
        nvl(i.item_condition,null) ITEM_CONDITION,
                dt.line_type LINE_TYPE,
                ps.lz_pos_repaire_id REPAIRE_ID,
                DECODE(dt.ADVANCE_PAYMENT, 0, 0, dt.ADVANCE_PAYMENT) ADVANCE_PAYMENT,
                DECODE(dt.cost, 0, 0, dt.cost) NET_PRICE
                from lz_pos_repair_mt ps, lz_pos_repair_det dt , items_mt i , lz_barcode_mt b
                WHERE ps.lz_pos_repaire_id = '$scan_barcode'
                AND ps.DELETED_STATUS != 1
                and dt.deleted_status != 1
                and ps.lz_pos_repaire_id = dt.lz_pos_repair_mt_id
                and dt.barcode_no = to_char(b.barcode_no(+))
                and b.item_id = i.item_id(+)";
                //         $qry = "SELECT ps.lz_pos_repaire_id BARCODE_NO,
                //         ps.expt_repaire_cost COST_PRICE,
                //         ps.mpn               MFG_PART_NO,
                //         ps.repaire_des       ITEM_MT_DESC,
                //         ps.repaire_status     REPAIR_STATUS,
                //         1 QUANTITY,
                //         NULL DISCOUNT_PER,
                //         NULL DISCOUNT_AMOUNT,
                //         NULL UPC,
                //         NULL MANUFACTURER,
                //         NULL ITEM_CONDITION ,
                //         'SR' LINE_TYPE,
                //         ps.lz_pos_repaire_id  REPAIRE_ID,
                //         DECODE(ps.ADVANCE_PAYMENT, 0, 0, ps.ADVANCE_PAYMENT) ADVANCE_PAYMENT,
                //         DECODE(ps.expt_repaire_cost, 0, 0, ps.expt_repaire_cost) NET_PRICE
                //    from lz_pos_repair_mt ps WHERE ps.lz_pos_repaire_id = '$scan_barcode' AND ps.DELETED_STATUS !=1";
                $res = $this->db->query($qry);
                if ($res->num_rows() > 0) {
                    $data = $res->result_array();
                    if ($data[0]["REPAIR_STATUS"] == 0) {
                        return array("status" => false, "message" => "Repaire is Panding");
                    } else if ($data[0]["REPAIR_STATUS"] == 1) {
                        return array("status" => false, "message" => "Repaire is Waiting For Parts");
                    } else {
                        return array("status" => true, 'buyer_data' => $result->result_array(), 'datatable' => $data);
                    }
                } else {
                    return array("status" => false, "message" => "No Barcode Found");
                }
            } else {
                return array("status" => false, "message" => "No Barcode Found");
            }

            // return array("status" => true,)
        }

    }
    public function Save_Invoice_Pos()
    {
        $craig_post = $this->input->post('ad_id');
        $doc_no = $this->input->post('doc_no');
        $portal_id = $this->input->post('market_place_id');
        if (!empty($portal_id)) {
            $portal_id = $portal_id['value'];
        }
        // $doc_no = docNo();

        // $doc_date = $this->input->post('doc_date');
        date_default_timezone_set("America/Chicago");
        $doc_date = date("Y-m-d H:i:s"); //change date format from 07-Dec-2016 to 12/07/2016
        // $date= date_format($date,"m/d/Y");
        $doc_date = "TO_DATE('" . $doc_date . "', 'YYYY-MM-DD HH24:MI:SS')";
        $phone_id = $this->input->post('phone_no');
        $phone_id = trim(str_replace("_", '', $phone_id));
        $buyer_email = $this->input->post('buyer_email');
        $buyer_email = trim(str_replace("  ", ' ', $buyer_email));
        $buyer_name = $this->input->post('buyer_name');
        $buyer_name = trim(str_replace("  ", ' ', $buyer_name));
        $buyer_address = $this->input->post('buyer_address');
        $buyer_address = trim(str_replace("  ", ' ', $buyer_address));
        $buyer_citys = $this->input->post('buyer_city');
        $buyer_city = $buyer_citys['value'];
        $buyer_states = $this->input->post('buyer_state');
        $buyer_state = $buyer_states['value'];
        $buyer_zip = $this->input->post('buyer_zip');
        $buyer_zip = trim(str_replace("  ", ' ', $buyer_zip));
        $store_id = $this->input->post("store_id");
        $store_id = $store_id['value'];
        $coma = ',';
        //----End Buyer Record-------
        //---- Payment Block ----
        $pay_mode = "";
        $pay_mode1 = $this->input->post('pay_mode');
        if ($pay_mode1 == "true") {
            $pay_mode = "C";
        }
        if ($pay_mode1 == "false") {
            $pay_mode = "R";
            // var_dump($pay_mode);exit();
        }

        $pay_mode = trim(str_replace("  ", ' ', $pay_mode));
        $tax_exempt = $this->input->post('exempt');
        $card_number = $this->input->post('card_number');
        $dis_percent = "";
        $disc_amount = $this->input->post('disc_total_amount');
        $net_amount = $this->input->post('net_amount');
        $td_amount = $this->input->post('tender_amount');
        $refund = $this->input->post('tender_refund');
        $login_id = $this->input->post('user_id');
        $sales_tax = $this->input->post('sale_tax');
        $card_date = $this->input->post("card_date");
        $card_last_4 = $this->input->post("card_last_4");
        // var_dump($card_date);
        // var_dump($card_last_4);
        // $sales_tax = 0;
        $tx_exmp = 0;
        if ($tax_exempt == 'true') {
            $tx_exmp = 1;
            $sales_tax = 0;
        } elseif ($tax_exempt == 'false') {
            $tx_exmp = 0;
            $sales_tax = $sales_tax;
        }
        // var_dump($tax_exempt);
        // var_dump($sales_tax);
        // exit;
        //---- End Payment block ----
        $qry_data = $this->db->query("SELECT get_single_primary_key('LZ_POS_MT', 'LZ_POS_MT_ID') LZ_POS_MT_ID
        FROM DUAL");

        $rs = $qry_data->result_array();
        $lz_pos_mt_id = $rs[0]['LZ_POS_MT_ID'];

        $qry_data = $this->db->query("SELECT get_single_primary_key('LJ_POS_RECEIPT_MT', 'RECEIPT_ID') RECEIPT_ID
        FROM DUAL");

        $rs = $qry_data->result_array();
        $receipt_id = $rs[0]['RECEIPT_ID'];

        if ($craig_post == null) {
            $craig_post = 1;
        }
        $qry = "SELECT LZ_CRAIG_POST_ID FROM LZ_CRAIG_POST WHERE LZ_CRAIG_POST_ID = '$craig_post'";
        $result = $this->db->query($qry);
        if ($result->num_rows() > 0) {
            $qr = "INSERT INTO LZ_POS_MT (LZ_POS_MT_ID,LZ_CRAIG_POST_ID,DOC_NO,DOC_DATE,BUYER_PHONE_ID,BUYER_EMAIL,BUYER_ADDRESS,BUYER_CITY_ID,BUYER_STATE_ID,BUYER_ZIP,PAY_MODE,DISC_PERC,DISC_AMOUNT,TENDER_AMOUNT,ENTERED_BY,ENTERED_DATE_TIME,CREDIT_CARD,TAX_EXEMPT,STAX_PERC,BUYER_NAME, STORE_ID, CARD_NUMBER, CARD_DATE, PORTAL_ID) VALUES($lz_pos_mt_id , '$craig_post' , '$doc_no' , $doc_date , '$phone_id' , '$buyer_email' , '$buyer_address' , '$buyer_city' , '$buyer_state' , '$buyer_zip' , '$pay_mode' , '$dis_percent' , '$disc_amount' , '$td_amount' , '$login_id' , $doc_date , '$card_number' , '$tx_exmp' , '$sales_tax','$buyer_name','$store_id', '$card_last_4', TO_DATE('$card_date', 'MM/YYYY'), '$portal_id')";
            $qry = $this->db->query($qr);
            $qrys = "INSERT INTO LJ_POS_RECEIPT_MT (RECEIPT_ID, POS_MT_ID, RECEIPT_NO, RECEIPT_DATE, RECEIPT_BY, AMOUNT_PAID, PAYMENT_TYPE, INSTRUMENT_NO) VALUES ('$receipt_id','$lz_pos_mt_id', '$doc_no', sysdate, '$login_id', '$td_amount', '$pay_mode', '$card_number')";
            $qry = $this->db->query($qrys);
            if ($qry === true) {
                $data = $this->input->post('data');
                foreach ($data as $tableData) {
                    $bar_code = $tableData['BARCODE_NO'];
                    // var_dump($tableData);exit;
                    $qty = $tableData['QUANTITY'];
                    $price = $tableData['COST_PRICE'];
                    $disc_perc = $tableData['DISCOUNT_PER'];
                    $dis_amount = $tableData['DISCOUNT_AMOUNT'];
                    $dis_desc = $tableData['ITEM_MT_DESC'];
                    $line_type = $tableData['LINE_TYPE'];
                    $repaire_id = $tableData['REPAIRE_ID'];

                    $qry2 = $this->db->query("SELECT get_single_primary_key('LZ_POS_DET','LZ_POS_DET_ID') LZ_POS_DET_ID FROM DUAL");

                    $rss = $qry2->result_array();
                    $lz_pos_det_id = $rss[0]['LZ_POS_DET_ID'];
                    if ($repaire_id == null) {
                        $merchant = $this->db->query("SELECT m.merchant_id
                         from lz_merchant_barcode_dt d, lz_merchant_barcode_mt m
                         WHERE m.mt_id = d.mt_id
                         AND d.barcode_no = '$bar_code'")->result_array();
                        if (count($merchant) > 0) {
                            $merch_id = $merchant[0]['MERCHANT_ID'];
                        } else {
                            $merch_id = 1;
                        }

                        $qryDt = $this->db->query("INSERT INTO LZ_POS_DET (LZ_POS_DET_ID,LZ_POS_MT_ID,BARCODE_ID,QTY,PRICE,SALES_TAX_PERC,DISC_PERC,DISC_AMT,ITEM_DESC,LINE_TYPE, REPAIRE_ID, MERCHANT_ID) VALUES($lz_pos_det_id , '$lz_pos_mt_id' , '$bar_code' , '$qty' , '$price' , '$sales_tax' , '$disc_perc' , '$dis_amount' , '$dis_desc' , '$line_type', null, '$merch_id')");
                    } else {
                        $bar_code = $tableData['BARCODE_NO'];
                        $bar_code = explode('-', $bar_code);
                        $bar_code = $bar_code[0];
                        //     $merchant = $this->db->query("SELECT m.merchant_id
                        //     from lz_merchant_barcode_dt d, lz_merchant_barcode_mt m
                        //    WHERE m.mt_id = d.mt_id
                        //    AND d.barcode_no = '$bar_code'")->result_array();
                        //     $merch_id = $merchant['MERCHANT_ID'];
                        // $merch_id = 2;
                        $qryDt = $this->db->query("INSERT INTO LZ_POS_DET (LZ_POS_DET_ID,LZ_POS_MT_ID,BARCODE_ID,QTY,PRICE,SALES_TAX_PERC,DISC_PERC,DISC_AMT,ITEM_DESC,LINE_TYPE, REPAIRE_ID, MERCHANT_ID) VALUES($lz_pos_det_id , '$lz_pos_mt_id' , '$bar_code' , '$qty' , '$price' , '$sales_tax' , '$disc_perc' , '$dis_amount' , '$dis_desc' , '$line_type', '$repaire_id', null)");
                    }

                }
                foreach ($data as $barcode) {
                    $bar_code = $barcode['BARCODE_NO'];
                    $bar_code = explode('-', $bar_code);
                    $bar_code = $bar_code[0];
                    if ($bar_code != '') {
                        $checkQry = $this->db->query("SELECT LZ_POS_MT_ID FROM LZ_BARCODE_MT WHERE BARCODE_NO='$bar_code'");
                        // var_dump($checkQry);exit;
                        if ($checkQry->num_rows == 0) {
                            $res = $this->db->query("select mb.MT_ID
                            from lz_merchant_barcode_dt dm, lz_merchant_barcode_mt mb
                           WHERE dm.barcode_no = '$bar_code'
                             and mb.pos_status = 1
                             and dm.mt_id = mb.mt_id
                             and mb.LZ_POS_MT_ID is null");
                            if ($res->num_rows() > 0) {
                                $res = $res->result_array();
                                $mt_id = $res[0]['MT_ID'];
                                $this->db->query("UPDATE lz_merchant_barcode_mt SET LZ_POS_MT_ID=$lz_pos_mt_id where MT_ID='$mt_id'");
                            } else {
                                $this->db->query("UPDATE LZ_BARCODE_MT SET LZ_POS_MT_ID=$lz_pos_mt_id where BARCODE_NO='$bar_code'");
                            }
                        }
                    }

                }
                if ($pay_mode1 == "true") {
                    $this->db->query("UPDATE  LZ_POS_MT P SET P.POST_YN = 1 WHERE P.LZ_POS_MT_ID = $lz_pos_mt_id");
                }
                if ($pay_mode1 == "true") {
                    $print = true;
                } else {
                    $print = false;
                }

                return array("status" => true, 'message' => "Record Updated Successfully", "lz_pos_mt_id" => $lz_pos_mt_id, 'print' => $print);

            } else {
                return array("status" => false, "message" => "Record Not Updated Successfully");
            }
        } else {
            return array("status" => false, "message" => "Ad Id is not exist");
        }

    }

    public function Print_Invoice($lz_pos_mt_id)
    {

//         $print_qry = $this->db->query("SELECT DT.LZ_POS_MT_ID,
        //         DT.ITEM_DESC,
        //         MT.DOC_NO,
        //         MT.PAY_MODE,
        //         MT.STAX_PERC DET_SALES_TAX,
        //         PS.ADVANCE_PAYMENT,
        //         NVL(SUM(DT.QTY), 0) QTY,
        //         NVL(SUM(DT.PRICE), 0) DET_PRICE,
        //         NVL(SUM(DT.DISC_AMT), 0) DISC_AMT
        //    FROM LZ_POS_DET DT, LZ_POS_MT MT, LZ_POS_REPAIR_DET PS
        //   WHERE DT.LZ_POS_MT_ID = $lz_pos_mt_id
        //     AND DT.LZ_POS_MT_ID = MT.LZ_POS_MT_ID
        //     AND PS.LZ_POS_REPAIR_MT_ID(+) = DT.repaire_id
        //   GROUP BY DT.ITEM_DESC,
        //            DT.LZ_POS_MT_ID,
        //            MT.DOC_NO,
        //            MT.PAY_MODE,
        //            MT.STAX_PERC,
        //            PS.ADVANCE_PAYMENT");
        $print_qry = $this->db->query("SELECT DT.LZ_POS_MT_ID,
DT.ITEM_DESC,
MT.DOC_NO,
MT.PAY_MODE,
MT.STAX_PERC DET_SALES_TAX,
(SELECT sum(rt.advance_payment)
   from lz_pos_repair_det rt
  where rt.lz_pos_repair_mt_id = DT.REPAIRE_ID
    AND rt.deleted_status != 1) ADVANCE_PAYMENT,
NVL(SUM(DT.QTY), 0) QTY,
NVL(SUM(DT.PRICE), 0) DET_PRICE,
NVL(SUM(DT.DISC_AMT), 0) DISC_AMT
FROM LZ_POS_DET DT, LZ_POS_MT MT --LZ_POS_REPAIR_DET PS
WHERE DT.LZ_POS_MT_ID = $lz_pos_mt_id

AND DT.LZ_POS_MT_ID = MT.LZ_POS_MT_ID
--AND PS.LZ_POS_REPAIR_MT_ID = DT.repaire_id
AND DT.DELETED_STATUS != 1
GROUP BY DT.ITEM_DESC,
   DT.LZ_POS_MT_ID,
   MT.DOC_NO,
   MT.PAY_MODE,
   MT.STAX_PERC,
   DT.REPAIRE_ID");
        $store_name = $this->db->query("select pst.store_name,
        pst.address,
        pst.phone_no,
        ps.buyer_name,
        cm.city_desc,
        sm.state_desc
   from lj_pos_store_mt pst, lz_pos_mt ps, WIZ_CITY_MT cm, WIZ_STATE_MT sm
  WHERE ps.store_id = pst.lj_pos_store_id
    AND ps.lz_pos_mt_id = $lz_pos_mt_id
    AND cm.city_id = ps.buyer_city_id
    AND sm.state_id = ps.buyer_state_id");

        return array('data' => $print_qry->result_array(), 'store_name' => $store_name->result_array());
    }

    public function Search_Repair_Form()
    {
        $variable = $this->input->post("search_barcode");
        $phone_no = $this->input->post("phoneNumber");
        $phone_no = trim(str_replace("_", ' ', $phone_no));
        $phone_no = trim(str_replace("-", '', $phone_no));
        if (!$variable) {
            return array('status' => false, 'message' => "Search is empty!");
        }
        $scan_barcode = explode('-', $variable);
        $scan_barcode = $scan_barcode[0];
        $data = trim($variable);
        $str = explode(' ', $data);
        $description = "";
        $name = "";
        $i = 1;
        foreach ($str as $key) {
            if ($i === 1) {
                $description .= "  UPPER(ps.EMAIL) LIKE UPPER('%$key%')";
                $name .= "  UPPER(ps.PRODUCT_OWNER) LIKE UPPER('%$key%')";
            } else {
                $description .= " AND  UPPER(ps.EMAIL) LIKE UPPER('%$key%') ";
                $name .= " AND  UPPER(ps.PRODUCT_OWNER) LIKE UPPER('%$key%')";
            }
            $i++;
        }

        // $qr = "SELECT
        // dt.barcode_no BARCODE_NO,
        // dt.cost COST_PRICE,
        // ps.mpn MFG_PART_NO,
        // ps.EMAIL,
        // ps.PRODUCT_OWNER,
        // ps.phone_no,
        // nvl(i.item_desc,
        // ps.brand || ' | ' || ps.mpn) ITEM_MT_DESC,
        // ps.repaire_status REPAIR_STATUS,
        // 1 QUANTITY,
        // NULL DISCOUNT_PER,
        // NULL DISCOUNT_AMOUNT,
        // nvl(i.item_mt_upc, NULL) UPC,
        // nvl(i.item_mt_manufacture,NULL) MANUFACTURER,
        // nvl(i.item_condition,null) ITEM_CONDITION,
        // dt.line_type LINE_TYPE,
        // ps.lz_pos_repaire_id REPAIRE_ID,
        // DECODE(dt.ADVANCE_PAYMENT, 0, 0, dt.ADVANCE_PAYMENT) ADVANCE_PAYMENT,
        // DECODE(dt.cost, 0, 0, dt.cost - dt.ADVANCE_PAYMENT) NET_PRICE
        // from lz_pos_repair_mt ps, lz_pos_repair_det dt , items_mt i , lz_barcode_mt b
        // WHERE ps.DELETED_STATUS != 1
        // and dt.deleted_status != 1
        // and ps.lz_pos_repaire_id = dt.lz_pos_repair_mt_id
        // and dt.barcode_no = to_char(b.barcode_no(+))
        // and b.item_id = i.item_id(+)
        // and (ps.lz_pos_repaire_id LIKE '%$scan_barcode%' OR  replace('ps.phone_no','-','') like '%$phone_no%' OR  ($description) OR ($name))";
        $qr = "SELECT
        ps.receipt_barcode_no BARCODE_NO,
        (select sum(dt.cost) from lz_pos_repair_det dt where dt.lz_pos_repair_mt_id = ps.lz_pos_repaire_id and dt.deleted_status != 1) COST_PRICE,
        (select sum(DECODE(dt.ADVANCE_PAYMENT, 0, 0, dt.ADVANCE_PAYMENT)) from lz_pos_repair_det dt where dt.lz_pos_repair_mt_id = ps.lz_pos_repaire_id  and dt.deleted_status != 1) ADVANCE_PAYMENT,
        (select sum(DECODE(dt.cost, 0, 0, dt.cost - dt.ADVANCE_PAYMENT)) from lz_pos_repair_det dt where dt.lz_pos_repair_mt_id = ps.lz_pos_repaire_id  and dt.deleted_status != 1) NET_PRICE,
        ps.mpn MFG_PART_NO,
        ps.EMAIL,
        ps.phone_no,
        ps.PRODUCT_OWNER,
        b.lz_pos_mt_id,
        ps.repaire_status REPAIR_STATUS,
        (SELECT COUNT(1) from lz_pos_repair_det dt where dt.lz_pos_repair_mt_id = ps.lz_pos_repaire_id and ps.deleted_status !=1 ) TOTAL_BARCODE,
        NULL DISCOUNT_PER,
        NULL DISCOUNT_AMOUNT,
        ps.lz_pos_repaire_id REPAIRE_ID
        from lz_pos_repair_mt ps,lz_barcode_mt b
        WHERE ps.DELETED_STATUS != 1
        AND ps.lz_pos_repaire_id = b.lz_pos_mt_id(+)
        and (ps.lz_pos_repaire_id LIKE '%$scan_barcode%' OR  replace('ps.phone_no','-','') like '%$phone_no%' OR  ($description) OR ($name) )";
        $result = $this->db->query($qr);
        if ($result->num_rows() > 0) {
            return array("status" => true, "data" => $result->result_array());
        } else {
            return array("status" => false, "data" => array(), "message" => "No Reacod Found");
        }
    }

    public function Get_Barcodes_Aganist_Barcode_Repair_Search()
    {
        $variable = $this->input->post("search_barcode");
        $scan_barcode = explode('-', $variable);
        $repair_id = $scan_barcode[0];
        $qr = "SELECT dt.BARCODE_NO
        from lz_pos_repair_det dt, lz_pos_repair_mt ps
       where ps.lz_pos_repaire_id = '$repair_id'
         and ps.lz_pos_repaire_id = dt.lz_pos_repair_mt_id
         and dt.deleted_status != 1";
        $data = $this->db->query($qr);
        return $data->result_array();
    }

    public function Get_Item_Qty_Aganist_Ebay_Id()
    {

        $ebay_id = trim($this->input->post('ebay_id'));
        // $remarks = trim($this->input->post('remarks'));
        // $adj_barcode = trim($this->input->post('adj_barcode'));
        // $adj_qty = trim($this->input->post('adj_qty'));
        // $user_id = $this->session->userdata('user_id');

        $get_seller_acct = $this->db->query("SELECT * FROM (SELECT E.LZ_SELLER_ACCT_ID,S.EBAY_LOCAL FROM EBAY_LIST_MT E, LZ_ITEM_SEED S WHERE E.EBAY_ITEM_ID = '$ebay_id'AND S.SEED_ID = E.SEED_ID AND UPPER(E.STATUS) = 'ADD' ORDER BY E.LIST_ID DESC) WHERE  ROWNUM = 1")->result_array();
        if (count($get_seller_acct) > 0) {
            $account_id = @$get_seller_acct[0]['LZ_SELLER_ACCT_ID'];
            $site_id = @$get_seller_acct[0]['EBAY_LOCAL'];
        } else {
            $get_seller = $this->db->query("SELECT * FROM (SELECT E.LZ_SELLER_ACCT_ID,S.EBAY_LOCAL FROM EBAY_LIST_MT E, LZ_ITEM_SEED S WHERE E.EBAY_ITEM_ID = '$ebay_id' AND S.SEED_ID = E.SEED_ID ORDER BY E.LIST_ID DESC) WHERE  ROWNUM = 1")->result_array();
            $account_id = @$get_seller[0]['LZ_SELLER_ACCT_ID'];
            $site_id = @$get_seller[0]['EBAY_LOCAL'];
        }

        if (empty($account_id)) {
            $get_seller = $this->db->query("SELECT E.LZ_SELLER_ACCT_ID FROM EBAY_LIST_MT E WHERE E.EBAY_ITEM_ID = '$ebay_id' AND ROWNUM=1")->result_array();
            $account_id = @$get_seller[0]['LZ_SELLER_ACCT_ID'];
            $site_id = 0;
        }
        if (empty($account_id)) {
            $data = array('status' => false, "message" => "Account id against this ebay Id:" . $ebay_id . " is Not Found in system.");
            //$data = 1;
            return $data;
            exit;
        }
        $data['ebay_id'] = $ebay_id;
        $data['site_id'] = $site_id;
        $data['account_name'] = $account_id; // used in configuration.php
        //$data['forceRevise'] = $forceRevise;
        // $this->session->unset_userdata('active_listing');s
        $this->load->view('ebay/trading/getItemQty', $data);
        $current_qty_adj = $this->session->userdata('current_qty_adj');
        return array("status" => true, "data" => $current_qty_adj);
        // $this->session->unset_userdata('current_qty_adj');
        // if(is_numeric($current_qty_adj)){
        //   $this->db->query("call pro_adjEbayQty($ebay_id, $adj_barcode, $adj_qty, $user_id, $remarks)");
        // }
        // echo json_encode($current_qty_adj);
        // return json_encode($current_qty_adj);
    }

    public function Single_Item_End()
    {
        $ebay_id = $this->input->post('ebay_id');
        // check if item sold or not
        $check_sold = $this->db->query("SELECT * FROM LZ_SALESLOAD_DET D WHERE D.ITEM_ID = '$ebay_id'");
        if ($check_sold->num_rows() > 0) {
            $barcode_qry = $this->db->query("UPDATE LZ_BARCODE_MT B SET B.LIST_ID = '',B.EBAY_ITEM_ID='' WHERE B.EBAY_ITEM_ID = '$ebay_id'AND B.SALE_RECORD_NO IS NULL AND B.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND B.LZ_PART_ISSUE_MT_ID IS NULL AND B.LZ_POS_MT_ID IS NULL AND B.PULLING_ID IS NULL");
        } else {
            $barcode_qry = $this->db->query("UPDATE LZ_BARCODE_MT B SET B.LIST_ID = '',B.EBAY_ITEM_ID='' WHERE B.EBAY_ITEM_ID = '$ebay_id'AND B.SALE_RECORD_NO IS NULL AND B.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND B.LZ_PART_ISSUE_MT_ID IS NULL AND B.LZ_POS_MT_ID IS NULL AND B.PULLING_ID IS NULL");

            $delete_qry = $this->db->query("DELETE FROM LZ_LISTING_ALLOC WHERE LIST_ID IN (SELECT LIST_ID FROM EBAY_LIST_MT E WHERE E.EBAY_ITEM_ID = '$ebay_id')");

            $delete_qry = $this->db->query("DELETE FROM EBAY_LIST_MT E WHERE E.EBAY_ITEM_ID = '$ebay_id'");

            $delete_url = $this->db->query("DELETE FROM LZ_LISTED_ITEM_URL U WHERE U.EBAY_ID =  '$ebay_id'");

        }

        return array("status" => true, 'message' => 'Barcode End Successfuly');
    }

// ****************************************************************//
    //          Start POS STORE REGISTOR
    // ****************************************************************//
    public function Pos_Store_Exist($store_name, $city_id, $state_id)
    {
        $qry = "SELECT LJ_POS_STORE_ID FROM LJ_POS_STORE_MT WHERE STORE_NAME = '$store_name' AND CITY_ID = '$city_id' AND STATE_ID = '$state_id'";
        $result = $this->db->query($qry);
        if ($result->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }
    public function Save_Pos_Store()
    {

        $owner_name = $this->input->post('owner_name');
        $store_name = $this->input->post("store_name");
        $phone_no = $this->input->post("phoneNumber");
        $phone_no = trim(str_replace("_", ' ', $phone_no));
        $email = $this->input->post('email');
        $email = trim(str_replace("  ", ' ', $email));
        $name = $this->input->post('name');
        $name = trim(str_replace("  ", ' ', $name));
        $address = $this->input->post('address');
        $address = trim(str_replace("  ", ' ', $address));
        $city_ids = $this->input->post('city_id');
        $city_id = $city_ids['value'];
        $state_ids = $this->input->post('state_id');
        $state_id = $state_ids['value'];
        $zip = $this->input->post('zip');
        $zip = trim(str_replace("  ", ' ', $zip));
        $sale_tax = $this->input->post('sale_tax');
        $sale_tax = trim(str_replace("$ ", ' ', $sale_tax));
        $created_by = $this->input->post('user_id');
        $res = $this->Pos_Store_Exist($store_name, $city_id, $state_id);
        if ($res === true) {
            $qry2 = $this->db->query("SELECT get_single_primary_key('LJ_POS_STORE_MT','LJ_POS_STORE_ID') LJ_POS_STORE_ID FROM DUAL");

            $rss = $qry2->result_array();
            $lz_pos_store_id = $rss[0]['LJ_POS_STORE_ID'];

            $qry = "INSERT INTO LJ_POS_STORE_MT (LJ_POS_STORE_ID, OWNER_NAME, STORE_NAME, PHONE_NO, EMAIL, ADDRESS, STATE_ID, CITY_ID, ZIP, CREATED_BY, INSERTED_AT, SALE_TAX) VALUES ( $lz_pos_store_id, '$owner_name', '$store_name', '$phone_no', '$email', '$address', '$state_id', '$city_id', '$zip', '$created_by', sysdate, '$sale_tax' )";
            $result = $this->db->query($qry);
            $qr = "SELECT PS.*, EM.USER_NAME, CM.CITY_DESC, SM.STATE_DESC
            FROM LJ_POS_STORE_MT PS, EMPLOYEE_MT EM, WIZ_CITY_MT CM, WIZ_STATE_MT SM
           WHERE EM.EMPLOYEE_ID = PS.CREATED_BY
             AND PS.LJ_POS_STORE_ID =  $lz_pos_store_id
             AND PS.CITY_ID = CM.CITY_ID
             AND PS.STATE_ID = SM.STATE_ID";
            $result = $this->db->query($qr);
            if ($result->num_rows() > 0) {
                return array("status" => true, "message" => 'Store is Registered', 'data' => $result->result_array());
            } else {
                return array("status" => false, "message" => 'Store is not Registered');
            }
        } else {
            $state = $state_ids['label'];
            $city = $city_ids['label'];
            return array("status" => false, "message" => "Store Already Registor By  $owner_name  At $address , $city, $state");
        }

    }

    public function Get_Pos_Store()
    {
        $qr = "SELECT PS.*, EM.USER_NAME, CM.CITY_DESC, SM.STATE_DESC
        FROM LJ_POS_STORE_MT PS, EMPLOYEE_MT EM, WIZ_CITY_MT CM, WIZ_STATE_MT SM
       WHERE EM.EMPLOYEE_ID = PS.CREATED_BY
         AND PS.CITY_ID = CM.CITY_ID
         AND PS.STATE_ID = SM.STATE_ID";
        $result = $this->db->query($qr);
        if ($result->num_rows() > 0) {
            return array("status" => true, "data" => $result->result_array());
        } else {
            return array("status" => false, "data" => array(), "message" => "No Store");
        }
    }

    public function Delete_Store()
    {
        $lz_pos_store_id = $this->input->post("lz_pos_store_id");
        $qr = " SELECT * FROM (SELECT count(1) TOTAL
        FROM LJ_POS_STORE_MT PS, LZ_POS_MT PM, LZ_POS_REPAIR_MT PRT
       WHERE  PS.LJ_POS_STORE_ID = '$lz_pos_store_id' AND (PS.LJ_POS_STORE_ID = PM.STORE_ID or PRT.STORE_ID = PS.LJ_POS_STORE_ID))";
        $result = $this->db->query($qr)->result_array();
        if ($result[0]['TOTAL'] != 0) {
            return array("status" => false, "message" => "Store Not Delete Because Aready In Use");
        } else {
            $qr = "DELETE FROM LJ_POS_STORE_MT WHERE LJ_POS_STORE_ID = '$lz_pos_store_id' ";
            $this->db->query($qr);
            return array("status" => true, "message" => "Store Is Deleted Successfully");
        }
    }

    public function Pos_Store_Exist_Edit($store_name, $city_id, $state_id, $store_id)
    {
        $qry = "SELECT LJ_POS_STORE_ID FROM LJ_POS_STORE_MT WHERE STORE_NAME = '$store_name' AND CITY_ID = '$city_id' AND STATE_ID = '$state_id' AND LJ_POS_STORE_ID != '$store_id'";
        $result = $this->db->query($qry);
        if ($result->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function Update_Pos_Store()
    {
        $owner_name = $this->input->post('edit_owner_name');
        $store_name = $this->input->post("edit_store_name");
        $store_id = $this->input->post('store_id');
        $phone_no = $this->input->post("edit_phoneNumber");
        $phone_no = trim(str_replace("_", '', $phone_no));
        $email = $this->input->post('edit_email');
        $email = trim(str_replace("  ", ' ', $email));
        $address = $this->input->post('edit_address');
        $address = trim(str_replace("  ", ' ', $address));
        $city_ids = $this->input->post('edit_city_id');
        $city_id = $city_ids['value'];
        $state_ids = $this->input->post('edit_state_id');
        $state_id = $state_ids['value'];
        $zip = $this->input->post('edit_zip');
        $zip = trim(str_replace("  ", ' ', $zip));
        $sale_tax = $this->input->post('edit_sale_tax');
        $created_by = $this->input->post('user_id');
        $res = $this->Pos_Store_Exist_Edit($store_name, $city_id, $state_id, $store_id);
        if ($res === true) {
            $qry = "UPDATE LJ_POS_STORE_MT  SET OWNER_NAME = '$owner_name' , STORE_NAME = '$store_name', PHONE_NO = '$phone_no', EMAIL = '$email', ADDRESS = '$address', STATE_ID = '$state_id', CITY_ID = $city_id, ZIP = '$zip', CREATED_BY = '$created_by', INSERTED_AT = sysdate, SALE_TAX = '$sale_tax' WHERE LJ_POS_STORE_ID = '$store_id'";
            $result = $this->db->query($qry);
            $qr = "SELECT PS.*, EM.USER_NAME, CM.CITY_DESC, SM.STATE_DESC
                FROM LJ_POS_STORE_MT PS, EMPLOYEE_MT EM, WIZ_CITY_MT CM, WIZ_STATE_MT SM
               WHERE EM.EMPLOYEE_ID = PS.CREATED_BY
                 AND PS.LJ_POS_STORE_ID =  $store_id
                 AND PS.CITY_ID = CM.CITY_ID
                 AND PS.STATE_ID = SM.STATE_ID";
            $result = $this->db->query($qr);
            if ($result->num_rows() > 0) {
                return array("status" => true, "message" => 'Store is Updated', "data" => $result->result_array());
            } else {
                return array("status" => false, "message" => 'Store is not Updated');
            }
        } else {
            $state = $state_ids['label'];
            $city = $city_ids['label'];
            return array("status" => false, "message" => "Store Already Registor By  $owner_name  At $address , $city, $state");
        }
    }
// ****************************************************************//
    //          Start POS Receipt View
    // ****************************************************************//
    public function Pos_Receipt_View()
    {

        // $receipt_view = $this->db->query("SELECT M.LZ_POS_MT_ID,M.DOC_NO, TO_CHAR(M.DOC_DATE, 'DD/MM/YYYY HH24:MI:SS') as DOC_DATE, M.BUYER_PHONE_ID, M.BUYER_EMAIL, M.BUYER_ADDRESS, M.ENTERED_BY, G.PRICE ,G.SALES_TAX_PERC, G.DISC_PERC, G.DISC_AMT FROM LZ_POS_MT M, (SELECT LZ_POS_MT_ID,SUM(PRICE) PRICE, SUM(DISC_PERC) DISC_PERC, SUM(DISC_AMT) DISC_AMT, SUM(SALES_TAX_PERC) SALES_TAX_PERC FROM LZ_POS_DET GROUP BY LZ_POS_MT_ID)G WHERE M.LZ_POS_MT_ID = G.LZ_POS_MT_ID(+) ORDER BY M.DOC_NO DESC");
        $receipt_view = $this->db->query("SELECT M.LZ_POS_MT_ID,
        M.DOC_NO,
        TO_CHAR(M.DOC_DATE, 'MM/DD/YYYY HH24:MI:SS') as DOC_DATE,
        M.BUYER_NAME,
        M.BUYER_PHONE_ID,
        M.BUYER_EMAIL,
        M.BUYER_ADDRESS,
        M.ENTERED_BY,
        M.POST_YN,
        M.GNRTD_DC_ID,
        M.GNRTD_INV_ID,
        EM.USER_NAME,
        DECODE(M.TAX_EXEMPT, '1', '0.00', PST.SALE_TAX)SALES_TAX_PERC,
        G.PRICE,
        G.DISC_PERC,
        G.DISC_AMT,
        (SELECT SUM(AMOUNT_PAID) AMOUNT_PAID
           FROM lj_pos_receipt_mt RM
          where RM.POS_MT_ID = M.LZ_POS_MT_ID) AMOUNT_PAID,
        DECODE(G.DISC_AMT, null, G.PRICE, G.PRICE - G.DISC_AMT) NET_TOTAL
   FROM LZ_POS_MT M,
        (SELECT LZ_POS_MT_ID,
                SUM(PRICE) PRICE,
                SUM(DISC_PERC) DISC_PERC,
                SUM(DISC_AMT) DISC_AMT
           FROM LZ_POS_DET
          GROUP BY LZ_POS_MT_ID) G,

        EMPLOYEE_MT     EM,
        LJ_POS_STORE_MT PST
  WHERE M.LZ_POS_MT_ID = G.LZ_POS_MT_ID(+)
    AND M.ENTERED_BY = EM.EMPLOYEE_ID

    AND M.DELETED_STATUS != 1
    AND M.STORE_ID = PST.LJ_POS_STORE_ID
  ORDER BY M.DOC_NO DESC");

        return array("status" => true, "data" => $receipt_view->result_array());
    }

    public function Get_Receipt_By_Store()
    {
        $store_id = $this->input->post('store_id');
        $store_id = $store_id['value'];

        if ($store_id == 'all') {
            $receipt_view = $this->db->query("SELECT M.LZ_POS_MT_ID,
            M.DOC_NO,
            TO_CHAR(M.DOC_DATE, 'MM/DD/YYYY HH24:MI:SS') as DOC_DATE,
            M.BUYER_NAME,
            M.BUYER_PHONE_ID,
            M.BUYER_EMAIL,
            M.BUYER_ADDRESS,
            M.ENTERED_BY,
            M.POST_YN,
            M.GNRTD_DC_ID,
            M.GNRTD_INV_ID,
            EM.USER_NAME,
            PST.SALE_TAX SALES_TAX_PERC,
            G.PRICE,
            G.DISC_PERC,
            G.DISC_AMT,
            (SELECT SUM(AMOUNT_PAID) AMOUNT_PAID
               FROM lj_pos_receipt_mt RM
              where RM.POS_MT_ID = M.LZ_POS_MT_ID) AMOUNT_PAID,
            DECODE(G.DISC_AMT, null, G.PRICE, G.PRICE - G.DISC_AMT) NET_TOTAL
       FROM LZ_POS_MT M,
            (SELECT LZ_POS_MT_ID,
                    SUM(PRICE) PRICE,
                    SUM(DISC_PERC) DISC_PERC,
                    SUM(DISC_AMT) DISC_AMT
               FROM LZ_POS_DET
              GROUP BY LZ_POS_MT_ID) G,

            EMPLOYEE_MT     EM,
            LJ_POS_STORE_MT PST
      WHERE M.LZ_POS_MT_ID = G.LZ_POS_MT_ID(+)
        AND M.ENTERED_BY = EM.EMPLOYEE_ID

        AND M.DELETED_STATUS != 1
        AND M.STORE_ID = PST.LJ_POS_STORE_ID
      ORDER BY M.DOC_NO DESC");
        } else {
            $receipt_view = $this->db->query("SELECT M.LZ_POS_MT_ID,
            M.DOC_NO,
            TO_CHAR(M.DOC_DATE, 'MM/DD/YYYY HH24:MI:SS') as DOC_DATE,
            M.BUYER_NAME,
            M.BUYER_PHONE_ID,
            M.BUYER_EMAIL,
            M.BUYER_ADDRESS,
            M.ENTERED_BY,
            M.POST_YN,
            M.GNRTD_DC_ID,
            M.GNRTD_INV_ID,
            EM.USER_NAME,
            PST.SALE_TAX SALES_TAX_PERC,
            G.PRICE,
            G.DISC_PERC,
            G.DISC_AMT,
            (SELECT SUM(AMOUNT_PAID) AMOUNT_PAID
               FROM lj_pos_receipt_mt RM
              where RM.POS_MT_ID = M.LZ_POS_MT_ID) AMOUNT_PAID,
            DECODE(G.DISC_AMT, null, G.PRICE, G.PRICE - G.DISC_AMT) NET_TOTAL
       FROM LZ_POS_MT M,
            (SELECT LZ_POS_MT_ID,
                    SUM(PRICE) PRICE,
                    SUM(DISC_PERC) DISC_PERC,
                    SUM(DISC_AMT) DISC_AMT
               FROM LZ_POS_DET
              GROUP BY LZ_POS_MT_ID) G,

            EMPLOYEE_MT     EM,
            LJ_POS_STORE_MT PST
      WHERE M.LZ_POS_MT_ID = G.LZ_POS_MT_ID(+)
        AND M.ENTERED_BY = EM.EMPLOYEE_ID

        AND M.DELETED_STATUS != 1
        AND M.STORE_ID = PST.LJ_POS_STORE_ID
      AND M.STORE_ID = '$store_id'
      ORDER BY M.DOC_NO DESC");
        }
        return array("status" => true, "data" => $receipt_view->result_array(), "message" => "Record Updated");
    }
    public function toggle_post_unpost_invoice()
    {
        $lz_pos_mt_id = $this->input->post('lz_pos_mt_id');
        $GNRTD_DC_ID = $this->input->post('GNRTD_DC_ID');
        $GNRTD_INV_ID = $this->input->post('GNRTD_INV_ID');
        // var_dump(empty($GNRTD_DC_ID));
        // exit;
        if (empty($GNRTD_DC_ID) && empty($GNRTD_INV_ID)) {
            $result = $this->db->query("UPDATE  LZ_POS_MT P SET P.POST_YN = 1 WHERE P.LZ_POS_MT_ID = $lz_pos_mt_id");
        } else {
            $result = $this->db->query("UPDATE  LZ_POS_MT P SET P.POST_YN = -1 WHERE P.LZ_POS_MT_ID = $lz_pos_mt_id");
        }
        if ($result == true) {
            $res = $this->db->query("SELECT GNRTD_DC_ID, GNRTD_INV_ID FROM LZ_POS_MT WHERE LZ_POS_MT_ID = $lz_pos_mt_id");
            if (empty($GNRTD_DC_ID)) {
                return array("status" => true, "message" => 'POS is Posted', "data" => $res->result_array());
            } else {
                return array("status" => true, "message" => 'POS is UnPosted', "data" => $res->result_array());
            }
        } else {
            return array("status" => false, "message" => 'POS is not Posted');
        }
    }
    public function Delete_invoice()
    {
        $lz_pos_mt_id = $this->input->post('lz_pos_mt_id');
        $user_id = $this->input->post("user_id");
        $data = $this->db->query("DELETE FROM LJ_POS_RECEIPT_MT WHERE POS_MT_ID = '$lz_pos_mt_id'");
        $this->db->query("UPDATE LZ_POS_DET SET DELETED_DATE= sysdate, DELETED_STATUS = 1,  DELETED_BY = '$user_id' WHERE LZ_POS_MT_ID = $lz_pos_mt_id");
        $this->db->query("UPDATE LZ_BARCODE_MT SET LZ_POS_MT_ID= null  WHERE LZ_POS_MT_ID = '$lz_pos_mt_id'");
        $data = "SELECT LZ_POS_MT_ID FROM lz_MERCHANT_BARCODE_MT WHERE LZ_POS_MT_ID = '$lz_pos_mt_id'  ";
        $result = $this->db->query($data);
        if ($result->num_rows() > 0) {
            $this->db->query("UPDATE lZ_MERCHANT_BARCODE_MT SET LZ_POS_MT_ID = null WHERE LZ_POS_MT_ID = '$lz_pos_mt_id'");
            $this->db->query("UPDATE LZ_POS_MT SET  POST_YN = '0' ,  GNRTD_DC_ID = NULL , GNRTD_INV_ID = NULL WHERE LZ_POS_MT_ID = '$lz_pos_mt_id'");
        }
        $del_qry_mt = $this->db->query("UPDATE LZ_POS_MT SET DELETED_DATE = sysdate, DELETED_STATUS = 1,  DELETED_BY = '$user_id' WHERE POST_YN = '0' AND  GNRTD_DC_ID IS NULL AND GNRTD_INV_ID IS NULL AND LZ_POS_MT_ID = $lz_pos_mt_id ");

        // $del_qry_det = $this->db->query("DELETE FROM LZ_POS_DET D WHERE D.LZ_POS_MT_ID = $lz_pos_mt_id");

        // $del_qry_mt = $this->db->query("DELETE FROM LZ_POS_MT M WHERE M.LZ_POS_MT_ID = $lz_pos_mt_id");

        if ($del_qry_mt) {

            return array("status" => true, "data" => "Invoice Deleted Successfully", "message" => "Invoice Deleted Successfully");

        } else {
            return array("status" => false, "data" => "Invoice is Not Deleted", "message" => "Invoice is Not Deleted");
        }

    }

    public function Delete_All_Pos_Invoice()
    {
        $user_id = $this->input->post("user_id");
        $qry = "SELECT M.LZ_POS_MT_ID FROM LZ_POS_MT M WHERE M.POST_YN = 0 AND  GNRTD_DC_ID IS NULL AND GNRTD_INV_ID IS NULL ";
        $result = $this->db->query($qry);
        $result = $result->result_array();
        if (count($result) > 0) {
            foreach ($result as $data) {
                $lz_pos_mt_id = $data['LZ_POS_MT_ID'];
                $this->db->query("DELETE FROM LJ_POS_RECEIPT_MT WHERE POS_MT_ID = '$lz_pos_mt_id'");
                // $this->db->query("DELETE FROM LZ_POS_DET D WHERE D.LZ_POS_MT_ID = $lz_pos_mt_id");
                // $this->db->query("UPDATE LZ_BARCODE_MT SET LZ_POS_MT_ID=null where BARCODE_NO='$barcode'");
                $res = $this->db->query("SELECT BARCODE_ID, REPAIRE_ID FROM LZ_POS_DET WHERE LZ_POS_MT_ID = '$lz_pos_mt_id'")->result_array();
                foreach ($res as $resposne) {
                    $barcode = $resposne['BARCODE_ID'];
                    $repaire = $resposne['REPAIRE_ID'];
                    if (isset($barcode) && $barcode !== null) {
                        $this->db->query("UPDATE LZ_BARCODE_MT SET LZ_POS_MT_ID=null where BARCODE_NO='$barcode'");
                        $res = $this->db->query("select mb.MT_ID
                        from lz_merchant_barcode_dt dm, lz_merchant_barcode_mt mb
                       WHERE dm.barcode_no = '$barcode'
                         and mb.pos_status = 1
                         and dm.mt_id = mb.mt_id")->result_array();
                        $mt_id = $res[0]['MT_ID'];
                        if (!empty($mt_id)) {
                            $this->db->query("UPDATE lz_merchant_barcode_mt SET LZ_POS_MT_ID= null  where MT_ID='$mt_id'");
                        }
                    } else {
                        $this->db->query("UPDATE LZ_BARCODE_MT SET LZ_POS_MT_ID=null where BARCODE_NO='$repaire'");
                    }
                }

                $this->db->query("UPDATE LZ_POS_DET SET DELETED_DATE= sysdate, DELETED_STATUS = 1,  DELETED_BY = '$user_id' WHERE LZ_POS_MT_ID = $lz_pos_mt_id");
                $del_qry_mt = $this->db->query("UPDATE LZ_POS_MT SET DELETED_DATE = sysdate, DELETED_STATUS = 1,  DELETED_BY = '$user_id' WHERE POST_YN = '0' AND  GNRTD_DC_ID IS NULL AND GNRTD_INV_ID IS NULL AND LZ_POS_MT_ID = $lz_pos_mt_id");
            }

            // $del_qry_mt = $this->db->query("DELETE FROM LZ_POS_MT M WHERE M.POST_YN = '0' AND  GNRTD_DC_ID IS NULL AND GNRTD_INV_ID IS NULL ");

            if ($del_qry_mt) {
                $data = $this->Pos_Receipt_View();
                return array("status" => true, "data" => "All Unposted Invoice Deleted Successfully", "message" => "All Unposted Invoice Deleted Successfully", "data1" => $data['data']);

            } else {
                return array("status" => false, "data" => "Invoice is Not Deleted", "message" => "Invoice is Not Deleted");
            }
        } else {
            return array("status" => false, "data" => "All Invocie is UnPosted", "message" => "All Invocie is UnPosted");
        }
    }

    public function Post_All_Pos_Invoice()
    {
        $qry = "SELECT M.LZ_POS_MT_ID FROM LZ_POS_MT M WHERE M.POST_YN = 0 AND  GNRTD_DC_ID IS NULL AND GNRTD_INV_ID IS NULL";
        $result = $this->db->query($qry);
        $result = $result->result_array();
        foreach ($result as $data) {
            $lz_pos_mt_id = $data['LZ_POS_MT_ID'];
            $this->db->query("UPDATE  LZ_POS_MT P SET P.POST_YN = 1 WHERE P.LZ_POS_MT_ID = $lz_pos_mt_id");
        }
        $result = $this->Pos_Receipt_View();
        return array("status" => true, "message" => "All POS Invoice Is Un Posted", "data" => $result['data']);
    }

    public function UnPost_All_Pos_Invoice()
    {
        $qry = "  SELECT M.LZ_POS_MT_ID FROM LZ_POS_MT M WHERE M.POST_YN = 0 AND  GNRTD_DC_ID IS NOT NULL AND GNRTD_INV_ID IS NOT NULL";
        $result = $this->db->query($qry);
        $result = $result->result_array();
        foreach ($result as $data) {
            $lz_pos_mt_id = $data['LZ_POS_MT_ID'];
            $this->db->query("UPDATE  LZ_POS_MT P SET P.POST_YN = -1 WHERE P.LZ_POS_MT_ID = $lz_pos_mt_id");
        }
        $result = $this->Pos_Receipt_View();
        return array("status" => true, "message" => "All POS Invoice Is Posted", "data" => $result['data']);
    }

    /**
     *
     *
     * Edit Invoice Receipt
     *
     *  */

    public function Get_Buyer_Info()
    {
        $lz_pos_mt_id = $this->input->post('lz_pos_mt_id');
        $qry = "SELECT DOC_NO,
        DOC_DATE,
        BUYER_PHONE_ID,
        BUYER_EMAIL,
        BUYER_NAME,
        BUYER_ADDRESS,
        BUYER_CITY_ID,
        BUYER_STATE_ID,
        BUYER_ZIP,
        STORE_ID,
        Tender_Amount,
        CREDIT_CARD,
        TOTAL_COST,
        TOTAL_PAID,
        (TOTAL_COST - TOTAL_PAID) TOTAL_AMOUNT,
        TAX_EXEMPT,
        PORTAL_ID
   FROM (SELECT M.LZ_POS_MT_ID,
                M.DOC_NO,
                TO_CHAR(M.DOC_DATE, 'MM/DD/YYYY ') as DOC_DATE,
                M.BUYER_PHONE_ID,
                M.BUYER_EMAIL,
                M.BUYER_NAME,
                M.BUYER_ADDRESS,
                M.BUYER_CITY_ID,
                M.BUYER_STATE_ID,
                M.BUYER_ZIP,
                M.STORE_ID,
                M.Tender_Amount,
                M.CREDIT_CARD,
                M.PORTAL_ID,
                (SELECT (nvl(sum(PD.PRICE),0) - nvl(sum(PD.DISC_AMT),0)) TOTAL_COST from LZ_POS_DET PD
WHERE PD.LZ_POS_MT_ID =' $lz_pos_mt_id') TOTAL_COST,
                (SELECT (nvl(sum(RP.AMOUNT_PAID), 0)) TOTAL_PAID
                   FROM LJ_POS_RECEIPT_MT RP
                  WHERE RP.POS_MT_ID = ' $lz_pos_mt_id') TOTAL_PAID,

                DECODE(M.TAX_EXEMPT, '0', 'false', '1', 'true') TAX_EXEMPT
         -- M.STAX_PERC
           FROM LZ_POS_MT M
          WHERE M.LZ_POS_MT_ID = ' $lz_pos_mt_id')";
//         $qry = "SELECT M.LZ_POS_MT_ID,
        //                  M.DOC_NO,
        //                  TO_CHAR(M.DOC_DATE, 'MM/DD/YYYY ') as DOC_DATE,
        //                  M.BUYER_PHONE_ID,
        //                  M.BUYER_EMAIL,
        //                  M.BUYER_NAME,
        //                  M.BUYER_ADDRESS,
        //                  M.BUYER_CITY_ID,
        //                  M.BUYER_STATE_ID,
        //                  M.BUYER_ZIP,
        //                  M.STORE_ID,
        //                 M.Tender_Amount,
        //                 M.CREDIT_CARD,
        // DECODE(M.TAX_EXEMPT, '0', 'false', '1','true') TAX_EXEMPT
        //  -- M.STAX_PERC
        // FROM LZ_POS_MT M WHERE M.LZ_POS_MT_ID = '$lz_pos_mt_id'";

        $result = $this->db->query($qry);
        if ($result->num_rows() > 0) {
            return array("status" => true, "data" => $result->result_array());

        } else {
            return array("status" => false, "message" => "No Record Found", "data" => array());
        }

    }

    public function Get_Scan_Barcode_Detail_Edit()
    {
        $scan_barcode = $this->input->post('scan_barcode');
        $scan_barcode = explode('-', $scan_barcode);
        $scan_barcode = $scan_barcode[0];
        $qr = "SELECT PR.*
        FROM Lz_Pos_Repair_Mt pr, lz_pos_det pp
       WHERE pr.lz_pos_repaire_id = '$scan_barcode'
         AND pp.repaire_id = pr.lz_pos_repaire_id AND pp.DELETED_STATUS != 1";
        $result = $this->db->query($qr);
        if ($result->num_rows() > 0) {
            return array("status" => false, "message" => "Inovice Is Already Created");

        } else {
            $qr = "SELECT ps.lz_pos_repaire_id lz_pos_repaire_id,
            ps.product_owner     PRODUCT_OWNER,
            ps.store_id          STORE_ID,
            ps.phone_no          PHONE_NO,
            ps.email             EMAIL,
            ps.city_id           CITY_ID,
            ps.state_id          STATE_ID
       from lz_pos_repair_mt ps WHERE ps.lz_pos_repaire_id = '$scan_barcode'";
            $result = $this->db->query($qr);
            if ($result->num_rows() > 0) {

                $qry = "SELECT
                dt.barcode_no BARCODE_NO,
                dt.cost COST_PRICE,
                ps.mpn MFG_PART_NO,
                nvl(i.item_desc,
                ps.brand || ' | ' || ps.mpn || ' | ' || dt.line_type) ITEM_MT_DESC,
                ps.repaire_status REPAIR_STATUS,
                1 QUANTITY,
                NULL DISCOUNT_PER,
                NULL DISCOUNT_AMOUNT,
                nvl(i.item_mt_upc, NULL) UPC,
        nvl(i.item_mt_manufacture,NULL) MANUFACTURER,
        nvl(i.item_condition,null) ITEM_CONDITION,
                dt.line_type LINE_TYPE,
                ps.lz_pos_repaire_id REPAIRE_ID,
                DECODE(dt.ADVANCE_PAYMENT, 0, 0, dt.ADVANCE_PAYMENT) ADVANCE_PAYMENT,
                DECODE(dt.cost, 0, 0, dt.cost) NET_PRICE
                from lz_pos_repair_mt ps, lz_pos_repair_det dt , items_mt i , lz_barcode_mt b
                WHERE ps.lz_pos_repaire_id = '$scan_barcode'
                AND ps.DELETED_STATUS != 1
                and dt.deleted_status != 1
                and ps.lz_pos_repaire_id = dt.lz_pos_repair_mt_id
                and dt.barcode_no = to_char(b.barcode_no(+))
                and b.item_id = i.item_id(+)";
                //         $qry = "SELECT ps.lz_pos_repaire_id BARCODE_NO,
                //         ps.expt_repaire_cost COST_PRICE,
                //         ps.mpn               MFG_PART_NO,
                //         ps.repaire_des       ITEM_MT_DESC,
                //         ps.repaire_status     REPAIR_STATUS,
                //         1 QUANTITY,
                //         NULL DISCOUNT_PER,
                //         NULL DISCOUNT_AMOUNT,
                //         NULL UPC,
                //         NULL MANUFACTURER,
                //         NULL ITEM_CONDITION ,
                //         'SR' LINE_TYPE,
                //         ps.lz_pos_repaire_id  REPAIRE_ID,
                //         DECODE(ps.ADVANCE_PAYMENT, 0, 0, ps.ADVANCE_PAYMENT) ADVANCE_PAYMENT,
                //         DECODE(ps.expt_repaire_cost, 0, 0, ps.expt_repaire_cost) NET_PRICE
                //    from lz_pos_repair_mt ps WHERE ps.lz_pos_repaire_id = '$scan_barcode' AND ps.DELETED_STATUS !=1 ";
                $res = $this->db->query($qry);
                if ($res->num_rows() > 0) {
                    $data = $res->result_array();
                    if ($data[0]["REPAIR_STATUS"] == 0) {
                        return array("status" => false, "message" => "Repaire is Panding");
                    } else if ($data[0]["REPAIR_STATUS"] == 1) {
                        return array("status" => false, "message" => "Repaire is Waiting For Parts");
                    } else {
                        return array("status" => true, 'buyer_data' => $result->result_array(), 'datatable' => $data);
                    }
                } else {
                    return array("status" => false, "message" => "No Barcode Found");
                }
            } else {
                return array("status" => false, "message" => "No Barcode Found");
            }
        }
    }

    public function Get_Edit_TablePOS_Data()
    {
        $lz_pos_mt_id = $this->input->post('lz_pos_mt_id');

//         $qr = "SELECT D.LZ_POS_DET_ID,
        //         D.LZ_POS_MT_ID,
        //         D.BARCODE_ID BARCODE_NO,
        //         D.QTY QUANTITY,
        //         D.PRICE COST_PRICE,
        //         D.SALES_TAX_PERC,
        //         D.DISC_PERC DISCOUNT_PER,
        //         D.DISC_AMT DISCOUNT_AMOUNT,
        //         D.ITEM_DESC ITEM_MT_DESC,
        //         D.LINE_TYPE LINE_TYPE,
        //         D.REPAIRE_ID REPAIRE_ID,
        //         I.ITEM_MT_MANUFACTURE MANUFACTURER,
        //         I.ITEM_MT_MFG_PART_NO MFG_PART_NO,
        //         I.ITEM_MT_UPC UPC,
        //         dt.advance_payment ADVANCE_PAYMENT,
        //         DECODE(D.DISC_AMT, null, D.PRICE, D.PRICE - D.DISC_AMT) NET_PRICE
        //    FROM LZ_POS_MT         M,
        //         LZ_POS_DET        D,
        //         lz_barcode_mt     BC,
        //         ITEMS_MT          I,
        //         lz_pos_repair_mt  psr,
        //         lz_pos_repair_det dt
        //   WHERE M.LZ_POS_MT_ID = D.LZ_POS_MT_ID
        //     AND psr.lz_pos_repaire_id(+) = D.REPAIRE_ID
        //     AND M.LZ_POS_MT_ID = ' $lz_pos_mt_id'
        //     AND M.DELETED_STATUS != 1
        //     AND D.DELETED_STATUS != 1
        //     AND dt.lz_pos_repair_mt_id(+) = psr.lz_pos_repaire_id
        //     AND BC.BARCODE_NO(+) = D.BARCODE_ID
        //     AND BC.ITEM_ID = I.ITEM_ID(+)";
        $qr = "SELECT D.LZ_POS_DET_ID,
D.LZ_POS_MT_ID,
D.BARCODE_ID BARCODE_NO,
D.QTY QUANTITY,
D.PRICE COST_PRICE,
D.SALES_TAX_PERC,
D.DISC_PERC DISCOUNT_PER,
D.DISC_AMT DISCOUNT_AMOUNT,
D.ITEM_DESC ITEM_MT_DESC,
D.LINE_TYPE LINE_TYPE,
D.REPAIRE_ID REPAIRE_ID,
I.ITEM_MT_MANUFACTURE MANUFACTURER,
I.ITEM_MT_MFG_PART_NO MFG_PART_NO,
I.ITEM_MT_UPC UPC,
(SELECT SUM(dt.advance_payment) FROM lz_pos_repair_mt psr,
lz_pos_repair_det dt WHERE psr.lz_pos_repaire_id(+) = D.REPAIRE_ID AND dt.lz_pos_repair_mt_id(+) = psr.lz_pos_repaire_id) ADVANCE_PAYMENT,
--dt.advance_payment ADVANCE_PAYMENT,
DECODE(D.DISC_AMT, null, D.PRICE, D.PRICE - D.DISC_AMT) NET_PRICE
FROM LZ_POS_MT M,
LZ_POS_DET D,
lz_barcode_mt BC,
ITEMS_MT I
/*lz_pos_repair_mt psr,
lz_pos_repair_det dt*/
WHERE M.LZ_POS_MT_ID = D.LZ_POS_MT_ID
/* AND psr.lz_pos_repaire_id(+) = D.REPAIRE_ID*/
AND M.LZ_POS_MT_ID = '$lz_pos_mt_id'
AND M.DELETED_STATUS != 1
AND D.DELETED_STATUS != 1
/*AND dt.lz_pos_repair_mt_id(+) = psr.lz_pos_repaire_id*/
AND BC.BARCODE_NO(+) = D.BARCODE_ID
AND BC.ITEM_ID = I.ITEM_ID(+)
order by d.lz_pos_det_id";
        $result = $this->db->query($qr);
        if ($result->num_rows() > 0) {
            return array("status" => true, "data" => $result->result_array());
        } else {
            return array("status" => false, "data" => array(), "message" => "No record Found");
        }
    }

    public function Update_Invoice_Pos()
    {
        $craig_post = $this->input->post('ad_id');
        $doc_no = $this->input->post('doc_no');
        $portal_id = $this->input->post('portal_id');
        if (!empty($portal_id)) {
            $portal_id = $portal_id['value'];
        }
        // $doc_no = docNo();

        // $doc_date = $this->input->post('doc_date');
        date_default_timezone_set("America/Chicago");
        $doc_date = date("Y-m-d H:i:s"); //change date format from 07-Dec-2016 to 12/07/2016
        // $date= date_format($date,"m/d/Y");
        $lz_pos_mt_id = $this->input->post("lz_pos_mt_id");
        $doc_date = "TO_DATE('" . $doc_date . "', 'YYYY-MM-DD HH24:MI:SS')";
        $phone_id = $this->input->post('phone_no');
        $phone_id = trim(str_replace("_", '', $phone_id));
        $buyer_email = $this->input->post('buyer_email');
        $buyer_email = trim(str_replace("  ", ' ', $buyer_email));
        $buyer_name = $this->input->post('buyer_name');
        $buyer_name = trim(str_replace("  ", ' ', $buyer_name));
        $buyer_address = $this->input->post('buyer_address');
        $buyer_address = trim(str_replace("  ", ' ', $buyer_address));
        $buyer_citys = $this->input->post('buyer_city');
        $buyer_city = $buyer_citys[0]['value'];
        $buyer_states = $this->input->post('buyer_state');
        $buyer_state = $buyer_states[0]['value'];
        $buyer_zip = $this->input->post('buyer_zip');
        $buyer_zip = trim(str_replace("  ", ' ', $buyer_zip));
        $store_id = $this->input->post("store_id");
        $store_id = $store_id[0]['value'];
        $data = $this->input->post('data');
        $coma = ',';
        //----End Buyer Record-------
        //---- Payment Block ----
        $pay_mode = "";
        $pay_mode1 = $this->input->post('pay_mode');
        if ($pay_mode1 == "true") {
            $pay_mode = "C";
        }
        if ($pay_mode1 == "false") {
            $pay_mode = "R";
            // var_dump($pay_mode);exit();
        }

        $pay_mode = trim(str_replace("  ", ' ', $pay_mode));
        $tax_exempt = $this->input->post('exempt');
        $card_number = $this->input->post('card_number');
        $dis_percent = "";
        $disc_amount = $this->input->post('disc_total_amount');
        $net_amount = $this->input->post('net_amount');
        $td_amount = $this->input->post('tender_amount');
        $refund = $this->input->post('tender_refund');
        $login_id = $this->input->post('user_id');
        $sales_tax = $this->input->post('sale_tax');
        $amount_paid = $this->input->post("amount_paid");
        // $sales_tax = 0;
        $tx_exmp = 0;
        if ($tax_exempt == 'true') {
            $tx_exmp = 1;
            $sales_tax = 0;
        } else if ($tax_exempt == 'false') {
            $tx_exmp = 0;
            $sales_tax = $sales_tax;
        }
        // var_dump($tax_exempt);
        // var_dump($tx_exmp);
        // exit;
        // var_dump($disc_amount);
        // exit;
        //---- End Payment block ----
        // $qry_data = $this->db->query("SELECT get_single_primary_key('LZ_POS_MT', 'LZ_POS_MT_ID') LZ_POS_MT_ID
        // FROM DUAL");

        // $rs = $qry_data->result_array();
        // $lz_pos_mt_id = $rs[0]['LZ_POS_MT_ID'];
        if ($craig_post == null) {
            $craig_post = 1;
        }
        $qry = "SELECT LZ_CRAIG_POST_ID FROM LZ_CRAIG_POST WHERE LZ_CRAIG_POST_ID = '$craig_post'";
        $result = $this->db->query($qry);

        if ($result->num_rows() > 0) {
            // $this->db->query("UPDATE  LZ_POS_MT P SET P.POST_YN = -1 WHERE P.LZ_POS_MT_ID = $lz_pos_mt_id");
            $del_qry_det = $this->db->query("DELETE FROM LZ_POS_DET D WHERE D.LZ_POS_MT_ID = $lz_pos_mt_id");
            foreach ($data as $tableData) {
                $bar_code = $tableData['BARCODE_NO'];
                // var_dump($bar_code);exit;
                $qty = $tableData['QUANTITY'];
                $price = $tableData['COST_PRICE'];
                $disc_perc = $tableData['DISCOUNT_PER'];
                $dis_amount = $tableData['DISCOUNT_AMOUNT'];
                $dis_desc = $tableData['ITEM_MT_DESC'];
                $line_type = $tableData['LINE_TYPE'];
                $repaire_id = $tableData['REPAIRE_ID'];

                $qry2 = $this->db->query("SELECT get_single_primary_key('LZ_POS_DET','LZ_POS_DET_ID') LZ_POS_DET_ID FROM DUAL");

                $rss = $qry2->result_array();
                $lz_pos_det_id = $rss[0]['LZ_POS_DET_ID'];
                if ($repaire_id == null) {
                    $merchant = $this->db->query("SELECT m.merchant_id
                    from lz_merchant_barcode_dt d, lz_merchant_barcode_mt m
                   WHERE m.mt_id = d.mt_id
                   AND d.barcode_no = '$bar_code'")->result_array();
                    // $merch_id = $merchant['MERCHANT_ID'];
                    if (count($merchant) > 0) {
                        $merch_id = $merchant[0]['MERCHANT_ID'];
                    } else {
                        $merch_id = 1;
                    }
                    $qryDt = $this->db->query("INSERT INTO LZ_POS_DET (LZ_POS_DET_ID,LZ_POS_MT_ID,BARCODE_ID,QTY,PRICE,SALES_TAX_PERC,DISC_PERC,DISC_AMT,ITEM_DESC,LINE_TYPE,REPAIRE_ID, MERCHANT_ID) VALUES($lz_pos_det_id , '$lz_pos_mt_id' , '$bar_code' , '$qty' , '$price' , '$sales_tax' , '$disc_perc' , '$dis_amount' , '$dis_desc' , '$line_type', null, '$merch_id')");
                } else {
                    $qryDt = $this->db->query("INSERT INTO LZ_POS_DET (LZ_POS_DET_ID,LZ_POS_MT_ID,BARCODE_ID,QTY,PRICE,SALES_TAX_PERC,DISC_PERC,DISC_AMT,ITEM_DESC,LINE_TYPE,REPAIRE_ID, MERCHANT_ID) VALUES($lz_pos_det_id , '$lz_pos_mt_id' , null , '$qty' , '$price' , '$sales_tax' , '$disc_perc' , '$dis_amount' , '$dis_desc' , '$line_type', '$repaire_id', null)");

                }
            }

            $qr = "UPDATE LZ_POS_MT SET LZ_CRAIG_POST_ID = '$craig_post',DOC_NO = '$doc_no', DOC_DATE = $doc_date, BUYER_PHONE_ID = '$phone_id',BUYER_EMAIL = '$buyer_email',
                 BUYER_ADDRESS = '$buyer_address', BUYER_CITY_ID = '$buyer_city',BUYER_STATE_ID = '$buyer_state',BUYER_ZIP = '$buyer_zip', PAY_MODE = '$pay_mode' ,DISC_PERC = '$dis_percent',DISC_AMOUNT = '$disc_amount',
                --  TENDER_AMOUNT = '$td_amount',
                ENTERED_BY = '$login_id', ENTERED_DATE_TIME = $doc_date ,CREDIT_CARD = '$card_number',TAX_EXEMPT = '$tx_exmp',STAX_PERC = '$sales_tax',BUYER_NAME = '$buyer_name', STORE_ID = '$store_id', PORTAL_ID = '$portal_id'  WHERE LZ_POS_MT_ID = '$lz_pos_mt_id' ";
            $qry = $this->db->query($qr);
            $qry_data = $this->db->query("SELECT get_single_primary_key('LJ_POS_RECEIPT_MT', 'RECEIPT_ID') RECEIPT_ID
            FROM DUAL");

            $rs = $qry_data->result_array();
            $receipt_id = $rs[0]['RECEIPT_ID'];
            $amount_paid = $net_amount - $amount_paid;
            $qrys = "INSERT INTO LJ_POS_RECEIPT_MT (RECEIPT_ID, POS_MT_ID, RECEIPT_NO, RECEIPT_DATE, RECEIPT_BY, AMOUNT_PAID, PAYMENT_TYPE, INSTRUMENT_NO) VALUES ('$receipt_id','$lz_pos_mt_id', '$doc_no', sysdate, '$login_id', '$amount_paid', '$pay_mode', '$card_number')";
            $qry = $this->db->query($qrys);
            if ($qry === true) {
                foreach ($data as $barcode) {
                    $bar_code = $barcode['BARCODE_NO'];
                    if ($bar_code != '') {
                        $checkQry = $this->db->query("SELECT LZ_POS_MT_ID FROM LZ_BARCODE_MT WHERE BARCODE_NO='$bar_code'");
                        // var_dump($checkQry);exit;
                        if ($checkQry->num_rows == 0) {
                            $this->db->query("UPDATE LZ_BARCODE_MT SET LZ_POS_MT_ID=$lz_pos_mt_id where BARCODE_NO='$bar_code'");
                        }
                    }

                }
                if ($pay_mode1 == "true") {
                    $this->db->query("UPDATE  LZ_POS_MT P SET P.POST_YN = 1 WHERE P.LZ_POS_MT_ID = $lz_pos_mt_id");
                }
                if ($pay_mode1 == "true") {
                    $print = true;
                } else {
                    $print = false;
                }
                return array("status" => true, 'message' => "Record Updated Successfully", "id" => $lz_pos_mt_id, 'print' => $print);

            } else {
                return array("status" => false, "message" => "Record Not Updated Successfully");
            }
        } else {
            return array("status" => false, "message" => "Ad Id is not exist");
        }

    }

    public function Delete_POS_Barcode_Edit()
    {
        $lz_pos_det_id = $this->input->post("id");
        $barcode = $this->input->post("barcode");
        $user_id = $this->input->post("user_id");
        $qr = "SELECT LZ_POS_MT_ID FROM LZ_POS_DET WHERE LZ_POS_DET_ID = '$lz_pos_det_id'";
        $resultId = $this->db->query($qr)->result_array();
        $qr = "UPDATE LZ_POS_DET SET DELETED_BY = '$user_id', DELETED_DATE = sysdate , DELETED_STATUS = '1' WHERE LZ_POS_DET_ID = '$lz_pos_det_id'";
        $result = $this->db->query($qr);
        if ($result == true) {
            $pos_id = $resultId[0]['LZ_POS_MT_ID'];
            $this->db->query("UPDATE LZ_BARCODE_MT SET LZ_POS_MT_ID=null where BARCODE_NO='$barcode'");
            $qr = "SELECT COUNT(1) TOTAL FROM LZ_POS_DET WHERE LZ_POS_MT_ID = '$pos_id' AND DELETED_STATUS = 0";
            $result = $this->db->query($qr)->result_array();
            if ($result[0]['TOTAL'] == 0) {
                $qr = "UPDATE LZ_POS_MT SET DELETED_BY = '$user_id', DELETED_DATE = sysdate , DELETED_STATUS = '1' WHERE LZ_POS_MT_ID = '$pos_id'";
                $result = $this->db->query($qr);
                return array("status" => true, "message" => "Recode Deleted Successfully");
            } else {
                return array("status" => true, "message" => "Recode Deleted Successfully");
            }
        }
    }

    /*******
     *
     *
     * REPAIRE FORM
     *
     *
     *
     */

    public function Get_Barcode_Detail_Pos_Repair()
    {
        $barcode = $this->input->post('barcode');
        $barcode = trim($barcode);
        // if (isset($barcode)) {
        $result = $this->db->query("SELECT *
            FROM LZ_BARCODE_MT b
           WHERE b.BARCODE_NO = '$barcode' ");
        if ($result->num_rows() > 0) {
            $data = $result->result_array();
            if ($data[0]['PULLING_ID'] != null) {
                $sale_record_no = $data[0]['SALE_RECORD_NO'];
                return array("status" => false, 'message' => "Barcode Ship Aganist sale Record $sale_record_no ");
            } else if ($data[0]['PULLING_ID'] == null && $data[0]['SALE_RECORD_NO'] != null) {
                $sale_record_no = $data[0]['SALE_RECORD_NO'];
                return array("status" => false, 'message' => "Barcode Already Sold Aganist sale Record  $sale_record_no ");
            } else if ($data[0]['PULLING_ID'] == null && $data[0]['SALE_RECORD_NO'] == null && $data[0]['EBAY_ITEM_ID'] != null) {
                $ebay_id = $data[0]['EBAY_ITEM_ID'];
                return array("status" => false, "message" => "Barcode Already Listed Aganist ebay id $ebay_id ");
            } else if ($data[0]['ITEM_ADJ_DET_ID_FOR_IN'] != null || $data[0]['ITEM_ADJ_DET_ID_FOR_OUT'] != null || $data[0]['LZ_PART_ISSUE_MT_ID'] != null || $data[0]['HOLD_STATUS'] != 0) {
                return array("status" => false, "message" => "Barcode Already Consumed");
            } elseif ($data[0]['LZ_POS_MT_ID'] != null) {
                $id = $data[0]['DOC_NO'];
                return array("status" => false, "message" => "Barcode Already Consumed By POS  DOC $id");
            } else if ($data[0]['REPAIR_ID'] !== null) {
                $id = $data[0]['REPAIR_ID'];
                return array("status" => false, "message" => "Barcode Already Consumed By Repair  $id");
            }
            $detail_query = $this->db->query("SELECT S.SEED_ID,
                LM.LZ_MANIFEST_ID,
                LM.PURCH_REF_NO,
                NVL(S.ITEM_TITLE, I.ITEM_DESC) ITEM_MT_DESC,
                I.ITEM_MT_MANUFACTURE MANUFACTURER,
                I.ITEM_MT_MFG_PART_NO MFG_PART_NO,
                I.ITEM_MT_UPC UPC,
                BCD.CONDITION_ID ITEM_CONDITION,
                BCD.QTY QUANTITY,
                S.EBAY_PRICE COST_PRICE,
                BCD.BARCODE_NO,
                null LINE_TYPE,
                null DISCOUNT_PER,
                null DISCOUNT_AMOUNT,
                null LZ_POS_DET_ID,
                null ADVANCE_PAYMENT,
                DECODE(S.EBAY_PRICE, 0, 0 , S.EBAY_PRICE) NET_PRICE,
                0 ADVANCE_PAYMENT,
                null REPAIRE_ID
           FROM LZ_MANIFEST_MT LM,
                ITEMS_MT I,
                LZ_ITEM_SEED S,
                (SELECT BC.EBAY_ITEM_ID,
                        BC.LZ_MANIFEST_ID,
                        BC.ITEM_ID,
                        BC.BARCODE_NO,
                        BC.CONDITION_ID,
                        COUNT(1) QTY
                   FROM LZ_BARCODE_MT BC
                  WHERE BC.BARCODE_NO = '$barcode'
                    and bc.pulling_id is null
                  GROUP BY BC.LZ_MANIFEST_ID,
                           BC.ITEM_ID,
                           BC.CONDITION_ID,
                           BC.BARCODE_NO,
                           BC.EBAY_ITEM_ID) BCD,
                (SELECT D.LZ_MANIFEST_ID,
                        I.ITEM_ID,
                        MAX(D.PO_DETAIL_RETIAL_PRICE) COST_PRICE
                   FROM LZ_MANIFEST_DET D, ITEMS_MT I
                  WHERE D.LAPTOP_ITEM_CODE = I.ITEM_CODE
                  GROUP BY D.LZ_MANIFEST_ID, I.ITEM_ID) QRY_PRICE
          WHERE BCD.ITEM_ID = I.ITEM_ID
            AND BCD.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID
            AND BCD.ITEM_ID = QRY_PRICE.ITEM_ID
            AND BCD.LZ_MANIFEST_ID = QRY_PRICE.LZ_MANIFEST_ID
            AND S.ITEM_ID(+) = BCD.ITEM_ID
            AND S.LZ_MANIFEST_ID(+) = BCD.LZ_MANIFEST_ID
            AND S.DEFAULT_COND(+) = BCD.CONDITION_ID");

            return array("status" => true, "data" => $detail_query->result_array());
        }
        return array("status" => false, "message" => "No Barcode Found");
        // }

    }

    public function Save_Pos_Repaire_Data()
    {
        $delivery_date = $this->input->post('delivery_date');
        $product_owner = $this->input->post('product_owner');
        $product_owner = trim(str_replace("  ", ' ', $product_owner));
        $repaire_cost = $this->input->post('repaire_cost');
        $repaire_cost = trim(str_replace("$", " ", $repaire_cost));
        $repaire_des = $this->input->post('repaire_des');
        $repaire_des = trim(str_replace("  ", ' ', $repaire_des));
        $email = $this->input->post('email');
        $email = trim(str_replace("  ", ' ', $email));
        $serial_no = $this->input->post('serial_no');
        $store_id = $this->input->post('store_id');
        $store_id = $store_id['value'];
        $phoneNumber = $this->input->post('phoneNumber');
        $phoneNumber = trim(str_replace("_", ' ', $phoneNumber));
        $brand = $this->input->post('brand');
        $brand = trim(str_replace("  ", ' ', $brand));
        // $phoneNumber = trim(str_replace("_", '', $phoneNumber));
        $advance_payment = $this->input->post("advance_payment");
        $advance_payment = trim(str_replace("$", " ", $advance_payment));
        $mpn = $this->input->post('mpn');
        $user_id = $this->input->post("user_id");
        $city_id = $this->input->post('city_id');
        $city_id = $city_id['value'];
        $state_id = $this->input->post('state_id');
        $state_id = $state_id['value'];
        $line_type = $this->input->post('line_type');
        $line_type = $line_type['value'];
        $user_id = $this->input->post('user_id');
        $service_charges = $this->input->post("service_charges");
        $service_charges = trim(str_replace("$", " ", $service_charges));
        $data = $this->input->post('data');
        $qry2 = $this->db->query("SELECT get_single_primary_key('LZ_POS_REPAIR_MT','LZ_POS_REPAIRE_ID') LZ_POS_REPAIRE_ID FROM DUAL");

        $rss = $qry2->result_array();
        $lz_pos_repaire_id = $rss[0]['LZ_POS_REPAIRE_ID'];
        $concatDate = date("m/d/Y");
        $barDate = str_replace('/', '', $concatDate);
        // var_dump($barDate);exit;
        $str1 = substr($barDate, 0, 4);
        $str2 = substr($barDate, 6, 8);
        $docDateStr = $str1 . $str2;
        $barcode = $lz_pos_repaire_id . '-' . $docDateStr;
        $qry = "INSERT INTO LZ_POS_REPAIR_MT (LZ_POS_REPAIRE_ID, PRODUCT_OWNER, STORE_ID, PHONE_NO, EMAIL, EXPT_REPAIRE_COST, EXPT_DEL_DATE, SERIAL_NO, MPN, REPAIRE_DES, CREATED_BY, CREATED_AT, CITY_ID, STATE_ID, ADVANCE_PAYMENT,BRAND,RECEIPT_BARCODE_NO, SERVICE_CHARGES) VALUES ($lz_pos_repaire_id, '$product_owner', '$store_id', '$phoneNumber', '$email', null,
        -- '$repaire_cost',
        TO_DATE('$delivery_date','DD/MM/YYYY HH24:MI:SS'), '$serial_no',
        '$mpn', '$repaire_des', '$user_id', sysdate, '$city_id', '$state_id',
        --'$advance_payment',
        null, '$brand', '$barcode', '$service_charges')";
        $result = $this->db->query($qry);
        $qry2 = $this->db->query("SELECT get_single_primary_key('LZ_POS_REPAIR_DET','LZ_POS_REPAIR_DET_ID') LZ_POS_REPAIR_DET_ID FROM DUAL");
        $rss = $qry2->result_array();
        $lz_pos_repaire_det_id = $rss[0]['LZ_POS_REPAIR_DET_ID'];
        $qr = "INSERT INTO LZ_POS_REPAIR_DET (LZ_POS_REPAIR_DET_ID, LZ_POS_REPAIR_MT_ID, BARCODE_NO, LINE_TYPE, COST, ADVANCE_PAYMENT, CREATED_BY, CREATED_AT) VALUES ($lz_pos_repaire_det_id ,$lz_pos_repaire_id, '$barcode', '$line_type', '$repaire_cost', '$advance_payment', '$user_id', sysdate )";
        $this->db->query($qr);
        if (!empty($data)) {
            foreach ($data as $record) {
                $lines_types = $record['LINE_TYPE'];
                $barcode_no = $record['BARCODE_NO'];
                $cost = $record['COST_PRICE'];
                $advance_pay = $record['ADVANCE_PAYMENT'];
                $qry2 = $this->db->query("SELECT get_single_primary_key('LZ_POS_REPAIR_DET','LZ_POS_REPAIR_DET_ID') LZ_POS_REPAIR_DET_ID FROM DUAL");
                $rss = $qry2->result_array();
                $lz_pos_repaire_det_id = $rss[0]['LZ_POS_REPAIR_DET_ID'];
                $qr = "INSERT INTO LZ_POS_REPAIR_DET (LZ_POS_REPAIR_DET_ID, LZ_POS_REPAIR_MT_ID, BARCODE_NO, LINE_TYPE, COST, ADVANCE_PAYMENT, CREATED_BY, CREATED_AT) VALUES ($lz_pos_repaire_det_id ,$lz_pos_repaire_id, '$barcode_no', '$lines_types', '$cost', '$advance_pay', '$user_id', sysdate )";
                $this->db->query($qr);
                $this->db->query("UPDATE LZ_BARCODE_MT SET REPAIR_ID = '$lz_pos_repaire_det_id' WHERE BARCODE_NO = '$barcode_no'");
            }
        }
        // } else {
        //     $qry2 = $this->db->query("SELECT get_single_primary_key('LZ_POS_REPAIR_DET','LZ_POS_REPAIR_DET_ID') LZ_POS_REPAIR_DET_ID FROM DUAL");
        //     $rss = $qry2->result_array();
        //     $lz_pos_repaire_det_id = $rss[0]['LZ_POS_REPAIR_DET_ID'];
        //     $qr = "INSERT INTO LZ_POS_REPAIR_DET (LZ_POS_REPAIR_DET_ID, LZ_POS_REPAIR_MT_ID, BARCODE_NO, LINE_TYPE, COST, ADVANCE_PAYMENT, CREATED_BY, CREATED_AT) VALUES ($lz_pos_repaire_det_id ,$lz_pos_repaire_id, null, '$line_type', '$repaire_cost', '$advance_payment' , '$user_id', sysdate )";
        //     $this->db->query($qr);
        //     var_dump($data);
        // }

        if ($result) {
            //         $qr = "SELECT  prt.lz_pos_repaire_id, prt.product_owner,
            //         prt.store_id,
            //         prt.phone_no,
            //         prt.email,
            //         prt.expt_del_date,
            //         prt.serial_no,
            //         prt.mpn,
            //         prt.created_by,
            //         prt.city_id,
            //         prt.created_at,
            //         prt.state_id,
            //         prt.service_charges,
            //         prt.repaire_status,
            //         prt.brand,
            //         prt.receipt_barcode_no,
            //         (select (sum(dt.cost))
            //            from lz_pos_repair_det dt
            //           where dt.lz_pos_repair_mt_id = prt.lz_pos_repaire_id
            //             and dt.deleted_status != 1) EXPT_REPAIRE_COST,
            //         (select (sum(dt.advance_payment))
            //            from lz_pos_repair_det dt
            //           where dt.lz_pos_repair_mt_id = prt.lz_pos_repaire_id
            //             and dt.deleted_status != 1) ADVANCE_PAYMENT,
            //         (select (sum(dt.cost) - sum(dt.advance_payment))
            //            from lz_pos_repair_det dt
            //           where dt.lz_pos_repair_mt_id = prt.lz_pos_repaire_id
            //             and dt.deleted_status != 1) EXPECTED_PAYABLE,
            //         SM.STATE_DESC,
            //         CM.CITY_DESC,
            //         pst.store_name,
            //         Decode(prt.REPAIRE_STATUS,
            //                0,
            //                'Pending',
            //                1,
            //                'Waiting For Parts',
            //                2,
            //                'Complete',
            //                3,
            //                'Not Repairable') REPAIR_STATUS
            //    from LZ_POS_REPAIR_MT prt,
            //    lz_pos_repair_det dt,
            //         WIZ_STATE_MT     SM,
            //         WIZ_CITY_MT      CM,
            //         LJ_POS_STORE_MT  PST
            //   WHERE prt.state_id = SM.STATE_ID
            //     AND prt.city_id = CM.CITY_ID
            //     AND prt.DELETED_STATUS != 1
            //     AND dt.deleted_status !=1
            //     AND prt.store_id = pst.lj_pos_store_id
            // AND prt.lz_pos_repaire_id = '$lz_pos_repaire_id'";
            $qr = "SELECT prt.lz_pos_repaire_id,
    prt.product_owner,
    prt.store_id,
    prt.phone_no,
    prt.email,
    prt.expt_del_date,
    prt.serial_no,
    prt.mpn,
    prt.created_by,
    prt.city_id,
    prt.created_at,
    prt.state_id,
    prt.service_charges,
    prt.repaire_status,
    prt.brand,
    prt.receipt_barcode_no,
    (select (sum(dt.cost))
       from lz_pos_repair_det dt, lz_pos_repair_mt prt
      where dt.lz_pos_repair_mt_id = prt.lz_pos_repaire_id
        and dt.deleted_status != 1) EXPT_REPAIRE_COST,
    (select (sum(dt.advance_payment))
       from lz_pos_repair_det dt
      where dt.lz_pos_repair_mt_id = prt.lz_pos_repaire_id
        and dt.deleted_status != 1) ADVANCE_PAYMENT,
    (select (sum(dt.cost) - DECODE(sum(dt.advance_payment),null,0,sum(dt.advance_payment)))
       from lz_pos_repair_det dt
      where dt.lz_pos_repair_mt_id = prt.lz_pos_repaire_id
        and dt.deleted_status != 1) EXPECTED_PAYABLE,
    SM.STATE_DESC,
    CM.CITY_DESC,
    pst.store_name,
    Decode(prt.REPAIRE_STATUS,
           0,
           'Pending',
           1,
           'Waiting For Parts',
           2,
           'Complete',
           3,
           'Not Repairable') REPAIR_STATUS
from LZ_POS_REPAIR_MT prt,
    -- lz_pos_repair_det dt,
    WIZ_STATE_MT    SM,
    WIZ_CITY_MT     CM,
    LJ_POS_STORE_MT PST
WHERE prt.state_id = SM.STATE_ID
AND prt.city_id = CM.CITY_ID
AND prt.DELETED_STATUS != 1
   --AND dt.deleted_status !=1
AND prt.store_id = pst.lj_pos_store_id
AND prt.lz_pos_repaire_id = '$lz_pos_repaire_id'";
            $result = $this->db->query($qr);
            return array('status' => true, "message" => "Record Updated", 'id' => $lz_pos_repaire_id, 'data' => $result->result_array());
        } else {
            return array('status' => false, "message" => "Record Not Updated");
        }

    }

    public function Print_Repaire_Slip($lz_pos_repaire_id)
    {
        $print_qry = $this->db->query("SELECT DT.LZ_POS_MT_ID,
        DT.ITEM_DESC,
        MT.DOC_NO,
        MT.PAY_MODE,
        MT.STAX_PERC DET_SALES_TAX,
        NVL(SUM(DT.QTY), 0) QTY,
        NVL(SUM(DT.PRICE), 0) DET_PRICE,
        NVL(SUM(DT.DISC_AMT), 0) DISC_AMT
   FROM LZ_POS_DET DT, LZ_POS_MT MT
  WHERE DT.LZ_POS_MT_ID = 42
    AND DT.LZ_POS_MT_ID = MT.LZ_POS_MT_ID
  GROUP BY DT.ITEM_DESC,
           DT.LZ_POS_MT_ID,
           MT.DOC_NO,
           MT.PAY_MODE,
           MT.STAX_PERC");
        $store_name = $this->db->query("select pst.store_name,
        pst.address,
        pst.phone_no,
        cm.city_desc,
        sm.state_desc,
        psr.product_owner,
        psr.service_charges,
       dt.cost expt_repaire_cost,
 /*(select sum(dt.cost)
           from lz_pos_repair_det dt
          where dt.lz_pos_repair_mt_id = '$lz_pos_repaire_id'
            and dt.deleted_status != 1) expt_repaire_cost,*/
        psr.expt_del_date,
        psr.serial_no,
        psr.lz_pos_repaire_id,
        nvl(i.item_desc, psr.brand || ' | ' || psr.mpn || '| ' ||dt.LINE_TYPE) repaire_des,
        pst.sale_tax,
        pst.owner_name,
        dt.advance_payment advance_payment,
        /*(select sum(dt.advance_payment)
           from lz_pos_repair_det dt
          where dt.lz_pos_repair_mt_id = '$lz_pos_repaire_id'
            and dt.deleted_status != 1) advance_payment,*/
        psr.Mpn,
        psr.BRAND,
        psr.phone_no CUSTOMER_NUMBER,
        (dt.cost - dt.advance_payment) EXPECTED_PAYABLE
        /*select (sum(dt.cost) - sum(dt.advance_payment))
           from lz_pos_repair_det dt
          where dt.lz_pos_repair_mt_id = '$lz_pos_repaire_id'
            and dt.deleted_status != 1) EXPECTED_PAYABLE*/
   from lj_pos_store_mt   pst,
        lz_pos_repair_mt  psr,
        WIZ_CITY_MT       cm,
        WIZ_STATE_MT      sm,
        lz_barcode_mt     b,
        items_mt          i,
        lz_pos_repair_det dt
  WHERE psr.store_id = pst.lj_pos_store_id
    AND psr.lz_pos_repaire_id = '$lz_pos_repaire_id'
    AND cm.city_id = psr.city_id
    AND sm.state_id = psr.state_id
    AND psr.lz_pos_repaire_id = dt.lz_pos_repair_mt_id
    AND dt.deleted_status !=1
    AND psr.deleted_status != 1
    AND dt.barcode_no = to_char(b.barcode_no(+))
    AND i.item_id(+) = b.item_id");

        return array('data' => $print_qry->result_array(), 'store_name' => $store_name->result_array());
    }

    public function Repaire_Pos_Data()
    {
        $qr = "SELECT prt.lz_pos_repaire_id,
        prt.product_owner,
        prt.store_id,
        prt.phone_no,
        prt.email,
        prt.expt_del_date,
        prt.serial_no,
        prt.mpn,
        prt.created_by,
        prt.city_id,
        prt.created_at,
        prt.state_id,
        prt.service_charges,
        prt.repaire_status,
        prt.brand,
        prt.receipt_barcode_no,
        (select (sum(dt.cost))
           from lz_pos_repair_det dt, lz_pos_repair_mt prt
          where dt.lz_pos_repair_mt_id = prt.lz_pos_repaire_id
            and dt.deleted_status != 1) EXPT_REPAIRE_COST,
        (select (sum(dt.advance_payment))
           from lz_pos_repair_det dt
          where dt.lz_pos_repair_mt_id = prt.lz_pos_repaire_id
            and dt.deleted_status != 1) ADVANCE_PAYMENT,
        (select (sum(dt.cost) - DECODE(sum(dt.advance_payment),null,0,sum(dt.advance_payment)))
           from lz_pos_repair_det dt
          where dt.lz_pos_repair_mt_id = prt.lz_pos_repaire_id
            and dt.deleted_status != 1) EXPECTED_PAYABLE,
        SM.STATE_DESC,
        CM.CITY_DESC,
        pst.store_name,
        Decode(prt.REPAIRE_STATUS,
               0,
               'Pending',
               1,
               'Waiting For Parts',
               2,
               'Complete',
               3,
               'Not Repairable') REPAIR_STATUS
   from LZ_POS_REPAIR_MT prt,
        -- lz_pos_repair_det dt,
        WIZ_STATE_MT    SM,
        WIZ_CITY_MT     CM,
        LJ_POS_STORE_MT PST
  WHERE prt.state_id = SM.STATE_ID
    AND prt.city_id = CM.CITY_ID
    AND prt.DELETED_STATUS != 1
       --AND dt.deleted_status !=1
    AND prt.store_id = pst.lj_pos_store_id ";
        $result = $this->db->query($qr);
        if ($result->num_rows() > 0) {
            return array("status" => true, "data" => $result->result_array());
        } else {
            return array("status" => false, "message" => "No Record Found");
        }
    }

    public function Get_Specific_Pos_Repair_Data()
    {
        $barcode = $this->input->post("barcode_no");
        $repiar_id = $this->input->post("id");
        $qr = "SELECT
        ps.lz_pos_repaire_id,
        dt.barcode_no BARCODE_NO,
        dt.cost COST_PRICE,
        ps.mpn MFG_PART_NO,
        nvl(i.item_desc,
        ps.brand || ' | ' || ps.mpn || ' | ' || dt.LINE_TYPE) ITEM_MT_DESC,
        ps.repaire_status REPAIR_STATUS,
        1 QUANTITY,
        NULL DISCOUNT_PER,
        NULL DISCOUNT_AMOUNT,
        nvl(i.item_mt_upc, NULL) UPC,
        nvl(i.item_mt_manufacture,NULL) MANUFACTURER,
        nvl(i.item_condition,null) ITEM_CONDITION,
        -- NULL UPC,
        -- NULL MANUFACTURER,
        -- NULL ITEM_CONDITION,
        dt.line_type LINE_TYPE,
        ps.lz_pos_repaire_id REPAIRE_ID,
        DECODE(dt.ADVANCE_PAYMENT, 0, 0, dt.ADVANCE_PAYMENT) ADVANCE_PAYMENT,
        DECODE(dt.cost, 0, 0, dt.cost) NET_PRICE
        from lz_pos_repair_mt ps, lz_pos_repair_det dt , items_mt i , lz_barcode_mt b
        WHERE ps.lz_pos_repaire_id = '$repiar_id'
        AND ps.DELETED_STATUS != 1
        AND dt.DELETED_STATUS != 1
        and ps.lz_pos_repaire_id = dt.lz_pos_repair_mt_id
        and dt.barcode_no = to_char(b.barcode_no(+))
        and b.item_id = i.item_id(+)";
        $data = $this->db->query($qr);
        if ($data->num_rows() > 0) {
            return array("status" => true, "data" => $data->result_array());
        } else {
            return array("status" => false, "data" => array());
        }
        // $this->db->quer("select prm.receipt_barcode_no from lz_pos_repair_mt prm where prm.lz_pos_repaire_id = '23'")

    }
    public function Update_Pos_Repaire_Data()
    {
        $delivery_date = $this->input->post('delivery_date');
        $product_owner = $this->input->post('product_owner');
        $product_owner = trim(str_replace("  ", ' ', $product_owner));
        $repaire_cost = $this->input->post('repaire_cost');
        $repaire_cost = trim(str_replace("$", " ", $repaire_cost));
        $repaire_cost = trim(str_replace(",", "", $repaire_cost));
        $repaire_des = $this->input->post('repaire_des');
        $repaire_des = trim(str_replace("  ", ' ', $repaire_des));
        $email = $this->input->post('email');
        $email = trim(str_replace("  ", ' ', $email));
        $edit_brand = $this->input->post('edit_brand');
        $edit_brand = trim(str_replace("  ", ' ', $edit_brand));
        $serial_no = $this->input->post('serial_no');
        $store_id = $this->input->post('store_id');
        $store_id = $store_id['value'];
        $phoneNumber = $this->input->post('phoneNumber');
        $phoneNumber = trim(str_replace("_", ' ', $phoneNumber));
        // $phoneNumber = trim(str_replace("_", ' ', $phoneNumber));
        $mpn = $this->input->post('mpn');
        $user_id = $this->input->post("user_id");
        $city_id = $this->input->post('city_id');
        $city_id = $city_id['value'];
        $state_id = $this->input->post('state_id');
        $state_id = $state_id['value'];
        $lz_pos_repaire_id = $this->input->post('id');
        $advance_payment = $this->input->post("edit_advance_payment");
        $advance_payment = trim(str_replace("$", ' ', $advance_payment));
        $edit_repair_status = $this->input->post('edit_repair_status');
        $edit_repair_status = $edit_repair_status['value'];
        $data = $this->input->post('data');
        // var_dump($state_id, $city_id, $store_id);
        // exit;

        $concatDate = date("m/d/Y");
        $barDate = str_replace('/', '', $concatDate);
        // var_dump($barDate);exit;
        $str1 = substr($barDate, 0, 4);
        $str2 = substr($barDate, 6, 8);
        $docDateStr = $str1 . $str2;
        $barcode = $lz_pos_repaire_id . '-' . $docDateStr;

        $qry = "UPDATE LZ_POS_REPAIR_MT SET PRODUCT_OWNER = '$product_owner', STORE_ID = '$store_id', PHONE_NO = '$phoneNumber', EMAIL = '$email', --EXPT_REPAIRE_COST = '$repaire_cost',
         EXPT_DEL_DATE = TO_DATE('$delivery_date','DD/MM/YYYY HH24:MI:SS') , SERIAL_NO = '$serial_no'
        ,MPN = '$mpn', REPAIRE_DES = '$repaire_des',
        -- ADVANCE_PAYMENT = '$advance_payment',
        CREATED_BY = '$user_id', CREATED_AT = sysdate, CITY_ID = '$city_id', STATE_ID = '$state_id', BRAND = '$edit_brand', REPAIRE_STATUS = '$edit_repair_status', RECEIPT_BARCODE_NO = '$barcode' WHERE LZ_POS_REPAIRE_ID = '$lz_pos_repaire_id'";
        $result = $this->db->query($qry);
        $qr = "SELECT RECEIPT_BARCODE_NO FROM lz_pos_repair_mt WHERE LZ_POS_REPAIRE_ID = '$lz_pos_repaire_id' ";
        $repair_id_barcode = $this->db->query($qr)->result_array();
        if ($result === true) {
            foreach ($data as $res) {
                $lines_types = $res['LINE_TYPE'];
                $barcode_no = $res['BARCODE_NO'];
                $cost = $res['COST_PRICE'];
                $advance_pay = $res['ADVANCE_PAYMENT'];
                if ($repair_id_barcode[0]['RECEIPT_BARCODE_NO'] == $barcode_no) {
                    $update = $this->db->query("UPDATE LZ_POS_REPAIR_MT SET SERVICE_CHARGES = '$cost' WHERE LZ_POS_REPAIRE_ID = '$lz_pos_repaire_id'");
                }
                $exist = $this->db->query("SELECT LZ_POS_REPAIR_DET_ID FROM LZ_POS_REPAIR_DET WHERE BARCODE_NO = '$barcode_no' AND DELETED_STATUS != 1");
                if ($exist->num_rows() > 0) {
                    $qr = "UPDATE LZ_POS_REPAIR_DET SET LINE_TYPE = '$lines_types', COST='$cost' , ADVANCE_PAYMENT ='$advance_pay' WHERE BARCODE_NO = '$barcode_no'";
                    $this->db->query($qr);
                } else {
                    $qry2 = $this->db->query("SELECT get_single_primary_key('LZ_POS_REPAIR_DET','LZ_POS_REPAIR_DET_ID') LZ_POS_REPAIR_DET_ID FROM DUAL");
                    $rss = $qry2->result_array();
                    $lz_pos_repaire_det_id = $rss[0]['LZ_POS_REPAIR_DET_ID'];
                    $qr = "INSERT INTO LZ_POS_REPAIR_DET (LZ_POS_REPAIR_DET_ID, LZ_POS_REPAIR_MT_ID, BARCODE_NO, LINE_TYPE, COST, ADVANCE_PAYMENT, CREATED_BY, CREATED_AT) VALUES ($lz_pos_repaire_det_id ,$lz_pos_repaire_id, '$barcode_no', '$lines_types', '$cost', '$advance_pay', '$user_id', sysdate )";
                    $this->db->query($qr);
                    $this->db->query("UPDATE LZ_BARCODE_MT SET REPAIR_ID = '$lz_pos_repaire_det_id' WHERE BARCODE_NO = '$barcode_no'");

                }
                // $this->db->query($qr);
            }
//             $qr = "SELECT prt.*,
            //         DECODE(prt.advance_payment,
            //                null,
            //                prt.expt_repaire_cost,
            //                prt.expt_repaire_cost - prt.advance_payment) EXPECTED_PAYABLE,
            //         SM.STATE_DESC,
            //         CM.CITY_DESC,
            //         pst.store_name,
            //         Decode(prt.REPAIRE_STATUS,
            //                    0,
            //                    'Pending',
            //                    1,
            //                    'Waiting For Parts',
            //                    2,
            //                    'Complete',
            //                    3,
            //                    'Not Repairable'
            //                   ) REPAIR_STATUS
            //    from LZ_POS_REPAIR_MT prt,
            //         WIZ_STATE_MT     SM,
            //         WIZ_CITY_MT      CM,
            //         LJ_POS_STORE_MT  PST
            //   WHERE prt.state_id = SM.STATE_ID
            //     AND prt.city_id = CM.CITY_ID
            //     AND prt.store_id = pst.lj_pos_store_id
            //     AND prt.lz_pos_repaire_id = '$lz_pos_repaire_id'";
            $qr = "SELECT prt.lz_pos_repaire_id,
prt.product_owner,
prt.store_id,
prt.phone_no,
prt.email,
prt.expt_del_date,
prt.serial_no,
prt.mpn,
prt.created_by,
prt.city_id,
prt.created_at,
prt.state_id,
prt.service_charges,
prt.repaire_status,
prt.brand,
prt.receipt_barcode_no,
(select (sum(dt.cost))
   from lz_pos_repair_det dt, lz_pos_repair_mt prt
  where dt.lz_pos_repair_mt_id = prt.lz_pos_repaire_id
    and dt.deleted_status != 1) EXPT_REPAIRE_COST,
(select (sum(dt.advance_payment))
   from lz_pos_repair_det dt
  where dt.lz_pos_repair_mt_id = prt.lz_pos_repaire_id
    and dt.deleted_status != 1) ADVANCE_PAYMENT,
    (select (sum(dt.cost) - DECODE(sum(dt.advance_payment),null,0,sum(dt.advance_payment)))
           from lz_pos_repair_det dt
          where dt.lz_pos_repair_mt_id = prt.lz_pos_repaire_id
            and dt.deleted_status != 1) EXPECTED_PAYABLE,
SM.STATE_DESC,
CM.CITY_DESC,
pst.store_name,
Decode(prt.REPAIRE_STATUS,
       0,
       'Pending',
       1,
       'Waiting For Parts',
       2,
       'Complete',
       3,
       'Not Repairable') REPAIR_STATUS
from LZ_POS_REPAIR_MT prt,
-- lz_pos_repair_det dt,
WIZ_STATE_MT    SM,
WIZ_CITY_MT     CM,
LJ_POS_STORE_MT PST
WHERE prt.state_id = SM.STATE_ID
AND prt.city_id = CM.CITY_ID
AND prt.DELETED_STATUS != 1
--AND dt.deleted_status !=1
AND prt.store_id = pst.lj_pos_store_id
AND prt.lz_pos_repaire_id = '$lz_pos_repaire_id'";
            $results = $this->db->query($qr);
            if ($results->num_rows() > 0) {
                return array('status' => true, "message" => "Record Updated", 'id' => $lz_pos_repaire_id, 'data' => $results->result_array());
            }
        } else {
            return array('status' => false, "message" => "Record Not Updated");
        }

    }

    public function Delete_Pos_Repaire_Data()
    {
        $lz_pos_repaire_id = $this->input->post('id');
        $user_id = $this->input->post('user_id');
        $qr = "SELECT REPAIRE_ID FROM LZ_POS_DET WHERE REPAIRE_ID = $lz_pos_repaire_id AND DELETED_STATUS != 1";
        $result = $this->db->query($qr)->result_array();
        if (count($result) > 0) {
            return array("status" => false, "message" => "Repaire Invoice Is Not Deleted Successfully Because Use In POS");
        } else {
            $id = $this->db->query("SELECT LZ_POS_REPAIR_DET_ID FROM LZ_POS_REPAIR_DET WHERE LZ_POS_REPAIR_MT_ID =  '$lz_pos_repaire_id'")->result_array();
            foreach ($id as $dt_id) {
                $lz_pos_repair_det_id = $dt_id['LZ_POS_REPAIR_DET_ID'];
                $this->db->query("UPDATE LZ_BARCODE_MT SET REPAIR_ID = null WHERE REPAIR_ID = '$lz_pos_repair_det_id'");
            }
            $qr = "UPDATE LZ_POS_REPAIR_MT SET DELETED_BY = '$user_id', DELETED_DATE = sysdate, DELETED_STATUS = 1 WHERE lz_pos_repaire_id = '$lz_pos_repaire_id' ";
            $qrs = "UPDATE LZ_POS_REPAIR_DET SET DELETED_BY = '$user_id', DELETED_AT = sysdate, DELETED_STATUS = 1 WHERE lz_pos_repair_mt_id = '$lz_pos_repaire_id'";
            $this->db->query($qrs);
            $result = $this->db->query($qr);
            if ($result === true) {
                return array("status" => true, "message" => "Repaire Invoice Deleted Successfully");
            } else {
                return array("status" => false, "message" => "Repaire Invoice  Is  Not Deleted Successfully");
            }
        }

    }
    public function Delete_Pos_Barcode_Repaire_Edit()
    {
        $barcode = $this->input->post('barcode');
        $ids = $this->input->post('id');
        $user_id = $this->input->post('user_id');
        $qr = "SELECT RECEIPT_BARCODE_NO from lz_pos_repair_mt WHERE LZ_POS_REPAIRE_ID = '$ids'";
        $data = $this->db->query($qr)->result_array();
        if ($barcode == $data[0]['RECEIPT_BARCODE_NO']) {
            $qr = "SELECT REPAIRE_ID FROM LZ_POS_DET WHERE REPAIRE_ID = $ids AND DELETED_STATUS != 1";
            $result = $this->db->query($qr)->result_array();
            if (count($result) > 0) {
                return array("status" => false, "message" => "Repaire Invoice Is Not Deleted Successfully Because Use In POS");
            } else {
                $id = $this->db->query("SELECT LZ_POS_REPAIR_DET_ID FROM LZ_POS_REPAIR_DET WHERE LZ_POS_REPAIR_MT_ID =  '$ids'")->result_array();
                foreach ($id as $dt_id) {
                    $lz_pos_repair_det_id = $dt_id['LZ_POS_REPAIR_DET_ID'];
                    $this->db->query("UPDATE LZ_BARCODE_MT SET REPAIR_ID = null WHERE REPAIR_ID = '$lz_pos_repair_det_id'");
                }
                $qr = "UPDATE LZ_POS_REPAIR_MT SET DELETED_BY = '$user_id', DELETED_DATE = sysdate, DELETED_STATUS = 1 WHERE lz_pos_repaire_id = '$ids' ";
                $qrs = "UPDATE LZ_POS_REPAIR_DET SET DELETED_BY = '$user_id', DELETED_AT = sysdate, DELETED_STATUS = 1 WHERE lz_pos_repair_mt_id = '$ids'";
                $this->db->query($qrs);
                $result = $this->db->query($qr);
                if ($result === true) {
                    return array("status" => true, "message" => "Repaire Invoice Deleted Successfully");
                } else {
                    return array("status" => false, "message" => "Repaire Invoice  Is  Not Deleted Successfully");
                }
            }
        } else {
            $this->db->query("UPDATE LZ_BARCODE_MT SET REPAIR_ID = null WHERE REPAIR_ID = '$ids'");
            $qrs = "UPDATE LZ_POS_REPAIR_DET SET DELETED_BY = '$user_id', DELETED_AT = sysdate, DELETED_STATUS = 1 WHERE lz_pos_repair_mt_id = '$ids' and BARCODE_NO = '$barcode'";
            $result = $this->db->query($qrs);
            if ($result === true) {
                return array("status" => true, "message" => "Repaire Barcode Deleted Successfully");
            } else {
                return array("status" => false, "message" => "Repaire Barcode  Is  Not Deleted Successfully");
            }
        }
    }

    /********
     *
     *
     * Pos Receipt Detail
     *
     * */

    public function Get_Invoice_Receipt_Detail()
    {
        $lz_pos_repaire_id = $this->input->post('id');
        $qr = "SELECT PM.*, EM.USER_NAME, (SELECT (sum(PD.PRICE) - sum(PD.DISC_AMT)) TOTAL_COST
                from LZ_POS_DET PD
                WHERE PD.LZ_POS_MT_ID = ' $lz_pos_repaire_id') TOTAL_COST
                from  LJ_POS_RECEIPT_MT PM, EMPLOYEE_MT EM
                WHERE PM.POS_MT_ID = ' $lz_pos_repaire_id'  AND EM.EMPLOYEE_ID = PM.RECEIPT_BY";
        $data = $this->db->query($qr);
        if ($data->num_rows() > 0) {
            return array("status" => true, "data" => $data->result_array());
        } else {
            return array("status" => false, "message" => "No Record Found", "data" => array());
        }
    }

    public function Delete_Invoice_Receipt_Detail()
    {
        $receipt_id = $this->input->post('receipt_id');
        $data = $this->db->query("SELECT POS_MT_ID FROM LJ_POS_RECEIPT_MT WHERE RECEIPT_ID = '$receipt_id'")->result_array();
        $id = $data[0]['POS_MT_ID'];
        $qr = "DELETE FROM LJ_POS_RECEIPT_MT WHERE RECEIPT_ID  = '$receipt_id'";
        $result = $this->db->query($qr);
        if ($result == true) {
            return array("status" => true, "message" => "Record Updated Successfully");
        } else {
            return array("status" => false, "message" => "Record Is Not Deleted");
        }

    }

    public function Edit_Invocie_Receipt_Amount_Paid()
    {
        $receipt_id = $this->input->post('receipt_id');
        $amount = $this->input->post("amount");
        $qr = "UPDATE LJ_POS_RECEIPT_MT SET AMOUNT_PAID = '$amount' WHERE RECEIPT_ID = '$receipt_id'";
        $result = $this->db->query($qr);
        if ($result == true) {
            return array("status" => true, "message" => "Record Updated Successfully");
        } else {
            return array("status" => false, "message" => "Record Is Not Updated");
        }
    }

    public function Create_Charge_Stripe()
    {
        $token = $this->input->post("id");
        $amount = $this->input->post("amount");
        /******
         * str(int($amount)*100)
         * Convert Doller In Cents and Remove . from number
         *
         *  */
        try {

            $charge = \Stripe\Charge::create([
                'amount' => ($amount) * 100,
                'currency' => 'USD',
                'source' => $token,
                'receipt_email' => 'johnVik031@gmail.com',
            ]);
            return array("status" => true, "message" => $charge->status);
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network problem, perhaps try again.
            return array("status" => false, "message" => "Network problem");
            // echo "Network problem";
        } catch (\Stripe\Error\InvalidRequest $e) {
            // echo "You screwed up in your programming";
            $body = $e->getJsonBody();
            $err = $body['error']['message'];
            return array("status" => false, "message" => $err);
            // You screwed up in your programming. Shouldn't happen!
        } catch (\Stripe\Error\Api $e) {
            return array("status" => false, "message" => "Stripe's servers are down!");
            // echo "Stripe's servers are down!";
            // Stripe's servers are down!
        } catch (\Stripe\Error\Card $e) {
            return array("status" => false, "message" => "Ohhh SomeThing Happens!");

        }
        // var_dump($charge->status);
        // print_r($charge);
    }

    /**
     *
     * End POS
     * Assign Barcodes
     *
     *
     */

    public function Get_Employee_Names()
    {
        $data = $this->db->query("SELECT M.EMPLOYEE_ID,M.USER_NAME FROM EMPLOYEE_MT M WHERE M.LOCATION = 'PK' AND M.STATUS =1 ")->result_array();
        if (count($data) > 0) {
            return array("status" => true, "employee_name" => $data);
        }
    }

    public function Get_Unique_Count_Lot()
    {
        $this->session->unset_userdata('searchLots');
        $posts = $this->input->post('lot_posting');
        $rslt = $this->input->post('lot_date');
        $merch_id = $this->input->post('merch_id');
        if (!empty($merch_id)) {
            $merch_id = $merch_id['value'];
        }

        $this->session->set_userdata('searchLots', ['session_posting' => $posts, 'lotDateRange' => $rslt]);
        $lotData = $this->session->userdata('searchLots');

        $sql = "SELECT COUNT(*) UNIQ_ITEM FROM (SELECT M.FOLDER_NAME  /*(SELECT EE.USER_NAME FROM EMPLOYEE_MT EE WHERE EE.EMPLOYEE_ID = M.INSERTED_BY)USER_NAME_INS,O.OBJECT_NAME,DE.LOT_DESC L_DESC, B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME, E.USER_NAME, C.COND_NAME */FROM LZ_SPECIAL_LOTS M, LOT_DEFINATION_MT  DE, LZ_BD_OBJECTS_MT O, BIN_MT B, EMPLOYEE_MT  E, LZ_CATALOGUE_MT  P, LZ_ITEM_COND_MT C WHERE M.OBJECT_ID = O.OBJECT_ID(+) AND M.BIN_ID = B.BIN_ID(+) AND M.UPDATED_BY = E.EMPLOYEE_ID(+) AND M.CATALOG_MT_ID = P.CATALOGUE_MT_ID(+) AND M.LOT_ID = DE.LOT_ID(+) AND M.CONDITION_ID = C.ID(+) ";

        if ($lotData['session_posting'] == 1 || $posts == 1) { // for posting
            // $rs = explode('-', $rslt);
            $fromdate = $rslt[0];
            $todate = $rslt[1];
            /*===Convert Date in 24-Apr-2016===*/
            $fromdate = date_create($rslt[0]);
            $todate = date_create($rslt[1]);

            $from = date_format($fromdate, 'Y-m-d');
            $to = date_format($todate, 'Y-m-d');
            $date_qry = " AND M.CARD_MPN IS NOT NULL AND M.MPN_DESCRIPTION IS NOT NULL AND M.BRAND IS NOT NULL AND M.PIC_DATE_TIME IS NOT NULL AND M.LZ_MANIFEST_DET_ID IS NOT NULL AND M.INSERTED_AT BETWEEN TO_DATE('$from " . "00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to " . "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";
            if (!empty($merch_id)) {
                $date_qry .= "  AND M.BARCODE_PRV_NO IN (SELECT DET.BARCODE_NO FROM LZ_MERCHANT_BARCODE_MT MT,LZ_MERCHANT_BARCODE_DT DET WHERE MT.MT_ID = DET.MT_ID AND MT.MERCHANT_ID = $merch_id)";
            }
            $date_qry .= " group by folder_name ) ";
            $sql .= $date_qry;
        } elseif ($lotData['session_posting'] == 2 || $posts == 2) { /// for non posting
            // $rs = explode('-', $rslt);
            $fromdate = $rslt[0];
            $todate = $rslt[1];
            /*===Convert Date in 24-Apr-2016===*/
            $fromdate = date_create($rslt[0]);
            $todate = date_create($rslt[1]);
            $from = date_format($fromdate, 'Y-m-d');
            $to = date_format($todate, 'Y-m-d');
            $date_qry = " AND (M.CARD_MPN IS NULL OR M.MPN_DESCRIPTION IS NULL OR M.BRAND IS NULL)  AND M.INSERTED_AT BETWEEN TO_DATE('$from " . "00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to " . "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";
            if (!empty($merch_id)) {
                $date_qry .= "  AND M.BARCODE_PRV_NO IN (SELECT DET.BARCODE_NO FROM LZ_MERCHANT_BARCODE_MT MT,LZ_MERCHANT_BARCODE_DT DET WHERE MT.MT_ID = DET.MT_ID AND MT.MERCHANT_ID = $merch_id)";
            }
            $date_qry .= " group by folder_name ) ";
            $sql .= $date_qry;
        } elseif ($lotData['session_posting'] == 0 || $posts == 0) { //// for all
            // $rs = explode('-', $rslt);
            $fromdate = $rslt[0];
            $todate = $rslt[1];
            /*===Convert Date in 24-Apr-2016===*/
            $fromdate = date_create($rslt[0]);
            $todate = date_create($rslt[1]);

            $from = date_format($fromdate, 'Y-m-d');
            $to = date_format($todate, 'Y-m-d');
            $date_qry = "  AND M.INSERTED_AT BETWEEN TO_DATE('$from " . "00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to " . "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";
            if (!empty($merch_id)) {
                $date_qry .= "  AND M.BARCODE_PRV_NO IN (SELECT DET.BARCODE_NO FROM LZ_MERCHANT_BARCODE_MT MT,LZ_MERCHANT_BARCODE_DT DET WHERE MT.MT_ID = DET.MT_ID AND MT.MERCHANT_ID = $merch_id)";
            }
            $date_qry .= " group by folder_name ) ";
            $sql .= $date_qry;

        } elseif ($lotData['session_posting'] == 3 || $posts == 3) {
            // $rs = explode('-', $rslt);
            $fromdate = $rslt[0];
            $todate = $rslt[1];
            /*===Convert Date in 24-Apr-2016===*/
            $fromdate = date_create($rslt[0]);
            $todate = date_create($rslt[1]);
            $from = date_format($fromdate, 'Y-m-d');
            $to = date_format($todate, 'Y-m-d');
            $date_qry = " AND M.CARD_MPN IS NOT NULL AND M.MPN_DESCRIPTION IS NOT NULL AND M.BRAND IS NOT NULL AND M.PIC_DATE_TIME IS NOT NULL  AND M.LZ_MANIFEST_DET_ID IS NULL AND M.LZ_MANIFEST_DET_ID IS NULL AND M.INSERTED_AT BETWEEN TO_DATE('$from " . "00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to " . "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";
            if (!empty($merch_id)) {
                $date_qry .= "  AND M.BARCODE_PRV_NO IN (SELECT DET.BARCODE_NO FROM LZ_MERCHANT_BARCODE_MT MT,LZ_MERCHANT_BARCODE_DT DET WHERE MT.MT_ID = DET.MT_ID AND MT.MERCHANT_ID = $merch_id)";
            }
            $date_qry .= " group by folder_name ) ";
            $sql .= $date_qry;
        } else {
            $date_qry = "AND M.INSERTED_AT >= SYSDATE-1";
            $date_qry .= " group by folder_name ) ";
            $sql .= $date_qry;
        }

        $query_count = $this->db->query($sql)->result_array();

        return array('query_count' => $query_count);
    }

    public function Load_Special_Lots()
    {
        $posts = $this->input->post('lot_posting');
        $rslt = $this->input->post('lot_date');
        $start_date = $this->input->post('startDate');
        $end_date = $this->input->post('endDate');
        $filterData = $this->input->post('filterData');
        $merch_id = $this->input->post('merch_id');
        $fromdate = @$rslt[0];
        //     $todate = @$rslt[1];
        //     /*===Convert Date in 24-Apr-2016===*/
        $fromdate = date_create($rslt[0]);
        $todate = date_create($rslt[1]);

        $from = date_format($fromdate, 'Y-m-d');
        $to = date_format($todate, 'Y-m-d');
        if (!empty($merch_id)) {
            $merch_id = $merch_id['value'];
        }
        $get_emp = $this->input->post('get_emp');
        if (!empty($get_emp)) {
            $get_emp = $get_emp['value'];
        }
        $lot_posting_chek = $this->input->post('lot_posting_chek');

        $sql = "SELECT * FROM (SELECT 'DEKIT' DEKIT_ITEM, DC.BRAND, D.LZ_DEKIT_US_DT_ID PK_ID, D.BARCODE_PRV_NO, DECODE(DC.MPN_DESCRIPTION, NULL, D.MPN_DESCRIPTION, DC.MPN_DESCRIPTION) MPN_DESCRIPTION, DC.MPN MPN, DC.UPC, O.OBJECT_NAME, C.COND_NAME, C.ID CONDITION_ID, D.AVG_SELL_PRICE,  D.DEKIT_REMARKS REMARKS, /*D.IDENT_REMARKS REMARKS,*/ d.allocate_to assign_to, (SELECT USER_NAME FROM EMPLOYEE_MT WHERE EMPLOYEE_ID = d.ALLOCATE_TO) USER_NAME,    to_char(M.BARCODE_NO)  MAS_BAR,/* M.MASTER_MPN_ID, K.CATALOGUE_MT_ID,  K.MPN_DESCRIPTION,*/
        I.ITEM_DESC   mast_mpn_desc FROM LZ_DEKIT_US_DT   D, LZ_DEKIT_US_MT   M, LZ_BD_OBJECTS_MT O, LZ_ITEM_COND_MT  C, LZ_CATALOGUE_MT  K, LZ_BARCODE_MT    MB, ITEMS_MT         I, LZ_CATALOGUE_MT  DC WHERE D.OBJECT_ID = O.OBJECT_ID(+) AND D.CONDITION_ID = C.ID(+) AND M.MASTER_MPN_ID = K.CATALOGUE_MT_ID(+) AND D.LZ_DEKIT_US_MT_ID = M.LZ_DEKIT_US_MT_ID AND D.DISCARD = 0 AND D.PIC_DATE_TIME IS NOT NULL AND D.PIC_BY IS NOT NULL AND D.CATALOG_MT_ID = DC.CATALOGUE_MT_ID(+) AND D.LZ_MANIFEST_DET_ID IS NULL AND M.LZ_MANIFEST_MT_ID IS NOT NULL AND M.BARCODE_NO = MB.BARCODE_NO AND MB.ITEM_ID = I.ITEM_ID AND D.LZ_MANIFEST_DET_ID IS NULL AND D.PIC_DATE_TIME BETWEEN TO_DATE(' $start_date" . "00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE(' $end_date " . "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";

        if (!empty($get_emp)) {

            $sql .= " and d.allocate_to = $get_emp";
        }
        if (!empty($rslt)) {

        }
        $sql .= "UNION ALL";

        $sql .= " SELECT 'LOT' DEKIT_ITEM, DECODE(MT.BRAND, NULL, LL.BRAND, MT.BRAND) BARAND, LL.SPECIAL_LOT_ID PK_ID, LL.BARCODE_PRV_NO, DECODE(MT.MPN_DESCRIPTION, NULL, LL.MPN_DESCRIPTION, MT.MPN_DESCRIPTION) MPN_DESCRIPTION, DECODE(MT.MPN, NULL, LL.CARD_MPN, MT.MPN) MPN, DECODE(MT.UPC, NULL, LL.CARD_UPC, MT.UPC) UPC, OB.OBJECT_NAME, C.COND_NAME, C.ID CONDITION_ID, TO_NUMBER(LL.AVG_SOLD) AVG_SOLD, LL.LOT_REMARKS REMARKS, ll.allocate_to assign_to, (SELECT USER_NAME FROM EMPLOYEE_MT WHERE EMPLOYEE_ID = ll.ALLOCATE_TO) USER_NAME, '' MAS_BAR, '' mast_mpn_desc FROM LZ_SPECIAL_LOTS  LL, LZ_CATALOGUE_MT  MT, LZ_ITEM_COND_MT  C, LZ_BD_OBJECTS_MT OB WHERE LL.CATALOG_MT_ID = MT.CATALOGUE_MT_ID(+) AND LL.CONDITION_ID = C.ID(+) AND LL.OBJECT_ID = OB.OBJECT_ID(+) AND LL.PIC_DATE_TIME IS NOT NULL AND LL.PIC_BY IS NOT NULL AND LL.DISCARD = 0 AND LL.LZ_MANIFEST_DET_ID IS NULL AND LL.PIC_DATE_TIME BETWEEN TO_DATE(' $start_date " . "00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE(' $end_date " . "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";

        if (!empty($get_emp)) {

            $sql .= " and ll.allocate_to = '$get_emp'";
        }
        $sql .= "  )";
        if ($filterData == 0) {
            $sql .= " WHERE DEKIT_ITEM = 'DEKIT'";
        } else if ($filterData == 1) {
            $sql .= " WHERE DEKIT_ITEM = 'LOT'";
        }

        $idntiti_data = $this->db->query($sql)->result_array();

        if (count($idntiti_data) >= 1) {

            $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array();
            $uri = $this->get_barcode_pics($idntiti_data, $conditions);
            $images = $uri['uri'];
            // $data = $uri['data'];
            return array('data' => $idntiti_data, 'images' => $images, 'status' => true);
        } else {
            return array('data' => array(), 'status' => false, 'images' => array(), 'message' => ' No Record Found');
        }

        // $sql = "SELECT M.*, (SELECT EE.USER_NAME FROM EMPLOYEE_MT EE WHERE EE.EMPLOYEE_ID = M.INSERTED_BY)USER_NAME_INS,O.OBJECT_NAME,DE.LOT_DESC L_DESC, B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME, E.USER_NAME,C.COND_NAME, E1.USER_NAME ASSIGN_TO FROM LZ_SPECIAL_LOTS M,EMPLOYEE_MT e1, LOT_DEFINATION_MT  DE, LZ_BD_OBJECTS_MT O, BIN_MT B, EMPLOYEE_MT  E, LZ_CATALOGUE_MT  P, LZ_ITEM_COND_MT C WHERE M.OBJECT_ID = O.OBJECT_ID(+)  AND M.ALLOCATE_TO = E1.EMPLOYEE_ID(+) AND M.BIN_ID = B.BIN_ID(+) AND M.UPDATED_BY = E.EMPLOYEE_ID(+) AND M.CATALOG_MT_ID = P.CATALOGUE_MT_ID(+) AND M.LOT_ID = DE.LOT_ID(+) AND M.CONDITION_ID = C.ID(+) AND M.DISCARD <> 1 ";

        // if (!empty($get_emp)) {
        //     $sql .= "AND M.ALLOCATE_TO = '$get_emp '";
        // }

        // if ($posts == 1) { // for posting

        //     $fromdate = @$rslt[0];
        //     $todate = @$rslt[1];
        //     /*===Convert Date in 24-Apr-2016===*/
        //     $fromdate = date_create($rslt[0]);
        //     $todate = date_create($rslt[1]);

        //     $from = date_format($fromdate, 'Y-m-d');
        //     $to = date_format($todate, 'Y-m-d');
        //     $date_qry = " AND M.CARD_MPN IS NOT NULL AND M.MPN_DESCRIPTION IS NOT NULL AND M.BRAND IS NOT NULL AND M.PIC_DATE_TIME IS NOT NULL AND M.LZ_MANIFEST_DET_ID IS NOT NULL AND M.INSERTED_AT BETWEEN TO_DATE('$from " . "00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to " . "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";

        //     if (!empty($lot_posting_chek)) {
        //         $date_qry .= "AND M.SPECIAL_LOT_ID  IN (SELECT MAX(L.SPECIAL_LOT_ID) SPECIAL_LOT_ID FROM LZ_SPECIAL_LOTS L GROUP BY L.FOLDER_NAME)";
        //     }
        //     if (!empty($merch_id)) {
        //         $date_qry .= "  AND M.BARCODE_PRV_NO IN (SELECT DET.BARCODE_NO FROM LZ_MERCHANT_BARCODE_MT MT,LZ_MERCHANT_BARCODE_DT DET WHERE MT.MT_ID = DET.MT_ID AND MT.MERCHANT_ID = $merch_id)";
        //     }

        //     $sql .= $date_qry;
        // } elseif ($posts == 2) { /// for non posting
        //     $fromdate = $rslt[0];
        //     $todate = $rslt[1];
        //     /*===Convert Date in 24-Apr-2016===*/
        //     $fromdate = date_create($rslt[0]);
        //     $todate = date_create($rslt[1]);
        //     $from = date_format($fromdate, 'Y-m-d');
        //     $to = date_format($todate, 'Y-m-d');
        //     $date_qry = " AND (M.CARD_MPN IS NULL OR M.MPN_DESCRIPTION IS NULL OR M.BRAND IS NULL)  AND M.INSERTED_AT BETWEEN TO_DATE('$from " . "00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to " . "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";
        //     if (!empty($lot_posting_chek)) {
        //         $date_qry .= "AND M.SPECIAL_LOT_ID  IN (SELECT MAX(L.SPECIAL_LOT_ID) SPECIAL_LOT_ID FROM LZ_SPECIAL_LOTS L GROUP BY L.FOLDER_NAME)";
        //     }
        //     if (!empty($merch_id)) {
        //         $date_qry .= "  AND M.BARCODE_PRV_NO IN (SELECT DET.BARCODE_NO FROM LZ_MERCHANT_BARCODE_MT MT,LZ_MERCHANT_BARCODE_DT DET WHERE MT.MT_ID = DET.MT_ID AND MT.MERCHANT_ID = $merch_id)";
        //     }
        //     $sql .= $date_qry;
        // } elseif ($posts == 0) { //// for all
        //     $fromdate = $rslt[0];
        //     $todate = $rslt[1];
        //     /*===Convert Date in 24-Apr-2016===*/
        //     $fromdate = date_create($rslt[0]);
        //     $todate = date_create($rslt[1]);

        //     $from = date_format($fromdate, 'Y-m-d');
        //     $to = date_format($todate, 'Y-m-d');
        //     $date_qry = "  AND M.INSERTED_AT BETWEEN TO_DATE('$from " . "00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to " . "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";
        //     if (!empty($lot_posting_chek)) {
        //         $date_qry .= "AND M.SPECIAL_LOT_ID  IN (SELECT MAX(L.SPECIAL_LOT_ID) SPECIAL_LOT_ID FROM LZ_SPECIAL_LOTS L GROUP BY L.FOLDER_NAME)";
        //     }
        //     if (!empty($merch_id)) {
        //         $date_qry .= "  AND M.BARCODE_PRV_NO IN (SELECT DET.BARCODE_NO FROM LZ_MERCHANT_BARCODE_MT MT,LZ_MERCHANT_BARCODE_DT DET WHERE MT.MT_ID = DET.MT_ID AND MT.MERCHANT_ID = $merch_id)";
        //     }
        //     $sql .= $date_qry;

        // } elseif ($posts == 3) {
        //     $fromdate = $rslt[0];
        //     $todate = $rslt[1];
        //     /*===Convert Date in 24-Apr-2016===*/
        //     $fromdate = date_create($rslt[0]);
        //     $todate = date_create($rslt[1]);
        //     $from = date_format($fromdate, 'Y-m-d');
        //     $to = date_format($todate, 'Y-m-d');
        //     $date_qry = " AND M.CARD_MPN IS NOT NULL AND M.MPN_DESCRIPTION IS NOT NULL AND M.BRAND IS NOT NULL AND M.PIC_DATE_TIME IS NOT NULL  AND M.LZ_MANIFEST_DET_ID IS NULL AND M.LZ_MANIFEST_DET_ID IS NULL AND M.INSERTED_AT BETWEEN TO_DATE('$from " . "00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to " . "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";
        //     if (!empty($lot_posting_chek)) {
        //         $date_qry .= "AND M.SPECIAL_LOT_ID  IN (SELECT MAX(L.SPECIAL_LOT_ID) SPECIAL_LOT_ID FROM LZ_SPECIAL_LOTS L GROUP BY L.FOLDER_NAME)";
        //     }

        //     if (!empty($merch_id)) {
        //         $date_qry .= "  AND M.BARCODE_PRV_NO IN (SELECT DET.BARCODE_NO FROM LZ_MERCHANT_BARCODE_MT MT,LZ_MERCHANT_BARCODE_DT DET WHERE MT.MT_ID = DET.MT_ID AND MT.MERCHANT_ID = $merch_id)";
        //     }
        //     $sql .= $date_qry;
        // } else {
        //     $date_qry = "AND M.INSERTED_AT >= SYSDATE-1";
        //     $sql .= $date_qry;
        // }
        // // if (!empty($requestData['search']['value'])) {
        // //     // if there is a search parameter, $requestData['search']['value'] contains search parameter
        // //     $perm = trim(strtoupper($requestData['search']['value']));
        // //     $sql .= " AND (M.SPECIAL_LOT_ID LIKE '%" . $perm . "%'";
        // //     $sql .= " OR M.BARCODE_PRV_NO LIKE '%" . $perm . "%'";
        // //     $sql .= " OR UPPER(E1.USER_NAME) LIKE '%" . $perm . "%'";
        // //     $sql .= " OR M.CARD_UPC LIKE '%" . $perm . "%'";
        // //     $sql .= " OR UPPER(M.CARD_MPN) LIKE '%" . $perm . "%'";
        // //     $sql .= " OR UPPER(M.MPN_DESCRIPTION) LIKE '%" . $perm . "%'";
        // //     $sql .= " OR M.CONDITION_ID LIKE '%" . $perm . "%'";
        // //     $sql .= " OR UPPER(M.BRAND) LIKE '%" . $perm . "%'";
        // //     $sql .= " OR UPPER(M.LOT_REMARKS) LIKE '%" . $perm . "%'";
        // //     $sql .= " OR UPPER(M.PIC_NOTES) LIKE '%" . $perm . "%'";
        // //     $sql .= " OR M.INSERTED_AT LIKE '%" . $perm . "%'";
        // //     $sql .= " OR M.INSERTED_BY LIKE '%" . $perm . "%'";
        // //     $sql .= " OR M.UPDATED_AT LIKE '%" . $perm . "%'";
        // //     $sql .= " OR M.UPDATED_BY LIKE '%" . $perm . "%'";
        // //     $sql .= " OR UPPER(DE.LOT_DESC) LIKE '%" . $perm . "%'";
        // //     $sql .= " OR UPPER(B.BIN_TYPE || '-' || B.BIN_NO) LIKE '%" . $perm . "%')";
        // // }
        // // if (!empty($columns[$requestData['order'][0]['column']])) {
        // //     $sql .= " ORDER BY  " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'];
        // // } else {
        // //     $sql .= " ORDER BY E1.USER_NAME DESC";
        // //     //$sql .= " ORDER BY M.SPECIAL_LOT_ID DESC";
        // // }

        //$query = $this->db->query($sql);

        // $totalData = $query->num_rows();
        // $totalFiltered = $totalData;

        // $sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($sql) q )";
        // $sql .= "WHERE   ROWNUM <= " . $requestData['length'] . " AND rn>= " . $requestData['start'];

        // /*=====  End of For Oracle 12-c  ======*/
        // $query = $this->db->query($sql);

        // return $query;
        //////////////////////////////
        //                            //
        //////////////////////////////

    }

    public function Combine_Pices_Specific_Barcode()
    {

        $combin_pics = $this->input->post('special_lot_barcodes');
        $copy_this_pic = $this->input->post('get_barcode');

        // $cond_exp = '';
        // $i = 0;
        foreach ($combin_pics as $comb_barc) {
            // if (!empty($combin_pics[$i + 1])) {
            //     $cond_exp = $cond_exp . $comb_barc['BARCODE_PRV_NO'] . ',';

            // } else {
            //     $cond_exp = $cond_exp . $comb_barc;
            // }
            // $i++;
            $barcode = $comb_barc['BARCODE_PRV_NO'];
            $name = ($comb_barc['DEKIT_ITEM']);
            if ($name == 'DEKIT') {
                $query = $this->db->query("UPDATE LZ_DEKIT_US_DT  L SET L.FOLDER_NAME = '$copy_this_pic' WHERE L.BARCODE_PRV_NO IN ($barcode)");
            } else {
                $query = $this->db->query("UPDATE LZ_SPECIAL_LOTS J SET J.FOLDER_NAME = '$copy_this_pic' WHERE J.BARCODE_PRV_NO IN ($barcode)");
            }

        }

        // $query = $this->db->query("UPDATE LZ_SPECIAL_LOTS J SET J.FOLDER_NAME = '$copy_this_pic' WHERE J.BARCODE_PRV_NO IN ($cond_exp)");

        if ($query) {

            return array("status" => true, "message" => "All Images Assign To This . $copy_this_pic . Barcode");
        } else {
            return array("status" => false, "message" => "All Images Not Assign To This . $copy_this_pic . Barcode");
        }

    }

    public function Assign_Barcode_Specific_Emp()
    {

        date_default_timezone_set("America/Chicago");
        $list_date = date("Y-m-d H:i:s");
        $alloc_date = "TO_DATE('" . $list_date . "', 'YYYY-MM-DD HH24:MI:SS')";

        $allocated_by = $this->input->post('user_id');
        $remarks = '';
        $seed_id = $this->input->post('toggle_barcodes');
        $assign_to = $this->input->post('get_emp'); //assign to person
        $assign_too = $assign_to['value'];
        $name = $assign_to['label'];

        $comma = ",";

        foreach ($seed_id as $data) {

            // $query = $this->db->query("SELECT get_single_primary_key('LZ_LISTING_ALLOC','ALLOC_ID') ALLOC_ID FROM DUAL");
            // $rs = $query->result_array();
            // $alloc_id = $rs[0]['ALLOC_ID'];
            $barcode = $data['BARCODE_PRV_NO'];
            $name = ($data['DEKIT_ITEM']);
            if ($name == 'DEKIT') {
                $query = $this->db->query("UPDATE LZ_DEKIT_US_DT  L SET L.ALLOCATE_TO = '$assign_too' ,ALLOCATE_DATE =$alloc_date ,ALLOCATE_BY ='$allocated_by' WHERE L.BARCODE_PRV_NO = '$barcode' ");
            } else {
                $query = $this->db->query("UPDATE LZ_SPECIAL_LOTS  L SET L.ALLOCATE_TO = '$assign_too' ,ALLOC_DATE =$alloc_date ,ALLOCATED_BY ='$allocated_by' WHERE L.BARCODE_PRV_NO = '$barcode' ");
            }
        }

        if ($query) {
            return array("status" => true, "message" => "All Images Assign To This . $name . Employee");
        } else {
            return array("status" => false, "message" => "All Images Not Assign To This . $name . Employee");
        }

        //var_dump($user_name, $seed_id);exit;
    }

    /**
     *
     *
     * Get Invoice Orders
     *
     */

    public function Get_Order_Data()
    {
        $order_id = $this->input->post('order_id');
        $merchant_id = $this->input->post('merchant_id');
        if (!empty($merchant_id) && !empty($order_id)) {
            $merchant_id = $merchant_id['value'];
            $qr = "SELECT   op.*, em.user_name, DECODE(op.verify, 0, 'Un Verified', 1, 'Verified') STATUS FROM LJ_ORDER_PACKING_MT op, employee_mt em   WHERE op.ORDER_ID = '$order_id' AND op.MERCHANT_ID = '$merchant_id'  AND em.employee_id(+) = op.verified_by";
            $result = $this->db->query($qr);
            $qry = "SELECT b.*,em.user_name, DECODE(op.verify, 0, 'Un Verified', 1, 'Verified') STATUS
            FROM lz_barcode_mt b, lj_order_packing_mt op, employee_mt em
           WHERE b.ORDER_ID = '$order_id'
           AND em.employee_id(+) = op.verified_by
             AND op.order_id = b.order_id";

            $results = $this->db->query($qry);
            if ($result->num_rows() > 0) {
                return array("status" => true, "data" => $result->result_array(), "barcode" => $results->result_array());
            } else {
                return array("status" => false, "message" => "No Record Found Aganist This Order and Merchant");
            }
        } else if (!empty($merchant_id)) {
            $merchant_id = $merchant_id['value'];
            $qr = "SELECT  op.*,em.user_name,  DECODE(op.verify, 0, 'Un Verified', 1, 'Verified') STATUS FROM LJ_ORDER_PACKING_MT op, employee_mt em  WHERE op.MERCHANT_ID = '$merchant_id'  AND em.employee_id(+) = op.verified_by";
            $result = $this->db->query($qr);
            if ($result->num_rows() > 0) {
                return array("status" => true, "data" => $result->result_array(), "barcode" => array());
            } else {
                return array("status" => false, "message" => "No Record Found Aganist This Merchant");
            }
        } else if (!empty($order_id)) {
            $qr = "SELECT op.*, em.user_name, DECODE(op.verify, 0, 'Un Verified', 1, 'Verified') STATUS FROM LJ_ORDER_PACKING_MT op, employee_mt em   WHERE op.ORDER_ID = '$order_id' AND em.employee_id(+) = op.verified_by";
            $result = $this->db->query($qr);
            $qry = "SELECT b.*,em.user_name, DECODE(op.verify, 0, 'Un Verified', 1, 'Verified') STATUS
            FROM lz_barcode_mt b, lj_order_packing_mt op, employee_mt em
           WHERE b.ORDER_ID = '$order_id'
           AND em.employee_id(+) = op.verified_by
             AND op.order_id = b.order_id";

            $results = $this->db->query($qry);
            if ($result->num_rows() > 0) {
                return array("status" => true, "data" => $result->result_array(), "barcode" => $results->result_array());
            } else {
                return array("status" => false, "message" => "No Record Found Aganist This Order");
            }
        } else {
            $qr = "SELECT op.*, em.user_name, DECODE(op.verify, 0, 'Un Verified', 1, 'Verified') STATUS  FROM LZ_BARCODE_MT b, LJ_ORDER_PACKING_MT op, employee_mt em
            WHERE op.order_id = b.order_id
            AND em.employee_id(+) = op.verified_by
            AND op.CHECKOUT_DATE BETWEEN sysdate AND  sysdate -2 ";
            $result = $this->db->query($qr);
            if ($result->num_rows() > 0) {
                return array("status" => true, "data" => $result->result_array());
            } else {
                return array("status" => false, "message" => "No Record Found Aganist  Last Two Days");
            }
        }

    }

    public function Get_Order_Id_Barcode()
    {
        $order_id = $this->input->post("order_id");
        // $qr = "SELECT * FROM LZ_BARCODE_MT WHERE ORDER_ID = '$order_id'";
        $qr = "SELECT b.*, em.user_name, DECODE(op.verify, 0, 'Un Verified', 1, 'Verified') STATUS
            FROM lz_barcode_mt b, lj_order_packing_mt op, employee_mt em
           WHERE b.ORDER_ID = '$order_id'
           AND em.employee_id(+) = op.verified_by
             AND op.order_id = b.order_id";

        $result = $this->db->query($qr);
        if ($result->num_rows() > 0) {
            return array("status" => true, "data" => $result->result_array());
        } else {
            return array("status" => false, "message" => "No Record Found Aganist This Order");
        }
    }

    public function Verified_All_Barcode()
    {
        $data = $this->input->post('data');
        $order_id = $data[0]['ORDER_ID'];
        $user_id = $this->input->post('user_id');
        $qry = "SELECT USER_NAME FROM EMPLOYEE_MT WHERE employee_id = '$user_id'";
        $data = $this->db->query($qry);
        $qr = "UPDATE LJ_ORDER_PACKING_MT SET VERIFY = 1, VERIFIED_BY = '$user_id' , VERIFIED_AT = sysdate WHERE ORDER_ID = '$order_id'";
        $result = $this->db->query($qr);
        if ($result) {
            return array("status" => true, "message" => "Record Verified Successfully", 'data' => $data->result_array());
        } else {
            return array("status" => false, "message" => "Query Error");
        }
    }

    public function Un_Verified_All_Barcode()
    {
        $data = $this->input->post('data');
        $order_id = $data[0]['ORDER_ID'];
        $user_id = $this->input->post('user_id');
        $qry = "SELECT USER_NAME FROM EMPLOYEE_MT WHERE employee_id = '$user_id'";
        $data = $this->db->query($qry);
        $qr = "UPDATE LJ_ORDER_PACKING_MT SET VERIFY = 0, VERIFIED_BY = '$user_id' , VERIFIED_AT = sysdate  WHERE ORDER_ID = '$order_id'";
        $result = $this->db->query($qr);
        if ($result) {
            return array("status" => true, "message" => "Record Un Verified Successfully", 'data' => $data->result_array());
        } else {
            return array("status" => false, "message" => "Query Error");
        }
    }
    /*****
     *
     * Adil Bhai Verify Barcode Screen
     *
     */
    public function Get_Item_Sold_Price_Verify_Screen()
    {

        $UPC = $this->input->post('UPC');
        $TITLE = $this->input->post('TITLE');
        $TITLE = trim(str_replace("  ", ' ', $TITLE));
        $TITLE = trim(str_replace(array("'"), "''", $TITLE));
        $MPN = $this->input->post('MPN');
        $MPN = trim(str_replace("  ", ' ', $MPN));
        $MPN = trim(str_replace(array("'"), "''", $MPN));
        $CATEGORY = $this->input->post('CATEGORY');
        $CATEGORY = trim(str_replace("  ", ' ', $CATEGORY));
        $CATEGORY = trim(str_replace(array("'"), "''", $CATEGORY));
        $CONDITION = $this->input->post('CONDITION');

        if (!empty($UPC) && strtoupper($UPC) != "DOES NOT APPLY") {
            $data['key'] = $UPC;
        } elseif (!empty($MPN && strtoupper($MPN) != "DOES NOT APPLY")) {
            $data['key'] = $MPN;
        } elseif (!empty($TITLE)) {
            $data['key'] = $TITLE;
        }
        $data['condition'] = $CONDITION;
        $data['category'] = $CATEGORY;
        $data['multicond'] = true;
        $data['result'] = $this->load->view('API/get_item_sold_price', $data);
        return $data['result'];
    }

    public function Suggest_Price_Verify_Screen()
    {

        $UPC = $this->input->post('UPC');
        $TITLE = $this->input->post('TITLE');
        $TITLE = trim(str_replace("  ", ' ', $TITLE));
        $TITLE = trim(str_replace(array("'"), "''", $TITLE));
        $MPN = $this->input->post('MPN');
        $MPN = trim(str_replace("  ", ' ', $MPN));
        $MPN = trim(str_replace(array("'"), "''", $MPN));
        $CATEGORY = $this->input->post('CATEGORY');
        $CATEGORY = trim(str_replace("  ", ' ', $CATEGORY));
        $CATEGORY = trim(str_replace(array("'"), "''", $CATEGORY));
        $CONDITION = $this->input->post('CONDITION');

        if (!empty($UPC) && strtoupper($UPC) != "DOES NOT APPLY") {
            $data['key'] = $UPC;
        } elseif (!empty($MPN && strtoupper($MPN) != "DOES NOT APPLY")) {
            $data['key'] = $MPN;
        } elseif (!empty($TITLE)) {
            $data['key'] = $TITLE;
        }
        $data['condition'] = $CONDITION;
        $data['category'] = $CATEGORY;
        $data['result'] = $this->load->view('API/suggest_price', $data);
        return $data['result'];
    }

    public function Search_Active_Listing_Verify_Screen()
    {

        $UPC = $this->input->post('UPC');
        $TITLE = $this->input->post('TITLE');
        $TITLE = trim(str_replace("  ", ' ', $TITLE));
        $TITLE = trim(str_replace(array("'"), "''", $TITLE));
        $MPN = $this->input->post('MPN');
        $MPN = trim(str_replace("  ", ' ', $MPN));
        $MPN = trim(str_replace(array("'"), "''", $MPN));
        $CATEGORY = $this->input->post('CATEGORY');
        $CATEGORY = trim(str_replace("  ", ' ', $CATEGORY));
        $CATEGORY = trim(str_replace(array("'"), "''", $CATEGORY));
        $CONDITION = $this->input->post('CONDITION');

        if (!empty($UPC) && strtoupper($UPC) != "DOES NOT APPLY") {
            $data['key'] = $UPC;
        } elseif (!empty($MPN && strtoupper($MPN) != "DOES NOT APPLY")) {
            $data['key'] = $MPN;
        } elseif (!empty($TITLE)) {
            $data['key'] = $TITLE;
        }
        $data['condition'] = $CONDITION;
        $data['category'] = $CATEGORY;
        $data['sellers'] = $this->db->query("SELECT DISTINCT ACCOUNT_NAME FROM LJ_MERHCANT_ACC_DT")->result_array();
        $data['result'] = $this->load->view('API/searchActiveListing', $data);
        return $data['result'];
    }

    public function Suggest_Categories_Verify_Screen()
    {

        $UPC = $this->input->post('UPC');
        $TITLE = $this->input->post('TITLE');
        $TITLE = trim(str_replace("  ", ' ', $TITLE));
        $TITLE = trim(str_replace(array("'"), "''", $TITLE));
        $MPN = $this->input->post('MPN');
        $MPN = trim(str_replace("  ", ' ', $MPN));
        $MPN = trim(str_replace(array("'"), "''", $MPN));
        if (!empty($UPC) && strtoupper($UPC) != "DOES NOT APPLY") {
            $data['key'] = $UPC;
        } elseif (!empty($MPN) && strtoupper($MPN) != "DOES NOT APPLY") {
            $data['key'] = $MPN;
        } elseif (!empty($TITLE)) {
            $data['key'] = $TITLE;
        }
        $data['result'] = $this->load->view('API/SuggestCategories', $data);
        return $data['result'];
    }

    public function Selected_Values()
    {
        $specific_barcode = ucfirst($this->input->post('specific_barcode'));
        $spec_barcode = trim(str_replace("  ", ' ', $specific_barcode));
        $spec_barcode = trim(str_replace(array("'"), "''", $spec_barcode));

        $item_qry = $this->db->query("SELECT M.ITEM_ID,M.LZ_MANIFEST_ID FROM LZ_BARCODE_MT M WHERE M.BARCODE_NO=$spec_barcode");
        $item_det = $item_qry->result_array();

        if ($item_qry->num_rows() > 0) {
            $item_det = $this->db->query("SELECT B.UNIT_NO,B.BARCODE_NO IT_BARCODE,V.ITEM_CONDITION,V.ITEM_MT_DESC,V.MANUFACTURER,V.MFG_PART_NO,V.UPC,V.AVAIL_QTY,V.ITEM_ID,V.LZ_MANIFEST_ID,V.PURCH_REF_NO FROM LZ_BARCODE_MT B, VIEW_LZ_LISTING_REVISED V WHERE B.ITEM_ID = V.ITEM_ID AND B.LZ_MANIFEST_ID = V.LZ_MANIFEST_ID AND B.LZ_MANIFEST_ID=" . $item_det[0]['LZ_MANIFEST_ID'] . " AND B.ITEM_ID = " . $item_det[0]['ITEM_ID'] . " ORDER BY B.UNIT_NO");
            $item_det = $item_det->result_array();
        }

        $cat_id = $this->db->query("SELECT DISTINCT DT.E_BAY_CATA_ID_SEG6,DT.BRAND_SEG3 FROM LZ_MANIFEST_DET DT WHERE DT.LAPTOP_ITEM_CODE = (SELECT V.LAPTOP_ITEM_CODE FROM VIEW_LZ_LISTING_REVISED V WHERE V.LZ_MANIFEST_ID = " . $item_det[0]['LZ_MANIFEST_ID'] . " AND V.ITEM_ID = " . $item_det[0]['ITEM_ID'] . " AND ROWNUM = 1) AND DT.E_BAY_CATA_ID_SEG6 NOT IN ('N/A', 'Other', 'OTHER', 'other')");

        $cat_id = $cat_id->result_array();
        //var_dump($cat_id);exit;

        if (!empty($cat_id[0]['E_BAY_CATA_ID_SEG6'])) {
            $mt_id = $this->db->query("SELECT * FROM CATEGORY_SPECIFIC_MT T WHERE T.EBAY_CATEGORY_ID = (SELECT DISTINCT DT.E_BAY_CATA_ID_SEG6 FROM LZ_MANIFEST_DET DT WHERE DT.LAPTOP_ITEM_CODE = (SELECT dt.laptop_item_code FROM lz_manifest_det dt WHERE dt.LZ_MANIFEST_ID = " . $item_det[0]['LZ_MANIFEST_ID'] . " AND dt.laptop_item_code = (select item_code from items_mt where item_id = " . $item_det[0]['ITEM_ID'] . ") AND ROWNUM = 1) AND DT.E_BAY_CATA_ID_SEG6 NOT IN ('N/A', 'Other', 'OTHER', 'other')  AND ROWNUM = 1) ORDER BY T.SPECIFIC_NAME");
            $mt_id = $mt_id->result_array();
            $specs_value = "SELECT MT.SPECIFICS_NAME, DT.SPECIFICS_VALUE,CM.MT_ID FROM LZ_ITEM_SPECIFICS_MT MT, LZ_ITEM_SPECIFICS_DET DT,category_specific_mt cm WHERE MT.SPECIFICS_MT_ID = DT.SPECIFICS_MT_ID and upper(cm.specific_name) = upper(mt.specifics_name) and cm.ebay_category_id = mt.category_id AND MT.ITEM_ID = " . $item_det[0]['ITEM_ID'] . "AND MT.CATEGORY_ID = " . $mt_id[0]['EBAY_CATEGORY_ID'] . "  ORDER BY MT.SPECIFICS_NAME";
            $specs_value = $this->db->query($specs_value);
            $specs_value = $specs_value->result_array();

            return array('result' => $specs_value, 'flag' => 1);
        } else {
            return array('result' => $specs_value, 'flag' => 0);
        }

    }

    public function get_barcode_pics($barcodes, $conditions)
    {

        $path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 2");
        $path = $path->result_array();

        $master_path = $path[0]["MASTER_PATH"];
        $uri = array();
        $base_url = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        foreach ($barcodes as $barcode) {

            $bar = $barcode['BARCODE_PRV_NO'];
            $type = $barcode['DEKIT_ITEM'];

            if (!empty($bar)) {

                if ($type == 'LOT') {
                    $getFolder = $this->db->query("SELECT LOT.FOLDER_NAME FROM LZ_SPECIAL_LOTS LOT WHERE lot.barcode_prv_no = '$bar' and rownum <= 1  ")->result_array();

                } elseif ($type == 'DEKIT') {
                    $getFolder = $this->db->query("SELECT LOT.FOLDER_NAME FROM LZ_DEKIT_US_DT LOT WHERE lot.barcode_prv_no = '$bar' and rownum <= 1  ")->result_array();

                }

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
                        // $barcode['IMAGE_PATH'] = $base_url . $withoutMasterPartUri;
                        // if($uri[$barcode['LZ_barcode_ID']]){
                        //     break;
                        // }

                        $j++;
                    }
                } else {
                    // $barcode['IMAGE_PATH'] = $base_url . "item_pictures/master_pictures/image_not_available.jpg";
                    $uri[$bar][0] = $base_url . "item_pictures/master_pictures/image_not_available.jpg";
                    $uri[$bar][1] = false;
                }
            } else {
                // $barcode['IMAGE_PATH'] = $base_url . "item_pictures/master_pictures/image_not_available.jpg";

                $uri[$bar][0] = $base_url . "item_pictures/master_pictures/image_not_available.jpg";
                $uri[$bar][1] = false;
            }
            // $data[] = $barcode;
        }
        // return array('data' => $data);
        return array('uri' => $uri);

    }

    public function Update_Image()
    {
        $master_reorder = $this->input->post('master_reorder');
        // var_dump($master_reorder);
        // exit;
        $barcode = $this->input->post('barcode');
        // $upc = $this->input->post('upc');
        // $mpn = $this->input->post('part_no');

        //      $it_condition = $this->input->post('it_condition');
        // if(is_numeric($it_condition)){
        //         if($it_condition == 3000){
        //             $it_condition = 'Used';
        //         }elseif($it_condition == 1000){
        //              $it_condition = 'New';
        //         }elseif($it_condition == 1500){
        //              $it_condition = 'New other';
        //         }elseif($it_condition == 2000){
        //               $it_condition = 'Manufacturer refurbished';
        //         }elseif($it_condition == 2500){
        //              $it_condition = 'Seller refurbished';
        //         }elseif($it_condition == 7000){
        //              $it_condition = 'For parts or not working';
        //         }else{
        //             $it_condition = 'Used';
        //         }
        //     }else{// end main if
        //         $it_condition  = ucfirst($it_condition);
        //     }
        //var_dump($upc."_".$part_no."_".$it_condition);exit;

        $query = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 2");
        $master_qry = $query->result_array();
        $master_path = $master_qry[0]['MASTER_PATH'];
        $dir = $master_path . $barcode . '/thumb'; //
        $dir2 = $master_path . $barcode;
        // $img_order = '';
        // var_dump($dir);exit;

        // Open a directory, and read its contents
        if (is_dir($dir)) {

            if ($dh = opendir($dir)) {
                $azRange = range('A', 'Z');
                $i = 0;
                // var_dump('reached');exit;
                while (($file = readdir($dh)) !== false) {
                    // var_dump($file);exit;
                    $parts = explode(".", $file);
                    if (is_array($parts) && count($parts) > 1) {
                        $extension = end($parts);
                        // var_dump($extension);
                        if (!empty($extension)) {

                            $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
                            $img_name = '';
                            $max = strlen($characters) - 1;
                            for ($k = 0; $k < 10; $k++) {
                                // var_dump('reached');exit;
                                $img_name .= $characters[mt_rand(0, $max)];
                                // var_dump($img_name);

                            }
                            // exit;
                            // var_dump(explode("\\", $master_reorder[0]['image']));
                            // var_dump($dir . "/" . $master_reorder[$i]['image']);
                            // var_dump($dir . "/" . $master_reorder[0]['image']);
                            $master_reorders = str_replace("\\", "*&", $master_reorder[$i]['image']);
                            $master_reorders = explode("*&", $master_reorders);
                            //var_dump($master_reorders);
                            @$img_order = rename($dir . "/" . $master_reorders[1], $dir . "/" . $azRange[$i] . "_" . $img_name . "." . $extension);
                            @$img_order2 = rename($dir2 . "/" . $master_reorders[1], $dir2 . "/" . $azRange[$i] . "_" . $img_name . "." . $extension);
                            // var_dump(rename($dir . "/" . $master_reorders[1], $dir . "/" . $azRange[$i] . "_" . $img_name . "." . $extension));
                            // var_dump($img_order2);
                            // exit;
                            $str = preg_replace('/[^A-Za-z0-9\. -]/', '', $parts[0]);
                            $new_string = substr($str, 0, 1) . "_" . substr($str, 1, strlen($str) - 1);

                            //    \Cloudinary\Uploader::destroy($barcode.'/'.$new_string, array( "invalidate" => TRUE));
                            //    \Cloudinary\Uploader::destroy($barcode.'/thumb/'.$new_string, array( "invalidate" => TRUE));

                            //    \Cloudinary\Uploader::upload($dir."/".$azRange[$i]."_".$img_name.".".$extension, array("folder"=>"$barcode","use_filename" => true, "unique_filename" => false));
                            //    \Cloudinary\Uploader::upload($dir2."/".$azRange[$i]."_".$img_name.".".$extension, array("folder"=>"$barcode"."/thumb/","use_filename" => true, "unique_filename" => false));

                            $i++;
                        }
                    }

                } //exit;//end while
                closedir($dh);

            } // sub if
        } //main if

        if (@$img_order) {
            return $data = true;
            //   echo json_encode($data);
            //   return json_encode($data);
        } else {
            $data = false;
            return $data;
            //   echo json_encode($data);
            //   return json_encode($data);
        }

    }
    public function Delete_Image()
    {
        $images = $this->input->post('images');
        foreach ($images as $image) {
            $base_url = 'http://' . $_SERVER['HTTP_HOST'] . '/';
            $withoutbaseUrl = str_replace($base_url, "", $image);
            $imagePath = "D:/wamp/www/" . $withoutbaseUrl;
            $folderPath = str_replace("\\", "*&", $imagePath);
            $folderPath = explode("*&", $folderPath);
            // var_dump($master_reorders);

            // var_dump($imagePath);
            if (file_exists($imagePath)) {
                $delete = unlink($imagePath);
                $thumbDelete = unlink($folderPath[0] . 'thumb/' . $folderPath[1]);
            }
        }
        if ($delete == true) {
            return array('status' => true);
        } else {
            return array('status' => false);
        }

    }

    public function Update_Seed_Remarks()
    {
        $remarks = $this->input->post('remarks');
        $item_type = $this->input->post('item_type');
        $barcode = $this->input->post('barcode');
        if ($item_type == 'DEKIT ITEM') {
            $qr = $this->db->query("UPDATE lz_dekit_us_dt SET DEKIT_REMARKS = '$remarks' WHERE BARCODE_PRV_NO = '$barcode'");
        } else if ($item_type == 'SPECIAL LOT') {
            $qr = $this->db->query("UPDATE lz_special_lots SET LOT_REMARKS = '$remarks' WHERE BARCODE_PRV_NO = '$barcode'");
        }
        if ($qr == true) {
            return array("status" => true, 'message' => "Remarks Updated Successfully");
        } else {
            return array("status" => false, 'message' => "Remarks Not Updated Successfully");
        }
    }

    public function show_all_seed_barcode()
    {
        $barcode = $this->input->post('barcode');
        $item_id = $this->db->query("SELECT B.LZ_MANIFEST_ID,B.ITEM_ID,B.CONDITION_ID  FROM LZ_BARCODE_MT B WHERE B.BARCODE_NO ='$barcode'")->result_array();
        $item_id = $item_id[0]['ITEM_ID'];
        $seed_id = $this->db->query("select SEED_ID from LZ_ITEM_SEED where item_id = '$item_id'")->result_array();
        $seed_id = $seed_id[0]['SEED_ID'];
        $unholded_barcode_qry = $this->db->query("SELECT B.BARCODE_NO FROM LZ_ITEM_SEED S,LZ_BARCODE_MT B WHERE S.ITEM_ID  =B.ITEM_ID AND S.LZ_MANIFEST_ID = B.LZ_MANIFEST_ID AND  S.DEFAULT_COND = B.CONDITION_ID AND S.SEED_ID = $seed_id AND HOLD_STATUS = 0 AND LIST_ID IS NULL AND SALE_RECORD_NO IS NULL AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND EBAY_ITEM_ID IS NULL")->result_array();

        $holded_barcode_qry = $this->db->query("SELECT B.BARCODE_NO FROM LZ_ITEM_SEED S,LZ_BARCODE_MT B WHERE S.ITEM_ID  =B.ITEM_ID AND S.LZ_MANIFEST_ID = B.LZ_MANIFEST_ID AND  S.DEFAULT_COND = B.CONDITION_ID AND S.SEED_ID = $seed_id AND HOLD_STATUS = 1 AND LIST_ID IS NULL AND SALE_RECORD_NO IS NULL AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND EBAY_ITEM_ID IS NULL")->result_array();

        return array('hold' => $holded_barcode_qry, 'unhold' => $unholded_barcode_qry);
    }
    public function Toggle_Hold_Selected_Barcode()
    {
        $hold_barcode = $this->input->post('barcodes');
        $barcodeStatus = $this->input->post('barcodeStatus');
        $user_id = $this->input->post('user_id');
        date_default_timezone_set("America/Chicago");
        $current_date = date("Y-m-d H:i:s");
        $current_date = "TO_DATE('" . $current_date . "', 'YYYY-MM-DD HH24:MI:SS')";
        $comma = ',';

        foreach ($hold_barcode as $barcodes) {
            // $check_status = $this->db->query("SELECT * FROM LZ_BARCODE_MT WHERE BARCODE_NO =$barcode AND HOLD_STATUS = 0");

            // if($check_status->num_rows()>0){
            $get_pk = $this->db->query("SELECT get_single_primary_key('LZ_BARCODE_HOLD_LOG','LZ_HOLD_ID') LZ_HOLD_ID FROM DUAL");
            $get_pk = $get_pk->result_array();
            $lz_hold_id = $get_pk[0]['LZ_HOLD_ID'];
            $barcode = $barcodes['BARCODE_NO'];
            $qry = "INSERT INTO LZ_BARCODE_HOLD_LOG VALUES ($lz_hold_id $comma $barcode $comma $current_date $comma $barcodeStatus $comma $user_id)";
            $this->db->query($qry);

            $hold_qry = "UPDATE LZ_BARCODE_MT SET HOLD_STATUS = $barcodeStatus WHERE BARCODE_NO = $barcode ";
            $hold_status = $this->db->query($hold_qry);

            // }else{
            //     $hold_status = true;
            // }
        } //barcode foreach
        if ($hold_status) {
            return true;
        } else {
            return false;
        }

    }
    /**
     *
     * Classified Ad
     *
     *
     * *** */

    public function Get_Classified_Ad()
    {
        $merchant_id = $this->input->post('merchant_id');
        $filterData = $this->input->post('filterData');
        $startDate = $this->input->post('startDate');
        $endDate = $this->input->post('endDate');
        // , REPLACE(cm.BRAND, ' ', '''') BRAND
        $qry = "SELECT cm.*, TO_CHAR(cm.PIC_DATE, 'MM/DD/YYYY HH24:MI:SS') PIC_DATE FROM lj_classified_ad_mt  cm, lz_merchant_mt  mm WHERE mm.merchant_id = $merchant_id AND cm.IDENT_BY IS NULL AND cm.PIC_DATE BETWEEN TO_DATE('$startDate" . " 00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$endDate" . " 23:59:59', 'YYYY-MM-DD HH24:MI:SS') ";
        // if ($employee_id !== '') {
        //     $employee_id = $employee_id['value'];
        //     $qry .= "AND cm.PI C_BY = '$employee_id'";
        // }
        // if ($filterData == 0 && $filterData !== '') {
        //     $qry .= "AND cm.IDENT_BY IS NOT NULL";

        // } else if ($filterData == 1 && $filterData !== '') {
        //     $qry .= "AND cm.IDENT_BY IS NULL";
        // }
        // if ($startDate !== '' && $endDate !== '') {
        //     $qry .= "AND cm.PIC_DATE BETWEEN TO_DATE('$startDate" . " 00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$endDate" . " 23:59:59', 'YYYY-MM-DD HH24:MI:SS')";
        // }
        $data = $this->db->query($qry);
        $image = $this->get_barcode_pics_classified($data->result_array());
        if ($data->num_rows() > 0) {
            return array("status" => true, "data" => $data->result_array(), 'image' => $image['uri']);
        } else {
            return array("data" => false, "data" => array(), "message" => "No Record Found", 'image' => array());
        }
    }
    public function Search_Classified_Ad()
    {
        $merchant_id = $this->input->post('merchant_id');
        $merchant_id = $merchant_id['value'];
        $employee_id = $this->input->post('employee_id');
        $filterData = $this->input->post('filterData');
        $startDate = $this->input->post('startDate');
        $endDate = $this->input->post('endDate');
        // , REPLACE(cm.BRAND, ' ', '''') BRAND
        $qry = "SELECT cm.*, TO_CHAR(cm.PIC_DATE, 'MM/DD/YYYY HH24:MI:SS') PIC_DATE FROM lj_classified_ad_mt  cm, lz_merchant_mt  mm WHERE mm.merchant_id = $merchant_id ";
        if ($employee_id !== '') {
            $employee_id = $employee_id['value'];
            $qry .= "AND cm.PIC_BY = '$employee_id'";
        }
        if ($filterData == 0 && $filterData !== '') {
            $qry .= "AND cm.IDENT_BY IS NOT NULL ";

        } else if ($filterData == 1 && $filterData !== '') {
            $qry .= "AND cm.IDENT_BY IS NULL ";
        }
        if ($startDate !== '' && $endDate !== '') {
            $qry .= "AND cm.PIC_DATE BETWEEN TO_DATE('$startDate" . " 00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$endDate" . " 23:59:59', 'YYYY-MM-DD HH24:MI:SS')";
        }
        $data = $this->db->query($qry);
        $image = $this->get_barcode_pics_classified($data->result_array());
        if ($data->num_rows() > 0) {
            return array("status" => true, "data" => $data->result_array(), 'image' => $image['uri']);
        } else {
            return array("data" => false, "data" => array(), "message" => "No Record Found", 'image' => array());
        }
    }

    public function get_barcode_pics_classified($barcodes)
    {

        $path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 2");
        $path = $path->result_array();

        $master_path = $path[0]["MASTER_PATH"];
        $uri = array();
        $base_url = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        foreach ($barcodes as $barcode) {

            $bar = $barcode['BARCODE_NO'];
            if (!empty($bar)) {

                $getFolder = $this->db->query("SELECT cm.BARCODE_NO FROM LJ_CLASSIFIED_AD_MT cm WHERE cm.BARCODE_NO = '$bar' and rownum <= 1  ")->result_array();
            }

            $folderName = "";
            if ($getFolder) {
                $folderName = $getFolder[0]['BARCODE_NO'];
            } else {
                $folderName = $bar;
            }
            $dir = "";
            $barcodePictures = $master_path . $folderName . "/";
            // var_dump($barcodePictures);
            $barcodePicturesThumb = $master_path . $folderName . "/thumb/";
            // $barcodePictures = 'D:/wamp/www/item_pictures/dekitted_pictures/' . $folderName . '/';
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

    public function Update_Classified_Data()
    {
        $ad_id = $this->input->post('ad_id');
        $barcode_no = trim($this->input->post("barcode_no"));
        $bin_id = trim($this->input->post('bin_id'));
        $pic_date = $this->input->post('pic_date');
        $pic_by = trim($this->input->post('pic_by'));
        $selectcondition = $this->input->post('selectcondition');
        if ($selectcondition) {
            $condition_id = trim($selectcondition['value']);
            $condition_name = trim($selectcondition['label']);
        }
        $item_desc = trim(str_replace("'", " ", $this->input->post('item_desc')));
        $upc = trim($this->input->post('upc'));
        $mpn = trim($this->input->post('mpn'));
        $brand = trim(str_replace("'", " ", $this->input->post('brand')));
        $item_cost = trim($this->input->post('item_cost'));
        $lot_id = trim($this->input->post('lot_id'));
        $category_id = trim($this->input->post('category_id'));
        $category_name = trim(str_replace("'", " ", $this->input->post('category_name')));
        $pic_remarks = trim(str_replace("'", " ", $this->input->post('pic_remarks')));
        $condition_remarks = trim(str_replace("'", " ", $this->input->post('condition_remarks')));
        $ident_remarks = trim(str_replace("'", " ", $this->input->post('ident_remarks')));
        $ident_date = trim($this->input->post('ident_date'));
        $ident_by = trim($this->input->post('ident_by'));
        $qr = "UPDATE LJ_CLASSIFIED_AD_MT SET BIN_ID = '$bin_id' , CONDITION_ID = '$condition_id', CONDITION_NAME = '$condition_name', ITEM_DESC = '$item_desc', UPC = '$upc', MPN = '$mpn',
        BRAND = '$brand', ITEM_COST = '$item_cost', CATEGORY_ID = '$category_id', CATEGORY_NAME = '$category_name', PIC_REMARKS = '$pic_remarks', CONDITION_REMARKS = '$condition_remarks', IDENT_REMARKS ='$ident_remarks',
        IDENT_DATE = sysdate, IDENT_BY = '$ident_by' WHERE AD_ID = '$ad_id'";
        $data = $this->db->query($qr);
        if ($data) {
            return array('status' => true, 'message' => "Record Updated Successfully");
        } else {
            return array('status' => false, 'message' => "Record Not Updated Successfully");
        }
    }
    /**
     *
     *
     * Lzw Config
     *
     *
     */
    public function Get_Objects()
    {
        $data = "SELECT OBJECT_ID, OBJECT_NAME FROM LZW_OBJECT_MT";
        $result = $this->db->query($data)->result_array();
        return array("status" => true, "data" => $result);
    }

    public function Get_Brands()
    {
        $data = "SELECT BRAND_ID, DESCRIPTION FROM LZW_BRANDS_MT";
        $result = $this->db->query($data)->result_array();
        return array("status" => true, "data" => $result);
    }

    public function Get_Series()
    {
        $data = "SELECT SERIES_ID, DESCRIPTION FROM LZW_SERIES_MT";
        $result = $this->db->query($data)->result_array();
        return array("status" => true, "data" => $result);
    }

    public function Get_Model()
    {
        $data = "SELECT MODEL_ID, DESCRIPTION FROM LZW_MODEL_MT";
        $result = $this->db->query($data)->result_array();
        return array("status" => true, "data" => $result);
    }
    public function Save_New_Object()
    {
        $object = $this->input->post('new_product');
        $user_id = $this->input->post('user_id');
        $object_name = strtoupper($object);
        $data = $this->db->query("SELECT OBJECT_NAME FROM LZW_OBJECT_MT WHERE UPPER(OBJECT_NAME) = '$object_name'");
        if ($data->num_rows() > 0) {
            return array("status" => false, "message" => "this Product Is Already Exist");
        } else {
            $get_pk = $this->db->query("SELECT get_single_primary_key('LZW_OBJECT_MT','OBJECT_ID') OBJECT_ID FROM DUAL");
            $get_pk = $get_pk->result_array();
            $object_id = $get_pk[0]['OBJECT_ID'];
            $insert = $this->db->query("INSERT INTO LZW_OBJECT_MT(OBJECT_ID, OBJECT_NAME, CREATED_BY, CREATED_DATE) VALUES ('$object_id','$object','$user_id',sysdate)");
            if ($insert == true) {
                return array("status" => true, "message" => "This Product is Save");
            } else {
                return array("status" => false, "message" => "This Product is not Save");
            }
        }

    }
    public function Save_New_Brand()
    {
        $brand = $this->input->post('new_brand');
        $user_id = $this->input->post('user_id');
        $brand_name = strtoupper($brand);
        $data = $this->db->query("SELECT DESCRIPTION FROM LZW_BRANDS_MT WHERE UPPER(DESCRIPTION) = '$brand_name'");
        if ($data->num_rows() > 0) {
            return array("status" => false, "message" => "This Brand Is Already Exist");
        } else {
            $get_pk = $this->db->query("SELECT get_single_primary_key('LZW_BRANDS_MT','BRAND_ID') BRAND_ID FROM DUAL");
            $get_pk = $get_pk->result_array();
            $barnd_id = $get_pk[0]['BRAND_ID'];
            $insert = $this->db->query("INSERT INTO LZW_BRANDS_MT(BRAND_ID, DESCRIPTION, CREATED_BY, CREATED_DATE) VALUES ('$barnd_id','$brand','$user_id',sysdate)");
            if ($insert == true) {
                return array("status" => true, "message" => "This Brand is Save");
            } else {
                return array("status" => false, "message" => "This Brand is not Save");
            }

        }

    }

    public function Save_New_Series()
    {
        $series = $this->input->post('new_series');
        $user_id = $this->input->post('user_id');
        $series_name = strtoupper($series);
        $data = $this->db->query("SELECT DESCRIPTION FROM LZW_SERIES_MT WHERE UPPER(DESCRIPTION) = '$series_name'");
        if ($data->num_rows() > 0) {
            return array("status" => false, "message" => "This Series Is Already Exist");
        } else {
            $get_pk = $this->db->query("SELECT get_single_primary_key('LZW_SERIES_MT','SERIES_ID') SERIES_ID FROM DUAL");
            $get_pk = $get_pk->result_array();
            $series_id = $get_pk[0]['SERIES_ID'];
            $insert = $this->db->query("INSERT INTO LZW_SERIES_MT(SERIES_ID, DESCRIPTION) VALUES ('$series_id','$series')");
            if ($insert == true) {
                return array("status" => true, "message" => "This Series is Save");
            } else {
                return array("status" => false, "message" => "This Series is not Save");
            }
        }
    }
    public function Save_New_Model()
    {
        $model = $this->input->post('new_model');
        $user_id = $this->input->post('user_id');
        $model_name = strtoupper($model);
        $data = $this->db->query("SELECT DESCRIPTION FROM LZW_MODEL_MT WHERE UPPER(DESCRIPTION) = '$model_name'");
        if ($data->num_rows() > 0) {
            return array("status" => false, "message" => "This Model Is Already Exist");
        } else {
            $get_pk = $this->db->query("SELECT get_single_primary_key('LZW_MODEL_MT','MODEL_ID') MODEL_ID FROM DUAL");
            $get_pk = $get_pk->result_array();
            $model_id = $get_pk[0]['MODEL_ID'];
            $insert = $this->db->query("INSERT INTO LZW_MODEL_MT(MODEL_ID, DESCRIPTION) VALUES ('$model_id','$model')");
            if ($insert == true) {
                return array("status" => true, "message" => "This Series is Save");
            } else {
                return array("status" => false, "message" => "This Series is not Save");
            }
        }
    }
    public function Save_New_Data()
    {
        $object = $this->input->post('product');
        $brand = $this->input->post('brand');
        $series = $this->input->post('series');
        $model = $this->input->post('model');
        $user_id = $this->input->post('user_id');
        var_dump($object);
        if (isset($object['__isNew__'])) {
            $object_name = $object['label'];
            $get_pk = $this->db->query("SELECT get_single_primary_key('LZW_OBJECT_MT','OBJECT_ID') OBJECT_ID FROM DUAL");
            $get_pk = $get_pk->result_array();
            $object_id = $get_pk[0]['OBJECT_ID'];
            $insert = $this->db->query("INSERT INTO LZW_OBJECT_MT('OBJECT_ID','OBJECT_NAME', 'CREATED_BY', 'CREATED_DATE') VALUES ('$object_id','$object_name','$user_id',sysdate)");
            var_dump($brand);
        } else if (isset($brand['__isNew__'])) {
            $brand_name = $brand['label'];
            $get_pk = $this->db->query("SELECT get_single_primary_key('LZW_BRANDS_MT','BRAND_ID') BRAND_ID FROM DUAL");
            $get_pk = $get_pk->result_array();
            $brand_id = $get_pk[0]['BRAND_ID'];
            $insert = $this->db->query("INSERT INTO LZW_BRANDS_MT('BRAND_ID','DESCRIPTION', 'CREATED_BY', 'CREATED_DATE') VALUES ('$brand_id','$brand_name','$user_id',sysdate)");

        }
    }

    public function Check_Brand_Exist($object_id, $brand_id)
    {

        $get_ids = $this->db->query("SELECT BRAND_DT_ID,BRAND_ID, OBJECT_ID FROM lzw_brands_dt WHERE BRAND_ID = '$brand_id' AND OBJECT_ID = '$object_id'")->result_array();
        if (count($get_ids) > 0) {
            $brand_dt_id = $get_ids[0]['BRAND_DT_ID'];
            return array('status' => true, 'brand_dt_id' => $brand_dt_id);
        } else {
            return array("status" => false);
        }
    }
    public function Check_Series_Exist($brand_dt_id, $series_id)
    {

        // $get_brand_dt = $this->db->query("SELECT BRAND_DT_ID FROM lzw_brands_dt WHERE  BRAND_ID = '$brand_id'")->result_array();
        // $brand_dt_id = $get_brand_dt[0]['BRAND_DT_ID'];
        $get_ids = $this->db->query("SELECT SERIES_DT_ID, SERIES_ID, BRAND_DT_ID FROM lzw_series_dt WHERE SERIES_ID = '$series_id' AND BRAND_DT_ID = '$brand_dt_id'");

        if ($get_ids->num_rows() > 0) {
            $series = $get_ids->result_array();
            $series_dt_id = $series[0]['SERIES_DT_ID'];
            return array("status" => true, 'series_dt_id' => $series_dt_id);

            // return array("status" =>false, "message" => "Series Combination Is Already Exist");
        } else {
            $series = $get_ids->result_array();
            // $series_dt_id = $series[0]['SERIES_DT_ID'];
            $series_dt_id = '';
            return array("status" => false, 'BRAND_DT_ID' => $brand_dt_id, 'series_dt_id' => $series_dt_id);
        }
    }

    public function Check_Model_Exist($series_dt_id, $model_id)
    {

        // $get_series_dt = $this->db->query("SELECT SERIES_DT_ID FROM lzw_series_dt WHERE  SERIES_ID = '$series_id'")->result_array();
        // $series_dt_id = $get_series_dt[0]['SERIES_DT_ID'];
        $get_ids = $this->db->query("SELECT SERIES_DT_ID, MODEL_ID FROM lzw_model_dt WHERE MODEL_ID = '$model_id' AND SERIES_DT_ID = '$series_dt_id'");

        if ($get_ids->num_rows() > 0) {
            return array("status" => true);

            // return array("status" =>false, "message" => "Series Combination Is Already Exist");
        } else {
            return array("status" => false, 'SERIES_DT_ID' => $series_dt_id);
        }
    }
    public function Save_All_Bind()
    {
        $object = $this->input->post('product');
        $brand = $this->input->post('brand');
        $series = $this->input->post('series');
        $model = $this->input->post('model');
        $user_id = $this->input->post('user_id');
        $object_id = $object['value'];
        $brand_id = $brand['value'];
        $series_id = $series['value'];
        $model_id = $model['value'];
        $brand_res = $this->Check_Brand_Exist($object_id, $brand_id);

        if ($brand_res['status'] == false) {
            /**
             *
             * Brand Dt Id
             */
            $get_pk = $this->db->query("SELECT get_single_primary_key('lzw_brands_dt','BRAND_DT_ID') BRAND_DT_ID FROM DUAL");
            $get_pk = $get_pk->result_array();
            $brand_dt_id = $get_pk[0]['BRAND_DT_ID'];

            $res = $this->db->query("INSERT INTO lzw_brands_dt (BRAND_DT_ID, BRAND_ID, OBJECT_ID, CREATED_BY, CREATED_DATE) VALUES ('$brand_dt_id', '$brand_id', '$object_id', '$user_id', sysdate)");
            if ($res == true) {
                $result[] = array('status' => true, 'message' => 'Brand Combination Is Created');
            } else {
                $result[] = array('status' => false, 'message' => 'Brand Combination Is  Not  Created');
            }
            /**
             *
             * Series Dt Id
             */
            $get_pk = $this->db->query("SELECT get_single_primary_key('lzw_series_dt','SERIES_DT_ID') SERIES_DT_ID FROM DUAL");
            $get_pk = $get_pk->result_array();
            $series_dt_id = $get_pk[0]['SERIES_DT_ID'];
            $res = $this->db->query("INSERT INTO lzw_series_dt (SERIES_DT_ID, SERIES_ID, BRAND_DT_ID) VALUES ('$series_dt_id', '$series_id', '$brand_dt_id')");
            if ($res == true) {
                $result[] = array('status' => true, 'message' => 'Series Combination Is Created');
            } else {
                $result[] = array('status' => false, 'message' => 'Series Combination Is Not Created');
            }
            /**
             *
             * Model  Dt Id
             */

            $get_pk = $this->db->query("SELECT get_single_primary_key('lzw_model_dt','MODEL_DT_ID') MODEL_DT_ID FROM DUAL");
            $get_pk = $get_pk->result_array();
            $model_dt_id = $get_pk[0]['MODEL_DT_ID'];
            $res = $this->db->query("INSERT INTO lzw_model_dt (MODEL_DT_ID, SERIES_DT_ID, MODEL_ID) VALUES ('$model_dt_id', '$series_dt_id', '$model_id')");
            if ($res == true) {
                $result[] = array('status' => true, 'message' => 'Model Combination Is Created');
            } else {
                $result[] = array('status' => false, 'message' => 'Model Combination Is Not Created');
            }

            return $result;
        } else {
            $result[] = array('status' => false, 'message' => 'Brand Combination Is  Already Created');
            $brand_dt_id = $brand_res['brand_dt_id'];
            $series_res = $this->Check_Series_Exist($brand_dt_id, $series_id);
            // var_dump($series_res);
            if ($series_res['status'] == false) {
                /**
                 *
                 * Series Dt Id
                 */
                $brand_dt_id = $series_res['BRAND_DT_ID'];
                $get_pk = $this->db->query("SELECT get_single_primary_key('lzw_series_dt','SERIES_DT_ID') SERIES_DT_ID FROM DUAL");
                $get_pk = $get_pk->result_array();
                $series_dt_id = $get_pk[0]['SERIES_DT_ID'];

                $res = $this->db->query("INSERT INTO lzw_series_dt (SERIES_DT_ID, SERIES_ID, BRAND_DT_ID) VALUES ('$series_dt_id', '$series_id', '$brand_dt_id')");
                if ($res == true) {
                    $result[] = array('status' => true, 'message' => 'Series Combination Is Created');
                } else {
                    $result[] = array('status' => false, 'message' => 'Series Combination Is Not Created');
                }
            } else {
                $result[] = array('status' => false, 'message' => 'Series Combination Is Already Created');

            }
            $series_dt_id = $series_res['series_dt_id'];
            $model_res = $this->Check_Model_Exist($series_dt_id, $model_id);
            // var_dump($model_res);
            if ($model_res['status'] == false) {
                $series_dt_id = $model_res['SERIES_DT_ID'];
                $get_pk = $this->db->query("SELECT get_single_primary_key('lzw_model_dt','MODEL_DT_ID') MODEL_DT_ID FROM DUAL");
                $get_pk = $get_pk->result_array();
                $model_dt_id = $get_pk[0]['MODEL_DT_ID'];
                $res = $this->db->query("INSERT INTO lzw_model_dt (MODEL_DT_ID, SERIES_DT_ID, MODEL_ID) VALUES ('$model_dt_id', '$series_dt_id', '$model_id')");
                if ($res == true) {
                    $result[] = array('status' => true, 'message' => 'Model Combination Is Created');
                } else {
                    $result[] = array('status' => false, 'message' => 'Model Combination Is Not Created');
                }
            } else {
                $result[] = array('status' => false, 'message' => 'Model Combination Is Already Created');
            }

            return $result;
        }

    }
    public function Save_Object_Binding()
    {
        $object = $this->input->post('product');
        $brand = $this->input->post('brand');
        $user_id = $this->input->post('user_id');
        $object_id = $object['value'];
        $brand_id = $brand['value'];
        $get_pk = $this->db->query("SELECT get_single_primary_key('lzw_brands_dt','BRAND_DT_ID') BRAND_DT_ID FROM DUAL");
        $get_pk = $get_pk->result_array();
        $brand_dt_id = $get_pk[0]['BRAND_DT_ID'];
        $get_ids = $this->db->query("SELECT BRAND_ID, OBJECT_ID FROM lzw_brands_dt WHERE BRAND_ID = '$brand_id' AND OBJECT_ID = '$object_id'")->result_array();
        if (count($get_ids) > 0) {
            return array("status" => false, "message" => 'Already This Combination Exist');
        } else {

            $result = $this->db->query("INSERT INTO lzw_brands_dt (BRAND_DT_ID, BRAND_ID, OBJECT_ID, CREATED_BY, CREATED_DATE) VALUES ('$brand_dt_id', '$brand_id', '$object_id', '$user_id', sysdate)");
            if ($result == true) {
                return array("status" => true, "message" => 'Record Updated');
            } else {
                return array("status" => false, "message" => 'Record Not Updated');
            }
        }
    }

    public function Save_Series_Binding()
    {
        $brand = $this->input->post('brand');
        $series = $this->input->post('series');
        $user_id = $this->input->post('user_id');
        $series_id = $series['value'];
        $brand_id = $brand['value'];
        $get_pk = $this->db->query("SELECT get_single_primary_key('lzw_series_dt','SERIES_DT_ID') SERIES_DT_ID FROM DUAL");
        $get_pk = $get_pk->result_array();
        $series_dt_id = $get_pk[0]['SERIES_DT_ID'];
        $get_brand_dt = $this->db->query("SELECT BRAND_DT_ID FROM lzw_brands_dt WHERE  BRAND_ID = '$brand_id'")->result_array();
        $brand_dt_id = $get_brand_dt[0]['BRAND_DT_ID'];
        $get_ids = $this->db->query("SELECT SERIES_ID, BRAND_DT_ID FROM lzw_series_dt WHERE SERIES_ID = '$series_id' AND BRAND_DT_ID = '$brand_dt_id'");
        //////
        if ($get_ids->num_rows() > 0) {
            return array("status" => false, "message" => 'This Binding is Already Exist');
        } else {
            $result = $this->db->query("INSERT INTO lzw_series_dt (SERIES_DT_ID, SERIES_ID, BRAND_DT_ID) VALUES ('$series_dt_id', '$series_id', '$brand_dt_id')");
            if ($result == true) {
                return array("status" => true, "message" => 'Record Updated');
            } else {
                return array("status" => false, "message" => 'Record Not Updated');
            }
        }

    }

    public function Save_Model_Binding()
    {
        $series = $this->input->post('series');
        $model = $this->input->post('model');
        $user_id = $this->input->post('user_id');
        $series_id = $series['value'];
        $model_id = $model['value'];
        $get_pk = $this->db->query("SELECT get_single_primary_key('lzw_model_dt','MODEL_DT_ID') MODEL_DT_ID FROM DUAL");
        $get_pk = $get_pk->result_array();
        $model_dt_id = $get_pk[0]['MODEL_DT_ID'];
        $get_series_dt = $this->db->query("SELECT SERIES_DT_ID FROM lzw_series_dt WHERE  SERIES_ID = '$series_id'")->result_array();
        $series_dt_id = $get_series_dt[0]['SERIES_DT_ID'];
        $get_ids = $this->db->query("SELECT SERIES_DT_ID, MODEL_ID FROM lzw_model_dt WHERE MODEL_ID = '$model_id' AND SERIES_DT_ID = '$series_dt_id'");
        if ($get_ids->num_rows() > 0) {
            return array("status" => false, "message" => 'This Model Is Already Exist');
        } else {
            $result = $this->db->query("INSERT INTO lzw_model_dt (MODEL_DT_ID, SERIES_DT_ID, MODEL_ID) VALUES ('$model_dt_id', '$series_dt_id', '$model_id')");
            if ($result == true) {
                return array("status" => true, "message" => 'Record Updated');
            } else {
                return array("status" => false, "message" => 'Record Not Updated');
            }
        }

    }

    public function Get_Lzw_Config_Detail()
    {
        //$qr = "select 'REP-'||LPAD(NVL(rm.REPAIRE_MT_ID,0), 6, '0') REPAIR_ID, (rm.f_name||' ' || rm.l_name) NAME, rm.email, rm.contact_no, rm.customer_remarks, (select om.object_name from lzw_object_mt om where om.object_id = rm.object_id) product_name, (select bmm.description from lzw_brands_dt bt, lzw_brands_mt bmm where bmm.brand_id = bt.brand_id and bt.brand_dt_id = rm.brand_dt_id) brand_name, (select sm.description from lzw_series_mt sm, lzw_series_dt st where sm.series_id = st.series_id and st.series_dt_id = rm.series_dt_id) series_name, (select mom.description from lzw_model_mt mom, lzw_model_dt mdt where mom.model_id = mdt.model_id and mdt.model_dt_id = rm.model_dt_id) model_name from lzw_repaire_mt rm"; 
        $qr = "SELECT 'REP-' || LPAD(NVL(RM.REPAIRE_MT_ID, 0), 6, '0') REPAIR_ID,
                    RM.REPAIRE_MT_ID,
                    RM.F_NAME || ' ' || RM.L_NAME NAME,
                    RM.EMAIL,
                    RM.CONTACT_NO,
                    RM.CUSTOMER_REMARKS,
                    (SELECT OM.OBJECT_NAME
                       FROM LZW_OBJECT_MT OM
                      WHERE OM.OBJECT_ID = RM.OBJECT_ID) PRODUCT_NAME, 
                    DECODE((SELECT BMM.DESCRIPTION
                             FROM LZW_BRANDS_DT BT, LZW_BRANDS_MT BMM
                            WHERE BMM.BRAND_ID = BT.BRAND_ID
                              AND TO_CHAR(BT.BRAND_DT_ID) = RM.BRAND_INPUT),
                           NULL,
                           RM.BRAND_INPUT,
                           (SELECT BMM.DESCRIPTION
                              FROM LZW_BRANDS_DT BT, LZW_BRANDS_MT BMM
                             WHERE BMM.BRAND_ID = BT.BRAND_ID
                               AND TO_CHAR(BT.BRAND_DT_ID) = RM.BRAND_INPUT)) BRAND_NAME,
                     DECODE((SELECT SM.DESCRIPTION
                              FROM LZW_SERIES_MT SM, LZW_SERIES_DT ST
                             WHERE SM.SERIES_ID = ST.SERIES_ID
                               AND TO_CHAR(ST.SERIES_DT_ID) = RM.SERIES_INPUT),
                            NULL,
                            RM.SERIES_INPUT,
                            (SELECT SM.DESCRIPTION
                               FROM LZW_SERIES_MT SM, LZW_SERIES_DT ST
                              WHERE SM.SERIES_ID = ST.SERIES_ID
                                AND TO_CHAR(ST.SERIES_DT_ID) = RM.SERIES_INPUT)) SERIES_NAME,
                    DECODE((SELECT MOM.DESCRIPTION
                             FROM LZW_MODEL_MT MOM, LZW_MODEL_DT MDT
                            WHERE MOM.MODEL_ID = MDT.MODEL_ID
                              AND TO_CHAR(MDT.MODEL_DT_ID) = RM.MODAL_INPUT),
                           NULL,
                           RM.MODAL_INPUT,
                           (SELECT MOM.DESCRIPTION
                              FROM LZW_MODEL_MT MOM, LZW_MODEL_DT MDT
                             WHERE MOM.MODEL_ID = MDT.MODEL_ID
                               AND TO_CHAR(MDT.MODEL_DT_ID) = RM.MODAL_INPUT)) MODEL_NAME,
                    NVL(OFFER, 0) OFFER,
                    CASE
                      WHEN nvl(OFFER, 0) >= 1 then
                       'Approved'
                      else
                       'Pending'
                    end status
               FROM LZW_REPAIRE_MT RM
              ORDER BY REPAIRE_MT_ID DESC
";
        $res = $this->db->query($qr);
        if ($res->num_rows() > 0) {
            return array('status' => true, 'data' => $res->result_array());
        } else {
            return array('status' => false, 'data' => array());
        }
    }

}
?>