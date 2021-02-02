<?php

class c_locations extends CI_Controller{
  public function __construct(){
      parent::__construct();
      $this->load->database();
      $this->load->model('locations/m_locations');
        $this->load->helper('security');
        //$this->load->model("dekitting_pk_us/m_uspk_listing");
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
  }

  public function index(){
  
  $result['war_data'] = $this->m_locations->load_ware_data();
   $this->load->view('locations/v_locations',$result);
  }
  public function add_warhouse(){
    
  
    
    $data= $this->m_locations->add_warhouse();
  
    $result['war_data'] = $this->m_locations->load_ware_data();
    $this->load->view('locations/v_locations',$result);
    
  }
  public function load_ware_data(){

    $data = $this->m_locations->load_ware_data();
      echo json_encode($data);
        return json_encode($data); 
  }
  public function view_rack(){

  $result['war_data'] = $this->m_locations->load_ware_data();
  $result['data'] = $this->m_locations->dropdowns();

   $this->load->view('locations/v_racks',$result);  
  }
  public function add_rack(){
    // var_dump('test');
    // exit;
  if($this->input->post('save_rack')){
  $data_pass = $this->m_locations->add_rack();
  redirect('locations/c_locations/view_rack');

  }

}
  public function view_bin(){
  $this->session->unset_userdata('bin_type_search');
  $this->session->unset_userdata('print_sta');

  $result['war_data'] = $this->m_locations->load_ware_data(); 
  
  $result['data'] = $this->m_locations->dropdowns();

   $this->load->view('locations/v_bin',$result);  
  }
  
  public function add_bin(){
  // /if($this->input->post('save_ware')){

    // $save_bin = $this->input->post('save_bin');
    // var_dump($test);
   
    
  if($this->input->post('save_bin')){
    // $data= $this->input->post('save_bin');
    // var_dump($data);exit;
    // echo "add bin";
    //  exit;
  $data_pass = $this->m_locations->add_bin();
  redirect('locations/c_locations/view_bin');

  } else if($this->input->post('search_bin')){
    $bin_type_search = $this->input->post('bin_type');
    $print_sta = $this->input->post('print_sta');

      $multi_data = array(
            'bin_type_search' => $bin_type_search,    
            'print_sta' => $print_sta,    
      );
      $this->session->set_userdata($multi_data);

  $result['war_data'] = $this->m_locations->load_ware_data(); 
  
  $result['data'] = $this->m_locations->dropdowns();

   $this->load->view('locations/v_bin',$result);
  }
  
  }


  public function print_all_racks(){
          $result = $this->m_locations->print_all_racks(); 

          $this->load->library('m_pdf');
    // to increse or decrese the width of barcode please set size attribute in barcode tag
          $i = 0;
          foreach($result as $data){
           // $text = $data["ITEM_DESC"];
            //$item_desc =implode("<br/>", str_split($text, 40));
            $html ='<div style = "margin-left:-35px!important;">
                      <div style="width:222px !important;" class="barcodecell"><barcode height="1.40" size="1.40" code="'.@$data["RACK_NAME"].'" type="C128A" class="barcode" /></div>
                  
                  <div style="margin-top:6px !important;width:440px;padding:0;font-size:40px;font-family:arial;">
                  <span><b>'.
                    @$data["RACK_NAME"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>'.'</div>';
            //generate the PDF from the given html
          $this->m_pdf->pdf->SetJS('this.print(false);');
            $this->m_pdf->pdf->WriteHTML($html);
            $i++;
            if(!empty($result[$i])){
              $this->m_pdf->pdf->AddPage();
            }
            
          }//end foreach
          
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "I");



  } 

  public function print_all_rows(){
      $rack_id = $this->uri->segment(4);
        $rack_stick = $this->db->query("SELECT RO.RACK_ROW_ID,'W' || '' || WA.WAREHOUSE_NO || '-' || RA.RACK_NO ||'-' || 'R' || RO.ROW_NO  RACK_NAME FROM RACK_MT RA, WAREHOUSE_MT WA, LZ_RACK_ROWS RO WHERE RA.RACK_ID = $rack_id AND RA.WAREHOUSE_ID = WA.WAREHOUSE_ID AND RA.RACK_ID = RO.RACK_ID ORDER BY RO.ROW_NO ASC ")->result_array();



        $rack_name = $rack_stick[0]['RACK_NAME'];
        $rack_rows = $rack_stick[0]['NO_OF_ROWS'];
        
        // var_dump($rack_rows);
        // exit;

          $this->load->library('m_pdf');

          
           $i = 0;
          foreach($rack_stick as $data){
           // $text = $data["ITEM_DESC"];
            //$item_desc =implode("<br/>", str_split($text, 40));
            $html ='<div style = "margin-left:-52px!important;">
                      <div style="width:300px !important;" class="barcodecell"><barcode height="1.40" size="1.40" code="'.@$data["RACK_NAME"].'" type="C128A" class="barcode" /></div>
                  
                  <div style="margin-left:20px !important;width:480px;padding:0;font-size:38px;font-family:arial;">
                  <span><b>'.
                    @$data["RACK_NAME"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>'.'</div>';
            //generate the PDF from the given html
            $this->m_pdf->pdf->SetJS('this.print(false);');
            $this->m_pdf->pdf->WriteHTML($html);
            $i++;
            if(!empty($rack_stick[$i])){
              $this->m_pdf->pdf->AddPage();
            }
            
          }//end foreach
            
          
          
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "I");
  } 





 public function print_single_bin(){
      $bin_id = $this->uri->segment(4);
        $rack_bin = $this->db->query("  SELECT  B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME ,DECODE(BIN_TYPE, 'NA', 'W' || WA.WAREHOUSE_NO || '-' || M.RACK_NO || '-R' || ROW_NO) WARE_NAME FROM BIN_MT B, LZ_RACK_ROWS RA, RACK_MT M, WAREHOUSE_MT WA WHERE BIN_TYPE NOT IN ('No Bin') AND B.CURRENT_RACK_ROW_ID = RA.RACK_ROW_ID AND RA.RACK_ID = M.RACK_ID AND M.WAREHOUSE_ID = WA.WAREHOUSE_ID AND B.BIN_ID =$bin_id  ")->result_array();

         $this->load->library('m_pdf');
    // to increse or decrese the width of barcode please set size attribute in barcode tag
          $i = 0;
          foreach($rack_bin as $data){
           // $text = $data["ITEM_DESC"];
            //$item_desc =implode("<br/>", str_split($text, 40));
            $html ='<div style = "margin-left:-50px!important; border:5px solid #000; padding-top:20px !important; padding-left: 20px !important; width:300px !important;">
                      <div style="" class="barcodecell"><barcode height="1.40" size="1.40" code="'.@$data["BIN_NAME"].'" type="C128A" class="barcode" /></div>
                  
                  <div style="margin-left:20px !important;width:480px;padding:0;font-size:38px;font-family:arial; padding-bottom:10px !important;">
                  <span><b>'.
                    @$data["BIN_NAME"].'&nbsp;&nbsp;</b></span>'.'</div><div style="margin-left:20px !important;width:480px;padding:0;font-size:20px;font-family:arial; padding-bottom:1px !important;">
                  <span><b>'.
                    @$data["WARE_NAME"].'&nbsp;&nbsp;</b></span>'.'</div>';
            //generate the PDF from the given html
          $this->m_pdf->pdf->SetJS('this.print(false);');
            $this->m_pdf->pdf->WriteHTML($html);
            $i++;
            if(!empty($rack_bin[$i])){
              $this->m_pdf->pdf->AddPage();
            }
            
          }//end foreach
          
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "I");

        $this->db->query(" UPDATE BIN_MT SET PRINT_STATUS = 2 where bin_id =$bin_id ");
  } 

  public function print_all_bin(){
      $bin_type = $this->uri->segment(4);
      $print_sta = $this->uri->segment(5);
      // var_dump($bin_type);
      // exit;
      $print_stat = $this->uri->segment(5);

        $rack_bin = $this->db->query("   SELECT  B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME ,DECODE(BIN_TYPE, 'NA', 'W' || WA.WAREHOUSE_NO || '-' || M.RACK_NO || '-R' || ROW_NO) WARE_NAME FROM BIN_MT B, LZ_RACK_ROWS RA, RACK_MT M, WAREHOUSE_MT WA WHERE B.BIN_type ='$bin_type' and B.PRINT_STATUS = $print_sta AND B.CURRENT_RACK_ROW_ID = RA.RACK_ROW_ID AND RA.RACK_ID = M.RACK_ID AND M.WAREHOUSE_ID = WA.WAREHOUSE_ID  ORDER BY B.BIN_TYPE,B.BIN_NO  ")->result_array(); 

        $this->load->library('m_pdf');
    // to increse or decrese the width of barcode please set size attribute in barcode tag
          $i = 0;
          foreach($rack_bin as $data){
           // $text = $data["ITEM_DESC"];
            //$item_desc =implode("<br/>", str_split($text, 40));
            $html ='<div style = "margin-left:-50px!important; border:5px solid #000; padding-top:20px !important; padding-left: 20px !important; width:300px !important;">
                      <div style="" class="barcodecell"><barcode height="1.40" size="1.40" code="'.@$data["BIN_NAME"].'" type="C128A" class="barcode" /></div>
                  
                  <div style="margin-left:20px !important;width:480px;padding:0;font-size:38px;font-family:arial; padding-bottom:10px !important;">
                  <span><b>'.
                    @$data["BIN_NAME"].'&nbsp;&nbsp;</b></span>'.'</div><div style="margin-left:20px !important;width:480px;padding:0;font-size:20px;font-family:arial; padding-bottom:1px !important;">
                  <span><b>'.
                    @$data["WARE_NAME"].'&nbsp;&nbsp;</b></span>'.'</div>';
            //generate the PDF from the given html
          $this->m_pdf->pdf->SetJS('this.print(false);');
            $this->m_pdf->pdf->WriteHTML($html);
            $i++;
            if(!empty($rack_bin[$i])){
              $this->m_pdf->pdf->AddPage();
            }
            
          }//end foreach
          
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "I");

        $this->db->query(" UPDATE BIN_MT SET PRINT_STATUS = 2  where  BIN_type ='$bin_type' and PRINT_STATUS = $print_sta  ");
  } 


 //  by danish on 3-3-2018
  function transfer_bin(){

      //$result['pageTitle'] = 'Transfer Location';
      $this->load->view('locations/v_transfer_bin');
  }
  function getbin(){
    $data = $this->m_locations->getbin();
    echo json_encode($data);
    return json_encode($data);
  }

function updatebin(){
    $data = $this->m_locations->updatebin();
    echo json_encode($data);
    return json_encode($data);
  }


  // end by danish on 3-3-2018 
  // By danish on 2-3-2018
  function ViewPacking(){
    $result['pageTitle'] = 'Packing Entry Form';
    $result['data'] = $this->m_locations->load_pack_data();
    $this->load->view('locations/v_packing',$result); 
  }
  function SavePacking(){
     $data_pass = $this->m_locations->save_pack();
     $result['data'] = $this->m_locations->load_pack_data();
    $this->load->view('locations/v_packing',$result);  
  }
   function deletePacking(){
    $data = $this->m_locations->deletePacking();
    echo json_encode($data);
    return json_encode($data);
   }
  //end by danish on 2-3-2018
          ////////////////////TRANSFER LOACATION CODE WRITTEN BY IMRAN 28-02-2018/////////////////////////
  
    function transfer_location(){
      //$this->session->unset_userdata('ses_bin');
      $result['pageTitle'] = 'Bulk Item Transfer';
      $this->load->view('locations/v_multiple_tran',$result);
  }
  function barcode_notes(){

      //$this->session->unset_userdata('ses_bin');
      $result['pageTitle'] = 'Barcode Notes';
      $this->load->view('locations/v_barcode_note',$result);
  }
  
  function getLocation(){
    $data = $this->m_locations->getLocation();
    echo json_encode($data);
    return json_encode($data);
  }
  function getPacking(){
    $data = $this->m_locations->getPacking();
    echo json_encode($data);
    return json_encode($data);
  }
  function updateLocation(){
    $data = $this->m_locations->updateLocation();
    echo json_encode($data);
    return json_encode($data);
  }
  function updatePacking(){
    $data = $this->m_locations->updatePacking();
    echo json_encode($data);
    return json_encode($data);
  }
// added by adil asdas
   function get_barcode(){
    $data = $this->m_locations->get_barcode();
    echo json_encode($data);
    return json_encode($data);
  }

  function get_barcode_notes(){
    $data = $this->m_locations->get_barcode_notes();
    echo json_encode($data);
    return json_encode($data);
  }

  function update_loc(){
    $data = $this->m_locations->update_loc();
    echo json_encode($data);
    return json_encode($data);
  }

  function updat_notes(){
    $data = $this->m_locations->updat_notes();
    echo json_encode($data);
    return json_encode($data);
  }
  function get_ebay_id(){
    $data = $this->m_locations->get_ebay_id();
    echo json_encode($data);
    return json_encode($data);
  }
  // added by adil
  function item_packing(){
    $result['pageTitle'] = 'Item Packing';
      $this->load->view('locations/v_item_packing',$result);
  }
  ////////////////////END OF TRANSFER LOACATION CODE WRITTEN BY IMRAN 28-02-2018/////////////////////////

  public function loc_history(){
    $this->session->unset_userdata('ser_barcode');
    $result['pageTitle'] = 'Location History';
    $result['data'] = $this->m_locations->loc_history_search();
    $this->load->view('locations/v_loc_history',$result);

  
}
public function loc_history_search(){

    $ser_barcode = $this->input->post('ser_barcode');
     $this->session->set_userdata('ser_barcode',$ser_barcode);

    $result['data'] = $this->m_locations->loc_history_search();
    $result['pageTitle'] = 'Location History';
    $this->load->view('locations/v_loc_history',$result);

  
}




}