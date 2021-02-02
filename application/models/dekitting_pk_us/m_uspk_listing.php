<?php  

	class M_uspk_listing extends CI_Model{

		public function __construct(){
		parent::__construct();
		$this->load->database();
	}

   public function get_emp(){

    $qyer =$this->db->query("SELECT M.EMPLOYEE_ID,M.USER_NAME FROM EMPLOYEE_MT M WHERE M.LOCATION = 'PK' AND M.STATUS =1 ")->result_array();

    return  array('qyer' => $qyer );


     }

public function nonListedTable(){
    $requestData= $_REQUEST;

    $columns = array(
        0 =>'', 
        1 =>'', 
        2 =>'BUISNESS_NAME',
        3 =>'VERIFY_BY',
        4 =>'OTHER_NOTES',
        5 =>'',
        6 =>'BARCODE_PRV_NO',
        7 =>'OBJECT_DESCRIP',
        8 =>'ITEM_CONDITION',
        9 =>'ITEM_MT_DESC',
        10 =>'QUANTITY',
        11 =>'MFG_PART_NO',
        12 =>'MANUFACTURER',
        13 =>'BIN_NAME',
        14 =>'LOADING_DATE',
        15 => 'ASSIGN_TO'
      );
    /////////////////////////////////////
       $this->session->unset_userdata('listing_options');
        $posts    = $this->input->post('listing_options');
        $get_emp    = $this->input->post('get_emp');
          // var_dump($get_emp); exit;
          $this->session->set_userdata('listing_options', $posts);
          $itemData =  $this->session->userdata('listing_options');

      //     $emp_id =   $this->session->userdata('user_id');

      $get_user_q = $this->db->query("SELECT upper(USER_NAME) USER_NAME FROM EMPLOYEE_MT WHERE EMPLOYEE_ID = '$get_emp'")->result_array();
      $get_user_id = @$get_user_q[0]['USER_NAME'];
      // $employee_id = $get_user_q[0]['EMPLOYEE_ID'];

      

$serc = strtoupper($requestData['search']['value']);
    if(!empty($serc)){
      $bracket = " )";
      $simple_query = "";
    }else{
      $bracket = " ";
      $simple_query = " )";
    }
    if($itemData == 1 || $posts == 1){
       $sql = "SELECT * FROM (SELECT LS.SEED_ID,(SELECT M.USER_NAME FROM EMPLOYEE_mT M WHERE M.EMPLOYEE_ID = DET.IDENTIFIED_BY)VERIFY_BY,DECODE(((SELECT * FROM (SELECT M.USER_NAME FROM LZ_LISTING_ALLOC L,EMPLOYEE_MT M WHERE L.SEED_ID = LS.SEED_ID AND L.LISTER_ID = M.EMPLOYEE_ID ORDER BY L.ALLOC_ID DESC) WHERE  ROWNUM<=1)), NULL, 'NOT ASSIGNED', ((SELECT * FROM (SELECT M.USER_NAME FROM LZ_LISTING_ALLOC L,EMPLOYEE_MT M WHERE L.SEED_ID = LS.SEED_ID AND L.LISTER_ID = M.EMPLOYEE_ID ORDER BY L.ALLOC_ID DESC) WHERE  ROWNUM<=1))) ASSIGN_TO, BB.BARCODE_NO, DET.BARCODE_PRV_NO, LS.ENTERED_BY, E.USER_NAME, LS.SHIPPING_SERVICE, LS.OTHER_NOTES, LS.LZ_MANIFEST_ID, LM.LOADING_DATE, LM.PURCH_REF_NO, LS.ITEM_TITLE ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_ID, I.ITEM_CODE, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_UPC UPC, BB.BIN_ID, BM.BIN_TYPE || '-' || BM.BIN_NO BIN_NAME, O.OBJECT_NAME OBJECT_DESCRIP, C.COND_NAME ITEM_CONDITION, '1' QUANTITY,DET.BARCODE_PRV_NO FOLDER_NAME FROM LZ_BARCODE_MT   BB, LZ_DEKIT_US_DT  DET, LZ_MANIFEST_DET MDET, ITEMS_MT        I, LZ_ITEM_SEED    LS, LZ_MANIFEST_MT  LM, BIN_MT          BM, LZ_ITEM_COND_MT C, LZ_BD_OBJECTS_MT O, EMPLOYEE_MT E WHERE BB.BARCODE_NO = DET.BARCODE_PRV_NO AND DET.LZ_MANIFEST_DET_ID = MDET.LAPTOP_ZONE_ID AND LM.LZ_MANIFEST_ID = MDET.LZ_MANIFEST_ID AND LS.DEFAULT_COND = BB.CONDITION_ID AND LS.ITEM_ID = BB.ITEM_ID AND LS.LZ_MANIFEST_ID = BB.LZ_MANIFEST_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND C.ID = DET.CONDITION_ID AND BB.ITEM_ID = I.ITEM_ID AND O.OBJECT_ID = DET.OBJECT_ID AND LS.ENTERED_BY = E.EMPLOYEE_ID(+) AND BB.EBAY_ITEM_ID IS NULL AND BB.BIN_ID = BM.BIN_ID AND BB.DISCARD=0 ".$simple_query; 
       if(!empty($get_emp)){
            $sql .=" where upper(assign_to) = '$get_user_id'";
            }

          // if($employee_id != '21' && $employee_id != '22' ){
          // $sql.= " WHERE UPPER(ASSIGN_TO)='".$get_user_id."'";

          // }

     }elseif ($itemData == 2 || $posts == 2) {

      $sql = "SELECT * FROM (SELECT LS.SEED_ID, (SELECT M.USER_NAME FROM EMPLOYEE_MT M WHERE M.EMPLOYEE_ID =L.UPDATED_BY )VERIFY_BY,DECODE(((SELECT * FROM (SELECT M.USER_NAME FROM LZ_LISTING_ALLOC L,EMPLOYEE_MT M WHERE L.SEED_ID = LS.SEED_ID AND L.LISTER_ID = M.EMPLOYEE_ID ORDER BY L.ALLOC_ID DESC) WHERE  ROWNUM<=1)), NULL, 'NOT ASSIGNED', ((SELECT * FROM (SELECT M.USER_NAME FROM LZ_LISTING_ALLOC L,EMPLOYEE_MT M WHERE L.SEED_ID = LS.SEED_ID AND L.LISTER_ID = M.EMPLOYEE_ID ORDER BY L.ALLOC_ID DESC) WHERE  ROWNUM<=1))) ASSIGN_TO,BB.BARCODE_NO, L.BARCODE_PRV_NO, LS.ENTERED_BY, E.USER_NAME, LS.SHIPPING_SERVICE, LS.OTHER_NOTES, LS.LZ_MANIFEST_ID, LM.LOADING_DATE, LM.PURCH_REF_NO, LS.ITEM_TITLE ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_ID, I.ITEM_CODE, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_UPC UPC, BB.BIN_ID, BM.BIN_TYPE || '-' || BM.BIN_NO BIN_NAME, O.OBJECT_NAME OBJECT_DESCRIP, C.COND_NAME ITEM_CONDITION, '1' QUANTITY,L.FOLDER_NAME FROM LZ_BARCODE_MT   BB, LZ_SPECIAL_LOTS L, LZ_MANIFEST_DET MDET, ITEMS_MT        I, LZ_ITEM_SEED    LS, LZ_MANIFEST_MT  LM, BIN_MT          BM, LZ_ITEM_COND_MT C, LZ_BD_OBJECTS_MT O, EMPLOYEE_MT E WHERE BB.BARCODE_NO = L.BARCODE_PRV_NO AND L.LZ_MANIFEST_DET_ID = MDET.LAPTOP_ZONE_ID AND LM.LZ_MANIFEST_ID = MDET.LZ_MANIFEST_ID AND LS.DEFAULT_COND = BB.CONDITION_ID AND LS.ITEM_ID = BB.ITEM_ID AND LS.LZ_MANIFEST_ID = BB.LZ_MANIFEST_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND BB.ITEM_ID = I.ITEM_ID AND C.ID = L.CONDITION_ID AND O.OBJECT_ID = L.OBJECT_ID AND LS.ENTERED_BY = E.EMPLOYEE_ID(+) AND BB.EBAY_ITEM_ID IS NULL AND BB.BIN_ID = BM.BIN_ID AND BB.DISCARD=0 ".$simple_query ;

      if(!empty($get_emp)){
            $sql .=" where upper(assign_to) = '$get_user_id'";
            }

        // if($employee_id != '21' && $employee_id != '22' ){
        //   $sql.= " WHERE UPPER(ASSIGN_TO)='".$get_user_id."'";

        //   }


    }
    elseif ($itemData == 3 || $posts == 3) {

      $sql = "SELECT *  FROM (SELECT LS.SEED_ID, (SELECT M.USER_NAME FROM EMPLOYEE_MT M WHERE M.EMPLOYEE_ID =L.UPDATED_BY )VERIFY_BY,DECODE(((SELECT * FROM (SELECT M.USER_NAME FROM LZ_LISTING_ALLOC L,EMPLOYEE_MT M WHERE L.SEED_ID = LS.SEED_ID AND L.LISTER_ID = M.EMPLOYEE_ID ORDER BY L.ALLOC_ID DESC) WHERE  ROWNUM<=1)), NULL, 'NOT ASSIGNED', ((SELECT * FROM (SELECT M.USER_NAME FROM LZ_LISTING_ALLOC L,EMPLOYEE_MT M WHERE L.SEED_ID = LS.SEED_ID AND L.LISTER_ID = M.EMPLOYEE_ID ORDER BY L.ALLOC_ID DESC) WHERE  ROWNUM<=1))) ASSIGN_TO,BB.BARCODE_NO, L.BARCODE_PRV_NO, LS.ENTERED_BY, E.USER_NAME, LS.SHIPPING_SERVICE, LS.OTHER_NOTES, LS.LZ_MANIFEST_ID, LM.LOADING_DATE, LM.PURCH_REF_NO, LS.ITEM_TITLE ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_ID, I.ITEM_CODE, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_UPC UPC, BB.BIN_ID, BM.BIN_TYPE || '-' || BM.BIN_NO BIN_NAME, O.OBJECT_NAME OBJECT_DESCRIP, C.COND_NAME ITEM_CONDITION, '1' QUANTITY,L.FOLDER_NAME FROM LZ_BARCODE_MT   BB, LZ_SPECIAL_LOTS L, LZ_MANIFEST_DET MDET, ITEMS_MT        I, LZ_ITEM_SEED    LS, LZ_MANIFEST_MT  LM, BIN_MT          BM, LZ_ITEM_COND_MT C, LZ_BD_OBJECTS_MT O, EMPLOYEE_MT E WHERE BB.BARCODE_NO = L.BARCODE_PRV_NO AND L.LZ_MANIFEST_DET_ID = MDET.LAPTOP_ZONE_ID AND LM.LZ_MANIFEST_ID = MDET.LZ_MANIFEST_ID AND LS.DEFAULT_COND = BB.CONDITION_ID AND LS.ITEM_ID = BB.ITEM_ID AND LS.LZ_MANIFEST_ID = BB.LZ_MANIFEST_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND BB.ITEM_ID = I.ITEM_ID AND C.ID = L.CONDITION_ID AND O.OBJECT_ID = L.OBJECT_ID AND LS.ENTERED_BY = E.EMPLOYEE_ID(+) AND BB.EBAY_ITEM_ID IS NULL AND BB.BIN_ID = BM.BIN_ID AND BB.DISCARD=0 ".$simple_query." WHERE BARCODE_NO IN (SELECT LG.BARCODE_NO FROM LJ_AGINIG_ITEM_LOG LG GROUP BY LG.BARCODE_NO )"; 
      if(!empty($get_emp)){
            $sql .=" where upper(assign_to) = '$get_user_id'";
            }

        // if($employee_id != '21' && $employee_id != '22' ){
        //   $sql.= " WHERE UPPER(ASSIGN_TO)='".$get_user_id."'";

        //   }


    }elseif($itemData == 0 || $posts == 0) {
            $dekit_search =''; 

            if(!empty($serc) && $posts == 0){
            $dekit_search.=" AND (upper(BARCODE_PRV_NO) LIKE '%".$serc."%' ";       
            $dekit_search.=" OR upper(LS.OTHER_NOTES) LIKE '%".$serc."%' ";    
            $dekit_search.=" OR upper(LS.ITEM_TITLE) LIKE '%".$serc."%' ";     
            $dekit_search.=" OR upper(I.ITEM_MT_MFG_PART_NO) LIKE '%".$serc."%' "; 
            $dekit_search.=" OR upper(BM.BIN_TYPE || '-' || BM.BIN_NO) LIKE '%".$serc."%' ";  
            $dekit_search.=" OR upper(I.ITEM_MT_MANUFACTURE) LIKE '%".$serc."%')"; 
          }

          $lot_search ='';
          if(!empty($serc) && $posts == 0){
            $lot_search.=" AND (upper(BARCODE_PRV_NO) LIKE '%".$serc."%' ";       
            $lot_search.=" OR upper(LS.OTHER_NOTES) LIKE '%".$serc."%' ";    
            $lot_search.=" OR upper(LS.ITEM_TITLE) LIKE '%".$serc."%' ";     
            $lot_search.=" OR upper(I.ITEM_MT_MFG_PART_NO) LIKE '%".$serc."%' ";  
            $lot_search.=" OR upper(L.CARD_MPN) LIKE '%".$serc."%' ";  
            $lot_search.=" OR upper(BM.BIN_TYPE || '-' || BM.BIN_NO) LIKE '%".$serc."%' ";  
            $lot_search.=" OR upper(I.ITEM_MT_MANUFACTURE) LIKE '%".$serc."%' "; 
            $lot_search.=" OR upper(L.BRAND) LIKE '%".$serc."%' )".$bracket; 
          }
          $sql = "SELECT * FROM (SELECT LS.SEED_ID,(SELECT M.USER_NAME FROM EMPLOYEE_MT M WHERE M.EMPLOYEE_ID = DET.IDENTIFIED_BY)VERIFY_BY,DECODE(((SELECT * FROM (SELECT M.USER_NAME FROM LZ_LISTING_ALLOC L,EMPLOYEE_MT M WHERE L.SEED_ID = LS.SEED_ID AND L.LISTER_ID = M.EMPLOYEE_ID ORDER BY L.ALLOC_ID DESC) WHERE  ROWNUM<=1)), NULL, 'NOT ASSIGNED', ((SELECT * FROM (SELECT M.USER_NAME FROM LZ_LISTING_ALLOC L,EMPLOYEE_MT M WHERE L.SEED_ID = LS.SEED_ID AND L.LISTER_ID = M.EMPLOYEE_ID ORDER BY L.ALLOC_ID DESC) WHERE  ROWNUM<=1))) ASSIGN_TO, BB.BARCODE_NO, DET.BARCODE_PRV_NO, LS.ENTERED_BY, E.USER_NAME, LS.SHIPPING_SERVICE, LS.OTHER_NOTES, LS.LZ_MANIFEST_ID, LM.LOADING_DATE, LM.PURCH_REF_NO, LS.ITEM_TITLE ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_ID, I.ITEM_CODE, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_UPC UPC, BB.BIN_ID, BM.BIN_TYPE || '-' || BM.BIN_NO BIN_NAME, O.OBJECT_NAME OBJECT_DESCRIP, C.COND_NAME ITEM_CONDITION, '1' QUANTITY,DET.BARCODE_PRV_NO FOLDER_NAME FROM LZ_BARCODE_MT   BB, LZ_DEKIT_US_DT  DET, LZ_MANIFEST_DET MDET, ITEMS_MT        I, LZ_ITEM_SEED    LS, LZ_MANIFEST_MT  LM, BIN_MT          BM, LZ_ITEM_COND_MT C, LZ_BD_OBJECTS_MT O, EMPLOYEE_MT E WHERE BB.BARCODE_NO = DET.BARCODE_PRV_NO AND DET.LZ_MANIFEST_DET_ID = MDET.LAPTOP_ZONE_ID AND LM.LZ_MANIFEST_ID = MDET.LZ_MANIFEST_ID AND LS.DEFAULT_COND = BB.CONDITION_ID AND LS.ITEM_ID = BB.ITEM_ID AND LS.LZ_MANIFEST_ID = BB.LZ_MANIFEST_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND C.ID = DET.CONDITION_ID AND BB.ITEM_ID = I.ITEM_ID AND O.OBJECT_ID = DET.OBJECT_ID AND LS.ENTERED_BY = E.EMPLOYEE_ID(+) AND BB.EBAY_ITEM_ID IS NULL AND BB.BIN_ID = BM.BIN_ID  AND BB.DISCARD=0 ".$dekit_search." ) "; 

            if(!empty($get_emp)){
              $sql .=" where upper(assign_to) = '$get_user_id'";
            }


          $sql .="UNION ALL SELECT * FROM (SELECT  LS.SEED_ID, (SELECT M.USER_NAME FROM EMPLOYEE_MT M WHERE M.EMPLOYEE_ID =L.UPDATED_BY )VERIFY_BY,DECODE(((SELECT * FROM (SELECT M.USER_NAME FROM LZ_LISTING_ALLOC L,EMPLOYEE_MT M WHERE L.SEED_ID = LS.SEED_ID AND L.LISTER_ID = M.EMPLOYEE_ID ORDER BY L.ALLOC_ID DESC) WHERE  ROWNUM<=1)), NULL, 'NOT ASSIGNED', ((SELECT * FROM (SELECT M.USER_NAME FROM LZ_LISTING_ALLOC L,EMPLOYEE_MT M WHERE L.SEED_ID = LS.SEED_ID AND L.LISTER_ID = M.EMPLOYEE_ID ORDER BY L.ALLOC_ID DESC) WHERE  ROWNUM<=1))) ASSIGN_TO,BB.BARCODE_NO, L.BARCODE_PRV_NO, LS.ENTERED_BY, E.USER_NAME, LS.SHIPPING_SERVICE, LS.OTHER_NOTES, LS.LZ_MANIFEST_ID, LM.LOADING_DATE, LM.PURCH_REF_NO, LS.ITEM_TITLE ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_ID, I.ITEM_CODE, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_UPC UPC, BB.BIN_ID, BM.BIN_TYPE || '-' || BM.BIN_NO BIN_NAME, O.OBJECT_NAME OBJECT_DESCRIP, C.COND_NAME ITEM_CONDITION, '1' QUANTITY,L.FOLDER_NAME FROM LZ_BARCODE_MT   BB, LZ_SPECIAL_LOTS L, LZ_MANIFEST_DET MDET, ITEMS_MT   I, LZ_ITEM_SEED    LS, LZ_MANIFEST_MT  LM, BIN_MT          BM, LZ_ITEM_COND_MT C, LZ_BD_OBJECTS_MT O, EMPLOYEE_MT E WHERE BB.BARCODE_NO = L.BARCODE_PRV_NO AND L.LZ_MANIFEST_DET_ID = MDET.LAPTOP_ZONE_ID AND LM.LZ_MANIFEST_ID = MDET.LZ_MANIFEST_ID AND LS.DEFAULT_COND = BB.CONDITION_ID AND LS.ITEM_ID = BB.ITEM_ID AND LS.LZ_MANIFEST_ID = BB.LZ_MANIFEST_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND BB.ITEM_ID = I.ITEM_ID AND C.ID = L.CONDITION_ID AND O.OBJECT_ID = L.OBJECT_ID AND LS.ENTERED_BY = E.EMPLOYEE_ID(+) AND BB.EBAY_ITEM_ID IS NULL AND BB.BIN_ID = BM.BIN_ID  AND BB.DISCARD=0 ".$lot_search.$simple_query;
            
            if(!empty($get_emp)){
              $sql .=" where upper(assign_to) = '$get_user_id'";
            }

          // if($employee_id != 21 && $employee_id != 22 ){
          // $sql.= " WHERE UPPER(ASSIGN_TO)='".$get_user_id."'";

          // }

        }     

    if(!empty($serc) && $posts == 1){
        $sql.=" AND (upper(DET.BARCODE_PRV_NO) LIKE '%".$serc."%' ";   
        $sql.=" OR upper(LS.OTHER_NOTES) LIKE '%".$serc."%' ";    
        $sql.=" OR upper(LS.ITEM_TITLE) LIKE '%".$serc."%' ";     
        $sql.=" OR upper(I.ITEM_MT_MFG_PART_NO) LIKE '%".$serc."%' ";  
        $sql.=" OR upper(BM.BIN_TYPE || '-' || BM.BIN_NO) LIKE '%".$serc."%' ";  
        $sql.=" OR upper(I.ITEM_MT_MANUFACTURE) LIKE '%".$serc."%')".$bracket; 
      }elseif(!empty($serc) && $posts == 2){
        $sql.=" AND (L.BARCODE_PRV_NO LIKE '%".$serc."%' ";   
        $sql.=" OR upper(LS.OTHER_NOTES) LIKE '%".$serc."%' ";    
        $sql.=" OR upper(LS.ITEM_TITLE) LIKE '%".$serc."%' ";     
        $sql.=" OR upper(L.CARD_MPN) LIKE '%".$serc."%' ";  
        $sql.=" OR upper(BM.BIN_TYPE) || '-' || BM.BIN_NO LIKE '%".$serc."%' ";  
        $sql.=" OR upper(L.BRAND) LIKE '%".$serc."%')".$bracket; 
      }
if($posts == 0){
     $sql = "SELECT Q.*, C.BUISNESS_NAME FROM LZ_MERCHANT_BARCODE_MT M , LZ_MERCHANT_BARCODE_DT D , LZ_MERCHANT_MT C , ($sql)Q WHERE M.MT_ID = D.MT_ID AND C.MERCHANT_ID = M.MERCHANT_ID AND D.BARCODE_NO =  Q.BARCODE_PRV_NO";
}
   

    $query = $this->db->query($sql);
    $totalData = $query->num_rows();
    $totalFiltered = $totalData; 

    
    //$sql = "SELECT  * FROM (SELECT  q.*, rownum rn FROM  ($sql) q )";
    $sql = "SELECT  * FROM (SELECT  q.*, rownum rn FROM  ($sql) q )";

    $sql.= " WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'];

    if(!empty($columns[$requestData['order'][0]['column']])) {
      $sql.=" ORDER BY  ".$columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir'];
    }
    
    /*=====  End of For Oracle 12-c  ======*/
    $query = $this->db->query($sql);
    $query = $query->result_array();

    $sl_options = array("USPSParcel", "USPSFirstClass", "USPSPriority","FedExHomeDelivery","USPSPriorityFlatRateEnvelope","USPSPriorityMailSmallFlatRateBox","USPSPriorityFlatRateBox","USPSPriorityMailLargeFlatRateBox","USPSPriorityMailPaddedFlatRateEnvelope","USPSPriorityMailLegalFlatRateEnvelope");

    $path_query = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 2")->result_array();

    // $users = $this->db->query("SELECT T.EMPLOYEE_ID, T.USER_NAME FROM EMPLOYEE_MT T WHERE T.EMPLOYEE_ID IN(4,5,13,14,16,2,18,21,22,23,24,25,26)")->result_array();
    $data = array();
    $i =0;
    foreach($query as $row ){
      $nestedData= array();
      $nestedData[] = '<div style="width: 60px!important;"> <div style="float:left;margin-left:18px;"> <input title="Check to Assign Listing to users" type="checkbox" name="assign_listing_pk[]" id="assign_listing_pk"  value="'.@$row['SEED_ID'].'"" > </div> </div>';
      $it_condition = @$row['ITEM_CONDITION'];

            $master_path = $path_query[0]['MASTER_PATH'];
            $m_dir =  $master_path.$row['FOLDER_NAME']."/thumb/";
            $m_dir = preg_replace("/[\r\n]*/","",$m_dir);
            if(is_dir(@$m_dir)){
              $iterator = new \FilesystemIterator(@$m_dir);
              if (@$iterator->valid()){    
                $m_flag = true;
            }else{
              $m_flag = true;
            }
          }else{
          $m_flag = true;
        }
    if($m_flag): 
      $bar_code = $row['BARCODE_PRV_NO'];
      $confirm = "return confirm('Are you sure?')";
      $nestedData[] = '<div style="width:180px;"><div style="float:left;margin-right:8px;"><button title="Discard" class="btn btn-danger btn-xs flag-discard" style="width: 25px;" id="discard_'.$row['BARCODE_PRV_NO'].'" dBarcode="'.$row['BARCODE_PRV_NO'].'"><i class="fa fa-trash-o text text-center" aria-hidden="true"></i> </button></div> <div style="float:left;margin-right:8px;"> <form action="'.base_url().'dekitting_pk_us/c_to_list_pk/list_item" method="post" accept-charset="utf-8"> <input type="hidden" name="seed_id" class="seed_id" id="seed_id_"'.$i.'" value="'.$row['SEED_ID'].'"/> <input type="submit" name="item_list" title="List to eBay" onclick="'.$confirm.'" class="btn btn-success btn-sm" value="List"> </form> </div> <div style="float:left;margin-right:8px;"> <a href="'.base_url().'dekitting_pk_us/c_to_list_pk/seed_view/'.$row['SEED_ID'].'/'.$bar_code.'" title="Create/Edit Seed" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span></a> </div> <div style="float:left;margin-right:8px;"> <a href="'.base_url().'tolist/c_tolist/seed_view_merg/'.$row['SEED_ID'].'/'.$bar_code.'" title="Create/Edit Seed" class="btn btn-warning btn-sm" target="_blank"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span></a> </div><div style="float:left;margin-right:8px;"><a href="'.base_url().'catalogueToCash/c_dekit_sticker/dekitPrintSingle/'.$row['ITEM_CODE'].'/'.$row['LZ_MANIFEST_ID'].'/'.$bar_code.'" title="Print Sticker" class="btn btn-primary btn-sm" target="_blank"> <span class="glyphicon glyphicon-print" aria-hidden="true"></span></a></div><div class="green_lock"><i  id = "'.$bar_code.'" class="fa fa-lock btn btn-danger btn-sm del_itm" aria-hidden="true"></i></div> </div> </div>';

      $user_id=@$row['ENTERED_BY'];
      $user_name = '';
      //foreach (@$users as $user){
           if(!empty($user_id))
           { 
            if ($user_id==5) {
               $user_name = "<b style='color:red;'>".@$row['USER_NAME'].": </b>";
            }else {
              $user_name = "<b>".@$row['USER_NAME'].": </b>";
            }
          }
        //} 
      $nestedData[]    = @$row['BUISNESS_NAME'];
      $nestedData[]     = $row['VERIFY_BY'];
      $other_note     = $row['OTHER_NOTES'];
      $nestedData[]   = $user_name.$other_note;

       if (is_dir($m_dir)){       
            $images = scandir($m_dir);
            if (count($images) > 2) { // make sure at least one image exists
                $url = $images[2]; // first image
                $img = file_get_contents($m_dir.$url);
                $img =base64_encode($img);
                $nestedData[] = '<div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);cursor: pointer!important;"><img class="sort_img up-img" id="" name="" src="data:image;base64,'.$img.'"/></div>';
            }else{
              $nestedData[] = 'Not Found';
            }
          }else{
            $nestedData[] = 'Not Found';
          }
      $nestedData[]     = '<div style="width:80px;">'.$row['BARCODE_PRV_NO'].'</div>';
      $nestedData[]     = '<div style="width:150px;">'.$row['OBJECT_DESCRIP'].'</div>';
      $nestedData[]     = $row['ITEM_CONDITION'];
      $nestedData[]     = $row['ITEM_MT_DESC'];
      $nestedData[]     = $row['QUANTITY'];
      $nestedData[]     = $row['MFG_PART_NO'];
      $nestedData[]     = $row['MANUFACTURER'];
      ////////////////////////////////////
      /////////////////////////////////////
      $nestedData[]       = $row['BIN_NAME'];
      /////////////////////////////////////
      $current_timestamp = date('m/d/Y');
      $purchase_date = @$row['LOADING_DATE'];
      $date1=date_create($current_timestamp);
      $date2=date_create($purchase_date);
      $diff=date_diff($date1,$date2);
      $date_rslt = $diff->format("%R%a days");
       $nestedData[] =  abs($date_rslt)." Days";
      /////////////////////////////////////
      $nestedData[]     = $row['ASSIGN_TO'];
      $data[]         = $nestedData;
      endif;
      $i++;
    }

    $json_data = array(
          "draw"            => intval( $requestData['draw'] ), 
          // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
          "recordsTotal"    =>  intval($totalData),  // total number of records
          "recordsFiltered" => intval( $totalFiltered ), 
          // total number of records after searching, if there is no searching then totalFiltered = totalData
          "deferLoading"    =>  intval($totalFiltered),
          "data"            => $data   // total data array
          );
    return $json_data; 

  }
public function listedTable(){
	$requestData= $_REQUEST;
	$columns = array( 
      0 =>'BARCODE_NO',
      1 =>'EBAY_ITEM_ID',
      2 =>'BARCODE_NO',
      3 =>'ITEM_CONDITION',
      4 =>'ITEM_MT_DESC',
      5 =>'QUANTITY',
      6 =>'EBAY_PRICE',
      10 =>'MANUFACTURER',
      11 =>'',
      12 =>'USER_NAME',
      13 =>'',
      14 =>'BIN_NAME',
      15 =>'',
      16 =>''
    );
      $searchedData               =  $this->session->unset_userdata('list_location');
        $this->session->unset_userdata('listing_type');
      $location                   = $this->input->post('listing_location');
	    $listing_type_post          = $this->input->post('listing_type');
        $this->session->set_userdata('list_location', $location);
        $this->session->set_userdata('listing_type', $listing_type_post);
        $me_loc                   = $this->session->userdata("list_location");
        $listing_type             = $this->session->userdata("listing_type");

        if (empty($location)) {
          $location = $me_loc;
        }
          if (empty($listing_type_post)) {
          $listType = $listing_type;
        }
        //var_dump($searchedData, $location, $me_loc);

         /*if(!empty($requestData['search']['value'])){
            $bracket = " )";
          }else{
            if (!empty($location)) {
             $bracket = ") ";
             $simple_query = " ";
            }else{
              $simple_query = ") ";
              $bracket = " ";
              $location = "PK";
            }
            
          }*/
        $sql = "SELECT * FROM(SELECT LS.SEED_ID, LS.OTHER_NOTES, LS.LZ_MANIFEST_ID, LS.SHIPPING_SERVICE, E.STATUS, E.LISTER_ID, E.LIST_ID, TO_CHAR(E.LIST_DATE, 'DD-MM-YYYY HH24:MI:SS') AS LIST_DATE, E.LZ_SELLER_ACCT_ID, LS.EBAY_PRICE, LM.PURCH_REF_NO, I.ITEM_ID, LS.ITEM_TITLE ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_UPC UPC, BCD.CONDITION_ID ITEM_CONDITION, BCD.EBAY_ITEM_ID, E.LIST_QTY QUANTITY, E_URL.EBAY_URL, BCD.BARCODE_NO, BM.BIN_TYPE || '-' || BM.BIN_NO BIN_NAME, EM.USER_NAME FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, EBAY_LIST_MT E, LZ_LISTED_ITEM_URL E_URL, LZ_BARCODE_MT BCD, BIN_MT BM, EMPLOYEE_MT EM WHERE LS.ITEM_ID = I.ITEM_ID AND E.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.ITEM_ID = I.ITEM_ID AND E.SEED_ID = LS.SEED_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E_URL.EBAY_ID = BCD.EBAY_ITEM_ID AND E.EBAY_ITEM_ID = BCD.EBAY_ITEM_ID AND  BCD.BIN_ID = BM.BIN_ID(+) AND E.LISTER_ID = EM.EMPLOYEE_ID(+)";
        if ($searchedData == 'PK' || $location == 'PK') {
        	$sql .= " AND E.LISTER_ID IN (SELECT EMPLOYEE_ID FROM EMPLOYEE_MT WHERE LOCATION = 'PK')  ";
        }elseif($searchedData == 'US'  || $location == 'US'){
        	$sql .= " AND E.LISTER_ID IN (SELECT EMPLOYEE_ID FROM EMPLOYEE_MT WHERE LOCATION = 'US')  ";
        }
    if ($listing_type_post == 0 || $listing_type == 0) {
      
      $sql .= " AND LM.MANIFEST_TYPE IN(3, 4)  ";
    }elseif ($listing_type_post == 1 || $listing_type == 1) {
      $sql .= " AND LM.MANIFEST_TYPE = 3  ";
    }elseif ($listing_type_post == 2 || $listing_type == 2) {
      $sql .= " AND LM.MANIFEST_TYPE = 4  ";
    }

     if(!empty($requestData['search']['value'])) {
      $sql.=" AND (BCD.EBAY_ITEM_ID LIKE '%".$requestData['search']['value']."%'";
      $sql.=" OR BCD.BARCODE_NO LIKE '%".$requestData['search']['value']."%' ";   
      $sql.=" OR BCD.CONDITION_ID LIKE '%".$requestData['search']['value']."%' ";   
      $sql.=" OR LS.ITEM_TITLE LIKE '%".$requestData['search']['value']."%' ";   
      $sql.=" OR E.LIST_QTY LIKE '%".$requestData['search']['value']."%' ";   
      $sql.=" OR LS.EBAY_PRICE LIKE '%".$requestData['search']['value']."%' ";   
      $sql.=" OR LM.PURCH_REF_NO LIKE '%".$requestData['search']['value']."%' ";   
      $sql.=" OR I.ITEM_MT_UPC LIKE '%".$requestData['search']['value']."%' ";   
      $sql.=" OR I.ITEM_MT_MFG_PART_NO LIKE '%".$requestData['search']['value']."%' ";   
      $sql.=" OR I.ITEM_MT_MANUFACTURE LIKE '%".$requestData['search']['value']."%' ";   
      $sql.=" OR EM.USER_NAME LIKE '%".$requestData['search']['value']."%' ";   
      $sql.=" OR BM.BIN_TYPE || '-' || BM.BIN_NO LIKE '%".$requestData['search']['value']."%') "; 
	  }
	  $sql.= " ORDER BY LIST_DATE DESC )";
		$query = $this->db->query($sql);
	    $totalData = $query->num_rows();
	    $totalFiltered = $totalData; 
 
	    $sql = "SELECT  * FROM (SELECT  q.*, rownum rn FROM  ($sql) q )";
	    $sql .= " WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'];
	    if (!empty($columns[$requestData['order'][0]['column']])) {
	    	$sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
	    }
	    
  
	    /*=====  End of For Oracle 12-c  ======*/
	    $query = $this->db->query($sql);
	    $query = $query->result_array();
	    ///////////////////////////////////////////////
	    $users = $this->db->query("SELECT T.EMPLOYEE_ID, T.USER_NAME FROM EMPLOYEE_MT T WHERE T.EMPLOYEE_ID IN(4,5,13,14,16,2,18,21,22,23,24,25,26)")->result_array();
	    //////////////////////////////////////////////
	    $data = array();
	    	$i =0;
		    foreach($query as $row ){ 
		      $nestedData=array();
		      //////////////////////////////////////////
		     /* $barcode_qry = $this->db->query("SELECT MT.BARCODE_NO, MT.ITEM_ID, MT.LZ_MANIFEST_ID, MT.CONDITION_ID FROM LZ_BARCODE_MT MT WHERE MT.ITEM_ID = ".$row['ITEM_ID']." AND MT.LZ_MANIFEST_ID = ".$row['LZ_MANIFEST_ID']." AND CONDITION_ID = ".$row['ITEM_CONDITION']." AND MT.HOLD_STATUS = 0 AND MT.EBAY_ITEM_ID IS NOT NULL")->result_array();
               
	            foreach($barcode_qry as $barcode){
	              $barcode_no =  @$barcode['BARCODE_NO']." - ";
	              $barcode_seed =  @$barcode['BARCODE_NO'];
	            }*/
		      /////////////////////////////////////////
		      
		      $nestedData[] 	= '<div style="width:100px;"> <div style="float:left;margin-right:8px;"> <a href="'.base_url().'dekitting_pk_us/c_to_list_pk/seed_view/'.$row['SEED_ID'].'/'.$row['BARCODE_NO'].'" title="Create/Edit Seed" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span></a> </div> <a style=" margin-right: 3px;" href="'.base_url().'listing/listing/print_label/'.@$row['LIST_ID'].'" title="Print Sticker" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></a> </div>';

		      $nestedData[] 	= '<a style="text-decoration: underline;" href="'.@$row['EBAY_URL'].'" title="eBay Link" target="_blank">'.@$row['EBAY_ITEM_ID'].'</a>';

		      $nestedData[] 	= '<div style="width:150px;">'.$row['BARCODE_NO'].' </div>';

		      	if(@$row['ITEM_CONDITION'] == 3000 ){
		      		$nestedData[]	= "USED";
		      	}elseif(@$row['ITEM_CONDITION'] == 1000 ){
		      		$nestedData[]	= "NEW";
		      	}elseif(@$row['ITEM_CONDITION'] == 1500 ){
		      		$nestedData[]	= "NEW OTHER";
		      	}elseif(@$row['ITEM_CONDITION'] == 2000 ){
		      		$nestedData[]	= "MANUFACTURER REFURBISHED";
		      	}elseif(@$row['ITEM_CONDITION'] == 2500 ){
		      		$nestedData[]	= "SELLER REFURBISHED";
		      	}elseif(@$row['ITEM_CONDITION'] == 7000 ){
		      		$nestedData[]	= "FOR PARTS OR NOT WORKING";
		      	}elseif(@$row['ITEM_CONDITION'] == 4000 ){
		      		$nestedData[]	= "VERY GOOD";
		      	}elseif(@$row['ITEM_CONDITION'] == 5000 ){
		      		$nestedData[]	= "GOOD";
		      	}elseif(@$row['ITEM_CONDITION'] == 6000 ){
		      		$nestedData[]	= "ACCEPTABLE";
		      	}else{
		      		$nestedData[]	= @$row['ITEM_CONDITION'];
		      }

		      $nestedData[]	= @$row['ITEM_MT_DESC'];
		      $nestedData[]	= @$row['QUANTITY'];
		      $nestedData[]	= '$'.number_format((float)@$row['EBAY_PRICE'],2,'.',',');
		     /* $nestedData[]	= @$row['PURCH_REF_NO'];
		      $nestedData[]	= @$row['UPC'];*/
		      $nestedData[]	= @$row['MFG_PART_NO'];
		      $nestedData[]	= @$row['MANUFACTURER'];
		      //$nestedData[]	= @$row['SHIPPING_SERVICE'];
		      /*foreach(@$users as $user):
                      if(@$row['LISTER_ID'] === $user['EMPLOYEE_ID']){
                        $u_name = ucfirst($user['USER_NAME']);
                        $nestedData[] =  $u_name;
                      break;
                      }else{
                      	$nestedData[] =  '';
                      }
                    endforeach;*/
		      $nestedData[]	= ucfirst(@$row['USER_NAME']);
		      $nestedData[]	= @$row['LIST_DATE'];
		      $nestedData[]	= @$row['BIN_NAME'];
		      if(@$row['LZ_SELLER_ACCT_ID'] == 1){
                      $nestedData[] =  "Techbargains2015";
                    }elseif(@$row['LZ_SELLER_ACCT_ID'] == 2){
                      $nestedData[] =  "Dfwonline";
                    }
		      $nestedData[]	= @$row['STATUS'];
		    
		      $data[] 			= $nestedData;
		      $i++;
		    }

    $json_data = array(
          "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
          "recordsTotal"    =>  intval($totalData),  // total number of records
          "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
          "deferLoading"    =>  intval( $totalFiltered ),
          "data"            => $data   // total data array
          );
    return $json_data; 
}
	public function updateShip(){
		$seed_id 				= 	$this->input->post('seed_id');
		$ship_service 			= 	$this->input->post('ship_service');
		//var_dump($seed_id, $ship_service); exit;
		$update_ship = $this->db->query("UPDATE LZ_ITEM_SEED S SET S.SHIPPING_SERVICE = '$ship_service' WHERE S.SEED_ID =  $seed_id");
		if ($update_ship) {
			return true;
		}else {
			return false;
		}
	}

  public function del_dekit_item(){

    $barcode = $this->input->post('bar');

    $insert_by = $this->session->userdata('user_id'); 


    $barcode_quer = $this->db->query("SELECT D.BARCODE_PRV_NO,D.LZ_MANIFEST_DET_ID FROM LZ_DEKIT_US_DT D,LZ_BARCODE_MT B WHERE D.BARCODE_PRV_NO = $barcode AND D.BARCODE_PRV_NO = B.BARCODE_NO AND B.EBAY_ITEM_ID IS NULL ")->result_array();

    if(count($barcode_quer) >=1){
      $this->db->query("call pro_mov_dekit_barcode($barcode ,$insert_by)");


      return 1;
    }else{


      $spec_barc = $this->db->query("SELECT L.LZ_MANIFEST_DET_ID FROM LZ_SPECIAL_LOTS L, LZ_BARCODE_MT B WHERE L.BARCODE_PRV_NO = B.BARCODE_NO AND L.BARCODE_PRV_NO = $barcode AND B.EBAY_ITEM_ID IS NULL")->result_array();

      if(count($spec_barc) >=1){
        $lz_id = $spec_barc[0]['LZ_MANIFEST_DET_ID'];

        $this->db->query("UPDATE LZ_SPECIAL_LOTS L SET L.CARD_UPC = '', L.CARD_MPN = '' ,L.MPN_DESCRIPTION = '' ,L.BRAND = '',L.LZ_MANIFEST_DET_ID = ''WHERE L.BARCODE_PRV_NO =$barcode");

        $this->db->query("call pro_unpost_barcode($barcode,$insert_by,'deleted')");

        $this->db->query("DELETE FROM LZ_MANIFEST_DET D WHERE D.LAPTOP_ZONE_ID ='$lz_id'");
        return 2;
      }else{

        return 3;

      }



      

    }

  }

public function discardBarcode(){

    $barcode = $this->input->post('bar');
    $user_id = $this->session->userdata('user_id'); 
    date_default_timezone_set("America/Chicago");
    $dated = date("Y-m-d H:i:s");
    $dated= "TO_DATE('".$dated."', 'YYYY-MM-DD HH24:MI:SS')";

    $qry = $this->db->query("UPDATE LZ_BARCODE_MT L SET L.DISCARD = 1 , L.DISCARD_BY = '$user_id' ,L.DISCARD_DATE = $dated WHERE L.BARCODE_NO =$barcode");
      if($qry){
        return 1;
      }else{
        return 0;
      }
    
  }


}