<?php
require_once "model/class/master.php";
$guru = new Guru($_SESSION['username']);
$get_ekstra = $guru -> getPenugasanEkstra();
$dataMasuk=json_decode($_POST['json']);
$ekstra = $dataMasuk[0];
//echo $ekstra;

$daftar_siswa = $guru -> getDaftarNilaiEkstra($ekstra);
$daftar_count = sizeof($daftar_siswa);

for ($x = 0; $x < $daftar_count; $x++) { 

	$siswa = new Siswa($daftar_siswa[$x]['nis']);
	$kelas = $siswa -> getKelas();
	$subkelas = $siswa -> getSubKelas();
	$no=$x+1;
	echo "<tr>";
	echo "<td>".$no."</td>";
	echo "<td>".$daftar_siswa[$x]['nis']."</td>";
	echo "<td class='text-center'>".$kelas.$subkelas."</td>";
	echo "<td class='text-left'>".$daftar_siswa[$x]['nama']."</td>";
	echo "<td>
			<div class='form-group text-center' style='margin-bottom: 0px;'>
				<input type='text' class='form-control input-sm input-e text-left' name='n-" . $daftar_siswa[$x]['nis'] . "' nis='" . $daftar_siswa[$x]['nis'] . "' value='" . $daftar_siswa[$x]['nilai'] . "' maxlength='3' tabindex='".$no."' style='font-size: 15px' >
			</div>
			</td>
		";
	echo "<td>
		<div class='form-group text-center' style='margin-bottom: 0px;'>
			<input type='text' class='form-control input-sm input-e text-left' name='k-" . $daftar_siswa[$x]['nis'] . "' nis='" . $daftar_siswa[$x]['nis'] . "' value='" . $daftar_siswa[$x]['keterangan'] . "' tabindex='".$no."' style='font-size: 15px' >
		</div>
		</td>
	";
    echo "
    <td class='inline-popups text-center'>
	    <a href='#' id='deleteSiswa' siswa-nis='".$daftar_siswa[$x]['nis']."' siswa-nama='".$daftar_siswa[$x]['nama']."' class='btn btn-danger delete-siswa' data-toggle='modal' data-target='#ModalDelete'>
	    Hapus
	    </a>
    </td>";
    echo "</tr>";
}
?>
<script>
$(document).ready(function(){

	var create_toast = function (tipe,judul,pesan){
		var i = -1;
		var toastCount = 0;
		var shortCutFunction = tipe;//$("#toastTypeGroup input:radio:checked").val();
		var msg = pesan;//$('#message').val();
		var title = judul;//$('#title').val() || '';
		var showDuration = "300";
		var hideDuration = "100";
		var timeOut = "500";
		var extendedTimeOut = "200";
		var showEasing = "swing";
		var hideEasing = "linear";
		var showMethod = "fadeIn";
		var hideMethod = "fadeOut";
		var toastIndex = toastCount++;
		toastr.options = {
			closeButton: false, //true false broo
			debug: false,
			positionClass: 'toast-top-right', // Top Right Bottom Right Bottom Left Top Left Top Full Width Bottom Full Width
			onclick: null
		};
		var $toast = toastr[shortCutFunction](msg, title);
	};

	$('.delete-siswa').click(function(){
		var nis = $(this).attr("siswa-nis");
		var nama = $(this).attr("siswa-nama");
		$("#kontenDelete").html("<h4 class='text-center'>Apakah anda yakin ingin menghapus<br />"+ nis + " - " + nama + "</h4>" );
		$('.hapus-konfirm').attr("siswa-nis",nis);
	});
})
</script>