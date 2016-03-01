<?php
require_once "model/class/master.php";
$guru = new Guru($_SESSION['username']);
$get_ekstra_id = $guru -> getPenugasanEkstra();
$ekstra_id = $get_ekstra_id[0]['ekskul_id'];
//echo $ekstra;

$daftar_siswa = $guru -> getDaftarNilaiEkstra($ekstra_id);
$daftar_count = sizeof($daftar_siswa);

for ($x = 0; $x < $daftar_count; $x++) {

	$siswa = new Siswa($daftar_siswa[$x]['nis']);
	$kelas = $siswa -> getKelas();
	$subkelas = $siswa -> getSubKelas();
	$no = $x + 1;
	$nama = $daftar_siswa[$x]['nama'];
	$nis = $daftar_siswa[$x]['nis'];
	$nilai = $daftar_siswa[$x]['nilai'];
	$keterangan = $daftar_siswa[$x]['keterangan'];
	$rec_nilai = $_POST["n-" . $nis];
	$rec_keterangan = $_POST["k-" . $nis];
	echo "$nis - $nama | $rec_nilai | $rec_keterangan |<br />";
	$ekstra = new Ekstra($ekstra_id);
	$nilai = $ekstra -> setNilai($nis, $rec_nilai);
	$keterangan = $ekstra -> setKeterangan($nis, $rec_keterangan);
}
header("Location: ?p=pertamax_ekstra_input_nilai_ekstra+input_nilai_ekstra&ok");

?>