<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class m_CodexModel extends CI_Model{
    /*
     * get rows from the files table
     */
    function getRows($params = array()){
        $query = $this->db->query('SELECT * FROM ITEM_PICTURES_MT WHERE ROWNUM=1');       
        return $img_data= $query->result();
    }

}