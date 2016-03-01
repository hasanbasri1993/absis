$(document).ready(function(){

	// var get_status = function()
	// alert('status init');
	// if(navigator.onLine){
	// 	alert('on');
	// }else{
	// 	alert('off');
	// };

	var on_status = function(){
		toastr.clear();
	    create_toast("success", "Internet Online", "Semua Perubahan Tersimpan", "99999999", "1000", true);
	};

	var off_status = function(){
		toastr.clear();
	    create_toast("error", "Internet Offline", "Perubahan Tidak Tersimpan", "99999999", "99999999", false);
	};

	window.addEventListener('online',  on_status);
	window.addEventListener('offline', off_status);

	var create_toast = function (tipe,judul,pesan, to, ext_to, close_btn){
	var i = -1;
	var toastCount = 0;
	var shortCutFunction = tipe;//$("#toastTypeGroup input:radio:checked").val();
	var msg = pesan;//$('#message').val();
	var title = judul;//$('#title').val() || '';
	var toastIndex = toastCount++;
	toastr.options = {
		showDuration: '300',
		hideDuration: '100',
		timeOut: to,
		extendedTimeOut: ext_to,
		showEasing: 'swing',
		hideEasing: 'linear',
		showMethod: 'fadeIn',
		hideMethod: 'fadeOut',
		positionClass: 'toast-top-right', // Top Right Bottom Right Bottom Left Top Left Top Full Width Bottom Full Width
		closeButton: close_btn, //true false broo
		debug: false,
		progressBar: false,
		onclick: null,
		tapToDismiss: false
		};
		var $toast = toastr[shortCutFunction](msg, title);
	};
});
