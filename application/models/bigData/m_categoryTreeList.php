<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
class m_categoryTreeList extends CI_Model {
 


  public function categoryTreeList() {

    $toys = $this->db2->query("SELECT T.CATEGORY_ID ID, T.CATEGORY_NAME CATEGORY_NAME, T.PARENT_CAT_ID FROM LZ_BIGDATA.LZ_BD_CATEGORY_TREE T WHERE T.PARENT_CAT_ID = 220");
    //$toys_count=$this->db->query("SELECT COUNT(*) TOTAL FROM LZ_BD_CATAG_DATA C WHERE C.MAIN_CATEGORY_ID = 111422")->result_array();
    //$toys_sale=$this->db->query("SELECT MAX(TO_CHAR(T.SALE_TIME, 'DD/MM/YYYY HH24:MI:SS')) as SALE_TIME FROM LZ_BD_CATAG_DATA T WHERE T.MAIN_CATEGORY_ID=111422")->result_array();
    //////////////////////////////////////////////////////////////////////
    $books = $this->db2->query("SELECT T.CATEGORY_ID ID, T.CATEGORY_NAME CATEGORY_NAME, T.PARENT_CAT_ID FROM LZ_BIGDATA.LZ_BD_CATEGORY_TREE T WHERE T.PARENT_CAT_ID = 267");
    //$books_count=$this->db->query("SELECT COUNT(*) TOTAL FROM LZ_BD_CATAG_DATA C WHERE C.MAIN_CATEGORY_ID = 267")->result_array();
    //$books_sale=$this->db->query("SELECT MAX(TO_CHAR(T.SALE_TIME, 'DD/MM/YYYY HH24:MI:SS')) as SALE_TIME FROM LZ_BD_CATAG_DATA T WHERE T.MAIN_CATEGORY_ID=267")->result_array();
    /////////////////////////////////////////////////////////////////////
    $jewelry = $this->db2->query("SELECT T.CATEGORY_ID ID, T.CATEGORY_NAME CATEGORY_NAME, T.PARENT_CAT_ID FROM LZ_BIGDATA.LZ_BD_CATEGORY_TREE T WHERE T.PARENT_CAT_ID = 281");
    //$jewelry_count=$this->db->query("SELECT COUNT(*) TOTAL FROM LZ_BD_CATAG_DATA C WHERE C.MAIN_CATEGORY_ID = 281")->result_array();
    //$jewelry_sale=$this->db->query("SELECT MAX(TO_CHAR(T.SALE_TIME, 'DD/MM/YYYY HH24:MI:SS')) as SALE_TIME FROM LZ_BD_CATAG_DATA T WHERE T.MAIN_CATEGORY_ID=281")->result_array();
    ////////////////////////////////////////////////////////////////////
    $electronics = $this->db2->query("SELECT T.CATEGORY_ID ID, T.CATEGORY_NAME CATEGORY_NAME, T.PARENT_CAT_ID FROM LZ_BIGDATA.LZ_BD_CATEGORY_TREE T WHERE T.PARENT_CAT_ID = 293");
    //$electronics_count=$this->db->query("SELECT COUNT(*) TOTAL FROM LZ_BD_CATAG_DATA C WHERE C.MAIN_CATEGORY_ID = 293")->result_array();
    //$electronics_sale=$this->db->query("SELECT MAX(TO_CHAR(T.SALE_TIME, 'DD/MM/YYYY HH24:MI:SS')) as SALE_TIME FROM LZ_BD_CATAG_DATA T WHERE T.MAIN_CATEGORY_ID=293")->result_array();
    ////////////////////////////////////////////////////////////////////
    $music = $this->db2->query("SELECT T.CATEGORY_ID ID, T.CATEGORY_NAME CATEGORY_NAME, T.PARENT_CAT_ID FROM LZ_BIGDATA.LZ_BD_CATEGORY_TREE T WHERE T.PARENT_CAT_ID = 619");
    //$music_count=$this->db->query("SELECT COUNT(*) TOTAL FROM LZ_BD_CATAG_DATA C WHERE C.MAIN_CATEGORY_ID = 619")->result_array();
    //$music_sale=$this->db->query("SELECT MAX(TO_CHAR(T.SALE_TIME, 'DD/MM/YYYY HH24:MI:SS')) as SALE_TIME FROM LZ_BD_CATAG_DATA T WHERE T.MAIN_CATEGORY_ID=619")->result_array();
    ////////////////////////////////////////////////////////////////////
    $camera = $this->db2->query("SELECT T.CATEGORY_ID ID, T.CATEGORY_NAME CATEGORY_NAME, T.PARENT_CAT_ID FROM LZ_BIGDATA.LZ_BD_CATEGORY_TREE T WHERE T.PARENT_CAT_ID = 625");
    //$camera_count=$this->db->query("SELECT COUNT(*) TOTAL FROM LZ_BD_CATAG_DATA C WHERE C.MAIN_CATEGORY_ID = 625")->result_array();
    //$camera_sale=$this->db->query("SELECT MAX(TO_CHAR(T.SALE_TIME, 'DD/MM/YYYY HH24:MI:SS')) as SALE_TIME FROM LZ_BD_CATAG_DATA T WHERE T.MAIN_CATEGORY_ID=625")->result_array();
    ///////////////////////////////////////////////////////////////////
    $games = $this->db2->query("SELECT T.CATEGORY_ID ID, T.CATEGORY_NAME CATEGORY_NAME, T.PARENT_CAT_ID FROM LZ_BIGDATA.LZ_BD_CATEGORY_TREE T WHERE T.PARENT_CAT_ID = 1249");
    //$games_count=$this->db->query("SELECT COUNT(*) TOTAL FROM LZ_BD_CATAG_DATA C WHERE C.MAIN_CATEGORY_ID = 1249")->result_array();
    //$games_sale=$this->db->query("SELECT MAX(TO_CHAR(T.SALE_TIME, 'DD/MM/YYYY HH24:MI:SS')) as SALE_TIME FROM LZ_BD_CATAG_DATA T WHERE T.MAIN_CATEGORY_ID=1249")->result_array();
    ///////////////////////////////////////////////////////////////////
    $clothing = $this->db2->query("SELECT T.CATEGORY_ID ID, T.CATEGORY_NAME CATEGORY_NAME, T.PARENT_CAT_ID FROM LZ_BIGDATA.LZ_BD_CATEGORY_TREE T WHERE T.PARENT_CAT_ID = 11450");
    //$clothing_count=$this->db->query("SELECT COUNT(*) TOTAL FROM LZ_BD_CATAG_DATA C WHERE C.MAIN_CATEGORY_ID = 11450")->result_array();
    //$clothing_sale=$this->db->query("SELECT MAX(TO_CHAR(T.SALE_TIME, 'DD/MM/YYYY HH24:MI:SS')) as SALE_TIME FROM LZ_BD_CATAG_DATA T WHERE T.MAIN_CATEGORY_ID=11450")->result_array();
    //////////////////////////////////////////////////////////////////
    $business = $this->db2->query("SELECT T.CATEGORY_ID ID, T.CATEGORY_NAME CATEGORY_NAME, T.PARENT_CAT_ID FROM LZ_BIGDATA.LZ_BD_CATEGORY_TREE T WHERE T.PARENT_CAT_ID = 12576");
    //$business_count=$this->db->query("SELECT COUNT(*) TOTAL FROM LZ_BD_CATAG_DATA C WHERE C.MAIN_CATEGORY_ID = 12576")->result_array();
    //$business_sale=$this->db->query("SELECT MAX(TO_CHAR(T.SALE_TIME, 'DD/MM/YYYY HH24:MI:SS')) as SALE_TIME FROM LZ_BD_CATAG_DATA T WHERE T.MAIN_CATEGORY_ID=12576")->result_array();
    //////////////////////////////////////////////////////////////////
    $accessory = $this->db2->query("SELECT T.CATEGORY_ID ID, T.CATEGORY_NAME CATEGORY_NAME, T.PARENT_CAT_ID FROM LZ_BIGDATA.LZ_BD_CATEGORY_TREE T WHERE T.PARENT_CAT_ID = 15032");
    //$accessory_count=$this->db->query("SELECT COUNT(*) TOTAL FROM LZ_BD_CATAG_DATA C WHERE C.MAIN_CATEGORY_ID = 15032")->result_array();
    //$accessory_sale=$this->db->query("SELECT MAX(TO_CHAR(T.SALE_TIME, 'DD/MM/YYYY HH24:MI:SS')) as SALE_TIME FROM LZ_BD_CATAG_DATA T WHERE T.MAIN_CATEGORY_ID=15032")->result_array();
    //////////////////////////////////////////////////////////////////
    $health = $this->db2->query("SELECT T.CATEGORY_ID ID, T.CATEGORY_NAME CATEGORY_NAME, T.PARENT_CAT_ID FROM LZ_BIGDATA.LZ_BD_CATEGORY_TREE T WHERE T.PARENT_CAT_ID = 26395 ");
    //$health_count=$this->db->query("SELECT COUNT(*) TOTAL FROM LZ_BD_CATAG_DATA C WHERE C.MAIN_CATEGORY_ID = 26395")->result_array();
    //$health_sale=$this->db->query("SELECT MAX(TO_CHAR(T.SALE_TIME, 'DD/MM/YYYY HH24:MI:SS')) as SALE_TIME FROM LZ_BD_CATAG_DATA T WHERE T.MAIN_CATEGORY_ID=26395")->result_array();
    //////////////////////////////////////////////////////////////////
    $computers = $this->db2->query("SELECT T.CATEGORY_ID ID, T.CATEGORY_NAME CATEGORY_NAME, T.PARENT_CAT_ID FROM LZ_BIGDATA.LZ_BD_CATEGORY_TREE T WHERE T.PARENT_CAT_ID = 58058");
    //$computers_count=$this->db->query("SELECT COUNT(*) TOTAL FROM LZ_BD_CATAG_DATA C WHERE C.MAIN_CATEGORY_ID = 58058")->result_array();
    //$computers_sale=$this->db->query("SELECT MAX(TO_CHAR(T.SALE_TIME, 'DD/MM/YYYY HH24:MI:SS')) as SALE_TIME FROM LZ_BD_CATAG_DATA T WHERE T.MAIN_CATEGORY_ID=58058")->result_array();

    return array(
                  'toys'=>$toys,
                  //'toys_count'=>$toys_count,
                  //'toys_sale'=>$toys_sale,
                  'books'=>$books,
                  //'books_count'=>$books_count,
                  //'books_sale'=>$books_sale,
                  'jewelry'=>$jewelry,
                  //'jewelry_count'=>$jewelry_count,
                  //'jewelry_sale'=>$jewelry_sale,
                  'electronics'=>$electronics,
                  //'electronics_count'=>$electronics_count,
                  //'electronics_sale'=>$electronics_sale,
                  'music'=>$music,
                  //'music_count'=>$music_count,
                  //'music_sale'=>$music_sale,
                  'camera'=>$camera,
                  //'camera_count'=>$camera_count,
                  //'camera_sale'=>$camera_sale,
                  'games'=>$games,
                  //'games_count'=>$games_count,
                  //'games_sale'=>$games_sale,
                  'clothing'=>$clothing,
                  //'clothing_count'=>$clothing_count,
                  //'clothing_sale'=>$clothing_sale,
                  'business'=>$business,
                  //'business_count'=>$business_count,
                  //'business_sale'=>$business_sale,
                  'accessory'=>$accessory,
                  //'accessory_count'=>$accessory_count,
                  //'accessory_sale'=>$accessory_sale,
                  'health'=>$health,
                  //'health_count'=>$health_count,
                  //'health_sale'=>$health_sale,
                  'computers'=>$computers
                  //'computers_count'=>$computers_count,
                  //'computers_sale'=>$computers_sale
                );
  }
  public function categoryDetail($cat_id)
  {
    $details=$this->db->query("SELECT T.MAIN_CATEGORY_ID, T.CATEGORY_NAME, TO_CHAR(T.START_TIME, 'DD/MM/YYYY HH24:MI:SS') as START_TIME , TO_CHAR(T.SALE_TIME, 'DD/MM/YYYY HH24:MI:SS') as SALE_TIME, TO_CHAR(T.INSERTED_DATE, 'DD/MM/YYYY HH24:MI:SS') as INSERTED_DATE FROM LZ_BD_CATAG_DATA T WHERE T.MAIN_CATEGORY_ID=$cat_id AND ROWNUM=1");
    $count=$this->db->query("SELECT COUNT(*) TOTAL FROM LZ_BD_CATAG_DATA C WHERE C.MAIN_CATEGORY_ID = $cat_id")->result_array();
    //var_dump($count); exit;
    return array(
      "details"=>$details,
      "count"=>$count
    );
  }
   public function treeList()
    {
       $query = $this->db2->query("SELECT T.CATEGORY_ID ID, LPAD(' ', 3 * LEVEL) || T.CATEGORY_NAME CATEGORY_NAME, T.PARENT_CAT_ID PARENT_ID, get_total_count(T.CATEGORY_ID) TOTAL_COUNT FROM LZ_BD_CATEGORY_TREE T START WITH T.PARENT_CAT_ID IS NULL CONNECT BY PRIOR T.CATEGORY_ID = T.PARENT_CAT_ID ");

       // "SELECT T.CATEGORY_ID ID, LPAD(' ', 3 * LEVEL) || T.CATEGORY_NAME CATEGORY_NAME, T.PARENT_CAT_ID PARENT_ID, get_total_count(T.CATEGORY_ID) total_count, get_Last_run_date(T.CATEGORY_ID) Last_run_date FROM LZ_BD_CATEGORY_TREE T START WITH T.CATEGORY_ID = 58058 CONNECT BY PRIOR T.CATEGORY_ID = T.PARENT_CAT_ID";
       return $query->result_array();
    }


  public function searchCategoryTree() {
    $category_id = $this->input->post('category_id');
    $this->session->set_userdata('category_id', $category_id);
    //$query = $this->db2->query("SELECT C.CATEGORY_ID ID, C.CATEGORY_NAME, C.PARENT_CAT_ID PARENT_ID FROM LZ_BD_CATEGORY_TREE C WHERE C.CATEGORY_ID = $category_id ORDER BY PARENT_ID"); 
    $query = $this->db2->query("SELECT T.CATEGORY_ID ID, LPAD(' ', 3 * LEVEL) || T.CATEGORY_NAME CATEGORY_NAME, T.PARENT_CAT_ID PARENT_ID FROM LZ_BD_CATEGORY_TREE T START WITH T.CATEGORY_ID = $category_id CONNECT BY PRIOR T.CATEGORY_ID = T.PARENT_CAT_ID"); // AND T.PARENT_CAT_ID NOT IN (267, 12576, 619, 26395)
    return $query->result_array();
  }
    // public function lastRun($cat_id){
    //   $lastRun = $this->db->query("SELECT MAX(INSERTED_DATE) FROM LZ_BD_CATAG_DATA WHERE CATEGORY_ID = $cat_id");
    //   $lastRun = $lastRun->result_array();
    //   return $lastRun;
    // }
 
}