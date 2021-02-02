<?php

defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');

if($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
    exit;
}

//required for REST API
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/Format.php';



class RestGetController extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('ContactModel', 'cm');
    }

    public function get_unposted_items_get() {
       
        $get_items = $this->cm->get_unposted_items();

        if ($get_items) {
            $this->response($get_items, 200);
        } else {
            $this->response(NULL, 404);
        }
    }
    function get_obj_drop_get() {
       
        $get_obj_itm = $this->cm->obj_drop();

        if ($get_obj_itm) {
            $this->response($get_obj_itm, 200);
        } else {
            $this->response(NULL, 404);
        }
    }

    function add_item_POST(){
        return $this->response("my first api");
        
        // $barcodeNo = $this->input->post('barcodeNo');
        // $upcNum = $this->input->post('upcNum');
        // $this->response(NULL, 404);



    }

    function contact_get() {
        if (!$this->get('id')) {
            $this->response(NULL, 400);
        }

        $contact = $this->cm->get_contact($this->get('id'));

        if ($contact) {
            $this->response($contact, 200); // 200 being the HTTP response code
        } else {
            $this->response(NULL, 404);
        }
    }

}