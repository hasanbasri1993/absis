<div class="form-group">
	<select class="pilih-penugasan-ekstra form-control" tabindex="2">
		<option value="0">Ekstrakurikuler Tidak Di Set</option>
		<?php
		include_once "model/class/master.php";

		$dbTA = new DB($_SESSION['database']);
		$sqlekstra = "SELECT * FROM data_ekskul";
		$ekstra = $dbTA -> prepare($sqlekstra);
		$ekstra -> execute();
		$data_ekstra = $ekstra -> fetchAll();
		$data_ekstra_count = $ekstra -> rowCount();
		$x = 0;
		while ($x <> $data_ekstra_count){

			echo "<option value='" . $data_ekstra[$x][1] . "'>" . $data_ekstra[$x][1] . "</option>
			";
			$x++;			
		}		
		?>
	</select>
</div>

<script>
$(document).ready(function(){

	$('.pilih-penugasan-ekstra').on('change', function(){

		thisVal = $(this).val();
		if (thisVal == 0){

			$('.warning-ekstra').html("");
			enable_button_save();
		} else {

			check_tugas_ekstra();
		}
	});

	var check_save = function(){

		var getWarningWali = $('.warning-wali').html()
		var getWarningEkstra = $('.warning-ekstra').html();
		var statWali = getWarningWali.substring(0,4);
		var statEkstra = getWarningEkstra.substring(0,4);

		if (statEkstra == "Sama"){

			disable_button_save();
		} else if (statWali == "Sama"){

			disable_button_save();
		} else {

			enable_button_save();
		}
	};
	var check_tugas_ekstra = function(){

		getNIP = $('.guru-title').attr("nip");
		getEkstra = $('.pilih-penugasan-ekstra').val();
		var arraySend = [getNIP, getEkstra];

		$.ajax({

			type: "POST",
			url: "?sajen=akademik_penugasan_guru_check_ekstra",
			data: {json: JSON.stringify(arraySend)},
			cache: false,
			success: function(html) {

				$('.warning-ekstra').html(html);
				check_save();
			} 
		});

	};

	var disable_button_save = function(){

		$('.simpan-penugasan').attr("disabled", "disabled");
	};

	var enable_button_save = function(){

		$('.simpan-penugasan').removeAttr("disabled");
	};


});
</script>