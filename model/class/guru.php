<?php
Class Guru{

	public $_nip;
	public $_nama;
	public $_ktsp_mapel_id;
	public $_k13_mapel_id;
	
	public function __construct($nip){
		$this->_nip= $nip;
		$this->_nama= $this->getNama();
		$this->_ktsp_mapel_id=$this->getMapelID('ktsp');
		$this->_k13_mapel_id=$this->getMapelID('k13');
	}
	
	public function getMapelID($kurikulum){
		$dbTA=new DB('smpn1smg_master');
		$sqlguru = "SELECT ktsp_mapel_id,k13_mapel_id FROM data_guru WHERE nip=:nip";
		$guru = $dbTA->prepare("$sqlguru");
		$guru->bindParam(":nip",$this->_nip,PDO::PARAM_STR);	
		$guru->execute();
		$mapel_id = $guru->fetch();
		
		if ($kurikulum=="ktsp"){
			return $mapel_id['ktsp_mapel_id'];
		}elseif ($kurikulum=="k13"){
			return $mapel_id['k13_mapel_id'];
		}
	}
	
	public function getNamaMapel($kurikulum){
		$dbTA=new DB('smpn1smg_master');
		
		
		if ($kurikulum=="ktsp"){
			$sqlguru = "SELECT mapel_nama FROM ktsp_mapel WHERE ktsp_mapel_id=:ktsp_mapel_id";
			$guru = $dbTA->prepare("$sqlguru");
			$guru->bindParam(":ktsp_mapel_id",$this->_ktsp_mapel_id,PDO::PARAM_STR);	
			$guru->execute();
			$mapel_id = $guru->fetch();
			return $mapel_id['mapel_nama'];
			//return print_r($guru->errorInfo());
			
		}elseif ($kurikulum=="k13"){
			$sqlguru = "SELECT mapel_nama FROM k13_mapel WHERE k13_mapel_id=:k13_mapel_id";
			$guru = $dbTA->prepare("$sqlguru");
			$guru->bindParam(":k13_mapel_id",$this->_k13_mapel_id,PDO::PARAM_STR);	
			$guru->execute();
			$mapel_id = $guru->fetch();
			return $mapel_id['mapel_nama'];
		}
	}
	
	public function getKodeMapel($kurikulum){
		$dbTA=new DB('smpn1smg_master');
		
		
		if ($kurikulum=="ktsp"){
			$sqlguru = "SELECT kode_nama FROM ktsp_mapel WHERE ktsp_mapel_id=:ktsp_mapel_id";
			$guru = $dbTA->prepare("$sqlguru");
			$guru->bindParam(":ktsp_mapel_id",$this->_ktsp_mapel_id,PDO::PARAM_STR);	
			$guru->execute();
			$mapel_id = $guru->fetch();
			return $mapel_id['kode_nama'];
			//return print_r($guru->errorInfo());
			
		}elseif ($kurikulum=="k13"){
			$sqlguru = "SELECT kode_nama FROM k13_mapel WHERE k13_mapel_id=:k13_mapel_id";
			$guru = $dbTA->prepare("$sqlguru");
			$guru->bindParam(":k13_mapel_id",$this->_k13_mapel_id,PDO::PARAM_STR);	
			$guru->execute();
			$mapel_id = $guru->fetch();
			return $mapel_id['kode_nama'];
		}
	}
	
	public function getNama(){
		$dbTA=new DB('smpn1smg_master');
		$sqlguru = "SELECT nama FROM data_guru WHERE nip=:nip";
		$guru = $dbTA->prepare("$sqlguru");
		$guru->bindParam(":nip",$this->_nip,PDO::PARAM_STR);	
		$guru->execute();
		$nama = $guru->fetch();
		
		if($guru->errorCode()=="0000"){
				return $nama['nama'];
			}else{
				return print_r($guru->errorInfo());
			}
							
	}

	public function updateNama($nama){
		$dbTA=new DB('smpn1smg_master');
		$sqlguru = "UPDATE data_guru SET nama=:nama WHERE nip=:nip";
		$guru = $dbTA->prepare("$sqlguru");
		$guru->bindParam(":nama",$nama,PDO::PARAM_STR);	
		$guru->bindParam(":nip",$this->_nip,PDO::PARAM_STR);	
		$guru->execute();
		//$nama = $guru->fetch();
		
		if($guru->errorCode()=="0000"){
				return "1";
			}else{
				return print_r($guru->errorInfo());
			}
							
	}
	
	public function getKelas(){
		$dbTA=new DB($_SESSION['database']);
		$sqlguru = "SELECT kelas,subkelas FROM guru_aktif WHERE nip=:nip AND semester=:semester ORDER BY kelas,subkelas ASC";
		$guru = $dbTA->prepare("$sqlguru");
		$guru->bindParam(":nip",$this->_nip,PDO::PARAM_STR);
		$guru->bindParam(":semester",$_SESSION['semester'],PDO::PARAM_STR);		
		$guru->execute();
		$kelas = $guru->fetchAll();
		
		return $kelas;
	}
	
	public function getHanyaKelas(){
		$dbTA=new DB($_SESSION['database']);
		$sqlguru = "SELECT DISTINCT kelas FROM guru_aktif WHERE nip=:nip AND semester=:semester ORDER BY kelas ASC";
		$guru = $dbTA->prepare("$sqlguru");
		$guru->bindParam(":nip",$this->_nip,PDO::PARAM_STR);	
		$guru->bindParam(":semester",$_SESSION['semester'],PDO::PARAM_STR);	
		$guru->execute();
		$kelas = $guru->fetchAll();
		
		return $kelas;
	}
	
	public function getSubkelas($kelas){
		$dbTA=new DB($_SESSION['database']);
		$sqlguru = "SELECT subkelas FROM guru_aktif WHERE nip=:nip AND kelas=:kelas AND semester=:semester ORDER BY subkelas ASC";
		$guru = $dbTA->prepare("$sqlguru");
		$guru->bindParam(":nip",$this->_nip,PDO::PARAM_STR);	
		$guru->bindParam(":kelas",$kelas,PDO::PARAM_STR);
		$guru->bindParam(":semester",$_SESSION['semester'],PDO::PARAM_STR);	
		$guru->execute();
		$kelas = $guru->fetchAll();
		
		return $kelas;
	}
	
	public function getKelasTerisi(){
		$dbTA=new DB($_SESSION['database']);
		$sqlguru = "SELECT nip,kelas,subkelas FROM guru_aktif WHERE nip<>:nip AND ktsp_mapel_id=:ktsp_mapel_id AND semester=:semester";
		$guru = $dbTA->prepare("$sqlguru");
		$guru->bindParam(":nip",$this->_nip,PDO::PARAM_STR);
		$guru->bindParam(":ktsp_mapel_id",$this->_ktsp_mapel_id,PDO::PARAM_STR);	
		$guru->bindParam(":semester",$_SESSION['semester'],PDO::PARAM_STR);		
		$guru->execute();
		$kelas = $guru->fetchAll();
		$banyakKelas= $guru->rowCount();
		
		$coco=0;
		while($coco<>$banyakKelas){
			$guruKU=new Guru($kelas[$coco]['nip']);
			$kelas[$coco]['nama']=$guruKU->getNama();
			$coco++;
		}
				
		return $kelas;
	}
	
	public function cekKelas($kelas,$subkelas){
		$dbTA=new DB($_SESSION['database']);
		$sqlguru = "SELECT * FROM guru_aktif WHERE ktsp_mapel_id=:ktsp_mapel_id AND kelas=:kelas AND subkelas=:subkelas AND semester=:semester";
		$guru = $dbTA->prepare("$sqlguru");
		//$guru->bindParam(":nip",$this->_nip,PDO::PARAM_STR);
		$guru->bindParam(":ktsp_mapel_id",$this->_ktsp_mapel_id,PDO::PARAM_STR);			
		$guru->bindParam(":kelas",$kelas,PDO::PARAM_STR);	
		$guru->bindParam(":subkelas",$subkelas,PDO::PARAM_STR);	
		$guru->bindParam(":semester",$_SESSION['semester'],PDO::PARAM_STR);	
		$guru->execute();
		$kelas = $guru->rowCount();
		
		if($guru->errorCode()=="0000"){
			return $kelas;
		}else{
			return print_r($guru->errorInfo());
		}
		
	}
	
	public function setKelas($kelas,$subkelas){
		$dbTA=new DB($_SESSION['database']);
		
		if($this->cekKelas($kelas,$subkelas)=="0"){ 
							
			$sqlguru = "INSERT INTO guru_aktif (nip, ktsp_mapel_id, k13_mapel_id,kelas, subkelas,semester)
						VALUES (:nip, :ktsp_mapel_id, :k13_mapel_id, :kelas, :subkelas,:semester)";
			$guru = $dbTA->prepare("$sqlguru");
			$guru->bindParam(":nip",$this->_nip,PDO::PARAM_STR);	
			$guru->bindParam(":ktsp_mapel_id",$this->_ktsp_mapel_id,PDO::PARAM_STR);	
			$guru->bindParam(":k13_mapel_id",$this->_k13_mapel_id,PDO::PARAM_STR);	
			$guru->bindParam(":kelas",$kelas,PDO::PARAM_STR);	
			$guru->bindParam(":subkelas",$subkelas,PDO::PARAM_STR);	
			$guru->bindParam(":semester",$_SESSION['semester'],PDO::PARAM_STR);	
			$guru->execute();
			
			if($guru->errorCode()=="0000"){
				return "1";
			}else{
				return print_r($guru->errorInfo());
			}
		}else{
			

		}
		
					
				
	}
	
	public function setKelasBackup($kelas,$subkelas){
		$dbTA=new DB($_SESSION['database']);
									
			$sqlguru = "INSERT INTO guru_aktif_delete (nip, ktsp_mapel_id, k13_mapel_id,kelas, subkelas,semester)
						VALUES (:nip, :ktsp_mapel_id, :k13_mapel_id, :kelas, :subkelas,:semester)";
			$guru = $dbTA->prepare("$sqlguru");
			$guru->bindParam(":nip",$this->_nip,PDO::PARAM_STR);	
			$guru->bindParam(":ktsp_mapel_id",$this->_ktsp_mapel_id,PDO::PARAM_STR);	
			$guru->bindParam(":k13_mapel_id",$this->_k13_mapel_id,PDO::PARAM_STR);	
			$guru->bindParam(":kelas",$kelas,PDO::PARAM_STR);	
			$guru->bindParam(":subkelas",$subkelas,PDO::PARAM_STR);	
			$guru->bindParam(":semester",$_SESSION['semester'],PDO::PARAM_STR);	
			$guru->execute();
			
			if($guru->errorCode()=="0000"){
				return "1";
			}else{
				return print_r($guru->errorInfo());
			}
					
				
	}
	
	public function deleteKelas($kelas,$subkelas){
		$dbTA=new DB($_SESSION['database']);
		
		$this->setKelasBackup($kelas,$subkelas);
		
		if($this->cekKelas($kelas,$subkelas)>0){ 		
			$sqlguru = "DELETE FROM guru_aktif
						WHERE nip=:nip AND kelas=:kelas AND subkelas=:subkelas AND semester=:semester";
			$guru = $dbTA->prepare("$sqlguru");
			$guru->bindParam(":nip",$this->_nip,PDO::PARAM_STR);	
			$guru->bindParam(":kelas",$kelas,PDO::PARAM_STR);	
			$guru->bindParam(":subkelas",$subkelas,PDO::PARAM_STR);	
			$guru->bindParam(":semester",$_SESSION['semester'],PDO::PARAM_STR);	
			$guru->execute();
			
			if($guru->errorCode()=="0000"){
				return "1";
			}else{
				return print_r($guru->errorInfo());
			}
		}
			
	}		
	
	public function getBanyakKelas(){
		$dbTA=new DB($_SESSION['database']);
		$sqlsiswa = "SELECT id FROM guru_aktif WHERE nip=:nip";
		$siswa = $dbTA->prepare("$sqlsiswa");
		$siswa->bindParam(":nip",$this->_nip,PDO::PARAM_STR);
		//$siswa->bindParam(":subkelas",$this->_subkelas,PDO::PARAM_STR);		
		$siswa->execute();
		$banyakSiswa = $siswa->rowCount();
		
		if($siswa->errorCode()=="0000"){
			return $banyakSiswa;
		}else{
			return print_r($siswa->errorInfo());
		}
			
	}

	public function getPenugasanWali(){

		$dbTA = new DB($_SESSION['database']);
		$sqlwali = "SELECT kelas, subkelas FROM guru_walikelas WHERE nip = :nip";
		$wali = $dbTA -> prepare($sqlwali);
		$wali -> bindParam(":nip", $this -> _nip, PDO::PARAM_STR);
		$wali -> execute();
		$wali_process = $wali -> fetchAll();

		if ($wali -> errorCode() == "0000"){

			if ($wali_process == null){

				return null;
			} else {

				return $wali_process;
			}

		} else {

			return print_r($wali -> errorInfo());
		}
	}


	public function getPenugasanEkstra(){

		$dbTA = new DB($_SESSION['database']);
		$nip = $this -> _nip;
		$sqlekstra = "SELECT * FROM data_ekskul WHERE ekskul_guru LIKE '%$nip%'";
		$ekstra = $dbTA -> prepare($sqlekstra);
		$ekstra -> execute();
		$ekstra_process = $ekstra -> fetchAll();

		if ($ekstra -> errorCode() == "0000"){

			if ($ekstra_process == null){

				return null;
			} else {

				return $ekstra_process;
			}
		} else {
			
			return  print_r($ekstra -> errorInfo());
		}
	}

	public function setPenugasanWali($tokelas, $tosubkelas){

		$dbTA = new DB($_SESSION['database']);
		$sqlwali = "UPDATE guru_walikelas SET nip = :nip WHERE kelas = :kelas AND subkelas = :subkelas";
		$wali = $dbTA -> prepare($sqlwali);
		$wali -> bindParam(":kelas", $tokelas, PDO::PARAM_STR);
		$wali -> bindParam(":subkelas", $tosubkelas, PDO::PARAM_STR);
		$wali -> bindParam(":nip", $this -> _nip, PDO::PARAM_STR);
		$wali -> execute();

		if ($wali -> errorCode() == "0000"){

			return 1;
		} else {

			return print_r($wali -> errorInfo());
		}
	}

	public function delPenugasanWali(){

		$dbTA = new DB($_SESSION['database']);
		$sqlwali = "SELECT * FROM guru_walikelas WHERE nip = :nip";
		$wali = $dbTA -> prepare($sqlwali);
		$wali -> bindParam(":nip", $this -> _nip, PDO::PARAM_STR);
		$wali -> execute();
		$wali_data = $wali -> fetchAll();
		$wali_count = $wali -> rowCount();
		if ($wali_count <> 0){

			$dbTA = new DB($_SESSION['database']);
			$sqlwali = "UPDATE guru_walikelas SET nip = :nip WHERE kelas = :kelas AND subkelas = :subkelas";
			$wali = $dbTA -> prepare($sqlwali);
			$nip_empty = "";
			$wali -> bindParam(":nip", $nip_empty, PDO::PARAM_STR);
			$wali -> bindParam(":kelas", $wali_data[0][2], PDO::PARAM_STR);
			$wali -> bindParam(":subkelas", $wali_data[0][3], PDO::PARAM_STR);
			$wali -> execute();
		} 

		if ($wali -> errorCode() == "0000"){

			return 1;
		} else {

			return print_r($wali -> errorInfo());
		}
	}

	public function setPenugasanEkstra($toekstra){

		$cok = new DB($_SESSION['database']);
		$sql = "SELECT ekskul_nama,ekskul_guru FROM data_ekskul WHERE ekskul_nama = :ekskul_nama";
		$wa = $cok-> prepare($sql);
		$wa -> bindParam(":ekskul_nama", $toekstra);
		$wa -> execute();
		$data_wa = $wa -> fetchAll();
		$e_nama = $data_wa[0][0];
		$e_guru = $data_wa[0][1];
		$data = explode(",", $e_guru);
		//echo $data[0];
		
		$dbTA = new DB($_SESSION['database']);
		$po = "$e_guru," . $this -> _nip;
		echo $po;
		$sqlekstra = "UPDATE data_ekskul SET ekskul_guru = :ekskul_guru WHERE ekskul_nama = :ekskul_nama";
		$ekstra = $dbTA -> prepare($sqlekstra);
		$ekstra -> bindParam(":ekskul_guru", $po, PDO::PARAM_STR);
		$ekstra -> bindParam(":ekskul_nama", $toekstra, PDO::PARAM_STR);
		$ekstra -> execute();
		
		if ($ekstra -> errorCode() == "0000"){

			return 1;
		} else {
			
			return  print_r($ekstra -> errorInfo());
		}
	}

	public function delPenugasanEkstra(){

		$a = $this -> getPenugasanEkstra();
		print_r($a);
		$last = $a[0]['ekskul_guru'];
		$new = str_replace($this -> _nip, "", $last);


		$dbTA = new DB($_SESSION['database']);
		$sqlekstra = "UPDATE data_ekskul SET ekskul_guru = :ekskul_guru_a WHERE ekskul_guru = :ekskul_guru_b";
		$ekstra = $dbTA -> prepare($sqlekstra);
		$ekstra -> bindParam(":ekskul_guru_a", $new, PDO::PARAM_STR);
		$ekstra -> bindParam(":ekskul_guru_b", $last, PDO::PARAM_STR);
		$ekstra -> execute();

		if ($ekstra -> errorCode() == "0000"){

			return 1;
		} else {
			
			return  print_r($ekstra -> errorInfo());
		}
	}

	public function checkPenugasanWali($kelas, $subkelas){

		$dbTA = new DB($_SESSION['database']);
		$sqlwali = "SELECT * FROM guru_walikelas WHERE kelas = :kelas AND subkelas = :subkelas";
		$wali = $dbTA -> prepare($sqlwali);
		$wali -> bindParam(":kelas", $kelas, PDO::PARAM_STR);
		$wali -> bindParam(":subkelas", $subkelas, PDO::PARAM_STR);
		$wali -> execute();
		$data_wali_count = $wali -> rowCount();
		if ($data_wali_count == 0){

			echo "Wali Not Defined";

		} elseif ($data_wali_count == 1) {

			$data_wali = $wali -> fetchAll();
			if ($data_wali[0][1] == $this -> _nip){

				echo "Data Awal Wali Kelas";
			} elseif ($data_wali[0][1] == "") {

				echo "Tidak Ada Tabrakan Data";
			} else {

				echo "Sama Dengan " . $data_wali[0][1];
			}
		} else {
			
			echo "Database Error";
		}

	}

	public function checkPenugasanEkstra($get_ekstra){

		$dbTA = new DB($_SESSION['database']);
		$sqlekstra = "SELECT * FROM data_ekskul WHERE ekskul_nama = :ekskul_nama";
		$ekstra = $dbTA -> prepare($sqlekstra);
		$ekstra -> bindParam(":ekskul_nama", $get_ekstra, PDO::PARAM_STR);
		$ekstra -> execute();
		$data_ekstra_count = $ekstra -> rowCount();
		$data_ekstra = $ekstra -> fetchAll();
		
		if ($data_ekstra_count == 0){

			echo "Ekstra Not Defined";
		} elseif ($data_ekstra_count == 1){

			if ($data_ekstra[0][3] == $this -> _nip){

				echo "Data Awal Ekstrakurikuler";
			} elseif ($data_ekstra[0][3] == "") {

				echo "Tidak Ada Tabrakan Data";
			} else {

				$a = $data_ekstra[0][3];
				$ss = explode(",", $a);
				//print_r($ss);
				echo "Sudah diampu oleh:<br>";
				foreach($ss as $bo){
					$guru = new Guru($bo);

					$aa = $guru -> getNama();
					echo "$bo - $aa<br />";
				}
			}
		} else {

			echo "Database Error";
		}

	}

	public function getDaftarNilaiEkstra($get_ekstra){

		$dbTA = new DB($_SESSION['database']);
		$sqlekstra = "SELECT * FROM ekskul_nilai WHERE ekskul_id = :ekskul_id AND semester = :semester ORDER BY kelas, nis ASC";
		$ekstra = $dbTA -> prepare($sqlekstra);
		$ekstra -> bindParam(":ekskul_id", $get_ekstra, PDO::PARAM_STR);
		$ekstra -> bindParam(":semester", $_SESSION['semester'], PDO::PARAM_STR);
		$ekstra -> execute();

		$daftar = $ekstra -> fetchAll();
		$daftar_count = $ekstra -> rowCount();
		for ($a = 0; $a < $daftar_count; $a++){

			$siswa = new Siswa($daftar[$a][1]);
			$nama_siswa = $siswa -> getNama();
			$daftar[$a][6] = $nama_siswa;
			$daftar[$a]["nama"] = $nama_siswa;
		}

		return $daftar;
	}

}
?>