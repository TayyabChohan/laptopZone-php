<?php 
require 'src/GoogleCloudVision.php';

class c_img_detect_text extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('ocr/m_img_detect_text');
	    if(!$this->loginmodel->is_logged_in())
	      {
	        redirect('login/login/');
	      } 
	}

  function index()
	{ 
	$track = $this->db->query("SELECT T.TRACKING_NO FROM LZ_BD_TRACKING_NO  T WHERE T.LABEL_TEXT is NULL")->result_array();
	      foreach($track as $trackcode){
      $dir = realpath(APPPATH . "../../") . "/item_pictures/ship_label/";
      //$trackcode['TRACKING_NO'];
         // echo $dir;
         // exit;
       $trackno = $trackcode['TRACKING_NO'];
       // echo $trackno;
       // exit;
	     if(is_dir($dir)){ 
	    $images = glob($dir."*.{JPG,jpg,GIF,gif,PNG,png,BMP,bmp,JPEG,jpeg}",GLOB_BRACE);
       if(count($images)>0){
     //echo '<pre>'; print_r($images); exit;

 //echo '<pre>'; print_r($images); exit;
	    $path = ""; 
	    foreach ($images as $image) {
     	$str=strpos($image, $trackno);
	    if( $str !== false) { 
	      $path = $image;
	       } 
	     } 
         $imgpath=$path;
        //echo $imgpath;
	     //exit;
         if(! empty($imgpath)){
         $path1 = str_replace(realpath(APPPATH . '../../'), trim('http://localhost', "/"), $imgpath);
	     //var_dump($path1);
	     //exit;
	     $data = $this->m_img_detect_text->callToApi($path1);
          
        $text = $data['responses'][0]['textAnnotations'][0]['description'];
        //echo $text;
        //exit;
        $this->db->query("UPDATE LZ_BD_TRACKING_NO TT SET TT.LABEL_TEXT='$text' WHERE TT.TRACKING_NO ='$trackno'"); 

          
		  //return json_encode($data);
         }//if empty
	     
       }// count if 
    
          
	   }// if(is_dir)
	     //
	}//end foreach
	echo 'Successfully Inserted Text';
}

}
