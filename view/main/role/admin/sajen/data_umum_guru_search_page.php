<?php
$dataSearch=json_decode($_POST['json']);
$query = htmlspecialchars($dataSearch[0], ENT_QUOTES);
$page_request = htmlspecialchars($dataSearch[1], ENT_QUOTES);
$page = $page_request - 1;
$item=80;
$sql_limited = "SELECT * FROM data_guru WHERE nama LIKE '%$query%' OR nip LIKE '%$query%' ORDER BY nip ASC LIMIT $page,$item";
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
		<td class='text-center' colspan='6'>
			Nama atau NIP: \"$query\" tidak ditemukan 
		</td>
	</tr>
		";
}
if ($no_limited != 0 ){

	$x = 0;
	$a = 1;
	while ($x<>$no_limited) {
		$get_nama = $row[$x]['nama'];
		$get_nip = $row[$x]['nip'];
		$nama = htmlspecialchars($get_nama, ENT_QUOTES, "UTF-8");
		$nip = htmlspecialchars($get_nip, ENT_QUOTES, "UTF-8");
	    echo "<tr>";
	    echo "<td>$a</td>";
		echo "<td>$nama <span class='badge badge-info badge-$nip'>aktif</span></td>";
		echo "<td>$nip</td>";
		echo "<td><input id='switch-state' guru-nip='$nip' type='checkbox' data-size='mini' data-on-text='1' data-off-text='0' data-on-color='primary' data-off-color='warning' switch checked></td>";
	    echo "<td><button name='button' data-toggle='modal' data-target='#ModalUbahGuru' class='btn btn-info ubah-guru' guru-nip='$nip' guru-nama='$nama'>Ubah</button></td>";
	    echo "<td><button name='button' data-toggle='modal' data-target='#ModalHapusGuru' class='btn btn-danger hapus-guru' guru-nip='$nip' guru-nama='$nama'>Hapus</button></td>";
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
			var nip = $(this).attr("guru-nip");
			if (get_state == false){

				var query = "false";
				var arrayGetDataSwitch = [query];
				$.ajax({

					type: "POST",
					url: "?sajen=data_umum_guru_switch",
					data: {json: JSON.stringify(arrayGetDataSwitch)},
					cache: false,
					success: function(html) {

						$(".badge-" + nip).attr("class", "badge badge-danger badge-" + nip);
						$(".badge-" + nip).html("tidak aktif");
						create_toast("info","TIDAK AKTIF",nip + "->" + get_state);
					} 
				});				
			} else {

				var query = "true";
				var arrayGetDataSwitch = [query];
				$.ajax({

					type: "POST",
					url: "?sajen=data_umum_guru_switch",
					data: {json: JSON.stringify(arrayGetDataSwitch)},
					cache: false,
					success: function(html) {

						$(".badge-" + nip).attr("class", "badge badge-info badge-" + nip);
						$(".badge-" + nip).html("aktif");
						create_toast("info","AKTIF",nip + "->" + get_state);
					} 
				});		
			};
		});

		$('.ubah-guru').click(function(){

			var nama = $(this).attr("guru-nama");
			var nip = $(this).attr("guru-nip");
			$(".ubah-nama-guru").attr("value", nama);
			$(".ubah-nip-guru").attr("value", nip);
			console.log(nama);
			console.log(nip);			
		});

		$('.hapus-guru').click(function(){

			var nip = $(this).attr("guru-nip");
			var nama = $(this).attr("guru-nama");
			$(".hapus-guru-nip-text").html(nip);
			$(".hapus-guru-nama-text").html(nama);			
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