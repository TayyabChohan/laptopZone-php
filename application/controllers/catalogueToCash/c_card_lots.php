
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '-1');
class C_card_lots extends CI_Controller
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
    $result['pageTitle'] = 'Special Item Recognition';
    $this->session->unset_userdata('specialLot');
    $result['data'] = $this->m_card_lots->obj_dropdown();
    $this->load->view('catalogueToCash/v_card_lots',$result);
    }
    public function lot_special_object(){
    

     $result['data'] = $this->m_card_lots->obj_dropdown();
    $this->load->view('catalogueToCash/v_special_lot_object',$result);
    }

    public function add_lot_special_object(){ 

        $data = $this->m_card_lots->add_lot_special_object();

        if($data){


         redirect('catalogueToCash/C_card_lots/lot_special_object');
        }
    // $obj_cat = $this->input->post('obj_cat');
    // $obj_name = $this->input->post('obj_name');
    // $ship_serv = $this->input->post('ship_serv');
    // $obj_cost = $this->input->post('obj_cost');
    // $obj_weig = $this->input->post('obj_weig');

    // $user_id = $this->session->userdata('user_id');
    // date_default_timezone_set("America/Chicago");
    // $date = date('Y-m-d H:i:s');
    // $curr_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";


    // $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_OBJECTS_MT', 'OBJECT_ID')ID FROM DUAL");
    //         $qry = $qry->result_array();
    //         $Object_id = $qry[0]['ID'];

    // $insert = $this->db->query(" INSERT INTO LZ_BD_OBJECTS_MT(D.OBJECT_ID, D.OBJECT_NAME, D.INSERT_DATE, D.INSERT_BY, D.CATEGORY_ID, D.ITEM_DESC, D.SHIP_SERV, D.WEIGHT, D.LZ_BD_GROUP_ID, D.ITEM_COST)values($Object_id,'$obj_name',$curr_date,$user_id,$obj_cat,'',$ship_serv,$WEIGHT,7,$obj_cost) ");
    // if($insert){
    //     $qry2 = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_CAT_GROUP_DET', 'LZ_BD_GROUP_DET_ID')GROUP_ID FROM DUAL");
    //         $qry2 = $qry2->result_array();
    //         $group_id = $qry[0]['GROUP_ID'];
    //         $this->db->query ("INSERT INTO LZ_BD_CAT_GROUP_DET(LZ_BD_GROUP_DET_ID,LZ_BD_GROUP_ID,CATEGORY_ID) VALUES($group_id,7,$obj_cat) ");

    // }

    //  $result['data'] = $this->m_card_lots->obj_dropdown();
    // $this->load->view('catalogueToCash/v_special_lot_object',$result);
    }

    public function getHistoryPics(){
    $data = $this->m_card_lots->getHistoryPics();
    echo json_encode($data);
    return json_encode($data);
    }
    public function obj_dropdown(){
    $data = $this->m_card_lots->obj_dropdown();
    echo json_encode($data);
    return json_encode($data);
    }
    public function add_special_lot(){
    $data = $this->m_card_lots->add_special_lot();
    echo json_encode($data);
    return json_encode($data);
  }
   public function update_special_lot(){
    $data = $this->m_card_lots->update_special_lot();
    echo json_encode($data);
    return json_encode($data);
  }
  public function postSpecialLots(){
    $user_id = $this->session->userdata('user_id');
    $post_data = $this->db->query("call pro_insert_lots($user_id)");
    if ($post_data) {
    echo json_encode(true);
    return json_encode(true); 
    }
  }
  public function update_without_picture(){
    $data = $this->m_card_lots->update_without_picture();
     $data2 = $this->m_card_lots->post_special_lot();


    echo json_encode($data);
    return json_encode($data);
  }
   public function combine_pics(){
    $data = $this->m_card_lots->combine_pics();
    echo json_encode($data);
    return json_encode($data);
              
    }

    public function special_lot_detail(){
        $result['pageTitle']    = 'Lot Detail';
        $result['data'] = $this->m_card_lots->obj_dropdown();

        $this->load->view('catalogueToCash/v_special_lot_detail', $result);       
    }

     public function asign_dkit_list(){
      
      $data['result'] = $this->m_card_lots->asign_dkit_list();
      echo json_encode($data['result']);
      return json_encode($data['result']);  

      
    }
    public function readyData(){
        $result['pageTitle']    = 'Lots with MNPS';
        $this->load->view('catalogueToCash/v_readyForPostingSpLots', $result);       
    }
    public function search_lots(){
        $result['pageTitle']    = 'search lots';
        $result['postings']    = $this->input->post('lot_posting');
        $result['rslt_date']    = $this->input->post('lot_date');
        $this->load->view('catalogueToCash/v_search_special_lots', $result);       
    }
    public function delete_lot(){
        $result['pageTitle']    = 'Lot Detail';
        $result['data']    = $this->m_card_lots->delete_lot();
        if($result['data'] == 1)
            {
                $this->session->set_flashdata('success', "Lot deleted successfully"); 
            }else{
                $this->session->set_flashdata('error',"Lot deletion Failed");
            }         
        $this->load->view('catalogueToCash/v_special_lot_detail', $result);       
    }
    public function load_special_lots(){
        $data         = $this->m_card_lots->load_special_lots();
        echo json_encode($data);
        return json_encode($data);     
    }

    public function post_special_lot(){       

         $data = $this->m_card_lots->post_special_lot();
        echo json_encode($data);
        return json_encode($data); 
    }
    public function load_mpns_lots(){
        $data         = $this->m_card_lots->load_mpns_lots();
        echo json_encode($data);
        return json_encode($data);     
    }
    public function discardBarcode(){
      $data = $this->m_card_lots->discardBarcode();
      echo json_encode($data);
      return json_encode($data); 
    }
  //   public function Suggest_Categories(){

  //   $UPC = $this->input->post('UPC');
  //   $TITLE = $this->input->post('TITLE');
  //   $TITLE = trim(str_replace("  ", ' ', $TITLE));
  //   $TITLE = trim(str_replace(array("'"), "''", $TITLE));
  //   $MPN = $this->input->post('MPN');
  //   $MPN = trim(str_replace("  ", ' ', $MPN));
  //       $MPN = trim(str_replace(array("'"), "''", $MPN));
  //   if(!empty($UPC) && strtoupper($UPC) != "DOES NOT APPLY")
  //   {
  //     $data['key']=$UPC;  
  //   }elseif(!empty($MPN) && strtoupper($MPN) != "DOES NOT APPLY"){
  //     $data['key']=$MPN;
  //   }elseif(!empty($TITLE)){
  //     $data['key']=$TITLE;
  //   }
  //   $data['result'] =$this->load->view('API/SuggestCategories2', $data);
  //   return $data['result'];
  // }

    public function get_avg_sold_price(){
        $catalogue_mt_id = $this->input->post('catalogue_mt_id');
        $get_kw = $this->db->query("SELECT * FROM (SELECT U.KEYWORD FROM LZ_BD_RSS_FEED_URL U WHERE U.CATLALOGUE_MT_ID ='$catalogue_mt_id' ORDER BY U.FEED_URL_ID DESC) WHERE ROWNUM=1")->result_array();
        $MPN = $this->input->post('mpn');
        $MPN = trim(str_replace("  ", ' ', $MPN));
        $MPN = trim(str_replace(array("'"), "''", $MPN));
        $CATEGORY = $this->input->post('category_id');
        $CATEGORY = trim(str_replace("  ", ' ', $CATEGORY));
        $CATEGORY = trim(str_replace(array("'"), "''", $CATEGORY));  
        $CONDITION = $this->input->post('condition_id');
        
        if(count($get_kw)>0)
        {
            $data['key']=$get_kw[0]['KEYWORD'];  
        }elseif(!empty($MPN)){
            $data['key']=$MPN;
        }else{
            return 'EXCEPTION';
        }
        $data['condition']=$CONDITION;
        $data['category']=$CATEGORY;
        $data['multicond']=false;
        $data['result'] = $this->load->view('API/get_item_sold_price2', $data);
        return $data['result'];
    }

    public function edit_lot(){
        $result['pageTitle']    = 'Special Item Recognition';
        $result['data'] = $this->m_card_lots->obj_dropdown();
        $result['datas']    = $this->m_card_lots->edit_lot();
        $this->load->view('catalogueToCash/v_edit_card_lot', $result);       
    }
    public function print_single_lot(){
    $result = $this->m_card_lots->print_single_lot();
    //$result = $this->m_dekitting_us->print_single_us_pk(); 
    // var_dump($result);exit;
    $this->load->library('m_pdf');
    // to increse or decrese the width of barcode please set size attribute in barcode tag
     foreach($result as $data){
      $html ='<div style = "margin-left:-35px!important;">
                <div style="width:222px !important;" class="barcodecell"><barcode height="0.75" size="1.18" code="'.@$data["BARCODE_PRV_NO"].'" type="C128A" class="barcode" /></div>
            
            <div style="margin-top:6px !important;width:222px;padding:0;font-size:10px;font-family:arial;">
            <span><b>'.
              @$data["BARCODE_PRV_NO"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>'.
              @$data["OBJECT_NAME"].'</u></b><br><span style="margin-top:3px!important; font-size:9px!important;font-family:arial;">'.
              @$data["COND_NAME"].'</span><br><strong>UPC:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
              .@$data["CARD_UPC"].'</strong><br><strong>MPN:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.
              @$data["CARD_MPN"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.@$data["SKU"].'</strong>'.
               
              //$newtext.
            '</span></div>
          </div>';
      //generate the PDF from the given html
      $this->m_pdf->pdf->SetJS('this.print(false);');
      $this->m_pdf->pdf->WriteHTML($html);
      //$i++;
      // if(!empty($result[$i])){
      //   $this->m_pdf->pdf->AddPage();
      // }
      
    }//end foreach
    //$i = 0;
  //download it.
  $this->m_pdf->pdf->Output($pdfFilePath, "I");


  }
  public function print_all_sticker(){
    $result = $this->m_card_lots->print_all_sticker();
    //$result = $this->m_dekitting_us->print_single_us_pk(); 
    // var_dump($result);exit;
    $this->load->library('m_pdf');
    $i = 0;
    // to increse or decrese the width of barcode please set size attribute in barcode tag
     foreach($result as $data){
      $html ='<div style = "margin-left:-35px!important;">
                <div style="width:222px !important;" class="barcodecell"><barcode height="0.75" size="1.18" code="'.@$data["BARCODE_PRV_NO"].'" type="C128A" class="barcode" /></div>
            
            <div style="margin-top:6px !important;width:222px;padding:0;font-size:10px;font-family:arial;">
            <span><b>'.
              @$data["BARCODE_PRV_NO"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>'.
              @$data["OBJECT_NAME"].'</u></b><br><span style="margin-top:3px!important; font-size:9px!important;font-family:arial;">'.
              @$data["COND_NAME"].'</span><br><strong>UPC:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
              .@$data["CARD_UPC"].'</strong><br><strong>MPN:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.
              @$data["CARD_MPN"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.@$data["SKU"].'</strong>'.
               
              //$newtext.
            '</span></div>
          </div>';
      //generate the PDF from the given html
      $this->m_pdf->pdf->SetJS('this.print(false);');
      $this->m_pdf->pdf->WriteHTML($html);
      $i++;
      if(!empty($result[$i])){
        $this->m_pdf->pdf->AddPage();
      }
      
    }//end foreach
    //$i = 0;
  //download it.
  $this->m_pdf->pdf->Output($pdfFilePath, "I");


  }
    public function img_upload(){
    // $sequn = $this->db->query("SELECT SEQ_BARCODE_NO.NEXTVAL as ID FROM DUAL")->result_array();
    // $barcode = $sequn[0]['ID'];
    $card_upc = $this->input->post('card_upc');
    $merch_id = $this->input->post('merch_id');
    $ent_qty = $this->input->post('ent_qty');
    $card_mpn = strtoupper($this->input->post('card_mpn'));
    $mpn = trim(str_replace("  ", ' ', $card_mpn));
    $card_mpn =str_replace("'", "''", $mpn);
   /* if (empty($card_mpn) || $card_mpn == '' || $card_mpn == null) {
                    $card_mpn = $card_upc;
                }*/
    $cond_item = $this->input->post('up_cond_item');

    $object_desc = strtoupper($this->input->post('up_object_desc'));
    $bin_rack = $this->input->post('up_bin_rack');


    $dek_remarks = $this->input->post('up_remarks');
    $dek_remark = trim(str_replace("  ", ' ', $dek_remarks));
    $dek =str_replace("'", "''", $dek_remark);

    $brand_name = strtoupper($this->input->post('brand_name'));
    $brand = trim(str_replace("  ", ' ', $brand_name));
    $brand_name =str_replace("'", "''", $brand);

    $mpn_description = $this->input->post('mpn_description');
    $mpn_desc = trim(str_replace("  ", ' ', $mpn_description));
    $mpn_description =str_replace("'", "''", $mpn_desc);

    $pic_notes = $this->input->post('pic_notes');
    $pic_note = trim(str_replace("  ", ' ', $pic_notes));
    $pic_not =str_replace("'", "''", $pic_note);

    $user_id = $this->session->userdata('user_id');
    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $dekit_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

    if ($object_desc == 2970) {
        $item_cost = 2;
        $item_weight = 6;
    }elseif($object_desc == 10000000086){
        $item_cost = 0.05;
        $item_weight = 3;
    }else{
        $item_cost = '';
        $item_weight = '';
    }
    $this->session->unset_userdata('specialLot');
    //////////////////////////////////////////
    //                                      //
    //////////////////////////////////////////

    $specialLot = array(
        'up_cond_item' => $cond_item,
        'up_object_desc' => $object_desc,
        'up_bin_rack' => $bin_rack,
        'merch_id' => $merch_id 
    );
    $this->session->set_userdata('specialLot', $specialLot);
    //////////////////////////////////////////
    //                                      //
    //////////////////////////////////////////
    $flag  = 0;
    $catalogue_mt_id = '';
    if (!empty($object_desc)) {
         $cats = $this->db->query("SELECT M.CATEGORY_ID FROM LZ_BD_OBJECTS_MT M WHERE M.OBJECT_ID = '$object_desc'")->result_array();
         $category_id = $cats[0]['CATEGORY_ID'];
          if (!empty($card_mpn)) {
             $check_mpn = $this->db->query("SELECT M.CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT M WHERE UPPER(M.MPN) = '$card_mpn' AND M.CATEGORY_ID = $category_id")->result_array();
         if (count($check_mpn) == 0) {
            $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT', 'CATALOGUE_MT_ID')ID FROM DUAL");
            $qry = $qry->result_array();
            $catalogue_mt_id = $qry[0]['ID'];


            $insert_mpn = $this->db->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY, OBJECT_ID, MPN_DESCRIPTION, BRAND, UPC) VALUES($catalogue_mt_id, '$card_mpn', $category_id, $dekit_date, $user_id, $object_desc, '$mpn_description', '$brand_name', '$card_upc')");
             }else{
                $catalogue_mt_id = $check_mpn[0]['CATALOGUE_MT_ID'];
             }
         }
                
                // loop on quaqntity
                
                for ($j = 1; $j<=$ent_qty ; $j++){

                $this->session->unset_userdata('special_lot_id');
                $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_SPECIAL_LOTS', 'SPECIAL_LOT_ID')ID FROM DUAL");
                $qry = $qry->result_array();
                $special_lot_id = $qry[0]['ID'];
                $this->session->set_userdata('special_lot_id', $special_lot_id);

                $sequn = $this->db->query("SELECT SEQ_BARCODE_NO.NEXTVAL as ID FROM DUAL")->result_array();
                $barcode = $sequn[0]['ID'];
                if($j == 1){
                    $fold_name = $barcode;
                }

                $insert_est_det = $this->db->query("INSERT INTO LZ_SPECIAL_LOTS(SPECIAL_LOT_ID,BARCODE_PRV_NO,OBJECT_ID,BIN_ID,PIC_DATE_TIME,PIC_BY,CATALOG_MT_ID,LOT_REMARKS,WEIGHT,CONDITION_ID,CARD_UPC,CARD_MPN, INSERTED_AT, INSERTED_BY,PIC_NOTES MPN_DESCRIPTION, BRAND, ITEM_COST,LOT_ID,FOLDER_NAME) VALUES($special_lot_id,$barcode,$object_desc,$bin_rack,$dekit_date,$user_id,'$catalogue_mt_id','$dek','$item_weight',$cond_item, '$card_upc','$card_mpn', $dekit_date, $user_id,'$pic_not', '$mpn_description', '$brand_name', '$item_cost',
                    '$merch_id','$fold_name')");
                }// end loop

                if ($insert_est_det) {
                    $flag = 1;
                }
    }

    ///////////////////////////////////////////////////////////
    if ($flag == 1) {
       // var_dump($barcode);exit;
        $azRange = range('A', 'Z');
        $this->load->library('image_lib');
        for( $i= 0; $i < count ($_FILES['image']['name']); $i++ ) {
            if(isset($_FILES["image"])) {
                // var_dump($_FILES["image"]);exit;
                @list(, , $imtype, ) = getimagesize($_FILES['image']['tmp_name'][$i]);

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
            if(getimagesize($_FILES['image']['tmp_name'][$i]) == FALSE){
              echo "Please select an image.";
            }else{

              $image = addslashes($_FILES['image']['tmp_name'][$i]);
              $name = addslashes($_FILES['image']['name'][$i]);

               $query = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 2");
               $master_qry = $query->result_array();
               $master_path = $master_qry[0]['MASTER_PATH'];
                // var_dump($master_path);exit;
                $new_dir = $master_path.$fold_name;//.;


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
                    move_uploaded_file($_FILES["image"]["tmp_name"][$i],$new_dir.'/'.$azRange[$i].'_'.$img_name.'.'.$extension);
                    //copy($new_dir.'/'.$azRange[$i].'_'.$img_name.'.'.$extension,$old_dir.'/'.$azRange[$i].'_'.$img_name.'.'.$extension);
                    /*====================================
                    =            image resize            =
                    ====================================*/
                    $config['image_library'] = 'GD2';
                    $config['source_image']  = $new_dir."/".$azRange[$i].'_'.$img_name.'.'.$extension;
                    $config['new_image']  = $new_dir."/".$azRange[$i].'_'.$img_name.'.'.$extension;
                    $config['maintain_ratio']    = true;
                    $config['width']     = 1000;
                    $config['height']   = 800;
                    //$config['create_thumb']    = true;
                    //$config['quality']     = 50; this filter doesnt work
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
                    //  mkdir($old_dir."/thumb");
                    // }
                    $config['new_image']  = $new_dir."/thumb/".$azRange[$i].'_'.$img_name.'.'.$extension;
                    // $config['old_image']  = $old_dir."/thumb/".$azRange[$i].'_'.$img_name.'.'.$extension;
                    $config['maintain_ratio']    = true;
                    $config['width']     = 100;
                    $config['height']   = 100;

                    //$config['quality']     = 50; this filter doesnt work
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
    } 
    //var_dump($special_lot_id, $image, $name, $master_path, $new_dir); exit;
    $data = array('lot_id'=>$special_lot_id, 'res'=>true); 
    echo json_encode($data);
    return json_encode($data);  

    }
     public function save_pics_master(){
      
    $sequn = $this->db->query("SELECT SEQ_BARCODE_NO.NEXTVAL as ID FROM DUAL")->result_array();
    $barcode = $sequn[0]['ID'];
    $radio_btn = $this->input->post('radio_btn'); //radio_btn identify MPN Image
    $pic_name = $this->input->post('pic_name'); //Name of pictures that select for identify MPN Image
    $card_upc  = $this->input->post('card_upc');
    $fol_name  = $this->input->post('fol_name'); // folder_name
    $card_mpn  = strtoupper($this->input->post('card_mpn')); 
    // if (empty($card_mpn) || $card_mpn == '' || $card_mpn == null) {
    //                 $card_mpn = $card_upc;
    //             }
    //radio_btn identify MPN Image
    $cond_item = $this->input->post('up_cond_item'); 
    $merch_id = $this->input->post('merch_id');     
    $ent_qty = $this->input->post('ent_qty');
    //Name of pictures that select for identify MPN Image
    $object_desc = $this->input->post('up_object_desc'); // Bin ID for Assign Bin
    $bin_rack = $this->input->post('up_bin_rack'); // Bin ID for Assign Bin
    //$this->session->set_userdata('bin_id', $bin_id); //exit;
    $brand_name = strtoupper($this->input->post('brand_name'));
    $brand = trim(str_replace("  ", ' ', $brand_name));
    $brand_name =str_replace("'", "''", $brand);

    $mpn_description = $this->input->post('mpn_description');
    $mpn_desc = trim(str_replace("  ", ' ', $mpn_description));
    $mpn_description =str_replace("'", "''", $mpn_desc);
    ////////////////////////////////////////////////////
    $dek_remarks = $this->input->post('up_remarks');
    $dek_remark = trim(str_replace("  ", ' ', $dek_remarks));
    $dek =str_replace("'", "''", $dek_remark);

    $pic_notes = $this->input->post('pic_notes');
    $pic_note = trim(str_replace("  ", ' ', $pic_notes));
    $pic_not =str_replace("'", "''", $pic_note);

    ///////////////////////////////////////////////////
    $user_id = $this->session->userdata('user_id');
    date_default_timezone_set("America/Chicago");
    $pic_date = date("Y-m-d H:i:s");
    $pic_date ="TO_DATE('".$pic_date."', 'YYYY-MM-DD HH24:MI:SS')";
    ////////////////////////////////////////
     $this->session->unset_userdata('specialLot');

    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $dekit_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
    //////////////////////////////////////////
    //                                      //
    //////////////////////////////////////////
    $specialLot = array(
        'up_cond_item' => $cond_item,
        'up_object_desc' => $object_desc,
        'up_bin_rack' => $bin_rack, 
        'merch_id' => $merch_id 
    );
    $this->session->set_userdata('specialLot', $specialLot);
    // not empty fold name 
    if(empty($fol_name)){   

    ///////////////////////////////////////
    $master_path    = '';
    $live_path      = '';
    $session_path_id = $this->session->userdata('syncDeviceLivePathId');
    if (!empty($session_path_id)) {
        $query          = $this->db->query("SELECT * FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = $session_path_id");
        $master_qry     = $query->result_array();
        $master_path    = $master_qry[0]['MASTER_PATH'];
        $live_path      = $master_qry[0]['LIVE_PATH'];
    } 
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

                        $config['image_library'] = 'gd2';
                        $config['source_image']  = $final_dir."/".$azRange[$i]."_".$img_name.".".$extension;
                        $config['new_image']  = $final_dir."/".$azRange[$i]."_".$img_name.".".$extension;
                        $config['maintain_ratio']    = true;
                        $config['width']     = 1000;
                        $config['height']   = 800;
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
                        $config['maintain_ratio']    = true;
                        $config['width']     = 100;
                        $config['height']   = 100;
                            
                            
                        //$config['quality']     = 50; this filter doesnt work
                        // var_dump($live_old_path);
                        $in =$this->image_lib->initialize($config); 
                        $result = $this->image_lib->resize($in);
                        $this->image_lib->clear();
                        //copy($final_dir."/
                        /*=====  End of upload pix to Cloudinary  ======*/   
                        $i++;
                    } //extension if end
                }
            }//end while/foreac
        }//main if
    
    
    ////////////////////////////////////////
     $data  = 0;
     $catalogue_mt_id = '';
    if (!empty($object_desc)) {
         $cats = $this->db->query("SELECT M.CATEGORY_ID FROM LZ_BD_OBJECTS_MT M WHERE M.OBJECT_ID = '$object_desc'")->result_array();
         $category_id = $cats[0]['CATEGORY_ID'];
         if (!empty($card_mpn)) {
         $check_mpn = $this->db->query("SELECT M.CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT M WHERE UPPER(M.MPN) = '$card_mpn' AND M.CATEGORY_ID = $category_id")->result_array();
         if (count($check_mpn) == 0) {
            $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT', 'CATALOGUE_MT_ID')ID FROM DUAL");
            $qry = $qry->result_array();
            $catalogue_mt_id = $qry[0]['ID'];


            $insert_mpn = $this->db->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY, OBJECT_ID, MPN_DESCRIPTION, BRAND, UPC) VALUES($catalogue_mt_id, '$card_mpn', $category_id, $dekit_date, $user_id, $object_desc, '$mpn_description', '$brand_name', '$card_upc')");
            }else{
            $catalogue_mt_id = $check_mpn[0]['CATALOGUE_MT_ID'];
         }
        } 

               if ($object_desc == 2970) {
                    $item_cost = 2;
                    $item_weight = 6;
                }elseif($object_desc == 10000000086){
                    $item_cost = 0.05;
                    $item_weight = 3;
                }else{
                    $item_cost = '';
                    $item_weight = '';
                }

                for ($j = 1; $j<=$ent_qty ; $j++){
                $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_SPECIAL_LOTS', 'SPECIAL_LOT_ID')ID FROM DUAL");
                $qry = $qry->result_array();
                $special_lot_id = $qry[0]['ID'];
                
                if($j == 1){
                    $fold_name = $barcode;
                }else{
                    $sequn = $this->db->query("SELECT SEQ_BARCODE_NO.NEXTVAL as ID FROM DUAL")->result_array();
                    $barcode = $sequn[0]['ID'];
                }

                $insert_est_det = $this->db->query("INSERT INTO LZ_SPECIAL_LOTS(SPECIAL_LOT_ID,BARCODE_PRV_NO,OBJECT_ID,BIN_ID,PIC_DATE_TIME,PIC_BY,CATALOG_MT_ID,LOT_REMARKS,WEIGHT,CONDITION_ID,CARD_UPC,CARD_MPN, INSERTED_AT, INSERTED_BY, PIC_NOTES,MPN_DESCRIPTION, BRAND, ITEM_COST,LOT_ID,FOLDER_NAME) VALUES($special_lot_id,$barcode,$object_desc,$bin_rack,$dekit_date,$user_id,'$catalogue_mt_id','$dek','$item_weight',$cond_item, '$card_upc','$card_mpn', $dekit_date, $user_id,'$pic_not', '$mpn_description', '$brand_name', '$item_cost',
                    '$merch_id','$fold_name')");
                }// end loop

                if ($insert_est_det) {
                    $data = 1;
                }
         
            }
            
        if ($data == 1) {

        ////////////////////////////////////////
        $query = $this->db->query("SELECT LIVE_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = $session_path_id");
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
             ////////////////////////////////////////
           $data = array('lot_id'=>$special_lot_id, 'res'=>true); 
            echo json_encode($data);
            return json_encode($data); 

               
        }

        }else// not empty folder_name else
        {
         $data  = 0;
        $catalogue_mt_id = '';
        if (!empty($object_desc)) {
         $cats = $this->db->query("SELECT M.CATEGORY_ID FROM LZ_BD_OBJECTS_MT M WHERE M.OBJECT_ID = '$object_desc'")->result_array();
         $category_id = $cats[0]['CATEGORY_ID'];
         if (!empty($card_mpn)) {
         $check_mpn = $this->db->query("SELECT M.CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT M WHERE UPPER(M.MPN) = '$card_mpn' AND M.CATEGORY_ID = $category_id")->result_array();
         if (count($check_mpn) == 0) {
            $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT', 'CATALOGUE_MT_ID')ID FROM DUAL");
            $qry = $qry->result_array();
            $catalogue_mt_id = $qry[0]['ID'];


            $insert_mpn = $this->db->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY, OBJECT_ID, MPN_DESCRIPTION, BRAND, UPC) VALUES($catalogue_mt_id, '$card_mpn', $category_id, $dekit_date, $user_id, $object_desc, '$mpn_description', '$brand_name', '$card_upc')");
            }else{
            $catalogue_mt_id = $check_mpn[0]['CATALOGUE_MT_ID'];
         }
        } 

               if ($object_desc == 2970) {
                    $item_cost = 2;
                    $item_weight = 6;
                }elseif($object_desc == 10000000086){
                    $item_cost = 0.05;
                    $item_weight = 3;
                }else{
                    $item_cost = '';
                    $item_weight = '';
                }

                for ($j = 1; $j<=$ent_qty ; $j++){
                $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_SPECIAL_LOTS', 'SPECIAL_LOT_ID')ID FROM DUAL");
                $qry = $qry->result_array();
                $special_lot_id = $qry[0]['ID'];
                
                if($j == 1){
                    $fold_name = $barcode;
                }else{
                    $sequn = $this->db->query("SELECT SEQ_BARCODE_NO.NEXTVAL as ID FROM DUAL")->result_array();
                    $barcode = $sequn[0]['ID'];
                }

                $insert_est_det = $this->db->query("INSERT INTO LZ_SPECIAL_LOTS(SPECIAL_LOT_ID,BARCODE_PRV_NO,OBJECT_ID,BIN_ID,PIC_DATE_TIME,PIC_BY,CATALOG_MT_ID,LOT_REMARKS,WEIGHT,CONDITION_ID,CARD_UPC,CARD_MPN, INSERTED_AT, INSERTED_BY, PIC_NOTES,MPN_DESCRIPTION, BRAND, ITEM_COST,LOT_ID,FOLDER_NAME) VALUES($special_lot_id,$barcode,$object_desc,$bin_rack,$dekit_date,$user_id,'$catalogue_mt_id','$dek','$item_weight',$cond_item, '$card_upc','$card_mpn', $dekit_date, $user_id,'$pic_not', '$mpn_description', '$brand_name', '$item_cost',
                    '$merch_id','$fol_name')");
                }// end loop

                if ($insert_est_det) {
                    $data = 1;
                }
         
            }
            
        if ($data == 1) {
           $data = array('lot_id'=>$special_lot_id, 'res'=>true); 
            echo json_encode($data);
            return json_encode($data); 

               
        }


        } // not empty folder_name  end if
    }





    ////////
    public function delete_all_master(){
    $upc = $this->input->post('upc');
    $mpn = $this->input->post('part_no');
    $mpn = str_replace('/', '_', $mpn);
    $it_condition = $this->input->post('it_condition');
    if(is_numeric($it_condition)){
            if($it_condition == 3000){
                $it_condition = 'Used';
            }elseif($it_condition == 1000){
                $it_condition = 'New'; 
            }elseif($it_condition == 1500){
                $it_condition = 'New other'; 
            }elseif($it_condition == 2000){
                $it_condition = 'Manufacturer refurbished';
            }elseif($it_condition == 2500){
                $it_condition = 'Seller refurbished'; 
            }elseif($it_condition == 7000){
                $it_condition = 'For parts or not working'; 
            }else{
                $it_condition = 'Used'; 
            }
        }else{ // end main if
            $it_condition  = ucfirst($it_condition);
        }       

    $query = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 5");
    $master_qry = $query->result_array();
    $master_path = $master_qry[0]['MASTER_PATH'];

    $dir = $master_path.$upc."~".@$mpn."/".$it_condition;
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


  public function deleteAllLivePictures(){
        $query = $this->db->query("SELECT LIVE_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 5");
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
    public function master_sorting_order(){
        $master_reorder = $this->input->post('master_reorder');

        $namess = [];

        //$it_condition = $this->input->post('condition');
        // var_dump($it_condition);
        $barcode = $this->input->post('child_barcode');

        $query = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 5");
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

                        //  \Cloudinary\Uploader::destroy($barcode.'/'.$new_string, array( "invalidate" => TRUE));
                        //  \Cloudinary\Uploader::destroy($barcode.'/thumb/'.$new_string, array( "invalidate" => TRUE));

                        //  \Cloudinary\Uploader::upload($dir."/".$azRange[$i]."_".$img_name.".".$extension, array("folder"=>"$barcode","use_filename" => true, "unique_filename" => false));
                        //  \Cloudinary\Uploader::upload($dir2."/".$azRange[$i]."_".$img_name.".".$extension, array("folder"=>"$barcode"."/thumb/","use_filename" => true, "unique_filename" => false));
                            
                            $i++;
                    }
                }

            }//exit;//end while
            closedir($dh);

            //exit;
          }// sub if
        }//main if 

        if(@$img_order2){

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
    public function print_single_lot_withoutPDF(){
    $result['data'] = $this->m_card_lots->print_single_lot_withoutPDF();
    $this->load->view('catalogueToCash/v_printView', $result);    

  }  
  function syncDevice(){
    $syncPictures = strtoupper(trim($this->input->post('syncPictures')));
    $live_path = '';
    $live_path_id = '';
    if ($syncPictures == 'PS1') {
        $path = $this->db->query("SELECT LIVE_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 2");
        $path = $path->result_array();
        $live_path = $path[0]['LIVE_PATH'];
        $live_path_id = $this->session->set_userdata('syncDeviceLivePathId', 2);
    }elseif ($syncPictures == 'PS2') {
        $path = $this->db->query("SELECT LIVE_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 5");
        $path = $path->result_array();
        $live_path = $path[0]['LIVE_PATH'];
        $live_path_id = $this->session->set_userdata('syncDeviceLivePathId', 5);
    }

    $result['pageTitle'] = 'Special Lots';
    $result['data'] = $this->m_card_lots->obj_dropdown();
    $result['live_path'] = $live_path_id;
    $this->load->view('catalogueToCash/v_card_lots',$result); 
  }

  public function serch_desc_sys(){
    $data = $this->m_card_lots->serch_desc_sys();
    echo json_encode($data);
    return json_encode($data);
    }
    public function serch_mpn_sys(){
    $data = $this->m_card_lots->serch_mpn_sys();
    echo json_encode($data);
    return json_encode($data);
    }
    public function serch_upc_sys(){
    $data = $this->m_card_lots->serch_upc_sys();
    echo json_encode($data);
    return json_encode($data);
    }
    public function get_obj_id(){
    $data = $this->m_card_lots->get_obj_id();
    echo json_encode($data);
    return json_encode($data);
    }
    public function get_cat_avail_cond(){
    $data = $this->m_card_lots->get_cat_avail_cond();
    echo json_encode($data);
    return json_encode($data);
    }

    public function get_avil_obj(){
    $data = $this->m_card_lots->obj_dropdown();
    echo json_encode($data);
    return json_encode($data);
    }
    public function get_unique_count_lot(){
    $data = $this->m_card_lots->get_unique_count_lot();
    echo json_encode($data);
    return json_encode($data);
    }
    public function upda_remar_only(){
    $data = $this->m_card_lots->upda_remar_only();
    echo json_encode($data);
    return json_encode($data);
    }
   
/*=====  End of update seller description  ======*/
}
