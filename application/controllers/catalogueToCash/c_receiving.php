<?php

class c_receiving extends CI_Controller{
  public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model('catalogueToCash/m_reciving');
        $this->load->helper('security');
        /*=============================================
        =  Section lz_bigData db connection block  =
        =============================================*/
        $CI = &get_instance();
        //setting the second parameter to TRUE (Boolean) the function will return the database object.
        $this->db2 = $CI->load->database('bigData', TRUE);
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

      $result['pageTitle'] = 'Receiving';
      $result['trackings'] = $this->m_reciving->get_tracking_nos();
        $this->load->view('catalogueToCash/v_receiving',$result);
    }
    public function update_lot_mpn(){
      $data = $this->m_reciving->update_lot_mpn();
      echo json_encode($data);
      return json_encode($data);
    }
    public function reciv_data(){
      $data = $this->m_reciving->reciv_get_data();
      echo json_encode($data);
      return json_encode($data);
    }
    
    public function reciv_add(){
      $data = $this->m_reciving->reciv_post();
      $lz_manifest_id = $data['manifest_id'];
      $condition_id = $data['condition_id'];
      //var_dump($data, $lz_manifest_id, $condition_id);exit;
      $action = "post";
      $result = $this->m_manf_load->manf_post($lz_manifest_id,$action);
      $this->m_reciving->skip_test($lz_manifest_id, $condition_id);
        echo json_encode($result);
        return json_encode($result);
    }

    public function reciev_lot(){
      $data = $this->m_reciving->reciev_lot();
      // var_dump('test');
      // exit;
      $track_estimate_id = $data['track_estimate_id'];
      $track_catagry_id = $data['track_catagry_id'];
      $result  = $this->m_reciving->lot_recive($track_estimate_id,$track_catagry_id); 
        echo json_encode($result);
        return json_encode($result);

    }

    public function lot_items(){
    $result['pageTitle'] = 'Manifest Lot ';
     $result['data'] = $this->m_reciving->lot_items();

     $this->load->view('catalogueToCash/v_lot_items', $result);     
      
    }
    public function lot_items_detail(){
      $result['pageTitle'] = 'Manifest Detail';

     $result['data'] = $this->m_reciving->lot_items_detail();

     $this->load->view('catalogueToCash/v_lot_item_detail', $result);     
      
    }


    public function get_autocomplete()
    {
     $search = $this->m_reciving->get_autocomplete();
     echo json_encode ($search);
       // if (!empty($search))
       // {
       //      foreach ($search as $row):
       //           echo "<li class='fill_tracking_no'>" . $row['TRACKING_NO'] . "</li>";
       //      endforeach;
       // }
       // else
       // {
       //       echo "<li> <em> Not found ... </em> </li>";
       // }
     }
    public function lotItems_print(){
      $lz_manifest_id = $this->uri->segment(4);
      $result['pageTitle'] = 'Lot Items Manifest Sticker';
      $result['data'] = $this->m_reciving->lotItems_print($lz_manifest_id);
      $result['master'] = $this->m_reciving->lot_items_detail();
      $this->load->view('catalogueToCash/v_lotitems_print', $result);
    }
    
    public function lotitemsPrintForAll(){

      $result = $this->m_reciving->lotitemsPrintForAll(); 
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
                @$data["LOT_NO"].'</u></b><br><span style="margin-top:3px!important; font-size:9px!important;font-family:arial;">'.
                @$item_desc.'</span><br><strong>LOT ID:'
                .@$data["PO_DETAIL_LOT_REF"].'</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>UNIT#:'
                .@$data["UNIT_NO"].'&nbsp;&nbsp;&nbsp;MPN:'.@$data["MPN"].'</strong><br><strong>QTY:'.
                @$data["LOT_QTY"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;UPC:'.@$data["UPC"].'</strong></span></div>
            </div>';
        //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);
        $i++;
        if(!empty($result[$i])){
          $this->m_pdf->pdf->AddPage();
        }
        $query = $this->db->query("UPDATE LZ_BARCODE_MT SET PRINT_STATUS = 1 WHERE BARCODE_NO = ".$data["BAR_CODE"]);        
      }//end foreach
    //download it.
    $this->m_pdf->pdf->Output($pdfFilePath, "I");

    }    
    public function manifest_print(){

      $item_code = $this->uri->segment(4);
      $manifest_id = $this->uri->segment(5);
      $barcode = $this->uri->segment(6);

      //$manifest_id = $this->input->post('manifest_id');
      //var_dump($manifest_id);exit;
      $result = $this->m_reciving->manifest_sticker_print($item_code,$manifest_id,$barcode); 
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
                @$data["LOT_NO"].'</u></b><br><span style="margin-top:3px!important; font-size:9px!important;font-family:arial;">'.
                @$item_desc.'</span><br><strong>LOT ID:'
                .@$data["PO_DETAIL_LOT_REF"].'</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>UNIT#:'
                .@$data["UNIT_NO"].'&nbsp;&nbsp;&nbsp;MPN:'.@$data["MPN"].'</strong><br><strong>QTY:'.
                @$data["LOT_QTY"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;UPC:'.@$data["UPC"].'</strong></span></div>
            </div>';
        //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);
      }//end foreach
    //download it.
    $this->m_pdf->pdf->Output($pdfFilePath, "I");



    }  


  public function get_append_data(){
    $data = $this->m_reciving->get_append_data();
    echo json_encode($data);
        return json_encode($data);
  }


 }