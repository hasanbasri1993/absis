<?php
include_once "model/class/master.php";

$dataMasuk = json_decode($_POST['json']);
$ekstra = $dataMasuk[1];
$tugas = new Guru($dataMasuk[0]);
$check_ekstra = $tugas -> checkPenugasanEkstra($ekstra);
?>