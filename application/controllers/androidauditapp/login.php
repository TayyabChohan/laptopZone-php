<?php 

  class login extends CI_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->database();
  }
 
  public function index()
{

    // $username = "ali";
    // $password = "ali";
    if (isset($_POST['username']) && isset($_POST['password']))
    {

      $username = $_POST['username'];
      $password = $_POST['password'];
      $response= array();
      $main_query = "select m.employee_id,
      (m.first_name || ' ' || m.last_name) name,
      m.user_name,
      m.pass_word
      from employee_mt m
      where 
      m.user_name ='$username' 
      and 
      m.pass_word ='$password' ";
      $row = $this->db->query($main_query)->result_array();
     // array_push($response,array(
       //   "error"=>false,
       //   "api_message"=>"Login Successfully!",
       //   "login_data"=>$row[0]
        // ));
      // $name = @$row[0]["NAME"];
      // echo $name;
      if (count($row) > 0)
      {
        echo(json_encode(array(
          "error"=>false,
          "api_message"=>"Login Successfully!",
          "login_data"=>$row[0]
         )));
      }
      else
      {
        echo(json_encode(array(
          "error"=>true,
          "api_message"=>"Wrong Cradentials!"
         )));
      }
      
     }
    else 
   {
    echo(json_encode(array(
      "error"=>true,
      "api_message"=>"Empty Paraeters!"
    )));
    }
    
}

}