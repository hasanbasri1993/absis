<?php
class DB extends PDO{
    private $engine;
    private $host;
    private $database;
    private $user;
    private $pass;
       
    private $result;    
     
    public function __construct($database)
        {
        $this->engine   = 'mysql';
        $this->host     = 'localhost';
        $this->database = $database;
        $this->user     = 'root';
        $this->pass     = 'ganeshatiga';
               
        $dns = $this->engine.':dbname='.$this->database.";host=".$this->host;
        parent::__construct( $dns, $this->user, $this->pass );
    }
       
             
}
 


Class Siswa{

	public $_nis;
	public $_kelas;
	public $_subkelas;
	public $_nama;
	public $_kurikulum;
	public $_semester;
	public $_TA;

	public function __construct($nis){
		$this->_nis= $nis;
		$this->_semester= $_SESSION['semester'];
		$this->_TA= $_SESSION['TA'];
		//3 data di atas harus di awal

		$this->_kelas= $this->getKelas();
		$this->_subkelas= $this->getSubKelas();

		if (isset($this->_kelas) AND isset($this->_subkelas)) {
			$this->_aktif=1;
		} else{
			$this->_aktif=0;
		}

		$this->_nama= $this->getNama();
		$this->_kurikulum= $this->getKurikulum();
		
	}
	
	public function getKurikulum(){
		$dbTA=new DB($_SESSION['database']);
		$kurikulumKelas="kurikulumkelas".$this->_kelas."smt".$this->_semester;
		
		$sqlsiswa = "SELECT nilai FROM info_ta WHERE kunci=:kunci";
		$siswa = $dbTA->prepare("$sqlsiswa");
		$siswa->bindParam(":kunci",$kurikulumKelas,PDO::PARAM_STR);	
		$siswa->execute();
		$kurikulum = $siswa->fetch();
		
		return $kurikulum['nilai'];
	}

	public function getKelas(){
		$dbTA=new DB($_SESSION['database']);
		$sqlsiswa = "SELECT kelas FROM siswa_aktif WHERE nis=:nis AND semester=:semester";
		$siswa = $dbTA->prepare("$sqlsiswa");
		$siswa->bindParam(":nis",$this->_nis,PDO::PARAM_STR);	
		$siswa->bindParam(":semester",$this->_semester,PDO::PARAM_STR);	
		$siswa->execute();
		$kelas = $siswa->fetch();
		
		if($siswa->errorCode()=="0000"){
			return $kelas['kelas'];
		}else{
			return print_r($siswa->errorInfo());
		}
		
	}
	
	public function getSemuaKelasSubkelas(){
		$dbTA=new DB($_SESSION['database']);
		$sqlsiswa = "SELECT kelas,subkelas FROM siswa_aktif WHERE nis=:nis AND semester=:semester";
		$siswa = $dbTA->prepare("$sqlsiswa");
		$siswa->bindParam(":nis",$this->_nis,PDO::PARAM_STR);	
		$siswa->bindParam(":semester",$this->_semester,PDO::PARAM_STR);	
		$siswa->execute();
		$kelas = $siswa->fetchAll();
		
		return $kelas;
	}

	public function getSubKelas(){
		$dbTA=new DB($_SESSION['database']);
		$sqlsiswa = "SELECT subkelas FROM siswa_aktif WHERE nis=:nis AND semester=:semester";
		$siswa = $dbTA->prepare("$sqlsiswa");
		$siswa->bindParam(":nis",$this->_nis,PDO::PARAM_STR);
		$siswa->bindParam(":semester",$this->_semester,PDO::PARAM_STR);		
		$siswa->execute();
		$subkelas = $siswa->fetch();
		
		return $subkelas['subkelas'];
	}

	public function cekKelas($kelas=null,$subkelas=null){
		$dbTA=new DB($_SESSION['database']);
		if($kelas==null AND $subkelas==null){
			$sqlguru = "SELECT * FROM siswa_aktif WHERE nis=:nis AND semester=:semester";
			$guru = $dbTA->prepare("$sqlguru");
			$guru->bindParam(":nis",$this->_nis,PDO::PARAM_STR);
			$guru->bindParam(":semester",$this->_semester,PDO::PARAM_STR);	
			//$guru->bindParam(":ktsp_mapel_id",$this->_ktsp_mapel_id,PDO::PARAM_STR);			
			//$guru->bindParam(":kelas",$kelas,PDO::PARAM_STR);	
			//$guru->bindParam(":subkelas",$subkelas,PDO::PARAM_STR);	
			$guru->execute();
			$kelas = $guru->rowCount();
		
			return $kelas;
			
		} else {
			$sqlguru = "SELECT * FROM siswa_aktif WHERE nis=:nis AND kelas=:kelas AND subkelas=:subkelas AND semester=:semester";
			$guru = $dbTA->prepare("$sqlguru");
			$guru->bindParam(":nis",$this->_nis,PDO::PARAM_STR);
			//$guru->bindParam(":ktsp_mapel_id",$this->_ktsp_mapel_id,PDO::PARAM_STR);			
			$guru->bindParam(":kelas",$kelas,PDO::PARAM_STR);	
			$guru->bindParam(":subkelas",$subkelas,PDO::PARAM_STR);	
			$guru->bindParam(":semester",$this->_semester,PDO::PARAM_STR);
			$guru->execute();
			$kelas = $guru->rowCount();
			
			return $kelas;
		}
		
		
	}
	
	public function setKelas($kelas,$subkelas){
		$dbTA=new DB($_SESSION['database']);
		
			if($this->cekKelas()==0){
			//$this->deleteKelas();
							
			$sqlguru = "INSERT INTO siswa_aktif (nis, kelas, subkelas,semester)
						VALUES (:nis, :kelas, :subkelas,:semester)";
			$guru = $dbTA->prepare("$sqlguru");
			$guru->bindParam(":nis",$this->_nis,PDO::PARAM_STR);	
			$guru->bindParam(":kelas",$kelas,PDO::PARAM_STR);	
			$guru->bindParam(":subkelas",$subkelas,PDO::PARAM_STR);	
			$guru->bindParam(":semester",$this->_semester,PDO::PARAM_STR);
			$guru->execute();
			
			if($guru->errorCode()=="0000"){
				return "1";
			}else{
				return print_r($guru->errorInfo());
			}
			
			}else{
				return "Udah Dapet Kelas bro, delete sek";
			}
		
					
				
	}
	
	public function deleteKelas($kelas=null,$subkelas=null){
		$dbTA=new DB($_SESSION['database']);
		//BACKUP DATA DULU
		
			$banyakBackup=$this->cekKelas();
			$coco=0;
			$varSemuaKelas=$this->getSemuaKelasSubkelas();
			
			while ($coco<$banyakBackup){
				
				$sqlguru = "INSERT INTO siswa_aktif_delete (nis, kelas, subkelas,semester)
							VALUES (:nis, :kelas, :subkelas,:semester)";
				$guru = $dbTA->prepare("$sqlguru");
				$guru->bindParam(":nis",$this->_nis,PDO::PARAM_STR);	
				//$guru->bindParam(":ktsp_mapel_id",$this->_ktsp_mapel_id,PDO::PARAM_STR);	
				//$guru->bindParam(":k13_mapel_id",$this->_k13_mapel_id,PDO::PARAM_STR);	
				$guru->bindParam(":kelas",$varSemuaKelas[$coco]['kelas'],PDO::PARAM_STR);	
				$guru->bindParam(":subkelas",$varSemuaKelas[$coco]['subkelas'],PDO::PARAM_STR);	
				$guru->bindParam(":semester",$this->_semester,PDO::PARAM_STR);
				$guru->execute();
				
				$coco++;
			}
			
			
				
		//DELETE DATA 
			$sqlguru = "DELETE FROM siswa_aktif
						WHERE nis=:nis AND semester=:semester";
			$guru = $dbTA->prepare("$sqlguru");
			$guru->bindParam(":nis",$this->_nis,PDO::PARAM_STR);
			$guru->bindParam(":semester",$this->_semester,PDO::PARAM_STR);	
			//$guru->bindParam(":kelas",$kelas,PDO::PARAM_STR);	
			//$guru->bindParam(":subkelas",$subkelas,PDO::PARAM_STR);	
			$guru->execute();
			
			if($guru->errorCode()=="0000"){
				return "1";
			}else{
				return print_r($guru->errorInfo());
			}
		
			
	}

	public function getNama(){
		$dbTA=new DB('smpn1smg_master');
		$sqlsiswa = "SELECT nama FROM data_siswa WHERE nis=:nis";
		$siswa = $dbTA->prepare("$sqlsiswa");
		$siswa->bindParam(":nis",$this->_nis,PDO::PARAM_STR);	
		$siswa->execute();
		$nama = $siswa->fetch();
		
		return $nama['nama'];
	}

	public function updateNama($nama){
		$dbTA=new DB('smpn1smg_master');
		$sqlsiswa = "UPDATE data_siswa SET nama=:nama WHERE nis=:nis";
		$siswa = $dbTA->prepare("$sqlsiswa");
		$siswa->bindParam(":nama",$nama,PDO::PARAM_STR);	
		$siswa->bindParam(":nis",$this->_nis,PDO::PARAM_STR);	
		$siswa->execute();
		//$nama = $guru->fetch();
		
		if($siswa->errorCode()=="0000"){
				return "1";
			}else{
				return print_r($siswa->errorInfo());
			}
							
	}
	
	

	public function getKelamin(){
		$dbTA=new DB('smpn1smg_master');
		$sqlsiswa = "SELECT kelamin FROM data_siswa WHERE nis=:nis";
		$siswa = $dbTA->prepare("$sqlsiswa");
		$siswa->bindParam(":nis",$this->_nis,PDO::PARAM_STR);	
		$siswa->execute();
		$nama = $siswa->fetch();
		
		return $nama['kelamin'];
	}

	public function updateKelamin($kelamin){
		$dbTA=new DB('smpn1smg_master');
		$sqlsiswa = "UPDATE data_siswa SET kelamin=:kelamin WHERE nis=:nis";
		$siswa = $dbTA->prepare("$sqlsiswa");
		$siswa->bindParam(":kelamin",$kelamin,PDO::PARAM_STR);	
		$siswa->bindParam(":nis",$this->_nis,PDO::PARAM_STR);	
		$siswa->execute();
		//$nama = $guru->fetch();
		
		if($siswa->errorCode()=="0000"){
				return "1";
			}else{
				return print_r($siswa->errorInfo());
			}
							
	}


	public function getNISN(){
		$dbTA=new DB('smpn1smg_master');
		$sqlsiswa = "SELECT nisn FROM data_siswa WHERE nis=:nis";
		$siswa = $dbTA->prepare("$sqlsiswa");
		$siswa->bindParam(":nis",$this->_nis,PDO::PARAM_STR);	
		$siswa->execute();
		$nama = $siswa->fetch();
		
		return $nama['nisn'];
	}

	public function updateNISN($nisn){
		$dbTA=new DB('smpn1smg_master');
		$sqlsiswa = "UPDATE data_siswa SET nisn=:nisn WHERE nis=:nis";
		$siswa = $dbTA->prepare("$sqlsiswa");
		$siswa->bindParam(":nisn",$nisn,PDO::PARAM_STR);	
		$siswa->bindParam(":nis",$this->_nis,PDO::PARAM_STR);	
		$siswa->execute();
		//$nama = $guru->fetch();
		
		if($siswa->errorCode()=="0000"){
				return "1";
			}else{
				return print_r($siswa->errorInfo());
			}
							
	}

	public function getAgama(){
		$dbTA=new DB('smpn1smg_master');
		$sqlsiswa = "SELECT agama FROM data_siswa WHERE nis=:nis";
		$siswa = $dbTA->prepare("$sqlsiswa");
		$siswa->bindParam(":nis",$this->_nis,PDO::PARAM_STR);	
		$siswa->execute();
		$agama = $siswa->fetch();
		
		return $agama['agama'];
	}

	public function updateAgama($agama){
		$dbTA=new DB('smpn1smg_master');
	
	}


	public function getNIS(){
				
		return $this->_nis;
	}


	public function getNilaiUTS($kodeNamaMapel){
		$dbTA=new DB($_SESSION['database']);
		
		$mapel = new Mapel($kodeNamaMapel);
		$kodeMapel = $mapel->getKodeMapel();
		
		if ($this->_kurikulum=="ktsp"){
		$sqln = "
		SELECT uts
		FROM ktsp_ujian
		WHERE ktsp_mapel_id=:kodeMapel and nis=:nis and semester=:semester
		ORDER BY id DESC LIMIT 1
		";	
		} elseif ($this->_kurikulum=="k13"){
		$sqln = "
		SELECT uts
		FROM k13_ujian
		WHERE k13_mapel_id=:kodeMapel and nis=:nis and semester=:semester
		ORDER BY id DESC LIMIT 1
		";		
		}
				
		$n = $dbTA->prepare("$sqln");
		$n->bindParam(":kodeMapel",$kodeMapel,PDO::PARAM_STR);
		$n->bindParam(":nis",$this->_nis,PDO::PARAM_STR);
		$n->bindParam(":semester",$this->_semester,PDO::PARAM_STR);
		$n->execute();
		$rown = $n->fetch();										
		
		if($rown[0]==null){
			$nilaiUTS=0;
		}else{
			$nilaiUTS=$rown[0];
		}	

		if($n->errorCode()=="0000"){
				return $nilaiUTS;
			}else{
				return print_r($n->errorInfo());
			}
	}

	public function getNilaiUTSBackup($kodeNamaMapel,$tanggal){
		$dbTA=new DB($_SESSION['database']);

		$tanggal=$tanggal."  00:00:00";
		$mapel = new Mapel($kodeNamaMapel);
		$kodeMapel = $mapel->getKodeMapel();
		
		if ($this->_kurikulum=="ktsp"){
		$sqln = "
		SELECT uts,waktu
		FROM ktsp_ujian_backup
		WHERE ktsp_mapel_id=:kodeMapel and nis=:nis and semester=:semester and waktu<:waktu + INTERVAL 1 DAY
		ORDER BY id DESC LIMIT 1
		";	
		} elseif ($this->_kurikulum=="k13"){
		$sqln = "
		SELECT uts
		FROM k13_ujian
		WHERE k13_mapel_id=:kodeMapel and nis=:nis and semester=:semester
		ORDER BY id DESC LIMIT 1
		";		
		}
				
		$n = $dbTA->prepare("$sqln");
		$n->bindParam(":kodeMapel",$kodeMapel,PDO::PARAM_STR);
		$n->bindParam(":nis",$this->_nis,PDO::PARAM_STR);
		$n->bindParam(":semester",$this->_semester,PDO::PARAM_STR);
		$n->bindParam(":waktu",$tanggal,PDO::PARAM_STR);
		$n->execute();
		$rown = $n->fetch();	

		if($rown[0]==null){
			$nilaiUTS=0;
		}else{
			$nilaiUTS=$rown[0];
		}									
			
		if($n->errorCode()=="0000"){
				return $nilaiUTS;
			}else{
				return print_r($n->errorInfo());
			}
	}
    
	
	public function getNilaiUAS($kodeNamaMapel){
		$dbTA=new DB($_SESSION['database']);
		
		$mapel = new Mapel($kodeNamaMapel);
		$kodeMapel = $mapel->getKodeMapel();
		
		if ($this->_kurikulum=="ktsp"){
		$sqln = "
		SELECT uas
		FROM ktsp_ujian
		WHERE ktsp_mapel_id=:kodeMapel and nis=:nis and semester=:semester
		ORDER BY id DESC LIMIT 1
		";	
		} elseif ($this->_kurikulum=="k13"){
		$sqln = "
		SELECT uas
		FROM k13_ujian
		WHERE k13_mapel_id=:kodeMapel and nis=:nis and semester=:semester
		ORDER BY id DESC LIMIT 1
		";		
		}
				
		$n = $dbTA->prepare("$sqln");
		$n->bindParam(":kodeMapel",$kodeMapel,PDO::PARAM_STR);
		$n->bindParam(":nis",$this->_nis,PDO::PARAM_STR);
		$n->bindParam(":semester",$this->_semester,PDO::PARAM_STR);
		$n->execute();
		$rown = $n->fetch();	

		if($rown[0]==null){
			$nilaiUAS=0;
		}else{
			$nilaiUAS=$rown[0];
		}									
			
		if($n->errorCode()=="0000"){
				return $nilaiUAS;
			}else{
				return print_r($n->errorInfo());
			}
	}

	public function getNilaiUASBackup($kodeNamaMapel,$tanggal){
		$dbTA=new DB($_SESSION['database']);

		$tanggal=$tanggal."  00:00:00";
		$mapel = new Mapel($kodeNamaMapel);
		$kodeMapel = $mapel->getKodeMapel();
		
		if ($this->_kurikulum=="ktsp"){
		$sqln = "
		SELECT uas,waktu
		FROM ktsp_ujian_backup
		WHERE ktsp_mapel_id=:kodeMapel and nis=:nis and semester=:semester and waktu<:waktu + INTERVAL 1 DAY
		ORDER BY id DESC LIMIT 1
		";	
		} elseif ($this->_kurikulum=="k13"){
		$sqln = "
		SELECT uas
		FROM k13_ujian
		WHERE k13_mapel_id=:kodeMapel and nis=:nis and semester=:semester
		ORDER BY id DESC LIMIT 1
		";		
		}
				
		$n = $dbTA->prepare("$sqln");
		$n->bindParam(":kodeMapel",$kodeMapel,PDO::PARAM_STR);
		$n->bindParam(":nis",$this->_nis,PDO::PARAM_STR);
		$n->bindParam(":semester",$this->_semester,PDO::PARAM_STR);
		$n->bindParam(":waktu",$tanggal,PDO::PARAM_STR);
		$n->execute();
		$rown = $n->fetch();	

		if($rown[0]==null){
			$nilaiUAS=0;
		}else{
			$nilaiUAS=$rown[0];
		}									
			
		if($n->errorCode()=="0000"){
				return $nilaiUAS;
			}else{
				return print_r($n->errorInfo());
			}
	}
   

	public function getNilaiEkskul(){
		$dbTA=new DB($_SESSION['database']);

		$sqln ="
		SELECT *
		FROM ekskul_nilai
		WHERE nis=:nis and semester=:semester
		";

		$n = $dbTA->prepare("$sqln");
		$n->bindParam(":nis",$this->_nis,PDO::PARAM_STR);
		$n->bindParam(":semester",$this->_semester,PDO::PARAM_STR);
		$n->execute();
		$rown = $n->fetchAll();										
		
		if($n->errorCode()=="0000"){
				return $rown;
			}else{
				return print_r($n->errorInfo());
			}
	}

	public function getKehadiran(){
		$dbTA=new DB($_SESSION['database']);

		$sqln ="
		SELECT sakit,izin,alpha
		FROM kehadiran
		WHERE nis=:nis and semester=:semester
		";

		$n = $dbo->prepare("$sqln");
		$n->bindParam(":nis",$this->_nis,PDO::PARAM_STR);
		$n->bindParam(":semester",$this->_semester,PDO::PARAM_STR);
		$n->execute();
		$rown = $n->fetch();										
		
		if($n->errorCode()=="0000"){
				return $rown;
			}else{
				return print_r($n->errorInfo());
			}
	}

	//NILAI SIKAP DISIAPIN UNTUK PISAH KTSP DAN K13
	/*public function getNilaiSikap(){
		$dbTA=new DB($_SESSION['database']);

		$sqln ="
		SELECT kejur_nilai AS kejujuran, kedis_nilai AS kedisiplinan, tj_nilai AS tanggungjawab
		FROM daftarhadir_2014
		WHERE nis=:nis
		";

		$n = $dbo->prepare("$sqln");
		//$n->bindParam(":$$$$",$kodeNamaMapel,PDO::PARAM_STR);
		$n->bindParam(":nis",$this->_nis,PDO::PARAM_STR);
		$n->execute();
		$rown = $n->fetch();										
		
		return $rown;
	}*/


	public function getNilaiHarian($kodeTopik){
		$dbTA=new DB($_SESSION['database']);
		
		$sqln = "
		SELECT nip,ktsp_mapel_id 
		FROM ktsp_topik
		WHERE topik_id=:topik_id AND active='1'
		";

		$n = $dbTA->prepare("$sqln");
		$n->bindParam(":topik_id",$kodeTopik,PDO::PARAM_STR);
		$n->execute();
		$rown = $n->fetch();
		$kodeMapel = $rown['ktsp_mapel_id'];
		
		
		if ($this->_kurikulum=="ktsp"){

			$sqln = "
			SELECT ut,ul,t,rata 
			FROM ktsp_harian
			WHERE ktsp_mapel_id=:ktsp_mapel_id and nis=:nis and topik_id=:topik_id and semester=:semester and nip=:nip 
			ORDER BY id DESC LIMIT 1
			";
			$n = $dbTA->prepare("$sqln");
			$n->bindParam(":nis",$this->_nis,PDO::PARAM_STR);
			$n->bindParam(":ktsp_mapel_id",$kodeMapel,PDO::PARAM_STR);
			$n->bindParam(":topik_id",$kodeTopik,PDO::PARAM_STR);
			$n->bindParam(":semester",$this->_semester,PDO::PARAM_STR);
			$n->bindParam(":nip",$rown['nip'],PDO::PARAM_STR);
			$n->execute();
			$rown = $n->fetch();										
						
			if($n->errorCode()=="0000"){
				return $rown;
			}else{
				return print_r($n->errorInfo());
			}								
						
		} elseif ($this->_kurikulum=="k13"){
			
		}
	}

	public function setNilaiUTS($kodeNamaMapel,$nilai){
		if($nilai<>$this->getNilaiUTS($kodeNamaMapel)){

		$dbTA=new DB($_SESSION['database']);

		$mapel = new Mapel($kodeNamaMapel,$this->_kelas,$this->_subkelas);
		$kodeMapel = $mapel->getKodeMapel();

		
		$sqln ="
		SELECT * FROM ktsp_ujian
		WHERE ktsp_mapel_id=:ktsp_mapel_id and nis=:nis and semester=:semester
		";
		$n = $dbTA->prepare("$sqln");
		$n->bindParam(":nis",$this->_nis,PDO::PARAM_STR);
		$n->bindParam(":ktsp_mapel_id",$kodeMapel,PDO::PARAM_STR);
		$n->bindParam(":semester",$this->_semester,PDO::PARAM_STR);
		$n->execute();
		$rown = $n->fetch();

		//return print_r($rown);

		if (isset($rown['uts'])==0) {
			$rown['uts']=0;
		}

		if (isset($rown['uas'])==0) {
			$rown['uas']=0;
		}


		
			//bikin backup dulu klo nilainya beda
			$sqlguru = "INSERT INTO ktsp_ujian_backup (nis, ktsp_mapel_id, semester,uts,uas,username,waktu)
						VALUES (:nis, :ktsp_mapel_id, :semester,:uts,:uas,:username,:waktu)";
			$guru = $dbTA->prepare("$sqlguru");
			$guru->bindParam(":nis",$rown['nis'],PDO::PARAM_STR);	
			$guru->bindParam(":ktsp_mapel_id",$rown['ktsp_mapel_id'],PDO::PARAM_STR);	
			$guru->bindParam(":semester",$rown['semester'],PDO::PARAM_STR);
			$guru->bindParam(":uts",$rown['uts'],PDO::PARAM_STR);	
			$guru->bindParam(":uas",$rown['uas'],PDO::PARAM_STR);	
			$guru->bindParam(":username",$rown['username'],PDO::PARAM_STR);
			$guru->bindParam(":waktu",$rown['waktu'],PDO::PARAM_STR);
			$guru->execute();

			// if($guru->errorCode()=="0000"){
			// 	return "1";
			// }else{
			// 	return print_r($guru->errorInfo());
			// }

			//delete data2 lama
			$sqln = "DELETE FROM ktsp_ujian
			WHERE ktsp_mapel_id=:ktsp_mapel_id and nis=:nis and semester=:semester
			";
			$n = $dbTA->prepare("$sqln");
			$n->bindParam(":nis",$this->_nis,PDO::PARAM_STR);
			$n->bindParam(":ktsp_mapel_id",$kodeMapel,PDO::PARAM_STR);
			$n->bindParam(":semester",$this->_semester,PDO::PARAM_STR);
			$n->execute();

			//insert nilai baru

			$nilaiUTS=$nilai;
			$nilaiUAS=$rown['uas'];
						
			$sqlguru = "INSERT INTO ktsp_ujian (nis, ktsp_mapel_id, semester,uts,uas)
						VALUES (:nis, :ktsp_mapel_id, :semester,:uts,:uas)";
			$guru = $dbTA->prepare("$sqlguru");
			$guru->bindParam(":nis",$this->_nis,PDO::PARAM_STR);	
			$guru->bindParam(":ktsp_mapel_id",$kodeMapel,PDO::PARAM_STR);	
			$guru->bindParam(":semester",$this->_semester,PDO::PARAM_STR);
			$guru->bindParam(":uts",$nilaiUTS,PDO::PARAM_STR);	
			$guru->bindParam(":uas",$nilaiUAS,PDO::PARAM_STR);	
			$guru->execute();
			
			if($guru->errorCode()=="0000"){
				return "1";
			}else{
				return print_r($guru->errorInfo());
			}
		} else{ return "1";}
	}


	public function setNilaiUAS($kodeNamaMapel,$nilai){
	if($nilai<>$this->getNilaiUAS($kodeNamaMapel)){

		$dbTA=new DB($_SESSION['database']);

		$mapel = new Mapel($kodeNamaMapel,$this->_kelas,$this->_subkelas);
		$kodeMapel = $mapel->getKodeMapel();

		
		$sqln ="
		SELECT * FROM ktsp_ujian
		WHERE ktsp_mapel_id=:ktsp_mapel_id and nis=:nis and semester=:semester
		";
		$n = $dbTA->prepare("$sqln");
		$n->bindParam(":nis",$this->_nis,PDO::PARAM_STR);
		$n->bindParam(":ktsp_mapel_id",$kodeMapel,PDO::PARAM_STR);
		$n->bindParam(":semester",$this->_semester,PDO::PARAM_STR);
		$n->execute();
		$rown = $n->fetch();

		//return print_r($rown);

		if (isset($rown['uts'])==0) {
			$rown['uts']=0;
		}

		if (isset($rown['uas'])==0) {
			$rown['uas']=0;
		}


		
			//bikin backup dulu klo nilainya beda
			$sqlguru = "INSERT INTO ktsp_ujian_backup (nis, ktsp_mapel_id, semester,uts,uas,username,waktu)
						VALUES (:nis, :ktsp_mapel_id, :semester,:uts,:uas,:username,:waktu)";
			$guru = $dbTA->prepare("$sqlguru");
			$guru->bindParam(":nis",$rown['nis'],PDO::PARAM_STR);	
			$guru->bindParam(":ktsp_mapel_id",$rown['ktsp_mapel_id'],PDO::PARAM_STR);	
			$guru->bindParam(":semester",$rown['semester'],PDO::PARAM_STR);
			$guru->bindParam(":uts",$rown['uts'],PDO::PARAM_STR);	
			$guru->bindParam(":uas",$rown['uas'],PDO::PARAM_STR);	
			$guru->bindParam(":username",$rown['username'],PDO::PARAM_STR);
			$guru->bindParam(":waktu",$rown['waktu'],PDO::PARAM_STR);
			$guru->execute();

			// if($guru->errorCode()=="0000"){
			// 	return "1";
			// }else{
			// 	return print_r($guru->errorInfo());
			// }

			//delete data2 lama
			$sqln = "DELETE FROM ktsp_ujian
			WHERE ktsp_mapel_id=:ktsp_mapel_id and nis=:nis and semester=:semester
			";
			$n = $dbTA->prepare("$sqln");
			$n->bindParam(":nis",$this->_nis,PDO::PARAM_STR);
			$n->bindParam(":ktsp_mapel_id",$kodeMapel,PDO::PARAM_STR);
			$n->bindParam(":semester",$this->_semester,PDO::PARAM_STR);
			$n->execute();

			//insert nilai baru

			$nilaiUTS=$rown['uts'];
			$nilaiUAS=$nilai;
						
			$sqlguru = "INSERT INTO ktsp_ujian (nis, ktsp_mapel_id, semester,uts,uas)
						VALUES (:nis, :ktsp_mapel_id, :semester,:uts,:uas)";
			$guru = $dbTA->prepare("$sqlguru");
			$guru->bindParam(":nis",$this->_nis,PDO::PARAM_STR);	
			$guru->bindParam(":ktsp_mapel_id",$kodeMapel,PDO::PARAM_STR);	
			$guru->bindParam(":semester",$this->_semester,PDO::PARAM_STR);
			$guru->bindParam(":uts",$nilaiUTS,PDO::PARAM_STR);	
			$guru->bindParam(":uas",$nilaiUAS,PDO::PARAM_STR);	
			$guru->execute();
			
			if($guru->errorCode()=="0000"){
				return "1";
			}else{
				return print_r($guru->errorInfo());
			}
		} else{ return "1";}
	}

	public function setNilaiHarian($kodeTopik,$tipe,$nilai){
		$dbTA=new DB($_SESSION['database']);

		if($this->_kurikulum=='ktsp'){
			$sqln = "
			SELECT nip,ktsp_mapel_id 
			FROM ktsp_topik
			WHERE topik_id=:topik_id
			";

			$n = $dbTA->prepare("$sqln");
			$n->bindParam(":topik_id",$kodeTopik,PDO::PARAM_STR);
			$n->execute();
			$rown = $n->fetch();
			$nip=$rown[0];
			$ktsp_mapel_id=$rown[1];
		
		//BACKUP NILAI
			$sqln = "
			SELECT * 
			FROM ktsp_harian
			WHERE ktsp_mapel_id=:ktsp_mapel_id and nis=:nis and topik_id=:topik_id and semester=:semester and nip=:nip 
			ORDER BY id DESC LIMIT 1
			";
			$n = $dbTA->prepare("$sqln");
			$n->bindParam(":nis",$this->_nis,PDO::PARAM_STR);
			$n->bindParam(":ktsp_mapel_id",$ktsp_mapel_id,PDO::PARAM_STR);
			$n->bindParam(":topik_id",$kodeTopik,PDO::PARAM_STR);
			$n->bindParam(":semester",$this->_semester,PDO::PARAM_STR);
			$n->bindParam(":nip",$nip,PDO::PARAM_STR);
			$n->execute();
			$rown = $n->fetch();
			//print_r($n->errorInfo());
			//print_r($rown);
			
			$sqlguru = "INSERT INTO ktsp_harian_backup (nis, ktsp_mapel_id, topik_id,semester,ut,ul,t,nip,timestamp,rata)
							VALUES (:nis, :ktsp_mapel_id, :topik_id,:semester,:ut,:ul,:t,:nip,:timestamp,:rata)";
			$guru = $dbTA->prepare("$sqlguru");
			$guru->bindParam(":nis",$rown['nis'],PDO::PARAM_STR);
			$guru->bindParam(":ktsp_mapel_id",$rown['ktsp_mapel_id'],PDO::PARAM_STR);
			$guru->bindParam(":topik_id",$rown['topik_id'],PDO::PARAM_STR);
			$guru->bindParam(":semester",$rown['semester'],PDO::PARAM_STR);
			$guru->bindParam(":ut",$rown['ut'],PDO::PARAM_STR);
			$guru->bindParam(":ul",$rown['ul'],PDO::PARAM_STR);
			$guru->bindParam(":t",$rown['t'],PDO::PARAM_STR);
			$guru->bindParam(":nip",$rown['nip'],PDO::PARAM_STR);
			$guru->bindParam(":timestamp",$rown['timestamp'],PDO::PARAM_STR);
			$guru->bindParam(":rata",$rown['rata'],PDO::PARAM_STR);
			$guru->execute();
			//print_r($guru->errorInfo());
		
		//HAPUS NILAI
			$sqln = "DELETE FROM ktsp_harian
			WHERE ktsp_mapel_id=:ktsp_mapel_id and nis=:nis and topik_id=:topik_id and semester=:semester and nip=:nip 
			";
			$n = $dbTA->prepare("$sqln");
			$n->bindParam(":nis",$this->_nis,PDO::PARAM_STR);
			$n->bindParam(":ktsp_mapel_id",$ktsp_mapel_id,PDO::PARAM_STR);
			$n->bindParam(":topik_id",$kodeTopik,PDO::PARAM_STR);
			$n->bindParam(":semester",$this->_semester,PDO::PARAM_STR);
			$n->bindParam(":nip",$nip,PDO::PARAM_STR);
			$n->execute();
		
		
		//NGISI NILAI
				
			$nilaiHarian=$rown;
			
			if(isset($nilaiHarian['ul'])==0){
			$nilaiHarian['ul']=0;}
			if(isset($nilaiHarian['ut'])==0){
			$nilaiHarian['ut']=0;}
			if(isset($nilaiHarian['t'])==0){
			$nilaiHarian['t']=0;}
			
			if ($tipe=="UL") {
				$sqlguru = "INSERT INTO ktsp_harian (nis, ktsp_mapel_id, topik_id,semester,ut,ul,t,nip,rata)
							VALUES (:nis, :ktsp_mapel_id, :topik_id,:semester,:ut,:ul,:t,:nip,:rata)";
				$guru = $dbTA->prepare("$sqlguru");
				$guru->bindParam(":ut",$nilaiHarian['ut'],PDO::PARAM_STR);
				$guru->bindParam(":ul",$nilai,PDO::PARAM_STR);
				$guru->bindParam(":t",$nilaiHarian['t'],PDO::PARAM_STR);
				
				$pembagi=0;
				$rata=0;
				if (isset($nilai) AND $nilai>0){$pembagi=$pembagi+1;}
				if (isset($nilaiHarian['ut']) AND $nilaiHarian['ut']>0){$pembagi=$pembagi+1;}
				if (isset($nilaiHarian['t']) AND $nilaiHarian['t']>0){$pembagi=$pembagi+1;}
				if(($nilai+$nilaiHarian['ut']+$nilaiHarian['t'])!=0){$rata=($nilai+$nilaiHarian['ut']+$nilaiHarian['t'])/$pembagi;}
				
			}elseif ($tipe=="UT") {
				$sqlguru = "INSERT INTO ktsp_harian (nis, ktsp_mapel_id, topik_id,semester,ut,ul,t,nip,rata)
							VALUES (:nis, :ktsp_mapel_id, :topik_id,:semester,:ut,:ul,:t,:nip,:rata)";
				$guru = $dbTA->prepare("$sqlguru");
				$guru->bindParam(":ut",$nilai,PDO::PARAM_STR);
				$guru->bindParam(":ul",$nilaiHarian['ul'],PDO::PARAM_STR);
				$guru->bindParam(":t",$nilaiHarian['t'],PDO::PARAM_STR);
				
				$pembagi=0;
				$rata=0;
				if (isset($nilai) AND $nilai>0){$pembagi=$pembagi+1;}
				if (isset($nilaiHarian['t']) AND $nilaiHarian['t']>0){$pembagi=$pembagi+1;}
				if (isset($nilaiHarian['ul']) AND $nilaiHarian['ul']>0){$pembagi=$pembagi+1;}
				if(($nilai+$nilaiHarian['t']+$nilaiHarian['ul'])!=0){$rata=($nilai+$nilaiHarian['t']+$nilaiHarian['ul'])/$pembagi;}
				
			}elseif ($tipe=="T") {
				$sqlguru = "INSERT INTO ktsp_harian (nis, ktsp_mapel_id, topik_id,semester,ut,ul,t,nip,rata)
							VALUES (:nis, :ktsp_mapel_id, :topik_id,:semester,:ut,:ul,:t,:nip,:rata)";
				$guru = $dbTA->prepare("$sqlguru");
				$guru->bindParam(":ut",$nilaiHarian['ut'],PDO::PARAM_STR);
				$guru->bindParam(":ul",$nilaiHarian['ul'],PDO::PARAM_STR);
				$guru->bindParam(":t",$nilai,PDO::PARAM_STR);
				
				$pembagi=0;
				$rata=0;
				if (isset($nilai) AND $nilai>0){$pembagi=$pembagi+1;}
				if (isset($nilaiHarian['ut']) AND $nilaiHarian['ut']>0){$pembagi=$pembagi+1;}
				if (isset($nilaiHarian['ul']) AND $nilaiHarian['ul']>0){$pembagi=$pembagi+1;}
				if(($nilai+$nilaiHarian['ut']+$nilaiHarian['ul'])!=0){$rata=($nilai+$nilaiHarian['ut']+$nilaiHarian['ul'])/$pembagi;}
			}
			
			$guru->bindParam(":nis",$this->_nis,PDO::PARAM_STR);	
			$guru->bindParam(":ktsp_mapel_id",$ktsp_mapel_id,PDO::PARAM_STR);	
			$guru->bindParam(":topik_id",$kodeTopik,PDO::PARAM_STR);	
			$guru->bindParam(":semester",$this->_semester,PDO::PARAM_STR);
			$guru->bindParam(":nip",$nip,PDO::PARAM_STR);
			$guru->bindParam(":rata",$rata,PDO::PARAM_STR);
			$guru->execute();
			
			if($guru->errorCode()=="0000"){
				return "1";
			}else{
				return print_r($guru->errorInfo());
			}
		} elseif ($this->_kurikulum=='k13'){
		
		}

	}

	public function getNilaiRataHarian($kodeNamaMapel){
		$dbTA=new DB($_SESSION['database']);
		$mapel = new Mapel($kodeNamaMapel,$this->_kelas,$this->_subkelas);
		$kodeMapel = $mapel->getKodeMapel();
		
		if ($this->_kurikulum=="ktsp"){

			$sqln = "
			SELECT AVG(rata) 
			FROM ktsp_harian
			WHERE ktsp_mapel_id=:ktsp_mapel_id and nis=:nis and semester=:semester and nip=:nip and rata IS NOT NULL and rata !=0
			ORDER BY id DESC LIMIT 1
			";
			$n = $dbTA->prepare("$sqln");
			$n->bindParam(":nis",$this->_nis,PDO::PARAM_STR);
			$n->bindParam(":ktsp_mapel_id",$kodeMapel,PDO::PARAM_STR);
			$n->bindParam(":nip",$mapel->_nip,PDO::PARAM_STR);
			$n->bindParam(":semester",$this->_semester,PDO::PARAM_STR);
			$n->execute();
			$rown = $n->fetch();										
						
			if($n->errorCode()=="0000"){
				return $rown[0];
			}else{
				return print_r($n->errorInfo());
			}								
						
		} elseif ($this->_kurikulum=="k13"){
			
		}
		
	}
	
	public function getNilaiTotalHarian($kodeNamaMapel){
		$dbTA=new DB($_SESSION['database']);
		$mapel = new Mapel($kodeNamaMapel,$this->_kelas,$this->_subkelas);
		$kodeMapel = $mapel->getKodeMapel();
		
		if ($this->_kurikulum=="ktsp"){

			$sqln = "
			SELECT SUM(rata) 
			FROM ktsp_harian
			WHERE ktsp_mapel_id=:ktsp_mapel_id and nis=:nis and semester=:semester and nip=:nip and rata IS NOT NULL and rata !=0
			ORDER BY id DESC LIMIT 1
			";
			$n = $dbTA->prepare("$sqln");
			$n->bindParam(":nis",$this->_nis,PDO::PARAM_STR);
			$n->bindParam(":ktsp_mapel_id",$kodeMapel,PDO::PARAM_STR);
			$n->bindParam(":nip",$mapel->_nip,PDO::PARAM_STR);
			$n->bindParam(":semester",$this->_semester,PDO::PARAM_STR);
			$n->execute();
			$rown = $n->fetch();										
						
			if($n->errorCode()=="0000"){
				return $rown[0];
			}else{
				return print_r($n->errorInfo());
			}								
						
		} elseif ($this->_kurikulum=="k13"){
			
		}
		
	}
	
	public function getBanyakTotalHarian($kodeNamaMapel){
		$dbTA=new DB($_SESSION['database']);
		$mapel = new Mapel($kodeNamaMapel,$this->_kelas,$this->_subkelas);
		$kodeMapel = $mapel->getKodeMapel();
		
		if ($this->_kurikulum=="ktsp"){

			$sqln = "
			SELECT id
			FROM ktsp_harian
			WHERE ktsp_mapel_id=:ktsp_mapel_id and nis=:nis and semester=:semester and nip=:nip and rata IS NOT NULL and rata !=0
		
			";
			$n = $dbTA->prepare("$sqln");
			$n->bindParam(":nis",$this->_nis,PDO::PARAM_STR);
			$n->bindParam(":ktsp_mapel_id",$kodeMapel,PDO::PARAM_STR);
			$n->bindParam(":nip",$mapel->_nip,PDO::PARAM_STR);
			$n->bindParam(":semester",$this->_semester,PDO::PARAM_STR);
			$n->execute();
			$rown = $n->rowCount();										
						
			if($n->errorCode()=="0000"){
				return $rown;
			}else{
				return print_r($n->errorInfo());
			}								
						
		} elseif ($this->_kurikulum=="k13"){
			
		}
		
	}

	public function getNilaiAkhir($kodeNamaMapel){
		$dbTA=new DB($_SESSION['database']);
		$mapel = new Mapel($kodeNamaMapel,$this->_kelas,$this->_subkelas);
		$kodeMapel = $mapel->getKodeMapel();

		$nilaiTotal=($this->getNilaiUTS($kodeNamaMapel)+$this->getNilaiUAS($kodeNamaMapel)+$this->getNilaiTotalHarian($kodeNamaMapel));
		if ($nilaiTotal<>0 AND $nilaiTotal <> null){
			$nilai=$nilaiTotal/($this->getBanyakTotalHarian($kodeNamaMapel)+2);
		} else {$nilai =0;}
		return round($nilai,0);
		//return $this->getBanyakTotalHarian($kodeNamaMapel);
	}


}


Class Mapel{
	
	public $_kodeMapel;
	public $_kodeNamaMapel;
	public $_nip;
	public $_kelas;
	public $_subkelas;
	public $_semester;

	public function __construct($kodeNamaMapel,$kelas=null,$subkelas=null){
		
		switch ($kodeNamaMapel) {
			case 'AGAMAIS':
				$kode="102";
				break;
			
			case 'AGAMAHIN':
				$kode="101";
				break;
				
			case 'AGAMAKRIS':
				$kode="104";
				break;
				
			case 'AGAMAKAT':
				$kode="103";
				break;

			case 'PKN':
				$kode="2";
				break;

			case 'BINDO':
				$kode="3";
				break;

			case 'BING':
				$kode="4";
				break;

			case 'MAT':
				$kode="5";
				break;

			case 'IPA':
				$kode="6";
				break;

			case 'IPS':
				$kode="7";
				break;

			case 'SENI':
				$kode="8";
				break;

			case 'JASMANI':
				$kode="9";
				break;

			case 'TIK':
				$kode="10";
				break;

			case 'PRAKARYA':
				$kode="10";
				break;

			case 'BAJA':
				$kode="11";
				break;
			
			default:
				# code...
				break;
		}
		
		$this->_kodeMapel= $kode;
		$this->_kodeNamaMapel= $kodeNamaMapel;
		$this->_semester= $_SESSION['semester'];
		
		if(isset($kelas)){
		$this->_kelas= $kelas;
		if(isset($subkelas)){
			$this->_subkelas= $subkelas;
			$this->_nip= $this->getNIP();
		}
		}
		
	}

	public function getKodeMapel(){
		return $this->_kodeMapel;
	}

	public function getRataKelas($kelas,$subkelas){
		$kelasX= new Kelas ($kelas,$subkelas);
		$banyak_siswa= $kelasX->getBanyakSiswa();
		$daftar_siswa= $kelasX->getSiswa();

		$count=0;
		$totalNilai=0;
		while ($count < $banyak_siswa) {
			$siswa=new Siswa($daftar_siswa[$count]['nis']);
			$totalNilai= $totalNilai + $siswa->getNilaiAkhir($this->_kodeNamaMapel);
		}

		$rataKelas=$totalNilai/$banyak_siswa;

		return $rataKelas;
	}

	public function getKKM(){
		if ($this->_kelas=="7"){$array_start=0;}
		if ($this->_kelas=="8"){$array_start=11;}
		if ($this->_kelas=="9"){$array_start=22;}

		switch ($this->_kodeNamaMapel) {
			case 'AGAMA':
				$array_start=$array_start;
				break;

			case 'PKN':
				$array_start=$array_start+1;
				break;

			case 'BINDO':
				$array_start=$array_start+2;
				break;

			case 'BING':
				$array_start=$array_start+3;
				break;

			case 'MAT':
				$array_start=$array_start+4;
				break;

			case 'IPA':
				$array_start=$array_start+5;
				break;

			case 'IPS':
				$array_start=$array_start+6;
				break;

			case 'SENI':
				$array_start=$array_start+7;
				break;

			case 'JASMANI':
				$array_start=$array_start+8;
				break;

			case 'TIK':
				$array_start=$array_start+9;
				break;

			case 'BAJA':
				$array_start=$array_start+10;
				break;
			
			default:
				# code...
				break;
		}
		
		$_KKM=array(80,80,80,80,80,78,80,80,80,80,80,80,80,80,80,80,78,80,80,80,80,80,80,80,80,80,80,80,80,80,80,80,80,80,80,80,80,80,80,80,80,80,80,80);
		return $_KKM[$array_start];
	}

	public function getNIP(){
		$dbTA=new DB($_SESSION['database']);
		
		$kelas=new Kelas($this->_kelas,$this->_subkelas);
		$kurikulum= $kelas->getKurikulum();
		
		if($kurikulum=="ktsp"){
			
			$sqln = "
			SELECT nip
			FROM guru_aktif
			WHERE ktsp_mapel_id=:kodeMapel and kelas=:kelas and subkelas=:subkelas
			";
			$n = $dbTA->prepare("$sqln");
			$n->bindParam(":kodeMapel",$this->_kodeMapel,PDO::PARAM_STR);
			$n->bindParam(":kelas",$this->_kelas,PDO::PARAM_STR);
			$n->bindParam(":subkelas",$this->_subkelas,PDO::PARAM_STR);
			$n->execute();
			$rown = $n->fetch();
			
			return $rown['nip'];
			
		}elseif($kurikulum=="k13"){
			
			$sqln = "
			SELECT nip
			FROM guru_aktif
			WHERE k13_mapel_id=:kodeMapel and kelas=:kelas and subkelas=:subkelas
			";
			$n = $dbTA->prepare("$sqln");
			$n->bindParam(":kodeMapel",$this->_kodeMapel,PDO::PARAM_STR);
			$n->bindParam(":kelas",$this->_kelas,PDO::PARAM_STR);
			$n->bindParam(":subkelas",$this->_subkelas,PDO::PARAM_STR);
			$n->execute();
			$rown = $n->fetch();
			
			return $rown['nip'];
			
		}
		
	}

	/*public function getNamaGuru($kelas,$subkelas){
		$dbTA=new DB($_SESSION['database']);
		
		$sqln = "
		SELECT nama
		FROM user_guru_2014
		WHERE mata_pelajaran_id=:kodeMapel and kelas=:kelas and subkelas=:subkelas
		";
		$n = $dbo->prepare("$sqln");
		$n->bindParam(":kodeMapel",$this->_kodeMapel,PDO::PARAM_STR);
		$n->bindParam(":kelas",$kelas,PDO::PARAM_STR);
		$n->bindParam(":subkelas",$subkelas,PDO::PARAM_STR);
		$n->execute();
		$rown = $n->fetch();

		return $rown['nama'];
	}*/



	/*public function getBanyakTopik($kelas,$subkelas){
		$dbTA=new DB($_SESSION['database']);
		
		$sqln = "
		SELECT topik_id
		FROM topik_pengetahuan_2014
		WHERE pelajaran_id=:kodeMapel and kelas=:kelas and nip=:nip
		";
		$n = $dbo->prepare("$sqln");
		$n->bindParam(":kodeMapel",$this->_kodeMapel,PDO::PARAM_STR);
		$n->bindParam(":kelas",$kelas,PDO::PARAM_STR);
		$n->bindParam(":nip",$this->getNIP($kelas,$subkelas),PDO::PARAM_STR);
		$n->execute();
		$rown = $n->rowCount();

		return $rown;
	}*/

	public function getNamaTopik($kodeTopik){
		$dbTA=new DB($_SESSION['database']);
		
		$sqln = "
		SELECT topik
		FROM topik_pengetahuan_2014
		WHERE topik_id=:kodeTopik
		";
		$n = $dbo->prepare("$sqln");
		$n->bindParam(":kodeTopik",$kodeTopik,PDO::PARAM_STR);
	
		$n->execute();
		$rown = $n->fetch();

		return $rown['topik'];
	}
	
	public function getSingkatanNamaTopik($kodeTopik){
		$dbTA=new DB($_SESSION['database']);
		
		$sqln = "
		SELECT topik_nama_singkat
		FROM topik_pengetahuan_2014
		WHERE topik_id=:kodeTopik
		";
		$n = $dbo->prepare("$sqln");
		$n->bindParam(":kodeTopik",$kodeTopik,PDO::PARAM_STR);
	
		$n->execute();
		$rown = $n->fetch();

		return $rown['topik_nama_singkat'];
	}

	/*public function getKodeTopik($namaTopik,$kelas,$subkelas){
		$dbTA=new DB($_SESSION['database']);
		
		$sqln = "
		SELECT topik_id
		FROM topik_pengetahuan_2014
		WHERE topik=:namaTopik and nip=:nip and kelas=:kelas
		";
		$n = $dbo->prepare("$sqln");
		$n->bindParam(":namaTopik",$namaTopik,PDO::PARAM_STR);
		$n->bindParam(":kelas",$kelas,PDO::PARAM_STR);
		$n->bindParam(":nip",$this->getNIP($kelas,$subkelas),PDO::PARAM_STR);
		$n->execute();
		$rown = $n->fetch();

		return $rown;
	}*/

	public function getTopik(){
		$dbTA=new DB($_SESSION['database']);
		
		$kelas=new Kelas($this->_kelas,$this->_subkelas);
		$kurikulum=$kelas->getKurikulum();
		$active='1';
		
		if($kurikulum=="ktsp"){
			
			$sqln = "
			SELECT *
			FROM ktsp_topik
			WHERE nip=:nip and kelas=:kelas and semester=:semester and active=:active
			";
			$n = $dbTA->prepare("$sqln");
			
			$n->bindParam(":kelas",$this->_kelas,PDO::PARAM_STR);
			$n->bindParam(":nip",$this->_nip,PDO::PARAM_STR);
			$n->bindParam(":semester",$this->_semester,PDO::PARAM_STR);
			$n->bindParam(":active",$active,PDO::PARAM_STR);
			$n->execute();
			$rown = $n->fetchAll();

			if($n->errorCode()=="0000"){
				return $rown;
			}else{
				return print_r($n->errorInfo());
			}
			
		}elseif($kurikulum=="k13"){
			
			$sqln = "
			SELECT *
			FROM k13_topik
			WHERE nip=:nip and kelas=:kelas and semester=:semester and active=:active
			";
			$n = $dbo->prepare("$sqln");
			
			$n->bindParam(":kelas",$this->_kelas,PDO::PARAM_STR);
			$n->bindParam(":nip",$this->_nip,PDO::PARAM_STR);
			$n->bindParam(":semester",$this->_semester,PDO::PARAM_STR);
			$n->bindParam(":active",$active,PDO::PARAM_STR);
			$n->execute();
			$rown = $n->fetchAll();

			if($n->errorCode()=="0000"){
				return $rown;
			}else{
				return print_r($n->errorInfo());
			}
			
		}
		
	}
	
	public function buatTopik($nama_topik,$nama_topik_singkat,$afterUTS){
		$dbTA=new DB($_SESSION['database']);
		
		$active='1';
		$kelas=new Kelas($this->_kelas,$this->_subkelas);
		$kurikulum=$kelas->getKurikulum();
		
		if($kurikulum=="ktsp"){
			
			$sqln = "
			INSERT INTO ktsp_topik (nip, ktsp_mapel_id, kelas, active,afterUTS,topik_nama,topik_nama_singkat,semester) 
						VALUES (:nip, :ktsp_mapel_id, :kelas, :active,:afterUTS,:nama_topik,:nama_topik_singkat,:semester)
			";
			$n = $dbTA->prepare("$sqln");
			
			$n->bindParam(":nip",$this->_nip,PDO::PARAM_STR);
			$n->bindParam(":ktsp_mapel_id",$this->_kodeMapel,PDO::PARAM_STR);
			$n->bindParam(":kelas",$this->_kelas,PDO::PARAM_STR);
			$n->bindParam(":active",$active,PDO::PARAM_STR);
			$n->bindParam(":afterUTS",$afterUTS,PDO::PARAM_STR);
			$n->bindParam(":nama_topik",$nama_topik,PDO::PARAM_STR);
			$n->bindParam(":nama_topik_singkat",$nama_topik_singkat,PDO::PARAM_STR);
			$n->bindParam(":semester",$this->_semester,PDO::PARAM_STR);
			$error=$n->execute();
			//$rown = $n->fetchAll();

			if($error=="1"){
				return "1";
			}else{
				return print_r($n->errorInfo());
			}
			
		}elseif($kurikulum=="k13"){
			
			$sqln = "
			SELECT *
			FROM k13_topik
			WHERE nip=:nip and kelas=:kelas
			";
			$n = $dbo->prepare("$sqln");
			
			$n->bindParam(":kelas",$this->_kelas,PDO::PARAM_STR);
			$n->bindParam(":nip",$this->_nip,PDO::PARAM_STR);
			$n->execute();
			$rown = $n->fetchAll();

			if($n->errorCode()=="0000"){
				return $rown;
			}else{
				return print_r($n->errorInfo());
			}
			
		}
		
	}
	
	public function hapusTopik($kode_topik){
		$dbTA=new DB($_SESSION['database']);
		
		$active='0';
		$kelas=new Kelas($this->_kelas,$this->_subkelas);
		$kurikulum=$kelas->getKurikulum();
		
		if($kurikulum=="ktsp"){
			
			$sqln = "
			DELETE from ktsp_topik
			WHERE topik_id=:topik_id
			";
			$n = $dbTA->prepare("$sqln");
			
			//$n->bindParam(":nip",$this->_nip,PDO::PARAM_STR);
			//$n->bindParam(":ktsp_mapel_id",$this->_kodeMapel,PDO::PARAM_STR);
			//$n->bindParam(":kelas",$this->_kelas,PDO::PARAM_STR);
			//$n->bindParam(":active",$active,PDO::PARAM_STR);
			//$n->bindParam(":afterUTS",$afterUTS,PDO::PARAM_STR);
			//$n->bindParam(":topik_nama",$nama_topik,PDO::PARAM_STR);
			//$n->bindParam(":nama_topik_singkat",$nama_topik_singkat,PDO::PARAM_STR);
			$n->bindParam(":topik_id",$kode_topik,PDO::PARAM_STR);
			$error=$n->execute();
			//$rown = $n->fetchAll();
			
			$sqln = "
			DELETE from ktsp_harian
			WHERE topik_id=:topik_id
			";
			$n = $dbTA->prepare("$sqln");
			
			//$n->bindParam(":nip",$this->_nip,PDO::PARAM_STR);
			//$n->bindParam(":ktsp_mapel_id",$this->_kodeMapel,PDO::PARAM_STR);
			//$n->bindParam(":kelas",$this->_kelas,PDO::PARAM_STR);
			//$n->bindParam(":active",$active,PDO::PARAM_STR);
			//$n->bindParam(":afterUTS",$afterUTS,PDO::PARAM_STR);
			//$n->bindParam(":topik_nama",$nama_topik,PDO::PARAM_STR);
			//$n->bindParam(":nama_topik_singkat",$nama_topik_singkat,PDO::PARAM_STR);
			$n->bindParam(":topik_id",$kode_topik,PDO::PARAM_STR);
			$error=$n->execute();
			//$rown = $n->fetchAll();


			if($error=="1"){
				return "1";
			}else{
				return print_r($n->errorInfo());
			}
			
		}elseif($kurikulum=="k13"){
			
			$sqln = "
			SELECT *
			FROM k13_topik
			WHERE nip=:nip and kelas=:kelas
			";
			$n = $dbo->prepare("$sqln");
			
			$n->bindParam(":kelas",$this->_kelas,PDO::PARAM_STR);
			$n->bindParam(":nip",$this->_nip,PDO::PARAM_STR);
			$n->execute();
			$rown = $n->fetchAll();

			if($n->errorCode()=="0000"){
				return $rown;
			}else{
				return print_r($n->errorInfo());
			}
			
		}
		
	}
	
	public function updateTopik($kode_topik,$nama_topik,$nama_topik_singkat,$afterUTS){
		$dbTA=new DB($_SESSION['database']);
		
		$active='1';
		$kelas=new Kelas($this->_kelas,$this->_subkelas);
		$kurikulum=$kelas->getKurikulum();
		
		if($kurikulum=="ktsp"){
			
			$sqln = "
			UPDATE ktsp_topik SET afterUTS=:afterUTS,topik_nama=:topik_nama,topik_nama_singkat=:nama_topik_singkat 
			WHERE topik_id=:topik_id
			";
			$n = $dbTA->prepare("$sqln");
			
			//$n->bindParam(":nip",$this->_nip,PDO::PARAM_STR);
			//$n->bindParam(":ktsp_mapel_id",$this->_kodeMapel,PDO::PARAM_STR);
			//$n->bindParam(":kelas",$this->_kelas,PDO::PARAM_STR);
			//$n->bindParam(":active",$active,PDO::PARAM_STR);
			$n->bindParam(":afterUTS",$afterUTS,PDO::PARAM_STR);
			$n->bindParam(":topik_nama",$nama_topik,PDO::PARAM_STR);
			$n->bindParam(":nama_topik_singkat",$nama_topik_singkat,PDO::PARAM_STR);
			$n->bindParam(":topik_id",$kode_topik,PDO::PARAM_STR);
			$error=$n->execute();
			//$rown = $n->fetchAll();

			if($error=="1"){
				return "1";
			}else{
				return print_r($n->errorInfo());
			}
			
		}elseif($kurikulum=="k13"){
			
			$sqln = "
			SELECT *
			FROM k13_topik
			WHERE nip=:nip and kelas=:kelas
			";
			$n = $dbo->prepare("$sqln");
			
			$n->bindParam(":kelas",$this->_kelas,PDO::PARAM_STR);
			$n->bindParam(":nip",$this->_nip,PDO::PARAM_STR);
			$n->execute();
			$rown = $n->fetchAll();

			if($n->errorCode()=="0000"){
				return $rown;
			}else{
				return print_r($n->errorInfo());
			}
			
		}
		
	}
}


include_once "guru.php";

include_once "kelas.php";

include_once "sekolah.php";

include_once "data_umum.php";

//include_once "activities.php";
?>