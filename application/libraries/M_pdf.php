<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
//include_once APPPATH.'\third_party\mpdf\mpdf.php';
require_once dirname(__FILE__) .'\third_party\mpdf\mpdf.php';  
class M_pdf {
 
    public $param;
    public $pdf;
 
    //public function __construct($param = '"en-GB-x","A4","","",10,10,10,10,6,3')
    public function __construct($param = '"en-GB-x","A4","","",10,10,10,10,6,3')
    {
        $this->param =$param;
        $this->pdf = new mPDF($this->param);
    }
}
// See more at: https://arjunphp.com/generating-a-pdf-in-codeigniter-using-mpdf/#sthash.YpCz9Ejx.dpuf