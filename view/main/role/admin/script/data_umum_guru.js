<script>
$(document).ready(function(){

	var search_table = function(query) {

		var arrayGetDataSearch = [query];
		$.ajax({

			type: "POST",
			url: "?sajen=data_umum_guru_search",
			data: {json: JSON.stringify(arrayGetDataSearch)},
			cache: false,
			success: function(html) {

				$("#data-guru-tabel").html(html);
			} 
		});

		$.ajax({

			type: "POST",
			url: "?sajen=data_umum_guru_page",
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

	$('.ubah-guru-save').click(function(){

		var nama = $(".ubah-nama-guru").attr("value");
		var nip = $(".ubah-nip-guru").attr("value");
		var kelamin = $(".select-kelamin-guru").val();
		console.log(nama);
		console.log(nip);
		console.log(kelamin);
		var arrayUbah = [nip,nama,kelamin];
		$.ajax({

				type: "POST",
				url: "index.php?sajen=data_umum_guru_ubah",
				data: {json: JSON.stringify(arrayUbah)},
				cache: false,
				success: function(html) {
					if (html=="1") {
							create_toast("info", "Sukses Ubah Guru", nip +" "+ nama);
							search_table($('#search-guru').val());
						} else {
							create_toast("error", "Error:", html);
							search_table($('#search-guru').val());
						}
					
	    		}      
			});
	});

	$('.hapus-guru-konfirmasi').click(function(){

		var nip = $(".hapus-guru-nip-text").html();
		var nama = $(".hapus-guru-nama-text").html();
		var arrayHapus = [nip];
		$.ajax({

				type: "POST",
				url: "index.php?sajen=data_umum_guru_delete",
				data: {json: JSON.stringify(arrayHapus)},
				cache: false,
				success: function(html) {
					create_toast("info", "Sukses Hapus Guru", nip + " " + nama);
	    		}      
			});
	});

	$(".tambah-guru-btn").on("click", function(){

		$(".tambah-nip-guru").val("");
		$(".tambah-nama-guru").val("");
		$(".select-tambah-kelamin-guru").val();
	});

	$(".tambah-guru-proses").on("click", function(){

		var nip = $(".tambah-nip-guru").val();
		var nama = $(".tambah-nama-guru").val();
		var kelamin = $(".select-tambah-kelamin-guru").val();
		if (nip == ""){

			var lanjut = 0;
			create_toast("error", "Dibutuhkan Data", "NIP");
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

			var arrayTambahGuru = [nip,nama,kelamin];
			$.ajax({

					type: "POST",
					url: "index.php?sajen=data_umum_guru_tambah",
					data: {json: JSON.stringify(arrayTambahGuru)},
					cache: false,
					success: function(html) {
						
						create_toast("info", "Sukses Tambah", nip + nama);
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