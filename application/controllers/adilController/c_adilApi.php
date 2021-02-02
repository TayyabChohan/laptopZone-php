<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");

class c_adilApi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('adilModels/m_adilApi');
    }
    public function save_image_api_data()
    {
        $mt_ids_array = $this->m_adilApi->save_image_api_data();
        if($mt_ids_array){
        echo json_encode(array(
            'Results' => $mt_ids_array
        ));
        }else{
        echo json_encode(array(
            'Results' => "Something wrong"
        )); 
        }
    }

}