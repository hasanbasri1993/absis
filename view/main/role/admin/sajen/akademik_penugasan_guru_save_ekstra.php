<?php
include_once "model/class/master.php";

$dataMasuk = json_decode($_POST['json']);
$ekstra = $dataMasuk[1];
$tugas = new Guru($dataMasuk[0]);
$del_ekstra = $tugas -> delPenugasanEkstra();
$save = $tugas -> setPenugasanEkstra($ekstra);
echo "Tambah Penugasan Ekstra<b>" . $dataMasuk[1] . "</b> ke Guru<b>" . $dataMasuk[0] . "</b><br />Sukses";
?>