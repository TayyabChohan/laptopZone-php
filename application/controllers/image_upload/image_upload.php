<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
$con =  oci_connect('laptop_zone', 's', 'wizmen-pc/ORCL') or die ('Error connecting to oracle');
	/**
	* Listing Controller
	*/
	class Image_Upload extends CI_Controller
	{
		
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function index(){

	$this->load->view('seed/seed_edit');
	$this->load->model('image_upload/m_image');


	}
	public function img_insert(){

	$this->load->view('insert_image/v_img');
	//$this->load->model('image_upload/m_image');


	}

	public function delete_img(){
			$id = $this->input->post('id');
			  $this->m_image->delete($id);
			  //redirect('listing/listing');
			  
	}

	public function delete_all_images(){
			$item_id = $this->input->post('item_id');
			$manifest_id = $this->input->post('manifest_id');
			  $this->m_image->delete_all($item_id, $manifest_id);
			  //redirect('listing/listing');
			  
	}

	public function do_upload(){
			

		//print_r($_FILES);exit;
		

		$item_id = $this->input->post('pic_item_id');
		$manifest_id = $this->input->post('pic_manifest_id');

		//echo $manifest_id;
		//exit;
		// $item_id = 14700 ;
		// $manifest_id = 9636;
		for( $i= 0; $i < count ($_FILES['image']['name']); $i++ ) {

		  	if(isset($_FILES["image"])) {

		    @list(, , $imtype, ) = getimagesize($_FILES['image']['tmp_name'][$i]);
		    // Get image type.
		    // We use @ to omit errors
		    if ($imtype == 3){ // cheking image type
		      $ext="png";
		    }
		    elseif ($imtype == 2){
		      $ext="jpeg";
		    }
		    elseif ($imtype == 1){
		      $ext="gif";
		    }
		    else{
		      $msg = 'Error: unknown file format';
		       echo $msg;
		      exit;
		    }
		    if(getimagesize($_FILES['image']['tmp_name'][$i]) == FALSE){
		      echo "Please select an image.";
		    }
		    else{
		      $image = addslashes($_FILES['image']['tmp_name'][$i]);
		      $name = addslashes($_FILES['image']['name'][$i]);
		      
		     

		      $img_size = filesize($_FILES['image']['tmp_name'][$i]);

				$img_size = $img_size/1024;	    
				//var_dump($img_size);exit;  

		      if($img_size > 2048){

		      	$this->session->set_userdata('size_error', $name);

		      	 
		      }else{

				 $image = file_get_contents($image);
				 $name = addslashes($_FILES['image']['name'][$i]);

				 // saveimage($name,$image);
				 $this->m_image->save($name,$image,$item_id,$manifest_id,$i+1);
				 }



		      //var_dump($img_size);exit;

		      //$image= base64_encode($image);

		     // saveimage($name,$image);
		      
		    }
		  }
		}

		// $count = count($image[]);

		// for($i=0; $i<= $count; $i++){

		// 	$name = addslashes($_FILES['image']['name'][$i]);

		// }



	}
	public function sorting_order(){

		$sortable = $this->input->post('sortable');
		$this->m_image->update_order($sortable);

		// foreach($sortable as $sort_id){
		// 	echo $sort_id;
		// }
		// 		var_dump($sortable);exit;
		
	}

	

	}



 ?>