<?php
Class Ekstra{

	public $_ekstra_id;
	
	public function __construct($ekstra_id){
		$this -> _ekstra_id = $ekstra_id;
	}

	public function insertSiswa($nis){

		if (($this -> checkSiswa($nis)) == "tidak"){

			$dbTA = new DB($_SESSION['database']);
			$siswa = new Siswa($nis);
			$kelas = $siswa -> getKelas();
			$subkelas = $siswa -> getSubKelas();
			$getkelassubkelas = "$kelas$subkelas";
			$sqlekstra = "INSERT INTO ekskul_nilai (nis, kelas, ekskul_id, semester) VALUES (:nis, :kelas, :ekskul_id, :semester)";
			$ekstra = $dbTA -> prepare("$sqlekstra");
			$ekstra -> bindParam(":nis", $nis);
			$ekstra -> bindParam(":kelas", $getkelassubkelas);
			$ekstra -> bindParam(":ekskul_id", $this -> _ekstra_id, PDO::PARAM_STR);
			$ekstra -> bindParam(":semester", $_SESSION['semester']);
			if ($ekstra -> execute()){

				return "1";
			} else {

				return "gagal";
			}
		} else {

			return "Sudah Ada";
		}
	}

	public function deleteSiswa($nis){

		$dbTA = new DB($_SESSION['database']);
		$sqldelete = "DELETE FROM ekskul_nilai WHERE nis = :nis AND ekskul_id = :ekskul_id AND semester = :semester";
		$delete = $dbTA -> prepare($sqldelete);
		$delete -> bindParam(":nis", $nis);
		$delete -> bindParam(":ekskul_id", $this -> _ekstra_id);
		$delete -> bindParam(":semester", $_SESSION['semester']);
		if ($delete -> execute()){

			return "sukses";
		} else {
			
			return "gagal";
		}
	}

	public function checkSiswa($nis){

		$dbTA = new DB($_SESSION['database']);
		$sqlcheck = "SELECT nis FROM ekskul_nilai WHERE nis = :nis AND ekskul_id = :ekskul_id AND semester = :semester";
		$check = $dbTA -> prepare($sqlcheck);
		$check -> bindParam(":nis", $nis);
		$check -> bindParam(":ekskul_id", $this -> _ekstra_id);
		$check -> bindParam(":semester", $_SESSION['semester']);
		if ($check -> execute()){

			$count = $check -> rowCount();
			if ($count == 1){

				return "ada";
			} elseif($count == 0){

				return "tidak";
			} else {

				return "error";
			}
		} else {

			return "exec error";
		}

	}

	public function setNilai($nis, $nilai){

		$dbTA = new DB($_SESSION['database']);
		$sqlSet = "UPDATE ekskul_nilai SET nilai = :nilai WHERE nis = :nis and ekskul_id = :ekskul_id and semester = :semester";
		$set = $dbTA -> prepare($sqlSet);
		$set -> bindParam(":nilai", $nilai);
		$set -> bindParam(":nis", $nis);
		$set -> bindParam(":ekskul_id", $this -> _ekstra_id);
		$set -> bindParam(":semester", $_SESSION['semester']);
		if ($set -> execute()){

			return "1";
		} else {

			return "gagal";
		}
	}

	public function setKeterangan($nis, $keterangan){

		$dbTA = new DB($_SESSION['database']);
		$sqlSet = "UPDATE ekskul_nilai SET keterangan = :keterangan WHERE nis = :nis and ekskul_id = :ekskul_id and semester = :semester";
		$set = $dbTA -> prepare($sqlSet);
		$set -> bindParam(":keterangan", $keterangan);
		$set -> bindParam(":nis", $nis);
		$set -> bindParam(":ekskul_id", $this -> _ekstra_id);
		$set -> bindParam(":semester", $_SESSION['semester']);
		if ($set -> execute()){

			return "1";
		} else {

			return "gagal";
		}
	}

	public function getNama(){
		$dbTA=new DB($_SESSION['database']);

		$sqln ="
		SELECT ekskul_nama
		FROM data_ekskul
		WHERE ekskul_id=:ekskul_id
		";

		$n = $dbTA->prepare("$sqln");
		$n->bindParam(":ekskul_id",$this -> _ekstra_id);
		$n->execute();
		$rown = $n->fetchAll();

		if($n->errorCode()=="0000"){
				return $rown[0]['ekskul_nama'];
			}else{
				return print_r($n->errorInfo());
			}
	}	
}
?>