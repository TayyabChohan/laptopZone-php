<?php

	class C_Pos_List extends CI_Controller{
		public function __construct(){
			parent::__construct();
			$this->load->database();
			$this->load->model('pos/m_pos_list');
		    if(!$this->loginmodel->is_logged_in())
		      {
		        redirect('login/login/');
		      } 
		}

		public function index(){

		}

		public function postedUnpostedData(){
			$result['data'] = $this->m_pos_list->postedUnpostedData();
			$result['lister'] = $this->lister_model->ListerUsers();
			$result['pageTitle'] = 'POS Posting List';
			$this->load->view('pos/v_pos_list', $result);
		}
		public function posPostDetail(){
			$result['data'] = $this->m_pos_list->posPostDetail();
			$result['pageTitle'] = 'POS AD Posting';
			$this->load->view('pos/v_posItemInfo', $result);
		}

	
		public function posReceiptView(){
			$result['data'] = $this->m_pos_list->posReceiptView();
		    $result['users'] = $this->m_ListingAllocation->UsersList();
		    $result['pageTitle'] = 'POS Receipt View';			
			$this->load->view('pos/v_posReceiptView', $result);
		}

		public function posAddPost(){
			$result['data'] = $this->m_pos_list->posAddPost();
			// $this->load->view('pos/v_pos_list',$result);
			return redirect('pos/c_pos_list/postedUnpostedData');
		}
		public function receiptSearch(){
			if($this->input->post('search_btn')){
				$result['perameter'] = $this->input->post('receipt_search');
				$result['data'] = $this->m_pos_list->receiptSearch();
				$result['users'] = $this->m_ListingAllocation->UsersList();
				$result['pageTitle'] = 'Search Result - POS Receipt View';
				$this->load->view('pos/v_posReceiptView', $result);
			}


		}
		public function deleteRecord(){
			$lz_craig_post_id = $this->uri->segment(4);
			$this->m_pos_list->deleteRecord($lz_craig_post_id);
			redirect('pos/c_pos_list/postedUnpostedData', 'refresh'); 

		}
		public function printInvoice(){
          $lz_pos_mt_id = $this->uri->segment(4);

        	date_default_timezone_set("America/Chicago");
        	$print_date = date("m/d/Y H:i A ");
        	//var_dump($print_date);exit;
        	$concatDate = date("m/d/Y");

        	$result = $this->m_pos_list->printInvoice($lz_pos_mt_id); 
/*==================================
=            m_pdf code            =
==================================*/
        //$data = [];
        //load the view and saved it into $html variable
        //$html=$this->load->view('welcome_message', $data, true);
 
        //this the the PDF filename that user will get to download
        //var_dump($result);exit;
        //$pdfFilePath = @$result[0]["DOC_NO"].".pdf";

 
        //load mPDF library
        //$this->load->library('m_pdf');
// to increse or decrese the width of barcode please set size attribute in barcode tag
        $header = '<style media="print"> @page {size: auto; margin: 0; } </style><!doctype html> <html class="no-js" lang=""> <head> <meta charset="utf-8"> <meta http-equiv="x-ua-compatible" content="ie=edge"> <title>Print Invoice</title> <meta name="description" content=""> <meta name="viewport" content="width=device-width, initial-scale=1"> </head> <body><div style="width: 280px !important;margin:0px !important;"> <div style="width: 138px;float:left;font-size:12px;font-family: arial;">'.@$print_date.'</div> <div style="width: 138px;float:right;font-size:12px;font-family: arial;"> <b>Sale Receipt #'.@$result[0]["DOC_NO"].'</b> </div> <div style="padding: 2px;font-size:12px;font-family: arial;">Store: 1</div> <div style="text-align: center;font-size: 20px; font-weight: bold; font-family: arial;padding: 3px;">LaptopZone</div> <div style="font-size:12px;font-weight: normal;font-family: arial;text-align: center;">2720 Royal Ln Suite 180<br> Dallas TX 75229<br> (214) 427-4496 </div><br><table> <thead> <tr style="font-size:12px !important;border-bottom: 1px solid #000 !important;font-family: arial;"> <th style="border-bottom-style: solid; border-bottom: 1px solid #000 !important;">Item Name</th> <th style="border-bottom-style: solid; border-bottom: 1px solid #000 !important;">Qty</th> <th style="border-bottom-style: solid; border-bottom: 1px solid #000 !important;">Price</th> <th style="border-bottom-style: solid; border-bottom: 1px solid #000 !important;">Ext Price</th> </tr></thead> <tbody> '; 

	        $html = '';
	        $sum_price = 0;
	        $sum_disc_amt = 0;
	        $sum_qty = 0;

          foreach($result as $data){
            $text = $data["ITEM_DESC"];
            $price = '$'.number_format((float)@$data['DET_PRICE'],2,'.',',');

            
            //$item_desc = implode("<br/>", str_split($text, 40));
            $item_desc = str_split($text, 40);
            //var_dump($item_desc);exit;
            $html .='<tr style="font-size:12px !important;font-family: arial;"> <td><div style="width:120px;">'.@$item_desc[0].'</div></td> <td><span style="float:right;margin-right:15px;">'.@$data["QTY"].'</span></td> <td>'.$price.'</td> <td>'.$price.'</td> </tr>'; 
            $sum_price  = $sum_price + $data['DET_PRICE'];

            $sum_disc_amt  = $sum_disc_amt + $data['DISC_AMT'];
            $sum_qty  = $sum_qty + $data['QTY'];
            //generate the PDF from the given html
            //echo $html;exit;
            

          }//end foreach
          //var_dump($sum_price);exit;
          $total = $sum_price - $sum_disc_amt;
          $pay_mode = @$result[0]['PAY_MODE'];
          $sales_tax = ($total/100)*@$result[0]['DET_SALES_TAX'];
          $sales_tax = number_format((float)@$sales_tax,2,'.',',');

          $receipt_total = $total + $sales_tax;
          $receipt_total = number_format((float)@$receipt_total,2,'.',',');
          if($pay_mode == "C"){
          	$rcpt_total = "Cash: $".$receipt_total; 

          }elseif($pay_mode == "R"){
          	$rcpt_total = "Credit: $".$receipt_total;
          }

           $barDate =str_replace('/', '', $concatDate);
           // var_dump($barDate);exit;
           $str1 = substr($barDate,0,4);
           $str2 = substr($barDate,6,8);
           $docDateStr = $str1.$str2;
          //echo $receipt_total;


          $footer = '<tr style="font-size:12px !important;font-family: arial;"> <td style="border-top-style: solid; border-top: 1px solid #000 !important;"></td> <td style="border-top-style: solid; border-top: 1px solid #000 !important;"><span style="float:right;margin-right:15px;">Qty: '.$sum_qty.'</span></td> <td style="border-top-style: solid; border-top: 1px solid #000 !important;"><b>Subtotal:</b></td> <td style="border-top-style: solid; border-top: 1px solid #000 !important;">'.'$'.$sum_price.'</td> </tr><tr style="font-size:12px !important;font-family: arial;"><td></td> <td></td> <td>Disc Amount:</td> <td>'.'$'.$sum_disc_amt.'</td></tr><tr style="font-size:12px !important;font-family: arial;"><td></td> <td></td> <td><b>Total:</b></td> <td>'.'$'.$total.'</td></tr> <tr style="font-size:12px !important;font-family: arial;"> <td></td> <td>Exempt</td> <td>0 % Tax:</td> <td>+ '.'$'.$sales_tax.'</td> </tr> <tr style="font-size:12px !important;font-family: arial;"> <td></td>  <td colspan="2"><b>GRAND TOTAL:</b></td> <td><b>'.'$'.$receipt_total.'</b></td> </tr> <tr style="font-size:12px !important;font-family: arial;"> <td></td> <td><div style="width:90px;">'.$rcpt_total.'</div></td> <td></td> <td></td> </tr> </tbody> </table><br> <div style="text-align:center;margin:5px;font-size: 12px;font-weight: normal;font-family: arial;">Thanks for shopping with us!</div> <div style="margin:5px;text-align:center;margin:5px;font-size: 12px;font-weight: normal;font-family: arial;"><img style="margin-bottom:3px;width: 200px;" alt="pos_barcode" src="'.base_url().'assets/barcode/barcode.php?text='.@$result[0]["DOC_NO"].'"/><div style="margin:5px;text-align:center;margin:5px;font-size: 12px;font-weight: normal;font-family: arial;">'.@$result[0]["DOC_NO"].'-'.$docDateStr.'</div> </div></body> </html>';
          echo $header.$html.$footer;
          // exit;
          //$this->m_pdf->pdf->WriteHTML($header.$html.$footer);
        //download it.
        //$this->m_pdf->pdf->Output($pdfFilePath, "I");


		}
		
	}

?>