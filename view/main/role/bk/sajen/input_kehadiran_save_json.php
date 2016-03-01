<?php
	include_once "model/class/master.php";
	// Prevent caching.
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');

	// The JSON standard MIME header.
	header('Content-type: application/json');

	$data=json_decode($_POST['json'],true);
	
	// [x][0]=jenis
	// [x][1]=nis
	// [x][2]=input
	// [x][3]=input_lama
	
	$banyakArray=sizeof($data);
	$i=0;
	for ($i=0; $i <= $banyakArray-1; $i++) { 	
		$siswa = new Siswa($data[$i][1]);

		$cek = $siswa->checkExistKehadiran();
		//echo $cek;
		if ($cek == "kosong") {
			$insert_siswa = $siswa->insertSiswaKehadiran();
		}

		if($data[$i][0]=="izin"){
			$isi = $siswa->setKehadiranI($data[$i][2]);
		}else if($data[$i][0]=="sakit"){
			$isi = $siswa->setKehadiranS($data[$i][2]);
		}else if($data[$i][0]=="alpha"){
			$isi = $siswa->setKehadiranA($data[$i][2]);
		}
	}
	$kirim_balik=$data;
	echo json_encode($kirim_balik);

?>