<?php class c_merchant extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('merchant/m_merchant');

        /*=====  End of Section lz_bigData db connection block  ======*/
        if (!$this->loginmodel->is_logged_in()) {
            redirect('login/login/');
        }
    }

    public function index()
    {

        $result['get_stat'] = $this->m_merchant->get_states();

        $this->load->view('merchant/v_merchant', $result);

    }

    public function merch_lot()
    {

        $result['lot_deta'] = $this->m_merchant->merchant_lot_details();
        $result['merchant'] = $this->m_merchant->get_merchant();
        // print_r($result['merchant']);
        $this->load->view('merchant/v_merch_lot', $result);

    }

    public function get_lot_det()
    {

        $data = $this->m_merchant->get_lot_det();
        echo json_encode($data);
        return json_encode($data);

    }
    public function get_merchant_acount_name()
    {
        $data['data'] = $this->m_merchant->get_Merchant_Acount_Name();
        echo json_encode($data);
        return json_encode($data);
    }
    public function update_lot()
    {

        $data = $this->m_merchant->update_lot();
        echo json_encode($data);
        return json_encode($data);

    }
    public function save_merch_lot()
    {

        $data = $this->m_merchant->save_merch_lot();
        if ($data == true) {

            redirect('merchant/c_merchant/merch_lot');

        }

    }

    public function save_merchant()
    {

        $data = $this->m_merchant->save_merchant();

        if ($data == true) {

            redirect('merchant/c_merchant/');

        }
    }
    public function update_merchant_view()
    {
        $result['get_stat'] = $this->m_merchant->get_states();

        $result['merch_deta'] = $this->m_merchant->update_merchant_view();
        $this->load->view('merchant/v_merchant_update', $result);

    }

    public function update_merchant()
    {

        $data = $this->m_merchant->update_merchant();

        if ($data == true) {

            redirect('merchant/c_merchant/');

        }
    }
    public function gen_barcode()
    {
        $data['pageTitle'] = 'Generate Barcode';
        $data['list'] = $this->m_merchant->gen_barcode();
        $data['avail_lot'] = $this->m_merchant->avail_lot();
        $data['get_mer_name'] = $this->m_merchant->get_merchant();
        $data['seller_account'] = $this->m_merchant->get_Merchant_Acount_Name();
        $this->load->view('merchant/v_generate_barcode', $data);

        // if($data == true){

        //   redirect('merchant/c_merchant/');

        // }
    }

    public function get_mech_lots()
    {

        $data = $this->m_merchant->get_mech_lots();
        echo json_encode($data);
        return json_encode($data);

    }
    public function get_total_bar()
    {

        $data = $this->m_merchant->get_total_bar();
        echo json_encode($data);
        return json_encode($data);

    }
    public function print_barcode()
    {

        $result = $this->m_merchant->print_barcode();
        $chek_rang = $result[0]['RANGE_ID'];

        if ($chek_rang == 1) {
            $no_of_barcode = $result[0]['NO_OF_BARCODE'];
            $len = count($result);

            $get_first = $result[0]['BARCODE_NO'] . "-";
            $get_last = $result[$len - 1]['BARCODE_NO'];

            $this->load->library('m_pdf');

            $i = 0;
            foreach ($result as $data) {

                $k = $i;
                $j = $k + 1;
                $text = $data["BUISNESS_NAME"];
                $item_desc = implode("<br/>", str_split($text, 40));
                $lot_desc = implode("<br/>", str_split($data['LOT_DESC'], 40));
                $html = '<div style = "margin-left:-35px!important;">
                <div style="width:222px !important;" class="barcodecell"><barcode height="0.75" size="1.18" code="' . @$data["BARCODE_NO"] . '" type="C128A" class="barcode" /></div>

            <div style="margin-top:6px !important;width:222px;padding:0;font-size:10px;font-family:arial;">
            <span><b>' .
                @$data["BARCODE_NO"] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>' .
                @$data["REF_NO"] . '</u>&nbsp;&nbsp;Lot Id:' .
                @$data['LOT_ID'] . '</span><br>
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
        } elseif ($chek_rang == 0) {

            $this->load->library('m_pdf');

            $i = 0;
            foreach ($result as $data) {

                $text = $data["BUISNESS_NAME"];
                $item_desc = implode("<br/>", str_split($text, 40));
                $lot_desc = implode("<br/>", str_split($data['LOT_DESC'], 40));
                $html = '<div style = "margin-left:-35px!important;">
                <div style="width:222px !important;" class="barcodecell"><barcode height="0.75" size="1.18" code="' . @$data["BARCODE_NO"] . '" type="C128A" class="barcode" /></div>

            <div style="margin-top:6px !important;width:222px;padding:0;font-size:10px;font-family:arial;">
            <span><b>' .
                @$data["BARCODE_NO"] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>' .
                @$data["REF_NO"] . '</u>&nbsp;&nbsp;<br></b>Lot Id:' .
                @$data['LOT_ID'] . '</span><br>
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
    public function barcodeDetail()
    {

        $data = $this->m_merchant->barcodeDetail();
        echo json_encode($data);
        return json_encode($data);
    }
    public function printBarcode()
    {

        $result = $this->m_merchant->printBarcode();

        $this->load->library('m_pdf');
        // to increse or decrese the width of barcode please set size attribute in barcode tag
        //$i = 0;
        foreach ($result as $data) {
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
            //generate the PDF from the given html
            $this->m_pdf->pdf->WriteHTML($html);
            // $i++;
            // if(!empty($result[$i])){
            //   $this->m_pdf->pdf->AddPage();
            // }

        } //end foreach

        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "I");
    }
    public function printAllBarcode()
    {

        $result = $this->m_merchant->printAllBarcode();

        $chek_rang = $result[0]['RANGE_ID'];

        if ($chek_rang == 1) {
            $no_of_barcode = $result[0]['NO_OF_BARCODE'];
            $len = count($result);

            $get_first = $result[0]['BARCODE_NO'] . "-";
            $get_last = $result[$len - 1]['BARCODE_NO'];

            $this->load->library('m_pdf');

            $i = 0;
            foreach ($result as $data) {

                $k = $i;
                $j = $k + 1;
                $text = $data["BUISNESS_NAME"];
                $item_desc = implode("<br/>", str_split($text, 40));
                $lot_desc = implode("<br/>", str_split($data['LOT_DESC'], 40));
                $html = '<div style = "margin-left:-35px!important;">
                <div style="width:222px !important;" class="barcodecell"><barcode height="0.75" size="1.18" code="' . @$data["BARCODE_NO"] . '" type="C128A" class="barcode" /></div>

            <div style="margin-top:6px !important;width:222px;padding:0;font-size:10px;font-family:arial;">
            <span><b>' .
                @$data["BARCODE_NO"] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>' .
                @$data["REF_NO"] . '</u>&nbsp;&nbsp;<br>' .
                @$item_desc . '</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:8px;">' .
                @$data["ISSUED_DATE"] . '</span><br><span style="margin-top:3px!important; font-size:9px!important;font-family:arial;">' .
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

                $text = $data["BUISNESS_NAME"];
                $item_desc = implode("<br/>", str_split($text, 40));
                $lot_desc = implode("<br/>", str_split($data['LOT_DESC'], 40));
                $html = '<div style = "margin-left:-35px!important;">
                <div style="width:222px !important;" class="barcodecell"><barcode height="0.75" size="1.18" code="' . @$data["BARCODE_NO"] . '" type="C128A" class="barcode" /></div>

            <div style="margin-top:6px !important;width:222px;padding:0;font-size:10px;font-family:arial;">
            <span><b>' .
                @$data["BARCODE_NO"] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>' .
                @$data["REF_NO"] . '</u>&nbsp;&nbsp;<br>' .
                @$item_desc . '</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:8px;">' .
                @$data["ISSUED_DATE"] . '</span><br><span style="margin-top:3px!important; font-size:9px!important;font-family:arial;">' .
                @$lot_desc . '</span><br>
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

    public function del_merchant()
    {

        $get_merch_id = $this->uri->segment(4);

        $this->db->query("DELETE FROM LZ_MERCHANT_MT K WHERE K.MERCHANT_ID = $get_merch_id ");

    }

    public function save_bar_cost()
    {
        $data = $this->m_merchant->save_bar_cost();
        echo json_encode($data);
        return json_encode($data);
    }
    public function save_rang_bar_cost()
    {
        $data = $this->m_merchant->save_rang_bar_cost();
        echo json_encode($data);
        return json_encode($data);
    }
}
