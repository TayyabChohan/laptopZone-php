<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* Order Pulling Controller
	*/
class C_Order_Pulling extends CI_Controller
{
		
	public function __construct(){
		parent::__construct();
		$this->load->database();
	    if(!$this->loginmodel->is_logged_in())
	     {
	       redirect('login/login/');
	     }		
	}

	public function index(){

		$status = $this->session->userdata('login_status');
		$login_id = $this->session->userdata('user_id');
		if(@$login_id && @$status == TRUE)
		{
			if($this->input->post('Submit')){
				//var_dump('from submit');
				$radio = $this->input->post('awaiting');
				$data['awaiting_pull'] = $this->m_order_pulling->order_details($radio);
				//$data['partially_pulled'] = $this->m_order_pulling->partially_pulled();
				//$data['pulled'] = $this->m_order_pulling->pulled();
				$data['summary'] = $this->m_order_pulling->order_summary();
				$data['pageTitle'] = 'Order Pulling';
				$this->load->view('order_pulling/v_order_pulling', $data);

			}else{
				$radio = NULL;
				$data['awaiting_pull'] = $this->m_order_pulling->order_details($radio);
				//$data['partially_pulled'] = $this->m_order_pulling->partially_pulled();
				//$data['pulled'] = $this->m_order_pulling->pulled();
				$data['summary'] = $this->m_order_pulling->order_summary();
				$data['pageTitle'] = 'Order Pulling';
				$this->load->view('order_pulling/v_order_pulling', $data);
			}

			
			//var_dump($data);exit;

			//$this->load->view('order_pulling/v_order_pulling');

		}else{
			redirect('login/login/');
		}

	}
	public function get_data(){
		$pull_barcode = $this->input->post('pull_barcode');
		$data = $this->m_order_pulling->get_data($pull_barcode);
		echo json_encode($data);//exit;
   		return json_encode($data);
		

	}
	public function partial_data(){
		$status = $this->session->userdata('login_status');
		$login_id = $this->session->userdata('user_id');
		if(@$login_id && @$status == TRUE)
		{
			if($this->input->post('search')){
				$radio = $this->input->post('awaiting');
				$data['partially_pulled'] = $this->m_order_pulling->partially_pulled();
				$data['summary'] = $this->m_order_pulling->partial_summary();
				$data['pageTitle'] = 'Partially Pulled Order';
				$this->load->view('order_pulling/v_order_partial_pull', $data);
			}else{
				$radio = NULL;
				$data['partially_pulled'] = $this->m_order_pulling->partially_pulled();
				$data['summary'] = $this->m_order_pulling->partial_summary();
				$data['pageTitle'] = 'Partially Pulled Order';
				$this->load->view('order_pulling/v_order_partial_pull', $data);
			}

		}else{
			redirect('login/login/');
		}
		

	}
	public function  pulled_data(){
		$status = $this->session->userdata('login_status');
		$login_id = $this->session->userdata('user_id');
		if(@$login_id && @$status == TRUE)
		{
			if($this->input->post('search')){
				$radio = $this->input->post('awaiting');
				$data['pulled'] = $this->m_order_pulling->pulled();
				$data['summary'] = $this->m_order_pulling->pulled_summary();
				$data['pageTitle'] = 'Pulled Order';
				$this->load->view('order_pulling/v_order_pulled', $data);
			}else{
				$radio = NULL;
				$data['pulled'] = $this->m_order_pulling->pulled();
				$data['summary'] = $this->m_order_pulling->pulled_summary();
				$data['pageTitle'] = 'Pulled Order';
				$this->load->view('order_pulling/v_order_pulled', $data);
			}

		}else{
			redirect('login/login/');
		}
		

	}
	public function pull_cancel(){
		$data = $this->m_order_pulling->pull_cancel();
		echo json_encode($data);
   		return json_encode($data);
	}
	public function save_print(){
		$order_no = $this->input->post('order_no');
		$unit = $this->input->post('unit');
		$weight = $this->input->post('weight');
		//var_dump($order_no,$unit,$weight);exit;
		$data = $this->m_order_pulling->save_print($order_no,$unit,$weight);
//var_dump($data[0]["SALES_RECORD_NO"]);exit;
		// echo '<div style="width:100%;margin:0px;padding:0px;text-align:center;"><span style="margin:0px;width:216px;padding:0px;font-size:18px;font-family:arial; text-align:center;">'.
		// 				@$data[0]["SALES_RECORD_NO"].'<br>'.
		// 				@$data[0]["WEIGHT"].'<br>'.
		// 			'</span><br>'.
		// 			'<div style="width:100px!important;float:left!important;font-size:16px;font-family:arial;">
		// 				'.@$data[0]["EBAY_ID"].'</div>
		// 				<div style="width:100px!important;float:right!important;font-size:16px;font-family:arial;">'.@$data[0]["PULLING_DATE"].'</div></div>';

		// $this->load->library('Pdf');
		// // $pdf = new CUSTOMPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
		// // //Add a custom size  
		// // $width = 175;  
		// // $height = 266; 
		// // $orientation = ($height>$width) ? 'P' : 'L';  
		// // $pdf->addFormat("custom", $width, $height);  
		// // $pdf->reFormat("custom", $orientation); 

		// // $this->load->library('Pdf');
		//  $pdf = new Pdf('P', 'mm', 'A6', true, 'UTF-8', false);
		// $pdf->SetTitle('Print Sticker');
		// $pdf->SetHeaderMargin(0);
		// $pdf->SetTopMargin(0);
		// $pdf->setFooterMargin(0);
		// $pdf->SetAutoPageBreak(true);
		// $pdf->SetPrintHeader(false);
		// $pdf->SetAuthor(PDF_CREATOR);
		// $pdf->SetSubject('TCPDF Tutorial');
		// $pdf->SetDisplayMode('real', 'default');
		// $pdf->SetMargins(2, 4, 0, true);
		// $pdf->AddPage();
		// //$text = @$data["SALES_RECORD_NO"];
		// //$newtext =implode("<br/>", str_split($text, 40));@$data[0]["WEIGHT"]
		// //$newtext = wordwrap($text, 40, "<br>", true);
		// //var_dump($data[0]["UOM_ID"]);exit;
		// if(@$data[0]["UOM_ID"] == 134){
		// 	$unit = ' lbs';
		// }else{
		// 	$unit = ' ozs';
		// }
		// //$unit * @$data[0]["PULLING_QTY"]
		// $html ='<div style="width:100%;margin:0px;padding:0px;"><span style="margin:0px;width:216px;padding:0px;font-size:20px;font-family:arial;font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.
		// 				@$data[0]["SALES_RECORD_NO"].'</span><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		// 				<span style="margin:0px;width:216px;padding:0px;font-size:18px;font-family:arial;">'.(@$data[0]["WEIGHT"]*@$data[0]["PULLING_QTY"]).$unit.'<br><br>'.
		// 			'</span><br>'.
		// 			'<div style="font-size:18px;font-family:arial;">
		// 				&nbsp;&nbsp;'.@$data[0]["EBAY_ID"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.@$data[0]["PULLING_DATE"].'</div>';
		// $pdf->writeHTML($html, true, false, true, false, '');
		// $pdf->Output(@$data[0]['SALES_RECORD_NO'].'.pdf', 'I');
/*========================================
=            mpdf code added             =
========================================*/
$this->load->library('m_pdf');
			// to increse or decrese the width of barcode please set size attribute in barcode tag
          
            // $text = $data["ITEM_DESC"];
            // $item_desc =implode("<br/>", str_split($text, 40));
	    	$this->m_pdf->pdf->SetTitle(@$row[0]["EBAY_ID"]);
            
			//$newtext = wordwrap($text, 40, "<br>", true);
			if(@$data[0]["UOM_ID"] == 134){
			$unit = ' lbs';
		}else{
			$unit = ' Oz';
		}
		//$unit * @$data[0]["PULLING_QTY"]
		$html ='<div style="width:100%;margin:0px;padding:0px;"><div style="width:150px !important;" class="barcodecell"><barcode height="1.00" size="1.50" code="'.@$data[0]["SALES_RECORD_NO"].'" type="C128A" class="barcode" /></div><span style="margin:0px;width:216px;padding:0px;font-size:20px;font-family:arial;font-weight:bold;">&nbsp;&nbsp;&nbsp;Order No: '.
						@$data[0]["SALES_RECORD_NO"].'</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<span style="margin:0px;width:216px;padding:0px;font-size:18px;font-family:arial;">'.@$data[0]["PULLING_DATE"].'<br><br>'.
					'</span>'.
					'<div style="font-size:18px;font-family:arial;">
						&nbsp;&nbsp;&nbsp;ID: '.@$data[0]["EBAY_ID"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.(@$data[0]["WEIGHT"]*@$data[0]["PULLING_QTY"]).$unit.'</div>';
          	//var_dump($html);exit;  
            //generate the PDF from the given html
            $this->m_pdf->pdf->WriteHTML($html);
          
        	//download it.
        	$this->m_pdf->pdf->Output($pdfFilePath, "I");


/*=====  End of mpdf code added   ======*/

	}


	
}
 ?>