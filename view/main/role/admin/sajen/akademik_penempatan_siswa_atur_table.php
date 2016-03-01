<?php
require_once "model/class/master.php";

$dataMasuk=json_decode($_POST['json']);
$kelas= $dataMasuk[0];
$subkelas= $dataMasuk[1];

$kelas= new Kelas($kelas,$subkelas);
$getSiswa= $kelas->getSiswa();
$banyakSiswa= sizeof($getSiswa);
$x=0;

while ($x<$banyakSiswa) { 
	//$siswa= new Siswa($daftarNIS[$x]['nis']);
	$no=$x+1;
	echo "<tr>";
	echo "<td>".$no."</td>";
	echo "<td>".$getSiswa[$x]['nis']."</td>";
	echo "<td class='text-center'>".$getSiswa[$x]['kelamin']."</td>";
	echo "<td>".$getSiswa[$x]['nama']."</td>";
    echo "
    <td class='inline-popups text-center'>
	    <button id='deleteSiswa' siswa-nis='".$getSiswa[$x]['nis']."' siswa-nama='".$getSiswa[$x]['nama']."' class='btn btn-danger delete-siswa' data-toggle='modal' data-target='#ModalDelete'>
	    Hapus
	    </button>
    </td>";
    echo "</tr>";
	$x++;   
}
?>
<script>
$(function(){
	$('.delete-siswa').click(function(){
		var nis = $(this).attr("siswa-nis");
		var nama = $(this).attr("siswa-nama");
		var kelas = "<?php echo $dataMasuk[0];?>";
		var subkelas = "<?php echo $dataMasuk[1];?>";
		$("#kontenDelete").html("<h4 class='text-center' nis='" + nis + "'>Apakah anda yakin ingin menghapus<br />" + nama + "<br />"+ nis +"</h4>");
		$('.hapus-konfirm').attr("siswa-nis",nis);
		$('.hapus-konfirm').attr("siswa-nama",nama);
		$('.hapus-konfirm').attr("siswa-kelas",kelas);
		$('.hapus-konfirm').attr("siswa-subkelas",subkelas);
	});
});
</script>