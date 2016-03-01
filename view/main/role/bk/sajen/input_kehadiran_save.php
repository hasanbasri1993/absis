<?php
require_once "model/class/master.php";
$get_kelas = $_POST['kelas'];
$kelas = $get_kelas['0'];
$subkelas = $get_kelas['1'];
$kelas= new Kelas($kelas,$subkelas);
$getSiswa= $kelas->getSiswa();
$banyakSiswa= sizeof($getSiswa);


for ($x=0; $x<$banyakSiswa; $x++) { 
	
	$siswa = new  Siswa($getSiswa[$x]['nis']);
	$kehadiran = $siswa -> getKehadiran();

	if (!isset($kehadiran[0]['sakit'])){

		$kehadiran[0]['sakit'] = "";
	}
	if (!isset($kehadiran[0]['izin'])){

		$kehadiran[0]['izin'] = "";
	}
	if (!isset($kehadiran[0]['alpha'])){

		$kehadiran[0]['alpha'] = "";
	}

	$nis = $getSiswa[$x]['nis'];
	$alpha = $kehadiran[0]['alpha'];
	$izin = $kehadiran[0]['izin'];
	$sakit = $kehadiran[0]['sakit'];

	$rec_alpha = $_POST["a-" . $nis];
	$rec_izin = $_POST["i-" . $nis];
	$rec_sakit = $_POST["s-" . $nis];

	$siswa = new Siswa($nis);
	$insert = $siswa -> setKehadiran("$rec_sakit", "$rec_izin", "$rec_alpha");
}
header("Location: ?p=input_kehadiran_proses&kelas=$get_kelas&ok");
?>