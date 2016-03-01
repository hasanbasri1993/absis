<?php
$req_url = "";
if (isset($_GET['url'])){

	$req_url = $_GET['url'];
} else {

	include_once "404.php";
}
if (isset($_GET['ta'])){

	$req_ta = $_GET['ta'];
	$_SESSION['database'] = "smpn1smg_".$req_ta;
	$_SESSION['TA'] = $req_ta;
} else {

	include_once "404.php";
}
if (isset($_GET['semester'])){

	$req_semester = $_GET['semester'];
	$_SESSION['semester'] = $req_semester;
} else {

	include_once "404.php";
}
header("Location: $req_url");
?>