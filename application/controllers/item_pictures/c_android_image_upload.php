<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');
	// $con =  oci_connect('laptop_zone', 's', 'wizmen-pc/ORCL') or die ('Error connecting to oracle');
	/**
	* Item Pictures Controller
	*/
	class C_android_image_upload extends CI_Controller
	{
	public function __construct()
	{
		parent::__construct();	
	}
	public function android_image_uploading()
	{
		$json = json_decode(file_get_contents('php://input'), true);
    	$name = $json["name"]; //within square bracket should be same as Utils.imageName & Utils.imageList
    	$imageList = $json["imageList"];
    	$folderName = $json["folderName"];
    	$path = "D:/wamp/www/item_pictures/dekitted_pictures/";
    	$live_path = $path.$folderName;
	    if (!is_dir($live_path))
	    {
            // create upload/images folder
            mkdir($live_path, 0777, true); 
            if(is_dir($live_path)){
            	mkdir($live_path.'/thumb', 0777, true); 
            }
	    }
	    $i = 0;
	    $response = array();
	    if (isset($imageList))
	     {
	        if (is_array($imageList))
	         {
	            foreach($imageList as $image)
	             {
	                $decodedImage = base64_decode("$image");
	                $return = file_put_contents($live_path."/".$name."~".$i.".JPG", $decodedImage);
	                // Ripping and thumbnail code goes here
	               
	                //////////////////////////////////
//	                resizeImage($name, $live_path);

			   		$this->load->library('image_lib');
			       /*====================================
			        =            image resize            =
			        ====================================*/
			        $config['image_library'] 	= 'GD2';
			        $config['source_image']  	= $live_path."/".$name."~".$i.".JPG";
			        $config['new_image']  		= $live_path."/".$name."~".$i.".JPG";
			        $config['maintain_ratio']   = true;
			        $config['width']     		= 1000;
			        $config['height']   		= 800;

			        $in =$this->image_lib->initialize($config); 
			        $result = $this->image_lib->resize($in);
			        $this->image_lib->clear();
			        /*====================================
			        =    image thumbnail creation        =
			        ====================================*/
			        $config['image_library'] = 'GD2';
			        $config['source_image']  = $live_path."/".$name."~".$i.".JPG";
			        $config['new_image']  = $live_path."/thumb/".$name."~".$i.".JPG";

			        $config['maintain_ratio']    = true;
			        $config['width']     = 100;
			        $config['height']   = 100;

			        //$config['quality']     = 50; this filter doesnt work
			        $in =$this->image_lib->initialize($config); 
			        $result = $this->image_lib->resize($in);
			        $this->image_lib->clear();	                

	                //////////////////////////////////
	                if($return !== false)
	                {
	                   $response['success'] = 1;
	                   $response['message'] = "Image Uploaded Successfully";
	                }
	                else
	                {
	                   $response['success'] = 0;
	                   $response['message'] = "Image Uploaded Failed";
	                }
	                $i++;
	            }
	        }
	    }
	    else
	    {
	        $response['success'] = 0;
	        $response['message'] = "List is empty.";
	    }
 
    	echo json_encode($response);
	}

	// public function resizeImage($name, $live_path)
 //   {
 //   	$this->load->library('image_lib');
 //       /*====================================
 //        =            image resize            =
 //        ====================================*/
 //        $config['image_library'] 	= 'GD2';
 //        $config['source_image']  	= $live_path;
 //        $config['new_image']  		= $live_path;
 //        $config['maintain_ratio']   = true;
 //        $config['width']     		= 1000;
 //        $config['height']   		= 800;

 //        $in =$this->image_lib->initialize($config); 
 //        $result = $this->image_lib->resize($in);
 //        $this->image_lib->clear();
 //        /*====================================
 //        =    image thumbnail creation        =
 //        ====================================*/
 //        $config['image_library'] = 'GD2';
 //        $config['source_image']  = $live_path;
 //        $config['new_image']  = $live_path."/thumb/";

 //        $config['maintain_ratio']    = true;
 //        $config['width']     = 100;
 //        $config['height']   = 100;

 //        //$config['quality']     = 50; this filter doesnt work
 //        $in =$this->image_lib->initialize($config); 
 //        $result = $this->image_lib->resize($in);
 //        $this->image_lib->clear();
 //   }
}

?>