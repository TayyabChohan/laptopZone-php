<?php
/*  © 2013 eBay Inc., All Rights Reserved */ 
/* Licensed under CDDL 1.0 -  http://opensource.org/licenses/cddl1.php */
//$conn =  oci_connect('laptop_zone', 's', 'ORA12CSER/ORADB');

// $qry = "insert into EBAY_NOTEIFICATION (test_pk,insert_date) values (1,sysdate)";
// $cmd =oci_parse($conn, $qry);
// oci_execute($cmd,OCI_DEFAULT);
// oci_commit($conn);
// $NotificationEventName = (string) $response->NotificationEventName;
// $data['merchant_name'] = (string) $response->RecipientUserID;
//$data['Timestamp'] = 'Sajid';
//$this->load->view('API/GetOrders/GetOrders_notification',$data);
// exit;
// if(strtoupper($NotificationEventName) === 'ITEMSOLD' ){
//$this->load->view('API/GetOrders/GetOrders_notification',$data);
//  	//include('/../../GetOrders_notification.php'); 
// }
  $qry = $this->db->query("insert into EBAY_NOTEIFICATION (test_pk,E_data,insert_date) values (get_single_primary_key('EBAY_NOTEIFICATION','test_pk'),'Sajid Khan',sysdate)");
// $config = @parse_ini_file('ebay.ini', true);
// var_dump($config);exit;
?>
<?php
// be sure include path contains current directory
// to make sure samples work
ini_set('include_path', ini_get('include_path') . ':.');

// Load general helper classes for eBay SOAP API
require_once 'eBaySOAP.php';

class eBayPlatformNotificationListener extends eBayPlatformNotifications {

	protected $NotificationSignature;

	// Dispatch method to ensure signature validation
	public function __call($method, $args) {
		$s = "Called with $method";
		$this->carp($s);

		if ($this->ValidateSignature($args[0])) {

			// strip off trailing "Request"
			$method = substr($method, 0, -8);
			if (method_exists($this, $method)) {
				return call_user_func_array(array($this, $method), $args);
			}
		}
		
		// Today is a good day to die.
		die("Death");
	}

	// Extract Signature for validation later
	// Can't validate here because we don't have access to the Timestamp
	public function RequesterCredentials($RequesterCredentials) {
		$this->NotificationSignature = $RequesterCredentials->NotificationSignature;

	}

	protected function ValidateSignature($Timestamp) {

		// Check for Signature Match
		$CalculatedSignature = $this->CalculateSignature($Timestamp);
		$NotificationSignature = $this->NotificationSignature;

		if ($CalculatedSignature != $NotificationSignature) {

			$this->carp("Sig Mismatch: Calc: $CalculatedSignature, Note: $NotificationSignature");
			return false;
		} else {

			$this->carp("Sig Match: $NotificationSignature");

		}

		// Check that Timestamp is within 10 minutes of now
		$tz = date_default_timezone_get();
		date_default_timezone_set('UTC');
		$then = strtotime($Timestamp);
		$now = time();
		date_default_timezone_set($tz);

		$drift = $now - $then;
		$ten_minutes = 60 * 10;
		if ($drift > $ten_minutes) {

			$this->carp("Time Drift is too large: $drift seconds");
			return false;
		} else {
			$this->carp("Time Drift is okay: $drift seconds");
		}

		return true;
	}

	// Arg order is brittle, assumes constant return ordering from eBay
	public function GetMemberMessages($Timestamp, $Ack, $CorrelationID,
						$Version, $Build, $NotificationEventName, 
						$RecipientUserID, $MemberMessage, 
						$PaginationResult, $HasMoreItems) {

		// Extract some data to prove this is working
		$UserID = $MemberMessage->MemberMessageExchange->Item->Seller->UserID;
		$this->carp($UserID);
		return $UserID;
	}

	public function GetItem($Timestamp, $Ack, $CorrelationID,
				$Version, $Build, $NotificationEventName, 
				$RecipientUserID, $Item) {

	       $ItemID = $Item->ItemID;
	       return "OutBid: $ItemID";
	}

}
//$conn =  oci_connect('laptop_zone', 's', 'ORA12CSER/ORADB');

// $qry = "insert into EBAY_NOTEIFICATION (test_pk) values (1)";
// $cmd =oci_parse($conn, $qry);
// oci_execute($cmd,OCI_DEFAULT);
// oci_commit($conn);

$config = parse_ini_file('ebay.ini', true);
$site = 'production';

$dev = $config[$site]['devId'];
$app = $config[$site]['appId'];
$cert = $config[$site]['cert'];

// $dev = "702653d3-dd1f-4641-97c2-dc818984bfaa";
// $app = "SajidKha-eRashanp-PRD-42f839365-d3726265";
// $cert = "PRD-2f839365e792-a58f-4449-b744-ecb4";

// Create and configure session
$session = new eBaySession($dev, $app, $cert);
// $qry = "insert into EBAY_NOTEIFICATION (test_pk,insert_date) values (2,sysdate)";
// $cmd =oci_parse($conn, $qry);
// oci_execute($cmd,OCI_DEFAULT);
// oci_commit($conn);
error_log(serialize(apache_request_headers()));

//error_log("trying to listen");


//$stdin = $GLOBALS['HTTP_RAW_POST_DATA'];
$stdin = file_get_contents("php://input");
file_put_contents('test.xml', $stdin);
//$qry = $this->db->query("insert into EBAY_NOTEIFICATION (test_pk,E_data,insert_date) values (get_single_primary_key('EBAY_NOTEIFICATION','test_pk'),'test.xml',sysdate)");
//error_log($stdin);

//$soap     = simplexml_load_string($soapXMLResult);

//echo $customerId;
// Loads the XML
$xml = simplexml_load_string($stdin);
//file_put_contents('test_xml.xml', $xml);
//$this->db->query("insert into EBAY_NOTEIFICATION (test_pk,E_data,insert_date) values (get_single_primary_key('EBAY_NOTEIFICATION','test_pk'),'test.sajid',sysdate)");
$response = $xml->children('http://schemas.xmlsoap.org/soap/envelope/')->Body->children()->GetItemResponse;
$NotificationEventName = (string) $response->NotificationEventName;
$ItemID = (string) $response->Item->ItemID;
$data['merchant_name'] = (string) $response->RecipientUserID;
$merchant_name = (string) $response->RecipientUserID;
$data['Timestamp'] = (string) $response->Timestamp;
$Timestamp = (string) $response->Timestamp;

$dTimestamp = (string) $response->Timestamp;

$Timestamp = str_split($Timestamp,19);
$Timestamp = str_replace('T'," ",$Timestamp[0]);
//$this->db->query("insert into EBAY_NOTEIFICATION (test_pk,E_data,insert_date) values (get_single_primary_key('EBAY_NOTEIFICATION','test_pk'),'test.adil',sysdate)");
//$qry = $this->db->query("insert into EBAY_NOTEIFICATION (test_pk,E_data,insert_date) values (get_single_primary_key('EBAY_NOTEIFICATION','test_pk'),'$dTimestamp',sysdate)");
//$qry = $this->db->query("insert into EBAY_NOTEIFICATION (test_pk,E_data,insert_date) values (get_single_primary_key('EBAY_NOTEIFICATION','test_pk'),	'OK',sysdate)");

$qry = $this->db->query("insert into EBAY_NOTEIFICATION (test_pk,E_data,insert_date,NOTIFICATION_TYPE) values (get_single_primary_key('EBAY_NOTEIFICATION','test_pk'),'$ItemID',sysdate,'$NotificationEventName')");

// uplaod data to fb
if(!empty($NotificationEventName)){
	require __DIR__.'/vendor/autoload.php';


	use Kreait\Firebase\Configuration;
	use Kreait\Firebase\Firebase;

	$config = new Configuration();
	//$config->setAuthConfigFile(__DIR__.'/secret/fbtest-e7425-8d3d759d5984.json');
	$config->setAuthConfigFile(__DIR__.'/secret/plateformnotification-b2648d771b9f.json');

	//$firebase = new Firebase('https://fbtest-e7425.firebaseio.com/', $config);
	$firebase = new Firebase('https://plateformnotification.firebaseio.com/', $config);

	// $firebase->set(['key' => 'value'], 'my/data');
	// $firebase->set('new value', 'my/data/key');

	$newKey = $firebase->push([
	    'merchant_name' => $merchant_name,
	    'Timestamp' => $Timestamp,
	    'NotificationEventName' => $NotificationEventName,
	    'ItemID' => $ItemID
	], 'PlateformNotification/ebay/itemSold');
}

 



//if(strtoupper($NotificationEventName) === 'ITEMSOLD' ){
	//$this->load->view('API/GetOrders/GetOrders_notification',$data);

 	//include('GetOrders_notification.php'); 
//}
// Grabs the posts
//$NotificationEventName = $xml->children('soapenv', true)->Body->children('GetItemResponse', true)->NotificationEventName;

// Take the posts and generate some markup
// foreach ($posts as $post)
// {
// 	$twitter_url = 'https://twitter.com/' . $post->Author->Twitter;

// 	echo '
// 		<article>
// 			<h1>' . $post->Title . '</h1>
// 			<time>' . $post->PostedDate . '</time>
// 			<a href="' . $twitter_url . ' rel="author">' . $post->Author->Name . '</a>
// 			<p>' . $post->Description . '</p>
// 			<a href="' . $post->Link . '">Read Article</a>
// 		</article>
// 	';
// }


// $responseDoc = new DomDocument();
//     $responseDoc->loadXML($stdin);


//     //get any error nodes
//     //$errors = $responseDoc->getElementsByTagName('Errors');
//     $response = simplexml_import_dom($responseDoc);
//     $NotificationEventName = $response->GetItemResponse->NotificationEventName;
    //$entries = $response->PaginationResult->TotalNumberOfEntries;

//$qry = $this->db->query("insert into EBAY_NOTEIFICATION (test_pk,E_data,insert_date) values (get_single_primary_key('EBAY_NOTEIFICATION','test_pk'),'$NotificationEventName',sysdate)");


$server = new SOAPServer(null, array('uri'=>'urn:ebay:apis:eBLBaseComponents'));
$server->setClass('eBayPlatformNotificationListener', $session, true);
$server->handle();

?>