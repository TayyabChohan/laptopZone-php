<?php
// defined('BASEPATH') OR exit('No direct script access allowed');


class getPrinterConfig extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http://example.com/index.php/welcome
     *  - or -
     *      http://example.com/index.php/welcome/index
     *  - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
        $this->load->model('androidauditapp/general_mod','handler');
        if (isset($_POST['type']))
        {
            $type = $_POST['type'];
            $data = $this->handler->get_printer_config($type);
            echo(json_encode(array("found" => true, "ip" => $data[0]["CONFIG_IP"], "port"=>$data[0]["CONFIG_PORT"] )));
        }
        else
        {
            echo(json_encode(array("found" => false )));
        }
    
    }
}
