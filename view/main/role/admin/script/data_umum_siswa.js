<script>
$(document).ready(function(){

	var search_table = function(query) {

		var arrayGetDataSearch = [query];
		$.ajax({

			type: "POST",
			url: "?sajen=data_umum_siswa_search",
			data: {json: JSON.stringify(arrayGetDataSearch)},
			cache: false,
			success: function(html) {

				$("#data-siswa-tabel").html(html);
			} 
		});

		$.ajax({

			type: "POST",
			url: "?sajen=data_umum_siswa_page",
			data: {json: JSON.stringify(arrayGetDataSearch)},
			cache: false,
			success: function(html) {
				
				$(".page-numb").html(html);
			} 
		});
	};
	search_table("a");

    $("#search-siswa").keyup(function() {
		
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

	$('.ubah-siswa-save').click(function(){

		var nama = $(".ubah-nama-siswa").attr("value");
		var nis = $(".ubah-nis-siswa").attr("value");
		var nisn = $(".ubah-nisn-siswa").attr("value");
		var kelamin = $(".select-kelamin-siswa").val();
		console.log(nama);
		console.log(nis);
		console.log(nisn);
		console.log(kelamin);
		var arrayUbah = [nis,nisn,nama,kelamin];
		$.ajax({

				type: "POST",
				url: "index.php?sajen=data_umum_siswa_ubah",
				data: {json: JSON.stringify(arrayUbah)},
				cache: false,
				success: function(html) {

					if (html=="1") {
							create_toast("info", "Sukses Ubah Siswa", nis +" "+ nama);
							search_table($('#search-siswa').val());
						} else {
							create_toast("error", "Error:", html);
							search_table($('#search-siswa').val());
						}
	    		}      
			});
	});

	$('.hapus-siswa-konfirmasi').click(function(){

		var nis = $(".hapus-siswa-nis-text").html();
		var nama = $(".hapus-siswa-nama-text").html();
		var arrayHapus = [nis];
		$.ajax({

				type: "POST",
				url: "index.php?sajen=data_umum_siswa_delete",
				data: {json: JSON.stringify(arrayHapus)},
				cache: false,
				success: function(html) {
					create_toast("info", "Sukses Hapus Siswa", nis + " " + nama);
	    		}      
			});
	});

	$(".tambah-siswa-btn").on("click", function(){

		$(".tambah-nis-siswa").val("");
		$(".tambah-nisn-siswa").val("");
		$(".tambah-nama-siswa").val("");
		$(".select-tambah-kelamin-siswa").val();
	});

	$(".tambah-siswa-proses").on("click", function(){

		var nis = $(".tambah-nis-siswa").val();
		var nisn = $(".tambah-nisn-siswa").val();
		var nama = $(".tambah-nama-siswa").val();
		var kelamin = $(".select-tambah-kelamin-siswa").val();
		if (nis == ""){

			var lanjut = 0;
			create_toast("error", "Dibutuhkan Data", "NIS");
		} else {

			var lanjut = 1;
		};
		if (nisn == ""){

			var lanjut = 0;
			create_toast("error", "Dibutuhkan Data", "NISN");
		} else {

			var lanjut = 1;
		};
		if (nama == ""){

			var lanjut = 0;
			create_toast("error", "Dibutuhkan Data", "NAMA");
		} else {

			var lanjut = 1;
		};

		if (lanjut == 1){

			var arrayTambahSiswa = [nis,nisn,nama,kelamin];
			$.ajax({

					type: "POST",
					url: "index.php?sajen=data_umum_siswa_tambah",
					data: {json: JSON.stringify(arrayTambahSiswa)},
					cache: false,
					success: function(html) {
						
						create_toast("info", "Sukses Tambah", nis + nisn + nama);
		    		}      
				});
		} else {

			create_toast("error", "Gagal Tambah","Data Tidak Lengkap");
		};
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