<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '-1');
class C_pokemonCards extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    // $this->load->model("bigData/m_recog_title_mpn_kits");
    /*=============================================
    =  Section lz_bigData db connection block  =
    =============================================*/

    $this->load->model('pokemonCards/m_pokemonCards');
    // $qry = $this->db2->query("SELECT * FROM lz_bd_category");
    // print_r($qry->result());exit;

    /*=====  End of Section lz_bigData db connection block  ======*/    
    if(!$this->loginmodel->is_logged_in())
        {
          redirect('login/login/');
        }
    }
    public function index(){
        
        $result['pageTitle'] = 'Pokemon Cards';
        $this->load->view('pokemonCards/v_pokemonCards', $result); 

    }
    public function pokemonCardsData(){
        $data = $this->m_pokemonCards->displayAllData();
        echo json_encode($data);
        return json_encode($data);        
    }    
    public function pokemon_cards(){
        //$result['pageTitle'] = 'Pokemon Cards';
        //echo "string";
        $this->load->view('pokemon-tcg/examples/pokemon_cards');
    }   
}
