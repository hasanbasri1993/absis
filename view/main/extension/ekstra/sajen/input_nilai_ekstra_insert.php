<?php
include_once "model/class/master.php";
$dataMasuk=json_decode($_POST['json']);
$guru = new Guru($_SESSION['username']);
$get_ekstra_id = $guru -> getPenugasanEkstra();
$ekstra_id = $get_ekstra_id[0]['ekskul_id'];
$nis = $dataMasuk[0];
$ekstra = new Ekstra($ekstra_id);
$insert_siswa = $ekstra -> insertSiswa($nis);
?>