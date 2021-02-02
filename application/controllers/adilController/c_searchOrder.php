<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");

class c_searchOrder extends CI_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('adilModels/m_searchOrder');
    }
    
    public function get_search_order_record()
    {
        $data = $this->m_searchOrder->get_search_order_record();
        
        echo json_encode($data);
        return json_encode($data);
    }
    public function printBarcode(){
    
      $result = $this->m_searchOrder->printBarcode();

      $this->load->library('m_pdf');
    // to increse or decrese the width of barcode please set size attribute in barcode tag
        $i = 0;
        foreach($result as $data){
          $text = $data["BUISNESS_NAME"];
          $item_desc =implode("<br/>", str_split($text, 40));
          $lot_desc =implode("<br/>", str_split($data['LOT_DESC'], 40));
          $html ='<div style = "margin-left:-35px!important;">
                <div style="width:222px !important;" class="barcodecell"><barcode height="0.75" size="1.18" code="'.@$data["BARCODE_NO"].'" type="C128A" class="barcode" /></div>
            
            <div style="margin-top:6px !important;width:222px;padding:0;font-size:10px;font-family:arial;">
            <span><b>'.
              @$data["BARCODE_NO"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>C
              </u>&nbsp;&nbsp;<br></b>Release Date: '.
              @$data['RELEASE_DATE'].'</span><br>
              <br></span></div>
                </div>';
          //generate the PDF from the given html
          $this->m_pdf->pdf->WriteHTML($html);
          $i++;
          if(!empty($result[$i])){
            $this->m_pdf->pdf->AddPage();
          }
          
        }//end foreach
        
      //download it.
      $this->m_pdf->pdf->Output($pdfFilePath, "I");
    }
    public function check_eligibility()
    {
        $order_id   = trim($this->input->post('order_id'));
        $account_id = $this->input->post("account_id");
        $accounts   = $this->db->query("SELECT A.SITE_TOKEN FROM LZ_SELLER_ACCTS A WHERE A.LZ_SELLER_ACCT_ID = $account_id")->result_array();
        
        if ($accounts) {
            $authToken = $accounts[0]['SITE_TOKEN'];
        }
        $post_data = json_encode(array(
            'legacyOrderId' => $order_id
            
        ));
        
        $url    = 'https://api.ebay.com/post-order/v2/cancellation/check_eligibility';
        $header = array(
            'Accept: application/json',
            'Authorization: TOKEN ' . $authToken,
            'Content-Type: application/json',
            'X-EBAY-C-MARKETPLACE-ID: EBAY-US'
        );
        $ch     = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($ch);
        $json     = json_decode($response, TRUE);
        if (curl_errno($ch)) {
            echo "ERROR:" . curl_error($ch);
        }
        curl_close($ch);
        $json     = json_decode($response, TRUE);
        $eligible = $json['eligible'];
        if ($eligible == TRUE) {
            $legecyId = $json['legacyOrderId'];
            foreach ($json['eligibleCancelReason'] as $key => $value) {
                $json['eligibleCancelReason'][$key] = str_replace("_", " ", $value);
            }
            echo json_encode(array(
                'found' => true,
                'legecyId' => $legecyId,
                'reason' => $json['eligibleCancelReason']
            ));
            return json_encode(array(
                'found' => true,
                'legecyId' => $legecyId,
                'reason' => $json['eligibleCancelReason']
            ));
        } else {
          $group_record_number = $this->db->query("SELECT SALES_RECORD_NO_GROUP FROM LZ_SALESLOAD_DET WHERE ORDER_ID ='$order_id'")->row();
          $group_record_number =$group_record_number->SALES_RECORD_NO_GROUP;
          $bar_codes =  array();
          if($group_record_number){
            $order_ids = $this->m_searchOrder->get_order_ids_by_group_record($group_record_number);
            
            foreach ($order_ids as $key => $value) {
              // echo $value['ORDER_ID'];
              $bar_codes1 = $this->m_searchOrder->get_bar_codes($value['ORDER_ID']);
              foreach ($bar_codes1 as $key => $value1) {
                $bar_codes1[$key]['ORDER_ID'] = $value['ORDER_ID'];
              }
              array_push($bar_codes ,$bar_codes1);
            }
            // echo '<pre>';
            //  print_r($bar_codes);
            // exit();
          }else{
            $bar_codes1 = $this->m_searchOrder->get_bar_codes($order_id);
            foreach ($bar_codes1 as $key => $value1) {
              $bar_codes1[$key]['ORDER_ID'] = $order_id;
            }
            array_push($bar_codes ,$bar_codes1);
            
          }

          // $bar_codes = $this->m_searchOrder->get_bar_codes($order_id);
          
          // echo "<pre>";
          // print_r($bar_codes);
          echo json_encode(array(
                'found' => false,
                'legecyId' => $order_id,
                'barcodes' => $bar_codes,
                'message' => 'Sorry item is not eligible due to : ' 
            ));
            return json_encode(array(
                'found' => false,
                'legecyId' => $order_id,
                'barcodes' => $bar_codes,
                'message' => 'Sorry item is not eligible due to : '
            ));
          
        }
        
    }
    function cancellation_request()
    {
        
        $legecyId       = trim($this->input->post('legecyId'));
        $remarks        = $this->input->post('remarks');
        $remarks        = str_replace(" ", "_", $remarks);
        $account_id     = $this->input->post("account_id");
        $userId         = $this->input->post("userId");
        $barcode_status = $this->input->post("barcode_status");
        $releaseRemarks = $this->input->post("releaseRemarks");
        $requestType    = $this->input->post("requestType");
        $bin_id    = $this->input->post("bin_id");
        $barcode_no    = $this->input->post("barcode_no");
        
        $accounts       = $this->db->query("SELECT A.SITE_TOKEN FROM LZ_SELLER_ACCTS A WHERE A.LZ_SELLER_ACCT_ID = $account_id")->result_array();
        
        if ($accounts) {
            $authToken = $accounts[0]['SITE_TOKEN'];
        }
        $header = array(
            'Accept: application/json',
            'Authorization: TOKEN ' . $authToken,
            'Content-Type: application/json',
            'X-EBAY-C-MARKETPLACE-ID: EBAY-US'
        );
        if ($requestType == 'CANCEL') {
            $post_data = json_encode(array(
                'legacyOrderId' => $legecyId,
                'cancelReason' => $remarks,
                'buyerPaid' => false
            ));
            $url       = 'https://api.ebay.com/post-order/v2/cancellation/';
            $ch        = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            $response = curl_exec($ch);
            $json     = json_decode($response, TRUE);
            if (curl_errno($ch)) {
                echo "ERROR:" . curl_error($ch);
            }
            curl_close($ch);
            $cancelId = $json['cancelId'];
            if ($cancelId) {
                $url = 'https://api.ebay.com/post-order/v2/cancellation/' . $cancelId;
                $ch  = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                curl_setopt($ch, CURLOPT_POST, 0);
                // curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                $response = curl_exec($ch);
                $json     = json_decode($response, TRUE);
                if (curl_errno($ch)) {
                    echo "ERROR:" . curl_error($ch);
                }
                curl_close($ch);
                date_default_timezone_set("America/Chicago");
                $date                = date('Y-m-d H:i:s');
                $insert_date         = "TO_DATE('" . $date . "', 'YYYY-MM-DD HH24:MI:SS')";
                $ebay_cancel_id      = $json['cancelDetail']['cancelId'];
                $marketplace_id      = $json['cancelDetail']['marketplaceId'];
                $legacy_order_id     = $json['cancelDetail']['legacyOrderId'];
                $requestor_type      = $json['cancelDetail']['requestorType'];
                $cancel_reason       = $json['cancelDetail']['cancelReason'];
                $cancel_state        = $json['cancelDetail']['cancelState'];
                $cancel_status       = $json['cancelDetail']['cancelStatus'];
                $cancel_close_reason = $json['cancelDetail']['cancelCloseReason'];
                $payment_status      = $json['cancelDetail']['paymentStatus'];
                
                $alreadyExit = $this->db->query("SELECT C.EBAY_CANCEL_ID FROM LJ_CANCELLATION_MT C WHERE C.EBAY_CANCEL_ID = $ebay_cancel_id")->result_array();
                if (!$alreadyExit) {
                    $cancel_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LJ_CANCELLATION_MT','CANCELLATION_ID') CANCELLATION_ID FROM DUAL")->result_array();
                    $cancel_id = $cancel_id[0]['CANCELLATION_ID'];
                    
                    $this->db->query("INSERT INTO LJ_CANCELLATION_MT C (C.CANCELLATION_ID,C.EBAY_CANCEL_ID,C.MARKETPLACE_ID,C.REQUESTOR_TYPE,C.CANCEL_STATE,C.CANCEL_STATUS,C.CANCEL_CLOSE_REASON,C.PAYMENT_STATUS,C.CANCEL_REASON,C.LEGACY_ORDER_ID,C.CREATED_AT,C.CREATED_BY,C.ACCOUNT_ID,C.STATUS)
                    values ($cancel_id,$ebay_cancel_id,'$marketplace_id','$requestor_type','$cancel_state','$cancel_status','$cancel_close_reason','$payment_status','$cancel_reason','$legacy_order_id',$insert_date,$userId,$account_id,'1')");
                    $barcodes = $this->db->query("SELECT B.BARCODE_NO FROM LZ_BARCODE_MT B WHERE B.ORDER_ID = (SELECT DT.ORDER_ID FROM LZ_SALESLOAD_DET DT WHERE DT.EXTENDEDORDERID =  '$legacy_order_id' AND ROWNUM = 1) ")->result_array();
                    if ($barcodes) {
                        foreach ($barcodes as $bar) {
                            $barcode = $bar['BARCODE_NO'];
                            $this->db->query("INSERT INTO LJ_CANCELLATION_DT CD (CD.CANCELLATION_DT_ID,CD.CANCELLATION_ID,CD.BARCODE_NO)
                                                             values (
                                                                 GET_SINGLE_PRIMARY_KEY('LJ_CANCELLATION_DT','CANCELLATION_DT_ID'),
                                                                 $cancel_id,
                                                                 $barcode) ");
                            
                        }
                    }
                } else {
                        $cancellation_id = $alreadyExit[0]['CANCELLATION_ID'];
                        $this->db->query("UPDATE LJ_CANCELLATION_MT C 
                        SET
                        C.EBAY_CANCEL_ID = $ebay_cancel_id,
                        C.MARKETPLACE_ID = '$marketplace_id',
                        C.REQUESTOR_TYPE = '$requestor_type',
                        C.CANCEL_STATE   = '$cancel_state',
                        C.CANCEL_STATUS  = '$cancel_status',
                        C.CANCEL_CLOSE_REASON = '$cancel_close_reason',
                        C.PAYMENT_STATUS = '$payment_status',
                        C.CANCEL_REASON = '$cancel_reason',
                        C.LEGACY_ORDER_ID = '$legacy_order_id',
                        C.ACCOUNT_ID = $merchant_id,
                        C.STATUS = '0'
                        WHERE C.CANCELLATION_ID = $cancellation_id");
                    }
                        echo json_encode(array(
                            'found' => true,
                            'message' => 'Item is cancelled successfully'
                        ));
                        return json_encode(array(
                            'found' => true,
                            'message' => 'Item is cancelled successfully'
                        ));
            } else {
                echo "here";
            }
        }else{
              $data = $this->m_searchOrder->processCancel($legecyId,$releaseRemarks,$userId,$bin_id,$barcode_no);
              if($data){
                if($data == 'release'){
                echo json_encode(array(
                  'found' => true,
                  'message' => 'Item successfully release!'
              ));
              return json_encode(array(
                  'found' => true,
                  'message' => 'Item successfully release!'
              ));
              }else{
                echo json_encode(array(
                  'found' => true,
                  'message' => 'Item successfully discard!'
              ));
              return json_encode(array(
                  'found' => true,
                  'message' => 'Item successfully discard!'
              ));
              }
          }
        }
    }
    public function get_cancelled_barcode()
    {
      $bar_codes = $this->m_searchOrder->get_cancelled_barcode();
      echo json_encode(array(
        'found' => true,
        'barcodes' => $bar_codes
        
    ));
    return json_encode(array(
        'found' => true,
        'barcodes' => $bar_codes
        
    ));
  
    }
    public function get_cancelled_barcode_records()
    {
      $records = $this->m_searchOrder->get_cancelled_barcode_records();
      echo json_encode(array(
        'found' => true,
        'records' => $records
        
    ));
    return json_encode(array(
        'found' => true,
        'records' => $records
        
    ));
  
    }
}