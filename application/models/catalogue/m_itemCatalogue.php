<?php 

  class M_itemCatalogue extends CI_Model{

    public function __construct(){
    parent::__construct();
    $this->load->database();
  }
  public function getCategorySpecifics($category_id = ''){
    if (empty($category_id)) {
      $cat_id = $this->input->post('bd_category');
    }else {
      $cat_id = $category_id;
    }
    
    $this->session->set_userdata('bd_category', $cat_id);

    $mt_query = $this->db2->query("SELECT * FROM CATEGORY_SPECIFIC_MT  M WHERE M.EBAY_CATEGORY_ID = $cat_id"); 
    $mt_query =  $mt_query->result_array();

    $group_qry = $this->db2->query("SELECT * FROM LZ_CATALOGUE_GROUP_MT");
    $group_qry =  $group_qry->result_array();

    // $det_query = $this->db2->query("SELECT * FROM  CATEGORY_SPECIFIC_DET D WHERE D.MT_ID IN (SELECT MT_ID FROM CATEGORY_SPECIFIC_MT  M WHERE M.EBAY_CATEGORY_ID = $cat_id)");

    // $det_query =  $det_query->result_array();

    return array('mt_query' => $mt_query, 'group_qry'=>$group_qry);

  }
  public function getItemSpecificsValues(){
    $spec_mt_id = $this->input->post('spec_mt_id');
    $bd_category = $this->input->post('bd_category');
    $this->session->set_userdata('bd_category', $bd_category);
    $det_query = $this->db2->query("SELECT * FROM  CATEGORY_SPECIFIC_DET D WHERE D.MT_ID IN (SELECT MT_ID FROM CATEGORY_SPECIFIC_MT  M WHERE M.EBAY_CATEGORY_ID = $bd_category AND M.MT_ID = $spec_mt_id)");

    return $det_query->result_array();  
  }

  public function custom_specifics($cat_id, $custom_name, $custom_value, $selectionMode, $catalogue_only, $maxValue){
    $comma = ',';
    date_default_timezone_set("America/Chicago");
    $current_date = date("Y-m-d H:i:s");
    $current_date = "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";  

    $query = $this->db2->query("SELECT SPECIFIC_NAME FROM CATEGORY_SPECIFIC_MT WHERE SPECIFIC_NAME = '$custom_name' AND EBAY_CATEGORY_ID = $cat_id"); 
    if($query->num_rows() >0){
        return false;
    }else{

      $get_mt_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('CATEGORY_SPECIFIC_MT','MT_ID') SPECIFICS_MT_ID FROM DUAL");
      $get_mt_pk = $get_mt_pk->result_array();
      $specifics_mt_id = $get_mt_pk[0]['SPECIFICS_MT_ID'];

        $ins_mt_qry = "INSERT INTO CATEGORY_SPECIFIC_MT(MT_ID, EBAY_CATEGORY_ID, SPECIFIC_NAME, MARKETPLACE_ID, MAX_VALUE, MIN_VALUE, SELECTION_MODE, UPDATE_DATE, CUSTOM, CATALOGUE_ONLY) VALUES ($specifics_mt_id $comma $cat_id $comma '$custom_name' $comma 1 $comma $maxValue $comma 1 $comma $selectionMode $comma $current_date $comma 1 $comma $catalogue_only)";
        $ins_mt_qry = $this->db2->query($ins_mt_qry);

      $get_det_pk = $this->db2->query("SELECT get_single_primary_key('CATEGORY_SPECIFIC_DET','DET_ID') SPECIFICS_DET_ID FROM DUAL");
      $get_det_pk = $get_det_pk->result_array();
      $specifics_det_id = $get_det_pk[0]['SPECIFICS_DET_ID'];              
      
        $ins_det_qry = "INSERT INTO CATEGORY_SPECIFIC_DET VALUES ($specifics_det_id $comma $specifics_mt_id $comma '$custom_value')";
        $ins_det_qry = $this->db2->query($ins_det_qry);
    }
  }

  public function itemCategorySpecifics($perameter =''){
    $cat_query = $this->db2->query("SELECT CATEGORY_ID,CATEGORY_NAME FROM LZ_BD_CATEGORY_TREE WHERE CATEGORY_ID = $perameter"); 
    $cat_query =  $cat_query->result_array();

    $mt_query = $this->db2->query("SELECT * FROM CATEGORY_SPECIFIC_MT  M WHERE M.EBAY_CATEGORY_ID = $perameter"); 
    $mt_query =  $mt_query->result_array();

    $det_query = $this->db2->query("SELECT * FROM  CATEGORY_SPECIFIC_DET D WHERE D.MT_ID IN (SELECT MT_ID FROM CATEGORY_SPECIFIC_MT  M WHERE M.EBAY_CATEGORY_ID = $perameter)");

    $det_query =  $det_query->result_array();

    return array('mt_query' => $mt_query, 'det_query'=>$det_query, 'cat_query'=>$cat_query);

   
  }
  public function specific_mpn($bd_mpn =''){
    return $this->db2->query("SELECT M.CATALOGUE_MT_ID , M.MPN FROM LZ_CATALOGUE_MT m where  M.CATALOGUE_MT_ID = $bd_mpn")->result_array();
  }

  public function getSpecificObjectsFirstLoad(){
    $qry = $this->db2->query("SELECT O.OBJECT_ID,O.OBJECT_NAME FROM LZ_BD_OBJECTS_MT O");
    $qry = $qry->result_array();
    return $qry;
  }

  public function getSpecificObjects($bd_category){
    $qry = $this->db2->query("SELECT O.OBJECT_ID,O.OBJECT_NAME FROM LZ_BD_OBJECTS_MT O WHERE O.CATEGORY_ID = $bd_category ORDER BY O.OBJECT_NAME");
    $qry = $qry->result_array();
    return $qry;
  }

  public function createObject(){
    $obj_val = $this->input->post('new_object');
    $group_id = $this->input->post('group_id');
    $bd_category = $this->input->post('bd_category');
    $obj_val = strtoupper($obj_val);
    $obj_val = trim(str_replace("  ", ' ', $obj_val));
    $obj_val = trim(str_replace(array("'"), "''", $obj_val));

    $insert_by = $this->session->userdata('user_id');

    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $insert_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
    // $get_mt_pk = $this->db2->query("SELECT get_single_primary_key('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') CATALOGUE_MT_ID FROM DUAL");
    //     $get_pk = $get_mt_pk->result_array();
    //     $cat_mt_id = $get_pk[0]['CATALOGUE_MT_ID'];

    $checkQry = $this->db2->query("SELECT OBJECT_ID,OBJECT_NAME FROM LZ_BD_OBJECTS_MT WHERE OBJECT_NAME = '$obj_val' AND CATEGORY_ID = $bd_category");
    if($checkQry->num_rows()>0){
      return 0;
    }else{
      $obj_id = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_OBJECTS_MT','OBJECT_ID') OBJECT_ID FROM DUAL");
      $get_mt_pk = $obj_id->result_array();
      $object_id = $get_mt_pk[0]['OBJECT_ID'];

      $qry = "INSERT INTO LZ_BD_OBJECTS_MT O (OBJECT_ID, OBJECT_NAME,INSERT_DATE,INSERT_BY, CATEGORY_ID, LZ_BD_GROUP_ID) VALUES($object_id, '$obj_val',$insert_date,$insert_by, $bd_category, '$group_id')";
      $this->db2->query($qry);

      return 1;
    }

    
  }

   public function updateObjectID(){
    $object_id = $this->input->post('obj_val');
    $mpn = $this->input->post('mpn');
    $cat_id = $this->input->post('cat_id');

    $checkQry = $this->db2->query("SELECT M.CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT M WHERE M.MPN = '$mpn' AND M.CATEGORY_ID = $cat_id AND M.OBJECT_ID IS  NULL");
    if($checkQry->num_rows() > 0){

      $query = $this->db2->query("UPDATE LZ_CATALOGUE_MT M SET M.OBJECT_ID = $object_id WHERE M.MPN = '$mpn' AND M.CATEGORY_ID = $cat_id");
      return 1;
    }else{
      return 0;
    }

    
   }

   public function updateObjectEdit(){
      $object_id = $this->input->post('obj_id');
      $mpn = $this->input->post('mpn');
      $cat_id = $this->input->post('cat_id');

      $checkQry = $this->db2->query("SELECT M.CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT M WHERE M.MPN = '$mpn' AND M.CATEGORY_ID = $cat_id AND M.OBJECT_ID IS NOT NULL");
    if($checkQry->num_rows() > 0){
      $qry = $this->db2->query("UPDATE LZ_CATALOGUE_MT M SET M.OBJECT_ID = $object_id WHERE M.MPN = '$mpn' AND M.CATEGORY_ID = $cat_id");
      return 1;
    }else if($checkQry->num_rows() == 0){
      $qry = $this->db2->query("UPDATE LZ_CATALOGUE_MT M SET M.OBJECT_ID = $object_id WHERE M.MPN = '$mpn' AND M.CATEGORY_ID = $cat_id");
      return 1;
    }else{
      return 0;
    }

   }


  public function addCatalogueGroupName($catalogueGroupName){

    $check_query = $this->db2->query("SELECT * FROM LZ_CATALOGUE_GROUP_MT T WHERE T.CATALOGUE_GROUP_VALUE = '$catalogueGroupName'");

    if($check_query->num_rows() > 0){
        return false;
    }else{

      $get_mt_pk = $this->db2->query("SELECT get_single_primary_key('LZ_CATALOGUE_GROUP_MT','CATALOGUE_GROUP_ID') CATALOGUE_GROUP_ID FROM DUAL");
      $get_pk = $get_mt_pk->result_array();
      $cat_group_mt = $get_pk[0]['CATALOGUE_GROUP_ID'];
      

      $query = $this->db2->query("INSERT INTO LZ_CATALOGUE_GROUP_MT (CATALOGUE_GROUP_ID, CATALOGUE_GROUP_VALUE) VALUES($cat_group_mt, '$catalogueGroupName')");
    }
      
  }

  public function catalogueDetail(){
    $mpn = $this->input->post('mpn');
    $this->session->set_userdata('mpn', $mpn);
    $catalogue_group_id = $this->input->post('catalogue_name');
    $cat_id = $this->input->post('cat_id');
    $spec_val = $this->input->post('spec_val');
      /*========================================
      =            Catalogue Detail            =
      ========================================*/
      $catalogue_detail_qry = "SELECT CG.CATALOGUE_GROUP_ID,DT.DET_ID,CG.CATALOGUE_GROUP_VALUE, MT.SPECIFIC_NAME,DT.SPECIFIC_VALUE FROM LZ_CATALOGUE_MT CM, LZ_CATALOGUE_DET CD, LZ_CATALOGUE_GROUP_MT CG,CATEGORY_SPECIFIC_DET DT,CATEGORY_SPECIFIC_MT MT WHERE CM.CATALOGUE_MT_ID = CD.CATALOGUE_MT_ID AND CD.CATALOGUE_GROUP_ID = CG.CATALOGUE_GROUP_ID AND MT.MT_ID=DT.MT_ID AND CD.SPECIFIC_DET_ID = DT.DET_ID AND CM.MPN = '$mpn'AND CM.CATEGORY_ID = $cat_id ORDER BY CG.CATALOGUE_GROUP_ID";

      $catalogue_group_count = "SELECT CATALOGUE_GROUP_ID,CATALOGUE_GROUP_VALUE,COUNT(1) ROW_SPAN FROM (SELECT CG.CATALOGUE_GROUP_ID,CG.CATALOGUE_GROUP_VALUE FROM LZ_CATALOGUE_MT       CM, LZ_CATALOGUE_DET      CD, LZ_CATALOGUE_GROUP_MT CG, CATEGORY_SPECIFIC_DET DT, CATEGORY_SPECIFIC_MT  MT WHERE CM.CATALOGUE_MT_ID = CD.CATALOGUE_MT_ID AND CD.CATALOGUE_GROUP_ID = CG.CATALOGUE_GROUP_ID AND MT.MT_ID = DT.MT_ID AND CD.SPECIFIC_DET_ID = DT.DET_ID AND CM.MPN = '$mpn' AND CM.CATEGORY_ID = $cat_id)  GROUP BY CATALOGUE_GROUP_ID,CATALOGUE_GROUP_VALUE ORDER BY CATALOGUE_GROUP_ID";

      $catalogue_detail = $this->db2->query($catalogue_detail_qry);
      $catalogue_data = $catalogue_detail->result_array();
      $groupCount = $this->db2->query( $catalogue_group_count);
      $groupCount_data = $groupCount->result_array();
      return  array('catalogue_data'=>$catalogue_data, 'groupCount'=>$groupCount_data);


  }


    public function get_mastermpn(){

        $mpn =$this->db2->query("SELECT M.CATALOGUE_MT_ID,M.MPN FROM LZ_CATALOGUE_MT M WHERE M.CATEGORY_ID in (111422, 179, 177, 111419) AND M.CATALOGUE_MT_ID NOT IN(424, 91921)");
        $master_mpn = $mpn->result_array();
        return $master_mpn;


    }


  public function addCatalogue(){
  
  
    $mpn = strtoupper($this->input->post('mpn'));
    $this->session->set_userdata('mpn', $mpn);
    $catalogue_group_id = $this->input->post('catalogue_name');
    $cat_id = $this->input->post('cat_id');
    $spec_val = $this->input->post('spec_val');
    $insert_by = $this->session->userdata('user_id');  
    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $insert_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
    $mpn_desc = $this->input->post('mpn_desc');
    $mpn_desc = strtoupper($mpn_desc);
    $mpn_desc = trim(str_replace("  ", ' ', $mpn_desc));
    $mpn_desc = trim(str_replace(array("'"), "''", $mpn_desc));
    $object_id = $this->input->post('object_id');
      /*========================================
      =            Catalogue Detail            =
      ========================================*/
      //$catalogue_detail_qry = "SELECT DT.DET_ID,CG.CATALOGUE_GROUP_ID,CG.CATALOGUE_GROUP_VALUE, MT.SPECIFIC_NAME,DT.SPECIFIC_VALUE FROM LZ_CATALOGUE_MT CM, LZ_CATALOGUE_DET CD, LZ_CATALOGUE_GROUP_MT CG,CATEGORY_SPECIFIC_DET DT,CATEGORY_SPECIFIC_MT MT WHERE CM.CATALOGUE_MT_ID = CD.CATALOGUE_MT_ID AND CD.CATALOGUE_GROUP_ID = CG.CATALOGUE_GROUP_ID AND MT.MT_ID=DT.MT_ID AND CD.SPECIFIC_DET_ID = DT.DET_ID AND CM.MPN = '$mpn'AND CM.CATEGORY_ID = $cat_id ORDER BY CG.CATALOGUE_GROUP_ID";
      $mpnDate = $this->db2->query("SELECT TO_CHAR(INSERTED_DATE, 'MM/DD/YYYY ') as CAT_DATE FROM LZ_CATALOGUE_MT WHERE upper(MPN) = '$mpn'");
      $mpnDate = $mpnDate->result_array();
      $arr = [$mpn,$mpnDate];
      $catalogue_detail_qry = "SELECT CG.CATALOGUE_GROUP_ID,DT.DET_ID,CG.CATALOGUE_GROUP_VALUE, MT.SPECIFIC_NAME,DT.SPECIFIC_VALUE FROM LZ_CATALOGUE_MT CM, LZ_CATALOGUE_DET CD, LZ_CATALOGUE_GROUP_MT CG,CATEGORY_SPECIFIC_DET DT,CATEGORY_SPECIFIC_MT MT WHERE CM.CATALOGUE_MT_ID = CD.CATALOGUE_MT_ID AND CD.CATALOGUE_GROUP_ID = CG.CATALOGUE_GROUP_ID AND MT.MT_ID=DT.MT_ID AND CD.SPECIFIC_DET_ID = DT.DET_ID AND CM.MPN = '$mpn'AND CM.CATEGORY_ID = $cat_id ORDER BY CG.CATALOGUE_GROUP_ID";
      // $catalogue_detail_qry = "SELECT CG.CATALOGUE_GROUP_ID, DT.DET_ID, CG.CATALOGUE_GROUP_VALUE, MT.SPECIFIC_NAME, DT.SPECIFIC_VALUE, V.SPEC_ALT_VALUE FROM LZ_CATALOGUE_MT       CM, LZ_CATALOGUE_DET      CD, LZ_CATALOGUE_GROUP_MT CG, CATEGORY_SPECIFIC_DET DT, CATEGORY_SPECIFIC_MT  MT, LZ_BD_SPECS_ALT_VAL V WHERE CM.CATALOGUE_MT_ID = CD.CATALOGUE_MT_ID AND CD.CATALOGUE_GROUP_ID = CG.CATALOGUE_GROUP_ID AND MT.MT_ID = DT.MT_ID AND CD.SPECIFIC_DET_ID = DT.DET_ID AND CD.SPECIFIC_DET_ID = V.DET_ID AND V.DET_ID=DT.DET_ID AND CM.MPN = '$mpn'AND CM.CATEGORY_ID = $cat_id ORDER BY CG.CATALOGUE_GROUP_ID";
      
      // $catalogue_group_count = "SELECT CATALOGUE_GROUP_ID,CATALOGUE_GROUP_VALUE,COUNT(1) ROW_SPAN FROM (SELECT CG.CATALOGUE_GROUP_ID,CG.CATALOGUE_GROUP_VALUE FROM LZ_CATALOGUE_MT       CM, LZ_CATALOGUE_DET      CD, LZ_CATALOGUE_GROUP_MT CG, CATEGORY_SPECIFIC_DET DT, CATEGORY_SPECIFIC_MT  MT WHERE CM.CATALOGUE_MT_ID = CD.CATALOGUE_MT_ID AND CD.CATALOGUE_GROUP_ID = CG.CATALOGUE_GROUP_ID AND MT.MT_ID = DT.MT_ID AND CD.SPECIFIC_DET_ID = DT.DET_ID AND CM.MPN = '$mpn' AND CM.CATEGORY_ID = $cat_id)  GROUP BY CATALOGUE_GROUP_ID,CATALOGUE_GROUP_VALUE ORDER BY CATALOGUE_GROUP_ID";

      $catalogue_group_count = "SELECT CATALOGUE_GROUP_ID,CATALOGUE_GROUP_VALUE,COUNT(1) ROW_SPAN FROM (SELECT CG.CATALOGUE_GROUP_ID,CG.CATALOGUE_GROUP_VALUE FROM LZ_CATALOGUE_MT       CM, LZ_CATALOGUE_DET      CD, LZ_CATALOGUE_GROUP_MT CG, CATEGORY_SPECIFIC_DET DT, CATEGORY_SPECIFIC_MT  MT WHERE CM.CATALOGUE_MT_ID = CD.CATALOGUE_MT_ID AND CD.CATALOGUE_GROUP_ID = CG.CATALOGUE_GROUP_ID AND MT.MT_ID = DT.MT_ID AND CD.SPECIFIC_DET_ID = DT.DET_ID AND CM.MPN = '$mpn' AND CM.CATEGORY_ID = $cat_id)  GROUP BY CATALOGUE_GROUP_ID,CATALOGUE_GROUP_VALUE ORDER BY CATALOGUE_GROUP_ID";

      /*=====  End of Catalogue Detail  ======*/

      $mpn_check = $this->db2->query("SELECT CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT WHERE upper(MPN) = '$mpn' AND CATEGORY_ID = $cat_id");

      if($mpn_check->num_rows() == 0){
        $get_mt_pk = $this->db2->query("SELECT get_single_primary_key('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') CATALOGUE_MT_ID FROM DUAL");
        $get_pk = $get_mt_pk->result_array();
        $cat_mt_id = $get_pk[0]['CATALOGUE_MT_ID'];

        $mt_qry = $this->db2->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY,OBJECT_ID,MPN_DESCRIPTION) VALUES($cat_mt_id, '$mpn', $cat_id, $insert_date, $insert_by,$object_id,'$mpn_desc')");        
      }else{
        $get_pk = $mpn_check->result_array();
        $cat_mt_id = $get_pk[0]['CATALOGUE_MT_ID'];
      }

      // var_dump($cat_mt_id);
      // exit;
     
      // master mpn for creating kit start
   

      
    

      // echo "<pre>";
      // print_r ($kitsmpn);
      // // echo "</pre>";
      // // var_dump($kitsmpn);
      // exit;
      $master_mpn = $this->input->post('master_mpn');

      //$i=0;
      if(!empty($master_mpn)){
        foreach ($master_mpn as $master) {
        
          $kitquery = ("SELECT CATALOGUE_MT_ID,PART_CATLG_MT_ID FROM LZ_BD_MPN_KIT_MT WHERE PART_CATLG_MT_ID = $cat_mt_id and catalogue_mt_id = $master");
          $kitsmpn = $this->db2->query($kitquery);
         

          if ($kitsmpn->num_rows() == 0){

          $mpn_kit_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('lz_bd_mpn_kit_mt','mpn_kit_mt_id') MPN_KIT_MT_ID FROM DUAL");
          $mpn_kit_pk = $mpn_kit_pk->result_array();
          $mpn_kit_mt_id = $mpn_kit_pk[0]['MPN_KIT_MT_ID'];

          $kitmpn_insert = $this->db2->query("INSERT INTO LZ_BD_MPN_KIT_MT  (MPN_KIT_MT_ID,CATALOGUE_MT_ID,QTY,PART_CATLG_MT_ID) VALUES($mpn_kit_mt_id,$master,1,$cat_mt_id )");

          }

        }//master mpn for creating kit start end
      }//endif master mpn
      
      if (!empty($spec_val)) {
       
        $det_check = $this->db2->query("SELECT CATALOGUE_DET_ID FROM LZ_CATALOGUE_DET WHERE SPECIFIC_DET_ID = $spec_val AND CATALOGUE_MT_ID = $cat_mt_id");
      
        if($det_check->num_rows() == 0){

          
         //if(!empty($cat_mt_id)){
           $get_dt_pk = $this->db2->query("SELECT get_single_primary_key('LZ_CATALOGUE_DET','CATALOGUE_DET_ID') CATALOGUE_DET_ID FROM DUAL");
            $get_pk = $get_dt_pk->result_array();
            $cat_dt_id = $get_pk[0]['CATALOGUE_DET_ID'];
            $det_query = "INSERT INTO LZ_CATALOGUE_DET(CATALOGUE_DET_ID, CATALOGUE_MT_ID, CATALOGUE_GROUP_ID, SPECIFIC_DET_ID) VALUES($cat_dt_id, $cat_mt_id, $catalogue_group_id, $spec_val)";
            if($this->db2->query($det_query)){
              $catalogue_detail = $this->db2->query($catalogue_detail_qry);
              $catalogue_data = $catalogue_detail->result_array();
              $groupCount = $this->db2->query($catalogue_group_count);
              $groupCount_data = $groupCount->result_array();
              return array('check'=>1,'catalogue_data'=>$catalogue_data, 'groupCount'=>$groupCount_data,'arr'=>$arr);
            }else {
              $catalogue_detail = $this->db2->query($catalogue_detail_qry);
              $catalogue_data = $catalogue_detail->result_array();
              $groupCount = $this->db2->query($catalogue_group_count);
              $groupCount_data = $groupCount->result_array();
              return array('check'=>0,'catalogue_data'=>$catalogue_data, 'groupCount'=>$groupCount_data,'arr'=>$arr);
            }

          //} 
        }else{
          $catalogue_detail = $this->db2->query($catalogue_detail_qry);
          $catalogue_data = $catalogue_detail->result_array();
          $groupCount = $this->db2->query($catalogue_group_count);
          $groupCount_data = $groupCount->result_array();
          return array('check'=>2,'catalogue_data'=>$catalogue_data, 'groupCount'=>$groupCount_data,'arr'=>$arr);
        }      
      }else {
           return array('check'=>1,'catalogue_data'=>'', 'groupCount'=>'','arr'=>$arr);
      }

  }
  public function addCustomSpecsforCatalog(){
    $cat_id = $this->input->post('cat_id');
    $custom_name = ucfirst($this->input->post('custom_name'));
    $custom_name = trim(str_replace("  ", ' ', $custom_name));
    $custom_name = trim(str_replace(array("'"), "''", $custom_name));

    $custom_value = ucfirst($this->input->post('custom_value'));
    $custom_value = trim(str_replace("  ", ' ', $custom_value));
    $custom_value = trim(str_replace(array("'"), "''", $custom_value));
    $selectionMode = $this->input->post('selectionMode');
    $catalogue_only = $this->input->post('catalogue_only');
    $maxValue = $this->input->post('maxValue');     
    $comma = ',';
    date_default_timezone_set("America/Chicago");
    $current_date = date("Y-m-d H:i:s");
    $current_date = "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";  

    $query = $this->db2->query("SELECT SPECIFIC_NAME FROM CATEGORY_SPECIFIC_MT WHERE SPECIFIC_NAME = '$custom_name' AND EBAY_CATEGORY_ID = $cat_id"); 
    if($query->num_rows() >0){
        return false;
    }else{

      $get_mt_pk = $this->db2->query("SELECT get_single_primary_key('CATEGORY_SPECIFIC_MT','MT_ID') SPECIFICS_MT_ID FROM DUAL");
      $get_mt_pk = $get_mt_pk->result_array();
      $specifics_mt_id = $get_mt_pk[0]['SPECIFICS_MT_ID'];

        $ins_mt_qry = "INSERT INTO CATEGORY_SPECIFIC_MT(MT_ID, EBAY_CATEGORY_ID, SPECIFIC_NAME, MARKETPLACE_ID, MAX_VALUE, MIN_VALUE, SELECTION_MODE, UPDATE_DATE, CUSTOM, CATALOGUE_ONLY) VALUES ($specifics_mt_id $comma $cat_id $comma '$custom_name' $comma 1 $comma $maxValue $comma 1 $comma '$selectionMode' $comma $current_date $comma 1 $comma $catalogue_only)";
        $ins_mt_qry = $this->db2->query($ins_mt_qry);

      $get_det_pk = $this->db2->query("SELECT get_single_primary_key('CATEGORY_SPECIFIC_DET','DET_ID') SPECIFICS_DET_ID FROM DUAL");
      $get_det_pk = $get_det_pk->result_array();
      $specifics_det_id = $get_det_pk[0]['SPECIFICS_DET_ID'];              
      
        $ins_det_qry = "INSERT INTO CATEGORY_SPECIFIC_DET VALUES ($specifics_det_id $comma $specifics_mt_id $comma '$custom_value')";
        $ins_det_qry = $this->db2->query($ins_det_qry);
    }
  }

  public function tableView(){
    $bd_category = $this->input->post('bd_category');
    var_dump($bd_category);exit;
    $mpn = $this->session->userdata('mpn');
    $query = $this->db2->query("SELECT CG.CATALOGUE_GROUP_VALUE, MT.SPECIFIC_NAME, DT.SPECIFIC_VALUE FROM LZ_CATALOGUE_MT       CM, LZ_CATALOGUE_DET      CD, LZ_CATALOGUE_GROUP_MT CG, CATEGORY_SPECIFIC_DET DT, CATEGORY_SPECIFIC_MT  MT WHERE CM.CATALOGUE_MT_ID = CD.CATALOGUE_MT_ID AND CD.CATALOGUE_GROUP_ID = CG.CATALOGUE_GROUP_ID AND MT.MT_ID = DT.MT_ID AND CD.SPECIFIC_DET_ID = DT.DET_ID AND CM.MPN = $mpn AND CM.CATEGORY_ID = $bd_category");
    return $query->result->array();
  }
  public function alternateValue(){
      $det_id = $this->input->post('det_id');
      $alt = $this->db2->query("SELECT * FROM LZ_BD_SPECS_ALT_VAL V WHERE V.DET_ID=$det_id");
      $original = $this->db2->query("SELECT * FROM CATEGORY_SPECIFIC_DET WHERE DET_ID = $det_id");
      $alt = $alt->result_array();
      $original = $original->result_array();

      return array('alt'=>$alt,'original'=>$original);
  }

  public function getGroupName(){
     $group_qry = $this->db2->query("SELECT * FROM LZ_CATALOGUE_GROUP_MT");
     $group_qry =  $group_qry->result_array();
     return $group_qry;
  }
/*==============================================================
=            Load data table on click search button            =
==============================================================*/





  public function loadData(){
    $requestData= $_REQUEST;
    $category = $this->input->post("category");
    $category = (int)$category;
    // var_dump($category);exit;
    $columns = array( 
    // datatable column index  => database column name
      
      0 =>'MPN',
      1 =>'INSERTED_DATE',
      2 =>'INSERTED_BY'
      
    );
    

    $sql = "SELECT CATALOGUE_MT_ID,MPN,CATEGORY_ID,TO_CHAR(INSERTED_DATE, 'MM/DD/YYYY ') as CAT_DATE,INSERTED_BY  FROM LZ_CATALOGUE_MT WHERE CATEGORY_ID = $category";
 

      if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" AND ( MPN LIKE '%".$requestData['search']['value']."%' )";
          
      }else{
        if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" AND (MPN LIKE '%".$requestData['search']['value']."%')";
          
        }
      }

    $query = $this->db2->query($sql);
    $totalData = $query->num_rows();
    $totalFiltered = $totalData;
    //$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
     // when there is a search parameter then we have to modify total number filtered rows as per search result. 
     $sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
    //$sql="SELECT * FROM ($sql) WHERE ROWNUM <= 100"; 
    $sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($sql) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'] ;
    // echo $sql;
    /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
    //$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
    /*=======================================
    =            For Oracle 12-c            =
    =======================================*/
      // $sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($sql) q ) OFFSET ".$requestData['start']." ROWS FETCH NEXT ".$requestData['length']."ROWS ONLY" ;
    
    
    /*=====  End of For Oracle 12-c  ======*/
    

    
    $query = $this->db2->query($sql);

    $query = $query->result_array();
    $data = array();
   
    
    foreach($query as $row ){ 
      $nestedData=array();

      $nestedData[] ='  <div style="float:left;margin-right:8px;">
                                
                              <a title="Edit Record" href="'.base_url().'catalogue/c_itemCatalogue/editCatalogue/'.$row['CATALOGUE_MT_ID'].'" class="btn btn-warning btn-xs" target="_blank"><span class="glyphicon glyphicon-pencil p-b-5" aria-hidden="true"></span>
                              </a>
                              <button title="Delete Record" id="del'.$row['CATALOGUE_MT_ID'].'" class=" del_mpn_data btn btn-danger btn-xs "><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                              </button>
                            
                              <a class="catalogues_detail" id="'.$row['CATALOGUE_MT_ID'].'" title="Show_Detail"><i style="font-size:21px;margin-top:px; cursor: pointer;" class="fa fa-external-link" aria-hidden="true"></i></a>
                        </div>';

    
      $nestedData[] = $row["MPN"];
     
      $nestedData[] = $row["CAT_DATE"];

      $lister = $row["INSERTED_BY"];

      if($lister == ''){
        $nestedData[]= '';
      }else{
        $result = $this->db2->query("SELECT T.USER_NAME FROM EMPLOYEE_MT T WHERE T.EMPLOYEE_ID= $lister");
        $result =  $result->result_array();
        $nestedData[] = $result[0]['USER_NAME'];
      }
      
      // $name = '';
      // foreach ($result as $listerName) {
      //   $name.=$listerName['USER_NAME'];
      // }
      
      
      // $nestedData[]= $row["INSERTED_BY"];
      // var_dump($result);exit;
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

  /*=====  End of Load data table on click search button  ======*/

  // public function deleteCatalogue($cat_mt_id){
  //     $del_qry_det = $this->db2->query("DELETE FROM LZ_CATALOGUE_DET D WHERE D.CATALOGUE_MT_ID = $cat_mt_id");

  //     $del_qry_mt = $this->db2->query("DELETE FROM LZ_CATALOGUE_MT M WHERE M.CATALOGUE_MT_ID = $cat_mt_id");

  //       if($del_qry_mt){

  //         $this->session->set_flashdata('deleted', 'Record Deleted Successfully.');

  //       }else{
  //         $this->session->set_flashdata('del_error', 'Record Not Deleted.');
  //       }       

  // }

/*=========================================================
=            Delete Row on Catalogue List View            =
=========================================================*/





   public function deleteCatalogue(){
      $cat_mt_id = $this->input->post('deleteID');
      $del_qry_det = $this->db2->query("DELETE FROM LZ_CATALOGUE_DET D WHERE D.CATALOGUE_MT_ID = $cat_mt_id");

      $del_qry_mt = $this->db2->query("DELETE FROM LZ_CATALOGUE_MT M WHERE M.CATALOGUE_MT_ID = $cat_mt_id");

        if($del_qry_mt){

          return 1;

        }else{
          return 0;
        }       

  }
/*=====  End of Delete Row on Catalogue List View  ======*/

/*===================================================================
=            Show detail of a row in Catalogue List View            =
===================================================================*/


  public function showCatalogueDetail(){
    $mt_id = $this->input->post('$id');
    $mt_id = (int)$mt_id;
    // var_dump($mt_id);exit;
    $catalogue_detail_qry = "SELECT D.CATALOGUE_MT_ID, C.MPN,C.CATEGORY_ID,C.OBJECT_ID,C.INSERTED_BY,TO_CHAR(INSERTED_DATE, 'MM/DD/YYYY ') as INSERT_DATE, G.CATALOGUE_GROUP_VALUE,G.CATALOGUE_GROUP_ID, S.SPECIFIC_VALUE,S.DET_ID,M.SPECIFIC_NAME,O.OBJECT_NAME FROM LZ_CATALOGUE_DET      D, LZ_CATALOGUE_MT       C, LZ_CATALOGUE_GROUP_MT G, CATEGORY_SPECIFIC_DET S,CATEGORY_SPECIFIC_MT M,LZ_BD_OBJECTS_MT O WHERE C.CATALOGUE_MT_ID = D.CATALOGUE_MT_ID AND G.CATALOGUE_GROUP_ID = D.CATALOGUE_GROUP_ID AND S.DET_ID = D.SPECIFIC_DET_ID AND S.MT_ID = M.MT_ID AND D.CATALOGUE_MT_ID = $mt_id AND C.OBJECT_ID = O.OBJECT_ID ORDER BY G.CATALOGUE_GROUP_ID";

    $catalogue_group_count = "SELECT CATALOGUE_GROUP_ID,CATALOGUE_GROUP_VALUE,COUNT(1) ROW_SPAN FROM(SELECT D.CATALOGUE_MT_ID, C.MPN, G.CATALOGUE_GROUP_VALUE,G.CATALOGUE_GROUP_ID, S.SPECIFIC_VALUE,S.DET_ID FROM LZ_CATALOGUE_DET      D, LZ_CATALOGUE_MT       C, LZ_CATALOGUE_GROUP_MT G, CATEGORY_SPECIFIC_DET S WHERE C.CATALOGUE_MT_ID = D.CATALOGUE_MT_ID AND G.CATALOGUE_GROUP_ID = D.CATALOGUE_GROUP_ID AND S.DET_ID = D.SPECIFIC_DET_ID AND D.CATALOGUE_MT_ID = $mt_id ) GROUP BY CATALOGUE_GROUP_ID,CATALOGUE_GROUP_VALUE ORDER BY CATALOGUE_GROUP_ID";


      $catalogue_detail = $this->db2->query($catalogue_detail_qry);
      $catalogue_data = $catalogue_detail->result_array();
      $groupCount = $this->db2->query( $catalogue_group_count);
      $groupCount_data = $groupCount->result_array();
      return  array('catalogue_data'=>$catalogue_data, 'groupCount'=>$groupCount_data);
  }
 /*=====  End of Show detail of a row in Catalogue List View  ======*/

 /*=================================================================
 =            edit Fields on catalogue detail view list            =
 =================================================================*/

 
  public function editCatalogue($cat_mt_id){
    $catalogue_detail_qry = "SELECT D.CATALOGUE_MT_ID, C.MPN, G.CATALOGUE_GROUP_VALUE,G.CATALOGUE_GROUP_ID, S.SPECIFIC_VALUE,S.DET_ID,M.SPECIFIC_NAME FROM LZ_CATALOGUE_DET      D, LZ_CATALOGUE_MT       C, LZ_CATALOGUE_GROUP_MT G, CATEGORY_SPECIFIC_DET S,CATEGORY_SPECIFIC_MT M WHERE C.CATALOGUE_MT_ID = D.CATALOGUE_MT_ID AND G.CATALOGUE_GROUP_ID = D.CATALOGUE_GROUP_ID AND S.DET_ID = D.SPECIFIC_DET_ID AND S.MT_ID = M.MT_ID AND D.CATALOGUE_MT_ID = $cat_mt_id ORDER BY G.CATALOGUE_GROUP_ID";

    $catalogue_group_count = "SELECT CATALOGUE_GROUP_ID,CATALOGUE_GROUP_VALUE,COUNT(1) ROW_SPAN FROM(SELECT D.CATALOGUE_MT_ID, C.MPN, G.CATALOGUE_GROUP_VALUE,G.CATALOGUE_GROUP_ID, S.SPECIFIC_VALUE,S.DET_ID FROM LZ_CATALOGUE_DET      D, LZ_CATALOGUE_MT       C, LZ_CATALOGUE_GROUP_MT G, CATEGORY_SPECIFIC_DET S WHERE C.CATALOGUE_MT_ID = D.CATALOGUE_MT_ID AND G.CATALOGUE_GROUP_ID = D.CATALOGUE_GROUP_ID AND S.DET_ID = D.SPECIFIC_DET_ID AND D.CATALOGUE_MT_ID = $cat_mt_id ) GROUP BY CATALOGUE_GROUP_ID,CATALOGUE_GROUP_VALUE ORDER BY CATALOGUE_GROUP_ID";


      $catalogue_detail = $this->db2->query($catalogue_detail_qry);
      $catalogue_data = $catalogue_detail->result_array();
      $groupCount = $this->db2->query( $catalogue_group_count);
      $groupCount_data = $groupCount->result_array();
      return  array('catalogue_data'=>$catalogue_data, 'groupCount'=>$groupCount_data);
  }

 /*=====  End of edit Fields on catalogue detail view list  ======*/

 /*==============================================================================================
 =            Show filled Data on click of edit button on catalogue detail list view            =
 ==============================================================================================*/
 
 
 
 
 
  public function getCategorySpecificsEdit(){
    $mt_id = $this->uri->segment(4);
    $catalogue_qry = $this->db2->query("SELECT CATEGORY_ID,MPN FROM LZ_CATALOGUE_MT WHERE CATALOGUE_MT_ID = $mt_id");

    $catalogue_qry = $catalogue_qry->result_array();
    $cat_id = $catalogue_qry[0]["CATEGORY_ID"];
    $mt_query = $this->db2->query("SELECT * FROM CATEGORY_SPECIFIC_MT  M WHERE M.EBAY_CATEGORY_ID = $cat_id"); 
    $mt_query =  $mt_query->result_array();

    $group_qry = $this->db2->query("SELECT * FROM LZ_CATALOGUE_GROUP_MT");
    $group_qry =  $group_qry->result_array();

    // $det_query = $this->db2->query("SELECT * FROM  CATEGORY_SPECIFIC_DET D WHERE D.MT_ID IN (SELECT MT_ID FROM CATEGORY_SPECIFIC_MT  M WHERE M.EBAY_CATEGORY_ID = $cat_id)");

    // $det_query =  $det_query->result_array();

    return array('mt_query' => $mt_query, 'group_qry'=>$group_qry,'catalogue_qry'=>$catalogue_qry);
  }

  public function editData(){
    $catalogue_mt_id = $this->input->post('$id');
    $specifics_det_id = $this->input->post('btnID');

    $sql = $this->db2->query("SELECT SD.DET_ID,SD.SPECIFIC_VALUE, SM.MT_ID, SM.SPECIFIC_NAME, CD.CATALOGUE_DET_ID, CD.CATALOGUE_GROUP_ID, CG.CATALOGUE_GROUP_VALUE FROM CATEGORY_SPECIFIC_MT  SM, CATEGORY_SPECIFIC_DET SD, LZ_CATALOGUE_DET      CD, LZ_CATALOGUE_MT       CM, LZ_CATALOGUE_GROUP_MT CG WHERE CM.CATALOGUE_MT_ID = $catalogue_mt_id AND SD.DET_ID = $specifics_det_id AND  CD.SPECIFIC_DET_ID = SD.DET_ID AND SD.MT_ID = SM.MT_ID AND CD.CATALOGUE_GROUP_ID = CG.CATALOGUE_GROUP_ID AND CD.CATALOGUE_MT_ID = CM.CATALOGUE_MT_ID AND CD.SPECIFIC_DET_ID = SD.DET_ID");
    $sql = $sql->result_array();
    return $sql;
  }
/*=====  End of Show filled Data on click of edit button on catalogue detail list view  ======*/
/*=========================================================
=            update catalogue detail list view            =
=========================================================*/



  public function updateCatalogueDetail(){
    $specval = $this->input->post('specVal');
    $cat_det_id  = $this->input->post('det_id');
    $qry = $this->db2->query("UPDATE LZ_CATALOGUE_DET SET SPECIFIC_DET_ID = $specval WHERE CATALOGUE_DET_ID = $cat_det_id");
    if($qry){
      return 1;
    }
    else{
      return 0;
    }
  }
/*=====  End of update catalogue detail list view  ======*/

/*=============================================
=           Delete row in catalogue detail list view           =
=============================================*/

  public function deleteCatalogueDetail(){
    $catalogue_mt_id = $this->input->post('$id');
    $specifics_det_id = $this->input->post('btnID');
    $qry = $this->db2->query("DELETE FROM LZ_CATALOGUE_DET WHERE SPECIFIC_DET_ID = $specifics_det_id AND CATALOGUE_MT_ID = $catalogue_mt_id");
    if($qry){
      return 1;
    }
    else{
      return 0;
    }
  }

  /*=====  End of Section comment block  ======*/

  public function saveCustomAttribute(){

    // $cat_id = $this->input->post('cat_id');
    $custom_attribute = $this->input->post('custom_attribute');
    $mt_id = $this->input->post('mt_id');
    $custom_attribute = ucfirst($this->input->post('custom_attribute'));
    $custom_attribute = trim(str_replace("  ", ' ', $custom_attribute));
    $custom_attribute = trim(str_replace(array("'"), "''", $custom_attribute));

    $comma = ',';
    $query = $this->db2->query("SELECT SPECIFIC_VALUE FROM CATEGORY_SPECIFIC_DET D WHERE D.MT_ID = $mt_id AND upper(SPECIFIC_VALUE) = upper('$custom_attribute')"); 
    if($query->num_rows() >0){
        return false;
    }else{
     
      // $mt_id = $get_mt_id[0]['MT_ID'];

      $get_det_pk = $this->db2->query("SELECT get_single_primary_key('CATEGORY_SPECIFIC_DET','DET_ID') SPECIFICS_DET_ID FROM DUAL");
      $get_det_pk = $get_det_pk->result_array();
      $specifics_det_id = $get_det_pk[0]['SPECIFICS_DET_ID'];
      
        $ins_det_qry = "INSERT INTO CATEGORY_SPECIFIC_DET VALUES ($specifics_det_id $comma $mt_id $comma '$custom_attribute')";
        $ins_det_qry = $this->db2->query($ins_det_qry);
    }    


    
  } 
  public function getCatGroups(){
    return $query = $this->db2->query("SELECT M.LZ_BD_GROUP_ID, M.GROUP_NAME FROM LZ_BD_CAT_GROUP_MT M")->result_array();  
  }

}

 ?>