<p>
	<input id="switch-state" nip="1321" type="checkbox" data-size="mini" data-on-text="1" data-off-text="0" data-on-color="primary" data-off-color="warning" switch checked>
	<!-- data-label-width="0" data-label-text="" data-label-width="10" data-handle-width="40" -->
</p>

<script>
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
		create_toast("info","a","b");


		$("[switch]").bootstrapSwitch();

		$('[switch]').on('switchChange.bootstrapSwitch', function () {
			var get_state = $(this).bootstrapSwitch('state');
			var nip = $(this).attr("nip");
			console.log(nip + get_state);
		});
	});	
</script>