<?php
$dataSearch=json_decode($_POST['json']);
$query = htmlspecialchars($dataSearch[0], ENT_QUOTES);
$page_request = htmlspecialchars($dataSearch[1], ENT_QUOTES);
$page = $page_request - 1;
$item=32;
$sql_limited = "SELECT * FROM data_siswa WHERE nama LIKE '%$query%' OR nis LIKE '%$query%' ORDER BY nis ASC LIMIT $page,$item";
$showdata_limited = $dbo -> prepare("$sql_limited");
$showdata_limited -> execute();
$row = $showdata_limited -> fetchAll();

$sql_all = "SELECT * FROM data_siswa";
$showdata_all = $dbo -> prepare("$sql_all");
$showdata_all -> execute();

$no_all = $showdata_all -> rowCount();
$no_limited = $showdata_limited -> rowCount();

$total_pages = ceil($no_limited/$item);
$x = 0;
$a = 1;
if ($no_limited == 0){
	echo "
	<tr>
		<td class='text-center' colspan='8'>
			Nama atau NIS: \"$query\" tidak ditemukan 
		</td>
	</tr>
		";
}
if ($no_limited != 0 ){

	while ($x<>$no_limited) {
		$get_nama = $row[$x]['nama'];
		$get_nis = $row[$x]['nis'];
		$get_nisn = $row[$x]['nisn'];
		$get_kelamin = $row[$x]['kelamin'];
		if ($get_kelamin == "L") {
			$get_kelamin = "Laki-Laki";
			$kelamin_ubah = "1";
		}else if ($get_kelamin == "P") {
			$get_kelamin = "Perempuan";
			$kelamin_ubah = "2";
		} else {
			$get_kelamin = "Undefined";
			$kelamin_ubah = "3";
		}
		$nis = htmlspecialchars($get_nis, ENT_QUOTES, "UTF-8");
		$nisn = htmlspecialchars($get_nisn, ENT_QUOTES, "UTF-8");
		$nama = htmlspecialchars($get_nama, ENT_QUOTES, "UTF-8");
		$kelamin = htmlspecialchars($get_kelamin, ENT_QUOTES, "UTF-8");
		if ($nisn == ""){
			$nisn = "0";
		}
		$kelas = htmlspecialchars("00", ENT_QUOTES, "UTF-8");
	    echo "<tr>";
	    echo "<td>$a</td>";
		echo "<td>$nama <span class='badge badge-info badge-$nis'>aktif</span></td>";
	    echo "<td>$kelamin</td>";
		echo "<td>$nis</td>";
		echo "<td>$nisn</td>";
		echo "<td><input id='switch-state' siswa-nis='$nis' type='checkbox' data-size='mini' data-on-text='1' data-off-text='0' data-on-color='primary' data-off-color='warning' switch checked></td>";
	    echo "<td><button name='button' data-toggle='modal' data-target='#ModalUbahSiswa' class='btn btn-info ubah-siswa' siswa-nis='$nis' siswa-nisn='$nisn' siswa-nama='$nama' siswa-kelamin='$kelamin_ubah'>Ubah</button></td>";
	    echo "<td><button name='button' data-toggle='modal' data-target='#ModalHapusSiswa' class='btn btn-danger hapus-siswa' siswa-nis='$nis' siswa-nama='$nama'>Hapus</button></td>";
	    echo "</tr>";
		$x++;
		$a++;
	}
}
?>
	<script>
	$(document).ready(function(){

		$("[switch]").bootstrapSwitch();

		$('[switch]').on('switchChange.bootstrapSwitch', function () {

			var get_state = $(this).bootstrapSwitch('state');
			var nis = $(this).attr("siswa-nis");
			if (get_state == false){

				var query = "false";
				var arrayGetDataSwitch = [query];
				$.ajax({

					type: "POST",
					url: "?sajen=data_umum_siswa_switch",
					data: {json: JSON.stringify(arrayGetDataSwitch)},
					cache: false,
					success: function(html) {

						$(".badge-" + nis).attr("class", "badge badge-danger badge-" + nis);
						$(".badge-" + nis).html("tidak aktif");
						create_toast("info","TIDAK AKTIF",nis + "->" + get_state);
					} 
				});				
			} else {

				var query = "true";
				var arrayGetDataSwitch = [query];
				$.ajax({

					type: "POST",
					url: "?sajen=data_umum_siswa_switch",
					data: {json: JSON.stringify(arrayGetDataSwitch)},
					cache: false,
					success: function(html) {

						$(".badge-" + nis).attr("class", "badge badge-info badge-" + nis);
						$(".badge-" + nis).html("aktif");
						create_toast("info","AKTIF",nis + "->" + get_state);
					} 
				});		
			};
		});

		$('.ubah-siswa').click(function(){

			var nama = $(this).attr("siswa-nama");
			var nis = $(this).attr("siswa-nis");
			var nisn = $(this).attr("siswa-nisn");
			var kelamin = $(this).attr("siswa-kelamin");
			$(".ubah-nama-siswa").attr("value", nama);
			$(".ubah-nis-siswa").attr("value", nis);
			$(".ubah-nisn-siswa").attr("value", nisn);
			$(".select-kelamin-siswa").val(kelamin);
			console.log(nama);
			console.log(nis);
			console.log(nisn);
			console.log(kelamin);
			
		});

		$('.hapus-siswa').click(function(){

			var nis = $(this).attr("siswa-nis");
			var nama = $(this).attr("siswa-nama");
			$(".hapus-siswa-nis-text").html(nis);
			$(".hapus-siswa-nama-text").html(nama);			
		});

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
	});
	</script>