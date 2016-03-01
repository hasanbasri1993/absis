<?php
require_once "model/class/master.php";
$array=json_decode($_POST['json']);
//print_r($array);

$nip_guru=$array[0];
$nama_guru=$array[1];

$guru= new Guru($nip_guru);
echo $guru->updateNama($nama_guru); 

?>