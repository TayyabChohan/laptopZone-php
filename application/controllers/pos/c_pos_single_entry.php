<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* Listing Controller
	*/
class C_Pos_Single_Entry extends CI_Controller
{
		
	public function __construct(){
		parent::__construct();
		$this->load->database();
	    // if(!$this->loginmodel->is_logged_in())
	    //  {
	    //    redirect('login/login/');
	    //  }		
	    $this->load->model('pos/m_pos_single_entry');
	}

	public function index(){

		$status = $this->session->userdata('login_status');
		$login_id = $this->session->userdata('user_id');
		if(@$login_id && @$status == TRUE)
		{
			$id = NULL;
			$se_radio = NULL;
			
		$data['auto_num'] = $this->m_pos_single_entry->loading_no();
		$data['supplier_id'] = $this->m_pos_single_entry->get_supplier_id();
		$data['singlentry_all'] = $this->m_pos_single_entry->singlentry_view_all($id,$se_radio);
		
		// var_dump($supplier_id);exit;
		$data['pageTitle'] = 'POS Single Entry Form';
		$this->load->view('pos/v_pos_single_entry', $data);

		}else{
			redirect('login/login/');
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
				$data['singlentry_all'] = $this->m_pos_single_entry->singlentry_view_all($id,$se_radio);
				$data['pageTitle'] = 'POS Single Entry View';
				$this->load->view('pos/v_pos_add_single_entry', $data);
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
			$data['auto_num'] = $this->m_pos_single_entry->loading_no();
			$data['supplier_id'] = $this->m_pos_single_entry->get_supplier_id();
			$data['pageTitle'] = 'POS Add Single Entry Form';
			$this->load->view('pos/v_pos_single_entry', $data);

		}else{
			redirect('login/login/');
		}


	}
	public function deleteComplete(){

			$lz_manifest_id = $this->uri->segment(4);
			$action = 'unpost';
			$this->m_manf_load->manf_post($lz_manifest_id, $action);
			redirect('pos/c_pos_single_entry/filter_data');		
		
	}	
	public function deleteCreateNew(){

		$status = $this->session->userdata('login_status');
		$login_id = $this->session->userdata('user_id');
		if(@$login_id && @$status == TRUE)
		{

			$id = $this->uri->segment(4);
			$se_radio =NULL;
			$data['supplier_id'] = $this->m_pos_single_entry->get_supplier_id();
			$data['singlentry_all'] = $this->m_pos_single_entry->singlentry_view_all($id,$se_radio);
			$data['pageTitle'] = 'POS Single Entry Delete &amp; Create New';
			$this->load->view('pos/v_pos_single_entry_delete_create_new', $data);

		}else{
			redirect('login/login/');
		}


	}
	public function updateRecordView(){

			$id = $this->uri->segment(4);
			$se_radio =NULL;
			$data['supplier_id'] = $this->m_pos_single_entry->get_supplier_id();
			$data['singlentry_all'] = $this->m_pos_single_entry->singlentry_view_all($id,$se_radio);
			$data['pageTitle'] = 'Update Single Entry Form';
			$this->load->view('pos/v_pos_single_entry_edit', $data);


	}
		
	public function check_purchref_no(){

		$purch_ref = $this->input->post('purch_ref');
		 $this->m_pos_single_entry->purchase_ref_no($purch_ref);
	}

	public function add() {

		if($this->input->post('save')) {
			$rs= $this->m_pos_single_entry->add();
			$lz_manifest_id = $rs[0]['LZ_MANIFEST_ID'];
			$single_entry_id = $rs[0]['SINGLE_ENTRY_ID'];
	        $action = "post";
	        $this->m_manf_load->manf_post($lz_manifest_id,$action);
	        $this->m_single_entry->skip_test($lz_manifest_id);
			redirect('pos/c_pos_single_entry/filter_data');
		} else{
		redirect('pos/c_pos_single_entry');
		}

	 }
	public function update() {

		if($this->input->post('update')) {

			//$id = $this->uri->segment(4);
			//var_dump($id);exit;
			$rs = $this->m_pos_single_entry->update();
			$lz_manifest_id = $rs[0]['LZ_MANIFEST_ID'];
			$single_entry_id = $rs[0]['SINGLE_ENTRY_ID'];
			$barcode = $this->m_pos_single_entry->get_old_barcode($lz_manifest_id,$single_entry_id);
			$action = "unpost";
			$this->m_manf_load->manf_post($lz_manifest_id,$action);
			$action = "post";
	        $this->m_manf_load->manf_post($lz_manifest_id,$action);
	        $this->m_pos_single_entry->skip_test($lz_manifest_id);
			redirect('pos/c_pos_single_entry/filter_data');
		} else{
		redirect('pos/c_pos_single_entry');
		}

	 }
	public function updateRecord() {

		if($this->input->post('update')) {

			//$id = $this->uri->segment(4);
			//var_dump($id);exit;
			$this->m_pos_single_entry->updateRecord();
			redirect('pos/c_pos_single_entry/filter_data');
		} else{
		redirect('pos/c_pos_single_entry');
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
        //var_dump($part_no);exit;
        //var_dump($upc);exit;
        $data = $this->m_pos_single_entry->get_data($upc, $part_no);
        echo json_encode($data);
   		return json_encode($data);
    }
    public function single_entry_print(){
    	$lz_manifest_id = $this->uri->segment(4);
    	$result['pageTitle'] = 'POS Single Entry Manifest Sticker';
    	$result['data'] = $this->m_pos_single_entry->single_entry_print($lz_manifest_id);
    	$this->load->view('pos/v_pos_single_entry_print', $result);
    }
  public function manifest_print(){


          $single_entry_id = $this->uri->segment(4);
          // $manifest_id = $this->uri->segment(4);
          // $barcode = $this->uri->segment(6);

          //$manifest_id = $this->input->post('manifest_id');
          //var_dump($manifest_id);exit;
          $result = $this->m_pos_single_entry->single_entry_print($single_entry_id);
          
          $this->load->library('m_pdf');
		// to increse or decrese the width of barcode please set size attribute in barcode tag
          foreach($result as $data){
            $text = $data["ITEM_MT_DESC"];
            $item_desc =implode("<br/>", str_split($text, 40));
            $price = '$'.number_format((float)@$data["PRICE"],2,'.',',');
            $html ='<div style = "margin-left:-26px!important;">
                      
                  
                  <div style="margin-top:6px !important;width:222px;padding:0;font-size:10px;font-family:arial;">
                  <span style="margin-top:3px!important; font-size:10px!important;font-family:arial;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.
                    @$item_desc.'</span><br>
                    <div style="text-align:center;margin-top:5px!important;"><span style="font-size: 16px; text-align: center; border: 2px solid #000; padding: 3px;">Price: <b>'. $price.'</b>
                  </span></div><br>
				<div style="width:222px !important; text-align:center;" class="barcodecell"><barcode height="0.75" size="1.18" code="'.@$data["BARCODE_NO"].'" type="C128A" class="barcode" /></div>
				<div style="text-align:center;"><span># '.@$data["BARCODE_NO"].'
                  </span></div></div>
                </div>';
                //echo $html;exit;
            //generate the PDF from the given html
            $this->m_pdf->pdf->WriteHTML($html);
          }//end foreach
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "I");



  }     	
	
}
 ?>