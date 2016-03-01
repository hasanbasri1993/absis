<?php
	//session_start();
	if (isset($_GET['meet'])){
		if ($_GET['meet'] == "login"){
			include_once "controller/auth/loginck.php";
		}
		if ($_GET['meet'] == "logout"){
			require_once "bye.php";
		}
	} else {
		include "controller/config/config.php";
		//include "controller/session/session.php";
		require "controller/auth/check.php";
	}
?>
<?php
/*
include 'model/feature/mobile/Mobile_Detect.php';
$detect = new Mobile_Detect();
if ($detect->isMobile()) {
	
    include_once "mobile.php";
    exit;
} else {

	include "controller/config/config.php";
	include "controller/session/session.php";
	require "controller/auth/check.php";
}
*/
//tambah comment
?>