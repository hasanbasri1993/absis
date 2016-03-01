<?php
$kelas = $_GET['kelas'];
$subkelas = $_GET['subkelas'];
$tipe = $_GET['tipe'];
// include_once "model/class/master.php";
if (isset($tipe) && ($tipe == "absensi")) {
	if($tipe=="absensi"){
		if (file_exists("model/feature/phpexcel/template/absensi.php")){
			include_once "model/feature/phpexcel/template/absensi.php";
		} else {
			echo "gak ono file e";
		}
	}
}else if(isset($tipe) && ($tipe == "ledger")){
	$jenis = $_GET['jenis'];
	if (file_exists("model/feature/phpexcel/template/ledger.php")){
		include_once "model/feature/phpexcel/template/ledger.php";
	} else {
		echo "File tidak ada";
	}
}else{
	echo "error";
	//include_once "view/main/require/redirect/redirect_404.php";
}
?>