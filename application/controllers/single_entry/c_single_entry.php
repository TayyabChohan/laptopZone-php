<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* Listing Controller
	*/
class C_Single_Entry extends CI_Controller
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
			$id = NULL;
			$se_radio = NULL;
			
		$data['auto_num'] = $this->m_single_entry->loading_no();
		$data['supplier_id'] = $this->m_single_entry->get_supplier_id();
		$data['cond'] = $this->m_single_entry->get_cond();
		//$data['singlentry_all'] = $this->m_single_entry->singlentry_view_all($id,$se_radio);
		
		// var_dump($supplier_id);exit;
		$data['pageTitle'] = 'Single Entry Form';
		$this->load->view('single_entry/v_single_entry', $data);

		}else{
			redirect('login/login/');
		}


	}

	public function get_loading_no(){

		$data = $this->m_single_entry->loading_no();        
        
        echo json_encode($data);
   		return json_encode($data);
    }
	public function single_entry_two(){

		$status = $this->session->userdata('login_status');
		$login_id = $this->session->userdata('user_id');
		if(@$login_id && @$status == TRUE)
		{
			$id = NULL;
			$se_radio = NULL;
			
		// $data['auto_num'] = $this->m_single_entry->loading_no();
		// $data['supplier_id'] = $this->m_single_entry->get_supplier_id();
		$data['get_data'] = $this->m_single_entry->get_single_entry_two_data();
		$data['cond'] = $this->m_single_entry->get_cond();
		$data['pageTitle'] = 'Single Entry Form';
		$this->load->view('single_entry/v_rapid_single_entry', $data);

		}else{
			redirect('login/login/');
		}
	}

	public function sing_entr_copy(){

		$status = $this->session->userdata('login_status');
		$login_id = $this->session->userdata('user_id');
		if(@$login_id && @$status == TRUE)
		{
			$id = NULL;
			$se_radio = NULL;
			
		$data['auto_num'] = $this->m_single_entry->loading_no();
		$data['supplier_id'] = $this->m_single_entry->get_supplier_id();
		$data['cond'] = $this->m_single_entry->get_cond();
		$data['get_uri_upc'] = $this->m_single_entry->get_single_entry_two_data();
		$data['pageTitle'] = 'Single Entry Form';
		$this->load->view('single_entry/v_single_entry_copy', $data);

		}else{
			redirect('login/login/');
		}


	}

	 public function add_two() {

		if($this->input->post('save')) {
			$rs= $this->m_single_entry->add_two();

			redirect('single_entry/c_single_entry/single_entry_two');
		} else{
		redirect('single_entry/c_single_entry/single_entry_two');
		}

	 }

	public function filter_data(){

		$status = $this->session->userdata('login_status');
		$login_id = $this->session->userdata('user_id');
		if(@$login_id && @$status == TRUE)
		{
			//if($this->input->post('search'))
			//{
				$id = NULL;
				$se_radio = $this->input->post('se_radio');
				//$se_radio =NULL;
				$data['singlentry_all'] = $this->m_single_entry->singlentry_view_all($id,$se_radio);
				$data['pageTitle'] = 'Single Entry View';
				$this->load->view('single_entry/v_add_singlentry', $data);
			//}

		}else{
			redirect('login/login/');
		}

	}

	public function add_record(){

		$status = $this->session->userdata('login_status');
		$login_id = $this->session->userdata('user_id');
		if(@$login_id && @$status == TRUE)
		{
			$data['auto_num'] = $this->m_single_entry->loading_no();
			$data['supplier_id'] = $this->m_single_entry->get_supplier_id();
			$data['cond'] = $this->m_single_entry->get_cond();
			$data['pageTitle'] = 'Add Single Entry Form';
			$this->load->view('single_entry/v_single_entry', $data);

		}else{
			redirect('login/login/');
		}


	}
	public function deleteComplete(){

			$lz_manifest_id = $this->uri->segment(4);
			$action = 'unpost';
			$this->m_manf_load->manf_post($lz_manifest_id, $action);
			redirect('single_entry/c_single_entry/filter_data');		
		
	}
	public function holdcheck(){
		$single_entry_id = $this->input->post('single_entry_id');
		$item_hold['check'] = $this->m_single_entry->holdcheck($single_entry_id);
		echo json_encode($item_hold['check']);
      	return json_encode($item_hold['check']); 
	}	
	public function pic_approval(){
		$data = $this->m_single_entry->pic_approval();
		echo json_encode($data);
      	return json_encode($data); 
	}
	public function deleteCreateNew(){

		$status = $this->session->userdata('login_status');
		$login_id = $this->session->userdata('user_id');
		if(@$login_id && @$status == TRUE)
		{

			 	$single_entry_id = $this->uri->segment(4);
			    $se_radio =NULL;
				$data['supplier_id'] = $this->m_single_entry->get_supplier_id();
				$data['singlentry_all'] = $this->m_single_entry->singlentry_view_all($single_entry_id,$se_radio);
				$data['cond'] = $this->m_single_entry->get_cond();
				$data['pageTitle'] = 'Single Entry Delete &amp; Create New';
				$this->load->view('single_entry/v_singlentry_delete_create_new', $data);
			
		}else{
			redirect('login/login/');
		}


	}
	public function updateRecordView(){

			$id = $this->uri->segment(4);
			$se_radio =NULL;
			$data['supplier_id'] = $this->m_single_entry->get_supplier_id();
			$data['singlentry_all'] = $this->m_single_entry->singlentry_view_all($id,$se_radio);
			$data['cond'] = $this->m_single_entry->get_cond();
			$data['pageTitle'] = 'Update Single Entry Form';
			$this->load->view('single_entry/v_singlentry_edit', $data);


	}
		
	public function check_purchref_no(){

		$purch_ref = $this->input->post('purch_ref');
		 $this->m_single_entry->purchase_ref_no($purch_ref);
	}

	// public function add() {

	// 	if($this->input->post('save')) {
	// 		$rs= $this->m_single_entry->add();
	// 		$lz_manifest_id = $rs[0]['LZ_MANIFEST_ID'];
	// 		$single_entry_id = $rs[0]['SINGLE_ENTRY_ID'];
	//         $action = "post";
	//         $this->m_manf_load->manf_post($lz_manifest_id,$action);
	//         $this->m_single_entry->skip_test($lz_manifest_id);
	//         $this->m_single_entry->autoList($single_entry_id);

	        


	// 		redirect('single_entry/c_single_entry/filter_data');
	// 	} else{
	// 	redirect('single_entry/c_single_entry');
	// 	}

	//  }
	//  
	public function add() {

		if($this->input->post('save')) {
			$rs= $this->m_single_entry->add();
			$lz_manifest_id = $rs[0]['LZ_MANIFEST_ID'];
			$single_entry_id = $rs[0]['SINGLE_ENTRY_ID'];
	        $action = "post";
	        $this->m_manf_load->manf_post($lz_manifest_id,$action);
	        $this->m_single_entry->skip_test($lz_manifest_id);
	        $this->m_single_entry->autoList($single_entry_id);

	        $pic_aprov = $this->input->post('pic_aprov');

		  	if($pic_aprov == 1){

			$get_seed = $this->db->query("SELECT S.SEED_ID FROM LZ_ITEM_SEED S, (SELECT * FROM (SELECT B.ITEM_ID, B.CONDITION_ID, MM.LZ_MANIFEST_ID FROM LZ_MANIFEST_MT MM, LZ_BARCODE_MT B WHERE MM.SINGLE_ENTRY_ID = '$single_entry_id' AND MM.LZ_MANIFEST_ID = B.LZ_MANIFEST_ID) WHERE ROWNUM <= 1) B WHERE S.ITEM_ID = B.ITEM_ID AND S.LZ_MANIFEST_ID = B.LZ_MANIFEST_ID AND S.DEFAULT_COND = B.CONDITION_ID")->result_array();

		  	$seed_id = $get_seed[0]['SEED_ID'];
			//$seed_id = trim($this->input->post('seed_id'));
		    date_default_timezone_set("America/Chicago");
		    $date = date('Y-m-d H:i:s');
		    $ins_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
		    $entered_by = $this->session->userdata('user_id');

		 	$query = $this->db->query("UPDATE LZ_ITEM_SEED S SET S.APPROVED_DATE = $ins_date, S.APPROVED_BY = $entered_by WHERE S.SEED_ID = '$seed_id'");

		  	}
			$this->session->set_userdata("lz_manifest_id",$lz_manifest_id);
	        //$this->printAllStickers_copy($lz_manifest_id);
	        redirect(react_url($lz_manifest_id));

			//redirect('single_entry/c_single_entry');
		} else{
		redirect('single_entry/c_single_entry');
		}

	 } 




	   function printAllStickers_copy($manifest_id){
 

          $result = $this->m_single_entry->printAllStickers_copy($manifest_id); 
          $bar  = $result[0]['BAR_CODE'];
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
                    @$item_desc.'</span><br><strong>LOT ID:'
                    .@$data["PO_DETAIL_LOT_REF"].'</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>UNIT#:'
                    .@$data["UNIT_NO"].'</strong><br><strong>LOT QTY:'.
                    @$data["LOT_QTY"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.@$data["UPC"].'</strong>'.
                     
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

  public function printAllStickers(){


          $result = $this->m_single_entry->printAllStickers(); 
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
                    @$item_desc.'</span><br><strong>LOT ID:'
                    .@$data["PO_DETAIL_LOT_REF"].'</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>UNIT#:'
                    .@$data["UNIT_NO"].'</strong><br><strong>LOT QTY:'.
                    @$data["LOT_QTY"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.@$data["UPC"].'</strong>'.
                     
                    //$newtext.
                  '</span></div>
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


	public function update() {

		if($this->input->post('update')) {

			//$id = $this->uri->segment(4);
			//var_dump($id);exit;
			$rs = $this->m_single_entry->update();
			$lz_manifest_id = $rs[0]['LZ_MANIFEST_ID'];
			$single_entry_id = $rs[0]['SINGLE_ENTRY_ID'];
			$barcode = $this->m_single_entry->get_old_barcode($lz_manifest_id,$single_entry_id);
			$action = "unpost";
			$this->m_manf_load->manf_post($lz_manifest_id,$action);
			$action = "post";
	        $this->m_manf_load->manf_post($lz_manifest_id,$action);
	        $this->m_single_entry->skip_test($lz_manifest_id);
			redirect('single_entry/c_single_entry/filter_data');
		} else{
		redirect('single_entry/c_single_entry');
		}

	 }
	public function updateRecord() {

		if($this->input->post('update')) {

			//$id = $this->uri->segment(4);
			//var_dump($id);exit;
			$this->m_single_entry->updateRecord();
			redirect('single_entry/c_single_entry/filter_data');
		} else{
		redirect('single_entry/c_single_entry');
		}

	 }
	public function post_item() {
	  	$lz_id = $this->input->post('manifest_id');
        $str =explode("-",$lz_id);
        $lz_manifest_id = $str[0];
        $action = $str[1];
        $this->m_manf_load->manf_post($lz_manifest_id,$action);
	 }
	public function get_data(){

        $upc = trim($this->input->post('upc'));
        $part_no = trim($this->input->post('part_no'));
        $condid = trim($this->input->post('condid'));
        //var_dump($part_no);exit;
        //var_dump($upc);exit;
        $data = $this->m_single_entry->get_data($upc, $part_no,$condid);
        echo json_encode($data);
   		return json_encode($data);
    }

    
    public function single_entry_print(){
    	$lz_manifest_id = $this->uri->segment(4);
    	$result['pageTitle'] = 'Single Entry Manifest Sticker';
    	$result['data'] = $this->m_single_entry->single_entry_print($lz_manifest_id);
    	$this->load->view('single_entry/v_single_entry_print', $result);
    }
  public function manifest_print(){


          $item_code = $this->uri->segment(4);
          $manifest_id = $this->uri->segment(5);
          $barcode = $this->uri->segment(6);

          //$manifest_id = $this->input->post('manifest_id');
          //var_dump($manifest_id);exit;
          $result = $this->m_single_entry->manifest_sticker_print($item_code,$manifest_id,$barcode); 
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
                    .@$data["UNIT_NO"].'</strong><br><strong>LOT QTY:'.
                    @$data["LOT_QTY"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.@$data["UPC"].'</strong>'.
                     
                    //$newtext.
                  '</span></div>
                </div>';
            //generate the PDF from the given html
            $this->m_pdf->pdf->WriteHTML($html);
          }//end foreach
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "I");



  }     	
	
	 public function dekit_print_all(){


          // $item_code = $this->uri->segment(4);
          // $manifest_id = $this->uri->segment(5);
          // $barcode = $this->uri->segment(6);

          //$manifest_id = $this->input->post('manifest_id');
          //var_dump($manifest_id);exit;
          $result = $this->m_single_entry->dekit_print_all(); 
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
                    @$item_desc.'</span><br><strong>LOT ID:'
                    .@$data["PO_DETAIL_LOT_REF"].'</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>UNIT#:'
                    .@$data["UNIT_NO"].'</strong><br><strong>LOT QTY:'.
                    @$data["LOT_QTY"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.@$data["UPC"].'</strong>'.
                     
                    //$newtext.
                  '</span></div>
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