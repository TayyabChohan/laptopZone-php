<?php
class c_dekitting extends CI_Controller {
  public function __construct(){
    parent::__construct();
    $this->load->database();
    $this->load->model("androidpicapp/m_dekitting");
    $this->load->helper('security');
    $this->load->library('image_lib');
    /*=============================================
    =  Section lz_bigData db connection block  =
    =============================================*/
    //$CI = &get_instance();
    //setting the second parameter to TRUE (Boolean) the function will return the database object.
   // $this->db2 = $CI->load->database('bigData', TRUE);
    /*======= End Section lz_bigData db connection block=====*/

    /*==============================================================
    =            get distinct category for rss feed url            =
    ==============================================================*/
    // $get_cat = $this->db2->query("SELECT DISTINCT CATEGORY_ID from LZ_BD_RSS_FEED_URL")->result_array();
    // foreach ($get_cat as $cat) {
    //   $this->cat_rss_feed($cat['CATEGORY_ID']);
    // }

    /*=====  End of get distinct category for rss feed url  ======*/
      
  }

  public function searchBarcode()
  {
    $masterBarcode = $_POST['master_barcode'];
    // $masterBarcode = "122994";
    $result = $this->m_dekitting->searchMasterBarcode($masterBarcode); 
    echo(json_encode($result));
  }
  public function createMasterDekit()
  {
    $masterBarcode = $_POST['master_barcode'];
    $userId = $_POST['user_id'];
    $userId = 2;
    $path = "";
    $url = "";
    $image_path_array = [];

    $azRange = range('A', 'Z');
    $j = 0;
    $myFile = "data.json";
    $path = "C:/wamp/www/item_pictures/dekitted_pictures/";
     file_put_contents($myFile, $masterBarcode);
    // $masterBarcode = file_get_contents($myFile);
    $masterBarcode = json_decode($masterBarcode);

    $live_path = $path."/".$masterBarcode->folderName;

    if (!is_dir($live_path)){
      //if (!file_exists($live_path)) {
          //if (is_dir($folderName) === false){
              // create upload/images folder
              mkdir($live_path, 0777, true);
         // }
      //}
    }
    if (is_dir($live_path)){
      if ($dh = opendir($live_path)){
       //$i=1;
        while (($file = readdir($dh)) !== false){
         $parts = explode(".", $file);
           if (is_array($parts) && count($parts) > 1){
           $extension = end($parts);
           if(!empty($extension)){
           
           //$img_name = explode('_', $master_reorder[$i-1]);
           //rename($dir."/".$parts['0'].".".$extension, $new_dir."/".$barcode."_".$i.".".$extension);
          //  @$img_order = unlink($live_path."/".$parts['0'].".".$extension);
          //  @$thumb_order = unlink($live_path."/thumb/".$parts['0'].".".$extension);
          $j++;

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
    // $masterBarcode->images_base64 = "null";
    $image_array = $masterBarcode->images_base64;
    for ($k = 0; $k<count($image_array); $k++)
        {
         // $response = $response." ".$Array[$i]->image_folder;ss
        //  echo($image_array[$k]);
        //  exit;
                $decodedImage = base64_decode($image_array[$k]);
                
                // $name = $image_array[$k]->file_name;
                // $name = str_replace('/', '_', $name);
                $characters = 'abcdefghijklmnopqrstuvwxyz0123456789'; 
                $name = '';
                $max = strlen($characters) - 1;
                for ($l = 0; $l < 10; $l++) {
                    $name .= $characters[mt_rand(0, $max)];
                }
                

    
        $return = file_put_contents($live_path."/".$azRange[$j]."_".$name.".jpg", $decodedImage);

                    $config['image_library'] = 'GD2';
                    // $config['source_image']  = $sub_dir2."/".$azRange[$i].'_'.$img_name.'.'.$extension;
                    $config['source_image']  = $live_path."/".$azRange[$j]."_".$name.".jpg";
                    if(!is_dir($live_path."/thumb")){
                        mkdir($live_path."/thumb");
                    }
                    $config['new_image']  = $live_path."/thumb/".$azRange[$j]."_".$name.".jpg";
                    $config['maintain_ratio']    = true;
                    $config['width']     = 100;
                    $config['height']   = 100;
                    
                    

                    //$config['quality']     = 50; this filter doesnt work
                    $in =$this->image_lib->initialize($config); 
                    $result = $this->image_lib->resize($in);
                    $this->image_lib->clear();

             if($j !==  25)
                    {
                      $j++;
                    }
                    else
                    {
                        $j = 0;
                    }

            }
            $m_flag = false;
					if(is_dir(@$live_path)){
						// var_dump($d_dir);
						 $iterator = new \FilesystemIterator(@$live_path);
							 if(@$iterator->valid()){    
									 $m_flag = true;
							 }else{
								 $m_flag = false;
							 }
						}
						if($m_flag)
						{
							if(is_dir($live_path))
							{
								$images = scandir($live_path);
								if(count($images) > 0)
								{
									for($i=2; $i<count($images)-1; $i++)
									{
									$image_path_array[$i-2] = $masterBarcode->folderName.'/'.$images[$i];}
								}
							}
						}

            $result = $this->m_dekitting->createMasterDekit($masterBarcode, $userId); 

    echo(json_encode(array("success" => $masterBarcode->barcode_no, "image" => $image_path_array, "mt_id" => $result)));
    // file_put_contents($myFile, $masterBarcode);
    // $pull_barcode = json_decode($pull_barcode);
    
  }
  public function getNewBarcode()
  {
    $result = $this->m_dekitting->getNewBarcode();
    echo json_encode($result);
  }
  public function createChildDekit()
  {
    // $childBarcode  = $_POST['child_barcode'];
    // $mtId          = $_POST['mt_id'];
    $mtId             = "1440";

    $myFile = "data.json";
    // $path = "C:/wamp/www/item_pictures/dekitted_pictures/";
    //  file_put_contents($myFile, $childBarcode);
        $childBarcode = file_get_contents($myFile);
        $childBarcode = json_decode($childBarcode);
        // echo ($childBarcode->barcode);

        $result = $this->m_dekitting->createChildDekit($childBarcode, $mtId);
        echo json_encode(array('result' => $result));


  }


}