<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
	/**
	* Listing Controller
	*/
class c_itemsAudit extends CI_Controller
{
		
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('reactcontroller/m_itemsAudit');	    		
	}
	public function deleteAuditBarcode(){
		$data = $this->m_itemsAudit->deleteAuditBarcode();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function searchTransferCount(){
		$data = $this->m_itemsAudit->searchTransferCount();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function transferBinSave(){
		$data = $this->m_itemsAudit->transferBinSave();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function getPictureBinRecords(){
		$data = $this->m_itemsAudit->getPictureBinRecords();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function getItemsHistory(){
		$data = $this->m_itemsAudit->getItemsHistory();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function getItemsHistoryContent(){
		$data = $this->m_itemsAudit->getItemsHistoryContent();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function updateBin(){
		$data = $this->m_itemsAudit->updateBin();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function saveVerified(){
		$data = $this->m_itemsAudit->saveVerified();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function searchBarcodeAudit(){
		$data = $this->m_itemsAudit->searchBarcodeAudit();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function searchBinContents(){
		$data = $this->m_itemsAudit->searchBinContents();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function searchAudit(){
		$data = $this->m_itemsAudit->searchAudit();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function del_audit_barcode(){
		$data = $this->m_itemsAudit->del_audit_barcode();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function searchDekitAudit(){
		$data = $this->m_itemsAudit->searchDekitAudit();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function getLocationHistory(){
		$data = $this->m_itemsAudit->getLocationHistory();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function get_barcode(){
		$data = $this->m_itemsAudit->get_barcode();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function updateLocation(){
		$data = $this->m_itemsAudit->updateLocation();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function getBarcodeShortage(){
		$data = $this->m_itemsAudit->getBarcodeShortage();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function discardBarcode(){
		$data = $this->m_itemsAudit->discardBarcode();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function getDiscardedBarcodes(){
		$data = $this->m_itemsAudit->getDiscardedBarcodes();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function getBinStats(){
		$data = $this->m_itemsAudit->getBinStats();                
        echo json_encode($data);
   		return json_encode($data);
	} 
	public function searchBinContentsWithoutShortage(){
		$data = $this->m_itemsAudit->searchBinContentsWithoutShortage();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function getBarcodeShortageByBin(){
		$data = $this->m_itemsAudit->getBarcodeShortageByBin();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function resetBin(){
		$data = $this->m_itemsAudit->resetBin();                
        echo json_encode($data);
   		return json_encode($data);
	}
	function printAllStickers($barcode){

		  $result = $this->m_itemsAudit->printAllStickers($barcode); 
		//   var_dump($result);
		//   exit;
		  $bar  = $result[0]['BARCODE_PRV_NO'];
		  
         // var_dump($result);exit;
          $this->load->library('m_pdf');
		// to increse or decrese the width of barcode please set size attribute in barcode tag
          $i = 0;
          foreach($result as $data){
            $text = $data["ITEM_DESC"];
            $item_desc =implode("<br/>", str_split($text, 40));
            $html ='<div style = "margin-left:-35px!important;">
                      <div style="width:222px !important;" class="barcodecell"><barcode height="0.75" size="1.18" code="'.@$data["BARCODE_NO"].'" type="C128A" class="barcode" /></div>
                  
                  <div style="margin-top:6px !important;width:222px;padding:0;font-size:10px;font-family:arial;">
                  <span><b>'.
                    @$data["BARCODE_NO"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u></u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.
                    @$data["REF_DATE"].'</b><br><span style="margin-top:3px!important; font-size:9px!important;font-family:arial;"> </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>UNIT#:'
                    .@$data["UNIT_NO"].'</strong><br><strong>LOT QTY:'.
                    @$data["NO_OF_BARCODE"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;UPC:'.@$data["CARD_UPC"].'</strong>'.
                     
                    //$newtext.
                  '</span></div>
                </div>';
            //generate the PDF from the given html

            $this->m_pdf->pdf->SetTitle($bar);
            $this->m_pdf->pdf->WriteHTML($html);
            $i++;
            if(!empty($result[$i])){
            	$this->m_pdf->pdf->AddPage();
            }
            
          }//end foreach
          
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "I");


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
}	