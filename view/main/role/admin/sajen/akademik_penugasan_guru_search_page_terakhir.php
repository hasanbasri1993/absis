<?php
require_once "model/class/master.php";
$item=10;
$sql_limited = "SELECT * FROM data_guru ORDER BY nip DESC LIMIT $item";
$showdata_limited = $dbo -> prepare("$sql_limited");
$showdata_limited -> execute();
$row = $showdata_limited -> fetchAll();

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
	while ($x<>$no_limited) {
		
		$guru= new Guru($row[$x]['nip']);

		$namaMapel = $guru -> getNamaMapel('ktsp');
		$banyakKelas = $guru -> getBanyakKelas();
		$waliKelas = $guru -> getPenugasanWali();
		$tugasEkstra = $guru -> getPenugasanEkstra();

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
			$ekstra_badge = "<span class='badge badge-danger' data-toggle='tooltip' data-placement='top' title='$tugasEkstra_fix'>$tugasEkstra_fix</span>";

		}

		if ($tugasEkstra_fix <> null){

			$state_show = "ekstra";			
		} elseif ($waliKelas_fix <> null){

			$state_show = "wali";			
		} else {

			$state_show = "normal";
		}

		echo "<tr>";
		echo "<td class='text-left'>".$row[$x]['nip']."</td>";
		echo "<td class='text-left'>".$row[$x]['nama']." " . $ekstra_badge . " " . $wali_badge . " </td>";
		echo "<td class='text-left'>".$namaMapel."</td>";
		echo "<td class='text-center'>".$banyakKelas."</td>";
		echo "<td class='inline-popups text-center'><button nip='".$row[$x]['nip']."' class='btn btn-info munyuk' data-toggle='modal' data-target='#ModalGuru'>Tambah</button></td>";
		echo "<td class='inline-popups text-center'><button nip='".$row[$x]['nip']."' nama='".$nama_ent."' state='" . $state_show . "' ekstra='". $tugasEkstra_show ."' wali-kelas='" . $waliKelas_Kelas_show . "' wali-subkelas='" . $waliKelas_Subkelas_show . "' class='btn btn-info munyuk-2' data-toggle='modal' data-target='#ModalTambahan'>Tambahan</button></td>";
		echo "</tr>";
		$x++;
	}
}
?>
<script>
$(document).ready(function(){

	$('.munyuk').click(function(){

		var thisNIP = $(this).attr("nip");
		$( "#TugasGuru" ).html("<div class='text-center'> <img src='assets/img/loading.gif'></div>");
		$.post( "index.php?sajen=akademik_penugasan_guru_penugasan", {nip: thisNIP}, function( data ) {
	  		$( "#TugasGuru" ).html( data );
	  	});		  	
	});

	$('.munyuk-2').click(function(){

		var thisNIP = $(this).attr("nip");
		var thisNama = $(this).attr("nama");
		var thisState = $(this).attr("state");
		var thisEkstra = $(this).attr("ekstra");
		var thisKelas = $(this).attr("wali-kelas");
		var thisSubkelas = $(this).attr("wali-subkelas");

		$('.simpan-penugasan').attr("nip", thisNIP);

		$('.guru-title').text(thisNama);
		$('.pilihan-warning-1').html("");
		$('.pilihan-warning-2').html("");
		$('.pilihan-warning-3').html("");
		$('.pilihan-warning-4').html("");

		if (thisState == "ekstra"){

			$('.pilih-penugasan').val(2);
			$('#content-tipe-penugasan').hide("slow");
			$('.title-tipe').text('Pilih Ekstra Kurikuler');
			$('.simpan-penugasan').attr("disabled", "disabled");
			$('.pilihan-warning-3').hide();
			$('.pilihan-warning-4').hide();
			$('.pilihan-parent').html("Sedang Mengambil Data");
			$.ajax({

				type: "POST",
				url: "?sajen=akademik_penugasan_guru_ekstra_list",
				cache: false,
				success: function(html) {

					$('.pilihan-parent').html(html);
					$('.pilihan-warning-1').html(thisEkstra);
					$('.pilihan-warning-1').hide();
					$('.pilihan-final').val(thisEkstra);
					$('#content-tipe-penugasan').show("slow");
				} 
			});
		} else if (thisState == "wali"){

			$('.pilih-penugasan').val(1);
			$('#content-tipe-penugasan').hide("slow");
			$('.title-tipe').text('Pilih Wali Kelas');
			$('.simpan-penugasan').attr("disabled", "disabled");
			$('.pilihan-warning-3').html(thisKelas + thisSubkelas);
			$('.pilihan-warning-1').hide();
			$('.pilihan-warning-2').hide();
			$('.pilihan-parent').html("Sedang Mengambil Data");
			$.ajax({

				type: "POST",
				url: "?sajen=akademik_penugasan_guru_wali_list",
				cache: false,
				success: function(html) {

					$('.pilihan-parent').html(html);
					$('.pilihan-warning-3').html(thisKelas + thisSubkelas);
					$('.pilihan-warning-3').hide();
					$('.pilihan-final-1').val(thisKelas);
					$('.pilihan-final-2').val(thisSubkelas);
					$('#content-tipe-penugasan').show("slow");

				} 
			});
		} else {

			$('.pilih-penugasan').val(0);
			$('#content-tipe-penugasan').hide();
			$('.simpan-penugasan').attr("disabled", "disabled");
		}

	});



});
</script>