<?php
require_once "model/class/master.php";
$dataSearch=json_decode($_POST['json']);
$query = htmlspecialchars($dataSearch[0], ENT_QUOTES, "UTF-8");
$page=0;
$item=80;
$sql_limited = "SELECT * FROM data_guru WHERE nama LIKE '%$query%' OR nip LIKE '%$query%' ORDER BY nip ASC LIMIT $page,$item";
$showdata_limited = $dbo -> prepare("$sql_limited");
$showdata_limited -> execute();
$row = $showdata_limited -> fetchAll();
$no_limited = $showdata_limited -> rowCount();

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
	while ($x <> $no_limited) {

		$guru= new Guru($row[$x]['nip']);

		$namaMapel = $guru -> getNamaMapel('ktsp');
		$banyakKelas = $guru -> getBanyakKelas();
		$waliKelas = $guru -> getPenugasanWali();
		$tugasEkstra = $guru -> getPenugasanEkstra();
		print_r($tugasEkstra);

		$waliKelas_Kelas = $waliKelas[0][0];
		$waliKelas_Subkelas = $waliKelas[0][1];
		$waliKelas_fix = "$waliKelas_Kelas$waliKelas_Subkelas";

		$nama_ent = htmlentities($row[$x]['nama'], ENT_QUOTES);

		if ($waliKelas_fix == ""){
			
			$wali_badge = "";
			$waliKelas_Kelas_show = "";
			$waliKelas_Subkelas_show = "";
		} else {

			$waliKelas_Kelas_show = $waliKelas[0][0];
			$waliKelas_Subkelas_show = $waliKelas[0][1];
			$wali_badge = "<span class='badge badge-info' data-toggle='tooltip' data-placement='top' title='Wali Kelas $waliKelas_Kelas$waliKelas_Subkelas'>Wali Kelas $waliKelas_Kelas$waliKelas_Subkelas</span>";
		}

		$tugasEkstra_fix = $tugasEkstra[0][1];
		if ($tugasEkstra_fix == ""){

			$ekstra_badge = "";
			$tugasEkstra_show = "";
		}  else {

			$tugasEkstra_show = $tugasEkstra[0][1];
			if (isset($tugasEkstra[1][1])){

				$tugasEkstra_fix = $tugasEkstra[1][1];
				$a = "<span class='badge badge-danger' data-toggle='tooltip' data-placement='top' title='$tugasEkstra_fix'>$tugasEkstra_fix</span>";

			} else {
				$a = "";
			}
			$tugasEkstra_fix = $tugasEkstra[0][1];
			$ekstra_badge = "<span class='badge badge-danger' data-toggle='tooltip' data-placement='top' title='$tugasEkstra_fix'>$tugasEkstra_fix</span>" . $a;

		}

		echo "<tr>";
		echo "<td class='text-left'>".$row[$x]['nip']."</td>";
		echo "<td class='text-left'>".$row[$x]['nama']." " . $ekstra_badge . " " . $wali_badge . " </td>";
		echo "<td class='text-left'>".$namaMapel."</td>";
		echo "<td class='text-center'>".$banyakKelas."</td>";
		echo "<td class='inline-popups text-center'><button class='btn btn-info tugas-1' nip='".$row[$x]['nip']."' data-toggle='modal' data-target='#ModalGuru'>Tambah</button></td>";
		echo "<td class='inline-popups text-center'><button class='btn btn-info tugas-2' nip='".$row[$x]['nip']."' nama='".$nama_ent."' ekstra='". $tugasEkstra_show ."' wali-kelas='" . $waliKelas_Kelas_show . "' wali-subkelas='" . $waliKelas_Subkelas_show . "' data-toggle='modal' data-target='#ModalTambahan'>Tambahan</button></td>";
		echo "</tr>";
		$x++;
	}
}
?>
<script>
$(document).ready(function(){

	$('.tugas-1').click(function(){

		var thisNIP = $(this).attr("nip");
		$( "#TugasGuru" ).html("<div class='text-center'> <img src='assets/img/loading.gif'></div>");

		$.ajax({

			type: "POST",
			url: "?sajen=akademik_penugasan_guru_penugasan",
			data: {nip: thisNIP},
			cache: false,
			success: function(html) {

				$( "#TugasGuru" ).html(html);
			} 
		});	  	
	});

	$('.tugas-2').click(function(){

		var thisNIP = $(this).attr("nip");
		var thisNama = $(this).attr("nama");
		var thisEkstra = $(this).attr("ekstra");
		var thisKelas = $(this).attr("wali-kelas");
		var thisSubkelas = $(this).attr("wali-subkelas");
		$('.guru-title').attr("nip", thisNIP);
		$('.guru-title').attr("kelas", thisKelas);
		$('.guru-title').attr("subkelas", thisSubkelas);
		$('.guru-title').attr("ekstra", thisEkstra);
		$('.guru-title').text(thisNama);

		reset_state();
		get_list("ekstra");
		disable_button_save();

	});

	var get_list = function(request){

		var getKelas = $('.guru-title').attr("kelas");
		var getSubkelas = $('.guru-title').attr("subkelas");
		var getEkstra = $('.guru-title').attr("ekstra");
		$(".content-tipe-penugasan-" + request).html("<div class='col-md-7 content-tipe-penugasan-ekstra'><h5 class='text-left'>Sedang mengambil data...</h5></div>");
		$.ajax({

			type: "POST",
			url: "?sajen=akademik_penugasan_guru_" + request + "_list",
			cache: false,
			success: function(html) {

				$(".content-tipe-penugasan-" + request).html(html);
				get_val_ekstra();
				get_val_wali_n();
			} 
		});
		
		if ((getKelas != "") || (getSubkelas != "")){

			$('.pilih-penugasan-wali-kelas').val(getKelas);
			$('.pilih-penugasan-wali-subkelas').val(getSubkelas);
		}

		if (getEkstra != ""){

			$('.pilih-penugasan-ekstra').val(getEkstra);
		}
	};

	var get_val_ekstra = function(){

		var getEkstra = $('.guru-title').attr("ekstra");

		if (getEkstra != ""){

			$('.pilih-penugasan-ekstra').val(getEkstra).change();
		}
	};

	var get_val_wali_n = function(){

		var getKelas = $('.guru-title').attr("kelas");
		var getSubkelas = $('.guru-title').attr("subkelas");

		if ((getKelas != "") || (getSubkelas != "")){

			$('.pilih-penugasan-wali').val(1).change();
		}
	};


	var reset_state = function(){

		$('.pilih-penugasan-wali').val(0);
		$('.pilih-penugasan-ekstra').val(0);

		$('.warning-wali').html("");
		$('.warning-ekstra').html("");

		$('.content-tipe-penugasan-wali').html("");
	};

	var disable_button_save = function(){

		$('.simpan-penugasan').attr("disabled", "disabled");
	};

	var enable_button_save = function(){

		$('.simpan-penugasan').removeAttr("disabled");
	};

});
</script>