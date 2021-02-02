<?php 
require 'src/GoogleCloudVision.php';

class img_detect_text extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('ocr/img_detect_text');
	    if(!$this->loginmodel->is_logged_in())
	      {
	        redirect('login/login/');
	      } 
	}

  function index()
	{ 
	  //$bar = $this->db->query("SELECT D.BARCODE_PRV_NO FROM LZ_DEKIT_US_DT D WHERE D.PIC_DATE_TIME IS NOT NULL AND D.PIC_TEXT IS NULL and D.BARCODE_PRV_NO=107336")->result_array();
	      //echo '</pre>';
	      //print_r($bar);
	      //exit;
	$bar = $this->db->query("SELECT D.BARCODE_PRV_NO FROM LZ_DEKIT_US_DT D WHERE D.PIC_DATE_TIME IS NOT NULL AND D.PIC_TEXT IS NULL")->result_array();
	      foreach($bar as $barcode){
      $dir = realpath(APPPATH . "../../") . "/item_pictures/dekitted_pictures/" . $barcode['BARCODE_PRV_NO'] ;
         //echo $dir;
         //exit;
       $barcod = $barcode['BARCODE_PRV_NO'];
	     if(is_dir($dir)){ 
	    $images = glob($dir."\*.{JPG,jpg,GIF,gif,PNG,png,BMP,bmp,JPEG,jpeg}",GLOB_BRACE);
       if(count($images)>0){  
     //echo '<pre>'; print_r($images); exit;
 //echo '<pre>'; print_r($images); exit;
	    $path = ""; 
	    foreach ($images as $image) {

	    	  //echo $image;
	    	  //exit;
	     if (strpos($image, "mpn_") !== false) { 
	      $path = $image;
	       } 
	     } 
         $imgpath=$path;
         if(! empty($imgpath)){
         $path1 = str_replace(realpath(APPPATH . '../../'), trim('http://localhost', "/"), $imgpath);
	     //var_dump($path1);
	     //exit;
	     $data = $this->m_ocr_detect_text->callToApi($path1);
          
        $text = $data['responses'][0]['textAnnotations'][0]['description'];
        //echo $text;
        //exit;
         $this->db->query("UPDATE LZ_DEKIT_US_DT SET PIC_TEXT = '$text'  WHERE BARCODE_PRV_NO = $barcod"); 

          
		  //return json_encode($data);
         }//if empty
	     
       }// count if 
    
          
	   }// if(is_dir)
	     //
	}//end foreach
	echo 'Successfully Inserted Text';
}

}
