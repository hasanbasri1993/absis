<?php
Class Sekolah{

	public $_kelas;
	public $_subkelas;

	public function __construct(){
	
	}
	
	public function getBanyakRombel($kelas){
		$dbTA=new DB($_SESSION['database']);
		//$semester=$_SESSION['semester'];
		
		$kunci="banyakrombelkelas".$kelas;
		
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
	
	public function getNamaKepalaSekolah(){
		$dbTA=new DB("smpn1smg_master");
		//$semester=$_SESSION['semester'];
		
		$kunci="nama_kepalaSekolah";
		
		$sqlsiswa = "SELECT nilai FROM data_sekolah WHERE kunci=:kunci";
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
		
	public function getAlamatSekolah(){
		$dbTA=new DB("smpn1smg_master");
		//$semester=$_SESSION['semester'];
		
		$kunci="alamat_sekolah";
		
		$sqlsiswa = "SELECT nilai FROM data_sekolah WHERE kunci=:kunci";
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


	
}

?>