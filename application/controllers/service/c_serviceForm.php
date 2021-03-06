<?php

	class C_ServiceForm extends CI_Controller{
		public function __construct(){
			parent::__construct();
			$this->load->database();
			$this->load->model('service/m_serviceForm');
			$this->load->model('service/m_serviceReceipt');
		    if(!$this->loginmodel->is_logged_in())
		      {
		        redirect('login/login/');
		      } 
		}
		public function showEquipment(){
			$data['pageTitle'] = 'Equipment Form';
			$this->load->view('service/v_equipment',$data);
		}

		public function addEquipment(){
			if($this->input->post('equip_save')){
				$this->m_serviceForm->addEquipment();
				return redirect('service/c_serviceForm/showEquipment');
			}
			
			else{
				return redirect('service/c_serviceForm/showEquipment');
			}
			
		}
		public function serviceView(){
			$data['component'] = $this->m_serviceForm->selectComponent();
			$data['equipment'] = $this->m_serviceForm->selectEquipment();
			$data['doc_no'] = $this->m_serviceForm->serviceDocNo();
			$data['data'] = $this->m_serviceForm->cityStateList();
			$data['pageTitle'] = 'Service Form';
			$this->load->view('service/v_serviceForm',$data);
		}
		
		public function addService(){

			if($this->input->post('saveService')){
				$lz_serv_mt_id = $this->m_serviceForm->addServiceRecord();
				$result['doc_no'] = $this->m_serviceForm->serviceDocNo();
				$result['data'] = $this->m_serviceForm->cityStateList();
				// $result['component'] = $this->m_serviceReceipt->receiptComponent();

				$result['component'] = $this->m_serviceForm->selectComponent();
				date_default_timezone_set("America/Chicago");
		        $print_date = date("m/d/Y H:i A ");
		        //var_dump($print_date);exit;

		        $concatDate = date("m/d/Y");
		        // var_dump($concatDate);exit;
		        $result = $this->m_serviceReceipt->printInvoice($lz_serv_mt_id);
		        $componentResult = $this->m_serviceReceipt->receiptComponent($lz_serv_mt_id);
				// var_dump($this->input->post('quantity'));exit;

				$header = '<style media="print"> @page {size: auto; margin: 0; } </style><!doctype html> <html class="no-js" lang=""> <head> <meta charset="utf-8"> <meta http-equiv="x-ua-compatible" content="ie=edge"> <title>Print Invoice</title> <meta name="description" content=""> <meta name="viewport" content="width=device-width, initial-scale=1"> </head> <body><div style="width: 280px !important;margin:0px !important;"> <div style="width: 138px;float:left;font-size:12px;font-family: arial;">'.@$print_date.'</div> <div style="width: 138px;float:right;font-size:12px;font-family: arial;"> <b>Sale Receipt #'.@$result[0]["DOC_NO"].'</b> </div> <div style="padding: 2px;font-size:12px;font-family: arial;">Store: 1</div> <div style="text-align: center;font-size: 20px; font-weight: bold; font-family: arial;padding: 3px;">LaptopZone</div> <div style="font-size:12px;font-weight: normal;font-family: arial;text-align: center;">2720 Royal Ln Suite 180<br> Dallas TX 75229<br> (214) 427-4496 </div><br><table> <thead> <tr style="font-size:12px !important;border-bottom: 1px solid #000 !important;font-family: arial;"> <th style="border-bottom-style: solid; border-bottom: 1px solid #000 !important;">Item Name</th> <th style="border-bottom-style: solid; border-bottom: 1px solid #000 !important;">Qty</th> <th style="border-bottom-style: solid; border-bottom: 1px solid #000 !important;">Price</th> <th style="border-bottom-style: solid; border-bottom: 1px solid #000 !important;">Ext Price</th> </tr></thead> <tbody> ';

		        $html = '';
		        $sum_price = 0;
		        $sum_disc_amt = $result[0]['DISC_AMT'];
		        $sum_qty = 0;
		        $serviceCharges = $result[0]['SERVICE_CHARGES'];
		        $advance = $result[0]['ADVANCE_AMT'];
			  $i =0;
			   foreach($result as $data){

	            	$compId = $lz_serv_mt_id;
	            	$compId2 = $componentResult[$i]['LZ_SERV_MT_ID'];
	            	$item = $componentResult[$i]['LZ_COMPONENT_DESC'];
	            	if($compId == $compId2){
		            		
			            // var_dump($compIdx);exit;
			            $qty = $data['QTY'];
			            $price = $data['DET_PRICE'];
			            $single = $price/$qty; // price for single quantity of item
			            $price = '$'.number_format((float)@$data['DET_PRICE'],2,'.',',');
			            
			            $html .='<tr style="font-size:12px !important;font-family: arial;"> <td><div style="width:120px;">'.@$item.'</div></td> <td><span style="float:right;margin-right:15px;">'.@$data["QTY"].'</span></td> <td>'.$single.'</td> <td>'.$price.'</td> </tr>'; 
			            $sum_price  = $sum_price + $data['DET_PRICE'];

			            // $sum_disc_amt  = $sum_disc_amt + $data['DISC_AMT'];
			            $sum_qty  = $sum_qty + $data['QTY'];
			            //generate the PDF from the given html
			            //echo $html;exit;
	            	}//endIf
		        
	            	$i++;
		    	}//End Foreach
		    		    		          //var_dump($sum_price);exit;
	          $total = $sum_price +$serviceCharges - $sum_disc_amt;
	          $pay_mode = @$result[0]['PAY_MODE'];
	          $sales_tax = ($total/100)*@$result[0]['DET_SALES_TAX'];
	          $sales_tax = number_format((float)@$sales_tax,2,'.',',');

	          $receipt_total = $total + $sales_tax;
	          $receipt_total = number_format((float)@$receipt_total,2,'.',',');
	          $rcpt_total = '';
	          if($pay_mode == "C"){
	          	$rcpt_total = "Cash: $".$advance; 

	          }elseif($pay_mode == "R"){
	          	$rcpt_total = "Credit: $".$advance;
	          }

	          // $con = implode($print_date);
	          $barDate =str_replace('/', '', $concatDate);
	          // var_dump($barDate);exit;
	          $str1 = substr($barDate,0,4);
	          $str2 = substr($barDate,6,8);
	          $docDateStr = $str1.$str2;
	          $remaining = $receipt_total - $advance;
	          $remaining = number_format((float)@$remaining,2,'.',',');

	         $footer = '<tr style="font-size:12px !important;font-family: arial;"> <td style="border-top-style: solid; border-top: 1px solid #000 !important;"></td> <td style="border-top-style: solid; border-top: 1px solid #000 !important;"><span style="float:right;margin-right:15px;">Qty: '.$sum_qty.'</span></td> <td style="border-top-style: solid; border-top: 1px solid #000 !important;"><b>Subtotal:</b></td> <td style="border-top-style: solid; border-top: 1px solid #000 !important;">'.'$'.$sum_price.'</td> </tr><tr style="font-size:12px !important;font-family: arial;"><td></td> <td></td> <td>Disc Amount:</td> <td>'.'$'.$sum_disc_amt.'</td></tr><tr style="font-size:12px !important;font-family: arial;"> <td></td><td></td>  <td >Service Charges:</td> <td>'.'$'.$serviceCharges.'</td> </tr><tr style="font-size:12px !important;font-family: arial;"><td></td> <td></td> <td><b>Total:</b></td> <td>'.'$'.$total.'</td></tr><tr style="font-size:12px !important;font-family: arial;"> <td></td><td></td>  <td >Advance Amount:</td> <td><b>'.'$'.$advance.'</b></td> </tr> <tr style="font-size:12px !important;font-family: arial;"> <td></td> <td>Exempt</td> <td>0 % Tax:</td> <td>+ '.'$'.$sales_tax.'</td> </tr> <tr style="font-size:12px !important;font-family: arial;"> <td></td>  <td colspan="2"><b>GRAND TOTAL:</b></td> <td><b>'.'$'.$receipt_total.'</b></td> </tr><tr style="font-size:12px !important;font-family: arial;"> <td></td> <td><div style="width:90px;">'.$rcpt_total.'</div></td> <td></td> <td></td> </tr><tr style="font-size:12px !important;font-family: arial;"> <td></td>  <td colspan="2"><b>Remaining:</b></td> <td><b>'.'$'.$remaining.'</b></td> </tr> <tr style="font-size:12px !important;font-family: arial;"> <td></td> <td><div style="width:90px;"></div></td> <td></td> <td></td> </tr> </tbody> </table><br> <div style="text-align:center;margin:5px;font-size: 12px;font-weight: normal;font-family: arial;">Thanks for shopping with us!</div> <div style="margin:5px;text-align:center;margin:5px;font-size: 12px;font-weight: normal;font-family: arial;"><img style="margin-bottom:3px;width: 200px;" alt="pos_barcode" src="'.base_url().'assets/barcode/barcode.php?text='.@$result[0]["DOC_NO"].'"/><div style="margin:5px;text-align:center;margin:5px;font-size: 12px;font-weight: normal;font-family: arial;">'.@$result[0]["DOC_NO"].'-'.$docDateStr.'</div> </div></body> </html>';
         	 echo $header.$html.$footer;

			}

			else{
				return redirect('service/c_serviceForm/serviceView');
			}
		}

		public function returnShowForm(){
			$result['pageTitle'] = 'Service Return';
			$this->load->view('service/v_serviceReturn',$result);
		}

		public function returnFilledData(){
			$data = $this->m_serviceForm->returnFilledData();
			// $data['city'] = $this->m_point_of_sale->cityStateList();
		    echo json_encode($data);
		    return json_encode($data);
		}

		public function returnAddService(){
			if($this->input->post('saveService')){
				$lz_serv_mt_id = $this->m_serviceForm->returnAddService();
				$result['doc_no'] = $this->m_serviceForm->serviceDocNo();
				$result['data'] = $this->m_serviceForm->cityStateList();
				// $result['component'] = $this->m_serviceReceipt->receiptComponent();

				$result['component'] = $this->m_serviceForm->selectComponent();
				date_default_timezone_set("America/Chicago");
		        $print_date = date("m/d/Y H:i A ");
		        //var_dump($print_date);exit;

		        $concatDate = date("m/d/Y");
		        // var_dump($concatDate);exit;
		        $result = $this->m_serviceReceipt->printInvoice($lz_serv_mt_id);
		        $componentResult = $this->m_serviceReceipt->receiptComponent($lz_serv_mt_id);
				// var_dump($this->input->post('quantity'));exit;

				$header = '<style media="print"> @page {size: auto; margin: 0; } </style><!doctype html> <html class="no-js" lang=""> <head> <meta charset="utf-8"> <meta http-equiv="x-ua-compatible" content="ie=edge"> <title>Print Invoice</title> <meta name="description" content=""> <meta name="viewport" content="width=device-width, initial-scale=1"> </head> <body><div style="width: 280px !important;margin:0px !important;"> <div style="width: 138px;float:left;font-size:12px;font-family: arial;">'.@$print_date.'</div> <div style="width: 138px;float:right;font-size:12px;font-family: arial;"> <b>Sale Receipt #'.@$result[0]["DOC_NO"].'</b> </div> <div style="padding: 2px;font-size:12px;font-family: arial;">Store: 1</div> <div style="text-align: center;font-size: 20px; font-weight: bold; font-family: arial;padding: 3px;">LaptopZone</div> <div style="font-size:12px;font-weight: normal;font-family: arial;text-align: center;">2720 Royal Ln Suite 180<br> Dallas TX 75229<br> (214) 427-4496 </div><br><table> <thead> <tr style="font-size:12px !important;border-bottom: 1px solid #000 !important;font-family: arial;"> <th style="border-bottom-style: solid; border-bottom: 1px solid #000 !important;">Item Name</th> <th style="border-bottom-style: solid; border-bottom: 1px solid #000 !important;">Qty</th> <th style="border-bottom-style: solid; border-bottom: 1px solid #000 !important;">Price</th> <th style="border-bottom-style: solid; border-bottom: 1px solid #000 !important;">Ext Price</th> </tr></thead> <tbody> ';

		        $html = '';
		        $sum_price = 0;
		        $sum_disc_amt = $result[0]['DISC_AMT'];
		        $sum_qty = 0;

			  $i =0;
			   foreach($result as $data){

	            	$compId = $lz_serv_mt_id;
	            	$compId2 = $componentResult[$i]['LZ_SERV_MT_ID'];
	            	$item = $componentResult[$i]['LZ_COMPONENT_DESC'];
	            	if($compId == $compId2){
		            		
			            // var_dump($compIdx);exit;
			            $qty = $data['QTY'];
			            $price = $data['DET_PRICE'];
			            $single = $price/$qty;
			            $price = '$'.number_format((float)@$data['DET_PRICE'],2,'.',',');
			            
			            $html .='<tr style="font-size:12px !important;font-family: arial;"> <td><div style="width:120px;">'.@$item.'</div></td> <td><span style="float:right;margin-right:15px;">'.@$data["QTY"].'</span></td> <td>'.$single.'</td> <td>'.$price.'</td> </tr>'; 
			            $sum_price  = $sum_price + $data['DET_PRICE'];

			            // $sum_disc_amt  = $data['DISC_AMT']; 
			            $sum_qty  = $sum_qty + $data['QTY'];
			            //generate the PDF from the given html
			            //echo $html;exit;
	            	}//endIf
		        
	            	$i++;
		    	}//End Foreach
		    		    		          //var_dump($sum_price);exit;
		      $serviceCharges = $result[0]['SERVICE_CHARGES'];
		      $advance = $result[0]['ADVANCE_AMT'];
	          $total = $sum_price +$serviceCharges - $sum_disc_amt;
	          $pay_mode = $result[0]['RET_PAY_MODE'];
	          // var_dump($pay_mode);exit;
	          $sales_tax = ($total/100)*@$result[0]['DET_SALES_TAX'];
	          // var_dump($sales_tax);
	          $sales_tax = number_format((float)@$sales_tax,2,'.',',');

	          $receipt_total = $total + $sales_tax;
	          $receipt_total = number_format((float)@$receipt_total,2,'.',',');
	          // $rcpt_total = '';
	          $remaining = $receipt_total - $advance;
	          $remaining = number_format((float)@$remaining,2,'.',',');
	          if($pay_mode == "C"){
	          	$rcpt_total = "Cash: $".$remaining; 

	          }elseif($pay_mode == "R"){
	          	$rcpt_total = "Credit: $".$remaining;
	          }

	          // $con = implode($print_date);
	          $barDate =str_replace('/', '', $concatDate);
	          // var_dump($barDate);exit;
	          $str1 = substr($barDate,0,4);
	          $str2 = substr($barDate,6,8);
	          $docDateStr = $str1.$str2;

	          
	        $footer = '<tr style="font-size:12px !important;font-family: arial;"> <td style="border-top-style: solid; border-top: 1px solid #000 !important;"></td> <td style="border-top-style: solid; border-top: 1px solid #000 !important;"><span style="float:right;margin-right:15px;">Qty: '.$sum_qty.'</span></td> <td style="border-top-style: solid; border-top: 1px solid #000 !important;"><b>Subtotal:</b></td> <td style="border-top-style: solid; border-top: 1px solid #000 !important;">'.'$'.$sum_price.'</td> </tr><tr style="font-size:12px !important;font-family: arial;"><td></td> <td></td> <td>Disc Amount:</td> <td>'.'$'.$sum_disc_amt.'</td></tr><tr style="font-size:12px !important;font-family: arial;"> <td></td><td></td>  <td >Advance Amount:</td> <td><b>'.'$'.$advance.'</b></td> </tr><tr style="font-size:12px !important;font-family: arial;"><td></td> <td></td> <td><b>Total:</b></td> <td>'.'$'.$total.'</td></tr> <tr style="font-size:12px !important;font-family: arial;"> <td></td> <td>Exempt</td> <td>0 % Tax:</td> <td>+ '.'$'.$sales_tax.'</td> </tr> <tr style="font-size:12px !important;font-family: arial;"> <td></td>  <td colspan="2"><b>GRAND TOTAL:</b></td> <td><b>'.'$'.$receipt_total.'</b></td> </tr><tr style="font-size:12px !important;font-family: arial;"> <td></td>  <td colspan="2"><b>Remaining:</b></td> <td><b>'.'$'.$remaining.'</b></td> </tr><tr style="font-size:12px !important;font-family: arial;"> <td></td> <td><div style="width:90px;">'.$rcpt_total.'</div></td> <td></td> <td></td> </tr> <tr style="font-size:12px !important;font-family: arial;"> <td></td> <td><div style="width:90px;"></div></td> <td></td> <td></td> </tr> </tbody> </table><br> <div style="text-align:center;margin:5px;font-size: 12px;font-weight: normal;font-family: arial;">Thanks for shopping with us!</div> <div style="margin:5px;text-align:center;margin:5px;font-size: 12px;font-weight: normal;font-family: arial;"><img style="margin-bottom:3px;width: 200px;" alt="pos_barcode" src="'.base_url().'assets/barcode/barcode.php?text='.@$result[0]["DOC_NO"].'"/><div style="margin:5px;text-align:center;margin:5px;font-size: 12px;font-weight: normal;font-family: arial;">'.@$result[0]["DOC_NO"].'-'.$docDateStr.'</div> </div></body> </html>';
          	echo $header.$html.$footer;

			}
			else{
				return redirect('service/c_serviceForm/returnShowForm');
			}
			
		}

		public function editServiceInvoice(){
			$lz_serv_mt_id = $this->uri->segment(4);
			$result['data'] = $this->m_serviceForm->editServiceInvoice($lz_serv_mt_id);
			$result['cityState'] = $this->m_serviceForm->cityStateList();
			$result['pageTitle'] = 'Service Edit Form';
			$result['equipment'] = $this->m_serviceForm->selectEquipment();
			$result['component'] = $this->m_serviceForm->selectComponent();

			$this->load->view('service/v_serviceEditForm', $result);

		}
		public function deleteServiceInvoice(){
			$lz_serv_mt_id = $this->uri->segment(4);
			$this->m_serviceForm->deleteServiceInvoice($lz_serv_mt_id);

			redirect('service/c_serviceReceipt/serviceReceiptView','refresh');

		}

		public function updateServiceInvoice(){
			$this->m_serviceForm->updateServiceInvoice();
			return redirect('service/c_serviceReceipt/serviceReceiptView');
		}

	}