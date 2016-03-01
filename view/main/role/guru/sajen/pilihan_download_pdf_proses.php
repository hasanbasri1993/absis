<?php
$kelas = $_GET['kelas'];
$subkelas = $_GET['subkelas'];
$tipe = $_GET['tipe'];
if (isset($tipe) && (($tipe == "absensi") OR ($tipe == "uts") OR ($tipe == "uas") OR ($tipe == "ukk") OR ($tipe == "buku_induk"))) {
	if($tipe=="absensi"){
		include_once "model/feature/mpdf/template/absensi.php";
	}
	if($tipe=="uts"){
		include_once "model/feature/mpdf/template/rapor_uts_ktsp.php";
	}
	if($tipe=="uas"){
		include_once "model/feature/mpdf/template/absensi.php";
	}
	if($tipe=="ukk"){
		include_once "model/feature/mpdf/template/absensi.php";
	}
	if($tipe=="buku_induk"){
		include_once "model/feature/mpdf/template/buku_induk2.php";
	}

	//
}else{
	include_once "view/main/require/redirect/redirect_404.php";
}
?>