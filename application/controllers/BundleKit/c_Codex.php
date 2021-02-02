<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Files management class created by CodexWorld
 */
class c_Codex extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('BundleKit/m_CodexModel');
    }
    
    public function index(){
        $data = array();
        
        //get files from database
        $data['files'] = $this->file->getRows();
        print
        
        //load the view
        //$this->load->view('BudleKit/codexview', $data);
    }
    
    public function download($id){
        if(!empty($id)){
            //load download helper
            $this->load->helper('download');
            
            //get file info from database
            $fileInfo = $this->file->getRows(array('id' => $id));
            
            //file path
            $file = 'assets/lpimages/'.$fileInfo['file_name'];
            
            //download file from directory
            force_download($file, NULL);
        }
    }
}