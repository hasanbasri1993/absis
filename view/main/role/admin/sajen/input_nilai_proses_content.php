<?php
include_once "model/class/master.php";
// Prevent caching.
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');

// The JSON standard MIME header.
header('Content-type: application/json');

// This ID parameter is sent by our javascript client.


$data=json_decode($_POST['json'],true);
/*
[0][0]=sessionID
[0][1]=TA
[0][2]=Semester
x=1 s/d jumlah cell yg diganti
[x][0]=NIS
[x][1]=Tipe Nilai (Ujian/Harian)
[x][2]=Kode Topik
[x][3]=Kode Nilai (UTS/UAS/UL/T/UT)
[x][4]=Nilai
[x][5]=Row
[x][6]=Col
*/
$banyakArray=sizeof($data);
$count=1;
$kirim_balik=array();

$kirim_balik[0][0]="200";
$kirim_balik[0][1]="Info Error";

$guru=new Guru($data[0][3]);
$kodeNamaMapel=$guru->getKodeMapel('ktsp');

while ($count < $banyakArray) {
	//$urutanArray=$count-1;

	$siswa= new Siswa($data[$count][0]);
	//$siswa->setNilaiHarian($data[$count][2],'UL','90');
	
	$nilai_db;
	if ($data[$count][1]=='ujian'){
	
		if($data[$count][3]=='UTS'){
			$siswa->setNilaiUTS($kodeNamaMapel,$data[$count][4]);
			$nilai_db=$siswa->getNilaiUTS($kodeNamaMapel);
		} elseif($data[$count][3]=='UAS'){
			$siswa->setNilaiUAS($kodeNamaMapel,$data[$count][4]);
			$nilai_db=$siswa->getNilaiUAS($kodeNamaMapel);
		}
	
	} elseif ($data[$count][1]=='harian'){
	
		$siswa->setNilaiHarian($data[$count][2],$data[$count][3],$data[$count][4]);
		$nilai_db=$siswa->getNilaiHarian($data[$count][2]);
		$nilai_db=$nilai_db[strtolower($data[$count][3])];
	}
	

	$kirim_balik[$count][0]=$data[$count][0];
	$kirim_balik[$count][1]=$data[$count][1];
	$kirim_balik[$count][2]=$data[$count][2];
	$kirim_balik[$count][3]=$data[$count][3];
	$kirim_balik[$count][4]=$nilai_db;
	// $kirim_balik[$count][0]=$siswa->getNama();
	//$kirim_balik[$count][1]=$siswa->getNilaiAkhir($kodeNamaMapel);//nilaiAkhir
	//$kirim_balik[$count][1]=$data[$count][4];//nilai
	$kirim_balik[$count][5]=$data[$count][5];//row
	$kirim_balik[$count][6]=$data[$count][6];//col
	$kirim_balik[$count][7]=$siswa->getNilaiAkhir($kodeNamaMapel);//nilai akhir (rapor UAS) ????????????????????????? EDIT DISINI MASSSSS

	
	$count++;
}
	
	//print_r($data);



// Send the data.
echo json_encode($kirim_balik);

?>
