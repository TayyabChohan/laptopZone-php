<?php
// use function GuzzleHttp\json_decode;
// use function GuzzleHttp\json_encode;

// use function GuzzleHttp\json_encode;

defined('BASEPATH') or exit('No direct script access allowed');

// header("Access-Control-Allow-Origin: *");

class c_react_test extends CI_Controller
{

	public function __construct()
	{
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
		parent::__construct();
		$this->load->database();
		$this->load->model('reactModel/m_react_test_model');
		// header("Access-Control-Allow-Origin: *");

	}

	public function getData()
	{

		$data['get_data'] = $this->m_react_test_model->getData();
		echo json_encode($data);
		return json_encode($data);
	}

	public function insertService()
	{
		$Data = json_decode(file_get_contents('php://input'), true);
		$name = $Data['name'];
		$name = trim(str_replace("  ", ' ', $name));
		$name = trim(str_replace(array("'"), "''", $name));
		$created_by = $Data['created_by'];
		$data = $this->m_react_test_model->insertService($name, $created_by);
		echo json_encode($data);
		return json_encode($data);
	}
	public function getService()
	{
		$data = $this->m_react_test_model->getService();
		echo json_encode($data);
		return json_encode($data);
	}

	public function deleteService()
	{
		//$Data = json_decode(file_get_contents('php://input'), true);
		$SERVICE_ID = $this->input->post('SERVICE_ID');
		//$SERVICE_ID = $Data['SERVICE_ID'];
		$data = $this->m_react_test_model->deleteService($SERVICE_ID);
		echo json_encode($data);
		return json_encode($data);
	}

	// 	 public function getServiceRateDrowp(){

	// 		$data= $this->m_react_test_model->getServiceRateDrowp();
	// echo json_encode($data);
	// return json_encode($data); 
	// 	}

	public function insertServiceRate()
	{
		//	$data = json_decode(file_get_contents('php://input'), true);
		// var_dump($data);exit;
		//foreach($data  as $value){

		$selectServiceName = $this->input->post('selectServiceName');
		$service_type = $this->input->post('service_type');
		$service_Charges = $this->input->post('service_Charges');
		$created_by = $this->input->post('created_by');

		// $selectServiceName=$value['selectServiceName'];
		// $service_type=$value['service_type'];
		// $service_Charges = $value['service_Charges'];
		// $created_by = $value['created_by'];
		//	}

		$service_Charges = trim(str_replace("  ", ' ', $service_Charges));
		$service_Charges = trim(str_replace(array("'"), "''", $service_Charges));
		if (!empty($selectServiceName)) {
			$data = $this->m_react_test_model->insertServiceRate($selectServiceName, $service_type, $service_Charges, $created_by);
			echo json_encode($data);
			return json_encode($data);
		}
	}


	public function getServiceRate()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$data = $this->m_react_test_model->getServiceRate($data['userId']);
		echo json_encode($data);
		return json_encode($data);
	}


	public function deleteServiceRate()
	{
		// $Data = json_decode(file_get_contents('php://input'), true);
		$ser_rate_id = $this->input->post('ser_rate_id');
		// $ser_rate_id = $Data['ser_rate_id'];
		//$service_Charges = $Data['service_Charges'];
		if (!empty($ser_rate_id)) {
			$data = $this->m_react_test_model->deleteServiceRate($ser_rate_id);
		}
		echo json_encode($data);
		return json_encode($data);
	}


	public function upDateSerViceRate()
	{


		// $service_Charges=trim(str_replace("  ", ' ', $service_Charges));
		// $service_Charges = trim(str_replace(array("'"), "''", $service_Charges));
		$data = $this->m_react_test_model->upDateSerViceRate();
		echo json_encode($data);
		return json_encode($data);
	}


	public function insertPacking()
	{

		$data = $this->m_react_test_model->InsertPacking();
		echo json_encode($data);
		return json_encode($data);
	}


	public function insertPacking22()
	{

		$data = $this->m_react_test_model->InsertPacking22();
		echo json_encode($data);
		return json_encode($data);
	}



	public function getPacking()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$data = $this->m_react_test_model->GetPacking();
		echo json_encode($data);
		return json_encode($data);
	}



	public function deletePacking()
	{
		// $Data = json_decode(file_get_contents('php://input'), true);
		// $PACKING_ID = $Data['PACKING_ID'];
		$PACKING_ID = $this->input->post('PACKING_ID');
		if (!empty($PACKING_ID)) {
			$data = $this->m_react_test_model->DeletePacking($PACKING_ID);
		}

		echo json_encode($data);
		return json_encode($data);
	}


	public function updatePacking()
	{


		$data = $this->m_react_test_model->UpdatePacking();
		echo json_decode($data);
		return json_encode($data);
	}


	public function packingOrderDrop()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$data = $this->m_react_test_model->PackingOrderDrop();
		echo json_encode($data);
		return json_encode($data);
	}

	public function marchantDrop()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$data = $this->m_react_test_model->MarchantDrop();
		echo json_encode($data);
		return json_encode($data);
	}



	public function getPackingOrderDetail()
	{
		//$data=json_decode(file_get_contents('php://input'),true);
		$MERCHANT_ID = $this->input->post('id');

		$data = $this->m_react_test_model->GetPackingOrderDetail();
		echo json_encode($data);
		return json_encode($data);
	}


	public function upDatePostage()
	{

		$POSTAGE = $this->input->post('POSTAGE');
		$LZ_SALESLOAD_DET_ID = $this->input->post('LZ_SALESLOAD_DET_ID');

		$data = $this->m_react_test_model->UpDatePostage();
		echo json_encode($data);
		return json_encode($data);
	}

	public function insertPackingDetail()
	{

		$PACKING_ID = $this->input->post('PACKING_ID');
		$ORDER_ID = $this->input->post('ORDER_ID');
		$MERCHANT_ID = $this->input->post('MERCHANT_ID');
		$PACKING_BY = $this->input->post('PACKING_BY');
		$PACKING_COST = $this->input->post('PACKING_COST');

		$data = $this->m_react_test_model->InsertPackingDetail();
		echo json_encode($data);
		return json_encode($data);
	}

	public function detailInsertPackingName()
	{
		$PACKING_ID = $this->input->post('pakingId');
		$ORDER_PACKING_ID = $this->input->post('ORDER_PACKING_ID');
		$data = $this->m_react_test_model->DetailInsertPackingName();
		echo json_encode($data);
		return json_encode($data);
	}

	public function listViewPackingName()
	{

		$ORDER_PACKING_ID = $this->input->post('id');
		$data = $this->m_react_test_model->ListViewPackingName();
		echo json_encode($data);
		return json_encode($data);
	}

	public function deleteListItem()
	{
		// $Data = json_decode(file_get_contents('php://input'), true);
		// $PACKING_ID = $Data['PACKING_ID'];
		$ORDER_PACKING_DT_ID = $this->input->post('id');

		$data = $this->m_react_test_model->DeleteListItem();
		echo json_encode($data);
		return json_encode($data);
	}



	public function upDateDemension()
	{

		$LWH = $this->input->post('LWH');
		$ITEM_ID = $this->input->post('item_id');

		$data = $this->m_react_test_model->UpDateDemension();
		echo json_encode($data);
		return json_encode($data);
	}

	public function getTempdata()
	{
		$data = $this->m_react_test_model->GetTempdata();
		echo json_encode($data);
		return json_encode($data);
	}
	public function shipingServiceDrowp()
	{ // for tamplate form
		$data = $this->m_react_test_model->ShipingServiceDrowp();
		echo json_encode($data);
		return json_encode($data);
	}

	public function insetTemplatedata()
	{ // for tamplate form
		$data = $this->m_react_test_model->InsetTemplatedata();
		echo json_encode($data);
		return json_encode($data);
	}

	public function deleteTamplateData()
	{ // for tamplate form
		$TEMPLATE_ID = $this->input->post('id');
		$data = $this->m_react_test_model->DeleteTamplateData();
		echo json_encode($data);
		return json_encode($data);
	}


	public function upDateTamplateData()
	{ // for tamplate form
		$TEMPLATE_ID = $this->input->post('TEMPLATE_ID');
		$data = $this->m_react_test_model->UpDateTamplateData();
		echo json_encode($data);
		return json_encode($data);
	}

	public function totalBarcode()
	{

		$data = $this->m_react_test_model->TotalBarcode();
		echo json_encode($data);
		return json_encode($data);
	}



	public function pictureDone()
	{

		$data = $this->m_react_test_model->PictureDone();
		echo json_encode($data);
		return json_encode($data);
	}

	public function getBarcodeProcess()
	{

		$data = $this->m_react_test_model->GetBarcodeProcess();
		echo json_encode($data);
		return json_encode($data);
	}

	public function getActiveNotListed()
	{
		$data = $this->m_react_test_model->GetActiveNotListed();
		echo json_encode($data);
		return json_encode($data);
	}


	public function getSoldItem()
	{
		$data = $this->m_react_test_model->GetSoldItem();
		echo json_encode($data);
		return json_encode($data);
	}

	public function get_Awaiting_Shipment()
	{
		$data = $this->m_react_test_model->Get_Awaiting_Shipment();
		echo json_encode($data);
		return json_encode($data);
	}


	public function get_Shipped()
	{
		$data = $this->m_react_test_model->Get_Shipped();
		echo json_encode($data);
		return json_encode($data);
	}


	public function get_Users_List()
	{
		$data = $this->m_react_test_model->Get_Users_List();
		echo json_encode($data);
		return json_encode($data);
	}

	public function getitemReturned()
	{
		$data = $this->m_react_test_model->GetitemReturned();
		echo json_encode($data);
		return json_encode($data);
	}

	public function insert_Users_List()
	{
		$data = $this->m_react_test_model->Insert_Users_List();
		echo json_encode($data);
		return json_encode($data);
	}

	public function disable_And_Anable_Users_List()
	{
		$data = $this->m_react_test_model->disable_And_Anable_Users_List();
		echo json_encode($data);
		return json_encode($data);
	}


	public function update_Users_List()
	{
		$data = $this->m_react_test_model->Update_Users_List();
		echo json_encode($data);
		return json_encode($data);
	}

	public function get_merchant_detail()
	{
		$data = $this->m_react_test_model->Get_merchant_detail();
		echo json_encode($data);
		return json_encode($data);
	}


	public function get_merchant_Services_Type()
	{
		$data = $this->m_react_test_model->Get_merchant_Services_Type();
		echo json_encode($data);
		return json_encode($data);
	}


	public function get_merchant_City()
	{
		$data = $this->m_react_test_model->Get_merchant_City();
		echo json_encode($data);
		return json_encode($data);
	}

	public function insert_merchant_detail()
	{
		$data = $this->m_react_test_model->Insert_merchant_detail();
		echo json_encode($data);
		return json_encode($data);
	}

	public function update_merchant_detail()
	{
		$data = $this->m_react_test_model->Update_merchant_detail();
		echo json_encode($data);
		return json_encode($data);
	}

	public function delete_merchant_detail()
	{
		$data = $this->m_react_test_model->Delete_merchant_detail();
		echo json_encode($data);
		return json_encode($data);
	}

	public function insert_MyProfile()
	{
		$merchant_id = $this->input->post('merchant_id');
		$result = $this->m_react_test_model->check_merchant_id($merchant_id);

		if ($result) {

			$data = $this->m_react_test_model->Update_MyProfile();
			//  var_dump($data);
			echo json_encode($data);
			return json_encode($data);
		} else {

			$data = $this->m_react_test_model->Insert_MyProfile();
			echo json_encode($data);
			return json_encode($data);
		}
	}

	public function get_MyProfile()
	{
		$data = $this->m_react_test_model->Get_MyProfile();
		//  var_dump($data);
		echo json_encode($data);
		return json_encode($data);
	}
	/********************************
	 *  Screen US-PK Non Listed Items Controler
	 *********************************/
	public function get_employee() // employee dropDown
	{

		$data = $this->m_react_test_model->Get_employee();
		//  var_dump($data);
		echo json_encode($data);
		return json_encode($data);
	}
	public function load_identification_data()
	{

		$data = $this->m_react_test_model->load_identification_data();
		echo json_encode($data);
		return json_encode($data);
	}

	public function get_nonListedItems()  // get All nonlistedData at load timme
	{

		$data = $this->m_react_test_model->Get_nonListedItems();
		//  var_dump($data);
		echo json_encode($data);
		return json_encode($data);
	}


	public function get_Selectedemployee_Dropdown()  // get select employee
	{

		$data = $this->m_react_test_model->Get_Selectedemployee_Dropdown();
		//  var_dump($data);
		echo json_encode($data);
		return json_encode($data);
	}

	public function get_select_Radio_value()  // get All nonlistedData at load timme
	{

		$data = $this->m_react_test_model->Get_SearchData();
		//  var_dump($data);
		echo json_encode($data);
		return json_encode($data);
		//}
	}

	/********************************
	 *  Screen US-PK Non Listed Items Controler
	 *********************************/

	/********************************
	 *  start Screen DE-Kitting - U.S.
	 *********************************/
	public function last_ten_barcode()  // get select barcode
	{

		$data = $this->m_react_test_model->Last_ten_barcode();
		//  var_dump($data);
		echo json_encode($data);
		return json_encode($data);
	}

	public function get_master_Barcode()  // get select masterbarcode
	{

		$data = $this->m_react_test_model->Get_master_Barcode();
		//  var_dump($data);
		echo json_encode($data);
		return json_encode($data);
	}
	public function get_master_detail()  // get select barcode
	{

		$data = $this->m_react_test_model->Get_master_detail();
		//  var_dump($data);
		echo json_encode($data);
		return json_encode($data);
	}

	public function get_object_DrowpDown()  // get select barcode
	{

		$data = $this->m_react_test_model->Get_object_DrowpDown();
		//  var_dump($data);
		echo json_encode($data);
		return json_encode($data);
	}
	public function get_condition_DrowpDown()  // get select barcode
	{

		$data = $this->m_react_test_model->Get_condition_DrowpDown();
		//  var_dump($data);
		echo json_encode($data);
		return json_encode($data);
	}

	public function get_bin_DrowpDown()  // get select barcode
	{

		$data = $this->m_react_test_model->Get_bin_DrowpDown();
		//  var_dump($data);
		echo json_encode($data);
		return json_encode($data);
	}

	public function updateWeight()  // get select barcode
	{

		$data = $this->m_react_test_model->UpdateWeight();
		//  var_dump($data);
		echo json_encode($data);
		return json_encode($data);
	}

	public function updateDekittingRemarks()  // get select barcode
	{

		$data = $this->m_react_test_model->UpdateDekittingRemarks();
		//  var_dump($data);
		echo json_encode($data);
		return json_encode($data);
	}

	public function updateMasterDetial()  // get select barcode
	{
		$data = $this->m_react_test_model->UpdateMasterDetial();
		//  var_dump($data);
		echo json_encode($data);
		return json_encode($data);
	}
	public function deleteMasterDetail()
	{
		$data = $this->m_react_test_model->DeleteMasterDetail();
		//  var_dump($data);
		echo json_encode($data);
		return json_encode($data);
	}

	public function saveMasterDetail()
	{
		$data = $this->m_react_test_model->SaveMasterDetail();
		//  var_dump($data);
		echo json_encode($data);
		return json_encode($data);
	}

	public function print_us_pk()
	{
		$result = $this->m_react_test_model->print_us_pk();
		// var_dump($result);exit;
		$this->load->library('m_pdf');
		// to increse or decrese the width of barcode please set size attribute in barcode tag
		//$i = 0;
		foreach ($result as $data) {
			$text = $data["ITEM_DESC"];
			$item_desc = implode("<br/>", str_split($text, 40));
			$html = '<div style = "margin-left:-35px!important;">
					<div style="width:222px !important;" class="barcodecell"><barcode height="0.75" size="1.18" code="' . @$data["BAR_CODE"] . '" type="C128A" class="barcode" /></div>
				
				<div style="margin-top:6px !important;width:222px;padding:0;font-size:10px;font-family:arial;">
				<span><b>' .
				@$data["BAR_CODE"] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>' .
				@$data["OBJECT_NAME"] . '</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
				@$data["LOT_NO"] . '</b><br><span style="margin-top:3px!important; font-size:9px!important;font-family:arial;">' .
				@$item_desc . '</span><br>' .
				@$data["BARCODE_NO"] . '</span><br>' .

				//$newtext.
				'</span></div>
			  </div>';
			//generate the PDF from the given html
			$this->m_pdf->pdf->SetJS('this.print(false);');
			$this->m_pdf->pdf->WriteHTML($html);
			//$i++;
			// if(!empty($result[$i])){
			//   $this->m_pdf->pdf->AddPage();
			// }

		} //end foreach

		//download it.
		// $this->m_pdf->pdf->Output($pdfFilePath, "I");
	}


	public function print_all_us_pk()
	{


		// $item_code = $this->uri->segment(4);
		// $manifest_id = $this->uri->segment(5);
		// $barcode = $this->uri->segment(6);

		//$manifest_id = $this->input->post('manifest_id');
		//var_dump($manifest_id);exit;
		$result = $this->m_react_test_model->print_all_us_pk();
		// var_dump($result);exit;
		$this->load->library('m_pdf');
		// to increse or decrese the width of barcode please set size attribute in barcode tag
		$i = 0;
		foreach ($result as $data) {
			$text = $data["ITEM_DESC"];
			$item_desc = implode("<br/>", str_split($text, 40));
			$html = '<div style = "margin-left:-35px!important;">
					<div style="width:222px !important;" class="barcodecell"><barcode height="0.75" size="1.18" code="' . @$data["BAR_CODE"] . '" type="C128A" class="barcode" /></div>
				
				<div style="margin-top:6px !important;width:222px;padding:0;font-size:10px;font-family:arial;">
				<span><b>' .
				@$data["BAR_CODE"] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>' .
				@$data["OBJECT_NAME"] . '</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
				@$data["LOT_NO"] . '</b><br><span style="margin-top:3px!important; font-size:9px!important;font-family:arial;">' .
				@$item_desc . '</span><br>' .
				@$data["BARCODE_NO"] . '</span><br>' . '</span></div></div>';
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

	/********************************
	 *  start Screen DE-Kitting - U.S.
	 *********************************/

	/********************************
	 *  start Screen post Item returns
	 *********************************/
	public function displayBarcode()
	{
		$result = $this->m_react_test_model->displayBarcode();
		echo json_encode($result);
		return json_encode($result);
	}

	public function filter_data_item_return()
	{
		$result = $this->m_react_test_model->Filter_Data_Item_Return();
		echo json_encode($result);
		return json_encode($result);
	}
	public function save_data_manualy()
	{

		$merchantArray = [
			$insertchants = $this->input->post('selectMarchant2')
		];
		$data = $this->m_react_test_model->save_data_manualy($merchantArray);

		echo json_encode($data);
		return json_encode($data);
	}

	public function post_item_returns()
	{
		$result = $this->m_react_test_model->post_item_returns();
		// var_dump($result);
		// exit;
		echo json_encode($result);
		return json_encode($result);
	}
	public function reasonDrop()
	{
		$result = $this->m_react_test_model->reasonDrop();
		// var_dump($result);
		// exit;
		echo json_encode($result);
		return json_encode($result);
	}

	public function insertedDate()
	{
		$dataArray = [
			$insertdate = $this->input->post('searchdDate')
		];

		$data = $this->m_react_test_model->InsertedDate($dataArray);
		//  var_dump($data);
		echo json_encode($data);
		return json_encode($data);
	}

	public function process_Return()
	{

		$data = $this->m_react_test_model->Process_Return();
		//$this->print_barcode();
		//  var_dump($data);
		echo json_encode($data);
		return json_encode($data);
	}
	public function undo_data()
	{

		$data = $this->m_react_test_model->undo_data();
		//$this->print_barcode();
		//  var_dump($data);
		echo json_encode($data);
		return json_encode($data);
	}
	public function get_location()
	{
		$data = $this->m_react_test_model->Get_location();
		//  var_dump($data);
		echo json_encode($data);
		return json_encode($data);
	}

	public function sellerDrop()
	{
		$data = $this->m_react_test_model->SellerDrop();
		//  var_dump($data);
		echo json_encode($data);
		return json_encode($data);
	}

	public function downlaodReturns()
	{
		$data = $this->m_react_test_model->DownlaodReturns();
		//  var_dump($data);
		echo json_encode($data);
		return json_encode($data);
	}

	public function print_barcode()
	{

		$result = $this->m_react_test_model->printBarcode();
		$this->load->library('m_pdf');

		$i = 0;
		foreach ($result as $data) {

			$text = $data["ITEM_DESC"];
			$item_desc = implode("<br/>", str_split($text, 40));
			//$lot_desc = implode("<br/>", str_split($data['LOT_DESC'], 40));
			$html = '<div style = "margin-left:-35px!important;">
                <div style="width:222px !important;" class="barcodecell"><barcode height="0.75" size="1.18" code="' . @$data["BARCODE_NO"] . '" type="C128A" class="barcode" /></div>

            <div style="margin-top:6px !important;width:222px;padding:0;font-size:10px;font-family:arial;">
            <span><b>' .
				@$data["BARCODE_NO"] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>' .
				@$data["R_BAR"] . '</u>&nbsp;&nbsp;<br></b>' .
				@$data['UPC'] . '</span><br>
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
		// $this->m_pdf->pdf->Output($pdfFilePath, "I");
	}
	public function FiterDeta_radio()
	{
		$result = $this->m_react_test_model->FiterDeta_radio();
		echo json_encode($result);
		return json_encode($result);
	}
	/********************************
	 *  end Screen post Item returns
	 *********************************/
	/********************************
	 * START  Screen invoices by tayyab
	 *********************************/
	public function insert_payment_detail()
	{
		$result = $this->m_react_test_model->insert_payment_detail();
		echo json_encode($result);
		return json_encode($result);
	}

	public function get_Receipt_no()
	{
		$result = $this->m_react_test_model->get_Receipt_no();
		echo json_encode($result);
		return json_encode($result);
	}

	/********************************
	 * START  Screen invoices by tayyab
	 *********************************/
	// /********************************
	//  * START  barcodeIMAGE firbase
	//  *********************************/
	public function get_barcode_detail()
	{
		$result = $this->m_react_test_model->get_barcode_detail();
		echo json_encode($result);
		return json_encode($result);
	}
	public function get_all_barcode()
	{
		$result = $this->m_react_test_model->get_all_barcode();
		echo json_encode($result);
		return json_encode($result);
	}
	// /********************************
	//  * end  barcodeIMAGE firbase
	//  *********************************/



	// /********************************
	//  *  START Screen Lister View
	//  *********************************/
	public function lister_view()
	{
		$result = $this->m_react_test_model->lister_view();
		echo json_encode($result);
		return json_encode($result);
	}
	public function sum_total_listing()
	{
		$result = $this->m_react_test_model->sum_total_listing();
		echo json_encode($result);
		return json_encode($result);
	}
	public function ListerUsers()
	{
		$result = $this->m_react_test_model->ListerUsers();
		echo json_encode($result);
		return json_encode($result);
	}
	public function filter_data()
	{
		$dataArray = [
			$insertdate = $this->input->post('date')
		];

		$result = $this->m_react_test_model->filter_data($dataArray);
		echo json_encode($result);
		return json_encode($result);
	}
	public function price_fiter()
	{
		$dataArray = [
			$insertdate = $this->input->post('date')
		];
		$result = $this->m_react_test_model->price_fiter($dataArray);
		echo json_encode($result);
		return json_encode($result);
	}


	// /********************************
	//  *  end Screen Lister View
	//  *********************************/


	// /********************************
	//  * start Screen add info
	//  *********************************/
	public function Filter_Data_Item_Return_add_info()
	{
		$result = $this->m_react_test_model->Filter_Data_Item_Return_add_info();
		echo json_encode($result);
		return json_encode($result);
	}
	public function add_tracking_no()
	{
		$result = $this->m_react_test_model->add_tracking_no();
		echo json_encode($result);
		return json_encode($result);
	}
	public function local_pic_up()
	{
		$result = $this->m_react_test_model->local_pic_up();
		echo json_encode($result);
		return json_encode($result);
	}

	// /********************************
	//  * start Screen add info
	//  *********************************/

	// /********************************
	//  * start Screen call log
	//  *********************************/
	public function form_state()
	{
		$result = $this->m_react_test_model->Get_State();
		echo json_encode($result);
		return json_encode($result);
	}
	public function call_log_save()
	{
		$result = $this->m_react_test_model->Call_log_save();
		echo json_encode($result);
		return json_encode($result);
	}
	public function call_log_save_all()
	{
		$result = $this->m_react_test_model->call_log_save_all();
		echo json_encode($result);
		return json_encode($result);
	}
	public function Get_State_single()
	{
		$result = $this->m_react_test_model->Get_State_single();
		echo json_encode($result);
		return json_encode($result);
	}
	public function Get_City_single()
	{
		$result = $this->m_react_test_model->Get_City_single();
		echo json_encode($result);
		return json_encode($result);
	}
	public function delete_log()
	{
		$result = $this->m_react_test_model->delete_log();
		echo json_encode($result);
		return json_encode($result);
	}
	public function update_call_log()
	{
		$result = $this->m_react_test_model->update_call_log();
		echo json_encode($result);
		return json_encode($result);
	}
	// /************0000000000000000000*********
	//  * start Screen call log
	//  *********************************/
	// /********************************
	//  * start Screen listed barcode
	//  *********************************/
	public function get_offerUp()
	{
		$result = $this->m_react_test_model->get_offerUp();
		echo json_encode($result);
		return json_encode($result);
	}
	public function Get_listed_barcode()
	{
		$result = $this->m_react_test_model->Get_listed_barcode();
		echo json_encode($result);
		return json_encode($result);
	}
	public function Get_Image_DecodeBase64()
	{
		$result = $this->m_react_test_model->Get_Image_DecodeBase64();
		echo json_encode($result);
		return json_encode($result);
	}
	public function get_conditionArray()
	{
		$result = $this->m_react_test_model->get_conditionArray();
		echo json_encode($result);
		return json_encode($result);
	}
	public function Save_listed_barcode()
	{
		$result = $this->m_react_test_model->Save_listed_barcode();
		echo json_encode($result);
		return json_encode($result);
	}
	public function get_listed_barcode_all()
	{
		$result = $this->m_react_test_model->get_listed_barcode_all();
		echo json_encode($result);
		return json_encode($result);
	}
	public function Save_marcket_place()
	{
		$result = $this->m_react_test_model->Save_marcket_place();
		echo json_encode($result);
		return json_encode($result);
	}
	public function Save_marcket_place_as_sold()
	{
		$result = $this->m_react_test_model->Save_marcket_place_as_sold();
		echo json_encode($result);
		return json_encode($result);
	}
	public function to_check_list_id()
	{
		$result = $this->m_react_test_model->to_check_list_id();
		echo json_encode($result);
		return json_encode($result);
	}
	// /********************************
	//  * end Screen listed Barcode
	//  *********************************/

	// /********************************
	//  * start Screen Serach Barcode
	//  *********************************/
	public function Get_filter_barcode()
	{
		$result = $this->m_react_test_model->Get_filter_barcode();
		echo json_encode($result);
		return json_encode($result);
	}
	public function endItem()
	{
		$ebay_id = $this->input->post('Ebayid');
		$remarks = $this->input->post('Remarks');
		$result['ebay_id'] = $ebay_id;
		$result['remarks'] = $remarks;

		$get_seller = $this->db->query("SELECT E.LZ_SELLER_ACCT_ID, A.ACCOUNT_NAME SELL_ACCT_DESC , S.EBAY_LOCAL FROM EBAY_LIST_MT E, LJ_MERHCANT_ACC_DT A , LZ_ITEM_SEED S WHERE A.ACCT_ID = E.LZ_SELLER_ACCT_ID AND S.SEED_ID = E.SEED_ID AND E.EBAY_ITEM_ID =  '$ebay_id' AND ROWNUM = 1")->result_array();
		$account_name = @$get_seller[0]['LZ_SELLER_ACCT_ID'];

		if (!empty(@$get_seller[0]['EBAY_LOCAL'])) {
			$site_id = @$get_seller[0]['EBAY_LOCAL'];
		} else {
			$site_id = 0;
		}
		$result['site_id'] = $site_id;
		if (!empty(@$account_name)) {
			$result['account_name'] = $account_name;
		}


		//  $data = $this->load->view('ebay/trading/endItem',$result);
		if ($result) {
			$result = $this->m_react_test_model->endItem();
			$data['response'] = $this->m_react_test_model->deleteItemfromShopify($ebay_id);
			//End item from Shopify

		}
		echo json_encode($result);
		return json_encode($result);
	}

	public function holdBarcode(){
		$data = $this->m_react_test_model->holdBarcode();
		echo json_encode($data);
		return json_encode($data);    
	
	  }
	  public function unHoldBarcode(){
		$data = $this->m_react_test_model->unHoldBarcode();
		echo json_encode($data);
		return json_encode($data);    
	
	  }
	  public function updateItemQty(){

		$ebay_id = trim($this->input->post('Ebayid'));
		$remarks = trim($this->input->post('Remarks'));
		$adj_barcode = trim($this->input->post('redioSearch'));
		$adj_qty = trim($this->input->post('Qty'));
		$user_id = trim($this->input->post('user_id'));
		$get_seller_acct = $this->db->query("SELECT * FROM (SELECT E.LZ_SELLER_ACCT_ID,S.EBAY_LOCAL FROM EBAY_LIST_MT E, LZ_ITEM_SEED S WHERE E.EBAY_ITEM_ID = '$ebay_id'AND S.SEED_ID = E.SEED_ID AND UPPER(E.STATUS) = 'ADD' ORDER BY E.LIST_ID DESC) WHERE  ROWNUM = 1")->result_array();
		if(count($get_seller_acct) > 0){
		  $account_id = @$get_seller_acct[0]['LZ_SELLER_ACCT_ID'];
		  $site_id = @$get_seller_acct[0]['EBAY_LOCAL'];
		}else{
		  $get_seller = $this->db->query("SELECT * FROM (SELECT E.LZ_SELLER_ACCT_ID,S.EBAY_LOCAL FROM EBAY_LIST_MT E, LZ_ITEM_SEED S WHERE E.EBAY_ITEM_ID = '$ebay_id' AND S.SEED_ID = E.SEED_ID ORDER BY E.LIST_ID DESC) WHERE  ROWNUM = 1")->result_array(); 
		  $account_id = @$get_seller[0]['LZ_SELLER_ACCT_ID'];
		  $site_id = @$get_seller[0]['EBAY_LOCAL'];      
		}
	
	
		if(empty($account_id)){
		  $get_seller = $this->db->query("SELECT E.LZ_SELLER_ACCT_ID FROM EBAY_LIST_MT E WHERE E.EBAY_ITEM_ID = '$ebay_id' AND ROWNUM=1")->result_array(); 
		  $account_id = @$get_seller[0]['LZ_SELLER_ACCT_ID'];
		  $site_id = 0;      
		}
		if(empty($account_id)){
		   $data = "Account id against this ebay Id:".$ebay_id. " is Not Found in system.";
		   //$data = 1;
		   echo json_encode($data);
		   return json_encode($data);
		   exit;
		}
		$data['ebay_id'] = $ebay_id;
		$data['site_id'] = $site_id;
		$data['quantity'] = $adj_qty;
		$data['account_name'] = $account_id;// used in configuration.php
		$data['addQty'] = 1;// used in less qty call
	  // $this->load->view('ebay/trading/reviseItemPrice',$data);
	//    $current_qty_adj = $this->session->userdata('current_qty_adj');
	//    $this->session->unset_userdata('current_qty_adj');
	   if($data === -1){
		$data1= $this->db->query("CALL PRO_ADJEBAYQTY($ebay_id, '$adj_barcode', $adj_qty, $user_id, '$remarks')"); 
		return array('data'=>$data1, 'status'=>true);
	   }
		echo json_encode($data);
		return json_encode($data);
	  }
	// /********************************
	//  * end Screen Search Barcode
	//  *********************************/
}
