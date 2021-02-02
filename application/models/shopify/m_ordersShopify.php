<?php  
  class M_ordersShopify extends CI_Model{

    public function __construct(){
	    parent::__construct();
	    $this->load->database();
    }
    public function getAllShopifyOrders()
    {

    	//Return All Order from Shopify
    	//https://c084db0733b8db2aef9f2a3a37b7314e:d19b1f6eece15313ce289b80e206286f@k2bay.myshopify.com/admin/order.json
    	// ------------------------------------------------------------------------
    	// Return Single Order from Shopify
    	//https://c084db0733b8db2aef9f2a3a37b7314e:d19b1f6eece15313ce289b80e206286f@k2bay.myshopify.com/admin/order/618236215363.json
    	

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://c084db0733b8db2aef9f2a3a37b7314e:d19b1f6eece15313ce289b80e206286f@k2bay.myshopify.com/admin/orders.json",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
		    "Postman-Token: 2b9cece6-b7bf-4186-a0b2-6e640e03da09",
		    "cache-control: no-cache"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
			echo $response;
		    $allOrders = json_decode($response, true);
		    // echo "<pre>";
		    // print_r ($allOrders);
		    // echo "</pre>"; //exit;

		    foreach($allOrders as $Order):
		    	foreach ($Order as $allOrder) {

					$order_id = @$allOrder["id"]; // Access Array data
					//var_dump($order_id);exit;
					$order_email = @$allOrder["email"];
					$order_closed_at = @$allOrder["closed_at"];
					$order_closed_at = str_replace("T", " ", $order_closed_at);
					$order_closed_at = str_replace("-05:00", "", $order_closed_at);
					$order_closed_at = "TO_DATE('".$order_closed_at."', 'YYYY-MM-DD HH24:MI:SS')";
					if(empty($order_closed_at)){
						$order_closed_at = "''";
					}
					//echo '<strong>:</strong><br>', var_dump( $order_closed_at ), '<hr>';exit;
					$order_created_at = @$allOrder["created_at"];
					$order_created_at = str_replace("T", " ", $order_created_at);
					$order_created_at = str_replace("-05:00", "", $order_created_at);
					$order_created_at = "TO_DATE('".$order_created_at."', 'YYYY-MM-DD HH24:MI:SS')";
					if(empty($order_created_at)){
						$order_created_at = "''";
					}

					$order_updated_at = @$allOrder["updated_at"];
					$order_updated_at = str_replace("T", " ", $order_updated_at);
					$order_updated_at = str_replace("-05:00", "", $order_updated_at);
					$order_updated_at = "TO_DATE('".$order_updated_at."', 'YYYY-MM-DD HH24:MI:SS')";
					if(empty($order_updated_at)){
						$order_updated_at = "''";
					}

					$order_number = @$allOrder["number"];
					$order_note = @$allOrder["note"];
					$order_note = trim(str_replace("  ", ' ', $order_note));
    				$order_note = trim(str_replace(array("'"), "''", $order_note));

					$order_token = @$allOrder["token"];
					$order_gateway = @$allOrder["gateway"];
					$order_test = @$allOrder["test"];
					$order_total_price = @$allOrder["total_price"];
					$order_subtotal_price = @$allOrder["subtotal_price"];
					$order_total_weight = @$allOrder["total_weight"];
					$order_total_tax = @$allOrder["total_tax"];
					$order_taxes_included = @$allOrder["taxes_included"];
					$order_currency = @$allOrder["currency"];
					$order_financial_status = @$allOrder["financial_status"];

					$order_confirmed = @$allOrder["confirmed"];
					$order_total_discounts = @$allOrder["total_discounts"];
					$order_total_line_items_price = @$allOrder["total_line_items_price"];
					$order_cart_token = @$allOrder["cart_token"];
					$order_buyer_accepts_marketing = @$allOrder["buyer_accepts_marketing"];

					$order_name = @$allOrder["name"];
					$order_landing_site = @$allOrder["landing_site"];
					$order_cancelled_at = @$allOrder["cancelled_at"];
					$order_cancelled_at = str_replace("T", " ", $order_cancelled_at);
					$order_cancelled_at = str_replace("-05:00", "", $order_cancelled_at);
					$order_cancelled_at = "TO_DATE('".$order_cancelled_at."', 'YYYY-MM-DD HH24:MI:SS')";
					if(empty($order_cancelled_at)){
						$order_cancelled_at = "''";
					}

					$order_cancel_reason = @$allOrder["cancel_reason"];
					$order_cancel_reason = trim(str_replace("  ", ' ', $order_cancel_reason));
    				$order_cancel_reason = trim(str_replace(array("'"), "''", $order_cancel_reason));

					$order_total_price_usd = @$allOrder["total_price_usd"];
					$order_checkout_token = @$allOrder["checkout_token"];
					$order_reference = @$allOrder["reference"];
					$order_user_id = @$allOrder["user_id"];
					$order_processed_at = @$allOrder["processed_at"];
					$order_processed_at = str_replace("T", " ", $order_processed_at);
					$order_processed_at = str_replace("-05:00", "", $order_processed_at);
					$order_processed_at = "TO_DATE('".$order_processed_at."', 'YYYY-MM-DD HH24:MI:SS')";
					if(empty($order_processed_at)){
						$order_processed_at = "''";
					}

					$order_device_id = @$allOrder["device_id"];

					$order_phone = @$allOrder["phone"];
					$order_order_number = @$allOrder["order_number"];
					$order_payment_gateway_names = @$allOrder["payment_gateway_names"][0];
					//var_dump($order_payment_gateway_names);exit;

					$order_processing_method = @$allOrder["processing_method"];
					$order_checkout_id = @$allOrder["checkout_id"];
					$order_source_name = @$allOrder["source_name"];			
					$order_fulfillment_status = @$allOrder["fulfillment_status"];

					$order_tax_price = @$allOrder["tax_lines"][0]["price"]; //["price"]
					//var_dump($order_tax_price);exit;
					$order_tax_rate = @$allOrder["tax_lines"][0]["rate"];
					
					$order_tax_title = @$allOrder["tax_lines"][0]["title"];
					$order_tax_title = trim(str_replace("  ", ' ', $order_tax_title));
    				$order_tax_title = trim(str_replace(array("'"), "''", $order_tax_title));
					// $order_tax_price2 = @$allOrder["tax_lines"]["price"];
					// $order_tax_rate2 = @$allOrder["tax_lines"]["rate"];
					// $order_tax_title2 = @$allOrder["tax_lines"]["title"];

					$order_contact_email = @$allOrder["contact_email"];
					$order_order_status_url = @$allOrder["order_status_url"];

					$line_items_id = @$allOrder["line_items"][0]["id"];
					
					$line_items_variant_id = @$allOrder["line_items"][0]["variant_id"];
					$line_items_title = @$allOrder["line_items"][0]["title"];
					$line_items_title = trim(str_replace("  ", ' ', $line_items_title));
    				$line_items_title = trim(str_replace(array("'"), "''", $line_items_title));

					$line_items_quantity = @$allOrder["line_items"][0]["quantity"];
					$line_items_price = @$allOrder["line_items"][0]["price"];
					$line_items_sku = @$allOrder["line_items"][0]["sku"]; //
					//var_dump($line_items_price, $line_items_sku); exit;
					$line_items_fulfillment_service = @$allOrder["line_items"][0]["fulfillment_service"];
					$line_items_product_id = @$allOrder["line_items"][0]["product_id"];
					
					$line_items_requires_shipping = @$allOrder["line_items"][0]["requires_shipping"];
					$line_items_taxable = @$allOrder["line_items"][0]["taxable"];
					$line_items_name = @$allOrder["line_items"][0]["name"];
					$line_items_name = trim(str_replace("  ", ' ', $line_items_name));
    				$line_items_name = trim(str_replace(array("'"), "''", $line_items_name));					
					//var_dump($line_items_name);exit;	
					$line_items_variant_in_mang = @$allOrder["line_items"][0]["variant_inventory_management"];
					$line_items_product_exists = @$allOrder["line_items"][0]["product_exists"];
					$line_items_fulfif_quantity = @$allOrder["line_items"][0]["fulfillable_quantity"];
					//var_dump($line_items_fulfillable_quantity);
					$shipping_lines_id = @$allOrder["line_items"][0]["id"]; //["origin_location"]["id"]
					//var_dump($shipping_lines_id); //exit;
					$shipping_lines_title = @$allOrder["line_items"][0]["title"]; //[0]["title"]
					$shipping_lines_title = trim(str_replace("  ", ' ', $shipping_lines_title));
    				$shipping_lines_title = trim(str_replace(array("'"), "''", $shipping_lines_title));	

					$shipping_lines_price = @$allOrder["line_items"][0]["price"];
					$shipping_lines_code = @$allOrder["line_items"][0]["code"];
					$shipping_lines_source = @$allOrder["line_items"][0]["source"];
					$shipping_lines_phone = @$allOrder["line_items"][0]["phone"];
					$shipping_lines_disc_price = @$allOrder["line_items"][0]["discounted_price"];
					//var_dump($shipping_lines_title);//exit;
					//var_dump($shipping_lines_price);//exit;
					$tax_state_lines_title = @$allOrder["line_items"][0]["tax_lines"][0]["title"];//["title"]
					$tax_state_lines_title = trim(str_replace("  ", ' ', $tax_state_lines_title));
    				$tax_state_lines_title = trim(str_replace(array("'"), "''", $tax_state_lines_title));						
					//var_dump($tax_state_lines_title); //exit;
					$tax_state_lines_price = @$allOrder["line_items"][0]["tax_lines"][0]["price"];
					$tax_state_lines_rate = @$allOrder["line_items"][0]["tax_lines"][0]["rate"];

					$tax_lines_title = @$allOrder["line_items"][0]["tax_lines"][0]["title"];//[1]["title"]
					$tax_lines_title = trim(str_replace("  ", ' ', $tax_lines_title));
    				$tax_lines_title = trim(str_replace(array("'"), "''", $tax_lines_title));					
					//var_dump($tax_lines_title); exit;
					$tax_lines_price = @$allOrder["line_items"][0]["tax_lines"][0]["price"];
					$tax_lines_rate = @$allOrder["line_items"][0]["tax_lines"][0]["rate"];
					//var_dump($tax_lines_rate2);exit;
					$billing_address_first_name = @$allOrder["billing_address"]["first_name"]; //
					$billing_address_first_name = trim(str_replace("  ", ' ', $billing_address_first_name));
    				$billing_address_first_name = trim(str_replace(array("'"), "''", $billing_address_first_name));					
					//var_dump($billing_address_first_name);exit;
					$billing_address_address1 = @$allOrder["billing_address"]["address1"];
					$billing_address_address1 = trim(str_replace("  ", ' ', $billing_address_address1));
    				$billing_address_address1 = trim(str_replace(array("'"), "''", $billing_address_address1));

					$billing_address_phone = @$allOrder["billing_address"]["phone"];
					$billing_address_city = @$allOrder["billing_address"]["city"];
					$billing_address_city = trim(str_replace("  ", ' ', $billing_address_city));
    				$billing_address_city = trim(str_replace(array("'"), "''", $billing_address_city));

					$billing_address_zip = @$allOrder["billing_address"]["zip"]; //zip
					$billing_address_province = @$allOrder["billing_address"]["province"];
					$billing_address_province = trim(str_replace("  ", ' ', $billing_address_province));
    				$billing_address_province = trim(str_replace(array("'"), "''", $billing_address_province));

					$billing_address_last_name = @$allOrder["billing_address"]["last_name"];
					$billing_address_last_name = trim(str_replace("  ", ' ', $billing_address_last_name));
    				$billing_address_last_name = trim(str_replace(array("'"), "''", $billing_address_last_name));

					$billing_address_address2 = @$allOrder["billing_address"]["address2"];
					$billing_address_address2 = trim(str_replace("  ", ' ', $billing_address_address2));
    				$billing_address_address2 = trim(str_replace(array("'"), "''", $billing_address_address2));

					$billing_address_company = @$allOrder["billing_address"]["company"];
					$billing_address_company = trim(str_replace("  ", ' ', $billing_address_company));
    				$billing_address_company = trim(str_replace(array("'"), "''", $billing_address_company));

					$billing_address_name = @$allOrder["billing_address"]["name"];
					$billing_address_name = trim(str_replace("  ", ' ', $billing_address_name));
    				$billing_address_name = trim(str_replace(array("'"), "''", $billing_address_name));

					$billing_address_country_code = @$allOrder["billing_address"]["country_code"];
					$billing_address_province_code = @$allOrder["billing_address"]["province_code"];
					//var_dump($billing_address_province_code);exit;
					$shipping_address_first_name = @$allOrder["shipping_address"]["first_name"];
					$shipping_address_first_name = trim(str_replace("  ", ' ', $shipping_address_first_name));
    				$shipping_address_first_name = trim(str_replace(array("'"), "''", $shipping_address_first_name));					
					//var_dump($shipping_address_first_name);exit;
					$shipping_address_address1 = @$allOrder["shipping_address"]["address1"];
					$shipping_address_address1 = trim(str_replace("  ", ' ', $shipping_address_address1));
    				$shipping_address_address1 = trim(str_replace(array("'"), "''", $shipping_address_address1));

					$shipping_address_phone = @$allOrder["shipping_address"]["phone"];
					$shipping_address_city = @$allOrder["shipping_address"]["city"];
					$shipping_address_city = trim(str_replace("  ", ' ', $shipping_address_city));
    				$shipping_address_city = trim(str_replace(array("'"), "''", $shipping_address_city));

					$shipping_address_zip = @$allOrder["shipping_address"]["zip"];
					$shipping_address_province = @$allOrder["shipping_address"]["province"];
					$shipping_address_province = trim(str_replace("  ", ' ', $shipping_address_province));
    				$shipping_address_province = trim(str_replace(array("'"), "''", $shipping_address_province));

					$shipping_address_last_name = @$allOrder["shipping_address"]["last_name"];
					$shipping_address_last_name = trim(str_replace("  ", ' ', $shipping_address_last_name));
    				$shipping_address_last_name = trim(str_replace(array("'"), "''", $shipping_address_last_name));

					$shipping_address_address2 = @$allOrder["shipping_address"]["address2"];
					$shipping_address_address2 = trim(str_replace("  ", ' ', $shipping_address_address2));
    				$shipping_address_address2 = trim(str_replace(array("'"), "''", $shipping_address_address2));

					$shipping_address_company = @$allOrder["shipping_address"]["company"];
					$shipping_address_company = trim(str_replace("  ", ' ', $shipping_address_company));
    				$shipping_address_company = trim(str_replace(array("'"), "''", $shipping_address_company));

					$shipping_address_name = @$allOrder["shipping_address"]["name"];
					$shipping_address_name = trim(str_replace("  ", ' ', $shipping_address_name));
    				$shipping_address_name = trim(str_replace(array("'"), "''", $shipping_address_name));

					$shipping_address_country_code = @$allOrder["shipping_address"]["country_code"];
					$shipping_address_province_code = @$allOrder["shipping_address"]["province_code"];
					//var_dump($shipping_address_province_code);exit;
					$customer_id = @$allOrder["customer"]["default_address"]["id"];
					$default_address_id = @$allOrder["customer"]["default_address"]["customer_id"]; //["default_address"]["customer_id"]
					//var_dump($default_address_id);exit;
					
			        $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('SHOPIFY_ORDERS','SHOPIFY_ID') SHOPIFY_ID FROM DUAL");
			        $rs = $qry->result_array();
			        $shopify_id = $rs[0]['SHOPIFY_ID'];
			        //var_dump($shopify_id);exit;
				    $check_order = $this->db->query("SELECT ORDER_ID FROM SHOPIFY_ORDERS WHERE ORDER_ID = $order_id AND ORDER_ORDER_NUMBER = $order_order_number");
				    $rs = $check_order->result_array();
				    $check_order_id = @$rs[0]['ORDER_ID'];	        
			        if(empty($check_order_id)){
						$ordersInsertion = $this->db->query("INSERT INTO SHOPIFY_ORDERS (SHOPIFY_ID, ORDER_ID, ORDER_EMAIL, ORDER_CLOSED_AT, ORDER_CREATED_AT, ORDER_UPDATED_AT, ORDER_NUMBER, ORDER_NOTE, ORDER_TOKEN, ORDER_GATEWAY, ORDER_TEST, ORDER_TOTAL_PRICE, ORDER_SUBTOTAL_PRICE, ORDER_TOTAL_WEIGHT, ORDER_TOTAL_TAX, ORDER_TAXES_INCLUDED, ORDER_CURRENCY, ORDER_FINANCIAL_STATUS, ORDER_CONFIRMED, ORDER_TOTAL_DISCOUNTS, ORDER_TOTAL_LINE_ITEMS_PRICE, ORDER_CART_TOKEN, ORDER_BUYER_ACCEPTS_MARKETING, ORDER_NAME, ORDER_LANDING_SITE, ORDER_CANCELLED_AT, ORDER_CANCEL_REASON, ORDER_TOTAL_PRICE_USD, ORDER_CHECKOUT_TOKEN, ORDER_REFERENCE, ORDER_USER_ID, ORDER_PROCESSED_AT, ORDER_DEVICE_ID, ORDER_PHONE, ORDER_ORDER_NUMBER, ORDER_PAYMENT_GATEWAY_NAMES, ORDER_PROCESSING_METHOD, ORDER_CHECKOUT_ID, ORDER_SOURCE_NAME, ORDER_FULFILLMENT_STATUS, ORDER_TAX_PRICE, ORDER_TAX_RATE, ORDER_TAX_TITLE, ORDER_CONTACT_EMAIL, ORDER_ORDER_STATUS_URL, LINE_ITEMS_ID, LINE_ITEMS_VARIANT_ID, LINE_ITEMS_TITLE, LINE_ITEMS_QUANTITY, LINE_ITEMS_PRICE, LINE_ITEMS_SKU, LINE_ITEMS_FULFILLMENT_SERVICE, LINE_ITEMS_PRODUCT_ID, LINE_ITEMS_REQUIRES_SHIPPING, LINE_ITEMS_TAXABLE, LINE_ITEMS_NAME, LINE_ITEMS_VARIANT_IN_MANG, LINE_ITEMS_PRODUCT_EXISTS, LINE_ITEMS_FULFIF_QUANTITY, SHIPPING_LINES_ID, SHIPPING_LINES_TITLE, SHIPPING_LINES_PRICE, SHIPPING_LINES_CODE, SHIPPING_LINES_SOURCE, SHIPPING_LINES_PHONE, SHIPPING_LINES_DISC_PRICE, TAX_STATE_LINES_TITLE, TAX_STATE_LINES_PRICE, TAX_STATE_LINES_RATE, TAX_LINES_TITLE, TAX_LINES_PRICE, TAX_LINES_RATE, BILLING_ADDRESS_FIRST_NAME, BILLING_ADDRESS_ADDRESS1, BILLING_ADDRESS_PHONE, BILLING_ADDRESS_CITY, BILLING_ADDRESS_ZIP, BILLING_ADDRESS_PROVINCE, BILLING_ADDRESS_LAST_NAME, BILLING_ADDRESS_ADDRESS2, BILLING_ADDRESS_COMPANY, BILLING_ADDRESS_NAME, BILLING_ADDRESS_COUNTRY_CODE, BILLING_ADDRESS_PROVINCE_CODE, SHIPPING_ADDRESS_FIRST_NAME, SHIPPING_ADDRESS_ADDRESS1, SHIPPING_ADDRESS_PHONE, SHIPPING_ADDRESS_CITY, SHIPPING_ADDRESS_ZIP, SHIPPING_ADDRESS_PROVINCE, SHIPPING_ADDRESS_LAST_NAME, SHIPPING_ADDRESS_ADDRESS2, SHIPPING_ADDRESS_COMPANY, SHIPPING_ADDRESS_NAME, SHIPPING_ADDRESS_COUNTRY_CODE, SHIPPING_ADDRESS_PROVINCE_CODE, CUSTOMER_ID, DEFAULT_ADDRESS_ID) VALUES($shopify_id, '$order_id', '$order_email', $order_closed_at, $order_created_at, $order_updated_at, '$order_number', '$order_note', '$order_token', '$order_gateway', '$order_test', '$order_total_price', '$order_subtotal_price', '$order_total_weight', '$order_total_tax', '$order_taxes_included', '$order_currency', '$order_financial_status', '$order_confirmed', '$order_total_discounts', '$order_total_line_items_price', '$order_cart_token', '$order_buyer_accepts_marketing', '$order_name', '$order_landing_site', $order_cancelled_at, '$order_cancel_reason', '$order_total_price_usd', '$order_checkout_token', '$order_reference', '$order_user_id', $order_processed_at, '$order_device_id', '$order_phone', '$order_order_number', '$order_payment_gateway_names', '$order_processing_method', '$order_checkout_id', '$order_source_name', '$order_fulfillment_status', '$order_tax_price', '$order_tax_rate', '$order_tax_title', '$order_contact_email', '$order_order_status_url', '$line_items_id', '$line_items_variant_id', '$line_items_title', '$line_items_quantity', '$line_items_price', '$line_items_sku', '$line_items_fulfillment_service', '$line_items_product_id', '$line_items_requires_shipping', '$line_items_taxable', '$line_items_name', '$line_items_variant_in_mang', '$line_items_product_exists', '$line_items_fulfif_quantity', '$shipping_lines_id', '$shipping_lines_title', '$shipping_lines_price', '$shipping_lines_code', '$shipping_lines_source', '$shipping_lines_phone', '$shipping_lines_disc_price', '$tax_state_lines_title', '$tax_state_lines_price', '$tax_state_lines_rate', '$tax_lines_title', '$tax_lines_price', '$tax_lines_rate', '$billing_address_first_name', '$billing_address_address1', '$billing_address_phone', '$billing_address_city', '$billing_address_zip', '$billing_address_province', '$billing_address_last_name', '$billing_address_address2', '$billing_address_company', '$billing_address_name', '$billing_address_country_code', '$billing_address_province_code', '$shipping_address_first_name', '$shipping_address_address1', '$shipping_address_phone', '$shipping_address_city', '$shipping_address_zip', '$shipping_address_province', '$shipping_address_last_name', '$shipping_address_address2', '$shipping_address_company', '$shipping_address_name', '$shipping_address_country_code', '$shipping_address_province_code', '$customer_id', '$default_address_id')");
			      		if($ordersInsertion){
			      			$status = 1;
            				$this->session->set_userdata("status", $status);
			      		}else {
				      		$status = 0;
            				$this->session->set_userdata("status", $status);
			      		}
			        }// order_id if closing		    		
		    	}//endforeach allorder
      				
	    	endforeach;
		}
    }
    public function ordersDetails(){
    	$query = $this->db->query("SELECT S.SHOPIFY_ID, S.ORDER_ID, S.BILLING_ADDRESS_NAME, S.ORDER_FINANCIAL_STATUS, S.ORDER_TOTAL_PRICE, S.ORDER_ORDER_NUMBER, S.ORDER_CREATED_AT, S.ORDER_FULFILLMENT_STATUS, S.LINE_ITEMS_SKU, S.LINE_ITEMS_QUANTITY FROM SHOPIFY_ORDERS S");
    	return $query->result_array();

    }
    public function checItemoneBay(){
    	$sku_as_barcode = $this->input->post("line_items_sku");
    	$line_items_quantity = $this->input->post("line_items_quantity");

    	$query = $this->db->query("SELECT B.EBAY_ITEM_ID, B.LZ_MANIFEST_ID, B.ITEM_ID, B.CONDITION_ID FROM LZ_BARCODE_MT B WHERE B.BARCODE_NO = $sku_as_barcode ");
    	$q = $query->result_array();
    	$ebay_id = @$q[0]['EBAY_ITEM_ID'];
    	$lz_manifest_id = @$q[0]['LZ_MANIFEST_ID'];
    	$item_id = @$q[0]['ITEM_ID'];
    	$condition_id = @$q[0]['CONDITION_ID'];

    	$result['ebay_id'] = $ebay_id;
    	//var_dump($ebay_id);

    	/*================================================================
    	=            GetItem from eBay Check if item is exist            =
    	================================================================*/
    	//$path = 'D:\wamp\www\laptopzone\application\views\ebay\trading\shopify\getitemForcheckeBayID.php';
	    //$path = './../../../../application/views/ebay/trading/shopify/getitemForcheckeBayID.php';
	    $this->load->view('ebay/trading/shopify/getitemForcheckeBayID', $result);
	    $ListingStatus = @$this->session->userdata("ListingStatus");
	    $Quantity = @$this->session->userdata("Quantity");
	    //var_dump($Quantity); exit;
	    $Quantity = $Quantity - $line_items_quantity;
	    $result['Quantity'] = $Quantity;

	    $get_seller = $this->db->query("SELECT E.LZ_SELLER_ACCT_ID,A.SELL_ACCT_DESC FROM EBAY_LIST_MT E , LZ_SELLER_ACCTS A WHERE A.LZ_SELLER_ACCT_ID = E.LZ_SELLER_ACCT_ID AND E.EBAY_ITEM_ID = '$ebay_id' AND ROWNUM=1")->result_array();
	    $account_name = @$get_seller[0]['SELL_ACCT_DESC'];
	    $account_id = @$get_seller[0]['LZ_SELLER_ACCT_ID'];
	    if(!empty(@$account_name)){
	      $result['account_name'] = $account_name;
	    }

	    if($ListingStatus === "Completed"){

	    	//echo "End Listing from ebay completed"; // end listing code goes here
			return 0;	    	


	    }else if($line_items_quantity === $Quantity){

	    	//echo "End Listing from ebay quantity"; // end listing code goes here


		    
		 //    $data = $this->load->view('ebay/trading/endItem',$result);
		 //    if($data){

		 //      	//$result['ebay_id'] = $ebay_id;
			// 	// check if item sold or not
			// 	$check_sold = $this->db->query("SELECT * FROM LZ_SALESLOAD_DET D WHERE D.ITEM_ID = '$ebay_id'"); 
			// 	if($check_sold->num_rows() > 0){
			// 		$barcode_qry = $this->db->query("UPDATE LZ_BARCODE_MT B SET B.LIST_ID = '',B.EBAY_ITEM_ID='' WHERE B.EBAY_ITEM_ID = '$ebay_id'AND B.SALE_RECORD_NO IS NULL AND B.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND B.LZ_PART_ISSUE_MT_ID IS NULL AND B.LZ_POS_MT_ID IS NULL AND B.PULLING_ID IS NULL");
			// 	}else{
			// 		$barcode_qry = $this->db->query("UPDATE LZ_BARCODE_MT B SET B.LIST_ID = '',B.EBAY_ITEM_ID='' WHERE B.EBAY_ITEM_ID = '$ebay_id'AND B.SALE_RECORD_NO IS NULL AND B.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND B.LZ_PART_ISSUE_MT_ID IS NULL AND B.LZ_POS_MT_ID IS NULL AND B.PULLING_ID IS NULL"); 

			// 	$delete_qry = $this->db->query("DELETE FROM EBAY_LIST_MT E WHERE E.EBAY_ITEM_ID = '$ebay_id'");

			// 	$delete_url = $this->db->query("DELETE FROM LZ_LISTED_ITEM_URL U WHERE U.EBAY_ID =  '$ebay_id'"); 

				
			// 	}
			
			return 1;

		 //    }	    	


	    }else if($line_items_quantity < $Quantity){

	    	//echo "End Listing from ebay less quantity"; // end listing code goes here
	    	//return 2;

			
			$this->load->view('ebay/trading/reviseQuantity',$result);
			//exit;
			if(!empty($this->session->userdata('ebay_item_id'))){

			$status = "REVISED";
			$check_btn = "revise";
			/*========================================================
			=            Insert eBay Id into ebay_list_mt            =
			========================================================*/

			$list_rslt = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('EBAY_LIST_MT','LIST_ID') LIST_ID FROM DUAL");
			$rs = $list_rslt->result_array();
			$LIST_ID = $rs[0]['LIST_ID'];
			//$this->session->set_userdata('list_id',$LIST_ID);
			//$ebay_id = $this->session->userdata('ebay_item_id');


			$query = $this->db->query("SELECT LS.ITEM_TITLE,LS.EBAY_PRICE, LS.SEED_ID, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NOT NULL AND BC.ITEM_ADJ_DET_ID_FOR_IN IS NULL AND BC.SALE_RECORD_NO IS NULL AND BC.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND BC.LZ_PART_ISSUE_MT_ID IS NULL AND BC.LZ_POS_MT_ID IS NULL AND BC.PULLING_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.ITEM_ID = $item_id and LS.LZ_MANIFEST_ID = $lz_manifest_id and LS.DEFAULT_COND=$condition_id"); 

				$rslt_dta = $query->result_array();

				//$list_date = date("d/M/Y");// return format Aug/13/2016
				date_default_timezone_set("America/Chicago");
				$list_date = date("Y-m-d H:i:s");
				$list_date= "TO_DATE('".$list_date."', 'YYYY-MM-DD HH24:MI:SS')";
				$lister_id = $this->session->userdata('user_id');
				$ebay_item_desc = $rslt_dta[0]['ITEM_TITLE'];
				$seed_id = $rslt_dta[0]['SEED_ID'];
			    $ebay_item_desc = trim(str_replace("  ", '', $ebay_item_desc));
			    $ebay_item_desc = trim(str_replace(array("'"), "''", $ebay_item_desc));

			    $list_qty = $Quantity;

				$ebay_item_id = $ebay_id;
				$list_price = $rslt_dta[0]['EBAY_PRICE'];
				$remarks = NULL;
				$single_entry_id = NULL;
				$salvage_qty = 0.00;
				$entry_type ="L";
				$LZ_SELLER_ACCT_ID = $account_id;
				$auth_by_id = "";
				$list_qty = "'".$list_qty."'";

				$insert_query = $this->db->query("INSERT INTO ebay_list_mt (LIST_ID, LZ_MANIFEST_ID, LISTING_NO, ITEM_ID, LIST_DATE, LISTER_ID, EBAY_ITEM_DESC, LIST_QTY, EBAY_ITEM_ID, LIST_PRICE, REMARKS, SINGLE_ENTRY_ID, SALVAGE_QTY, ENTRY_TYPE, LZ_SELLER_ACCT_ID, SEED_ID, STATUS, ITEM_CONDITION, AUTH_BY_ID)VALUES (".$LIST_ID.",".$lz_manifest_id.", ".$LIST_ID.", ".$item_id.", ".$list_date.", ".$lister_id.", '".$ebay_item_desc."', ".$list_qty.",".$ebay_item_id.",".$list_price.",NULL,NULL, NULL, '".$entry_type."',".$LZ_SELLER_ACCT_ID.",".$seed_id.",'".trim($status)."',".$condition_id.", '".$auth_by_id."')"); 
				if($insert_query){

			/*=====  End of Insert eBay Id into ebay_list_mt  ======*/

			    $this->session->unset_userdata('ebay_error');
			    $this->session->unset_userdata('ebay_item_id');
			    return 2;
			    //$this->session->unset_userdata('ebay_item_url');
			    //break;
				}else{

					die('Unable to Revise an item');
					return 3;
				}	    	
			} // session ebay id if closing	

	    } // else if $line_items_quantity < $Quantity
	    
    	
    	/*=====  End of GetItem from eBay Check if item is exist  ======*/
    	

    }
    public function reviseQuantityonShopify()
    {

    	$qty_qry = $this->db->query("SELECT D.ITEM_ID, SUM(D.QUANTITY) QTY FROM LZ_AWAITING_SHIPMENT A, LZ_SALESLOAD_DET D WHERE TO_CHAR(D.SALES_RECORD_NUMBER) = TO_CHAR(A.SALERECORDID) GROUP BY D.ITEM_ID ")->result_array();
    	 
    	    function str_replace_first($from, $to, $content)
		    {
		        $from = '/'.preg_quote($from, '/').'/';

		        return preg_replace($from, $to, $content, 1);
		    }

    	foreach($qty_qry as $qty){


    		$sold_qty = $qty["QTY"];
    		$ebay_id = $qty["ITEM_ID"];

	    	$qry = $this->db->query("SELECT B.SHOPIFY_LIST_ID FROM LZ_BARCODE_MT B WHERE B.EBAY_ITEM_ID = '$ebay_id' AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND ROWNUM = 1")->result_array();
	    	
	    	if(count($qry) > 0){

		    	$list_id = @$qry[0]["SHOPIFY_LIST_ID"];

		    	$qry2 = $this->db->query("SELECT S.SHOPIFY_ID FROM SHOPIFY_LIST_MT S WHERE S.LIST_ID = '$list_id' ")->result_array();
		    	$shopify_id = @$qry2[0]["SHOPIFY_ID"];


				// Get Old Quantity from Shopify

				$curl = curl_init();

				curl_setopt_array($curl, array(
				  CURLOPT_URL => "https://c084db0733b8db2aef9f2a3a37b7314e:d19b1f6eece15313ce289b80e206286f@k2bay.myshopify.com/admin/products/$shopify_id.json",
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 30,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "GET",
				  CURLOPT_HTTPHEADER => array(
				    "Postman-Token: 1568c600-0d8d-4356-b25d-e48e1725fb78",
				    "cache-control: no-cache"
				  ),
				));

				$getOldQuantity = curl_exec($curl);
				$getOldQuantityErr = curl_error($curl);

				curl_close($curl);

				if ($getOldQuantityErr) {
				  echo "cURL Get Old Quantity Error #:" . $getOldQuantityErr;
				} else {
			  //echo $response;

					$getOldQuantity = json_decode($getOldQuantity, true);
					foreach($getOldQuantity as $qty_record){
						$old_inventory_quantity = @$qty_record["variants"][0]["old_inventory_quantity"];

						$revised_qty = $old_inventory_quantity - $sold_qty;
						if($revised_qty < 0){
							$revised_qty = 0; 
						}

						$curl = curl_init();

						curl_setopt_array($curl, array(
						  CURLOPT_URL => "https://c084db0733b8db2aef9f2a3a37b7314e:d19b1f6eece15313ce289b80e206286f@k2bay.myshopify.com/admin/products/$shopify_id.json",
						  CURLOPT_RETURNTRANSFER => true,
						  CURLOPT_ENCODING => "",
						  CURLOPT_MAXREDIRS => 10,
						  CURLOPT_TIMEOUT => 30,
						  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						  CURLOPT_CUSTOMREQUEST => "PUT",
						  CURLOPT_POSTFIELDS => "{\r\n  \"product\": {\r\n    \"id\": $shopify_id,\r\n    \"variants\": [\r\n      {\r\n        \"inventory_quantity\": $revised_qty\r\n\r\n      }]\r\n  }\r\n}",
						  CURLOPT_HTTPHEADER => array(
						    "Content-Type: application/json",
						    "Postman-Token: c48940f7-5730-42bb-8111-d45d15dc7f32",
						    "cache-control: no-cache"
						  ),
						));

						$revised_item_response = curl_exec($curl);
						$revised_item_response_err = curl_error($curl);

						curl_close($curl);

						if ($revised_item_response_err) {
						  echo "cURL Error #:" . $revised_item_response_err;
						} else {
						  //echo $response;
			 				$revise_product = json_decode($revised_item_response, true);

			 				$update_qry = $this->db->query("UPDATE LZ_SALESLOAD_DET SET SHOPIFY_ADJUSTMENT_ID = 1 WHERE ITEM_ID = '$ebay_id' ");

						   
						}// responce else closing							

					}// get old quantity foreach closing
					

				}// response else closing of get old quantity call
	    	} else{
	    		//Add Item Call

		    	$result['ebay_id'] = $ebay_id;
		    	$this->load->view("ebay/trading/shopify/getitem_additonShopify", $result);


	    	}// count query else closing


    	}// endforeach ebay id query


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
				
			}
		  //echo $response;
		}        
    }
}
