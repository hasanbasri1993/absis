<?php
$kelas = $_GET['kelas'];
$subkelas = $_GET['subkelas'];
$tipe = $_GET['tipe'];
// include_once "model/class/master.php";
if (isset($tipe) && ($tipe == "absensi")) {
	if($tipe=="absensi"){
		//echo "$tipe";
		if (file_exists("model/feature/phpexcel/template/absensi.php")){
			// $kelasx = new Kelas($kelas,$subkelas);
			// $daftar_siswa= $kelasx->getSiswa();
			// $daftar_siswa= json_decode(json_encode($daftar_siswa),true);
			// $jumlah_siswa= sizeof($daftar_siswa);
		 //  	$jumlah_L= $kelasx->getBanyakSiswaL();
		 //  	$jumlah_P= $kelasx->getBanyakSiswaP();
		 //  	$nip_wali= $kelasx->getWaliKelasNIP();
		 //  	$guru = new Guru($nip_wali);
		 //  	$nama_wali = $guru->getNama();
			include_once "model/feature/phpexcel/template/absensi.php";
		} else {
			echo "gak ono file e";
		}
	}

	//
}else{
	echo "error";
	//include_once "view/main/require/redirect/redirect_404.php";
}
?>