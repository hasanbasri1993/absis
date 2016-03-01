<?php
include_once "model/class/master.php";

$dataMasuk = json_decode($_POST['json']);
$kelas = $dataMasuk[1];
$subkelas = $dataMasuk[2];
$tugas = new Guru($dataMasuk[0]);
$del_wali = $tugas -> delPenugasanWali();
$save = $tugas -> setPenugasanWali($kelas, $subkelas);
echo "Tambah Penugasan Wali Kelas <b>" . $dataMasuk[1] . $dataMasuk[0][2] . "</b> ke Guru<b>" . $dataMasuk[0] . "</b><br />Sukses";
?>