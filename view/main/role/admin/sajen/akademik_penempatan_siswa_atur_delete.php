<?php

include_once "model/class/master.php";

$dataMasuk=json_decode($_POST['json']);
// print_r($dataMasuk);
$nis= $dataMasuk[0];
$kelas= $dataMasuk[1];
$subkelas= $dataMasuk[2];


$siswa= new Siswa($nis);
$error_code = $siswa->deleteKelas($kelas,$subkelas);

echo $error_code;

?>