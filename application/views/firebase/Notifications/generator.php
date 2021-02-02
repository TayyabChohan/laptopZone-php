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

class eBayPlatformNotificationGenerator extends eBayPlatformNotifications {
	protected $ApplicationURL = null;

	public function __construct(eBaySession $session, $debug = false) {
		parent::__construct($session, $debug);

		$this->ApplicationURL = $this->GetApplicationURL();
	}

	protected function GetApplicationURL() {
		 $client = new eBaySOAP($this->session);
	 
		 $params = array('Version' => 525);
		 $results = $client->GetNotificationPreferences($params);
	 
		 return $results->ApplicationDeliveryPreferences->ApplicationURL;
	}

	public function GenerateNotification($notification) {
		$ch = curl_init($this->ApplicationURL);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$httpheader = array(
			"SOAPAction: \"http://developer.ebay.com/notification/{$notification}\"",
			"Content-Type: text/xml;charset=utf-8",);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
	
		// XXX: Hardcoded pathname
		$postfields = file_get_contents("./notifications/{$notification}.xml");
	
		$dom = DOMDocument::loadXML($postfields);
		// XXX: This generates a slightly different, but I believe equally valid, formatted time
		// XXX: It lacks fractional seconds, and shows UTC as "+0:00" instead of "Z"
		$now = gmdate(DATE_ISO8601);
	
		$Timestamp = $dom->getElementsByTagNameNS('urn:ebay:apis:eBLBaseComponents', 'Timestamp')->item(0);
		$Timestamp->nodeValue = $now;
	
		$signature = $this->CalculateSignature($now);
		$NotificationSignature = $dom->getElementsByTagNameNS('urn:ebay:apis:eBLBaseComponents', 'NotificationSignature')->item(0);
		$NotificationSignature->nodeValue = $signature;
	
		$postfields = $dom->saveXML();
	
		$this->carp($postfields);
	
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
	
		$out = curl_exec($ch);
		curl_close($ch);
		
		return $out;
	}
}


// Load developer-specific configuration data from ini file
$config = parse_ini_file('ebay.ini', true);
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
$notifications = array('AskSellerQuestion');
// if ($argc == 1) {
//     $notifications = array('AskSellerQuestion');
// } else {
//     $notifications = array_slice($argv, 1);
// }

// Generate a ASQ notification
try {
	$debug = false;
	$ng = new eBayPlatformNotificationGenerator($session, $debug);
	
	foreach ($notifications as $n) {
		$results = $ng->GenerateNotification($n);
		print $results;	
	}

} catch (SOAPFault $f) {
	print $f; // error handling
}
/*
// Uncomment below to view SOAP envelopes
print "Request: \n".$client->__getLastRequestHeaders() ."\n";
print "Request: \n".$client->__getLastRequest() ."\n";
print "Response: \n".$client->__getLastResponseHeaders()."\n";
print "Response: \n".$client->__getLastResponse()."\n";
*/

?>