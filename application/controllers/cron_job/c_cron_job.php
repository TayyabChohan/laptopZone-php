<?php
use Kreait\Firebase\Configuration;
use Kreait\Firebase\Firebase;
class c_cron_job extends CI_Controller {
  public function __construct(){
    parent::__construct();
    $this->load->database();
    $this->load->model('rssFeed/m_rssfeed');
    $this->load->model('cron_job/m_cron_job');
    $this->load->helper('security');
    /*=============================================
    =  Section lz_bigData db connection block  =
    =============================================*/
    $CI = &get_instance();
    //setting the second parameter to TRUE (Boolean) the function will return the database object.
    $this->db2 = $CI->load->database('bigData', TRUE);
    /*======= End Section lz_bigData db connection block=====*/

    /*==============================================================
    =            get distinct category for rss feed url            =
    ==============================================================*/
    // $get_cat = $this->db2->query("SELECT DISTINCT CATEGORY_ID from LZ_BD_RSS_FEED_URL")->result_array();
    // foreach ($get_cat as $cat) {
    //   $this->cat_rss_feed($cat['CATEGORY_ID']);
    // }

    /*=====  End of get distinct category for rss feed url  ======*/
      
  }
  public function test_ebay()
  {
    $this->load->view('API/GetOrders/GetOrders_test');
  }
  public function getOrders_mod()
  {
    $this->load->view('API/GetOrders/getOrdersAll');
  }
  public function getOrders_ById()
  {
    $this->load->view('API/GetOrders/getOrdersAllById');
  }
  public function getSingleOrderById()
  {
    $result['LZ_SELLER_ACCT_ID']= $this->input->post("seller_id");
    $result['ORDER_ID']= $this->input->post("order_id");
    $result['print_r']= true;
    //var_dump($result);exit;

    //$result['LZ_SELLER_ACCT_ID']= '2';
    //$result['ORDER_ID']= '254243058755-2473168825015';// '07-03528-19848'
    $this->load->view('API/GetOrders/getSingleOrderById',$result);
    $response = $this->session->has_userdata('response');
    if($response){
      if(@$this->session->userdata('response') === 'error'){
        $data['response'] = @$this->session->userdata('response');
        $data['code'] = @$this->session->userdata('code');
        $data['shortMsg'] = @$this->session->userdata('shortMsg');
        $data['longMsg'] = @$this->session->userdata('longMsg');

        
        @$this->session->unset_userdata('code');
        @$this->session->unset_userdata('shortMsg');
        @$this->session->unset_userdata('longMsg');

      }else{
        $data['response'] = @$this->session->userdata('response');
      }

    }else{
      $data['response'] = 'Network';
    }
    @$this->session->unset_userdata('response');
    echo json_encode($data);
    return json_encode($data);
  }
// public function ebayNotificationListener()
//   {
// //$this->db->query("insert into EBAY_NOTEIFICATION (test_pk,E_data,insert_date,NOTIFICATION_TYPE) values (get_single_primary_key('EBAY_NOTEIFICATION','test_pk'),'from cron job',sysdate,'')");
//       // $result['data']=$this->m_cron_job->runAllSoldFeed();
//       //$this->load->view('firebase/listener');
//       // echo "All Category Feed Updated".PHP_EOL;

//       //$stdin = $GLOBALS['HTTP_RAW_POST_DATA'];
// $stdin = file_get_contents("php://input");
// file_put_contents('test.xml', $stdin,FILE_APPEND);
// // Loads the XML
// $xml = simplexml_load_string($stdin);

// $mainNode = $xml->children('http://schemas.xmlsoap.org/soap/envelope/')->Body->children()->getName();

// $this->db->query("insert into EBAY_NOTEIFICATION (test_pk,E_data,insert_date) values (get_single_primary_key('EBAY_NOTEIFICATION','test_pk'),'r1:$mainNode',sysdate)");
// $response = $xml->children('http://schemas.xmlsoap.org/soap/envelope/')->Body->children()->$mainNode;

// $NotificationEventName = (string) $response->NotificationEventName;
// $ItemID = (string) $response->Item->ItemID;

// $merchant_name = (string) $response->RecipientUserID;
// //$data['Timestamp'] = (string) $response->Timestamp;
// $Timestamp = (string) $response->Timestamp;

// $dTimestamp = (string) $response->Timestamp;

// $Timestamp = str_split($Timestamp,19);
// $Timestamp = str_replace('T'," ",$Timestamp[0]);
// $this->db->query("insert into EBAY_NOTEIFICATION (test_pk,E_data,insert_date) values (get_single_primary_key('EBAY_NOTEIFICATION','test_pk'),'NotificationEventName:$NotificationEventName , ItemID: $ItemID merchant_name: $merchant_name, ',sysdate)");
// if($mainNode == 'GetItemTransactionsResponse'){
// $Transaction = $response->TransactionArray->Transaction;
// $OrderID = $Transaction->ContainingOrder->OrderID;
// $this->db->query("insert into EBAY_NOTEIFICATION (test_pk,E_data,insert_date) values (get_single_primary_key('EBAY_NOTEIFICATION','test_pk'),'OrderID:$OrderID',sysdate)");
// $data['Timestamp'] = $Timestamp;
// $data['merchant_name'] = $merchant_name;
// $data['NotificationEventName'] = $NotificationEventName;
// $data['ItemID'] = $ItemID;
// $data['OrderID'] = $OrderID;
// //$this->load->view('API/GetOrders/GetOrders_notification',$data);
// $this->load->view('API/GetOrders/GetOrdersByID_notification',$data);

// }else{
// $this->db->query("insert into EBAY_NOTEIFICATION (test_pk,E_data,insert_date) values (get_single_primary_key('EBAY_NOTEIFICATION','test_pk'),'from else of mainnode ',sysdate)");
// }
// //7188


// //$this->db->query("insert into EBAY_NOTEIFICATION (test_pk,E_data,insert_date) values (get_single_primary_key('EBAY_NOTEIFICATION','test_pk'),'test.adil',sysdate)");
// //$qry = $this->db->query("insert into EBAY_NOTEIFICATION (test_pk,E_data,insert_date) values (get_single_primary_key('EBAY_NOTEIFICATION','test_pk'),'$dTimestamp',sysdate)");
// //$qry = $this->db->query("insert into EBAY_NOTEIFICATION (test_pk,E_data,insert_date) values (get_single_primary_key('EBAY_NOTEIFICATION','test_pk'),  'OK',sysdate)");

// //$qry = $this->db->query("insert into EBAY_NOTEIFICATION (test_pk,E_data,insert_date,NOTIFICATION_TYPE) values (get_single_primary_key('EBAY_NOTEIFICATION','test_pk'),'$OrderID cron_job',sysdate,'$NotificationEventName')");




// // uplaod data to fb
// // if(!empty($NotificationEventName)){
// //   require __DIR__.'/vendor/autoload.php';


// //   use Kreait\Firebase\Configuration;
// //   use Kreait\Firebase\Firebase;

// //   $config = new Configuration();
// //   //$config->setAuthConfigFile(__DIR__.'/secret/fbtest-e7425-8d3d759d5984.json');
// //   $config->setAuthConfigFile(__DIR__.'/secret/plateformnotification-b2648d771b9f.json');

// //   //$firebase = new Firebase('https://fbtest-e7425.firebaseio.com/', $config);
// //   $firebase = new Firebase('https://plateformnotification.firebaseio.com/', $config);

// //   // $firebase->set(['key' => 'value'], 'my/data');
// //   // $firebase->set('new value', 'my/data/key');

// //   $newKey = $firebase->push([
// //       'merchant_name' => $merchant_name,
// //       'Timestamp' => $Timestamp,
// //       'NotificationEventName' => $NotificationEventName,
// //       'ItemID' => $ItemID
// //   ], 'PlateformNotification/ebay/itemSold');
// // }


    
//   }
public function ebayNotificationListener()
{
//$this->db->query("insert into EBAY_NOTEIFICATION (test_pk,E_data,insert_date,NOTIFICATION_TYPE) values (get_single_primary_key('EBAY_NOTEIFICATION','test_pk'),'from cron job',sysdate,'')");
      // $result['data']=$this->m_cron_job->runAllSoldFeed();
      //$this->load->view('firebase/listener');
      // echo "All Category Feed Updated".PHP_EOL;

      //$stdin = $GLOBALS['HTTP_RAW_POST_DATA'];
  $stdin = file_get_contents("php://input");
  
  // Loads the XML
  $xml = simplexml_load_string($stdin);

  $mainNode = $xml->children('http://schemas.xmlsoap.org/soap/envelope/')->Body->children()->getName();

  $this->db->query("insert into EBAY_NOTEIFICATION (test_pk,E_data,insert_date) values (get_single_primary_key('EBAY_NOTEIFICATION','test_pk'),'r1:$mainNode',sysdate)");
  $response = $xml->children('http://schemas.xmlsoap.org/soap/envelope/')->Body->children()->$mainNode;

  $NotificationEventName = (string) $response->NotificationEventName;
  
  $merchant_name = (string) $response->RecipientUserID;
  //$data['Timestamp'] = (string) $response->Timestamp;
  $Timestamp = (string) $response->Timestamp;
  $dTimestamp = (string) $response->Timestamp;
  $Timestamp = str_split($Timestamp,19);
  $Timestamp = str_replace('T'," ",$Timestamp[0]);
  $ItemID = (string) $response->Item->ItemID;





  $this->db->query("insert into EBAY_NOTEIFICATION (test_pk,E_data,insert_date) values (get_single_primary_key('EBAY_NOTEIFICATION','test_pk'),'NotificationEventName:$NotificationEventName , ItemID: $ItemID merchant_name: $merchant_name, ',sysdate)");
  if($mainNode == 'GetItemTransactionsResponse'){
file_put_contents('test.xml', $stdin,FILE_APPEND);
 // exit;die();
  $currency = (string) $response->Item->Currency;//<Currency>USD</Currency>
  $itemid = (string) $response->Item->ItemID;//<ItemID>264298358737</ItemID>
  $listingtype = (string) $response->Item->ListingType;//<ListingType>FixedPriceItem</ListingType>
  $paymentmethods = (string) $response->Item->PaymentMethods;//<PaymentMethods>PayPal</PaymentMethods>
  $categoryid = (string) $response->Item->PrimaryCategory->CategoryID;//<CategoryID>PayPal</CategoryID>
  $convertedcurrentprice = (string) $response->Item->SellingStatus->ConvertedCurrentPrice;//<ConvertedCurrentPrice currencyID="USD">104.99</ConvertedCurrentPrice>
  $quantitysold = (string) $response->Item->SellingStatus->QuantitySold;
  $listingstatus = (string) $response->Item->SellingStatus->ListingStatus;
  $site = (string) $response->Item->Site;
  $title = (string) $response->Item->Title;
  $title = trim(str_replace("  ", '', $title));
  $title = trim(str_replace(array("'", '"'), "''", $title));
  $conditionid = (string) $response->Item->ConditionID;
  $conditiondisplayname = (string) $response->Item->ConditionDisplayName;
  $timestamp = (string) $response->Timestamp;
  /*=========================================
  =            transaction array            =
  =========================================*/
  $Transaction = $response->TransactionArray->Transaction;
  $amountpaid = $Transaction->AmountPaid;
  $adjustmentamount = $Transaction->AdjustmentAmount;
  $convertedadjustmentamount = $Transaction->ConvertedAdjustmentAmount;

  $Buyer = $Transaction->Buyer;
  $email = $Buyer->Email;
  $feedbackscore = $Buyer->FeedbackScore;
  $positivefeedbackpercent = $Buyer->PositiveFeedbackPercent;
  $feedbackratingstar = $Buyer->FeedbackRatingStar;
  $userid = $Buyer->UserID;
  $staticalias = $Buyer->StaticAlias;
  $userfirstname = $Buyer->UserFirstName;
  $userfirstname = trim(str_replace("  ", '', $userfirstname));
  $userfirstname = trim(str_replace(array("'", '"'), "''", $userfirstname));
  $userlastname = $Buyer->UserLastName;
  $userlastname = trim(str_replace("  ", '', $userlastname));
  $userlastname = trim(str_replace(array("'", '"'), "''", $userlastname));



  $BuyerInfo = $Buyer->BuyerInfo;
  $shipname = $BuyerInfo->ShippingAddress->Name;//shipName
  $shipname = trim(str_replace("  ", '', $shipname));
  $shipname = trim(str_replace(array("'", '"'), "''", $shipname));
  $street1 = $BuyerInfo->ShippingAddress->Street1;
  $street1 = trim(str_replace("  ", '', $street1));
  $street1 = trim(str_replace(array("'", '"'), "''", $street1));
  $street2 = $BuyerInfo->ShippingAddress->Street2;
  $street2 = trim(str_replace("  ", '', $street2));
  $street2 = trim(str_replace(array("'", '"'), "''", $street2));
  $cityname = $BuyerInfo->ShippingAddress->CityName;
  $cityname = trim(str_replace("  ", '', $cityname));
  $cityname = trim(str_replace(array("'", '"'), "''", $cityname));
  $stateorprovince = $BuyerInfo->ShippingAddress->StateOrProvince;
  $stateorprovince = trim(str_replace("  ", '', $stateorprovince));
  $stateorprovince = trim(str_replace(array("'", '"'), "''", $stateorprovince));
  $country = $BuyerInfo->ShippingAddress->Country;//US //CountryCode
  $countryname = $BuyerInfo->ShippingAddress->CountryName; // United States
  $countryname = trim(str_replace("  ", '', $countryname));
  $countryname = trim(str_replace(array("'", '"'), "''", $countryname));
  $phone = $BuyerInfo->ShippingAddress->Phone; 
  $postalcode = $BuyerInfo->ShippingAddress->PostalCode; 
  $addressid = $BuyerInfo->ShippingAddress->AddressID; 
  $addressowner = $BuyerInfo->ShippingAddress->AddressOwner; 
  $addressusage = $BuyerInfo->ShippingAddress->AddressUsage; //<AddressUsage>DefaultShipping</AddressUsage>

  $salestaxpercent = $Transaction->ShippingDetails->SalesTax->SalesTaxPercent;
  $salestaxamount = $Transaction->ShippingDetails->SalesTax->SalesTaxAmount;
  $shippingservice = $Transaction->ShippingDetails->ShippingServiceOptions->ShippingService;
  $shippingservicecost = $Transaction->ShippingDetails->ShippingServiceOptions->ShippingServiceCost;
  $shippingtype = $Transaction->ShippingDetails->ShippingType;
  $salesrecordnumber = $Transaction->ShippingDetails->SellingManagerSalesRecordNumber;//SalesRecordNumber

  $convertedamountpaid = $Transaction->ConvertedAmountPaid;
  $convertedtransactionprice = $Transaction->ConvertedTransactionPrice;
  $createddate = $Transaction->CreatedDate;
  $quantitypurchased = $Transaction->QuantityPurchased;
  $checkoutstatus = $Transaction->Status->CheckoutStatus;
  $lasttimemodified = $Transaction->Status->LastTimeModified;
  $paymentmethodused = $Transaction->Status->PaymentMethodUsed;
  $completestatus = $Transaction->Status->CompleteStatus;//<CompleteStatus>Complete</CompleteStatus>
  $buyerselectedshipping = $Transaction->Status->BuyerSelectedShipping;
  $paymentholdstatus = $Transaction->Status->PaymentHoldStatus;
  $inquirystatus = $Transaction->Status->InquiryStatus;
  $returnstatus = $Transaction->Status->ReturnStatus;
  $transactionid = $Transaction->TransactionID;
  $transactionprice = $Transaction->TransactionPrice;
  $externaltransactionid = $Transaction->ExternalTransaction->ExternalTransactionID;
  $externaltransactiontime = $Transaction->ExternalTransaction->ExternalTransactionTime;
  $feeorcreditamount = $Transaction->ExternalTransaction->FeeOrCreditAmount;
  $paymentorrefundamount = $Transaction->ExternalTransaction->PaymentOrRefundAmount;
  $externaltransactionstatus = $Transaction->ExternalTransaction->ExternalTransactionStatus;
  $shippingserviceselected = $Transaction->ShippingServiceSelected->ShippingService;
  $paidtime = $Transaction->PaidTime;
  $orderid = $Transaction->ContainingOrder->OrderID;
  $orderlineitemid = $Transaction->OrderLineItemID;
  $orderstatus = $Transaction->ContainingOrder->OrderStatus;
  $sales_record_no_group = $Transaction->ContainingOrder->ShippingDetails->SellingManagerSalesRecordNumber;//combine order only
  $cancelstatus = $Transaction->ContainingOrder->CancelStatus;
  $extendedorderid = $Transaction->ContainingOrder->ExtendedOrderID;
  $containsebayplustransaction = $Transaction->ContainingOrder->ContainseBayPlusTransaction;
  $finalvaluefee = $Transaction->FinalValueFee;
  $transactionsiteid = $Transaction->TransactionSiteID;
  $platform = $Transaction->Platform;
  $paypalemailaddress = $Transaction->PayPalEmailAddress;
  $buyercheckoutmessage = @$Transaction->BuyerCheckoutMessage;
  $buyercheckoutmessage = trim(str_replace("  ", '', $buyercheckoutmessage));
  $buyercheckoutmessage = trim(str_replace(array("'", '"'), "''", $buyercheckoutmessage));
  $actualshippingcost = $Transaction->ActualShippingCost;
  $actualhandlingcost = $Transaction->ActualHandlingCost;
  $ismultilegshipping = $Transaction->IsMultiLegShipping;// check for combine order <IsMultiLegShipping>false</IsMultiLegShipping>
  $intangibleitem = $Transaction->IntangibleItem;
  
  $paymentstatus = $Transaction->MonetaryDetails->Payments->Payment->PaymentStatus;
  $payer = $Transaction->MonetaryDetails->Payments->Payment->Payer;//<Payer type="eBayUser">02slva02</Payer>
  $payer = trim(str_replace("  ", '', $payer));
  $payer = trim(str_replace(array("'", '"'), "''", $payer));
  $payee = $Transaction->MonetaryDetails->Payments->Payment->Payee;//<Payee type="eBayUser">dfwonline</Payee>
  $payee = trim(str_replace("  ", '', $payee));
  $payee = trim(str_replace(array("'", '"'), "''", $payee));
  $paymenttime = $Transaction->MonetaryDetails->Payments->Payment->PaymentTime;//<Payee type="eBayUser">dfwonline</Payee>
  $paymentamount = $Transaction->MonetaryDetails->Payments->Payment->PaymentAmount;
  $referenceid = $Transaction->MonetaryDetails->Payments->Payment->ReferenceID;
  //$FeeOrCreditAmount = $Transaction->MonetaryDetails->Payments->Payment->FeeOrCreditAmount;//duplicate
  
  /*=====  End of transaction array  ======*/
  $item_id = $itemid;
  $countrycode = $country;
  $notificationeventname = $NotificationEventName;
  $timestamp = str_split($timestamp,19);
  $timestamp = str_replace('T'," ",$timestamp[0]); 

  $createddate = str_split($createddate,19);
  $createddate = str_replace('T'," ",$createddate[0]); 

  $externaltransactiontime = str_split($externaltransactiontime,19);
  $externaltransactiontime = str_replace('T'," ",$externaltransactiontime[0]); 
  
  $paidtime = str_split($paidtime,19);
  $paidtime = str_replace('T'," ",$paidtime[0]); 
  
  $paymenttime = str_split($paymenttime,19);
  $paymenttime = str_replace('T'," ",$paymenttime[0]); 
  

  $timestamp = "TO_DATE('".$timestamp."', 'YYYY-MM-DD HH24:MI:SS')";
  $createddate = "TO_DATE('".$createddate."', 'YYYY-MM-DD HH24:MI:SS')";
  $externaltransactiontime = "TO_DATE('".$externaltransactiontime."', 'YYYY-MM-DD HH24:MI:SS')";
  $paidtime = "TO_DATE('".$paidtime."', 'YYYY-MM-DD HH24:MI:SS')";
  $paymenttime = "TO_DATE('".$paymenttime."', 'YYYY-MM-DD HH24:MI:SS')";
 
/*========================================================
=            check if orderstatus = completed            =
========================================================*/
if($orderstatus == 'Completed'){


if(strpos($orderid, '-') !== false)//if order id contain - its mean its a single order not combine
{
  $combine_order_id = '';
}else{
  $combine_order_id = $orderid;
}
 $select_query = "select * from LJ_ITEMSOLD_NOTIFICATION d where d.orderid = '$orderlineitemid'";
    $row = $this->db->query($select_query)->result_array();

  // ===================== End Checking if record already exist ===============================

   if(count($row) == 0){
  $this->db->query("insert into LJ_ITEMSOLD_NOTIFICATION (
  notification_id,
  notificationeventname,
  merchant_name,
  timestamp,
  currency,
  item_id,
  listingtype,
  paymentmethods,
  categoryid,
  quantitysold,
  listingstatus,
  site,
  title,
  conditionid,
  conditiondisplayname,
  convertedcurrentprice,
  amountpaid,
  adjustmentamount,
  convertedadjustmentamount,
  email,
  feedbackscore,
  positivefeedbackpercent,
  userid,
  staticalias,
  userfirstname,
  userlastname,
  shipname,
  street1,
  cityname,
  stateorprovince,
  countrycode,
  countryname,
  phone,
  postalcode,
  addressid,
  addressowner,
  addressusage,
  salestaxpercent,
  salestaxamount,
  shippingservice,
  shippingservicecost,
  salesrecordnumber,
  convertedamountpaid,
  convertedtransactionprice,
  createddate,
  quantitypurchased,
  checkoutstatus,
  buyerselectedshipping,
  paymentholdstatus,
  inquirystatus,
  returnstatus,
  transactionid,
  transactionprice,
  externaltransactionid,
  externaltransactiontime,
  feeorcreditamount,
  paymentorrefundamount,
  externaltransactionstatus,
  shippingserviceselected,
  paidtime,
  orderid,
  orderstatus,
  cancelstatus,
  extendedorderid,
  containsebayplustransaction,
  finalvaluefee,
  transactionsiteid,
  platform,
  paypalemailaddress,
  buyercheckoutmessage,
  actualshippingcost,
  actualhandlingcost,
  ismultilegshipping,
  intangibleitem,
  paymentstatus,
  payer,
  payee,
  paymenttime,
  paymentamount,
  referenceid,
  sales_record_no_group,
  combine_order_id
  )
  values(
  get_single_primary_key('LJ_ITEMSOLD_NOTIFICATION','notification_id'),
  '$notificationeventname',
  '$merchant_name',
  $timestamp,
  '$currency',
  '$item_id',
  '$listingtype',
  '$paymentmethods',
  '$categoryid',
  '$quantitysold',
  '$listingstatus',
  '$site',
  '$title',
  '$conditionid',
  '$conditiondisplayname',
  '$convertedcurrentprice',
  '$amountpaid',
  '$adjustmentamount',
  '$convertedadjustmentamount',
  '$email',
  '$feedbackscore',
  '$positivefeedbackpercent',
  '$userid',
  '$staticalias',
  '$userfirstname',
  '$userlastname',
  '$shipname',
  '$street1',
  '$cityname',
  '$stateorprovince',
  '$countrycode',
  '$countryname',
  '$phone',
  '$postalcode',
  '$addressid',
  '$addressowner',
  '$addressusage',
  '$salestaxpercent',
  '$salestaxamount',
  '$shippingservice',
  '$shippingservicecost',
  '$salesrecordnumber',
  '$convertedamountpaid',
  '$convertedtransactionprice',
  $createddate,
  '$quantitypurchased',
  '$checkoutstatus',
  '$buyerselectedshipping',
  '$paymentholdstatus',
  '$inquirystatus',
  '$returnstatus',
  '$transactionid',
  '$transactionprice',
  '$externaltransactionid',
  $externaltransactiontime,
  '$feeorcreditamount',
  '$paymentorrefundamount',
  '$externaltransactionstatus',
  '$shippingserviceselected',
  $paidtime,
  '$orderlineitemid',
  '$orderstatus',
  '$cancelstatus',
  '$extendedorderid',
  '$containsebayplustransaction',
  '$finalvaluefee',
  '$transactionsiteid',
  '$platform',
  '$paypalemailaddress',
  '$buyercheckoutmessage',
  '$actualshippingcost',
  '$actualhandlingcost',
  '$ismultilegshipping',
  '$intangibleitem',
  '$paymentstatus',
  '$payer',
  '$payee',
  $paymenttime,
  '$paymentamount',
  '$referenceid',
  '$sales_record_no_group',
  '$combine_order_id'

  )");
} //close if(count($row) == 0){
 // $this->db->query("insert into EBAY_NOTEIFICATION (test_pk,E_data,insert_date) values (get_single_primary_key('EBAY_NOTEIFICATION','test_pk'),'OrderID:$orderid',sysdate)");

/*=================================================================
=            upload data to oracle db lz_salesload_det            =
=================================================================*/
  
  $get_seller = $this->db->query("SELECT S.LZ_SELLER_ACCT_ID FROM LZ_SELLER_ACCTS S, LJ_MERHCANT_ACC_DT D WHERE UPPER(TRIM(S.SELL_ACCT_DESC)) = UPPER(TRIM(D.ACCOUNT_NAME)) AND UPPER(TRIM(S.SELL_ACCT_DESC)) = UPPER('$merchant_name') AND ROWNUM = 1")->result_array();

  $LZ_SELLER_ACCT_ID = @$get_seller[0]['LZ_SELLER_ACCT_ID'];

/*==========================================================
=            insert data into lz_sales_load_det            =
==========================================================*/
 // =============== Start Checking if record already exist in lz_salesload_mt table ===============
      $current_date=date('Y-m-d');
      $current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD')";
      $q ="SELECT * FROM (select * from LZ_SALESLOAD_MT where loading_date like $current_date and LZ_SELLER_ACCT_ID=$LZ_SELLER_ACCT_ID ORDER BY LZ_SALELOAD_ID DESC) WHERE ROWNUM = 1";
      $row = $this->db->query($q);//->result_array();
// =============== End Checking if record already exist in lz_salesload_mt table ===============

    // ========================== Starts Insertion in MT table ===============================
    if($row->num_rows() == 0){
        $max_id = "SELECT GET_SINGLE_PRIMARY_KEY('LZ_SALESLOAD_MT','LZ_SALELOAD_ID') LZ_SALELOAD_ID FROM DUAL";
        $row = $this->db->query($max_id)->result_array();
        $lz_saleload_id = $row[0]['LZ_SALELOAD_ID'];
        $max_id = "SELECT GET_SINGLE_PRIMARY_KEY('LZ_SALESLOAD_MT','LOADING_NO') LOADING_NO FROM DUAL";
        $row = $this->db->query($max_id)->result_array();
        $LOADING_NO = $row[0]['LOADING_NO'];
        $LOADING_DATE=date('m/d/Y');
        $SALES_REF_NO=date('m/d/Y');
        $EXCEL_FILE_NAME=date('m/d/Y');
        $EXCEL_FILE_NAME=$EXCEL_FILE_NAME."_".$LZ_SELLER_ACCT_ID;
        $POSTED='Post in ERP';
        $comma = ',';
        $insert_qry = "INSERT INTO lz_salesload_mt VALUES($lz_saleload_id $comma $LOADING_NO $comma TO_DATE('$LOADING_DATE', 'mm/dd/yyyy') $comma '$SALES_REF_NO' $comma NULL $comma '$EXCEL_FILE_NAME' $comma '$POSTED' $comma $LZ_SELLER_ACCT_ID )";
        $this->db->query($insert_qry);
    }else{
        $row = $this->db->query($q)->result_array();
        $lz_saleload_id = $row[0]['LZ_SALELOAD_ID'];
    }
    // ========================== End Insertion in MT table ===============================
/*==============================================
=            insertion in det table            =
==============================================*/
$max_id = "SELECT GET_SINGLE_PRIMARY_KEY('LZ_SALESLOAD_DET','LZ_SALESLOAD_DET_ID') LZ_SALESLOAD_DET_ID FROM LZ_SALESLOAD_DET";
$row = $this->db->query($max_id)->result_array();
$lz_salesload_det_id = $row[0]['LZ_SALESLOAD_DET_ID'];

  // working Dat format = TO_DATE('2016-08-30 20:49:08', 'YYYY-MM-DD HH24:MI:SS')

  // ===================== Start Checking if record already exist ==============================
    $select_query = "select * from LZ_SALESLOAD_det d where d.order_id = '$orderlineitemid'";
    $row = $this->db->query($select_query)->result_array();

  // ===================== End Checking if record already exist ===============================

   if(count($row) == 0){

        $qry = "INSERT INTO LZ_SALESLOAD_DET (
sales_record_number,
user_id,
buyer_fullname,
buyer_phone_number,
buyer_email,
buyer_address1,
BUYER_ADDRESS2,
buyer_city,
buyer_state,
buyer_zip,
buyer_country,
item_id,
transaction_id,
item_title,
quantity,
sale_price,
shipping_and_handling,
sales_tax,
total_price,
payment_method,
paypal_transaction_id,
sale_date,
checkout_date,
paid_on_date,
shipping_service,
listed_on,
sold_on,
lz_saleload_id,
lz_salesload_det_id,
ebay_fee_perc,
paypal_per_trans_fee,
posted,
ship_to_address1,
SHIP_TO_ADDRESS2,
ship_to_city,
ship_to_state,
ship_to_zip,
ship_to_country,
mannual_yn,
order_id,
buyer_checkout_msg,
buyer_street1,
BUYER_STREET2,
buyer_address_id,
orderstatus,
sales_record_no_group,
ship_to_name,
ship_to_phone,
combine_order_id,
inserted_date,
extendedorderid,
conditionid,
conditiondisplayname )
values(
'$salesrecordnumber',
'$userid',
'$userfirstname $userlastname',
'$phone',
'$email',
'$street1',
'$street2',
'$cityname',
'$stateorprovince',
'$postalcode',
'$countryname',
'$item_id',
'$transactionid',
'$title',
'$quantitypurchased',
'$convertedcurrentprice',
'$actualhandlingcost',
'$salestaxamount',
'$convertedamountpaid',
'$paymentmethods',
'$externaltransactionid',
 $createddate,
 $externaltransactiontime,
 $paidtime,
'$shippingservice',
'$platform',
'$platform',
'$lz_saleload_id',
'$lz_salesload_det_id',
'$finalvaluefee',
'$feeorcreditamount',
'post in erp',
'$street1',
'$street2',
'$cityname',
'$stateorprovince',
'$postalcode',
'$countryname',
'2',
'$orderlineitemid',
'$buyercheckoutmessage',
'$street1',
'$street2',
'$addressid',
'$orderstatus',
'$sales_record_no_group',
'$shipname',
'$phone',
'$combine_order_id',
sysdate,
'$extendedorderid',
'$conditionid',
'$conditiondisplayname'
)";

    }else{
        $qry = "UPDATE LZ_SALESLOAD_DET SET ORDERSTATUS='$orderstatus' , EXTENDEDORDERID = '$extendedorderid' WHERE ORDER_ID = '$orderlineitemid'";
    }
        $this->db->query($qry);

/*=====  End of insertion in det table  ======*/



    /*=============================================
    =            lz_awaiting_shipment insertion           =
    =============================================*/
    if($orderstatus != 'Cancelled')
    {
      $lz_seller_account_id = $LZ_SELLER_ACCT_ID;
     
      $this->db->query("INSERT INTO LZ_AWAITING_SHIPMENT (TRANSACTIONID, SALERECORDID, ORDERLINEITEMID, LZ_SELLER_ACCOUNT_ID) SELECT '$transactionid', '$salesrecordnumber', '$orderlineitemid', '$lz_seller_account_id' FROM DUAL WHERE NOT EXISTS (SELECT * FROM LZ_AWAITING_SHIPMENT A WHERE A.ORDERLINEITEMID = '$orderlineitemid') ");
       
    }
                                
    /*=====  End of lz_awaiting_shipment insertion ======*/   



/*=====  End of insert data into lz_sales_load_det  ======*/

  // $data['Timestamp'] = $Timestamp;
  // $data['merchant_name'] = $merchant_name;
  // $data['NotificationEventName'] = $NotificationEventName;
  // $data['ItemID'] = $ItemID;
  // $data['OrderID'] = $OrderID;
  // $this->load->view('API/GetOrders/GetOrders_notification',$data);
  // $this->load->view('API/GetOrders/GetOrdersByID_notification',$data);

/*=====  End of upload data to oracle db lz_salesload_det  ======*/
/*========================================================
=            get required data from oracle db            =
========================================================*/

  $this->load->model('notification/m_notification','handler');
  $data = $this->handler->awaitingOrders($orderlineitemid);
  require __DIR__.'/vendor/autoload.php';
  $config = new Configuration();
  $config->setAuthConfigFile(__DIR__.'/secret/orderpulling-0a04788d3b7b.json');
  $firebase = new Firebase('https://orderpulling.firebaseio.com/', $config);
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

                $data_location = $this->handler->get_multi_location($data[$i]["EBAYID"]);
                
                $record_no =   $this->handler->get_shiping_services();
                
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

}//end if orderstatus = 'Completed'


/*=====  End of check if orderstatus = completed  ======*/


  }else{//if($mainNode == 'GetItemTransactionsResponse'){
  
  }//main else of if close



    
}

public function notificationTesting()
{
  
  // Loads the XML
  //$xml = simplexml_load_string($stdin);
  $xml = simplexml_load_file("testorder.xml");

  $mainNode = $xml->children('http://schemas.xmlsoap.org/soap/envelope/')->Body->children()->getName();


  $response = $xml->children('http://schemas.xmlsoap.org/soap/envelope/')->Body->children()->$mainNode;

  $NotificationEventName = (string) $response->NotificationEventName;
  
  $merchant_name = (string) $response->RecipientUserID;
  //$data['Timestamp'] = (string) $response->Timestamp;
  $Timestamp = (string) $response->Timestamp;
  $dTimestamp = (string) $response->Timestamp;
  $Timestamp = str_split($Timestamp,19);
  $Timestamp = str_replace('T'," ",$Timestamp[0]);
  $ItemID = (string) $response->Item->ItemID;






  if($mainNode == 'GetItemTransactionsResponse'){
//file_put_contents('test.xml', $stdin,FILE_APPEND);
//die('GetItemTransactionsResponse');
  $currency = (string) $response->Item->Currency;//<Currency>USD</Currency>
  $itemid = (string) $response->Item->ItemID;//<ItemID>264298358737</ItemID>
  $listingtype = (string) $response->Item->ListingType;//<ListingType>FixedPriceItem</ListingType>
  $paymentmethods = (string) $response->Item->PaymentMethods;//<PaymentMethods>PayPal</PaymentMethods>
  $categoryid = (string) $response->Item->PrimaryCategory->CategoryID;//<CategoryID>PayPal</CategoryID>
  $convertedcurrentprice = (string) $response->Item->SellingStatus->ConvertedCurrentPrice;//<ConvertedCurrentPrice currencyID="USD">104.99</ConvertedCurrentPrice>
  $quantitysold = (string) $response->Item->SellingStatus->QuantitySold;
  $listingstatus = (string) $response->Item->SellingStatus->ListingStatus;
  $site = (string) $response->Item->Site;
  $title = (string) $response->Item->Title;
  $title = trim(str_replace("  ", '', $title));
  $title = trim(str_replace(array("'", '"'), "''", $title));
  $conditionid = (string) $response->Item->ConditionID;
  $conditiondisplayname = (string) $response->Item->ConditionDisplayName;
  $timestamp = (string) $response->Timestamp;
  /*=========================================
  =            transaction array            =
  =========================================*/
  $Transaction = $response->TransactionArray->Transaction;
  $amountpaid = $Transaction->AmountPaid;
  $adjustmentamount = $Transaction->AdjustmentAmount;
  $convertedadjustmentamount = $Transaction->ConvertedAdjustmentAmount;

  $Buyer = $Transaction->Buyer;
  $email = $Buyer->Email;
  $feedbackscore = $Buyer->FeedbackScore;
  $positivefeedbackpercent = $Buyer->PositiveFeedbackPercent;
  $feedbackratingstar = $Buyer->FeedbackRatingStar;
  $userid = $Buyer->UserID;
  $staticalias = $Buyer->StaticAlias;
  $userfirstname = $Buyer->UserFirstName;
  $userfirstname = trim(str_replace("  ", '', $userfirstname));
  $userfirstname = trim(str_replace(array("'", '"'), "''", $userfirstname));
  $userlastname = $Buyer->UserLastName;
  $userlastname = trim(str_replace("  ", '', $userlastname));
  $userlastname = trim(str_replace(array("'", '"'), "''", $userlastname));



  $BuyerInfo = $Buyer->BuyerInfo;
  $shipname = $BuyerInfo->ShippingAddress->Name;//shipName
  $shipname = trim(str_replace("  ", '', $shipname));
  $shipname = trim(str_replace(array("'", '"'), "''", $shipname));
  $street1 = $BuyerInfo->ShippingAddress->Street1;
  $street1 = trim(str_replace("  ", '', $street1));
  $street1 = trim(str_replace(array("'", '"'), "''", $street1));
  $street2 = $BuyerInfo->ShippingAddress->Street2;
  $street2 = trim(str_replace("  ", '', $street2));
  $street2 = trim(str_replace(array("'", '"'), "''", $street2));
  $cityname = $BuyerInfo->ShippingAddress->CityName;
  $cityname = trim(str_replace("  ", '', $cityname));
  $cityname = trim(str_replace(array("'", '"'), "''", $cityname));
  $stateorprovince = $BuyerInfo->ShippingAddress->StateOrProvince;
  $stateorprovince = trim(str_replace("  ", '', $stateorprovince));
  $stateorprovince = trim(str_replace(array("'", '"'), "''", $stateorprovince));
  $country = $BuyerInfo->ShippingAddress->Country;//US //CountryCode
  $countryname = $BuyerInfo->ShippingAddress->CountryName; // United States
  $countryname = trim(str_replace("  ", '', $countryname));
  $countryname = trim(str_replace(array("'", '"'), "''", $countryname));
  $phone = $BuyerInfo->ShippingAddress->Phone; 
  $postalcode = $BuyerInfo->ShippingAddress->PostalCode; 
  $addressid = $BuyerInfo->ShippingAddress->AddressID; 
  $addressowner = $BuyerInfo->ShippingAddress->AddressOwner; 
  $addressusage = $BuyerInfo->ShippingAddress->AddressUsage; //<AddressUsage>DefaultShipping</AddressUsage>

  $salestaxpercent = $Transaction->ShippingDetails->SalesTax->SalesTaxPercent;
  $salestaxamount = $Transaction->ShippingDetails->SalesTax->SalesTaxAmount;
  $shippingservice = $Transaction->ShippingDetails->ShippingServiceOptions->ShippingService;
  $shippingservicecost = $Transaction->ShippingDetails->ShippingServiceOptions->ShippingServiceCost;
  $shippingtype = $Transaction->ShippingDetails->ShippingType;
  $salesrecordnumber = $Transaction->ShippingDetails->SellingManagerSalesRecordNumber;//SalesRecordNumber

  $convertedamountpaid = $Transaction->ConvertedAmountPaid;
  $convertedtransactionprice = $Transaction->ConvertedTransactionPrice;
  $createddate = $Transaction->CreatedDate;
  $quantitypurchased = $Transaction->QuantityPurchased;
  $checkoutstatus = $Transaction->Status->CheckoutStatus;
  $lasttimemodified = $Transaction->Status->LastTimeModified;
  $paymentmethodused = $Transaction->Status->PaymentMethodUsed;
  $completestatus = $Transaction->Status->CompleteStatus;//<CompleteStatus>Complete</CompleteStatus>
  $buyerselectedshipping = $Transaction->Status->BuyerSelectedShipping;
  $paymentholdstatus = $Transaction->Status->PaymentHoldStatus;
  $inquirystatus = $Transaction->Status->InquiryStatus;
  $returnstatus = $Transaction->Status->ReturnStatus;
  $transactionid = $Transaction->TransactionID;
  $transactionprice = $Transaction->TransactionPrice;
  $externaltransactionid = $Transaction->ExternalTransaction->ExternalTransactionID;
  $externaltransactiontime = $Transaction->ExternalTransaction->ExternalTransactionTime;
  $feeorcreditamount = $Transaction->ExternalTransaction->FeeOrCreditAmount;
  $paymentorrefundamount = $Transaction->ExternalTransaction->PaymentOrRefundAmount;
  $externaltransactionstatus = $Transaction->ExternalTransaction->ExternalTransactionStatus;
  $shippingserviceselected = $Transaction->ShippingServiceSelected->ShippingService;
  $paidtime = $Transaction->PaidTime;
  $orderid = $Transaction->ContainingOrder->OrderID;
  $orderlineitemid = $Transaction->OrderLineItemID;
  $orderstatus = $Transaction->ContainingOrder->OrderStatus;
  $sales_record_no_group = $Transaction->ContainingOrder->ShippingDetails->SellingManagerSalesRecordNumber;//combine order only
  $cancelstatus = $Transaction->ContainingOrder->CancelStatus;
  $extendedorderid = $Transaction->ContainingOrder->ExtendedOrderID;
  $containsebayplustransaction = $Transaction->ContainingOrder->ContainseBayPlusTransaction;
  $finalvaluefee = $Transaction->FinalValueFee;
  $transactionsiteid = $Transaction->TransactionSiteID;
  $platform = $Transaction->Platform;
  $paypalemailaddress = $Transaction->PayPalEmailAddress;
  $buyercheckoutmessage = @$Transaction->BuyerCheckoutMessage;
  $buyercheckoutmessage = trim(str_replace("  ", '', $buyercheckoutmessage));
  $buyercheckoutmessage = trim(str_replace(array("'", '"'), "''", $buyercheckoutmessage));
  $actualshippingcost = $Transaction->ActualShippingCost;
  $actualhandlingcost = $Transaction->ActualHandlingCost;
  $ismultilegshipping = $Transaction->IsMultiLegShipping;// check for combine order <IsMultiLegShipping>false</IsMultiLegShipping>
  $intangibleitem = $Transaction->IntangibleItem;
  
  $paymentstatus = $Transaction->MonetaryDetails->Payments->Payment->PaymentStatus;
  $payer = $Transaction->MonetaryDetails->Payments->Payment->Payer;//<Payer type="eBayUser">02slva02</Payer>
  $payer = trim(str_replace("  ", '', $payer));
  $payer = trim(str_replace(array("'", '"'), "''", $payer));
  $payee = $Transaction->MonetaryDetails->Payments->Payment->Payee;//<Payee type="eBayUser">dfwonline</Payee>
  $payee = trim(str_replace("  ", '', $payee));
  $payee = trim(str_replace(array("'", '"'), "''", $payee));
  $paymenttime = $Transaction->MonetaryDetails->Payments->Payment->PaymentTime;//<Payee type="eBayUser">dfwonline</Payee>
  $paymentamount = $Transaction->MonetaryDetails->Payments->Payment->PaymentAmount;
  $referenceid = $Transaction->MonetaryDetails->Payments->Payment->ReferenceID;
  //$FeeOrCreditAmount = $Transaction->MonetaryDetails->Payments->Payment->FeeOrCreditAmount;//duplicate
  
  /*=====  End of transaction array  ======*/
  $item_id = $itemid;
  $countrycode = $country;
  $notificationeventname = $NotificationEventName;
  $timestamp = str_split($timestamp,19);
  $timestamp = str_replace('T'," ",$timestamp[0]); 

  $createddate = str_split($createddate,19);
  $createddate = str_replace('T'," ",$createddate[0]); 

  $externaltransactiontime = str_split($externaltransactiontime,19);
  $externaltransactiontime = str_replace('T'," ",$externaltransactiontime[0]); 
  
  $paidtime = str_split($paidtime,19);
  $paidtime = str_replace('T'," ",$paidtime[0]); 
  
  $paymenttime = str_split($paymenttime,19);
  $paymenttime = str_replace('T'," ",$paymenttime[0]); 
  

  $timestamp = "TO_DATE('".$timestamp."', 'YYYY-MM-DD HH24:MI:SS')";
  $createddate = "TO_DATE('".$createddate."', 'YYYY-MM-DD HH24:MI:SS')";
  $externaltransactiontime = "TO_DATE('".$externaltransactiontime."', 'YYYY-MM-DD HH24:MI:SS')";
  $paidtime = "TO_DATE('".$paidtime."', 'YYYY-MM-DD HH24:MI:SS')";
  $paymenttime = "TO_DATE('".$paymenttime."', 'YYYY-MM-DD HH24:MI:SS')";
 
if(strpos($orderid, '-') !== false)//if order id contain - its mean its a single order not combine
{
  $combine_order_id = '';
}else{
  $combine_order_id = $orderid;
}
 $select_query = "select * from LJ_ITEMSOLD_NOTIFICATION d where d.orderid = '$orderlineitemid'";
    $row = $this->db->query($select_query)->result_array();

  // ===================== End Checking if record already exist ===============================

   if(count($row) == 0){
  $this->db->query("insert into LJ_ITEMSOLD_NOTIFICATION (
  notification_id,
  notificationeventname,
  merchant_name,
  timestamp,
  currency,
  item_id,
  listingtype,
  paymentmethods,
  categoryid,
  quantitysold,
  listingstatus,
  site,
  title,
  conditionid,
  conditiondisplayname,
  convertedcurrentprice,
  amountpaid,
  adjustmentamount,
  convertedadjustmentamount,
  email,
  feedbackscore,
  positivefeedbackpercent,
  userid,
  staticalias,
  userfirstname,
  userlastname,
  shipname,
  street1,
  cityname,
  stateorprovince,
  countrycode,
  countryname,
  phone,
  postalcode,
  addressid,
  addressowner,
  addressusage,
  salestaxpercent,
  salestaxamount,
  shippingservice,
  shippingservicecost,
  salesrecordnumber,
  convertedamountpaid,
  convertedtransactionprice,
  createddate,
  quantitypurchased,
  checkoutstatus,
  buyerselectedshipping,
  paymentholdstatus,
  inquirystatus,
  returnstatus,
  transactionid,
  transactionprice,
  externaltransactionid,
  externaltransactiontime,
  feeorcreditamount,
  paymentorrefundamount,
  externaltransactionstatus,
  shippingserviceselected,
  paidtime,
  orderid,
  orderstatus,
  cancelstatus,
  extendedorderid,
  containsebayplustransaction,
  finalvaluefee,
  transactionsiteid,
  platform,
  paypalemailaddress,
  buyercheckoutmessage,
  actualshippingcost,
  actualhandlingcost,
  ismultilegshipping,
  intangibleitem,
  paymentstatus,
  payer,
  payee,
  paymenttime,
  paymentamount,
  referenceid,
  sales_record_no_group,
  combine_order_id
  )
  values(
  get_single_primary_key('LJ_ITEMSOLD_NOTIFICATION','notification_id'),
  '$notificationeventname',
  '$merchant_name',
  $timestamp,
  '$currency',
  '$item_id',
  '$listingtype',
  '$paymentmethods',
  '$categoryid',
  '$quantitysold',
  '$listingstatus',
  '$site',
  '$title',
  '$conditionid',
  '$conditiondisplayname',
  '$convertedcurrentprice',
  '$amountpaid',
  '$adjustmentamount',
  '$convertedadjustmentamount',
  '$email',
  '$feedbackscore',
  '$positivefeedbackpercent',
  '$userid',
  '$staticalias',
  '$userfirstname',
  '$userlastname',
  '$shipname',
  '$street1',
  '$cityname',
  '$stateorprovince',
  '$countrycode',
  '$countryname',
  '$phone',
  '$postalcode',
  '$addressid',
  '$addressowner',
  '$addressusage',
  '$salestaxpercent',
  '$salestaxamount',
  '$shippingservice',
  '$shippingservicecost',
  '$salesrecordnumber',
  '$convertedamountpaid',
  '$convertedtransactionprice',
  $createddate,
  '$quantitypurchased',
  '$checkoutstatus',
  '$buyerselectedshipping',
  '$paymentholdstatus',
  '$inquirystatus',
  '$returnstatus',
  '$transactionid',
  '$transactionprice',
  '$externaltransactionid',
  $externaltransactiontime,
  '$feeorcreditamount',
  '$paymentorrefundamount',
  '$externaltransactionstatus',
  '$shippingserviceselected',
  $paidtime,
  '$orderlineitemid',
  '$orderstatus',
  '$cancelstatus',
  '$extendedorderid',
  '$containsebayplustransaction',
  '$finalvaluefee',
  '$transactionsiteid',
  '$platform',
  '$paypalemailaddress',
  '$buyercheckoutmessage',
  '$actualshippingcost',
  '$actualhandlingcost',
  '$ismultilegshipping',
  '$intangibleitem',
  '$paymentstatus',
  '$payer',
  '$payee',
  $paymenttime,
  '$paymentamount',
  '$referenceid',
  '$sales_record_no_group',
  '$combine_order_id'

  )");
}// if close  if(count($row) == 0){
 // $this->db->query("insert into EBAY_NOTEIFICATION (test_pk,E_data,insert_date) values (get_single_primary_key('EBAY_NOTEIFICATION','test_pk'),'OrderID:$orderid',sysdate)");

/*=================================================================
=            upload data to oracle db lz_salesload_det            =
=================================================================*/
  
  $get_seller = $this->db->query("SELECT S.LZ_SELLER_ACCT_ID FROM LZ_SELLER_ACCTS S, LJ_MERHCANT_ACC_DT D WHERE UPPER(TRIM(S.SELL_ACCT_DESC)) = UPPER(TRIM(D.ACCOUNT_NAME)) AND UPPER(TRIM(S.SELL_ACCT_DESC)) = UPPER('$merchant_name') AND ROWNUM = 1")->result_array();

  $LZ_SELLER_ACCT_ID = @$get_seller[0]['LZ_SELLER_ACCT_ID'];

/*==========================================================
=            insert data into lz_sales_load_det            =
==========================================================*/
 // =============== Start Checking if record already exist in lz_salesload_mt table ===============
      $current_date=date('Y-m-d');
      $current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD')";
      $q ="SELECT * FROM (select * from LZ_SALESLOAD_MT where loading_date like $current_date and LZ_SELLER_ACCT_ID=$LZ_SELLER_ACCT_ID ORDER BY LZ_SALELOAD_ID DESC) WHERE ROWNUM = 1";
      $row = $this->db->query($q);//->result_array();
// =============== End Checking if record already exist in lz_salesload_mt table ===============

    // ========================== Starts Insertion in MT table ===============================
    if($row->num_rows() == 0){
        $max_id = "SELECT GET_SINGLE_PRIMARY_KEY('LZ_SALESLOAD_MT','LZ_SALELOAD_ID') LZ_SALELOAD_ID FROM DUAL";
        $row = $this->db->query($max_id)->result_array();
        $lz_saleload_id = $row[0]['LZ_SALELOAD_ID'];
        $max_id = "SELECT GET_SINGLE_PRIMARY_KEY('LZ_SALESLOAD_MT','LOADING_NO') LOADING_NO FROM DUAL";
        $row = $this->db->query($max_id)->result_array();
        $LOADING_NO = $row[0]['LOADING_NO'];
        $LOADING_DATE=date('m/d/Y');
        $SALES_REF_NO=date('m/d/Y');
        $EXCEL_FILE_NAME=date('m/d/Y');
        $EXCEL_FILE_NAME=$EXCEL_FILE_NAME."_".$LZ_SELLER_ACCT_ID;
        $POSTED='Post in ERP';
        $comma = ',';
        $insert_qry = "INSERT INTO lz_salesload_mt VALUES($lz_saleload_id $comma $LOADING_NO $comma TO_DATE('$LOADING_DATE', 'mm/dd/yyyy') $comma '$SALES_REF_NO' $comma NULL $comma '$EXCEL_FILE_NAME' $comma '$POSTED' $comma $LZ_SELLER_ACCT_ID )";
        $this->db->query($insert_qry);
    }else{
        $row = $this->db->query($q)->result_array();
        $lz_saleload_id = $row[0]['LZ_SALELOAD_ID'];
    }
    // ========================== End Insertion in MT table ===============================
/*==============================================
=            insertion in det table            =
==============================================*/
$max_id = "SELECT GET_SINGLE_PRIMARY_KEY('LZ_SALESLOAD_DET','LZ_SALESLOAD_DET_ID') LZ_SALESLOAD_DET_ID FROM LZ_SALESLOAD_DET";
$row = $this->db->query($max_id)->result_array();
$lz_salesload_det_id = $row[0]['LZ_SALESLOAD_DET_ID'];

  // working Dat format = TO_DATE('2016-08-30 20:49:08', 'YYYY-MM-DD HH24:MI:SS')

  // ===================== Start Checking if record already exist ==============================
    $select_query = "select * from LZ_SALESLOAD_det d where d.order_id = '$orderlineitemid'";
    $row = $this->db->query($select_query)->result_array();

  // ===================== End Checking if record already exist ===============================

   if(count($row) == 0){

        $qry = "INSERT INTO LZ_SALESLOAD_DET (
sales_record_number,
user_id,
buyer_fullname,
buyer_phone_number,
buyer_email,
buyer_address1,
BUYER_ADDRESS2,
buyer_city,
buyer_state,
buyer_zip,
buyer_country,
item_id,
transaction_id,
item_title,
quantity,
sale_price,
shipping_and_handling,
sales_tax,
total_price,
payment_method,
paypal_transaction_id,
sale_date,
checkout_date,
paid_on_date,
shipping_service,
listed_on,
sold_on,
lz_saleload_id,
lz_salesload_det_id,
ebay_fee_perc,
paypal_per_trans_fee,
posted,
ship_to_address1,
SHIP_TO_ADDRESS2,
ship_to_city,
ship_to_state,
ship_to_zip,
ship_to_country,
mannual_yn,
order_id,
buyer_checkout_msg,
buyer_street1,
BUYER_STREET2,
buyer_address_id,
orderstatus,
sales_record_no_group,
ship_to_name,
ship_to_phone,
combine_order_id,
inserted_date,
extendedorderid )
values(
'$salesrecordnumber',
'$userid',
'$userfirstname $userlastname',
'$phone',
'$email',
'$street1',
'$street2',
'$cityname',
'$stateorprovince',
'$postalcode',
'$countryname',
'$item_id',
'$transactionid',
'$title',
'$quantitypurchased',
'$convertedcurrentprice',
'$actualhandlingcost',
'$salestaxamount',
'$convertedamountpaid',
'$paymentmethods',
'$externaltransactionid',
 $createddate,
 $externaltransactiontime,
 $paidtime,
'$shippingservice',
'$platform',
'$platform',
'$lz_saleload_id',
'$lz_salesload_det_id',
'$finalvaluefee',
'$feeorcreditamount',
'post in erp',
'$street1',
'$street2',
'$cityname',
'$stateorprovince',
'$postalcode',
'$countryname',
'2',
'$orderlineitemid',
'$buyercheckoutmessage',
'$street1',
'$street2',
'$addressid',
'$orderstatus',
'$sales_record_no_group',
'$shipname',
'$phone',
'$combine_order_id',
sysdate,
'$extendedorderid'
)";

    }else{
        $qry = "UPDATE LZ_SALESLOAD_DET SET ORDERSTATUS='$orderstatus' WHERE ORDER_ID = '$orderlineitemid'";
    }
        $this->db->query($qry);

/*=====  End of insertion in det table  ======*/



    /*=============================================
    =            lz_awaiting_shipment insertion           =
    =============================================*/
    if($orderstatus != 'Cancelled')
    {
      $lz_seller_account_id = $LZ_SELLER_ACCT_ID;
     
      $this->db->query("INSERT INTO LZ_AWAITING_SHIPMENT (TRANSACTIONID, SALERECORDID, ORDERLINEITEMID, LZ_SELLER_ACCOUNT_ID) SELECT '$transactionid', '$salesrecordnumber', '$orderlineitemid', '$lz_seller_account_id' FROM DUAL WHERE NOT EXISTS (SELECT * FROM LZ_AWAITING_SHIPMENT A WHERE A.ORDERLINEITEMID = '$orderlineitemid') ");
       
    }
                                
    /*=====  End of lz_awaiting_shipment insertion ======*/   



/*=====  End of insert data into lz_sales_load_det  ======*/

  // $data['Timestamp'] = $Timestamp;
  // $data['merchant_name'] = $merchant_name;
  // $data['NotificationEventName'] = $NotificationEventName;
  // $data['ItemID'] = $ItemID;
  // $data['OrderID'] = $OrderID;
  // $this->load->view('API/GetOrders/GetOrders_notification',$data);
  // $this->load->view('API/GetOrders/GetOrdersByID_notification',$data);

/*=====  End of upload data to oracle db lz_salesload_det  ======*/
/*========================================================
=            get required data from oracle db            =
========================================================*/

  $this->load->model('notification/m_notification','handler');
  $data = $this->handler->awaitingOrders($orderlineitemid);
   require __DIR__.'/vendor/autoload.php';
      $config = new Configuration();
      $config->setAuthConfigFile(__DIR__.'/secret/orderpulling-0a04788d3b7b.json');
      $firebase = new Firebase('https://orderpulling.firebaseio.com/', $config);
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

                $data_location = $this->handler->get_multi_location($data[$i]["EBAYID"]);
                
                $record_no =   $this->handler->get_shiping_services();
                
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
            $barcodeNode = 'test_Barcodes/'.$data[0]['ITM_ID'].'/'.$data[0]['SALENO'].'/'.$data[0]['DEF_BARCODE'];
            $availableBarcodeNode = 'test_Barcodes/'.$data[0]['ITM_ID'].'/AVAILABLE';
            $bin_location = $data[0]["BIN_LOCATION"];
            $location_vrf = true;
            if(empty($data[0]["LOCATION_VRF"]))
            {
                $location_vrf = false;
            }
            $availibleBarcodes = $data[0]["BARCODEARRAY"];
            //var_dump(count($availibleBarcodes));exit;
            
            for($k=0; $k< count($availibleBarcodes); $k++)
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
      $newKey = $firebase->update([
        'STATUS' => 'AWAITING',
        'B_LOCATION' => (string)$bin_location,
        'LOCATION_VRF' => $location_vrf
      ], $barcodeNode);

      /*=====  End of upload data to fb  ======*/           
  }// if(count($data) > 0 ){

  }else{//if($mainNode == 'GetItemTransactionsResponse'){
  
  }//main else of if close


    
}

  public function getOrders_new()
  {

      // $result['data']=$this->m_cron_job->runAllSoldFeed();
      $this->load->view('API/GetOrders/GetAllAccOrders');
      // echo "All Category Feed Updated".PHP_EOL;
    
  }

  public function recognizeDatajob()
  {
    $this->db2->query("CALL PRO_RECOG_DATA_JOB()");
      //$verify_pro = "CALL PRO_RECOG_DATA_JOB()";
  }
  public function testFunction()
  {
    $response = 'ok';
    //$data = $this->db->query("DECLARE RESPONSE VARCHAR2(200); BEGIN pro_processAgingItemSingle('1',RESPONSE); DBMS_OUTPUT.put_line(RESPONSE); END;")->result_array();
    $sql = "call pro_processAgingItemSingle('1',?)";
    $data = $this->db->query($sql,'OK')->result_array();
    var_dump($data);
  }
  public function createActiveListingUrlFile()
  {
    $this->m_cron_job->createActiveListingUrlFile();
    echo "Feed Updated".PHP_EOL;
      //$verify_pro = "CALL PRO_RECOG_DATA_JOB()";
  }
  public function auto_rss_feed()
  {
    //$this->output->nocache();
    $this->load->library('rssparser');
    //for  ($k = 1; $k <=  100000000000000; $k++) {
      
      //$result['pageTitle'] = 'eBay RSS Feed';
      $this->m_rssfeed->auto_rss_feed();
      echo "Feed Updated".PHP_EOL;
     
       $this->auto_rss_feed();
    //}
  }
  public function cat_rss_feed($cat_id = '')
  {
    if(!empty($cat_id)){
      $this->load->library('rssparser');
      $this->m_cron_job->cat_rss_feed($cat_id);
      echo $cat_id ."-Feed Updated".PHP_EOL;
      $this->cat_rss_feed($cat_id);
    }else{
      echo 'category_id not found';
    }
  }

  public function lookup_feed($feed_id = '')
  {
    if(!empty($feed_id)){
      $this->load->library('rssparser');
      $this->m_cron_job->lookup_feed($feed_id);
      echo $feed_id ."-Feed Updated".PHP_EOL;
      $this->lookup_feed($feed_id);
    }else{
      echo 'feed_id not found';
    }
  }
  public function lookup_sold_feed($feed_id = '')
  {
    if(!empty($feed_id)){
      $result['data']=$this->m_cron_job->lookup_sold_feed($feed_id);
      $this->load->view('ebay/async/soldItemWithKeyword',$result);
      echo $feed_id ."-Feed Updated".PHP_EOL;
    }else{
      echo 'feed_id not found';
    }
  }  
  public function runAllSoldFeed()
  {

      $result['data']=$this->m_cron_job->runAllSoldFeed();
      $this->load->view('ebay/async/soldItemWithKeyword',$result);
      echo "All Category Feed Updated".PHP_EOL;
    
  }
  public function runPurchasedSoldFeed()
  {
      $result['data']=$this->m_cron_job->runPurchasedSoldFeed();
      $this->load->view('ebay/async/soldItemWithKeyword',$result);
      echo "All Category Feed Updated".PHP_EOL;
  }   
  public function lookup_feed_chunk()
  {
    //if(!empty($feed_id)){
      $this->load->library('rssparser');
      $this->m_cron_job->lookup_feed_chunk();
      echo $cat_id ."-Feed Updated".PHP_EOL;
      $this->lookup_feed_chunk();
    // }else{
    //   echo 'feed_id not found';
    // }
  }
  public function createLookupStream_chunk()
  {
      $this->m_cron_job->createLookupStream_chunk();
  }
  public function createLocalStream_chunk()
  {
      $this->m_cron_job->createLocalStream_chunk();
  }
  public function createGetordersBatchFile()
  {
      $this->m_cron_job->createGetordersBatchFile();
  }
  public function createCategoryStream_chunk()
  {
      $this->m_cron_job->createCategoryStream_chunk();
  }
  public function updateRSSFeed_chunk()
  {
      $this->m_cron_job->updateRSSFeed_chunk();
  }
  public function runPurchasedItemChunk()
  {
    $this->load->library('rssparser');
    $this->m_cron_job->runPurchasedItemChunk();
    echo "Feed Updated".PHP_EOL;
  }
  public function runLookupStreamChunk($min_url_id,$max_url_id)
  {
    if(!empty($min_url_id) && !empty($max_url_id)){
      $this->load->library('rssparser');
      $this->m_cron_job->runLookupStreamChunk($min_url_id,$max_url_id);
      echo $min_url_id.'-'.$max_url_id ."-Feed Updated".PHP_EOL;
      $this->runLookupStreamChunk($min_url_id,$max_url_id);
     }else{
       echo 'feed_url_id not found';
     }
  }
  public function runAutoBuyStream()
  {
      $this->load->library('rssparser');
      $this->m_cron_job->runAutoBuyStream();
      echo "Feed Updated".PHP_EOL;
      $this->runAutoBuyStream();
  }
  public function runAutoBINStream()
  {
      $this->load->library('rssparser');
      $this->m_cron_job->runAutoBINStream();
      echo "Feed Updated".PHP_EOL;
      $this->runAutoBINStream();
  }
  public function runAutoBuyAuctionStream()
  {
      $this->load->library('rssparser');
      $this->m_cron_job->runAutoBuyAuctionStream();
      echo "Feed Updated".PHP_EOL;
      $this->runAutoBuyAuctionStream();
  }
  public function runCatAuctionStream()
  {
      $this->load->library('rssparser');
      $this->m_cron_job->runCatAuctionStream();
      echo "Feed Updated".PHP_EOL;
      $this->runCatAuctionStream();
  }
  public function runFeedChunktest($min_url_id,$max_url_id)
  {
    if(!empty($min_url_id) && !empty($max_url_id)){
      $this->load->library('rssparser');
      $this->m_cron_job->runFeedChunktest($min_url_id,$max_url_id);
      echo $min_url_id.'-'.$max_url_id ."-Feed Updated".PHP_EOL;
      $this->runFeedChunk($min_url_id,$max_url_id);
     }else{
       echo 'feed_url_id not found';
     }
  }
  //     public function runLocalFeedChunk($min_url_id,$max_url_id)
  // {
  //   if(!empty($min_url_id) && !empty($max_url_id)){
  //     $this->load->library('rssparser');
  //     $this->m_cron_job->runLocalFeedChunk($min_url_id,$max_url_id);
  //     echo $min_url_id.'-'.$max_url_id ."-Feed Updated".PHP_EOL;
  //     $this->runLocalFeedChunk($min_url_id,$max_url_id);
  //    }else{
  //      echo 'feed_url_id not found';
  //    }
  // }
  public function runCategoryStream($cat_id = '')
  {
    if(!empty($cat_id)){
      $this->load->library('rssparser');
      $this->m_cron_job->runCategoryStream($cat_id);
      echo $cat_id ."-Feed Updated".PHP_EOL;
      $this->runCategoryStream($cat_id);
    }else{
      echo 'category_id not found';
    }
  }
  public function runLocalStreamChunk($min_url_id,$max_url_id)
  {
    if(!empty($min_url_id) && !empty($max_url_id)){
      $this->load->library('rssparser');
      $this->m_cron_job->runLocalStreamChunk($min_url_id,$max_url_id);
      echo $min_url_id.'-'.$max_url_id ."-Feed Updated".PHP_EOL;
      $this->runLocalStreamChunk($min_url_id,$max_url_id);
     }else{
       echo 'feed_url_id not found';
     }
  }
  public function getSoldActiveSummary()
  {
    $result['data']=$this->m_cron_job->getSoldActiveSummary();
    $this->load->view('API\get_avg_sold_price',$result);

  }
  public function getSoldActiveSummaryAll()
  {
    $result['data']=$this->m_cron_job->getSoldActiveSummaryAll();
    $this->load->view('API\get_avg_sold_price',$result);

  }
  public function GetMostWatchedItems()
  {

    $result['data']=$this->m_cron_job->GetMostWatchedItems();
    $this->load->view('API\GetMostWatchedItems',$result);

  }
  public function GetEpid($user_id)
  {
    $result['user_id'] = $user_id;
    $this->load->view('ebay\oauth-tokens\01-get-app-token',$result);
    $result['res']=$this->m_cron_job->GetEpid($user_id);

    $this->load->view('ebay/browse/01-search-for-items',$result);

  }
  public function GetEbayCatalogue()
  {

    $result['data']=$this->m_cron_job->GetEbayCatalogue();
    $this->load->view('ebay/catalog/02-getProduct',$result);

  }
  public function updateUserLog()
  {

    $this->m_cron_job->updateUserLog();
    echo "USER LOG UPDATED SUCCESSFULLY".PHP_EOL;
    //$this->load->view('ebay/catalog/02-getProduct',$result);

  }
  public function getAuctionItemPrice()
  {
    $result['data']=$this->m_cron_job->getAuctionItemPrice();
    $this->load->view('API\getAuctionItemPrice',$result);

  } 
  public function uploadBbyfile()
  {
    $this->m_cron_job->uploadBbyfile();
  }
  public function GetCategoryFeatures()
  {
    $result['data'] = $this->m_cron_job->GetCategoryFeatures();
    $this->load->view('ebay/trading/GetCategoryFeatures',$result);
  }
  public function endItemAging()
  {
    $this->load->view('ebay/trading/endItemAging');
  }
  public function GetActiveItemEpid($user_id)
  {
    //var_dump($user_id);exit;
    $result['user_id'] = $user_id;
    $this->load->view('ebay\oauth-tokens\01-get-app-token',$result);
    $result['res']=$this->m_cron_job->GetActiveItemEpid($user_id);
    $this->load->view('ebay/browse/getEpid',$result);
    //$this->load->view('ebay/browse/getEpid');

  }
  public function assignEpid($user_id)
  {
    //var_dump($user_id);exit;
    $result['user_id'] = $user_id;
    //$this->load->view('ebay\oauth-tokens\01-get-app-token',$result);
    $result['seed_data']=$this->m_cron_job->assignEpid();
    $this->load->view('ebay/trading/AssignEpidtoActiveListing',$result);
    //$this->load->view('ebay/browse/getEpid');

  }
  public function createCampaign($user_id)
  {
    //var_dump($user_id);exit;
    $result['user_id'] = $user_id;
    $this->load->view('ebay\oauth-tokens\01-get-app-token',$result);
    //$this->load->view('ebay\oauth-tokens\02-get-user-token',$result);
   // $result['seed_data']=$this->m_cron_job->assignEpid();
    //$this->load->view('ebay/trading/AssignEpidtoActiveListing',$result);
    $this->load->view('ebay/Marketing/createCampaign',$result);
    //$this->load->view('ebay/browse/getEpid');

  }
  public function CreateAdByListingID($user_id)
  {
    //var_dump($user_id);exit;
    $result['user_id'] = $user_id;
    //$this->load->view('ebay\oauth-tokens\01-get-app-token',$result);
    $this->load->view('ebay\oauth-tokens\02-get-user-token',$result);
   // $result['seed_data']=$this->m_cron_job->assignEpid();
    //$this->load->view('ebay/trading/AssignEpidtoActiveListing',$result);
    $this->load->view('ebay/Marketing/CreateAdByListingID',$result);
    //$this->load->view('ebay/browse/getEpid');

  }
  public function getCampaigns($user_id)
  {
    //var_dump($user_id);exit;
    $result['user_id'] = $user_id;
    //$this->load->view('ebay\oauth-tokens\01-get-app-token',$result);
    //$this->load->view('ebay\oauth-tokens\02-get-user-token',$result);
   // $result['seed_data']=$this->m_cron_job->assignEpid();
    //$this->load->view('ebay/trading/AssignEpidtoActiveListing',$result);
    $this->load->view('ebay/Marketing/getCampaigns',$result);
    //$this->load->view('ebay/browse/getEpid');

  }
 
  public function completeSale()
  {
    $result['transaction_id'] = $_GET['transaction_id'];
    $result['item_id'] = $_GET['item_id'];
    $result['tracking_number'] = $_GET['tracking_number'];
    $result['acc_id'] = $_GET['acc_id'];
    //updated by tahir => 8/23/19
    $order_id = $_GET['order_id'];
    $shippingLabelRate = $_GET['shippingLabelRate'];
    $trackingNo = $_GET['tracking_number'];
    
    $update = $this->db->query("UPDATE LZ_SALESLOAD_DET D SET D.TRACKING_NUMBER = '$trackingNo', D.SHIPPINGLABELRATE = '$shippingLabelRate'  WHERE D.ORDER_ID = '$order_id' "); 

    //end 
    // var_dump($result);
    $this->load->view('API\GetOrders\CompleteSale',$result);
  }
  public function getAwaitingShipments($user_id)
  {
    $result['user_id'] = $user_id;
    $this->load->view('ebay/trading/getAwaitingShipments',$result);
  }
  public function getItemSeed($account_id,$user_id)
  {
    //$result['user_id'] = $user_id;
    $result['account_id'] = $account_id;
    $result['user_id'] = $user_id;
    $this->load->view('ebay/trading/getitem_seed',$result);
  }
  public function getAwaitingShipmentsDetails($user_id)
  {
    $result['user_id'] = $user_id;
    $this->load->view('API\GetOrders\getAwaitingShipmentsDetails',$result);

  }
  public function shopifyOrdersReviseCall(){
    $this->m_ordersShopify->reviseQuantityonShopify();
  }
  public function getSoldItems($user_id){
    $result['user_id'] = $user_id;
    //$this->load->view('ebay\oauth-tokens\01-get-app-token',$result);
    $result['data']=$this->m_cron_job->getSoldItems();
    $this->load->view('ebay/finding/getSoldItems',$result);
  }
  public function getActiveItems($user_id){
    $result['user_id'] = $user_id;
    //$this->load->view('ebay\oauth-tokens\01-get-app-token',$result);
    $result['data']=$this->m_cron_job->getSoldItems();
    $this->load->view('ebay/finding/getActiveItems',$result);
  }
  public function findItems($user_id)
  {
    $result['user_id'] = $user_id;
    $this->load->view('ebay\oauth-tokens\01-get-app-token',$result);
    //$result['res']=$this->m_cron_job->GetEpid($user_id);

    $this->load->view('ebay/browse/findItems',$result);

  }
  public function searchByImage($user_id)
  {
    $result['user_id'] = $user_id;
    $this->load->view('ebay\oauth-tokens\01-get-app-token',$result);
    //$result['res']=$this->m_cron_job->GetEpid($user_id);

    $this->load->view('ebay/browse/searchByImage',$result);

  }
  public function soldDataBatch_01($user_id)
  {
    $result['user_id'] = $user_id;
    $this->load->view('ebay/async/auto_run_sold',$result);

  }
  public function soldDataBatch_02($user_id)
  {
    $result['user_id'] = $user_id;
    $this->load->view('ebay/async/auto_run_sold_40004_100003',$result);

  }
  public function soldDataBatch_03($user_id)
  {
    $result['user_id'] = $user_id;
    $this->load->view('ebay/async/auto_run_sold_10004_184770',$result);

  }
  public function localSoldData($user_id)
  {
    $result['user_id'] = $user_id;
    $this->load->view('ebay/async/localSoldData',$result);

  }
  public function pullOrders(){
    $data['Timestamp'] = $_GET['Timestamp'];
    $data['merchant_name'] = $_GET['merchantName'];
    $data['NotificationEventName'] = $_GET['NotificationEventName'];
    $data['ItemID'] = $_GET['ItemID'];
    $this->load->view('API/GetOrders/GetOrders_notification',$data);
  }
  public function GetSellerOrders($sellerId)
  {
    $result['sellerId']=$sellerId;
    $this->load->view('API/GetOrders/GetSellerOrders',$result);
  }
  public function downloadOrders($sellerId)
  {
    //$sellerId = $this->input->post("accountId");
    //var_dump($sellerId);exit;
    $result['sellerId']=$sellerId;
    $this->load->view('API/GetOrders/GetSellerOrders',$result);
    
  }
  public function searchReturn($user_id)
  {
    //$result['user_id'] = $user_id;
    $result['merchant_id'] = $merchant_id;
    $result['returnCall'] = 1;
    //$this->load->view('ebay\oauth-tokens\01-get-app-token',$result);
    //$result['res']=$this->m_cron_job->GetEpid($user_id);

    $this->load->view('ebay/postOrder/01-searchReturn',$result);

  }
  public function searchReturnWeb()
  {
    //$user_id = $this->input->post("user_id");
    $merchant_id = $this->input->post("merchant_id");

    //$result['user_id'] = $user_id;
    $result['merchant_id'] = $merchant_id;
    $result['returnCall'] = 1;
    //$this->load->view('ebay\oauth-tokens\01-get-app-token',$result);
    //$result['res']=$this->m_cron_job->GetEpid($user_id);

    $this->load->view('ebay/postOrder/01-searchReturn',$result);

  }

  public function decideReturn($user_id)
  {
    $result['user_id'] = $user_id;
    //$this->load->view('ebay\oauth-tokens\01-get-app-token',$result);
    //$result['res']=$this->m_cron_job->GetEpid($user_id);

    $this->load->view('ebay/postOrder/02-DecideReturn',$result);

  }
}