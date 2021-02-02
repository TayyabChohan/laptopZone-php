<?php  
  class M_unverified extends CI_Model{

    public function __construct(){
    parent::__construct();
    $this->load->database();
  }

    public function get_mastermpn(){
      $ct_category = $this->input->post('ct_category');
      $brand_name = strtoupper($this->input->post('brand_name'));      
      //$mpnList = $this->db2->query("SELECT M.CATALOGUE_MT_ID, M.MPN FROM LZ_CATALOGUE_MT M, LZ_CATALOGUE_DET D, CATEGORY_SPECIFIC_MT  CM, CATEGORY_SPECIFIC_DET CD WHERE M.CATALOGUE_MT_ID = D.CATALOGUE_MT_ID AND CM.MT_ID = CD.MT_ID AND CD.DET_ID = D.SPECIFIC_DET_ID AND UPPER(CM.SPECIFIC_NAME) = 'BRAND' AND CD.DET_ID = $det_id AND M.CATEGORY_ID = $ct_category");
      $mpnList = $this->db2->query("SELECT MT.CATALOGUE_MT_ID,MT.MPN FROM LZ_CATALOGUE_MT MT WHERE UPPER(MT.MPN_DESCRIPTION) LIKE '%$brand_name%' AND MT.CATEGORY_ID = $ct_category AND MT.MPN NOT LIKE '%DELETED%'");
       
      return $mpnList->result_array();

    }
    public function get_brands($cat_id){
      
      $objectList = $this->db2->query("SELECT DISTINCT CD.DET_ID, CM. SPECIFIC_NAME, CD. SPECIFIC_VALUE FROM LZ_CATALOGUE_MT       M, LZ_CATALOGUE_DET      D, CATEGORY_SPECIFIC_MT  CM, CATEGORY_SPECIFIC_DET CD WHERE M.CATALOGUE_MT_ID = D.CATALOGUE_MT_ID AND CM.MT_ID = CD.MT_ID AND UPPER(CM.SPECIFIC_NAME) = 'BRAND' AND CD.DET_ID = D.SPECIFIC_DET_ID AND M.CATEGORY_ID = $cat_id"); 
      return $objectList->result_array();

    }    
  public function verifyMPN(){
    $ct_category = $this->input->post('ct_category');
    $verifiedmpn = $this->input->post('verifiedmpn');
    $selectedCheckbox = $this->input->post('selectedCheckbox');
    $cata_id_val = $this->input->post('cata_id_val');

    foreach($selectedCheckbox as $index => $code){
      $query = $this->db2->query("UPDATE LZ_BD_ACTIVE_DATA_$ct_category SET CATALOGUE_MT_ID = $verifiedmpn, VERIFIED = 1 WHERE LZ_BD_CATA_ID =". $cata_id_val[$index]." ");
    }
    if($query){
      return 1;
    }else{
      return 0;
    }

  }
  
}
