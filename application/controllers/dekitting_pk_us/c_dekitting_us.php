<?php 

class c_dekitting_us extends CI_Controller{
	public function __construct(){
	    parent::__construct();
	    $this->load->database();
	    
	    $this->load->model("dekitting_pk_us/m_dekitting_us");
        //$this->load->helper('security');
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

	$result['pageTitle'] = 'DE-Kitting - U.S';

  // $data = $this->load->view('dekitting_pk_us/v_dekitting_us');
  // var_dump($data);
  // exit;
  $result['data'] = $this->m_dekitting_us->obj_dropdown();
  $result['data'] = $this->m_dekitting_us->last_ten_barcode();

	$this->load->view('dekitting_pk_us/v_dekitting_us',$result);

	}

	public function print_all_us_pk(){
 

          // $item_code = $this->uri->segment(4);
          // $manifest_id = $this->uri->segment(5);
          // $barcode = $this->uri->segment(6);

          //$manifest_id = $this->input->post('manifest_id');
          //var_dump($manifest_id);exit;
          $result = $this->m_dekitting_us->print_all_us_pk(); 
         // var_dump($result);exit;
          $this->load->library('m_pdf');
		// to increse or decrese the width of barcode please set size attribute in barcode tag
          $i = 0;
          foreach($result as $data){
            $text = $data["ITEM_DESC"];
            $item_desc =implode("<br/>", str_split($text, 40));
            $html ='<div style = "margin-left:-35px!important;">
                      <div style="width:222px !important;" class="barcodecell"><barcode height="0.75" size="1.18" code="'.@$data["BAR_CODE"].'" type="C128A" class="barcode" /></div>
                  
                  <div style="margin-top:6px !important;width:222px;padding:0;font-size:10px;font-family:arial;">
                  <span><b>'.
                    @$data["BAR_CODE"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>'.
                    @$data["OBJECT_NAME"].'</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.
                    @$data["LOT_NO"].'</b><br><span style="margin-top:3px!important; font-size:9px!important;font-family:arial;">'.
                    @$item_desc.'</span><br>'.
                    @$data["BARCODE_NO"].'</span><br>'.'</span></div></div>';
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
  public function print_single_us_pk(){
  	$result = $this->m_dekitting_us->print_single_us_pk(); 
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
                    @$data["BAR_CODE"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>'.
                    @$data["OBJECT_NAME"].'</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.
                    @$data["LOT_NO"].'</b><br><span style="margin-top:3px!important; font-size:9px!important;font-family:arial;">'.
                    @$item_desc.'</span><br>'.
                    @$data["BARCODE_NO"].'</span><br>'.
                     
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


  public function master_barcode_det(){

  $data = $this->m_dekitting_us->master_barcode_det();
  echo json_encode($data);
  return json_encode($data);
  }
	public function obj_dropdown(){

	$data = $this->m_dekitting_us->obj_dropdown();
	echo json_encode($data);
	return json_encode($data);
	}
	public function update_obj_dropdown(){

	$data = $this->m_dekitting_us->obj_dropdown();
	echo json_encode($data);
	return json_encode($data);
	}


	public function save_mast_barcode(){

  $data = $this->m_dekitting_us->save_mast_barcode();
  echo json_encode($data);
  return json_encode($data);

  }
  public function save_mast_barcode_qty(){

	$data = $this->m_dekitting_us->save_mast_barcode_qty();
	echo json_encode($data);
	return json_encode($data);

	}

  public function add_onupdate(){

  $data = $this->m_dekitting_us->add_onupdate();
  echo json_encode($data);
  return json_encode($data);

  }

	public function deleteDeKitDet(){

		$data = $this->m_dekitting_us->deleteDeKitDet();
		echo json_encode($data);
		return json_encode($data);

	}	

	public function getDetDetails(){
    $data = $this->m_dekitting_us->getDetDetails();
    echo json_encode($data);
    return json_encode($data);
  }

  public function Save_deki_remarks(){
		$data = $this->m_dekitting_us->Save_deki_remarks();
		echo json_encode($data);
		return json_encode($data);
	}

	public function updateDetKit(){
    $data = $this->m_dekitting_us->updateDetKit();
    echo json_encode($data);
    return json_encode($data);
  }
  public function save_bin(){
  $this->session->unset_userdata('rack_bin_id');
   $bin_id =  $this->input->post('bin_id');
   $this->session->set_userdata('rack_bin_id', $bin_id);
	
	}




}