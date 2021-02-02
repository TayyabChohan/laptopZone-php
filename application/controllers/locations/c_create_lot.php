<?php

class c_create_lot extends CI_Controller{
  public function __construct(){
      parent::__construct();
      $this->load->database();
      $this->load->model('locations/m_create_lot');
      $this->load->helper('security');
          
      if(!$this->loginmodel->is_logged_in())
       {
         redirect('login/login/');
       }      
  }

  public function index(){
    $result['pageTitle'] = 'Create Lot'; 
    $result['data'] = $this->m_create_lot->Condiotion();
    $this->load->view('locations/v_create_lot',$result);
  } 

  public function my_lot_sticker(){
    $get_bar = $this->uri->segment(4);
    
    $lot_items = $this->db->query(" SELECT B.BARCODE_NO , I.ITEM_DESC,DE.PO_DETAIL_RETIAL_PRICE COST_PRICE,DE.CONDITIONS_SEG5 FROM LZ_MANIFEST_MT M, LZ_MANIFEST_DET DE, ITEMS_MT I, LZ_BARCODE_MT B WHERE M.MANIFEST_TYPE = 5 AND DE.LAPTOP_ITEM_CODE = I.ITEM_CODE AND I.ITEM_ID = B.ITEM_ID(+) AND M.LZ_MANIFEST_ID = DE.LZ_MANIFEST_ID AND BARCODE_NO = $get_bar order by BARCODE_NO desc " )->result_array();

         $this->load->library('m_pdf');
    // to increse or decrese the width of barcode please set size attribute in barcode tag
          
         foreach($lot_items as $data){
        $text = $data["ITEM_DESC"];
        $item_desc =implode("<br/>", str_split($text, 40));
        $html ='<div style = "margin-left:-35px!important;">
                <div style="width:222px !important;" class="barcodecell"><barcode height="0.75" size="1.18" code="'.@$data["BARCODE_NO"].'" type="C128A" class="barcode" /></div>
            
            <div style="margin-top:6px !important;width:222px;padding:0;font-size:10px;font-family:arial;">
            <span><b>'.
              @$data["BARCODE_NO"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>'.
              @$data["LOT_NO"].'</b><br><span style="margin-top:3px!important; font-size:9px!important;font-family:arial;">'.
              @$item_desc.'</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
          </div>';
        //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);
      }//end foreach
          
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "I");

        $this->db->query(" UPDATE BIN_MT SET PRINT_STATUS = 2 where bin_id =$bin_id ");
    

  }
 public function my_lot_items(){
    $result['pageTitle'] = 'My Lot Details'; 
    $result['data'] = $this->m_create_lot->my_lot_items();
    $this->load->view('locations/v_my_lots',$result);
  }
  public function my_lot_items_dettail(){
    $result['pageTitle'] = 'My Lot Details'; 
    $result['data'] = $this->m_create_lot->my_lot_items_dettail();
    $this->load->view('locations/v_my_lots_details',$result);
  }

  
  public function get_barcode(){
    $data = $this->m_create_lot->get_barcode();
    
    echo json_encode($data);
    return json_encode($data);
  }
  public function get_bar_item_id(){
    $data = $this->m_create_lot->get_bar_item_id();
    
    echo json_encode($data);
    return json_encode($data);
  } 
  public function save_lot(){
    $data = $this->m_create_lot->save_lot();
    echo json_encode($data);
    return json_encode($data);
  }



}