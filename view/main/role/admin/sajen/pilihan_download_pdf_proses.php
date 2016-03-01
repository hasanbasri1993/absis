<?php
$kelas = $_GET['kelas'];
$subkelas = $_GET['subkelas'];
$tipe = $_GET['tipe'];
if (isset($_GET['tipe']) && isset($_GET['kelas']) && isset($_GET['subkelas'])){

	switch ($tipe) {

		case 'absensi':
			include_once "model/feature/mpdf/template/absensi.php";
			break;

		case 'uts':
			include_once "model/feature/mpdf/template/rapor_uts_ktsp.php";
			break;

		case 'uas':
			include_once "model/feature/mpdf/template/index_uas.php";
			break;

		case 'ukk':
			include_once "model/feature/mpdf/template/coming.php";
			break;

		case 'buku_induk':
			include_once "model/feature/mpdf/template/buku_induk2.php";
			break;

		case 'ledger':
			include_once "model/feature/mpdf/template/kosong.php";
			break;

		default:
			echo "var: tipe not defined";
			break;
	}
} else {

	include_once "view/main/require/redirect/redirect_404.php";	
}
?>