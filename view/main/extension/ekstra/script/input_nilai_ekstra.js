<script type="text/javascript">
<?php
require_once "model/class/master.php";
$guru = new Guru($_SESSION['username']);
$get_ekstra = $guru -> getPenugasanEkstra();
?>
var ekstra = "<?php echo $get_ekstra[0][0];?>";
var arrayGetTable= [ekstra];
$(document).ready(function(){

	var reloadTable = function(){
		$("#content-table").html("<td colspan='6' align='center'>Mencoba Mengambil Data...h</td>");
        $.ajax({
        		type: "POST",
                url: "index.php?sajen=pertamax_ekstra_input_nilai_ekstra+input_nilai_ekstra_table",
                data: {json: JSON.stringify(arrayGetTable)},
                cache: false,
                success: function(html) {

                    $("#content-table").html(html);
                } 
            });
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
	<?php
	if (isset($_GET['ok'])){
		echo "create_toast('info','Action', 'Sukses Menyimpan Data');";
	}
	?>

    $('.hapus-konfirm').click(function(){
		var nis = $(this).attr("siswa-nis");
		var arrayGetDataDelete = [nis];
		$.ajax({

			type: "POST",
			url: "index.php?sajen=pertamax_ekstra_input_nilai_ekstra+input_nilai_ekstra_delete",
			data: {json: JSON.stringify(arrayGetDataDelete)},
			cache: false,
			success: function(html) {

				create_toast("info","Action", html);
				reloadTable();					
    		}      
		});
	});

	$(".input-s").keyup(function() {

		var searchid = $(this).val();
		var arrayGetDataSearch = [searchid];

		//explode " ", if expploded ! = "" go, else hide
		if(searchid != '') {
			$.ajax({

				type: "POST",
				url: "index.php?sajen=pertamax_ekstra_input_nilai_ekstra+input_nilai_ekstra_search",
				data: {json: JSON.stringify(arrayGetDataSearch)},
				cache: false,
				success: function(html) {

					$("#content-r").html(html).show();
				} 
			});
		} else {
			$("#content-r").html("Masukkan Nama atau NIS Siswa").show();
		}
		return false;    
	});

	$(document).live("click", function(e) { 
		var clicked = $(e.target);
		if (! clicked.hasClass("input-s")){

			jQuery("#content-r").fadeOut();
			$("#content-r").html("");
			$('#input-s').val("");
		}
	});

	$('#input-s').click(function(){
		jQuery("#content-r").fadeIn();
		$("#content-r").html("Masukkan Nama atau NIS Siswa").show();
	});

	reloadTable();

});
</script>