<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* Listing Controller
	*/
class Listing extends CI_Controller
{
		
	public function __construct(){
		parent::__construct();
		$this->load->database();
		// login check commented due to issue on printer sticker
		// Do not un-comment the code other wise print sticker is not working
		 // if(!$this->loginmodel->is_logged_in())
		 //     {
		 //       redirect('login/login/');
		 //     }	
		 /*=============================================
        =  Section lz_bigData db connection block  =
        =============================================*/
        $CI = &get_instance();
		//setting the second parameter to TRUE (Boolean) the function will return the database object.
 //  $this->db2 = $CI->load->database('bigData', TRUE);
        /*=====  End of Section lz_bigData db connection block  ======*/		
	}

	public function index(){

		$status = $this->session->userdata('login_status');
		$login_id = $this->session->userdata('user_id');
		if(@$login_id && @$status == TRUE)
		{

		$this->load->model('listing/listing_model');
		// In View it will be $listing as row
		$data['listing'] = $this->listing_model->listed_data();
		$data['seed'] = $this->listing_model->seed_data();

		$data['pageTitle'] = 'Listing Form';
		$this->load->view('listing_views/listing_view', $data);
		}else{
			redirect('login/login/');
		}


	}
	public function barcode(){
		$this->load->view('ebay/trading/print_script/barcode.php');
	}
// public function print_label(){
// 		$this->load->view('ebay/trading/print_script/test.php');
// 	}
	public function print_label(){

		$list_id = $this->uri->segment(4);
		if(empty($list_id)){
			$list_id = $this->session->userdata('list_id');
		}

		//$con =  oci_connect('LAPTOP_ZONE_08dec16', 's', 'oraserver/LTPZDB') or die ('Error connecting to oracle');
		
		$qry = $this->db->query("SELECT DISTINCT MD.ITEM_MT_BBY_SKU,MM.PURCH_REF_NO,MD.ITEM_MT_MANUFACTURE BRAND,MD.ITEM_MT_MFG_PART_NO MPN,T.EBAY_ITEM_DESC ITEM_DESC,T.EBAY_ITEM_ID,'*' || T.EBAY_ITEM_ID || '*' BAR_CODE FROM EBAY_LIST_MT T, ITEMS_MT IM, LZ_MANIFEST_DET MD, LZ_MANIFEST_MT MM WHERE T.ITEM_ID = IM.ITEM_ID AND IM.ITEM_CODE = MD.LAPTOP_ITEM_CODE AND MM.LZ_MANIFEST_ID = MD.LZ_MANIFEST_ID AND T.LIST_ID = $list_id");

		$row = $qry->result_array();

	    $this->load->library('m_pdf');
		// to increse or decrese the width of barcode please set size attribute in barcode tag
          
        // $text = $data[0]["ITEM_DESC"];
        // $item_desc =implode("<br/>", str_split($text, 40));

		$text = @$row[0]["ITEM_DESC"];
		$newtext =implode("<br/>", str_split($text, 40));
		//$newtext = wordwrap($text, 40, "<br>", true);
		$html ='<div style = "margin-left:-35px!important;">
					<div style="width:150px !important;" class="barcodecell"><barcode height="0.85" size="0.65" code="'.@$row[0]["EBAY_ITEM_ID"].'" type="C128A" class="barcode" /></div>
					<Span style="margin:0;width:216px;padding:0;font-size:9px;font-family:arial;font-weight:600;">'.
						@$row[0]["BRAND"].'<br>'.
						@$row[0]["MPN"].'<br>'.
						$newtext.
					'</span><br>
					<strong style="margin: 0;padding: 0;font-size:14px">'.
						@$row[0]["EBAY_ITEM_ID"].
					'</strong><br>
				</div>';
            
        //generate the PDF from the given html
		$this->m_pdf->pdf->SetJS('this.print(false);');				
        $this->m_pdf->pdf->WriteHTML($html);
          
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "I");

		date_default_timezone_set("America/Chicago");
		$audit_datetime = date("Y-m-d H:i:s");
  		$audit_datetime = "TO_DATE('".$audit_datetime."', 'YYYY-MM-DD HH24:MI:SS')";
		$audit_by = $this->session->userdata('user_id');

		// if(!empty($this->uri->segment(4))){
		// 	$barcode = $this->uri->segment(5);

			$query = $this->db->query("UPDATE LZ_BARCODE_MT SET EBAY_STICKER = 1, AUDIT_DATETIME = $audit_datetime, AUDIT_BY = $audit_by WHERE LIST_ID = $list_id");	
		// }			
	}

	// code section added by adil asad 1-19-2018
	//*******************************************
	public function print_audit_label(){


		$list_id = $this->uri->segment(4);
		$audit_bin_id = trim(strtoupper($this->uri->segment(6)));

	  	$remarks = "";

		//var_dump($bin_id); exit;
		if(empty($list_id)){
			$list_id = $this->session->userdata('list_id');
		}

		//$con =  oci_connect('LAPTOP_ZONE_08dec16', 's', 'oraserver/LTPZDB') or die ('Error connecting to oracle');
		
		$qry = $this->db->query("SELECT DISTINCT MD.ITEM_MT_BBY_SKU,MM.PURCH_REF_NO,MD.ITEM_MT_MANUFACTURE BRAND,MD.ITEM_MT_MFG_PART_NO MPN,T.EBAY_ITEM_DESC ITEM_DESC,T.EBAY_ITEM_ID,'*' || T.EBAY_ITEM_ID || '*' BAR_CODE FROM EBAY_LIST_MT T, ITEMS_MT IM, LZ_MANIFEST_DET MD, LZ_MANIFEST_MT MM WHERE T.ITEM_ID = IM.ITEM_ID AND IM.ITEM_CODE = MD.LAPTOP_ITEM_CODE AND MM.LZ_MANIFEST_ID = MD.LZ_MANIFEST_ID AND T.LIST_ID = $list_id");
		$row = $qry->result_array();
		//var_dump($row);//exit;
	    $prev_barcode = $this->uri->segment(5);
	    $bar_qry = $this->db->query("SELECT MA.BARCODE_NO FROM LZ_DEKIT_US_DT DET, LZ_DEKIT_US_MT MA WHERE DET.BARCODE_PRV_NO = $prev_barcode AND DET.LZ_DEKIT_US_MT_ID = MA.LZ_DEKIT_US_MT_ID "); 

	    $bar_result = $bar_qry->result_array();

	    $master_barcod = @$bar_result[0]["BARCODE_NO"];
	    //var_dump($master_barcod);exit;

	    if(!empty($master_barcod)){

	    	$this->load->library('m_pdf');
			// to increse or decrese the width of barcode please set size attribute in barcode tag
          
            // $text = $data["ITEM_DESC"];
            // $item_desc =implode("<br/>", str_split($text, 40));
	    	$this->m_pdf->pdf->SetTitle(@$row[0]["EBAY_ITEM_ID"]);
            $text = @$row[0]["ITEM_DESC"];

			$newtext =implode("<br/>", str_split($text, 40));
			//$newtext = wordwrap($text, 40, "<br>", true);
			$html ='<div style = "margin-left:-35px!important;">
					<div style="width:150px !important;" class="barcodecell"><barcode height="0.85" size="0.65" code="'.@$row[0]["EBAY_ITEM_ID"].'" type="C128A" class="barcode" /></div>
					<Span style="margin:0;width:216px;padding:0;font-size:9px;font-family:arial;font-weight:600;">'.
						@$row[0]["BRAND"].'MB:'.@$master_barcod.'<br>'.
						@$row[0]["MPN"].'<br>'.
						$newtext.
					'</span><br>
					<strong style="margin: 0;padding: 0;font-size:14px">'.
						@$row[0]["EBAY_ITEM_ID"].
					'</strong><br>
				</div>';
          	//var_dump($html);exit;  
            //generate the PDF from the given html
          	//$this->m_pdf->pdf->SetJS('this.print(false);');
            $this->m_pdf->pdf->WriteHTML($html);

        	//download it.
        	$this->m_pdf->pdf->Output();

		}else{
			$this->load->library('m_pdf');
			$this->m_pdf->pdf->SetTitle(@$row[0]["EBAY_ITEM_ID"]);
			// to increse or decrese the width of barcode please set size attribute in barcode tag
          
            // $text = $data["ITEM_DESC"];
            // $item_desc =implode("<br/>", str_split($text, 40));

            $text = @$row[0]["ITEM_DESC"];
            //var_dump($text); exit;
			$newtext =implode("<br/>", str_split($text, 40));
			//$newtext = wordwrap($text, 40, "<br>", true);
			$html ='<div style = "margin-left:-35px!important;">
					<div style="width:150px !important;" class="barcodecell"><barcode height="0.85" size="0.65" code="'.@$row[0]["EBAY_ITEM_ID"].'" type="C128A" class="barcode" /></div>
					<Span style="margin:0;width:216px;padding:0;font-size:9px;font-family:arial;font-weight:600;">'.
						@$row[0]["BRAND"].'<br>'.
						@$row[0]["MPN"].'<br>'.
						$newtext.
					'</span><br>
					<strong style="margin: 0;padding: 0;font-size:14px">'.
						@$row[0]["EBAY_ITEM_ID"].
					'</strong><br>
				</div>';
            
            //generate the PDF from the given html
			//$this->m_pdf->pdf->SetJS('this.print(false);');				
            $this->m_pdf->pdf->WriteHTML($html);
            
        	//download it.
        	$this->m_pdf->pdf->Output();

		}

		date_default_timezone_set("America/Chicago");
		$audit_datetime = date("Y-m-d H:i:s");
  		$audit_datetime = "TO_DATE('".$audit_datetime."', 'YYYY-MM-DD HH24:MI:SS')";
		$audit_by = $this->session->userdata('user_id');

		if(!empty($this->uri->segment(5))){
			$barcode = $this->uri->segment(5); 

				// for New entered Bin
			$bin_id_qry = $this->db->query("SELECT BIN_ID, BIN_NAME FROM (SELECT B.BIN_ID, B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME FROM BIN_MT B) WHERE BIN_NAME = '$audit_bin_id'");
			$result = $bin_id_qry->result_array();
			$new_bin_id = @$result[0]['BIN_ID'];

			/*==== Bin Assignment to item barcode start ====*/
			$current_bin_qry = $this->db->query("SELECT MT.BIN_ID FROM LZ_BARCODE_MT MT WHERE MT.BARCODE_NO = $barcode");
			$bin_result = $current_bin_qry->result_array();
			$old_loc_id = @$bin_result[0]['BIN_ID'];


			$this->db->query("UPDATE LZ_BARCODE_MT SET EBAY_STICKER = 1, AUDIT_DATETIME = $audit_datetime, AUDIT_BY = $audit_by, BIN_ID = '$new_bin_id' WHERE BARCODE_NO = $barcode");


				if(!(empty($new_bin_id))){

				        $log_id_qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_LOC_TRANS_LOG','LOC_TRANS_ID') ID FROM DUAL"); 
				        $rs = $log_id_qry->result_array();
				        $loc_trans_id = @$rs[0]['ID'];							

						$this->db->query("INSERT INTO LZ_LOC_TRANS_LOG (LOC_TRANS_ID, TRANS_DATE_TIME, BARCODE_NO, TRANS_BY_ID, NEW_LOC_ID, OLD_LOC_ID, REMARKS, OLD_ROW_ID, NEW_ROW_ID) VALUES($loc_trans_id, $audit_datetime, $barcode, $audit_by, '$new_bin_id', '$old_loc_id', '$remarks',null,null)"); 

				}


				/*==== Bin Assignment to item barcode end ====*/					
		}			
	}
	// code section adden by adil asad jan-19-2018
	
	public function print_test(){

		$list_id = $this->uri->segment(4);

		//var_dump($bin_id); exit;
		if(empty($list_id)){
			$list_id = $this->session->userdata('list_id');
		}

		//$con =  oci_connect('LAPTOP_ZONE_08dec16', 's', 'oraserver/LTPZDB') or die ('Error connecting to oracle');
		
		$qry = $this->db->query("SELECT DISTINCT MD.ITEM_MT_BBY_SKU,MM.PURCH_REF_NO,MD.ITEM_MT_MANUFACTURE BRAND,MD.ITEM_MT_MFG_PART_NO MPN,T.EBAY_ITEM_DESC ITEM_DESC,T.EBAY_ITEM_ID,'*' || T.EBAY_ITEM_ID || '*' BAR_CODE FROM EBAY_LIST_MT T, ITEMS_MT IM, LZ_MANIFEST_DET MD, LZ_MANIFEST_MT MM WHERE T.ITEM_ID = IM.ITEM_ID AND IM.ITEM_CODE = MD.LAPTOP_ITEM_CODE AND MM.LZ_MANIFEST_ID = MD.LZ_MANIFEST_ID AND T.LIST_ID = $list_id");
		$row = $qry->result_array();
		//var_dump($row);//exit;
	    $prev_barcode = $this->uri->segment(5);
	    $bar_qry = $this->db->query("SELECT MA.BARCODE_NO FROM LZ_DEKIT_US_DT DET, LZ_DEKIT_US_MT MA WHERE DET.BARCODE_PRV_NO = $prev_barcode AND DET.LZ_DEKIT_US_MT_ID = MA.LZ_DEKIT_US_MT_ID "); 

	    $bar_result = $bar_qry->result_array();

	    $result['data'] = array('row'=>$row, 'bar_result' => $bar_result);

	    //var_dump($data);exit;

	    $this->load->view('listing_views/v_printView', $result);

	   
	}
	public function refreshUserToken(){
		$this->load->view('ebay\oauth-tokens\03-refresh-user-token');
	}
	public function getUserToken(){
		$this->load->view('ebay\oauth-tokens\02-get-user-token');
	}
	public function getAppToken(){
		$this->load->view('ebay\oauth-tokens\01-get-app-token');
	}
	public function findProducts(){
		$this->load->view('ebay\product\02-findProducts');
	}
	public function GetMostWatchedItems(){
		$this->load->view('API\GetMostWatchedItems');
	}
	public function searchitemrest(){
		$this->load->view('ebay/oauth-tokens/01-get-app-token');
		$this->load->view('ebay/browse/01-search-for-items');
	}
	public function getitemrest(){
		$this->load->view('ebay/browse/02-get-items');
	}
	public function searchcatalogrest(){
		$this->load->view('ebay/catalog/01-search');
	}
	public function getProduct(){
		$this->load->view('ebay/catalog/02-getProduct');
	}
	public function find_webhook(){
		$this->load->view('ebay/async/finditemswebhook');
	}
	public function item_specifics(){
		$this->load->view('ebay/trading/item_specifics');
	}
	public function cat_specific(){
		$this->load->view('ebay/trading/09-download-category-item-specifics');
	}
	public function check_active_ebay_id(){
		$this->load->view('ebay/trading/check_active_ebay_id');
	}
	public function GetOrdersbyorderid_tech(){
		$this->load->view('API\GetOrders\GetOrdersbyorderid_tech');
	}
	public function GetOrdersbyorderid(){
		$this->load->view('API\GetOrders\GetOrdersbyorderid');
	}
	public function findItemsAdvanced(){
		$this->load->view('ebay/finding/05-find-items-advanced');
	}
	public function findItemsbyproduct(){
		$this->load->view('ebay/finding/03-find-items-by-product');
	}
	public function find_sold_item(){
		$this->load->view('ebay/finding/find_sold_item');
	}
	public function GetSellingManagerSoldListings(){
		$this->load->view('ebay/trading/GetSellingManagerSoldListings');
	}
	public function getorders(){
		$this->load->view('API\GetOrders\GetOrders');
	}
	public function getAllOrders(){
		$this->load->view('API\GetOrders\GetOrders_dfw');
		$this->load->view('API\GetOrders\GetOrders_tech');
	}
	public function GetOrders_dfw(){
		$this->load->view('API\GetOrders\GetOrders_dfw');
	}
	public function get_sold_avg(){
		$get_kw = $this->db2->query("SELECT DISTINCT REPLACE(TRIM(UPPER(U.KEYWORD)),'&','') KEYWORD, U.CATLALOGUE_MT_ID, U.CONDITION_ID, U.CATEGORY_ID, TRIM(UPPER(U.EXCLUDE_WORDS)) EXCLUDE_WORDS FROM LZ_BD_RSS_FEED_URL U WHERE (U.CONDITION_ID <> 0 OR U.CONDITION_ID <> NULL) AND TRIM(U.KEYWORD) IS NOT NULL AND U.CATLALOGUE_MT_ID IS NOT NULL AND U.KEYWORD LIKE '%&%'ORDER BY U.CATLALOGUE_MT_ID DESC"); $result['data'] =  $get_kw->result_array();
		$this->load->view('API\get_avg_sold_price',$result);
	}
	public function get_sold_data(){
		$this->load->view('API\get_sold_data');
	}
	public function getsellerprofile(){
		$this->load->view('ebay/business-policies-management/01-retrieve-all-policies');
	}
	public function getcat(){
		$this->load->view('ebay/trading/02-get-category-hierarchy');
	}
	public function GetSpecifics(){
		$this->load->view('ebay/trading/specifics_download');
	}
	public function saveseed_test(){
		$this->load->view('ebay/trading/saveseed_test');
	}
	public function getitem(){
		$this->load->view('ebay/trading/getitem');
	}
	public function getitemall(){
		$listed_ebay_id = $this->db->query("SELECT BCD.EBAY_ITEM_ID FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, EBAY_LIST_MT E, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.EBAY_ITEM_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NOT NULL GROUP BY BC.EBAY_ITEM_ID, BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND E.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.ITEM_ID = I.ITEM_ID AND E.SEED_ID = LS.SEED_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID "); 
		$data['listed_ebay_id'] =  $listed_ebay_id->result_array();
		$this->load->view('ebay/trading/getitemALL',$data);
	}
	public function getitemstatus(){
		$this->load->view('ebay/shopping/03- get_item_status');
	}
	public function GetApiAccessRules(){
		$this->load->view('ebay/trading/GetApiAccessRules');
	}
	public function SetNotificationPreferences(){
		$data['account_name'] = 1;
		$this->load->view('ebay/trading/SetNotificationPreferences',$data);
	}
	public function GetNotificationPreferences(){
		$data['account_name'] = 1;
		$this->load->view('ebay/trading/GetNotificationPreferences',$data);
	}
	public function getebaydetails(){
		$this->load->view('ebay/trading/getebaydetails');
	}
	public function getmylist(){
		$data['account_name'] = 1;
		$this->load->view('ebay/trading/11-get-my-ebay-selling',$data);
	}
	public function getmyebayselling_merchant(){
		$data['account_name'] = 1;
		$this->load->view('ebay/trading/getmyebayselling_merchant',$data);
	}
	public function getsellerlist(){
		$this->load->view('ebay/trading/getsellerlist');

	}
	public function saveseed(){
		$this->load->view('ebay/trading/saveseed');
	}
	public function save_active_list(){
		$this->load->view('ebay/trading/save_active_list');
	}
	public function getcategories(){
		//$this->load->view('ebay/trading/getcategories');
		$this->load->view('ebay/trading/getcategories');
	}	
	public function GetCategoryFeatures(){
		
		//$get_cat = $this->db2->query("SELECT T.CATEGORY_ID FROM LZ_BD_CATEGORY_TREE T, LZ_BD_CATEGORY C WHERE T.PARENT_CAT_ID IS NOT NULL AND T.UPDATED IS NOT NULL AND C.CATEGORY_ID = T.CATEGORY_ID AND T.CATEGORY_ID > 187 AND C.CONDITION_AVAILABLE = 1 ORDER BY T.CATEGORY_ID ASC"); 
		$get_cat = $this->db2->query("SELECT DISTINCT U.CATEGORY_ID FROM LZ_BD_RSS_FEED_URL U ORDER BY U.CATEGORY_ID ASC");
		$result['data'] = $get_cat->result_array();

		$this->load->view('ebay/trading/GetCategoryFeatures',$result);
	}	
	public function find_seller_item(){
		$this->load->view('ebay/finding/finditembykeyword');
	}
	public function findItemsAdvance(){
		$this->load->view('ebay/finding/finditemadvance');
	}
	public function finditeminebaystore(){
		$this->load->view('ebay/finding/finditeminebaystore');
	}
	public function GetSessionID(){
		$data = $this->load->view('ebay/trading/GetSessionID');
		return $data;
	}
	public function FetchToken(){
		 $data = $this->load->view('ebay/trading/FetchToken');
 		return $data;
		//  echo json_encode($data);
		//  return json_encode($data);
	}
	public function upload_item()
	{
		if($this->input->post('submit'))
		{
			if(!empty($this->input->post('selected_item')))
			{
				foreach ($this->input->post('selected_item') as $item_id) 
				{
					$str =explode("-",$item_id);
                    $item_id = $str[0];
                    $manifest_id = $str[1];
                    // $manifest_id = $this->input->post($item_id);
					$list_qty = $this->input->post($manifest_id.$item_id);
					$this->load->model('listing/listing_model');
					$remain_qty=$this->listing_model->check_avail_qty($item_id,$manifest_id);
					if($remain_qty > 0)
					{
						$this->listing_model->check_item_id($item_id);
						$this->listing_model->uplaod_listQty($item_id,$manifest_id,$list_qty);
						$data['seed_data'] = $this->listing_model->uplaod_seed($item_id,$manifest_id);
						$data['pic_data'] = $this->listing_model->uplaod_seed_pic($item_id,$manifest_id);
						$data['specific_data'] = $this->listing_model->item_specifics($item_id,$manifest_id);
						$check = $this->session->userdata('check_item_id');
						if($check == true)
						{
							$active_listing = $this->load->view('ebay/trading/check_active_ebay_id');
						}
						$active_listing = $this->session->userdata('active_listing');
						if(!empty(@$active_listing) && $active_listing == true)
						{
							$this->session->unset_userdata('active_listing');
							// $list_item = $this->input->post('list_item');
							// if($list_item == 'Revised'){
							// 	$this->load->view('ebay/trading/Revisefixedpriceitem',$data);
							// }elseif($list_item == 'Add'){
							// 	$this->session->unset_userdata('ebay_item_id');
							// $this->load->view('ebay/trading/04-add-fixed-price-item',$data);
							// }
							$this->load->view('ebay/trading/Revisefixedpriceitem',$data);
							if(!empty($this->session->userdata('ebay_item_id')))
							{
								if($this->session->userdata('ebay_error'))
								{
									$this->session->unset_userdata('ebay_error');
									$this->session->unset_userdata('ebay_item_id');
									$this->session->unset_userdata('check_item_id');
									break;
								}
								$this->listing_model->insert_ebay_id($item_id,$manifest_id);
								$this->session->unset_userdata('ebay_item_id');
								$this->session->unset_userdata('check_item_id');
							}
							
						}else{
							$this->session->unset_userdata('ebay_item_id');
							$this->load->view('ebay/trading/04-add-fixed-price-item',$data);
								if($this->session->userdata('ebay_item_id'))
								{
									$this->listing_model->insert_ebay_id($item_id,$manifest_id);
									$this->session->unset_userdata('ebay_item_id');
									$this->session->unset_userdata('check_item_id');
								}
						}// end active listing ifelse
					}else{//Remain qty ifelse
						echo "<b>No More Quantity Available Against this Item.Item Not Listed.</b>";
					}
				}// end foreach
			}// end selected item if
		}// end submit if
	}// end public function

	public function seed(){
		
		$this->load->view('forms/seed');
	}
	
	public function suggest_price(){
		
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
		
		if(!empty($UPC) && strtoupper($UPC) != "DOES NOT APPLY")
		{
			$data['key']=$UPC;	
		}elseif(!empty($MPN && strtoupper($MPN) != "DOES NOT APPLY")){
			$data['key']=$MPN;
		}elseif(!empty($TITLE)){
			$data['key']=$TITLE;
		}
		$data['condition']=$CONDITION;
		$data['category']=$CATEGORY;
		$data['result'] = $this->load->view('API/suggest_price', $data);
	    return $data['result'];
	}
	public function searchActiveListing(){
		
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
		
		if(!empty($UPC) && strtoupper($UPC) != "DOES NOT APPLY")
		{
			$data['key']=$UPC;	
		}elseif(!empty($MPN && strtoupper($MPN) != "DOES NOT APPLY")){
			$data['key']=$MPN;
		}elseif(!empty($TITLE)){
			$data['key']=$TITLE;
		}
		$data['condition']=$CONDITION;
		$data['category']=$CATEGORY;
		$data['sellers']=$this->db->query("SELECT DISTINCT ACCOUNT_NAME FROM LJ_MERHCANT_ACC_DT")->result_array();
		$data['result'] = $this->load->view('API/searchActiveListing', $data);
	    return $data['result'];
	}
	public function get_item_sold_price(){
		
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
		
		if(!empty($UPC) && strtoupper($UPC) != "DOES NOT APPLY")
		{
			$data['key']=$UPC;	
		}elseif(!empty($MPN && strtoupper($MPN) != "DOES NOT APPLY")){
			$data['key']=$MPN;
		}elseif(!empty($TITLE)){
			$data['key']=$TITLE;
		}
		$data['condition']=$CONDITION;
		$data['category']=$CATEGORY;
		$data['multicond']=true;
		$data['result'] = $this->load->view('API/get_item_sold_price', $data);
	    return $data['result'];
	}
	public function Suggest_Categories(){

		$UPC = $this->input->post('UPC');
		$TITLE = $this->input->post('TITLE');
		$TITLE = trim(str_replace("  ", ' ', $TITLE));
        $TITLE = trim(str_replace(array("'"), "''", $TITLE));
		$MPN = $this->input->post('MPN');
		$MPN = trim(str_replace("  ", ' ', $MPN));
        $MPN = trim(str_replace(array("'"), "''", $MPN));
		if(!empty($UPC) && strtoupper($UPC) != "DOES NOT APPLY")
		{
			$data['key']=$UPC;	
		}elseif(!empty($MPN) && strtoupper($MPN) != "DOES NOT APPLY"){
			$data['key']=$MPN;
		}elseif(!empty($TITLE)){
			$data['key']=$TITLE;
		}
		$data['result'] =$this->load->view('API/SuggestCategories', $data);
		return $data['result'];
	}

	public function bby_getProduct(){

		// $UPC = $this->input->post('UPC');
		// $TITLE = $this->input->post('TITLE');
		// $TITLE = trim(str_replace("  ", ' ', $TITLE));
  //       $TITLE = trim(str_replace(array("'"), "''", $TITLE));
		// $MPN = $this->input->post('MPN');
		// $MPN = trim(str_replace("  ", ' ', $MPN));
  //       $MPN = trim(str_replace(array("'"), "''", $MPN));
		// if(!empty($UPC) && strtoupper($UPC) != "DOES NOT APPLY")
		// {
		// 	$data['key']=$UPC;	
		// }elseif(!empty($MPN) && strtoupper($MPN) != "DOES NOT APPLY"){
		// 	$data['key']=$MPN;
		// }elseif(!empty($TITLE)){
		// 	$data['key']=$TITLE;
		// }
		$data['key']='';
		$data['result'] =$this->load->view('API/BestBuy/getProduct', $data);
		return $data['result'];
	}
	/*=====  Start of API's for Shopify comment block  ======*/

	public function getitem_shopify(){
		$this->load->view('ebay/trading/shopify/getitem_shopify');
	}
	public function getsellerlist_shopify(){
		$this->load->view('ebay/trading/shopify/getsellerlist_shopify');
	}

	/*======= Bulk Delete Shopify Items ===========*/
	public function Bulk_deleteItem_Shopify(){
		$this->load->view('ebay/trading/shopify/Bulk_deleteItem_Shopify');	
	}

/*=====  End of API's for Shopify comment block  ======*/
}
 ?>