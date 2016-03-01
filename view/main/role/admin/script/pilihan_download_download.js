<script>
$(document).ready(function(){

	function myFunction(){
		var select_tipe = document.getElementById("select_tipe");
		var select_kelas = document.getElementById("select_kelas");
		var select_subkelas = document.getElementById("select_subkelas");    
	    var tipe = select_tipe.options[select_tipe.selectedIndex].value;
	    var kelas = select_kelas.options[select_kelas.selectedIndex].value;
	    var subkelas = select_subkelas.options[select_subkelas.selectedIndex].value;

	    var jenis = select_jenis.options[select_jenis.selectedIndex].value;

	    if(tipe!='Pilih'){
		    if ((kelas!='Kelas')&&(subkelas!='Sub Kelas')){
		    	if((tipe=='absensi')||(tipe=='buku_induk')||(tipe=='uts')||(tipe=='uas')){
		    		$('#tbl_1').removeAttr('disabled');//pdf
		    	}
		    	if((tipe=='absensi')||(tipe=='ledger')){
		    		$('#tbl_2').removeAttr('disabled');//excel
		    	}
		    	document.getElementById('preview').src="?sajen=pilihan_download_pdf_proses&state=pdf&kelas=" + kelas+"&subkelas="+subkelas+"&tipe="+tipe+"&download=0";//tanggal_cetak="+tanggal_cetak; 
				document.getElementById('tbl_1').href="?sajen=pilihan_download_pdf_proses&state=pdf&kelas=" + kelas+"&subkelas="+subkelas+"&tipe="+tipe+"&download=1";//&tanggal_cetak="+tanggal_cetak; 
				document.getElementById('tbl_2').href="?sajen=pilihan_download_excel_proses&state=pdf&kelas=" + kelas+"&subkelas="+subkelas+"&tipe="+tipe; 
		    }
	    	if(tipe=='ledger'){
	    		$('#input_jenis').removeAttr('hidden');
	    		document.getElementById('tbl_2').href="?sajen=pilihan_download_excel_proses&state=pdf&kelas=" + kelas+"&subkelas="+subkelas+"&tipe="+tipe+"&jenis="+jenis; 
	    	}
	    }
	}
	
	$(".select-tipe").change(function(){
    	myFunction();
	});

	$(".select-kelas").change(function(){
    	myFunction();
	});

	$(".select-subkelas").change(function(){
    	myFunction();
	});

	$(".select-jenis").change(function(){
    	myFunction();
	});

	window.onload = myFunction;

});
</script>