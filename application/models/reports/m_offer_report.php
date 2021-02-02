<?php 

	class m_offer_report extends CI_Model
	{

		public function __construct(){
		parent::__construct();
		$this->load->database();
		
	}

  public function unVerifyDropdown(){ 
      $list_types = $this->db->query("SELECT LISTING_TYPE FROM LZ_BD_LISTING_TYPES")->result_array();

      $conditions = $this->db->query("SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT")->result_array();
      

    $flag_id = "SELECT FLAG_ID ,FLAG_NAME FROM LZ_BD_PURCHASING_FLAG ORDER BY FLAG_ID";
    $flag_id = $this->db->query($flag_id)->result_array();

    $emp_id = "SELECT EM.EMPLOYEE_ID  EMP_ID, EM.FIRST_NAME||' '||EM.LAST_NAME NAME  FROM EMPLOYEE_MT EM";
    $emp_id = $this->db->query($emp_id)->result_array();
    $category_id = $this->session->userdata('mpn_cata');
    if(!empty($category_id)){
      $spec_id = "SELECT MT.MT_ID,MT.SPECIFIC_NAME FROM CATEGORY_SPECIFIC_MT MT WHERE MT.EBAY_CATEGORY_ID = $category_id"; 
      $spec_id = $this->db2->query($spec_id)->result_array();
    }else{
      $spec_id = null;
    }
    
    $cattegory = "SELECT K.CATEGORY_ID CATEGORY_ID,K.CATEGORY_NAME ||'-'|| K.CATEGORY_ID CATEGORY_NAME FROM LZ_BD_CATEGORY K ORDER BY  DECODE(CATEGORY_ID,177,177)";
    $cattegory = $this->db2->query($cattegory);
    $cattegory = $cattegory->result_array();

      return array('list_types' => $list_types, 'conditions' => $conditions, 'spec_id' => $spec_id , 'cattegory' => $cattegory,'flag_id' => $flag_id,'emp_id' =>$emp_id);
  }
  public function condition_dd(){ 


      $conditions = $this->db->query("SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT")->result_array();
    

      return array('conditions' => $conditions);
  }
	public function load_offer_query(){
    $Search_category = $this->session->userdata('offer_category');
    $end_from = $this->session->userdata('end_from');
    $end_to = $this->session->userdata('end_to');
    $off_from = $this->session->userdata('off_from');
    $off_to = $this->session->userdata('off_to');
    $resdropdown = $this->session->userdata('resdropdown');
    $emp_id = $this->session->userdata('emp_id');
    $Skip_offer = $this->session->userdata('Skip_offer');
    $Skip_end = $this->session->userdata('Skip_end');
    $await_ship = $this->session->userdata('radiobutton');
    
    $check_categ = $Search_category[0];
    if($check_categ != 'all' && $check_categ != null){
      $categ_exp = '';
      $i = 0;
      foreach ($Search_category as $catag_value) {
        if(!empty($Search_category[$i+1])){
        $categ_exp= $categ_exp . $catag_value.',';
    
      }else{
        $categ_exp= $categ_exp . $catag_value;
        }
    $i++; 
        
      }
    }

    $check_emp_id = $emp_id[0];
    if($check_emp_id != 'all' && $check_emp_id != null){
      $emp_id_exp = '';
      $i = 0;
      foreach ($emp_id as $emp_id_value) {
        if(!empty($emp_id[$i+1])){
        $emp_id_exp= $emp_id_exp . $emp_id_value.',';
    
      }else{
        $emp_id_exp= $emp_id_exp . $emp_id_value;
        }
    $i++; 
        
      }
    }

    $requestData = $_REQUEST;

   $columns     = array(
      // datatable column index  => database column name
      0 =>'EBAY_ID',
      1 =>'TITLE',
      2 => 'LISTING_TYPE',
      3 => 'LIST_PRICE',
      4 => 'AVERAGE',
      5 => 'OFFER',
      //6 => 'AVERAGE',
      6 => 'PROFITLOS',
      7 => 'KIT_AVG',
      8 => 'KITPROFLOS',
      9 => 'LIST',
      10 => 'OFFER_DATE',
      11 => 'RESULT',
      12 => 'CATEGORY_ID',
      13 => 'OFFER_BY',
      14 => 'TRACKING_NO'
          
    );
    

    $sql = "SELECT V.EBAY_ID, V.TITLE, V.LISTING_TYPE,MT.LZ_BD_ESTIMATE_ID , /*PRICE US $*/ V.SALE_PRICE LIST_PRICE,V.ITEM_URL, (SELECT nvl(SUM(DE.EST_SELL_PRICE),0) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = MT.LZ_BD_ESTIMATE_ID GROUP BY DE.LZ_BD_ESTIMATE_ID) EST_PRICE, NVL(OFER.OFFER_AMOUNT, 0) OFFER, NVL(MPAV.AVG_PRICE, 0) AVERAGE, ROUND(DECODE(NVL(OFER.OFFER_AMOUNT, 0), 0, 0, MPAV.AVG_PRICE - NVL(OFER.OFFER_AMOUNT, 0)), 2) PROFITLOS, /*PRICE US COLUMNS END*/ /*KIT*/ (SELECT SUM(DE.EST_SELL_PRICE) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = MT.LZ_BD_ESTIMATE_ID GROUP BY DE.LZ_BD_ESTIMATE_ID) KIT_AVG,  decode(NVL(OFER.OFFER_AMOUNT, 0),0,0,(SELECT NVL(SUM(DE.EST_SELL_PRICE), 0) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = MT.LZ_BD_ESTIMATE_ID GROUP BY DE.LZ_BD_ESTIMATE_ID) - NVL(OFER.OFFER_AMOUNT, 0)) KITPROFLOS, /*KIT COLUMNS END*/ /*DATES COLUMNS START*/ to_char(v.start_time,'dd-mm-yyyy hh:mm:ss') LIST,to_char(V.SALE_TIME,'dd-mm-yyyy hh:mm:ss') END_DATE,to_char(OFER.OFFER_DATE,'dd-mm-yyyy hh:mm:ss') OFFER_DATE, /*DATES COLUMNS END*/ DECODE(OFER.WIN_STATUS, 1, 'WIN', 0, 'LOST', 2, 'NOT RELAIABLE', NULL) RESULT, V.CATEGORY_ID CATEGORY_ID, (SELECT EM.FIRST_NAME || '' || EM.LAST_NAME NAME FROM EMPLOYEE_MT EM WHERE EM.EMPLOYEE_ID = OFER.OFFERED_BY) OFFER_BY, T.TRACKING_NO TRACKING_NO FROM LZ_BD_ESTIMATE_MT    MT, LZ_BD_ITEMS_TO_EST   V, LZ_BD_PURCHASE_OFFER OFER, LZ_BD_TRACKING_NO    T, MPN_AVG_PRICE        MPAV WHERE MT.LZ_BD_CATAG_ID = V.LZ_BD_CATA_ID AND MT.LZ_BD_CATAG_ID = OFER.LZ_BD_CATA_ID(+) AND MT.LZ_BD_CATAG_ID = T.LZ_BD_CATA_ID(+) AND V.CATALOGUE_MT_ID = MPAV.CATALOGUE_MT_ID(+) AND V.CONDITION_ID = MPAV.CONDITION_ID(+) ";
     if($check_categ != 'all' && $check_categ != null){
      $sql.=" AND  V.CATEGORY_ID in($categ_exp)";
        }
        if(empty($Skip_offer)){        
        if(!empty($off_from) && !empty($off_to)){
          $sql.= "AND OFER.OFFER_DATE between TO_DATE('$off_from "."00:00:00','MM/DD/YY HH24:MI:SS') and TO_DATE('$off_to ". "23:59:59','MM/DD/YY  HH24:MI:SS')";
          }
        }
        if(empty($Skip_end)){
        if(!empty($end_from) && !empty($end_to)){
          $sql.= "AND v.SALE_TIME between TO_DATE('$end_from "."00:00:00','MM/DD/YY HH24:MI:SS') and TO_DATE('$end_to ". "23:59:59','MM/DD/YY  HH24:MI:SS')";
        }
      }if(!empty($resdropdown)){
          $sql.= " AND OFER.WIN_STATUS  = $resdropdown ";
        }
        if($check_emp_id != 'all' && $check_emp_id != null){
          $sql.=" AND  OFER.OFFERED_BY in($emp_id_exp)";
        }if($await_ship == 1){// yes
          $sql.=" AND t.tracking_no is not null ";
          $sql.=" AND t.lz_single_entry_id is null ";

        }  
  
        if( !empty($requestData['search']['value']) ) {   
    // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" AND ( EBAY_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR TITLE LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' )";
          // $sql.=" OR OFFER_BY LIKE '%".$requestData['search']['value']."%' "; 
          // $sql.=" OR TRACKING_NO LIKE '%".$requestData['search']['value']."%' )"; 
          
      }else{
        if(!empty($requestData['search']['value'])){
           // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" AND ( EBAY_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR TITLE LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' )"; 
           // $sql.=" OR OFFER_BY LIKE '%".$requestData['search']['value']."%' ";
           //  $sql.=" OR TRACKING_NO LIKE '%".$requestData['search']['value']."%' )"; 
         
        }
      }

    $query   = $this->db->query($sql); 
    $totalData     = $query->num_rows();
    $totalFiltered = $totalData;

    
    $sql .= " ORDER BY " . $columns[$requestData['order']['0']['column']] . "   " . $requestData['order']['0']['dir'];
    $sql = "SELECT  * FROM    (SELECT  q.*, ROWNUM rn FROM ($sql) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn >= ".$requestData['start'] ;
    $query         = $this->db->query($sql)->result_array();
   
      
    $data          = array();
     $i = 1;
    foreach($query as $row ){ 
      $nestedData=array();
      $nestedData[] ="<a href='".@$row['ITEM_URL']."' target='_blank' >".@$row['EBAY_ID']."</a>";
      //$nestedData[] = $row['EBAY_ID'];
      $nestedData[] = $row['TITLE'];
      $nestedData[] = $row['LISTING_TYPE'];
      $nestedData[] = '<div class="pull-right">$ '. number_format((float)@$row['LIST_PRICE'],2,'.',',').'</div>';
      //$nestedData[] = '<div class="pull-right">$ '. number_format((float)@$row['EST_PRICE'],2,'.',',').'</div>';

      $nestedData[] ='<div class="pull-right">$ '. number_format((float)@$row['AVERAGE'],2,'.',',').'</div>';


      $nestedData[] = '<div class="pull-right">$ '. number_format((float)@$row['OFFER'],2,'.',',').'</div>';
      
      //$nestedData[] = $row['AVERAGE'];
      
      $nestedData[] = '<div class="pull-right">$ '. number_format((float)@$row['PROFITLOS'],2,'.',',').'</div>';

      //$nestedData[] =  "<a  class = 'url'>". number_format((float)@$row['KIT_AVG'],2,'.',',')."</a>";
        
        //  code for model dialogue
      // $nestedData[] =  "<a id='link".$i."' det_id = ".$row['LZ_BD_ESTIMATE_ID']." class ='url'>". number_format((float)@$row['KIT_AVG'],2,'.',',')."</a>";


       $nestedData[] =  "<a href='".base_url()."reports/c_offer_report/load_offer_detail/".$row['EBAY_ID']."/".$row['LZ_BD_ESTIMATE_ID']."' target='_blank'>". number_format((float)@$row['KIT_AVG'],2,'.',',')."</a>";

      $nestedData[] = '<div class="pull-right">$ '. number_format((float)@$row['KITPROFLOS'],2,'.',',').'</div>';
      
      $nestedData[] = $row['LIST'];
      $nestedData[] = $row['END_DATE'];
      $nestedData[] = $row['OFFER_DATE'];
      $nestedData[] = $row['RESULT'];
      $nestedData[] = $row['CATEGORY_ID'];
      $nestedData[] = $row['OFFER_BY'];
      $nestedData[] = $row['TRACKING_NO'];
             
    $data[] = $nestedData;        
 
    $i++;
    } //// end main foreach
    $json_data = array(
      "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
      "recordsTotal" => intval($totalData), // total number of records
      "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "deferLoading" =>  intval( $totalFiltered ),
      "data" => $data // total data array
    );
    return $json_data;
 	}

  public function load_offer_detail(){
  $ebay_id=$this->uri->segment(4);
  $est_id=$this->uri->segment(5);

  $query = $this->db->query("SELECT V.EBAY_ID,V.TITLE, V.LISTING_TYPE,(SELECT ll.FIRST_NAME || '' || ll.LAST_NAME          ENTERED_BY FROM EMPLOYEE_MT ll WHERE ll.EMPLOYEE_ID =MT.ENTERED_BY ) ENTER_BY, /*PRICE US $*/ V.SALE_PRICE LIST_PRICE,V.ITEM_URL, (SELECT nvl(SUM(DE.EST_SELL_PRICE),0) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = MT.LZ_BD_ESTIMATE_ID GROUP BY DE.LZ_BD_ESTIMATE_ID) EST_PRICE, NVL(OFER.OFFER_AMOUNT, 0) OFFER,(SELECT MT.MPN FROM LZ_CATALOGUE_MT MT WHERE MT.CATALOGUE_MT_ID = V.CATALOGUE_MT_ID) MPN, NVL(MPAV.AVG_PRICE, 0) AVERAGE, NVL(MPAV.AVG_PRICE, 0) - NVL(OFER.OFFER_AMOUNT, 0) PROFITLOS, /*PRICE US COLUMNS END*/ /*KIT*/ (SELECT SUM(DE.EST_SELL_PRICE) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = MT.LZ_BD_ESTIMATE_ID GROUP BY DE.LZ_BD_ESTIMATE_ID) KIT_AVG, (SELECT NVL(SUM(DE.EST_SELL_PRICE), 0) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = MT.LZ_BD_ESTIMATE_ID GROUP BY DE.LZ_BD_ESTIMATE_ID) - NVL(OFER.OFFER_AMOUNT, 0) KITPROFLOS, /*KIT COLUMNS END*/ /*DATES COLUMNS START*/ to_char(v.start_time,'dd-mm-yyyy hh:mm:ss') LIST,to_char(V.SALE_TIME,'dd-mm-yyyy hh:mm:ss') END_DATE,to_char(OFER.OFFER_DATE,'dd-mm-yyyy hh:mm:ss') OFFER_DATE, /*DATES COLUMNS END*/ DECODE(OFER.WIN_STATUS, 1, 'WIN', 0, 'LOST', 2, 'NOT RELAIABLE', NULL) RESULT, V.CATEGORY_ID CATEGORY_ID, (SELECT EM.FIRST_NAME || '' || EM.LAST_NAME NAME FROM EMPLOYEE_MT EM WHERE EM.EMPLOYEE_ID = OFER.OFFERED_BY) OFFER_BY, T.TRACKING_NO TRACKING_NO FROM LZ_BD_ESTIMATE_MT    MT, LZ_BD_ITEMS_TO_EST   V, LZ_BD_PURCHASE_OFFER OFER, LZ_BD_TRACKING_NO    T, MPN_AVG_PRICE        MPAV WHERE MT.LZ_BD_CATAG_ID = V.LZ_BD_CATA_ID AND MT.LZ_BD_CATAG_ID = OFER.LZ_BD_CATA_ID(+) AND MT.LZ_BD_CATAG_ID = T.LZ_BD_CATA_ID(+) AND V.CATALOGUE_MT_ID = MPAV.CATALOGUE_MT_ID(+) AND V.CONDITION_ID = MPAV.CONDITION_ID(+) and V.EBAY_ID = $ebay_id ")->result_array();



  $det_query = $this->db->query("SELECT MT.LZ_BD_ESTIMATE_ID, DE.PART_CATLG_MT_ID, CA.MPN, DE.TECH_COND_ID, MPN_AVG.AVG_PRICE, DE.EST_SELL_PRICE, ROUND(DECODE((SELECT NVL(SUM(DE.EST_SELL_PRICE), 0) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = MT.LZ_BD_ESTIMATE_ID GROUP BY DE.LZ_BD_ESTIMATE_ID), 0, 0, DE.EST_SELL_PRICE/*MPN_AVG.AVG_PRICE*/ / (SELECT NVL(SUM(DE.EST_SELL_PRICE), 0) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = MT.LZ_BD_ESTIMATE_ID GROUP BY DE.LZ_BD_ESTIMATE_ID) * OFER.OFFER_AMOUNT),2) OFFER, ROUND(DE.EST_SELL_PRICE/*MPN_AVG.AVG_PRICE*/ - DECODE((SELECT NVL(SUM(DE.EST_SELL_PRICE), 0) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = MT.LZ_BD_ESTIMATE_ID GROUP BY DE.LZ_BD_ESTIMATE_ID), 0, 0, DE.EST_SELL_PRICE/*MPN_AVG.AVG_PRICE*/ / (SELECT NVL(SUM(DE.EST_SELL_PRICE), 0) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = MT.LZ_BD_ESTIMATE_ID GROUP BY DE.LZ_BD_ESTIMATE_ID) * OFER.OFFER_AMOUNT),2) PLOST, (SELECT OB.OBJECT_NAME FROM LZ_BD_OBJECTS_MT OB WHERE OB.OBJECT_ID = CA.OBJECT_ID AND OB.CATEGORY_ID = CA.CATEGORY_ID) OBJ_NAME FROM LZ_BD_ESTIMATE_MT    MT, LZ_BD_ESTIMATE_DET   DE, LZ_CATALOGUE_MT      CA, MPN_AVG_PRICE        MPN_AVG, LZ_BD_PURCHASE_OFFER OFER WHERE MT.LZ_BD_ESTIMATE_ID = DE.LZ_BD_ESTIMATE_ID AND DE.PART_CATLG_MT_ID = MPN_AVG.CATALOGUE_MT_ID(+) AND DE.TECH_COND_ID = MPN_AVG.CONDITION_ID(+) AND MT.LZ_BD_ESTIMATE_ID = $est_id AND MT.LZ_BD_CATAG_ID = OFER.LZ_BD_CATA_ID(+) AND DE.PART_CATLG_MT_ID = CA.CATALOGUE_MT_ID")->result_array(); return array('query' => $query,'det_query' =>$det_query);

  }

  // public function load_reacvice_repo(){


  // }

  public function load_reacvice_repo(){
   
    $requestData = $_REQUEST;

   $columns     = array(
      // datatable column index  => database column name
      0 =>'EBAY_ID',
      1 =>'TITLE',
      2 => 'LISTING_TYPE',
      3 => 'LIST_PRICE',
      4 => 'COST_PRICE',
      5 => 'AVERAGE',
      6 => 'OFFER',
      //6 => 'AVERAGE',
      7 => 'PROFITLOS',
      8 => 'KIT_AVG',
      9 => 'KITPROFLOS',
      10 => 'LIST',
      11 => 'OFFER_DATE',
      12 => 'RESULT',
      13 => 'CATEGORY_ID',
      14 => 'OFFER_BY',
      15 => 'REACIVE_DATE',
      16 => 'TRACKING_NO'
          
    );
    

    $sql = "SELECT V.EBAY_ID, V.TITLE, NVL(T.COST_PRICE,0) COST_PRICE,(SELECT TO_CHAR(S.PURCHASE_DATE, 'DD-MM-YYYY HH:MM:SS') FROM LZ_SINGLE_ENTRY S WHERE S.ID = T.LZ_SINGLE_ENTRY_ID) REACIVE_DATE,V.LISTING_TYPE,DECODE(T.LZ_SINGLE_ENTRY_ID ,NULL,'NOT POSTED','POSTED') STATUS, MT.LZ_BD_ESTIMATE_ID, /*PRICE US $*/ V.SALE_PRICE LIST_PRICE, V.ITEM_URL, (SELECT nvl(SUM(DE.EST_SELL_PRICE), 0) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = MT.LZ_BD_ESTIMATE_ID GROUP BY DE.LZ_BD_ESTIMATE_ID) EST_PRICE, NVL(OFER.OFFER_AMOUNT, 0) OFFER, NVL(MPAV.AVG_PRICE, 0) AVERAGE,   ROUND(DECODE(NVL(T.COST_PRICE, 0), 0, MPAV.AVG_PRICE - NVL(OFER.OFFER_AMOUNT, 0), T.COST_PRICE - NVL(OFER.OFFER_AMOUNT, 0) ), 2) PROFITLOS, /*PRICE US COLUMNS END*/ /*KIT*/ (SELECT SUM(DE.EST_SELL_PRICE) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = MT.LZ_BD_ESTIMATE_ID GROUP BY DE.LZ_BD_ESTIMATE_ID) KIT_AVG, decode(NVL(OFER.OFFER_AMOUNT, 0),0,0,(SELECT NVL(SUM(DE.EST_SELL_PRICE), 0) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = MT.LZ_BD_ESTIMATE_ID GROUP BY DE.LZ_BD_ESTIMATE_ID) - NVL(OFER.OFFER_AMOUNT, 0)) KITPROFLOS, /*KIT COLUMNS END*/ /*DATES COLUMNS START*/ to_char(v.start_time, 'dd-mm-yyyy hh:mm:ss') LIST, to_char(V.SALE_TIME, 'dd-mm-yyyy hh:mm:ss') END_DATE, to_char(OFER.OFFER_DATE, 'dd-mm-yyyy hh:mm:ss') OFFER_DATE, /*DATES COLUMNS END*/ DECODE(OFER.WIN_STATUS, 1, 'WIN', 0, 'LOST', 2, 'NOT RELAIABLE', NULL) RESULT, V.CATEGORY_ID CATEGORY_ID, (SELECT EM.FIRST_NAME || '' || EM.LAST_NAME NAME FROM EMPLOYEE_MT EM WHERE EM.EMPLOYEE_ID = OFER.OFFERED_BY) OFFER_BY, T.TRACKING_NO TRACKING_NO FROM LZ_BD_ESTIMATE_MT    MT, LZ_BD_ACTIVE_DATA   V, LZ_BD_PURCHASE_OFFER OFER, LZ_BD_TRACKING_NO    T, MPN_AVG_PRICE     MPAV WHERE MT.LZ_BD_CATAG_ID = V.LZ_BD_CATA_ID AND MT.LZ_BD_CATAG_ID = OFER.LZ_BD_CATA_ID(+) AND MT.LZ_BD_CATAG_ID = T.LZ_BD_CATA_ID(+) AND V.CATALOGUE_MT_ID = MPAV.CATALOGUE_MT_ID(+) AND V.CONDITION_ID = MPAV.CONDITION_ID(+) "; //   if($check_categ != 'all' && $check_categ != null){//     $sql.=" AND  V.CATEGORY_ID in($categ_exp)"; //   } //   if(empty($Skip_offer)){
      //   if(!empty($off_from) && !empty($off_to)){
      //     $sql.= "AND OFER.OFFER_DATE between TO_DATE('$off_from "."00:00:00','MM/DD/YY HH24:MI:SS') and TO_DATE('$off_to ". "23:59:59','MM/DD/YY  HH24:MI:SS')";
      //     }
      //   }
      //   if(empty($Skip_end)){
      //   if(!empty($end_from) && !empty($end_to)){
      //     $sql.= "AND v.SALE_TIME between TO_DATE('$end_from "."00:00:00','MM/DD/YY HH24:MI:SS') and TO_DATE('$end_to ". "23:59:59','MM/DD/YY  HH24:MI:SS')";
      //   }
      // }if(!empty($resdropdown)){
      //     $sql.= " AND OFER.WIN_STATUS  = $resdropdown ";
      //   }
      //   if($check_emp_id != 'all' && $check_emp_id != null){
      //     $sql.=" AND  OFER.OFFERED_BY in($emp_id_exp)";
      //   }

        // if($await_ship == 1){// yes
        //   $sql.=" AND t.tracking_no is not null ";
        //   $sql.=" AND t.lz_single_entry_id is null ";

        // }  
  
        if( !empty($requestData['search']['value']) ) {   
    // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" AND ( EBAY_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR TITLE LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' )";
          // $sql.=" OR OFFER_BY LIKE '%".$requestData['search']['value']."%' "; 
          // $sql.=" OR TRACKING_NO LIKE '%".$requestData['search']['value']."%' )"; 
          
      }else{
        if(!empty($requestData['search']['value'])){
           // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" AND ( EBAY_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR TITLE LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' )"; 
           // $sql.=" OR OFFER_BY LIKE '%".$requestData['search']['value']."%' ";
           //  $sql.=" OR TRACKING_NO LIKE '%".$requestData['search']['value']."%' )"; 
         
        }
      }

    $query   = $this->db->query($sql); 
    $totalData     = $query->num_rows();
    $totalFiltered = $totalData;

    
    $sql .= " ORDER BY " . $columns[$requestData['order']['0']['column']] . "   " . $requestData['order']['0']['dir'];
    $sql = "SELECT  * FROM    (SELECT  q.*, ROWNUM rn FROM ($sql) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn >= ".$requestData['start'] ;
    $query         = $this->db->query($sql)->result_array();
   
      
    $data          = array();
     $i = 1;
    foreach($query as $row ){ 
      $nestedData=array();
      // $nestedData[] ="<button type='button' title='+' det_id = ".$row['LZ_BD_ESTIMATE_ID']." class='btn btn-success btn-xs get_detail'>update</button>";
      // $nestedData[] ="<i class='fa fa-plus-square details-control' aria-hidden='true' det_id = ".$row['LZ_BD_ESTIMATE_ID']." ></i>";

      $nestedData[] ="<a href='".@$row['ITEM_URL']."' target='_blank' >".@$row['EBAY_ID']."</a>";
      //$nestedData[] = $row['EBAY_ID'];
      $nestedData[] = $row['TITLE'];
      $nestedData[] = $row['LISTING_TYPE'];
      $nestedData[] = '<div class="pull-right">$ '. number_format((float)@$row['LIST_PRICE'],2,'.',',').'</div>';
      $nestedData[] = '<div class="pull-right">$ '. number_format((float)@$row['COST_PRICE'],2,'.',',').'</div>';
      //$nestedData[] = '<div class="pull-right">$ '. number_format((float)@$row['EST_PRICE'],2,'.',',').'</div>';

      $nestedData[] ='<div class="pull-right">$ '. number_format((float)@$row['AVERAGE'],2,'.',',').'</div>';


      $nestedData[] = '<div class="pull-right">$ '. number_format((float)@$row['OFFER'],2,'.',',').'</div>';
      
      //$nestedData[] = $row['AVERAGE'];
      
      $nestedData[] = '<div class="pull-right">$ '. number_format((float)@$row['PROFITLOS'],2,'.',',').'</div>';

      //$nestedData[] =  "<a  class = 'url'>". number_format((float)@$row['KIT_AVG'],2,'.',',')."</a>";
        
        //  code for model dialogue
      // $nestedData[] =  "<a id='link".$i."' det_id = ".$row['LZ_BD_ESTIMATE_ID']." class ='url'>". number_format((float)@$row['KIT_AVG'],2,'.',',')."</a>";


       $nestedData[] =  "<a href='".base_url()."reports/c_offer_report/load_offer_detail/".$row['EBAY_ID']."/".$row['LZ_BD_ESTIMATE_ID']."' target='_blank'>". number_format((float)@$row['KIT_AVG'],2,'.',',')."</a>";

      $nestedData[] = '<div class="pull-right">$ '. number_format((float)@$row['KITPROFLOS'],2,'.',',').'</div>';
      
      $nestedData[] = $row['LIST'];
      $nestedData[] = $row['END_DATE'];
      $nestedData[] = $row['OFFER_DATE'];
      $nestedData[] = $row['RESULT'];
      $nestedData[] = $row['CATEGORY_ID'];
      $nestedData[] = $row['OFFER_BY'];
      $nestedData[] = $row['REACIVE_DATE'];
      $nestedData[] = $row['TRACKING_NO'];
      
             
    $data[] = $nestedData;        
 
    $i++;
    } //// end main foreach
    $json_data = array(
      "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
      "recordsTotal" => intval($totalData), // total number of records
      "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "deferLoading" =>  intval( $totalFiltered ),
      "data" => $data // total data array
    );
    return $json_data;
  }

/// post _recipt report start

public function load_post_receipt(){
    
    $pos_cata = $this->session->userdata('pos_cata');
    $pos_barc = $this->session->userdata('pos_barc');
    $item_drop = $this->session->userdata('item_drop');
    $lot_drop = $this->session->userdata('lot_drop');

    $dk_from = $this->session->userdata('dk_from');
    $dk_to = $this->session->userdata('dk_to');
    $skip_dek_date = $this->session->userdata('skip_dek_date');

    $lis_from = $this->session->userdata('lis_from');
    $lis_to = $this->session->userdata('lis_to');
    $Skip_list_d = $this->session->userdata('Skip_list_d');

    $sol_from = $this->session->userdata('sol_from');
    $sol_to = $this->session->userdata('sol_to');
    $Skip_sold_d = $this->session->userdata('Skip_sold_d');


    $check_categ = $pos_cata[0];
    if($check_categ != 'all' && $check_categ != null){
      $categ_exp = '';
      $i = 0;
      foreach ($pos_cata as $catag_value) {
        if(!empty($pos_cata[$i+1])){
        $categ_exp= $categ_exp."'". $catag_value."'".',';
    
      }else{
        $categ_exp= $categ_exp."'".$catag_value."'";;
        }
    $i++; 
        
      }
    }

    $requestData = $_REQUEST;

   $columns     = array(
      // datatable column index  => database column name
      0   =>'EBAY_ID',
      1   =>'BARCODE_NO',
      2   => 'TITLE',
      3   => 'OFFER_AMOUNT',
      4   => 'COST_PRICE',
      5   => 'AVG_PRICE',
      6   => 'PROFITLOS',
      7  => 'PROFITPERCNT',
      8   => 'KIT_AVG',
      9   => 'KITPROFLOS',
      10   => 'COST_PRICE',
      11  => 'LIST_PRICE',
      12  => 'SOLD_PRICE',
      13  => 'COMP_EBAY_FEE',
      14  => 'COMP_PAYPAL_FEE',
      15  => 'COMP_SHIP_FEE',
      16  => 'TOTAL_EXPENS',
      17  => 'PROL',
      18  => 'DEKIT_DATR',          
      19  => 'LIST_DATE',          
      20  => 'SOLD_DATE',         
      21  => 'COST',          
      22  => 'LIST',          
      23  => 'SOLD',         
      24  => 'EBAY',          
      25  => 'PAYPAL',          
      26  => 'SHIP',          
      27  => 'COM_PROFIT',          
      28  => 'TOTAL_EXP'          
    );
    

    $sql = "SELECT Q1.PULLING_ID, Q1.EBAY_ID EBAY_ID, Q1.MANIFEST_TYPE MANIFEST_TYPE, Q1.CATEGORY_ID CATEGORY_ID, Q1.ITEM_URL, Q1.BARCODE_NO BARCODE_NO, Q1.DK_BAR, TO_CHAR(Q1.LIST_DATE, 'DD-MON-YYYY') LIST_DATE, TO_CHAR(Q1.SOLD_DATE, 'DD-MON-YYYY') SOLD_DATE, Q1.DEKIT_DATR, (SELECT I.ITEM_DESC FROM ITEMS_MT I WHERE I.ITEM_ID = Q1.ITEM_ID) ||  DECODE(Q1.MANIFEST_TYPE,1,'(REG)',2,'(LOT)') ITEM_TITLE, DECODE(Q1.TITLE, NULL, (SELECT I.ITEM_DESC FROM ITEMS_MT I WHERE I.ITEM_ID = Q1.ITEM_ID), Q1.TITLE) TITLE, Q1.OFFER_AMOUNT, Q1.AVG_PRICE AVG_PRICE, Q1.COST_PRICE COST_PRICE, ROUND(DECODE(NVL(Q1.COST_PRICE, 0), 0, NVL(Q1.AVG_PRICE, 0) - NVL(Q1.OFFER_AMOUNT, 0)        , Q1.COST_PRICE - NVL(Q1.OFFER_AMOUNT, 0)), 2) PROFITLOS, NVL(DECODE(Q1.AVG_PRICE, 0, 0, ROUND(DECODE(NVL(Q1.COST_PRICE, 0), 0, NVL(Q1.AVG_PRICE, 0) - DECODE(Q1.MANIFEST_TYPE, 2, Q1.COST_PRICE, NVL(Q1.OFFER_AMOUNT, 0)), Q1.COST_PRICE - DECODE(Q1.MANIFEST_TYPE, 2, Q1.COST_PRICE, NVL(Q1.OFFER_AMOUNT, 0))), 2) / Q1.AVG_PRICE * 100), 0) PROFITPERCNT, /*-- ASSEMBLED PL*/ /*ASSEMBELED ITEM MATH*/ SOLD_PRICE, LIST_PRICE, COMP_EBAY_FEE, COMP_PAYPAL_FEE, COMP_SHIP_FEE, nvl(SOLD_PRICE -  (COMP_EBAY_FEE + COMP_PAYPAL_FEE + COMP_SHIP_FEE + Q1.COST_PRICE),0) PROL,       COMP_EBAY_FEE + COMP_PAYPAL_FEE + COMP_SHIP_FEE  TOTAL_EXPENS, /*ASSEMBELED ITEM MATH*/ Q1.KIT_AVG KIT_AVG, Q1.KITPROFLOS KITPROFLOS, '' COST, SUM_LIST LIST, SUM_SOLD SOLD, SUM_EBAY EBAY, SUM_PAYPAL PAYPAL, SUM_SHIP SHIP, SUM_TOTAL TOTAL_EXP ,COM_PROF COM_PROFIT FROM (SELECT B.EBAY_ITEM_ID EBAY_ID,                EB_URL.EBAY_URL ITEM_URL, K.MANIFEST_TYPE, DETK.E_BAY_CATA_ID_SEG6 CATEGORY_ID, DECODE(ES_DET.SOLD_PRICE, NULL, (SELECT MPN_AVG.AVG_PRICE FROM MPN_AVG_PRICE MPN_AVG WHERE MPN_AVG.CATALOGUE_MT_ID = V.CATALOGUE_MT_ID AND MPN_AVG.CONDITION_ID = B.CONDITION_ID AND ROWNUM = 1), ES_DET.SOLD_PRICE) AVG_PRICE, DK.LZ_DEKIT_US_MT_ID DK_BAR, TO_CHAR(DK.DEKIT_DATE_TIME, 'DD-MON-YYYY') DEKIT_DATR, B.BARCODE_NO BARCODE_NO, V.TITLE TITLE, DECODE(K.MANIFEST_TYPE, 2, PO_DETAIL_RETIAL_PRICE/DETK.Available_Qty,1, NVL(OFER.OFFER_AMOUNT, 0)) OFFER_AMOUNT, /*TR.COST_PRICE,*/ /*(SELECT DETK.PO_DETAIL_RETIAL_PRICE FROM LZ_MANIFEST_DET DETK, ITEMS_MT II WHERE DETK.LAPTOP_ITEM_CODE = II.ITEM_CODE AND II.ITEM_ID = B.ITEM_ID AND DETK.LZ_MANIFEST_ID = K.LZ_MANIFEST_ID)*/ nvl(DETK.PO_DETAIL_RETIAL_PRICE / DETK.Available_Qty,0) COST_PRICE, /*(SELECT NVL(T.COST_PRICE, 0) FROM LZ_BD_TRACKING_NO T WHERE (T.LZ_BD_CATA_ID = ES.LZ_BD_CATAG_ID OR T.LZ_BD_CATA_ID = TR.LZ_BD_CATA_ID)) COST_PRICE,*/ (SELECT SUM(DE.EST_SELL_PRICE) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = ES.LZ_BD_ESTIMATE_ID GROUP BY DE.LZ_BD_ESTIMATE_ID) KIT_AVG, DECODE(NVL(OFER.OFFER_AMOUNT, 0), 0, (SELECT NVL(SUM(DE.EST_SELL_PRICE), 0) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = ES.LZ_BD_ESTIMATE_ID GROUP BY DE.LZ_BD_ESTIMATE_ID) - DETK.PO_DETAIL_RETIAL_PRICE, (SELECT NVL(SUM(DE.EST_SELL_PRICE), 0) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = ES.LZ_BD_ESTIMATE_ID GROUP BY DE.LZ_BD_ESTIMATE_ID) - DECODE(K.MANIFEST_TYPE, 2, DETK.PO_DETAIL_RETIAL_PRICE, NVL(OFER.OFFER_AMOUNT, 0))) KITPROFLOS, /*-- KIT PL*/ K.LZ_MANIFEST_ID LZ_MANIFEST_ID, K.EST_MT_ID EST_MT_ID, TR.LZ_ESTIMATE_ID TR_ESMT_ID, ES.LZ_BD_ESTIMATE_ID ES_ESMT_ID, B.ITEM_ID, B.PULLING_ID, /*ASSEMBELED ITEM MATH*/ SAL_DE.SALE_DATE SOLD_DATE, NVL(SAL_DE.SALE_PRICE / SAL_DE.QUANTITY ,0) SOLD_PRICE, (SELECT nvl(MAX(EB_LIST.LIST_PRICE),0) FROM EBAY_LIST_MT EB_LIST WHERE EB_LIST.EBAY_ITEM_ID = B.EBAY_ITEM_ID) LIST_PRICE, (SELECT MAX(EB_LIST_DA.LIST_DATE) FROM EBAY_LIST_MT EB_LIST_DA WHERE EB_LIST_DA.EBAY_ITEM_ID = B.EBAY_ITEM_ID) LIST_DATE, NVL(SAL_DE.EBAY_FEE_PERC, 0) COMP_EBAY_FEE, NVL(SAL_DE.PAYPAL_FEE_PERC, 0) COMP_PAYPAL_FEE, NVL(SAL_DE.SHIPPING_CHARGES, 0) COMP_SHIP_FEE, NVL(SAL_DE.SHIPPING_CHARGES + SAL_DE.PAYPAL_FEE_PERC + SAL_DE.SHIPPING_CHARGES, 5) TOTAL_EXPENS, /*ASSEMBELED ITEM MATH*/ COM_SUM.LIST_PRICE SUM_LIST, COM_SUM.SOLD_PRICE SUM_SOLD, COM_SUM.EBAY_FEE SUM_EBAY, COM_SUM.PAY_FEE SUM_PAYPAL, COM_SUM.SHIP_FEE SUM_SHIP, COM_SUM.TOTAL_EXP SUM_TOTAL,COM_SUM.COMPO_PL COM_PROF FROM LZ_MANIFEST_MT K, LZ_BARCODE_MT B, LZ_BD_TRACKING_NO TR, LZ_BD_ESTIMATE_MT ES, LZ_BD_ACTIVE_DATA V, LZ_BD_PURCHASE_OFFER OFER, LZ_SALES_PULLING SAL_PUL, LZ_SALESLOAD_DET SAL_DE, LZ_DEKIT_US_MT DK,   (select LZ_DEKIT_US_MT_ID, LIST_PRICE, SOLD_PRICE, EBAY_FEE, PAY_FEE, SHIP_FEE, TOTAL_EXP, COMPO_PL FROM (SELECT LZ_DEKIT_US_MT_ID, SUM(COST) COST, SUM(LIST_PRICE) LIST_PRICE, SUM(SOLD_PRICE) SOLD_PRICE, SUM(EBAY_FEE) EBAY_FEE, SUM(PAYPAL_FEE) PAY_FEE, SUM(SHIP_FEE) SHIP_FEE, SUM(EBAY_FEE + PAYPAL_FEE + SHIP_FEE) TOTAL_EXP, SUM(DECODE(SOLD_PRICE, 0, 0, NVL(SOLD_PRICE - (EBAY_FEE + PAYPAL_FEE + SHIP_FEE + COST), 0))) COMPO_PL FROM (SELECT MT.LZ_DEKIT_US_MT_ID, B.EBAY_ITEM_ID EBAY_ID, DT.BARCODE_PRV_NO BARCODE, (SELECT CA.MPN FROM LZ_CATALOGUE_MT CA WHERE CA.CATALOGUE_MT_ID = DT.CATALOG_MT_ID) MPN, (SELECT OB.OBJECT_NAME FROM LZ_BD_OBJECTS_MT OB WHERE OB.OBJECT_ID = DT.OBJECT_ID) OBJ_NAME, ROUND(NVL(M_DET.PO_DETAIL_RETIAL_PRICE / M_DET.AVAILABLE_QTY, 0) * (DT.AVG_SELL_PRICE / (SELECT SUM(DK.AVG_SELL_PRICE) PRIC FROM LZ_DEKIT_US_DT DK WHERE DK.LZ_DEKIT_US_MT_ID = DT.LZ_DEKIT_US_MT_ID)), 2) COST, NVL(DT.AVG_SELL_PRICE, 0) AVERAGE, (SELECT MAX(EB_LIST.LIST_PRICE) FROM EBAY_LIST_MT EB_LIST WHERE EB_LIST.EBAY_ITEM_ID = B.EBAY_ITEM_ID) LIST_PRICE, NVL(SAL_DE.SALE_PRICE, 0) SOLD_PRICE, NVL(SAL_DE.EBAY_FEE_PERC, 0) EBAY_FEE, NVL(SAL_DE.PAYPAL_FEE_PERC, 0) PAYPAL_FEE, NVL(SAL_DE.SHIPPING_CHARGES, 0) SHIP_FEE FROM LZ_DEKIT_US_DT               DT, LZ_DEKIT_US_MT               MT, LZ_BARCODE_MT                MAS_BAR, LZ_BARCODE_MT                B, MPN_AVG_PRICE MPN_AVG, LZ_SALES_PULLING             SAL_PUL, LZ_SALESLOAD_DET             SAL_DE, ITEMS_MT                     I, LZ_MANIFEST_DET              M_DET WHERE DT.LZ_DEKIT_US_MT_ID = MT.LZ_DEKIT_US_MT_ID AND MT.BARCODE_NO = MAS_BAR.BARCODE_NO AND MAS_BAR.ITEM_ID = I.ITEM_ID AND I.ITEM_CODE = M_DET.LAPTOP_ITEM_CODE AND DT.BARCODE_PRV_NO = B.BARCODE_NO(+) AND DT.CATALOG_MT_ID = MPN_AVG.CATALOGUE_MT_ID(+) AND DT.CONDITION_ID = MPN_AVG.CONDITION_ID(+) AND B.PULLING_ID = SAL_PUL.PULLING_ID(+) AND SAL_PUL.SALES_RECORD_NO = SAL_DE.SALES_RECORD_NUMBER(+)) GROUP BY LZ_DEKIT_US_MT_ID) ) COM_SUM, LZ_MANIFEST_DET DETK, ITEMS_MT II, LZ_BD_ESTIMATE_DET ES_DET , LZ_LISTED_ITEM_URL EB_URL/*, LZ_CATALOGUE_MT CAT_MT */WHERE K.SINGLE_ENTRY_ID = TR.LZ_SINGLE_ENTRY_ID(+) AND B.EBAY_ITEM_ID =EB_URL.EBAY_ID(+) /*AND UPPER(DETK.ITEM_MT_MFG_PART_NO) = UPPER(CAT_MT.MPN(+)) AND DETK.E_BAY_CATA_ID_SEG6 = CAT_MT.CATEGORY_ID(+)*/ AND DETK.LAPTOP_ITEM_CODE = II.ITEM_CODE AND DETK.LZ_MANIFEST_ID = K.LZ_MANIFEST_ID AND DETK.EST_DET_ID = ES_DET.LZ_ESTIMATE_DET_ID(+) AND II.ITEM_ID = B.ITEM_ID AND ES.LZ_BD_CATAG_ID = V.LZ_BD_CATA_ID(+) AND ES.LZ_BD_CATAG_ID = OFER.LZ_BD_CATA_ID(+) AND K.EST_MT_ID = ES.LZ_BD_ESTIMATE_ID(+) AND K.LZ_MANIFEST_ID = B.LZ_MANIFEST_ID AND B.PULLING_ID = SAL_PUL.PULLING_ID(+) AND SAL_PUL.SALES_RECORD_NO = SAL_DE.SALES_RECORD_NUMBER(+) AND B.BARCODE_NO = DK.BARCODE_NO(+) AND DK.LZ_DEKIT_US_MT_ID = COM_SUM.LZ_DEKIT_US_MT_ID(+) AND K.MANIFEST_TYPE IN (1, 2)) Q1 WHERE MANIFEST_TYPE <> 0"; if($check_categ != 'all' && $check_categ != null){$sql.= " and CATEGORY_ID IN ($categ_exp) "; } if(!empty($pos_barc)){
        $sql.= " AND BARCODE_NO =$pos_barc ";
      }
      if(!empty($item_drop)){ 
        if($item_drop == 1){// for assembled item
          $sql.= " AND DK_BAR is not null ";

        }elseif($item_drop == 2){// for dekit item
          $sql.= " AND DK_BAR is  null ";
        }
      }
      if(!empty($lot_drop)){ 
        if($lot_drop == 1){// for REGULAR item
          $sql.= " AND MANIFEST_TYPE =  1 ";
        }elseif($lot_drop == 2){// for LOT item
          $sql.= " AND MANIFEST_TYPE = 2 ";
        }
      }

      if(empty($skip_dek_date)){        
        if(!empty($dk_from) && !empty($dk_to)){
          $sql.= " AND DEKIT_DATR between TO_DATE('$dk_from "."00:00:00','MM/DD/YY HH24:MI:SS') and TO_DATE('$dk_to ". "23:59:59','MM/DD/YY  HH24:MI:SS')";
          }
      }
      if(empty($Skip_list_d)){        
        if(!empty($lis_from) && !empty($lis_to)){
          $sql.= " AND LIST_DATE between TO_DATE('$lis_from "."00:00:00','MM/DD/YY HH24:MI:SS') and TO_DATE('$lis_to ". "23:59:59','MM/DD/YY  HH24:MI:SS')";
          }
      }
      if(empty($Skip_sold_d)){        
        if(!empty($sol_from) && !empty($sol_to)){
          $sql.= " AND SOLD_DATE between TO_DATE('$sol_from "."00:00:00','MM/DD/YY HH24:MI:SS') and TO_DATE('$sol_to ". "23:59:59','MM/DD/YY  HH24:MI:SS')";
          }
      }



    if( !empty($requestData['search']['value']) ) {
    // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" WHERE (EBAY_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR BARCODE_NO LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR TITLE LIKE '%".$requestData['search']['value']."%') ";  
                  
      }else{
        if(!empty($requestData['search']['value'])){
           // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" WHERE ( EBAY_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR BARCODE_NO LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR TITLE LIKE '%".$requestData['search']['value']."%' )";  
                  
        }
      }

    $query   = $this->db->query($sql); 
    $totalData     = $query->num_rows();
    $totalFiltered = $totalData;
    
    $sql .= " ORDER BY " . $columns[$requestData['order']['0']['column']] . "   " . $requestData['order']['0']['dir'];
    $sql = "SELECT  * FROM    (SELECT  q.*, ROWNUM rn FROM ($sql) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn >= ".$requestData['start'] ;
    $query         = $this->db->query($sql)->result_array();   
      
    $data          = array();
     $i = 1;
    foreach($query as $row ){ 

      $nestedData=array();      
      $nestedData[] ="<a href='".@$row['ITEM_URL']."' target='_blank' >".@$row['EBAY_ID']."</a>";
      $nestedData[] = $row['BARCODE_NO'];
      $nestedData[] = $row['ITEM_TITLE'];
      $nestedData[] = '<div class="pull-right">$ '. number_format((float)@$row['OFFER_AMOUNT'],2,'.',',').'</div>';
      $nestedData[] = '<div class="pull-right">$ '. number_format((float)@$row['COST_PRICE'],2,'.',',').'</div>';
      $nestedData[] ='<div class="pull-right">$ '. number_format((float)@$row['AVG_PRICE'],2,'.',',').'</div>';
      $nestedData[] = '<div class="pull-right">$ '. number_format((float)@$row['PROFITLOS'],2,'.',',').'</div>';
      $nestedData[] = '<div class="pull-right">'. number_format((float)@$row['PROFITPERCNT'],2,'.',',').' %</div>';
      // profit percent
      // KIT AVG AND PL CALULATION START 
      $nestedData[] = '<div class="pull-right">$ '. number_format((float)@$row['KIT_AVG'],2,'.',',').'</div>';
      $nestedData[] = '<div class="pull-right">$ '. number_format((float)@$row['KITPROFLOS'],2,'.',',').'</div>';
      // KIT AVG AND PL CALULATION END 
      // ASSEMBLE ITEM MATH VALUES START
      $nestedData[] = '<div class="pull-right">$ '. number_format((float)@$row['COST_PRICE'],2,'.',',').'</div>';
      $nestedData[] = '<div class="pull-right">$ '. number_format((float)@$row['LIST_PRICE'],2,'.',',').'</div>';
      $nestedData[] = '<div class="pull-right">$ '. number_format((float)@$row['SOLD_PRICE'],2,'.',',').'</div>';
      $nestedData[] = '<div class="pull-right">$ '. number_format((float)@$row['COMP_EBAY_FEE'],2,'.',',').'</div>';
      $nestedData[] = '<div class="pull-right">$ '. number_format((float)@$row['COMP_PAYPAL_FEE'],2,'.',',').'</div>';
      $nestedData[] = '<div class="pull-right">$ '. number_format((float)@$row['COMP_SHIP_FEE'],2,'.',',').'</div>';
      $nestedData[] = '<div class="pull-right">$ '. number_format((float)@$row['TOTAL_EXPENS'],2,'.',',').'</div>';
      $nestedData[] = '<div class="pull-right">$ '. number_format((float)@$row['PROL'],2,'.',',').'</div>';
      // ASSEMBLED ITEM MATH VALUES END 
      $nestedData[] = $row['DEKIT_DATR'];
      $nestedData[] = $row['LIST_DATE'];
      $nestedData[] = $row['SOLD_DATE'];
      $chek_est_id = $row['DK_BAR']; /// estimate _id
      $nestedData[] = '<div class="pull-right">$ '. number_format((float)@$row['COST_PRICE'],2,'.',',').'</div>';
      $nestedData[] = '<div class="pull-right">$ '. number_format((float)@$row['LIST'],2,'.',',').'</div>';
      $nestedData[] = '<div class="pull-right">$ '. number_format((float)@$row['SOLD'],2,'.',',').'</div>';
      $nestedData[] = '<div class="pull-right">$ '. number_format((float)@$row['EBAY'],2,'.',',').'</div>';
      $nestedData[] = '<div class="pull-right">$ '. number_format((float)@$row['PAYPAL'],2,'.',',').'</div>';
      $nestedData[] = '<div class="pull-right">$ '. number_format((float)@$row['SHIP'],2,'.',',').'</div>';
      $nestedData[] = '<div class="pull-right">$ '. number_format((float)@$row['COM_PROFIT'],2,'.',',').'</div>';
    
      $nestedData[] = '<div class="pull-right">$ '. number_format((float)@$row['TOTAL_EXP'],2,'.',',').'</div>';
      
      if(!empty($chek_est_id)){
          $nestedData[] ="<i class='fa fa-plus-square details-control' aria-hidden='true' det_id = ".$row['DK_BAR']." ></i>";
        }      
        else{
          $nestedData[] = "not available";
       }
                   
      $data[] = $nestedData;        
 
    $i++;
    } //// end main foreach

    $json_data = array(
      "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
      "recordsTotal" => intval($totalData), // total number of records
      "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "deferLoading" =>  intval( $totalFiltered ),
      "data" => $data // total data array
    );
    return $json_data;


}

public function dekt_barcode_details(){

  $det_id = $this->input->post('det_id'); 

  $dek_qry = $this->db->query(" SELECT EBAY_ID, BARCODE, MPN, OBJ_NAME, COST, AVERAGE, LIST, SOLD_PRICE, EBAY_FEE, PAYPAL_FEE, SHIP_FEE, DECODE (SOLD_PRICE,0,0,NVL(SOLD_PRICE - (EBAY_FEE + PAYPAL_FEE + SHIP_FEE + COST), 0)) PL, EBAY_FEE + PAYPAL_FEE + SHIP_FEE TOTAL_EXPENS FROM (SELECT B.EBAY_ITEM_ID EBAY_ID, DT.BARCODE_PRV_NO BARCODE, (SELECT CA.MPN FROM LZ_CATALOGUE_MT CA WHERE CA.CATALOGUE_MT_ID = DT.CATALOG_MT_ID) MPN, (SELECT OB.OBJECT_NAME FROM LZ_BD_OBJECTS_MT OB WHERE OB.OBJECT_ID = DT.OBJECT_ID) OBJ_NAME, ROUND(NVL(M_DET.PO_DETAIL_RETIAL_PRICE/ M_DET.AVAILABLE_QTY, 0) * (DT.AVG_SELL_PRICE / (SELECT SUM(DK.AVG_SELL_PRICE) PRIC FROM LZ_DEKIT_US_DT DK WHERE DK.LZ_DEKIT_US_MT_ID = DT.LZ_DEKIT_US_MT_ID)), 2) COST, NVL(DT.AVG_SELL_PRICE, 0) AVERAGE, (SELECT MAX(EB_LIST.LIST_PRICE) FROM EBAY_LIST_MT EB_LIST WHERE EB_LIST.EBAY_ITEM_ID = B.EBAY_ITEM_ID) LIST, NVL(SAL_DE.SALE_PRICE, 0) SOLD_PRICE, NVL(SAL_DE.EBAY_FEE_PERC, 0) EBAY_FEE, NVL(SAL_DE.PAYPAL_FEE_PERC, 0) PAYPAL_FEE, NVL(SAL_DE.SHIPPING_CHARGES, 0) SHIP_FEE FROM LZ_DEKIT_US_DT DT, LZ_DEKIT_US_MT MT, LZ_BARCODE_MT  MAS_BAR, LZ_BARCODE_MT B, MPN_AVG_PRICE MPN_AVG, LZ_SALES_PULLING             SAL_PUL, LZ_SALESLOAD_DET SAL_DE, ITEMS_MT I, LZ_MANIFEST_DET M_DET WHERE DT.LZ_DEKIT_US_MT_ID = $det_id AND DT.LZ_DEKIT_US_MT_ID = MT.LZ_DEKIT_US_MT_ID AND MT.BARCODE_NO = MAS_BAR.BARCODE_NO AND MAS_BAR.ITEM_ID  = I.ITEM_ID AND I.ITEM_CODE = M_DET.LAPTOP_ITEM_CODE AND DT.BARCODE_PRV_NO = B.BARCODE_NO(+)AND DT.CATALOG_MT_ID = MPN_AVG.CATALOGUE_MT_ID(+) AND DT.CONDITION_ID = MPN_AVG.CONDITION_ID(+) AND B.PULLING_ID = SAL_PUL.PULLING_ID(+) AND SAL_PUL.SALES_RECORD_NO = SAL_DE.SALES_RECORD_NUMBER(+)) ")->result_array(); return $dek_qry; 

   return $dek_qry; //array('deks_qry' => $deks_qry);
}


  public function load_mpn_price(){

    $search_key = $this->session->userdata('search_key');
    $exclude_key = $this->session->userdata('exclude_key');
        
     $exclude_key = strtoupper($exclude_key);
     $str1=explode(',' ,$exclude_key);
    
    // var_dump($str);
    // exit;

    $exc_key='';
    foreach($str1 as $val){
    $val = strtoupper($val);
    $exc_key.= "And UPPER(TITLE) NOT LIKE '%$val%'";
    }
    $mpn_cata = $this->session->userdata('mpn_cata');
    $get_cond = $this->session->userdata('get_cond');

    $search_key = trim(str_replace("'","''", $search_key));
    $search_key = strtoupper($search_key);
    $str = explode(' ', $search_key);

    $requestData= $_REQUEST;
    
    $columns = array( 
    // datatable column index  => database column name
      0 =>'EBAY_ID',
      1 =>'TITLE',
      2 =>'MPN',
      3 =>'MPN_DESCRIPTION',
      4 =>'CONDITION_NAME',
      5 =>'SALE_PRICE',
      6 =>'BRAND'

    );

    $table = 'LZ_BD_CATAG_DATA_'.$mpn_cata;

    if(!empty($mpn_cata)){
    $sql1 = $this->db->query("SELECT D.EBAY_ID EBAY_ID,D.TITLE TITLE, CA.MPN MPN, CA.MPN_DESCRIPTION MPN_DESCRIPTION,CONDITION_NAME CONDITION_NAME,SALE_PRICE SALE_PRICE FROM $table  D ,LZ_CATALOGUE_MT CA WHERE  D.CATALOGUE_MT_ID = CA.CATALOGUE_MT_ID(+) AND SALE_TIME >= SYSDATE - 90 ");
  }else{
    $sql1 = $this->db->query(" SELECT D.EBAY_ID EBAY_ID,D.TITLE TITLE, CA.MPN MPN, CA.MPN_DESCRIPTION MPN_DESCRIPTION,CONDITION_NAME CONDITION_NAME,SALE_PRICE SALE_PRICE FROM LZ_BD_CATAG_DATA_177 D ,LZ_CATALOGUE_MT CA WHERE  D.CATALOGUE_MT_ID = CA.CATALOGUE_MT_ID(+)  AND SALE_TIME >= SYSDATE - 90 and ROWNUM <=0 ");
  }

    $totalData = $sql1->num_rows();
    // var_dump($totalData);exit;
    //$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
    

    if(!empty($mpn_cata)){
    $sql = " SELECT D.EBAY_ID EBAY_ID,D.ITEM_URL ITEM_URL,D.TITLE TITLE, CA.MPN MPN,CA.BRAND, CA.MPN_DESCRIPTION MPN_DESCRIPTION,CONDITION_NAME CONDITION_NAME,SALE_PRICE SALE_PRICE FROM $table  D ,LZ_CATALOGUE_MT CA WHERE  D.CATALOGUE_MT_ID = CA.CATALOGUE_MT_ID(+) AND SALE_TIME >= SYSDATE - 90 ";

    }
    else{
      $sql = " SELECT D.EBAY_ID EBAY_ID,D.TITLE TITLE, CA.MPN MPN, CA.MPN_DESCRIPTION MPN_DESCRIPTION,CONDITION_NAME CONDITION_NAME,SALE_PRICE SALE_PRICE FROM LZ_BD_CATAG_DATA_177 D ,LZ_CATALOGUE_MT CA WHERE  D.CATALOGUE_MT_ID = CA.CATALOGUE_MT_ID(+)  AND SALE_TIME >= SYSDATE - 90 and ROWNUM <=0";
    }
    // else{
    // $sql = " SELECT D.*,CA.MPN,CA.MPN_DESCRIPTION FROM LZ_BD_CATAG_DATA_177,LZ_CATALOGUE_MT CA WHERE  D.CATALOGUE_MT_ID = CA.CATALOGUE_MT_ID(+) ";
    // }

    if(!empty($search_key) ) {   // if there is a search parameter, $search_key contains search parameter
        if (count($str)>1) {
          $i=1;
          foreach ($str as $key) {
            if($i === 1){
              $sql.=" and UPPER(TITLE) LIKE '%$key%' ";
            }else{
              $sql.=" AND UPPER(TITLE) LIKE '%$key%' ";
            }
            $i++;
          }
        }else{
          $sql.=" and UPPER(TITLE) LIKE '%$search_key%' ";
        }
    }

    if(!empty($exclude_key)){
      $sql.=$exc_key;
    }
    if(!empty($get_cond)){    

      $sql.=" and CONDITION_ID = $get_cond ";
      }

      if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
         $sql.=" AND (upper(MPN_DESCRIPTION) LIKE upper('%".$requestData['search']['value']."%')";  
         $sql.=" OR   upper(TITLE) LIKE upper('%".$requestData['search']['value']."%') ";  
         $sql.=" OR   EBAY_ID LIKE '".$requestData['search']['value']."' ";
         $sql.=" OR   SALE_PRICE LIKE '".$requestData['search']['value']."' ";
         $sql.=" OR   CONDITION_NAME LIKE '".$requestData['search']['value']."' ";
         $sql.=" OR   MPN LIKE '".$requestData['search']['value']."')";
      }

    $query = $this->db->query($sql);
    
    //$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
    $totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
     $sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
     /*================================================
     =            for oracle 11g or bellow  it also words on 12c          =
     ================================================*/
     //$sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($sql) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'];   
     
     /*=====  End of for oracle 11g or bellow  ======*/
     
    /*=======================================
    =            For Oracle 12-c            =
    =======================================*/
    $sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($sql) q ) OFFSET ".$requestData['start']." ROWS FETCH NEXT ".$requestData['length']."ROWS ONLY" ;
    /*=====  End of For Oracle 12-c  ======*/
    
    $query = $this->db->query($sql);
    $query = $query->result_array();
    $data = array();
    $i = 1;
    foreach($query as $row ){ 
      
      $nestedData=array();
      
      $nestedData[] ="<a href='".@$row['ITEM_URL']."' target='_blank' >".@$row['EBAY_ID']."</a>";
      $nestedData[] = $row['TITLE'];
      $nestedData[] = $row['MPN'];
      $nestedData[] = $row['MPN_DESCRIPTION'];
      $nestedData[] = $row['CONDITION_NAME'];
      
      
      $nestedData[] = '<div class="pull-right">$ '. number_format((float)@$row['SALE_PRICE'],2,'.',',').'</div>';
      $nestedData[] = $row['BRAND'];
    $data[] = $nestedData;

      $i++;
    }//end foreach

    $json_data = array(
          "draw"            => intval($requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
          "recordsTotal"    =>  intval($totalData),  // total number of records
          "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
          //"deferLoading" =>  intval( $totalFiltered ),
          "data"            => $data   // total data array
          
          );
    return $json_data;


  }

  // method for v_mpn_price view end

public function mpn_price_update (){
  $search_key = $this->session->userdata('search_key');
  $search_key = trim(str_replace("'","''", $search_key));
  $search_key = strtoupper($search_key);
  $str = explode(' ', $search_key);
  $exclude_key = $this->session->userdata('exclude_key');
  $exclude_key = trim(str_replace("'","''", $exclude_key));
  $exclude_key = strtoupper($exclude_key);
  $get_mpn = $this->input->post('get_mpn');
  $get_new_obj = $this->input->post('get_obj');
  $get_desc = $this->input->post('get_desc');
  $get_upc = $this->input->post('get_upc');
  $get_brand = $this->input->post('get_brand');
  $get_brand = trim(str_replace("'","''", $get_brand));
  $get_brand = strtoupper($get_brand);

  //$get_pric = $this->input->post('get_pric');
  $mpn_cata = $this->session->userdata('mpn_cata');

  $insert_by = $this->session->userdata('user_id');
        date_default_timezone_set("America/Chicago");
            $date = date('Y-m-d H:i:s');
            $insert_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";


    /// object
    
    $get_obj = $this->db->query("SELECT OB.OBJECT_ID FROM LZ_BD_OBJECTS_MT OB WHERE UPPER(OB.OBJECT_NAME) =upper('$get_new_obj') and ob.category_id =$mpn_cata ");

      if($get_obj->num_rows() > 0 ){

      $get_obj = $get_obj->result_array();

      $get_obj = $get_obj[0]['OBJECT_ID'];
      $get_new_obj = $get_obj;     

      }else{      

      $obj_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_OBJECTS_MT','OBJECT_ID') OBJECT_ID FROM DUAL");
        $get_mt_pk = $obj_id->result_array();
        $object_id = $get_mt_pk[0]['OBJECT_ID'];

        $this->db->query("INSERT INTO LZ_BD_OBJECTS_MT(OBJECT_ID, OBJECT_NAME,INSERT_DATE,INSERT_BY, CATEGORY_ID) VALUES($object_id, '$get_new_obj',$insert_date,$insert_by, $mpn_cata)");
        $get_new_obj = $object_id; //storing object id
    }             

    ///object

   if (!empty($get_mpn)) {
      $item_mpn = strtoupper($get_mpn);
     $mpn_data = $this->db->query("SELECT MT.CATALOGUE_MT_ID, MT.MPN, MT.BRAND, MT.MPN_DESCRIPTION FROM LZ_CATALOGUE_MT MT WHERE UPPER(MT.MPN) = '$item_mpn' AND MT.CATEGORY_ID = $mpn_cata");
    if($mpn_data->num_rows() == 0){
        $get_mt_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') ID FROM DUAL");
        //$get_mt_pk = $this->db->query("SELECT MAX(CATALOGUE_MT_ID + 1) CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT");
        $get_pk = $get_mt_pk->result_array();
        $cat_mt_id = $get_pk[0]['ID'];

        $this->db->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY,OBJECT_ID,MPN_DESCRIPTION,BRAND,UPC) VALUES($cat_mt_id, '$get_mpn', $mpn_cata, $insert_date, $insert_by,$get_new_obj,'$get_desc','$get_brand','$get_upc')");
        $get_id = $cat_mt_id;
        
     }else{
      $get_mpn = $mpn_data->result_array();
      $get_id = $get_mpn[0]['CATALOGUE_MT_ID'];


     }
  }

/*=============================================
=            create/update keyword            =
=============================================*/
    $feedName                 = $search_key;
    $feedName                 = trim(str_replace("  ", ' ', $feedName));
    $feedName                 = str_replace(array("`,′"), "", $feedName);
    $feedName                 = str_replace(array("'"), "''", $feedName);
    $keyword                  = $search_key;
    $keyword                  = trim(str_replace("  ", ' ', $keyword));
    $keyword                  = str_replace(array("`,′"), "", $keyword);
    $keyword                  = str_replace(array("'"), "''", $keyword);
    $excludedWords            = $exclude_key;
    $excludedWords            = trim(str_replace("  ", ' ', $excludedWords));
    $excludedWords            = str_replace(array("`,′"), "", $excludedWords);
    $excludedWords            = str_replace(array("'"), "''", $excludedWords);
    $category_id              = $mpn_cata;
    $catalogue_mt_id          = $get_id;
    $rss_feed_cond            = 0;
    $rss_listing_type         = 'BIN';
    $min_price                = NULL;
    $max_price                = NULL;
    $zipCode                  = NULL;
    $withIn                   = NULL;
    $feed_type                = 30;//lookup feed is is 30 in lz_bd_purchasing_flag
    $seller_filter            = NULL;
    $seller_name              = NULL;
    $feed_cond = $mpn_cata;
    $created_by = $this->session->userdata('user_id');
    date_default_timezone_set("America/Chicago");
    $created_date = date("Y-m-d H:i:s");
    $created_date= "TO_DATE('".$created_date."', 'YYYY-MM-DD HH24:MI:SS')";
    $exclude_words = '';
    if (strpos($excludedWords, ',') !== false) {
          $excludedWords = explode(',', $excludedWords);
          //var_dump(count($excludedWords));
          if(count($excludedWords) >2){
            foreach ($excludedWords as $word) {
              $exclude_words .= ' -'.trim($word);
            }
          }else{
               $exclude_words = ' -'.trim($excludedWords[0]);
          }
        }elseif(!empty($excludedWords)){
          $exclude_words = ' -'.$excludedWords;
        }

    $auto_created = 0;



$pro_call = $this->db->query("CALL PRO_VERIFIED_MPN_FEED_URL('$keyword','$catalogue_mt_id','$category_id','$feedName','$feed_cond','$min_price','$max_price','$rss_listing_type','$created_by',$created_date,'$exclude_words',$auto_created,'$withIn','$zipCode','$seller_filter','$seller_name','$feed_type')");


/*=====  End of create/update keyword  ======*/

  $table = 'LZ_BD_CATAG_DATA_'.$mpn_cata;
  $sql = ("UPDATE $table  SET CATALOGUE_MT_ID = $get_id");

   if(!empty($search_key) ) {   // if there is a search parameter, $search_key contains search parameter
        if (count($str)>1) {
          $i=1;
          foreach ($str as $key) {
            if($i === 1){
              $sql.=" WHERE UPPER(TITLE) LIKE '%$key%' ";
            }else{
              $sql.=" AND UPPER(TITLE) LIKE '%$key%' ";
            }
            $i++;
          }
        }else{
          $sql.=" where UPPER(TITLE) LIKE '%$search_key%' ";
        }
    }


  $this->db->query($sql);


}
public function save_object (){
  $sav_objct = $this->input->post('sav_objct');
  $mpn_cata = $this->input->post('mpn_cata');

  $insert_by = $this->session->userdata('user_id');
        date_default_timezone_set("America/Chicago");
            $date = date('Y-m-d H:i:s');
            $insert_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

 $get_obj = $this->db->query("SELECT OB.OBJECT_ID FROM LZ_BD_OBJECTS_MT OB WHERE UPPER(OB.OBJECT_NAME) =upper('$sav_objct') and ob.category_id =$mpn_cata ");

      if($get_obj->num_rows()  == 0 ){         
     $obj_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_OBJECTS_MT','OBJECT_ID') OBJECT_ID FROM DUAL");
        $get_mt_pk = $obj_id->result_array();
        $object_id = $get_mt_pk[0]['OBJECT_ID'];

        $sav_object_mt = $this->db->query("INSERT INTO LZ_BD_OBJECTS_MT(OBJECT_ID, OBJECT_NAME,INSERT_DATE,INSERT_BY, CATEGORY_ID) VALUES($object_id, '$sav_objct',$insert_date,$insert_by, $mpn_cata)");
        
          return true;
 
         }else{
          
            return false;
        }
 

  }

public function get_mpn_avg(){
  $exclude_key = $this->input->post('exclude_key');
  $condition_id = $this->input->post('get_cond');
  if(!empty($condition_id)){
    $cond_clouse = ' AND CONDITION_ID ='.$condition_id;
  }else{
     $cond_clouse = '';
  }
  $str=explode(',' ,$exclude_key);
  $exc_key='';
  foreach($str as $val){
    $val = trim(str_replace("'","''", $val));
    $val = strtoupper($val);
    $exc_key.= " AND UPPER(TITLE) NOT LIKE '%$val%'";
  }

  $search_key = $this->session->userdata('search_key');
  $search_key = trim(str_replace("'","''", $search_key));
  $search_key = strtoupper($search_key);
  $str = explode(' ', $search_key);  

  $mpn_cata = $this->session->userdata('mpn_cata');
  $table = 'LZ_BD_CATAG_DATA_'.$mpn_cata;

  $sql = ("SELECT ' $' ||ROUND(NVL(AVG(SALE_PRICE+SHIPPING_COST),0),2)  SALE_PRICE,COUNT(1) QTY_SOLD FROM $table WHERE SALE_TIME >= SYSDATE - 90 AND LOTSONLY = 0 AND IS_DELETED = 0".$cond_clouse);

  if(!empty($search_key) ) {   // if there is a search parameter, $search_key contains search parameter
        if (count($str)>1) {
          $i=1;
          foreach ($str as $key) {
            if($i === 1){
              $sql.=" AND UPPER(TITLE) LIKE '%$key%' ";
            }else{
              $sql.=" AND UPPER(TITLE) LIKE '%$key%' ";
            }
            $i++;
          }
        }else{
          $sql.=" AND UPPER(TITLE) LIKE '%$search_key%' ";
        }
    }
     //var_dump($sql,$exc_key);
    if(!empty($exclude_key)){
   
    $sql.=$exc_key;
  }
  //var_dump($sql.' ORDER BY LZ_BD_CATA_ID DESC) WHERE ROWNUM <= 100',$exc_key);exit;
    $sql = $this->db->query($sql); 
    $sql = $sql->result_array();
    

  return array('sql'=> $sql);


}
public function get_avg_price(){
  $exclude_key = $this->input->post('exclude_key');
  $condition_id = $this->input->post('get_cond');
  if(!empty($condition_id)){
    $cond_clouse = ' AND CONDITION_ID ='.$condition_id;
  }else{
     $cond_clouse = '';
  }
  $str=explode(',' ,$exclude_key);
  $exc_key='';
  foreach($str as $val){
    $val = trim(str_replace("'","''", $val));
    $val = strtoupper($val);
    $exc_key.= " AND UPPER(TITLE) NOT LIKE '%$val%'";
  }

  $search_key = $this->session->userdata('search_key');
  $search_key = trim(str_replace("'","''", $search_key));
  $search_key = strtoupper($search_key);
  $str = explode(' ', $search_key);  

  $mpn_cata = $this->session->userdata('mpn_cata');
  $table = 'LZ_BD_CATAG_DATA_'.$mpn_cata;

  $sql = ("SELECT '$ ' ||ROUND(NVL(AVG(SALE_PRICE+SHIPPING_COST),0),2)  SALE_PRICE,COUNT(1) QTY_SOLD FROM (SELECT SALE_PRICE,SHIPPING_COST FROM $table WHERE SALE_TIME >= SYSDATE - 90 AND LOTSONLY = 0 AND IS_DELETED = 0".$cond_clouse);

  if(!empty($search_key) ) {   // if there is a search parameter, $search_key contains search parameter
        if (count($str)>1) {
          $i=1;
          foreach ($str as $key) {
            if($i === 1){
              $sql.=" AND UPPER(TITLE) LIKE '%$key%' ";
            }else{
              $sql.=" AND UPPER(TITLE) LIKE '%$key%' ";
            }
            $i++;
          }
        }else{
          $sql.=" AND UPPER(TITLE) LIKE '%$search_key%' ";
        }
    }
     //var_dump($sql,$exc_key);
    if(!empty($exclude_key)){
   
    $sql.=$exc_key;
  }
  //var_dump($sql.' ORDER BY LZ_BD_CATA_ID DESC) WHERE ROWNUM <= 100',$exc_key);exit;
    $sql = $this->db->query($sql.' ORDER BY LZ_BD_CATA_ID DESC) WHERE ROWNUM <= 100'); 
    $sql = $sql->result_array();
    

  return array('sql'=> $sql);


}

 public function pic_report(){

  $emp_id =  $this->input->post('emp_id');
  $this->session->set_userdata('get_emp_id', $emp_id);


  $filt_date =  $this->input->post('filt_date');
  $this->session->set_userdata('filt_data', $filt_date);

  $rs = explode('-',$filt_date);
            $fromdate = @$rs[0];
            $todate = @$rs[1];

            /*===Convert Date in 24-Apr-2016===*/
            $fromdate = date_create(@$rs[0]);
            $todate = date_create(@$rs[1]);

            $from = date_format(@$fromdate,'m/d/Y');
            $to = date_format(@$todate, 'm/d/Y');
            $sys_date = date('m/d/Y');

           // var_dump($from,$to);
            //exit;


    $get_pic_sumar = " SELECT COUNT(F_NAME) F_NAME, SUM(NO_PIC) NO_PIC, SUM(NO_OF_BAR) NO_OF_BAR, USER_NAME,PIC_BY FROM (SELECT MIN(FOLDER_NAME) F_NAME, MIN(NO_OF_PIC) NO_PIC, COUNT(BARCODE_NO) NO_OF_BAR, USER_NAME,PIC_BY FROM (SELECT L.*, TO_DATE(TO_CHAR(L.PIC_DATE, 'DD/MM/YY'), 'DD/MM/YY') DATEE, M.USER_NAME, ROUND((L.PIC_DATE - NVL(LAG(L.PIC_DATE) OVER(ORDER BY L.PIC_DATE), L.PIC_DATE)) * 24 * 60, 2) ELAPSED_TIME_IN_MIN FROM LZ_PIC_LOG L, EMPLOYEE_MT M WHERE L.PIC_BY = M.EMPLOYEE_ID ";
    if(!empty($filt_date)){

       $get_pic_sumar.= " and TO_DATE(TO_CHAR(L.PIC_DATE, 'MM/DD/YY'), 'MM/DD/YY') between
                       to_date('$from', 'MM/DD/YY') and
                       to_date('$to', 'MM/DD/YY')";
    }else{
       $get_pic_sumar.= " and TO_DATE(TO_CHAR(L.PIC_DATE, 'MM/DD/YY'), 'MM/DD/YY') between
                       to_date('$sys_date', 'MM/DD/YY') and
                       to_date('$sys_date', 'MM/DD/YY')";

    }

      $get_pic_sumar.=" ) GROUP BY FOLDER_NAME, USER_NAME ,PIC_BY)  ";
      if(!empty($emp_id)){    
      $get_pic_sumar.=" where  PIC_BY = $emp_id";
      }
      $get_pic_sumar.=" GROUP BY USER_NAME,PIC_BY";

    $get_res = $this->db->query($get_pic_sumar)->result_array(); 

    $get_emp = $this->db->query("  SELECT M.EMPLOYEE_ID,M.USER_NAME FROM EMPLOYEE_MT M  ")->result_array();

    return array('get_res' => $get_res,'get_emp' => $get_emp);

  }

   public function pic_report_detail(){

    $filt_date = $this->session->userdata('filt_data');
    $rs = explode('-',$filt_date);
            $fromdate = @$rs[0];
            $todate = @$rs[1];

            /*===Convert Date in 24-Apr-2016===*/
            $fromdate = date_create(@$rs[0]);
            $todate = date_create(@$rs[1]);

            $from = date_format(@$fromdate,'m/d/Y');
            $to = date_format(@$todate, 'm/d/Y');
            $sys_date = date('m/d/Y');


    $user_id  = $this->uri->segment(4);

    $get_pic_sumar_det_quer = "SELECT L.FOLDER_NAME,MIN(L.NO_OF_PIC)NO_OF_PIC,COUNT(L.BARCODE_NO) NO_OF_BAR, TO_CHAR(L.PIC_DATE,'DD/MM/YY HH24:MI:SS') PICTUR_DATE, ROUND((L.PIC_DATE - NVL(LAG(L.PIC_DATE) OVER(ORDER BY L.PIC_DATE), L.PIC_DATE)) * 24 * 60, 2) TIM_DIFF, TO_CHAR(TRUNC((((86400 * ((L.PIC_DATE - NVL(LAG(L.PIC_DATE) OVER(ORDER BY L.PIC_DATE), L.PIC_DATE)))) / 60) / 60) / 24)) || 'D ' || TO_CHAR(TRUNC(((86400 * ((L.PIC_DATE - NVL(LAG(L.PIC_DATE) OVER(ORDER BY L.PIC_DATE), L.PIC_DATE)))) / 60) / 60) - 24 * (TRUNC((((86400 * ((L.PIC_DATE - NVL(LAG(L.PIC_DATE) OVER(ORDER BY L.PIC_DATE), L.PIC_DATE)))) / 60) / 60) / 24))) || ' H :' || TO_CHAR(TRUNC((86400 * ((L.PIC_DATE - NVL(LAG(L.PIC_DATE) OVER(ORDER BY L.PIC_DATE), L.PIC_DATE)))) / 60) - 60 * (TRUNC(((86400 * ((L.PIC_DATE - NVL(LAG(L.PIC_DATE) OVER(ORDER BY L.PIC_DATE), L.PIC_DATE)))) / 60) / 60))) || ' M :' || TO_CHAR(TRUNC(86400 * ((L.PIC_DATE - NVL(LAG(L.PIC_DATE) OVER(ORDER BY L.PIC_DATE), L.PIC_DATE)))) - 60 * (TRUNC((86400 * ((L.PIC_DATE - NVL(LAG(L.PIC_DATE) OVER(ORDER BY L.PIC_DATE), L.PIC_DATE)))) / 60))) || ' S '  TIM_DIFF, M.USER_NAME FROM LZ_PIC_LOG L, EMPLOYEE_MT M WHERE L.PIC_BY = M.EMPLOYEE_ID and L.PIC_BY = $user_id ";

      if(!empty($filt_date)){

       $get_pic_sumar_det_quer.= " and TO_DATE(TO_CHAR(L.PIC_DATE, 'MM/DD/YY'), 'MM/DD/YY') between
                       to_date('$from', 'MM/DD/YY') and
                       to_date('$to', 'MM/DD/YY')";
    }else{
       $get_pic_sumar_det_quer.= " and TO_DATE(TO_CHAR(L.PIC_DATE, 'MM/DD/YY'), 'MM/DD/YY') between
                       to_date('$sys_date', 'MM/DD/YY') and
                       to_date('$sys_date', 'MM/DD/YY')";
    }      

      $get_pic_sumar_det_quer.= " GROUP BY L.FOLDER_NAME,L.PIC_DATE,M.USER_NAME ORDER BY L.PIC_DATE ";

      $get_pic_sumar_det = $this->db->query($get_pic_sumar_det_quer)->result_array();

      

    return array('get_pic_sumar_det' => $get_pic_sumar_det);
  }
}

?>