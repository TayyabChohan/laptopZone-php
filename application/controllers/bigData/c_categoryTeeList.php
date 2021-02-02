<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '-1');
class c_categoryTeeList extends CI_Controller
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
        // $result['pageTitle'] = 'Categories Tree List';
  // //       //$result['data'] = $this->m_categoryTreeList->categoryTreeList();
         // $result['data'] = $this->m_categoryTreeList->treeList();

  // //       // $result['trees'] = $this->m_bigData->categoryTreeview();
  // // 		/*echo "<pre>";
		// // print_r($result['trees']->result_array());
		// // exit;*/
		// // // $result['maxDate'] = $this->m_categoryTreeList->lastRun($cat_id);
         // $this->load->view("bigData/v_tree", $result);
    }

    public function categoryTreeview(){
		$result['pageTitle'] = 'Category Tree View';
		$result['data'] = $this->m_categoryTreeList->treeList();
		//$result['other_qry'] = $this->m_bigData->otherCategoriesTree();
		$this->load->view('bigData/v_tree', $result);
	}
    public function showDetail($cat_id=''){
		$result['pageTitle'] = 'Category Tree View';
		$result['data'] = $this->m_categoryTreeList->categoryDetail($cat_id);
		// echo "<pre>";
		// print_r($result['data']);
		// exit;
		//$result['other_qry'] = $this->m_bigData->otherCategoriesTree();
		$this->load->view('bigData/v_bd_categoryDetail', $result);
	}

	public function searchCategoryTree(){
		if($this->input->post('search_category')){
			$result['pageTitle'] = 'Search Category Tree View';
			$result['data'] = $this->m_categoryTreeList->searchCategoryTree();
			$this->load->view('bigData/v_SearchCategoryTreeview', $result);				
		}		
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
	// public function lastRun($cat_id){

	// 	$data['data'] = $this->m_categoryTreeList->categoryDetail($cat_id);
	// 	// $date['Date'] = $this->m_categoryTreeList->lastRun($cat_id);
	// 	$this->load->view("bigData/v_tree", $data);
	// }
}