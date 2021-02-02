<?php 
require 'src/GoogleCloudVision.php';

class img_upload extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
	    if(!$this->loginmodel->is_logged_in())
	      {
	        redirect('login/login/');
	      } 
	}

  function index()
	{
		$this->load->view('ocr/v_image');
	  }

function ajax_upload()  
      {  
    $query = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 4"); 
    $master_qry = $query->result_array(); 
    $master_path = $master_qry[0]['MASTER_PATH'];
    $tid= $this->input->post('tracking_id');

   if(isset($_FILES["image_file"]["name"]))  
           {
           $directory = $master_path;

// Open a directory, and read its contents
           if (is_dir($directory)){
           if ($opendirectory = opendir($directory)){  
            if ($opendirectory = opendir($master_path)){
    while (($file = readdir($opendirectory)) !== false){
      if (strpos($file, $tid) !== false)
  {
     echo 'File Already Exists';
  //exit;
    $var=unlink($directory.$file);
      if($var){
      $this->db->query("UPDATE LZ_BD_TRACKING_NO TT SET TT.LABEL_TEXT = '' WHERE TT.TRACKING_NO ='$tid'");
       }//if
}
    }
    closedir($opendirectory);
  }
}
}
                $config['file_name']=$tid;
                $config['upload_path'] = $master_path;  
                $config['allowed_types'] = 'JPG|jpg|GIF|gif|PNG|png|BMP|bmp|JPEG|jpeg';  
                $this->load->library('upload', $config);  
                if(!$this->upload->do_upload('image_file'))  
                {  
                     echo $this->upload->display_errors();  
                }  
                else  
                {  
                     $data = $this->upload->data();
                }  
           }
              echo "Successfully Uploaded Image";
           }
}