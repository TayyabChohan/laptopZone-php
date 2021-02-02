<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
	/**
	* Listing Controller
	*/
class c_product extends CI_Controller
{
		
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('reactcontroller/m_product');	    		
	}

	public function checkInventory(){
		$data = $this->m_product->checkInventory();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function add_product(){
		$data = $this->m_product->add_product();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function get_products(){
		$data = $this->m_product->get_products();                
        echo json_encode($data);
   		return json_encode($data);
  }
  public function getCondition(){
    $data = $this->m_product->getCondition();                
        echo json_encode($data);
   		return json_encode($data);
  }
  public function listToJeannie(){
    $data = $this->m_product->listToJeannie();                
        echo json_encode($data);
   		return json_encode($data);
  }
  public function addSeedProduct(){
    $data = $this->m_product->addSeedProduct();                
        echo json_encode($data);
   		return json_encode($data);
  }
  public function updateBarcodeStatus(){
    $data = $this->m_product->updateBarcodeStatus();                
        echo json_encode($data);
   		return json_encode($data);
  }
  public function updateCost(){
    $data = $this->m_product->updateCost();                
        echo json_encode($data);
   		return json_encode($data);
  }
  public function updateAccount(){
    $data = $this->m_product->updateAccount();                
        echo json_encode($data);
   		return json_encode($data);
  }
  public function updateAllAccounts(){
    $data = $this->m_product->updateAllAccounts();                
        echo json_encode($data);
   		return json_encode($data);
  }
  public function updateAllCosts(){
    $data = $this->m_product->updateAllCosts();                
        echo json_encode($data);
   		return json_encode($data);
  }
  public function selectiveDelete(){
    $data = $this->m_product->selectiveDelete();                
        echo json_encode($data);
   		return json_encode($data);
  }
  public function deleteAll(){
    $data = $this->m_product->deleteAll();                
        echo json_encode($data);
   		return json_encode($data);
  }
  public function getBarcodes(){
    $data = $this->m_product->getBarcodes();                
        echo json_encode($data);
   		return json_encode($data);
  }
  public function getAllProducts(){
    $data = $this->m_product->getAllProducts();                
        echo json_encode($data);
   		return json_encode($data);
  }
  public function getLzProductInvMt(){
    $data = $this->m_product->getLzProductInvMt();                
        echo json_encode($data);
   		return json_encode($data);
  }
  public function saveNewInventory(){
    $data = $this->m_product->saveNewInventory();                
        echo json_encode($data);
   		return json_encode($data);
  }
	public function search_product(){
		$data = $this->m_product->search_product();                
        echo json_encode($data);
   		return json_encode($data);
    }
    public function add_invventory(){
        $data = $this->m_product->add_invventory();                
        echo json_encode($data);
   		return json_encode($data);
  }
    public function getBins(){
        $data = $this->m_product->getBins();                
        echo json_encode($data);
   		return json_encode($data);
  }
  public function printBarcode(){
    
      $result = $this->m_product->printBarcode();

      $this->load->library('m_pdf');
  // to increse or decrese the width of barcode please set size attribute in barcode tag
        $i = 0;
        foreach($result as $data){
          $text = $data["BUISNESS_NAME"];
          $item_desc =implode("<br/>", str_split($text, 40));
          $lot_desc =implode("<br/>", str_split($data['LOT_DESC'], 40));
          $html ='<div style = "margin-left:-35px!important;">
                <div style="width:222px !important;" class="barcodecell"><barcode height="0.75" size="1.18" code="'.@$data["BARCODE_NO"].'" type="C128A" class="barcode" /></div>
            
            <div style="margin-top:6px !important;width:222px;padding:0;font-size:10px;font-family:arial;">
            <span><b>'.
              @$data["BARCODE_NO"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>'.
              @$data["REF_NO"].'</u>&nbsp;&nbsp;<br></b>Lot Id:'.
              @$data['LOT_ID'].'</span><br>
              <br></span></div>
                </div>';
          //generate the PDF from the given html
          $this->m_pdf->pdf->WriteHTML($html);
          $i++;
          if(!empty($result[$i])){
            $this->m_pdf->pdf->AddPage();
          }
          
        }//end foreach
        
      //download it.
      $this->m_pdf->pdf->Output($pdfFilePath, "I");
    }
    public function printAllBarcode(){
    
      $result = $this->m_product->printAllBarcode();
      

      $chek_rang = $result[0]['RANGE_ID'];       

      if($chek_rang == 1){
        $no_of_barcode = $result[0]['NO_OF_BARCODE'];
        $len = count($result);

        $get_first = $result[0]['BARCODE_NO'] . "-";
        $get_last = $result[$len - 1]['BARCODE_NO'];

      $this->load->library('m_pdf');
  
        $i = 0;
        foreach($result as $data){


          $k=$i;
          $j = $k+1;
          $text = $data["BUISNESS_NAME"];
          $item_desc =implode("<br/>", str_split($text, 40));
          $lot_desc =implode("<br/>", str_split($data['LOT_DESC'], 40));
          $html ='<div style = "margin-left:-35px!important;">
                <div style="width:222px !important;" class="barcodecell"><barcode height="0.75" size="1.18" code="'.@$data["BARCODE_NO"].'" type="C128A" class="barcode" /></div>
            
            <div style="margin-top:6px !important;width:222px;padding:0;font-size:10px;font-family:arial;">
            <span><b>'.
              @$data["BARCODE_NO"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>'.
              @$data["REF_NO"].'</u>&nbsp;&nbsp;<br>'.
              @$item_desc.'</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:8px;">'.
                    @$data["ISSUED_DATE"].'</span><br><span style="margin-top:3px!important; font-size:9px!important;font-family:arial;">'.
              @$lot_desc.'</span><br><strong></b>'.$j.' of '.@$no_of_barcode.'&nbsp;&nbsp;'.$get_first.''.$get_last.'<strong></span></div>
                </div>';
          //generate the PDF from the given html
          $this->m_pdf->pdf->WriteHTML($html);
          $i++;
          if(!empty($result[$i])){
            $this->m_pdf->pdf->AddPage();
          }
          
        }//end foreach
        
      //download it.
      $this->m_pdf->pdf->Output($pdfFilePath, "I");
    }elseif($chek_rang == 0){

      $this->load->library('m_pdf');
  
        $i = 0;
        foreach($result as $data){
          
          $text = $data["BUISNESS_NAME"];
          $item_desc =implode("<br/>", str_split($text, 40));
          $lot_desc =implode("<br/>", str_split($data['LOT_DESC'], 40));
          $html ='<div style = "margin-left:-35px!important;">
                <div style="width:222px !important;" class="barcodecell"><barcode height="0.75" size="1.18" code="'.@$data["BARCODE_NO"].'" type="C128A" class="barcode" /></div>
            
            <div style="margin-top:6px !important;width:222px;padding:0;font-size:10px;font-family:arial;">
            <span><b>'.
              @$data["BARCODE_NO"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>'.
              @$data["REF_NO"].'</u>&nbsp;&nbsp;<br>'.
              @$item_desc.'</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:8px;">'.
                    @$data["ISSUED_DATE"].'</span><br><span style="margin-top:3px!important; font-size:9px!important;font-family:arial;">'.
              @$lot_desc.'</span><br>
              <br></span></div>
                </div>';
          //generate the PDF from the given html
          $this->m_pdf->pdf->WriteHTML($html);
          $i++;
          if(!empty($result[$i])){
            $this->m_pdf->pdf->AddPage();
          }
          
        }//end foreach
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "I");

      }
    }

    function printAllStickers($MT_ID){

		  $result = $this->m_product->printAllStickers($MT_ID); 
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
                      <div style="width:222px !important;" class="barcodecell"><barcode height="0.75" size="1.18" code="'.@$data["BARCODE_PRV_NO"].'" type="C128A" class="barcode" /></div>
                  
                  <div style="margin-top:6px !important;width:222px;padding:0;font-size:10px;font-family:arial;">
                  <span><b>'.
                    @$data["BARCODE_PRV_NO"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u></u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.
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

}	