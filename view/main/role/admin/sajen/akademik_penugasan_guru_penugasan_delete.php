<?php
include_once "model/class/master.php";
$get_nip = $_POST['nip'];
$get_kelas = $_POST['kelas'];
$get_subkelas = $_POST['subkelas'];

$guru= new Guru($get_nip);
echo $guru->deleteKelas("$get_kelas","$get_subkelas");

?>