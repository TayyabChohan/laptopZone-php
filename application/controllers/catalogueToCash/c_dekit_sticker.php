<?php

class C_dekit_sticker extends CI_Controller{
    public function __construct(){
          parent::__construct();
          $this->load->database();
          $this->load->model('catalogueToCash/m_dekit_sticker');
        /*=============================================
        =  Section lz_bigData db connection block  =
        =============================================*/
        // $CI = &get_instance();
        // //setting the second parameter to TRUE (Boolean) the function will return the database object.
        // $this->db2 = $CI->load->database('bigData', TRUE);
        // $qry = $this->db2->query("SELECT * FROM lz_bd_category");
        // print_r($qry->result());exit;

        /*=====  End of Section lz_bigData db connection block  ======*/
          if(!$this->loginmodel->is_logged_in())
           {
             redirect('login/login/');
           }      
         // $this->load->model('manifest_loading/csv_model');
    }

    public function index(){
        
      
    }

    public function lister_view(){
      $result['pageTitle'] = 'Print Sticker De-Kited';
      $result['data'] = $this->m_dekit_sticker->listedTable();
      $result['lister'] = $this->lister_model->ListerUsers();
      $result['activeTab'] = 'Print Sticker';
      $this->load->view('catalogueToCash/v_dekit_sticker',$result);
    } 
    public function updateShip(){
      $data = $this->m_dekit_sticker->updateShip();
      echo json_encode($data);
      return json_encode($data); 
    }

   public function dekitPrintSingle(){

    $result = $this->m_dekit_sticker->dekitPrintSingle(); 
    // var_dump($result);exit;
    $this->load->library('m_pdf');
    // to increse or decrese the width of barcode please set size attribute in barcode tag
    //$i = 0;
    foreach($result as $data){
      $text = $data["ITEM_DESC"];
      $item_desc =implode("<br/>", str_split($text, 40));
      $html ='<div style = "margin-left:-35px!important;">
                <div style="width:222px !important;" class="barcodecell"><barcode height="0.75" size="1.18" code="'.@$data["BAR_CODE"].'" type="C128A" class="barcode" /></div>
            
            <div style="margin-top:6px !important;width:222px;padding:0;font-size:10px;font-family:arial;">
            <span><b>'.
              @$data["BAR_CODE"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>'.
              @$data["OBJECT_NAME"].'</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.
              @$data["LOT_NO"].'</b><br><span style="margin-top:3px!important; font-size:9px!important;font-family:arial;">'.
              @$item_desc.'</span><br><strong>LOT ID:'
              .@$data["PO_DETAIL_LOT_REF"].'</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>UNIT#:'
              .@$data["UNIT_NO"].'</strong><br><strong>LOT QTY:'.
              @$data["LOT_QTY"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.@$data["SKU"].'</strong>'.
               
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
      
    }//end foreach
    
  //download it.
  $this->m_pdf->pdf->Output($pdfFilePath, "I");



  } 


 }