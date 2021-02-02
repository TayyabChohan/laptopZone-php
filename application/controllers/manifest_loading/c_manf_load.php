<?php
class c_manf_load extends CI_Controller
{
   //public $data;
  public function __construct(){
      parent::__construct();
      $this->load->database();
      if(!$this->loginmodel->is_logged_in())
       {
         redirect('login/login/');
       }      
     // $this->load->model('manifest_loading/csv_model');
  }

  public function index()
  {
      $data = $this->m_manf_load->list_manf();
      //$data['flag'] = array('list'=> true,'detail' => false);
      $results['data'] = array('list_manf'=> $data ,'list'=> true,'detail' => false);
      $results['pageTitle'] = 'Manifest Uploading';
      $this->load->view('manifest_loading/v_manf_load',$results);
       //$this->load->view('manifest_loading/v_manf_load');
  }

 public function manf_detail()
  {
      $lz_manifest_id = $this->uri->segment(4);
      $data =$this->m_manf_load->manf_detail($lz_manifest_id);
      $results['data'] = array('manf_data'=> $data ,'list'=> false,'detail' => true);
      $results['pageTitle'] = 'Manifest Uploading Detail';
      $this->load->view('manifest_loading/v_manf_load',$results);
      
  }

  public function manf_post()
  {
      $lz_id = $this->input->post('manifest_id');
      $str =explode("-",$lz_id);
      $lz_manifest_id = $str[0];
      $action = $str[1];
      $this->m_manf_load->manf_post($lz_manifest_id,$action);
  }
  public function uploadCSV()
  {   
      $lz_manifest_id = $this->m_manf_load->import_xls_record();
      redirect('manifest_loading/c_manf_load/manf_detail/'.$lz_manifest_id);

      
  }
  public function uploadData()
    {
        //$this->csv_model->uploadData();
      $this->load->model('manifest_loading/csv_model');
        $this->csv_model->uploadData();
        //redirect('manifest_loading/csv');
        
    }

  public function import_label_view()
  {   
       $this->load->view('manifest_loading/v_import_label_cost');
  }
  public function import_label_cost()
  {   
      $this->m_manf_load->import_label_cost();
      $this->load->view('manifest_loading/v_import_label_cost');
      //redirect('manifest_loading/c_manf_load/manf_detail/'.$lz_manifest_id);

      
  }
  public function mannual_price(){

      if($this->input->post('submit'))
      {

          if(!empty($this->input->post('selected_item')))
          {
              foreach($this->input->post('selected_item') as $lz_id)
              {
                  $str =explode("_",$lz_id);
                  $lz_id = $str[0];
                  $manifest_id = $str[1];
                  $MPN = $str[2];
                  $UPC = $str[3];
                  $r_price = $this->input->post($lz_id);
                  $ship_fee = $this->input->post($lz_id.$manifest_id);
                  $this->m_manf_load->r_price($lz_id,$manifest_id,$r_price,$MPN,$UPC,$ship_fee);                
              }
              $active = true;
              $this->session->set_userdata('active', $active);
              redirect('manifest_loading/c_manf_load/manf_detail/'.$manifest_id);
          
          }

      }
      
  }
  public function check_purchref_no(){

      $purch_ref = $this->input->post('purch_ref');
      $this->m_manf_load->purchase_ref_no($purch_ref);
  }
  public function auc_detail(){
      //var_dump($this->input->post('abc'));exit;
      if($this->input->post('submit_auc'))
      {
          $lz_manifest_id = $this->input->post('lz_manifest_id');
          $manifest_status = $this->input->post('manifest_status');
          $sold_price = $this->input->post('sold_price');
          $manifestendate = $this->input->post('manifestendate');
          $manifestendate= "TO_DATE('".$manifestendate."', 'MM-DD-YYYY HH:MI AM')";
          $purchase_date = $this->input->post('purchase_date');  
          $purchase_date= "TO_DATE('".$purchase_date."', 'MM-DD-YYYY')";
          $lz_offer = $this->input->post('lz_offer');
          //var_dump($lz_manifest_id."-".$manifest_status."-".$sold_price."-".$manifestendate."-".$lz_offer) ;exit;      
          $this->m_manf_load->auc_detail($lz_manifest_id,$manifest_status,$sold_price,$manifestendate,$purchase_date,$lz_offer);
          redirect('manifest_loading/c_manf_load/manf_detail/'.$lz_manifest_id);
      }
  }

  public function manifest_print(){


          $item_code = $this->uri->segment(4);
          $manifest_id = $this->uri->segment(5);
          $barcode = $this->uri->segment(6);

          //$manifest_id = $this->input->post('manifest_id');
          //var_dump($manifest_id);exit;
          $result = $this->m_manf_load->manifest_sticker_print($item_code,$manifest_id,$barcode); 
/*==================================
=            m_pdf code            =
==================================*/
        //$data = [];
        //load the view and saved it into $html variable
        //$html=$this->load->view('welcome_message', $data, true);
 
        //this the the PDF filename that user will get to download
        $pdfFilePath = @$result[0]["BAR_CODE"].".pdf";
 
        //load mPDF library
        $this->load->library('m_pdf');
// to increse or decrese the width of barcode please set size attribute in barcode tag

          foreach($result as $data){
            $text = $data["ITEM_DESC"];
            $item_desc =implode("<br/>", str_split($text, 40));
            $html ='<div style = "margin-left:-35px!important;">
                      <div style="width:222px !important;" class="barcodecell"><barcode height="0.75" size="1.18" code="'.@$data["BAR_CODE"].'" type="C128A" class="barcode" /></div>
                  
                  <div style="margin-top:6px !important;width:222px;padding:0;font-size:10px;font-family:arial;">
                  <span>'.
                    @$data["BAR_CODE"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><u>'.
                    @$data["LOT_NO"].'</u></b><br><span style="margin-top:5px!important; font-size:8px!important;font-family:arial;">'.
                    @$item_desc.'</span><br><span style="font-size:8px;">LOT ID:'
                    .@$data["PO_DETAIL_LOT_REF"].'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:8px;">UNIT#:'
                    .@$data["UNIT_NO"].'</span><br><span style="font-size:8px;">LOT QTY:'.
                    @$data["LOT_QTY"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.@$data["SKU"].'</span><br>'.'<span style="font-size:8px;">MPN:'.
                    @$data["MPN"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;UPC:'.@$data["UPC"].'</span></span></div>
                </div>';
            //generate the PDF from the given html
            $this->m_pdf->pdf->WriteHTML($html);
          }//end foreach
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "I");
// See more at: https://arjunphp.com/generating-a-pdf-in-codeigniter-using-mpdf/#sthash.YpCz9Ejx.dpuf
                              
 }
 public function printAllStickers(){

    $result = $this->m_manf_load->printAllStickers(); 
    
    $this->load->library('m_pdf');
  // to increse or decrese the width of barcode please set size attribute in barcode tag
        $i = 0;
        foreach($result as $data){
          $text = $data["ITEM_DESC"];
          $item_desc =implode("<br/>", str_split($text, 40));
          $html ='<div style = "margin-left:-35px!important;">
                    <div style="width:222px !important;" class="barcodecell"><barcode height="0.75" size="1.18" code="'.@$data["BAR_CODE"].'" type="C128A" class="barcode" /></div>
                
                  <div style="margin-top:6px !important;width:222px;padding:0;font-size:10px;font-family:arial;">
                  <span>'.
                    @$data["BAR_CODE"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><u>'.
                    @$data["LOT_NO"].'</u></b><br><span style="margin-top:5px!important; font-size:8px!important;font-family:arial;">'.
                    @$item_desc.'</span><br><span style="font-size:8px;">LOT ID:'
                    .@$data["PO_DETAIL_LOT_REF"].'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:8px;">UNIT#:'
                    .@$data["UNIT_NO"].'</span><br><span style="font-size:8px;">LOT QTY:'.
                    @$data["LOT_QTY"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.@$data["SKU"].'</span><br>'.'<span style="font-size:8px;">MPN:'.
                    @$data["MPN"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;UPC:'.@$data["UPC"].'</span></span></div>
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
 public function RePrintAllStickers(){

    $result = $this->m_manf_load->RePrintAllStickers(); 
    
    $this->load->library('m_pdf');
  // to increse or decrese the width of barcode please set size attribute in barcode tag
        $i = 0;
        foreach($result as $data){
          $text = $data["ITEM_DESC"];
          $item_desc =implode("<br/>", str_split($text, 40));
          $html ='<div style = "margin-left:-35px!important;">
                    <div style="width:222px !important;" class="barcodecell"><barcode height="0.75" size="1.18" code="'.@$data["BAR_CODE"].'" type="C128A" class="barcode" /></div>
                
                  <div style="margin-top:6px !important;width:222px;padding:0;font-size:10px;font-family:arial;">
                  <span>'.
                    @$data["BAR_CODE"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><u>'.
                    @$data["LOT_NO"].'</u></b><br><span style="margin-top:5px!important; font-size:8px!important;font-family:arial;">'.
                    @$item_desc.'</span><br><span style="font-size:8px;">LOT ID:'
                    .@$data["PO_DETAIL_LOT_REF"].'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:8px;">UNIT#:'
                    .@$data["UNIT_NO"].'</span><br><span style="font-size:8px;">LOT QTY:'.
                    @$data["LOT_QTY"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.@$data["SKU"].'</span><br>'.'<span style="font-size:8px;">MPN:'.
                    @$data["MPN"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;UPC:'.@$data["UPC"].'</span></span></div>
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
?>