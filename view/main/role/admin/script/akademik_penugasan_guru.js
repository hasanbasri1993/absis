<script>
$(document).ready(function(){

	var search_table = function(query) {

		$("#data-guru-tabel").html("<tr><td colspan='8' class='text-center'><h3>Sedang Mengambil Data...</h3></td></tr>");
		var arrayGetDataSearch = [query];
		$.ajax({

			type: "POST",
			url: "?sajen=akademik_penugasan_guru_search",
			data: {json: JSON.stringify(arrayGetDataSearch)},
			cache: false,
			success: function(html) {

				$("#data-guru-tabel").html(html);
			} 
		});

		$.ajax({

			type: "POST",
			url: "?sajen=akademik_penugasan_guru_page",
			data: {json: JSON.stringify(arrayGetDataSearch)},
			cache: false,
			success: function(html) {
				
				$(".page-numb").html(html);
			} 
		});
	};
	search_table("a");

    $("#search-guru").keyup(function() {
		
		if (query == ""){
			var query = "a";
			search_table(query);
		}
		if(query != '') {
			var query = $(this).val();
			search_table(query);
		} else {
			$(".page-numb").html("<ul class='pagination square'><li class='active'><a href='#fakelink'>0</a></li></ul>");
		}
		return false;    
	});

	$('.pilih-penugasan-wali').on('change', function(){

		var thisVal = $(this).val();
		if (thisVal == 0){

			$('.content-tipe-penugasan-wali').html("");
			$('.warning-wali').html("");
			enable_button_save();
		} else {

			get_list("wali");

		}
	});

	$('.simpan-penugasan').on('click', function(){

		var getNIP = $('.guru-title').attr("nip");
		var getEkstra = $('.pilih-penugasan-ekstra').val();
		var getStateWali = $('.pilih-penugasan-wali').val();

		if (getStateWali == 1){

			var getWaliKelas = $('.pilih-penugasan-wali-kelas').val();
			var getWaliSubkelas = $('.pilih-penugasan-wali-subkelas').val();
			save_wali(getNIP, getWaliKelas, getWaliSubkelas);
		} else {

			del_wali(getNIP);			
		}


		if (getEkstra == 0){

			del_ekstra(getNIP);
		} else  {

			save_ekstra(getNIP, getEkstra);
		}

		console.log(getNIP + getEkstra + getWaliKelas + getWaliSubkelas);

	});

	var save_ekstra = function (nip,ekstra){

		var arraySend = [nip,ekstra];
		$.ajax({

			type: "POST",
			url: "?sajen=akademik_penugasan_guru_save_ekstra",
			data: {json: JSON.stringify(arraySend)},
			cache: false,
			success: function(html) {

				create_toast("info", "success", html);
				search_table("a");
			} 
		});
	};

	var save_wali = function (nip,kelas,subkelas){

		var arraySend = [nip, kelas, subkelas];
			$.ajax({

				type: "POST",
				url: "?sajen=akademik_penugasan_guru_save_wali",
				data: {json: JSON.stringify(arraySend)},
				cache: false,
				success: function(html) {

				create_toast("info", "success", "Simpan Penugasan Wali");
					search_table("a");
				} 
			});
	};

	var del_wali = function (nip){

		var arraySend = [nip];
			$.ajax({

				type: "POST",
				url: "?sajen=akademik_penugasan_guru_del_wali",
				data: {json: JSON.stringify(arraySend)},
				cache: false,
				success: function(html) {

				create_toast("info", "success", "Delete Penugasan Wali");
					search_table("a");
				} 
			});
	};

	var del_ekstra = function (nip){

		var arraySend = [nip];
			$.ajax({

				type: "POST",
				url: "?sajen=akademik_penugasan_guru_del_ekstra",
				data: {json: JSON.stringify(arraySend)},
				cache: false,
				success: function(html) {

				create_toast("info", "success", html);
					search_table("a");
				} 
			});
	};

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
				get_val_wali_b();
			} 
		});
		
		if ((getKelas != "") || (getSubkelas != "")){

			$('.pilih-penugasan-wali-kelas').val(getKelas);
			$('.pilih-penugasan-wali-subkelas').val(getSubkelas);
			enable_button_save();
		} else {

			$('.warning-wali').html("Isi Kelas dan Subkelas");
			disable_button_save();
		}

		if (getEkstra != ""){

			$('.pilih-penugasan-ekstra').val(getEkstra);
			enable_button_save();
		}
	};

	var get_val_wali_b = function(){

		var getKelas = $('.guru-title').attr("kelas");
		var getSubkelas = $('.guru-title').attr("subkelas");

		if ((getKelas != "") || (getSubkelas != "")){

			$('.pilih-penugasan-wali-kelas').val(getKelas).change();
			$('.pilih-penugasan-wali-subkelas').val(getSubkelas).change();
		}
	};
	

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

	var disable_button_save = function(){

		$('.simpan-penugasan').attr("disabled", "disabled");
	};

	var enable_button_save = function(){

		$('.simpan-penugasan').removeAttr("disabled");
	};
});
</script>