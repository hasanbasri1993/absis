<?php
include_once "model/class/master.php";


//if (isset($_GET['url'])){
	
	$nip          = $_SESSION['username'];
	$guru         = new Guru($nip);
	$kelas        = new Kelas($_POST['kelas'],$_POST['subkelas']);
	$mapel        = new Mapel($guru->getKodeMapel($kelas->getKurikulum()),$_POST['kelas'],$_POST['subkelas']);

	//print_r($_GET);
	$error=$mapel->hapusTopik($_POST['topik_id']);
	//echo $error;

	if($error=="1"){
		echo "SUKSES DELETE TOPIK";
	
	} else {
		echo "GAGAL DELETE TOPIK";
	}
	

?>