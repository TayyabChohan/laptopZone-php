<?php
// defined('BASEPATH') OR exit('No direct script access allowed');


class load_data extends CI_Controller {

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
        
        $location = "'PK','US'";
        $fromdate = '04/13/2018';
        $todate = '05/13/2019';

        if (isset($_POST['location']) && isset($_POST['fromdate']) && isset($_POST['todate']))
        {
            $location = $_POST['location'];
            if($location=='US')
            {
                $location = "'US'";
            }
            else if($location=='PK')
            {
                $location = "'PK'";
            }
            else if($location=='ALL')
            {
                $location = "'PK','US'";
            }
            
            $fromdate = $_POST['fromdate'];
            $todate = $_POST['todate'];
        }
        
        $this->load->model('androidauditapp/general_mod','handler');
        $data = $this->handler->getdata($location,$fromdate,$todate);
        for($i = 0; $i < count($data);$i++)
        { 
            $d_dir = "D:/wamp/www/item_pictures/";
            $s_dir = "D:/wamp/www/item_pictures/";
            $folder = $data[$i]["IMAGE"];
            $folder1 = $data[$i]["FOL_NAME1"];
            $d_dir = @$d_dir.@$folder.'/thumb/';
            $s_dir = @$s_dir.@$folder1.'/thumb/';
            if(is_dir(@$d_dir)){
                // var_dump($d_dir);
                 $iterator = new \FilesystemIterator(@$d_dir);
                   if(@$iterator->valid()){    
                       $m_flag = true;
                   }else{
                     $m_flag = false;
                   }
                }
                elseif(is_dir(@$s_dir)){
                 $iterator = new \FilesystemIterator(@$s_dir);
                     if (@$iterator->valid()){    
                       $m_flag = true;
                   }else{
                     $m_flag = false;
                   }
                }
            else{
                 $m_flag = false;
             }
             if($m_flag){
                if (is_dir($d_dir)){
                 $images = scandir($d_dir);
                 // Image selection and display:
                 //display first image
                 if (count($images) > 0){ // make sure at least one image exists
                     $url = @$images[2]; // first image
  
                     $data[$i]["IMAGE"] = $folder.'/thumb/'.$url;
                  
                 }
                 elseif(is_dir($s_dir)){
                  $images = scandir($s_dir);
                  // Image selection and display:
                  //display first image
                  if (count($images) > 0){ // make sure at least one image exists
                      $url = @$images[2]; // first image
   
                      $data[$i]["IMAGE"] = $folder1.'/thumb/'.$url;
                   
                       }
                   }
             }
  
             elseif(is_dir($s_dir)){
                  $images = scandir($s_dir);
                  // Image selection and display:
                  //display first image
                  if (count($images) > 0){ // make sure at least one image exists
                      $url = @$images[2]; // first image
   
                      $data[$i]["IMAGE"] = $folder1.'/thumb/'.$url;
                   
                       }
                   }
              }
        }
        echo(json_encode($data));
    }
}
