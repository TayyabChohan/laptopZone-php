<?php

$conn =  oci_connect('laptop_zone', 's', 'wizmen-pc/orcl');

if (! $conn){
	trigger_error('Could not connect to database', E_USER_ERROR);
}
else{
	//echo "Connection Established";
}

?>