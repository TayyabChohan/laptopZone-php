<?php 

  class M_autoCatalog extends CI_Model{

    public function __construct(){
    parent::__construct();
    $this->load->database();
  }
  public function checkExp(){
    $bd_category = $this->input->post('bd_category');
    $kit_mpn = $this->input->post('kit_mpn');
    $kit_exp = $this->input->post('kit_exp');
       //$this->session->set_userdata('bd_category', $bd_category);
       //    select *
       //  from $table_name c
       // where c.category_id = 111422
       //   and c.title like '%MD101LL/A%'
       //   and c.title like '%2012%'
       //   and c.title like '%13.3"%'
       //$exp_query = $this->db2->simple_query("SELECT * FROM $table_name WHERE CATEGORY_ID = $bd_category ".$kit_exp);
       //echo $this->db2->last_query();exit;
       // var_dump($exp_query->num_rows());exit;
       //$this->db->db_debug = FALSE;
       //if($exp_query->num_rows() > 0){
    $table_name='LZ_BD_CATAG_DATA_'.$bd_category;
      if($this->db2->query("SELECT * FROM $table_name WHERE CATEGORY_ID = $bd_category ".$kit_exp)){
      //echo "<script>alert('Error');</script>";
      return true;
    }else{
      return false;
    }
  }
  public function getCategories(){
    $sql = "SELECT DISTINCT D.CATEGORY_ID, BD.CATEGORY_NAME, GET_ACTIVE_COUNT(D.CATEGORY_ID) CAT_COUNT FROM LZ_BD_CAT_GROUP_DET D, LZ_BD_CATEGORY BD WHERE  D.CATEGORY_ID = BD.CATEGORY_ID" ;
    $query = $this->db2->query($sql);
    $query = $query->result_array();
    return $query;
  }
  public function getObjects(){
    $sql = "SELECT DISTINCT O.OBJECT_ID, O.OBJECT_NAME FROM LZ_BD_OBJECTS_MT O, LZ_CATALOGUE_MT M WHERE O.OBJECT_ID=M.OBJECT_ID";
    $query = $this->db->query($sql);
    $query = $query->result_array();
    return $query;
  }

  public function getAllObjects(){
     $sql = "SELECT DISTINCT O.OBJECT_ID, O.OBJECT_NAME FROM LZ_BD_OBJECTS_MT O";
     $query = $this->db->query($sql);
     $query = $query->result_array();
     return $query;
  }
  public function getMpns(){
    $sql = "SELECT M.CATALOGUE_MT_ID, M.MPN FROM LZ_BD_OBJECTS_MT O, LZ_CATALOGUE_MT M WHERE O.OBJECT_ID=M.OBJECT_ID AND M.CATEGORY_ID IN ('31569', '175676', '168061', '1244', '16145', '31519', '175669', '31510', '31568', '14295', '20318', '131486', '175668', '56083', '51064', '131511', '171814', '162', '175745', '176982', '33963', '175677', '20357', '180235', '3709', '176973', '168068', '182097')";
    // $sql = "SELECT M.CATALOGUE_MT_ID, M.MPN FROM LZ_BD_OBJECTS_MT O, LZ_CATALOGUE_MT M WHERE O.OBJECT_ID=M.OBJECT_ID AND M.CATEGORY_ID = 111422";
    $query = $this->db->query($sql);
    $query = $query->result_array();
    return $query;
  }
  public function getAltMpns(){
    $sql = "SELECT K.MPN_KIT_MT_ID,M.MPN FROM LZ_BD_MPN_KIT_MT K,LZ_CATALOGUE_MT M
WHERE M.CATALOGUE_MT_ID=K.CATALOGUE_MT_ID";
    $query = $this->db->query($sql);
    $query = $query->result_array();
    return $query;
  }
  public function saveMpn(){
    $bd_recog_category = $this->input->post('bd_category');
    $bd_kit_mpn = $this->input->post('bd_kit_mpn');

    $bd_kit_object = $this->input->post('bd_kit_object');
    $bd_kit_object = trim(str_replace("  ", ' ', $bd_kit_object));
    $bd_kit_object = trim(str_replace(array("'"), "''", $bd_kit_object));
    $bd_kit_object = strtoupper($bd_kit_object);


    $kit_exp = $this->input->post('kit_exp');
    $kit_exp = trim(str_replace("  ", ' ', $kit_exp));
    $kit_exp = strtoupper($kit_exp);
    $main_exp_text = $kit_exp;
    $kit_exp = trim(str_replace(array("'"), "''", $kit_exp));
    
    $mpn_text = $this->input->post('mpn_text');
    $mpn_text = trim(str_replace("  ", ' ', $mpn_text));
    $mpn_text = trim(str_replace(array("'"), "''", $mpn_text));
    $mpn_text = strtoupper($mpn_text);
    $mpn_exp = "AND TITLE LIKE ''%".$mpn_text."%''";
    //var_dump($main_exp_text); exit;
    date_default_timezone_set("America/Chicago");
    $current_date = date("Y-m-d H:i:s");
    $current_date = "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";

    $insert_by = $this->session->userdata('user_id');
   

       $checkExp = $this->db2->query("SELECT MPN_RECOG_MT_ID FROM LZ_BD_MPN_RECOG_MT WHERE UPPER(EXPR_TEXT)='$kit_exp'");
       if ($checkExp->num_rows()==0) {

          $mpnExp = $this->db2->query("SELECT MPN_RECOG_MT_ID FROM LZ_BD_MPN_RECOG_MT WHERE UPPER(TRIM(EXPR_TEXT))='$mpn_exp'");
            if($mpnExp->num_rows()==0){
              $query = $this->db2->query("SELECT laptop_zone.get_single_primary_key('LZ_BD_MPN_RECOG_MT','MPN_RECOG_MT_ID') ID FROM DUAL");
              $rs = $query->result_array();
              $MPN_RECOG_MT_ID = $rs[0]['ID'];
            //var_dump($MPN_RECOG_MT_ID, $bd_kit_mpn, $kit_exp); exit;
              $det_query = $this->db2->query("INSERT INTO LZ_BD_MPN_RECOG_MT(MPN_RECOG_MT_ID, CATALOGUE_MT_ID, EXPR_TEXT,INSERTED_DATE,INSERTED_BY) VALUES($MPN_RECOG_MT_ID, $bd_kit_mpn, '$mpn_exp',$current_date,$insert_by)");
            }
            $query = $this->db2->query("SELECT laptop_zone.get_single_primary_key('LZ_BD_MPN_RECOG_MT','MPN_RECOG_MT_ID') ID FROM DUAL");
            $rs = $query->result_array();
            $MPN_RECOG_MT_ID = $rs[0]['ID'];
            //var_dump($MPN_RECOG_MT_ID, $bd_kit_mpn, $kit_exp); exit;
                $det_query = $this->db2->query("INSERT INTO LZ_BD_MPN_RECOG_MT(MPN_RECOG_MT_ID, CATALOGUE_MT_ID, EXPR_TEXT,INSERTED_DATE,INSERTED_BY) VALUES($MPN_RECOG_MT_ID, $bd_kit_mpn, '$kit_exp',$current_date,$insert_by)");
                  if ($det_query){
                    $arrayData=[
                        'bd_recog_category'=> $bd_recog_category,
                        'bd_kit_mpn'=> $bd_kit_mpn,
                        'bd_kit_object'=> $bd_kit_object,
                        'kit_exp'=> $main_exp_text
                    ];
                    $this->session->set_userdata($arrayData);
                    return 1;
                      }else {
                    return 0;
                    }
       }
 }

   public function saveAlternateMpn(){
    $cat_mt_id = $this->input->post('bd_alt_mpn');
    $mpn_kit_mt_id = $this->input->post('mpn_kit_mt_id');
    $query = $this->db2->query("SELECT laptop_zone.get_single_primary_key('LZ_BD_MPN_KIT_ALT_MPN','MPN_KIT_ALT_MPN') ID FROM DUAL");
      $rs = $query->result_array();
      $MPN_KIT_ALT_MPN = $rs[0]['ID'];


    //var_dump($bd_alt_main_mpn, $bd_alt_mpn); exit;
    $det_query = $this->db2->query("INSERT INTO LZ_BD_MPN_KIT_ALT_MPN(MPN_KIT_ALT_MPN, MPN_KIT_MT_ID, CATALOGUE_MT_ID) VALUES($MPN_KIT_ALT_MPN, $mpn_kit_mt_id,$cat_mt_id )");

    if ($det_query){
      return 1;
    }else {
      return 0;
    }
  }
  public function showCurExpDetail(){
    $bd_category = $this->input->post('bd_category');
    //$kit_mpn = $this->input->post('kit_mpn');
    $kit_exp = $this->input->post('kit_exp');
    $table_name='LZ_BD_CATAG_DATA_'.$bd_category;
    $query = $this->db2->query("SELECT * FROM $table_name WHERE CATEGORY_ID = $bd_category AND VERIFIED = 0 AND IS_DELETED = 0 ". $kit_exp);
    $exp_result= $query->result_array();

    $total_record = $this->db2->query("SELECT COUNT(1) TOTAL_RECORD FROM $table_name WHERE CATEGORY_ID = $bd_category AND IS_DELETED = 0");
    $total_record = $total_record->result_array();
    $total_verified = $this->db2->query("SELECT COUNT(1) TOTAL_VERIFIED FROM $table_name WHERE VERIFIED = 1 AND CATEGORY_ID = $bd_category AND IS_DELETED = 0");
    $total_verified = $total_verified->result_array();
    $total_unverified = $this->db2->query("SELECT COUNT(1) TOTAL_UNVERIFIED FROM $table_name WHERE VERIFIED<>1 AND CATEGORY_ID = $bd_category AND IS_DELETED = 0");
    $total_unverified = $total_unverified->result_array();

    return array('exp_result'=>$exp_result,'total_record'=>$total_record,'total_verified'=>$total_verified,'total_unverified'=>$total_unverified);
     
    }
 public function showExpDetail(){
    $kit_exp_id = $this->input->post('kit_exp_id');
    //var_dump($kit_exp_id); exit;
    $exps = $this->db2->query("SELECT DISTINCT M.EXPR_TEXT FROM LZ_BD_MPN_RECOG_MT M WHERE M.MPN_RECOG_MT_ID = $kit_exp_id")->result_array(); 

    $kit_exp=$exps[0]['EXPR_TEXT']; 
    $kit_exp_main= str_replace("'", "''", $kit_exp);
    //var_dump($kit_exp_main); exit; 
 $bd_category = $this->session->userdata('bd_recog_category');
 //var_dump($bd_category); exit;
  $table_name='LZ_BD_CATAG_DATA_'.$bd_category;
 if (!empty($bd_category)) {
    $exp_result = $this->db2->query("SELECT * FROM $table_name WHERE VERIFIED = 0  AND IS_DELETED = 0 AND CATEGORY_ID = $bd_category ".$kit_exp)->result_array();
    //var_dump($exp_result); exit;
    $total_record = $this->db2->query("SELECT COUNT(1) TOTAL_RECORD FROM $table_name WHERE CATEGORY_ID = $bd_category AND IS_DELETED = 0");
    $total_record = $total_record->result_array();
    $total_verified = $this->db2->query("SELECT COUNT(1) TOTAL_VERIFIED FROM $table_name WHERE VERIFIED=1 AND CATEGORY_ID = $bd_category AND IS_DELETED = 0");
    $total_verified = $total_verified->result_array();
    $total_unverified = $this->db2->query("SELECT COUNT(1) TOTAL_UNVERIFIED FROM $table_name WHERE VERIFIED <> 1 AND CATEGORY_ID = $bd_category AND IS_DELETED = 0");
    $total_unverified = $total_unverified->result_array();
    return array(
                  'exp_result'=>$exp_result,
                  'total_record'=>$total_record,
                  'total_verified'=>$total_verified,
                  'total_unverified'=>$total_unverified
                   );
     //var_dump($ddd); exit;
  } 
}
    public function getSpecificExprs(){
      $fltr_bd_category = $this->input->post('fltr_bd_category');
      $sesion_arr=["bd_recog_category"=>$fltr_bd_category];
      $this->session->set_userdata($sesion_arr);

      $query = $this->db->query("SELECT M.EXPR_NAME, M.CAT_EXP_ID FROM LZ_BD_CAT_EXP_MT M WHERE CATEGORY_ID =$fltr_bd_category");
      return $query->result_array();
     
    }
    public function getExprName(){
      $fltr_bd_category = $this->input->post('fltr_bd_category');
      $bd_expr_id = $this->input->post('bd_expr_id');
      $query = $this->db->query("SELECT M.EXPR_NAME  FROM LZ_BD_CAT_EXP_MT M WHERE M.CATEGORY_ID =$fltr_bd_category AND M.CAT_EXP_ID = $bd_expr_id");
      return $query->result_array();
     
    }
     public function displayRelatedExps(){
      $fltr_bd_category = $this->input->post('fltr_bd_category');
      $bd_title_expr_id = $this->input->post('bd_title_expr');
      //var_dump($bd_kit_mpn_id); exit;

       $collection = $this->db->query("SELECT D.CAT_EXP_ID, M.CATEGORY_ID, M.EXPR_NAME, D.EXP_TEXT FROM LZ_BD_CAT_EXP_MT M, LZ_BD_CAT_EXP_DET D WHERE M.CAT_EXP_ID = D.CAT_EXP_ID AND M.CATEGORY_ID = $fltr_bd_category AND M.CAT_EXP_ID = $bd_title_expr_id")->result_array(); 
        $expr = $this->db->query("SELECT M.EXPR_NAME  FROM LZ_BD_CAT_EXP_MT M WHERE M.CATEGORY_ID =$fltr_bd_category AND M.CAT_EXP_ID = $bd_title_expr")->result_array();
        return array("collection"=>$collection, "expr"=>$expr);


    } 
    public function getSpecificObject(){
      $bd_kit_mpn_id = $this->input->post('bd_kit_mpn_id');

      $objects = $this->db->query("SELECT DISTINCT M.OBJECT_ID, O.OBJECT_NAME FROM LZ_CATALOGUE_MT M, LZ_BD_OBJECTS_MT O WHERE M.OBJECT_ID=O.OBJECT_ID AND M.catalogue_mt_id = $bd_kit_mpn_id")->result_array();
      $bd_recog_category= $this->session->userdata("bd_recog_category");
      //var_dump($bd_recog_category); exit;
      $kit_object=$objects[0]['OBJECT_NAME'];
      $arrayData=[
                        'bd_recog_category'=> $bd_recog_category,
                        'bd_kit_mpn'=> $bd_kit_mpn_id,
                        'bd_kit_object'=> $kit_object
                    ];
                    $this->session->set_userdata($arrayData);
                    //var_dump($this->session->userdata("recog_mpn", "bd_recog_category")); exit;
                    return $objects;
     
    }
    public function verifyExpData($exp_id){
      $cat_id = $this->db2->query("SELECT DISTINCT C.CATEGORY_ID FROM LZ_BD_MPN_RECOG_MT R,LZ_CATALOGUE_MT C WHERE C.CATALOGUE_MT_ID=R.CATALOGUE_MT_ID AND R.MPN_RECOG_MT_ID = $exp_id")->result_array(); 
      $bd_category = $cat_id[0]['CATEGORY_ID'];

      $verifyData = "CALL PRO_RECOGNIZE_TITLE_FOR_EXP($bd_category,$exp_id)";
      $verifyData = $this->db2->query($verifyData);
      if($verifyData){
        $this->session->set_flashdata('success', 'Record Verified Successfully.');
        return 1;
      }else{
        $this->session->set_flashdata('error', 'Error! Record Not Verified.');
        return 0;
      }
      
     
    }
   public function getMpnObjects(){
    $bd_mpn = $this->input->post('bd_mpn');

    $query = $this->db2->query("SELECT DISTINCT M.OBJECT_ID, O.OBJECT_NAME FROM LZ_CATALOGUE_MT M, LZ_BD_OBJECTS_MT O WHERE M.OBJECT_ID = O.OBJECT_ID AND M.CATALOGUE_MT_ID = $bd_mpn");
    return $query->result_array();
     
  }
  public function getMpnObjectsResult(){
    // $bd_category = $this->input->post('bd_category');

    $bd_kit_mpn = $this->session->userdata('bd_kit_mpn');
    // $bd_kit_mpn = (int)$bd_kit_mpn;
    // var_dump($bd_kit_mpn);exit;
    if($bd_kit_mpn != ''){
      $query = $this->db2->query("SELECT O.OBJECT_NAME, C.MPN, M.QTY, M.MPN_KIT_MT_ID,M.PART_CATLG_MT_ID  FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE M.PART_CATLG_MT_ID = C.CATALOGUE_MT_ID AND C.OBJECT_ID = O.OBJECT_ID AND  M.CATALOGUE_MT_ID = $bd_kit_mpn  ");
      return $query->result_array();
    }
  
     
  }

  public function getAlternateMpn(){
    $bd_category = $this->input->post('bd_category');
    $alternated_mpn  = $this->input->post('alternated_mpn');
    $query = $this->db2->query("SELECT M.CATALOGUE_MT_ID, M.MPN FROM LZ_CATALOGUE_MT M WHERE M.CATEGORY_ID = $bd_category  AND M.CATALOGUE_MT_ID <> $alternated_mpn "); 
    return $query->result_array();
  }
  public function getExpById($expId){
    $query = $this->db2->query("SELECT * FROM LZ_BD_MPN_RECOG_MT M WHERE M.MPN_RECOG_MT_ID = $expId"); 
    // echo "<pre>";
    // print_r($collection->result_array());
    // exit;
    return $query->result_array();
  }
  public function deleteBdExpresion($expId){
    $query = $this->db2->query("DELETE FROM  LZ_BD_MPN_RECOG_MT M WHERE M.MPN_RECOG_MT_ID = $expId"); 
    if($query){
      return 1;
    }else{
      return 0;
    }
    // echo "<pre>";
    // print_r($collection->result_array());
    // exit;
    return $query->result_array();
  }
  public function bdUpdateExpresion(){
    $exp_id = $this->input->post('exp_id');
    $kit_exp = $this->input->post('kit_exp');
    $kit_exp = trim(str_replace("  ", ' ', $kit_exp));
    $kit_exp = trim(str_replace(array("'"), "''", $kit_exp));
    $kit_exp = strtoupper($kit_exp);
    //var_dump($exp_id, $kit_exp); exit;
    $query = $this->db2->query("UPDATE LZ_BD_MPN_RECOG_MT M SET M.EXPR_TEXT = '$kit_exp' WHERE M.MPN_RECOG_MT_ID = $exp_id"); 
    // echo "<pre>";
    // print_r($collection->result_array());
    // exit;
    if($query){
      return 1;
    }else{
      return 0;
    }
    
  }

  public function deleteMpnObjectResults(){
    $mpn_kit_mt_id = $this->input->post('mpn_kit_id');
    $query = $this->db2->query("DELETE FROM LZ_BD_MPN_KIT_ALT_MPN WHERE MPN_KIT_MT_ID = $mpn_kit_mt_id "); 
    $del_qry = $this->db2->query("DELETE FROM LZ_BD_MPN_KIT_MT WHERE MPN_KIT_MT_ID = $mpn_kit_mt_id ");

    if($del_qry){
      return 1;
    }else{
      return 0;
    }

  }

  public function saveMpnKit(){
    // print_r($this->session->userdata); exit;
    $catalogue_mt_id = $this->session->userdata('bd_kit_mpn');
    $part_cata_id = $this->input->post('bd_mpn');
    $kit_qty = $this->input->post('kit_qty');
    $query = $this->db2->query("SELECT laptop_zone.get_single_primary_key('LZ_BD_MPN_KIT_MT','MPN_KIT_MT_ID') ID FROM DUAL");
      $rs = $query->result_array();
      $MPN_KIT_MPN = $rs[0]['ID'];
    //var_dump($bd_alt_main_mpn, $bd_alt_mpn); exit;
    $det_query = $this->db2->query("INSERT INTO LZ_BD_MPN_KIT_MT(MPN_KIT_MT_ID, CATALOGUE_MT_ID,QTY,PART_CATLG_MT_ID) VALUES($MPN_KIT_MPN, $catalogue_mt_id,$kit_qty,$part_cata_id )");

    if ($det_query){
      return 1;
    }else {
      return 0;
    }
  }
  public function addKitComponent(){
    // print_r($this->session->userdata); exit;
    $catalogue_mt_id = $this->input->post('catalogue_mpn_id');
    $part_cata_id = $this->input->post('bd_mpn');
    $kit_qty = $this->input->post('kit_qty');
    $query = $this->db2->query("SELECT laptop_zone.get_single_primary_key('LZ_BD_MPN_KIT_MT','MPN_KIT_MT_ID') ID FROM DUAL");
      $rs = $query->result_array();
      $MPN_KIT_MPN = $rs[0]['ID'];
    //var_dump($bd_alt_main_mpn, $bd_alt_mpn); exit;
    $det_query = $this->db2->query("INSERT INTO LZ_BD_MPN_KIT_MT(MPN_KIT_MT_ID, CATALOGUE_MT_ID,QTY,PART_CATLG_MT_ID) VALUES($MPN_KIT_MPN, $catalogue_mt_id,$kit_qty,$part_cata_id )");

    if ($det_query){
      return 1;
    }else {
      return 0;
    }
  }
  public function deleteResultRow($id){
    $bd_category = $this->input->post('bd_category');
    $table_name = 'LZ_BD_CATAG_DATA_'.$bd_category;
    //var_dump($id, $bd_category, $table_name); exit; 
    $query = $this->db2->query("UPDATE $table_name SET IS_DELETED = 1 WHERE LZ_BD_CATA_ID = $id ");
    if ($query){
      return true;
    }else {
      return false;
    }    
  }
  public function get_alt_mpn(){
    // $bd_kit_mpn= $this->session->userdata('bd_kit_mpn');
    // var_dump($bd_kit_mpn);
    // exit;
    
    $sql = "SELECT  KIT.MPN_KIT_ALT_MPN AS MPN_KIT_ALT_MPN, KIT_ALT.MPN AS PARENT_MPN, CAT.MPN AS CHILD_MPN FROM LZ_BD_MPN_KIT_ALT_MPN KIT,LZ_CATALOGUE_MT CAT , ( SELECT K.MPN_KIT_MT_ID AS ID,K.CATALOGUE_MT_ID AS C_ID,C.MPN FROM LZ_BIGDATA.LZ_BD_MPN_KIT_MT K,LZ_CATALOGUE_MT C WHERE K.CATALOGUE_MT_ID=C.CATALOGUE_MT_ID )KIT_ALT WHERE KIT.CATALOGUE_MT_ID=CAT.CATALOGUE_MT_ID AND KIT.MPN_KIT_MT_ID=KIT_ALT.ID(+) ";
     $query = $this->db->query($sql);
    $query = $query->result_array();
    return $query;
  }
   public function del_alt_mpn(){
    $MPN_KIT_ALT_MPN=$this->uri->segment(4);
    // var_dump($MPN_KIT_ALT_MPN);
    // exit;
    $sql = $this->db->query("DELETE  FROM LZ_BD_MPN_KIT_ALT_MPN WHERE MPN_KIT_ALT_MPN=$MPN_KIT_ALT_MPN");
        
  }

  public function updateMPN(){
    
    $catalogue_id = $this->session->userdata('bd_kit_mpn');
    $mpn_kit_id = $this->input->post('mpn_kit_id');
    $update_qty = $this->input->post('mpn_qty');
    $part_cata_id =  $this->input->post('part_cata_id');
    $qry = $this->db->query("UPDATE lz_bd_mpn_kit_mt SET CATALOGUE_MT_ID = $catalogue_id, QTY =$update_qty,PART_CATLG_MT_ID =$part_cata_id WHERE MPN_KIT_MT_ID =  $mpn_kit_id");
    if($qry){
      return 1;
    }else{
      return 0;
    }
  }

  public function unVerifiedLoadData($cat_id){
    $requestData= $_REQUEST;
    //$cat_id = $this->session->userdata('bd_recog_category');
    // $category = (int)$category;
     //var_dump($cat_id);exit;
    $columns = array( 
    // datatable column index  => database column name
      
      0 =>'EBAY_ID',
      1 =>'TITLE',
      2 =>'CONDITION_NAME',
      3 =>'SELLER_ID',
      4 =>'LISTING_TYPE',
      5 =>'SALE_PRICE',
      6 =>'START_TIME',
      7 =>'SALE_TIME',
      8 =>'FEEDBACK_SCORE'
    );
    //$table_name='LZ_BD_CATAG_DATA_'.$cat_id;
    $sql = "SELECT LZ_BD_CATA_ID,EBAY_ID,TITLE,CONDITION_NAME,SELLER_ID,LISTING_TYPE,SALE_PRICE,START_TIME,SALE_TIME,FEEDBACK_SCORE FROM LZ_BD_CATAG_DATA_$cat_id  WHERE CATEGORY_ID = $cat_id AND VERIFIED = 0 AND IS_DELETED = 0";

    if( !empty($requestData['search']['value']) ) {   
    // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" AND ( EBAY_ID LIKE '%".$requestData['search']['value']."%' )";
          // $sql.=" OR TITLE LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR SALE_PRICE LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR START_TIME LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR SALE_TIME LIKE '%".$requestData['search']['value']."%' )";
          $sql.=" OR FEEDBACK_SCORE LIKE '%".$requestData['search']['value']."%' ";
      }else{
        if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" AND ( EBAY_ID LIKE '%".$requestData['search']['value']."%' )";
          // $sql.=" OR TITLE LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR SALE_PRICE LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR START_TIME LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR SALE_TIME LIKE '%".$requestData['search']['value']."%' )";
          $sql.=" OR FEEDBACK_SCORE LIKE '%".$requestData['search']['value']."%' ";
          
        }
      }

    $query = $this->db2->query($sql);
    $totalData = $query->num_rows();
    $totalFiltered = $totalData;

    $sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
    //$sql="SELECT * FROM ($sql) WHERE ROWNUM <= 100"; 
    $sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($sql) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'] ;


    $query = $this->db2->query($sql);

    $query = $query->result_array();
    $data = array();

    foreach($query as $row ){ 
      $nestedData=array();

      $nestedData[] ="<div style='float:left;margin-right:8px;'> <a title='Delete' id='".$row['LZ_BD_CATA_ID']."'  class='btn btn-danger btn-xs delResultRow'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> </a> </div>";
    
      $nestedData[] = $row["EBAY_ID"];
     
      $nestedData[] = $row["TITLE"];

      $nestedData[] = $row["CONDITION_NAME"];

      $nestedData[] = $row["SELLER_ID"];
      $nestedData[] = $row["LISTING_TYPE"];
      $nestedData[] = $row["SALE_PRICE"];
      $nestedData[] = $row["START_TIME"];
      $nestedData[] = $row["SALE_TIME"];
      $nestedData[] = $row["FEEDBACK_SCORE"];

      $data[] = $nestedData;

    }

    $json_data = array(
          "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
          "recordsTotal"    =>  intval($totalData),  // total number of records
          "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
          "deferLoading" =>  intval( $totalFiltered ),
          "data"            => $data   // total data array
          
          );
    return $json_data;
  }

  public function deleteUnVerifiedData(){
      $cata_id = $this->input->post('deleteID');


        if($del_qry_mt){

          return 1;

        }else{
          return 0;
        }       

  }

  public function loadBdMpn(){
    $object_id = $this->input->post('object_id');
    $sql = "SELECT C.MPN, C.CATALOGUE_MT_ID, O.OBJECT_ID FROM LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE O.OBJECT_ID = C.OBJECT_ID AND O.OBJECT_ID = $object_id";
    $sql = $this->db->query($sql);
    $sql = $sql->result_array();
    return $sql;
  }
  public function displayCatalogueMPN(){
    $bd_kit_mpn = $this->input->post('bd_kit_mpn');
    $bd_category = $this->input->post('bd_category');
    
    $query = $this->db->query("SELECT CG.CATALOGUE_GROUP_ID, DT.DET_ID, CG.CATALOGUE_GROUP_VALUE, MT.SPECIFIC_NAME, DT.SPECIFIC_VALUE FROM LZ_CATALOGUE_MT CM, LZ_CATALOGUE_DET CD, LZ_CATALOGUE_GROUP_MT CG, CATEGORY_SPECIFIC_DET DT, CATEGORY_SPECIFIC_MT  MT WHERE CM.CATALOGUE_MT_ID = CD.CATALOGUE_MT_ID AND CD.CATALOGUE_GROUP_ID = CG.CATALOGUE_GROUP_ID AND MT.MT_ID = DT.MT_ID AND CD.SPECIFIC_DET_ID = DT.DET_ID AND CM.MPN = '$bd_kit_mpn'AND CM.CATEGORY_ID = $bd_category AND UPPER(CG.CATALOGUE_GROUP_VALUE) = 'PRODUCT IDENTIFIERS' ORDER BY CG.CATALOGUE_GROUP_ID");
    return $query->result_array();

  }
  public function saveFilterExp(){
    $fltr_exp = $this->input->post('fltr_exp');
    $fltr_exp = trim(str_replace("  ", ' ', $fltr_exp));
    $fltr_exp = strtoupper(trim(str_replace(array("'"), "''", $fltr_exp))); 

    $exp_name = $this->input->post('exp_name');
    $exp_name = trim(str_replace("  ", ' ', $exp_name));
    $exp_name = strtoupper(trim(str_replace(array("'"), "''", $exp_name))); 
       
    $fltr_bd_category = $this->input->post('fltr_bd_category');

    date_default_timezone_set("America/Chicago");
    $current_date = date("Y-m-d H:i:s");
    $current_date = "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";
    $insert_by = $this->session->userdata('user_id');

       $checkExpName = $this->db2->query("SELECT M.CAT_EXP_ID FROM LZ_BD_CAT_EXP_MT M, LZ_BD_CAT_EXP_DET D  WHERE UPPER(TRIM(M.EXPR_NAME)) = '$exp_name' AND UPPER(TRIM(D.EXP_TEXT)) = '$fltr_exp' AND M.CATEGORY_ID = $fltr_bd_category");
       $checkExpName1 = $this->db2->query("SELECT M.CAT_EXP_ID FROM LZ_BD_CAT_EXP_MT M, LZ_BD_CAT_EXP_DET D  WHERE UPPER(TRIM(M.EXPR_NAME)) = '$exp_name'  AND M.CATEGORY_ID = $fltr_bd_category");
      if($checkExpName->num_rows() == 0){
        $query = $this->db2->query("SELECT laptop_zone.get_single_primary_key('LZ_BD_CAT_EXP_MT','CAT_EXP_ID') ID FROM DUAL");
        $rs = $query->result_array();
        $cat_exp_id = $rs[0]['ID'];

        $mt_query = $this->db2->query("INSERT INTO LZ_BD_CAT_EXP_MT (CAT_EXP_ID, CATEGORY_ID, EXPR_NAME, INSERTED_DATE, INSERTED_BY) VALUES($cat_exp_id, $fltr_bd_category, '$exp_name', $current_date, $insert_by)");
            $det_pk_query = $this->db2->query("SELECT laptop_zone.get_single_primary_key('LZ_BD_CAT_EXP_DET','CAT_EXP_DET_ID') ID FROM DUAL");
            $rs = $det_pk_query->result_array();
            $cat_exp_det_id = $rs[0]['ID'];
            $det_ins_query = $this->db2->query("INSERT INTO LZ_BD_CAT_EXP_DET (CAT_EXP_DET_ID, CAT_EXP_ID, EXP_TEXT) VALUES($cat_exp_det_id, $cat_exp_id, '$fltr_exp')");
                  if($det_ins_query){
                    return 1;
                  }else{
                    return 0;
                  }
            }elseif($checkExpName1->num_rows() > 0){
              $checkExpName2 = $this->db2->query("SELECT M.CAT_EXP_ID FROM LZ_BD_CAT_EXP_MT M WHERE UPPER(TRIM(D.EXP_TEXT)) = '$fltr_exp' AND M.CATEGORY_ID = $fltr_bd_category AND ");
                if (!empty($exp_name) && $checkExpName2->num_rows() == 0) {
                  $exp_name_ids = $checkExpName1->result_array();
                  $exp_name_id = $exp_name_ids[0]['CAT_EXP_ID'];
                  $det_pk_query = $this->db2->query("SELECT laptop_zone.get_single_primary_key('LZ_BD_CAT_EXP_DET','CAT_EXP_DET_ID') ID FROM DUAL");
                  $rs = $det_pk_query->result_array();
                  $cat_exp_det_id = $rs[0]['ID'];
                  $det_ins_query = $this->db2->query("INSERT INTO LZ_BD_CAT_EXP_DET (CAT_EXP_DET_ID, CAT_EXP_ID, EXP_TEXT) VALUES($cat_exp_det_id, $exp_name_id, '$fltr_exp')");
                    if($det_ins_query){
                        return 1;
                      }else{
                        return 0;
                            }
            }else {
              return 3; ////for $checkExpName2
            }           
              
      }else{
        return 2; //// for $checkExpName
      }
           
       
       
  }

  public function saveWordExp(){

    $word_exp = $this->input->post('word_exp');
    $word_exp = trim(str_replace("  ", ' ', $word_exp));
    $word_exp = strtoupper(trim(str_replace(array("'"), "''", $word_exp)));    
    $bd_category = $this->input->post('bd_category');

    $word_exp_name = $this->input->post('word_exp_name');
    $word_exp_name = trim(str_replace("  ", ' ', $word_exp_name));
    $word_exp_name = strtoupper(trim(str_replace(array("'"), "''", $word_exp_name)));

    date_default_timezone_set("America/Chicago");
    $current_date = date("Y-m-d H:i:s");
    $current_date = "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";
    $insert_by = $this->session->userdata('user_id');

    $checkExpName = $this->db2->query("SELECT CAT_EXP_ID FROM LZ_BD_CAT_EXP_MT WHERE UPPER(TRIM(EXPR_NAME)) = '$word_exp_name'");
      if($checkExpName->num_rows() == 0){
        $query = $this->db2->query("SELECT laptop_zone.get_single_primary_key('LZ_BD_CAT_EXP_MT','CAT_EXP_ID') ID FROM DUAL");
        $rs = $query->result_array();
        $cat_exp_id = $rs[0]['ID'];

        $mt_query = $this->db2->query("INSERT INTO LZ_BD_CAT_EXP_MT (CAT_EXP_ID, CATEGORY_ID, EXPR_NAME, INSERTED_DATE, INSERTED_BY) VALUES($cat_exp_id, $bd_category, '$word_exp', $current_date, $insert_by)");

        $det_pk_query = $this->db2->query("SELECT laptop_zone.get_single_primary_key('LZ_BD_WORDS_EXP_DET','WORD_EXP_DET_ID') ID FROM DUAL");
        $rs = $det_pk_query->result_array();
        $word_exp_det_id = $rs[0]['ID'];
      
        $det_ins_query = $this->db2->query("INSERT INTO LZ_BD_WORDS_EXP_DET (WORD_EXP_DET_ID, CAT_EXP_ID, EXP_TEXT) VALUES($word_exp_det_id, $cat_exp_id, '$word_exp')");

        if($det_ins_query){
          return 1;
        }else{
          return 0;
        }
      }else{
        return 2;
      }
           
       
       
  }  
  ////////////////////////CREATED BY IMRAN OCT-03-2017 /////////////////////////////////////
  public function getResults(){
    $rows = $this->db2->query("SELECT * FROM SPLITTED_WORDS_COUNT")->result_array();
    $count = count($rows);
    return array(
      "rows"=>$rows,
      "count"=>$count
    );
  }
  public function getResultObjects(){
    return $res = $this->db2->query("SELECT O.OBJECT_ID,O.OBJECT_NAME FROM LZ_BD_OBJECTS_MT O")->result_array();
  }
  public function getTitles(){
    $result_cat   = $this->input->post("result_cat");
    $result_word = $this->input->post("result_word");
     $result_word = trim(str_replace("  ", ' ', $result_word));
    $result_word = strtoupper(trim(str_replace(array("'"), "''", $result_word))); 

    //var_dump($result_cat, $result_word); exit;
    return $res = $this->db2->query("SELECT EBAY_ID,TITLE FROM LZ_BD_CATAG_DATA_$result_cat WHERE UPPER(TITLE) LIKE '%$result_word%'")->result_array();
   /* echo "<pre>";
    print_r($res);
    exit*/;
  }
   public function addAutoMpn(){
    $category_id = $this->input->post('cat_id');
    $word_mpn = $this->input->post('word_mpn');
    $alt_mpn = $this->input->post('alt_mpn');

    $object_id = $this->input->post('exp_object');

    $mpn_desc = $this->input->post('mpn_desc');
    //var_dump($alt_mpn, $word_mpn, $mpn_desc, $object_id); exit;

    date_default_timezone_set("America/Chicago");
    $current_date = date("Y-m-d H:i:s");
    $current_date = "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";
    $insert_by = $this->session->userdata('user_id');

    $i =0;
    foreach ($word_mpn as $mpn) {
      $word_mpn = trim(str_replace("  ", ' ', $mpn));
      $word_mpn = strtoupper(trim(str_replace(array("'"), "''", $word_mpn)));

      $alternate_mpn = trim(str_replace("  ", ' ', $alt_mpn[$i]));
      $alternate_mpn = strtoupper(trim(str_replace(array("'"), "''", $alternate_mpn)));

      $mpn_descriptipn = trim(str_replace("  ", ' ', $mpn_desc[$i]));
      $mpn_descriptipn = strtoupper(str_replace(array("'"), "''", $mpn_descriptipn));
      //var_dump($word_mpn, $alternate_mpn); exit;
       $check_qry = $this->db->query("SELECT M.CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT M WHERE UPPER(TRIM(M.MPN)) = '$word_mpn' AND M.CATEGORY_ID = $category_id");
      if($check_qry->num_rows() == 0){
         $return_data = 1;
        $query = $this->db->query("SELECT get_single_primary_key('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') ID FROM DUAL");
        $rs = $query->result_array();
        $catalogue_mt_id = $rs[0]['ID'];

        $mt_query = $this->db->query("INSERT INTO LZ_CATALOGUE_MT (CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY, CUSTOM_MPN, OBJECT_ID, MPN_DESCRIPTION, AUTO_CREATED) VALUES($catalogue_mt_id, '$word_mpn', $category_id, $current_date, $insert_by, 0, $object_id[$i], '$mpn_descriptipn', 1)");
          if ($mt_query && !empty($alternate_mpn)) {
              $check_alt_mpn = $this->db->query("SELECT MPN_ALT_VALUE FROM LZ_ALT_CATALOGUE_MPN M WHERE UPPER(TRIM(M.MPN_ALT_VALUE)) = '$alternate_mpn' AND M.CATALOGUE_MT_ID = $catalogue_mt_id");
                if($check_alt_mpn->num_rows() == 0){
                  $alts = $this->db->query("SELECT get_single_primary_key('LZ_ALT_CATALOGUE_MPN','CATALOGUE_ALT_ID') ID FROM DUAL");
                  $rs = $alts->result_array();
                  $alternate_pk_id = $rs[0]['ID'];
                  if (!empty($alternate_mpn)) {
                    $alt_query = $this->db->query("INSERT INTO LZ_ALT_CATALOGUE_MPN (CATALOGUE_ALT_ID, CATALOGUE_MT_ID, MPN_ALT_VALUE, INSERT_DATE, INSERT_BY) VALUES($alternate_pk_id, $catalogue_mt_id, '$alternate_mpn', $current_date, $insert_by)");
                  } 
                } 
              }
      }else {
        $catalogue_id = $check_qry->result_array();
        $catalogue_mt_id= $catalogue_id[0]['CATALOGUE_MT_ID'];
        $check_alt_mpn = $this->db->query("SELECT MPN_ALT_VALUE FROM LZ_ALT_CATALOGUE_MPN M WHERE UPPER(TRIM(M.MPN_ALT_VALUE)) = '$alternate_mpn' AND M.CATALOGUE_MT_ID = $catalogue_mt_id");
            if($check_alt_mpn->num_rows() == 0){
               $alts = $this->db->query("SELECT get_single_primary_key('LZ_ALT_CATALOGUE_MPN','CATALOGUE_ALT_ID') ID FROM DUAL");
              $rs = $alts->result_array();
              $alternate_pk_id = $rs[0]['ID'];
              if (!empty($alternate_mpn)) {
                $alt_query = $this->db->query("INSERT INTO LZ_ALT_CATALOGUE_MPN (CATALOGUE_ALT_ID, CATALOGUE_MT_ID, MPN_ALT_VALUE, INSERT_DATE, INSERT_BY) VALUES($alternate_pk_id, $catalogue_mt_id, '$alternate_mpn', $current_date, $insert_by)");
              }
              
              $return_data = 1;
              $mt_query = 1;
            }
          }
        $i++;
    }
     if($mt_query || $alt_query){
        return $return_data;
      }else{
        return 0;
      }
        
  }
  /////////////////////////////////////////////////////
   public function saveCatInSession(){
   $cat_id = $this->input->post("cat_id");
   $this->session->set_userdata(["auto_mpn_save_cat"=>$cat_id]);
  }
  public function delete_auto_mpn(){
   $cat_id = $this->input->post("cat_id");
   $mpn_word = $this->input->post("mpn_word");
   $del = $this->db2->query("DELETE FROM SPLITTED_WORDS_COUNT M WHERE M.WORDS='$mpn_word'");
     if ($del) {
       return true;
     }else {
       return false;
     }
  }
   public function getWords(){
     return $this->db2->query("SELECT * FROM LZ_BD_GEN_WORDS_MT")->result_array();
    }

    public function addAutoJunk(){
    $category_id = $this->input->post('cat_id');
    $word_id = $this->input->post('word_id');
    $junk_words = $this->input->post('junk_words');
    //var_dump($alt_mpn, $junk_words, $mpn_desc, $object_id); exit;

    date_default_timezone_set("America/Chicago");
    $current_date = date("Y-m-d H:i:s");
    $current_date = "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";
    $insert_by = $this->session->userdata('user_id');

    $i =0;
    foreach ($junk_words as $word) {
      $junk_word = trim(str_replace("  ", ' ', $word));
      $junk_word = strtoupper(trim(str_replace(array("'"), "''", $junk_word)));
      //var_dump($junk_word, $alternate_mpn); exit;
       $check_qry = $this->db2->query("SELECT M.GEN_MT_ID, M.GEN_WORDS FROM LZ_BD_GEN_WORDS_DET M WHERE UPPER(TRIM(M.GEN_WORDS)) = '$junk_word' AND M.GEN_MT_ID = $word_id");
      if($check_qry->num_rows() == 0){
         $return_data = 1;
        $query = $this->db2->query("SELECT laptop_zone.get_single_primary_key('LZ_BD_GEN_WORDS_DET','GEN_DET_ID') ID FROM DUAL");
        $rs = $query->result_array();
        $gen_det_id = $rs[0]['ID'];

        $mt_query = $this->db2->query("INSERT INTO LZ_BD_GEN_WORDS_DET (GEN_DET_ID, GEN_MT_ID, GEN_WORDS, INSERT_DATE, INSERT_BY) VALUES($gen_det_id, $word_id, '$junk_word', $current_date, $insert_by)");
          if ($mt_query) {

            $check_alt_mpn = $this->db2->query("SELECT M.GEN_MT_ID, M.CATEGORY_ID FROM LZ_BD_GEN_WORDS_CATEGORIES M WHERE M.GEN_MT_ID = $word_id AND M.CATEGORY_ID = $category_id");
            if($check_alt_mpn->num_rows() == 0){
              $alts = $this->db2->query("SELECT laptop_zone.get_single_primary_key('LZ_BD_GEN_WORDS_CATEGORIES','GEN_WORD_ID') ID FROM DUAL");
              $rs = $alts->result_array();
              $gen_word_id = $rs[0]['ID'];

              $alt_query = $this->db2->query("INSERT INTO LZ_BD_GEN_WORDS_CATEGORIES (GEN_WORD_ID, GEN_MT_ID, CATEGORY_ID) VALUES($gen_word_id, $word_id,$category_id)");
              
            }
             
          }
      }
      $i++;
    }
    if ($alt_query){
        return 1;
      }else {
        return false;
      } 
        
  }
 /////////////// YOUSAF METHODS//////////////////////
    public function addCatalogueDetail(){
    // $cat_id = $this->uri->segment(4);
    // var_dump($cat_id );exit;
    // $mpn = $this->uri->segment(5); 
    // $mpn = urldecode($this->uri->segment(5));
    // var_dump($mpn);exit;
    $cat_id = $this->input->post('result_cat');
    // var_dump($cat_id);
    $mpn = $this->input->post('result_word');
    // var_dump($mpn);exit;
    $mpn = strtoupper(trim($mpn));
    $mpn = "'AND UPPER(TITLE) LIKE ''%$mpn%'''";
    // echo "<script> alert($mpn);</script>";
    // var_dump($mpn);exit;
    // $call = $this->db2->query("call pro_auto_catalogue($cat_id,$mpn)");
    // var_dump($$mpn);exit;

    $qry = "SELECT SPECIFIC_NAME,SPECIFIC_VALUE,DET_ID,MT_ID,MAX_VALUE,COUNT(1) C FROM (SELECT M.SPECIFIC_NAME,D.SPECIFIC_VALUE,D.DET_ID,M.MT_ID,M.MAX_VALUE FROM  SPLITTED_SPEC_WORDS W,LAPTOP_ZONE.CATEGORY_SPECIFIC_MT M,LAPTOP_ZONE.CATEGORY_SPECIFIC_DET D WHERE M.MT_ID=D.MT_ID AND M.EBAY_CATEGORY_ID = $cat_id AND UPPER(D.SPECIFIC_VALUE) = UPPER(W.WORD) ) GROUP BY SPECIFIC_NAME,DET_ID,MT_ID,MAX_VALUE, SPECIFIC_VALUE";
    $qry = $this->db2->query($qry);
    $qry = $qry->result_array();
    // var_dump($qry);exit;
    return $qry;
  }

    public function makeCatalogueDetail(){
    $cat_id = $this->input->post('cat_id');
    $mpn = $this->input->post('mpn');

    // var_dump($mpn);exit;

    $spec_det_ids = $this->input->post('det_ids');
    // var_dump($spec_det_ids);exit;

    $checkCatalogue = $this->db->query("SELECT CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT M WHERE UPPER(M.MPN) = '$mpn' AND M.CATEGORY_ID = $cat_id");

    if($checkCatalogue->num_rows()>0){
      $catalogue_mt_id = $checkCatalogue->result_array();
      $catalogue_mt_id = $catalogue_mt_id[0]['CATALOGUE_MT_ID'];
      // var_dump($catalogue_mt_id);exit;

      foreach($spec_det_ids as $det_id){
        // var_dump($det_id);exit;
        // $checkDetail = $this->db->query("SELECT CATALOGUE_DET_ID FROM LZ_CATALOGUE_DET WHERE SPECIFIC_DET_ID = $det_id AND CATALOGUE_MT_ID = $catalogue_mt_id  ");
        // $checkDetail = $checkDetail->result_array();
        // $checkDetail = $checkDetail[0]['CATALOGUE_DET_ID'];
        // if($checkDetail->num_rows() == 0){
          $query = $this->db->query("SELECT get_single_primary_key('LZ_CATALOGUE_DET','CATALOGUE_DET_ID') ID FROM DUAL");
          $rs = $query->result_array();
          $catalogue_det_id = $rs[0]['ID'];

          $this->db->query("INSERT INTO LZ_CATALOGUE_DET(CATALOGUE_DET_ID, CATALOGUE_MT_ID, CATALOGUE_GROUP_ID, SPECIFIC_DET_ID)  VALUES($catalogue_det_id,$catalogue_mt_id,14,$det_id) ");
          // return 1;
        // }
        // else{
        //   return 2;
        // }
        
          
      }//end foreach
      return 1;
    }else{
      
        return 0;
    }
    // $query = ""
  }

  public function specsByCategory(){

    // SELECT DISTINCT D.CATEGORY_ID,
    //                BD.CATEGORY_NAME
    //  FROM LZ_BD_CAT_GROUP_DET D, LZ_BD_CATEGORY BD
    // WHERE D.CATEGORY_ID = BD.CATEGORY_ID
    $categories = "SELECT DISTINCT S.EBAY_CATEGORY_ID, BD.CATEGORY_NAME FROM CATEGORY_SPECIFIC_MT S,LZ_BD_CATEGORY BD WHERE S.EBAY_CATEGORY_ID = BD.CATEGORY_ID ";

    $sql = $this->db2->query($categories);
    $sql = $sql->result_array();
    // var_dump($sql);
    return $sql;
  }

  public function loadSpecifics(){
    $cat_id = $this->input->post('cat_id');

    $specs = "SELECT * FROM CATEGORY_SPECIFIC_MT WHERE EBAY_CATEGORY_ID = $cat_id ORDER BY SPECIFIC_NAME";
    $sql = $this->db2->query($specs);
    $sql = $sql->result_array();
    // var_dump($sql);exit;
    return $sql;
  }

  public function saveSpecifics(){
    $mt_ids = $this->input->post('spec_checked');
    // var_dump($mt_ids);exit;
    $cat_id = $this->input->post('cat_id');

    $specs_for = $this->input->post('specs');
    // var_dump($specs_for);exit;
  
    foreach($mt_ids as $mt_id){
      
      $check = $this->db2->query("SELECT S.SPECIFIC_MT_ID,S.CATEGORY_ID,S.LZ_SPEC_ID FROM LZ_SPEC_FOR_CATALOGUE S WHERE S.SPECIFIC_MT_ID = $mt_id AND S.CATEGORY_ID = $cat_id");
      if($check->num_rows() == 0){

        $query = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_SPEC_FOR_CATALOGUE','LZ_SPEC_ID') ID FROM DUAL");
        $rs = $query->result_array();
        $spec_id = $rs[0]['ID'];

        
        $qry = "INSERT INTO LZ_SPEC_FOR_CATALOGUE (LZ_SPEC_ID,SPECIFIC_MT_ID,CATEGORY_ID,SPECS_FOR) VALUES($spec_id,$mt_id,$cat_id,$specs_for)";
        $qry = $this->db2->query($qry);
        // return 1;
        // if($qry){
        //   return 1;
        // }else{
        //   return 0;
        // }

      }

      
    }
    return 1;
  }

 public function loadSpecificsDetail(){
    $cat_id = $this->input->post('cat_id');

    $specs = "SELECT C.SPECIFIC_NAME, S.LZ_SPEC_ID,S.SPECS_FOR,S.SPECIFIC_MT_ID FROM CATEGORY_SPECIFIC_MT C, LZ_SPEC_FOR_CATALOGUE S WHERE C.MT_ID = S.SPECIFIC_MT_ID AND S.CATEGORY_ID = $cat_id"; 
    $sql = $this->db2->query($specs);
    $sql = $sql->result_array();
    // var_dump($sql);exit;
    return $sql;
  }

 public function deleteSpecForCatalogue(){
  $del_id = $this->input->post('del_id');

  $qry = $this->db2->query("DELETE FROM LZ_SPEC_FOR_CATALOGUE S WHERE S.LZ_SPEC_ID = $del_id");
  if($qry){
    return 1;
  }else{
    return 0;
  }
 }

 public function updateOneSpec(){
  $spec_id = $this->input->post('dropVal');
  // var_dump($spec_id);exit;
  $cat_id = $this->input->post('cat_id');
  $lz_spec_id = $this->input->post('lz_spec_id');
  // var_dump($lz_spec_id);exit;
  $spec_for = $this->input->post('specFor');
   // var_dump($spec_for);exit;
  $qry = $this->db2->query("UPDATE LZ_SPEC_FOR_CATALOGUE SET SPECIFIC_MT_ID = $spec_id , SPECS_FOR = $spec_for WHERE LZ_SPEC_ID = $lz_spec_id");

  if($qry){
    return 1;
  }else{
    return 0 ;
  }
 } 

 public function deleteAllSpec(){
    $cat_id = $this->input->post('cat_id');

    $qry = $this->db2->query("DELETE FROM LZ_SPEC_FOR_CATALOGUE  WHERE CATEGORY_ID = $cat_id");

    if($qry){
      return 1;
    }else{
      return 0 ;
    }
 }
}

?>