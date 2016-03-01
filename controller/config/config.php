<?php
$hostname 	= "localhost";
$database 	= "smpn1smg_master"; 
$username	= "root";    
$password	= "";   

try {

	$dbo = new PDO('mysql:host='.$hostname.';dbname='.$database, $username, $password);
}
catch (PDOException $e) {

	$msg = $e->getMessage();
	echo $msg;
	die();
}
?>
