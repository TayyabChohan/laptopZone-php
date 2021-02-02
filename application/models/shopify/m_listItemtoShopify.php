<?php  
  class M_listItemtoShopify extends CI_Model{

    public function __construct(){
    parent::__construct();
    $this->load->database();

    }
      
    public function insertShopifyItems(){


// $products = $shopify('GET /admin/products/count.json', array('published_status'=>'published'));

//     $totalproducts = $shopify('GET /admin/products/count.json', array('published_status'=>'published'));
//     $limit = 50;
//     $totalpage = ceil($totalproducts/$limit);
//     for($i=1; $i<=$totalpage; $i++){
//         $products = $shopify('GET /admin/products.json?'.$limit.'=50&page='.$i, array('published_status'=>'published'));
//         foreach($products as $product){
//           //do anything at once for all the products in store
//         }
//      }

		/*==========================================
		=            Get Products Count            =
		==========================================*/

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://c084db0733b8db2aef9f2a3a37b7314e:d19b1f6eece15313ce289b80e206286f@k2bay.myshopify.com/admin/products/count.json",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
		    "Content-Type: application/json",
		    "Postman-Token: ab3b071d-86c3-4eb3-bb31-7b3c2f655d30",
		    "cache-control: no-cache"
		  ),
		));

		$totalproducts = curl_exec($curl);
		$errcount = curl_error($curl);

		curl_close($curl);

		if ($errcount) {
		  echo "cURL Error #:" . $errcount;
		} 
		else {
		  //echo $totalproducts;
			$totalproducts = json_decode($totalproducts, true);
			$totalproducts = $totalproducts["count"];
		  //var_dump($totalproducts["count"]); exit;
		  //exit;
/*=====  End of Get Products Count  ======*/
    	/*=====================================================
    	=            Get All Products from Shopify            =
    	=====================================================*/
    	
    	$limit = 50;
    	$totalpage = ceil($totalproducts/$limit);

	    for($i=1; $i<=$totalpage; $i++){

	        //$products = $shopify('GET /admin/products.json?'.$limit.'=50&page='.$i, array('published_status'=>'published'));
	        //foreach($products as $product){
	          //do anything at once for all the products in store
	       // }
	     //}
	    	// var_dump($limit);
	    	// var_dump($i); exit;


		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://c084db0733b8db2aef9f2a3a37b7314e:d19b1f6eece15313ce289b80e206286f@k2bay.myshopify.com/admin/products.json?$limit=50&page=$i",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
		    "Postman-Token: 58e0a439-d6f1-40db-b4a9-2c33eb33b8c7",
		    "cache-control: no-cache"
		  ),
		));
		// curl_setopt_array($curl, array(
		//   CURLOPT_URL => "https://c084db0733b8db2aef9f2a3a37b7314e:d19b1f6eece15313ce289b80e206286f@k2bay.myshopify.com/admin/products.json",
		//   CURLOPT_RETURNTRANSFER => true,
		//   CURLOPT_ENCODING => "",
		//   CURLOPT_MAXREDIRS => 10,
		//   CURLOPT_TIMEOUT => 30,
		//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		//   CURLOPT_CUSTOMREQUEST => "GET",
		//   CURLOPT_HTTPHEADER => array(
		//     "Postman-Token: a8cec15b-ae9b-44dc-b2f8-fef036352fa9",
		//     "cache-control: no-cache"
		//   ),
		// ));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {

		  	//echo $response;

		    $products = json_decode($response, true);
		    // echo "<pre>";
		    // print_r ($response);
		    // echo "</pre>"; 
		    // exit;

		    foreach($products as $product):
		    	foreach ($product as $record) {

					$shopify_id = @$record["id"]; // Access Array data
					// var_dump($shopify_id);exit;
					$item_title = @$record["title"];
					$item_title = trim(str_replace("  ", ' ', $item_title));
    				$item_title = trim(str_replace(array("'"), "''", $item_title));

					$body_html_desc = @$record["body_html"];
					$body_html_desc = trim(str_replace("  ", ' ', $body_html_desc));
    				$body_html_desc = trim(str_replace(array("'"), "''", $body_html_desc));

					$product_type = @$record["product_type"];
					$product_type = trim(str_replace("  ", ' ', $product_type));
    				$product_type = trim(str_replace(array("'"), "''", $product_type));

					$created_at = @$record["created_at"];
					$created_at = str_replace("T", " ", $created_at);
					$created_at = str_replace("-05:00", "", $created_at);
					$created_at = "TO_DATE('".$created_at."', 'YYYY-MM-DD HH24:MI:SS')";
					if(empty($created_at)){
						$created_at = "''";
					}

					$handle = @$record["handle"];
					$handle = trim(str_replace("  ", ' ', $handle));
    				$handle = trim(str_replace(array("'"), "''", $handle));

					//echo '<strong>:</strong><br>', var_dump( $order_closed_at ), '<hr>';exit;
					$updated_at = @$record["updated_at"];
					$updated_at = str_replace("T", " ", $updated_at);
					$updated_at = str_replace("-05:00", "", $updated_at);
					$updated_at = "TO_DATE('".$updated_at."', 'YYYY-MM-DD HH24:MI:SS')";
					if(empty($updated_at)){
						$updated_at = "''";
					}

					$published_at = @$record["published_at"];
					$published_at = str_replace("T", " ", $published_at);
					$published_at = str_replace("-05:00", "", $published_at);
					$published_at = "TO_DATE('".$published_at."', 'YYYY-MM-DD HH24:MI:SS')";
					if(empty($published_at)){
						$published_at = "''";
					}

					$variants_id = @$record["variants"][0]["id"];
					$variants_price = @$record["variants"][0]["price"];
					$variants_sku = @$record["variants"][0]["sku"];
					if($variants_sku === "null"){
						$variants_sku = "";
					}

					$variants_created_at = @$record["variants"][0]["created_at"];
					$variants_created_at = str_replace("T", " ", $variants_created_at);
					$variants_created_at = str_replace("-05:00", "", $variants_created_at);
					$variants_created_at = "TO_DATE('".$variants_created_at."', 'YYYY-MM-DD HH24:MI:SS')";
					if(empty($variants_created_at)){
						$variants_created_at = "''";
					}

					$variants_updated_at = @$record["variants"][0]["updated_at"];
					$variants_updated_at = str_replace("T", " ", $variants_updated_at);
					$variants_updated_at = str_replace("-05:00", "", $variants_updated_at);
					$variants_updated_at = "TO_DATE('".$variants_updated_at."', 'YYYY-MM-DD HH24:MI:SS')";
					if(empty($variants_updated_at)){
						$variants_updated_at = "''";
					}
					//var_dump($variants_sku);exit;

					$variants_barcode = @$record["variants"][0]["barcode"];
					$variants_grams = @$record["variants"][0]["grams"];
					$variants_inventory_quantity = @$record["variants"][0]["inventory_quantity"];
					$variants_weight = @$record["variants"][0]["weight"];
					$variants_weight_unit = @$record["variants"][0]["weight_unit"];
					$variants_inventory_item_id = @$record["variants"][0]["inventory_item_id"];
					$old_inventory_quantity = @$record["variants"][0]["old_inventory_quantity"];
					$inserted_by = @$this->session->userdata('user_id');
										
					//var_dump($default_address_id);exit;
					
			        $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('SHOPIFY_LIST_MT_TEMP','LIST_ID') LIST_ID FROM DUAL");
			        $rs = $qry->result_array();
			        $list_id = $rs[0]['LIST_ID'];
			        //var_dump($shopify_id);exit;
				    $check_item = $this->db->query("SELECT SHOPIFY_ID FROM SHOPIFY_LIST_MT_TEMP WHERE SHOPIFY_ID = $shopify_id");
				    $rs = $check_item->result_array();
				    $check_shopify_id = @$rs[0]['SHOPIFY_ID'];	        
			        if(empty($check_shopify_id)){
						$itemInsertion = $this->db->query("INSERT INTO SHOPIFY_LIST_MT_TEMP (LIST_ID, SHOPIFY_ID, ITEM_TITLE, BODY_HTML_DESC, PRODUCT_TYPE, CREATED_AT, HANDLE, UPDATED_AT, PUBLISHED_AT, VARIANTS_ID, VARIANTS_PRICE, VARIANTS_SKU, VARIANTS_CREATED_AT, VARIANTS_UPDATED_AT, VARIANTS_BARCODE, VARIANTS_GRAMS, VARIANTS_INVENTORY_QUANTITY, VARIANTS_WEIGHT, VARIANTS_WEIGHT_UNIT, VARIANTS_INVENTORY_ITEM_ID, OLD_INVENTORY_QUANTITY, INSERTED_BY) VALUES($list_id, $shopify_id, '$item_title', '$body_html_desc', '$product_type', $created_at, '$handle', $updated_at, $published_at, $variants_id, $variants_price, '$variants_sku', $variants_created_at, $variants_updated_at, '$variants_barcode', $variants_grams, $variants_inventory_quantity, $variants_weight, '$variants_weight_unit', $variants_inventory_item_id, $old_inventory_quantity, $inserted_by)");
			      		if($itemInsertion){
			      			echo $i." - Inserted<br>";
			      			// $status = 1;
            // 				$this->session->set_userdata("status", $status);
			      		}else {
			      			echo "Not Inserted";
				      		// $status = 0;
            // 				$this->session->set_userdata("status", $status);
			      		}
			        }// order_id if closing		    		
		    	}//endforeach record
      				
	    	endforeach;
	    }// for loop closing


		} // product response else closing   	
    	
    	/*=====  End of Get All Products from Shopify  ======*/



		} //else if closing

		
    	
        
    }
    public function insertBarcodeSku()
    {
    	$query = $this->db->query("SELECT S.SHOPIFY_ID FROM SHOPIFY_LIST_MT S WHERE S.SKU IS NULL");
    	$q = $query->result_array();
    	// $total_ids = count($q);
    	// $shopify_id = $q[0]['SHOPIFY_ID'];

    	foreach ($q as $shopify_id) {
    		$id = $shopify_id['SHOPIFY_ID'];
    		//var_dump($q);exit;
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://c084db0733b8db2aef9f2a3a37b7314e:d19b1f6eece15313ce289b80e206286f@k2bay.myshopify.com/admin/products/$id.json",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_HTTPHEADER => array(
			    "Postman-Token: 57046d08-5361-41a5-a5ed-cf4614cc2e70",
			    "cache-control: no-cache"
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
			  echo "cURL Error #:" . $err;
			} else {

			  	//echo $response;
			  	$product = json_decode($response, true);
			    // echo "<pre>";
			    // print_r ($response);
			    // echo "</pre>"; 
			    // exit;
			    foreach($product as $record):

					$variants_sku = @$record["variants"][0]["sku"];
					// var_dump ($variants_sku);
					// exit;
					if($variants_sku === "null"){
						$variants_sku = "";
					}else if($variants_sku === "N"){
						$variants_sku = "";
					}

					$update_qry = $this->db->query("UPDATE SHOPIFY_LIST_MT S SET S.SKU = '$variants_sku' WHERE S.SHOPIFY_ID = $id");

				endforeach;			  
			}

    	}// endforeach



    }
    public function listOnShopify($seed_id, $item_id, $qty){
    	//$seed_id = $this->input->post("seed_id");
    	$trans = array("′" => "''","’" => "''","'" => "''","＇" => "''", '"'=>"''");//use in strtr function

    	$query = $this->db->query("SELECT S.ITEM_TITLE, S.CURRENCY, S.CATEGORY_NAME, S.ITEM_DESC, I.ITEM_MT_UPC UPC, I.ITEM_MT_MFG_PART_NO MPN, C.COND_NAME, S.QUANTITY, S.EBAY_PRICE, I.ITEM_MT_MANUFACTURE, D.WEIGHT, B.BARCODE_NO, B.CONDITION_ID, B.LZ_MANIFEST_ID FROM LZ_ITEM_SEED S, ITEMS_MT I, LZ_ITEM_COND_MT C, LZ_MANIFEST_DET D, LZ_BARCODE_MT B WHERE S.SEED_ID = $seed_id AND S.ITEM_ID = I.ITEM_ID AND C.ID = S.DEFAULT_COND AND I.ITEM_CODE = D.LAPTOP_ITEM_CODE AND S.LZ_MANIFEST_ID = D.LZ_MANIFEST_ID AND S.ITEM_ID = B.ITEM_ID AND S.LZ_MANIFEST_ID = B.LZ_MANIFEST_ID AND S.DEFAULT_COND = B.CONDITION_ID");
    	$q = $query->result_array();
    	$item_title = $q[0]['ITEM_TITLE'];
    	$currency = $q[0]['CURRENCY'];
    	$category_name = $q[0]['CATEGORY_NAME'];
    	$item_desc = $q[0]['ITEM_DESC'];
    	$upc = $q[0]['UPC'];
    	$mpn = $q[0]['MPN'];
    	$cond_name = $q[0]['COND_NAME'];
    	$quantity =  $qty;
    	$price = $q[0]['EBAY_PRICE'];
    	$Brand = $q[0]['ITEM_MT_MANUFACTURE'];
    	$weight = $q[0]['WEIGHT'];
    	$barcode_no = $q[0]['BARCODE_NO'];
    	$condition_id = $q[0]['CONDITION_ID'];
    	$lz_manifest_id = $q[0]['LZ_MANIFEST_ID'];
    	/*============================================
    	=            List item on Shopify            =
    	============================================*/
    	

	    $Title = trim(str_replace("  ", ' ', $item_title));
	    $Title = str_replace('"',"\\\"", $Title);

	    // echo $Title; //exit;
	    // var_dump($Title);
	    
	    $Description = strip_tags($item_desc); //Remove HTML Tags

	    //echo $Description."<br>";

	    $a = $Description;

	    if (strpos($a, 'Please read listing carefully') !== false) {
	        $pos = strpos($a, 'Please read listing carefully');
	        //var_dump($pos);
	        //echo 'true';
	        $Description = substr( $Description, 0, $pos);
	        $Description = trim(str_replace("  ", ' ', $Description));
	        $Description = str_replace('"',"\\\"", $Description);        
	        //var_dump("afterstr <br>".$Description);
	        //echo $Description."<br>";
	    }elseif(strpos($a, 'Holidays') == false){
	        $Description = strip_tags($item_desc);
	        $Description = trim(str_replace("  ", ' ', $Description));
	        $Description = str_replace('"',"\\\"", $Description);
	        //var_dump($Description);        
	        //echo $Description."<br>";
	    }

	    // https://stackoverflow.com/questions/1252693/using-str-replace-so-that-it-only-acts-on-the-first-match
	    // Remove First Occurance of string function
	    function str_replace_first($from, $to, $content)
	    {
	        $from = '/'.preg_quote($from, '/').'/';

	        return preg_replace($from, $to, $content, 1);
	    }

	    $Description = str_replace_first($Title, '', $Description);
	    //var_dump ($Description);exit;
	    $currencyID = trim(str_replace("  ", ' ', $currency));
	    $Quantity = trim(str_replace("  ", ' ', $quantity));
	    //$Quantity = 1;
	    $priceValue = trim(str_replace("  ", ' ', $price));
	    //$PictureURL = $all_url;

	    $ConditionDisplayName = trim(str_replace("  ", ' ', $cond_name)); //Condition Name: Used, New etc
	    $ConditionDisplayName = trim(str_replace(array("'"), "''", $cond_name));

	    $Brand = trim(str_replace("  ", ' ', $Brand));
	    $Brand = trim(str_replace(array("'"), "''", $Brand));

	    $WeightUnit = @$weight;
	    //$WeightUnit = 2.5;
	    
	    $category_name = trim(str_replace("  ", ' ', $category_name));
	    $category_name = trim(str_replace(array("'"), "''", $category_name));

	    $barcode_sku = @$barcode_no;
	    //$barcode_sku = 1234;
	    if(empty($barcode_sku)){
	        $barcode_sku = 'null';
	    }
	    if(!is_numeric($upc)){
	        $upc = $barcode_sku;
	    }

	    $upc = ltrim($upc, '0');

	    $pic_qry = $this->db->query("SELECT D.PIC_URL FROM SITE_HOSTED_PIC_MT S, SITE_HOSTED_PIC_DT D WHERE S.PIC_MT_ID = D.PIC_MT_ID AND S.ITEM_ID = $item_id AND S.CONDITION_ID = $condition_id ORDER BY D.PIC_DT_ID ASC")->result_array();
	    $all_url = $pic_qry;
	    $i = 1;
	    $img_src = "";

	    foreach($all_url as $pic){
	        $url = str_replace("/$","/\$", $pic["PIC_URL"]);
	        //echo $url."<br>";
	        if($i == count($all_url)){
	            $end_part = " }\r\n";
	        }else{
	            $end_part = " },\r\n";
	        }
	        $img_src .= "{\r\n        \"position\": $i,\r\n      \t\"src\": \"$url\"\r\n ".$end_part;
	        $i++;
	    }	    
	   // print_r($img_src);
	   //exit;

	    
	    //Empty MPN Check
	    // ----------------------------------------------------
	    // $lz_mpn = "LZ-"
	    // $sys_mpn = strstr($mpn,$lz_mpn);
	    $sys_mpn = $mpn;
	    if(!empty(@$sys_mpn)){
	        @$check_mpn = "";
	    }else if(@$sys_mpn == false){
	        $check_mpn = "<strong>MPN:</strong>  $mpn";
	    }
	    if(empty(@$mpn) && @$mpn == ""){
	        @$check_mpn = "";
	    }else{
	        $check_mpn = "<strong>MPN:</strong>  $mpn";        
	    }
	    //Empty Brand Check
	    // ----------------------------------------------------
	    if(empty(@$Brand) && @$Brand == ""){
	        @$check_brand = "";
	    }else{
	        $check_brand = "<strong>Brand:</strong>  $Brand";    
	    }
	    //Empty Condition Display Name
	    // -----------------------------------------------------
	    if(empty($ConditionDisplayName) && $ConditionDisplayName == ""){
	        @$check_condition = "";
	    }else{
	        $check_condition = "<strong>Condition:</strong>  $ConditionDisplayName";    
	    }    

	    $check_query = $this->db->query("SELECT * FROM (SELECT S.SHOPIFY_ID FROM SHOPIFY_LIST_MT S WHERE S.ITEM_ID = $item_id ORDER BY S.SHOPIFY_ID DESC) WHERE ROWNUM = 1");

		if ($check_query->num_rows() > 0){
			// Update & and get old quantity call
			$check_query = $check_query->result_array();
			$shopify_id = $check_query[0]["SHOPIFY_ID"];

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
			  $getqtyerr = "cURL Get Old Quantity Error #:" . $getOldQuantityErr;
			  return $getqtyerr;
			} else {
			  //echo $response;

				$getOldQuantity = json_decode($getOldQuantity, true);
				foreach($getOldQuantity as $qty_record){
					$old_inventory_quantity = @$qty_record["variants"][0]["old_inventory_quantity"];

					$revised_qty = $old_inventory_quantity + $Quantity;

					$curl = curl_init();

					curl_setopt_array($curl, array(
					  CURLOPT_URL => "https://c084db0733b8db2aef9f2a3a37b7314e:d19b1f6eece15313ce289b80e206286f@k2bay.myshopify.com/admin/products/$shopify_id.json",
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_ENCODING => "",
					  CURLOPT_MAXREDIRS => 10,
					  CURLOPT_TIMEOUT => 30,
					  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					  CURLOPT_CUSTOMREQUEST => "PUT",
					  CURLOPT_POSTFIELDS => "{\r\n    \"product\": {\r\n   \"id\": $shopify_id,\r\n    \"title\": \"$Title\",\r\n  \"body_html\": \" $check_mpn   $check_brand   $check_condition  <br><br><div style=\\\"color:#002CFD;font-family: Arial;font-size: 22px;text-decoration: underline;text-align: center;\\\">$Title</div><br><div style=\\\"font-size:16px;font-family:Arial;text-align:center;\\\">$Description</div>  \",\r\n  \"vendor\": \"K2Bay\",\r\n        \"product_type\": \"$category_name\",\r\n  \r\n    \"variants\": [\r\n  {\r\n  \"product_id\": $shopify_id,\r\n  \"price\": \" $priceValue \",\r\n  \"sku\": \" $barcode_sku \",\r\n   \"inventory_quantity\": $revised_qty \r\n\r\n  }\r\n ]\r\n   \r\n        \r\n    }\r\n}",
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
					  $revised_resp =  "Revised Response Error #:" . $revised_item_response_err;
					  return $revised_resp;
					} else {
					  //echo $response;
		 				$revise_product = json_decode($revised_item_response, true);
					    // echo "<pre>";
					    // print_r ($response);
					    // echo "</pre>"; 
					    // exit;
					    foreach($revise_product as $record):

							$shopify_id = @$record["id"]; // Access Array data
							//var_dump($shopify_id);exit;
							$title = @$record["title"];
							$handle = @$record["handle"];
							//var_dump($handle);
							$item_url = "https://k2bay.com/products/".$handle;
							//var_dump($item_url); exit;
							$title = strtr($title, $trans);
							// $title = trim(str_replace("  ", ' ', $title));
							// $title = trim(str_replace(array("'"), "''", $title));

							$item_description = @$record["body_html"];
							$item_description = strtr($item_description, $trans);
							// $item_description = trim(str_replace("  ", ' ', $item_description));
							// $item_description = trim(str_replace(array("'"), "''", $item_description));

							$listed_date = @$record["created_at"];
							$listed_date = str_replace("T", " ", $listed_date);
							$listed_date = str_replace("-05:00", "", $listed_date);
							$listed_date = str_replace("-06:00", "", $listed_date);
							$listed_date = "TO_DATE('".@$listed_date."', 'YYYY-MM-DD HH24:MI:SS')";
							if(empty($listed_date)){
								$listed_date = "''";
							}

							$quantity = @$record["variants"][0]["inventory_quantity"];
							$list_price = @$record["variants"][0]["price"];
							$variants_sku = @$record["variants"][0]["sku"];
							$listed_by = @$this->session->userdata('user_id');
							$status = "Revise";
												
							//var_dump($default_address_id);exit;
							
					        $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('SHOPIFY_LIST_MT','LIST_ID') LIST_ID FROM DUAL");
					        $rs = $qry->result_array();
					        $list_id = $rs[0]['LIST_ID'];
					        //var_dump($shopify_id);exit;

							$itemInsertion = $this->db->query("INSERT INTO SHOPIFY_LIST_MT (LIST_ID, SHOPIFY_ID, SEED_ID, STATUS, QUANTITY, TITLE, ITEM_DESCRIPTION, LIST_PRICE, LISTED_BY, LISTED_DATE, SKU, ITEM_ID) VALUES($list_id, $shopify_id, $seed_id, '$status', $quantity, '$title', '$item_description', $list_price, $listed_by, $listed_date, $variants_sku, $item_id)");
				      		if($itemInsertion){

				      			//echo "Inserted";
				      			//$this->session->set_userdata("item_url", $item_url);
				      			//echo $this->session->userdata("item_url"); exit;
				      			$update_qry = $this->db->query("UPDATE LZ_BARCODE_MT SET SHOPIFY_LIST_ID = $list_id WHERE ITEM_ID = $item_id AND LZ_MANIFEST_ID = $lz_manifest_id AND CONDITION_ID = $condition_id AND SALE_RECORD_NO IS NULL AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND SHOPIFY_LIST_ID IS NULL");

				      			return $item_url;
				      			
		         				
				      		}else {
				      			//echo "Not Inserted";
				      			$insertionError = "Not Inserted";
					      		return $insertionError;
		         				
				      		}
				        //}// order_id if closing		    		
		 				endforeach;

					}// responce else closing							

				}// get old quantity foreach closing
				

			}// response else closing of get old quantity call


		}else{

			// Add Item Call on Shopify
	        $item_source = "{\r\n  \"product\": {\r\n    \"title\": \"$Title\",\r\n    \"body_html\": \" $check_mpn   $check_brand   $check_condition  <br><br><div style=\\\"color:#002CFD;font-family: Arial;font-size: 22px;text-decoration: underline;text-align: center;\\\">$Title</div><br><div style=\\\"font-size:16px;font-family:Arial;text-align:center;\\\">$Description</div> \",\r\n    \"vendor\": \"K2Bay\",\r\n    \"product_type\": \"$category_name\",\r\n\t\"published_scope\": \"global\",\r\n    \"images\": [\r\n    \t\r\n    $img_src        ],\r\n  \"variant\": {\r\n    \"title\": \"$Title\",\r\n    \"price\": \"$priceValue\",\r\n    \"sku\": \"$barcode_sku\",\r\n    \"position\": 5,\r\n    \"inventory_policy\": \"deny\",\r\n    \"fulfillment_service\": \"manual\",\r\n    \"inventory_management\": \"shopify\",\r\n    \"barcode\": $upc,\r\n    \"inventory_quantity\": $Quantity,\r\n    \"weight\": $WeightUnit,\r\n    \"weight_unit\": \"oz\",\r\n    \"requires_shipping\": true\r\n  }\r\n  }\r\n}";

	        //print_r($item_source);exit;

	        $curl = curl_init();

	        curl_setopt_array($curl, array(
	          CURLOPT_URL => "https://c084db0733b8db2aef9f2a3a37b7314e:d19b1f6eece15313ce289b80e206286f@k2bay.myshopify.com/admin/products.json",
	          CURLOPT_RETURNTRANSFER => true,
	          CURLOPT_ENCODING => "",
	          CURLOPT_MAXREDIRS => 10,
	          CURLOPT_TIMEOUT => 30,
	          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	          CURLOPT_CUSTOMREQUEST => "POST",
	          CURLOPT_POSTFIELDS => $item_source,
	          CURLOPT_HTTPHEADER => array(
	            "Authorization: Basic YzA4NGRiMDczM2I4ZGIyYWVmOWYyYTNhMzdiNzMxNGU6ZDE5YjFmNmVlY2UxNTMxM2NlMjg5YjgwZTIwNjI4NmY=",
	            "Cache-Control: no-cache",
	            "Content-Type: application/json",
	            "Postman-Token: 9c475c3f-4b15-4e3c-be0b-af818d58bcf0"
	          ),
	        ));

	        $response = curl_exec($curl);
	        $err = curl_error($curl);

	        curl_close($curl);

	        if ($err) {
	            echo $err;
	            $response = "Response Error:".$err;
	            return $response;
	            //$this->session->set_userdata("response", $response);
	        } else {
	        	//echo $response;

			    $product = json_decode($response, true);
			    // echo "<pre>";
			    // print_r ($response);
			    // echo "</pre>"; 
			    // exit;
			    foreach($product as $record):

					$shopify_id = @$record["id"]; // Access Array data
					//var_dump($shopify_id);exit;
					$title = @$record["title"];
					$handle = @$record["handle"];
					//var_dump($handle);
					$item_url = "https://k2bay.com/products/".$handle;
					//var_dump($item_url); exit;
					$title = strtr($title, $trans);
					// $title = trim(str_replace("  ", ' ', $title));
					// $title = trim(str_replace(array("'"), "''", $title));

					$item_description = @$record["body_html"];
					$item_description = strtr($item_description, $trans);
					// $item_description = trim(str_replace("  ", ' ', $item_description));
					// $item_description = trim(str_replace(array("'"), "''", $item_description));
					$listed_date = "";
					$listed_date = @$record["created_at"];
					$listed_date = str_replace("T", " ", $listed_date);
					$listed_date = str_replace("-05:00", "", $listed_date);
					$listed_date = str_replace("-06:00", "", $listed_date);
					$listed_date = "TO_DATE('".@$listed_date."', 'YYYY-MM-DD HH24:MI:SS')";
					if(empty($listed_date)){
						$listed_date = "''";
					}

					$quantity = @$record["variants"][0]["inventory_quantity"];
					$list_price = @$record["variants"][0]["price"];
					$variants_sku = @$record["variants"][0]["sku"];
					$listed_by = @$this->session->userdata('user_id');
					$status = "Add";
										
					//var_dump($default_address_id);exit;
					
			        $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('SHOPIFY_LIST_MT','LIST_ID') LIST_ID FROM DUAL");
			        $rs = $qry->result_array();
			        $list_id = $rs[0]['LIST_ID'];
			        //var_dump($shopify_id);exit;

					$itemInsertion = $this->db->query("INSERT INTO SHOPIFY_LIST_MT (LIST_ID, SHOPIFY_ID, SEED_ID, STATUS, QUANTITY, TITLE, ITEM_DESCRIPTION, LIST_PRICE, LISTED_BY, LISTED_DATE, SKU, ITEM_ID) VALUES($list_id, $shopify_id, $seed_id, '$status', $quantity, '$title', '$item_description', $list_price, $listed_by, $listed_date, $variants_sku, $item_id)");
		      		if($itemInsertion){

		      			$update_qry = $this->db->query("UPDATE LZ_BARCODE_MT SET SHOPIFY_LIST_ID = $list_id WHERE ITEM_ID = $item_id AND LZ_MANIFEST_ID = $lz_manifest_id AND CONDITION_ID = $condition_id AND SALE_RECORD_NO IS NULL AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND SHOPIFY_LIST_ID IS NULL");
		      			//echo "Inserted";
		      			return $item_url;
		      			
         				
		      		}else {
		      			//echo "Not Inserted";
		      			$insertionError = "Not Inserted";
			      		return $insertionError;
         				
		      		}
		        //}// order_id if closing		    		
 				endforeach;

			} // product response else closing   	
   	
    	
    	/*=====  End of List item on Shopify  ======*/

		}// add item call else if closing
	


    }
    public function deleteItemfromShopifyandSystem(){

    	$shopify_list = array("1800925315139", "1800925741123", "1801347727427", "1801347956803", "1801348087875", "1801348382787", "1801348612163", "1801348776003", "1801348907075", "1801349103683", "1801349267523", "1801155739715", "1801155870787", "1801156100163", "1801156296771", "1801156427843", "1801156591683", "1801156689987", "1801136603203", "1801136767043", "1801136898115", "1801137061955", "1801137291331", "1801137455171", "1801137750083", "1801138044995", "1801138208835", "1800925937731", "1800926134339", "1800926560323", "1800927019075", "1800927379523", "1800928198723", "1800928591939", "1801353789507", "1801353986115", "1801354248259", "1801354510403", "1801354641475", "1801354936387", "1801159049283", "1801159213123", "1801159311427", "1801159409731", "1801159475267", "1801159606339", "1801159770179", "1801159934019", "1801138372675", "1801138536515", "1801138667587", "1801138864195", "1801139028035", "1801139322947", "1801139421251", "1801139552323", "1801139683395", "1800928952387", "1800929378371", "1800929837123", "1800930066499", "1800930263107", "1800930525251", "1800930754627", "1801340158019", "1801340289091", "1801340420163", "1801340584003", "1801340878915", "1801341075523", "1801341304899", "1801341501507", "1801341698115", "1801160032323", "1801160163395", "1801160261699", "1801139781699", "1801140011075", "1801140142147", "1801140273219", "1801140502595", "1801140863043", "1801141059651", "1801141223491", "1801141387331", "1801349398595", "1801349496899", "1801349660739", "1801349857347", "1801350086723", "1801350316099", "1801350479939", "1801350578243", "1800769306691", "1800769732675", "1800769863747", "1800770158659", "1800770420803", "1800770682947", "1800771010627", "1801014968387", "1801015394371", "1801015558211", "1801015951427", "1801016148035", "1801016344643", "1801016541251", "1801017032771", "1800779202627", "1800779792451", "1800780152899", "1800780382275", "1800780578883", "1800780808259", "1800780972099", "1801031286851", "1801031548995", "1801031680067", "1801031843907", "1801032040515", "1801032237123", "1801032433731", "1800771240003", "1800807907395", "1800808300611", "1800808693827", "1800809021507", "1800809316419", "1800809578563", "1801017262147", "1801305456707", "1800781135939", "1800781463619", "1800781692995", "1800781889603", "1800789327939", "1800789622851", "1800790016067", "1801032728643", "1801050685507", "1800809775171", "1800810004547", "1800810233923", "1800810430531", "1800810758211", "1800811085891", "1800811479107", "1800811675715", "1800812036163", "1801305882691", "1801306013763", "1646274314307", "1801306243139", "1801306406979", "1801306603587", "1801306931267", "1800790671427", "1800791064643", "1800791195715", "1800791457859", "1800791883843", "1801307422787", "1801307783235", "1801308045379", "1800812265539", "1800812429379", "1800812560451", "1800812822595", "1800812855363", "1800812986435", "1800813150275", "1800813379651", "1800813609027", "1801307291715", "1801308471363", "1801308635203", "1801308897347", "1801309028419", "1801309225027", "1800792080451", "1800792506435", "1800792997955", "1800793260099", "1800793980995", "1800794275907", "1800794472515", "1801308307523", "1800813674563", "1800813838403", "1800813969475", "1800814100547", "1800814362691", "1800814395459", "1800814592067", "1800814723139", "1800814952515", "1800795062339", "1800795291715", "1800795521091", "1800795750467", "1800795947075", "1800796241987", "1801321742403", "1801321906243", "1801322070083", "1801322201155", "1801322397763", "1801322561603", "1801322725443", "1801322823747", "1800815149123", "1800815280195", "1800815411267", "1800815968323", "1800816099395", "1800816230467", "1800816459843", "1800816623683", "1800816787523", "1801316597827", "1801316728899", "1801316925507", "1801317089347", "1801317187651", "1801317548099", "1801317679171", "1801317875779", "1801318039619", "1800796897347", "1800797126723", "1800797487171", "1800797814851", "1800798175299", "1800798404675", "1800798666819", "1800798928963", "1800799387715", "1801311977539", "1801313222723", "1801313321027", "1800817311811", "1800817606723", "1800818065475", "1800818131011", "1800818491459", "1800818786371", "1801322922051", "1801324953667", "1801325248579", "1801325609027", "1801325805635", "1801325969475", "1800799649859", "1800799944771", "1800800174147", "1800800567363", "1800800895043", "1800801058883", "1800801419331", "1800801976387", "1801318301763", "1801318367299", "1801318465603", "1801318531139", "1801318629443", "1801318858819", "1800819081283", "1800819343427", "1800819540035", "1800819802179", "1801313550403", "1801313648707", "1801313845315", "1801313943619", "1801314172995", "1801314271299", "1800802238531", "1800802533443", "1800802730051", "1800802926659", "1800803287107", "1800803549251", "1800803811395", "1801326100547", "1801326166083", "1801326231619", "1801326395459", "1801326624835", "1801326723139", "1801326952515", "1801327116355", "1801327444035", "1800822358083", "1800823013443", "1801319252035", "1801319546947", "1801319776323", "1801319972931", "1801320136771", "1801320235075", "1801320333379", "1801320562755", "1801017655363", "1801017851971", "1801018146883", "1801018343491", "1801018572867", "1801018900547", "1801314467907", "1801314566211", "1801314697283", "1801314828355", "1801315221571", "1801315385411", "1800824913987", "1800825143363", "1801323118659", "1801323249731", "1801323446339", "1801323577411", "1801323774019", "1801324003395", "1801324298307", "1801324560451", "1801324724291", "1801019228227", "1801019457603", "1801019785283", "1801020145731", "1801020506179", "1801020735555", "1801020866627", "1801021063235", "1801021227075", "1801320628291", "1801320824899", "1801321054275", "1801321119811", "1801321185347", "1801321349187", "1801321545795", "1800828813379", "1800829009987", "1800829763651", "1801315582019", "1801315713091", "1801316237379", "1801316335683", "1801316401219", "1801316532291", "1801021456451", "1801021620291", "1801021784131", "1801022144579", "1801022308419", "1801022537795", "1801022701635", "1801022865475", "1800756920387", "1800757182531", "1800757411907", "1800757641283", "1800757870659", "1800758067267", "1800758263875", "1800758362179", "1800829927491", "1800830189635", "1800771502147", "1800771764291", "1800772157507", "1800772386883", "1800772550723", "1800772747331", "1800773009475", "1800773206083", "1800773304387", "1801023094851", "1801023422531", "1801023586371", "1801023750211", "1801023946819", "1801024176195", "1801024438339", "1801024667715", "1801024766019", "1800758788163", "1800759181379", "1800759476291", "1800759869507", "1800760328259", "1800760655939", "1800760983619", "1801006776387", "1800773435459", "1800773632067", "1800773828675", "1800773959747", "1800774058051", "1800774221891", "1800774385731", "1800774615107", "1801024962627", "1801025159235", "1801025355843", "1801025519683", "1801025683523", "1801025978435", "1801026175043", "1801026306115", "1800761212995", "1800761442371", "1800761638979", "1800761835587", "1800762032195", "1800762294339", "1800762458179", "1800762556483", "1800762785859", "1801007071299", "1801007366211", "1801007530051", "1801007824963", "1801008087107", "1801008480323", "1801008709699", "1801008971843", "1800774811715", "1800775041091", "1800775303235", "1800775467075", "1800775663683", "1800775794755", "1800776056899", "1801026568259", "1801026895939", "1801027027011", "1801027387459", "1801027584067", "1801027780675", "1800763048003", "1800763441219", "1800763637827", "1800763965507", "1800764194883", "1800764555331", "1800764784707", "1800764883011", "1800765079619", "1801009135683", "1801009365059", "1801009627203", "1801010085955", "1801010151491", "1801010282563", "1801010413635", "1801010577475", "1800776351811", "1800776417347", "1800776581187", "1800776745027", "1800776908867", "1800777007171", "1800777171011", "1800777334851", "1801027977283", "1801028108355", "1801028370499", "1801028501571", "1801028632643");

    	foreach ($shopify_list as $shopify_id) {
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
			    "Authorization: Basic YzA4NGRiMDczM2I4ZGIyYWVmOWYyYTNhMzdiNzMxNGU6ZDE5YjFmNmVlY2UxNTMxM2NlMjg5YjgwZTIwNjI4NmY=",
			    "Content-Type: application/json",
			    "Postman-Token: 64fe568c-3be4-462a-98df-c7d28ecb370f",
			    "cache-control: no-cache"
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
			  echo "cURL Error #:" . $err."<br>";
			} else {
			  echo $response." Deleted <br>";
			}
    	} //end foreach loop

	} 

}
