<?php
	include_once "model/class/master.php";
	// Prevent caching.
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');

	// The JSON standard MIME header.
	header('Content-type: application/json');

	$datap=json_decode($_POST['json'],true);
	
	// [x][0]=jenis
	// [x][1]=nis
	// [x][2]=ekstra_id
	// [x][3]=nilai / keterangan
	// [x][4]=nilai_lama
	
	$banyakArray=sizeof($datap);
	$count=0;
	for ($count=0; $count <= $banyakArray-1; $count++) { 	
		$ekstra = new Ekstra($datap[$count][2]);

		$cek = $ekstra->checkSiswa($datap[$count][1]);
		if ($cek == "tidak") {
			$insert_siswa = $ekstra -> insertSiswa($datap[$count][1]);
		}

		if ($datap[$count][0]=="nilai") {
			$nilai = $ekstra->setNilai($datap[$count][1],$datap[$count][3]);
		}else{
			$keterangan = $ekstra->setKeterangan($datap[$count][1], $datap[$count][3]);
		}
		
	}
	$kirim_balik=$datap;
	echo json_encode($kirim_balik);

?>