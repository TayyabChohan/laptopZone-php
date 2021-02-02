<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class c_Bundlekit extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->database();
		 if(!$this->loginmodel->is_logged_in())
		     {
		       redirect('login/login/');
		     }		
	}
	public function index()
	{
		// Create headers to send with CURL request.
		/*$dev_id=5f940391-f231-422f-8dc9-e125a616249c;
		$app_id=Muhammad-bundlean-PRD-208fa563f-4079df85;
		$cert_id=PRD-08fa563fee6d-1205-402d-9f28-2e57;
		$headers = array
		(
		'X-EBAY-API-COMPATIBILITY-LEVEL: ' . $compat_level,
		'X-EBAY-API-DEV-NAME: ' . $dev_id,
		'X-EBAY-API-APP-NAME: ' . $app_id,
		'X-EBAY-API-CERT-NAME: ' . $cert_id,
		'X-EBAY-API-CALL-NAME: ' . $call_name, 
		'X-EBAY-API-SITEID: ' . $site_id,
		);*/

		$this->load->view("BundleKit/v_BundleKit");
	}
}