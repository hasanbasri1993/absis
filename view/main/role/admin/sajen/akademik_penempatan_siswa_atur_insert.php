<?php
include_once "model/class/master.php";

$dataMasuk=json_decode($_POST['json']);
$nis= $dataMasuk[0];
$kelas= $dataMasuk[1];
$subkelas= $dataMasuk[2];


$siswa= new Siswa($nis);
$error_code = $siswa->setKelas($kelas,$subkelas);

echo $error_code;

?>