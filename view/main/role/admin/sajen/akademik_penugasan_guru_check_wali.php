<?php
include_once "model/class/master.php";

$dataMasuk = json_decode($_POST['json']);
$kelas = $dataMasuk[1];
$subkelas = $dataMasuk[2];
$tugas = new Guru($dataMasuk[0]);

$check_wali = $tugas -> checkPenugasanWali($kelas, $subkelas);
?>