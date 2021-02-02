<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Single Entry Model
 */
class m_recycle extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function lz_recyle_form()
    {
        $full_name = html_escape(trim($this->input->post('full_name')));

        $email = html_escape(trim($this->input->post('email')));
        $phone = html_escape(trim($this->input->post('phone')));
        $remarks = html_escape(trim($this->input->post('remarks')));
        $images = $_FILES['images'];
        
        $query = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('lzw_rec_pickup', 'REC_ID')ID FROM DUAL")->result_array();
        $pk = $query[0]['ID'];

        $stat_query = $this->db->query("INSERT INTO  
            lzw_rec_pickup(REC_ID,  REC_FIRST_NAME, REC_LAST_NAME, REC_EMAIL, REC_PHONE, REC_REMARKS,REC_INSERTED_DATE) 
                values 
                    ($pk,
                    '$full_name',
                    '$full_name',
                    '$email',
                    '$phone',
                    '$remarks',
                    sysdate
                    )");
         if($stat_query){
            $query = $this->db->query("SELECT c.MASTER_PATH from lz_pict_path_config c where c.path_id = 8");
            $specific_qry = $query->result_array();
            $specific_path = $specific_qry[0]['MASTER_PATH'];
            // $specific_path = "E:/wamp/www/item_pictures/recycle_pics/";
            if(isset($_FILES['images'])){
            $main_dir =  $specific_path . $pk;
            if (is_dir($main_dir) === false) {
                mkdir($main_dir);
            }
            foreach ($images['name'] as $key => $value) {
                $_FILES['file']['name'] = $_FILES['images']['name'][$key];
                $_FILES['file']['type'] = $_FILES['images']['type'][$key];
                $_FILES['file']['tmp_name'] = $_FILES['images']['tmp_name'][$key];
                $_FILES['file']['error'] = $_FILES['images']['error'][$key];
                $_FILES['file']['size'] = $_FILES['images']['size'][$key];
                $config['upload_path'] = $main_dir; 
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size'] = '10000'; // max_size in kb
                $new_name = $pk.'_recycle';
                $config['file_name'] = $new_name;
                $this->load->library('upload',$config); 
                $this->upload->do_upload('file');
                }
            }
            
            return true;
         }   else{
             return false;
         }        
    }
    public function save_pull_request()
    {
        $requestId = html_escape(trim($this->input->post('requestId')));
        $getRadioVale = html_escape(trim($this->input->post('getRadioVale')));

        $save = $this->db->query(" UPDATE LZW_REPAIRE_MT SET SELECT_OPTION ='$getRadioVale'  where REPAIRE_MT_ID = (SELECT REP_ID
          FROM (SELECT 'REP-' || LPAD(NVL(RM.REPAIRE_MT_ID, 0), 6, '0') REPAIR_ID,RM.REPAIRE_MT_ID REP_ID
                  FROM LZW_REPAIRE_MT RM) where UPPER(REPAIR_ID)='$requestId' )");
        if($save){
            $query = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('lzw_dropoffs', 'ID')ID FROM DUAL")->result_array();
            $pk = $query[0]['ID'];
            $stat_query = $this->db->query("INSERT INTO  
            lzw_dropoffs(ID,  REQUEST_ID, CREATED_AT, UPDATED_AT) 
                values 
                    ($pk,
                    '$requestId',
                    sysdate,
                    sysdate)");
            if($stat_query){
                return array(
                    "save" => true,
                    "message" => "Successfully save !");
            } else{
                return array(
                    "save" => false,
                    "message" => "Updated but no save !");
            }       
           
        }else{
            return array(
                "save" => false,
                "message" => "Something went wrong !");
        }
    
    }
    
}
?>    