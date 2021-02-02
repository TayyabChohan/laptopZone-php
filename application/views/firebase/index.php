<?php
//require_once './vendor/autoload.php';
require __DIR__.'/vendor/autoload.php';


use Kreait\Firebase\Configuration;
use Kreait\Firebase\Firebase;

$config = new Configuration();
$config->setAuthConfigFile(__DIR__.'/secret/plateformnotification-b2648d771b9f.json');

$firebase = new Firebase('https://fbtest-e7425.firebaseio.com/', $config);

$firebase->set(['key' => 'value'], 'my/data');
$firebase->set('new value', 'my/data/key');

print_r($firebase->get('my/data'));

//$firebase->delete('my/data');

// bellow code is for php 7.0 ^
// use Kreait\Firebase\Factory;
// use Kreait\Firebase\ServiceAccount;
// echo "Hello WOrld";


// // This assumes that you have placed the Firebase credentials in the same directory
// // as this PHP file.
// $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/secret/fbtest-e7425-8d3d759d5984.json');

// $firebase = (new Factory)
//     ->withServiceAccount($serviceAccount)
//     // The following line is optional if the project id in your credentials file
//     // is identical to the subdomain of your Firebase project. If you need it,
//     // make sure to replace the URL with the URL of your project.
//     //->withDatabaseUri('https://my-project.firebaseio.com')
//     ->create();

// $database = $firebase->getDatabase();

?>
