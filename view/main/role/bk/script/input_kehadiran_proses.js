<?php
if (isset($_GET['ok'])){

	?>
		<script type="text/javascript">
			$(document).ready(function(){

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

			create_toast("info", "Sukses", "Berhasil Menyimpan Data");

			});
		</script>
	<?php
}
?>