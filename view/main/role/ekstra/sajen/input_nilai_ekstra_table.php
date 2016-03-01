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
	echo "<td>
			<div class='form-group text-center' style='margin-bottom: 0px;'>
				<input type='text' id='input-e' class='form-control input-sm input-e text-left' name='nilai-ekstra' nis='" . $getSiswa[$x]['nis'] . "' value='" . $nilai_ekstra . "' maxlength='3' tabindex='".$no."' style='font-size: 15px' >
			</div>
			</td>
		";
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
		var kelas = "<?php echo $dataMasuk[0];?>";
		var subkelas = "<?php echo $dataMasuk[1];?>";
		$("#kontenDelete").html("<h4 class='text-center' nis='" + nis + "'>Apakah anda yakin ingin menghapus<br />" + nama + "<br />"+ nis +"</h4>");
		$('.hapus-konfirm').attr("siswa-nis",nis);
		$('.hapus-konfirm').attr("siswa-nama",nama);
		$('.hapus-konfirm').attr("siswa-kelas",kelas);
		$('.hapus-konfirm').attr("siswa-subkelas",subkelas);
	});

	$(".input-e").keyup(function() {

		var get_nilai = $(this).val();
		var nilai = get_nilai.replace(/ /g,'');
		var nis = $(this).attr("nis");		
		var arrayGetInputNilaiEkstra = [nilai,nis];

		$.ajax({

			type: "POST",
			url: "index.php?sajen=input_nilai_ekstra_nilai",
			data: {json: JSON.stringify(arrayGetInputNilaiEkstra)},
			cache: false,
			success: function(html) {
				if (nilai == " "){

					create_toast("danger", "Input Nilai", "Nilai Kosong");
				} else {

					create_toast("info", "Input Nilai", nis + "->" + nilai);
				};

			} 
		});
	});
});
</script>