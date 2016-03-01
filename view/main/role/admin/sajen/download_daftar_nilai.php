<?php
	include_once "model/class/master.php";
	
	if (($_GET['kelas']=='all')OR(strlen($_GET['kelas'])==2)){
	
		
		$nip  		= $_SESSION['username'];
		$guru		= new Guru($nip);
		$gurux 	  	= (array) $guru;
		$nama_guru 	= $gurux['_nama'];
		$kelas_g 	= $guru->getKelas();
		
		$arr_kelas 	= array();
		$data_siswa= array();
		if ($_GET['kelas']=='all'){
			//echo "Semua kelas";

			for ($kelascount=0; $kelascount < sizeof($kelas_g); $kelascount++) {
				array_push($arr_kelas, array('kelas'=>$kelas_g[$kelascount]['kelas'],'subkelas'=>$kelas_g[$kelascount]['subkelas']));
				
				$kelas_get    	= $kelas_g[$kelascount]['kelas'];
				$subkelas_get 	= $kelas_g[$kelascount]['subkelas'];
				$kelas        	= new Kelas($kelas_get,$subkelas_get);
				$kode_mapel   	= $guru->getKodeMapel($kelas->getKurikulum());
				$nama_mapel		= $guru->getNamaMapel($kelas->getKurikulum());
				$mapel        	= new Mapel($kode_mapel,$kelas_get,$subkelas_get);
				$daftar_siswa 	= $kelas->getSiswa();
				$jumlah_siswa 	= sizeof($daftar_siswa);
				$topik        	= $mapel->getTopik();
				$kkm          	= $mapel->getKKM();
				$kelas_d 		= array('kelas' => $kelas_get, 'subkelas' => $subkelas_get);			
				
				$arr_data 	 = array();
				$nilai_siswa = array();
				for ($i=0; $i < $jumlah_siswa; $i++) {
					$siswa        = new Siswa($daftar_siswa[$i]['nis']);
					$n_UTS        = $siswa->getNilaiUTS($kode_mapel); 
					$n_UAS        = $siswa->getNilaiUAS($kode_mapel); //$siswa->getNilaiHarian($kode_topik);
					$na_UAS       = $siswa->getNilaiAkhir($kode_mapel);
					$nilai_topik  = array();
					for ($x=0; $x < sizeof($topik); $x++) { 
					  $arr_nilai = $siswa->getNilaiHarian($topik[$x]['topik_id']); //$n_topik = array('UT' => $n_UT, 'UL' => $n_UL, 'T' => $n_T);
					  array_push($nilai_topik, $arr_nilai);
					}
					$arr = array('nis' => $daftar_siswa[$i]['nis'],'nama' => $daftar_siswa[$i]['nama'],'kkm' =>$kkm,'r_UTS' => $n_UTS, 'r_UAS' => $na_UAS, 'UTS' => $n_UTS, 'UAS' => $n_UAS, 'topik' => $nilai_topik);
					array_push($nilai_siswa, $arr);
				}

				$arr_data = array('data_topik' => $topik,'data_kelas' => $kelas_d,'data_siswa' => $nilai_siswa);
				array_push($data_siswa,$arr_data);

			}
			
		}else if (strlen($_GET['kelas'])==2){
			
			//echo "Satu kelas";
			for ($kelascount=0; $kelascount < 1; $kelascount++) {
				array_push($arr_kelas, array('kelas'=>$_GET['kelas'][0],'subkelas'=>$_GET['kelas'][1]));
				
				$kelas_get    	= $_GET['kelas'][0];
				$subkelas_get 	= $_GET['kelas'][1];
				$kelas        	= new Kelas($kelas_get,$subkelas_get);
				$kode_mapel   	= $guru->getKodeMapel($kelas->getKurikulum());
				$nama_mapel		= $guru->getNamaMapel($kelas->getKurikulum());
				$mapel        	= new Mapel($kode_mapel,$kelas_get,$subkelas_get);
				$daftar_siswa 	= $kelas->getSiswa();
				$jumlah_siswa 	= sizeof($daftar_siswa);
				$topik        	= $mapel->getTopik();
				$kkm          	= $mapel->getKKM();			
				$kelas_d 		= array('kelas' => $kelas_get, 'subkelas' => $subkelas_get);							

				$arr_data 	 = array();
				$nilai_siswa = array();
				for ($i=0; $i < $jumlah_siswa; $i++) {
					$siswa        = new Siswa($daftar_siswa[$i]['nis']);
					$n_UTS        = $siswa->getNilaiUTS($kode_mapel); 
					$n_UAS        = $siswa->getNilaiUAS($kode_mapel); //$siswa->getNilaiHarian($kode_topik);
					$na_UAS       = $siswa->getNilaiAkhir($kode_mapel);
					$nilai_topik  = array();
					for ($x=0; $x < sizeof($topik); $x++) { 
					  $arr_nilai = $siswa->getNilaiHarian($topik[$x]['topik_id']); //$n_topik = array('UT' => $n_UT, 'UL' => $n_UL, 'T' => $n_T);
					  array_push($nilai_topik, $arr_nilai);
					}
					$arr = array('nis' => $daftar_siswa[$i]['nis'],'nama' => $daftar_siswa[$i]['nama'],'kkm' =>$kkm,'r_UTS' => $n_UTS, 'r_UAS' => $na_UAS, 'UTS' => $n_UTS, 'UAS' => $n_UAS, 'topik' => $nilai_topik);
					array_push($nilai_siswa, $arr);
				}
	
				$arr_data = array('data_topik' => $topik,'data_kelas' => $kelas_d,'data_siswa' => $nilai_siswa);
				array_push($data_siswa,$arr_data);


				// echo "<br>";
				// print_r($data_siswa[$kelascount]);
				// echo "<br>======================================================<br>";
			}			
		}

		include_once "model/feature/phpexcel/template/daftar_nilai.php";
	
	}else{
		echo "Data error";
	}
?>
