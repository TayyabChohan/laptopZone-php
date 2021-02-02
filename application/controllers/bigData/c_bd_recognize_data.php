<?php
ini_set('memory_limit', '-1');
defined('BASEPATH') OR exit('No direct script access allowed');
class c_bd_recognize_data extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		 /*=============================================
        =  Section lz_bigData db connection block  =
        =============================================*/
        $CI = &get_instance();
        //setting the second parameter to TRUE (Boolean) the function will return the database object.
        $this->db2 = $CI->load->database('bigData', TRUE);
        /*=====  End of Section lz_bigData db connection block  ======*/
		if(!$this->loginmodel->is_logged_in())
		    {
		      redirect('login/login/');
		    }		
	}
	function index()
	{
		$result['pageTitle'] = 'Search &amp; Recognize Data';
		$result['getCategories'] = $this->m_bd_recognize_data->getCategories();
		$this->load->view("bigData/v_bd_recognize_data", $result);
	}
	function queryData()
	{
		if($this->input->post('bd_submit')){
			$result['pageTitle'] = 'Search &amp; Recognize Data';
			$result['getCategories'] = $this->m_bd_recognize_data->getCategories();
			$result['data'] = $this->m_bd_recognize_data->queryData();
			//var_dump($data);exit;
			$this->load->view("bigData/v_bd_recognize_data", $result);
		}else{
			redirect('bigData/c_bd_recognize_data');
		}
		
	}
	function createObject()
	{
		$result['pageTitle'] = 'Search & Recognize Object';
		$result['getCategories'] = $this->m_bd_recognize_data->getCategories();
		$this->load->view("bigData/v_bd_createObject", $result);
	}
	function queryObject()
	{
		//var_dump( $this->uri->segment(4));exit;
		if($this->input->post('bd_submit')){
			$keyword = $this->input->post('bd_search');
			$category_id = $this->input->post('bd_category');
			$this->session->set_userdata('search_key', $keyword);
			$this->session->set_userdata('category_id', $category_id);
			$result['pageTitle'] = 'Search &amp; Recognize Object';
			$result['getCategories'] = $this->m_bd_recognize_data->getCategories();
			$result['getDatatype'] = $this->m_bd_recognize_data->getDatatype();
			$result['getSpecifics'] = $this->m_bd_recognize_data->getSpecifics();
			$result['getStatistics'] = $this->m_bd_recognize_data->getStatistics();
			//var_dump($data);exit;
			$this->load->view("bigData/v_bd_createObject", $result);
		}elseif( !empty( $this->session->userdata('category_id') )){
			$keyword = $this->session->userdata('search_key');
			$category_id = $this->session->userdata('category_id');
			// $this->session->set_userdata('search_key', $keyword);
			// $this->session->set_userdata('category_id', $category_id);
			$result['pageTitle'] = 'Search &amp; Recognize Object';
			$result['getCategories'] = $this->m_bd_recognize_data->getCategories();
			$result['getDatatype'] = $this->m_bd_recognize_data->getDatatype();
			$result['getSpecifics'] = $this->m_bd_recognize_data->getSpecifics();
			$result['getStatistics'] = $this->m_bd_recognize_data->getStatistics();
			//$result['data'] = $this->m_bd_recognize_data->queryData();
			//var_dump($data);exit;
			$this->load->view("bigData/v_bd_createObject", $result);			
		}else{
			redirect('bigData/c_bd_recognize_data');
		}
		
	}
	function loadData()
	{
			$result['data'] = $this->m_bd_recognize_data->loadData();
			echo json_encode($result['data']);
      		return json_encode($result['data']);
			//var_dump($data);exit;
			//$this->load->view("bigData/v_bd_createObject", $result);
		
	}
	function saveObject()
	{
		if($this->input->post('recognizeObject')){
			$result['pageTitle'] = 'Search &amp; Recognize Object';
			$result['saveObject'] = $this->m_bd_recognize_data->saveObject();
			$category_id = $this->input->post('cat_id');
			$this->session->set_userdata('category_id', $category_id);
			$keyword = $this->input->post('bd_search');
			$this->session->set_userdata('search_key', $keyword);
			redirect('bigData/c_bd_recognize_data/queryObject/');
			// $result['getCategories'] = $this->m_bd_recognize_data->getCategories();
			// var_dump($result['saveObject']);exit;
			// $result['getDatatype'] = $this->m_bd_recognize_data->getDatatype();
			// $result['getSpecifics'] = $this->m_bd_recognize_data->getSpecifics_obj($result['saveObject']);
			// $result['data'] = $this->m_bd_recognize_data->queryData();
			// //var_dump($data);exit;
			// $this->load->view("bigData/v_bd_createObject", $result);
		}else{
			redirect('bigData/c_bd_recognize_data');
		}
		
	}
	function recognizeAll(){
		$result['data'] = $this->m_bd_recognize_data->recognizeAll();
		$category_id = $this->input->post('bd_category');
		$this->session->set_userdata('category_id', $category_id);
		$keyword = $this->input->post('bd_search');
		$this->session->set_userdata('search_key', $keyword);		
		echo json_encode($result['data']);
  		return json_encode($result['data']);
		
	}
	function verifyData()
	{
		$data['pageTitle'] = 'Verify Data';
		$data['getCategories'] = $this->m_bd_recognize_data->getCategories();
		//echo "<pre>";
		//print_r($result['getCategories']);
		//exit;
		$this->load->view("bigData/v_bd_verify_data", $data);
	}
	function search_verified_data()
	{
		$data['pageTitle'] = 'Search Verify Data';
		$bd_search_data = $this->input->post('bd_search');
		$bd_categoryId= $this->input->post('bd_category');
		$array_data=array('bd_search_data'=>$bd_search_data, 'bd_categoryId'=>$bd_categoryId);
		$this->session->set_userdata($array_data);
		$data['varifies']= $this->m_bd_recognize_data->verified_data();
		/*echo "<pre>";
		print_r($data['varifies']);
		exit;*/
		$data['getCategories'] = $this->m_bd_recognize_data->getCategories();
		$this->load->view("bigData/v_bd_verify_data_detail", $data);
	}
	function verifyDataDetail()
	{
		$data['pageTitle'] = 'Verify Data Detail';
		$lz_bd_cata_id = $this->uri->segment(4);
		$data['getSpecifics'] = $this->m_bd_recognize_data->getSpecifics();
		$data['varifiedData'] = $this->m_bd_recognize_data->varifiedData();
		//echo "<pre>";
		//print_r($data['getCategories']);
		//exit;
		$this->load->view("bigData/v_bd_verify_title", $data);
	}
	function verifyDataConfirm()
	{
		$data['pageTitle'] = 'Verify Data';
		$data['getCategories'] = $this->m_bd_recognize_data->verifyDataConfirm();
		$lz_bd_cata_id = $this->input->post('title_id');
		$category_id = $this->input->post('cat_id');
		redirect('bigData/c_bd_recognize_data/verifyDataDetail/'.$lz_bd_cata_id.'/'.$category_id);
		//echo "<pre>";
		//print_r($result['getCategories']);
		//exit;
		//$this->load->view("bigData/v_bd_verify_data", $data);
	}
	function autoFill()
	{
		$result = $this->m_bd_recognize_data->autoFill();
		echo json_encode($result);
  		return json_encode($result);
	}	
	public function recognizeWords(){
		$data['pageTitle'] = 'Recognize Leftover Title';
		$data['getCategories'] = $this->m_bd_recognize_data->getCategories();

		$this->load->view("bigData/v_bd_recognizeWords", $data);		
	}
	public function recognizeWordSearch(){
		if($this->input->post('bd_submit')){

			// $this->session->set_userdata('search_key', $keyword);
			// $this->session->set_userdata('category_id', $category_id);
			$result['pageTitle'] = 'Search - Recognize Leftover Title';
			$result['getCategories'] = $this->m_bd_recognize_data->getCategories();
			$result['data'] = $this->m_bd_recognize_data->titleData();
			//$result['getSpecifics'] = $this->m_bd_recognize_data->getSpecificsValues();
			//var_dump($data);exit;
			$this->load->view("bigData/v_bd_recognizeWords", $result);
		}		
	}
	public function getSpecificsValues(){
		$data = $this->m_bd_recognize_data->getSpecificsValues();
		echo json_encode($data);
  		return json_encode($data);		

	}
	public function addSpecificsAltVal(){
		$data = $this->m_bd_recognize_data->addSpecificsAltVal();
		echo json_encode($data);
  		return json_encode($data);		

	}
	public function addMpnData(){
		$data = $this->m_bd_recognize_data->addMpnData();
		echo json_encode($data);
  		return json_encode($data);			
	}	
	public function verifySingleTitle(){
		$data = $this->m_bd_recognize_data->verifySingleTitle();
		echo json_encode($data);
  		return json_encode($data);		

	}
	public function getCategorySpecifics(){
		$data = $this->m_bd_recognize_data->getCategorySpecifics();
		echo json_encode($data);
  		return json_encode($data);		

	}
	public function getGenWords(){
		$data = $this->m_bd_recognize_data->getGenWords();
		echo json_encode($data);
  		return json_encode($data);			
	}
	public function getSuggestedMPN(){
		$data = $this->m_bd_recognize_data->getSuggestedMPN();
		echo json_encode($data);
  		return json_encode($data);			
	}
	public function selectSugestedMPN(){
		$data = $this->m_bd_recognize_data->selectSugestedMPN();
		echo json_encode($data);
  		return json_encode($data);			
	}
}