<?php
include_once "model/class/master.php";


if (isset($_GET['url'])){
	
	$nip          = $_GET['nip'];
	$guru         = new Guru($nip);
	$kelas        = new Kelas($_GET['kelas'],$_GET['subkelas']);
	$mapel        = new Mapel($guru->getKodeMapel($kelas->getKurikulum()),$_GET['kelas'],$_GET['subkelas']);
	if ($_GET['UTS']=="sebelum") {
		$_GET['UTS']=0;
	} elseif ($_GET['UTS']=="setelah") {
		$_GET['UTS']=1;
	}

	$error=$mapel->buatTopik($_GET['topik'],$_GET['topik_singkat'],$_GET['UTS']);

	if($error=="1"){
		echo "<script>alert('OK, to redirectering...');</script>";
		//print_r($_GET) ;
		$url = $_GET['url'];
		header("Location: $url");
	} else {
		//echo "<script>alert('OK, to redirectering...');</script>";
		//print_r($_GET) ;
		$url = $_GET['url'];
		header("Location: $url");
	}
	
}
?>