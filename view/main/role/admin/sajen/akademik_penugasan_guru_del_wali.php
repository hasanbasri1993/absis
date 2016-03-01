<?php
include_once "model/class/master.php";

$dataMasuk = json_decode($_POST['json']);
$tugas = new Guru($dataMasuk[0]);
$del = $tugas -> delPenugasanWali();
echo "Delete Penugasan <b>" . $dataMasuk[0] . "</b><br> Sukses";
?>