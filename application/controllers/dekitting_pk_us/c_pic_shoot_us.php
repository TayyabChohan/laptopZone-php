<?php

  require 'Cloudinary.php';
  require 'Uploader.php';
  require 'Api.php';

  \Cloudinary::config(array( 
    "cloud_name" => "ecologix", 
    "api_key" => "567368836433995", 
    "api_secret" => "THXklWb19H_es1k6XLBF6hLI2v0" 
  ));
class c_pic_shoot_us extends CI_Controller{
	public function __construct(){
	    parent::__construct();
	    $this->load->database();
	    //$this->load->model('catalogueToCash/m_reciving');
	    $this->load->model('dekitting_pk_us/m_dekitting_us');
        $this->load->helper('security');
	      /*=============================================
        =  Section lz_bigData db connection block  =
        =============================================*/
        $CI = &get_instance();
        //setting the second parameter to TRUE (Boolean) the function will return the database object.
        $this->db2 = $CI->load->database('bigData', TRUE);
        // $qry = $this->db2->query("SELECT * FROM lz_bd_category");
        // print_r($qry->result());exit;

        /*=====  End of Section lz_bigData db connection block  ======*/	
	      if(!$this->loginmodel->is_logged_in())
	       {
	         redirect('login/login/');
	       }      
 	}

	public function index(){

	$result['pageTitle'] = 'Picture Shooting';

	// $img = 'D:/item_pictures/dekitted_pictures/106238/thumb/\A_oguggg9agy.JPG';
	// $result['pic'] = $img;

	$this->load->view('dekitting_pk_us/v_pic_shoot_us',$result);

	}
	public function pictureShootingDetails(){
		$result['pageTitle'] = 'Picture Shooting Details';
		$this->load->view('dekitting_pk_us/v_withAndWithoutPictures',$result);		
	}

	public function addPicture(){
		$result['pageTitle'] = 'Add Picture';


		$this->load->view('dekitting_pk_us/v_itemPicture',$result);

	}
	public function loadPicView(){
		$result['pageTitle'] = 'Add Picture';
		$result['picture'] = $this->input->post('pics');
		// var_dump($result['picture']);exit;
		$this->load->view('dekitting_pk_us/v_pic_shoot_us',$result);
	}

	public function showMasterDetails(){
        $data = $this->m_dekitting_us->showMasterDetails();
        echo json_encode($data);
        return json_encode($data); 
	}

	public function getPrvDetails(){
        $data = $this->m_dekitting_us->getPrvDetails();

        echo json_encode($data);
        return json_encode($data);		
	}

	public function img_upload(){

		$barcode = $this->input->post('barcode');
		$it_condition = $this->input->post('condition');

	  	$bin_id = trim(strtoupper($this->input->post('bin_id')));
	  	$this->session->set_userdata('bin_id', $bin_id);
	  	$remarks = $this->input->post('remarks');
		$remarks = trim(str_replace("  ", ' ', $remarks));
		$remarks = str_replace(array("`,′"), "", $remarks);
		$remarks = str_replace(array("'"), "''", $remarks);	

		$pic_notes = $this->input->post('pic_notes');
		$pic_note = trim(str_replace("  ", ' ', $pic_notes));
		$pic_note = str_replace(array("`,′"), "", $pic_note);
		$pic_notes = str_replace(array("'"), "''", $pic_notes);	  	
	  	$current_bin = trim(strtoupper($this->input->post('current_bin')));

		$user = $this->session->userdata('user_id');
		date_default_timezone_set("America/Chicago");
		$pic_date = date("Y-m-d H:i:s");
		$pic_date ="TO_DATE('".$pic_date."', 'YYYY-MM-DD HH24:MI:SS')";

		// var_dump($barcode);exit;
		$azRange = range('A', 'Z');
		$this->load->library('image_lib');
		for( $i= 0; $i < count ($_FILES['dekit_image']['name']); $i++ ) {
			if(isset($_FILES["dekit_image"])) {
				// var_dump($_FILES["dekit_image"]);exit;
				@list(, , $imtype, ) = getimagesize($_FILES['dekit_image']['tmp_name'][$i]);

				// var_dump($imtype);exit;
			

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
		    if(getimagesize($_FILES['dekit_image']['tmp_name'][$i]) == FALSE){
		      echo "Please select an image.";
		    }else{

		      $image = addslashes($_FILES['dekit_image']['tmp_name'][$i]);
				$name = addslashes($_FILES['dekit_image']['name'][$i]);
			   $query = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 2");
			   $master_qry = $query->result_array();
			   $master_path = $master_qry[0]['MASTER_PATH'];
			    // var_dump($master_path);exit;
				$new_dir = $master_path.$barcode;//.;

			 	if(!is_dir($new_dir)){
			 		//var_dump($new_dir);
			 		mkdir($new_dir);
			 		// var_dump($new_dir);
			 	}
			 	if(!is_dir($new_dir)){
			 			mkdir($new_dir);
			 	}
	 			if (file_exists($new_dir.'/'. $name)) {
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
					move_uploaded_file($_FILES["dekit_image"]["tmp_name"][$i],$new_dir.'/'.$azRange[$i].'_'.$img_name.'.'.$extension);
					//copy($new_dir.'/'.$azRange[$i].'_'.$img_name.'.'.$extension,$old_dir.'/'.$azRange[$i].'_'.$img_name.'.'.$extension);
					/*====================================
					=            image resize            =
					====================================*/
					$config['image_library'] = 'GD2';
				    $config['source_image']  = $new_dir."/".$azRange[$i].'_'.$img_name.'.'.$extension;
				    $config['new_image']  = $new_dir."/".$azRange[$i].'_'.$img_name.'.'.$extension;
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
				    $config['source_image']  = $new_dir."/".$azRange[$i].'_'.$img_name.'.'.$extension;
				    if(!is_dir($new_dir."/thumb")){
						mkdir($new_dir."/thumb");
					}
					//  if(!is_dir($old_dir."/thumb")){
					// 	mkdir($old_dir."/thumb");
					// }
				    $config['new_image']  = $new_dir."/thumb/".$azRange[$i].'_'.$img_name.'.'.$extension;
				    // $config['old_image']  = $old_dir."/thumb/".$azRange[$i].'_'.$img_name.'.'.$extension;
				    $config['maintain_ratio']	 = true;
				    $config['width']	 = 100;
				    $config['height']	= 100;

				    //$config['quality']	 = 50; this filter doesnt work
					$in =$this->image_lib->initialize($config); 
				    $result = $this->image_lib->resize($in);
					$this->image_lib->clear();
					//copy($new_dir."/thumb/".$azRange[$i].'_'.$img_name.'.'.$extension,$old_dir."/thumb/".$azRange[$i].'_'.$img_name.'.'.$extension);
					/*=====  End of image thumbnail creation  ======*/
					//$qr = $this->db->query("UPDATE LZ_DEKIT_US_DT SET PIC_DATE_TIME = $pic_date, PIC_BY = $user,PIC_STATUS = 1 WHERE BARCODE_PRV_NO = $barcode ");

					/*================================================
					=            upload pix to cloudinary            =
					================================================*/
						//// \Cloudinary\Uploader::upload($new_dir.'/'.$azRange[$i].'_'.$img_name.'.'.$extension, array("folder"=>"$barcode","use_filename" => true, "unique_filename" => false));
						//// \Cloudinary\Uploader::upload($new_dir."/".$azRange[$i].'_'.$img_name.'.'.$extension, array("folder"=>"$barcode"."/thumb/","use_filename" => true, "unique_filename" => false));

					/*=====  End of upload pix to cloudinary  ======*/
					
						
					}
// $old_dir = $master_old_path.'~'.$mpn.'/'.@$it_condition;
				
		    	}//else if getimage size
		  }//if isset file image
		}//main for loop

		/*==== Bin Assignment to item barcode start ====*/

			$bin_id_qry = $this->db->query("SELECT BIN_ID, BIN_NAME FROM (SELECT B.BIN_ID, B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME FROM BIN_MT B) WHERE BIN_NAME = '$bin_id'");

			$result = $bin_id_qry->result_array();
			$return_bin_id = @$result[0]['BIN_ID'];

			if(!(empty($return_bin_id))){
				$qr = $this->db->query("UPDATE LZ_DEKIT_US_DT SET PIC_DATE_TIME = $pic_date, PIC_BY = $user, PIC_NOTES = '$pic_notes', PIC_STATUS = 1, BIN_ID = $return_bin_id WHERE BARCODE_PRV_NO = $barcode ");	
			}
		

		/*==== Bin Assignment to item barcode end ====*/	

	}


	public function master_sorting_order(){
		$master_reorder = $this->input->post('master_reorder');

		$namess = [];

		$it_condition = $this->input->post('condition');
		// var_dump($it_condition);
		$barcode = $this->input->post('child_barcode');

	    $query = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 2");
	    $master_qry = $query->result_array();
	    $master_path = $master_qry[0]['MASTER_PATH'];
		// $mpn = str_replace('/', '_', $mpn);

		$dir = $master_path.$barcode.'/thumb';//
		$dir2 = $master_path.$barcode;
		// var_dump($dir);
		// var_dump($dir2);exit;
		// $img_order = '';
		// var_dump($dir);exit;
		
		// Open a directory, and read its contents
		if (is_dir($dir)){
			
		  if ($dh = opendir($dir)){
		  	$azRange = range('A', 'Z');
		  	$i=0;
		  	// var_dump('reached');exit;
		    while (($file = readdir($dh)) !== false){
		    	// var_dump($file);
				$parts = explode(".", $file);
				if (is_array($parts) && count($parts) > 1){
				    $extension = end($parts);
				    // var_dump($extension);
				    if(!empty($extension)){
				    	
							$characters = 'abcdefghijklmnopqrstuvwxyz0123456789'; 
							 $img_name = '';
							 $max = strlen($characters) - 1;
							 for ($k = 0; $k < 10; $k++) {
							 	// var_dump('reached');exit;
							      $img_name .= $characters[mt_rand(0, $max)];
							      // var_dump($img_name);
							      
							 }			    	
				    		// exit;
							 // var_dump($dir."/".$master_reorder[$i]);
							 @$img_order = rename($dir."/".$master_reorder[$i], $dir."/".$azRange[$i]."_".$img_name.".".$extension);
							 @$img_order2 = rename($dir2."/".$master_reorder[$i], $dir2."/".$azRange[$i]."_".$img_name.".".$extension);
							 $str = preg_replace('/[^A-Za-z0-9\. -]/', '', $parts[0]);
					    	 $new_string = substr($str,0,1) . "_" . substr($str,1,strlen($str)-1);

						//	\Cloudinary\Uploader::destroy($barcode.'/'.$new_string, array( "invalidate" => TRUE));
	     				//	\Cloudinary\Uploader::destroy($barcode.'/thumb/'.$new_string, array( "invalidate" => TRUE));

	     				//	\Cloudinary\Uploader::upload($dir."/".$azRange[$i]."_".$img_name.".".$extension, array("folder"=>"$barcode","use_filename" => true, "unique_filename" => false));
						//	\Cloudinary\Uploader::upload($dir2."/".$azRange[$i]."_".$img_name.".".$extension, array("folder"=>"$barcode"."/thumb/","use_filename" => true, "unique_filename" => false));
							
							$i++;
					}
				}

		    }//exit;//end while
		    closedir($dh);

		    //exit;
		  }// sub if
		}//main if 

	    if(@$img_order && @$img_order2){

	    	$data = true;
        	echo json_encode($data);
        	return json_encode($data);
    	}else{
    		$data = false;
        	echo json_encode($data);
        	return json_encode($data);
    	}	
	}

  public function sorting_order_seed_pk(){
  	$master_reorder = $this->input->post('master_reorder');
  	//var_dump($master_reorder);
  	//exit;
  	$barcode = $this->input->post('barcode');
  	// $upc = $this->input->post('upc');
  	// $mpn = $this->input->post('part_no');

 //  	$it_condition = $this->input->post('it_condition');
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

	$query = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 2");
	$master_qry = $query->result_array();
	$master_path = $master_qry[0]['MASTER_PATH'];
	$dir = $master_path.$barcode.'/thumb';//
	$dir2 = $master_path.$barcode;
		// $img_order = '';
		 //var_dump($dir);exit;
		
		// Open a directory, and read its contents
		if (is_dir($dir)){
			
		  if ($dh = opendir($dir)){
		  	$azRange = range('A', 'Z');
		  	$i=0;
		  	// var_dump('reached');exit;
		    while (($file = readdir($dh)) !== false){
		    	// var_dump($file);
				$parts = explode(".", $file);
				if (is_array($parts) && count($parts) > 1){
				    $extension = end($parts);
				    // var_dump($extension);
				    if(!empty($extension)){
				    	
							$characters = 'abcdefghijklmnopqrstuvwxyz0123456789'; 
							 $img_name = '';
							 $max = strlen($characters) - 1;
							 for ($k = 0; $k < 10; $k++) {
							 	// var_dump('reached');exit;
							      $img_name .= $characters[mt_rand(0, $max)];
							      // var_dump($img_name);
							      
							 }			    	
				    		// exit;
							 // var_dump($dir."/".$master_reorder[$i]);
							 @$img_order = rename($dir."/".$master_reorder[$i], $dir."/".$azRange[$i]."_".$img_name.".".$extension);
							 @$img_order2 = rename($dir2."/".$master_reorder[$i], $dir2."/".$azRange[$i]."_".$img_name.".".$extension);
							 $str = preg_replace('/[^A-Za-z0-9\. -]/', '', $parts[0]);
					    	 $new_string = substr($str,0,1) . "_" . substr($str,1,strlen($str)-1);

						//	\Cloudinary\Uploader::destroy($barcode.'/'.$new_string, array( "invalidate" => TRUE));
	     				//	\Cloudinary\Uploader::destroy($barcode.'/thumb/'.$new_string, array( "invalidate" => TRUE));

	     				//	\Cloudinary\Uploader::upload($dir."/".$azRange[$i]."_".$img_name.".".$extension, array("folder"=>"$barcode","use_filename" => true, "unique_filename" => false));
						//	\Cloudinary\Uploader::upload($dir2."/".$azRange[$i]."_".$img_name.".".$extension, array("folder"=>"$barcode"."/thumb/","use_filename" => true, "unique_filename" => false));
							
							$i++;
					}
				}

		    }//exit;//end while
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
public function delete_all_master(){
		// var_dump($it_condition);
	$barcode = $this->input->post('child_barcode');
  	
	$user = $this->session->userdata('user_id');
	 date_default_timezone_set("America/Chicago");
	 $pic_date = date("Y-m-d H:i:s");
	$pic_date ="TO_DATE('".$pic_date."', 'YYYY-MM-DD HH24:MI:SS')";

    $query = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 2");
    $master_qry = $query->result_array();
    $master_path = $master_qry[0]['MASTER_PATH'];

    $dir = $master_path.$barcode;
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

						$str = preg_replace('/[^A-Za-z0-9\. -]/', '', $parts[0]);
					    $new_string = substr($str,0,1) . "_" . substr($str,1,strlen($str)-1);
					    // $pieces = explode(".", $new_string);
					    // $new_string = $pieces[0];
					     $qr = $this->db->query("UPDATE LZ_DEKIT_US_DT SET PIC_DATE_TIME = $pic_date, PIC_BY = $user,PIC_STATUS = 0 WHERE BARCODE_PRV_NO = $barcode ");

					//	\Cloudinary\Uploader::destroy($barcode.'/'.$new_string, array( "invalidate" => TRUE));
	     			//	\Cloudinary\Uploader::destroy($barcode.'/thumb/'.$new_string, array( "invalidate" => TRUE));

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
	public function deleteAllLivePictures(){

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
  	public function deleteSpecificLivePictures(){

	    $pic_path = $this->input->post('pic_path');
	 //    var_dump($pic_path);
	 //    $parts = explode("/", $pic_path);
	 //    $str = explode(".",@$parts[4]);
	 //    var_dump($str);
		// $image_name = explode("\\", $parts[4]);
		// var_dump($image_name);exit;
  //       $image_name = end($image_name);	   
	    
	 //    $string =  preg_replace('/[^A-Za-z0-9\-]/', '', $str[0]); 

	 //    $str = preg_replace('/[^A-Za-z0-9\. -]/', '', $parts[4]);
	 //    $new_string = substr($str,0,1) . "_" . substr($str,1,strlen($str)-1);
	 //    $pieces = explode(".", $new_string);
	 //    $new_string = $pieces[0];

	 //    $spec_url = $parts[0].'/'.$parts[1].'/'.$parts[2].'/'.$parts[3].'/'.$image_name;

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
	
  public function saveNotes(){
  	$data = $this->m_dekitting_us->saveNotes();
	echo json_encode($data);
	return json_encode($data);
  }

  // getPicNote
   public function getPicNote(){
  	$data = $this->m_dekitting_us->getPicNote();
	echo json_encode($data);
	return json_encode($data);
  }

   public function master_barcode_det(){
   	$data = $this->m_dekitting_us->master_barcode_det();
	echo json_encode($data);
	return json_encode($data);
   }

  public function showChildDetails(){

  	$result['pageTitle'] = 'Picture Shooting';

  	if($this->input->post('barcode_search')){
		$barcode_prv = $this->input->post('barcode_prv');
		$this->session->set_userdata('barcode_prv', $barcode_prv);  		
    	$result['data'] = $this->m_dekitting_us->showChildDetails($barcode_prv);
    	//var_dump($data);
    	$this->load->view('dekitting_pk_us/v_pic_shoot_us',$result);
    }elseif($this->uri->segment(4)){
    	$barcode_prv = trim($this->uri->segment(4));
    	$this->session->set_userdata('barcode_prv', $barcode_prv);
    	$result['data'] = $this->m_dekitting_us->showChildDetails($barcode_prv);
    	//var_dump($data);
    	$this->load->view('dekitting_pk_us/v_pic_shoot_us',$result);    	
    }

  }   

  public function checkPicturess(){
    $data = $this->m_dekitting_us->checkPicturess();
    echo json_encode($data);
    return json_encode($data);    
  } 
  

  // public function checkNonPictures(){
  //   $data = $this->m_dekitting_us->checkPictures();
  //   echo json_encode($data);
  //   return json_encode($data);    
  // }

  public function checkNonPicturess(){
    $data = $this->m_dekitting_us->checkNonPicturess();
    echo json_encode($data);
    return json_encode($data);    
  }

  public function get_my_dekited_pic(){
	$data = $this->m_dekitting_us->get_my_dekited_pic();
    echo json_encode($data);
    return json_encode($data); 	
  }

   public function getLivePictures(){
	$data = $this->m_dekitting_us->getLivePictures();
    echo json_encode($data);
    return json_encode($data); 	
  }

  public function getBarcodePics(){
	$data = $this->m_dekitting_us->getBarcodePics();
    echo json_encode($data);
    return json_encode($data);  	
  }

  public function getHistoryPics(){
	$data = $this->m_dekitting_us->getHistoryPics();
    echo json_encode($data);
    return json_encode($data);  	
  }

  public function save_pics_master(){

  	$barcode = $this->input->post('barcode');
  	$it_condition = $this->input->post('condition');
  	$radio_btn = $this->input->post('radio_btn'); //radio_btn identify MPN Image
  	$pic_name = $this->input->post('pic_name'); //Name of pictures that select for identify MPN Image
  	$bin_id = trim(strtoupper($this->input->post('bin_id'))); // Bin ID for Assign Bin
  	$this->session->set_userdata('bin_id', $bin_id); //exit;
  	// $bin_id = explode("-", $bin_id);
  	// //$bin_id = $bin_id[1];
  	// $bin_id = ltrim($bin_id[1], '0');
  	//var_dump($bin_id); exit;

  	$user = $this->session->userdata('user_id');
	date_default_timezone_set("America/Chicago");
	$pic_date = date("Y-m-d H:i:s");
	$pic_date ="TO_DATE('".$pic_date."', 'YYYY-MM-DD HH24:MI:SS')";

    $query = $this->db->query("SELECT * FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 2");
    $master_qry = $query->result_array();
    $master_path = $master_qry[0]['MASTER_PATH'];
    $live_path = $master_qry[0]['LIVE_PATH'];

	$this->load->library('image_lib'); 
	 $dir = $live_path;
		if (is_dir($dir)){
			$images = glob($dir."\*.{JPG,jpg,GIF,gif,PNG,png,BMP,bmp,JPEG,jpeg}",GLOB_BRACE);

			$i=0;
			$azRange = range('A', 'Z');
			foreach($images as $image){
				//var_dump($image);
				$parts = explode(".", $image);
				//var_dump($parts);exit;
				if (is_array($parts) && count($parts) > 1){
				    $extension = end($parts);

				    if(!empty($extension)){ //extension if start			    	

						$characters = 'abcdefghijklmnopqrstuvwxyz0123456789'; 
						$img_name = '';
						$max = strlen($characters) - 1;
						for ($k = 0; $k < 10; $k++) {
						    $img_name .= $characters[mt_rand(0, $max)];
						      
						}

						$sub_dir = $master_path.$barcode;

						$final_dir = $sub_dir;

						if(!is_dir($final_dir)){
							mkdir($final_dir);
						}
						/*======= MPN Image check start ======*/
						$img_url = explode("\\", $image);
	                    $check_img_name = end($img_url);				    
	                    //var_dump($check_img_name);exit;
	                    
						if($check_img_name == $pic_name){
							//var_dump($pic_name);exit;
							$img_moved = rename($parts['0'].".".$extension, $final_dir."/".$radio_btn.$azRange[$i]."_".$img_name.".".$extension);
						}else{	
							$img_moved = rename($parts['0'].".".$extension, $final_dir."/".$azRange[$i]."_".$img_name.".".$extension);
						}	                    
						/*======= MPN Image check end ======*/

						//copy($final_dir."/".$azRange[$i]."_".$img_name.".".$extension, $master_old_path.'~'.$mpn.'/'.@$it_condition."/".$azRange[$i]."_".$img_name.".".$extension);


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
					    // var_dump($live_old_path);
						$in =$this->image_lib->initialize($config); 
					    $result = $this->image_lib->resize($in);
						$this->image_lib->clear();
						//copy($final_dir."/thumb/".$azRange[$i].'_'.$img_name.'.'.$extension,$master_old_path.'~'.$mpn.'/'.@$it_condition."/thumb/".$azRange[$i]."_".$img_name.".".$extension);
						//var_dump($mpn);

						/*=====  End of image thumbnail creation  ======*/
						/*===========================================
						=            upload pix to Cloudinary            =
						===========================================*/
						//// \Cloudinary\Uploader::upload($final_dir."/".$azRange[$i].'_'.$img_name.'.'.$extension, array("folder"=>"$barcode","use_filename" => true, "unique_filename" => false));
						
						//// \Cloudinary\Uploader::upload($final_dir."/".$azRange[$i].'_'.$img_name.'.'.$extension, array("folder"=>"$barcode"."/thumb/","use_filename" => true, "unique_filename" => false));
						
						/*=====  End of upload pix to Cloudinary  ======*/
							
							
						$i++;
					} //extension if end
				}

		    }//end while/foreach

			/*==== Bin Assignment to item barcode start ====*/

				$bin_id_qry = $this->db->query("SELECT BIN_ID, BIN_NAME FROM (SELECT B.BIN_ID, B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME FROM BIN_MT B) WHERE BIN_NAME = '$bin_id'");

				$result = $bin_id_qry->result_array();
				$return_bin_id = @$result[0]['BIN_ID'];

				if(!(empty($return_bin_id))){
					$qr = $this->db->query("UPDATE LZ_DEKIT_US_DT SET PIC_DATE_TIME = $pic_date, PIC_BY = $user, PIC_STATUS = 1, BIN_ID = $return_bin_id WHERE BARCODE_PRV_NO = $barcode ");	
				}
			

			/*==== Bin Assignment to item barcode end ====*/	

		    //closedir($dh);

		    //exit;
		 // }// sub if
		}//main if


		$data = true;
    	echo json_encode($data);
    	return json_encode($data);
	
		
	}

/*========= Save and Marks as MPN Start ===========*/
  public function saveAndMarkasMPN(){

  	$barcode = $this->input->post('barcode');
  	$it_condition = $this->input->post('condition');
  	$radio_btn = $this->input->post('radio_btn'); //radio_btn identify MPN Image
  	$pic_name = $this->input->post('pic_name'); //Name of pictures that select for identify MPN Image

  	$user = $this->session->userdata('user_id');
	date_default_timezone_set("America/Chicago");
	$pic_date = date("Y-m-d H:i:s");
	$pic_date ="TO_DATE('".$pic_date."', 'YYYY-MM-DD HH24:MI:SS')";

    $query = $this->db->query("SELECT * FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 2");
    $master_qry = $query->result_array();
    $master_path = $master_qry[0]['MASTER_PATH'];
    //$live_path = $master_qry[0]['LIVE_PATH'];
	$this->load->library('image_lib'); 
	$dir = $master_path.$barcode;
	//var_dump($dir);

		if (is_dir($dir)){
			$images = glob($dir."\*.{JPG,jpg,GIF,gif,PNG,png,BMP,bmp,JPEG,jpeg}",GLOB_BRACE);

			$i=0;
			$azRange = range('A', 'Z');
			foreach($images as $image){
				//var_dump($image);exit;
				$parts = explode(".", $image);
				//var_dump($parts);exit;
				if (is_array($parts) && count($parts) > 1){
				    $extension = end($parts);

				    if(!empty($extension)){ //extension if start			    	

						$characters = 'abcdefghijklmnopqrstuvwxyz0123456789'; 
						$img_name = '';
						$max = strlen($characters) - 1;
						for ($k = 0; $k < 10; $k++) {
						    $img_name .= $characters[mt_rand(0, $max)];
						      
						}

						$sub_dir = $master_path.$barcode;

						$final_dir = $sub_dir;

						if(!is_dir($final_dir)){
							mkdir($final_dir);
						}
						/*======= MPN Image check start ======*/
						$img_url = explode("\\", $image);
	                    $check_img_name = end($img_url);				    
	                    //var_dump($check_img_name);exit;
	                    
						if($check_img_name == $pic_name){
							//var_dump($pic_name);exit;
							$img_moved = rename($parts['0'].".".$extension, $final_dir."/".$radio_btn.$azRange[$i]."_".$img_name.".".$extension);
						}else{	
							$img_moved = rename($parts['0'].".".$extension, $final_dir."/".$azRange[$i]."_".$img_name.".".$extension);
						}	                    
						/*======= MPN Image check end ======*/

						//copy($final_dir."/".$azRange[$i]."_".$img_name.".".$extension, $master_old_path.'~'.$mpn.'/'.@$it_condition."/".$azRange[$i]."_".$img_name.".".$extension);


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
					    // var_dump($live_old_path);
						$in =$this->image_lib->initialize($config); 
					    $result = $this->image_lib->resize($in);
						$this->image_lib->clear();
						//copy($final_dir."/thumb/".$azRange[$i].'_'.$img_name.'.'.$extension,$master_old_path.'~'.$mpn.'/'.@$it_condition."/thumb/".$azRange[$i]."_".$img_name.".".$extension);
						//var_dump($mpn);
						$qr = $this->db->query("UPDATE LZ_DEKIT_US_DT SET PIC_DATE_TIME = $pic_date, PIC_BY = $user,PIC_STATUS = 1 WHERE BARCODE_PRV_NO = $barcode ");
						/*=====  End of image thumbnail creation  ======*/
						/*===========================================
						=            upload pix to Cloudinary            =
						===========================================*/
						//// \Cloudinary\Uploader::upload($final_dir."/".$azRange[$i].'_'.$img_name.'.'.$extension, array("folder"=>"$barcode","use_filename" => true, "unique_filename" => false));
						
						//// \Cloudinary\Uploader::upload($final_dir."/".$azRange[$i].'_'.$img_name.'.'.$extension, array("folder"=>"$barcode"."/thumb/","use_filename" => true, "unique_filename" => false));
						
						/*=====  End of upload pix to Cloudinary  ======*/
							
							
						$i++;
					} //extension if end
				}

		    }//end while/foreach
		    //closedir($dh);

		    //exit;
		 // }// sub if
		}//main if


		$data = true;
    	echo json_encode($data);
    	return json_encode($data);
	
		
	}
/*========= Save and Marks as MPN End ===========*/

/*=========================================
	=            save from history            =
	=========================================*/
	
  public function save_history_master(){

  	$barcode = $this->input->post('barcode');
  	$it_condition = $this->input->post('condition');
  	$radio_btn = $this->input->post('radio_btn'); //radio_btn identify MPN Image
  	$pic_name = $this->input->post('pic_name'); //Name of pictures that select for identify MPN Image

  	$bin_id = trim(strtoupper($this->input->post('bin_id'))); // Bin ID for Assign Bin
  	$this->session->set_userdata('bin_id', $bin_id); //exit;

	$getMpn = $this->db->query("SELECT I.ITEM_MT_MFG_PART_NO, DT.OBJECT_ID FROM LZ_DEKIT_US_DT DT, LZ_DEKIT_US_MT MT,LZ_BARCODE_MT B, ITEMS_MT I WHERE DT.LZ_DEKIT_US_MT_ID = MT.LZ_DEKIT_US_MT_ID AND B.BARCODE_NO = MT.BARCODE_NO AND B.ITEM_ID = I.ITEM_ID AND DT.BARCODE_PRV_NO = $barcode");

	$getMpn = $getMpn->result_array();
	$mpn = $getMpn[0]["ITEM_MT_MFG_PART_NO"];
	$OBJECT_ID = $getMpn[0]["OBJECT_ID"];  

	$getMasterBarcodeId = $this->db->query("SELECT D.LZ_DEKIT_US_MT_ID FROM LZ_DEKIT_US_MT D, LZ_BARCODE_MT B , ITEMS_MT I WHERE I.ITEM_ID = B.ITEM_ID AND B.BARCODE_NO = D.BARCODE_NO AND I.ITEM_MT_MFG_PART_NO = '$mpn' ORDER BY D.LZ_DEKIT_US_MT_ID DESC");

 
	$getMasterBarcodeId = $getMasterBarcodeId->result_array();
	$master_id = $getMasterBarcodeId[0]["LZ_DEKIT_US_MT_ID"];


	$getBarcodePrv_no =  $this->db->query("SELECT DT.BARCODE_PRV_NO FROM LZ_DEKIT_US_DT DT WHERE DT.LZ_DEKIT_US_MT_ID = $master_id AND DT.OBJECT_ID = '$OBJECT_ID' AND DT.PIC_DATE_TIME IS NOT NULL AND DT.PIC_STATUS = 1 AND DT.BARCODE_PRV_NO <> $barcode ORDER BY DT.LZ_DEKIT_US_DT_ID DESC");

	$getBarcodePrv_no = $getBarcodePrv_no->result_array();	  

		if(count($getBarcodePrv_no) > 0){

		 $getBarcodePrv_no = @$getBarcodePrv_no[0]["BARCODE_PRV_NO"];
		}

		
	  // $old_path = 	$this->db->query("SELECT * FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
	  // $old_path = $old_path->result_array();
	  // $master_old_path = $old_path[0]['MASTER_PATH'];
	  // $mdir = $master_old_path.'~'.$mpn.'/'.@$it_condition;  	

  		$user = $this->session->userdata('user_id');
		date_default_timezone_set("America/Chicago");
		$pic_date = date("Y-m-d H:i:s");
		$pic_date ="TO_DATE('".$pic_date."', 'YYYY-MM-DD HH24:MI:SS')";

	    $query = $this->db->query("SELECT * FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 2");
	    $master_qry = $query->result_array();
	    $master_path = $master_qry[0]['MASTER_PATH'];
	    $live_path = $master_qry[0]['LIVE_PATH'];

		$this->load->library('image_lib'); 
		 $dir = $master_path.$getBarcodePrv_no;
		 // var_dump($getBarcodePrv_no);exit;

			if (is_dir($dir)){
				$images = glob($dir."\*.{JPG,jpg,GIF,gif,PNG,png,BMP,bmp,JPEG,jpeg}",GLOB_BRACE);

                  $i=0;
                  $azRange = range('A', 'Z');
                  foreach($images as $image){

					$parts = explode(".", $image);
					// var_dump($parts);exit;
					if (is_array($parts) && count($parts) > 1){
					    $extension = end($parts);
					    // var_dump($extension);exit;
					    if(!empty($extension)){

								$characters = 'abcdefghijklmnopqrstuvwxyz0123456789'; 
								 $img_name = '';
								 $max = strlen($characters) - 1;
								 for ($k = 0; $k < 10; $k++) {
								      $img_name .= $characters[mt_rand(0, $max)];
								      
								 }

								$sub_dir = $master_path.$barcode;

								$final_dir = $sub_dir;

								if(!is_dir($final_dir)){
									mkdir($final_dir);
								}

								/*======= MPN Image check start ======*/
								$img_url = explode("\\", $image);
			                    $check_img_name = end($img_url);				    
			                    //var_dump($check_img_name);exit;
			                    
								if($check_img_name == $pic_name){
									//var_dump($pic_name);exit;
									copy($parts['0'].".".$extension,$final_dir."/".$radio_btn.$azRange[$i]."_".$img_name.".".$extension);
								}else{	
									
									copy($parts['0'].".".$extension,$final_dir."/".$azRange[$i]."_".$img_name.".".$extension);
								}	                    
								/*======= MPN Image check end ======*/

								//copy($parts['0'].".".$extension,$final_dir."/".$azRange[$i]."_".$img_name.".".$extension);
								//copy($parts['0'].".".$extension,$master_old_path.'~'.$mpn.'/'.@$it_condition."/".$azRange[$i]."_".$img_name.".".$extension);

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
								//copy($final_dir."/thumb/".$azRange[$i].'_'.$img_name.'.'.$extension,$master_old_path.'~'.$mpn.'/'.@$it_condition."/thumb/".$azRange[$i]."_".$img_name.".".$extension);
								
								//$qr = $this->db->query("UPDATE LZ_DEKIT_US_DT SET PIC_DATE_TIME = $pic_date, PIC_BY = $user,PIC_STATUS = 1 WHERE BARCODE_PRV_NO = $barcode ");
								/*=====  End of image thumbnail creation  ======*/
							//	\Cloudinary\Uploader::upload($final_dir."/".$azRange[$i].'_'.$img_name.'.'.$extension, array("folder"=>"$barcode","use_filename" => true, "unique_filename" => false));
								
							//	\Cloudinary\Uploader::upload($final_dir."/".$azRange[$i].'_'.$img_name.'.'.$extension, array("folder"=>"$barcode"."/thumb/","use_filename" => true, "unique_filename" => false));
								$i++;
						}
					}

			    }//end while/foreach

  				/*==== Bin Assignment to item barcode start ====*/

				$bin_id_qry = $this->db->query("SELECT BIN_ID, BIN_NAME FROM (SELECT B.BIN_ID, B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME FROM BIN_MT B) WHERE BIN_NAME = '$bin_id'");

				$result = $bin_id_qry->result_array();
				$return_bin_id = @$result[0]['BIN_ID'];

				if(!(empty($return_bin_id))){
					$qr = $this->db->query("UPDATE LZ_DEKIT_US_DT SET PIC_DATE_TIME = $pic_date, PIC_BY = $user, PIC_STATUS = 1, BIN_ID = $return_bin_id WHERE BARCODE_PRV_NO = $barcode ");	
				}
			

			/*==== Bin Assignment to item barcode end ====*/

			    //closedir($dh);

			    //exit;
			 // }// sub if
			}//main if
	
	 //    if($img_moved){
		// /*======Approval check for listing=====*/	    	
				
		// 	$seed_id = $this->db->query("SELECT S.SEED_ID FROM LZ_ITEM_SEED S WHERE S.ITEM_ID = $item_id AND S.LZ_MANIFEST_ID = $manifest_id AND S.DEFAULT_COND = $it_condition");
		// 	$seed_id =  $seed_id->result_array();
		// 	$seed_id = $seed_id[0]['SEED_ID'];

		// 	date_default_timezone_set("America/Chicago");
		// 	 $list_date = date("Y-m-d H:i:s");
		//      $ins_date = "TO_DATE('".$list_date."', 'YYYY-MM-DD HH24:MI:SS')";
		// 	 $entered_by = $this->session->userdata('user_id');



	 // 	 	$query = $this->db->query("UPDATE LZ_ITEM_SEED S SET S.APPROVED_DATE = $ins_date, S.APPROVED_BY = $entered_by WHERE S.SEED_ID = $seed_id");
	 // 	 	/*======End of Approval check for listing=====*/

	 //    	$data = true;
  //       	echo json_encode($data);
  //       	return json_encode($data);
  //   	}else{
    		$data = true;
        	echo json_encode($data);
        	return json_encode($data);
    	// }			
		
	}	
	
	
	/*=====  End of save from history  ======*/
		


	/*=========================================
	=            delete single pic            =
	=========================================*/
	public function specific_img_delete(){
	    $specific_url = $this->input->post('specific_url');
	    $child_barcode = $this->input->post('child_barcode');
	 	$parts = explode("/", $specific_url);
	 	//var_dump($parts);
	 	//$str = explode(".",@$parts[4]);
	 	//var_dump($parts);exit;
		// $image_name = explode("\\", $parts[4]);
  		//$image_name = end($image_name);	   

	    $user = $this->session->userdata('user_id');
		date_default_timezone_set("America/Chicago");
		$pic_date = date("Y-m-d H:i:s");
		$pic_date ="TO_DATE('".$pic_date."', 'YYYY-MM-DD HH24:MI:SS')";
	    
	    // $string =  preg_replace('/[^A-Za-z0-9\-]/', '', $str[0]); 
	    $thumbnail_url = $parts[0].'/'.$parts[1].'/'.$parts[2].'/'.$parts[3].'/'.$parts[4].'/'.$parts[5].'/thumb/'.$parts[6];
	    //var_dump($thumbnail_url);exit;
	    // $str = preg_replace('/[^A-Za-z0-9\. -]/', '', $parts[4]);
	    // $new_string = substr($str,0,1) . "_" . substr($str,1,strlen($str)-1);
	    // $pieces = explode(".", $new_string);
	    // $new_string = $pieces[0];

	    // $spec_url = $parts[0].'/'.$parts[1].'/'.$parts[2].'/'.$parts[3].'/'.$image_name;

	    if (is_readable($specific_url ) ) {

	     	unlink($thumbnail_url);
	     	unlink($specific_url);
	     	//$qr = $this->db->query("UPDATE LZ_DEKIT_US_DT SET PIC_DATE_TIME = $pic_date, PIC_BY = $user,PIC_STATUS = 0 WHERE BARCODE_PRV_NO = $child_barcode ");
	    // \Cloudinary\Uploader::destroy($parts[3].'/'.$new_string, array( "invalidate" => TRUE));
	    // \Cloudinary\Uploader::destroy($parts[3].'/thumb/'.$new_string, array( "invalidate" => TRUE));

	     //// \Cloudinary\Uploader::destroy($new_string, array( "invalidate" => TRUE));
	      $data = true;
	        echo json_encode($data);
	        return json_encode($data);
	    } else {
	        $data = false;
	        echo json_encode($data);
	        return json_encode($data);
	    }
  }
		
	/*=====  End of delete single pic  ======*/
    public function setBinIdtoSession(){
      $data  = $this->m_dekitting_us->setBinIdtoSession(); 
      echo json_encode($data);
      return json_encode($data);    
    }  	
	
}




