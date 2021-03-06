<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '-1');
class c_bigData extends CI_Controller
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
        // $qry = $this->db2->query("SELECT * FROM lz_bd_category");
        // print_r($qry->result());exit;

        /*=====  End of Section lz_bigData db connection block  ======*/		
		if(!$this->loginmodel->is_logged_in())
		    {
		      redirect('login/login/');
		    }		
	}
	public function index()
    {
        $result['pageTitle'] = 'eBay Category Data';
        //$result['data'] = $this->m_bigData->categoryListData();
        $this->load->view("bigData/v_categoryList", $result);
    }
    function loadData()
    {
        $result['data'] = $this->m_bigData->loadData();
        // echo "<pre>";
        // print_r($result['data']);
        // exit;
        echo json_encode($result['data']);
        return json_encode($result['data']);
        //var_dump($data);    exit;
        //$this->load->view("bigData/v_bd_createObject", $result);    
    }
	public function addCategoryData(){
		$result['pageTitle'] = 'Add Category Data';
		//$result['category_data'] = $this->m_bigData->addCategoryData();
		$this->load->view("bigData/v_addCategoryData", $result);		

	}
	public function saveCategoryData(){
		if($this->input->post('save_btn')){
			$this->m_bigData->saveCategoryData();
			redirect('bigData/c_bigData/addCategoryData', 'refresh');
		}
		
	}
	// public function showDetailData($category_id=''){
	// 	$result['pageTitle'] = 'Category Detail Data';
	// 	$result['category_data'] = $this->m_bigData->showDetailData($category_id);
	// 	$this->load->view("bigData/v_bigData", $result);			
	// }

	public function pullCategoryData($lz_bd_category_id='')
	{
		$result['data'] = $this->m_bigData->pullCategoryData($lz_bd_category_id);
		//var_dump($result['data'][0]['CATEGORY_ID']);exit;
		//$this->load->view('ebay/async/finditemswebhook',$result);
		$this->load->view('ebay/async/solditemsIncat',$result);
		redirect('bigData/c_bigData/showDetailData/'.$result['data'][0]['CATEGORY_ID']);
	}
	public function pullActiveData()
	{
		// $cat_id = $this->uri->segment(4);
  //   var_dump($cat_id);exit;
		//$this->load->view('ebay/async/dateloopscript');
		$this->load->view('ebay/async/dateloopscriptactive');
		//$result['data'] = $this->m_bigData->pullActiveData();
		//var_dump($result['data'][0]['CATEGORY_ID']);exit;
		//$this->load->view('ebay/async/finditemswebhook',$result);
		//$this->load->view('ebay/async/findactiveitems',$result);
		//redirect('bigData/c_bigData/showDetailData/'.$result['data'][0]['CATEGORY_ID']);
	}
	public function editBdCategory(){
		$perameter = $this->uri->segment(4);
		$result['data'] = $this->m_bigData->editBdCategory($perameter);
		$this->load->view('bigData/v_editCategoryData', $result);

	}
	public function updateBdCategory(){
		if($this->input->post('update_btn')){
			$this->m_bigData->updateBdCategory();
			
			redirect('bigData/c_bigData/', 'refresh');
		}
	}
	public function pullAllCategoryData(){
		$this->load->view('ebay/async/dateloopscript');
	}
	public function showDetailData(){
		$result['pageTitle'] = 'Category Detail Data';
		$this->load->view("bigData/v_bigData", $result);
	}
	public function categoryTreeview(){
		$result['pageTitle'] = 'Category Tree View';
		$result['data'] = $this->m_bigData->categoryTreeview();
		//$result['other_qry'] = $this->m_bigData->otherCategoriesTree();
		$this->load->view('bigData/v_categoryTreeview', $result);
	}
	public function addCategorytreeData(){
		if($this->input->post('add_category_id')){
			$category_id = $this->input->post('category_id');
			$category_id = explode(",", $category_id);
			$category_str =   implode(",", $category_id);
			// var_dump($category_str);
			//echo $category_str;
			$data['category_id'] = $category_str;

			$this->load->view('ebay/trading/getcategories', $data);			
		}

	}
	public function searchCategoryTree(){
		if($this->input->post('search_category')){
			$result['pageTitle'] = 'Search Category Tree View';
			$result['data'] = $this->m_bigData->searchCategoryTree();
			$this->load->view('bigData/v_SearchCategoryTreeview', $result);				
		}		
	}
	
	// public function deleteBdCategory(){
	// 	$perameter = $this->uri->segment(4);
	// 	var_dump($perameter);exit;

	// 	$this->m_bigData->deleteBdCategory($perameter);

	// 	redirect('bigData/c_bigData/','refresh');
	// }
	

}