<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Listing Controller
 */
class c_haziqreact extends CI_Controller
{
    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        parent::__construct();
        $this->load->database();
        // $this->Data = json_decode(file_get_contents('php://input'), true);
        if (!empty(json_decode(file_get_contents('php://input'), true))) {
            $this->Data = json_decode(file_get_contents('php://input'), true);

        }
        // $this->load->model('reactcontroller/m_react');
        $this->load->model("reactcontroller/m_genrateToken");

    }

    public function get_portal()
    {
        $data = $this->m_genrateToken->get_Portal_data();
        echo json_encode($data);
        return json_encode($data);
    }

    public function get_store_name()
    {
        // $Data = json_decode(file_get_contents('php://input'), true);
        // $name = $Data['storename'];
        // $portal_code = $Data['selectedportalname'];
        // $merchant_id = $Data['merchant_id'];
        $name = $this->input->post('storename');
        $portal_code = $this->input->post('selectedportalname');
        $merchant_id = $this->input->post('merchant_id');
        // $name= "haziq";
        $data = $this->m_genrateToken->get_Store_Name($name, $portal_code, $merchant_id);
        echo json_encode($data);
        return json_encode($data);
    }

    public function save_store_name()
    {
        // $Data = json_decode(file_get_contents('php://input'), true);
        // $name = $Data['storename'];
        // $portal_code = $Data['selectedportalname'];
        // $marchantid = $Data['marchantid'];
        // $insertedby = $Data['insertedby'];
        // $email = $Data['email'];
        // $default_merchant = $Data['default_merchant'];
        $default_merchant = $this->input->post('default_merchant');
        $name = $this->input->post('storename');
        $portal_code = $this->input->post('selectedportalname');
        $marchantid = $this->input->post('marchantid');
        $insertedby = $this->input->post('insertedby');
        $email = $this->input->post('email');

        $token = '';
        // $token = "sadhadghjagdjsd32432";
        // $dataArray = array("ACCOUNT_NAME"=>$name, "PORTAL_ID"=>$portal_code, "MERCHANT_ID"=> $marchantid, "INSERTED_BY"=> $insertedby, "TOKEN"=>$token);
        if (!empty($name)) {
            $data = $this->m_genrateToken->save_Store_Name($name, $portal_code, $marchantid, $insertedby, $token, $email, $default_merchant);
            // var_dump($this->m_genrateToken->select_Paypal_Email($email));
            echo json_encode($data);
            return json_encode($data);
        }

    }

    public function select_all_store_name()
    {
        $Data = json_decode(file_get_contents('php://input'), true);
        $merchant_id = ($_GET['mid']);
        $user_id = $_GET['user_id'];
        // $merchant_id = 10000000072;
        $data = $this->m_genrateToken->select_All_Store_Data($merchant_id, $user_id);
        echo json_encode($data);
        return json_encode($data);

    }

    public function get_last_insert_store()
    {
        $data = $this->m_genrateToken->get_Last_Insert_Store();
        echo json_encode($data);
        return json_encode($data);
    }

    public function signin_ebay()
    {
        $Data = json_decode(file_get_contents('php://input'), true);
        $Acct_id = ($_GET['acct_id']);
        // $merchant_id = 10000000056;
        $data = $this->m_genrateToken->signIn_EBay_Url_Detail($Acct_id);
        echo json_encode($data);
        return json_encode($data);
    }

    public function updatestorestatus()
    {
        // $Data = json_decode(file_get_contents('php://input'), true);
        // $acct_id = $Data['acct_id'];
        // $merchant_status = $Data['merchant_status'];
        $acct_id = $this->input->post('acct_id');
        $merchant_status = $this->input->post('merchant_status');
        // if (!empty($acct_id)) {
        $result = $this->m_genrateToken->updateStoreStatus($acct_id, $merchant_status);
        echo json_encode($result);
        return json_encode($result);

        // }
    }

    public function set_default_store_name()
    {

        $acct_id = $this->input->post('acct_id');
        $merchant_id = $this->input->post('merchant_id');
        $user_id = $this->input->post('user_id');
        $default_merchant = $this->input->post('default_merchant');

        $result = $this->m_genrateToken->set_Default_Store_Name($acct_id, $default_merchant, $user_id, $merchant_id);
        echo json_encode($result);
        return json_encode($result);

    }
/*

END EBAY INTEGRATION
START GENRATE BARCODE

 */
    public function get_merchant_detail()
    {
        $user_id = $this->input->post('user_id');
        //  $_GET['user_id'];
        //
        $merchant_id = $this->input->post('mid');
        // $_GET['mid'];
        //
        $data['merchant_detail'] = $this->m_genrateToken->get_Merchant_Detail($user_id, $merchant_id);
        $data['merchant_lot'] = $this->m_genrateToken->get_Merchant_Lot($user_id, $merchant_id);
        $data['seller_account'] = $this->m_genrateToken->get_Merchant_Acount_Name($user_id, $merchant_id);

        echo json_encode($data);
        return json_encode($data);
    }

    public function get_total_bar()
    {
        $lot_id = $this->input->post('lot_id');
        $data["tot_bar"] = $this->m_genrateToken->get_Total_Bar($lot_id);
        echo json_encode($data);
        return json_encode($data);
    }

    public function print_barcode()
    {
        $bar_range = $this->input->post('bar_range');
        $no_of_barcode = $this->input->post('no_of_bar');
        $mer_name = $this->input->post('merchant_id');
        $user_id = $this->input->post('user_id');
        $merchant_id = $this->input->post('merchant_id');
        $avail_lot = $this->input->post('lot_id');
        $pos_check = $this->input->post('pos_check');
        if ($avail_lot == null) {
            $avail_lot = '';
        }
        $seller_account_id = $this->input->post('seller_account_id');
        $result['data'] = $this->m_genrateToken->print_Barcode($bar_range, $no_of_barcode, $mer_name, $merchant_id, $user_id, $avail_lot, $seller_account_id, $pos_check);
        $result['latest'] = $this->m_genrateToken->latest_Gen_Barcode_DataTable($result['data']['MT_ID']);
        echo json_encode($result);
        return json_encode($result);
    }
    public function get_barcode_form_database()
    {
        $mt_id = $_GET['mt_id'];
        $result = $this->m_genrateToken->get_Barcode_Form_Database($mt_id);
        //     echo json_encode($result);
        //     return json_encode($result);
        $chek_rang = $result[0]['RANGE_ID'];

        if ($chek_rang == 1) {
            $no_of_barcode = $result[0]['NO_OF_BARCODE'];
            $len = count($result);

            $get_first = $result[0]['BARCODE_NO'] . "-";
            $get_last = $result[$len - 1]['BARCODE_NO'];

            $this->load->library('m_pdf');

            $i = 0;
            foreach ($result as $data) {
                $status = '';
                $k = $i;
                $j = $k + 1;
                $barcode = '';
                $text = $data["BUISNESS_NAME"];
                $item_desc = implode("<br/>", str_split($text, 40));
                $lot_desc = implode("<br/>", str_split($data['LOT_DESC'], 40));
                if (@$data['POS_STATUS'] == 'USE FOR POS') {
                    $barcode = @$data['MERCHANT_ID'] . '@' . @$data['BARCODE_NO'];
                    $status = "POS Barcode";
                } else {
                    $barcode = @$data['BARCODE_NO'];
                    $status = '';
                }
                $html = '<div style = "margin-left:-35px!important;">
                <div style="width:222px !important;" class="barcodecell"><barcode height="0.75" size="1.18" code="' . @$barcode . '" type="C128A" class="barcode" /></div>

            <div style="margin-top:6px !important;width:222px;padding:0;font-size:8px;font-family:arial;">
            <span><b>' .
                @$barcode . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>' .
                @$status . '&nbsp;&nbsp;' . @$data["REF_NO"] . '</u>&nbsp;&nbsp;<br></b> Merchant Name: ' . @$data["BUISNESS_NAME"] . '<br></b>Issue Date: ' .
                @$data['ISSUED_DATE'] . '</span><br><span style="margin-top:3px!important; font-size:9px!important;font-family:arial;">' .
                @$lot_desc . '</span><br><strong></b>' . $j . ' of ' . @$no_of_barcode . '&nbsp;&nbsp;' . $get_first . '' . $get_last . '<strong></span></div>
                </div>';

                //generate the PDF from the given html
                $this->m_pdf->pdf->WriteHTML($html);
                $i++;
                if (!empty($result[$i])) {
                    $this->m_pdf->pdf->AddPage();
                }

            } //end foreach

            //download it.
            $this->m_pdf->pdf->Output($pdfFilePath, "I");
        } elseif ($chek_rang == 0) {

            $this->load->library('m_pdf');

            $i = 0;
            foreach ($result as $data) {
                $barcode = '';
                $status = "";
                $text = $data["BUISNESS_NAME"];
                $item_desc = implode("<br/>", str_split($text, 40));
                $lot_desc = implode("<br/>", str_split($data['LOT_DESC'], 40));
                if (@$data['POS_STATUS'] == 'USE FOR POS') {
                    $barcode = @$data['MERCHANT_ID'] . '@' . @$data['BARCODE_NO'];
                    $status = "POS Barcode";
                } else {
                    $barcode = @$data['BARCODE_NO'];
                    $status = "";
                }
                $html = '<div style = "margin-left:-35px!important;">
                <div style="width:222px !important;" class="barcodecell"><barcode height="0.75" size="1.18" code="' . @$barcode . '" type="C128A" class="barcode" /></div>

            <div style="margin-top:6px !important;width:222px;padding:0;font-size:8px;font-family:arial;">
            <span><b>' .
                @$barcode . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>' .
                @$status . '&nbsp;&nbsp;' . @$data["REF_NO"] . '</u>&nbsp;&nbsp;<br></b> Merchant Name: ' . @$data["BUISNESS_NAME"] . '<br></b>Issue Date: ' .
                @$data['ISSUED_DATE'] . '</span><br>
              <br></span></div>
                </div>';
                //generate the PDF from the given html
                $this->m_pdf->pdf->WriteHTML($html);
                $i++;
                if (!empty($result[$i])) {
                    $this->m_pdf->pdf->AddPage();
                }

            } //end foreach
            //download it.
            $this->m_pdf->pdf->Output($pdfFilePath, "I");

        }
    }

    public function gen_barcode_datatable()
    {
        $user_id = $_GET['userId'];
        $merchant_id = $_GET['merchant_id'];
        $status = $_GET['record'];
        if (!empty($user_id)) {
            $mt_id = $this->m_genrateToken->gen_Barcode_DataTable($user_id, $merchant_id, $status);
            echo json_encode($mt_id);
            return json_encode($mt_id);
        }
    }
    public function get_barcode_detail()
    {
        // $mt_id = $this->input->post('cell');

        $result = $this->m_genrateToken->get_Barcode_Detail();
        echo json_encode($result);
        return json_encode($result);
    }
    public function genrate_barcode_by_dt()
    {
        $data = $this->Print_Specific_Barcode();
        // echo json_encode($data);
        // return josn_encode($data);
    }
    public function Print_Specific_Barcode()
    {
        $dt_id = $_GET['result'];
        $result = $this->m_genrateToken->genrate_Barcode_By_Dt($dt_id);
        $this->load->library('m_pdf');
        // to increse or decrese the width of barcode please set size attribute in barcode tag
        //$i = 0;
        // var_dump($result);
        // exit;
        foreach ($result as $data) {
            // var_dump($data['BUISNESS_NAME']);exit;
            $barcode = '';
            $status = '';
            $text = $data["BUISNESS_NAME"];
            $item_desc = implode("<br/>", str_split($text, 40));
            $lot_desc = implode("<br/>", str_split($data['LOT_DESC'], 40));
            if (@$data['POS_STATUS'] == 'USE FOR POS') {
                $barcode = @$data['MERCHANT_ID'] . '@' . @$data['BARCODE_NO'];
                $status = "POS Barcode";
            } else {
                $barcode = @$data['BARCODE_NO'];
                $status = "";
            }
            $html = '<div style = "margin-left:-35px!important;">
            <div style="width:222px !important;" class="barcodecell"><barcode height="0.75" size="1.18" code="' . @$barcode . '" type="C128A" class="barcode" /></div>

        <div style="margin-top:6px !important;width:222px;padding:0;font-size:8px;font-family:arial;">
        <span><b>' .
            @$barcode . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>' .
            @$status . '&nbsp;&nbsp;' . @$data["REF_NO"] . '</u>&nbsp;&nbsp;<br></b> Merchant Name: ' . @$data["BUISNESS_NAME"] . '<br></b>Issue Date: ' .
            @$data['ISSUED_DATE'] . '</span><br>
          <br></span></div>
            </div>';
            // var_dump($barcode);
            // var_dump(@$data['BARCODE_NO']);
            // exit;

            //generate the PDF from the given html
            $this->m_pdf->pdf->WriteHTML($html);

        } //end foreach

        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "I");
    }

    public function update_cost()
    {
        $result = $this->m_genrateToken->update_Cost();
        echo json_encode($result);
        return json_encode($result);
    }
    public function add_new_barcode()
    {
        $result = $this->m_genrateToken->Add_New_Barcode();
        echo json_encode($result);
        return json_encode($result);
    }
    public function delete_barcode()
    {
        $result = $this->m_genrateToken->Delete_Barcode();
        echo json_encode($result);
        return json_encode($result);
    }
    /*

    Merchant Lot Detail

     */
    public function save_merchant_lot()
    {
        // $Data = json_decode(file_get_contents('php://input'), true);
        $lot_desc = $this->input->post('lot_desc');
        // $Data['lot_desc'];
        $purch_date = $this->input->post('purch_date');
        // $Data['purch_date'];
        // $purch_date = $Data['purch_date'];
        // $purch_date = date_create($purch_date, timezone_open('America/Chicago'));
        // $get_purch_date = date_format(@$purch_date, 'm/d/y H:i'); /// purchase date get
        // $get_purch_date = $this->input->post('purch_date');
        //  $purch_date;
        $purch_date = $this->input->post('purch_date');
        // $Data['purch_date'];
        $lot_mini_prof = $this->input->post('lot_mini_prof');
        // $Data['lot_mini_prof'];
        $lot_cost = $this->input->post('lot_cost');
        // $Data['lot_cost'];
        $lot_sourc = $this->input->post('lot_sourc');
        // $Data['lot_sourc'];
        $est_reques = $this->input->post('est_reques');
        // $Data['est_reques'];
        $part_lis = $this->input->post('part_lis');
        // $Data['part_lis'];
        $lis_Cost = $this->input->post('lis_cost');
        // $Data['lis_cost'];
        $appr_list = $this->input->post('appr_list');
        // $Data['appr_list'];
        $lot_ref = $this->input->post('lot_ref');
        // $Data['lot_ref'];
        $merchant_id = $this->input->post('mer_name');
        // $Data["mer_name"];
        // if (empty($merchant_id)) {
        //     $merchant_id = "10000000072";
        // }
        // if (!empty($lot_desc)) {
        $data['mer_lot_detail'] = $this->m_genrateToken->save_Merchant_Lot($lot_desc, $purch_date, $lot_mini_prof, $lot_cost, $lot_sourc, $est_reques, $part_lis, $lis_Cost, $appr_list, $lot_ref, $merchant_id);
        $data['new_lot_data'] = $this->m_genrateToken->get_Latest_Merchant_Lot();

        // }
        echo json_encode($data);
        return json_encode($data);
    }
    /*

    Create Appointment

     */

    public function get_services()
    {
        $data = $this->m_genrateToken->get_Services();
        echo json_encode($data);
        return json_encode($data);
    }

    public function get_appointment_summary()
    {
        $result = $this->m_genrateToken->Get_Summary_Appointment();
        echo json_encode($result);
        return json_encode($result);
    }
    public function insert_appointment()
    {
        date_default_timezone_set('GMT');

        $services_id = $this->input->post('service_id');
        $created_date = $this->input->post('created_date');
        $merchant_id = $this->input->post('mid');
        $user_id = $this->input->post('user_id');
        $appointment_datee = $this->input->post('appointment_date');
        $expected_barcode = $this->input->post('no_of_items');
        $remarks = $this->input->post('remarks');
        $request_for_approvel = '1';

        if (is_array($appointment_datee)) {
            $appointment_date = $appointment_datee[0];
        } else {

            $appointment_date = $appointment_datee;
        }

        $appointment_status = '0';

        $result['insert_appointment'] = $this->m_genrateToken->insert_Appointment($created_date, $request_for_approvel, $merchant_id, $user_id, $appointment_date,
            $appointment_status, $expected_barcode, $remarks);
        for ($i = 0; $i < sizeof($services_id); $i++) {
            $service_id = $services_id[$i]['value'];
            $result['insert_appointment_dt'] = $this->m_genrateToken->insert_Appointment_Dt($service_id);
        }
        echo json_encode($result);
        return json_encode($result);
    }
    public function get_appointmentdetail()
    {
        $user_id = $_GET['user_id'];
        $merchant_id = $_GET['merchant_id'];
        $result = $this->m_genrateToken->get_AppointmentDetail($user_id, $merchant_id);
        echo json_encode($result);
        return json_encode($result);
    }
    public function cancel_appointment()
    {
        $cell_id = $this->input->post('cell_id');
        $user_id = $this->input->post('user_id');

        $result = $this->m_genrateToken->cancel_Appointment($cell_id, $user_id);

        echo json_encode($result);
        return json_encode($result);
    }

    public function approve_appointment()
    {
        $cell_id = $this->input->post('cell_id');
        $user_id = $this->input->post('user_id');
        $status = $this->input->post('status');

        if (!empty($cell_id)) {
            $result = $this->m_genrateToken->approve_Appointment($cell_id, $user_id, $status);

        }
        echo json_encode($result);
        return json_encode($result);
    }
    public function send_to_approve()
    {

        $result = $this->m_genrateToken->send_To_Approve();
        echo json_encode($result);
        return json_encode($result);
    }
    public function get_specific_services()
    {
        $cell_id = $this->input->post('cell_id');

        $result = $this->m_genrateToken->get_Specific_Services($cell_id);
        echo json_encode($result);
        return json_encode($result);
    }

    public function in_process_appointment()
    {
        $result = $this->m_genrateToken->in_Process_Appointment();
        echo json_encode($result);
        return json_encode($result);
    }
    public function complete_appointment()
    {
        $result = $this->m_genrateToken->complete_Appointment();
        echo json_encode($result);
        return json_encode($result);
    }
    public function custom_barcode_in_process()
    {
        $result = $this->m_genrateToken->custom_Barcode_In_Process();
        echo json_encode($result);
        return json_encode($result);
    }

    public function get_specific_log_detail()
    {
        $result = $this->m_genrateToken->get_Specific_Log_Detail();
        echo json_encode($result);
        return json_encode($result);
    }

    public function save_date_appointmetnt_Barcode_log()
    {
        $result = $this->m_genrateToken->Save_Date_Appointmetnt_Barcode_Log();
        echo json_encode($result);
        return json_encode($result);
    }

    public function delete_appointment_services()
    {
        // $result = $this->m_genrateToken->delete_Appointment_Services();
        $result = $this->m_genrateToken->delete_Log_Appointment_Services();
        echo json_encode($result);
        return json_encode($result);
    }

    public function delete_all_appointment_barcode()
    {
        $result = $this->m_genrateToken->Delete_All_Appointment_Barcode();
        echo json_encode($result);
        return json_encode($result);
    }
    public function diff_mins()
    {
        $result = $this->m_genrateToken->Diff_Mins();
        echo json_encode($result);
        return json_encode($result);
    }

    public function save_appointment_packing()
    {
        $result = $this->m_genrateToken->Save_Appointment_Packing();
        echo json_encode($result);
        return json_encode($result);
    }

    public function add_packing_all_appointment_barcode()
    {
        $result = $this->m_genrateToken->Add_Packing_All_Appointment_Barcode();
        echo json_encode($result);
        return json_encode($result);
    }

    public function get_all_appointment_packing()
    {
        $result = $this->m_genrateToken->Get_Packing_Detail_Appointment();
        echo json_encode($result);
        return json_encode($result);
    }
    public function search_barcode()
    {
        $result = $this->m_genrateToken->search_Barcode();
        echo json_encode($result);
        return json_encode($result);
    }
    public function get_lot_aganist_appointment_merchant()
    {
        $result = $this->m_genrateToken->Get_Lot_Aganist_Appointment_Merchant();
        echo json_encode($result);
        return json_encode($result);
    }

    public function get_appointment_lot_barcode_detail()
    {

        $result = $this->m_genrateToken->Get_Appointment_Lot_Barcode_Detail();
        echo json_encode($result);
        return json_encode($result);
    }
    public function save_all_lot_barcode()
    {
        $result = $this->m_genrateToken->Save_All_Lot_Barcode();
        echo json_encode($result);
        return json_encode($result);
    }
    public function Add_barcode_aganist_lot_and_barcode()
    {
        $result = $this->m_genrateToken->Add_Barcode_Aganist_Lot_And_Barcode();
        echo json_encode($result);
        return json_encode($result);
    }
    /**
     *
     *
     * END Create Appointment Controller
     * Genrate Billing
     *
     *
     */

    public function get_packing_type()
    {
        $result = $this->m_genrateToken->get_Packing_Type();
        echo json_encode($result);
        return json_encode($result);
    }
    public function genrate_service_bill()
    {
        $data = [
            $merchant_id = $this->input->post('merchant_id'),
            $service_id = $this->input->post('service_id'),
            $qty = $this->input->post('qty'),
            $service_cost = $this->input->post('service_cost'),
            $dateStart = $this->input->post('date'),
            $created_by = $this->input->post('created_by'),

        ];

        $result = $this->m_genrateToken->genrate_Service_Packing_Bill($data, 'service_billing');
        echo json_encode($result);
        return json_encode($result);

    }

    public function genrate_packing_bill()
    {
        $packingdata = [
            $merchant_id = $this->input->post("packingmerchant_id"),
            $packing_id = $this->input->post("packing_id"),
            $qty = $this->input->post('packingqty'),
            $service_cost = $this->input->post('packingservice_cost'),
            $dateStart = $this->input->post('packingdate'),
            // $created_by = $this->input->post('created_by'),

        ];

        $result = $this->m_genrateToken->genrate_Service_Packing_Bill($packingdata, 'packing_billing');
        echo json_encode($result);
        return json_encode($result);

    }

    public function get_service_bills()
    {
        $result = $this->m_genrateToken->get_Service_Bills();
        echo json_encode($result);
        return json_encode($result);
    }

    public function delete_service_bill()
    {
        $result = $this->m_genrateToken->delete_Service_Bill();
        echo json_encode($result);
        return json_encode($result);
    }

    public function update_service_detail()
    {
        $result = $this->m_genrateToken->update_Service_Detail();
        echo json_encode($result);
        return json_encode($result);
    }
    /**
     *
     * End Bill
     * Product Dimension
     *
     *
     */
    public function get_merchant_product()
    {
        $result = $this->m_genrateToken->get_Merchant_Product();
        echo json_encode($result);
        return json_encode($result);
    }
    public function update_product_detail()
    {
        $result = $this->m_genrateToken->update_Product_Detail();
        echo json_encode($result);
        return json_encode($result);
    }
    /**
     *
     *
     * End Product Dimension
     * Start Invoice Detail
     *
     *
     *  */
    public function get_invoice_detail()
    {
        $result = $this->m_genrateToken->get_Invoice_Detail();
        echo json_encode($result);
        return json_encode($result);
    }

    public function get_invoice_data_detail()
    {
        $result = $this->m_genrateToken->get_Invoice_Data_Detail();
        echo json_encode($result);
        return json_encode($result);
    }

    public function get_specific_invoice_detail()
    {
        $result = $this->m_genrateToken->get_Specific_Invoice_Detail();
        echo json_encode($result);
        return json_encode($result);
    }

    public function save_discount_amount()
    {
        $result = $this->m_genrateToken->save_Discount_Amount();
        echo json_encode($result);
        return json_encode($result);
    }
    public function save_all_discount_amount()
    {
        $result = $this->m_genrateToken->save_All_Discount_Amount();
        echo json_encode($result);
        return json_encode($result);
    }
    /**
     *
     *
     * End Invoice Detail
     * Start Create Lot
     *
     *
     *  */
    public function get_lot_barcode_detail()
    {
        $result = $this->m_genrateToken->get_Lot_Barcode_Detail();
        echo json_encode($result);
        return json_encode($result);
    }
    public function get_lot_range_barcode_detail()
    {
        $result = $this->m_genrateToken->Get_Lot_Range_Barcode_Detail();
        echo json_encode($result);
        return json_encode($result);
    }
    public function get_item_cond()
    {
        $result = $this->m_genrateToken->Get_Item_Cond();
        echo json_encode($result);
        return json_encode($result);
    }

    public function get_object_cond()
    {
        $result = $this->m_genrateToken->Get_Object_Cond();
        echo json_encode($result);
        return json_encode($result);
    }
    public function save_lot_data()
    {
        $result = $this->m_genrateToken->Save_Lot_Data();
        echo json_encode($result);
        return json_encode($result);
    }

    public function create_lot_object()
    {
        $result = $this->m_genrateToken->Create_Lot_Object();
        echo json_encode($result);
        return json_encode($result);
    }
    public function suggest_lot_categories()
    {
        $result = $this->m_genrateToken->Suggest_Lot_Categories();
        echo json_encode($result);
        return json_encode($result);
    }

    /**
     *
     *
     * End Posted Barcode Create Lot
     * Start Un Posted Create Lot
     *
     *
     *  */

    public function get_lot_unposted_barcode_detail()
    {
        $result = $this->m_genrateToken->get_Lot_UnPosted_Barcode_Detail();
        echo json_encode($result);
        return json_encode($result);
    }

    public function get_lot_unposted_range_barcode_detail()
    {
        $result = $this->m_genrateToken->Get_Lot_UnPosted_Range_Barcode_Detail();
        echo json_encode($result);
        return json_encode($result);
    }

    public function save_unposted_lot_data()
    {
        $result = $this->m_genrateToken->Save_Unposted_Lot_Data();
        echo json_encode($result);
        return json_encode($result);
    }
    // public function upload_barcode_to_firebase()
    // {
    //     $result = $this->m_genrateToken->Upload_Barcode_To_Firebase();
    //     echo json_encode($result);
    //     return json_encode($result);
    // }

    /**
     *
     *
     * End UnPosted Barcode Create Lot
     * Start Point Of Sale
     *
     *
     *  */

    public function pos_form_data()
    {
        $result["Doc_No"] = $this->m_genrateToken->Doc_No();
        $result["City_State_List"] = $this->m_genrateToken->City_State_List();
        $result['Store_Name'] = $this->m_genrateToken->Get_POS_Store_Name();
        echo json_encode($result);
        return json_encode($result);
    }
    public function pos_form_state()
    {
        $result = $this->m_genrateToken->Get_State();
        echo json_encode($result);
        return json_encode($result);
    }

    public function pos_form_state_edit()
    {
        $result = $this->m_genrateToken->Get_State_Edit();
        echo json_encode($result);
        return json_encode($result);
    }
    public function get_pos_store_name()
    {
        $result = $this->m_genrateToken->Get_POS_Store_Name();
        echo json_encode($result);
        return json_encode($result);
    }

    public function get_tax()
    {
        $result = $this->m_genrateToken->Get_Tax();
        echo json_encode($result);
        return json_encode($result);
    }
    public function get_barcode_detail_pos()
    {
        $result = $this->m_genrateToken->Get_Barcode_Detail_Pos();
        echo json_encode($result);
        return json_encode($result);
    }
    public function get_scan_barcode_detail()
    {
        $result = $this->m_genrateToken->Get_Scan_Barcode_Detail();
        echo json_encode($result);
        return json_encode($result);
    }

    public function save_invoice_pos()
    {
        $result = $this->m_genrateToken->Save_Invoice_Pos();
        echo json_encode($result);
        return json_encode($result);
    }

    public function print_invoice()
    {
        $lz_pos_mt_id = $_GET['lz_pos_mt_id'];
        //var_dump($lz_pos_mt_id);exit;
        // $result['Doc_No'] = $this->m_genrateToken->docNo();
        // $result['data'] = $this->m_genrateToken->cityStateList();

        //return redirect('pos/c_point_of_sale/pos_showForm');

        /*------Print Invoice ------*/

        //$lz_pos_mt_id = $this->uri->segment(4);

        date_default_timezone_set("America/Chicago");
        $print_date = date("m/d/Y H:i A ");
        //var_dump($print_date);exit;

        $concatDate = date("m/d/Y");
        // var_dump($concatDate);exit;
        $result = $this->m_genrateToken->Print_Invoice($lz_pos_mt_id);
        /*==================================
        =            m_pdf code            =
        ==================================*/
        //$data = [];
        //load the view and saved it into $html variable
        //$html=$this->load->view('welcome_message', $data, true);

        //this the the PDF filename that user will get to download
        //var_dump($result);exit;
        //$pdfFilePath = @$result[0]["DOC_NO"].".pdf";

        //load mPDF library
        //$this->load->library('m_pdf');
        // to increse or decrese the width of barcode please set size attribute in barcode tag
        $header_table = '<table> <tr>
        <th style="font-size:12px !important;font-family: arial; text-align:left;">Customer Name:</th>
        <td style="font-size:12px !important;font-family: arial;">' . trim(str_replace(" ", '', @$result["store_name"][0]["BUYER_NAME"])) . '</td>
      </tr>
      <tbody></table> <br>';

        $header = '<style media="print"> @page {size: auto; margin: 0; } </style><!doctype html> <html class="no-js" lang=""> <head> <meta charset="utf-8"> <meta http-equiv="x-ua-compatible" content="ie=edge"> <title>Print Invoice</title> <meta name="description" content=""> <meta name="viewport" content="width=device-width, initial-scale=1"> </head> <body><div style="width: 280px !important;margin:0px !important;"> <div style="width: 138px;float:left;font-size:12px;font-family: arial;">' . @$print_date . '</div> <div style="width: 138px;float:right;font-size:12px;font-family: arial;"> <b>Sale Receipt #' . @$result["data"][0]["DOC_NO"] . '</b> </div> <div style="padding: 2px;font-size:12px;font-family: arial;">Store:' . @$result["store_name"][0]["STORE_NAME"] . '</div> <div style="text-align: center;font-size: 20px; font-weight: bold; font-family: arial;padding: 3px;">LaptopZone</div> <div style="font-size:12px;font-weight: normal;font-family: arial;text-align: center;">' . @$result["store_name"][0]["ADDRESS"] . '<br>' . @$result["store_name"][0]["CITY_DESC"] . '<br> ' . trim(str_replace("_", '', @$result["store_name"][0]["PHONE_NO"])) . ' </div><br>' . $header_table . '<table> <thead> <tr style="font-size:12px !important;border-bottom: 1px solid #000 !important;font-family: arial;"> <th style="border-bottom-style: solid; border-bottom: 1px solid #000 !important;">Item Name</th> <th style="border-bottom-style: solid; border-bottom: 1px solid #000 !important;">Qty</th> <th style="border-bottom-style: solid; border-bottom: 1px solid #000 !important;">Price</th> <th style="border-bottom-style: solid; border-bottom: 1px solid #000 !important;">Ext Price</th> </tr></thead> <tbody> ';
        $html = '';
        $sum_price = 0;
        $sum_disc_amt = 0;
        $sum_qty = 0;
        $total_pay_advance = 0;
        foreach ($result['data'] as $data) {
            $text = $data["ITEM_DESC"];
            $price = '$' . number_format((float) @$data['DET_PRICE'], 2, '.', ',');

            //$item_desc = implode("<br/>", str_split($text, 40));
            $item_desc = str_split($text, 40);
            //var_dump($item_desc);exit;
            $html .= '<tr style="font-size:12px !important;font-family: arial;"> <td><div style="width:120px;">' . @$item_desc[0] . '</div></td> <td><span style="float:right;margin-right:15px;">' . @$data["QTY"] . '</span></td> <td>' . $price . '</td> <td>' . $price . '</td> </tr>';
            $sum_price = $sum_price + $data['DET_PRICE'];

            $sum_disc_amt = $sum_disc_amt + $data['DISC_AMT'];
            $sum_qty = $sum_qty + $data['QTY'];
            $total_pay_advance = $total_pay_advance + $data['ADVANCE_PAYMENT'];
            //generate the PDF from the given html
            //echo $html;exit;

        } //end foreach
        //var_dump($sum_price);exit;
        $total = $sum_price - $sum_disc_amt;
        $pay_mode = @$result['data'][0]['PAY_MODE'];
        $sales_tax = ($total / 100) * @$result['data'][0]['DET_SALES_TAX'];
        $sales_tax = number_format((float) @$sales_tax, 2, '.', ',');

        $receipt_total = $total + $sales_tax;
        $receipt_totals = $receipt_total - $total_pay_advance;
        $receipt_total = number_format((float) @$receipt_total, 2, '.', ',');
        $receipt_totals = number_format((float) @$receipt_totals, 2, '.', ',');
        if ($pay_mode == "C") {
            $rcpt_total = "Cash: $" . $receipt_total;

        } elseif ($pay_mode == "R") {
            $rcpt_total = "Credit: $" . $receipt_total;
        }

        // $con = implode($print_date);
        $barDate = str_replace('/', '', $concatDate);
        // var_dump($barDate);exit;
        $str1 = substr($barDate, 0, 4);
        $str2 = substr($barDate, 6, 8);
        $docDateStr = $str1 . $str2;
        // var_dump($docDateStr);exit;
        //echo $receipt_total;

        $footer = '<tr style="font-size:12px !important;font-family: arial;"> <td style="border-top-style: solid; border-top: 1px solid #000 !important;"></td> <td style="border-top-style: solid; border-top: 1px solid #000 !important;"><span style="float:right;margin-right:15px;">Qty: ' . $sum_qty . '</span></td> <td style="border-top-style: solid; border-top: 1px solid #000 !important;"><b>Subtotal:</b></td> <td style="border-top-style: solid; border-top: 1px solid #000 !important;">' . '$' . $sum_price . '</td> </tr><tr style="font-size:12px !important;font-family: arial;"><td></td> <td></td> <td>Disc Amount:</td> <td>' . '$' . $sum_disc_amt . '</td></tr><tr style="font-size:12px !important;font-family: arial;"><td></td> <td></td> <td><b>Total:</b></td> <td>' . '$' . $total . '</td></tr> <tr style="font-size:12px !important;font-family: arial;"><td></td> <td></td> <td>Advance Pay:</td> <td>' . '$' . $total_pay_advance . '</td></tr> <tr style="font-size:12px !important;font-family: arial;"> <td></td> <td>Exempt</td> <td>0 % Tax:</td> <td>+ ' . '$' . $sales_tax . '</td> </tr> <tr style="font-size:12px !important;font-family: arial;"> <td></td>  <td colspan="2"><b>GRAND TOTAL:</b></td> <td><b>' . '$' . $receipt_total . '</b></td> </tr> <tr style="font-size:12px !important;font-family: arial;"> <td></td> <td><div style="width:90px;">' . $rcpt_total . '</div></td> <td></td> <td></td> </tr> <tr style="font-size:12px !important;font-family: arial;"><td></td> <td></td> <td>Total Pay:</td> <td>' . '$' . $receipt_totals . '</td></tr> </tbody> </table><br> <div style="text-align:center;margin:5px;font-size: 12px;font-weight: normal;font-family: arial;">Thanks for shopping with us!</div> <div style="margin:5px;text-align:center;margin:5px;font-size: 12px;font-weight: normal;font-family: arial;"><img style="margin-bottom:3px;width: 200px;" alt="pos_barcode" src="' . base_url() . 'assets/barcode/barcode.php?text=' . @$result['data'][0]["DOC_NO"] . '"/><div style="margin:5px;text-align:center;margin:5px;font-size: 12px;font-weight: normal;font-family: arial;">' . @$result['data'][0]["DOC_NO"] . '-' . @$docDateStr . '</div> </div></body> </html>';
        echo $header . $html . $footer;
        // exit;
        //$this->m_pdf->pdf->WriteHTML($header.$html.$footer);
        //download it.
        //$this->m_pdf->pdf->Output($pdfFilePath, "I");

        /*----End Print Invoice ------*/
    }

    public function search_repair_form()
    {
        $result = $this->m_genrateToken->Search_Repair_Form();
        echo json_encode($result);
        return json_encode($result);
    }
    public function get_barcodes_aganist_barcode_repair_search()
    {
        $result = $this->m_genrateToken->Get_Barcodes_Aganist_Barcode_Repair_Search();
        echo json_encode($result);
        return json_encode($result);
    }
    public function get_item_qty_aganist_ebay_id()
    {
        $result = $this->m_genrateToken->Get_Item_Qty_Aganist_Ebay_Id();
        echo json_encode($result);
        return json_encode($result);

    }

    public function single_item_end()
    {
        $ebay_id = $this->input->post('ebay_id');
        $user_id = $this->input->post('user_id');
        $remarks = $this->input->post('remarks');
        $result['ebay_id'] = $ebay_id;
        $result['remarks'] = $remarks;
        //$get_seller = $this->db->query("SELECT E.LZ_SELLER_ACCT_ID,A.SELL_ACCT_DESC FROM EBAY_LIST_MT E , LZ_SELLER_ACCTS A WHERE A.LZ_SELLER_ACCT_ID = E.LZ_SELLER_ACCT_ID AND E.EBAY_ITEM_ID = '$ebay_id' AND ROWNUM=1")->result_array();

        //$get_seller = $this->db->query("SELECT E.LZ_SELLER_ACCT_ID, A.ACCOUNT_NAME SELL_ACCT_DESC FROM EBAY_LIST_MT E, LJ_MERHCANT_ACC_DT A WHERE A.ACCT_ID = E.LZ_SELLER_ACCT_ID AND E.EBAY_ITEM_ID = '$ebay_id' AND ROWNUM = 1")->result_array();
        $get_seller = $this->db->query("SELECT E.LZ_SELLER_ACCT_ID, A.ACCOUNT_NAME SELL_ACCT_DESC , S.EBAY_LOCAL FROM EBAY_LIST_MT E, LJ_MERHCANT_ACC_DT A , LZ_ITEM_SEED S WHERE A.ACCT_ID = E.LZ_SELLER_ACCT_ID AND S.SEED_ID = E.SEED_ID AND E.EBAY_ITEM_ID =  '$ebay_id' AND ROWNUM = 1")->result_array();
        $account_name = @$get_seller[0]['LZ_SELLER_ACCT_ID'];

        if (!empty(@$get_seller[0]['EBAY_LOCAL'])) {
            $site_id = @$get_seller[0]['EBAY_LOCAL'];
        } else {
            $site_id = 0;
        }
        $result['site_id'] = $site_id;
        if (!empty(@$account_name)) {
            $result['account_name'] = $account_name;
        }
        $result['user_id'] = $user_id;
        $data = $this->load->view('ebay/trading/endItem', $result);
        if ($data) {
            $data = $this->m_genrateToken->Single_Item_End();
            $result['response'] = $this->m_ordersShopify->deleteItemfromShopify($ebay_id);
            //End item from Shopify

        }
        echo json_encode($data);
        return json_encode($data);
    }
    public function update_multiple_barcode_Qty()
    {

        $ebay_id = trim($this->input->post('ebay_id'));
        $remarks = trim($this->input->post('remarks'));
        $adj_barcode = trim($this->input->post('adj_barcode'));
        $adj_qty = trim($this->input->post('adj_qty'));
        $barcode_no = $this->input->post('barcode_no');
        $user_id = $this->input->post('user_id');
        //$get_seller_acct = $this->db->query("SELECT E.LZ_SELLER_ACCT_ID FROM EBAY_LIST_MT E WHERE E.EBAY_ITEM_ID = '$ebay_id' AND UPPER(E.STATUS) = 'ADD' AND ROWNUM=1 ")->result_array();
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
            $data = "Account id against this ebay Id:" . $ebay_id . " is Not Found in system.";
            //$data = 1;
            echo json_encode($data);
            return json_encode($data);
            exit;
        }
        $data['ebay_id'] = $ebay_id;
        $data['site_id'] = $site_id;
        $data['quantity'] = $adj_qty;
        $data['account_name'] = $account_id; // used in configuration.php
        $data['addQty'] = 1; // used in less qty call
        //$data['forceRevise'] = $forceRevise;
        //$this->session->unset_userdata('active_listing');
        $this->load->view('ebay/trading/reviseItemPrice', $data);
        $current_qty_adj = $this->session->userdata('current_qty_adj');
        $this->session->unset_userdata('current_qty_adj');
        if ($current_qty_adj === -1) {
            $this->db->query("CALL pro_adjEbayQty_pos($ebay_id, '$adj_barcode', $adj_qty, $user_id, '$remarks', $barcode_no)");
            // array('status' => true, 'message' => ' Barcode Release Successfully ');
            echo json_encode(array('status' => true, 'message' => ' Barcode Release Successfully '));
            return json_encode(array('status' => true, 'message' => ' Barcode Release Successfully '));
            //  echo json_encode($current_qty_adj);
            //  return json_encode($current_qty_adj);
        } else {
            echo json_encode(array('status' => false, 'message' => ' Barcode Not Release Successfully '));
            return json_encode(array('status' => false, 'message' => ' Barcode Not Release Successfully '));
        }

    }
    /**
     *
     *
     * End  Point Of Sale FORM
     * Start Point Of Sale STORE Registr
     *
     *
     *  */

    public function save_pos_store()
    {
        $result = $this->m_genrateToken->Save_Pos_Store();
        echo json_encode($result);
        return json_encode($result);
    }
    public function get_pos_store()
    {
        $result = $this->m_genrateToken->Get_Pos_Store();
        echo json_encode($result);
        return json_encode($result);
    }
    public function delete_store()
    {
        $result = $this->m_genrateToken->Delete_Store();
        echo json_encode($result);
        return json_encode($result);

    }
    public function update_pos_store()
    {
        $result = $this->m_genrateToken->Update_Pos_Store();
        echo json_encode($result);
        return json_encode($result);
    }
    /**
     *
     *
     * End  Point Of Sale STORE Registr
     * Start Point Of Sale Receipt View
     *
     *
     *  */

    public function pos_receipt_view()
    {

        $result = $this->m_genrateToken->Pos_Receipt_View();
        echo json_encode($result);
        return json_encode($result);
    }

    public function get_scan_barcode_detail_edit()
    {
        $result = $this->m_genrateToken->Get_Scan_Barcode_Detail_Edit();
        echo json_encode($result);
        return json_encode($result);
    }
    public function get_receipt_by_store()
    {
        $result = $this->m_genrateToken->Get_Receipt_By_Store();
        echo json_encode($result);
        return json_encode($result);
    }

    public function toggle_post_unpost_invoice()
    {
        $result = $this->m_genrateToken->toggle_post_unpost_invoice();
        echo json_encode($result);
        return json_encode($result);
    }
    public function delete_invoice()
    {
        $result = $this->m_genrateToken->Delete_invoice();
        echo json_encode($result);
        return json_encode($result);
    }

    public function delete_all_pos_invoice()
    {
        $result = $this->m_genrateToken->Delete_All_Pos_Invoice();
        echo json_encode($result);
        return json_encode($result);
    }

    public function post_all_pos_invoice()
    {
        $result = $this->m_genrateToken->Post_All_Pos_Invoice();
        echo json_encode($result);
        return json_encode($result);
    }

    public function unpost_all_pos_invoice()
    {
        $result = $this->m_genrateToken->UnPost_All_Pos_Invoice();
        echo json_encode($result);
        return json_encode($result);
    }
    public function edit_invoice_receipt()
    {
        $result['buyer_info'] = $this->m_genrateToken->Get_Buyer_Info();
        $result["City_State_List"] = $this->m_genrateToken->City_State_List();
        $result['Store_Name'] = $this->m_genrateToken->Get_POS_Store_Name();
        $result['table_data'] = $this->m_genrateToken->Get_Edit_TablePOS_Data();
        echo json_encode($result);
        return json_encode($result);
    }

    public function update_invoice_pos()
    {
        $result = $this->m_genrateToken->Update_Invoice_Pos();
        echo json_encode($result);
        return json_encode($result);
    }
    public function delete_pos_barcode_edit()
    {
        $result = $this->m_genrateToken->Delete_POS_Barcode_Edit();
        echo json_encode($result);
        return json_encode($result);
    }
    /*****
     *
     *
     * Repaire Form Data
     *
     */
    public function get_barcode_detail_pos_repair()
    {
        $result = $this->m_genrateToken->Get_Barcode_Detail_Pos_Repair();
        echo json_encode($result);
        return json_encode($result);
    }
    public function repaire_pos_data()
    {
        $result = $this->m_genrateToken->Repaire_Pos_Data();
        echo json_encode($result);
        return json_encode($result);
    }
    public function save_pos_repaire_data()
    {
        $result = $this->m_genrateToken->Save_Pos_Repaire_Data();
        echo json_encode($result);
        return json_encode($result);
    }

    public function get_specific_pos_repair_data()
    {
        $result = $this->m_genrateToken->Get_Specific_Pos_Repair_Data();
        echo json_encode($result);
        return json_encode($result);
    }
    public function genrate_repaire_slip()
    {
        $lz_pos_repaire_id = $_GET['lz_pos_repaire_id'];
        //var_dump($lz_pos_mt_id);exit;
        // $result['Doc_No'] = $this->m_genrateToken->docNo();
        // $result['data'] = $this->m_genrateToken->cityStateList();

        //return redirect('pos/c_point_of_sale/pos_showForm');

        /*------Print Invoice ------*/

        //$lz_pos_mt_id = $this->uri->segment(4);

        date_default_timezone_set("America/Chicago");
        $print_date = date("m/d/Y H:i A ");
        //var_dump($print_date);exit;

        $concatDate = date("m/d/Y");
        // var_dump($concatDate);exit;
        $result = $this->m_genrateToken->Print_Repaire_Slip($lz_pos_repaire_id);
        /*==================================
        =            m_pdf code            =
        ==================================*/
        //$data = [];
        //load the view and saved it into $html variable
        //$html=$this->load->view('welcome_message', $data, true);

        //this the the PDF filename that user will get to download
        //var_dump($result);exit;
        //$pdfFilePath = @$result[0]["DOC_NO"].".pdf";

        //load mPDF library
        // $this->load->library('m_pdf2');
        // to increse or decrese the width of barcode please set size attribute in barcode tag
        $master_header = '<style media="print"> @page {size: auto; margin: 0; } </style><!doctype html> <html class="no-js" lang=""> <head> <meta charset="utf-8"> <meta http-equiv="x-ua-compatible" content="ie=edge"> <title>Print Invoice</title> <meta name="description" content=""> <meta name="viewport" content="width=device-width, initial-scale=1"> </head> <body>';
        $header_table = '<table> <tr>
        <th style="font-size:12px !important;font-family: arial; text-align:left;">Customer Name:</th>
        <td style="font-size:12px !important;font-family: arial;">' . @$result['store_name'][0]['PRODUCT_OWNER'] . '</td>
      </tr>
      <tr>
        <th style="font-size:12px !important;font-family: arial; text-align:left;">Created By:</th>
        <td style="font-size:12px !important;font-family: arial;">' . @$result['store_name'][0]['OWNER_NAME'] . '</td>
      </tr>
      <tr>
        <th style="font-size:12px !important;font-family: arial; text-align:left;">Serial No:</th>
        <td style="font-size:12px !important;font-family: arial;">' . @$result['store_name'][0]['SERIAL_NO'] . '</td>
      </tr>
      <tr>
        <th style="font-size:12px !important;font-family: arial;text-align:left;">Expt Delivery Date:</th>
        <td style="font-size:12px !important;font-family: arial;">' . @$result['store_name'][0]['EXPT_DEL_DATE'] . '</td>
      </tr>
      <tr>
        <th style="font-size:12px !important;font-family: arial;text-align:left;">Brand:</th>
        <td style="font-size:12px !important;font-family: arial;">' . @$result['store_name'][0]['BRAND'] . '</td>
      </tr>
      <tr>
        <th style="font-size:12px !important;font-family: arial;text-align:left;">MPN:</th>
        <td style="font-size:12px !important;font-family: arial;">' . @$result['store_name'][0]['MPN'] . '</td>
      </tr>

      <tr>
        <th style="font-size:12px !important;font-family: arial;text-align:left;">Customer Number:</th>
        <td style="font-size:12px !important;font-family: arial;">' . trim(str_replace("_", '', @$result['store_name'][0]['CUSTOMER_NUMBER'])) . '</td>
      </tr>
      <tbody></table> <br>';
        $header = '<div style="width: 280px !important;margin:0px !important;"> <div style="width: 138px;float:left;font-size:12px;font-family: arial;">' . @$print_date . '</div> <div style="width: 138px;float:right;font-size:12px;font-family: arial;"> <b>Sale Receipt # ' . @$result["store_name"][0]["LZ_POS_REPAIRE_ID"] . '</b> </div> <div style="padding: 2px;font-size:12px;font-family: arial;">Store:' . @$result["store_name"][0]["STORE_NAME"] . '</div> <div style="text-align: center;font-size: 20px; font-weight: bold; font-family: arial;padding: 3px;">LaptopZone</div> <div style="font-size:12px;font-weight: normal;font-family: arial;text-align: center;">' . @$result["store_name"][0]["ADDRESS"] . '<br>' . @$result["store_name"][0]["CITY_DESC"] . '<br> ' . trim(str_replace("_", '', @$result["store_name"][0]["PHONE_NO"])) . ' </div> <br>' . $header_table . ' <table> <thead> <tr style="font-size:12px !important;border-bottom: 1px solid #000 !important;font-family: arial;"> <th style="border-bottom-style: solid; border-bottom: 1px solid #000 !important;">Item Desc</th><th style="border-bottom-style: solid; border-bottom: 1px solid #000 !important;">Price</th> <th style="border-bottom-style: solid; border-bottom: 1px solid #000 !important;">Ext Price</th> </tr></thead><tbody>';
        $header2 = '<div style=" width: 280px !important;margin-top:50px !important;"> <div style="width: 138px;float:left;font-size:12px;font-family: arial;">' . @$print_date . '</div> <div style="width: 138px;float:right;font-size:12px;font-family: arial;"> <b>Sale Receipt # ' . @$result["store_name"][0]["LZ_POS_REPAIRE_ID"] . '</b> </div> <div style="padding: 2px;font-size:12px;font-family: arial;">Store:' . @$result["store_name"][0]["STORE_NAME"] . '</div> <div style="text-align: center;font-size: 20px; font-weight: bold; font-family: arial;padding: 3px;">LaptopZone</div> <div style="font-size:12px;font-weight: normal;font-family: arial;text-align: center;">' . @$result["store_name"][0]["ADDRESS"] . '<br>' . @$result["store_name"][0]["CITY_DESC"] . '<br> ' . trim(str_replace("_", '', @$result["store_name"][0]["PHONE_NO"])) . ' </div> <br>' . $header_table . ' <table> <thead> <tr style="font-size:12px !important;border-bottom: 1px solid #000 !important;font-family: arial;"> <th style="border-bottom-style: solid; border-bottom: 1px solid #000 !important;">Item Desc</th><th style="border-bottom-style: solid; border-bottom: 1px solid #000 !important;">Price</th> <th style="border-bottom-style: solid; border-bottom: 1px solid #000 !important;">Ext Price</th> </tr></thead><tbody>';

        $html = '';
        $sum_price = 0;
        $sum_disc_amt = 0;
        $sum_qty = 0;

        foreach ($result['store_name'] as $data) {
            $text = $data["REPAIRE_DES"];
            $price = '$' . number_format((float) @$data['EXPT_REPAIRE_COST'], 2, '.', ',');

            //$item_desc = implode("<br/>", str_split($text, 40));
            $item_desc = str_split($text, 40);
            //var_dump($item_desc);exit;
            $html .= '<tr style="font-size:12px !important;font-family: arial;"> <td><div style="width:120px;">' . @$item_desc[0] . '</div></td><td>' . $price . '</td> <td>' . $price . '</td> </tr>';
            $sum_price = $sum_price + $data['EXPT_REPAIRE_COST'];

            $sum_disc_amt = $sum_disc_amt + 0;
            // $sum_qty = $sum_qty + $data['QTY'];
            //generate the PDF from the given html
            //echo $html;exit;

        } //end foreach
        //var_dump($sum_price);exit;
        $total = $sum_price - $sum_disc_amt;
        // $pay_mode = @$result['data'][0]['PAY_MODE'];
        $sales_tax = ($total / 100) * @$result['store_name'][0]['SALE_TAX'];
        $sales_tax = number_format((float) @$sales_tax, 2, '.', ',');
        $service_charges = number_format((float) @$result['store_name'][0]['SERVICE_CHARGES']);
        $receipt_total = $total + $sales_tax;
        $receipt_totals = $receipt_total-@$result['store_name'][0]['ADVANCE_PAYMENT'];

        $receipt_total = number_format((float) @$receipt_total, 2, '.', ',');
        $receipt_totals = number_format((float) @$receipt_totals, 2, '.', ',');

        // if ($pay_mode == "C") {
        //     $rcpt_total = "Cash: $" . $receipt_total;

        // } elseif ($pay_mode == "R") {
        //     $rcpt_total = "Credit: $" . $receipt_total;
        // }
        $rcpt_total = "Credit: $" . $receipt_total;

        // $con = implode($print_date);
        $barDate = str_replace('/', '', $concatDate);
        // var_dump($barDate);exit;
        $str1 = substr($barDate, 0, 4);
        $str2 = substr($barDate, 6, 8);
        $docDateStr = $str1 . $str2;
        // var_dump($docDateStr);exit;
        //echo $receipt_total;

        $footer = '<tr style="font-size:12px !important;font-family: arial;"><td style="border-top-style: solid; border-top: 1px solid #000 !important;"></td> <td style="border-top-style: solid; border-top: 1px solid #000 !important;"><b>Subtotal:</b></td> <td style="border-top-style: solid; border-top: 1px solid #000 !important;">' . '$' . $sum_price . '</td> </tr><tr style="font-size:12px !important;font-family: arial;"> <td></td> <td>Disc Amount:</td> <td>' . '$' . $sum_disc_amt . '</td></tr><tr style="font-size:12px !important;font-family: arial;"> <td></td> <td>Advance Pay:</td> <td>' . '$' . @$result['store_name'][0]['ADVANCE_PAYMENT'] . '</td></tr><tr style="font-size:12px !important;font-family: arial;"> <td></td> <td>Service Charges:</td> <td>' . '$' . @$result['store_name'][0]['SERVICE_CHARGES'] . '</td></tr></tr><tr style="font-size:12px !important;font-family: arial;"><td></td>  <td><b>Total:</b></td> <td>' . '$' . $total . '</td></tr> <tr style="font-size:12px !important;font-family: arial;">  <td>Exempt</td> <td>' . @$result['store_name'][0]['SALE_TAX'] . ' % Tax:</td> <td>+ ' . '$' . $sales_tax . '</td> </tr> <tr><td> </td></tr> <tr style="font-size:12px !important;font-family: arial;">  <td colspan="2"><b>GRAND TOTAL:</b></td> <td><b>' . '$' . $receipt_total . '</b></td> </tr> <tr style="font-size:12px !important;font-family: arial;"> <td><div style="width:90px;">' . $rcpt_total . '</div></td> <td></td> <td></td><tr style="font-size:12px !important;font-family: arial;"> <td></td> <td>Total Pay:</td> <td>' . '$' . $receipt_totals . '</td></tr> </tr> </tbody> </table><br> <div style="text-align:center;margin:5px;font-size: 12px;font-weight: normal;font-family: arial;">Thanks for shopping with us!</div> <div style="margin:5px;text-align:center;margin:5px;font-size: 12px;font-weight: normal;font-family: arial;"><img style="margin-bottom:3px;width: 200px;" alt="pos_barcode" src="' . base_url() . 'assets/barcode/barcode.php?text=' . @$result["store_name"][0]["LZ_POS_REPAIRE_ID"] . '"/><div style="margin:5px;text-align:center;margin:5px;font-size: 12px;font-weight: normal;font-family: arial;">' . @$result["store_name"][0]["LZ_POS_REPAIRE_ID"] . '-' . @$docDateStr . '</div></div><div style="text-align:left;font-size: 12px;font-weight: normal;font-family: arial;margin-top: 50; margin-bottom:40px;"><table> <thead> <tr style="font-size:12px !important;border-bottom: 1px solid #000 !important;font-family: arial;border-top-style: solid; border-top: 1px solid #000 !important;"> <th style="float: left;border-top-style: solid; border-top: 1px solid #000 !important;">Store Manager</th> <th style="float: right;margin-left: 70;border-top-style: solid;border-top: 1px solid #000 !important;">Customer Signature</th> </tr></thead>
</table></div></div><span>&#9986;</span>-----------------------------------------------------';
        $master_footer = '</body> </html>';
        $test = '';
        for ($i = 0; $i < 4; $i++) {
            if ($i === 0) {
                $test .= $header . $html . $footer;
            } else {
                $test .= $header2 . $html . $footer;
            }

            // ' <br> <br> <br>';
        }
        echo $master_header . $test . $master_footer;
        // exit;
        // $this->m_pdf2->pdf->WriteHTML($header.$html.$footer);
        //download it.
        // $this->m_pdf2->pdf->Output($pdfFilePath, "I");

        /*----End Print Invoice ------*/
    }
    public function update_pos_repaire_data()
    {
        $result = $this->m_genrateToken->Update_Pos_Repaire_Data();
        echo json_encode($result);
        return json_encode($result);
    }

    public function delete_pos_repaire_data()
    {
        $result = $this->m_genrateToken->Delete_Pos_Repaire_Data();
        echo json_encode($result);
        return json_encode($result);
    }

    public function Delete_Pos_Barcode_Repaire_Edit()
    {
        $result = $this->m_genrateToken->Delete_Pos_Barcode_Repaire_Edit();
        echo json_encode($result);
        return json_encode($result);
    }
    /********
     *
     *
     * Pos Receipt Detail
     *
     * */
    public function get_invoice_receipt_detail()
    {
        $result = $this->m_genrateToken->Get_Invoice_Receipt_Detail();
        echo json_encode($result);
        return json_encode($result);
    }

    public function delete_invoice_receipt_detail()
    {
        $result = $this->m_genrateToken->Delete_Invoice_Receipt_Detail();
        echo json_encode($result);
        return json_encode($result);
    }
    public function edit_invocie_receipt_amount_paid()
    {
        $result = $this->m_genrateToken->Edit_Invocie_Receipt_Amount_Paid();
        echo json_encode($result);
        return json_encode($result);
    }
    public function create_charge_stripe()
    {
        $result = $this->m_genrateToken->Create_Charge_Stripe();
        echo json_encode($result);
        return json_encode($result);
    }

    /**
     *
     * End POS
     * Assign Barcodes
     *
     *
     */

    public function get_employee_names()
    {
        $result = $this->m_genrateToken->Get_Employee_Names();
        echo json_encode($result);
        return json_encode($result);
    }
    public function get_unique_count_lot()
    {
        $result = $this->m_genrateToken->Get_Unique_Count_Lot();
        echo json_encode($result);
        return json_encode($result);
    }
    public function load_special_lots()
    {
        $result = $this->m_genrateToken->Load_Special_Lots();
        echo json_encode($result);
        return json_encode($result);
    }
    public function combine_pices_specific_barcode()
    {

        $result = $this->m_genrateToken->Combine_Pices_Specific_Barcode();
        echo json_encode($result);
        return json_encode($result);
    }
    public function assign_barcode_specific_emp()
    {
        $result = $this->m_genrateToken->Assign_Barcode_Specific_Emp();
        echo json_encode($result);
        return json_encode($result);
    }

/**
 *
 *
 * Invoice Orders
 *
 *
 */

    public function get_order_data()
    {
        $result = $this->m_genrateToken->Get_Order_Data();
        echo json_encode($result);
        return json_encode($result);
    }

    public function get_order_id_barcode()
    {
        $result = $this->m_genrateToken->Get_Order_Id_Barcode();
        echo json_encode($result);
        return json_encode($result);
    }

    public function verified_all_barcode()
    {
        $result = $this->m_genrateToken->Verified_All_Barcode();
        echo json_encode($result);
        return json_encode($result);
    }

    public function un_verified_all_barcode()
    {
        $result = $this->m_genrateToken->Un_Verified_All_Barcode();
        echo json_encode($result);
        return json_encode($result);
    }

    /*****
     *
     * Adil Bhai Verify Barcode Screen
     *
     */
    public function get_item_sold_price()
    {
        $result = $this->m_genrateToken->Get_Item_Sold_Price_Verify_Screen();
        echo json_encode($result);
        return json_encode($result);
    }
    public function suggest_price()
    {
        $result = $this->m_genrateToken->Suggest_Price_Verify_Screen();
        echo json_encode($result);
        return json_encode($result);
    }
    public function search_active_listing()
    {
        $result = $this->m_genrateToken->Search_Active_Listing_Verify_Screen();
        echo json_encode($result);
        return json_encode($result);
    }
    public function suggest_categories()
    {
        $result = $this->m_genrateToken->Suggest_Categories_Verify_Screen();
        echo json_encode($result);
        return json_encode($result);
    }

    public function selected_values()
    {
        $result = $this->m_genrateToken->Selected_Values();
        echo json_encode($result);
        return json_encode($result);
    }

    public function update_image()
    {
        $result = $this->m_genrateToken->Update_Image();
        echo json_encode($result);
        return json_encode($result);
    }
    public function delete_image()
    {
        $result = $this->m_genrateToken->Delete_Image();
        echo json_encode($result);
        return json_encode($result);
    }

    public function update_seed_remarks()
    {
        $result = $this->m_genrateToken->Update_Seed_Remarks();
        echo json_encode($result);
        return json_encode($result);
    }
    public function show_all_seed_barcode()
    {

        $result = $this->m_genrateToken->Show_All_Seed_Barcode();
        echo json_encode($result);
        return json_encode($result);

    }
    public function toggle_hold_selected_barcode()
    {
        $result = $this->m_genrateToken->Toggle_Hold_Selected_Barcode();
        echo json_encode($result);
        return json_encode($result);
    }

    /**
     *
     *
     *  Classified Ad
     *
     */
    public function get_classified_ad()
    {
        $result = $this->m_genrateToken->Get_Classified_Ad();
        echo json_encode($result);
        return json_encode($result);
    }
    public function search_classified_ad()
    {
        $result = $this->m_genrateToken->Search_Classified_Ad();
        echo json_encode($result);
        json_encode($result);
    }
    public function update_classified_data()
    {
        $result = $this->m_genrateToken->Update_Classified_Data();
        echo json_encode($result);
        return json_encode($result);
    }
    public function print_view()
    {
        // $lz_pos_mt_id = $this->input->post('lz_pos_mt_id');
        $lz_pos_mt_id = $_GET['lz_pos_mt_id'];
        date_default_timezone_set("America/Chicago");
        $print_date = date("m/d/Y H:i A ");
        //var_dump($print_date);exit;

        $concatDate = date("m/d/Y");
        // var_dump($concatDate);exit;
        $result1 = $this->m_genrateToken->Print_Invoice($lz_pos_mt_id);
        $this->load->helper('url');
        $result = $this->load->view('epson_print/v_print', $result1);
        echo json_encode($result);
        return json_encode($result);
    }
    /**
     *
     *
     * Lzw Config
     *
     *
     */
    public function get_objects()
    {
        $result = $this->m_genrateToken->Get_Objects();
        echo json_encode($result);
        return json_encode($result);
    }

    public function get_brands()
    {
        $result = $this->m_genrateToken->Get_Brands();
        echo json_encode($result);
        return json_encode($result);
    }

    public function get_series()
    {
        $result = $this->m_genrateToken->Get_Series();
        echo json_encode($result);
        return json_encode($result);
    }

    public function get_models()
    {
        $result = $this->m_genrateToken->Get_Model();
        echo json_encode($result);
        return json_encode($result);
    }
    public function save_new_object()
    {
        $result = $this->m_genrateToken->Save_New_Object();
        echo json_encode($result);
        return json_encode($result);
    }

    public function save_new_brand()
    {
        $result = $this->m_genrateToken->Save_New_Brand();
        echo json_encode($result);
        return json_encode($result);
    }
    public function save_new_series()
    {
        $result = $this->m_genrateToken->Save_New_Series();
        echo json_encode($result);
        return json_encode($result);
    }
    public function save_new_model()
    {
        $result = $this->m_genrateToken->Save_New_Model();
        echo json_encode($result);
        return json_encode($result);
    }

    public function save_new_data()
    {
        $result = $this->m_genrateToken->Save_New_Data();
        echo json_encode($result);
        return json_encode($result);
    }

    public function save_all_bind()
    {
        $result = $this->m_genrateToken->Save_All_Bind();
        echo json_encode($result);
        return json_encode($result);
    }

    public function save_object_binding()
    {
        $result = $this->m_genrateToken->Save_Object_Binding();
        echo json_encode($result);
        return json_encode($result);
    }
    public function save_series_binding()
    {
        $result = $this->m_genrateToken->Save_Series_Binding();
        echo json_encode($result);
        return json_encode($result);
    }
    public function save_model_binding()
    {
        $result = $this->m_genrateToken->Save_Model_Binding();
        echo json_encode($result);
        return json_encode($result);
    }
    public function get_lzw_config_detail()
    {
        $result = $this->m_genrateToken->Get_Lzw_Config_Detail();
        echo json_encode($result);
        return json_encode($result);
    }
    public function hello()
    {
        echo "hello";
    }

}
