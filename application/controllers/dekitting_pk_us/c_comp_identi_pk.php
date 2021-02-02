<?php

class c_comp_identi_pk extends CI_Controller{
	public function __construct(){
	    parent::__construct();
	    $this->load->database();
	    $this->load->model('dekitting_pk_us/m_comp_identi_pk');
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
 	}

	public function index(){
		$result['pageTitle'] = 'Comp-Identification Pk';
		$result['items'] = $this->m_comp_identi_pk->get_items();
		$this->load->view('dekitting_pk_us/v_comp_identi_pk',$result);
	}
	public function get_mpns(){
		$data = $this->m_comp_identi_pk->get_mpns();
		echo json_encode($data);
        return json_encode($data);
	}
	public function update_mpn(){
		$data = $this->m_comp_identi_pk->update_mpn();
		echo json_encode($data);
        return json_encode($data);
	}
	public function get_mpn_data(){
		$data = $this->m_comp_identi_pk->get_mpn_data();
		echo json_encode($data);
        return json_encode($data);
	}
	public function addCataMpn(){
		$data = $this->m_comp_identi_pk->addCataMpn();
		echo json_encode($data);
        return json_encode($data);
	}
	public function showMpnDesc(){
		$data = $this->m_comp_identi_pk->showMpnDesc();
		echo json_encode($data);
        return json_encode($data);
	}
	public function showAllPictures(){
		$result['pageTitle'] = 'Show All Pictures';
		$this->load->view('dekitting_pk_us/v_show_all_pics',$result);

	}
	public function get_history(){
		$data = $this->m_comp_identi_pk->get_history();
		echo json_encode($data);
        return json_encode($data);
	}
	public function get_avg_sold_price(){
        // $catalogue_mt_id = $this->input->post('catalogue_mt_id');
        // $get_kw = $this->db->query("SELECT * FROM (SELECT U.KEYWORD FROM LZ_BD_RSS_FEED_URL U WHERE U.CATLALOGUE_MT_ID ='$catalogue_mt_id' ORDER BY U.FEED_URL_ID DESC) WHERE ROWNUM=1")->result_array();
        $MPN = $this->input->post('mpn');
        $MPN = trim(str_replace("  ", ' ', $MPN));
        $MPN = trim(str_replace(array("'"), "''", $MPN));
        $CATEGORY = $this->input->post('category_id');
        $CATEGORY = trim(str_replace("  ", ' ', $CATEGORY));
        $CATEGORY = trim(str_replace(array("'"), "''", $CATEGORY));  
        $CONDITION = $this->input->post('condition_id');
        
        // if(count($get_kw)>0)
        // {
        //     $data['key']=$get_kw[0]['KEYWORD'];  
        // }else
        if(!empty($MPN)){
            $data['key']=$MPN;
        }else{
            return 'EXCEPTION';
        }
        $data['condition']=$CONDITION;
        $data['category']=$CATEGORY;
        $data['multicond']=false;
        $data['result'] = $this->load->view('API/get_item_sold_price2', $data);
        return $data['result'];
    }



}
																		
