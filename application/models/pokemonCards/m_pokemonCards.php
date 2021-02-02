
<?php  
  class M_pokemonCards extends CI_Model{

    public function __construct(){
    parent::__construct();
    $this->load->database();

    // var_dump('test');
    // exit;
  }

  /// add component through brands

  public function displayAllData(){


    $requestData = $_REQUEST;
    
    $columns = array( 
    // datatable column index  => database column name
      0 => 'IMAGEURL',
      1 => 'CARD_NAME',
      2 => 'CARD_ID',
      3 => 'NATIONALPOKEDEXNUMBER',
      4 => 'CARD_TYPES',
      5 => 'CARD_SUBTYPE',
      6 => 'SUPERTYPE',
      7 => 'HP',
      8 => 'CARD_NUMBER',
      9 => 'ARTIST',
      10 => 'RARITY',
      11 => 'CARD_SERIES',
      12 => 'CARD_SET',
      13 => 'SETCODE',
      14 => 'RETREATCOST',
      15 => 'CONVERTEDRETREATCOST',
      16 => 'CARD_TEXT',
      17 => 'ATTACKDAMAGE',
      18 => 'ATTACKCOST',
      19 => 'ATTACKNAME',
      20 => 'ATTACKTEXT',
      21 => 'WEAKNESSES',
      22 => 'RESISTANCES',
      23 => 'ANCIENTTRAIT',
      24 => 'ABILITYNAME',
      25 => 'ABILITYTEXT',
      26 => 'ABILITYTYPE',
      27 => 'CONTAINS',
      
      // 28 => 'IMAGEURLHIRES',
      28 => 'ABILITY',
      29 => 'ATTACKS'

    );


    $pokemon_cards_qry = '';
    
    $pokemon_cards_qry = $this->db->query("SELECT * FROM LZ_POKEMON_CARDS"); //ORDER BY BD.INSERTED_DATE DESC

    $totalData = $pokemon_cards_qry->num_rows();
    //var_dump($totalData);exit;
    $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
    
    $sql = "SELECT * FROM LZ_POKEMON_CARDS ";


      if(!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" WHERE CARD_NAME LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR CARD_ID LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR NATIONALPOKEDEXNUMBER LIKE '".$requestData['search']['value']."' ";
          $sql.=" OR CARD_TYPES LIKE '".$requestData['search']['value']."' ";
          $sql.=" OR SUPERTYPE LIKE '".$requestData['search']['value']."' ";
          $sql.=" OR CARD_SUBTYPE LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR HP LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR CARD_NUMBER LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR ARTIST LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR RARITY LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR CARD_SERIES LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR CARD_SET LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR SETCODE LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR RETREATCOST LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR CONVERTEDRETREATCOST LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR CARD_TEXT LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR ATTACKDAMAGE LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR ATTACKCOST LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR ATTACKNAME LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR ATTACKTEXT LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR WEAKNESSES LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR RESISTANCES LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR ANCIENTTRAIT LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR ABILITYNAME LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR ABILITYTEXT LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR ABILITYTYPE LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR CONTAINS LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR IMAGEURL LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR IMAGEURLHIRES LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR ABILITY LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR ATTACKS LIKE '%".$requestData['search']['value']."%' ";
          
      }


    $query = $this->db->query($sql);
    
    //$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
    $totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
     //$sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
    //$sql="SELECT * FROM ($sql) WHERE ROWNUM <= 100"; 
    //var_dump($requestData); exit;
    $sql = "SELECT * FROM (SELECT  q.*, rownum rn FROM ($sql ORDER BY CARD_ID DESC) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn >= ".$requestData['start']." ";
    // echo $sql;
    /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
    //$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
    /*=======================================
    =            For Oracle 12-c            =
    =======================================*/
      // $sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($sql) q ) OFFSET ".$requestData['start']." ROWS FETCH NEXT ".$requestData['length']."ROWS ONLY" ;
    
    
    /*=====  End of For Oracle 12-c  ======*/
    

    
    $query = $this->db->query($sql);
    $query = $query->result_array();
    $data = array();
    // $qry = array_combine(keys, values)


    foreach($query as $row ){ 
      $nestedData=array();
      $nestedData[] ='<div style="width:120px;"><a href="'.@$row["IMAGEURLHIRES"].'" target="_blank"><img src="'.@$row["IMAGEURL"].'" alt="'.@$row["CARD_NAME"].'" height="100" width="100"></a></div>';
      $nestedData[] ='<div style="width:100px;">'.@$row["CARD_NAME"].'</div>';
      $nestedData[] ='<div style="width:80px;">'.@$row["CARD_ID"].'</div>';
      $nestedData[] ='<div style="width:80px;">'.@$row["NATIONALPOKEDEXNUMBER"].'</div>';
      $nestedData[] ='<div style="width:80px;">'.@$row["CARD_TYPES"].'</div>';
      $nestedData[] ='<div style="width:80px;">'.@$row["CARD_SUBTYPE"].'</div>';
      $nestedData[] ='<div style="width:80px;">'.@$row["SUPERTYPE"].'</div>';
      $nestedData[] ='<div style="width:80px;">'.@$row["HP"].'</div>';
      $nestedData[] ='<div style="width:80px;">'.@$row["CARD_NUMBER"].'</div>';
      $nestedData[] ='<div style="width:80px;">'.@$row["ARTIST"].'</div>';
      $nestedData[] ='<div style="width:80px;">'.@$row["RARITY"].'</div>';
      $nestedData[] ='<div style="width:80px;">'.@$row["CARD_SERIES"].'</div>';
      $nestedData[] ='<div style="width:80px;">'.@$row["CARD_SET"].'</div>';
      $nestedData[] ='<div style="width:80px;">'.@$row["SETCODE"].'</div>';
      $nestedData[] ='<div style="width:80px;">'.@$row["RETREATCOST"].'</div>';
      $nestedData[] ='<div style="width:80px;">'.@$row["CONVERTEDRETREATCOST"].'</div>';
      $nestedData[] ='<div style="width:250px;">'.@$row["CARD_TEXT"].'</div>';
      $nestedData[] ='<div style="width:80px;">'.@$row["ATTACKDAMAGE"].'</div>';
      $nestedData[] ='<div style="width:80px;">'.@$row["ATTACKCOST"].'</div>';
      $nestedData[] ='<div style="width:80px;">'.@$row["ATTACKNAME"].'</div>';
      $nestedData[] ='<div style="width:250px;">'.@$row["ATTACKTEXT"].'</div>';
      $nestedData[] ='<div style="width:80px;">'.@$row["WEAKNESSES"].'</div>';
      $nestedData[] ='<div style="width:80px;">'.@$row["RESISTANCES"].'</div>';
      $nestedData[] ='<div style="width:80px;">'.@$row["ANCIENTTRAIT"].'</div>';
      $nestedData[] ='<div style="width:80px;">'.@$row["ABILITYNAME"].'</div>';
      $nestedData[] ='<div style="width:250px;">'.@$row["ABILITYTEXT"].'</div>';
      $nestedData[] ='<div style="width:80px;">'.@$row["ABILITYTYPE"].'</div>';
      $nestedData[] ='<div style="width:80px;">'.@$row["CONTAINS"].'</div>';
      
      // $nestedData[] ='<div style="width:80px;"><img src="'.@$row["IMAGEURLHIRES"].'" alt="'.@$row["CARD_NAME"].'" height="42" width="42"></div>';
      $nestedData[] ='<div style="width:80px;">'.@$row["ABILITY"].'</div>';
      $nestedData[] ='<div style="width:80px;">'.@$row["ATTACKS"].'</div>';


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

  
}
