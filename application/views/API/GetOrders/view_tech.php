<?php
/*  © 2013 eBay Inc., All Rights Reserved */ //Test
/* Licensed under CDDL 1.0 -  http://opensource.org/licenses/cddl1.php */
header("Content-Type: text/html; charset=UTF-8");
//$response = simplexml_import_dom($responseDoc);
if ($entries == 0) {
    echo "Sorry No entries found in the Time period requested. Change CreateTimeFrom/CreateTimeTo and Try again";
} else {
    $orders = $response->OrderArray->Order;
    if ($orders != null) {

        // =============== Start Checking if record already exist in lz_salesload_mt table ===============

    //select * from LZ_SALESLOAD_MT where loading_date = to_timestamp('2/26/2016 5:36:29 AM', 'dd/mm/yyyy hh24:mi:ss')
                //$current_date = date('m/d/Y');
               // date_default_timezone_set("Asia/Karachi");
                $current_date=date('Y-m-d');
                $current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD')";
     
                $LZ_SELLER_ACCT_ID= 1;//$this->session->userdata('account_type');

                //var_dump($current_date);exit;
                $q ="select * from LZ_SALESLOAD_MT where loading_date like $current_date and LZ_SELLER_ACCT_ID=$LZ_SELLER_ACCT_ID";
                $data = oci_parse($conn, $q);
                oci_execute($data,OCI_DEFAULT);
                $row = oci_fetch_array($data, OCI_ASSOC);
                $LZ_SALELOAD_ID = $row['LZ_SALELOAD_ID'];
    // =============== End Checking if record already exist in lz_salesload_mt table ===============

    // ========================== Starts Insertion in MT table ===============================
                if($row==false)
                {
                    
                    $max_id = "SELECT GET_SINGLE_PRIMARY_KEY('LZ_SALESLOAD_MT','LZ_SALELOAD_ID') LZ_SALELOAD_ID FROM DUAL";
                    $data = oci_parse($conn, $max_id);
                    oci_execute($data,OCI_DEFAULT);
                    $row = oci_fetch_array($data, OCI_ASSOC);
                    $LZ_SALELOAD_ID = $row['LZ_SALELOAD_ID'];
                    $max_id = "SELECT GET_SINGLE_PRIMARY_KEY('LZ_SALESLOAD_MT','LOADING_NO') LOADING_NO FROM DUAL";
                    $data = oci_parse($conn, $max_id);
                    oci_execute($data,OCI_DEFAULT);
                    $row = oci_fetch_array($data, OCI_ASSOC);
                    $LOADING_NO = $row['LOADING_NO'];
                    //$LOADING_DATE=date('Y-m-d H:i:s');
                    $LOADING_DATE=date('m/d/Y');
                    //var_dump($LOADING_DATE);exit;
                    $SALES_REF_NO=date('m/d/Y');
                    // $LOADING_DATE=date_format($LOADING_DATE,'d-M-y');
                    // $SALES_REF_NO=date_format($SALES_REF_NO,'d-M-y');
                    //$REMARKS=NULL;
                    $EXCEL_FILE_NAME=date('m/d/Y');
                    $EXCEL_FILE_NAME=$EXCEL_FILE_NAME."_".$LZ_SELLER_ACCT_ID;
                    $POSTED='Post in ERP';
                    //var_dump($LZ_SELLER_ACCT_ID);exit;

                    $comma = ',';
    // INSERT INTO lz_salesload_mt VALUES(147,88,to_date('09/03/2016', 'mm/dd/yyyy'),'09/03/2016',NULL,'09/03/2016','Post in ERP',1)
                    $insert_qry = "INSERT INTO lz_salesload_mt VALUES($LZ_SALELOAD_ID $comma $LOADING_NO $comma TO_DATE('$LOADING_DATE', 'mm/dd/yyyy') $comma '$SALES_REF_NO' $comma NULL $comma '$EXCEL_FILE_NAME' $comma '$POSTED' $comma $LZ_SELLER_ACCT_ID )";
                     $insert =oci_parse($conn, $insert_qry);
                    oci_execute($insert,OCI_DEFAULT);
                     print_r($insert_qry);//exit;
                    echo "<br>";
                    oci_commit($conn);
                }
                //var_dump($LZ_SALELOAD_ID);exit;
               // exit;
    // ========================== End Insertion in MT table ===============================

        foreach ($orders as $order) {
            
            $orderid=$order->OrderID;
            $orderStatus = $order->OrderStatus;
            $trackingnumber = $order->TransactionArray->Transaction->ShippingDetails->ShipmentTrackingDetails->ShipmentTrackingNumber;
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
                    $address = $shippingAddress->Name . ",";
                    if ($shippingAddress->Street1 != null) {
                        $address .=  $shippingAddress->Street1 . ",";
                        $street1=$shippingAddress->Street1;
                    }
                    if ($shippingAddress->Street2 != null) {
                        $address .=  $shippingAddress->Street2 ;
                        $street2=$shippingAddress->Street2;
                    }
                    if ($shippingAddress->AddressID != null) {
                        $addressid=$shippingAddress->AddressID;
                    }
                    if ($shippingAddress->CityName != null) {
                        $address .= $shippingAddress->CityName . ",";
                        $city =$shippingAddress->CityName;
                    }
                    if ($shippingAddress->StateOrProvince != null) {
                        $address .= $shippingAddress->StateOrProvince . "-";
                        $stateorprovince = $shippingAddress->StateOrProvince;
                    }
                    if ($shippingAddress->PostalCode != null) {
                        $address .= $shippingAddress->PostalCode . ",";
                        $postalcode=$shippingAddress->PostalCode;
                    }
                    if ($shippingAddress->CountryName != null) {
                        $address .= $shippingAddress->CountryName . ".";
                        $countryname = $shippingAddress->CountryName;
                        
                    }
                    if ($shippingAddress->Phone != null) {
                        $address .=  $shippingAddress->Phone . "";
                        $phoneno = $shippingAddress->Phone;
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
                            $quantitypurchased = $transaction->QuantityPurchased;
                            $buyeremail = $transaction->Buyer->Email;
                            $recordnumber = $transaction->ShippingDetails->SellingManagerSalesRecordNumber;
                            $buyername = $transaction->Buyer->UserFirstName ." ". $transaction->Buyer->UserLastName;
                            $datesold = $transaction->CreatedDate;
                            $datesold = str_split($datesold,19);
                            $datesold = str_replace('T'," ",$datesold[0]);
                            //  echo "T removed:".$test;
                            // echo "Date Soled:".$datesold[0];exit;
                            $ebayid = $transaction->Item->ItemID;
                            $itemtitle = $transaction->Item->Title;
                            $finalvaluefee = $transaction->FinalValueFee;
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
                    $data = oci_parse($conn, $max_id);
                    oci_execute($data,OCI_DEFAULT);
                    $row = oci_fetch_array($data, OCI_ASSOC);
                    $LZ_SALESLOAD_DET_ID = $row['LZ_SALESLOAD_DET_ID'];
                    
    //========================== Get LZ_SALELOAD_ID from lz_salesload_mt table end =============

    // ============================ Start Insertion Process =============================
                $WIZ_ERP_CODE = "''";
                $SALES_RECORD_NUMBER= $recordnumber;
                $USER_ID= $buyeruserid;
                $buyername = trim(str_replace("  ", '', $buyername));
                $buyername = trim(str_replace(array("'", '"'), "''", $buyername));
                $BUYER_FULLNAME= $buyername;
                $BUYER_PHONE_NUMBER= $phoneno;
                if($buyeremail){$BUYER_EMAIL= $buyeremail;}else{$BUYER_EMAIL= '';}
                $address = trim(str_replace("  ", '', $address));
                $address = trim(str_replace(array("'", '"'), "''", $address));
                $BUYER_ADDRESS1= $address;
                $BUYER_ADDRESS2= '';
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
                $ORDER_ID= $orderid;
                $ITEM_ID= $ebayid;
                $TRANSACTION_ID= $transactionid;
                $itemtitle = trim(str_replace("  ", '', $itemtitle));
                $itemtitle = trim(str_replace(array("'", '"'), "''", $itemtitle));
                $ITEM_TITLE= $itemtitle;
                $QUANTITY= $quantitypurchased;
                $SALE_PRICE= $transactionprice;
                $SHIPPING_AND_HANDLING= 0.00;
                $SALES_TAX= $salestaxamount;
                $INSURANCE= 0.00;
                $TOTAL_PRICE= $total;
                $PAYMENT_METHOD= $paymentmethod;
                $PAYPAL_TRANSACTION_ID= $externaltransactionid;
                $SALE_DATE= "TO_DATE('".$datesold."', 'YYYY-MM-DD HH24:MI:SS')"; //to_date('$datesold', 'yyyy/mm/dd')
                $CHECKOUT_DATE= "TO_DATE('".$checkoutdate."', 'YYYY-MM-DD HH24:MI:SS')";
                $PAID_ON_DATE= "TO_DATE('".$paidtime."', 'YYYY-MM-DD HH24:MI:SS')";
                if($shippedtime){$SHIPPED_ON_DATE= "TO_DATE('".$shippedtime."', 'YYYY-MM-DD HH24:MI:SS')";}else{$SHIPPED_ON_DATE="''";}
                //$SHIPPED_ON_DATE = $shippedtime;
                $SHIPPING_SERVICE= $shippingservice;
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
                $EBAY_FEE_PERC= $finalvaluefee;
                $PAYPAL_FEE_PERC= '';
                $PAYPAL_PER_TRANS_FEE= $paypalfee;
                $POSTED= 'post in erp';
                if($trackingnumber){$TRACKING_NUMBER= $trackingnumber;}else{$TRACKING_NUMBER= '';}
                $SHIP_TO_ADDRESS1= '';//PROFILE ADDRESS
                $SHIP_TO_ADDRESS2= ''; //SHIPPING ADDRESS
                $SHIP_TO_CITY= '';
                $SHIP_TO_STATE= '';
                $SHIP_TO_ZIP= '';
                $SHIP_TO_COUNTRY= '';
                $MANNUAL_YN= '';
                $MANNUAL_LOADED_BY_EMP_ID= '';
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
                //$select_query = "select * from LZ_SALESLOAD_mt m,LZ_SALESLOAD_det d where m.lz_saleload_id = d.lz_saleload_id and d.transaction_id='$TRANSACTION_ID' and m.lz_seller_acct_id =$LZ_SELLER_ACCT_ID";
                $select_query = "select * from LZ_SALESLOAD_det d where d.SALES_RECORD_NUMBER = $SALES_RECORD_NUMBER and d.transaction_id='$TRANSACTION_ID'";
                $select =oci_parse($conn, $select_query);
                oci_execute($select,OCI_DEFAULT);
                $num_row = oci_fetch_array($select, OCI_ASSOC);
                

    // ===================== End Checking if record already exist ===============================
                if((int)$SALE_RECORD_NO_GROUP_ID == (int)$SALES_RECORD_NUMBER){
                        $SALE_RECORD_NO_GROUP_ID = '';
                }
                if($num_row == false){

                    $qry = "INSERT INTO LZ_SALESLOAD_DET (WIZ_ERP_CODE, SALES_RECORD_NUMBER, USER_ID, BUYER_FULLNAME, BUYER_PHONE_NUMBER, BUYER_EMAIL, BUYER_ADDRESS1, BUYER_ADDRESS2, BUYER_CITY, BUYER_STATE, BUYER_ZIP, BUYER_COUNTRY, ITEM_ID, TRANSACTION_ID, ITEM_TITLE, QUANTITY, SALE_PRICE, SHIPPING_AND_HANDLING, SALES_TAX, INSURANCE, TOTAL_PRICE, PAYMENT_METHOD, PAYPAL_TRANSACTION_ID, SALE_DATE, CHECKOUT_DATE, PAID_ON_DATE, SHIPPED_ON_DATE, SHIPPING_SERVICE, FEEDBACK_LEFT, FEEDBACK_RECEIVED, NOTES_TO_YOURSELF, CUSTOM_LABEL, LISTED_ON, SOLD_ON, VARIATION_DETAILS, LZ_SALELOAD_ID, LZ_SALESLOAD_DET_ID, GNRTD_DC_ID, GNRTD_DC_DET_ID, GNRTD_INV_ID, GNRTD_INV_DET_ID, EBAY_FEE_PERC, PAYPAL_FEE_PERC, PAYPAL_PER_TRANS_FEE, POSTED, TRACKING_NUMBER, SHIP_TO_ADDRESS1, SHIP_TO_ADDRESS2, SHIP_TO_CITY, SHIP_TO_STATE, SHIP_TO_ZIP, SHIP_TO_COUNTRY, MANNUAL_YN, MANNUAL_LOADED_BY_EMP_ID, ORDER_ID, BUYER_CHECKOUT_MSG, BUYER_STREET1, BUYER_STREET2, BUYER_ADDRESS_ID, ORDERSTATUS, SHIPPING_CHARGES, SALES_RECORD_NO_GROUP) VALUES($WIZ_ERP_CODE $comma '$SALES_RECORD_NUMBER' $comma '$USER_ID' $comma '$BUYER_FULLNAME' $comma '$BUYER_PHONE_NUMBER' $comma '$BUYER_EMAIL' $comma '$BUYER_ADDRESS1' $comma '$BUYER_ADDRESS2' $comma '$BUYER_CITY' $comma '$BUYER_STATE' $comma '$BUYER_ZIP' $comma '$BUYER_COUNTRY' $comma '$ITEM_ID' $comma '$TRANSACTION_ID' $comma '$ITEM_TITLE' $comma $QUANTITY $comma $SALE_PRICE $comma $SHIPPING_AND_HANDLING $comma $SALES_TAX $comma $INSURANCE $comma $TOTAL_PRICE $comma '$PAYMENT_METHOD' $comma '$PAYPAL_TRANSACTION_ID' $comma $SALE_DATE $comma $CHECKOUT_DATE $comma $PAID_ON_DATE $comma $SHIPPED_ON_DATE $comma '$SHIPPING_SERVICE' $comma '$FEEDBACK_LEFT' $comma '$FEEDBACK_RECEIVED' $comma '$NOTES_TO_YOURSELF' $comma '$CUSTOM_LABEL' $comma '$LISTED_ON' $comma '$SOLD_ON' $comma '$VARIATION_DETAILS' $comma $LZ_SALELOAD_ID $comma $LZ_SALESLOAD_DET_ID $comma '$GNRTD_DC_ID' $comma '$GNRTD_DC_DET_ID' $comma '$GNRTD_INV_ID' $comma '$GNRTD_INV_DET_ID' $comma $EBAY_FEE_PERC $comma '$PAYPAL_FEE_PERC' $comma $PAYPAL_PER_TRANS_FEE $comma '$POSTED' $comma '$TRACKING_NUMBER' $comma '$SHIP_TO_ADDRESS1' $comma '$SHIP_TO_ADDRESS2' $comma '$SHIP_TO_CITY' $comma '$SHIP_TO_STATE' $comma '$SHIP_TO_ZIP' $comma '$SHIP_TO_COUNTRY' $comma '$MANNUAL_YN' $comma '$MANNUAL_LOADED_BY_EMP_ID' $comma '$ORDER_ID' $comma '$BUYER_CHECKOUT_MSG' $comma '$BUYER_STREET1' $comma '$BUYER_STREET2' $comma '$BUYER_ADDRESS_ID' $comma '$ORDERSTATUS' $comma $SHIPPING_CHARGES $comma '$SALE_RECORD_NO_GROUP_ID')";

                }else{
//,SHIPPING_CHARGES = $SHIPPING_CHARGES
                    $qry = "UPDATE LZ_SALESLOAD_DET SET TRACKING_NUMBER ='$TRACKING_NUMBER',SHIPPED_ON_DATE = $SHIPPED_ON_DATE,ORDERSTATUS='$ORDERSTATUS' WHERE SALES_RECORD_NUMBER = $SALES_RECORD_NUMBER AND TRANSACTION_ID='$TRANSACTION_ID'";
                }

                    $cmd =oci_parse($conn, $qry);
                    oci_execute($cmd,OCI_DEFAULT);
                    oci_commit($conn);
                    print_r($qry);//exit;
                    echo "<br>";
                            
                            
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