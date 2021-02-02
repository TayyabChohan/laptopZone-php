<?php 

  class M_UnpostItem extends CI_Model{
    public function __construct(){
    parent::__construct();
    $this->load->database();
  }
  public function queryData($perameter){
    $show_all=$this->input->post('show_all');
    //var_dump($show_all); exit;
    if(is_numeric($perameter)){
      $query = $this->db->query("SELECT S.SEED_ID, S.SHIPPING_SERVICE, S.EBAY_PRICE, LM.SINGLE_ENTRY_ID, LM.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE LAPTOP_ITEM_CODE, NVL(S.ITEM_TITLE, I.ITEM_DESC) ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_BBY_SKU SKU_NO, I.ITEM_MT_UPC UPC, BCD.EBAY_ITEM_ID, BCD.CONDITION_ID ITEM_CONDITION, BCD.BARCODE_NO, QRY_PRICE.COST_PRICE FROM LZ_MANIFEST_MT LM, ITEMS_MT I, LZ_ITEM_SEED S, (SELECT BC.EBAY_ITEM_ID, BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.BARCODE_NO FROM LZ_BARCODE_MT BC WHERE BC.BARCODE_NO = $perameter) BCD, (SELECT D.LZ_MANIFEST_ID, I.ITEM_ID, MAX(D.PO_DETAIL_RETIAL_PRICE) COST_PRICE FROM LZ_MANIFEST_DET D, ITEMS_MT I WHERE D.LAPTOP_ITEM_CODE = I.ITEM_CODE GROUP BY D.LZ_MANIFEST_ID, I.ITEM_ID) QRY_PRICE WHERE BCD.ITEM_ID = I.ITEM_ID AND BCD.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND BCD.ITEM_ID = QRY_PRICE.ITEM_ID AND BCD.LZ_MANIFEST_ID = QRY_PRICE.LZ_MANIFEST_ID AND S.ITEM_ID(+) = BCD.ITEM_ID AND S.LZ_MANIFEST_ID(+) = BCD.LZ_MANIFEST_ID AND S.DEFAULT_COND(+) = BCD.CONDITION_ID"); 
      //$query = $this->db->query("SELECT LS.SEED_ID, LS.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE           LAPTOP_ITEM_CODE, I.ITEM_DESC           ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_BBY_SKU     SKU_NO, I.ITEM_MT_UPC         UPC, BCD.CONDITION_ID      ITEM_CONDITION,BCD.BARCODE_NO FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID,BC.BARCODE_NO FROM LZ_BARCODE_MT BC WHERE BC.BARCODE_NO = $perameter) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID ");
      if($query->num_rows() > 0){
        $query = $query->result_array();
       /* echo "<pre>";
        print_r($query);
        exit;*/
        foreach ($query as $q)
        {
          $manifest_id                =$q['LZ_MANIFEST_ID'];
          $item_id                    =$q['ITEM_ID'];
          $condition_id               =$q['ITEM_CONDITION'];
          if (empty($condition_id)) {
            $condition_id=NULL;
          }
        }
        if (!empty($show_all) && $show_all=='All') {
          $not_listed_barcode = $this->db->query("SELECT S.SEED_ID, S.SHIPPING_SERVICE, S.EBAY_PRICE, LM.SINGLE_ENTRY_ID, LM.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE LAPTOP_ITEM_CODE, NVL(S.ITEM_TITLE, I.ITEM_DESC) ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_BBY_SKU SKU_NO, I.ITEM_MT_UPC UPC, BCD.EBAY_ITEM_ID, BCD.CONDITION_ID ITEM_CONDITION, BCD.BARCODE_NO, QRY_PRICE.COST_PRICE FROM LZ_MANIFEST_MT LM, ITEMS_MT I, LZ_ITEM_SEED S, (SELECT BC.EBAY_ITEM_ID, BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.BARCODE_NO FROM LZ_BARCODE_MT BC WHERE BC.LZ_MANIFEST_ID=$manifest_id AND BC.ITEM_ID=$item_id AND BC.CONDITION_ID= $condition_id ) BCD, (SELECT D.LZ_MANIFEST_ID, I.ITEM_ID, MAX(D.PO_DETAIL_RETIAL_PRICE) COST_PRICE FROM LZ_MANIFEST_DET D, ITEMS_MT I WHERE D.LAPTOP_ITEM_CODE = I.ITEM_CODE GROUP BY D.LZ_MANIFEST_ID, I.ITEM_ID) QRY_PRICE WHERE BCD.ITEM_ID = I.ITEM_ID AND BCD.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND BCD.ITEM_ID = QRY_PRICE.ITEM_ID AND BCD.LZ_MANIFEST_ID = QRY_PRICE.LZ_MANIFEST_ID AND S.ITEM_ID(+) = BCD.ITEM_ID AND S.LZ_MANIFEST_ID(+) = BCD.LZ_MANIFEST_ID AND S.DEFAULT_COND(+) = BCD.CONDITION_ID ");
        $not_listed_barcode =  $not_listed_barcode->result_array();
        }else{
              $not_listed_barcode = $this->db->query("SELECT S.SEED_ID, S.SHIPPING_SERVICE, S.EBAY_PRICE, LM.SINGLE_ENTRY_ID, LM.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE LAPTOP_ITEM_CODE, NVL(S.ITEM_TITLE, I.ITEM_DESC) ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_BBY_SKU SKU_NO, I.ITEM_MT_UPC UPC, BCD.EBAY_ITEM_ID, BCD.CONDITION_ID ITEM_CONDITION, BCD.BARCODE_NO, QRY_PRICE.COST_PRICE FROM LZ_MANIFEST_MT LM, ITEMS_MT I, LZ_ITEM_SEED S, (SELECT BC.EBAY_ITEM_ID, BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.BARCODE_NO FROM LZ_BARCODE_MT BC WHERE BC.LZ_MANIFEST_ID=$manifest_id AND BC.ITEM_ID=$item_id AND BC.BARCODE_NO = $perameter ) BCD, (SELECT D.LZ_MANIFEST_ID, I.ITEM_ID, MAX(D.PO_DETAIL_RETIAL_PRICE) COST_PRICE FROM LZ_MANIFEST_DET D, ITEMS_MT I WHERE D.LAPTOP_ITEM_CODE = I.ITEM_CODE GROUP BY D.LZ_MANIFEST_ID, I.ITEM_ID) QRY_PRICE WHERE BCD.ITEM_ID = I.ITEM_ID AND BCD.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND BCD.ITEM_ID = QRY_PRICE.ITEM_ID AND BCD.LZ_MANIFEST_ID = QRY_PRICE.LZ_MANIFEST_ID AND S.ITEM_ID(+) = BCD.ITEM_ID AND S.LZ_MANIFEST_ID(+) = BCD.LZ_MANIFEST_ID AND S.DEFAULT_COND(+) = BCD.CONDITION_ID ");
              $not_listed_barcode =  $not_listed_barcode->result_array();
        }
        
      }else{

        //$query = "SELECT LS.SEED_ID, LS.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE           LAPTOP_ITEM_CODE, I.ITEM_DESC           ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_BBY_SKU     SKU_NO, I.ITEM_MT_UPC         UPC, BCD.CONDITION_ID      ITEM_CONDITION,BCD.BARCODE_NO FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID,BC.BARCODE_NO FROM LZ_BARCODE_MT BC) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID(+) AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID";
        $query = "SELECT S.SEED_ID, S.SHIPPING_SERVICE, S.EBAY_PRICE, LM.SINGLE_ENTRY_ID, LM.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE LAPTOP_ITEM_CODE, NVL(S.ITEM_TITLE, I.ITEM_DESC) ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_BBY_SKU SKU_NO, I.ITEM_MT_UPC UPC, BCD.EBAY_ITEM_ID, BCD.CONDITION_ID ITEM_CONDITION, BCD.QTY QUANTITY, QRY_PRICE.COST_PRICE FROM LZ_MANIFEST_MT LM, ITEMS_MT I, LZ_ITEM_SEED S, (SELECT BC.EBAY_ITEM_ID, BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.EBAY_ITEM_ID) BCD, (SELECT D.LZ_MANIFEST_ID, I.ITEM_ID, MAX(D.PO_DETAIL_RETIAL_PRICE) COST_PRICE FROM LZ_MANIFEST_DET D, ITEMS_MT I WHERE D.LAPTOP_ITEM_CODE = I.ITEM_CODE GROUP BY D.LZ_MANIFEST_ID, I.ITEM_ID) QRY_PRICE WHERE BCD.ITEM_ID = I.ITEM_ID AND BCD.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND BCD.ITEM_ID = QRY_PRICE.ITEM_ID AND BCD.LZ_MANIFEST_ID = QRY_PRICE.LZ_MANIFEST_ID AND S.ITEM_ID(+) = BCD.ITEM_ID AND S.LZ_MANIFEST_ID(+) = BCD.LZ_MANIFEST_ID AND S.DEFAULT_COND(+) = BCD.CONDITION_ID"; 
        $perameter = "AND (I.ITEM_ID like '%$perameter%' or I.ITEM_CODE like '%$perameter%' or I.ITEM_DESC like '%$perameter%' or I.ITEM_MT_MANUFACTURE like '%$perameter%' or I.ITEM_MT_MFG_PART_NO like '%$perameter%' or I.ITEM_MT_BBY_SKU like '%$perameter%' or I.ITEM_MT_UPC like '%$perameter%' or LM.PURCH_REF_NO like '%$perameter%' or LM.LZ_MANIFEST_ID like '%$perameter%')";
        $query = $this->db->query($query." ".$perameter. " ORDER BY LM.LZ_MANIFEST_ID DESC");
        
        if($query->num_rows() > 0){
        $query = $query->result_array();
        $not_listed_barcode = $this->db->query("SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.BARCODE_NO FROM LZ_BARCODE_MT BC WHERE BC.ITEM_ID =".$query[0]['ITEM_ID']."AND BC.LZ_MANIFEST_ID=".$query[0]['LZ_MANIFEST_ID']." AND BC.CONDITION_ID=".$query[0]['ITEM_CONDITION']."");
        $not_listed_barcode =  $not_listed_barcode->result_array();
      }else{
        $not_listed_barcode =[];
        $query = $query->result_array();
      }
      
      }
    }else{

        $query = "SELECT S.SEED_ID, S.SHIPPING_SERVICE, S.EBAY_PRICE, LM.SINGLE_ENTRY_ID, LM.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE LAPTOP_ITEM_CODE, NVL(S.ITEM_TITLE, I.ITEM_DESC) ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_BBY_SKU SKU_NO, I.ITEM_MT_UPC UPC, BCD.EBAY_ITEM_ID, BCD.CONDITION_ID ITEM_CONDITION, BCD.QTY QUANTITY, QRY_PRICE.COST_PRICE FROM LZ_MANIFEST_MT LM, ITEMS_MT I, LZ_ITEM_SEED S, (SELECT BC.EBAY_ITEM_ID, BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.EBAY_ITEM_ID) BCD, (SELECT D.LZ_MANIFEST_ID, I.ITEM_ID, MAX(D.PO_DETAIL_RETIAL_PRICE) COST_PRICE FROM LZ_MANIFEST_DET D, ITEMS_MT I WHERE D.LAPTOP_ITEM_CODE = I.ITEM_CODE GROUP BY D.LZ_MANIFEST_ID, I.ITEM_ID) QRY_PRICE WHERE BCD.ITEM_ID = I.ITEM_ID AND BCD.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND BCD.ITEM_ID = QRY_PRICE.ITEM_ID AND BCD.LZ_MANIFEST_ID = QRY_PRICE.LZ_MANIFEST_ID AND S.ITEM_ID(+) = BCD.ITEM_ID AND S.LZ_MANIFEST_ID(+) = BCD.LZ_MANIFEST_ID AND S.DEFAULT_COND(+) = BCD.CONDITION_ID"; 
      //$query = "SELECT LS.SEED_ID, LS.LZ_MANIFEST_ID, LS.SHIPPING_SERVICE, LS.EBAY_PRICE, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE LAPTOP_ITEM_CODE, LS.ITEM_TITLE ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_BBY_SKU SKU_NO, I.ITEM_MT_UPC UPC, BCD.BARCODE_NO, BCD.CONDITION_ID  ITEM_CONDITION FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.BARCODE_NO,BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID FROM LZ_BARCODE_MT BC) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID";
        $perameter = "AND (I.ITEM_ID like '%$perameter%' or I.ITEM_CODE like '%$perameter%' or I.ITEM_DESC like '%$perameter%' or I.ITEM_MT_MANUFACTURE like '%$perameter%' or I.ITEM_MT_MFG_PART_NO like '%$perameter%' or I.ITEM_MT_BBY_SKU like '%$perameter%' or I.ITEM_MT_UPC like '%$perameter%' or LM.PURCH_REF_NO like '%$perameter%' or LM.LZ_MANIFEST_ID like '%$perameter%')";
        $query = $this->db->query($query." ".$perameter. " ORDER BY LM.LZ_MANIFEST_ID DESC");
        
        if($query->num_rows() > 0){
        $query = $query->result_array();
        $not_listed_barcode = $this->db->query("SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.BARCODE_NO FROM LZ_BARCODE_MT BC WHERE BC.ITEM_ID =".$query[0]['ITEM_ID']." AND BC.LZ_MANIFEST_ID=".$query[0]['LZ_MANIFEST_ID']." AND BC.CONDITION_ID=".$query[0]['ITEM_CONDITION']."");
        $not_listed_barcode =  $not_listed_barcode->result_array();
      }else{
        $not_listed_barcode =[];
        $query = $query->result_array();
      }
      
      }

      $path_query = $this->db->query("SELECT * FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
        $path_query =  $path_query->result_array();

      $barcode_arr = [];
      // var_dump($query);exit;
          foreach($query as $cond){
            //var_dump($cond['CONDITION_ID']);exit;
            if(!empty($cond['ITEM_CONDITION'])){
              $condition_id = @$cond['ITEM_CONDITION'];

            $barcode_qry = $this->db->query("SELECT MT.BARCODE_NO, MT.ITEM_ID, MT.LZ_MANIFEST_ID FROM LZ_BARCODE_MT MT WHERE MT.ITEM_ID = ".$cond['ITEM_ID']." AND MT.LZ_MANIFEST_ID = ".$cond['LZ_MANIFEST_ID']." AND CONDITION_ID = ".$condition_id." AND ROWNUM = 1");
           
            if($barcode_qry->num_rows() > 0){
              $barcode_qry = $barcode_qry->result_array();
    //var_dump(@$barcode_qry[0]['BARCODE_NO']);exit;
            array_push($barcode_arr, @$barcode_qry[0]['BARCODE_NO']);
          }
            
          }else{
            //$barcode_qry = null;
            array_push($barcode_arr, null);
            
          }       

        } //END FOREACH    

         
        

        return array('query'=>$query,'path_query' => $path_query, 'not_listed_barcode' => $not_listed_barcode, 'barcode_qry'=>$barcode_arr);

    }
    public function getData($perameter){

      $data_qry = $this->db->query("SELECT B.ITEM_ID, B.LZ_MANIFEST_ID, C.COND_NAME, I.ITEM_DESC,B.EBAY_ITEM_ID FROM LZ_BARCODE_MT B, ITEMS_MT I , LZ_ITEM_COND_MT C WHERE B.ITEM_ID = I.ITEM_ID AND C.ID = B.CONDITION_ID AND B.ITEM_ADJ_DET_ID_FOR_IN IS NULL AND B.LIST_ID IS NULL AND B.SALE_RECORD_NO IS NULL AND B.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND B.LZ_PART_ISSUE_MT_ID IS NULL AND B.PULLING_ID IS NULL AND B.BARCODE_NO = $perameter"); 
      if($data_qry->num_rows() > 0){
        return array('response' => $data_qry->result_array(),'item_alloc' => '');
      }else{
        /*============================================
        =            check in special lot            =
        ============================================*/
          $check_barcode = $this->db->query("SELECT * FROM LZ_SPECIAL_LOTS D WHERE D.BARCODE_PRV_NO = $perameter"); 
          if($check_barcode->num_rows() > 0){
            $delete_barcode = $this->db->query("DELETE FROM LZ_SPECIAL_LOTS WHERE BARCODE_PRV_NO = $perameter");
            return array('response' => $data_qry->result_array(),'deleted' => '1');
            /*=====  End of check in special lot  ======*/
          }else{
            /*============================================
            =            check in dekit table            =
            ============================================*/
            $check_barcode = $this->db->query("SELECT * FROM LZ_DEKIT_US_DT D WHERE D.BARCODE_PRV_NO = $perameter"); 
            if($check_barcode->num_rows() > 0){
              $this->db->query("DELETE FROM LZ_DEKIT_US_DT WHERE BARCODE_PRV_NO = $perameter");
              return array('response' => $data_qry->result_array(),'deleted' => '1');
              /*=====  End of check in dekit table  ======*/
            }else{
              /*=================================================
              =            check in merchent barcode            =
              =================================================*/
              $check_barcode = $this->db->query("SELECT * FROM LZ_MERCHANT_BARCODE_DT D WHERE D.BARCODE_NO = $perameter"); 
              if($check_barcode->num_rows() > 0){
                $delete_barcode = $this->db->query("DELETE FROM LZ_MERCHANT_BARCODE_DT D WHERE D.BARCODE_NO = $perameter");
                return array('response' => $data_qry->result_array(),'deleted' => '1');
              }else{
                return array('response' => $data_qry->result_array(),'item_alloc' => '1');
              }
              /*=====  End of check in merchent barcode  ======*/
              
            }// check dekit if else end
          }//check special lot if else end        
      }// main if else
      
    }
    public function UnpostItem(){
          date_default_timezone_set("America/Chicago");
          $del_date = date("Y-m-d H:i:s");
          $del_date = "TO_DATE('".$del_date."', 'YYYY-MM-DD HH24:MI:SS')";
          $deleted_by = $this->session->userdata('user_id');     
          //$user_name = $this->input->post('user_name');
          $remarks = $this->input->post('remarks');
          if(empty($remarks)){
            $remarks = "";
          }
          $barcode = $this->input->post('unpost_item');

           //var_dump($barcode);exit;
          // $seed_id = explode(',',$seed_id);
          $comma = ",";

          foreach($barcode as $barcode_no){

            // $item_alloc = $this->db->query("select * from lz_listing_alloc a where a.seed_id = (select s.seed_id from lz_barcode_mt b, lz_item_seed s where b.item_id = s.item_id and b.lz_manifest_id = s.lz_manifest_id and b.condition_id = s.default_cond and b.barcode_no = $barcode_no)");

            // if($item_alloc->num_rows() > 0){

            //  return array('item_alloc'=>$item_alloc);

            // }else{

              $hold_barcode_qry = $this->db->query("SELECT * FROM LZ_BARCODE_HOLD_LOG WHERE BARCODE_NO = $barcode_no AND ACTION = 1");
                if($hold_barcode_qry->num_rows() == 0){                        

                // $query = $this->db->query("SELECT get_single_primary_key('LZ_DELETION_LOG','LOG_ID') LOG_ID FROM DUAL");
                // $rs = $query->result_array();
                // $log_id = $rs[0]['LOG_ID'];
                // $query = $this->db->query("SELECT B.ITEM_ID,B.LZ_MANIFEST_ID,B.CONDITION_ID, I.ITEM_DESC FROM LZ_BARCODE_MT B, ITEMS_MT I WHERE B.ITEM_ID = I.ITEM_ID AND B.BARCODE_NO = $barcode_no");
                // $rs = $query->result_array();
                // $item_id = $rs[0]['ITEM_ID'];
                // $lz_manifest_id = $rs[0]['LZ_MANIFEST_ID'];
                // $condition_id = $rs[0]['CONDITION_ID'];
                // $item_title = $rs[0]['ITEM_DESC'];

                  //echo $id;
                  // $query = $this->db->query("INSERT INTO lz_deletion_log VALUES($log_id $comma $barcode_no $comma $item_id $comma $lz_manifest_id $comma '$condition_id' $comma $deleted_by $comma $del_date $comma '$item_title' $comma '$remarks')");
                  
                  $unpost_barcode = "call Pro_Unpost_barcode($barcode_no, $deleted_by, '$remarks')";
                  $unpost_barcode = $this->db->query($unpost_barcode);
                  /*==================================
                  =            delete pic            =
                  ==================================*/
                  if($unpost_barcode){
                    $check_pic = $this->db->query("SELECT * FROM LZ_SPECIAL_LOTS L WHERE L.FOLDER_NAME = $barcode_no");
                    if($check_pic->num_rows() == 1){
                        $query = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 2");
                        $specific_qry = $query->result_array();
                        $master_path = $specific_qry[0]['MASTER_PATH']; 
                        $pic_dir = $master_path.$barcode_no;
                        $thumb_dir = $master_path.$barcode_no.'/thumb';
                        if (is_readable($pic_dir) && unlink($thumb_dir) && unlink($pic_dir)) {
                          null;
                        }

                    }else{
                      $check_pic = $this->db->query("SELECT FOLDER_NAME FROM LZ_DEKIT_US_DT WHERE FOLDER_NAME = $barcode_no");
                      if($check_pic->num_rows() == 1){
                        $query = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 2");
                        $specific_qry = $query->result_array();
                        $master_path = $specific_qry[0]['MASTER_PATH']; 
                        $pic_dir = $master_path.$barcode_no;
                        $thumb_dir = $master_path.$barcode_no.'/thumb';
                        if (is_readable($pic_dir) && unlink($thumb_dir) && unlink($pic_dir)) {
                          null;
                        }

                      }
                    }
                  }
                  
                  
                  /*=====  End of delete pic  ======*/

              }else{ //holded barcode if else
                  //echo "Item is holded. Please un-hold item first.";
                  return array('item_holded'=>$barcode_no);
              } 

            //}

                  
          }//foreach end
          if($unpost_barcode){
            //echo "Item Deletion process Succsessfully executed.";

            return "deleted";
          }
         
    }
    
  
    
}




 ?>