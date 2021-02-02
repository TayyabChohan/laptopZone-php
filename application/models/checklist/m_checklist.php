 <?php
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
 
class M_Checklist extends CI_Model {
  
 function add() {
  $checklist_name = $this->input->post('checklist_name');
  $checklist_name = trim(str_replace("  ", ' ', $checklist_name));
  $checklist_name = trim(str_replace("'", "''", $checklist_name));
  $checklist_att_1 = $this->input->post('checklist_att_1');
  $checklist_att_1 = trim(str_replace("  ", ' ', $checklist_att_1));
  $checklist_att_1 = trim(str_replace("'", "''", $checklist_att_1));
  $optradio_1 = $this->input->post('optradio_1');

    $query = $this->db->query("SELECT get_single_primary_key('LZ_TEST_CHECK_MT','LZ_TEST_MT_ID') LZ_TEST_MT_ID FROM DUAL");
    $rs = $query->result_array();
    $lz_test_mt_id = @$rs[0]['LZ_TEST_MT_ID'];

    $data = array(
      'LZ_TEST_MT_ID' =>$lz_test_mt_id,
      'CHECK_NAME' =>$checklist_att_1,
      'SELECTION_MODE' =>$optradio_1,
      'ATTRIBUTE_NAME' => $checklist_att_1
    );
     $this->db->insert('LZ_TEST_CHECK_MT', $data);
    // var_dump($query);exit;

    $optradio_1 = $this->input->post('optradio_1');

    $query = $this->db->query("SELECT get_single_primary_key('LZ_TEST_CHECK_DET','LZ_TEST_DET_ID') LZ_TEST_DET_ID FROM DUAL");
    $rs = $query->result_array();
    $lz_test_det_id = @$rs[0]['LZ_TEST_DET_ID'];

    $data = array(
      'LZ_TEST_DET_ID' =>$lz_test_det_id,
      'LZ_TEST_MT_ID' =>$lz_test_mt_id,    
      'CHECK_VALUE' =>$optradio_1
      
    );
     $this->db->insert('LZ_TEST_CHECK_DET', $data);

 } 
  function save_checklist() {
    if($this->input->post('submit_checklist')){
      
      if(!empty($this->input->post('check_list'))){
// var_dump('call');exit;
          $checklist_name = $this->input->post('checklist_name');
          $checklist_name = trim(str_replace("  ", ' ', $checklist_name));
          $checklist_name = trim(str_replace("'", "''", $checklist_name));
          $checklist_name = ucfirst($checklist_name);

      $query = $this->db->query("SELECT CHECKLIST_NAME FROM LZ_CHECKLIST_MT WHERE CHECKLIST_NAME = '$checklist_name'"); 
      if($query->num_rows() >0){
          return false;
      }else{

          $query = $this->db->query("SELECT get_single_primary_key('LZ_CHECKLIST_MT','CHECKLIST_MT_ID') CHECKLIST_MT_ID FROM DUAL");
          $rs = $query->result_array();
          $checklist_mt_id = @$rs[0]['CHECKLIST_MT_ID'];
          $data = array(
            'CHECKLIST_MT_ID' =>$checklist_mt_id,
            'CHECKLIST_NAME' =>$checklist_name
          );
           $this->db->insert('LZ_CHECKLIST_MT', $data);
          foreach($this->input->post('check_list') as $selected){
            if(!empty($selected)){
              $query = $this->db->query("SELECT get_single_primary_key('LZ_CHECKLIST_DET','CHECKLIST_DET_ID') CHECKLIST_DET_ID FROM DUAL");
              $rs = $query->result_array();
              $checklist_det_id = @$rs[0]['CHECKLIST_DET_ID'];
              $data = array(
                'CHECKLIST_DET_ID' =>$checklist_det_id,
                'CHECKLIST_MT_ID' =>$checklist_mt_id,
                'LZ_TEST_MT_ID' =>$selected
              );
               $this->db->insert('LZ_CHECKLIST_DET', $data);
            }
          }//end foreach
          return true;
        }//end if checklist name check  
      }//end checklist if

    }//else{echo "ELSE";}//end main if
 }
 function test_save() {
  $checklist_name = $this->input->post('checklist_name');
  $max_val = $this->input->post('max_val');
  $checklist_name = trim(str_replace("  ", ' ', $checklist_name));
  $checklist_name = trim(str_replace("'", "''", $checklist_name));
  $checklist_name = ucfirst($checklist_name);

  $query = $this->db->query("SELECT CHECK_NAME from LZ_TEST_CHECK_MT WHERE CHECK_NAME = '$checklist_name'");
    if($query->num_rows() >0){
        return false;
    }else{
          $optradio_1 = $this->input->post('optradio_1');
          $query = $this->db->query("SELECT LZ_TEST_MT_ID,SELECTION_MODE FROM LZ_TEST_CHECK_MT WHERE CHECK_NAME = '$checklist_name'");
          $rs = $query->result_array();
          //var_dump($rs);exit;
          if(!empty($rs)){
              $selection_mode = @$rs[0]['SELECTION_MODE'];
              $lz_test_mt_id = @$rs[0]['LZ_TEST_MT_ID'];
          }else{
             $selection_mode = '';
              $lz_test_mt_id = '';
          }
          if(!empty($selection_mode) && $selection_mode != $optradio_1){
            $data = array(
              
              'SELECTION_MODE' =>$optradio_1
            );
            $this->db->where('LZ_TEST_MT_ID', $lz_test_mt_id);
            $this->db->update('LZ_TEST_CHECK_MT', $data);

                if($optradio_1 == 'Logical'){
                  $query = $this->db->query("SELECT LZ_TEST_DET_ID FROM LZ_TEST_CHECK_DET WHERE LZ_TEST_MT_ID = $lz_test_mt_id");
                  $rs = $query->result_array();
                  
                  $i=0;

                    $check_value = ['Yes','No','N/A'];
                    foreach ($check_value as $val) {
                        $data = array('CHECK_VALUE' =>$val);
                        $this->db->where('LZ_TEST_DET_ID', $rs[$i]['LZ_TEST_DET_ID']);
                        $this->db->update('LZ_TEST_CHECK_DET', $data);
                        $i++;
                    }
                  }elseif($optradio_1 == 'FreeText'){
                    $value = '';
                    $data = array('CHECK_VALUE' =>$value);
                        $this->db->where('LZ_TEST_MT_ID', $lz_test_mt_id);
                        $this->db->update('LZ_TEST_CHECK_DET', $data);
                         return true;
                  }elseif($optradio_1 == 'List'){
                      $query = $this->db->query("SELECT LZ_TEST_DET_ID FROM LZ_TEST_CHECK_DET WHERE LZ_TEST_MT_ID = $lz_test_mt_id");
                      $rs = $query->result_array();
                      $i=0;
                      $default_val = $this->input->post('default_val');
                      $default_val = trim(str_replace("  ", ' ', $default_val));
                      $default_val = trim(str_replace("'", "''", $default_val));
                      $spec_name = $this->input->post('spec_name');
                    foreach ($spec_name as $val) {
                      if($default_val != $val){
                        $data = array('CHECK_VALUE' =>$val);
                        $this->db->where('LZ_TEST_DET_ID', $rs[$i]['LZ_TEST_DET_ID']);
                        $this->db->update('LZ_TEST_CHECK_DET', $data);
                        return true;

                      }else{
                        $data = array('CHECK_VALUE' =>$val,'DEFAULT_VALUE' =>1);
                        $this->db->where('LZ_TEST_DET_ID', $rs[$i]['LZ_TEST_DET_ID']);
                        $this->db->update('LZ_TEST_CHECK_DET', $data);
                        return true;
                      }
                        
                        $i++;
                    }

                  }
          

          }else{

                  $query = $this->db->query("SELECT get_single_primary_key('LZ_TEST_CHECK_MT','LZ_TEST_MT_ID') LZ_TEST_MT_ID FROM DUAL");
                  $rs = $query->result_array();
                  $lz_test_mt_id = @$rs[0]['LZ_TEST_MT_ID'];

                  $data = array(
                    'LZ_TEST_MT_ID' =>$lz_test_mt_id,
                    'CHECK_NAME' =>$checklist_name,
                    'SELECTION_MODE' =>$optradio_1,
                    'LIST_MAX_VALUE' =>$max_val
                    // 'ATTRIBUTE_NAME' => $checklist_att_1
                  );
                   $this->db->insert('LZ_TEST_CHECK_MT', $data);
                    //return true;
                  if($optradio_1 == 'Logical'){
                    $check_value = ['Yes','No'];
                    foreach ($check_value as $value) {
                        $query = $this->db->query("SELECT get_single_primary_key('LZ_TEST_CHECK_DET','LZ_TEST_DET_ID') LZ_TEST_DET_ID FROM DUAL");
                        $rs = $query->result_array();
                        $lz_test_det_id = @$rs[0]['LZ_TEST_DET_ID'];

                        $data = array(
                          'LZ_TEST_DET_ID' =>$lz_test_det_id,
                          'LZ_TEST_MT_ID' =>$lz_test_mt_id,    
                          'CHECK_VALUE' =>$value
                          
                        );
                         $this->db->insert('LZ_TEST_CHECK_DET', $data);
                          
                    }
                    return true;
                  }elseif($optradio_1 == 'FreeText'){
                    $value = '';
                    $query = $this->db->query("SELECT get_single_primary_key('LZ_TEST_CHECK_DET','LZ_TEST_DET_ID') LZ_TEST_DET_ID FROM DUAL");
                        $rs = $query->result_array();
                        $lz_test_det_id = @$rs[0]['LZ_TEST_DET_ID'];

                        $data = array(
                          'LZ_TEST_DET_ID' =>$lz_test_det_id,
                          'LZ_TEST_MT_ID' =>$lz_test_mt_id,    
                          'CHECK_VALUE' =>$value
                          
                        );
                         $this->db->insert('LZ_TEST_CHECK_DET', $data);
                          return true;
                  }elseif($optradio_1 == 'List'){
                    $spec_name = $this->input->post('spec_name');
                    $default_val = $this->input->post('default_val');
                    $default_val = trim(str_replace("  ", ' ', $default_val));
                    $default_val = trim(str_replace("'", "''", $default_val));
                    foreach ($spec_name as $val) {
                      if($default_val != $val){
                        $query = $this->db->query("SELECT get_single_primary_key('LZ_TEST_CHECK_DET','LZ_TEST_DET_ID') LZ_TEST_DET_ID FROM DUAL");
                        $rs = $query->result_array();
                        $lz_test_det_id = @$rs[0]['LZ_TEST_DET_ID'];

                        $data = array(
                          'LZ_TEST_DET_ID' =>$lz_test_det_id,
                          'LZ_TEST_MT_ID' =>$lz_test_mt_id,    
                          'CHECK_VALUE' =>$val
                          
                        );
                         $this->db->insert('LZ_TEST_CHECK_DET', $data);
                         

                      }else{
                        $query = $this->db->query("SELECT get_single_primary_key('LZ_TEST_CHECK_DET','LZ_TEST_DET_ID') LZ_TEST_DET_ID FROM DUAL");
                        $rs = $query->result_array();
                        $lz_test_det_id = @$rs[0]['LZ_TEST_DET_ID'];

                        $data = array(
                          'LZ_TEST_DET_ID' =>$lz_test_det_id,
                          'LZ_TEST_MT_ID' =>$lz_test_mt_id,    
                          'CHECK_VALUE' =>$val,
                          'DEFAULT_VALUE' =>1
                          
                        );
                         $this->db->insert('LZ_TEST_CHECK_DET', $data);
                        
                      }

                  }
                   return true;
                }
              }//else end
       
    }//main if else end

  

 }
 function checklist_view() {
  $query = $this->db->query("SELECT * FROM LZ_TEST_CHECK_MT ORDER BY LZ_TEST_MT_ID DESC");
  return $query->result_array();

 }
 function bind_view() {
  $cat_qry = $this->db->query("SELECT DISTINCT DT.E_BAY_CATA_ID_SEG6,DT.BRAND_SEG3 FROM LZ_MANIFEST_DET DT WHERE DT.E_BAY_CATA_ID_SEG6 IS NOT NULL AND DT.BRAND_SEG3 IS NOT NULL AND DT.E_BAY_CATA_ID_SEG6 <> 'N/A' ORDER BY DT.BRAND_SEG3"); 
  $cat_qry = $cat_qry->result_array();

  $checklist_qry = $this->db->query("SELECT * FROM LZ_CHECKLIST_MT ORDER BY CHECKLIST_NAME"); 
  $checklist_qry = $checklist_qry->result_array();
  return array('cat_qry'=>$cat_qry,'checklist_qry'=>$checklist_qry);
 }
 function cat_bind_save() {

  $category_id = $this->input->post('category_dd');
  //$checklist_id = $this->input->post('checklist_dd');
  foreach($this->input->post('check_list') as $selected){
    //$checklist_id = $selected;
    $query = $this->db->query("SELECT CATEGORY_ID FROM LZ_CATEGORY_CHECKLIST_BIND WHERE CATEGORY_ID = $category_id AND CHECKLIST_MT_ID = $selected");
    if($query->num_rows() >0){
        //echo "<script>alert('Category already binded.');window.location.href= '".base_url('checklist/c_checklist/screen3')."';</script>";
        // return true;
        //exit;
    }else{
          $get_pk = $this->db->query("SELECT get_single_primary_key('LZ_CATEGORY_CHECKLIST_BIND','CHECKLIST_BIND_ID') CHECKLIST_BIND_ID FROM DUAL");
          $get_pk = $get_pk->result_array();
          $checklist_bind_id = $get_pk[0]['CHECKLIST_BIND_ID'];
          $data = array(
                          'CHECKLIST_BIND_ID' => $checklist_bind_id,
                          'CATEGORY_ID' =>$category_id,
                          'CHECKLIST_MT_ID' =>$selected
                        ); 
          $flag = $this->db->insert('LZ_CATEGORY_CHECKLIST_BIND', $data);
          
    }
  }//end foreach
  if($flag){
    echo "<script>alert('Record added successfully.');</script>";
  }
  
  //return $query->result_array();
 }
function test_detail() {
  $test_id = $this->input->post('test_id');
  $query = $this->db->query("SELECT * FROM LZ_TEST_CHECK_MT MT,LZ_TEST_CHECK_DET DT WHERE MT.LZ_TEST_MT_ID = DT.LZ_TEST_MT_ID AND MT.LZ_TEST_MT_ID=$test_id"); 
  return $query->result_array();

 }
 function view_checklist(){
  $query = $this->db->query("SELECT * FROM LZ_CHECKLIST_MT ORDER BY CHECKLIST_MT_ID"); 
  return $query->result_array();
 }
 function edit_checklist(){
  $checklist_mt_id = $this->uri->segment(4);
  $selected_data = $this->db->query("SELECT D.LZ_TEST_MT_ID, M.CHECKLIST_NAME,M.CHECKLIST_MT_ID FROM LZ_CHECKLIST_MT M,LZ_CHECKLIST_DET D WHERE M.CHECKLIST_MT_ID = D.CHECKLIST_MT_ID AND D.CHECKLIST_MT_ID = $checklist_mt_id ORDER BY D.LZ_TEST_MT_ID DESC"); 
  $selected_data = $selected_data->result_array();
  //var_dump($selected_data);exit;
  $all_data = $this->db->query("SELECT * FROM LZ_TEST_CHECK_MT ORDER BY LZ_TEST_MT_ID DESC");
  $all_data = $all_data->result_array();
  return array('selected_data'=> $selected_data, 'all_data'=>$all_data);
 }
 function update_checklist(){
  
  if($this->input->post('update_checklist')){
    if(!empty($this->input->post('check_list'))){
        $mt_id = $this->input->post('checklist_mt_id');
        $this->db->query("DELETE FROM LZ_CHECKLIST_DET WHERE CHECKLIST_MT_ID = $mt_id");
        $this->db->query("DELETE FROM LZ_CHECKLIST_MT WHERE CHECKLIST_MT_ID = $mt_id");

        $checklist_name = $this->input->post('checklist_name');
        $checklist_name = trim(str_replace("  ", ' ', $checklist_name));
        $checklist_name = trim(str_replace("'", "''", $checklist_name));
        $checklist_name = ucfirst($checklist_name);

    $query = $this->db->query("SELECT CHECKLIST_NAME FROM LZ_CHECKLIST_MT WHERE CHECKLIST_NAME = '$checklist_name'"); 
    if($query->num_rows() >0){
        return false;
    }else{

        $query = $this->db->query("SELECT get_single_primary_key('LZ_CHECKLIST_MT','CHECKLIST_MT_ID') CHECKLIST_MT_ID FROM DUAL");
        $rs = $query->result_array();
        $checklist_mt_id = @$rs[0]['CHECKLIST_MT_ID'];
        $data = array(
          'CHECKLIST_MT_ID' =>$checklist_mt_id,
          'CHECKLIST_NAME' =>$checklist_name
        );
         $this->db->insert('LZ_CHECKLIST_MT', $data);
        foreach($this->input->post('check_list') as $selected){
          if(!empty($selected)){
            $query = $this->db->query("SELECT get_single_primary_key('LZ_CHECKLIST_DET','CHECKLIST_DET_ID') CHECKLIST_DET_ID FROM DUAL");
            $rs = $query->result_array();
            $checklist_det_id = @$rs[0]['CHECKLIST_DET_ID'];
            $data = array(
              'CHECKLIST_DET_ID' =>$checklist_det_id,
              'CHECKLIST_MT_ID' =>$checklist_mt_id,
              'LZ_TEST_MT_ID' =>$selected
            );
             $this->db->insert('LZ_CHECKLIST_DET', $data);
          }
        }//end foreach
        $this->db->query("UPDATE LZ_CATEGORY_CHECKLIST_BIND SET CHECKLIST_MT_ID = $checklist_mt_id WHERE CHECKLIST_MT_ID = $mt_id");
        return true;
      }//end if checklist name check  
    }//end checklist if

  }//else{echo "ELSE";}//end main if
 }
 function testing_check_screen(){
  $query = $this->db->query("SELECT * FROM LZ_TEST_CHECK_MT ORDER BY LZ_TEST_MT_ID DESC"); 
  return $query->result_array();  
 }
 function testing_check_delete(){
  $url_id = $this->uri->segment(4);
  if(!empty($url_id)){
    $query_det = $this->db->delete('LZ_TEST_CHECK_DET', array('LZ_TEST_MT_ID' => $url_id));
  //$query_det = $this->db->query("DELETE FROM LZ_TEST_CHECK_DET WHERE LZ_TEST_MT_ID = $url_id");
  // var_dump($query_det);exit;
//   $this->db->where('LZ_TEST_MT_ID', $url_id);
// $query_det = $this->db->delete('LZ_TEST_CHECK_DET');
//  }
  //if($query_det){ 
    $query_det = $this->db->delete('LZ_TEST_CHECK_MT', array('LZ_TEST_MT_ID' => $url_id));
    // $query_mt = $this->db->query("DELETE FROM LZ_TEST_CHECK_MT WHERE LZ_TEST_MT_ID = $url_id"); 
//   $this->db->where('LZ_TEST_MT_ID', $url_id);
// $query_mt = $this->db->delete('LZ_TEST_CHECK_MT');    
  }

 }
 function search_item_barcode($search_barcode){

    //$var = "select m.item_id,m.lz_manifest_id from lz_barcode_mt m where m.barcode_no=$search_barcode";
    $item_qry = $this->db->query("select m.barcode_no, m.item_id,m.lz_manifest_id from lz_barcode_mt m where m.barcode_no=$search_barcode");
    //var_dump($var);exit; 
    $item_data = $item_qry->result_array();

    if($item_qry->num_rows() > 0){
      $item_det = $this->db->query("SELECT B.UNIT_NO,B.BARCODE_NO IT_BARCODE,V.ITEM_CONDITION,V.ITEM_MT_DESC,V.MANUFACTURER,V.MFG_PART_NO,V.UPC,V.AVAIL_QTY,V.ITEM_ID,V.LZ_MANIFEST_ID,V.PURCH_REF_NO FROM LZ_BARCODE_MT B, VIEW_LZ_LISTING_REVISED V WHERE B.ITEM_ID = V.ITEM_ID AND B.LZ_MANIFEST_ID = V.LZ_MANIFEST_ID AND B.LZ_MANIFEST_ID=".$item_data[0]['LZ_MANIFEST_ID']." AND B.ITEM_ID = ".$item_data[0]['ITEM_ID']." ORDER BY B.UNIT_NO"); 
      $item_det = $item_det->result_array();
    }    

   // $var = "select distinct dt.e_bay_cata_id_seg6 from lz_manifest_det dt where dt.laptop_item_code = (select v.laptop_item_code from view_lz_listing_revised v where v.lz_manifest_id = ".$item_det[0]['LZ_MANIFEST_ID']." AND v.item_id = ".$item_det[0]['ITEM_ID'].") and dt.e_bay_cata_id_seg6 not in ('N/A', 'Other', 'OTHER', 'other')";
   // var_dump($var);exit;
    $cat_id = $this->db->query("select distinct dt.e_bay_cata_id_seg6,dt.brand_seg3 from lz_manifest_det dt where dt.laptop_item_code = (select v.laptop_item_code from view_lz_listing_revised v where v.lz_manifest_id = ".$item_det[0]['LZ_MANIFEST_ID']." AND v.item_id = ".$item_det[0]['ITEM_ID']."  AND ROWNUM=1) and dt.e_bay_cata_id_seg6 not in ('N/A', 'Other', 'OTHER', 'other')");

     $cat_id = $cat_id->result_array();

    return array('item_det'=> $item_det, 'cat_id'=>$cat_id, 'item_data'=>$item_data); 
 }
  function category_binding_results(){
    $test_manifest_id = $this->input->post('test_manifest_id');
        //======================== Un-binded Data tab Start =============================//

        $un_binded_qry = "SELECT distinct DT.E_BAY_CATA_ID_SEG6,dt.brand_seg3 FROM LZ_MANIFEST_DET DT,lz_category_checklist_bind cb WHERE   DT.E_BAY_CATA_ID_SEG6 IS NOT NULL AND DT.BRAND_SEG3 IS NOT NULL AND DT.E_BAY_CATA_ID_SEG6 <> 'N/A'and dt.lz_manifest_id = $test_manifest_id and dt.e_bay_cata_id_seg6 not in (SELECT distinct DT.E_BAY_CATA_ID_SEG6 FROM LZ_MANIFEST_DET DT,lz_category_checklist_bind cb WHERE   DT.E_BAY_CATA_ID_SEG6 IS NOT NULL AND DT.BRAND_SEG3 IS NOT NULL AND DT.E_BAY_CATA_ID_SEG6 <> 'N/A'and dt.lz_manifest_id = $test_manifest_id and cb.category_id = dt.e_bay_cata_id_seg6 )"; 
        $un_binded_qry =$this->db->query($un_binded_qry);
        $un_binded_qry = $un_binded_qry->result_array();
         
        //======================== Un-Tested Data tab End =============================//

        //======================== binded Data tab Start =============================//

        $binded_qry = "SELECT distinct DT.E_BAY_CATA_ID_SEG6,dt.brand_seg3,cm.checklist_name FROM LZ_MANIFEST_DET DT,lz_category_checklist_bind cb,lz_checklist_mt cm WHERE   DT.E_BAY_CATA_ID_SEG6 IS NOT NULL AND DT.BRAND_SEG3 IS NOT NULL AND DT.E_BAY_CATA_ID_SEG6 <> 'N/A'and dt.lz_manifest_id = $test_manifest_id and cb.category_id = dt.e_bay_cata_id_seg6 and cb.checklist_mt_id = cm.checklist_mt_id"; 
        $binded_qry =$this->db->query($binded_qry);
        $binded_qry = $binded_qry->result_array();
         
        //================ Tested Data tab End =======================//                    

        return array('un_binded_qry' => $un_binded_qry, 'binded_qry'=>$binded_qry); 

  }

}
