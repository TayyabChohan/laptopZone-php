<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
class m_bigDataTest extends CI_Model {
  public function categoryListData() {
    $query_data = $this->db->query("SELECT * FROM LZ_BD_CATEGORY");
    $result     = $query_data->result_array();
    $arr        = arra();
    //$a=array("red","green");
    foreach ($result as $category_id) {
      //var_dump($category_id);exit;
      $count_qry = $this->db->query("SELECT COUNT(1) AS TOTAL_ROWS FROM LZ_BD_CATAG_DATA C WHERE C.MAIN_CATEGORY_ID = " . $category_id['CATEGORY_ID']);
      $count     = $count_qry->result_array();
      $c         = $count[0]['TOTAL_ROWS'];
      //var_dump($count[0]['TOTAL_ROWS']);exit;
      array_push($arr, $c);
    }
    //$category_id = $query_data[0]['CATEGORY_ID'];
    //var_dump($arr);exit;
    return array(
      'query_data' => $result,
      'count_qry' => $arr
    );
  }
  public function loadData() {
    $requestData = $_REQUEST;
    $columns     = array(
      // datatable column index  => database column name
      0 => 'LZ_BD_CATEGORY_ID',
      1 => 'CATEGORY_NAME',
      2 => 'CATEGORY_ID',
      3 => 'LISTING_TYPE',
      4 => 'CONDITION',
      5 => 'SELLER_ID',
      6 => 'KEYWORD',
      7 => 'INSERTED_DATE',
      8 => 'ENTERED_BY',
      9 => 'LISTING_FILTER',
      10 => 'GLOBAL_ID'
    );
    $sql = $this->db->query("SELECT LZ_BD_CATEGORY_ID, CATEGORY_NAME, CATEGORY_ID, LISTING_TYPE, SELLER_ID, CONDITION, KEYWORD, INSERTED_DATE, ENTERED_BY, LISTING_FILTER, GLOBAL_ID FROM LZ_BD_CATEGORY");
    $totalData     = $sql->num_rows();
    $totalFiltered = $totalData;
    $sql ="SELECT LZ_BD_CATEGORY_ID, CATEGORY_NAME, CATEGORY_ID, LISTING_TYPE, SELLER_ID, CONDITION, KEYWORD, INSERTED_DATE, ENTERED_BY, LISTING_FILTER, GLOBAL_ID FROM LZ_BD_CATEGORY";
        if (!empty($requestData['search']['value'])) { // if there is a search parameter, $requestData['search']['value'] contains search parameter
      $sql .= " WHERE ( CATEGORY_NAME LIKE '%" . $requestData['search']['value'] . "%' ";
      $sql .= " OR CATEGORY_ID LIKE '" . $requestData['search']['value'] . "' ";
      $sql .= " OR LISTING_TYPE LIKE '" . $requestData['search']['value'] . "' ";
      $sql .= " OR CONDITION LIKE '%" . $requestData['search']['value'] . "%' ";
      $sql .= " OR SELLER_ID LIKE '%" . $requestData['search']['value'] . "%' ";
      $sql .= " OR KEYWORD LIKE '%" . $requestData['search']['value'] . "%' ";
      $sql .= " OR INSERTED_DATE LIKE '%" . $requestData['search']['value'] . "%' ";
      $sql .= " OR ENTERED_BY LIKE '%" . $requestData['search']['value'] . "%' ";
      $sql .= " OR LISTING_FILTER LIKE '%" . $requestData['search']['value'] . "%' ";
      $sql .= " OR GLOBAL_ID LIKE '" . $requestData['search']['value'] . "' )";
    }
    // when there is no search parameter then total number rows = total number filtered rows. 
    //$sql .= " ORDER BY " . $columns[$requestData['order']['0']['column']] . "   " . $requestData['order']['0']['dir'];
    //$sql="SELECT * FROM ($sql) WHERE ROWNUM <= 100"; 
    //$sql           = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM  ($sql) q ) WHERE   rn BETWEEN " . $requestData['start'] . " AND " . $requestData['length'];
   $sql = "SELECT  * FROM    (SELECT  q.*, ROWNUM rn FROM ($sql) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn >= ".$requestData['start'] ;
   //print_r($sql);
   //exit;
    //echo $sql;
    /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
    //$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
    $query         = $this->db->query($sql);
   /* $totalData     = $query->num_rows();
    $totalFiltered = $totalData;*/
    $data          = array();
    $i=1;
    foreach ($query->result_array() as $row) { // preparing an array

      $nestedData   = array();
      $nestedData[] = "<div class='edit_btun' style='width: 120px; height: auto;'><a title='Delete Record' href='" . base_url() . "bigData/c_bigData/deleteBdCategory" . $row['LZ_BD_CATEGORY_ID'] . "' onclick='return confirm('Are you sure to delete?');' class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>&nbsp;<a title='Edit Record' href='".base_url()."bigData/c_bigData/editBdCategory/".$row['LZ_BD_CATEGORY_ID']."' class='btn btn-warning btn-xs'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a>&nbsp;<a title='Pull Data' href='".base_url()."bigData/c_bigData/pullAllCategoryData/".$row['CATEGORY_ID']."' onclick='return confirm('Are you sure to want Pull Data?');' class='btn btn-success btn-xs' target='_blank'><i class='fa fa-download' aria-hidden='true'></i></a>&nbsp;<a target='_blank' href='".base_url()."bigData/c_bigData/showDetailData/".$row['CATEGORY_ID']."'  class='btn btn-primary btn-xs' title='Show Detail'><i style=' cursor: pointer;' class='fa fa-external-link' aria-hidden='true'></i></a>&nbsp;&nbsp; <input type='submit' value='Run BatchFile' class='ct btn btn-xs btn-success' id='bt".$i."' /><input type='hidden' class='cat_id' id='cat_id".$i."' value='".$row['CATEGORY_ID']."' /> </div>";
      $nestedData[] = $row["CATEGORY_ID"];
      $nestedData[] = $row["CATEGORY_NAME"];
      $condition= $row["CONDITION"];
      if(@$condition == 3000){
            $nestedData[] ='Used';
          }elseif(@$condition == 1000){
            $nestedData[] ='New'; 
          }elseif(@$condition == 1500){
            $nestedData[] ='New other'; 
          }elseif(@$condition == 2000){
             $nestedData[] ='Manufacturer refurbished';
          }elseif(@$condition == 2500){
            $nestedData[] ='Seller refurbished'; 
          }elseif(@$condition == 7000){
            $nestedData[] ='For parts or not working'; 
          }elseif (@$condition == 0) {
            $nestedData[] ='All'; 
          }
      $nestedData[] = $row["SELLER_ID"];
      $nestedData[] = $row["GLOBAL_ID"];
      $nestedData[] = $row["KEYWORD"];
      $nestedData[] = $row["LISTING_FILTER"];
      $nestedData[] = $row["LISTING_TYPE"];
      $nestedData[] = $row["INSERTED_DATE"];
            $count_qry = $this->db->query("SELECT COUNT(1) AS TOTAL_ROWS FROM LZ_BD_CATAG_DATA C WHERE C.MAIN_CATEGORY_ID = " . $row['CATEGORY_ID']);
            $count     = $count_qry->result_array();
      $nestedData[] = $count[0]['TOTAL_ROWS'];
      $data[]       = $nestedData;
      $i++;
    }//endforeach
    $json_data = array(
      "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
      "recordsTotal" => intval($totalData), // total number of records
      "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "data" => $data // total data array
    );
    return $json_data;
  }
  public function saveCategoryData() {
    $categoryId    = $this->input->post('categoryId');
    $category_name = $this->input->post('category_name');
    $condition     = $this->input->post('condition');
    $seller_id     = $this->input->post('seller_id');
    $keyword       = $this->input->post('keyword');
    $global_id     = $this->input->post('global_id');
    date_default_timezone_set("America/Chicago");
    $inserted_date     = date("Y-m-d H:i:s");
    $inserted_date     = "TO_DATE('" . $inserted_date . "', 'YYYY-MM-DD HH24:MI:SS')";
    $entered_by        = $this->session->userdata('user_id');
    $listing_filter    = $this->input->post('listing_filter');
    $listing_type      = $this->input->post('listing_type');
    $type              = implode(', ', $listing_type);
    // var_dump($type);exit;
    $coma              = ',';
    $qry_data          = $this->db->query("SELECT get_single_primary_key('LZ_BD_CATEGORY','LZ_BD_CATEGORY_ID') LZ_BD_CATEGORY_ID FROM DUAL");
    $rs                = $qry_data->result_array();
    $lz_bd_category_id = $rs[0]['LZ_BD_CATEGORY_ID'];
    $query             = $this->db->query("INSERT INTO LZ_BD_CATEGORY (LZ_BD_CATEGORY_ID, CATEGORY_ID, CATEGORY_NAME, CONDITION, SELLER_ID, GLOBAL_ID, KEYWORD, INSERTED_DATE, ENTERED_BY, LISTING_FILTER, LISTING_TYPE) VALUES($lz_bd_category_id $coma $categoryId $coma '$category_name' $coma $condition $coma '$seller_id' $coma  '$global_id' $coma '$keyword' $coma $inserted_date $coma $entered_by $coma '$listing_filter' $coma '$type')");
    if ($query) {
      $this->session->set_flashdata('success', 'Record Inserted Successfully.');
    } else {
      $this->session->set_flashdata('error', 'Record Not Inserted.');
    }
  }
  public function showDetailData($category_id) {
    $query = $this->db->query("SELECT LZ_BD_CATA_ID, CATEGORY_ID, EBAY_ID, TITLE, CONDITION_ID, CONDITION_NAME, ITEM_URL, SALE_PRICE, LISTING_TYPE, START_TIME, SALE_TIME, SELLER_ID, STATUS, FEEDBACK_SCORE, CATEGORY_NAME, CURRENCY_ID FROM LZ_BD_CATAG_DATA WHERE MAIN_CATEGORY_ID = $category_id");
    if ($query->num_rows() > 0) {
                    return $query->result_array();
    } else {
      $query = $this->db->query("SELECT LZ_BD_CATA_ID, CATEGORY_ID, EBAY_ID, TITLE, CONDITION_ID, CONDITION_NAME, ITEM_URL, SALE_PRICE, LISTING_TYPE, START_TIME, SALE_TIME, SELLER_ID, STATUS, FEEDBACK_SCORE, CATEGORY_NAME, CURRENCY_ID FROM LZ_BD_CATAG_DATA WHERE CATEGORY_ID = $category_id");
      return $query->result_array();
    }
  }
  public function load_data() {
    $requestData   = $_REQUEST;
    $category_id   = $this->input->post('category_id');
    //var_dump($requestData['order']);//exit;
    $columns       = array(
      // datatable column index  => database column name
      0 => 'LZ_BD_CATA_ID',
      1 => 'CATEGORY_NAME',
      2 => 'CATEGORY_ID',
      3 => 'EBAY_ID',
      5 => 'CONDITION_NAME',
      6 => 'SELLER_ID',
      7 => 'LISTING_TYPE',
      8 => 'SALE_PRICE',
      9 => 'START_TIME',
      10 => 'SALE_TIME',
      11 => 'FEEDBACK_SCORE'
    );
    $sql           = $this->db->query("SELECT LZ_BD_CATA_ID, CATEGORY_ID, EBAY_ID, TITLE, CONDITION_NAME, ITEM_URL, SALE_PRICE, LISTING_TYPE, START_TIME, SALE_TIME, SELLER_ID, FEEDBACK_SCORE, CATEGORY_NAME, CURRENCY_ID FROM LZ_BD_CATAG_DATA WHERE MAIN_CATEGORY_ID = $category_id");
    $totalData     = $sql->num_rows();
    $totalFiltered = $totalData; // when there is no search parameter then total number rows = total number filtered rows.
    $sql           = "SELECT LZ_BD_CATA_ID, CATEGORY_ID, EBAY_ID, TITLE, CONDITION_NAME, ITEM_URL, SALE_PRICE, LISTING_TYPE, START_TIME, SALE_TIME, SELLER_ID, FEEDBACK_SCORE, CATEGORY_NAME, CURRENCY_ID ";
    $sql .= " FROM LZ_BD_CATAG_DATA WHERE MAIN_CATEGORY_ID = $category_id";
    if (!empty($requestData['search']['value'])) { // if there is a search parameter, $requestData['search']['value'] contains search parameter
      $sql .= " AND ( CATEGORY_NAME LIKE '%" . $requestData['search']['value'] . "%' ";
      $sql .= " OR CATEGORY_ID LIKE '" . $requestData['search']['value'] . "' ";
      $sql .= " OR MAIN_CATEGORY_ID LIKE '" . $requestData['search']['value'] . "' ";
      $sql .= " OR TITLE LIKE '%" . $requestData['search']['value'] . "%' ";
      $sql .= " OR CONDITION_NAME LIKE '%" . $requestData['search']['value'] . "%' ";
      $sql .= " OR SELLER_ID LIKE '%" . $requestData['search']['value'] . "%' ";
      $sql .= " OR LISTING_TYPE LIKE '%" . $requestData['search']['value'] . "%' ";
      $sql .= " OR START_TIME LIKE '%" . $requestData['search']['value'] . "%' ";
      $sql .= " OR SALE_TIME LIKE '%" . $requestData['search']['value'] . "%' ";
      $sql .= " OR EBAY_ID LIKE '" . $requestData['search']['value'] . "' )";
    }
    $query         = $this->db->query($sql);
    //$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
    $totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
    $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'];
    //$sql="SELECT * FROM ($sql) WHERE ROWNUM <= 100"; 
    $sql   = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($sql) q ) WHERE   rn BETWEEN " . $requestData['start'] . " AND " . $requestData['length'];
    /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
    //$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
    $query = $this->db->query($sql);
    //$query->result_array();
    $data  = array();
    foreach ($query->result_array() as $row) { // preparing an array
      $listing_type = $row['LISTING_TYPE'];
      if ($listing_type == 'FixedPrice') {
        $listing_type = "BIN";
      } elseif ($listing_type == 'StoreInventory') {
        $listing_type = "BIN/Best Offer";
      }
      $nestedData   = array();
      $nestedData[] = "<a title='Delete Record' href='" . base_url() . "BundleKit/c_bk_webhook/deleteWebhookDetail/" . $row['EBAY_ID'] . "' onclick='return confirm('Are you sure to delete?');' class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>";
      $nestedData[] = $row["CATEGORY_NAME"];
      $nestedData[] = $row["CATEGORY_ID"];
      $nestedData[] = "<a target='_blank' href='" . $row['ITEM_URL'] . "'>" . $row['EBAY_ID'] . "</a>";
      //$nestedData[] = $row["EBAY_ID"];
      $nestedData[] = $row["TITLE"];
      $nestedData[] = $row["CONDITION_NAME"];
      $nestedData[] = $row["SELLER_ID"];
      $nestedData[] = $listing_type;
      $nestedData[] = '$ ' . number_format((float) @$row['SALE_PRICE'], 2, '.', ',');
      //$nestedData[] = $row["SALE_PRICE"];
      $nestedData[] = $row["START_TIME"];
      $nestedData[] = $row["SALE_TIME"];
      $nestedData[] = $row["FEEDBACK_SCORE"];
      $data[]       = $nestedData;
    }
    $json_data = array(
      "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
      "recordsTotal" => intval($totalData), // total number of records
      "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "data" => $data // total data array
    );
    return $json_data;
  }
  public function pullCategoryData($lz_bd_category_id) {
    $cat_qry = $this->db->query("SELECT * FROM LZ_BD_CATEGORY WHERE LZ_BD_CATEGORY_ID = $lz_bd_category_id");
    $cat_qry = $cat_qry->result_array();
    return $cat_qry;
  }
  public function editBdCategory($perameter) {
    $query = $this->db->query("SELECT * FROM LZ_BD_CATEGORY C WHERE C.LZ_BD_CATEGORY_ID = $perameter");
    return $query->result_array();
  }
  public function updateBdCategory() {
    $lz_bd_category_id = $this->input->post('lz_bd_category_id');
    //var_dump($lz_bd_category_id);exit;
    $categoryId        = $this->input->post('categoryId');
    $category_name     = $this->input->post('category_name');
    $condition         = $this->input->post('condition');
    $seller_id         = $this->input->post('seller_id');
    $keyword           = $this->input->post('keyword');
    $global_id         = $this->input->post('global_id');
    date_default_timezone_set("America/Chicago");
    $inserted_date  = date("Y-m-d H:i:s");
    $inserted_date  = "TO_DATE('" . $inserted_date . "', 'YYYY-MM-DD HH24:MI:SS')";
    $entered_by     = $this->session->userdata('user_id');
    $listing_filter = $this->input->post('listing_filter');
    $listing_type   = $this->input->post('listing_type');
    $type           = implode(', ', $listing_type);
    $query          = $this->db->query("UPDATE LZ_BD_CATEGORY C SET C.CATEGORY_ID = $categoryId, C.CATEGORY_NAME = '$category_name', C.CONDITION = $condition, C.SELLER_ID = '$seller_id', C.GLOBAL_ID = '$global_id', C.KEYWORD = '$keyword', C.INSERTED_DATE = $inserted_date, C.ENTERED_BY = $entered_by, C.LISTING_FILTER = '$listing_filter', C.LISTING_TYPE = '$type' WHERE C.LZ_BD_CATEGORY_ID = $lz_bd_category_id");
    if ($query) {
      $this->session->set_flashdata('success', 'Record Updated Successfully.');
    } else {
      $this->session->set_flashdata('error', 'Record Not Updated.');
    }
  }
  public function deleteBdCategory($perameter) {
    //$query = $this->db->query("");
  }
  public function categoryTreeview() {
    // $query = $this->db2->query("SELECT LPAD(W.CATEGORY_ID, 14, '0')  AS ID , W.CATEGORY_NAME, LPAD(W.PARENT_CAT_ID, 14, '0') || DECODE(W.PARENT_CAT_ID,NULL,'0') AS PARENT_ID FROM LZ_BD_CATEGORY_TREE  W ORDER BY PARENT_ID"); 
    $query = $this->db2->query("SELECT T.CATEGORY_ID ID, LPAD(' ', 3 * LEVEL) || T.CATEGORY_NAME CATEGORY_NAME, T.PARENT_CAT_ID PARENT_ID FROM LZ_BD_CATEGORY_TREE T START WITH T.PARENT_CAT_ID IS NULL CONNECT BY PRIOR T.CATEGORY_ID = T.PARENT_CAT_ID ");
    // AND T.PARENT_CAT_ID NOT IN (267, 12576, 619, 26395)
    return $query->result_array();
  }
  public function searchCategoryTree() {
    $category_id = $this->input->post('category_id');
    $this->session->set_userdata('category_id', $category_id);
    //$query = $this->db2->query("SELECT C.CATEGORY_ID ID, C.CATEGORY_NAME, C.PARENT_CAT_ID PARENT_ID FROM LZ_BD_CATEGORY_TREE C WHERE C.CATEGORY_ID = $category_id ORDER BY PARENT_ID"); 
    $query = $this->db2->query("SELECT T.CATEGORY_ID ID, LPAD(' ', 3 * LEVEL) || T.CATEGORY_NAME CATEGORY_NAME, T.PARENT_CAT_ID PARENT_ID FROM LZ_BD_CATEGORY_TREE T START WITH T.CATEGORY_ID = $category_id CONNECT BY PRIOR T.CATEGORY_ID = T.PARENT_CAT_ID"); // AND T.PARENT_CAT_ID NOT IN (267, 12576, 619, 26395)
    return $query->result_array();
  }
  // public function otherCategoriesTree(){
  //  // $other_qry = $this->db2->query("SELECT T.CATEGORY_ID ID, LPAD(' ', 3 * LEVEL) || T.CATEGORY_NAME CATEGORY_NAME, T.PARENT_CAT_ID PARENT_ID FROM LZ_BD_CATEGORY_TREE T START WITH T.PARENT_CAT_ID IS NULL CONNECT BY PRIOR T.CATEGORY_ID = T.PARENT_CAT_ID AND T.PARENT_CAT_ID IN (267, 12576, 619, 26395, 58058, 15032, 293, 1249, 220, 625)");
  //  // return $other_qry->result_array();
  // }
}