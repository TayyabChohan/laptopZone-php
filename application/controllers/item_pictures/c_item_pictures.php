<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
// $con =  oci_connect('laptop_zone', 's', 'wizmen-pc/ORCL') or die ('Error connecting to oracle');
	/**
	* Item Pictures Controller
	*/
	class C_Item_Pictures extends CI_Controller
	{
		
	public function __construct(){
		parent::__construct();
		$this->load->database();
		 if(!$this->loginmodel->is_logged_in())
		     {
		       redirect('login/login/');
		     }		
	}

	public function index(){
	$result['pageTitle'] = 'Item Pictures';

	$this->load->view('item_pictures/v_item_pictures', $result);


	}







	 public function sav_my_pic(){

	$child_barcode = $this->input->post('child_barcode');
	$get_url = $this->input->post('get_url');
	$get_pic = $this->input->post('get_pic');
	$stat_rot = $this->input->post('stat_rot');
	
	// exit;

	// $query = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 2");
 //    $specific_qry = $query->result_array();
 //    $master_path = $specific_qry[0]['MASTER_PATH'];
    //var_dump($master_path,$get_url,$get_pic);
   // $dir = preg_replace("/[\r\n]*/","",$get_url);
    $image_parts = explode(";base64,", $get_pic);
    $img = str_replace(' ', '+', $image_parts);    

    $dir = preg_replace("/[\r\n]*/","",$get_url);

    // $get_im_nam = explode("/", $dir);
    // $get_coun = (count($get_im_nam));
    // $get_finl_index = $get_im_nam[$get_coun-1];
    // var_dump($get_finl_index);
    //exit;

   // $sub_dir1 =$master_path.$child_barcode; //'E:/wamp/www/item_pictures/dekitted_pictures/125294/';

    // var_dump($img);
    // exit;
 //    if ( !file_exists($sub_dir1) ) {
 //     mkdir ($sub_dir1, 0744);
 // }
 	$label = imagecreatefromstring(base64_decode($img[1]));

	$rotated_imaged = imagerotate($label, $stat_rot, 0);
	$save = imagejpeg($rotated_imaged,$dir);


	if($save){

		$flag = 'true';
	}else{
		$flag = 'false';

	}
	echo json_encode($flag);
     return json_encode($flag);

	// if($save){

	// 	return true;
	// }else{
	// 	return false;
	// }
	
  	
 	 }
























	public function master_view(){
	$result['pageTitle'] = 'Master Pictures';

	$this->load->view('item_pictures/v_master_pictures', $result);


	}
	public function upload_spec_img(){
	$upc = trim($this->input->post('upc'));
	$mpn = trim($this->input->post('part_no'));
	$it_condition = trim($this->input->post('it_condition'));
	$condition_name = trim($this->input->post('condition_name'));
	$manifest_id = trim($this->input->post('manifest_id'));
	//var_dump($upc_mpn);exit;
	// $str = explode('~', $upc_mpn);
	// $upc = $str[0];
	// $mpn = $str[1];
	 $mpn = str_replace('/', '_', $mpn);

	// if(is_numeric($it_condition)){
 //        if($it_condition == 3000){
 //        	$it_condition = 'Used';
 //        }elseif($it_condition == 1000){
 //         	$it_condition = 'New'; 
 //        }elseif($it_condition == 1500){
 //         	$it_condition = 'New other'; 
 //        }elseif($it_condition == 2000){
 //          	$it_condition = 'Manufacturer refurbished';
 //        }elseif($it_condition == 2500){
 //         	$it_condition = 'Seller refurbished'; 
 //        }elseif($it_condition == 7000){
 //         	$it_condition = 'For parts or not working'; 
 //        }else{
 //            $it_condition = 'Used'; 
 //        }
 //    }else{// end main if
 //    	$it_condition  = ucfirst($it_condition);
 //    }
    $azRange = range('A', 'Z');
    $this->load->library('image_lib');
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
		    }else{
		      $image = addslashes($_FILES['image']['tmp_name'][$i]);
		      $name = addslashes($_FILES['image']['name'][$i]);

				    $query = $this->db->query("SELECT SPECIFIC_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
				    $specific_qry = $query->result_array();
				    $specific_path = $specific_qry[0]['SPECIFIC_PATH'];

					  $main_dir =  $specific_path.$upc."~".@$mpn;
					 if (is_dir($main_dir) === false){
					 		mkdir($main_dir);
					 	if(is_dir($main_dir)){
					 			$sub_dir1 = $main_dir.'/'.$condition_name;
					 			mkdir($sub_dir1);
					 			if(is_dir($sub_dir1)){
					 			$sub_dir2 = $sub_dir1.'/'.$manifest_id;
					 			mkdir($sub_dir2);
					 			//var_dump($new_dir.'/'.$condition_name);exit;
					 			if (file_exists($sub_dir2.'/'.$name)) {
								echo $name. " <b>already exists.</b> ";
								}
								else {
								$str = explode('.', $name);
								$extension = end($str);
								$characters = 'abcdefghijklmnopqrstuvwxyz0123456789'; 
								 $img_name = '';
								 $max = strlen($characters) - 1;
								 for ($k = 0; $k < 10; $k++) {
								      $img_name .= $characters[mt_rand(0, $max)];
								      
								 }
								 //$j=$i+1;
								move_uploaded_file($_FILES["image"]["tmp_name"][$i],$sub_dir2.'/'.$azRange[$i].'_'.$img_name.'.'.$extension);
								/*====================================
								=            image resize            =
								====================================*/
								$config['image_library'] = 'GD2';
							    $config['source_image']  = $sub_dir2.'/'.$azRange[$i].'_'.$img_name.'.'.$extension;
							    $config['new_image']  = $sub_dir2.'/'.$azRange[$i].'_'.$img_name.'.'.$extension;
							    $config['maintain_ratio']	 = true;
							    $config['width']	 = 1000;
							    $config['height']	= 800;
							    //$config['quality']	 = 50; this filter doesnt work
								$in =$this->image_lib->initialize($config); 
							    $result = $this->image_lib->resize($in);
								$this->image_lib->clear();
								
								/*=====  End of image resize  ======*/
								/*====================================
								=            image thumbnail creation            =
								====================================*/
								$config['image_library'] = 'GD2';
							    $config['source_image']  = $sub_dir2."/".$azRange[$i].'_'.$img_name.'.'.$extension;
							    if(!is_dir($sub_dir2."/thumb")){
									mkdir($sub_dir2."/thumb");
								}
							    $config['new_image']  = $sub_dir2."/thumb/".$azRange[$i].'_'.$img_name.'.'.$extension;
							    $config['maintain_ratio']	 = true;
							    $config['width']	 = 100;
							    $config['height']	= 100;
							    
							    //$config['quality']	 = 50; this filter doesnt work
								$in =$this->image_lib->initialize($config); 
							    $result = $this->image_lib->resize($in);
								$this->image_lib->clear();
								
								/*=====  End of image thumbnail creation  ======*/
								}
					 		}
					 	}
					 }else{
					 	if(is_dir($main_dir.'/'.$condition_name) === false){
					 		mkdir($main_dir.'/'.$condition_name);
					 	}
					 	if(is_dir($main_dir.'/'.$condition_name.'/'. $manifest_id) === false){
					 		mkdir($main_dir.'/'.$condition_name.'/'. $manifest_id);
					 	}
					 	if(file_exists($main_dir.'/'.$condition_name.'/'. $manifest_id.'/'.$name)) {
								echo "<script>alert('already exists.');</script>";
								}
								else {
								$str = explode('.', $name);
								$extension = end($str);
								$characters = 'abcdefghijklmnopqrstuvwxyz0123456789'; 
								 $img_name = '';
								 $max = strlen($characters) - 1;
								 for ($k = 0; $k < 10; $k++) {
								      $img_name .= $characters[mt_rand(0, $max)];
								      
								 }

								 //$azRange[$i]=$i+1;
								move_uploaded_file($_FILES["image"]["tmp_name"][$i],$main_dir.'/'.$condition_name.'/'. $manifest_id.'/'.$azRange[$i].'_'.$img_name.'.'.$extension);
								/*====================================
								=            image resize            =
								====================================*/
								$config['image_library'] = 'GD2';
							    $config['source_image']  = $main_dir.'/'.$condition_name.'/'. $manifest_id.'/'.$azRange[$i].'_'.$img_name.'.'.$extension;
							    $config['new_image']  = $main_dir.'/'.$condition_name.'/'. $manifest_id.'/'.$azRange[$i].'_'.$img_name.'.'.$extension;
							    $config['maintain_ratio']	 = true;
							    $config['width']	 = 1000;
							    $config['height']	= 800;
							    //$config['quality']	 = 50; this filter doesnt work
								$in =$this->image_lib->initialize($config); 
							    $result = $this->image_lib->resize($in);
								$this->image_lib->clear();
								//var_dump($main_dir.'/'.$condition_name.'/'. $manifest_id);exit;
								/*=====  End of image resize  ======*/
								/*====================================
								=            image thumbnail creation            =
								====================================*/
								$config['image_library'] = 'GD2';
							    $config['source_image']  = $main_dir.'/'.$condition_name.'/'. $manifest_id."/".$azRange[$i].'_'.$img_name.'.'.$extension;
							    if(!is_dir($main_dir.'/'.$condition_name.'/'. $manifest_id."/thumb")){
									mkdir($main_dir.'/'.$condition_name.'/'. $manifest_id."/thumb");
								}
							    $config['new_image']  = $main_dir.'/'.$condition_name.'/'. $manifest_id."/thumb/".$azRange[$i].'_'.$img_name.'.'.$extension;
							    $config['maintain_ratio']	 = true;
							    $config['width']	 = 100;
							    $config['height']	= 100;
							    
							    //$config['quality']	 = 50; this filter doesnt work
								$in =$this->image_lib->initialize($config); 
							    $result = $this->image_lib->resize($in);
								$this->image_lib->clear();
								
								/*=====  End of image thumbnail creation  ======*/
								}
					 }
				//}size else
		    }
		  }
		}
	}
	public function img_thumb(){
	$main_dir = 'D:/item_pictures/master_pictures';
	$directories = glob($main_dir . '/*' , GLOB_ONLYDIR);
	$this->load->library('image_lib');
	foreach ($directories as $dir) {
		$sub_directories = glob($dir . '/*' , GLOB_ONLYDIR);
		//var_dump($sub_directories);exit;
		//$this->load->library('image_lib');
		foreach ($sub_directories as $sub_dir) {

			if (is_dir($sub_dir)){

				if ($dh = opendir($sub_dir)){
					//var_dump(readdir($dh));//exit;
					while (($file = readdir($dh)) !== false){
						$parts = explode(".", $file);

                         if (is_array($parts) && strlen($parts[0]) > 1 && $parts[0] != 'thumb'){

                            $extension = end($parts);
                            if(!empty($extension)){
                            	$img_path = $sub_dir.'/'.$parts['0'].'.'.$extension;

                            	$config['image_library'] = 'gd2';
							    $config['source_image']  = $img_path;
							    if(!is_dir($sub_dir."/thumb")){
									mkdir($sub_dir."/thumb");
								}
							    $config['new_image']  = $sub_dir."/thumb/".$parts['0'].'.'.$extension;
							    //var_dump($img_path,$config['new_image']);//exit;
							    //$config['create_thumb']	 = true;
							    $config['maintain_ratio']	 = true;
							    $config['width']	 = 100;
							    $config['height']	= 100;
							    //$this->load->library('image_lib',$config); 
								$in =$this->image_lib->initialize($config); 
							    //$result = 
							    if ( ! $this->image_lib->resize($in))
								{
							        echo $this->image_lib->display_errors();
								}
							    //$this->image_lib->resize($in);
								$this->image_lib->clear();
                            }
                         }
					}//while close
					closedir($dh);
				}//opendir if
		    }//isdir if
		}//sub_dir foreach
	}//dir foreach
	
}
/***************************************************
* FOR REDUCING THE SIZE OF IMAGES IN DIRECTORIES
****************************************************/
public function img_rip(){
	$main_dir = 'D:/item_pictures/master_pictures';
	$directories = glob($main_dir . '/*' , GLOB_ONLYDIR);
	$this->load->library('image_lib');
	foreach ($directories as $dir) {
		$sub_directories = glob($dir . '/*' , GLOB_ONLYDIR);
		//var_dump($sub_directories);exit;
		//$this->load->library('image_lib');
		foreach ($sub_directories as $sub_dir) {

			if (is_dir($sub_dir)){

				if ($dh = opendir($sub_dir)){
					//var_dump(readdir($dh));//exit;
					while (($file = readdir($dh)) !== false){
						$parts = explode(".", $file);

                         if (is_array($parts) && strlen($parts[0]) > 1 && $parts[0] != 'thumb'){

                            $extension = end($parts);
                            if(!empty($extension)){
                            	$img_path = $sub_dir.'/'.$parts['0'].'.'.$extension;

                            	$config['image_library'] = 'gd2';
							    $config['source_image']  = $img_path;
							   /* if(!is_dir($sub_dir."/thumb")){
									mkdir($sub_dir."/thumb");
								}*/
							    $config['new_image']  = $sub_dir."/".$parts['0'].'.'.$extension;
							    //var_dump($img_path,$config['new_image']);//exit;
							    //$config['create_thumb']	 = true;
							    $config['maintain_ratio']	 = true;
							    $config['width']	 = 1000;
							    $config['height']	= 800;
							    //$this->load->library('image_lib',$config); 
								$in =$this->image_lib->initialize($config); 
							    //$result = 
							    if ( ! $this->image_lib->resize($in))
								{
							        echo $this->image_lib->display_errors();
								}
							    //$this->image_lib->resize($in);
								$this->image_lib->clear();
                            }
                         }
					}//while close
					closedir($dh);
				}//opendir if
		    }//isdir if
		}//sub_dir foreach
	}//dir foreach
	
}
	public function img_upload(){
	$upc_mpn = trim($this->input->post('upc~mpn'));
	$str = explode('~', $upc_mpn);
	$upc = $str[0];
	$mpn = $str[1];
	$mpn = str_replace('/', '_', $mpn);

	$condition_id  = $this->input->post('it_condition');
	$condition_name  = trim($this->input->post('condition_name'));
	//var_dump($condition_name);exit;
	$lz_item_id = $this->input->post('lz_item_id');
	$lz_manifest_id = $this->input->post('lz_manifest_id');

  	$master_bin_id = trim(strtoupper($this->input->post('bin_id')));
  	$this->session->set_userdata('master_bin_id', $master_bin_id);
  	$pic_bar_code = $this->input->post('pic_bar_code');
  	$remarks = $this->input->post('remarks');
  	$current_bin = trim(strtoupper($this->input->post('current_bin')));

  	$user = $this->session->userdata('user_id');
	date_default_timezone_set("America/Chicago");
	$trans_date_time = date("Y-m-d H:i:s");
	$trans_date_time ="TO_DATE('".$trans_date_time."', 'YYYY-MM-DD HH24:MI:SS')";

	$this->load->library('image_lib');
	//var_dump($lz_item_id, $lz_manifest_id);exit;

	// if(is_numeric($it_condition)){
 //        if($it_condition == 3000){
 //        	$it_condition = 'Used';
 //        }elseif($it_condition == 1000){
 //         	$it_condition = 'New'; 
 //        }elseif($it_condition == 1500){
 //         	$it_condition = 'New other'; 
 //        }elseif($it_condition == 2000){
 //          	$it_condition = 'Manufacturer refurbished';
 //        }elseif($it_condition == 2500){
 //         	$it_condition = 'Seller refurbished'; 
 //        }elseif($it_condition == 7000){
 //         	$it_condition = 'For parts or not working'; 
 //        }else{
 //            $it_condition = 'Used'; 
 //        }
 //    }else{// end main if
 //    	$it_condition  = ucfirst($it_condition);
 //    }
    $it_condition  = $condition_name;
    $azRange = range('A', 'Z');
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
		    }else{
			        $image = addslashes($_FILES['image']['tmp_name'][$i]);
					$name = addslashes($_FILES['image']['name'][$i]);
				    $query = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
				    $master_qry = $query->result_array();
				    $master_path = $master_qry[0]['MASTER_PATH'];
					$new_dir = $master_path.$upc."~".@$mpn;//."/".@$it_condition;

				 	if(!is_dir($new_dir)){
				 		mkdir($new_dir);
				 	}
				 	if(!is_dir($new_dir.'/'.$it_condition)){
				 			mkdir($new_dir.'/'.$it_condition);
				 	}
		 			if (file_exists($new_dir.'/'.$it_condition.'/'. $name)) {
					echo $name. " <b>already exists.</b> ";
					}else{
						$str = explode('.', $name);
							$extension = end($str);
						$characters = 'abcdefghijklmnopqrstuvwxyz0123456789'; 
						 $img_name = '';
						 $max = strlen($characters) - 1;
						 for ($k = 0; $k < 10; $k++) {
						      $img_name .= $characters[mt_rand(0, $max)];
						      
						 }
						 //$j=$azRange[$i];
						move_uploaded_file($_FILES["image"]["tmp_name"][$i],$new_dir.'/'.$it_condition.'/'.$azRange[$i].'_'.$img_name.'.'.$extension);
						/*====================================
						=            image resize            =
						====================================*/
						$config['image_library'] = 'GD2';
					    $config['source_image']  = $new_dir."/".$it_condition."/".$azRange[$i].'_'.$img_name.'.'.$extension;
					    $config['new_image']  = $new_dir."/".$it_condition."/".$azRange[$i].'_'.$img_name.'.'.$extension;
					    $config['maintain_ratio']	 = true;
					    $config['width']	 = 1000;
					    $config['height']	= 800;
					    //$config['create_thumb']	 = true;
					    //$config['quality']	 = 50; this filter doesnt work
						$in =$this->image_lib->initialize($config); 
					    $result = $this->image_lib->resize($in);
						$this->image_lib->clear();
						
						/*=====  End of image resize  ======*/
						/*====================================
						=            image thumbnail creation            =
						====================================*/
						$config['image_library'] = 'GD2';
					    $config['source_image']  = $new_dir."/".$it_condition."/".$azRange[$i].'_'.$img_name.'.'.$extension;
					    if(!is_dir($new_dir."/".$it_condition."/thumb")){
							mkdir($new_dir."/".$it_condition."/thumb");
						}
					    $config['new_image']  = $new_dir."/".$it_condition."/thumb/".$azRange[$i].'_'.$img_name.'.'.$extension;
					    $config['maintain_ratio']	 = true;
					    $config['width']	 = 100;
					    $config['height']	= 100;
					    
					    //$config['quality']	 = 50; this filter doesnt work
						$in =$this->image_lib->initialize($config); 
					    $result = $this->image_lib->resize($in);
						$this->image_lib->clear();
						
						/*=====  End of image thumbnail creation  ======*/
					}
		    	}//else if getimage size
		  }//if isset file image
		}//main for loop

		/*==== Bin Assignment to item barcode start ====*/

		// for New entered Bin
		$bin_id_qry = $this->db->query("SELECT BIN_ID, BIN_NAME FROM (SELECT B.BIN_ID, B.BIN_TYPE  || '-' || B.BIN_NO BIN_NAME FROM BIN_MT B) WHERE BIN_NAME = '$master_bin_id'");

		$result = $bin_id_qry->result_array();
		$new_bin_id = @$result[0]['BIN_ID'];

		if(!empty($current_bin)){
			// for Old or current entered Bin
			$current_bin_qry = $this->db->query("SELECT BIN_ID, BIN_NAME FROM (SELECT B.BIN_ID, B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME FROM BIN_MT B) WHERE BIN_NAME = '$current_bin'");

			$result = $current_bin_qry->result_array();
			$old_loc_id = @$result[0]['BIN_ID'];

		}else{
			$old_loc_id = "";
		}
		//var_dump($lz_item_id, $lz_manifest_id);exit;
		if(!(empty($new_bin_id)))
		{
			$barcode_query = $this->db->query("SELECT B.BARCODE_NO FROM LZ_BARCODE_MT B WHERE B.ITEM_ID = $lz_item_id  AND B.LZ_MANIFEST_ID = $lz_manifest_id  AND B.CONDITION_ID IN(SELECT DISTINCT B.CONDITION_ID FROM LZ_BARCODE_MT B WHERE B.ITEM_ID = $lz_item_id  AND B.LZ_MANIFEST_ID = $lz_manifest_id ) ORDER BY B.CONDITION_ID");	
			$barcodes =  $barcode_query->result_array();
			/*echo "<pre>";
			print_r($barcodes); 
			exit;*/
			if (count($barcodes) > 0)
				 {
					foreach ($barcodes as $barcode)
					 {
					 	 $barcode_val = $barcode['BARCODE_NO'];
					 	$qr = $this->db->query("UPDATE LZ_BARCODE_MT SET BIN_ID = $new_bin_id WHERE BARCODE_NO = $barcode_val");
						if($qr){
						    	$log_id_qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_LOC_TRANS_LOG','LOC_TRANS_ID') ID FROM DUAL"); 
						    	$rs = $log_id_qry->result_array();
						    	$loc_trans_id = @$rs[0]['ID'];							

								$this->db->query("INSERT INTO LZ_LOC_TRANS_LOG (LOC_TRANS_ID, TRANS_DATE_TIME, BARCODE_NO, TRANS_BY_ID, NEW_LOC_ID, OLD_LOC_ID, REMARKS, OLD_ROW_ID, NEW_ROW_ID) VALUES($loc_trans_id, $trans_date_time, $barcode_val, $user, '$new_bin_id', '$old_loc_id', '$remarks',null,null)"); 
						    }
					}
				}
		}


		/*==== Bin Assignment to item barcode end ====*/

		/*==== Item Pictures Log for pictures start ====*/
				// For condition column changed condition into id
		        // if($it_condition == 'Used'){
		        // 	@$condition_id = 3000;
		        // }elseif($it_condition == 'New'){
		        //  	@$condition_id = 1000; 
		        // }elseif($it_condition == 'New other'){
		        //  	@$condition_id = 1500; 
		        // }elseif($it_condition == 'Manufacturer refurbished'){
		        //   	@$condition_id = 2000;
		        // }elseif($it_condition == 'Seller refurbished'){
		        //  	@$condition_id = 2500; 
		        // }elseif($it_condition == 'For parts or not working'){
		        //  	@$condition_id = 7000; 
		        // }

		        if(!empty($upc) && !empty($mpn)){
		        	$pic_log_check = $this->db->query("SELECT I.PIC_ID FROM LZ_ITEM_PICTURES I WHERE I.UPC = '$upc' AND I.MPN = '$mpn' AND I.CONDITION = '$condition_id' ");
		        }elseif(empty($upc)){
		        	$pic_log_check = $this->db->query("SELECT I.PIC_ID FROM LZ_ITEM_PICTURES I WHERE I.MPN = '$mpn' AND I.CONDITION = '$condition_id' AND I.UPC IS NULL");
		        }elseif(empty($mpn)){
		        	$pic_log_check = $this->db->query("SELECT I.PIC_ID FROM LZ_ITEM_PICTURES I WHERE I.UPC = '$upc' AND I.CONDITION = '$condition_id' AND I.MPN IS NULL");
		        }
		        
		        if($pic_log_check->num_rows() == 0){

			        $pic_log_qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_ITEM_PICTURES','PIC_ID') ID FROM DUAL"); 
			        $rs = $pic_log_qry->result_array();
			        $pic_id = @$rs[0]['ID'];							

					$this->db->query("INSERT INTO LZ_ITEM_PICTURES (PIC_ID, UPC, MPN, CONDITION, PIC_DATE, PIC_BY, CONDITION_DESC) VALUES($pic_id, '$upc', '$mpn', '$condition_id', $trans_date_time, $user, '$it_condition')"); 	
		        }else{
			        $rs = $pic_log_check->result_array();
			        $pic_id = @$rs[0]['PIC_ID'];			        	

		        	$this->db->query("UPDATE LZ_ITEM_PICTURES SET PIC_UPDATE_DATE = $trans_date_time, PIC_UPDATE_BY = $user WHERE PIC_ID =  $pic_id");
		        }


				/*==== Item Pictures Log for pictures end ====*/

		/*======Approval check for listing=====*/
			// $it_condition = $this->input->post('it_condition');
			// 	if(!is_numeric($it_condition)){
			//         if($it_condition == 'Used'){
			//         	$it_condition = 3000;
			//         }elseif($it_condition == 'New'){
			//          	$it_condition = 1000; 
			//         }elseif($it_condition == 'New other'){
			//          	$it_condition = 1500; 
			//         }elseif($it_condition == 'Manufacturer refurbished'){
			//           	$it_condition = 2000;
			//         }elseif($it_condition == 'Seller refurbished'){
			//          	$it_condition = 2500; 
			//         }elseif($it_condition == 'For parts or not working'){
			//          	$it_condition = 7000; 
			//         }else{
			//             $it_condition = 'Used'; 
			//         }
			//     }		
			$seed_id = $this->db->query("SELECT S.SEED_ID FROM LZ_ITEM_SEED S WHERE S.ITEM_ID = $lz_item_id AND S.LZ_MANIFEST_ID = $lz_manifest_id AND S.DEFAULT_COND = $condition_id");
			$seed_id =  $seed_id->result_array();
			$seed_id = $seed_id[0]['SEED_ID'];

			date_default_timezone_set("America/Chicago");
			 $list_date = date("Y-m-d H:i:s");
		     $ins_date = "TO_DATE('".$list_date."', 'YYYY-MM-DD HH24:MI:SS')";
			 $entered_by = $this->session->userdata('user_id');



	 	 	$query = $this->db->query("UPDATE LZ_ITEM_SEED S SET S.APPROVED_DATE = $ins_date, S.APPROVED_BY = $entered_by WHERE S.SEED_ID = $seed_id");	
		/*======Approval check for listing=====*/	 	 		

	}
	public function save_pics_master(){

  	$upc = trim($this->input->post('upc'));
  	$mpn = trim($this->input->post('part_no'));
  	$condition_id = $this->input->post('it_condition');
  	$condition_name = trim($this->input->post('condition_name'));
  	$manifest_id = $this->input->post('manifest_id');
  	$item_id = $this->input->post('item_id'); 

  	$master_bin_id = trim(strtoupper($this->input->post('bin_id')));
  	$this->session->set_userdata('master_bin_id', $master_bin_id);
  	$pic_bar_code = $this->input->post('pic_bar_code');
  	$remarks = $this->input->post('remarks');
  	$current_bin = trim(strtoupper($this->input->post('current_bin')));

  	$user = $this->session->userdata('user_id');
	date_default_timezone_set("America/Chicago");
	$trans_date_time = date("Y-m-d H:i:s");
	$trans_date_time ="TO_DATE('".$trans_date_time."', 'YYYY-MM-DD HH24:MI:SS')";

	$mpn = str_replace('/', '_', $mpn);

	$it_condition  = $condition_name;
	// if(is_numeric($it_condition)){
 //        if($it_condition == 3000){
 //        	$it_condition = 'Used';
 //        }elseif($it_condition == 1000){
 //         	$it_condition = 'New'; 
 //        }elseif($it_condition == 1500){
 //         	$it_condition = 'New other'; 
 //        }elseif($it_condition == 2000){
 //          	$it_condition = 'Manufacturer refurbished';
 //        }elseif($it_condition == 2500){
 //         	$it_condition = 'Seller refurbished'; 
 //        }elseif($it_condition == 7000){
 //         	$it_condition = 'For parts or not working'; 
 //        }else{
 //            $it_condition = 'Used'; 
 //        }
 //    }else{// end main if
 //    	$it_condition  = ucfirst($it_condition);
 //    }


	    $query = $this->db->query("SELECT * FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
	    $master_qry = $query->result_array();
	    $master_path = $master_qry[0]['MASTER_PATH'];
	    $live_path = $master_qry[0]['LIVE_PATH'];

		$this->load->library('image_lib'); 
		 $dir = $live_path;
					// Open a directory, and read its contents
			if (is_dir($dir)){
				$images = glob($dir."\*.{JPG,jpg,GIF,gif,PNG,png,BMP,bmp,JPEG,jpeg}",GLOB_BRACE);
                    //if ($dh = glob($dir . "*.jpg")){
                      $i=0;
                       $azRange = range('A', 'Z');
                      foreach($images as $image){
			  //if ($dh = opendir($dir)){
			  	// $i=1;
			    //while (($file = readdir($dh)) !== false){
					$parts = explode(".", $image);
					if (is_array($parts) && count($parts) > 1){
					    $extension = end($parts);
					    if(!empty($extension)){
					    	//echo '<img style ="width:250px;" src="./images/'.$parts['0'].'.'.$extension.'" /><br />';

								//$str = explode('.', $parts['0']);
								//$extension = end($str);
								$characters = 'abcdefghijklmnopqrstuvwxyz0123456789'; 
								 $img_name = '';
								 $max = strlen($characters) - 1;
								 for ($k = 0; $k < 10; $k++) {
								      $img_name .= $characters[mt_rand(0, $max)];
								      
								 }
								 //$j=$i+1;									
									
									//$new_dir = "D:/test_img";
								$sub_dir = $master_path.$upc."~".@$mpn;
								$final_dir = $sub_dir.'/'.$it_condition;
								if(!is_dir($sub_dir)){
									mkdir($sub_dir);
								}
								if(!is_dir($final_dir)){
									mkdir($final_dir);
								}

								$img_moved = rename($parts['0'].".".$extension, $final_dir."/".$azRange[$i]."_".$img_name.".".$extension);

							    $config['image_library'] = 'gd2';
							    $config['source_image']  = $final_dir."/".$azRange[$i]."_".$img_name.".".$extension;
							    $config['new_image']  = $final_dir."/".$azRange[$i]."_".$img_name.".".$extension;
							    $config['maintain_ratio']	 = true;
							    $config['width']	 = 1000;
							    $config['height']	= 800;
								$in =$this->image_lib->initialize($config); 
							    $result = $this->image_lib->resize($in);
								$this->image_lib->clear();
								/*====================================
								=            image thumbnail creation            =
								====================================*/
								$config['image_library'] = 'GD2';
							    $config['source_image']  = $final_dir."/".$azRange[$i].'_'.$img_name.'.'.$extension;
							    if(!is_dir($final_dir."/thumb")){
									mkdir($final_dir."/thumb");
								}
							    $config['new_image']  = $final_dir."/thumb/".$azRange[$i].'_'.$img_name.'.'.$extension;
							    $config['maintain_ratio']	 = true;
							    $config['width']	 = 100;
							    $config['height']	= 100;
							    
							    //$config['quality']	 = 50; this filter doesnt work
								$in =$this->image_lib->initialize($config); 
							    $result = $this->image_lib->resize($in);
								$this->image_lib->clear();
								
								/*=====  End of image thumbnail creation  ======*/

								$i++;
						}
					}

			    }//end while/foreach

				/*==== Bin Assignment to item barcode start ====*/

				// for New entered Bin
				$bin_id_qry = $this->db->query("SELECT BIN_ID, BIN_NAME FROM (SELECT B.BIN_ID, B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME FROM BIN_MT B) WHERE BIN_NAME = '$master_bin_id'");

				$result = $bin_id_qry->result_array();
				$new_bin_id = @$result[0]['BIN_ID'];

				if(!empty($current_bin)){
					// for Old or current entered Bin
					$current_bin_qry = $this->db->query("SELECT BIN_ID, BIN_NAME FROM (SELECT B.BIN_ID, B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME FROM BIN_MT B) WHERE BIN_NAME = '$current_bin'");

					$result = $current_bin_qry->result_array();
					$old_loc_id = @$result[0]['BIN_ID'];

				}else{
					$old_loc_id = "";
				}
		
				if(!(empty($new_bin_id))){
					$barcode_query = $this->db->query("SELECT B.BARCODE_NO, B.CONDITION_ID FROM LZ_BARCODE_MT B WHERE B.ITEM_ID = $item_id  AND B.LZ_MANIFEST_ID = $manifest_id  AND B.CONDITION_ID IN(SELECT DISTINCT B.CONDITION_ID FROM LZ_BARCODE_MT B WHERE B.ITEM_ID = $item_id  AND B.LZ_MANIFEST_ID = $manifest_id ) ORDER BY B.CONDITION_ID");	
					$barcodes =  $barcode_query->result_array();
					if (count($barcodes) > 0)
					 {
						foreach ($barcodes as $barcode)
						 {
						 	$barcode_val = $barcode['BARCODE_NO'];
							$qr = $this->db->query("UPDATE LZ_BARCODE_MT SET BIN_ID = $new_bin_id WHERE BARCODE_NO = $barcode_val ");

							if($qr){
						        $log_id_qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_LOC_TRANS_LOG','LOC_TRANS_ID') ID FROM DUAL"); 
						        $rs = $log_id_qry->result_array();
						        $loc_trans_id = @$rs[0]['ID'];							
								$this->db->query("INSERT INTO LZ_LOC_TRANS_LOG (LOC_TRANS_ID, TRANS_DATE_TIME, BARCODE_NO, TRANS_BY_ID, NEW_LOC_ID, OLD_LOC_ID, REMARKS, OLD_ROW_ID, NEW_ROW_ID) VALUES($loc_trans_id, $trans_date_time, $barcode_val, $user, '$new_bin_id', '$old_loc_id', '$remarks',null,null)"); 
							}
						 }
					 }

										

				}
				/*==== Bin Assignment to item barcode end ====*/
				/*==== Item Pictures Log for pictures start ====*/
				// For condition column changed condition into id
		        // if($it_condition == 'Used'){
		        // 	@$condition_id = 3000;
		        // }elseif($it_condition == 'New'){
		        //  	@$condition_id = 1000; 
		        // }elseif($it_condition == 'New other'){
		        //  	@$condition_id = 1500; 
		        // }elseif($it_condition == 'Manufacturer refurbished'){
		        //   	@$condition_id = 2000;
		        // }elseif($it_condition == 'Seller refurbished'){
		        //  	@$condition_id = 2500; 
		        // }elseif($it_condition == 'For parts or not working'){
		        //  	@$condition_id = 7000; 
		        // }
				
		        if(!empty($upc) && !empty($mpn)){
		        	$pic_log_check = $this->db->query("SELECT I.PIC_ID FROM LZ_ITEM_PICTURES I WHERE I.UPC = '$upc' AND I.MPN = '$mpn' AND I.CONDITION = '$condition_id' ");
		        }elseif(empty($upc)  && !empty($mpn)){
		        	$pic_log_check = $this->db->query("SELECT I.PIC_ID FROM LZ_ITEM_PICTURES I WHERE I.MPN = '$mpn' AND I.CONDITION = '$condition_id' AND I.UPC IS NULL");
		        }elseif(empty($mpn)  && !empty($upc)){
		        	$pic_log_check = $this->db->query("SELECT I.PIC_ID FROM LZ_ITEM_PICTURES I WHERE I.UPC = '$upc' AND I.CONDITION = '$condition_id' AND I.MPN IS NULL");
		        }		      

		        if($pic_log_check->num_rows() == 0){

			        $pic_log_qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_ITEM_PICTURES','PIC_ID') ID FROM DUAL"); 
			        $rs = $pic_log_qry->result_array();
			        $pic_id = @$rs[0]['ID'];							

					$this->db->query("INSERT INTO LZ_ITEM_PICTURES (PIC_ID, UPC, MPN, CONDITION, PIC_DATE, PIC_BY, CONDITION_DESC) VALUES($pic_id, '$upc', '$mpn', '$condition_id', $trans_date_time, $user, '$it_condition')"); 	
		        }else{
			        $rs = $pic_log_check->result_array();
			        $pic_id = @$rs[0]['PIC_ID'];			        	

		        	$this->db->query("UPDATE LZ_ITEM_PICTURES SET PIC_UPDATE_DATE = $trans_date_time, PIC_UPDATE_BY = $user WHERE PIC_ID =  $pic_id");
		        }


				/*==== Item Pictures Log for pictures end ====*/				    
			    //closedir($dh);
			    //exit;
			 // }// sub if
			}//main if
	    if($img_moved){
		/*======Approval check for listing=====*/	    	
			// $it_condition = $this->input->post('it_condition');
				// if(!is_numeric($it_condition)){
			 //        if($it_condition == 'Used'){
			 //        	$it_condition = 3000;
			 //        }elseif($it_condition == 'New'){
			 //         	$it_condition = 1000; 
			 //        }elseif($it_condition == 'New other'){
			 //         	$it_condition = 1500; 
			 //        }elseif($it_condition == 'Manufacturer refurbished'){
			 //          	$it_condition = 2000;
			 //        }elseif($it_condition == 'Seller refurbished'){
			 //         	$it_condition = 2500; 
			 //        }elseif($it_condition == 'For parts or not working'){
			 //         	$it_condition = 7000; 
			 //        }else{
			 //            $it_condition = 'Used'; 
			 //        }
			 //    }				
			$seed_id = $this->db->query("SELECT S.SEED_ID FROM LZ_ITEM_SEED S WHERE S.ITEM_ID = $item_id AND S.LZ_MANIFEST_ID = $manifest_id AND S.DEFAULT_COND = $condition_id");
			$seed_id =  $seed_id->result_array();
			$seed_id = $seed_id[0]['SEED_ID'];

			date_default_timezone_set("America/Chicago");
			 $list_date = date("Y-m-d H:i:s");
		     $ins_date = "TO_DATE('".$list_date."', 'YYYY-MM-DD HH24:MI:SS')";
			 $entered_by = $this->session->userdata('user_id');



	 	 	$query = $this->db->query("UPDATE LZ_ITEM_SEED S SET S.APPROVED_DATE = $ins_date, S.APPROVED_BY = $entered_by WHERE S.SEED_ID = $seed_id");
	 	 	/*======End of Approval check for listing=====*/

	    	$data = true;
        	echo json_encode($data);
        	return json_encode($data);
    	}else{
    		$data = true;
        	echo json_encode($data);
        	return json_encode($data);
    	}			
		
	}
	public function save_pics_specifics(){

  	$upc = $this->input->post('upc');
  	$mpn = $this->input->post('part_no');
  	$it_condition = $this->input->post('it_condition');
  	$condition_name = trim($this->input->post('condition_name'));
	$manifest_id  = $this->input->post('manifest_id');

	// if(is_numeric($it_condition)){
 //        if($it_condition == 3000){
 //        	$it_condition = 'Used';
 //        }elseif($it_condition == 1000){
 //         	$it_condition = 'New'; 
 //        }elseif($it_condition == 1500){
 //         	$it_condition = 'New other'; 
 //        }elseif($it_condition == 2000){
 //          	$it_condition = 'Manufacturer refurbished';
 //        }elseif($it_condition == 2500){
 //         	$it_condition = 'Seller refurbished'; 
 //        }elseif($it_condition == 7000){
 //         	$it_condition = 'For parts or not working'; 
 //        }else{
 //            $it_condition = 'Used'; 
 //        }
 //    }else{// end main if
 //    	$it_condition  = ucfirst($it_condition);
 //    }

		$query = $this->db->query("SELECT SPECIFIC_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
		$specific_qry = $query->result_array();
		$specific_path = $specific_qry[0]['SPECIFIC_PATH'];
		//$new_dir = "D:/item_pictures/master_pictures/".$upc."~".$mpn;
		$dir1 = $specific_path.$upc."~".@$mpn;
		$dir2 = $specific_path.$upc."~".@$mpn."/".$condition_name;
		$dir = $specific_path.$upc."~".@$mpn."/".$condition_name."/".$manifest_id;
		if(!is_dir($dir1)){
			mkdir($dir1);
		}
		if(!is_dir($dir2)){
			mkdir($dir2);
		}
		if(!is_dir($dir)){
			mkdir($dir);
		}
					// Open a directory, and read its contents
			if (is_dir($dir)){

			  if ($dh = opendir($dir)){

			  	$i=1;
			    while (($file = readdir($dh)) !== false){
			    	//var_dump($dir);exit;
					$parts = explode(".", $file);
					if (is_array($parts) && count($parts) > 1){
					    $extension = end($parts);
					    if(!empty($extension)){
					    	//echo '<img style ="width:250px;" src="./images/'.$parts['0'].'.'.$extension.'" /><br />';

								//$str = explode('.', $parts['0']);
								//$extension = end($str);
								$characters = 'abcdefghijklmnopqrstuvwxyz0123456789'; 
								 $img_name = '';
								 $max = strlen($characters) - 1;
								 for ($k = 0; $k < 10; $k++) {
								      $img_name .= $characters[mt_rand(0, $max)];
								      
								 }
								 $j=$i+1;									
									
									$new_dir = "D:/test_img";
							

								 $img_moved = rename($dir."/".$parts['0'].".".$extension, $new_dir."/".$j."_".$img_name.".".$extension);
								  
								 $this->load->library('image_lib'); 
							    $config['image_library'] = 'gd2';
							    $config['source_image']  = $new_dir."/".$j."_".$img_name.".".$extension;
							    $config['new_image']  = $new_dir."/".$j."_".$img_name.".".$extension;
							    $config['maintain_ratio']	 = true;
							    $config['width']	 = 1900;
							    $config['height']	= 800;
								$in =$this->image_lib->initialize($config); 
							    $result = $this->image_lib->resize($in);
								$this->image_lib->clear();
								$i++;
						}
					}

			    }//end while
			    closedir($dh);
			    //exit;
			  }// sub if
			}//main if
	    if($img_moved){
	    	$data = true;
        	echo json_encode($data);
        	return json_encode($data);
    	}else{
    		$data = true;
        	echo json_encode($data);
        	return json_encode($data);
    	}			
		
	}		
	public function item_search(){
		if($this->input->post('barcode_search')){
			$barcode = trim($this->input->post('pic_bar_code'));
			$result['data'] = $this->m_item_pictures->item_search($barcode);
			//var_dump($result['data']['search_query'][0]['ITEM_CONDITION']);exit;
			if(@$result['data'] === TRUE){
				//var_dump('if');exit;
				$result['error_msg'] = null;
				$result['barcode_error'] = 'Item Barcode not found. Please enter a valid Barcode.';
				$this->load->view('item_pictures/v_item_pictures',$result);
			}elseif(!empty(@$result['data']['search_query'][0]['ITEM_CONDITION']))
			{
				//var_dump($result['data']);exit;
				$result['error_msg'] = null;
				$result['pageTitle'] = 'Item Pictures';
				$this->load->view('item_pictures/v_item_pictures',$result);
			}else{

				$result['error_msg'] = 'Item Condition not found. Please add Item Test and condtion from Tester Screen.';
				$result['pageTitle'] = 'Item Pictures';
				$this->load->view('item_pictures/v_item_pictures',$result);
			}

		}elseif($this->input->post('master_search')) {
			$barcode = trim($this->input->post('pic_bar_code'));
			//var_dump($barcode);exit;
			$result['data'] = $this->m_item_pictures->item_search($barcode);
			// var_dump($result['data']);exit;
			// $result['pageTitle'] = 'Master Pictures';
			// $this->load->view('item_pictures/v_master_pictures',$result);
			if(@$result['data'] === TRUE){
				//var_dump('if');exit;
				$result['error_msg'] = null;
				$result['barcode_error'] = 'Item Barcode not found. Please enter a valid Barcode.';
				$this->load->view('item_pictures/v_master_pictures',$result);
			}elseif(!empty(@$result['data']['search_query'][0]['ITEM_CONDITION']))
			{
				//var_dump($result['data']);exit;
				$result['error_msg'] = null;
				$result['pageTitle'] = 'Master Pictures';
				$this->load->view('item_pictures/v_master_pictures',$result);
			}else{
				
				$result['error_msg'] = 'Item Condition not found. Please add Item Test and condtion from Tester Screen.';
				$result['pageTitle'] = 'Master Pictures';
				$this->load->view('item_pictures/v_master_pictures',$result);
			}

		}elseif($this->uri->segment(4)){

			$barcode = trim($this->uri->segment(4));
			$result['data'] = $this->m_item_pictures->item_search($barcode);

			// $result['pageTitle'] = 'Master Pictures';
			// $this->load->view('item_pictures/v_master_pictures',$result);

			if(!empty(@$result['data']['search_query'][0]['ITEM_CONDITION']))
			{
				//var_dump($result['data']);exit;
				$result['error_msg'] = null;
				$result['pageTitle'] = 'Master Pictures';
				$this->load->view('item_pictures/v_master_pictures',$result);
			}else{
				
				$result['error_msg'] = 'Item Condition not found. Please add Item Test and condtion from Tester Screen.';
				$result['pageTitle'] = 'Master Pictures';
				$this->load->view('item_pictures/v_master_pictures',$result);
			}			
		}

	}
	public function item_pic_spec(){
		if($this->uri->segment(4)){
			$barcode = trim($this->uri->segment(4));
			$result['data'] = $this->m_item_pictures->item_search($barcode);
			$result['pageTitle'] = 'Item Pictures';
			$this->load->view('item_pictures/v_item_pictures',$result);
		}
	}
	public function pic_rename(){
		if($this->input->post('rename')){
			//var_dump($this->input->post('rename'));exit;
			$dir = "D:\wamp\www\laptopzone\assets\item_pic";
			// Open a directory, and read its contents
			if (is_dir($dir)){
			  if ($dh = opendir($dir)){
			  	$i=1;
			    while (($file = readdir($dh)) !== false){
					$parts = explode(".", $file);
					if (is_array($parts) && count($parts) > 1){
					    $extension = end($parts);
					    if(!empty($extension)){
					    	//echo '<img style ="width:250px;" src="./images/'.$parts['0'].'.'.$extension.'" /><br />';

									$barcode = trim($this->input->post('bar_code'));
									
									$new_dir = "D:/wamp/www/laptopzone/assets/item_pic_rename"."/".$barcode;
									//var_dump($barcode,$dir,$new_dir);exit;
									if( is_dir($new_dir) === false )
									{
									    mkdir($new_dir);
									}
							  	// if(file_exists($new_dir."/".$barcode."_".$i.".".$extension))
							  	// {

							  	// }
								  rename($dir."/".$parts['0'].".".$extension, $new_dir."/".$barcode."_".$i.".".$extension);
								  
								 $this->load->library('image_lib'); 
							    $config['image_library'] = 'gd2';
							    $config['source_image']  = $new_dir."/".$barcode."_".$i.".".$extension;
							    $config['new_image']  = $new_dir."/".$barcode."_".$i.".".$extension;
							    $config['maintain_ratio']	 = true;
							    $config['width']	 = 1000;
							    $config['height']	= 800;
								$in =$this->image_lib->initialize($config); 
							    $result = $this->image_lib->resize($in);
								$this->image_lib->clear();
								$i++;
						}
					}

			    }//end while
			    closedir($dh);
			    //exit;
			  }// sub if
			}//main if
		}//end submit check if

	}//end function


	public function uploadimage()
    {
    $image_name =	$this->input->post('barcode');
    //var_dump($image_name);exit;
	$this->load->library('image_lib'); 
    $config['image_library'] = 'gd2';
    $config['source_image']  = './uploads/'.$image_name;
    $config['new_image']  = './uploads/new_'.$image_name;
    
    $config['width']	 = 1000;
    $config['height']	= 800;
    
    $this->image_lib->initialize($config); 
   
    $this->image_lib->resize();
	
		//$this->load->view('image_view');

    }
  public function master_img_delete(){
    $master_url = $this->input->post('master_url');
    if (is_readable($master_url) && unlink($master_url)) {
      $data = true;
        echo json_encode($data);
        return json_encode($data);
    } else {
        $data = false;
        echo json_encode($data);
        return json_encode($data);
    }
    
        
  }

  public function delete_all_master(){
  	$upc = $this->input->post('upc');
  	$mpn = $this->input->post('part_no');
  	$mpn = str_replace('/', '_', $mpn);
  	$it_condition = $this->input->post('it_condition');
  	$condition_name = trim($this->input->post('condition_name'));
	// if(is_numeric($it_condition)){
	//         if($it_condition == 3000){
	//         	$it_condition = 'Used';
	//         }elseif($it_condition == 1000){
	//          	$it_condition = 'New'; 
	//         }elseif($it_condition == 1500){
	//          	$it_condition = 'New other'; 
	//         }elseif($it_condition == 2000){
	//           	$it_condition = 'Manufacturer refurbished';
	//         }elseif($it_condition == 2500){
	//          	$it_condition = 'Seller refurbished'; 
	//         }elseif($it_condition == 7000){
	//          	$it_condition = 'For parts or not working'; 
	//         }else{
	//             $it_condition = 'Used'; 
	//         }
	//     }else{// end main if
	//     	$it_condition  = ucfirst($it_condition);
	//     }   	

    $query = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
    $master_qry = $query->result_array();
    $master_path = $master_qry[0]['MASTER_PATH'];

    $dir = $master_path.$upc."~".@$mpn."/".$condition_name;
    //var_dump($dir); exit;
	// Open a directory, and read its contents
	if (is_dir($dir)){
	  if ($dh = opendir($dir)){
	  	//$i=1;
	    while (($file = readdir($dh)) !== false){
			$parts = explode(".", $file);
			if (is_array($parts) && count($parts) > 1){
			    $extension = end($parts);
			    if(!empty($extension)){
			    	
			    	//$img_name = explode('_', $master_reorder[$i-1]);
			    	//rename($dir."/".$parts['0'].".".$extension, $new_dir."/".$barcode."_".$i.".".$extension);
						 @$img_order = unlink($dir."/".$parts['0'].".".$extension);
						 @$thumb_order = unlink($dir."/thumb/".$parts['0'].".".$extension);

						//$i++;
				}
			}

	    }//end while

	    closedir($dh);
	    // unlink($dir);
	    // unlink($master_path.$upc."~".@$mpn);

	    //exit;
	  }// sub if
	}//main if 
	    if(@$img_order && @$thumb_order){
	    	$data = true;
        	echo json_encode($data);
        	return json_encode($data);
    	}else{
    		$data = true;
        	echo json_encode($data);
        	return json_encode($data);
    	}		      
  }


  public function specific_img_delete(){
    $specific_url = $this->input->post('specific_url');
    $parts = explode("/", $specific_url);
    //var_dump($parts);exit;
    $thumbnail_url = $parts[0].'/'.$parts[1].'/'.$parts[2].'/'.$parts[3].'/'.$parts[4].'/'.$parts[5].'/'.$parts[6].'/thumb/'.$parts[7];
    //var_dump($thumbnail_url); exit;
    //D:/item_pictures/master_pictures/888462647823~MJ2R2LL_A/Used/A_eerlh1drf7.png 
    if (is_readable($specific_url) && unlink($specific_url) && unlink($thumbnail_url)) {
      $data = true;
        echo json_encode($data);
        return json_encode($data);
    } else {
        $data = false;
        echo json_encode($data);
        return json_encode($data);
    }
    
        
  }
public function delete_all_specific(){
  	$upc = $this->input->post('upc');
  	$mpn = $this->input->post('part_no');
  	$it_condition = $this->input->post('it_condition');
  	$condition_name = trim($this->input->post('condition_name'));
  	$manifest_id = $this->input->post('manifest_id');

    $query = $this->db->query("SELECT SPECIFIC_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
    $specific_qry = $query->result_array();
    $specific_path = $specific_qry[0]['SPECIFIC_PATH']; 
	$mpn = str_replace('/', '_', $mpn);
	// if(is_numeric($it_condition)){
	//         if($it_condition == 3000){
	//         	$it_condition = 'Used';
	//         }elseif($it_condition == 1000){
	//          	$it_condition = 'New'; 
	//         }elseif($it_condition == 1500){
	//          	$it_condition = 'New other'; 
	//         }elseif($it_condition == 2000){
	//           	$it_condition = 'Manufacturer refurbished';
	//         }elseif($it_condition == 2500){
	//          	$it_condition = 'Seller refurbished'; 
	//         }elseif($it_condition == 7000){
	//          	$it_condition = 'For parts or not working'; 
	//         }else{
	//             $it_condition = 'Used'; 
	//         }
	//     }else{// end main if
	//     	$it_condition  = ucfirst($it_condition);
	//     } 	
    $dir = $specific_path.$upc."~".@$mpn."/".$condition_name."/".$manifest_id;
	// Open a directory, and read its contents
	if (is_dir($dir)){
	  if ($dh = opendir($dir)){
	  	//$i=1;
	    while (($file = readdir($dh)) !== false){
			$parts = explode(".", $file);
			if (is_array($parts) && count($parts) > 1){
			    $extension = end($parts);
			    if(!empty($extension)){
			    	
			    		//$img_name = explode('_', $master_reorder[$i-1]);
			    	//rename($dir."/".$parts['0'].".".$extension, $new_dir."/".$barcode."_".$i.".".$extension);
						 @$img_order = unlink($dir."/".$parts['0'].".".$extension);


						//$i++;
				}
			}

	    }//end while
	    closedir($dh);

	    //exit;
	  }// sub if
	}//main if 
	    if(@$img_order){
	    	$data = true;
        	echo json_encode($data);
        	return json_encode($data);
    	}else{
    		$data = true;
        	echo json_encode($data);
        	return json_encode($data);
    	}		


        
  }  
  public function master_sorting_order(){
  	$master_reorder = $this->input->post('master_reorder');
  	$upc = $this->input->post('upc');
  	$mpn = $this->input->post('part_no');
  	$condition_name = trim($this->input->post('condition_name'));
  	$it_condition = $this->input->post('it_condition');
	// if(is_numeric($it_condition)){
	//         if($it_condition == 3000){
	//         	$it_condition = 'Used';
	//         }elseif($it_condition == 1000){
	//          	$it_condition = 'New'; 
	//         }elseif($it_condition == 1500){
	//          	$it_condition = 'New other'; 
	//         }elseif($it_condition == 2000){
	//           	$it_condition = 'Manufacturer refurbished';
	//         }elseif($it_condition == 2500){
	//          	$it_condition = 'Seller refurbished'; 
	//         }elseif($it_condition == 7000){
	//          	$it_condition = 'For parts or not working'; 
	//         }else{
	//             $it_condition = 'Used'; 
	//         }
	//     }else{// end main if
	//     	$it_condition  = ucfirst($it_condition);
	//     }  	
  	//var_dump($upc."_".$part_no."_".$it_condition);exit;

    $query = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
    $master_qry = $query->result_array();
    $master_path = $master_qry[0]['MASTER_PATH'];
	$mpn = str_replace('/', '_', $mpn);

	$dir = $master_path.$upc."~".@$mpn."/".$condition_name;//

	
	
	// Open a directory, and read its contents
	if (is_dir($dir)){
	  if ($dh = opendir($dir)){
	  	$azRange = range('A', 'Z');
	  	$i=0;
	    while (($file = readdir($dh)) !== false){
			$parts = explode(".", $file);
			if (is_array($parts) && count($parts) > 1){
			    $extension = end($parts);
			    if(!empty($extension)){
			    	//echo '<img style ="width:250px;" src="./images/'.$parts['0'].'.'.$extension.'" /><br />';

							// $barcode = trim($this->input->post('bar_code'));
							
							// $new_dir = "D:/wamp/www/laptopzone/assets/item_pic_rename"."/".$barcode;
							// //var_dump($barcode,$dir,$new_dir);exit;
							// if( is_dir($new_dir) === false )
							// {
							//     mkdir($new_dir);
							// }
					  	// if(file_exists($new_dir."/".$barcode."_".$i.".".$extension))
					  	// {

					  	// }
						$characters = 'abcdefghijklmnopqrstuvwxyz0123456789'; 
						 $img_name = '';
						 $max = strlen($characters) - 1;
						 for ($k = 0; $k < 10; $k++) {
						      $img_name .= $characters[mt_rand(0, $max)];
						      
						 }			    	
			    		//$img_name = explode('_', $master_reorder[$i-1]);
						 @$img_order = rename($dir."/".$master_reorder[$i], $dir."/".$azRange[$i]."_".$img_name.".".$extension);
						 //var_dump($img_order);exit;
						 //var_dump($dir."/".$master_reorder[$i-1], $dir."/".$i."_".$img_name);exit;
						  //var_dump($barcode);exit;
						  
						//  $this->load->library('image_lib'); 
					 //    $config['image_library'] = 'gd2';
					 //    $config['source_image']  = $new_dir."/".$barcode."_".$i.".".$extension;
					 //    $config['new_image']  = $new_dir."/".$barcode."_".$i.".".$extension;
					 //    $config['maintain_ratio']	 = true;
					 //    $config['width']	 = 1200;
					 //    $config['height']	= 1200;
						// $in =$this->image_lib->initialize($config); 
					 //    $result = $this->image_lib->resize($in);
						// $this->image_lib->clear();
						$i++;
				}
			}

	    }//end while
	    closedir($dh);

	    //exit;
	  }// sub if
	}//main if 
	    if(@$img_order){
	    	$data = true;
        	echo json_encode($data);
        	return json_encode($data);
    	}else{
    		$data = false;
        	echo json_encode($data);
        	return json_encode($data);
    	}		 	

  } 
  public function specific_sorting_order(){
  	$specific_order = $this->input->post('specific_order');
  	$upc = $this->input->post('upc');
  	$mpn = $this->input->post('part_no');
  	$it_condition = $this->input->post('it_condition');
  	$condition_name = trim($this->input->post('condition_name'));
	// if(is_numeric($it_condition)){
	//         if($it_condition == 3000){
	//         	$it_condition = 'Used';
	//         }elseif($it_condition == 1000){
	//          	$it_condition = 'New'; 
	//         }elseif($it_condition == 1500){
	//          	$it_condition = 'New other'; 
	//         }elseif($it_condition == 2000){
	//           	$it_condition = 'Manufacturer refurbished';
	//         }elseif($it_condition == 2500){
	//          	$it_condition = 'Seller refurbished'; 
	//         }elseif($it_condition == 7000){
	//          	$it_condition = 'For parts or not working'; 
	//         }else{
	//             $it_condition = 'Used'; 
	//         }
	//     }else{// end main if
	//     	$it_condition  = ucfirst($it_condition);
	//     }   	
  	$manifest_id = $this->input->post('manifest_id');
  	//var_dump($upc."_".$part_no."_".$it_condition);exit;

    $query = $this->db->query("SELECT SPECIFIC_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
    $specific_qry = $query->result_array();
    $specific_path = $specific_qry[0]['SPECIFIC_PATH'];   
	$mpn = str_replace('/', '_', $mpn);
	$dir = $specific_path.$upc."~".@$mpn."/".$condition_name."/".$manifest_id;
	
	// Open a directory, and read its contents
	if (is_dir($dir)){
	  if ($dh = opendir($dir)){
	  	$azRange = range('A', 'Z');
	  	$i=0;
	    while (($file = readdir($dh)) !== false){
			$parts = explode(".", $file);
			if (is_array($parts) && count($parts) > 1){
			    $extension = end($parts);
			    if(!empty($extension)){
			    	//echo '<img style ="width:250px;" src="./images/'.$parts['0'].'.'.$extension.'" /><br />';

							// $barcode = trim($this->input->post('bar_code'));
							
							// $new_dir = "D:/wamp/www/laptopzone/assets/item_pic_rename"."/".$barcode;
							// //var_dump($barcode,$dir,$new_dir);exit;
							// if( is_dir($new_dir) === false )
							// {
							//     mkdir($new_dir);
							// }
					  	// if(file_exists($new_dir."/".$barcode."_".$i.".".$extension))
					  	// {

					  	// }
						$characters = 'abcdefghijklmnopqrstuvwxyz0123456789'; 
						 $img_name = '';
						 $max = strlen($characters) - 1;
						 for ($k = 0; $k < 10; $k++) {
						      $img_name .= $characters[mt_rand(0, $max)];
						      
						 }			    	
			    		//$img_name = explode('_', $master_reorder[$i-1]);
						 @$img_order = rename($dir."/".$specific_order[$i], $dir."/".$azRange[$i]."_".$img_name.".".$extension);
						 //var_dump($dir."/".$master_reorder[$i-1], $dir."/".$i."_".$img_name);exit;
						  //var_dump($barcode);exit;
						  
						//  $this->load->library('image_lib'); 
					 //    $config['image_library'] = 'gd2';
					 //    $config['source_image']  = $new_dir."/".$barcode."_".$i.".".$extension;
					 //    $config['new_image']  = $new_dir."/".$barcode."_".$i.".".$extension;
					 //    $config['maintain_ratio']	 = true;
					 //    $config['width']	 = 1200;
					 //    $config['height']	= 1200;
						// $in =$this->image_lib->initialize($config); 
					 //    $result = $this->image_lib->resize($in);
						// $this->image_lib->clear();
						$i++;
				}
			}

	    }//end while
	    closedir($dh);

	    //exit;
	  }// sub if
	}//main if 
	    if(@$img_order){
	    	$data = true;
        	echo json_encode($data);
        	return json_encode($data);
    	}else{
    		$data = true;
        	echo json_encode($data);
        	return json_encode($data);
    	}		 	

  }
	public function delsingleLiveMasterPicture(){

	    $pic_path = $this->input->post('pic_path');

	    if (is_readable($pic_path ) ) {

	     	unlink($pic_path);

			$data = true;
			echo json_encode($data);
			return json_encode($data);

	    } else {
	        $data = false;
	        echo json_encode($data);
	        return json_encode($data);
	    }
	}
	public function delAllLiveMasterPictures(){

	    $query = $this->db->query("SELECT LIVE_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 1");
	    $master_qry = $query->result_array();
	    $master_path = $master_qry[0]['LIVE_PATH'];

	    //$dir = $master_path.$barcode;
	    $dir = $master_path;
	    //var_dump($dir); exit;
		// Open a directory, and read its contents
		if (is_dir($dir)){
		  if ($dh = opendir($dir)){
		  	//$i=1;
		    while (($file = readdir($dh)) !== false){
				$parts = explode(".", $file);
				if (is_array($parts) && count($parts) > 1){
				    $extension = end($parts);
				    if(!empty($extension)){
				    	
				    		//$img_name = explode('_', $master_reorder[$i-1]);
				    	//rename($dir."/".$parts['0'].".".$extension, $new_dir."/".$barcode."_".$i.".".$extension);
							 @$img_order = unlink($dir."/".$parts['0'].".".$extension);


					}
				}

		    }//end while

		    closedir($dh);

		  }// sub if
		}//main if 
	    if(@$img_order){
	    	$data = true;
	    	echo json_encode($data);
	    	return json_encode($data);
		}else{
			$data = false;
	    	echo json_encode($data);
	    	return json_encode($data);
		}
  	}
    public function setBinIdtoSession(){
      $data  = $this->m_item_pictures->setBinIdtoSession(); 
      echo json_encode($data);
      return json_encode($data);    
    }  	

  public function renameDirectory(){

    $query = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
    $master_qry = $query->result_array();
    $master_path = $master_qry[0]['MASTER_PATH'];

    $upc_query = $this->db->query("SELECT ITEM_MT_MFG_PART_NO MPN, UPC, CONDITIONS_SEG5 FROM NO_UPC_ITEM");
    $upc_query = $upc_query->result_array();

 

    foreach($upc_query as $row){

		$mpn = $row['MPN'];
		$new_upc = $row['UPC'];
		$it_condition = ucfirst($row['CONDITIONS_SEG5']);    	
    


	 //  	$upc = "";
	 //  	$it_condition = "Used";
		// $new_upc = "1234";
	 //  	$mpn = 'test';    

		$mpn = str_replace('/', '_', $mpn);

		$old_dir = $master_path.@$upc."~".@$mpn."/".$it_condition;//
		$dir_mpn = $master_path.@$upc."~".@$mpn;//

		//var_dump($dir_mpn);//exit;
		
		// Open a directory, and read its contents
		//if (is_dir($dir_mpn)){

		$new_dir = $master_path.$new_upc.'~'.$mpn;
		if(is_dir($new_dir)){
			$cond_dir = $new_dir.'/'.$it_condition;
			//var_dump($cond_dir);exit;
			if(is_dir($cond_dir)){

			  if ($dh = opendir($cond_dir)){
				  	//$i=1;
				    while (($file = readdir($dh)) !== false){
						$parts = explode(".", $file);
						if (is_array($parts) && count($parts) > 1){
						    $extension = end($parts);
						    if(!empty($extension)){
						    	
								@$del_img = unlink($cond_dir."/".$parts['0'].".".$extension);
								@$del_img_thumb = unlink($cond_dir."/thumb/".$parts['0'].".".$extension);

							}
						}

				    }//end while


				    closedir($dh);

				  }// sub if

				/*===============================================
				= Move old_dir pictures to $cond_dir start block =
				================================================*/

				  if ($dh = opendir($old_dir)){
				  	//$i=1;
				    while (($file = readdir($dh)) !== false){
						$parts = explode(".", $file);
						if (is_array($parts) && count($parts) > 1){
						    $extension = end($parts);
						    if(!empty($extension)){
						    	
								// @$del_img = unlink($cond_dir."/".$parts['0'].".".$extension);
								// @$del_img_thumb = unlink($cond_dir."/thumb/".$parts['0'].".".$extension);

								copy($old_dir."/".$parts['0'].".".$extension, $cond_dir."/".$parts['0'].".".$extension); //copy 
								copy($old_dir."/thumb/".$parts['0'].".".$extension, $cond_dir."/thumb/".$parts['0'].".".$extension); //copy 							

							}
						}

				    }//end while


				    closedir($dh);

				  }// sub if
				
				/*=====  End Move old_dir pictures to $cond_dir end  ======*/			  			  


			}else{

				mkdir($cond_dir);
				mkdir($cond_dir.'/thumb');

			/*===============================================
			= Move old_dir pictures to $cond_dir start block =
			================================================*/

			  if ($dh = opendir($old_dir)){
			  	//$i=1;
			    while (($file = readdir($dh)) !== false){
					$parts = explode(".", $file);
					if (is_array($parts) && count($parts) > 1){
					    $extension = end($parts);
					    if(!empty($extension)){
					    	
							// @$del_img = unlink($cond_dir."/".$parts['0'].".".$extension);
							// @$del_img_thumb = unlink($cond_dir."/thumb/".$parts['0'].".".$extension);

							copy($old_dir."/".$parts['0'].".".$extension, $cond_dir."/".$parts['0'].".".$extension); //copy 
							copy($old_dir."/thumb/".$parts['0'].".".$extension, $cond_dir."/thumb/".$parts['0'].".".$extension); //copy 							

						}
					}

			    }//end while


			    closedir($dh);

			  }// sub if
			
			/*=====  End Move old_dir pictures to $cond_dir end  ======*/

			  if ($dh = opendir($old_dir)){
			  	//$i=1;
			    while (($file = readdir($dh)) !== false){
					$parts = explode(".", $file);
					if (is_array($parts) && count($parts) > 1){
					    $extension = end($parts);
					    if(!empty($extension)){
					    	
							@$del_img = unlink($old_dir);
							@$del_img_thumb = unlink($old_dir."/thumb/");

						}
					}

			    }//end while


			    closedir($dh);

			  }// sub if


			} //else closing of $is_dir


		}else{
			$renamed_dir = rename($dir_mpn, $new_dir); //exit;	
			echo $renamed_dir;
		} //else closing of $new_dir
		
	//}//main if 
	} //foreach closing

  } 
  public function picturesInsertionLog(){

    $query = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
    $master_qry = $query->result_array();
    $master_path = $master_qry[0]['MASTER_PATH'];

	// $dirs = array_filter(glob('*'), 'is_dir');
	// print_r( $dirs); exit; //return project's folder name and count

/*================================================================
=            Show total names from a parent directory            =
================================================================*/

	// $path = $master_path;
	// $dirs = array();

	// // directory handle
	// $dir = dir($path);

	// while (false !== ($entry = $dir->read())) {
	//     if ($entry != '.' && $entry != '..') {
	//        if (is_dir($path . '/' .$entry)) {
	//             $dirs[] = $entry; 
	//        }
	//     }
	// }

	//echo "<pre>"; print_r($dirs); exit;

/*=====  End of Show total names from a parent directory  ======*/

/*=============================================
=            Section comment block            =
=============================================*/

	function expandDirectoriesMatrix($base_dir, $level = 0) {
	    $directories = array();
	    foreach(scandir($base_dir) as $file) {
	        if($file == '.' || $file == '..') continue;
	        $dir = $base_dir.DIRECTORY_SEPARATOR.$file;
	        if(is_dir($dir)) {
	            $directories[]= array(
	                    'level' => $level,
	                    'name' => $file,
	                    'path' => $dir,
	                    'children' => expandDirectoriesMatrix($dir, $level +1)
	            );
	        }


	    }
	    return $directories;
	}

	$dir = $master_path;
	$directories = expandDirectoriesMatrix($dir);

	//$i = 0;
	foreach($directories as $dir){
		//echo @$dir['level'].'<br>';                // 0
		//echo @$dir['name'].'<br>';                 // pathA
		$upc_mpn = @$dir['name'];

		$upc_mpn = explode("~", $upc_mpn);
		$upc =  trim(@$upc_mpn[0]); // piece1
		$mpn =  @$upc_mpn[1]; // piece2

		// echo $upc.'<br>';
		// echo $mpn.'<br>';
		//echo @$dir['path'].'<br>';                 // /var/www/pathA
		//echo @$dir['children'][0]['name'].'<br>';  // subPathA1
		foreach(@$dir['children'] as $sub_dir){
			$condtion_desc = ucfirst(@$sub_dir['name']);


			if(@$condtion_desc == 'Used'){
				@$condtion_id = 3000;
			}elseif(@$condtion_desc == 'New'){
				@$condtion_id = 1000; 
			}elseif(@$condtion_desc == 'New other'){
				@$condtion_id = 1500; 
			}elseif(@$condtion_desc == 'Manufacturer refurbished'){
				@$condtion_id = 2000;
			}elseif(@$condtion_desc == 'Seller refurbished'){
				@$condtion_id = 2500; 
			}elseif(@$condtion_desc == 'For parts or not working'){
				@$condtion_id = 7000; 
			}else{
				@$condtion_id = 3000;
			}

			//var_dump($condtion_1);exit;
			//echo $condtion_1;
			//echo @$dir['children'][0]['level'].'<br>'; // 1
			//echo @$dir['children'][1]['name'].'<br>';  // subPathA2
			// $condtion_2 = @$dir['children'][1]['name'].'<br><br>';
			// echo $condtion_2;
			//echo @$dir['children'][1]['level'].'<br>'; // 1	
			//echo "Count: ".$i;
			//$i++;
		    date_default_timezone_set("America/Chicago");
		    $date = date("Y-m-d H:i:s");
		    $pic_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";


	        $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_ITEM_PICTURES','PIC_ID') ID FROM DUAL");
	        $rs = $qry->result_array();
	        $pic_id = $rs[0]['ID'];

	      	$insert_query = $this->db->query("INSERT INTO LZ_ITEM_PICTURES (PIC_ID, UPC, MPN, CONDITION, PIC_DATE, PIC_BY, CONDITION_DESC) VALUES($pic_id, '$upc', '$mpn', '$condtion_id', $pic_date, 2, '$condtion_desc')");
	      	if($insert_query){
	      		echo "Successfully Inserted."."</br>";
	      	}else{
	      		echo "Not Inserted";
	      	}			
		}



	} //endforeach closing


	/*=====  End of Section comment block  ======*/


  } 

public function thumbnailPicturesRippingCode(){

	$main_dir = 'D:/wamp/www/item_pictures/dekitted_pictures/';
	//$directories = glob($main_dir . '/*' , GLOB_ONLYDIR);

	$barcodeForThumbRipping = array("146249","146250","146484","146483","146195","146466","146467","146248","146247","146246","146245","146244","146243","146241","146240","146239","146238","146237","146236","146235","146234","146233","146232","146231","146230","146228","146227","146027","146026","146025","146024","146023","146022","146021","146020","146019","146018","146017","146016","146015","146014,146013","146192","146187","146185","146184","146183","146182","146180","146178","146177","146152","146150","146148","146147","146146","146144","146139","146138","146116","146113","148251","148250","148248","148230","148227","148219","148196","148193","148192","148191","148190","148189","148170","148155","148154","148153","148152","148151","148138","148137","147551","147551","147519","147500","146693","146685","148078","148052","148046","148045","148320","148305","148304","148288","148286","148284","148283","148279","148274","148273","148272","148258","148254","148044","148001","148000");


	//var_dump($directories);exit;

	//$this->load->library('image_lib');
	foreach ($barcodeForThumbRipping as $dir) {

		$sub_dir = $main_dir.$dir.'/thumb';
		//var_dump($sub_dir);//exit;
		if (is_dir($sub_dir)){
		  if ($dh = opendir($sub_dir)){

					while (($file = readdir($dh)) !== false){
						//echo "filename:" . $file . "<br>";
						$parts = explode(".", $file);
						//var_dump($parts);exit;

		                 if (is_array($parts) && strlen($parts[0]) > 1){

		                    $extension = strtolower(end($parts));
		                    if(!empty($extension)){
		                    	$img_path = $sub_dir.'/'.$parts['0'].'.'.$extension;
		                    	rename($sub_dir.'/'.$parts['0'].'.jpg.'.$extension, $sub_dir.'/'.$parts['0'].'.'.$extension);
		                    	// var_dump($parts['0']);
		                    	// var_dump($img_path);exit;
		                    	$config['image_library'] = 'gd2';
							    $config['source_image']  = $img_path;
							   /* if(!is_dir($sub_dir."/thumb")){
									mkdir($sub_dir."/thumb");
								}*/
							    $config['new_image']  = $sub_dir."/".$parts['0'].'.'.$extension;
							    //var_dump($img_path,$config['new_image']);//exit;
							    //$config['create_thumb']	 = true;
							    $config['maintain_ratio']	 = true;
							    $config['width']	 = 100;
							    $config['height']	= 100;
							    $this->load->library('image_lib'); 
								$in =$this->image_lib->initialize($config); 
							    //$result = 
							    if ( ! $this->image_lib->resize($in))
								{
							        echo $this->image_lib->display_errors();
								}
							    //$this->image_lib->resize($in);
								$this->image_lib->clear();
		                    }
		                 }
					}//while close
					closedir($dh);
			} // if opendir closing
		} // if is_dir closing
		
	}//dir foreach
	
}

public function androidMainPicturesRename(){

	$main_dir = 'D:/wamp/www/item_pictures/dekitted_pictures/';
	//$directories = glob($main_dir . '/*' , GLOB_ONLYDIR);

	$barcodeForThumbRipping = array("146249","146250","146484","146483","146195","146466","146467","146248","146247","146246","146245","146244","146243","146241","146240","146239","146238","146237","146236","146235","146234","146233","146232","146231","146230","146228","146227","146027","146026","146025","146024","146023","146022","146021","146020","146019","146018","146017","146016","146015","146014,146013","146192","146187","146185","146184","146183","146182","146180","146178","146177","146152","146150","146148","146147","146146","146144","146139","146138","146116","146113","148251","148250","148248","148230","148227","148219","148196","148193","148192","148191","148190","148189","148170","148155","148154","148153","148152","148151","148138","148137","147551","147551","147519","147500","146693","146685","148078","148052","148046","148045","148320","148305","148304","148288","148286","148284","148283","148279","148274","148273","148272","148258","148254","148044","148001","148000");
	//var_dump($directories);exit;

	//$this->load->library('image_lib');
	foreach ($barcodeForThumbRipping as $dir) {

		$sub_dir = $main_dir.$dir;
		//var_dump($sub_dir);//exit;
		if (is_dir($sub_dir)){
		  if ($dh = opendir($sub_dir)){

					while (($file = readdir($dh)) !== false){
						//echo "filename:" . $file . "<br>";
						$parts = explode(".", $file);
						//var_dump($parts);exit;

		                 if (is_array($parts) && strlen($parts[0]) > 1){

		                    $extension = strtolower(end($parts));
		                    if(!empty($extension)){
		                    	$img_path = $sub_dir.'/'.$parts['0'].'.'.$extension;
		                    	rename($sub_dir.'/'.$parts['0'].'.jpg.'.$extension, $sub_dir.'/'.$parts['0'].'.'.$extension);
		                    	// var_dump($parts['0']);
		                    	// var_dump($img_path);exit;
		      //               	$config['image_library'] = 'gd2';
							 //    $config['source_image']  = $img_path;
							 //   /* if(!is_dir($sub_dir."/thumb")){
								// 	mkdir($sub_dir."/thumb");
								// }*/
							 //    $config['new_image']  = $sub_dir."/".$parts['0'].'.'.$extension;
							 //    //var_dump($img_path,$config['new_image']);//exit;
							 //    //$config['create_thumb']	 = true;
							 //    $config['maintain_ratio']	 = true;
							 //    $config['width']	 = 100;
							 //    $config['height']	= 100;
							 //    $this->load->library('image_lib'); 
								// $in =$this->image_lib->initialize($config); 
							 //    //$result = 
							 //    if ( ! $this->image_lib->resize($in))
								// {
							 //        echo $this->image_lib->display_errors();
								// }
							 //    //$this->image_lib->resize($in);
								// $this->image_lib->clear();
		                    }
		                 }
					}//while close
					closedir($dh);
			} // if opendir closing
		} // if is_dir closing
		
	}//dir foreach
	
}

}

?>