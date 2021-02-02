<?php

//$conn =  oci_connect('laptop_zone', 's', 'ORA12CSER/ORADB');
$conn =  oci_connect('laptop_zone', 's', 'oraserverpk/ORADBPK');
//$conn =  oci_connect('lz_bigData', 's', '192.168.0.78/LZBIGDATA');
if (! $conn){
	trigger_error('Could not connect to database', E_USER_ERROR);
}
else{
	//echo "Connection Established";
}

?>

