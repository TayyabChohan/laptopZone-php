<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class c_images extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('download');
    }
    public function index()
    {
        
//You have to pass Appropriate username, Password,Serveice name
//$db =  OCILogon('laptop_zone', 's', 'wizmen-pc/ORCL') or die ('Error connecting to oracle');
//$db = OCILogon("scott","tiger","grk");
        $query = $this->db->query('SELECT * FROM ITEM_PICTURES_MT WHERE ROWNUM=1');
            
            $img_data= $query->result();
            //$current_url = current_url();
      if(!empty($img_data)){
        foreach($img_data as $im){
                  $img = $im->ITEM_PIC->load();
                  $pic= base64_encode($img);
                  $image=$im->ITEM_PICT_DESC;
                  //$parts = explode(".", $image);
                  //$pic= base64_encode($img);
                 var_dump($pic);
             
                  exit;

                echo '<li id="$im->ITEM_PICTURE_ID">';
                  echo '<span class="tg-li">';
                    echo '<div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);">';                      
                      echo '<img class="sort_img up-img" id=""  src="data:image;base64,'.$pic.'.jpg'.' "/>';

                      echo '<div class="img_overlay">';
                        echo '<span><i class="fa fa-trash"></i></span>';
                      echo '</div>';

                    echo '</div>';                    
                 echo '</span>';                        
                echo '</li>';  
               //$f =site_url().'assets/lpimages/ggh.jpg';
               //$f = "D:\wamp\www\lpzone\assets\lpimages\ggh.jpg";

                /*$link=$current_url;
                $destdir = site_url().'assets/lpimages/';
                $content=$img=file_get_contents($link);
                file_put_contents($destdir.substr($link, strrpos($link,'/')), $pic.".jpg");
                $fp = fopen($destdir, "w");
                fwrite($fp, $content);
                fclose($fp);*/
               
                }
            }
                
        }
      } 