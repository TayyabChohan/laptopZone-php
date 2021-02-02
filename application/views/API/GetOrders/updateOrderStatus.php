<?php
use Kreait\Firebase\Configuration;
use Kreait\Firebase\Firebase;

require __DIR__.'/vendor/autoload.php';
$config = new Configuration();
$config->setAuthConfigFile(__DIR__.'/secret/orderpulling-0a04788d3b7b.json');
$firebase = new Firebase('https://orderpulling.firebaseio.com/', $config);
/*  � 2013 eBay Inc., All Rights Reserved */ //Test
/* Licensed under CDDL 1.0 -  http://opensource.org/licenses/cddl1.php */
//header("Content-Type: text/html; charset=UTF-8");
//$response = simplexml_import_dom($responseDoc);
if ($entries == 0) {
    echo "Sorry No entries found in the Time period requested. Change CreateTimeFrom/CreateTimeTo and Try again";
} else {
    $orders = $response->OrderArray->Order;
    if ($orders != null) {

        foreach ($orders as $order) {

            $orderid=$order->OrderID;
            $orderStatus = $order->OrderStatus;
            $trackingnumber = $order->TransactionArray->Transaction->ShippingDetails->ShipmentTrackingDetails->ShipmentTrackingNumber;
            // $transactions = $order->TransactionArray;
            $SALES_RECORD_NUMBER = $order->ShippingDetails->SellingManagerSalesRecordNumber;
        //     foreach ($transactions->Transaction as $transaction) {
        //         $orderlineitemid = $transaction->OrderLineItemID;
        // /*===========================================================
        // =            check order id already exist or not            =
        // ===========================================================*/
        //     $select_query = "select * from LZ_SALESLOAD_det d where d.order_id = '$orderlineitemid'";
        //         // $select =oci_parse($conn, $select_query);
        //         // oci_execute($select,OCI_DEFAULT);
        //         // $num_row = oci_fetch_array($select, OCI_ASSOC);
        //         $row = $this->db->query($select_query)->result_array();

        //     // ===================== End Checking if record already exist ===============================

        //        if(count($row) > 0){
        //         if($trackingnumber){$TRACKING_NUMBER= $trackingnumber;}else{$TRACKING_NUMBER= '';}
        //         if(!empty($order->ShippedTime)){
        //         $shippedtime=$order->ShippedTime;
        //         $shippedtime = str_split($shippedtime,19);
        //         $shippedtime = str_replace('T'," ",$shippedtime[0]);
        //         }else{
        //             $shippedtime=0;
        //         }
        //         if($shippedtime){$SHIPPED_ON_DATE= "TO_DATE('".$shippedtime."', 'YYYY-MM-DD HH24:MI:SS')";}else{$SHIPPED_ON_DATE="''";}
        //         $qry = "UPDATE LZ_SALESLOAD_DET SET TRACKING_NUMBER ='$TRACKING_NUMBER',SHIPPED_ON_DATE = $SHIPPED_ON_DATE,ORDERSTATUS='$orderStatus' WHERE ORDER_ID = '$orderlineitemid'";
        //          $this->db->query($qry);

        //          /*=========================================
        //         =            upload data to fb            =
        //         =========================================*/
        //         $data=file_get_contents('https://orderpulling.firebaseio.com/test_orders/'.$SALES_RECORD_NUMBER.'.json');

        //         if($data != 'null'){
        //             //echo "found";
        //             require __DIR__.'/vendor/autoload.php';
        //             $config = new Configuration();
        //             $config->setAuthConfigFile(__DIR__.'/secret/orderpulling-0a04788d3b7b.json');
        //             $firebase = new Firebase('https://orderpulling.firebaseio.com/', $config);

        //             if($orderStatus === "Completed"){
        //                 $orderStatus = 'AWAITING';
        //             }
        //             $orderNode = 'test_orders/'.$SALES_RECORD_NUMBER;
        //             if(!empty($TRACKING_NUMBER)){
        //               $firebase->update([
        //               'EBAY_STATUS' => (string)$orderStatus,
        //               'TrackingNumber' => (string)$TRACKING_NUMBER,
        //               'ORDER_STATUS' => "COMPLETED"
        //             ], $orderNode);
        //             }else{
        //                $firebase->update([
        //               'EBAY_STATUS' => (string)$orderStatus,
        //               'TrackingNumber' => (string)$TRACKING_NUMBER
        //             ], $orderNode); 
        //             }
                    

        //         }else{
        //             echo "order not found FB: $SALES_RECORD_NUMBER";
        //         }
        //         if($orderlineitemid === $orderid){
        //             continue 2;// skip the code below and move to next order id of outer foreach
        //         }else{
        //             continue;// skip the code below and move to next order id of current foreach
        //         }
             
        //        }else{// if(count($row) > 0){ end
        //                 // =============== Start Checking if record already exist in lz_salesload_mt table ===============
        //             $current_date=date('Y-m-d');
        //             $current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD')";
        //             $q ="SELECT * FROM (select * from LZ_SALESLOAD_MT where loading_date like $current_date and LZ_SELLER_ACCT_ID=$LZ_SELLER_ACCT_ID ORDER BY LZ_SALELOAD_ID DESC) WHERE ROWNUM = 1";
        //             $row = $this->db->query($q);//->result_array();
        //                 // =============== End Checking if record already exist in lz_salesload_mt table ===============

        //             // ========================== Starts Insertion in MT table ===============================
        //              if($row->num_rows() == 0)
        //             {
        //                 $max_id = "SELECT GET_SINGLE_PRIMARY_KEY('LZ_SALESLOAD_MT','LZ_SALELOAD_ID') LZ_SALELOAD_ID FROM DUAL";
        //                 $row = $this->db->query($max_id)->result_array();
        //                 $LZ_SALELOAD_ID = $row[0]['LZ_SALELOAD_ID'];
        //                 $max_id = "SELECT GET_SINGLE_PRIMARY_KEY('LZ_SALESLOAD_MT','LOADING_NO') LOADING_NO FROM DUAL";
        //                 $row = $this->db->query($max_id)->result_array();
        //                 $LOADING_NO = $row[0]['LOADING_NO'];
        //                 $LOADING_DATE=date('m/d/Y');
        //                 $SALES_REF_NO=date('m/d/Y');
        //                 $EXCEL_FILE_NAME=date('m/d/Y');
        //                 $EXCEL_FILE_NAME=$EXCEL_FILE_NAME."_".$LZ_SELLER_ACCT_ID;
        //                 $POSTED='Post in ERP';
        //                 $comma = ',';
        //                 $insert_qry = "INSERT INTO lz_salesload_mt VALUES($LZ_SALELOAD_ID $comma $LOADING_NO $comma TO_DATE('$LOADING_DATE', 'mm/dd/yyyy') $comma '$SALES_REF_NO' $comma NULL $comma '$EXCEL_FILE_NAME' $comma '$POSTED' $comma $LZ_SELLER_ACCT_ID )";
        //                 $this->db->query($insert_qry);
        //             }
        //             else{
        //                 $row = $this->db->query($q)->result_array();
        //                 $LZ_SALELOAD_ID = $row[0]['LZ_SALELOAD_ID'];
        //             }
            
        //             // ========================== End Insertion in MT table ===============================
        //        }//else close if(count($row) > 0){ 
        //     }// end foreach ($transactions->Transaction as $transaction) {
            

                   
            /*=====  End of check order id already exist or not  ======*/
            
/* ==================== Start Checking Status of Order ============================  */
            if($orderStatus == 'Completed' || $orderStatus == 'Cancelled' || ($orderStatus == 'Active' && !empty($trackingnumber)))
            {
                if(!empty($order->ShippedTime)){
                $shippedtime=$order->ShippedTime;
                $shippedtime = str_split($shippedtime,19);
                $shippedtime = str_replace('T'," ",$shippedtime[0]);
                }else{
                        $shippedtime=0;
                }
                $buyeruserid=$order->BuyerUserID;
                $paidtime= $order->PaidTime;
                $paidtime = str_split($paidtime,19);
                $paidtime = str_replace('T'," ",$paidtime[0]);
                
                $recordnumber = $order->ShippingDetails->SellingManagerSalesRecordNumber;
                $SALE_RECORD_NO_GROUP_ID = $recordnumber;
                $trackingnumber= $order->TransactionArray->Transaction->ShippingDetails->ShipmentTrackingDetails->ShipmentTrackingNumber;
                $salestaxamount=$order->ShippingDetails->SalesTax->SalesTaxAmount;
                if(!isset($salestaxamount))
                {
                    $salestaxamount = 0;
                }
                $total =$order->Total;
                $checkoutdate = $order->CheckoutStatus->LastModifiedTime;
                $checkoutdate = str_split($checkoutdate,19);
                $checkoutdate = str_replace('T'," ",$checkoutdate[0]);
                $paymentmethod = $order->CheckoutStatus->PaymentMethod;
                if($paymentmethod){
                        $paymentmethod = $order->CheckoutStatus->PaymentMethod;
                    }else{
                        $paymentmethod = '';
                    }
                
                //if the order is completed, print details
                if ($orderStatus) {

                    // get the amount paid
                    //$AmountPaid = $order->AmountPaid;
                    // $AmountPaidAttr = $AmountPaid->attributes();
                    // $AmountPaid = $AmountPaid . " "  .$AmountPaidAttr["currencyID"];
                    // get the payment method 
                    // if($order->PaymentMethods){
                    //     $paymentmethod = $order->PaymentMethods;
                    // }else{
                    //     $paymentmethod = 'NULL';
                    // }
                    // get the checkout message left by the buyer, if any
                    if ($order->BuyerCheckoutMessage) {
                        $buyercheckoutmsg= $order->BuyerCheckoutMessage;
                    }else{
                        $buyercheckoutmsg= '';
                    }

                    // get the sales tax, if any 
                    // $SalesTaxAmount = $order->ShippingDetails->SalesTax->SalesTaxAmount;
                    // $SalesTaxAmountAttr = $SalesTaxAmount->attributes();
                    // $SalesTaxAmount = $SalesTaxAmount. " " .$SalesTaxAmountAttr["currencyID"];
                    // get the external transaction information - if payment is made via PayPal, then this is the PayPal transaction info
                    $externalTransaction = $order->ExternalTransaction;
                    if ($externalTransaction) {
                        $externaltransactionid=$externalTransaction->ExternalTransactionID;
                        $paiddate= $externalTransaction->ExternalTransactionTime;
                        $paiddate = str_split($paiddate,19);
                        $paiddate = str_replace('T'," ",$paiddate[0]);
                        $externalTransactionFeeAttr = $externalTransaction->FeeOrCreditAmount->attributes();
                        //$paypalfee =$externalTransaction->FeeOrCreditAmount . " " .$externalTransactionFeeAttr["currencyID"];
                        $paypalfee =$externalTransaction->FeeOrCreditAmount;
                        $paymentorrefundamount= $externalTransaction->PaymentOrRefundAmount . " " .$externalTransactionFeeAttr["currencyID"];
                    }else{
                        $paiddate = '';
                        $externaltransactionid='';
                        //$paypalfee =$externalTransaction->FeeOrCreditAmount . " " .$externalTransactionFeeAttr["currencyID"];
                        $paypalfee ='';
                        $paymentorrefundamount= '';
                    }
                    // get the shipping service selected by the buyer
                    $ShippingServiceSelected = $order->ShippingServiceSelected;
                    if($ShippingServiceSelected){
                    $shippingservice=$ShippingServiceSelected->ShippingService;
                    //$ShippingCostAttr = $ShippingServiceSelected->ShippingServiceCost->attributes();
                    //$shippingservicecost = $ShippingServiceSelected->ShippingServiceCost . " " . $ShippingCostAttr["currencyID"];
                    $shippingservicecost = $ShippingServiceSelected->ShippingServiceCost;
                    }
     // get the buyer's shipping address 
                    $shippingAddress = $order->ShippingAddress;
                    $SHIP_TO_NAME= $shippingAddress->Name;
                    $SHIP_TO_NAME = trim(str_replace("  ", '', $SHIP_TO_NAME));
                    $SHIP_TO_NAME = trim(str_replace(array("'", '"'), "''", $SHIP_TO_NAME));
                    $address = $SHIP_TO_NAME . ",";
                    if ($shippingAddress->Street1 != null) {
                        $SHIP_TO_ADDRESS1= $shippingAddress->Street1;
                        $SHIP_TO_ADDRESS1 = trim(str_replace("  ", '', $SHIP_TO_ADDRESS1));
                        $SHIP_TO_ADDRESS1 = trim(str_replace(array("'", '"'), "''", $SHIP_TO_ADDRESS1));
                        $address .=  $SHIP_TO_ADDRESS1 . ",";
                        $street1=$SHIP_TO_ADDRESS1;
                    }
                    if ($shippingAddress->Street2 != null) {
                        $SHIP_TO_ADDRESS2= $shippingAddress->Street2;
                        $SHIP_TO_ADDRESS2 = trim(str_replace("  ", '', $SHIP_TO_ADDRESS2));
                        $SHIP_TO_ADDRESS2 = trim(str_replace(array("'", '"'), "''", $SHIP_TO_ADDRESS2));
                        $address .=  $SHIP_TO_ADDRESS2 ;
                        $street2=$SHIP_TO_ADDRESS2;
                    }
                    if ($shippingAddress->AddressID != null) {
                        $addressid=$shippingAddress->AddressID;
                    }
                    if ($shippingAddress->CityName != null) {
                        $SHIP_TO_CITY= $shippingAddress->CityName;
                        $SHIP_TO_CITY = trim(str_replace("  ", '', $SHIP_TO_CITY));
                        $SHIP_TO_CITY = trim(str_replace(array("'", '"'), "''", $SHIP_TO_CITY));
                        $address .= $SHIP_TO_CITY . ",";
                        $city =$SHIP_TO_CITY;
                    }
                    if ($shippingAddress->StateOrProvince != null) {
                        $SHIP_TO_STATE= $shippingAddress->StateOrProvince;
                        $SHIP_TO_STATE = trim(str_replace("  ", '', $SHIP_TO_STATE));
                        $SHIP_TO_STATE = trim(str_replace(array("'", '"'), "''", $SHIP_TO_STATE));
                        $address .= $SHIP_TO_STATE . "-";
                        $stateorprovince = $SHIP_TO_STATE;
                    }
                    if ($shippingAddress->PostalCode != null) {
                        $SHIP_TO_ZIP= $shippingAddress->PostalCode;
                        $SHIP_TO_ZIP = trim(str_replace("  ", '', $SHIP_TO_ZIP));
                        $SHIP_TO_ZIP = trim(str_replace(array("'", '"'), "''", $SHIP_TO_ZIP));
                        $address .= $SHIP_TO_ZIP . ",";
                        $postalcode=$SHIP_TO_ZIP;
                    }
                    if ($shippingAddress->CountryName != null) {
                        $SHIP_TO_COUNTRY= $shippingAddress->CountryName;
                        $SHIP_TO_COUNTRY = trim(str_replace("  ", '', $SHIP_TO_COUNTRY));
                        $SHIP_TO_COUNTRY = trim(str_replace(array("'", '"'), "''", $SHIP_TO_COUNTRY));
                        $address .= $SHIP_TO_COUNTRY . ".";
                        $countryname = $SHIP_TO_COUNTRY;
                        
                    }
                    if ($shippingAddress->Phone != null) {
                        $SHIP_TO_PHONE= $shippingAddress->Phone;
                        $SHIP_TO_PHONE = trim(str_replace("  ", '', $SHIP_TO_PHONE));
                        $SHIP_TO_PHONE = trim(str_replace(array("'", '"'), "''", $SHIP_TO_PHONE));
                        $address .=  $SHIP_TO_PHONE . "";
                        $phoneno = $SHIP_TO_PHONE;
                    }
                    if(!$address){
                     $address = '';
                    }

    // =============================Start address in part ===============================
                    // $shippingAddress = $order->ShippingAddress;
                    // $address = $shippingAddress->Name . "\n";
                    // if ($shippingAddress->Street1 != null) {
                    //     $street1=$shippingAddress->Street1;
                    // }
                    // if ($shippingAddress->Street2 != null) {
                    //     $street2=$shippingAddress->Street2;
                    // }
                    // if ($shippingAddress->CityName != null) {
                    //     $city =$shippingAddress->CityName;
                    // }
                    // if ($shippingAddress->StateOrProvince != null) {
                    //     $stateorprovince = $shippingAddress->StateOrProvince;
                    // }
                    // if ($shippingAddress->PostalCode != null) {
                    //     $postalcode=$shippingAddress->PostalCode;
                    // }
                    // if ($shippingAddress->CountryName != null) {
                    //     $countryname = $shippingAddress->CountryName;
                    // }
                    // if ($shippingAddress->Phone != null) {
                    //     $phoneno = $shippingAddress->Phone;
                    // }
                    
    // =========================End address in part =============================    

    // ======================= Start Ship To Address =========================== 
                    $check = $order->IsMultiLegShipping;
    //var_dump($check);
                   if($check=='true'){
                    //echo "from If" . var_dump($check);
                    $node=$order->MultiLegShippingDetails->SellerShipmentToLogisticsProvider->ShipToAddress;
                    //var_dump($node);exit;
                    $address = '';
                    $name = $node->Name;
                    $address .=  $name . ",";
                    $street1 =$node->Street1;
                    $address .=  $street1 . ",";
                    $street2='';
                    $cityname =$node->CityName;
                    $address .=  $cityname ;
                    $state =$node->StateOrProvince;
                    $address .=  $state ;
                    // $country =$node->Country;
                    // $address .=  $country ;
                    $countryname =$node->CountryName;
                    $address .=  $countryname ;
                    $postalcode = $node->PostalCode;
                    $address .=  $postalcode ;
                    //echo $receiver_name."<br>". $receiver_street1 ."<br>" . $receiver_cityname . "<br>".$receiver_state."<br>".$receiver_country."<br>".$receiver_countryname."<br>".$receiver_postalcode;
                   }

    // ======================= End Ship To Address =========================        
                    $transactions = $order->TransactionArray;
                    if ($transactions) {
                        //echo "Transaction Array \n";
                        // iterate through each transaction for the order
                        foreach ($transactions->Transaction as $transaction) {
                            // get the OrderLineItemID, Quantity, buyer's email and SKU
                            $orderlineitemid = $transaction->OrderLineItemID;
                            $ebayid = $transaction->Item->ItemID;
                            $ConditionID = $transaction->Item->ConditionID;
                            $ConditionDisplayName = $transaction->Item->ConditionDisplayName;
                            $datesold = $transaction->CreatedDate;
                            $datesold = str_split($datesold,19);
                            $datesold = str_replace('T'," ",$datesold[0]);
                            //  echo "T removed:".$test;
                            $fb_sold_date = date("m/d/Y H:i:s", strtotime($datesold));
                            //echo "Date Soled:".$datesold;
                            //echo "Date Soled:".$newDate;exit;
                            $extendedorderid = $transaction->ExtendedOrderID; 

                            /*====================================================================
                            =            copy code from insert call to update address            =
                            ====================================================================*/
                            
        $quantitypurchased = $transaction->QuantityPurchased;
        $buyername = $transaction->Buyer->UserFirstName ." ". $transaction->Buyer->UserLastName;
        $buyername = trim(str_replace("  ", '', $buyername));
        $buyername = trim(str_replace(array("'", '"'), "''", $buyername));
        $BUYER_FULLNAME= $buyername;
        $finalvaluefee = $transaction->FinalValueFee;
        $transactionid = $transaction->TransactionID;
        $transactionprice = $transaction->TransactionPrice;
        $BUYER_PHONE_NUMBER= $phoneno;
        $address = trim(str_replace("  ", '', $address));
        $address = trim(str_replace(array("'", '"'), "''", $address));
        $BUYER_ADDRESS1= $address;
        $city = trim(str_replace("  ", '', $city));
        $city = trim(str_replace(array("'", '"'), "''", $city));
        $BUYER_CITY= $city;
        $stateorprovince = trim(str_replace("  ", '', $stateorprovince));
        $stateorprovince = trim(str_replace(array("'", '"'), "''", $stateorprovince));
        $BUYER_STATE= $stateorprovince;
        $BUYER_ZIP= $postalcode;
        $countryname = trim(str_replace("  ", '', $countryname));
        $countryname = trim(str_replace(array("'", '"'), "''", $countryname));
        $BUYER_COUNTRY= $countryname;
        $QUANTITY= $quantitypurchased;
        $SALE_PRICE= $transactionprice;
        $TOTAL_PRICE= $total;
        $SALE_DATE= "TO_DATE('".$datesold."', 'YYYY-MM-DD HH24:MI:SS')"; //to_date('$datesold', 'yyyy/mm/dd')
        $CHECKOUT_DATE= "TO_DATE('".$checkoutdate."', 'YYYY-MM-DD HH24:MI:SS')";
        $PAID_ON_DATE= "TO_DATE('".$paidtime."', 'YYYY-MM-DD HH24:MI:SS')";
        if($shippedtime){$SHIPPED_ON_DATE= "TO_DATE('".$shippedtime."', 'YYYY-MM-DD HH24:MI:SS')";}else{$SHIPPED_ON_DATE="''";}
        $SHIPPING_SERVICE= $shippingservice;
        $EBAY_FEE_PERC= $finalvaluefee;
        $PAYPAL_PER_TRANS_FEE= $paypalfee;
        if($buyercheckoutmsg){
            $buyercheckoutmsg = trim(str_replace("  ", '', $buyercheckoutmsg));
            $buyercheckoutmsg = trim(str_replace(array("'", '"'), "''", $buyercheckoutmsg));
            $BUYER_CHECKOUT_MSG = $buyercheckoutmsg;}else{$BUYER_CHECKOUT_MSG = '';}
        if($street1){
            $street1 = trim(str_replace("  ", '', $street1));
            $street1 = trim(str_replace(array("'", '"'), "''", $street1));
            $BUYER_STREET1=$street1;}else{$BUYER_STREET1='';}
        if(!empty($street2)){
            $street2 = trim(str_replace("  ", '', $street2));
            $street2 = trim(str_replace(array("'", '"'), "''", $street2));
            $BUYER_STREET2=$street2;}else{$BUYER_STREET2='';}
        if($addressid){$BUYER_ADDRESS_ID=$addressid;}else{$BUYER_ADDRESS_ID='';}
                            
                            /*=====  End of copy code from insert call to update address  ======*/
                            
                /*=========================================
                =            check order in db            =
                =========================================*/
        /*===========================================================
        =            check order id already exist or not            =
        ===========================================================*/
            $select_query = "select * from LZ_SALESLOAD_det d where d.order_id = '$orderlineitemid'";
                // $select =oci_parse($conn, $select_query);
                // oci_execute($select,OCI_DEFAULT);
                // $num_row = oci_fetch_array($select, OCI_ASSOC);
                $row = $this->db->query($select_query)->result_array();

            // ===================== End Checking if record already exist ===============================

               if(count($row) > 0){
                if(strpos($orderid, '-') !== false)//if order id contain - its mean its a single order not combine
                {
                  $combine_order_id = '';
                  $combine_group_id = '';
                }else{
                  $combine_order_id = $orderid;
                  $combine_group_id = $SALE_RECORD_NO_GROUP_ID;
                }
                if($trackingnumber){$TRACKING_NUMBER= $trackingnumber;}else{$TRACKING_NUMBER= '';}
                if(!empty($order->ShippedTime)){
                $shippedtime=$order->ShippedTime;
                $shippedtime = str_split($shippedtime,19);
                $shippedtime = str_replace('T'," ",$shippedtime[0]);
                }else{
                    $shippedtime=0;
                }
                //$qry = "INSERT INTO LZ_SALESLOAD_DET (WIZ_ERP_CODE, SALES_RECORD_NUMBER, USER_ID, BUYER_FULLNAME, BUYER_PHONE_NUMBER, BUYER_EMAIL, BUYER_ADDRESS1, BUYER_ADDRESS2, BUYER_CITY, BUYER_STATE, BUYER_ZIP, BUYER_COUNTRY, ITEM_ID, TRANSACTION_ID, ITEM_TITLE, QUANTITY, SALE_PRICE, SHIPPING_AND_HANDLING, SALES_TAX, INSURANCE, TOTAL_PRICE, PAYMENT_METHOD, PAYPAL_TRANSACTION_ID, SALE_DATE, CHECKOUT_DATE, PAID_ON_DATE, SHIPPED_ON_DATE, SHIPPING_SERVICE, FEEDBACK_LEFT, FEEDBACK_RECEIVED, NOTES_TO_YOURSELF, CUSTOM_LABEL, LISTED_ON, SOLD_ON, VARIATION_DETAILS, LZ_SALELOAD_ID, LZ_SALESLOAD_DET_ID, GNRTD_DC_ID, GNRTD_DC_DET_ID, GNRTD_INV_ID, GNRTD_INV_DET_ID, EBAY_FEE_PERC, PAYPAL_FEE_PERC, PAYPAL_PER_TRANS_FEE, POSTED, TRACKING_NUMBER, SHIP_TO_ADDRESS1, SHIP_TO_ADDRESS2, SHIP_TO_CITY, SHIP_TO_STATE, SHIP_TO_ZIP, SHIP_TO_COUNTRY, MANNUAL_YN, MANNUAL_LOADED_BY_EMP_ID, ORDER_ID, BUYER_CHECKOUT_MSG, BUYER_STREET1, BUYER_STREET2, BUYER_ADDRESS_ID, ORDERSTATUS, SHIPPING_CHARGES, SALES_RECORD_NO_GROUP,SHIP_TO_NAME,SHIP_TO_PHONE,COMBINE_ORDER_ID,INSERTED_DATE,EXTENDEDORDERID) VALUES($WIZ_ERP_CODE $comma '$SALES_RECORD_NUMBER' $comma '$USER_ID' $comma '$BUYER_FULLNAME' $comma '$BUYER_PHONE_NUMBER' $comma '$BUYER_EMAIL' $comma '$BUYER_ADDRESS1' $comma '$BUYER_ADDRESS2' $comma '$BUYER_CITY' $comma '$BUYER_STATE' $comma '$BUYER_ZIP' $comma '$BUYER_COUNTRY' $comma '$ITEM_ID' $comma '$TRANSACTION_ID' $comma '$ITEM_TITLE' $comma $QUANTITY $comma $SALE_PRICE $comma $SHIPPING_AND_HANDLING $comma '$SALES_TAX' $comma $INSURANCE $comma $TOTAL_PRICE $comma '$PAYMENT_METHOD' $comma '$PAYPAL_TRANSACTION_ID' $comma $SALE_DATE $comma $CHECKOUT_DATE $comma $PAID_ON_DATE $comma $SHIPPED_ON_DATE $comma '$SHIPPING_SERVICE' $comma '$FEEDBACK_LEFT' $comma '$FEEDBACK_RECEIVED' $comma '$NOTES_TO_YOURSELF' $comma '$CUSTOM_LABEL' $comma '$LISTED_ON' $comma '$SOLD_ON' $comma '$VARIATION_DETAILS' $comma $LZ_SALELOAD_ID $comma $LZ_SALESLOAD_DET_ID $comma '$GNRTD_DC_ID' $comma '$GNRTD_DC_DET_ID' $comma '$GNRTD_INV_ID' $comma '$GNRTD_INV_DET_ID' $comma $EBAY_FEE_PERC $comma '$PAYPAL_FEE_PERC' $comma $PAYPAL_PER_TRANS_FEE $comma '$POSTED' $comma '$TRACKING_NUMBER' $comma '$SHIP_TO_ADDRESS1' $comma '$SHIP_TO_ADDRESS2' $comma '$SHIP_TO_CITY' $comma '$SHIP_TO_STATE' $comma '$SHIP_TO_ZIP' $comma '$SHIP_TO_COUNTRY' $comma '$MANNUAL_YN' $comma '$MANNUAL_LOADED_BY_EMP_ID' $comma '$orderlineitemid' $comma '$BUYER_CHECKOUT_MSG' $comma '$BUYER_STREET1' $comma '$BUYER_STREET2' $comma '$BUYER_ADDRESS_ID' $comma '$ORDERSTATUS' $comma $SHIPPING_CHARGES $comma '$SALE_RECORD_NO_GROUP_ID' $comma '$SHIP_TO_NAME' $comma '$SHIP_TO_PHONE' $comma '$combine_order_id' $comma SYSDATE $comma '$extendedorderid')";

                if($shippedtime){$SHIPPED_ON_DATE= "TO_DATE('".$shippedtime."', 'YYYY-MM-DD HH24:MI:SS')";}else{$SHIPPED_ON_DATE="''";}
                $qry = "UPDATE LZ_SALESLOAD_DET SET BUYER_FULLNAME = '$BUYER_FULLNAME' ,BUYER_PHONE_NUMBER = '$BUYER_PHONE_NUMBER', BUYER_ADDRESS1 = '$BUYER_ADDRESS1' , BUYER_CITY = '$BUYER_CITY', BUYER_STATE = '$BUYER_STATE' , BUYER_ZIP = '$BUYER_ZIP' , BUYER_COUNTRY = '$BUYER_COUNTRY' , QUANTITY = '$QUANTITY'  , SALE_PRICE = '$SALE_PRICE' , TOTAL_PRICE = '$TOTAL_PRICE' , SALE_DATE = $SALE_DATE , CHECKOUT_DATE = $CHECKOUT_DATE , PAID_ON_DATE = $PAID_ON_DATE ,TRACKING_NUMBER ='$TRACKING_NUMBER',SHIPPED_ON_DATE = $SHIPPED_ON_DATE, SHIPPING_SERVICE = '$SHIPPING_SERVICE', EBAY_FEE_PERC = '$EBAY_FEE_PERC', ORDERSTATUS='$orderStatus', PAYPAL_PER_TRANS_FEE='$PAYPAL_PER_TRANS_FEE', SHIP_TO_ADDRESS1='$SHIP_TO_ADDRESS1', SHIP_TO_ADDRESS2='$SHIP_TO_ADDRESS2', SHIP_TO_CITY='$SHIP_TO_CITY' , SHIP_TO_STATE='$SHIP_TO_STATE', SHIP_TO_ZIP='$SHIP_TO_ZIP' , SHIP_TO_COUNTRY='$SHIP_TO_COUNTRY' , BUYER_CHECKOUT_MSG='$BUYER_CHECKOUT_MSG', BUYER_STREET1='$BUYER_STREET1', BUYER_STREET2='$BUYER_STREET2', BUYER_ADDRESS_ID='$BUYER_ADDRESS_ID', SHIP_TO_NAME='$SHIP_TO_NAME', SHIP_TO_PHONE='$SHIP_TO_PHONE' ,COMBINE_ORDER_ID = '$combine_order_id' ,extendedorderid = '$extendedorderid' , ConditionID = '$ConditionID',ConditionDisplayName = '$ConditionDisplayName' WHERE ORDER_ID = '$orderlineitemid'";
                 $this->db->query($qry);
                 // if (php_sapi_name() != "cli") {
                 //        // In cli-mode
                 //        echo "UPDATED: $SALES_RECORD_NUMBER";
                 //    }
                /*=========================================
                =            upload data to fb            =
                =========================================*/

                $data=file_get_contents('https://orderpulling.firebaseio.com/test_orders/'.$SALES_RECORD_NUMBER.'.json');

                if($data != 'null'){
                    //echo "found";

                    if($orderStatus === "Completed"){
                        $orderStatus = 'AWAITING';
                    }
                    $orderNode = 'test_orders/'.$SALES_RECORD_NUMBER;
                    if(!empty($TRACKING_NUMBER)){
                      $firebase->update([
                      'EBAY_STATUS' => (string)$orderStatus,
                      'TrackingNumber' => (string)$TRACKING_NUMBER,
                      'ORDER_STATUS' => "COMPLETED"//,
                      // 'GROUP_SALENO' => $combine_group_id,
                      // 'SALE_DATE' => $fb_sold_date
                    ], $orderNode);
                    }else{ 
                       $firebase->update([
                      'EBAY_STATUS' => (string)$orderStatus,
                      'TrackingNumber' => (string)$TRACKING_NUMBER//,
                      //'ORDER_STATUS' => (string)$orderStatus
                      // 'GROUP_SALENO' => $combine_group_id,
                      // 'SALE_DATE' => $fb_sold_date
                    ], $orderNode); 
                    }
                    
                    if (php_sapi_name() == "cli") {
                        // In cli-mode
                        echo "UPDATED: $SALES_RECORD_NUMBER".PHP_EOL;
                    } else {
                        // Not in cli-mode
                        echo "UPDATED: $SALES_RECORD_NUMBER<br/>";
                    }

                }else{


/*==================================================
=            block copy from inser part            =
==================================================*/
                     if(empty($trackingnumber) AND $orderStatus == 'Completed'){
                        /*================================================
                        =            copy from m_notification            =
                        ================================================*/
                        $main_query = "SELECT decode(l.folder_name, null, decode(dd.folder_name, null, 'master_pictures/' || trim(i.item_mt_upc) || '~' || trim(i.item_mt_mfg_part_no) || '/' || trim(cc.cond_name), 'dekitted_pictures/' || dd.folder_name), 'dekitted_pictures/' || l.folder_name) IMAGE, 'master_pictures/' || trim(i.item_mt_upc) || '~' || trim(i.item_mt_mfg_part_no) || '/' || trim(cc.cond_name) FOL_NAME1, get.* FROM (SELECT ROWNUM RE, SDD.MERCHANT_ID, SDD.BARCODE_NO BARCODEARRAY, SDD.BARCODE_NO def_barcode, SDD.WAREHOUSE_NO, TO_CHAR(SDD.Sale_Date, 'MM/DD/YYYY HH24:MI:SS') SALE_DATE, SDD.USER_ID USER_ID, (SDD.BUYER_FULLNAME) FULLNAME, (SDD.BUYER_ADDRESS1) ADDRESS1, (SDD.BUYER_ADDRESS2) ADDRESS2, SDD.BUYER_CITY, SDD.BUYER_STATE, SDD.BUYER_ZIP, SDD.BUYER_COUNTRY, decode(SDD.ebay_status, 'Completed', 'AWAITING', SDD.ebay_status) ORDER_STATUS, sdd.QUANTITY, sdd.item_title, sdd.itm_id, sdd.order_num saleno, sdd.ITEM_ID ebayid, sdd.BIN_LOCATION, SDD.TOTAL_PRICE, SDD.LZ_SELLER_ACCT_ID SELLER_ACCT, SDD.PULLER_NAME, SDD.PULLING_DATE, SDD.MPN, SDD.UPC, SDD.COND_NAME, SDD.TRANSACTION_ID, decode(SDD.STAMPS_SHIPPING_RATE, NULL, 0, SDD.STAMPS_SHIPPING_RATE) STAMPS_SHIPPING_RATE, 0 PACK_WEIGHT, DECODE(WS.MACHINE_INPUT_YN, NULL, 0, WS.MACHINE_INPUT_YN) MACHINE_INPUT_YN, SDD.SHIPPING_SERVICE, sdd.pulling_id, sdd.condition_id, sdd.ebay_status, SDD.BUISNESS_NAME MERCHANT_NAME, SDD.ACCOUNT_NAME, sdd.order_id, sdd.SALES_RECORD_NO_GROUP GROUP_SALENO, sdd.extendedorderid, sdd.location_vrf FROM (SELECT SD.ITEM_ID, b.bin_id, sd.sales_record_number order_num, sd.item_title, SD.USER_ID, DECODE(VF.BARCODE_NO, NULL, '', VF.BARCODE_NO) LOCATION_VRF, DECODE(SD.SHIP_TO_NAME, NULL, SD.BUYER_FULLNAME, SD.SHIP_TO_NAME) BUYER_FULLNAME, SD.TRANSACTION_ID, LD.MERCHANT_ID, DECODE(SD.SHIP_TO_ADDRESS1, NULL, SD.BUYER_ADDRESS1, SD.SHIP_TO_ADDRESS1) BUYER_ADDRESS1, DECODE(SD.SHIP_TO_ADDRESS2, NULL, SD.BUYER_ADDRESS2, SD.SHIP_TO_ADDRESS2) BUYER_ADDRESS2, DECODE(SD.SHIP_TO_CITY, NULL, SD.BUYER_CITY, SD.SHIP_TO_CITY) BUYER_CITY, DECODE(SD.SHIP_TO_STATE, NULL, SD.BUYER_STATE, SD.SHIP_TO_STATE) BUYER_STATE, DECODE(SD.SHIP_TO_ZIP, NULL, SD.BUYER_ZIP, SD.SHIP_TO_ZIP) BUYER_ZIP, DECODE(SD.SHIP_TO_COUNTRY, NULL, SD.BUYER_COUNTRY, SD.SHIP_TO_COUNTRY) BUYER_COUNTRY, SD.Sale_Date, B.LZ_MANIFEST_ID, im.item_code, SP.PULLER_NAME, SP.PULLING_DATE, im.item_mt_mfg_part_no mpn, im.item_mt_upc upc, c.cond_name, SD.QUANTITY, SD.TOTAL_PRICE, SD.SHIPPING_SERVICE, SD.STAMPS_SHIPPING_RATE, SM.LZ_SELLER_ACCT_ID, NVL(SP.PULLING_QTY, 0) PULLING_QTY, NVL(SP.CANCEL_QTY, 0) CANCEL_QTY, B.BARCODE_NO, b.item_id itm_id, WA.WAREHOUSE_NO, b.condition_id, B.Pulling_Id, LM.BUISNESS_NAME, LD.ACCOUNT_NAME, SD.Orderstatus ebay_status, SD.Order_Id, sd.SALES_RECORD_NO_GROUP, sd.extendedorderid, DECODE(Bi.BIN_ID, 0, 'NO BIN', 'W' || Wa.WAREHOUSE_NO || '-' || Rac.RACK_NO || '-R' || Ro.ROW_NO || '-' || Bi.BIN_TYPE || '-' || Bi.BIN_NO) BIN_LOCATION FROM LZ_SALESLOAD_DET SD, LZ_BARCODE_MT B, LJ_BIN_VERIFY_DT VF, LZ_AWAITING_SHIPMENT aw, BIN_MT BI, LZ_RACK_ROWS RO, RACK_MT RAC, lz_item_cond_mt c, WAREHOUSE_MT WA, items_mt im, LZ_SALESLOAD_MT SM, LJ_MERHCANT_ACC_DT LD, LZ_MERCHANT_MT LM, (SELECT P.SALES_RECORD_NO, P.EBAY_ITEM_ID, MAX(PULLER_NAME) PULLER_NAME, TO_CHAR(MAX(PULLING_DATE), 'YYYY-MM-DD HH24:MI:SS') PULLING_DATE, SUM(NVL(PULLING_QTY, 0)) PULLING_QTY, SUM(NVL(CANCEL_QTY, 0)) CANCEL_QTY FROM LZ_SALES_PULLING P GROUP BY P.SALES_RECORD_NO, P.EBAY_ITEM_ID) SP WHERE SD.SALES_RECORD_NUMBER = SP.SALES_RECORD_NO(+) AND SD.ITEM_ID = SP.EBAY_ITEM_ID(+) AND SD.SALES_RECORD_NUMBER = B.SALE_RECORD_NO(+) and SD.ITEM_ID = B.EBAY_ITEM_ID AND VF.BARCODE_NO(+) = B.BARCODE_NO and sd.sales_record_number = to_Char(aw.salerecordid) AND SD.LZ_SALELOAD_ID = SM.LZ_SALELOAD_ID AND SM.LZ_SELLER_ACCT_ID = LD.ACCT_ID AND LD.MERCHANT_ID = LM.MERCHANT_ID AND B.BIN_ID = BI.BIN_ID(+) AND BI.CURRENT_RACK_ROW_ID = RO.RACK_ROW_ID(+) AND RO.RACK_ID = RAC.RACK_ID(+) AND RAC.WAREHOUSE_ID = WA.WAREHOUSE_ID(+) and b.condition_id = c.id(+) and im.item_id = b.item_id and sd.item_id = b.ebay_item_id AND B.PULLING_ID IS NULL and sd.uk_firebase_waiting is null and b.item_adj_det_id_for_out is null and b.lz_part_issue_mt_id is null and b.lz_pos_mt_id is null AND SD.GNRTD_DC_ID IS NULL AND SD.TRACKING_NUMBER IS NULL) SDD, (SELECT DISTINCT W.ITEM_ID, W.PACK_WEIGHT, W.SHIPPING_SERVICE, W.MACHINE_INPUT_YN FROM LZ_ITEM_PACK_WEIGHT W) WS WHERE NVL(SDD.QUANTITY, 0) <> (NVL(SDD.PULLING_QTY, 0) + NVL(SDD.CANCEL_QTY, 0)) AND SDD.ITM_ID = WS.ITEM_ID(+) AND SDD.BARCODE_NO IS NOT NULL) get, lz_special_lots l, items_mt i, lz_dekit_us_dt dd, lz_item_cond_mt cc where def_barcode = l.barcode_prv_no(+) and def_barcode = dd.barcode_prv_no(+) and get.condition_id = cc.id(+) and itm_id = i.item_id and get.order_id = '$orderid'order by get.saleno asc ";
                          $data = $this->db->query($main_query)->result_array();

                        /*=====  End of copy from m_notification  ======*/
                        if(count($data) > 0 ){
                            $pic_path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 7")->result_array();;
                            $master_path = $pic_path[0]['MASTER_PATH'];
                            for($i = 0; $i < count($data);$i++){  
                                $d_dir = $master_path;
                                $s_dir = $master_path;
                                 $folder = $data[$i]["IMAGE"];
                                $folder1 = $data[$i]["FOL_NAME1"];
                                $d_dir = @$d_dir.@$folder.'/thumb/';
                                $s_dir = @$s_dir.@$folder1.'/thumb/';
                                
                                     


                                     if(is_dir(@$d_dir)){
                                        // var_dump($d_dir);
                                         $iterator = new \FilesystemIterator(@$d_dir);
                                           if(@$iterator->valid()){    
                                               $m_flag = true;
                                           }else{
                                             $m_flag = false;
                                           }
                                        }
                                        elseif(is_dir(@$s_dir)){
                                         $iterator = new \FilesystemIterator(@$s_dir);
                                             if (@$iterator->valid()){    
                                               $m_flag = true;
                                           }else{
                                             $m_flag = false;
                                           }
                                        }

                                    else{
                                         $m_flag = false;
                                     }

                                   if($m_flag){
                                      if (is_dir($d_dir)){
                                       $images = scandir($d_dir);
                                       // Image selection and display:
                                       //display first image
                                       if (count($images) > 0){ // make sure at least one image exists
                                           $url = @$images[2]; // first image

                                           $data[$i]["IMAGE"] = $folder.'/thumb/'.$url;
                                        
                                       }
                                       elseif(is_dir($s_dir)){
                                        $images = scandir($s_dir);
                                        // Image selection and display:
                                        //display first image
                                        if (count($images) > 0){ // make sure at least one image exists
                                            $url = @$images[2]; // first image
                         
                                            $data[$i]["IMAGE"] = $folder1.'/thumb/'.$url;
                                         
                                             }
                                         }
                                   }

                                   elseif(is_dir($s_dir)){
                                        $images = scandir($s_dir);
                                        // Image selection and display:
                                        //display first image
                                        if (count($images) > 0){ // make sure at least one image exists
                                            $url = @$images[2]; // first image
                         
                                            $data[$i]["IMAGE"] = $folder1.'/thumb/'.$url;
                                         
                                             }
                                         }

                                    }
                                //   $data[$i]["FOL_NAME"] = "aaaaaaa";

                                     //$data_location = $this->handler->get_multi_location($data[$i]["EBAYID"]);
                                    $main_query = "SELECT DISTINCT 'W' || W.WAREHOUSE_NO || '-' || R.RACK_NO || '-R' || RR.ROW_NO || '-' || B.BIN_TYPE || '-' || B.BIN_NO B_LOCATION, BB.BARCODE_NO LOCATION_BARCODE_NO, DECODE(VF.BARCODE_NO, NULL, '', VF.BARCODE_NO) LOCATION_VRF FROM BIN_MT        B, RACK_MT       R, WAREHOUSE_MT  W, LZ_RACK_ROWS  RR, LZ_BARCODE_MT BB, LJ_BIN_VERIFY_DT VF WHERE B.BIN_ID = BB.BIN_ID AND B.CURRENT_RACK_ROW_ID = RR.RACK_ROW_ID AND R.RACK_ID = RR.RACK_ID AND R.WAREHOUSE_ID = W.WAREHOUSE_ID AND VF.BARCODE_NO(+) = BB.BARCODE_NO AND BB.EBAY_ITEM_ID = '$ebayid'AND BB.PULLING_ID IS NULL AND BB.SALE_RECORD_NO IS NULL AND BB.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND BB.LZ_PART_ISSUE_MT_ID IS NULL ";
                                    $data_location = $this->db->query($main_query)->result_array();


                                     //$record_no =   $this->handler->get_shiping_services();
                                     $record_no = $this->db->query("SELECT * FROM LZ_SHIPING_NAME S WHERE S.STAMPS_SHIPING_CODE IS NOT NULL")->result_array();
                                // echo json_encode(array('location_data'=>($data_location)));
                                $data[$i]["BARCODEARRAY"] = $data_location;
                                for($j = 0; $j < count($record_no); $j++)
                                {
                                  if($record_no[$j]["SHIPING_NAME"] == $data[$i]["SHIPPING_SERVICE"])
                                  {
                                    $data[$i]["SHIPPING_SERVICE"] = $record_no[$j];
                                  }
                                }
                                $data[$i]["SHIPINGARRAY"] = $record_no;
                                

                                }// end main foreach
                                
                                $availableBarcodeNode = 'test_Barcodes/'.$data[0]['ITM_ID'].'/AVAILABLE';

                                foreach ($data as $value) {

                                  $barcodeNode = 'test_Barcodes/'.$data[0]['ITM_ID'].'/'.$data[0]['SALENO'].'/'.$value['DEF_BARCODE'];
                                  $newKey = $firebase->update([
                                    'STATUS' => 'AWAITING',
                                    'B_LOCATION' => (string)$value["BIN_LOCATION"],
                                    'LOCATION_VRF' => $value["LOCATION_VRF"]
                                  ], $barcodeNode);
                                  
                                }
                                $availibleBarcodes = $data[0]["BARCODEARRAY"];
                                
                                for($k=0; $k<count($availibleBarcodes); $k++)
                                {
                                    $availableBarcodeNode = 'test_Barcodes/'.$data[0]['ITM_ID'].'/AVAILABLE/'.$availibleBarcodes[$k]["LOCATION_BARCODE_NO"];
                                    $availableLocationVrf = true;
                                    if(empty($availibleBarcodes[$k]["LOCATION_VRF"]))
                                    {
                                        $availableLocationVrf = false;
                                    }
                                    $newKey = $firebase->update([
                                        'B_LOCATION' => (string)$availibleBarcodes[$k]["B_LOCATION"],
                                        'LOCATION_VRF' => $availableLocationVrf
                                      ], $availableBarcodeNode);
                                }

                          $data[0]["BARCODEARRAY"] = null;
                          $data[0]["DEF_BARCODE"] = null;
                          $data[0]["BIN_LOCATION"] = null;
                          $data[0]["PULLQTY"] = "0";
                          $data[0]['selectedBarcode'] = "null";
                          ////$data[0]['GROUP_SALENO'] = $combine_group_id;


                    /*=========================================
                    =            upload data to fb            =
                    =========================================*/
                   
                    $orderNode = 'test_orders/';//.$data[0]['SALENO'];
                    $newKey = $firebase->update([
                      $data[0]['SALENO'] => $data[0]
                    ], $orderNode);
                    
                    /*=====  End of upload data to fb  ======*/           
                }// if(count($data) > 0 ){

                     }// end if(empty($TRACKING_NUMBER) AND $ORDERSTATUS == 'Completed'){

/*=====  End of block copy from inser part  ======*/




                    if (php_sapi_name() == "cli") {
                        // In cli-mode
                        echo "INSERTED: $SALES_RECORD_NUMBER".PHP_EOL;
                    } else {
                        // Not in cli-mode
                        echo "INSERTED: $SALES_RECORD_NUMBER<br/>";
                    }
                }// else close if($data != null)
                /*=====  End of upload data to fb  ======*/
                if($orderlineitemid === $orderid){
                    continue 2;// skip the code below and move to next order id of outer foreach
                }else{
                    continue;// skip the code below and move to next order id of current foreach
                }
             
               }else{// if(count($row) > 0){ end
                        // =============== Start Checking if record already exist in lz_salesload_mt table ===============
                    $current_date=date('Y-m-d');
                    $current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD')";
                    $q ="SELECT * FROM (select * from LZ_SALESLOAD_MT where loading_date like $current_date and LZ_SELLER_ACCT_ID=$LZ_SELLER_ACCT_ID ORDER BY LZ_SALELOAD_ID DESC) WHERE ROWNUM = 1";
                    $row = $this->db->query($q);//->result_array();
                        // =============== End Checking if record already exist in lz_salesload_mt table ===============

                    // ========================== Starts Insertion in MT table ===============================
                     if($row->num_rows() == 0)
                    {
                        $max_id = "SELECT GET_SINGLE_PRIMARY_KEY('LZ_SALESLOAD_MT','LZ_SALELOAD_ID') LZ_SALELOAD_ID FROM DUAL";
                        $row = $this->db->query($max_id)->result_array();
                        $LZ_SALELOAD_ID = $row[0]['LZ_SALELOAD_ID'];
                        $max_id = "SELECT GET_SINGLE_PRIMARY_KEY('LZ_SALESLOAD_MT','LOADING_NO') LOADING_NO FROM DUAL";
                        $row = $this->db->query($max_id)->result_array();
                        $LOADING_NO = $row[0]['LOADING_NO'];
                        $LOADING_DATE=date('m/d/Y');
                        $SALES_REF_NO=date('m/d/Y');
                        $EXCEL_FILE_NAME=date('m/d/Y');
                        $EXCEL_FILE_NAME=$EXCEL_FILE_NAME."_".$LZ_SELLER_ACCT_ID;
                        $POSTED='Post in ERP';
                        $comma = ',';
                        $insert_qry = "INSERT INTO lz_salesload_mt VALUES($LZ_SALELOAD_ID $comma $LOADING_NO $comma TO_DATE('$LOADING_DATE', 'mm/dd/yyyy') $comma '$SALES_REF_NO' $comma NULL $comma '$EXCEL_FILE_NAME' $comma '$POSTED' $comma $LZ_SELLER_ACCT_ID )";
                        $this->db->query($insert_qry);
                    }
                    else{
                        $row = $this->db->query($q)->result_array();
                        $LZ_SALELOAD_ID = $row[0]['LZ_SALELOAD_ID'];
                    }
            
                    // ========================== End Insertion in MT table ===============================
               }//else close if(count($row) > 0){ 

                
                /*=====  End of check order in db  ======*/
                



                            //$quantitypurchased = $transaction->QuantityPurchased;
                            $buyeremail = $transaction->Buyer->Email;
                            $recordnumber = $transaction->ShippingDetails->SellingManagerSalesRecordNumber;
                            
                            $datesold = $transaction->CreatedDate;
                            $datesold = str_split($datesold,19);
                            $datesold = str_replace('T'," ",$datesold[0]);
                            //  echo "T removed:".$test;
                            // echo "Date Soled:".$datesold[0];exit;
                            $itemtitle = $transaction->Item->Title;
                            //$finalvaluefee = $transaction->FinalValueFee;
                            
                            $SKU = $transaction->Item->SKU;
                            if ($SKU) {
                                $sku = $SKU;
                            }
                            
                            // if the item is listed with variations, get the variation SKU
                            $VariationSKU = $transaction->Variation->SKU;
                            if ($VariationSKU != null) {
                                $variationsku = $VariationSKU;
                            }else{
                                $variationsku = '';
                            }
                            $transactionid = $transaction->TransactionID;
                            $transactionprice = $transaction->TransactionPrice;
                            //$transactionPriceAttr = $transaction->TransactionPrice->attributes();
                            //$transactionprice = $transaction->TransactionPrice . " " . $transactionPriceAttr["currencyID"];
                            $platform = $transaction->Platform;

                            /*=============================================================================
                            =            following code is moved from outside forech to inside transaction foreach    Dated: 28-03-2018       =
                            =============================================================================*/
                            //========================== Get LZ_SALELOAD__det_ID from lz_salesload_mt table start =============
                    $max_id = "SELECT GET_SINGLE_PRIMARY_KEY('LZ_SALESLOAD_DET','LZ_SALESLOAD_DET_ID') LZ_SALESLOAD_DET_ID FROM LZ_SALESLOAD_DET";
                    // $data = oci_parse($conn, $max_id);
                    // oci_execute($data,OCI_DEFAULT);
                    // $row = oci_fetch_array($data, OCI_ASSOC);
                    $row = $this->db->query($max_id)->result_array();
                    $LZ_SALESLOAD_DET_ID = $row[0]['LZ_SALESLOAD_DET_ID'];
                    
    //========================== Get LZ_SALELOAD_ID from lz_salesload_mt table end =============

    // ============================ Start Insertion Process =============================
                $WIZ_ERP_CODE = "''";
                $SALES_RECORD_NUMBER= $recordnumber;
                $USER_ID= $buyeruserid;
                //$BUYER_PHONE_NUMBER= $phoneno;
                if($buyeremail){$BUYER_EMAIL= $buyeremail;}else{$BUYER_EMAIL= '';}
                //$address = trim(str_replace("  ", '', $address));
                //$address = trim(str_replace(array("'", '"'), "''", $address));
                //$BUYER_ADDRESS1= $address;
                $BUYER_ADDRESS2= '';
                // $city = trim(str_replace("  ", '', $city));
                // $city = trim(str_replace(array("'", '"'), "''", $city));
                // $BUYER_CITY= $city;
                // $stateorprovince = trim(str_replace("  ", '', $stateorprovince));
                // $stateorprovince = trim(str_replace(array("'", '"'), "''", $stateorprovince));
                // $BUYER_STATE= $stateorprovince;
                // $BUYER_ZIP= $postalcode;
                // $countryname = trim(str_replace("  ", '', $countryname));
                // $countryname = trim(str_replace(array("'", '"'), "''", $countryname));
                // $BUYER_COUNTRY= $countryname;
                $ORDER_ID= $orderid;
                if(strpos($ORDER_ID, '-') !== false)//if order id contain - its mean its a single order not combine
                {
                  $combine_order_id = '';
                  $combine_group_id = '';
                }else{
                  $combine_order_id = $ORDER_ID;
                  $combine_group_id = $SALE_RECORD_NO_GROUP_ID;
                }
                $ITEM_ID= $ebayid;
                $TRANSACTION_ID= $transactionid;
                $itemtitle = trim(str_replace("  ", '', $itemtitle));
                $itemtitle = trim(str_replace(array("'", '"'), "''", $itemtitle));
                $ITEM_TITLE= $itemtitle;
                //$QUANTITY= $quantitypurchased;
                //$SALE_PRICE= $transactionprice;
                $SHIPPING_AND_HANDLING= 0.00;
                $SALES_TAX= $salestaxamount;
               
                if(empty($SALES_TAX))
                {
                    $SALES_TAX = 0.00;
                }
                $INSURANCE= 0.00;
                //$TOTAL_PRICE= $total;
                $PAYMENT_METHOD= $paymentmethod;
                $PAYPAL_TRANSACTION_ID= $externaltransactionid;
                // $SALE_DATE= "TO_DATE('".$datesold."', 'YYYY-MM-DD HH24:MI:SS')"; //to_date('$datesold', 'yyyy/mm/dd')
                // $CHECKOUT_DATE= "TO_DATE('".$checkoutdate."', 'YYYY-MM-DD HH24:MI:SS')";
                // $PAID_ON_DATE= "TO_DATE('".$paidtime."', 'YYYY-MM-DD HH24:MI:SS')";
                // if($shippedtime){$SHIPPED_ON_DATE= "TO_DATE('".$shippedtime."', 'YYYY-MM-DD HH24:MI:SS')";}else{$SHIPPED_ON_DATE="''";}
                //$SHIPPING_SERVICE= $shippingservice;
                $FEEDBACK_LEFT= '';
                $FEEDBACK_RECEIVED= '';
                $NOTES_TO_YOURSELF= '';
                if($variationsku){$CUSTOM_LABEL= $variationsku;}else{$CUSTOM_LABEL= '';}
                $LISTED_ON= $platform;
                $SOLD_ON= $platform;
                $VARIATION_DETAILS= '';
                $LZ_SALELOAD_ID= $LZ_SALELOAD_ID;
                $LZ_SALESLOAD_DET_ID= $LZ_SALESLOAD_DET_ID;
                $GNRTD_DC_ID= '';
                $GNRTD_DC_DET_ID= '';
                $GNRTD_INV_ID= '';
                $GNRTD_INV_DET_ID= '';
                // $EBAY_FEE_PERC= $finalvaluefee;
                $PAYPAL_FEE_PERC= '';
                $PAYPAL_PER_TRANS_FEE= $paypalfee;
                $POSTED= 'post in erp';
                if($trackingnumber){$TRACKING_NUMBER= $trackingnumber;}else{$TRACKING_NUMBER= '';}
                // $SHIP_TO_ADDRESS1= '';//PROFILE ADDRESS
                // $SHIP_TO_ADDRESS2= ''; //SHIPPING ADDRESS
                // $SHIP_TO_CITY= '';
                // $SHIP_TO_STATE= '';
                // $SHIP_TO_ZIP= '';
                // $SHIP_TO_COUNTRY= '';
                $MANNUAL_YN= '';
                $MANNUAL_LOADED_BY_EMP_ID= '';
                // if($buyercheckoutmsg){
                //     $buyercheckoutmsg = trim(str_replace("  ", '', $buyercheckoutmsg));
                //     $buyercheckoutmsg = trim(str_replace(array("'", '"'), "''", $buyercheckoutmsg));
                //     $BUYER_CHECKOUT_MSG = $buyercheckoutmsg;}else{$BUYER_CHECKOUT_MSG = '';}
                // if($street1){
                //     $street1 = trim(str_replace("  ", '', $street1));
                //     $street1 = trim(str_replace(array("'", '"'), "''", $street1));
                //     $BUYER_STREET1=$street1;}else{$BUYER_STREET1='';}
                // if(!empty($street2)){
                //     $street2 = trim(str_replace("  ", '', $street2));
                //     $street2 = trim(str_replace(array("'", '"'), "''", $street2));
                //     $BUYER_STREET2=$street2;}else{$BUYER_STREET2='';}
                // if($addressid){$BUYER_ADDRESS_ID=$addressid;}else{$BUYER_ADDRESS_ID='';}
                $ORDERSTATUS=$orderStatus;
                if($SHIPPING_SERVICE == 'USPSFirstClass' ||$SHIPPING_SERVICE == 'USPS First Class Package'){
                $SHIPPING_CHARGES = 3.25;
            }elseif($SHIPPING_SERVICE == 'USPSPriority' || $SHIPPING_SERVICE == 'USPS Priority Mail'){
                $SHIPPING_CHARGES = 8.25;

            }elseif($SHIPPING_SERVICE == 'FedExHomeDelivery' || $SHIPPING_SERVICE == 'FedExGround'){
                $SHIPPING_CHARGES = 15.00;

            }else{
                $SHIPPING_CHARGES = 0.00;
            }

                $comma = ',';
    // working Dat format = TO_DATE('2016-08-30 20:49:08', 'YYYY-MM-DD HH24:MI:SS')

    // ===================== Start Checking if record already exist ==============================

                // $select_query = "select * from LZ_SALESLOAD_det d where d.order_id = '$orderlineitemid'";
                // $row = $this->db->query($select_query)->result_array();

    // ===================== End Checking if record already exist ===============================
                if((int)$SALE_RECORD_NO_GROUP_ID == (int)$SALES_RECORD_NUMBER){
                        $SALE_RECORD_NO_GROUP_ID = '';
                }
                $select_query = "select * from LZ_SALESLOAD_det d where d.order_id = '$orderlineitemid'";
                // $select =oci_parse($conn, $select_query);
                // oci_execute($select,OCI_DEFAULT);
                // $num_row = oci_fetch_array($select, OCI_ASSOC);
                $row = $this->db->query($select_query)->result_array();

            // ===================== End Checking if record already exist ===============================

               if(count($row) == 0){
               //if(1){

                    $qry = "INSERT INTO LZ_SALESLOAD_DET (WIZ_ERP_CODE, SALES_RECORD_NUMBER, USER_ID, BUYER_FULLNAME, BUYER_PHONE_NUMBER, BUYER_EMAIL, BUYER_ADDRESS1, BUYER_ADDRESS2, BUYER_CITY, BUYER_STATE, BUYER_ZIP, BUYER_COUNTRY, ITEM_ID, TRANSACTION_ID, ITEM_TITLE, QUANTITY, SALE_PRICE, SHIPPING_AND_HANDLING, SALES_TAX, INSURANCE, TOTAL_PRICE, PAYMENT_METHOD, PAYPAL_TRANSACTION_ID, SALE_DATE, CHECKOUT_DATE, PAID_ON_DATE, SHIPPED_ON_DATE, SHIPPING_SERVICE, FEEDBACK_LEFT, FEEDBACK_RECEIVED, NOTES_TO_YOURSELF, CUSTOM_LABEL, LISTED_ON, SOLD_ON, VARIATION_DETAILS, LZ_SALELOAD_ID, LZ_SALESLOAD_DET_ID, GNRTD_DC_ID, GNRTD_DC_DET_ID, GNRTD_INV_ID, GNRTD_INV_DET_ID, EBAY_FEE_PERC, PAYPAL_FEE_PERC, PAYPAL_PER_TRANS_FEE, POSTED, TRACKING_NUMBER, SHIP_TO_ADDRESS1, SHIP_TO_ADDRESS2, SHIP_TO_CITY, SHIP_TO_STATE, SHIP_TO_ZIP, SHIP_TO_COUNTRY, MANNUAL_YN, MANNUAL_LOADED_BY_EMP_ID, ORDER_ID, BUYER_CHECKOUT_MSG, BUYER_STREET1, BUYER_STREET2, BUYER_ADDRESS_ID, ORDERSTATUS, SHIPPING_CHARGES, SALES_RECORD_NO_GROUP,SHIP_TO_NAME,SHIP_TO_PHONE,COMBINE_ORDER_ID,INSERTED_DATE,EXTENDEDORDERID,ConditionID,ConditionDisplayName) VALUES($WIZ_ERP_CODE $comma '$SALES_RECORD_NUMBER' $comma '$USER_ID' $comma '$BUYER_FULLNAME' $comma '$BUYER_PHONE_NUMBER' $comma '$BUYER_EMAIL' $comma '$BUYER_ADDRESS1' $comma '$BUYER_ADDRESS2' $comma '$BUYER_CITY' $comma '$BUYER_STATE' $comma '$BUYER_ZIP' $comma '$BUYER_COUNTRY' $comma '$ITEM_ID' $comma '$TRANSACTION_ID' $comma '$ITEM_TITLE' $comma $QUANTITY $comma $SALE_PRICE $comma $SHIPPING_AND_HANDLING $comma '$SALES_TAX' $comma $INSURANCE $comma $TOTAL_PRICE $comma '$PAYMENT_METHOD' $comma '$PAYPAL_TRANSACTION_ID' $comma $SALE_DATE $comma $CHECKOUT_DATE $comma $PAID_ON_DATE $comma $SHIPPED_ON_DATE $comma '$SHIPPING_SERVICE' $comma '$FEEDBACK_LEFT' $comma '$FEEDBACK_RECEIVED' $comma '$NOTES_TO_YOURSELF' $comma '$CUSTOM_LABEL' $comma '$LISTED_ON' $comma '$SOLD_ON' $comma '$VARIATION_DETAILS' $comma $LZ_SALELOAD_ID $comma $LZ_SALESLOAD_DET_ID $comma '$GNRTD_DC_ID' $comma '$GNRTD_DC_DET_ID' $comma '$GNRTD_INV_ID' $comma '$GNRTD_INV_DET_ID' $comma $EBAY_FEE_PERC $comma '$PAYPAL_FEE_PERC' $comma '$PAYPAL_PER_TRANS_FEE' $comma '$POSTED' $comma '$TRACKING_NUMBER' $comma '$SHIP_TO_ADDRESS1' $comma '$SHIP_TO_ADDRESS2' $comma '$SHIP_TO_CITY' $comma '$SHIP_TO_STATE' $comma '$SHIP_TO_ZIP' $comma '$SHIP_TO_COUNTRY' $comma '$MANNUAL_YN' $comma '$MANNUAL_LOADED_BY_EMP_ID' $comma '$orderlineitemid' $comma '$BUYER_CHECKOUT_MSG' $comma '$BUYER_STREET1' $comma '$BUYER_STREET2' $comma '$BUYER_ADDRESS_ID' $comma '$ORDERSTATUS' $comma $SHIPPING_CHARGES $comma '$SALE_RECORD_NO_GROUP_ID' $comma '$SHIP_TO_NAME' $comma '$SHIP_TO_PHONE' $comma '$combine_order_id' $comma SYSDATE $comma '$extendedorderid' $comma '$ConditionID' $comma '$ConditionDisplayName')";
                     $this->db->query($qry);
                     $this->db->query("CALL PRO_ORDERPACKING('$orderlineitemid')");
                     if (php_sapi_name() != "cli") {
                        // In cli-mode
                        echo "INSERTED: $SALES_RECORD_NUMBER";
                    }

                        //$this->load->model('notification/m_notification','handler');
                        //$data = $this->handler->awaitingOrders($orderid);
                     if(empty($TRACKING_NUMBER) AND $ORDERSTATUS == 'Completed'){
/*================================================
                        =            copy from m_notification            =
                        ================================================*/
                         $main_query = "SELECT decode(l.folder_name, null, decode(dd.folder_name, null, 'master_pictures/' || trim(i.item_mt_upc) || '~' || trim(i.item_mt_mfg_part_no) || '/' || trim(cc.cond_name), 'dekitted_pictures/' || dd.folder_name), 'dekitted_pictures/' || l.folder_name) IMAGE, 'master_pictures/' || trim(i.item_mt_upc) || '~' || trim(i.item_mt_mfg_part_no) || '/' || trim(cc.cond_name) FOL_NAME1, get.* FROM (SELECT ROWNUM RE, SDD.MERCHANT_ID, SDD.BARCODE_NO BARCODEARRAY, SDD.BARCODE_NO def_barcode, SDD.WAREHOUSE_NO, TO_CHAR(SDD.Sale_Date, 'MM/DD/YYYY HH24:MI:SS') SALE_DATE, SDD.USER_ID USER_ID, (SDD.BUYER_FULLNAME) FULLNAME, (SDD.BUYER_ADDRESS1) ADDRESS1, (SDD.BUYER_ADDRESS2) ADDRESS2, SDD.BUYER_CITY, SDD.BUYER_STATE, SDD.BUYER_ZIP, SDD.BUYER_COUNTRY, decode(SDD.ebay_status, 'Completed', 'AWAITING', SDD.ebay_status) ORDER_STATUS, sdd.QUANTITY, sdd.item_title, sdd.itm_id, sdd.order_num saleno, sdd.ITEM_ID ebayid, sdd.BIN_LOCATION, SDD.TOTAL_PRICE, SDD.LZ_SELLER_ACCT_ID SELLER_ACCT, SDD.PULLER_NAME, SDD.PULLING_DATE, SDD.MPN, SDD.UPC, SDD.COND_NAME, SDD.TRANSACTION_ID, decode(SDD.STAMPS_SHIPPING_RATE, NULL, 0, SDD.STAMPS_SHIPPING_RATE) STAMPS_SHIPPING_RATE, 0 PACK_WEIGHT, DECODE(WS.MACHINE_INPUT_YN, NULL, 0, WS.MACHINE_INPUT_YN) MACHINE_INPUT_YN, SDD.SHIPPING_SERVICE, sdd.pulling_id, sdd.condition_id, sdd.ebay_status, SDD.BUISNESS_NAME MERCHANT_NAME, SDD.ACCOUNT_NAME, sdd.order_id, sdd.SALES_RECORD_NO_GROUP GROUP_SALENO, sdd.extendedorderid, sdd.location_vrf FROM (SELECT SD.ITEM_ID, b.bin_id, sd.sales_record_number order_num, sd.item_title, SD.USER_ID, DECODE(VF.BARCODE_NO, NULL, '', VF.BARCODE_NO) LOCATION_VRF, DECODE(SD.SHIP_TO_NAME, NULL, SD.BUYER_FULLNAME, SD.SHIP_TO_NAME) BUYER_FULLNAME, SD.TRANSACTION_ID, LD.MERCHANT_ID, DECODE(SD.SHIP_TO_ADDRESS1, NULL, SD.BUYER_ADDRESS1, SD.SHIP_TO_ADDRESS1) BUYER_ADDRESS1, DECODE(SD.SHIP_TO_ADDRESS2, NULL, SD.BUYER_ADDRESS2, SD.SHIP_TO_ADDRESS2) BUYER_ADDRESS2, DECODE(SD.SHIP_TO_CITY, NULL, SD.BUYER_CITY, SD.SHIP_TO_CITY) BUYER_CITY, DECODE(SD.SHIP_TO_STATE, NULL, SD.BUYER_STATE, SD.SHIP_TO_STATE) BUYER_STATE, DECODE(SD.SHIP_TO_ZIP, NULL, SD.BUYER_ZIP, SD.SHIP_TO_ZIP) BUYER_ZIP, DECODE(SD.SHIP_TO_COUNTRY, NULL, SD.BUYER_COUNTRY, SD.SHIP_TO_COUNTRY) BUYER_COUNTRY, SD.Sale_Date, B.LZ_MANIFEST_ID, im.item_code, SP.PULLER_NAME, SP.PULLING_DATE, im.item_mt_mfg_part_no mpn, im.item_mt_upc upc, c.cond_name, SD.QUANTITY, SD.TOTAL_PRICE, SD.SHIPPING_SERVICE, SD.STAMPS_SHIPPING_RATE, SM.LZ_SELLER_ACCT_ID, NVL(SP.PULLING_QTY, 0) PULLING_QTY, NVL(SP.CANCEL_QTY, 0) CANCEL_QTY, B.BARCODE_NO, b.item_id itm_id, WA.WAREHOUSE_NO, b.condition_id, B.Pulling_Id, LM.BUISNESS_NAME, LD.ACCOUNT_NAME, SD.Orderstatus ebay_status, SD.Order_Id, sd.SALES_RECORD_NO_GROUP, sd.extendedorderid, DECODE(Bi.BIN_ID, 0, 'NO BIN', 'W' || Wa.WAREHOUSE_NO || '-' || Rac.RACK_NO || '-R' || Ro.ROW_NO || '-' || Bi.BIN_TYPE || '-' || Bi.BIN_NO) BIN_LOCATION FROM LZ_SALESLOAD_DET SD, LZ_BARCODE_MT B, LJ_BIN_VERIFY_DT VF, LZ_AWAITING_SHIPMENT aw, BIN_MT BI, LZ_RACK_ROWS RO, RACK_MT RAC, lz_item_cond_mt c, WAREHOUSE_MT WA, items_mt im, LZ_SALESLOAD_MT SM, LJ_MERHCANT_ACC_DT LD, LZ_MERCHANT_MT LM, (SELECT P.SALES_RECORD_NO, P.EBAY_ITEM_ID, MAX(PULLER_NAME) PULLER_NAME, TO_CHAR(MAX(PULLING_DATE), 'YYYY-MM-DD HH24:MI:SS') PULLING_DATE, SUM(NVL(PULLING_QTY, 0)) PULLING_QTY, SUM(NVL(CANCEL_QTY, 0)) CANCEL_QTY FROM LZ_SALES_PULLING P GROUP BY P.SALES_RECORD_NO, P.EBAY_ITEM_ID) SP WHERE SD.SALES_RECORD_NUMBER = SP.SALES_RECORD_NO(+) AND SD.ITEM_ID = SP.EBAY_ITEM_ID(+) AND SD.SALES_RECORD_NUMBER = B.SALE_RECORD_NO(+) and SD.ITEM_ID = B.EBAY_ITEM_ID AND VF.BARCODE_NO(+) = B.BARCODE_NO and sd.sales_record_number = to_Char(aw.salerecordid) AND SD.LZ_SALELOAD_ID = SM.LZ_SALELOAD_ID AND SM.LZ_SELLER_ACCT_ID = LD.ACCT_ID AND LD.MERCHANT_ID = LM.MERCHANT_ID AND B.BIN_ID = BI.BIN_ID(+) AND BI.CURRENT_RACK_ROW_ID = RO.RACK_ROW_ID(+) AND RO.RACK_ID = RAC.RACK_ID(+) AND RAC.WAREHOUSE_ID = WA.WAREHOUSE_ID(+) and b.condition_id = c.id(+) and im.item_id = b.item_id and sd.item_id = b.ebay_item_id AND B.PULLING_ID IS NULL and sd.uk_firebase_waiting is null and b.item_adj_det_id_for_out is null and b.lz_part_issue_mt_id is null and b.lz_pos_mt_id is null AND SD.GNRTD_DC_ID IS NULL AND SD.TRACKING_NUMBER IS NULL) SDD, (SELECT DISTINCT W.ITEM_ID, W.PACK_WEIGHT, W.SHIPPING_SERVICE, W.MACHINE_INPUT_YN FROM LZ_ITEM_PACK_WEIGHT W) WS WHERE NVL(SDD.QUANTITY, 0) <> (NVL(SDD.PULLING_QTY, 0) + NVL(SDD.CANCEL_QTY, 0)) AND SDD.ITM_ID = WS.ITEM_ID(+) AND SDD.BARCODE_NO IS NOT NULL) get, lz_special_lots l, items_mt i, lz_dekit_us_dt dd, lz_item_cond_mt cc where def_barcode = l.barcode_prv_no(+) and def_barcode = dd.barcode_prv_no(+) and get.condition_id = cc.id(+) and itm_id = i.item_id and get.order_id = '$orderid'order by get.saleno asc ";
                          $data = $this->db->query($main_query)->result_array();

                        /*=====  End of copy from m_notification  ======*/
                        if(count($data) > 0 ){
                            $pic_path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 7")->result_array();;
                            $master_path = $pic_path[0]['MASTER_PATH'];
                            for($i = 0; $i < count($data);$i++){  
                                $d_dir = $master_path;
                                $s_dir = $master_path;
                                 $folder = $data[$i]["IMAGE"];
                                $folder1 = $data[$i]["FOL_NAME1"];
                                $d_dir = @$d_dir.@$folder.'/thumb/';
                                $s_dir = @$s_dir.@$folder1.'/thumb/';
                                
                                     


                                     if(is_dir(@$d_dir)){
                                        // var_dump($d_dir);
                                         $iterator = new \FilesystemIterator(@$d_dir);
                                           if(@$iterator->valid()){    
                                               $m_flag = true;
                                           }else{
                                             $m_flag = false;
                                           }
                                        }
                                        elseif(is_dir(@$s_dir)){
                                         $iterator = new \FilesystemIterator(@$s_dir);
                                             if (@$iterator->valid()){    
                                               $m_flag = true;
                                           }else{
                                             $m_flag = false;
                                           }
                                        }

                                    else{
                                         $m_flag = false;
                                     }

                                   if($m_flag){
                                      if (is_dir($d_dir)){
                                       $images = scandir($d_dir);
                                       // Image selection and display:
                                       //display first image
                                       if (count($images) > 0){ // make sure at least one image exists
                                           $url = @$images[2]; // first image

                                           $data[$i]["IMAGE"] = $folder.'/thumb/'.$url;
                                        
                                       }
                                       elseif(is_dir($s_dir)){
                                        $images = scandir($s_dir);
                                        // Image selection and display:
                                        //display first image
                                        if (count($images) > 0){ // make sure at least one image exists
                                            $url = @$images[2]; // first image
                         
                                            $data[$i]["IMAGE"] = $folder1.'/thumb/'.$url;
                                         
                                             }
                                         }
                                   }

                                   elseif(is_dir($s_dir)){
                                        $images = scandir($s_dir);
                                        // Image selection and display:
                                        //display first image
                                        if (count($images) > 0){ // make sure at least one image exists
                                            $url = @$images[2]; // first image
                         
                                            $data[$i]["IMAGE"] = $folder1.'/thumb/'.$url;
                                         
                                             }
                                         }

                                    }
                                //   $data[$i]["FOL_NAME"] = "aaaaaaa";

                                     //$data_location = $this->handler->get_multi_location($data[$i]["EBAYID"]);
                                    $main_query = "SELECT DISTINCT 'W' || W.WAREHOUSE_NO || '-' || R.RACK_NO || '-R' || RR.ROW_NO || '-' || B.BIN_TYPE || '-' || B.BIN_NO B_LOCATION, BB.BARCODE_NO LOCATION_BARCODE_NO, DECODE(VF.BARCODE_NO, NULL, '', VF.BARCODE_NO) LOCATION_VRF FROM BIN_MT        B, RACK_MT       R, WAREHOUSE_MT  W, LZ_RACK_ROWS  RR, LZ_BARCODE_MT BB, LJ_BIN_VERIFY_DT VF WHERE B.BIN_ID = BB.BIN_ID AND B.CURRENT_RACK_ROW_ID = RR.RACK_ROW_ID AND R.RACK_ID = RR.RACK_ID AND R.WAREHOUSE_ID = W.WAREHOUSE_ID AND VF.BARCODE_NO(+) = BB.BARCODE_NO AND BB.EBAY_ITEM_ID = '$ebayid'AND BB.PULLING_ID IS NULL AND BB.SALE_RECORD_NO IS NULL AND BB.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND BB.LZ_PART_ISSUE_MT_ID IS NULL";
                                    $data_location = $this->db->query($main_query)->result_array();


                                     //$record_no =   $this->handler->get_shiping_services();
                                     $record_no = $this->db->query("SELECT * FROM LZ_SHIPING_NAME S WHERE S.STAMPS_SHIPING_CODE IS NOT NULL")->result_array();
                                // echo json_encode(array('location_data'=>($data_location)));
                                $data[$i]["BARCODEARRAY"] = $data_location;
                                for($j = 0; $j < count($record_no); $j++)
                                {
                                  if($record_no[$j]["SHIPING_NAME"] == $data[$i]["SHIPPING_SERVICE"])
                                  {
                                    $data[$i]["SHIPPING_SERVICE"] = $record_no[$j];
                                  }
                                }
                                $data[$i]["SHIPINGARRAY"] = $record_no;
                                

                                }// end main foreach
                                
                                $availableBarcodeNode = 'test_Barcodes/'.$data[0]['ITM_ID'].'/AVAILABLE';
                                foreach ($data as $value) {

                                  $barcodeNode = 'test_Barcodes/'.$data[0]['ITM_ID'].'/'.$data[0]['SALENO'].'/'.$value['DEF_BARCODE'];
                                  $newKey = $firebase->update([
                                    'STATUS' => 'AWAITING',
                                    'B_LOCATION' => (string)$value["BIN_LOCATION"],
                                    'LOCATION_VRF' => $value["LOCATION_VRF"]
                                  ], $barcodeNode);
                                  
                                }
                                $availibleBarcodes = $data[0]["BARCODEARRAY"];
                                
                                for($k=0; $k<count($availibleBarcodes); $k++)
                                {
                                    $availableBarcodeNode = 'test_Barcodes/'.$data[0]['ITM_ID'].'/AVAILABLE/'.$availibleBarcodes[$k]["LOCATION_BARCODE_NO"];
                                    $availableLocationVrf = true;
                                    if(empty($availibleBarcodes[$k]["LOCATION_VRF"]))
                                    {
                                        $availableLocationVrf = false;
                                    }
                                    $newKey = $firebase->update([
                                        'B_LOCATION' => (string)$availibleBarcodes[$k]["B_LOCATION"],
                                        'LOCATION_VRF' => $availableLocationVrf
                                      ], $availableBarcodeNode);
                                }

                          $data[0]["BARCODEARRAY"] = null;
                          $data[0]["DEF_BARCODE"] = null;
                          $data[0]["BIN_LOCATION"] = null;
                          $data[0]["PULLQTY"] = "0";
                          $data[0]['selectedBarcode'] = "null";
                          ////$data[0]['GROUP_SALENO'] = $combine_group_id;


                    /*=========================================
                    =            upload data to fb            =
                    =========================================*/
                    
                    $orderNode = 'test_orders/';//.$data[0]['SALENO'];
                    $newKey = $firebase->update([
                      $data[0]['SALENO'] => $data[0]
                    ], $orderNode);
                    // $newKey = $firebase->update([
                    //   'STATUS' => 'AWAITING',
                    //   'B_LOCATION' => (string)$bin_location,
                    //   'LOCATION_VRF' => $location_vrf
                    // ], $barcodeNode);

                    /*=====  End of upload data to fb  ======*/           
                }// if(count($data) > 0 ){

                     }else{// end if(empty($TRACKING_NUMBER) AND $ORDERSTATUS == 'Completed'){
                        /*=========================================
                        =            upload data to fb            =
                        =========================================*/
                        $data=file_get_contents('https://orderpulling.firebaseio.com/test_orders/'.$SALES_RECORD_NUMBER.'.json');

                        if($data != 'null'){
                            //echo "found";
                            
                            if($ORDERSTATUS === "Completed"){
                                $ORDERSTATUS = 'AWAITING';
                            }
                            $orderNode = 'test_orders/'.$SALES_RECORD_NUMBER;
                            $firebase->update([
                              'EBAY_STATUS' => (string)$ORDERSTATUS,
                              'TrackingNumber' => (string)$TRACKING_NUMBER,
                              'ORDER_STATUS' => "COMPLETED",
                              'GROUP_SALENO' => $combine_group_id
                            ], $orderNode);

                        }else{
                            if (php_sapi_name() == "cli") {
                                // In cli-mode
                                echo "order not found FB: $SALES_RECORD_NUMBER".PHP_EOL;
                            } else {
                                // Not in cli-mode
                                echo "order not found FB: $SALES_RECORD_NUMBER<br/>";
                            }
                            
                        }
                     }
                        
                        

                }// isert query if end

                   
                    // print_r($qry);//exit;
                    // echo "<br>";
                            
/*=============================================
=            lz_awaiting_shipment insertion           =
=============================================*/
if($orderStatus != 'Cancelled' && $TRACKING_NUMBER == '')
{
$TransactionID = $TRANSACTION_ID;
$SaleRecordID  = $recordnumber;
$OrderLineItemID = $orderlineitemid;                           
$lz_seller_account_id = $LZ_SELLER_ACCT_ID;
$this->db->query("INSERT INTO LZ_AWAITING_SHIPMENT (TRANSACTIONID, SALERECORDID, ORDERLINEITEMID, LZ_SELLER_ACCOUNT_ID) SELECT '$TransactionID', '$SaleRecordID', '$OrderLineItemID', '$lz_seller_account_id' FROM DUAL WHERE NOT EXISTS (SELECT * FROM LZ_AWAITING_SHIPMENT A WHERE A.ORDERLINEITEMID = '$OrderLineItemID') ");
}
                            
/*=====  End of lz_awaiting_shipment insertion ======*/                    
                            /*=====  End of following code is moved from outside forech to inside transaction foreach  ======*/
                            
                        }//end transaction array foreach
                    }// end transaction if
                }//end order status if
                //echo "---------------------------------------------------- \n";
    

    
            }// end orderstatus if
// ============================ End Insertion Process ===============================
        } // end foreach
    }else{
    echo "No Order Found";
    }
}




?>