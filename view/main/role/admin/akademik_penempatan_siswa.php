<?php
if (isset($_GET['state'])) {
	if ($_GET['state'] == "atur"){
		$get_kelas = $_GET['kelas'];
		$title_1 = "Penempatan Siswa Kelas $get_kelas";
		$state_navbar = "akademik_penempatan_siswa_atur"; // view/main/require/navbar/~ -home -content -other~
		include_once "view/main/require/navbar/navbar.php";
		include_once "view/main/role/admin/akademik_penempatan_siswa_atur.php";
	} else {

		include_once "view/main/require/redirect/redirect_404.php";
		exit;
	}
} else {

	$title_1 = "Penempatan Siswa";
	$state_navbar = "akademik_penempatan_siswa_landing"; // view/main/require/navbar/~ -home -content -other~
	include_once "view/main/require/navbar/navbar.php";
	include_once "view/main/role/admin/akademik_penempatan_siswa_landing.php";
}
?>