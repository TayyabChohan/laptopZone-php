<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
class m_categories extends CI_Model{

public function __construct(){
    parent::__construct();
    $this->load->database();
  }

 
  public function get_categories(){
    $sql = "SELECT B.CATEGORY_ID CATEGORY_ID,B.KEYWORD KEYWORD FROM LZ_BD_CATEGORY B" ;
    $query = $this->db->query($sql);
    $query = $query->result_array();
    
    $sql1 = "SELECT MT.LZ_BD_GROUP_ID,MT.GROUP_NAME,MT.INSERTED_DATE, MT.UPDATED_DATE,MT.UPDATED_BY,MT.INSERTED_BY ,M.FIRST_NAME||' '||M.LAST_NAME NAME  FROM LZ_BD_CAT_GROUP_MT MT,EMPLOYEE_MT M WHERE MT.INSERTED_BY = M.EMPLOYEE_ID(+) order by MT.LZ_BD_GROUP_ID DESC ";
     $cquery = $this->db->query($sql1);
    $cquery = $cquery->result_array();

    return array('query' =>$query ,'cquery' =>$cquery);
  }
  public function add_categories(){
  

  $cat_name = $this->input->post('category_name'); //ID
  $category = $this->input->post('category'); //ID

  $cat_group_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_CAT_GROUP_MT', 'LZ_BD_GROUP_ID')ID FROM DUAL")->result_array();
  $cat_group_pk = $cat_group_pk[0]['ID'];
    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $insert_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
    $insert_by_id = $this->session->userdata('user_id');


     $sql= $this->db->query("SELECT * FROM LZ_BD_CAT_GROUP_MT where GROUP_NAME = '$cat_name'");
     if($sql->num_rows()>0){
      $this->session->set_flashdata('category_info', ' Category Group Name Already Exist');
      redirect('categories/c_categories');
     }else{
      $query= $this->db->query ("INSERT INTO LZ_BD_CAT_GROUP_MT(LZ_BD_GROUP_ID,GROUP_NAME,INSERTED_DATE,INSERTED_BY) VALUES($cat_group_pk,
      '$cat_name',$insert_date, $insert_by_id)");


      foreach($category as $key){ // 2 
                $cat_fk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_CAT_GROUP_DET', 'LZ_BD_GROUP_DET_ID')ID FROM DUAL")->result_array();
                $cat_fk = $cat_fk[0]['ID']; 
                $this->db->query ("INSERT INTO LZ_BD_CAT_GROUP_DET(LZ_BD_GROUP_DET_ID,LZ_BD_GROUP_ID,CATEGORY_ID) values( $cat_fk,$cat_group_pk,$key)");     
        }

     }    
    // insertion fOR DETAIL TABLE
     if($query){
      $this->session->set_flashdata('category_success', ' Categories Group Details Inserted Succcessful');
      redirect('categories/c_categories');
    }
    else{
      $this->session->set_flashdata('category_error', 'Something is wrong.Please Try Again!!');
      redirect('categories/c_categories');
    }//2
    // insertion for DETAIL end
   
  }
   public function deleteGroup(){
    $group_id = $this->input->post('group_id');
    //var_dump($packing_id);
    //exit;
     $sql= $this->db->query("SELECT * FROM LZ_BD_CAT_GROUP_DET where LZ_BD_GROUP_ID =$group_id");
     if($sql->num_rows()>0){
      $query= $this->db->query("DELETE FROM LZ_BD_CAT_GROUP_DET where LZ_BD_GROUP_ID=$group_id");
     if($query){
       $this->db->query("DELETE FROM LZ_BD_CAT_GROUP_MT where LZ_BD_GROUP_ID=$group_id");
       return 1 ;
     }else{
      return 2;
     }
  }

}

 public function edit_cat_group(){
    $group_id = $this->input->post('cat_id');
    // var_dump($cat_id);
    // exit;
   $qry=$this->db->query("SELECT MT.LZ_BD_GROUP_ID,MT.GROUP_NAME,MT.INSERTED_DATE, MT.UPDATED_DATE,MT.UPDATED_BY,MT.INSERTED_BY ,M.FIRST_NAME||' '||M.LAST_NAME NAME  FROM LZ_BD_CAT_GROUP_MT MT,EMPLOYEE_MT M WHERE MT.INSERTED_BY = M.EMPLOYEE_ID(+) AND LZ_BD_GROUP_ID =$group_id")->result_array(); 
   //$results = $qry->result_array();

    $all_cats = $this->db->query("SELECT B.CATEGORY_ID CATEGORY_ID,B.KEYWORD KEYWORD FROM LZ_BD_CATEGORY B")->result_array();
   $selected_cats=$this->db->query("SELECT DT.CATEGORY_ID FROM LZ_BD_CAT_GROUP_MT MT, LZ_BD_CAT_GROUP_DET DT WHERE MT.LZ_BD_GROUP_ID = DT.LZ_BD_GROUP_ID AND MT.LZ_BD_GROUP_ID = $group_id")->result_array();
   //$category=$query->result_array();
    return array("results"=>$qry,"selected_cats"=>$selected_cats, "all_cats"=>$all_cats);
  }

public function update_cat_group(){

    $group_id = $this->input->post('group_id'); //ID
    $cat_name = $this->input->post('cat_name'); //ID
    $categories = $this->input->post('categories'); //ID
    //var_dump($group_id,$categories,$cat_name);
  
    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $update_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
    $update_by_id = $this->session->userdata('user_id');
   
    $sql= $this->db->query("SELECT * FROM LZ_BD_CAT_GROUP_MT where GROUP_NAME = '$cat_name'");
     if($sql->num_rows()>0){
       //alert('Category Group Name Already Exist');
       $this->session->set_flashdata('category_info', ' Category Group Name Already Exist');
       return 1;
     }else{


    $sql= $this->db->query("SELECT * FROM LZ_BD_CAT_GROUP_DET where LZ_BD_GROUP_ID =$group_id");
     if($sql->num_rows()>0){
      $query= $this->db->query("DELETE FROM LZ_BD_CAT_GROUP_DET where LZ_BD_GROUP_ID=$group_id");
     if($query){
  $query= $this->db->query ("UPDATE LZ_BD_CAT_GROUP_MT SET GROUP_NAME= '$cat_name', UPDATED_DATE = $update_date, UPDATED_BY = $update_by_id  WHERE  LZ_BD_GROUP_ID = $group_id");

      foreach($categories as $key){ // 2 
                $cat_fk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_CAT_GROUP_DET', 'LZ_BD_GROUP_DET_ID')ID FROM DUAL")->result_array();
                $cat_fk = $cat_fk[0]['ID']; 
                $this->db->query ("INSERT INTO LZ_BD_CAT_GROUP_DET(LZ_BD_GROUP_DET_ID,LZ_BD_GROUP_ID,CATEGORY_ID) values( $cat_fk,$group_id,$key)");     
        }

     //}   
  if($query){
      $this->session->set_flashdata('cat_update_success', ' Categories Group Details Updated Succcessful');
    }
    else{
      $this->session->set_flashdata('cat_update_error', 'Updating Failed.Please Try Again!!');
      
    }//2 
        
        }
  }



      
     }


  return $query;
 
}



}