<?php
defined('BASEPATH') or exit('No direct script access allowed');

// header("Access-Control-Allow-Origin: *");

class c_add_werehouse extends CI_Controller
{

	public function __construct()
	{
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
		parent::__construct();
		$this->load->database();
		$this->load->model('reactModel/m_add_werehouse');
		// header("Access-Control-Allow-Origin: *");

	}
	public function add_warhouse()  // get select barcode
	{

		$data = $this->m_add_werehouse->add_wer();
		//  var_dump($data);
		echo json_encode($data);
		return json_encode($data);
	}
	public function get_atu_no()
	{
		$data = $this->m_add_werehouse->get_atu_no();
		echo json_encode($data);
		return json_encode($data);
	}
	public function get_wer()  // get select barcode
	{

		$data = $this->m_add_werehouse->get_wer();
		//  var_dump($data);
		echo json_encode($data);
		return json_encode($data);
	}

	/********************************
	 *   start Screen rack
	 *********************************/
	public function dropdown_wer_desc()  // get select barcode
	{

		$data = $this->m_add_werehouse->dropdown_wer_desc();
		//  var_dump($data);
		echo json_encode($data);
		return json_encode($data);
	}

	public function dropdown_rack_type()  // get select barcode
	{

		$data = $this->m_add_werehouse->dropdown_rack_type();
		//  var_dump($data);
		echo json_encode($data);
		return json_encode($data);
	}
	public function get_Rack()  // get select barcode
	{

		$data = $this->m_add_werehouse->get_Rack();
		//  var_dump($data);
		echo json_encode($data);
		return json_encode($data);
	}
	public function add_rack()  // get select barcode
	{

		$data = $this->m_add_werehouse->add_rack();
		//  var_dump($data);
		echo json_encode($data);
		return json_encode($data);
	}

	public function print_sticker()
	{
		$result = $this->m_add_werehouse->print_sticker();

		$this->load->library('m_pdf');
		// to increse or decrese the width of barcode please set size attribute in barcode tag
		$i = 0;
		foreach ($result as $data) {
			// $text = $data["ITEM_DESC"];
			//$item_desc =implode("<br/>", str_split($text, 40));
			$html = '<div style = "margin-left:-35px!important;">
					<div style="width:222px !important;" class="barcodecell"><barcode height="1.40" size="1.40" code="' . @$data["RACK_NAME"] . '" type="C128A" class="barcode" /></div>
					
				<div style="margin-top:6px !important;width:440px;padding:0;font-size:40px;font-family:arial;">
				<span><b>' .
				@$data["RACK_NAME"] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>' . '</div>';
			//generate the PDF from the given html
			$this->m_pdf->pdf->SetJS('this.print(false);');
			$this->m_pdf->pdf->WriteHTML($html);
			$i++;
			if (!empty($result[$i])) {
				$this->m_pdf->pdf->AddPage();
			}
		} //end foreach

		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "I");
	}

	public function print_all_rows()
	{
		//$rack_id = $this->uri->segment(4);
		$rack_id = $_GET['id'];
		$rack_stick = $this->db->query("SELECT RO.RACK_ROW_ID,'W' || '' || WA.WAREHOUSE_NO || '-' || RA.RACK_NO ||'-' || 'R' || RO.ROW_NO  RACK_NAME FROM RACK_MT RA, WAREHOUSE_MT WA, LZ_RACK_ROWS RO WHERE RA.RACK_ID = $rack_id AND RA.WAREHOUSE_ID = WA.WAREHOUSE_ID AND RA.RACK_ID = RO.RACK_ID ORDER BY RO.ROW_NO ASC ")->result_array();



		$rack_name = $rack_stick[0]['RACK_NAME'];
		$rack_rows = $rack_stick[0]['NO_OF_ROWS'];

		// var_dump($rack_rows);
		// exit;

		$this->load->library('m_pdf');


		$i = 0;
		foreach ($rack_stick as $data) {
			// $text = $data["ITEM_DESC"];
			//$item_desc =implode("<br/>", str_split($text, 40));
			$html = '<div style = "margin-left:-52px!important;">
		  <div style="width:300px !important;" class="barcodecell"><barcode height="1.40" size="1.40" code="' . @$data["RACK_NAME"] . '" type="C128A" class="barcode" /></div>
		  
		  <div style="margin-left:20px !important;width:480px;padding:0;font-size:38px;font-family:arial;">
		  <span><b>' .
				@$data["RACK_NAME"] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>' . '</div>';
			//generate the PDF from the given html
			$this->m_pdf->pdf->SetJS('this.print(false);');
			$this->m_pdf->pdf->WriteHTML($html);
			$i++;
			if (!empty($rack_stick[$i])) {
				$this->m_pdf->pdf->AddPage();
			}
		} //end foreach



		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "I");
	}
	/********************************
	 *   end Screen bin
	 *********************************/


	public function get_bin()  // get select barcode
	{

		$data = $this->m_add_werehouse->get_bin();
		//  var_dump($data);
		echo json_encode($data);
		return json_encode($data);
	}

	public function print_single_bin()
	{
		//$bin_id = $this->uri->segment(4);
		$bin_id = $_GET['id'];
		$rack_bin = $this->db->query("  SELECT  B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME ,DECODE(BIN_TYPE, 'NA', 'W' || WA.WAREHOUSE_NO || '-' || M.RACK_NO || '-R' || ROW_NO) WARE_NAME FROM BIN_MT B, LZ_RACK_ROWS RA, RACK_MT M, WAREHOUSE_MT WA WHERE BIN_TYPE NOT IN ('No Bin') AND B.CURRENT_RACK_ROW_ID = RA.RACK_ROW_ID AND RA.RACK_ID = M.RACK_ID AND M.WAREHOUSE_ID = WA.WAREHOUSE_ID AND B.BIN_ID =$bin_id  ")->result_array();

		$this->load->library('m_pdf');
		// to increse or decrese the width of barcode please set size attribute in barcode tag
		$i = 0;
		foreach ($rack_bin as $data) {
			// $text = $data["ITEM_DESC"];
			//$item_desc =implode("<br/>", str_split($text, 40));
			$html = '<div style = "margin-left:-50px!important; border:5px solid #000; padding-top:20px !important; padding-left: 20px !important; width:300px !important;">
						<div style="" class="barcodecell"><barcode height="1.40" size="1.40" code="' . @$data["BIN_NAME"] . '" type="C128A" class="barcode" /></div>
					
					<div style="margin-left:20px !important;width:480px;padding:0;font-size:38px;font-family:arial; padding-bottom:10px !important;">
					<span><b>' .
				@$data["BIN_NAME"] . '&nbsp;&nbsp;</b></span>' . '</div><div style="margin-left:20px !important;width:480px;padding:0;font-size:20px;font-family:arial; padding-bottom:1px !important;">
					<span><b>' .
				@$data["WARE_NAME"] . '&nbsp;&nbsp;</b></span>' . '</div>';
			//generate the PDF from the given html
			$this->m_pdf->pdf->SetJS('this.print(false);');
			$this->m_pdf->pdf->WriteHTML($html);
			$i++;
			if (!empty($rack_bin[$i])) {
				$this->m_pdf->pdf->AddPage();
			}
		} //end foreach

		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "I");

		$this->db->query(" UPDATE BIN_MT SET PRINT_STATUS = 2 where bin_id =$bin_id ");
	}


	public function print_all_bin()
	{
		// $bin_type = $this->uri->segment(4);
		// $print_sta = $this->uri->segment(5);

		$print_sta = $_GET['PrintStatus'];
		$bin_type = $_GET['Bin_type'];
		// var_dump($bin_type);
		// var_dump($print_sta);
		// exit;
		// var_dump($bin_type,$print_sta );
		// exit;
		$print_stat = $this->uri->segment(5);

		$rack_bin = $this->db->query("   SELECT  B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME ,DECODE(BIN_TYPE, 'NA', 'W' || WA.WAREHOUSE_NO || '-' || M.RACK_NO || '-R' || ROW_NO) WARE_NAME FROM BIN_MT B, LZ_RACK_ROWS RA, RACK_MT M, WAREHOUSE_MT WA WHERE B.BIN_type ='$bin_type' and B.PRINT_STATUS = $print_sta AND B.CURRENT_RACK_ROW_ID = RA.RACK_ROW_ID AND RA.RACK_ID = M.RACK_ID AND M.WAREHOUSE_ID = WA.WAREHOUSE_ID  ORDER BY B.BIN_TYPE,B.BIN_NO  ")->result_array();

		$this->load->library('m_pdf');
		// to increse or decrese the width of barcode please set size attribute in barcode tag
		$i = 0;
		foreach ($rack_bin as $data) {
			// $text = $data["ITEM_DESC"];
			//$item_desc =implode("<br/>", str_split($text, 40));
			$html = '<div style = "margin-left:-50px!important; border:5px solid #000; padding-top:20px !important; padding-left: 20px !important; width:300px !important;">
						<div style="" class="barcodecell"><barcode height="1.40" size="1.40" code="' . @$data["BIN_NAME"] . '" type="C128A" class="barcode" /></div>
					
					<div style="margin-left:20px !important;width:480px;padding:0;font-size:38px;font-family:arial; padding-bottom:10px !important;">
					<span><b>' .
				@$data["BIN_NAME"] . '&nbsp;&nbsp;</b></span>' . '</div><div style="margin-left:20px !important;width:480px;padding:0;font-size:20px;font-family:arial; padding-bottom:1px !important;">
					<span><b>' .
				@$data["WARE_NAME"] . '&nbsp;&nbsp;</b></span>' . '</div>';
			//generate the PDF from the given html
			$this->m_pdf->pdf->SetJS('this.print(false);');
			$this->m_pdf->pdf->WriteHTML($html);
			$i++;
			if (!empty($rack_bin[$i])) {
				$this->m_pdf->pdf->AddPage();
			}
		} //end foreach

		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "I");

		$this->db->query(" UPDATE BIN_MT SET PRINT_STATUS = 2  where  BIN_type ='$bin_type' and PRINT_STATUS = $print_sta  ");
	}

	public function add_bin()  // get select barcode
	{

		$data = $this->m_add_werehouse->add_bin();
		//  var_dump($data);
		echo json_encode($data);
		return json_encode($data);
	}
	// public function Search_printStatus()  // get select barcode
	// {

	// 	$data = $this->m_add_werehouse->Search_printStatus();
	// 	//  var_dump($data);
	// 	echo json_encode($data);
	// 	return json_encode($data);
	// }


	public function Search_printStatus()
	{


		$result = $this->m_add_werehouse->Search_printStatus();
		echo json_encode($result);
		return json_encode($result);
	}

	/********************************
	 *   end Screen bin
	 *********************************/
	/********************************
	 *   start Screen item packing
	 *********************************/
	public function get_barcode()  // get select barcode
	{

		$data = $this->m_add_werehouse->get_barcode();
		//  var_dump($data);
		echo json_encode($data);
		return json_encode($data);
	}
	public function updatePacking()  // get select barcode
	{

		$data = $this->m_add_werehouse->updatePacking();
		//  var_dump($data);
		echo json_encode($data);
		return json_encode($data);
	}
	public function get_packing_drop()  // get select barcode
	{

		$data = $this->m_add_werehouse->get_packing_drop();
		//  var_dump($data);
		echo json_encode($data);
		return json_encode($data);
	}


	/********************************
	 *   end Screen item packing
	 *********************************/
}
