<?php

Class Kelas{

	public $_kelas;
	public $_subkelas;

	public function __construct($kelas,$subkelas=null){
		$this->_kelas= $kelas;
		if(isset($subkelas)){
		$this->_subkelas= $subkelas;}
	}

	public function getSiswa(){
		$dbTA=new DB($_SESSION['database']);
		$sqlsiswa = "SELECT nis FROM siswa_aktif WHERE kelas=:kelas and subkelas=:subkelas and semester=:semester";
		$siswa = $dbTA->prepare("$sqlsiswa");
		$siswa->bindParam(":kelas",$this->_kelas,PDO::PARAM_STR);
		$siswa->bindParam(":subkelas",$this->_subkelas,PDO::PARAM_STR);	
		$siswa->bindParam(":semester",$_SESSION['semester'],PDO::PARAM_STR);		
		$siswa->execute();
		$daftarSiswa = $siswa->fetchAll();
		$daftarNama=array();

		$banyakSiswa=sizeof($daftarSiswa);
		$count=0;

		while ($count < $banyakSiswa) {

			$siswaBaru= new Siswa($daftarSiswa[$count][0]);
			$nama=$siswaBaru->getNama();
			$kelamin=$siswaBaru->getKelamin();
			$nisn=$siswaBaru->getNISN();

			array_push($daftarNama,$nama);
			$daftarSiswa[$count]['nama']=$nama;
			$daftarSiswa[$count]['kelamin']=$kelamin;
			$daftarSiswa[$count]['nisn']=$nisn;
			$count++;
		}

		array_multisort($daftarNama, SORT_ASC, $daftarSiswa);

		
		if($siswa->errorCode()=="0000"){
			return $daftarSiswa;
		}else{
			return print_r($siswa->errorInfo());
		}
			
	}
	
	public function getKurikulum(){
		$dbTA=new DB($_SESSION['database']);
		$semester=$_SESSION['semester'];
		
		$kunci="kurikulumkelas".$this->_kelas."smt".$semester;
		
		$sqlsiswa = "SELECT nilai FROM info_ta WHERE kunci=:kunci";
		$siswa = $dbTA->prepare("$sqlsiswa");
		$siswa->bindParam(":kunci",$kunci,PDO::PARAM_STR);
		$siswa->execute();
		$kurikulum = $siswa->fetch();
		
		if($siswa->errorCode()=="0000"){
			return $kurikulum['nilai'];	
		}else{
			return print_r($siswa->errorInfo());
		}
		
		
	}

	public function getMapel(){
		$dbTA=new DB($_SESSION['database']);
		$kelas=new Kelas($this->_kelas,$this->_subkelas);
		$kurikulum=$kelas->getKurikulum();

		if($kurikulum=="ktsp"){	
			$sqlmapel= "SELECT * FROM ktsp_mapel";
			$mapel = $dbTA->prepare("$sqlmapel");
			$mapel->execute();
			$daftarMapel = $mapel->fetchAll();
			$arrayMapel = array();
			$jumlahMapel = sizeof($daftarMapel);$count=0;
			while ($count < $jumlahMapel) {
				if ($daftarMapel[$count]['kode_nama']!='AGAMAHIN' AND $daftarMapel[$count]['kode_nama']!='AGAMAIS' AND $daftarMapel[$count]['kode_nama']!='AGAMAKAT' AND $daftarMapel[$count]['kode_nama']!='AGAMAKRIS' AND $daftarMapel[$count]['kode_nama']!='BK') {	
					array_push($arrayMapel, array('mapel_id' => $daftarMapel[$count]['ktsp_mapel_id'], 'mapel_nama' => $daftarMapel[$count]['mapel_nama'], 'kode_nama' => $daftarMapel[$count]['kode_nama']));
				}
				$count++;
			}
			array_push($arrayMapel, array('mapel_id' => 0, 'mapel_nama' => 'Pendidikan Agama', 'kode_nama' => 'AGAMA'));
		}elseif ($kurikulum=="k13") {
			echo "KURIKULUM 2013 BELUM SIAP DIGUNAKAN";
		}
		
		return $arrayMapel;
	}

	public function getBanyakSiswa(){
		$dbTA=new DB($_SESSION['database']);
		$sqlsiswa = "SELECT nis FROM siswa_aktif WHERE kelas=:kelas and subkelas=:subkelas and semester=:semester";
		$siswa = $dbTA->prepare("$sqlsiswa");
		$siswa->bindParam(":kelas",$this->_kelas,PDO::PARAM_STR);
		$siswa->bindParam(":subkelas",$this->_subkelas,PDO::PARAM_STR);
		$siswa->bindParam(":semester",$_SESSION['semester'],PDO::PARAM_STR);			
		$siswa->execute();
		$banyakSiswa = $siswa->rowCount();
		
			
		if($siswa->errorCode()=="0000"){
			return $banyakSiswa;
		}else{
			return print_r($siswa->errorInfo());
		}
	}

	public function getBanyakSiswaAgama($agama){
		$dbTA=new DB($_SESSION['database']);
		$sqlsiswa = "SELECT nis FROM siswa_aktif WHERE kelas=:kelas and subkelas=:subkelas and semester=:semester and agama=:agama";
		$siswa = $dbTA->prepare("$sqlsiswa");
		$siswa->bindParam(":kelas",$this->_kelas,PDO::PARAM_STR);
		$siswa->bindParam(":subkelas",$this->_subkelas,PDO::PARAM_STR);
		$siswa->bindParam(":semester",$_SESSION['semester'],PDO::PARAM_STR);	
		$siswa->bindParam(":agama",$agama,PDO::PARAM_STR);			
		$siswa->execute();
		$banyakSiswa = $siswa->rowCount();
		
			
		if($siswa->errorCode()=="0000"){
			return $banyakSiswa;
		}else{
			return print_r($siswa->errorInfo());
		}
	}



	public function getBanyakSiswaP(){
		$dbTA=new DB($_SESSION['database']);
		$sqlsiswa = "SELECT nis FROM siswa_aktif WHERE kelas=:kelas and subkelas=:subkelas";
		$siswa = $dbTA->prepare("$sqlsiswa");
		$siswa->bindParam(":kelas",$this->_kelas,PDO::PARAM_STR);
		$siswa->bindParam(":subkelas",$this->_subkelas,PDO::PARAM_STR);		
		$siswa->execute();
		$daftarSiswa = $siswa->fetchAll();

		$banyakKelamin=0;
		$banyakSiswa=sizeof($daftarSiswa);
		$count=0;

		while ($count < $banyakSiswa) {

			$siswaBaru= new Siswa($daftarSiswa[$count][0]);
			$kelamin=$siswaBaru->getKelamin();
			
			if($kelamin=="P"){
				$banyakKelamin++;
			}

			$count++;
		}
			
		if($siswa->errorCode()=="0000"){
			return $banyakKelamin;
		}else{
			return print_r($siswa->errorInfo());
		}
	}

	public function getBanyakSiswaL(){
		$dbTA=new DB($_SESSION['database']);
		$sqlsiswa = "SELECT nis FROM siswa_aktif WHERE kelas=:kelas and subkelas=:subkelas";
		$siswa = $dbTA->prepare("$sqlsiswa");
		$siswa->bindParam(":kelas",$this->_kelas,PDO::PARAM_STR);
		$siswa->bindParam(":subkelas",$this->_subkelas,PDO::PARAM_STR);		
		$siswa->execute();
		$daftarSiswa = $siswa->fetchAll();

		$banyakKelamin=0;
		$banyakSiswa=sizeof($daftarSiswa);
		$count=0;

		while ($count < $banyakSiswa) {

			$siswaBaru= new Siswa($daftarSiswa[$count][0]);
			$kelamin=$siswaBaru->getKelamin();
			
			if($kelamin=="L"){
				$banyakKelamin++;
			}

			$count++;
		}
			
		if($siswa->errorCode()=="0000"){
			return $banyakKelamin;
		}else{
			return print_r($siswa->errorInfo());
		}
	}

	public function getWaliKelasNIP(){
		$dbTA=new DB($_SESSION['database']);
		$sqlsiswa = "SELECT nip FROM guru_walikelas WHERE kelas=:kelas and subkelas=:subkelas";
		$siswa = $dbTA->prepare("$sqlsiswa");
		$siswa->bindParam(":kelas",$this->_kelas,PDO::PARAM_STR);
		$siswa->bindParam(":subkelas",$this->_subkelas,PDO::PARAM_STR);		
		$siswa->execute();
		$waliKelas = $siswa->fetch();
		
		if($siswa->errorCode()=="0000"){
			return trim($waliKelas['nip']);
		}else{
			return print_r($siswa->errorInfo());
		}
			
	}
	
	public function setWaliKelas($nip){
		$dbTA=new DB($_SESSION['database']);
		
		$sqlguru = "SELECT id FROM guru_walikelas WHERE nip=:nip";
		$guru = $dbTA->prepare("$sqlguru");
		$guru->bindParam(":nip",$nip,PDO::PARAM_STR);		
		$guru->execute();
		$banyakWaliKelas = $guru->rowCount();
		//return print_r($guru->errorInfo());
		//return $banyakWaliKelas;
		
		if($banyakWaliKelas==0){
		
		$sqlguru = "DELETE FROM guru_walikelas
					WHERE kelas=:kelas AND subkelas=:subkelas";
		$guru = $dbTA->prepare("$sqlguru");
		//$guru->bindParam(":nip",$this->_nip,PDO::PARAM_STR);	
		$guru->bindParam(":kelas",$this->_kelas,PDO::PARAM_STR);
		$guru->bindParam(":subkelas",$this->_subkelas,PDO::PARAM_STR);	
		$guru->execute();
		
		$sqlguru = "INSERT INTO guru_walikelas (nip, kelas, subkelas)
					VALUES (:nip, :kelas, :subkelas)";
		$guru = $dbTA->prepare("$sqlguru");
		$guru->bindParam(":nip",$nip,PDO::PARAM_STR);	
		//$guru->bindParam(":ktsp_mapel_id",$this->_ktsp_mapel_id,PDO::PARAM_STR);	
		//$guru->bindParam(":k13_mapel_id",$this->_k13_mapel_id,PDO::PARAM_STR);	
		$guru->bindParam(":kelas",$this->_kelas,PDO::PARAM_STR);
		$guru->bindParam(":subkelas",$this->_subkelas,PDO::PARAM_STR);			
		$guru->execute();
		
			if($guru->errorCode()=="0000"){
				return "1";
			}else{
				return print_r($guru->errorInfo());
			}
			
		} else{
			return "1";
		}
	}
}

?>