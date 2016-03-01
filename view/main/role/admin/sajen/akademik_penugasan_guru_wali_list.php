<div class='row'>
	<div class='col-md-6'>
		<div class='form-group'>
			<select class='form-control pilih-penugasan-wali-kelas' tabindex='2'>
				<option value='0'>Kelas</option>
				<option value='7'>7</option>
				<option value='8'>8</option>
				<option value='9'>9</option>
			</select>
		</div>
	</div>
	<div class='col-md-6'>
		<div class='form-group'>
			<select class='form-control pilih-penugasan-wali-subkelas' tabindex='2'>
				<option value='0'>Subkelas</option>
				<option value='A'>A</option>
				<option value='B'>B</option>
				<option value='C'>C</option>
				<option value='D'>D</option>
				<option value='E'>E</option>
				<option value='F'>F</option>
				<option value='G'>G</option>
				<option value='H'>H</option>
				<option value='I'>I</option>
			</select>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){

	$('.pilih-penugasan-wali-kelas').on('change', function(){

		var thisVal = $(this).val();
		var subkelasVal = $('.pilih-penugasan-wali-subkelas').val();

		if (thisVal  == 0){

			$('.warning-wali').html("Insert Kelas");
			disable_button_save();
		} else if (subkelasVal == 0){

			$('.warning-wali').html("Insert Subkelas");
			disable_button_save();
		}  else {

			check_tugas_wali();
		}
	});

	$('.pilih-penugasan-wali-subkelas').on('change', function(){

		var thisVal = $(this).val();
		var kelasVal = $('.pilih-penugasan-wali-kelas').val();

		if (thisVal  == 0){

			$('.warning-wali').html("Insert Subkelas");
		} else if (kelasVal == 0){

			$('.warning-wali').html("Insert Kelas");
		} else {

			check_tugas_wali();
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

	var check_tugas_wali = function(){

		getNIP = $('.guru-title').attr("nip");
		getKelas = $('.pilih-penugasan-wali-kelas').val();
		getSubkelas = $('.pilih-penugasan-wali-subkelas').val();

		var arraySend = [getNIP, getKelas, getSubkelas];

		$.ajax({

			type: "POST",
			url: "?sajen=akademik_penugasan_guru_check_wali",
			data: {json: JSON.stringify(arraySend)},
			cache: false,
			success: function(html) {

				$('.warning-wali').html(html);
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