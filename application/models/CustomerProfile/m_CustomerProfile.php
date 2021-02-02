<?php 

  class M_CustomerProfile extends CI_Model{

    public function __construct(){
    parent::__construct();
    $this->load->database();
  } 
  
  public function customerInfo(){
      $from = date('m/d/Y', strtotime('-1 months'));// date('m/01/Y');
      $to = date('m/d/Y');
      $rslt =$from." - ".$to;
      $fromdate = date_create($from);
      $todate = date_create($to);
      $from = date_format($fromdate,'d-m-y');
      $to = date_format($todate, 'd-m-y');
      $query = $this->db->query("SELECT SHIPPING_CHARGES, SALES_RECORD_NUMBER, ITEM_ID, TRACKING_NUMBER, USER_ID, BUYER_FULLNAME, BUYER_PHONE_NUMBER, BUYER_EMAIL, BUYER_ADDRESS1, BUYER_ADDRESS2, BUYER_CITY, BUYER_STATE, BUYER_ZIP, BUYER_COUNTRY, SHIP_TO_ADDRESS1, SHIP_TO_ADDRESS2, SHIP_TO_CITY, SHIP_TO_STATE, SHIP_TO_ZIP, SHIP_TO_COUNTRY, BUYER_STREET1, BUYER_STREET2, BUYER_ADDRESS_ID FROM LZ_SALESLOAD_DET  WHERE SALE_DATE between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')"); 
     return $query->result_array();

    }
    public function CustomerProfile($parameter){
      $parameter = strtoupper($parameter);

     
      //exit;
          
      $query = $this->db->query("SELECT SHIPPING_CHARGES, SALES_RECORD_NUMBER, ITEM_ID, TRACKING_NUMBER,USER_ID, BUYER_FULLNAME, BUYER_PHONE_NUMBER, BUYER_EMAIL, BUYER_ADDRESS1, BUYER_ADDRESS2, BUYER_CITY, BUYER_STATE, BUYER_ZIP, BUYER_COUNTRY, SHIP_TO_ADDRESS1, SHIP_TO_ADDRESS2, SHIP_TO_CITY, SHIP_TO_STATE, SHIP_TO_ZIP, SHIP_TO_COUNTRY, BUYER_STREET1, BUYER_STREET2, BUYER_ADDRESS_ID FROM LZ_SALESLOAD_DET WHERE upper(USER_ID) LIKE '%$parameter%' OR upper(BUYER_FULLNAME) LIKE '%$parameter%' OR ITEM_ID LIKE '%$parameter%'  OR SALES_RECORD_NUMBER LIKE '%$parameter%'   OR BUYER_PHONE_NUMBER LIKE '%$parameter%' OR upper(BUYER_EMAIL) LIKE '%$parameter%' OR upper(BUYER_ADDRESS1) LIKE '%$parameter%' OR upper(BUYER_ADDRESS2) LIKE '%$parameter%' OR upper(BUYER_CITY) LIKE '%$parameter%' OR BUYER_ZIP LIKE '%$parameter%' OR upper(BUYER_STATE) LIKE '%$parameter%' OR upper(TRACKING_NUMBER) LIKE '%$parameter%' OR upper(BUYER_COUNTRY) LIKE '%$parameter%' OR upper(SHIP_TO_ADDRESS1) LIKE '%$parameter%' OR upper(SHIP_TO_ADDRESS2) LIKE '%$parameter%' OR upper(SHIP_TO_CITY) LIKE '%$parameter%' OR upper(SHIP_TO_STATE) LIKE '%$parameter%' OR upper(SHIP_TO_ZIP) LIKE '%$parameter%' OR upper(SHIP_TO_COUNTRY) LIKE '%$parameter%' OR upper(BUYER_ADDRESS_ID) LIKE '%$parameter%' "); 
      return $query->result_array();
              
    }

// By Danish
public function to_customerresult(){

    $requestData= $_REQUEST;
    $columns = array( 
     0 =>'SALES_RECORD_NUMBER',
     1 =>'ITEM_ID',
     2 =>'USER_ID',
     3 =>'BUYER_FULLNAME',
     4 =>'BUYER_PHONE_NUMBER',
     5 =>'BUYER_EMAIL',
     6 =>'BUYER_ADDRESS1',
     7 =>'BUYER_ADDRESS2',
     8 =>'BUYER_CITY',
     9 =>'BUYER_ZIP',
     10 =>'BUYER_STATE',
     11 =>'SHIPPING_CHARGES',
     12 =>'TRACKING_NUMBER'
    );



        $getsearch = trim($this->input->post('getsearch'));
        $getsearch= trim(str_replace("  ", ' ', $getsearch));
        $getsearch = trim(str_replace(array("'"), "''", $getsearch)); 


      // $getsearch= $this->input->post('getsearch');
        
      $from = date('m/d/Y', strtotime('-1 months'));// date('m/01/Y');
      $to = date('m/d/Y');
      $rslt =$from." - ".$to;
      $fromdate = date_create($from);
      $todate = date_create($to);
      $from = date_format($fromdate,'d-m-y');
      $to = date_format($todate, 'd-m-y');
      
      $sql ="SELECT SHIPPING_CHARGES, SALES_RECORD_NUMBER, ITEM_ID, TRACKING_NUMBER, USER_ID, BUYER_FULLNAME, BUYER_PHONE_NUMBER, BUYER_EMAIL, BUYER_ADDRESS1, BUYER_ADDRESS2, BUYER_CITY, BUYER_STATE, BUYER_ZIP, BUYER_COUNTRY, SHIP_TO_ADDRESS1, SHIP_TO_ADDRESS2, SHIP_TO_CITY, SHIP_TO_STATE, SHIP_TO_ZIP, SHIP_TO_COUNTRY, BUYER_STREET1, BUYER_STREET2, BUYER_ADDRESS_ID FROM LZ_SALESLOAD_DET  WHERE SALE_DATE between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";  

       if(!empty($requestData['search']['value'])){   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter  
        $sql.=" AND ( ITEM_ID LIKE '%".$requestData['search']['value']."%'";    
        $sql .=" OR upper(BUYER_EMAIL) LIKE upper('%".$requestData['search']['value']."%')";  
        $sql .=" OR upper(USER_ID) LIKE upper('%".$requestData['search']['value']."%')";  
        $sql .=" OR upper(BUYER_FULLNAME) LIKE upper('%".$requestData['search']['value']."%')";  
        $sql .=" OR upper(BUYER_CITY) LIKE upper('%".$requestData['search']['value']."%') ";  
        $sql .=" OR upper(BUYER_STATE) LIKE upper('%".$requestData['search']['value']."%') ";  
        $sql .=" OR upper(BUYER_ADDRESS1) LIKE upper('%".$requestData['search']['value']."%') ";  
        $sql .=" OR upper(BUYER_ADDRESS2) LIKE upper('%".$requestData['search']['value']."%') ";  
        $sql .=" OR BUYER_ZIP LIKE '%".$requestData['search']['value']."%' ";  
        $sql .=" OR ITEM_ID LIKE '%".$requestData['search']['value']."%' ";  
        $sql .=" OR BUYER_PHONE_NUMBER LIKE '%".$requestData['search']['value']."%' "; 
        $sql .=" OR SALES_RECORD_NUMBER LIKE '%".$requestData['search']['value']."%' ";   
        $sql .=" OR TRACKING_NUMBER LIKE '%".$requestData['search']['value']."%') "; 
    }

      if(!empty($getsearch)){
        $sql .= " AND USER_ID = '$getsearch'";
        $sql .= " OR upper(BUYER_FULLNAME) = upper('$getsearch')";
        $sql .= " OR BUYER_PHONE_NUMBER = '$getsearch'";
        $sql .= " OR upper(BUYER_EMAIL) = upper('$getsearch')";
        $sql .= " OR upper(BUYER_ADDRESS1) = upper('$getsearch')";
        $sql .= " OR upper(BUYER_ADDRESS2) = upper('$getsearch')";
        $sql .= " OR upper(BUYER_CITY) = upper('$getsearch')";
        $sql .= " OR BUYER_ZIP = '$getsearch'";
        $sql .= " OR upper(BUYER_STATE) = upper('$getsearch')";
        $sql .= " OR TRACKING_NUMBER = '$getsearch'";
        }
        if(is_numeric($getsearch)){
          $sql .= " OR ITEM_ID = '$getsearch'";
          $sql .= " OR SALES_RECORD_NUMBER = '$getsearch'";
        }
   
    //$sql.=" ORDER BY SALES_RECORD_NUMBER DESC";
     $query           = $this->db->query($sql);
     $totalData       = $query->num_rows();
     $totalFiltered   = $totalData; 
    //$sql="SELECT * FROM ($sql) WHERE ROWNUM <= 100";

    $sql = "SELECT * FROM (SELECT q.*, rownum rn FROM  ($sql) q )";
    $sql.= " WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'];
    $sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir'];
    $query = $this->db->query($sql);
    $query = $query->result_array();
    $data = array();
    foreach($query as $row ){ 
      $nestedData=array();
      $nestedData[]   = @$row['SALES_RECORD_NUMBER'];
      $nestedData[]   = @$row['ITEM_ID'];
      $nestedData[]   = @$row['USER_ID'];
      $nestedData[]   = @$row['BUYER_FULLNAME'];
      $nestedData[]   = @$row['BUYER_PHONE_NUMBER'];      
      $nestedData[]   = @$row['BUYER_EMAIL'];
      $nestedData[]   = @$row['BUYER_ADDRESS1'];
      $nestedData[]   = @$row['BUYER_ADDRESS2'];;
      $nestedData[]   = @$row['BUYER_CITY'];
      $nestedData[]   = @$row['BUYER_ZIP'];
      $nestedData[]   = @$row['BUYER_STATE'];
      $nestedData[]   ='$ '.number_format((float)@$row['SHIPPING_CHARGES'],2,'.',',');
      $nestedData[]   = @$row['TRACKING_NUMBER'];

      $data[]         = $nestedData;
      
    }
    $json_data = array(
          "draw"                => intval( $requestData['draw'] ),  
          // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
          "recordsTotal"        =>  intval($totalData),  // total number of records
          "recordsFiltered"     => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
          "deferLoading"        =>  intval( $totalFiltered ),
          "data"                => $data   // total data array
          );
    return $json_data;
  }
 //end Danish     
}

 ?>