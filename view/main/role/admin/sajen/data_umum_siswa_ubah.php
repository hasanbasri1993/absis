<?php
require_once "model/class/master.php";
$array=json_decode($_POST['json']);
//print_r($array);

$nis=$array[0];
$nisn=$array[1];
$nama=$array[2];
$kelamin=$array[3];

if ($kelamin=="1") {
	$kelamin="L";
}elseif ($kelamin=="2") {
	$kelamin="P";
}else{
	echo "Kelamin Kosong";
}

$siswa= new Siswa($nis);
$nisn_error_code = $siswa->updateNISN($nisn);
$nama_error_code = $siswa->updateNama($nama);
$kelamin_error_code = $siswa->updateKelamin($kelamin);

if ($nisn_error_code AND $nama_error_code AND $kelamin_error_code){
	echo "1";
}

?>