
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '-1');
class c_tl_auction extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
        $this->load->model("catalogueToCash/m_tl_auction");
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

    $this->session->unset_userdata('auc_key'); 
    $result['pageTitle'] = 'TL Auction';
    $this->load->view('catalogueToCash/v_tl_auction',$result);
  }

  public function load_auction_data(){
    $this->session->unset_userdata('get_keywoerd'); 
    $data = $this->m_tl_auction->load_auction_data(); 
    echo json_encode($data);
    return json_encode($data);


  }public function move_data(){

    $data = $this->m_tl_auction->move_data(); 
    echo json_encode($data);
    return json_encode($data);


  }
  public function save_auc_obj(){

    $data = $this->m_tl_auction->save_auc_obj(); 
    echo json_encode($data);
    return json_encode($data);
  }


  public function load_auction_detail_data(){
    $result['pageTitle'] = 'Auction Detail';
    $result['data'] = $this->m_tl_auction->load_auction_detail_data(); 

    $this->load->view('catalogueToCash/v_tl_auction_det',$result);


  }
  public function getCategory(){

    $result['data'] = $this->m_tl_auction->getCategory(); 
    $this->load->view('API\getAuctionItemCat',$result);
  }
  public function getCatObj(){

    $data = $this->m_tl_auction->getCatObj(); 
    echo json_encode($data);
    return json_encode($data);
  }

  public function cash_item_brand(){
    $data = $this->m_tl_auction->cash_item_brand(); 
    echo json_encode($data);
    return json_encode($data);
  }
  public function cash_item(){
    $data = $this->m_tl_auction->cash_item(); 
    echo json_encode($data);
    return json_encode($data);
  }
public function del_audit_barcode(){
    $data = $this->m_tl_auction->del_audit_barcode(); 
    echo json_encode($data);
    return json_encode($data);
  }

}