<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class c_images extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('download');
    }
    public function index()
    {
        
      $query = $this->db->query('SELECT * FROM ITEM_PICTURES_MT');
            
      $img_data= $query->result();
      if(!empty($img_data)){
        foreach($img_data as $im){
          $img = $im->ITEM_PIC->load();
          $item_id = $im->ITEM_ID;
        /*==============================================
        =            get image storage path            =
        ==============================================*/
        $query = $this->db->query("SELECT * FROM LZ_PICT_PATH_CONFIG");
        $master_qry = $query->result_array();
        $master_path = $master_qry[0]['MASTER_PATH'];
        $live_path = $master_qry[0]['LIVE_PATH'];
        

        /*=====  End of get image storage path  ======*/

        $query = $this->db->query("SELECT I.ITEM_MT_UPC,I.ITEM_MT_MFG_PART_NO,I.ITEM_CONDITION FROM ITEMS_MT I WHERE I.ITEM_ID=$item_id");
        $itm_det = $query->result_array();
        $upc = $itm_det[0]['ITEM_MT_UPC'];        
        $mpn = $itm_det[0]['ITEM_MT_MFG_PART_NO'];
        $it_condition = $itm_det[0]['ITEM_CONDITION'];
        
        $mpn = str_replace('/', '_', $mpn);
        $dir = $master_path.$upc."~".@$mpn;

        // if(is_numeric($it_condition)){
        //       if($it_condition == 3000){
        //         $it_condition = 'Used';
        //       }elseif($it_condition == 1000){
        //         $it_condition = 'New'; 
        //       }elseif($it_condition == 1500){
        //         $it_condition = 'New other'; 
        //       }elseif($it_condition == 2000){
        //           $it_condition = 'Manufacturer refurbished';
        //       }elseif($it_condition == 2500){
        //         $it_condition = 'Seller refurbished'; 
        //       }elseif($it_condition == 7000){
        //         $it_condition = 'For parts or not working'; 
        //       }else{
        //           $it_condition = 'Used'; 
        //       }
        //   }else
        if(ucfirst($it_condition) == 'New' || ucfirst($it_condition) == 'New Without Tags'){// end main if
            $it_condition  = 'New';
          }elseif(ucfirst($it_condition) == 'Used'){
            $it_condition = 'Used';
          }elseif(ucfirst($it_condition) == 'New Other' || $it_condition == 'New other (see details)'){
            $it_condition = 'New other';
          }elseif(ucfirst($it_condition) == 'Manufacturer Refurbished'){
            $it_condition = 'Manufacturer refurbished';
          }elseif(ucfirst($it_condition) == 'Seller Refurbished'){
            $it_condition = 'Seller refurbished';
          }elseif(ucfirst($it_condition) == 'For Parts Or Not Working'){
            $it_condition = 'For parts or not working';
          }else{
                  $it_condition = 'Used'; 
          }

          $path = $dir.'/'.$it_condition;
          if(!is_dir($dir)){
          mkdir($dir);
          
        }
        if(!is_dir($path)){
            mkdir($path);
          }
          //$path = "C:/";
          $file = fopen($path."/".$im->ITEM_PICT_DESC,"w");
          //echo "File name: ".$path."$im->ITEM_PICT_DESC\n";
          fwrite($file, $img);
          fclose($file);

    /*================================================
    =            image display on webpage            =
    ================================================*/

                // echo '<li id="$im->ITEM_PICTURE_ID">';
                //   echo '<span class="tg-li">';
                //     echo '<div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);">';  

                //       echo '<img class="sort_img up-img" id="'.$im->ITEM_PICTURE_ID.'" name="'.$im->ITEM_PICT_DESC.'" src="data:image;base64,'.$pic.' "/>';

                //       echo '<div class="img_overlay">';
                //         echo '<span><i class="fa fa-trash"></i></span>';
                //       echo '</div>';

                //     echo '</div>';                    
                //  echo '</span>';                        
                // echo '</li>';  

    /*=====  End of image display on webpage  ======*/
      
        }
      }
            
    }
  } 