<?php
/*  © 2013 eBay Inc., All Rights Reserved */ 
/* Licensed under CDDL 1.0 -  http://opensource.org/licenses/cddl1.php */
?>
<?php
// be sure include path contains current directory
// to make sure samples work
ini_set('include_path', ini_get('include_path') . ':.');

// Load general helper classes for eBay SOAP API
require_once 'eBaySOAP.php';

// Load developer-specific configuration data from ini file
$config = parse_ini_file('ebay.ini', true);
//var_dump($config);exit;
//$site = 'sandbox';
$site = 'production';

$dev = $config[$site]['devId'];
$app = $config[$site]['appId'];
$cert = $config[$site]['cert'];
$token = $config[$site]['authToken'];
$location = $config[$site]['gatewaySOAP'];

// Create and configure session
$session = new eBaySession($dev, $app, $cert);
$session->token = $token;
$session->site = 0; // 0 = US;
$session->location = $location;

// Deliver messages to the following URL
try {
    $client = new eBaySOAP($session);
	 
    // $params = array('Version' => 525,
	   //          'ApplicationDeliveryPreferences' => array(
		  //       //'ApplicationURL' => 'http://www.trachtenberg.com/ebay/notifications/listener.php',));
		  //       'ApplicationURL' => 'http://71.78.236.21/ebay_note/listener.php',));

    $params = array('Version' => 525,
     'ApplicationDeliveryPreferences' => array(
         'ApplicationURL' => 'http://71.78.236.21/ebay_note/listener.php',
         'AlertEmail' => 'mailto://sajid.khan@ecologix.us',
         'AlertEnable' => 'Enable',
         'ApplicationEnable' => 'Enable'
     )
 );
    $results = $client->SetNotificationPreferences($params);
	 echo "<pre>";
    print_r($results);	

} catch (SOAPFault $f) {
	print $f; // error handling
}

// Uncomment below to view SOAP envelopes
print "Request: \n".$client->__getLastRequestHeaders() ."\n";
print "Request: \n".$client->__getLastRequest() ."\n";
print "Response: \n".$client->__getLastResponseHeaders()."\n";
print "Response: \n".$client->__getLastResponse()."\n";


?>