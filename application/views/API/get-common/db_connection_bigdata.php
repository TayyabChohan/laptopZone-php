<?php

$conn =  oci_connect('lz_bigData', 's', 'wizmen-pc/ORCL');

if (! $conn){
	trigger_error('Could not connect to database', E_USER_ERROR);
}
else{
	//echo "Connection Established";
}

?>